<?php

require_once("../app/model/Friends.php");

class friends extends Router {

    protected function u()
    {
        $friends_control = new FriendsController();

        //loginid in route
        $loginid = $argv[0];
        $UserBlogID = $friends_control->getUserID($loginid);
        //Checks if the user exist
        if ($UserBlogID == null) {
            //User does not exist
            $this->abort(404);
        } else {
            //User Exist
            $friendsList = $friends_control->getFriends($UserBlogID);
            // Process the friends list data here
            // For example, you can loop through the friends list and display their names
            $data = [
                'friends_list' => $friendsList
            ];
        }
    }
}