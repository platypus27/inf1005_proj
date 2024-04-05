<?php

require_once('../app/controllers/TintController.php');
require_once('../app/controllers/LikesController.php');
require_once('../app/controllers/FriendsController.php');

/**
 * Tint
 * 
 * This class is responsible for handling tint requests
 * 
 * @category Controller
 * @package  Tint
 * 
 */
class tint extends Router
{
    protected $RIGHTS = AUTH_GUEST;
    /**
     * Route for /tint
     */


    /**
     * /tint/
     *
     * No access to all users
     */
    protected function index()
    {
        $this->abort(404);
    }

    /**
     * /tint/u/<loginid>
     * 
     * Get the tint of <loginid>
     * 
     * @param array argv Contains the loginid
     * 
     * Returns an error page if an invalid loginid is being accessed
     */
    protected function u($argv)
    {
        $tint_control = new TintController();
        $like_control = new LikesController();
        $friends_control = new FriendsController();

        //Checks if parameters contains at least 1 and at most 2 parameters
        if ((sizeof($argv)) < 1 || (sizeof($argv) > 2)) {
            //loginid not in route or parameters > 2
            $this->abort(404);
        } else {
            //loginid in route
            $loginid = $tint_control->getUserID($_SESSION[SESSION_LOGIN]);
            $UserTintID = $tint_control->getUserID($argv[0]);

            //Checks if the user exist
            if ($UserTintID == null) {
                //User does not exist
                $this->abort(404);
            } else {
                //User Exist
                $requested = null;
                // get friends
                $friendsList = $friends_control->getFriends($UserTintID);
                // get friend requests
                $friend_requests = $friends_control->getFriendRequests($loginid);
                $sent_requests = $friends_control->getSentRequests($loginid);
                foreach ($friendsList as $f) {
                    if ($f->getFriendA()->getValue() != $UserTintID){
                        $friendsUsers[] = $friends_control->getLoginID($f->getFriendA()->getValue());
                    }
                    elseif ($f->getFriendB()->getValue() != $UserTintID){
                        $friendsUsers[] = $friends_control->getLoginID($f->getFriendB()->getValue());
                    }
                }
                if ($friendsList != null) {
                    foreach ($friendsUsers as $friend) {
                        if ($friend == $_SESSION[SESSION_LOGIN]) {
                            $requested = 'Friends';
                        }
                    }
                }
                if ($argv[0] == $_SESSION[SESSION_LOGIN]) {
                    $requested = 'MYSELF';
                }
                if ($friend_requests != null){
                    foreach ($friend_requests as $f) {
                        $req = $friends_control->getLoginID($f->getUserID()->getValue());
                        if ($req == $argv[0]) {
                            $requested = 'Accept Request';
                            break;
                        }
                    }
                }
                if ($sent_requests != null){
                    foreach ($sent_requests as $s) {
                        $req = $friends_control->getLoginID($s->getFriendID()->getValue());
                        if ($req == $argv[0]) {
                            $requested = 'Requested';
                            break;
                        }
                    }
                }

                //Get User Tint info
                $tint_info = $tint_control->getTint($UserTintID);
                $tint_like = $like_control->getLikes(1, $UserTintID);
                //Check if tint has a post
                if ($tint_info == null) {
                    //This user has no post
                    //Set tint info
                    $data = [
                        'page' => 'tint',
                        'tint_name' => $argv[0],
                        'total_post' => 0,
                        'total_likes' => 0,
                        'requests' => $requested,
                    ];
                    //Serve /tint/u/<loginid> with tint.php
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
                    for ($x=1;$x<=sizeof($tint_info);$x++) {
                        $comments[] = $tint_control->getComments(($tint_info[$x-1])->getField('id')->getValue());
                        $postid = $tint_info[$x-1]->getField('id')->getValue();
                        $post_like[$postid] = $like_control->getLikes(2, null, $postid);
                    }
                    //Check if a comment is being added
                    
                    
                    //Set tint info
                    $tint_info = array_reverse($tint_info);
                    $comments = array_reverse($comments);
                    $data = [
                        'page' => 'tint',
                        'tint_name' => $argv[0],
                        'tint_info' => $tint_info,
                        'requests' => $requested,
                        'usr_like' => $postIds,
                        'likes_count' => $post_like,
                        'comments' => $comments,
                        'script' => '../../public/static/js/clipboard.js',
                    ];
                    //Serve /tint/u/<loginid> with tint.php
                    $this->view($data);
                }
                
            }
        }
    }

