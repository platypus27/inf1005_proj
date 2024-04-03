<?php
require_once '../app/constants.php';

/**
 * Router
 * 
 * This class is responsible for handling routing requests
 * 
 * @category Controller
 * @package  Router
 * 
 */
class Router{
    protected $RIGHTS = AUTH_GUEST;
    protected $METHODS = ['GET', 'POST'];

    /**
     * View
     * 
     * @param array $data
     * 
     * @return void
     * 
     */
    public function view($data = [])
    {
        require_once '../app/view/base.php';
    }

    /**
     * Token Generation
     * 
     * @return void
     * 
     */
    public function token_gen()
    {
        require_once '../app/utils/helpers.php';        
        if(isset($_SESSION[SESSION_CSRF_TOKEN]) ? $_SESSION[SESSION_CSRF_TOKEN]==null : true){
            $length = 32;
            $_SESSION[SESSION_CSRF_TOKEN] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
            $_SESSION[SESSION_CSRF_EXPIRE] = time()+3600;
        }
    }

    /**
     * Token Compare
     * 
     * @return bool
     * 
     */
    protected function token_compare(){
        require_once '../app/utils/helpers.php';
        if($_SESSION[SESSION_CSRF_TOKEN]==$_POST[FORM_CSRF_FIELD]){
            return $this->check_session_timeout();
        }
        return false;
    }

    /**
     * Check Session Timeout
     * 
     * @return bool
     * 
     */
    public function check_session_timeout(){
        if(time()>=$_SESSION[SESSION_CSRF_EXPIRE]){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Abort
     * 
     * @param int $status
     * 
     * @return void
     * 
     */
    protected function abort($status)
    {
        http_response_code($status);
        $this->view(['page' => 'error/' . $status]);
        die();
    }

    /**
     * Call
     * 
     * @param string $method
     * @param array $arguments
     * 
     * @return void
     * 
     */
    public function __call($method, $arguments)
    {
        if ($this->RIGHTS > $_SESSION[SESSION_RIGHTS]) {
            $this->abort(403);
        }

        if (!in_array($_SERVER['REQUEST_METHOD'], $this->METHODS, true)) {
            $this->abort(405);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$this->token_compare()) {
            $this->abort(400);
        }
        
        return call_user_func_array(array($this,$method),$arguments);
    }
}