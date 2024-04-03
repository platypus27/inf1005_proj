<?php
require_once '../app/controllers/RegisterController.php';
require_once '../app/utils/helpers.php';

/**
 * Setup
 * 
 * This class is responsible for handling setup requests
 * 
 * @category Router
 * @package  Setup
 * 
 */
class Setup extends Router{
    /**
     * Index
     * 
     * This function is responsible for handling setup requests
     * 
     * @return void
     * 
     */
    protected function index($args){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            self::view(["page"=>"admin/setup"]);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $register_control = new RegisterController();
            $register_admin = $register_control->createUserAccount();
            if ($register_admin === NULL){
                $this->abort(500);
            } else{
                header("Location: /");
            }
        }
    }
}
?>