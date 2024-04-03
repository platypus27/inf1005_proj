<?php
/**
 * FriendsController
 * 
 * This class handles the friends list and friend requests
 * 
 * @category Controller
 * @package  FriendsController
 */
class FriendsController{
    /**
     * Sanitize input
     * 
     * @param string $input input to be sanitized
     * 
     * @return string sanitized input
     * 
     * @var string $input input to be sanitized
     */
    public function getFriends($user_id){
        require_once("../app/model/Friends_List.php");
        $rowsA = get_friends("*", ['friendA' => ['=', $user_id]]);
        $rowsB = get_friends("*", ['friendB' => ['=', $user_id]]);
        $rowsA = $rowsA ? $rowsA : [];
        $rowsB = $rowsB ? $rowsB : [];
        $rows = array_merge($rowsA, $rowsB);
        return $rows;
    }

    /**
     * Get User ID
     * 
     * @param string login_id
     * 
     * @return null User does not exist
     * @return int User ID
     */
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

    /**
     * Get Friend
     * 
     * @param string friendA
     * @param string friendB
     * 
     * @return null User does not have that friend
     * @return array rows User have a matching friend
     */
    public function deleteFriend($friendA, $friendB){
        require_once('../app/model/Friends_List.php');
        $friend = get_friends("*",['friendA'=>['=',$friendA], 'friendB'=>['=',$friendB]]);
        if ($friend == null){
            $friend = get_friends("*",['friendA'=>['=',$friendB], 'friendB'=>['=',$friendA]]);
        }
        return $friend[0]->deleteFriend();
    }

    /**
     * Get Login ID
     * 
     * @param string user_id
     * 
     * @return null User does not exist
     * @return string User Login ID
     */
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

    /**
     * Get Friend Requests
     * 
     * @param string user_id
     * 
     * @return array rows Contains an array of friend requests
     */
    public function getFriendRequests($user_id){
        require_once("../app/model/Friend_Requests.php");
        $rows = get_friendRequests("*",['friendID'=>['=',$user_id]]);
        return $rows;
    }

    /**
     * Get Friend Request
     * 
     * @param string firstID
     * @param string secondID
     * 
     * @return null User does not have that friend request
     * @return array rows User have a matching friend request
     */
    public function getFriendRequest($firstID, $secondID){
        require_once("../app/model/Friend_Requests.php");
        $rows = get_friendRequests("*",['userID'=>['=',$firstID], 'friendID'=>['=',$secondID]]);
        return $rows;
    }

    /**
     * Get Sent Requests
     * 
     * @param string user_id
     * 
     * @return array rows Contains an array of sent friend requests
     */
    public function getSentRequests($user_id){
        require_once("../app/model/Friend_Requests.php");
        $rows = get_friendRequests("*",['userID'=>['=',$user_id]]);
        return $rows;
    }

    /**
     * Confirm Request
     * 
     * @param string friendA
     * @param string friendB
     * 
     * @return bool true if request is confirmed
     * @return bool false if request is not confirmed
     */
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

    /**
     * Delete Request
     * 
     * @param string userID
     * @param string friendID
     * 
     * @return bool true if request is deleted
     * @return bool false if request is not deleted
     */
    public function deleteReq($userID, $friendID){
        require_once('../app/model/Friend_Requests.php');
        $request = $this -> getFriendRequest($userID, $friendID);
        if ($request == null){
            $request = $this -> getFriendRequest($friendID, $userID);
        }
        
        return $request[0]->deleteFriendRequest();
    }

    /**
     * Send Request
     * 
     * @param string userID
     * @param string friendID
     * 
     * @return bool true if request is sent
     * @return bool false if request is not sent
     */
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