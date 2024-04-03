<?php
require_once("../app/controllers/ContactUsController.php");
require_once("../app/routes/blogs.php");

/**
 * main
 * 
 * This class is responsible for handling main requests
 * 
 * @category Router
 * @package  main
 * 
 */
class main extends Router{
    protected $RIGHTS = AUTH_GUEST;
    protected function index(){
        $this->view(['page'=>'main']);
    }

    protected function aboutus(){
        $this->view(['page'=>'aboutus']);
    }

    protected function contactus(){
        $this->view(['page'=>'contactus']);
    }

    protected function blogs(){
        $this->view(['page'=>'blogs']);
    }

    protected function contact_us(){
        (new ContactUsController)->submit_us();
        header("Location: /main/contactus");
    }
}