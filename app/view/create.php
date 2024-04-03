<section class="m-5">
    <h2>create post</h2>
        <form action="/tint/create" method="post">
            <fieldset class="row">
                <div class="col">
                    <div class="form-group" id="post-title" >
                        <input type="text" name="title" class="form-control" placeholder="title" required>
                    </div>
                    <div class="form-group" id="post-content" >
                        <textarea class="form-control post-box" name="content" rows="15" placeholder="caption here..." required></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary float-right comment post-submit">add post</button>
                        <input type="hidden" name="<?=FORM_CSRF_FIELD?>" value="<?=$_SESSION[SESSION_CSRF_TOKEN]?>">
                    </div>
                </div>
            </fieldset>
        </form>
</section>