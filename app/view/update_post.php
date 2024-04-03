<section class="m-5">
    <h2>Edit Post</h2>
        <form action="/tint/updatepost/<?= ($data['tint_post'])->getField('id')->getValue(); ?>" method="post">
            <fieldset class="row">
                <div class="col">
                    <div class="form-group">
                        <label class="h4">
                            Title: <?= ($data['tint_post'])->getField('title')->getValue(); ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control post-box" name="content" rows="15"
                                placeholder="Edit your Post here..."
                                required><?= ($data['tint_post'])->getField('content')->getValue(); ?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="postid" value="<?= ($data['tint_post'])->getField('id')->getValue(); ?>">
                        <input type="hidden" name="<?=FORM_CSRF_FIELD?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN] ?>">
                        <button class="btn btn-primary" id="submit">Update post</button>
                    </div>
                </div>
            </fieldset>
        </form>
</section>