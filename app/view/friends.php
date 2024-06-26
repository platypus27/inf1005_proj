<section>
    <article class="card m-1 friends">
        <div class="card-header" id="friendsList">
            <h2 class="mr-auto pt-2 pl-5">friends list</h2>
            <div class="friends d-flex flex-column">
                <?php 
                    if (isset($data['friends_list'])) {
                        foreach ($data['friends_list'] as $friend) {
                            echo "<a class='friendbox' href=/tint/u/".$friend.">";
                            echo $friend ;
                            echo "</a>";
                        }
                    }
                ?>
            </div>
        </div>
        <div class='card-header'>
            <h2 class='mr-auto pt-2 pl-5' id="friendsReq">friend requests</h2>
            <div class="friends d-flex flex-column">
                <?php
                    if (isset($data['friend_requests'])) {
                        foreach ($data['friend_requests'] as $friend) {
                            echo "<form class='friendbox' action='/friends/addfriend/".$friend."' method='post'>";
                            echo "<a class='friendbox' href='/tint/u/".$friend."'>";
                            echo $friend;
                            echo "</a>";
                            echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                            echo "<button class='btn btn-primary float-right post-submit'>Accept Friend Request</button>";
                            echo "</form>";
                        }
                    }
                ?>
            </div>
        </div>
        <div class='card-header'>
            <h2 class='mr-auto pt-2 pl-5' id="sentReq">sent requests</h2>
            <div class="friends d-flex flex-column">
                <?php
                if (isset($data['sent_requests'])) {
                    foreach ($data['sent_requests'] as $friend) {
                        echo "<form class='friendbox' action='/friends/rejectfriend/".$friend."' method='post'>";
                        echo "<a class='friendbox' href=/tint/u/".$friend.">";
                        echo $friend;
                        echo "</a>";
                        echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                        echo "<button class='btn btn-primary float-right post-submit'>Reject Friend Request</button>";
                        echo "</form>";
                    }
                }
                ?>
            </div>
        </div>
    </article>
</section>