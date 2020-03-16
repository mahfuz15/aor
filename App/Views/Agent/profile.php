<div class="login-box">
    <div class="login-logo">
        
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
            <label for="username">Username</label>
            <input name="username" type="text" class="form-control" id="username"  placeholder="Enter username">
        </div>
        <div class="form-group mt-3">
            <label for="password">New Password</label>
            <input name="password" type="password" class="form-control" id="password"  placeholder="Enter password">
        </div>
        <div class="form-group mt-3">
            <label for="ConfirmPassword">Repeat New Password</label>
            <input name="ConfirmPassword" type="password" class="form-control" id="ConfirmPassword" placeholder="Repeat password">
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary btn-block btn-color">Complete Registration</button>
        </div>
        <?php echo $this->csrfToken(); ?>
    </form>
</div>