    /**
     * /tint/create
     * Creates a post for <loginid>
     */
    protected function create()
    {
        if(!($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN)){
            $this->abort(400);
        }
        $tint_control = new TintController();
        //Checks if a post is being added
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //A post is being added

            //return  either array: an post entry is invalid, or bool: post entry is added
            $postsuccess = $tint_control->AddPost($_POST);
            //Check if post is added
            if (is_bool($postsuccess)) {
                //Post is added
                $_SESSION['post_success'] = true;
                //redirect to /tint/u/<loginid>
                header("Location: /tint/u/" . $_SESSION[SESSION_LOGIN]);
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
     * /tint/updatepost/<postid>
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
                $tint_control = new TintController();

                //Check if an update request is sent
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    //Post is being updated
                    //returns either array: entry is invalid, bool: update is a success
                    $postsuccess = $tint_control->updatePost($_POST['content'], $postid);
                    if ($postsuccess == true) {
                        //update is a success
                        //Redirect to user tint
                        $_SESSION['update_success'] = true;
                        header("Location: /tint/u/" . $_SESSION[SESSION_LOGIN]);
                    } else {
                        //update fails
                        //Sends user back to /tint/updatepost/<postid>
                        header("Location: /tint/updatepost/" . $postid . "?update=failed");
                    }
                } else {
                    //User want to edit <postid>
                    $usr_id = $tint_control->getUserID($_SESSION[SESSION_LOGIN]);
                    $tint_post = $tint_control->getPost($usr_id, $postid);
                    //Check if the user owns that post
                    if (is_null($tint_post)) {
                        //User has no access to that post
                        $this->abort(403);
                    } else {
                        //User can edit post
                        $this->view(['page' => 'update_post', 'tint_post' => $tint_post[0]]);
                    }
                }
            }
        }
    }

    /**
     * /tint/deletepost
     * 
     * Delete a post
     */
    protected function deletepost()
    {
        if(!($_SESSION[SESSION_RIGHTS] >= AUTH_LOGIN)){
            $this->abort(400);
        }

        //Only accepts post request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->abort(405);
        }
        $tint_control = new TintController();
        $like_control = new LikesController();
        if (isset($_POST['postid'])) {
            if ($_POST['postid'] !== null ) {
                $postid = $_POST['postid'];
                error_log("Postid: " . $postid, 0);
                //Checks if the postid is an int
                if (is_int(filter_var($postid, FILTER_VALIDATE_INT))) {
                    $like_control->RemovePostLikes($tint_control->getUserID($_SESSION[SESSION_LOGIN]),$postid);
                    $tint_control->deletePost($postid);
                    $_SESSION['postdeleted'] = true;
                    header("Location: /tint/u/" . $_SESSION[SESSION_LOGIN]);
                }
            }else{
                $this->abort(405);
            }
        }else{
            $this->abort(404);
        }
    }

    /**
     * /tint/like
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

    /**
     * /tint/sendreq/<loginid>
     * 
     * Send a friend request to <loginid>
     * 
     * @param array argv Contains the loginid
     * 
     * Returns an error page if an invalid loginid is being accessed
     */
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
                header("Location: /tint/u/" . $argv[0]);
            }
        }
    }

    /**
     * /tint/deletereq/<loginid>
     * 
     * Delete a friend request to <loginid>
     * 
     * @param array argv Contains the loginid
     * 
     * Returns an error page if an invalid loginid is being accessed
     */
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
                header("Location: /tint/u/" . $argv[0]);
            } else {
                //Post is not added

                //returns to create post page with an error message
                header("Location: /tint/u/" . $argv[0]);
            }
        } else {
            //User is creating a post
            header("Location: /tint/u/" . $argv[0]);
        }
    }

    /**
     * /tint/acceptreq/<loginid>
     * 
     * Accept a friend request from <loginid>
     * 
     * @param array argv Contains the loginid
     * 
     * Returns an error page if an invalid loginid is being accessed
     */
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
                header("Location: /tint/u/" . $_SESSION[SESSION_LOGIN]);
            } else {
                //Post is not added

                //returns to create post page with an error message
                header("Location: /tint/u/" . $_SESSION[SESSION_LOGIN]);
            }
        } else {
            //User is creating a post
            header("Location: /tint/u/" . $_SESSION[SESSION_LOGIN]);
        }
    }

    /**
     * /tint/delfriend/<loginid>
     * 
     * Delete a friend from <loginid>
     * 
     * @param array argv Contains the loginid
     * 
     * Returns an error page if an invalid loginid is being accessed
     */
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
                header("Location: /tint/u/" . $argv[0]);
            } else {
                //Post is not added

                //returns to create post page with an error message
                header("Location: /tint/u/" . $argv[0]);
            }
        } else {
            //User is creating a post
            header("Location: /tint/u/" . $argv[0]);
        }
    }

    /**
     * /tint/addcomment/<postid>
     * 
     * Add a comment to <postid>
     * 
     * @param array argv Contains the postid
     * 
     * Returns an error page if an invalid postid is being accessed
     */
    protected function addComment($argv) {
        require_once('../app/controllers/TintController.php');
        $tint_control = new TintController();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //returns true:Comment added, false:Comment not added
            $tint_control->addComments($argv[0]+1);
        }
        header("Location: /tint/u/" . $_SESSION[SESSION_LOGIN]);
    }
}