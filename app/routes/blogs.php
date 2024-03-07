<?php

require_once('../app/controllers/BlogsController.php');
class blogs extends Router 
{
    public function all()
    {
        $blogs_control = new BlogsController();
        // $like_control = new LikesController();
        
        //View Blog

        //Get All Blog info
        $blogs_info = $blogs_control->getAllPosts();
        // $blog_like = $like_control->getLikes(1, $UserBlogID);

        //Check if blog has a post
        if ($blogs_info == null) {
            //This user has no post
            //Set blog info
            $data = [
                'page' => 'blogs',
                'total_post' => 0,
                'total_likes' => 0,
                'blog_info' => 'tests3'
            ];
            //Serve /main/blogs with blog.php
            $this->view($data);

        } else {
            //Set blog info
            $data = [
                'page' => 'blogs',
                'total_post' => is_null($blogs_info) ? 0 : sizeof($blogs_info),
                'blog_info' => $blogs_info
                // 'total_likes' => $blog_like
            ];
            //Serve /main/blogs with blogs.php
            $this->view($data);
        }
        
    }
}
?>