<?php

class TintController{
    /**
     * Get id of user
     * 
     * @param string loginid loginid to be found
     * 
     * @return null null No user is found
     * OR
     * @return string id Found UserID
     * 
     */
    public function getUserID($login_id){
        require_once("../app/model/User.php");
        $userFound = get_user("*", ['loginid'=>['=', $login_id]]);
        if($userFound==null){
            return $rows = null;
        }else {
            $user = $userFound[0];
            return $user->getField('id')->getValue();
        }
    }

    /**
     * @param string userid User Tint to get
     * 
     * @return array rows Contains an array of sorted post
     * OR
     * @return null rows no post found
     */
    public function getTint($user_id){
        require_once("../app/model/Post.php");
        $rows = get_post("*",['usr_id'=>['=',$user_id]]);
        //Check if user has a post
        if ($rows!=null) {
            //Sort user by most recent post
            usort($rows, function ($PostEntryA, $PostEntryB) {
                $epochTimeA = $PostEntryA->getField('created_at')->getValue();
                $epochTimeB = $PostEntryB->getField('created_at')->getValue();
                if ($epochTimeA == $epochTimeB) {
                    return 0;
                }
                //Sort By desending order
                return $epochTimeA > $epochTimeB ? -1 : 1;
            });
        }
        return $rows;
    }

    /**
     * Gets Tint by page
     * 
     * @param string tint_info all tints of a user
     * 
     * @return null user has no post
     * OR
     * @return array contains a index with a max page
     * OR
     * @return array containing current up to 5 tint entries
     */

    /**
     * Get Post
     * 
     * @param string user_id
     * @param string post_id
     * 
     * @return null User does not have that post
     * @return array rows User have a matching post
     */
    public function getPost($user_id,$post_id){
        require_once("../app/model/Post.php");
        return $rows = get_post("*",['usr_id'=>['=',$user_id],'id'=>['=',$post_id]]);
    }

    /**
     * Adds a post
     * 
     * @param array tint_post tint_post contains title and content
     * 
     * @return bool result of adding a post
     * @return array values are invalid
     */
    public function AddPost($tint_post){
        $title = $content = "";
        $err_msg = array(false, false);
        $loginid = $_SESSION[SESSION_LOGIN];
        //Validate input
        if(!empty($tint_post['title'])){
            $title = $this->sanitize_input($tint_post['title']);
        }else{
            $err_msg[0] = true;
        }
        if(!empty($tint_post['content'])){
            $content = $this->sanitize_input($tint_post['content']);
        }else{
            $err_msg[1] = true;
        }
        if(in_array(true,$err_msg)){
            return $err_msg;
        }else{
            require_once('../app/model/Post.php');
            $Postvalue = [
                "title"=>$title,
                "content"=>$content,
                "created_at"=>time(),
                "updated_at"=>time(),
                "usr_id"=>$this->getUserID($loginid)
            ];
            //Add post to database    
            $add_post = new Post($Postvalue);
            return $add_post->add();
        }
    }
    /**
     * Get all comments
     * 
     * @param string postid
     * 
     * @return array comment_array all comments of a post
     */
    public function getComments($postid)
    {
        require_once('../app/model/Comment.php');
        require_once('../app/model/User.php');
        $row = get_comment("*", ['posts_id' => ['=', $postid]]);
        $comment_array = array();
        //Check if post have a comment
        if ($row != null) {
            //Sort comments by most recent
            usort($row, function ($CommentA, $CommentB) {
                $epochTimeA = $CommentA->getField('created_at')->getValue();
                $epochTimeB = $CommentB->getField('created_at')->getValue();
                if ($epochTimeA == $epochTimeB) {
                    return 0;
                }
                return $epochTimeA > $epochTimeB ? -1 : 1;
            });
            //Create comment array
            foreach ($row as &$comment) {
                $usr_id = $comment->getField('usr_id')->getValue();
                $loginid = get_user('*', ['id' => ['=', $usr_id]]);
                array_push($comment_array,[
                    'created_at' => $comment->getField('created_at')->getValue(),
                    'loginid' => $loginid[0]->getField('loginid')->getValue(),
                    'comment' => $comment->getField('comment')->getValue()
                ]);
            }

        }
        return $comment_array;
    }

    /**
     * Add a comment to a post
     * 
     * @param string PostID add a comment to this PostID
     * 
     * @return false comment is invalid
     * OR
     * @return array comment is added
     * 
     * 
     */
    public function addComments($PostID){
        require_once('../app/model/Comment.php');
        $comment = "";
        //validate comment
        if(empty($_POST['comment'])){
            return false;
        }else{
            $comment = $this->sanitize_input($_POST['comment']);
        }

        $add_comment = new Comment([
            "comment"=>$comment,
            "usr_id"=>$this->getUserID($_SESSION[SESSION_LOGIN]),
            "posts_id"=>$PostID,
            "created_at"=>time(),
        ]);
        $add_comment->add();
        return true;
    }

    /**
     * Updates Post
     * 
     * @param string content new content of the post
     * @param string postid to be updated
     * 
     * @return false invalid input
     * OR
     * @return array result of post update
     */
    public function  updatePost($content, $postid){
        require_once('../app/model/Post.php');
        //Validate input
        if(empty($content)){
            return false;
        }elseif(empty($postid)){
            return false;
        }

        $userid = $this->getUserID($_SESSION[SESSION_LOGIN]);
        //Get post that is being updated
        $post_update = ($this->getPost($userid,$postid))[0];

        //Updating post
        $updated_post_value = [
            "content"=>$this->sanitize_input($content),
            "updated_at"=>time()
        ];
        foreach($updated_post_value as $key=>$val){
            $post_update->setValue($key,$val);
        }
        return $post_update->update();
    }

    public function deletePost($postid){
        require_once('../app/model/Post.php');
        $loginid = $_SESSION[SESSION_LOGIN];
        $usr_id = $this->getUserID($loginid);
        $post = $this->getPost($usr_id,$postid);
        if(is_array($post)){
            ($post[0])->delete();
        }
    }

    /**
     * sanitize user input
     * 
     * @param string input to be sanitize
     * 
     * @return string santize input
     */
    public function sanitize_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }


}