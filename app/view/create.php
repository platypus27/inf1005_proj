<section class="ml-5 mr-5 mt-3">
<?php if(isset($data['err_msg'])):?>
    <article class="alert alert-danger alert-dismissible fade show alert-box ml-5 w-25" role="alert">
        
        <?php if(($data['err_msg'])[0]) : ?>
            <p class="text-center">Title is empty</p>
            <?php endif;
        if(($data['err_msg'])[1]) :?>
        <p class="text-center">Your Post is empty</p>
        <?php endif;?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </article>

<?php endif;?>
    <h2 style="font-weight:bold;">create post</h2>
        <form action="/blog/create" method="post">
            <fieldset class="row">
                <div class="col">
                    <div class="form-group" id="post-title" >
                        <input type="text" name="title" class="form-control" placeholder="title" required>
                    </div>
                    <div class="form-group" id="post-content" >
                        <textarea class="form-control post-box" name="content" rows="18" placeholder="caption here..." required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="<?=FORM_CSRF_FIELD?>" value="<?=$_SESSION[SESSION_CSRF_TOKEN]?>">
                        <button class="btn btn-primary float-right" id="post-submit">add post</button>
                    </div>
                </div>
            </fieldset>
        </form>
</section>