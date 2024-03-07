<section>
<h2 class="card border-0 border-bottom pt-3 mb-3 text-center">Friends</h2>
    <article class="card m-1">
        <div class="card-header d-sm-flex">
            <h2 class="mr-auto  pt-2 pl-5">Friends List</h2>
        </div>
        <?php 
            echo $data['friends_list'];
            // Check if 'blog_info' key exists in the $data array
            if (isset($data['friends_list']))  : 
                // Loop through each blog post in 'blog_info'
                foreach ($data['friends_list'] as &$entry) : 
                    // Each blog post is wrapped in an 'article' tag
                    foreach ($data['friends_list'] as $friend) {
                        echo $friend . '<br>';
                    }
                // End of the loop
                endforeach; 
            // End of the 'if' statement
            endif; 
        ?>

    </article>
</section>