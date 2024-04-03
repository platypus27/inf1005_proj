<section class="card border-0 m-3">
    <h1>Contact Requests</h1>
<?php if (isset($data['contact'])) { ?>
    <div class="d-flex flex-column">
        <?php
            foreach ($data['contact'] as $contact) { 
                $id = $contact->getField('id')->getValue();
        ?>
        <div class='p-4 m-2 bg-light'>
            <p class="commentloginid">name: <?= htmlspecialchars($contact->getField('name')->getValue()); ?></p>
            <p class="commentloginid">email: <?= htmlspecialchars($contact->getField('email')->getValue()); ?></p>
            <p class="commentloginid">message: <?= htmlspecialchars($contact->getField('message')->getValue()); ?></p>
            <form class="text-left" method="POST" action="/admin/delete">
                <input type="hidden" name="<?= FORM_CSRF_FIELD ?>" value="<?= $_SESSION[SESSION_CSRF_TOKEN]; ?>">
                <input type="hidden" name="id" value="<?= htmlspecialchars($contact->getField('id')->getValue()); ?>">
                <input type="submit" name="delete" class="btn btn-danger" value="Delete request"/>
            </form>
        </div>  
        <?php } ?>
    </div>
<?php } else { ?>
    <h5>no open contact requests</h2>
<?php } ?>
</section>
