<?php

require_once("../app/model/User.php");
require_once("../app/constants.php");

/**
 * Controller for User Accounts
 * This file states all the functions that are required to manage user accounts
 * 
 * @package    Tint
 * @subpackage Tint/controllers
 * @category   Controllers
 * @version    1.0
 * 
 */
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
        $keyval = [];
    
        if ($userid != $_SESSION[SESSION_LOGIN] && get_user('*', ['loginid' => ["=", $userid]]) !== NULL) {
            $_SESSION['msg'] = "a user with the given user id already exists";
            return;
        }
    
        switch ($_POST["update"]) {
            case 'bprofile':
                $fields = ['loginid' => $userid, 'email' => $email, 'name' => $name];
                foreach ($fields as $field => $value) {
                    if (empty($value)) {
                        $errorMsg .= "$field is required <br>";
                        $success = false;
                    } else {
                        if ($field === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $errorMsg .= "invalid email format.<br>";
                            $success = false;
                        } else {
                            $keyval[$field] = $value;
                        }
                    }
                }
                break;
    
            case 'bpassword':
                if (empty($cpwd) || empty($npwd) || empty($ncpwd)) {
                    $errorMsg .= "password is required.";
                    $success = false;
                } else if (!password_verify($cpwd, $currentpwd)) {
                    $errorMsg .= "current password is wrong <br>";
                    $success = false;
                } else if ($npwd != $ncpwd) {
                    $errorMsg .= "new password do not match.<br>";
                    $success = false;
                } else {
                    $keyval['key'] = password_hash($npwd, PASSWORD_DEFAULT);
                    $p = true;
                }
                break;
        }
    
        if ($success) {
            foreach ($keyval as $key => $val) {
                if (!empty($val)) {
                    $user->setValue($key, $val);
                }
            }
            $_SESSION[SESSION_LOGIN] = empty($userid) ? $_SESSION[SESSION_LOGIN] : $userid;
            $msg = "Profile have been successfully updated <br>";
            if($p){
                $msg .= "your updated password will take effect after next login";
            }
            $_SESSION['msg'] = $msg;
            return $user->update();
        } else {
            $_SESSION['msg'] = $errorMsg;
        }
    }
}
