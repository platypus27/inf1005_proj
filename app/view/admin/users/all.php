<section class="card border-0 m-3">
    <h1 style="color:#ffc2c3; font-weight:bold;">users</h1>
<?php include_once "../app/constants.php"; ?>
<?php if (isset($data['users'])) { ?>
        <div class="d-flex flex-column">
            <?php
                foreach ($data['users'] as $user) { 
                    $id = $user->getField('id')->getValue();
            ?>
            <div class='p-4 m-2 bg-light'>
                <p class="commentloginid">
                    <a href="/admin/u/<?= $id ?>"><?= $id ?></a>
                </p>
                <p class="commentloginid">
                    <a href="/blog/u/<?= htmlspecialchars($user->getField('loginid')->getValue()); ?>"><?= htmlspecialchars($user->getField('loginid')->getValue()); ?></a>
                </p>
                <p class="commentloginid">email: <?= htmlspecialchars($user->getField('email')->getValue()); ?></p>
                <p class="commentloginid">name: <?= htmlspecialchars($user->getField('name')->getValue()); ?></p>
                <p class="commentloginid">admin: <?= $user->getField('isadmin')->getValue() == 1 ? 'Yes' : 'No'; ?></p>
                <p class="commentloginid">suspended: <?= $user->getField('suspended')->getValue() == 1 ? 'Yes' : 'No'; ?></p>
                <p>
                    <form class="userAction" id="user<?= $id ?>">
                        <input type="hidden" name="<?= FORM_CSRF_FIELD ?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN]; ?>">
                        <input type="hidden" name="uid" value="<?= $id ?>">
                        <?php if ($user->getField('isadmin')->getValue() == 1) { ?>
                            <input type="submit" name="demote" class="btn btn-primary admin" value="remove admin"/>
                        <?php } else  { ?>
                            <input type="submit" name="promote" class="btn btn-primary admin" value="promote to admin"/>
                        <?php }
                        if ($user->getField('suspended')->getValue() == 1) { ?>
                            <input type="submit" name="unsuspend" class="btn btn-primary admin" value="unsuspend user"/>
                        <?php } else  { ?>
                            <input type="submit" name="suspend" class="btn btn-primary admin" value="suspend user"/>
                        <?php } ?>
                    </form>
                </p>
            </div>  
            <?php } ?>
        </div>
<?php } else { ?>
    <h5>no registered users found</h2>
<?php } ?>
</section>
