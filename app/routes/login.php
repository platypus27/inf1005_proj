<?php
require_once '../app/controllers/LoginController.php';
require_once '../app/utils/helpers.php';

/**
 * Login
 * 
 * This class is responsible for handling login requests
 * 
 * @category Router
 * @package  Login
 * 
 */
class login extends Router
{
    /**
     * Index
     * 
     * This function is responsible for handling login requests
     * 
     * @return void
     * 
     */
    protected function index() {
        $this->view(['page' => 'login']);
    }

    /**
     * Process login
     * 
     * This function is responsible for processing login requests
     * 
     * @return void
     * 
     */
    protected function login_process() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->abort(403);
        }
        $login_control = new LoginController();

        $account = $login_control->getUserAccount();
        if ($account == NULL) {
            header("Location: /login?error=invalidcredentials");
        } else if ($account['isadmin'] == 1) {
            $_SESSION[SESSION_RIGHTS] = AUTH_ADMIN;
            $_SESSION[SESSION_LOGIN] = $account['loginid'];
            $_SESSION[SESSION_CSRF_EXPIRE] = time() + 3600;
            header("Location: /admin");
        } else if ($account['suspended'] == 1) {
            header("Location: /login?error=accountlocked");
        } else {
            $_SESSION[SESSION_LOGIN] = $account['loginid'];
            $_SESSION[SESSION_CSRF_EXPIRE] = time() + 3600;
            $_SESSION[SESSION_RIGHTS] = AUTH_LOGIN;
            header("Location: /tints/all");
        }
    }
}
