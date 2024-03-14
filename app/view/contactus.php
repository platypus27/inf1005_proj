<div class="card" id="contactus">
    <form class="contactus card-body" id="contact" method="post" action="/main/contact_us">
        <h1 class="card-header" id="contactheader">contact us</h1>
        <?php
            if (!empty($_SESSION['contactus'])) {
                echo "<div id='myMsg'>" . $_SESSION['contactus'] . "</div>";
                unset($_SESSION['contactus']);
            }
        ?>
        <br>
        <label>name</label>
        <div class="form-group">
            <input class="form-group col-sm" type="text" name="fullname" required aria-label="fullname">
        </div>

        <label>email</label>
        <div class="form-group">
            <input class="form-group col-sm" type="email" name="email" value="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required aria-label="email">
        </div>

        <label>description</label>
        <div class="form-group">
            <textarea class="form-group col-sm" name="description" rows="6" cols="50" required aria-label="description"></textarea>
        </div>
        
        <input type="hidden" name="<?= FORM_CSRF_FIELD ?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN] ?>">
        <button class="btn btn-primary float-right" type="submit" name="update" value="bname">submit</button>
    </form>
</div>