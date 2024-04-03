<form class="register col-sm-auto" name="frmRegistration" method="post" action="/register/register_process">
    <h2 class="form-group col-sm-auto" style="color:#ffc2c3; font-weight:bold;">create account</h2>
    <div class="register form-group">
        <?php
        if (!empty($errorMessage) && is_array($errorMessage)) {
        ?>
            <div class="error-message">
                <?php
                foreach ($errorMessage as $message) {
                    echo $message . "<br/>";
                }
                ?>
            </div>
        <?php
        }
        ?>
        <div class="form-group col-sm-auto">
            <label for="loginid">profile name</label>
            <div>
                <input type="text" title="this will be your profile name." class="form-control" required name="loginid" id="loginid">
            </div>
        </div>
        <div class="form-group col-sm-auto">
            <label>name</label>
            <div>
                <input type="text" title="Your full name." class="form-control" required id="name" name="name">
            </div>

        </div>
        <div class="form-group col-sm-auto">
            <label>email</label>
            <div><input type="email" class="form-control" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" id="email" name="email"></div>
        </div>

        <div class="form-group col-sm-auto">
            <label>password</label>
            <div><input type="password" title="password must contain at least 8 characters, including uppercase letters and numbers." class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" id="password" name="password"></div>
        </div>
        <div class="form-group col-sm-auto">
            <label>confirm password</label>
            <div>
                <input type="password" title="password different from above" class="form-control" required id="confirm_password" name="confirm_password">
            </div>
        </div>
        <div class="form-group col-sm-auto">
            <div class="terms">
                <input type="checkbox" required name="terms"> i accept the terms and conditions
            </div>
            <div>
                <input type="hidden" name="<?= FORM_CSRF_FIELD ?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN]; ?>">
                <button type="submit" id="register-user" name="register-user" class="btn btn-primary float-right">register</button>
            </div>
            <?php
            if (isset($_GET['error'])) {
                echo '<p id="sqlerror">error</p>';
            }
            ?>
        </div>
    </div>
</form>