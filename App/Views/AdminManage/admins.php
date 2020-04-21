<?php
$admins = $this->val('admins');
$filterRole = isset($_GET["role"]) ? $this->request->getUrlData("role") : 'all';
$filterStatus = isset($_GET["status"]) ? $this->request->getUrlData("status") : 'all';

$roleArray = array(10 => 'Admin', 20 => 'Super Admin');
$adminStatus = array(1 => 'Active', 0 => 'Inactive');

$activeStatus = isset($adminStatus[$filterStatus]) ? $adminStatus[$filterStatus] : 'all';
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-user-secret" aria-hidden="true"></i> Admins
            <small>Master Maintenance</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="admin/">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li> Admins</li>
        </ol>
    </section>
    <section class="content pt-0">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default no-border" id="filter">
                    <div class="box-header">
                        <div class="row text-right">
                            <form class="form-inline">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="input-group input-group-sm" style="width: 200px;">
                                        <input type="text" id="query" name="q" value="<?php echo $this->request->getUrlData("q"); ?>" class="form-control pull-right search-field" placeholder="Search admins name and username" />
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i> Filter
                                            </button>
                                            <a href="<?php echo BASE_URL; ?>admins/" type="button" class="btn btn-default btn-sm">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4">
                                    <label for="role">Role: </label>
                                    <select name="role" class="form-control input-sm">
                                        <option value="all">All Roles</option>
                                        <?php
                                        if (!empty($roleArray)) {
                                            foreach ($roleArray as $role => $roleName) {
                                                ?>
                                                <option value="<?php echo $role; ?>"<?php echo $role == $filterRole ? ' selected' : ''; ?>><?php echo ucfirst($roleName); ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <label for="status">Status: </label>
                                    <select name="status" class="form-control input-sm">
                                        <option value=""<?php echo ($activeStatus === 'all') ? ' selected' : ''; ?>>All</option>
                                        <?php
                                        if (!empty($adminStatus)) {
                                            foreach ($adminStatus as $status => $statusName) {
                                                ?>
                                                <option value="<?php echo $status; ?>"<?php echo ($activeStatus === $statusName) ? ' selected' : ''; ?>><?php echo ucfirst($statusName); ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 pull-right">
                                    <a href="<?php echo BASE_URL; ?>admin/add" class="btn btn-success"><i class="fa fa-plus"></i> Add Admin</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <?php
                                $sl = $this->values['pagination']->getOffSet() + 1;
                                if (!empty($admins)) {
                                    foreach ($admins as $admin) {
                                        $link = BASE_URL.PANEL .'/user/edit/'. $admin->id;
                                        ?>
                                        <tr>
                                            <td><span><?php echo $sl++; ?></span></td>
                                            <td>
                                                <a href="<?= $link; ?>">
                                                    <?php echo $admin->name; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= $link; ?>">
                                                    <?php echo $admin->username; ?>
                                                </a>
                                            <td>
                                                <span class="label label-<?php echo $admin->role_id > 1 ? "primary" : "info"; ?>">
                                                    <?php echo $admin->role_title; ?>
                                                </span>
                                            </td>
                                            <td><?php echo $admin->email; ?></td>
                                            <td class="text-center"><?php echo $this->statusIcon($admin->status); ?></td>
                                            <td class="text-center">
                                                <a class="btn btn-info btn-xs color-white" href="<?= $link; ?>">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </a>
                                                <a class="popup btn btn-danger btn-xs color-white" href="<?php echo BASE_URL.PANEL.'/user/delete/'.$admin->id; ?>">
                                                    <i class="fa fa-trash " aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->make(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
