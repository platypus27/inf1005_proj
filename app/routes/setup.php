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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $registerControl = new RegisterController();
            $registerAdmin = $registerControl->createUserAccount();
    
            if ($registerAdmin === null) {
                $this->abort(500);
                return;
            }
    
            header("Location: /");
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            self::view(["page" => "admin/setup"]);
        }
    }
}
?>