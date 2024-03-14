<section class='card border-dark mb-3' id="profile">
    <h1 class="card-header" style="color:#FFC2C3; font-weight:bold;">profile settings</h1>
    <form class="profile card-body" method="post" action="/account/update_profile">
        <div id="exTab3" class="container">	
            <ul  class="nav nav-pills">
                <li class="active"><a  href="#1b" data-toggle="tab">general</a></li>
                <li><a href="#2b" data-toggle="tab">password</a></li>
            </ul>

            <div class="tab-content clearfix">
                <div class="tab-pane active" id="1b">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <?php
                            if (!empty($_SESSION['msg'])) {
                                echo "<div id='myMsg'>" . $_SESSION['msg'] . "</div>";
                                unset($_SESSION['msg']);
                            }
                        ?>
                        <label>User Id:</label>
                        <div class="form-group">
                            <?php
                                $user = $data['loginid'];
                                echo '<input class="form-group" type="text" name="userid" placeholder="Enter Your user id" maxlength="50" value=' . $user . ' aria-label="loginid">';
                            ?>
                        </div>

                        <label>Email:</label>
                        <div class="form-group">
                            <?php
                                $email = $data['email'];
                                echo '<input class="form-group" type="text" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Enter Your new Email" maxlength="100" value=' . $email . ' aria-label="email">';
                            ?>
                        </div>

                        <label>Name:</label>
                        <div class="form-group">
                        <?php
                            $name = $data['name'];
                            echo '<input class="form-group" type="text" name="name" placeholder="Enter Your new Name" maxlength="50"     value=' . $name . ' aria-label="name">';
                        ?>
                        <button class="btn btn-primary float-right" type="submit" name="update" value="bprofile">Update Profile</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="2b">
                    <div class="tab-pane" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <label>Current Password:</label>
                        <div class="form-group">
                            <input class="form-group" type="password" minlength="8" name="cpassword" placeholder="Enter current password" aria-label="cpassword">
                        </div>

                        <label>New Password:</label>
                        <div class="form-group">
                            <input class="form-group" type="password" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" name="npassword" placeholder="Enter new password" aria-label="npassword">
                        </div>

                        <label>Confirm New Password:</label>
                        <div class="form-group">
                            <input class="form-group" type="password" minlength="8" name="ncpassword" placeholder="Enter new confirm password" aria-label="ncpassword">
                            <button class="btn btn-primary float-right" type="submit" name="update" value="bpassword">Change Password</button>
                        </div>

                        
                        <label id="profilenote">Note: if you change your password, your password will be updated on your next sign in</label>
                        <input type="hidden" name="<?= FORM_CSRF_FIELD ?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN] ?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>