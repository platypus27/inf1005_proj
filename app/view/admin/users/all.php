<section class="card border-0 m-3">
    <h1 style="color:#ffc2c3;">users</h1>
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
                </tr>
                <?php
                    foreach ($data['users'] as $user) { 
                        $id = $user->getField('id')->getValue();
                ?>
                    <tr>
                        <td>
                            <a href="/admin/u/<?= $id ?>"><?= $id ?></a>
                        </td>
                        <td><?= htmlspecialchars($user->getField('loginid')->getValue()); ?></td>
                        <td><?= htmlspecialchars($user->getField('email')->getValue()); ?></td>
                        <td><?= htmlspecialchars($user->getField('name')->getValue()); ?></td>
                        <td><?= $user->getField('isadmin')->getValue() == 1 ? 'Yes' : 'No'; ?></td>
                        <td><?= $user->getField('suspended')->getValue() == 1 ? 'Yes' : 'No'; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
<?php } else { ?>
    <h5>No registered users found</h2>
<?php } ?>
</section>
