<section>
<?php if (isset($_SESSION['post_success'])): ?>
    <article class="alert alert-light alert-dismissible fade show mt-2 mb-0 alert-box post-alert" role="alert">
        <h5 class="text-center">your post has been added!!</h5>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </article>
    <?php unset($_SESSION['post_success']);
endif; ?>
<?php if (isset($_SESSION['update_success'])): ?>
    <article class="alert alert-light alert-dismissible fade show mt-2 mb-0 alert-box post-alert" role="alert">
        <h5 class="text-center">your post has been updated</h5>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </article>
    <?php unset($_SESSION['update_success']);
endif; ?>
<?php if (isset($_SESSION['postdeleted'])):?>
    <article class="alert alert-light alert-dismissible fade show mt-2 mb-0 alert-box post-alert" role="alert">
        <h5 class="text-center">your post has been successfully deleted</h5>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </article>
<?php unset($_SESSION['postdeleted']);
endif;?>
<h2 class="card border-0 border-bottom pt-3 mb-3 text-left" style="color:#FFC2C3; font-weight:bold;"><?= strtolower($data['blog_name']) ?></h2>
    <?php 
        if ($_SESSION[SESSION_RIGHTS] == AUTH_ADMIN || $_SESSION[SESSION_RIGHTS] == AUTH_LOGIN) {
            if ($data['blog_name'] != $_SESSION[SESSION_LOGIN]) {
                if ($data['requests'] == null) {
                    echo "<form action='/blog/sendReq/".$data['blog_name']."' method='post'>";
                    echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                    echo "<button class='btn btn-primary post-submit'>Send Friend Request</button>";
                    echo "</form>";
                }
                elseif ($data['requests'] == 'Friends') {
                    echo "<form action='/blog/delFriend/".$data['blog_name']."' method='post'>";
                    echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                    echo "<button class='btn btn-danger post-submit'>".$data['requests']."</button>";
                    echo "</form>";
                }
                elseif ($data['requests'] == 'Requested'){
                    echo "<form action='/blog/deleteReq/".$data['blog_name']."' method='post'>";
                    echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                    echo "<button class='btn btn-danger post-submit'>".$data['requests']."</button>";
                    echo "</form>";
                }
                elseif ($data['requests'] == 'Accept Request'){
                    echo "<form action='/blog/acceptReq/".$data['blog_name']."' method='post'>";
                    echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                    echo "<button class='btn btn-danger post-submit'>".$data['requests']."</button>";
                    echo "</form>";
                }
            }
        }
    ?>
    <article class="card m-1">
        <?php if (isset($data['blog_info'])) : ?>
            <?php if (isset($data['blog_info']))  : ?>
                <?php for ($x=0;$x<count($data['blog_info']);$x++) : ?>
                    <?php $entry = $data['blog_info'][$x]; ?>
                    <article class="card m-5">
                        <div class="card-header postheader">
                            <p class="card-text blog-post" style="font-size:xx-large;"><?= $entry->getField('title')->getValue() ?></p>
                            <div class="card-body">
                                <p class="card-text blog-post">
                                    <?php $content = $entry->getField('content')->getValue(); ?>
                                    <?= $content ?>
                                </p>
                            </div>
                            <h6 class="row">
                                    <?php
                                    $epochCreated = (int)($entry->getField('created_at')->getValue());
                                    $epochUpdated = (int)($entry->getField('updated_at')->getValue());

                                    $dtCreated = new DateTime("@$epochCreated");
                                    $dtUpdated = new DateTime("@$epochUpdated");
                                    echo "<span class='col-md text-left'>" . $dtCreated->format('D, j M Y g:i:s A') . "</span>";
                                    if ($epochUpdated > $epochCreated) {
                                        echo "<span class='col-md text-right'>Last Edited: " . $dtUpdated->format('D, j M Y g:i:s A') . "</span>";
                                    } ?>
                            </h6>
                            <div class="d-sm-flex">
                                <?php if(isset($_SESSION[SESSION_LOGIN])):?>
                                <div class="p-1">
                                    <form action="/blog/like" method="post">
                                        <input type="hidden" name="postid" value="<?= $entry->getField('id')->getValue() ?>">
                                        <?php
                                        $like_css = "primary";
                                        $like_action = "Like";
                                        if (is_null($data['usr_like'][$x])) {
                                            $like_css = "primary";
                                            $like_action = "Like";
                                        } else {
                                            $like_css = "danger";
                                            $like_action = "Unlike";
                                        } ?>
                                            <input type="hidden" name="<?=FORM_CSRF_FIELD?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN] ?>">
                                            <input class="btn btn-<?= $like_css ?>" type="submit" name="submit" value="<?= $like_action ?>">
                                    </form>
                                </div>
                                    <?php endif;?>
                                <div class="p-1">
                                    <?php //Get Full url
                                    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
                                    <button class="btn btn-primary share-btn"
                                            data-clipboard-text="<?= $link ?>">Share</button>
                                </div>

                                <?php if (isset($_SESSION[SESSION_LOGIN])):
                                    if ($data['blog_name'] == $_SESSION[SESSION_LOGIN])  : ?>
                                        <div class="p-1">
                                        <a class="btn btn-primary d-sm-flex"
                                            href="/blog/updatepost/<?= $entry->getField("id")->getValue() ?>">Update Post</a>
                                        </div>
                                        <div class="p-1">
                                        <form action="/blog/deletepost" method="post">
                                        <input type="hidden" name="postid" value="<?= $entry->getField("id")->getValue() ?>">
                                        <input type="hidden" name="<?=FORM_CSRF_FIELD?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN] ?>">
                                        <button class="btn btn-danger d-flex">Delete Post</button>
                                        </form>
                                        </div>
                                <?php endif;
                                endif; ?>
                                <div class="p-1 ml-auto">
                                    <button class="btn btn-primary" type="button" data-target="#comments<?= $x ?>" data-toggle="collapse" style="width:10rem;" aria-expanded="false"><?= sizeof($data['comments'][$x]) ?> comments</button>
                                </div>
                            </div>
                            <div class="collapse commentslist" id="comments<?= $x ?>">
                                <?php if (!empty($data['comments'][$x])) : ?>
                                    <?php $comment = $data['comments'][$x][0]; ?>
                                    <?php
                                    $epoch = (int)($comment['created_at']);
                                    $commentTimeStamp = new DateTime("@$epoch");
                                    ?>
                                    <?php foreach ($data['comments'][$x] as $comment) : ?>
                                        <div class="d-sm-flex flex-column commentbox">
                                            <p class="p-1 commentloginid"><span><a class="nav-link"
                                                href="/blog/u/<?= $comment['loginid'] ?>"><?= $comment['loginid'] ?></a></span>
                                            </p>
                                            <p class="p-1 commentinfo"><?= $comment['comment'] ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if(isset($_SESSION[SESSION_LOGIN])) :?>
                                    <div class="card-body">                    
                                        <form class="form-group" action="/blog/addComment/<?= $x ?> " method="post">
                                            <label class="form-group" style="display:none;"><?= $_SESSION[SESSION_LOGIN] ?></label>
                                            <span class="input-group">
                                                <input class="form-control comment-box" rows="5" aria-label="With textarea" name="comment" required></input>
                                            </span>
                                            <span class="input-group float-right">
                                                <input type="hidden" name="<?=FORM_CSRF_FIELD?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN] ?>">
                                                <input class="btn btn-primary comment" type="submit" name="submit">
                                            </span>
                                        </form>
                                        <span class="border-top"></span>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </article>
                <?php endfor; ?>
            <?php endif; ?>
        <?php else : ?>
            <div class="card-body">
                <h5 class="card-title">no posts...</h5>
            </div>
        <?php endif; ?>
    </article>
    
</section>