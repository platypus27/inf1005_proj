<?php declare(strict_types=1);
require_once("../app/model/utils/Query.php");

/**
 * Model
 * 
 * This class is responsible for handling model operations
 * 
 * @category Model
 * @package  Model
 * 
 */
class Model {
    /**
     * Placeholder for known fields to be updated
     */
    const fields = [];
    /**
     * Placeholder for tablename
     */
    const tablename = null;

    /**
     * Get field
     * @param   string  field   Field with value
     * @return  string  Field field
     */
    public function getField($field=''): Field {
        return $field != null ? $this->{$field} : '';
    }

    /**
     * Set value for field
     * @param   string  field   Field to set value for
     * @param   string  value   Value to be set to field
     * @return  int     1 if succesful and 0 if unsuccessful
     */
    public function setValue($field, $value): int {
        if (in_array($field, static::fields, TRUE)){
            $this->{$field}->setValue($value);
            return 1;
        }
        return 0;
    }

    /**
     * Add new record
     * @return  bool    True if successful and False if unsuccessful
     */
    public function add(){
        $query = new Query();
        $fields = static::fields;
        $stmt = $query->build_insert(static::tablename, $fields);
        $conn = $query->build_connection();
        $stmt = $conn->prepare($stmt);

        array_walk($fields, function($value) use ($stmt){
            $field = $this->{$value};
            $fvalue = $field->getValue();
            $ftype = $field->getType();
            $stmt->bindParam(":$value", $fvalue, $ftype);
        });
        return $stmt->execute();
    }

    /**
     * Delete record
     * @return  bool    True if successful and False if unsuccessful
     */
    public function delete(){
        if ($this->id->getValue() != null){
            $query = new Query();
            $id = $this->id->getName();
            $stmt = $query->build_delete(static::tablename, [$id=>"="]);
            $conn = $query->build_connection();
            $stmt = $conn->prepare($stmt);
            $idtype = $this->id->getType();
            $idval = $this->id->getValue();
            $stmt->bindParam(":filter_$id", $idval, $idtype);
            return $stmt->execute();
        } else {
            return 0;
        }
    }

    /**
     * Delete friend
     * @return  bool    True if successful and False if unsuccessful
     */
    public function deleteFriend(){
        if ($this->friendA->getValue() != null && $this->friendB->getValue() != null){
            $query = new Query();
            $friendA = $this->friendA->getName();
            $friendB = $this->friendB->getName();
            $stmt = $query->build_delete(static::tablename, [$friendA=>"=", $friendB=>"="]);
            $conn = $query->build_connection();
            $stmt = $conn->prepare($stmt);
            $friendAType = $this->friendA->getType();
            $friendAVal = $this->friendA->getValue();
            $friendBType = $this->friendB->getType();
            $friendBVal = $this->friendB->getValue();
            $stmt->bindParam(":filter_$friendA", $friendAVal, $friendAType);
            $stmt->bindParam(":filter_$friendB", $friendBVal, $friendBType);
            return $stmt->execute();
        } else {
            return 0;
        }
    }

    /**
     * Delete friend request
     * @return  bool    True if successful and False if unsuccessful
     */
    public function deleteFriendRequest(){
        if ($this->userID->getValue() != null && $this->friendID->getValue() != null){
            $query = new Query();
            $userID = $this->userID->getName();
            $friendID = $this->friendID->getName();
            $stmt = $query->build_delete(static::tablename, [$userID=>"=", $friendID=>"="]);
            $conn = $query->build_connection();
            $stmt = $conn->prepare($stmt);
            $userIDType = $this->userID->getType();
            $userIDVal = $this->userID->getValue();
            $friendIDType = $this->friendID->getType();
            $friendIDVal = $this->friendID->getValue();
            $stmt->bindParam(":filter_$userID", $userIDVal, $userIDType);
            $stmt->bindParam(":filter_$friendID", $friendIDVal, $friendIDType);
            return $stmt->execute();
        } else {
            return 0;
        }
    }

    /**
     * Update record
     * @return  bool    True if successful and False if unsuccessful
     */
    public function update() {
        if ($this->id->getValue() != null){
            $query = new Query();
            $id = $this->id->getName();
            $fields = static::fields;
            $stmt = $query->build_update(static::tablename, $fields, [$id=>'=']);
            $conn = $query->build_connection();
            $stmt = $conn->prepare($stmt);

            array_walk($fields, function($value) use ($stmt){
                $field = $this->{$value};
                $fvalue = $field->getValue();
                $ftype = $field->getType();
                $stmt->bindParam(":$value", $fvalue, $ftype);
            });
            $idtype = $this->id->getType();
            $idval = $this->id->getValue();
            $stmt->bindParam(":filter_$id", $idval, $idtype);
            return $stmt->execute();
        }
        return false;
    }
}


/**
 * Get row
 * @param   string  table       Table to get row from
 * @param   string  fields      Fields to get
 * @param   array   filter_by   Filter by
 * @return  array   Model       Model
 */
function get_row($table, $fields='*', $filter_by=[]){
    $tablename = $table::tablename;
    $known_fields = $table::fields;
    $query = new Query();
    if (is_array($fields)){
        $fields = array_intersect($fields, $known_fields);
    }
    $proc = [];
    array_walk($filter_by, function ($value, $key) use (&$proc, $known_fields){
        if (in_array($key, $known_fields)){
            $proc[$key] = $value[0];
        }
    });

    $stmt = $query->build_select($tablename, $fields, $proc);
    $conn = $query->build_connection();
    $stmt = $conn->prepare($stmt);

    array_walk($filter_by, function($value, $key) use ($stmt){
        $field = $key;
        $fvalue = $value[1];
        $stmt->bindParam(":filter_$field", $fvalue);
    });

    $result = $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_UNIQUE);
    $model = [];
    
    array_walk($result, function($row, $id) use (&$model, $table){
        $row['id'] = $id;
        array_push($model, new $table($row));
    });
    return count($model) > 0 ? $model : null;
}

/**
 * Get table
 * @param   string  table       Table to get row from
 * @param   string  fields      Fields to get
 * @param   array   filter_by   Filter by
 * @return  array   Model       Model
 */
function get_table($table, $fields='*', $filter_by=[]){
    $tablename = $table::tablename;
    $known_fields = $table::fields;
    $query = new Query();
    if (is_array($fields)){
        $fields = array_intersect($fields, $known_fields);
    }
    $proc = [];
    array_walk($filter_by, function ($value, $key) use (&$proc, $known_fields){
        if (in_array($key, $known_fields)){
            $proc[$key] = $value[0];
        }
    });

    $stmt = $query->build_select($tablename, $fields, $proc);
    $conn = $query->build_connection();
    $stmt = $conn->prepare($stmt);

    array_walk($filter_by, function($value, $key) use ($stmt){
        $field = $key;
        $fvalue = $value[1];
        $stmt->bindParam(":filter_$field", $fvalue);
    });

    $result = $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $model = [];
    
    array_walk($result, function($row, $id) use (&$model, $table){
        $row['id'] = $id;
        array_push($model, new $table($row));
    });
    return count($model) > 0 ? $model : null;
}

?>