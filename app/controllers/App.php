<?php
/**
 * App class
 * This class is the main controller of the application
 * 
 * @package    Blog
 * @subpackage Blog/controllers
 * @category   Controllers
 * @version    1.0
 * 
 */

require_once "../app/model/User.php";
require_once "../app/controllers/Router.php";

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
        get($this->url[1]);
        get($this->url[2]);
        $this->SetPageName();
        if (!is_null(get_user('*', ['isadmin'=>['=', 1]]))) {
            if ($this->controller === 'setup') {
                header('Location: /', true, 301);
                die();
            }
        } else if ($this->controller !== 'setup'){
            header("Location: /setup");
        }
        require_once '../app/routes/' . $this->controller . '.php';
        $this->SetFunctionName();
        $this->SetParam();
        $function = $this->function;
        $params = $this->params;
        (new $this->controller())->$function($params);
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
        if(!isset($_SESSION[SESSION_RIGHTS])){
            $_SESSION[SESSION_RIGHTS] = AUTH_GUEST;
        }
        if(!isset($_SESSION[SESSION_CSRF_TOKEN])){
            (new Router())->token_gen();
        }
        if(!(new Router())->check_session_timeout() && $_SESSION[SESSION_RIGHTS] > 0){
            session_destroy();
            header('Location: /?timeout=1');
            die();
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
        if(isset($this->url[2])){
            if(method_exists($this->controller, $this->url[2])){
                $this->function = $this->url[2];
                unset($this->url[2]);
            }else{
                (new Router)->abort(404);
                die();
            }
        }
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