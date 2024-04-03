<?php
require_once '../app/controllers/RegisterController.php';
require_once '../app/utils/helpers.php';

/**
 * Register
 * 
 * This class is responsible for handling register requests
 * 
 * @category Router
 * @package  Register
 * 
 */
class register extends Router{
    /**
     * Index
     * 
     * This function is responsible for handling register requests
     * 
     * @return void
     * 
     */
    protected function index(){
        $this->view(['page' => 'register', 'script' => '/static/js/validate.js']);
    }
    /**
     * Process register
     * 
     * This function is responsible for processing register requests
     * 
     * @return void
     * 
     */
    protected function register_process(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->abort(403);
        }
        $register_control = new RegisterController();
        $register = $register_control->createUserAccount();
        if ($register == NULL){
            header("Location: /register?error=sqlerror");
        } else{
            header("Location: /login");
        }
    }
}