<?php
require_once('../app/controllers/TintController.php');
require_once('../app/model/Post_Like.php');

/**
 * LikesController
 * 
 * @package LikesController
 * 
 */
class LikesController{
    /**
     * Like a Post
    * @param string postid
    *
    */
    public function setLikes($postid){
        $loginid = $_SESSION[SESSION_LOGIN];
        $usr_id = (new TintController())->getUserID($loginid);
        //Check if post is already liked by user
        $LikeFound = $this->getLikes(3,$usr_id,$postid);
        if(is_null($LikeFound)) {
            //User did not like post yet
            $Like_values = [
                'usr_id' => $usr_id,
                'posts_id' => $postid,
                'liked_at' => time()
            ];
            $add_like = new Post_Like($Like_values);

            return $add_like->add();
        }else{
            //User has already liked the post
            return false;
        }

    }

    /**
     * remove like from post
    * 
    * 
    * @param string postid
    */
    public function RemoveLikes($postid){
        $loginid = $_SESSION[SESSION_LOGIN];
        $usr_id = (new TintController())->getUserID($loginid);
        //Check if user like the post
        $like_post = ($this->getLikes(3, $usr_id,$postid));
        if(is_array($like_post)){
            ($like_post[0])->delete();
        }
    }
    public function RemovePostLikes($postid){
        $all_post_like = get_post_likes('*',['posts_id'=>['=',$postid]]);
        foreach($all_post_like as $lp){
                $lp->delete();
        }
    }

    /**
     * get likes base on liketype
    * 
    * @param int liketype
    * @param string usr_id
    * @param string postid
    *
    * 
    */
    public function getLikes($liketype, $usr_id = null, $postid = null){
        require_once("../app/model/Post.php");
    
        switch ($liketype) {
            case 1:
                return $this->getUserPostLikes($usr_id);
            case 2:
                return $this->getPostLikes($postid);
            case 3:
                return $this->getUserSpecificPostLikes($usr_id, $postid);
            default:
                throw new InvalidArgumentException("Invalid like type: $liketype");
        }
    }
    
    private function getUserPostLikes($usr_id) {
        $all_usr_likes = get_post_likes('*',['usr_id'=>['=',$usr_id]]);
        
        return $all_usr_likes;
    }
    
    private function getPostLikes($postid) {
        $row = get_post_likes('*',['posts_id'=>['=',$postid]]);
        return is_null($row) ? 0 : sizeof($row);
    }
    
    private function getUserSpecificPostLikes($usr_id, $postid) {
        return get_post_likes('*',['usr_id'=>['=',$usr_id], 'posts_id'=>['=',$postid]]);
    }

}