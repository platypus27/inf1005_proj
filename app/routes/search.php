<?php
require_once '../app/controllers/SearchController.php';
require_once '../app/utils/helpers.php';

/**
 * Search
 * 
 * This class is responsible for handling search requests
 * 
 * @category Router
 * @package  Search
 * 
 */
class search extends Router{
    protected $RIGHTS = AUTH_LOGIN;
    /**
     * Index
     * 
     * This function is responsible for handling search requests
     * 
     * @return void
     * 
     */
    protected function index(){
        $search = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchControl = new SearchController();
            $search = $searchControl->getSearchResults();
        }

        $this->view([
            'page' => 'search_results',
            'search' => $search
        ]);
    }
}