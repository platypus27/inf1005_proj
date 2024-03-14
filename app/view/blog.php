<section>
<?php if (isset($_SESSION['post_success'])): ?>
    <article class="alert alert-success alert-dismissible fade show mt-2 mb-0 alert-box post-alert" role="alert">
        <h5 class="text-center">Your Post has been added!!</h5>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </article>
    <?php unset($_SESSION['post_success']);
endif; ?>
<?php if (isset($_SESSION['update_success'])): ?>
    <article class="alert alert-success alert-dismissible fade show mt-2 mb-0 alert-box post-alert" role="alert">
        <h5 class="text-center">Your Post has been updated!!</h5>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </article>
    <?php unset($_SESSION['update_success']);
endif; ?>
<?php if (isset($_SESSION['postdeleted'])):?>
    <article class="alert alert-success alert-dismissible fade show mt-2 mb-0 alert-box post-alert" role="alert">
        <h5 class="text-center">Your Post has been successfully deleted!!</h5>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </article>
<?php unset($_SESSION['postdeleted']);
endif;?>
<h2 class="card border-0 border-bottom pt-3 mb-3 text-left" style="color:#FFC2C3; font-weight:bold;"><?= strtolower($data['blog_name']) ?></h2>
    <?php 
        if ($data['blog_name'] != $_SESSION[SESSION_LOGIN]) {
            if ($data['requests'] == null) {
                echo "<form action='/blog/sendReq/".$data['blog_name']."' method='post'>";
                echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                echo "<button class='btn btn-primary' id='post-submit'>Send Friend Request</button>";
                echo "</form>";
            }
            elseif ($data['requests'] == 'Friends') {
                echo "<form action='/blog/delFriend/".$data['blog_name']."' method='post'>";
                echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                echo "<button class='btn btn-danger' id='post-submit'>".$data['requests']."</button>";
                echo "</form>";
            }
            elseif ($data['requests'] == 'Requested'){
                echo "<form action='/blog/deleteReq/".$data['blog_name']."' method='post'>";
                echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                echo "<button class='btn btn-danger' id='post-submit'>".$data['requests']."</button>";
                echo "</form>";
            }
            elseif ($data['requests'] == 'Accept Request'){
                echo "<form action='/blog/acceptReq/".$data['blog_name']."' method='post'>";
                echo "<input type='hidden' name='".FORM_CSRF_FIELD."' value='".$_SESSION[SESSION_CSRF_TOKEN]."'>";
                echo "<button class='btn btn-danger' id='post-submit'>".$data['requests']."</button>";
                echo "</form>";
            }
        }
    ?>
    <article class="card m-1">
        <?php if (isset($data['blog_info'])) : ?>
            <?php if (isset($data['blog_info']))  : ?>
                <?php foreach ($data['blog_info'] as &$entry) : ?>
                    <article class="card m-5">
                            <header class="card-header">
                                <?php
                                $epoch = (int)($entry->getField('created_at')->getValue());
                                $PostTimeStamp = new DateTime("@$epoch");
                                ?>
                                <?= $PostTimeStamp->format('D, j M Y g:i:s A'); ?>
                            </header>
                            <div class="card-body">
                                <h5 class="card-title"><?= $entry->getField('title')->getValue() ?></h5>
                                <p class="card-text post-preview">
                                    <?php
                                    $preview_content = $entry->getField('content')->getValue();
                                    if (strlen($preview_content) > 100) {
                                        $preview_content = substr($preview_content, 0, 100) . '...';
                                    }
                                    ?>
                                    <?= $preview_content ?>
                                </p>
                                <a href="<?=parse_url($_SERVER['REQUEST_URI'])['path']. "/" . $entry->getField('id')->getValue() ?>"
                                    class="btn btn-primary float-right">Read More</a>
                            </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php else : ?>
            <div class="card-body">
                <h5 class="card-title">no posts...</h5>
            </div>
        <?php endif; ?>
    </article>
</section>