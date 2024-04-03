<?php
require_once("../app/model/utils/Field.php");
require_once("../app/model/utils/Model.php");
require_once("../app/utils/helpers.php");

/**
 * Friends_List
 * 
 * This class is responsible for handling friends list operations
 * 
 * @category Model
 * @package  Friends_List
 * 
 */
class Friends_List extends Model{
    const tablename = "friends_list";
    const fields = ["friendA", "friendB"];
    protected $friendA = null;
    protected $friendB = null;

    /**
     * Constructor
     * 
     * @param   array   $values     Values to be assigned to fields
     * 
     */
    function __construct($values)
    {
        // Initialise fields
        $this->friendA = new Field("friendA", PDO::PARAM_INT);
        $this->friendB = new Field("friendB", PDO::PARAM_INT);

        // Assign values
        $this->friendA->setValue(get($values["friendA"]));
        $this->friendB->setValue(get($values["friendB"]));
    }

    /**
     * Get friend A
     * 
     * @return  int
     * 
     */
    public function getFriendA() {
        return $this->friendA;
    }

    /**
     * Get friend B
     * 
     * @return  int
     * 
     */
    public function getFriendB() {
        return $this->friendB;
    }
}

/**
 * Get friends
 * 
 * @param   string  $fields     Fields to be selected
 * @param   array   $filter_by  Filter to be applied
 * @return  array|null
 * 
 */
function get_friends($fields='*', $filter_by=[]){
    return get_table('friends_list', $fields, $filter_by);
}
?>