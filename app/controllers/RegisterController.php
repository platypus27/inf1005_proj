<?php
require_once("../app/model/User.php");
require_once("../app/controllers/TintController.php");


/**
 * RegisterController
 * 
 * This class is responsible for handling registration requests
 * 
 * @category Controller
 * @package  RegisterController
 * 
 */
class RegisterController
{
    /**
     * Create user account
     * 
     * @return bool
     * 
     */
    public function createUserAccount()
    {
        $values = [
            'loginid' => $_POST["loginid"] ?? null,
            'password' => $_POST["password"] ?? null,
            'email' => $_POST["email"] ?? null,
            'name' => $_POST["name"] ?? null,
            'isadmin' => 0
        ];
        $confirm_pass = $_POST["confirm_password"] ?? null;

        if (empty($values['loginid']) || empty($values['password']) || empty($values['email']) || empty($values['name']) || empty($confirm_pass)) {
            return null;
        }

        if (strlen($values['password']) < 8 || strlen($confirm_pass) < 8) {
            return null;
        }

        if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/i", $values['password'])) {
            return null;
        }

        if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        if ($confirm_pass != $values['password']) {
            return null;
        }

        if (($userFound = get_user("*", ['loginid' => ['=', $values['loginid']]])) != null) {
            return null;
        }
        
        if (preg_match("/\s/", $values['loginid'])) {
            return null; // Return null if the username contains a space
        }

        $values['password'] = password_hash($values['password'], PASSWORD_DEFAULT);
        if ($_SERVER['REQUEST_URI'] === '/setup') {
            $values['isadmin'] = 1;
        }

        $user = new User($values);
        return $user->add();
    }
}
