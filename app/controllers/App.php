<?php
require_once "../app/model/User.php";
require_once "../app/controllers/Router.php";

/**
 * App class
 * This class is the main controller of the application
 * 
 * @package    Tint
 * @subpackage Tint/controllers
 * @category   Controllers
 * @version    1.0
 * 
 */
class App{
    protected $controller = 'main';

    protected $function = 'index';

    protected $params = [];

    protected $url = '';

    /**
     * Constructor
     * This function is the constructor of the App class
     * 
     * @return void
     * 
     */
    public function __construct(){
        require_once '../app/utils/helpers.php';
        $this->StartSession();
        $this->url = $_SERVER['REQUEST_URI'];
        $this->parseUrl();
        $this->SetPageName();
    
        $isAdminExists = !is_null(get_user('*', ['isadmin'=>['=', 1]]));
        if ($isAdminExists && $this->controller === 'setup') {
            header('location: /', true, 301);
            die();
        } elseif (!$isAdminExists && $this->controller !== 'setup') {
            header("location: /setup");
            die();
        }
    
        $controllerFile = '../app/routes/' . $this->controller . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        } else {
            throw new Exception("controller file does not exist: $controllerFile");
        }
    
        $this->SetFunctionName();
        $this->SetParam();
    
        $controller = new $this->controller();
        $function = $this->function;
        $params = $this->params;
    
        if (method_exists($controller, $function)) {
            $controller->$function($params);
        } else {
            throw new Exception("method $function does not exist in controller " . get_class($controller));
        }
    }

    /**
     * StartSession
     * This function starts the session
     * 
     * @return void
     * 
     */
    public function StartSession(){
        session_start();
    
        $_SESSION[SESSION_RIGHTS] = $_SESSION[SESSION_RIGHTS] ?? AUTH_GUEST;
        if (!isset($_SESSION[SESSION_CSRF_TOKEN])) {
            (new Router())->token_gen();
        }
    
        $router = new Router();
        $isSessionTimeout = !$router->check_session_timeout();
        if ($isSessionTimeout && $_SESSION[SESSION_RIGHTS] > AUTH_GUEST) {
            session_destroy();
            header('Location: /?timeout=1');
            exit();
        }
    }

    /**
     * parseUrl
     * This function parses the URL for cleaner routing
     * 
     * @return void
     * 
     */
    public function parseUrl(){
        $this->url = parse_url($this->url);
        $this->url = explode('/',$this->url['path'], FILTER_SANITIZE_URL);
        unset($this->url[0]);
    }

    /**
     * SetPageName
     * This function sets the page route
     * 
     * @return void
     * 
     */
    public function SetPageName(){
        if($this->url[1]==''){
            $this->controller = 'main';
        }elseif($this->url[1]=='main' && !isset($this->url[2])){
            header("Location: /");
        }elseif(file_exists('../app/routes/' . $this->url[1] . '.php')) {
            $this->controller = $this->url[1];
            unset($this->url[1]);
        }else{
            (new Router)->abort(404);
            die();
        }
    }

    /**
     * SetFunctionName
     * This function sets the function name
     * 
     * @return void
     * 
     */
    public function SetFunctionName(){
        if (!isset($this->url[2])) {
            return;
        }
    
        if (!method_exists($this->controller, $this->url[2])) {
            (new Router)->abort(404);
            exit();
        }
    
        $this->function = $this->url[2];
        unset($this->url[2]);
    }

    /**
     * SetParam
     * This function sets the parameters
     * 
     * @return void
     * 
     */
    public function SetParam(){
        $this->params = $this->url ? array_values($this->url) : [];
    }
}