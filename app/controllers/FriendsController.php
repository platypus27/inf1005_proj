<?php
class FriendsController{
    public function getFriends($user_id){
        require_once("../app/model/Post.php");
        $rows = get_friends("*",['usr_id'=>['=',$user_id]]);
        return $rows;
    }
}
?>