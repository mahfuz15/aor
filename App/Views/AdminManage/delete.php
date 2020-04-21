<?php
$admin = $this->admin;
?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Do you want to delete this User?</h3>
    </div>
    <div class="box-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd><?php echo $admin->name; ?></dd>
            <dt>Email</dt>
            <dd><?php echo $admin->email; ?></dd>
            <dt>Username</dt>
            <dd><?php echo $admin->username; ?></dd>
        </dl>
    </div>
    <div class="box-footer">
        <form method="post" action="admin/delete/<?php echo $this->values["admin"]->id; ?>">
            <input type="hidden" name="confirm" value="delete" />
            <?php echo $this->csrfToken(); ?>
            <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
        </form>
    </div>
</div>