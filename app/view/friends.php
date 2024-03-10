<section>
<h2 class="card border-0 border-bottom pt-3 mb-3 text-center">Friends</h2>
    <article class="card m-1">
        <div class="card-header d-sm-flex">
            <h2 class="mr-auto  pt-2 pl-5">Friends List</h2>
        </div>
        <?php 
            
            if (isset($data['friends_list'])) {
                foreach ($data['friends_list'] as $friend) {
                    echo "<a href=/blog/u/".$friend.">";
                    echo $friend ;
                    echo "</a>";
                }
            }
        ?>
        <div class='card-header d-sm-flex'>
            <h2 class='mr-auto  pt-2 pl-5'>Friend Requests</h2>
            <?php
                if (isset($data['friend_requests'])) {
                    foreach ($data['friend_requests'] as $friend) {
                        echo "<form action='/friends/addfriend/".$friend."' method='post'>";
                        echo "<a href='/blog/u/".$friend."'>";
                        echo $friend;
                        echo "</a>";
                        echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                        echo "<button class='btn btn-primary' id='post-submit'>Accept Friend Request</button>";
                        echo "</form>";
                    }
                }
            ?>
        </div>
        <div class='card-header d-sm-flex'>
            <h2 class='mr-auto  pt-2 pl-5'>Sent Requests</h2>
            <?php
            if (isset($data['sent_requests'])) {
                foreach ($data['sent_requests'] as $friend) {
                    echo "<form action='/friends/rejectfriend/".$friend."' method='post'>";
                    echo "<a href=/blog/u/".$friend.">";
                    echo $friend;
                    echo "</a>";
                    echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                    echo "<button class='btn btn-primary' id='post-submit'>Reject Friend Request</button>";
                    echo "</form>";
                }
            }
            ?>
        </div>
    </article>
</section>