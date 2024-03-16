<?php
class BlogsController{
    public function getAllPosts(){
        require_once("../app/model/Post.php");
        $rows = get_post();
        if ($rows!=null) {
            //Sort user by most recent post
            usort($rows, function ($PostEntryA, $PostEntryB) {
                $epochTimeA = $PostEntryA->getField('created_at')->getValue();
                $epochTimeB = $PostEntryB->getField('created_at')->getValue();
                if ($epochTimeA == $epochTimeB) {
                    return 0;
                }
                //Sort By desending order
                return $epochTimeA > $epochTimeB ? -1 : 1;
            });
        }
        return $rows;
    }
}
?>