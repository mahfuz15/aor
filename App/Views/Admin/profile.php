<?php
$adminData = $this->values['admin'];
$roleArray = $this->val('roleArray');
$activeRole = $this->objval('admin', 'role');

?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Update Profile Info
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL . PANEL; ?>/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li> Profile</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <form class="form-horizontal" method="post" enctype="multipart/form-data" id="registrationForm">
                <div class="col-md-8 col-xs-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">My Account</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-sm-12">
                                <label for="name" class="col-sm-2 control-label"><i class="fa fa-user"></i> Name</label>
                                <div class="col-sm-8">
                                    <input name="name" data-labelmask data-enchanched="true" type="text" class="form-control" id="fullname" required="" placeholder="Enter your Name" value="<?php echo $this->objval('admin', 'name'); ?>">
                                </div>
                            </div>                                

                            <div class="form-group col-sm-12">
                                <label for="username" class="col-sm-2 control-label"><i class="fa fa-user-md"></i> Username</label>
                                <div class="col-sm-8">
                                    <input name="username" type="text" class="form-control input-sm" id="username" required="" placeholder="Enter Unique Username" value="<?php echo $this->objval('admin', 'username'); ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="email" class="col-sm-2 control-label"><i class="fa fa-at"></i> Email</label>
                                <div class="col-sm-8">
                                    <input name="email" type="email" class="form-control input-sm" id="email" required="" placeholder="Enter your Email" value="<?php echo $this->objval('admin', 'email'); ?>">
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <div class="col-sm-6 nopadding">
                                    <label for="password" class="col-sm-4 control-label"><i class="fa fa-key" aria-hidden="true"></i> Password</label>
                                    <div class="col-sm-8">
                                        <input name="password" type="password" class="form-control input-sm" id="password" placeholder="Enter Password">
                                    </div>
                                </div>
                               <!-- <div class="col-sm-6 nopadding">
                                    <label for="re-password" class="col-sm-4 control-label"><i class="fa fa-key" aria-hidden="true"></i> Confirm</label>
                                    <div class="col-sm-8">
                                        <input name="confirm_password" type="password" class="form-control input-sm" id="re-password" placeholder="Enter Password again to confirm">
                                    </div>
                                </div>-->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="<?php echo BASE_URL . PANEL; ?>/" class="btn btn-default btn-sm pull-left"><i class="fa fa-close" aria-hidden="true"></i> Close</a>
                            <button type="submit" class="btn btn-sm btn-success reg-but">Update </button>
                        </div>
                        <?php echo $this->csrfToken(); ?>
                    </div>

                </div>
                <div class="col-md-3 col-xs-12 pad-left-0">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Avatar</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            
                            if (!empty($adminData->avatar)) {
                                $avatar = BASE_URL . $adminData->avatar;
                            } else {
                                $avatar = BASE_URL . 'images/admins/default.jpg';
                            }
                            ?>
                            <img src="<?php echo $avatar; ?>" class="img-responsive img-center">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="exampleInputFile">Update Avatar</label>
                                    <input type="file" id="inputAvatar" name="avatar">
                                    <p class="help-block">Minimum photo size 512 x 512, file size shouldn't exceed 1MB</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>