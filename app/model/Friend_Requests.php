<?php
require_once("../app/model/utils/Field.php");
require_once("../app/model/utils/Model.php");
require_once("../app/utils/helpers.php");

/**
 * FriendRequests
 * 
 * This class is responsible for handling friend requests operations
 * 
 * @category Model
 * @package  FriendRequests
 * 
 */
class FriendRequests extends Model{
    const tablename = "friend_requests";
    const fields = ["userID", "friendID"];
    protected $id = null;
    protected $userID = null;
    protected $friendID = null;

    /**
     * Constructor
     * 
     * @param   array   $values     Values to be assigned to fields
     * 
     */
    function __construct($values)
    {
        // Initialise fields
        $this->userID = new Field("userID", PDO::PARAM_INT);
        $this->friendID = new Field("friendID", PDO::PARAM_INT);

        // Assign values
        $this->userID->setValue(get($values["userID"]));
        $this->friendID->setValue(get($values["friendID"]));
    }

    /**
     * Get user ID
     * 
     * @return  int
     * 
     */
    public function getUserID() {
        return $this->userID;
    }

    /**
     * Get friend ID
     * 
     * @return  int
     * 
     */
    public function getFriendID() {
        return $this->friendID;
    }
}

/**
 * Get friend requests
 * 
 * @param   string  $fields     Fields to be selected
 * @param   array   $filter_by  Filter to be applied
 * @return  array|null
 * 
 */
function get_friendRequests($fields='*', $filter_by=[]){
    return get_table('FriendRequests', $fields, $filter_by);
}
?>