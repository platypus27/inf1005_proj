<?php
require_once("../app/model/utils/Field.php");
require_once("../app/model/utils/Model.php");
require_once("../app/utils/helpers.php");

class Friends_List extends Model{
    const tablename = "friends_list";
    const fields = ["friendA", "friendB"];
    protected $friendA = null;
    protected $friendB = null;

    function __construct($values)
    {
        // Initialise fields
        $this->friendA = new Field("friendA", PDO::PARAM_INT);
        $this->friendB = new Field("friendB", PDO::PARAM_INT);

        // Assign values
        $this->friendA->setValue(get($values["friendA"]));
        $this->friendB->setValue(get($values["friendB"]));
    }

    public function getFriendA() {
        return $this->friendA;
    }

    public function getFriendB() {
        return $this->friendB;
    }
}

function get_friends(){
    return get_table('friends_list');
}
?>