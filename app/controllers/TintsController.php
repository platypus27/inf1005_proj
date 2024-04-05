<?php
/**
 * TintsController
 */
class TintsController{
    /**
     * Get all posts
     * @return array
     */
    public function getAllPosts(){
        require_once("../app/model/Post.php");
        $rows = get_post();
        if ($rows!=null) {
            usort($rows, function ($PostEntryA, $PostEntryB) {
                $epochTimeA = $PostEntryA->getField('created_at')->getValue();
                $epochTimeB = $PostEntryB->getField('created_at')->getValue();
                if ($epochTimeA == $epochTimeB) {
                    return 0;
                }
                return $epochTimeA > $epochTimeB ? -1 : 1;
            });
        }
        return $rows;
    }
}
?>