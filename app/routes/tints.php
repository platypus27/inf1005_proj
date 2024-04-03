<?php

require_once('../app/controllers/TintsController.php');
require_once('../app/controllers/TintController.php');
require_once('../app/controllers/LikesController.php');

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
        
        //View Tint

        //Get All Tint info
        $tints_info = $tints_control->getAllPosts();
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
            for ($x=1;$x<=sizeof($tints_info);$x++) {
                require_once '../app/model/Post.php';
                if(isset($_SESSION[SESSION_LOGIN])){
                    $usr_id = $tint_control->getUserID($_SESSION[SESSION_LOGIN]);
                    $usr_like[] = $like_control->getLikes(3, $usr_id, $postid = $x);
                    $post_like[] = $like_control->getLikes(2, null, $postid = $x);
                }
                $comments[] = $tint_control->getComments(($tints_info[$x-1])->getField('id')->getValue());
            }
            $tints_info = array_reverse($tints_info);
            $comments = array_reverse($comments);
            //Set tint info
            $data = [
                'page' => 'tints',
                'tint_name' => $loginid,
                'tint_info' => $tints_info,
                'usr_like' => $usr_like,
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