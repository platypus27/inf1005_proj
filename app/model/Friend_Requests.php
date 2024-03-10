<?php
require_once("../app/model/utils/Field.php");
require_once("../app/model/utils/Model.php");
require_once("../app/utils/helpers.php");

class FriendRequests extends Model{
    const tablename = "friend_requests";
    const fields = ["userID", "friendID"];
    protected $id = null;
    protected $userID = null;
    protected $friendID = null;

    function __construct($values)
    {
        // Initialise fields
        $this->userID = new Field("userID", PDO::PARAM_INT);
        $this->friendID = new Field("friendID", PDO::PARAM_INT);

        // Assign values
        $this->userID->setValue(get($values["userID"]));
        $this->friendID->setValue(get($values["friendID"]));
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getFriendID() {
        return $this->friendID;
    }
}

function get_friendRequests($fields='*', $filter_by=[]){
    return get_table('FriendRequests', $fields, $filter_by);
}
?>