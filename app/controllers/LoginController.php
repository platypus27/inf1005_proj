<?php

/**
 * LoginController
 * 
 * This class is responsible for handling login requests
 * 
 * @category Controller
 * @package  LoginController
 * 
 */
class LoginController
{
    /**
     * Get user account
     * 
     * @return array|null
     * 
     */
    public function getUserAccount()
    {
        require_once("../app/model/User.php");

        $loginId = $_POST["loginid"] ?? null;
        $password = $_POST["password"] ?? null;

        if (is_null($loginId) || is_null($password)) {
            throw new InvalidArgumentException("Login ID and password are required");
        }

        $values = ['loginid' => ['=', $loginId]];
        $rows = get_user("*", $values);

        if (is_null($rows)) {
            return null;
        }

        $user = $rows[0];
        if (!password_verify($password, $user->getField('password')->getValue())) {
            return null;
        }

        return [
            'loginid' => $user->getField('loginid')->getValue(),
            'isadmin' => $user->getField('isadmin')->getValue(),
            'suspended' => $user->getField('suspended')->getValue()
        ];
    }
}
