<section>
<h2 class="card border-0 border-bottom pt-3 mb-3 text-left" style="color:#FFC2C3; font-weight:bold;">feed</h2>
<article class="card m-1">
        <?php if (isset($data['tint_info'])) : ?>
            <?php if (isset($data['tint_info']))  : ?>
                <?php for ($x=0;$x<count($data['tint_info']);$x++) : ?>
                    <?php $entry = $data['tint_info'][$x]; ?>
                    <div class="card m5">
                        <div class="card-header postheader">
                            <p class="card-text tint-post" style="font-size:xxx-large;"><?= $data['username'][$x] ?></p>
                            <p class="card-text tint-post" style="font-size:xx-large;"><?= $entry->getField('title')->getValue() ?></p>
                            <div class="card-body">
                                <p class="card-text tint-post">
                                    <?php $content = $entry->getField('content')->getValue(); ?>
                                    <?= $content ?>
                                </p>
                            </div>
                            <div class="row">
                                <p class="col text-right pl-0"><?= $data['likes_count'][$entry->getField('id')->getValue()] ?> likes</p>
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
                                    <form action="/tint/like" method="post">
                                        <input type="hidden" name="postid" value="<?= $entry->getField('id')->getValue() ?>">
                                        <?php
                                        $like_css = "primary";
                                        $like_action = "Like";
                                        if (is_null($data['usr_like'][$entry->getField('id')->getValue()])) {
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
                                                href="/tint/u/<?= $comment['loginid'] ?>"><?= $comment['loginid'] ?></a></span>
                                            </p>
                                            <p class="p-1 commentinfo"><?= $comment['comment'] ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if(isset($_SESSION[SESSION_LOGIN])) :?>
                                    <div class="card-body">                    
                                        <form class="form-group" action="/tints/addComment/<?= $entry->getField('id')->getValue() - 1 ?> " method="post">
                                            <label class="form-group" style="display:none;"><?= $_SESSION[SESSION_LOGIN] ?></label>
                                            <span class="input-group">
                                                <input class="form-control comment-box" aria-label="With textarea" name="comment" required>
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
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
        <?php else : ?>
            <div class="card-body">
                <h5 class="card-title">no posts...</h5>
            </div>
        <?php endif; ?>
    </article>
</section>