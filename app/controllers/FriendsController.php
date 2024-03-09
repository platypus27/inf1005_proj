<?php
class FriendsController{
    public function getFriends(){
        require_once("../app/model/Friends_List.php");
        $rows = get_friends("*");
        // $rows = get_friends("*",['usr_id'=>['=',$user_id]]);
        return $rows;
    }

    public function getUserID($login_id){
        require_once("../app/model/User.php");
        $userFound = get_user("*", ['loginid'=>['=', $login_id]]);
        // $userFound = get_user("*");
        if($userFound==null){
            return $rows = null;
        }else {
            $user = $userFound[0];
            return $user->getField('id')->getValue();
        }
    }

    public function getLoginID($user_id){
        require_once("../app/model/User.php");
        $userFound = get_user("*", ['id'=>['=', $user_id]]);
        if($userFound==null){
            return $rows = null;
        }else {
            $user = $userFound[0];
            return $user->getField('loginid')->getValue();
        }
    }
}
?>