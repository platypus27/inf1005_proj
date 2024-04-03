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
            return;
        }
    
        $loginControl = new LoginController();
        $account = $loginControl->getUserAccount();
    
        if ($account === null) {
            header("Location: /login?error=invalid");
            exit();
        }
    
        if ($account['isadmin'] == 1) {
            $_SESSION[SESSION_RIGHTS] = AUTH_ADMIN;
            $_SESSION[SESSION_LOGIN] = $account['loginid'];
            $_SESSION[SESSION_CSRF_EXPIRE] = time() + 3600;
            header("Location: /admin");
            exit();
        }
    
        if ($account['suspended'] == 1) {
            header("Location: /login?error=suspended");
            exit();
        }
    
        $_SESSION[SESSION_LOGIN] = $account['loginid'];
        $_SESSION[SESSION_CSRF_EXPIRE] = time() + 3600;
        $_SESSION[SESSION_RIGHTS] = AUTH_LOGIN;
        header("Location: /tints/all");
        exit();
    }
}
