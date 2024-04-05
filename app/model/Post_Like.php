<?php
require_once("../app/model/utils/Field.php");
require_once("../app/model/utils/Model.php");
require_once("../app/utils/helpers.php");

/**
 * Post_Like
 * 
 * This class is responsible for handling post like operations
 * 
 * @category Model
 * @package  Post_Like
 * 
 */
class Post_Like extends Model{
    const tablename = "post_likes";
    const fields = ["id", "usr_id", "posts_id", "liked_at"];
    protected $id = null;
    protected $usr_id = null;
    protected $posts_id = null;
    protected $liked_at = null;

    /**
     * Constructor
     * 
     * @param   array   $values     Values to be assigned to fields
     * 
     */
    function __construct($values)
    {
        // Initialise fields
        $this->id = new Field("id", PDO::PARAM_INT);
        $this->usr_id = new Field("usr_id", PDO::PARAM_INT);
        $this->posts_id = new Field("posts_id", PDO::PARAM_INT);
        $this->liked_at = new Field("liked_at", PDO::PARAM_INT);

        // Assign values
        $this->id->setValue(get($values["id"]));
        $this->usr_id->setValue(get($values["usr_id"]));
        $this->posts_id->setValue(get($values["posts_id"]));
        $this->liked_at->setValue(get($values["liked_at"]));
    }

    public function getPostsId() {
        return $this->posts_id->getValue();
    }
}

/**
 * Get post likes
 * 
 * @param   string  $fields     Fields to be selected
 * @param   array   $filter_by  Filter to be applied
 * @return  array|null
 * 
 */
function get_post_likes($fields='*', $filter_by=[]){
    return get_row('Post_Like', $fields, $filter_by);
}
?>