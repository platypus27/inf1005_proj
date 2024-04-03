<?php
/**
 * Controller for User Accounts
 * This file states all the functions that are required to manage user accounts
 * 
 * @package    Blog
 * @subpackage Blog/controllers
 * @category   Controllers
 * @version    1.0
 * 
 */

require_once("../app/model/User.php");
require_once("../app/constants.php");

class AccountController
{
    /**
     * Get the details of the user from database
     * 
     * @return User|null
     * 
     * @var string $loginid
     */
    public function getdetails()
    {
        if($_SESSION[SESSION_RIGHTS] == AUTH_LOGIN || $_SESSION[SESSION_RIGHTS] == AUTH_ADMIN){
            $loginid = $_SESSION[SESSION_LOGIN];
            $data = get_user('*', ['loginid' => ["=", $loginid]]);
            return $data == NULL ? NULL : $data[0];
        } else {
            return NULL;
        }
    }

    /**
     * Sanitize the input
     * 
     * @return string
     * 
     * @var string $input
     */
    public function sanitize_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    /**
     * Update the user details
     * 
     * @return bool
     * 
     * @var string $userid
     * @var string $name
     * @var string $cpwd
     * @var string $npwd 
     * @var string $ncpwd
     * @var string $email
     * @var string $key
     * @var string $val
     * @var array $keyval
     * @var string $msg
     * @var string $errorMsg
     * @var bool $success
     * @var bool $p
     * @var string $currentpwd
     * 
     */
    public function update_user() {
        $user = $this->getdetails();

        $currentpwd = $user->getField('password')->getValue();
        $errorMsg = "";
        $success = true;
        $p = false;

        // variables
        $userid = $this->sanitize_input($_POST["userid"]);
        $name = $this->sanitize_input($_POST["name"]);
        $cpwd = $this->sanitize_input($_POST["cpassword"]);
        $npwd = $this->sanitize_input($_POST["npassword"]);
        $ncpwd = $this->sanitize_input($_POST["ncpassword"]);
        $email = $this->sanitize_input($_POST["email"]);
        $key = '';
        $val = '';
        $keyval = (array) null;
        $msg = '';
        
        if ($userid != $_SESSION[SESSION_LOGIN]){
            if (get_user('*', ['loginid' => ["=", $userid]]) !== NULL) {
                $_SESSION['msg'] = "a user with the given user id already exists";
                return;
            }
        }
        
        switch ($_POST["update"]) {
                //when update user id button is pressed
            case 'bprofile':
                if (empty($userid)) {
                    $errorMsg .= "user id is required <br>";
                    $success = false;
                } else {
                    $keyval['loginid'] = $userid;
                    $msg = 'profile';
                    $success = $success && true;
                }

                if (empty($email)) {
                    $errorMsg .= "email is required.<br>";
                    $success = false;
                } else {
                    // Additional check to make sure e-mail address is well-formed.
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errorMsg .= "invalid email format.<br>";
                        $success = false;
                    } else {
                        $keyval['email'] = $email;
                        $msg = 'profile';
                        $success = $success && true;
                    }
                }

                if (empty($name)) {
                    $errorMsg .= "name is required <br>";
                    $success = false;
                } else {
                    $keyval['name'] = $name;
                    $msg = 'profile';
                    $success = $success && true;
                }
                break;
                
            case 'bpassword':
                if (empty($cpwd) || empty($npwd) || empty($ncpwd)) {
                    $errorMsg .= "password is required.";
                    $success = false;
                } else {
                    if (password_verify($cpwd,$currentpwd)) {
                        if ($npwd == $ncpwd) {
                            $keyval['key'] = password_hash($npwd, PASSWORD_DEFAULT);
                            $msg = 'password';
                            $p = true;
                            $success = true;
                        } else {
                            $errorMsg .= "new password do not match.<br>";
                            $success = false;
                        }
                    } else {
                        $errorMsg .= "current password is wrong <br>";
                        $success = false;
                    }
                }
                echo "update password<br>";
                break;
        }


        if ($success) {
            foreach ($keyval as $key => $val) {
                if ($val != null || $val != " ") {
                    $user->setValue($key, $val);
                }
            }
            
            $_SESSION[SESSION_LOGIN] = $userid == "" ? $_SESSION[SESSION_LOGIN] : $userid;
            $msg .= " have been successfully updated <br>";
            if($p == true){
                $msg.="your updated password will take effect after next login";
            }
            $_SESSION['msg'] = $msg;
            return $user->update();
        } else {
            $_SESSION['msg'] = $errorMsg;
        }
    }
}
