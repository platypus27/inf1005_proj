<section>
<h2 class="card border-0 border-bottom pt-3 mb-3 text-center">Friends</h2>
    <article class="card m-1">
        <div class="card-header d-sm-flex">
            <h2 class="mr-auto  pt-2 pl-5">Friends List</h2>
        </div>
        <?php 
            if (isset($data['friends_list'])) {
                foreach ($data['friends_list'] as $friendsList) {
                    echo 'Friend A ID: ' . $friendsList->getFriendA()->getValue() . '<br>';
                    echo 'Friend B ID: ' . $friendsList->getFriendB()->getValue() . '<br>';
                    echo '<br>';  // add a blank line between friends
                }
            }
        ?>

    </article>
</section>