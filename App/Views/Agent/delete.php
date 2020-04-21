<?php
$agent = $this->agent;
?>

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Do you want to delete this Agent?</h3>
    </div>
    <div class="box-body">
        <dl class="dl-horizontal">
            <dt>Agent Title:</dt>
            <dd><?php echo $agent->title; ?></dd>
        </dl>
    </div>
    <div class="box-footer">
        <form method="post" action="<?php echo BASE_URL . PANEL; ?>/agent/delete/<?php echo $agent->id ?>">
            <?php echo $this->csrfToken(); ?>
            <input type="hidden" name="confirm" value="delete" />
            <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
        </form>
    </div>
</div>