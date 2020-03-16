<?php
$adminData = $this->val('admin');
$editClass = ($this->edit) ? 'hide' : '';

$userStatus = array(1 => 'Active', 0 => 'Inactive');
$permissionStatus= array(0 => 'Select',1 => 'View', 2 => 'View , Add', 3 => 'View , Add , Edit', 4 => 'View , Add , Edit, Delete');
$roleArray = $this->roleArray;
$activeStatus = isset($adminData->status) ? $adminData->status : 1;
$activeRole = isset($adminData->role_id) ? $adminData->role_id : 0;
$permission = $this->permission;
$userList = $this->userList;
$moduleList = $this->moduleList;
?>
<style>
    span.permission_text {
        position: relative;
        bottom: 5px;
        padding-right: 20px;
        display: inline-block;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php
            if (isset($adminData->name)) {
                echo '<i class="fa fa-user-secret" aria-hidden="true"></i> ' . $adminData->name;
            } else {
                echo '<i class="fa fa-user-secret" aria-hidden="true"></i> Add New Admin';
            }
            ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="admin/">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="admins/" class="active"> Admins</a>
            </li>
            <li> <?php echo ($this->edit) ? 'Edit' : 'Add'; ?> User</li>
        </ol>
    </section>
    <section class="content pt-0">
        <div class="row">
            <form class="form-horizontal" method="post" id="adminForm" enctype="multipart/form-data">
                <div class="col-md-9 col-xs-12">
                    <div class="box box-default no-border">
                        <div class="box-header no-border">
                            <h3 class="box-title">User Information</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">User ID</label>
                                <div class="col-sm-10 col-xs-12">
                                    <label class="control-label">
                                        <?php echo isset($adminData->id) ? $adminData->id : ''; ?>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group custom-group">
                                <label for="inputName" class="col-sm-2 control-label">Full Name <span class="require">*</span></label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <input type="text" name="name" class="form-control input-sm" required id="inputName" placeholder="i.e. John Smith" value="<?php echo isset($adminData->name) ? $adminData->name : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group custom-group">
                                <label for="inputUser" class="col-sm-2 control-label">Username <span class="require">*</span></label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <input type="text" name="username" class="form-control input-sm" id="inputUser" required placeholder="i.e. john01" value="<?php echo isset($adminData->username) ? $adminData->username : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group custom-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email <span class="require">*</span></label>
                                <div class="col-sm-9 col-xs-12 validationHolder">
                                    <input type="email" name="email" class="form-control input-sm" required id="inputEmail" placeholder="name@domain.tls" value="<?php echo isset($adminData->email) ? $adminData->email : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group custom-group">
                                <label for="inputRole" class="col-sm-2 control-label">Role</label>
                                <div class="col-sm-4 col-xs-12">
                                    <select name="role_id" class="form-control input-sm <?php echo $editClass; ?> admin_role">
                                        <option value=""> -- Select an option -- </option>
                                        <?php
                                        foreach ($roleArray as $k => $role) {
                                            ?>
                                            <option value="<?= $role->id; ?>" <?php if(!empty($adminData->role_id)){echo ($role->id === $adminData->role_id) ? ' selected' : ''; }?>><?= $role->title;?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if ($this->edit) { ?>
                                        <?php
                                        if ($adminData->role_id > 1) {
                                            $parentMessage = 'primary';
                                        } else {
                                            $parentMessage = 'info';
                                        }
                                        ?>
                                        <span class="edit-control">
                                            <span class="label label-<?php echo $parentMessage; ?>"><?php if(isset($adminData->role_title)){echo ($adminData->role_title); }?></span> &nbsp;
                                            <a href="#" class="editBtn"><i class="fa fa-pencil" aria-hidden="true"></i> Change User Role</a>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group custom-group">
                                <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                                <span class="<?php echo $editClass; ?>">
                                    <div class="col-sm-4 col-xs-12 validationHolder">
                                        <input type="password" name="password" class="form-control input-sm" id="inputPassword" placeholder="Password" <?php if (!$this->edit) { echo 'required';}?> >
                                    </div>
                                    <!--<label for="inputConfirm" class="col-sm-2 control-label">Confirm Password</label>
                                    <div class="col-sm-4 col-xs-12 validationHolder">
                                        <input type="password" name="confirm" class="form-control input-sm" id="inputConfirm" placeholder="Confirm Password">
                                    </div>-->
                                </span>
                                <?php if ($this->edit) { ?>
                                    <div class="col-sm-10 edit-control">
                                        <span class="label label-success">Valid</span> &nbsp;
                                        <a href="#" class="editBtn"><i class="fa fa-pencil" aria-hidden="true"></i> Change password</a> &nbsp;
                                    </div>
                                <?php } ?>
                            </div>
                            <?php echo $this->csrfToken(); ?>
                            <input type="hidden" name="uid" value="<?php echo isset($adminData->id) ? $adminData->id : 0; ?>">
                        </div>
                    </div>
                    <div class="box box-default no-border">
                        <div class="box-header no-border">
                            <h3 class="box-title">User Permission</h3>
                        </div>
                        <div class="permission">
                            <div class="box-body">

                                <div class="form-group" >
                                    <div class="col-sm-2 col-xs-12 validationHolder  col-md-offset-1">
                                        <label for="module_id" class="control-label">Module</label>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 validationHolder ">
                                        <label for="language_id" class="col-sm-1 control-label">Select</label>
                                    </div>
                                </div>
                                <?php
                                if (!empty($moduleList)):
                                    foreach ($moduleList as $k => $module):
                                        ?>
                                        <div class="form-group custom-group">

                                            <div class="col-sm-2 col-xs-12 validationHolder col-md-offset-1">
                                                <h5 class="permission_text"><?= $module->title ?></h5>
                                                <input type="hidden" name="module_id[]" class="form-control input-sm" placeholder="module_id" value="<?= $module->id ?>">
                                            </div>
                                            <div class="col-sm-8 col-xs-12 validationHolder" style="padding-left: 50px">
                                                <select name="view[]" class="form-control input-sm">
                                                    <?php
                                                    foreach ($permissionStatus as $status => $value) {
                                                        ?>
                                                        <option value="<?php echo $status; ?>"<?php if (isset($permission[$k]->permission)) {
                                                            echo ($status === $permission[$k]->permission) ? ' selected' : '';
                                                        } ?>>
                                                            <?= $value; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="admins/" class="btn btn-default btn-sm"><i class="fa fa-close" aria-hidden="true"></i> Close</a>
                            <?php if (isset($adminData->id)) { ?>
                                <a href="admin/delete/<?php echo $adminData->id; ?>" class="popup">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Delete this user
                                </a>
                            <?php } ?>
                            <button type="submit" class="btn btn-success btn-sm pull-right">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 pad-left-0">
                    <div class="box box-default no-border">
                        <div class="box-header no-border">
                            <h3 class="box-title">Avatar</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            if (!empty($adminData->avatar)) {
                                $avatar = BASE_URL . $adminData->avatar;
                            } else {
                                $avatar = BASE_URL . 'images/admins/demo.png';
                            }
                            ?>
                            <img src="<?php echo $avatar; ?>" class="img-responsive img-center" style="max-width: 50%;">
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
                <div class="col-md-3 col-xs-12 pad-left-0">
                    <div class="box box-default no-border">
                        <div class="box-header no-border">
                            <h3 class="box-title">Extra Settings</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputStatus" class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-9 col-xs-12">
                                    <select name="status" id="inputStatus" class="form-control input-sm <?php echo $editClass; ?>">
                                        <?php
                                        foreach ($userStatus as $status => $statusName) {
                                            ?>
                                            <option value="<?php echo $status; ?>"<?php echo ($activeStatus === $status) ? ' selected' : ''; ?>>
                                                <?php
                                                echo ucfirst($statusName);
                                                ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <?php if ($this->edit) { ?>
                                        <?php
                                        if ($adminData->status == -1) {
                                            $statMessage = ['Blocked', 'danger'];
                                        } else if ($adminData->status == 0) {
                                            $statMessage = ['Pending', 'warning'];
                                        } else {
                                            $statMessage = ['Active', 'success'];
                                        }
                                        ?>
                                        <span class="edit-control">
                                            <span class="label label-<?php echo $statMessage[1]; ?>"><?php echo $statMessage[0]; ?></span> &nbsp;
                                            <a href="#" class="editBtn"><i class="fa fa-pencil" aria-hidden="true"></i> Active/Block User</a>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<script>
    $(document).on('change', '.admin_role', function () {
        var id = $(this).val();
        var uid = $('.uid').val();
        var csrf_token = $('[name="csrf_token"]').val();
        $this = $(this);
        $.ajax({
            url: "<?= BASE_URL; ?>admin/permission/role",
            type: "post",
            data: {id: id, uid:uid, csrf_token: csrf_token},
            success: function (response) {
                $('.permission').html(response);
            },
        });
    });
</script>