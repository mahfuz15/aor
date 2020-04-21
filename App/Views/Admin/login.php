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
	    <div class="form-group has-feedback">
		<input name="username" type="text" class="form-control" placeholder="<?php echo ucfirst(PANEL); ?> ID" autofocus>
		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	    </div>
	    <div class="form-group has-feedback">
		<input name="password" type="password" class="form-control" placeholder="Password">
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	    </div>
	    <div class="row">
		<div class="col-xs-8">
                <label>
                    <a class="btn btn-primary btn-block btn-flat" href="<?php echo BASE_URL . PANEL?>/forgot-password">Forgot Password?</a>
                </label>
		</div>
		<div class="col-xs-4">
		    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
		</div>
	    </div>
	    <?php echo $this->csrfToken(); ?>
	</form>
    </div>
</div>