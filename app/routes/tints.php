<?php

require_once('../app/controllers/TintsController.php');
require_once('../app/controllers/TintController.php');
require_once('../app/controllers/LikesController.php');
require_once('../app/controllers/FriendsController.php');

/**
 * tints
 * 
 * This class is responsible for handling tint requests
 * 
 * @category Router
 * @package  tints
 * 
 */
class tints extends Router 
{
    /**
     * All
     * 
     * This function is responsible for handling all tint requests
     * 
     * @return void
     * 
     */
    public function all()
    {
        $tints_control = new TintsController();
        $tint_control = new TintController();
        $like_control = new LikesController();
        $friends_control = new FriendsController();
        
        //View Tint

        //Get All Tint info
        $tints_info = $tints_control->getAllPosts();
        $usernames = array();
        for ($i = 0; $i < count($tints_info); $i++) {
            $usr_id_field = $tints_info[$i]->getUsrId();
            $new_login_id = $friends_control->getLoginID($usr_id_field->getValue());
        
            $post_id_field = $tints_info[$i]->getId(); // Get the ID Field object
            $post_id = $post_id_field->getValue(); // Get the value of the field
            $usernames[$i] = $new_login_id;
        }
        $loginid = $_SESSION[SESSION_LOGIN];

        //Check if tint has a post
        if ($tints_info == null) {
            //This user has no post
            //Set tint info
            $data = [
                'page' => 'tints',
                'total_post' => 0,
                'total_likes' => 0,
            ];
            //Serve /main/tints with tint.php
            $this->view($data);

        } else {

            $usr_like = [];
            $post_like = [];
            $comments = [];
            $usr_id = $tint_control->getUserID($_SESSION[SESSION_LOGIN]);
            $usr_like[] = $like_control->getLikes(1, $usr_id);
            $postsIds = [];
            foreach ($usr_like as $innerArray) {
                foreach ($innerArray as $postLikeObject) {
                    $postsIds[] = $postLikeObject->getPostsId();
                }
            }
            $postIds = array_fill_keys($postsIds, 1);
            
            for ($x=1;$x<=sizeof($tints_info);$x++) {
                $comments[] = $tint_control->getComments(($tints_info[$x-1])->getField('id')->getValue());
                $postid = $tints_info[$x-1]->getField('id')->getValue();
                $post_like[$postid] = $like_control->getLikes(2, null, $postid);
            }
            $tints_info = array_reverse($tints_info);
            $comments = array_reverse($comments);
            $usernames = array_reverse($usernames);
            //Set tint info
            $data = [
                'page' => 'tints',
                'username' => $usernames,
                'tint_name' => $loginid,
                'tint_info' => $tints_info,
                'usr_like' => $postIds,
                'likes_count' => $post_like,
                'comments' => $comments,
                'script' => '../../public/static/js/clipboard.js',
            ];
            //Serve /main/tints with tints.php
            $this->view($data);
        }
        
    }
    /**
     * Add
     * 
     * This function is responsible for handling add tint requests
     * 
     * @param array $argv
     * 
     * @return void
     * 
     */
    protected function addComment($argv) {
        require_once('../app/controllers/TintController.php');
        $tint_control = new TintController();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //returns true:Comment added, false:Comment not added
            $tint_control->addComments($argv[0]+1);
        }
        header("Location: /tints/all");
    }
}
?>