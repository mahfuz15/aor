<div class="m-3">
    <div class="login-box card col-lg-4 col-sm-12 mx-auto">
        <div class="login-logo mx-auto pb-3 pt-3">
        <a href="<?php echo BASE_URL?>login"><b>LOGIN</b></a>
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
            <input name="username" type="text" class="form-control" placeholder="Email" autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
            <input name="password" type="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    <a class="small float-right mt-3 mb-3" href="<?php echo BASE_URL?>forgot-password">Forgot Password?</a>
                </div>
            </div>
            <?php echo $this->csrfToken(); ?>
        </form>
        </div>
    </div>
</div>