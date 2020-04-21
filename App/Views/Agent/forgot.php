<div class="login-box">
    <div class="login-logo">
        <a href=""><b><?php echo ucfirst(PANEL); ?></b> Panel</a>
    </div>
    <div class="login-box-body">
        <?php
        $alertMsg = $this->message();
        if (!empty($alertMsg)) {
        //$alertType = $alertMsg[0]['type'];
        foreach ($alertMsg as $altmsg) {
        ?>
        <div class="alert alert-<?php echo $altmsg['type']; ?>"">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $altmsg['message']; ?>
    </div>
    <?php
    }
    }
    ?>
    <form method="post">
        <div class="form-group mt-3">
            <label for="login-password">Provide your email address</label>
            <input name="email" type="email" class="form-control" id="login-password" placeholder="email" required>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <label>
                    <a class="btn btn-primary btn-block btn-flat" href="<?php echo BASE_URL . PANEL?>/login">Login?</a>
                </label>
            </div>
            <div class="col-xs-6">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
            </div>
        </div>
        <?php echo $this->csrfToken(); ?>
    </form>
</div>
</div>

