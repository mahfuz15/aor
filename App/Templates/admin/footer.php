<?php if ($this->isLoggedIn('admin')) { ?>
    <aside class="control-sidebar control-sidebar-dark">
      <div class="tab-content">
        <div id="control-sidebar-theme-demo-options-tab" class="tab-pane active">
          <div>
            <h4 class="control-sidebar-heading">Site Settings</h4>     
            <div class="form-group">
              <label class="control-sidebar-subheading">Remove all cache</label>
              <p>Remove whole site cache</p>
              <a href="<?php echo BASE_URL . PANEL; ?>/cache/clear" class="btn btn-danger btn-sm">Clear cache</a>
            </div>          
          </div>
        </div>
    </aside>
<?php } ?>
</div>

<div class="modal modal-default fade" id="popup-modal" tabindex="-1" role="dialog"
     aria-labelledby="CommonModal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Confirm</h4>
      </div>
      <div class="modal-body"><content>Loading, Please wait...</content></div>
    </div>
  </div>
</div>

<?php
$actionMsg = $this->message();

if (!empty($actionMsg)) {
    $notifyType = $actionMsg[0]['type'];
    $msgType = [];

    if ($notifyType === 'warning') {
        $msgType[0] = 'warning'; // Modal class
        $msgType[1] = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> OOPS! Something is not right!'; // Notification title
        $msgType[2] = 'Could not process your request because of the following problems:'; // Notification Pretext
    } else if ($notifyType === 'danger') {
        $msgType[0] = 'danger'; // Modal class
        $msgType[1] = '<i class="fa fa-ban" aria-hidden="true"></i> Aw, Snap! Error ocurred!'; // Notification title
        $msgType[2] = 'Could not process your request because of the following errors:'; // Notification Pretext
    } else if ($notifyType === 'success') {
        $msgType[0] = 'success'; // Modal class
        $msgType[1] = '<i class="fa fa-check-square-o" aria-hidden="true"></i> Awesome, you did it!'; // Notification title
        $msgType[2] = 'Your following requests have been completed successfully:'; // Notification Pretext
    } else {
        $msgType[0] = 'info'; // Modal class
        $msgType[1] = '<i class="fa fa-comment-o" aria-hidden="true"></i> FYI, something just happened!'; // Notification title
        $msgType[2] = 'Youu have got following notifications:'; // Notification Pretext
    }
    ?>
    <div class="modal modal-<?php echo $msgType[0]; ?> fade" id="message-modal" tabindex="-1" role="dialog" aria-labelledby="MessageModal" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"><?php echo $msgType[1]; ?></h4>
          </div>
          <div class="modal-body">
            <h4>
                <?php
                echo $msgType[2];
                ?>
            </h4>
            <ul>
                <?php
                foreach ($actionMsg as $msg) {
                    echo '<li>' . $msg['message'] . '</li>';
                }
                ?>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline" data-dismiss="modal"> Ok </button>
          </div>
        </div>
      </div>
    </div>
    <?php
}