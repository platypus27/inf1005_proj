<?php
class FriendsController{
    public function getFriends($user_id){
        require_once("../app/model/Friends_List.php");
        $rowsA = get_friends("*", ['friendA' => ['=', $user_id]]);
        $rowsB = get_friends("*", ['friendB' => ['=', $user_id]]);
        $rowsA = $rowsA ? $rowsA : [];
        $rowsB = $rowsB ? $rowsB : [];
        $rows = array_merge($rowsA, $rowsB);
        return $rows;
    }

    public function getUserID($login_id){
        require_once("../app/model/User.php");
        $userFound = get_user("*", ['loginid'=>['=', $login_id]]);
        if($userFound==null){
            return $rows = null;
        }else {
            $user = $userFound[0];
            return $user->getField('id')->getValue();
        }
    }

    public function deleteFriend($friendA, $friendB){
        error_log("deleteFriend: $friendA, $friendB");
        require_once('../app/model/Friends_List.php');
        $friend = get_friends("*",['friendA'=>['=',$friendA], 'friendB'=>['=',$friendB]]);
        if ($friend == null){
            $friend = get_friends("*",['friendA'=>['=',$friendB], 'friendB'=>['=',$friendA]]);
        }
        return $friend[0]->deleteFriend();
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

    public function getFriendRequests($user_id){
        require_once("../app/model/Friend_Requests.php");
        $rows = get_friendRequests("*",['friendID'=>['=',$user_id]]);
        return $rows;
    }

    public function getFriendRequest($firstID, $secondID){
        require_once("../app/model/Friend_Requests.php");
        $rows = get_friendRequests("*",['userID'=>['=',$firstID], 'friendID'=>['=',$secondID]]);
        return $rows;
    }

    public function getSentRequests($user_id){
        require_once("../app/model/Friend_Requests.php");
        $rows = get_friendRequests("*",['userID'=>['=',$user_id]]);
        return $rows;
    }

    public function confirmReq($friendA, $friendB){
        require_once('../app/model/Friends_List.php');
        if($friendA != null || $friendB != null){
            $Postvalue = [
                "friendA" => $friendA,
                "friendB" => $friendB
            ];
        }
        $add_friend = new Friends_List($Postvalue);
        return $add_friend->add();
    }

    public function deleteReq($userID, $friendID){
        require_once('../app/model/Friend_Requests.php');
        $request = $this -> getFriendRequest($userID, $friendID);
        if ($request == null){
            $request = $this -> getFriendRequest($friendID, $userID);
        }
        
        return $request[0]->deleteFriendRequest();
    }

    public function sendReq($userID, $friendID){
        require_once('../app/model/Friend_Requests.php');
        if($userID != null || $friendID != null){
            $Postvalue = [
                "userID" => $userID,
                "friendID" => $friendID
            ];
        }
        $add_request = new FriendRequests($Postvalue);
        return $add_request->add();
    }
}
?>