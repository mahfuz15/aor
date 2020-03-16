<?php
//pr($this->values);
$widget = $this->val('widget');
?>
<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Do you want to delete this Widget ?</h3>
  </div>
  <div class="box-body">
    <dl class="dl-horizontal">
      <dt>Widget:</dt>
      <dd><?php echo $widget->title; ?></dd>
      <dt>Position:</dt>
      <dd><?php echo ucfirst($widget->position); ?></dd>
      <dt>Type:</dt>
      <dd><?php echo ucfirst($widget->type); ?></dd>
    </dl>
  </div>
  <div class="box-footer">
    <form method="post" action="<?php echo BASE_URL; ?>admin/widget/delete/<?php echo $widget->id; ?>">
      <?php echo $this->csrfToken(); ?>
      <input type="hidden" name="confirm" value="delete" />
      <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
    </form>
  </div>
</div>