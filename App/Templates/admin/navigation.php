<?php
$userInfo = $this->loggedUser;
$userModule = $this->userModulePermission;

?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">APP NAVIGATION</li>
            <li class="treeview">
                <a href="<?php echo BASE_URL . PANEL; ?>/">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="header">MANAGE</li>
            <li class="treeview">
                <a href="<?php echo BASE_URL . PANEL; ?>/">
                    <i class="fa fa-th"></i>
                    <span>Manage</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php if (!empty($userModule)) {
                        foreach ($userModule as $module) {
                            if ($module->module_status > 0) {
                                ?>
                                <li>
                                    <a href="<?php echo BASE_URL . PANEL . '/' . $module->route; ?>" id="sidebarCollapse">
                                        <i class="<?= $module->icon?>"></i> <?= $module->title ?>
                                    </a>
                                </li>
                            <?php }
                        }
                    } ?>
                </ul>
            </li>

            <?php if (PANEL == 'admin' && $userInfo->role_id == 1) { ?>

                <li class="header">ADMINISTRATION</li>
                <li class="treeview">
                    <a href="<?php echo BASE_URL . PANEL; ?>s">
                        <i class="fa fa-user-secret"></i>
                        <span>Admins</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="<?php echo BASE_URL . PANEL; ?>s">
                                <i class="fa fa-user-secret text-green"></i> Manage Admins
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL . PANEL; ?>/add">
                                <i class="fa fa-user text-aqua"></i> New Admin
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL . PANEL. '/' .strtolower(SITE). '/modules' ;?>">
                                <i class="fa fa-cubes"></i>Modules
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL . PANEL. '/' .strtolower(SITE). '/roles' ;?>">
                                <i class="fa fa-unlock text-yellow"></i>Roles
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="<?php echo BASE_URL . PANEL; ?>/config/site">
                        <i class="fa fa-cogs"></i>
                        <span>Configuration</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="<?php echo BASE_URL . PANEL; ?>/config/site">
                                <i class="fa fa-circle-o text-red"></i> Site Configuration
                            </a>
                        </li>
                    </ul>
                </li>
            <?php }
            ?>
        </ul>
    </section>
</aside>
