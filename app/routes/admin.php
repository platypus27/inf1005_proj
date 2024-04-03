<?php

require_once('../app/model/User.php');
require_once('../app/model/ContactUs.php');

/**
 * Route for /admin endpoints
 */
class admin extends Router{
    protected $RIGHTS = AUTH_ADMIN;

    /**
     * Redirects to /admin/u if no subpath is specified
     */
    protected function index(){
        header("Location: /admin/u");
    }

    /**
     * Endpoint to retrieve all or specific user information.
     * Endpoint only allows GET
     */
    protected function u($args) {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET'){
            $this->abort(405);
        }

        if (count($args))
        {   
            $user = get_user(['id', 'loginid', 'email', 'name', 'isadmin', 'suspended'], ['id'=>['=', $args[0]]]);
            if ($user == null) {
                $this->abort(404);
            }
            if (count($user) > 1) {
                $user = $user[0];
            }
            self::view(['page'=>'admin/users/specific', 'user'=>$user, 'script'=>'../public/static/js/admin/action.js']);
        } else {
            $users = get_user(['id', 'loginid', 'email', 'name', 'isadmin', 'suspended']);
            self::view(['page'=>'admin/users/all', 'users'=>$users, 'script'=>'../public/static/js/admin/action.js']);
        }
    }

    /**
     * Endpoint to promote, demote, suspend or unsuspend user account
     * Endpoint only allows POST
     */
    protected function action($args) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->abort(405);
            return;
        }

        $uid = $_POST['uid'] ?? null;
        $button = $_POST['button'] ?? null;

        if (is_null($uid) || is_null($button)) {
            $this->abort(400);
            return;
        }

        $user = get_user('*', ['id' => ['=', $uid]])[0] ?? null;

        if (is_null($user)) {
            $this->abort(404);
            return;
        }

        $actions = [
            'promote' => ['isadmin', 1],
            'demote' => ['isadmin', 0],
            'suspend' => ['suspended', 1],
            'unsuspend' => ['suspended', 0]
        ];

        if (!array_key_exists($button, $actions)) {
            $this->abort(400);
            return;
        }

        [$field, $value] = $actions[$button];
        $user->getField($field)->setValue($value);

        $result = $user->update();
        http_response_code($result === true ? 204 : 500);
    }

    /**
     * Endpoint to retrieve all or specific contact request information.
     * Endpoint only allows GET
     */
    protected function contact($args) {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->abort(405);
            return;
        }
    
        if (count($args)) {
            $contact = get_contactus('*', ['id' => ['=', $args[0]]]);
    
            if ($contact === null) {
                $this->abort(404);
                return;
            }
    
            $page = 'admin/contact/specific';
            $script = '../public/static/js/admin/action.js';
        } else {
            $contact = get_contactus('*');
            $page = 'admin/contact/all';
            $script = null;
        }
    
        self::view([
            'page' => $page,
            'contact' => $contact,
            'script' => $script
        ]);
    }

    /**
     * Endpoint to delete contact requests
     * Endpoint only allows POST
     */
    protected function delete($args) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->abort(405);
        }
        $contact = get_contactus('*', ['id'=>['=', $_POST["id"]]])[0];
        if ($contact === NULL) {
            $this->abort(404);
        }
        if  ($contact->delete() === true) {
            header("Location: /admin/contact");
        } else {
            $this->abort(400);
        }
    }
}