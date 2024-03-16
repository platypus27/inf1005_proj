<section class="card border-0 m-3" id="login">
    <h1 style="color:#ffc2c3; font-weight:bold;">login</h1>
    <form class="login text-left" name="frmLogin" action="/login/login_process" method="POST">
        <div class="form-group">
            <label for="loginid">user</label>
            <input class="form-control" type="text" required id="loginid" name="loginid">
        </div>
        <div class="form-group">
            <label for="password">password</label>
            <input class="form-control" type="password" id="password" required name="password">
            <br>
            <div class="form-group m-auto">
                <input type="hidden" name="<?=FORM_CSRF_FIELD?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN]; ?>">
                <button class="btn btn-primary float-right" type="submit">Submit</button>
            </div>
        </div>
    </form>
    <?php
        if (isset($_GET['error'])){
            if($_GET['error'] == "invalidcredentials"){
                echo '<p id="loginerror">Invalid username/password combination.</p>';
            } else if($_GET['error'] == "accountlocked"){
                echo '<p id="loginerror">Your account is suspended.</p>';
            }
        }
    ?>
</section>
