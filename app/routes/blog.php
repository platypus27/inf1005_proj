<?php

require_once('../app/controllers/BlogController.php');
require_once('../app/controllers/LikesController.php');
require_once('../app/controllers/FriendsController.php');


class blog extends Router
{
    protected $RIGHTS = AUTH_GUEST;
    /**
     * Route for /blog
     */


    /**
     * /blog/
     *
     * No access to all users
     */
    protected function index()
    {
        $this->abort(404);
    }

    /**
     * /blog/u
     *
     * No access to all users
     *
     * /blog/u/<loginid>
     *
     * <loginid>'s blog page
     *
     * /blog/u/<loginid>/<postid>
     *
     * Single Post by <loginid>
     *
     * @param array argv argv[0]: set as loginid
     *                   argv[1]: set as postid
     *
     * array of argv containing more than 2 values
     * will return Error 404
     *
     * Invalid loginid returns Error 404
     */

    protected function u($argv)
    {
        $blog_control = new BlogController();
        $like_control = new LikesController();
        $friends_control = new FriendsController();

        //Checks if parameters contains at least 1 and at most 2 parameters
        if ((sizeof($argv)) < 1 || (sizeof($argv) > 2)) {
            //loginid not in route or parameters > 2
            $this->abort(404);
        } else {
            //loginid in route
            $loginid = $argv[0];
            $UserBlogID = $blog_control->getUserID($loginid);

            //Checks if the user exist
            if ($UserBlogID == null) {
                //User does not exist
                $this->abort(404);
            } else {
                //User Exist
                $requested = null;
                // get friends
                $UserID = $friends_control->getUserID($loginid);
                $friendsList = $friends_control->getFriends($UserID);
                if ($friendsList != null) {
                    foreach ($friendsList as $f) {
                        if ($f->getFriendA()->getValue() != $UserID){
                            $friendsUsers[] = $friends_control->getLoginID($f->getFriendA()->getValue());
                        }
                        elseif ($f->getFriendB()->getValue() != $UserID){
                            $friendsUsers[] = $friends_control->getLoginID($f->getFriendB()->getValue());
                        }
                    }
                    foreach ($friendsUsers as $friend) {
                        if ($friend == $_SESSION[SESSION_LOGIN]) {
                            $requested = 'Friends';
                        }
                    }
                }
                elseif ($loginid == $_SESSION[SESSION_LOGIN]) {
                    $requested = 'MYSELF';
                }
                else {
                    // not currently a friend
                    // get friend requests
                    $friend_requests = $friends_control->getFriendRequests($UserBlogID);
                    $sent_requests = $friends_control->getSentRequests($UserBlogID);

                    // check if there is any ongoing requests eitherway
                    if ($friend_requests != null || $sent_requests != null) {
                        // check if the user has already sent a request
                        if ($friend_requests != null) {
                            $test2 = "yes";
                            foreach ($friend_requests as $f) {
                                $test3 = "yes";
                                $req = $friends_control->getLoginID($f->getUserID()->getValue());
                                if ($req == $_SESSION[SESSION_LOGIN]) {
                                    $test4 = "yes";
                                    $requested = 'Requested';
                                    break;
                                }
                            }
                        }
                        // check if the user has already received a request
                        elseif ($sent_requests != null) {
                            foreach ($sent_requests as $f) {
                                $req = $friends_control->getLoginID($f->getUserID()->getValue());
                                if ($req == $argv[0]) {
                                    $requested = 'Accept Request';
                                    break;
                                }
                            }
                        }
                        else {
                            $requested = null;
                        }
                    }
                }

                //Get User Blog info
                $blog_info = $blog_control->getBlog($UserBlogID);
                $blog_like = $like_control->getLikes(1, $UserBlogID);
                //Check if blog has a post
                if ($blog_info == null) {
                    //This user has no post
                    //Set blog info
                    $data = [
                        'page' => 'blog',
                        'blog_name' => $loginid,
                        'total_post' => 0,
                        'total_likes' => 0,
                        'requests' => $requested,
                    ];
                    //Serve /blog/u/<loginid> with blog.php
                    $this->view($data);
                    
                } else {
                    $usr_like = [];
                    $post_like = [];
                    $test = [];
                    $comments = [];
                    for ($x=1;$x<=sizeof($blog_info);$x++) {
                        require_once '../app/model/Post.php';
                        if(isset($_SESSION[SESSION_LOGIN])){
                            $usr_id = $blog_control->getUserID($_SESSION[SESSION_LOGIN]);
                            $usr_like[] = $like_control->getLikes(3, $usr_id, $postid = $x);
                            $post_like[] = $like_control->getLikes(2, null, $postid = $x);
                        }
                        // Get info of the blog post
                        $comments[] = $blog_control->getComments(($blog_info[$x-1])->getField('id')->getValue());
                    }
                    //Check if a comment is being added
                    
                    
                    //Set blog info
                    $usr_like = array_reverse($usr_like);
                    $post_like = array_reverse($post_like);
                    $comments = array_reverse($comments);
                    $data = [
                        'page' => 'blog',
                        'blog_name' => $loginid,
                        'blog_info' => $blog_info,
                        'requests' => $requested,
                        'usr_like' => $usr_like,
                        'likes_count' => $post_like,
                        'comments' => $comments,
                        'script' => '/static/js/clipboard.js',
                    ];
                    //Serve /blog/u/<loginid> with blog.php
                    $this->view($data);
                }
                
            }
        }
    }
    /**
     * /blog/create
     * Creates a post for <loginid>
     */
    protected function create()
    {
        if(!($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN)){
            $this->abort(400);
        }
        $blog_control = new BlogController();
        //Checks if a post is being added
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //A post is being added

            //return  either array: an post entry is invalid, or bool: post entry is added
            $postsuccess = $blog_control->AddPost($_POST);
            //Check if post is added
            if (is_bool($postsuccess)) {
                //Post is added
                $_SESSION['post_success'] = true;
                //redirect to /blog/u/<loginid>
                header("Location: /blog/u/" . $_SESSION[SESSION_LOGIN]);
            } else {
                //Post is not added

                //returns to create post page with an error message
                $this->view(['page' => 'create', 'err_msg' => $postsuccess]);
            }
        } else {
            //User is creating a post
            $this->view(['page' => 'create']);
        }
    }
    /**
     * /blog/updatepost/<postid>
     * 
     * Update an existing post
     * 
     * @param array argv Contains the postid
     * 
     * Returns an error page if an invalid post is being edited
     */
    protected function updatepost($argv)
    {
        if(!($_SESSION[SESSION_RIGHTS] >= AUTH_LOGIN)){
            $this->abort(400);
        }
        //Check is postid is set
        if (sizeof($argv)!=1) {
            //postid is not set
            $this->abort(404);
        } else {
            //postid is set
            $postid = $argv[0];
            //check if postid is an integer
            if (!is_int(filter_var($postid, FILTER_VALIDATE_INT))) {
                //postid is not a valid int
                $this->abort(403);
            } else {
                //postid is an int
                $blog_control = new BlogController();

                //Check if an update request is sent
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    //Post is being updated
                    //returns either array: entry is invalid, bool: update is a success
                    $postsuccess = $blog_control->updatePost($_POST['content'], $postid);
                    if ($postsuccess == true) {
                        //update is a success
                        //Redirect to user blog
                        $_SESSION['update_success'] = true;
                        header("Location: /blog/u/" . $_SESSION[SESSION_LOGIN]);
                    } else {
                        //update fails
                        //Sends user back to /blog/updatepost/<postid>
                        header("Location: /blog/updatepost/" . $postid . "?update=failed");
                    }
                } else {
                    //User want to edit <postid>
                    $usr_id = $blog_control->getUserID($_SESSION[SESSION_LOGIN]);
                    $blog_post = $blog_control->getPost($usr_id, $postid);
                    //Check if the user owns that post
                    if (is_null($blog_post)) {
                        //User has no access to that post
                        $this->abort(403);
                    } else {
                        //User can edit post
                        $this->view(['page' => 'update_post', 'blog_post' => $blog_post[0]]);
                    }
                }
            }
        }
    }

    protected function deletepost()
    {
        if(!($_SESSION[SESSION_RIGHTS] >= AUTH_LOGIN)){
            $this->abort(400);
        }

        //Only accepts post request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->abort(405);
        }
        $blog_control = new BlogController();
        $like_control = new LikesController();
        if (isset($_POST['postid'])) {
            if ($_POST['postid'] !== null ) {
                $postid = $_POST['postid'];
                //Checks if the postid is an int
                if (is_int(filter_var($postid, FILTER_VALIDATE_INT))) {
                    $like_control->RemovePostLikes($blog_control->getUserID($_SESSION[SESSION_LOGIN]),$postid);
                    $blog_control->deletePost($postid);
                    $_SESSION['postdeleted'] = true;
                    header("Location: /blog/u/" . $_SESSION[SESSION_LOGIN]);
                }
            }else{
                $this->abort(405);
            }
        }else{
            $this->abort(404);
        }
    }
    /**
     * /blog/like
     * 
     * Send a like/Unlike to <postid>
     * 
     * Only accepts POST request
     */
    protected function like()
    {
        if(!($_SESSION[SESSION_RIGHTS] >= AUTH_LOGIN)){
            $this->abort(400);
        }

        //Only accepts post request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->abort(405);
        }
        $likes_control = new LikesController();

        if (isset($_POST['submit'])) {
            if ($_POST['submit'] !== null ) {
                $postid = $_POST['postid'];
                //Checks if the postid is an int
                if (is_int(filter_var($postid, FILTER_VALIDATE_INT))) {
                    //Checks if user like the post
                    if ($_POST['submit'] == 'Like') {
                        $likes_control->setLikes($postid);
                        header('Location: ' . parse_url($_SERVER['HTTP_REFERER'])['path']);
                        //check if user unlike the post
                    } elseif ($_POST['submit'] == 'Unlike') {
                        $likes_control->RemoveLikes($postid);
                        header('Location: ' . parse_url($_SERVER['HTTP_REFERER'])['path']);
                    }
                } else {
                    $this->abort(405);
                }
            } else {
                $this->abort(404);
            }
        } else {
            $this->abort(404);
        }
    }

    protected function sendReq($argv)
    {
        if(!($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN)){
            $this->abort(400);
        }
        $friends_control = new FriendsController();
        $friendA = $friends_control->getUserID($_SESSION[SESSION_LOGIN]);
        $friendB = $friends_control->getUserID($argv[0]);
        //Checks if a post is being added
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //A post is being added
            
            //return  either array: an post entry is invalid, or bool: post entry is added
            $addsuccess = $friends_control->sendReq($friendA, $friendB);
            //Check if post is added
            if (is_bool($addsuccess)) {
                //Post is added
                $_SESSION['post_success'] = true;
                header("Location: /blog/u/" . $argv[0]);
            }
        }
    }

    protected function deleteReq($argv)
    {
        $friends_control = new FriendsController();
        $friendA = $friends_control->getUserID($_SESSION[SESSION_LOGIN]);
        $friendB = $friends_control->getUserID($argv[0]);
        if(!($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN)){
            $this->abort(400);
        }
        //Checks if a post is being added
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //A post is being added
            
            //return  either array: an post entry is invalid, or bool: post entry is added
            $removesuccess = $friends_control->deleteReq($friendA, $friendB);
            //Check if post is added
            if (is_bool($removesuccess)) {
                //Post is added
                $_SESSION['post_success'] = true;
                header("Location: /blog/u/" . $argv[0]);
            } else {
                //Post is not added

                //returns to create post page with an error message
                header("Location: /blog/u/" . $argv[0]);
            }
        } else {
            //User is creating a post
            header("Location: /blog/u/" . $argv[0]);
        }
    }

    protected function acceptReq($argv){
        $friends_control = new FriendsController();
        $friendA = $friends_control->getUserID($_SESSION[SESSION_LOGIN]);
        $friendB = $friends_control->getUserID($argv[0]);
        if(!($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN)){
            $this->abort(400);
        }
        //Checks if a post is being added
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //A post is being added
            
            //return  either array: an post entry is invalid, or bool: post entry is added
            $addsuccess = $friends_control->confirmReq($friendA, $friendB);
            $removesuccess = $friends_control->deleteReq($friendA, $friendB);
            //Check if post is added
            if (is_bool($addsuccess)) {
                //Post is added
                $_SESSION['post_success'] = true;
                header("Location: /blog/u/" . $_SESSION[SESSION_LOGIN]);
            } else {
                //Post is not added

                //returns to create post page with an error message
                header("Location: /blog/u/" . $_SESSION[SESSION_LOGIN]);
            }
        } else {
            //User is creating a post
            header("Location: /blog/u/" . $_SESSION[SESSION_LOGIN]);
        }
    }

    protected function delFriend($argv) {
        $friends_control = new FriendsController();
        $friendA = $friends_control->getUserID($_SESSION[SESSION_LOGIN]);
        $friendB = $friends_control->getUserID($argv[0]);
        if(!($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN)){
            $this->abort(400);
        }
        //Checks if a post is being added
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //A post is being added
            
            //return  either array: an post entry is invalid, or bool: post entry is added
            $removesuccess = $friends_control->deleteFriend($friendA, $friendB);
            //Check if post is added
            if (is_bool($removesuccess)) {
                //Post is added
                $_SESSION['post_success'] = true;
                header("Location: /blog/u/" . $argv[0]);
            } else {
                //Post is not added

                //returns to create post page with an error message
                header("Location: /blog/u/" . $argv[0]);
            }
        } else {
            //User is creating a post
            header("Location: /blog/u/" . $argv[0]);
        }
    }

    protected function addComment($argv) {
        require_once('../app/controllers/BlogController.php');
        $blog_control = new BlogController();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //returns true:Comment added, false:Comment not added
            $blog_control->addComments($argv[0]+1);
        }
        header("Location: /blog/u/" . $_SESSION[SESSION_LOGIN]);
    }
}