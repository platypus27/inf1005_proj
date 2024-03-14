<section>
<h2 class="card border-0 border-bottom pt-3 mb-3 text-left" style="color:#FFC2C3; font-weight:bold;">feed</h2>
    <article class="card m-1">
        <?php if (isset($data['blog_info'])) : ?>
            <?php 
                // Check if 'blog_info' key exists in the $data array
                if (isset($data['blog_info']))  : 
                    // Loop through each blog post in 'blog_info'
                    foreach ($data['blog_info'] as &$entry) : 
                        // Each blog post is wrapped in an 'article' tag
                        echo '<article class="card m-5">';
                            echo '<header class="card-header">';
                                // Convert the 'created_at' timestamp to a DateTime object
                                $epoch = (int)($entry->getField('created_at')->getValue());
                                $PostTimeStamp = new DateTime("@$epoch");
                                // Display the formatted date and time of the blog post
                                echo $PostTimeStamp->format('D, j M Y g:i:s A'); 
                            echo '</header>';
                            echo '<div class="card-body">';
                                // Display the title of the blog post
                                echo '<h5 class="card-title">' . $entry->getField('title')->getValue() . '</h5>';
                                echo '<p class="card-text post-preview">';
                                    // Get the content of the blog post
                                    $preview_content = $entry->getField('content')->getValue();
                                    // If the content is more than 100 characters, truncate it and add '...'
                                    if (strlen($preview_content) > 100) {
                                        $preview_content = substr($preview_content, 0, 100) . '...';
                                    }
                                    // Display the truncated content
                                    echo $preview_content;
                                echo '</p>';
                                // Display a 'Read More' button that links to the full blog post
                                echo '<a href="' . parse_url($_SERVER['REQUEST_URI'])['path']. "/" . $entry->getField('id')->getValue() . '" class="btn btn-primary float-right">Read More</a>';
                            echo '</div>';
                        echo '</article>';
                    // End of the loop
                    endforeach; 
                // End of the 'if' statement
                endif; 
            ?>
        <?php else : ?>
            <!-- no posts -->
            <h2 class="card-header">Hmmm...</h2>
            <div class="card-body">
                <h5 class="card-title">No Post Yet!</h5>
                <p class="card-text">Blog under construction</p>
            </div>
                    
        <?php endif; ?>
    </article>
</section>