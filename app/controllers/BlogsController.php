<?php
class BlogsController{
    public function getAllPosts(){
        require_once("../app/model/Post.php");
        $rows = get_post();
        return $rows;
    }
}
?>