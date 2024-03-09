<?php

require_once('../app/controllers/BlogController.php');
require_once('../app/controllers/FriendsController.php');

class friends extends Router 
{
    protected function u($argv)
    {
        $friends_control = new FriendsController();
        $friendsUsers = [];

        //loginid in route
        $loginid = $argv[0];
        $UserID = $friends_control->getUserID($loginid);
        $friendsList = $friends_control->getFriends();
        foreach ($friendsList as $f) {
            if ($f->getFriendA()->getValue() != $UserID){
                $friendsUsers[] = $friends_control->getLoginID($f->getFriendA()->getValue());
            }
            elseif ($f->getFriendB()->getValue() != $UserID){
                $friendsUsers[] = $friends_control->getLoginID($f->getFriendB()->getValue());
            }
            // $test = $friends_control->getLoginID($friendsList->getFriendA()->getValue());
        }
        // $test = $friends_control->getLoginID(2);

        // if ($friendsList->getFriendA()->getValue() != $UserID){
        //     $friendsUsers = ['']
        // }
        // if ($friendsList->getFriendB()->getValue() != $UserID){
        //     echo 'Friend B ID: ' . $friendsList->getFriendB()->getValue() . '<br>';
        // }
        $data = [
            'page' => 'friends',
            // 'test' => $test,
            'friends_list' => $friendsUsers,
            'userid' => $UserID
        ];
        $this->view($data);
    }
}