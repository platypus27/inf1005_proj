<?php
require_once("../app/controllers/AccountController.php");
require_once("../app/model/User.php");

/**
 * Account Router
 * 
 * This class is responsible for handling account requests
 * 
 * @category Router
 * @package  Account
 * 
 */
class account extends Router
{
    protected $RIGHTS = AUTH_LOGIN;
    /**
     * Constructor
     * 
     * @param   array   $url    URL parameters
     * 
     */
    protected function index()
    {
        $this->abort(404);
    }

    /**
     * Route requests
     * 
     * @param   array   $url    URL parameters
     * 
     */
    protected function profile() {
        $accountControl = new AccountController();
        $user = $accountControl->getdetails();

        if ($user === null) {
            $this->abort(400);
            return;
        }

        $this->view([
            'page' => 'profile',
            'loginid' => $user->getField('loginid')->getValue(),
            'name' => $user->getField('name')->getValue(),
            'email' => $user->getField('email')->getValue()
        ]);
    }

    /**
     * Route requests
     * 
     * @param   array   $url    URL parameters
     * 
     */
    protected function update_profile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->abort(405);
            return;
        }

        $account_control = new AccountController();
        if ($account_control->update_user() === false) {
            $_SESSION['msg'] = 'An unexpected error occurred';
        }

        header("Location: /account/profile");
        exit();
    }
}
