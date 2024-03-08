<?php

require_once('../app/controllers/BlogController.php');
require_once('../app/controllers/FriendsController.php');

class friends extends Router 
{
    protected function u($argv)
    {
        $friends_control = new FriendsController();

        //loginid in route
        $loginid = $argv[0];
        $UserBlogID = $friends_control->getUserID($loginid);
        
        $friendsList = $friends_control->getFriends($UserBlogID);
        $data = [
            'page' => 'friends',
            // 'friends_list' => 'wtf man how to do',
            'friends_list' => $friendsList,
        ];
        $this->view($data);
    }
}