<?php
$userInfo = $this->loggedUser;
//pr($userInfo);die();
?>
<?php
if ((PANEL === USER_PANEL_NAME && $this->isLoggedIn('user')) || (PANEL == ADMIN_PANEL_NAME && $this->isLoggedIn('admin'))) {

    if (file_exists(ROOT . DS . PUBLIC_DIR . DS . $userInfo->avatar)) {
        $avatar = BASE_URL . $userInfo->avatar;
    } else {
        $avatar = BASE_URL . 'images/' . PANEL . 's';
    }
    ?>
    <div class="wrapper" >
    <header class="main-header">
        <a href="<?php echo PANEL; ?>/" class="logo">
                <span class="logo-mini" style="padding: 10px;">
                    <img src="images/branding/logo-atago.png" class="img-responsive" />
                </span>
            <span class="logo-lg" style="padding: 3px 15px;margin-top: 5px">
                    <img src="images/branding/logo-white.png" class="img-responsive" style="max-height: 46px;" />
                </span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <h4 class="pull-left headtitle" style="padding-left: 5px"><?php echo SITE; ?> - Management Panel</h4>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo BASE_URL; ?>" target="_blank"><i class="fa fa-external-link"></i> Live Site</a>
                    </li>

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo $avatar; ?>" class="user-image" alt="">
                            <span class="hidden-xs"><?php echo isset($userInfo->name) ? $userInfo->name : 'Unknown User'; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                            if (!empty($adminData->avatar)) {
                                $avatar = BASE_URL . $adminData->avatar;
                            } else {
                                $avatar = BASE_URL . 'images/admins/demo.png';
                            }
                            ?>
                            <li class="user-header">
                                <img src="<?php echo $avatar; ?>" class="img-circle" alt="User Image">
                                <p>
                                    <?php echo isset($userInfo->fullname) ? $userInfo->fullname : ''; ?> <?php echo isset($userInfo->roleName) ? ucfirst($userInfo->roleName->title) : ''; ?>
                                    <small>Member since <?php echo isset($userInfo->created) ? date("M Y", strtotime($userInfo->created)) : ''; ?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo BASE_URL . PANEL; ?>/profile" class="btn btn-success btn-flat">Account</a>
                                    <a href="<?php echo BASE_URL . PANEL; ?>/preference" class="btn btn-info btn-flat">Preference</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo BASE_URL . PANEL; ?>/logout" class="btn btn-danger btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <?php require 'navigation.php'; ?>
    <?php
}
?>