<?php
/**
 * SearchController
 * 
 * This class is responsible for handling search requests
 * 
 * @category Controller
 * @package  SearchController
 * 
 */
class SearchController{
    /**
     * Get search results
     * 
     * @return array|null
     * 
     */
    public function getSearchResults() {
        require_once('../app/model/User.php');

        $login_id = $_POST['search'] ?? null;
        $login_id = trim(htmlspecialchars($login_id));

        if (empty($login_id)) {
            return 0;
        }

        $userFound = get_user("*", ['loginid' => ['LIKE', '%' . $login_id . '%']]);

        return $userFound ?? 0;
    }
}
