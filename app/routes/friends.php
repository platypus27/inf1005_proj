<?php

require_once('../app/controllers/TintController.php');
require_once('../app/controllers/FriendsController.php');

/**
 * friends
 * 
 * This class is responsible for handling friends requests
 * 
 * @category Router
 * @package  friends
 * 
 */
class friends extends Router 
{
    /**
     * All
     * 
     * This function is responsible for handling all friends requests
     * 
     * @return void
     * 
     */
    protected function u()
    {
        $friends_control = new FriendsController();
        $friendsUsers = [];
        $friendReq = [];
        $sentReq = [];

        //loginid in route
        $loginid = $_SESSION[SESSION_LOGIN];
        $UserID = $friends_control->getUserID($loginid);
        $friendsList = $friends_control->getFriends($UserID);
        foreach ($friendsList as $f) {
            if ($f->getFriendA()->getValue() != $UserID){
                $friendsUsers[] = $friends_control->getLoginID($f->getFriendA()->getValue());
            }
            elseif ($f->getFriendB()->getValue() != $UserID){
                $friendsUsers[] = $friends_control->getLoginID($f->getFriendB()->getValue());
            }
        }

        // friend requests
        $friend_requests = $friends_control->getFriendRequests($UserID);
        if($friend_requests != null){
            foreach ($friend_requests as $f) {
                $friendReq[] = $friends_control->getLoginID($f->getUserID()->getValue());
            }
        }
        $sent_requests = $friends_control->getSentRequests($UserID);
        if($sent_requests != null){
            foreach ($sent_requests as $f) {
                $sentReq[] =  $friends_control->getLoginID($f->getFriendID()->getValue());
            }
        }

        $data = [
            'page' => 'friends',
            'friends_list' => $friendsUsers,
            'friend_requests' => $friendReq,
            'sent_requests' => $sentReq,
            'userid' => $UserID,
            'test' => $friendsList
        ];
        $this->view($data);
    }

    /**
     * Add friend
     * 
     * This function is responsible for adding a friend
     * 
     * @param   array   $argv    URL parameters
     * 
     * @return void
     * 
     */
    protected function addfriend($argv)
    {
        $friends_control = new FriendsController();
        $friendA = $friends_control->getUserID($_SESSION[SESSION_LOGIN]);
        $friendB = $friends_control->getUserID($argv[0]);
        if(!($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN)){
            $this->abort(400);
        }
        //Checks if a post is being added
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //A post is being added
            
            //return  either array: an post entry is invalid, or bool: post entry is added
            $addsuccess = $friends_control->confirmReq($friendA, $friendB);
            $removesuccess = $friends_control->deleteReq($friendA, $friendB);
            //Check if post is added
            if (is_bool($addsuccess)) {
                //Post is added
                $_SESSION['post_success'] = true;
                header("Location: /friends/u/" . $_SESSION[SESSION_LOGIN]);
            } else {
                //Post is not added

                //returns to create post page with an error message
                $this->view(['page' => 'friends', 'err_msg' => $addsuccess]);
            }
        } else {
            //User is creating a post
            $this->view(['page' => 'friends']);
        }
    }

    /**
     * Reject friend
     * 
     * This function is responsible for rejecting a friend request
     * 
     * @param   array   $argv    URL parameters
     * 
     * @return void
     * 
     */
    protected function rejectfriend($argv)
    {
        $friends_control = new FriendsController();
        $friendA = $friends_control->getUserID($_SESSION[SESSION_LOGIN]);
        $friendB = $friends_control->getUserID($argv[0]);
        if(!($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN)){
            $this->abort(400);
        }
        //Checks if a post is being added
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //A post is being added
            
            //return  either array: an post entry is invalid, or bool: post entry is added
            $removesuccess = $friends_control->deleteReq($friendA, $friendB);
            //Check if post is added
            if (is_bool($removesuccess)) {
                //Post is added
                $_SESSION['post_success'] = true;
                header("Location: /friends/u/" . $_SESSION[SESSION_LOGIN]);
            } else {
                //Post is not added

                //returns to create post page with an error message
                $this->view(['page' => 'friends', 'err_msg' => $removesuccess]);
            }
        } else {
            //User is creating a post
            $this->view(['page' => 'friends']);
        }
    }

    /**
     * Send friend request
     * 
     * This function is responsible for sending a friend request
     * 
     * @param   array   $argv    URL parameters
     * 
     * @return void
     * 
     */
    protected function sendReq($argv){
        $friends_control = new FriendsController();
        $userID = $friends_control->getUserID($_SESSION[SESSION_LOGIN]);
        $friendID = $friends_control->getUserID($argv[0]);
        if(!($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN)){
            $this->abort(400);
        }
        //Checks if a post is being added
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //A post is being added
            
            //return  either array: an post entry is invalid, or bool: post entry is added
            $addsuccess = $friends_control->sendReq($userID, $friendID);
            //Check if post is added
            if (is_bool($addsuccess)) {
                //Post is added
                $_SESSION['post_success'] = true;
                header("Location: /friends/u/" . $_SESSION[SESSION_LOGIN]);
            } else {
                //Post is not added

                //returns to create post page with an error message
                $this->view(['page' => 'friends', 'err_msg' => $addsuccess]);
            }
        } else {
            //User is creating a post
            $this->view(['page' => 'friends']);
        }
    }

    /**
     * Delete friend
     * 
     * This function is responsible for deleting a friend
     * 
     * @param   array   $argv    URL parameters
     * 
     * @return void
     * 
     */
    protected function delFriend($argv){
        $friends_control = new FriendsController();
        $userID = $friends_control->getUserID($_SESSION[SESSION_LOGIN]);
        $friendID = $friends_control->getUserID($argv[0]);
        
        if(!($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN)){
            $this->abort(400);
        }
        
        // Delete the row from the friends_list table
        $deleteSuccess = $friends_control->deleteFriend($userID, $friendID);
        
        if ($deleteSuccess) {
            // Row deleted successfully
            $_SESSION['post_success'] = true;
            header("Location: /friends/u/" . $_SESSION[SESSION_LOGIN]);
        } else {
            // Error deleting the row
            $this->view(['page' => 'friends', 'err_msg' => 'Error deleting friend']);
        }
    }
}