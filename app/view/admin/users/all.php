<section class="card border-0 m-3">
    <h1 style="color:#ffc2c3; font-weight:bold;">users</h1>
<?php include_once "../app/constants.php"; ?>
<?php if (isset($data['users'])) { ?>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>id</th>
                    <th>user</th>
                    <th>email</th>
                    <th>name</th>
                    <th>rights</th>
                    <th>suspended</th>
                    <th>buttons</th>
                </tr>
                <?php
                    foreach ($data['users'] as $user) { 
                        $id = $user->getField('id')->getValue();
                ?>
                    <tr>
                        <td>
                            <a href="/admin/u/<?= $id ?>"><?= $id ?></a>
                        </td>
                        <td>
                            <a href="/blog/u/<?= htmlspecialchars($user->getField('loginid')->getValue()); ?>"><?= htmlspecialchars($user->getField('loginid')->getValue()); ?></a>
                        </td>
                        <td><?= htmlspecialchars($user->getField('email')->getValue()); ?></td>
                        <td><?= htmlspecialchars($user->getField('name')->getValue()); ?></td>
                        <td><?= $user->getField('isadmin')->getValue() == 1 ? 'Yes' : 'No'; ?></td>
                        <td><?= $user->getField('suspended')->getValue() == 1 ? 'Yes' : 'No'; ?></td>
                        <td>
                            <form class="text-center userAction" id="user<?= $id ?>">
                                <input type="hidden" name="<?= FORM_CSRF_FIELD ?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN]; ?>">
                                <input type="hidden" name="uid" value="<?= $id ?>">
                                <?php if ($user->getField('isadmin')->getValue() == 1) { ?>
                                    <input type="submit" name="demote" class="btn btn-danger" value="Remove admin rights"/>
                                <?php } else  { ?>
                                    <input type="submit" name="promote" class="btn btn-success" value="Promote to admin"/>
                                <?php }
                                if ($user->getField('suspended')->getValue() == 1) { ?>
                                    <input type="submit" name="unsuspend" class="btn btn-danger" value="Unsuspend user"/>
                                <?php } else  { ?>
                                    <input type="submit" name="suspend" class="btn btn-danger" value="Suspend user"/>
                                <?php } ?>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
<?php } else { ?>
    <h5>no registered users found</h2>
<?php } ?>
</section>
