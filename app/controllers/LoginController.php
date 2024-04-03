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
        $values = [
            'loginid' => ['=', $_POST["loginid"]]
        ];
        $rows = get_user("*", $values);
        if ($rows == NULL) {
            return NULL;
        } else if(password_verify($_POST['password'],$rows[0]->getField('password')->getValue())){
            $user = $rows[0];
            $values = [
                'loginid' => $user->getField('loginid')->getValue(),
                'isadmin' => $user->getField('isadmin')->getValue(),
                'suspended' => $user->getField('suspended')->getValue()
            ];
            return $values;
        } else{
            return NULL;
        }
            
    }
}
