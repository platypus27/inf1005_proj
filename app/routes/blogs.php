<?php

require_once('../app/controllers/BlogsController.php');
require_once('../app/controllers/BlogController.php');
require_once('../app/controllers/LikesController.php');

/**
 * blogs
 * 
 * This class is responsible for handling blog requests
 * 
 * @category Router
 * @package  blogs
 * 
 */
class blogs extends Router 
{
    /**
     * All
     * 
     * This function is responsible for handling all blog requests
     * 
     * @return void
     * 
     */
    public function all()
    {
        $blogs_control = new BlogsController();
        $blog_control = new BlogController();
        $like_control = new LikesController();
        
        //View Blog

        //Get All Blog info
        $blogs_info = $blogs_control->getAllPosts();
        $loginid = $_SESSION[SESSION_LOGIN];

        //Check if blog has a post
        if ($blogs_info == null) {
            //This user has no post
            //Set blog info
            $data = [
                'page' => 'blogs',
                'total_post' => 0,
                'total_likes' => 0,
            ];
            //Serve /main/blogs with blog.php
            $this->view($data);

        } else {

            $usr_like = [];
            $post_like = [];
            $comments = [];
            for ($x=1;$x<=sizeof($blogs_info);$x++) {
                require_once '../app/model/Post.php';
                if(isset($_SESSION[SESSION_LOGIN])){
                    $usr_id = $blog_control->getUserID($_SESSION[SESSION_LOGIN]);
                    $usr_like[] = $like_control->getLikes(3, $usr_id, $postid = $x);
                    $post_like[] = $like_control->getLikes(2, null, $postid = $x);
                }
                $comments[] = $blog_control->getComments(($blogs_info[$x-1])->getField('id')->getValue());
            }
            $blogs_info = array_reverse($blogs_info);
            $comments = array_reverse($comments);
            //Set blog info
            $data = [
                'page' => 'blogs',
                'blog_name' => $loginid,
                'blog_info' => $blogs_info,
                'usr_like' => $usr_like,
                'likes_count' => $post_like,
                'comments' => $comments,
                'script' => '../../public/static/js/clipboard.js',
            ];
            //Serve /main/blogs with blogs.php
            $this->view($data);
        }
        
    }
    /**
     * Add
     * 
     * This function is responsible for handling add blog requests
     * 
     * @param array $argv
     * 
     * @return void
     * 
     */
    protected function addComment($argv) {
        require_once('../app/controllers/BlogController.php');
        $blog_control = new BlogController();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //returns true:Comment added, false:Comment not added
            $blog_control->addComments($argv[0]+1);
        }
        header("Location: /blogs/all");
    }
}
?>