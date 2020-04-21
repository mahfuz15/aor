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
$view = 0;
/*$add = 0;
$edit = 0;
$delete = 0;*/
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
                echo '<i class="fa fa-user" aria-hidden="true"></i> ' . $adminData->name;
            } else {
                echo '<i class="fa fa-user-plus" aria-hidden="true"></i> New Admin';
            }
            ?>
            <small>Add new admin</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="admins/" class="active"> Admins</a></li>
            <li> <?php echo ($this->edit) ? 'Edit' : 'Add'; ?> User</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <form class="form-horizontal" method="post" id="adminForm" enctype="multipart/form-data">
                <div class="col-md-8 col-xs-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
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
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Full Name</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="name" class="form-control input-sm" id="inputName" placeholder="i.e. John Smith" 
                                           value="<?php echo isset($adminData->name) ? $adminData->name : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="email" name="email" class="form-control input-sm" id="inputEmail" placeholder="name@domain.tls" 
                                           value="<?php echo isset($adminData->email) ? $adminData->email : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputUser" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="username" class="form-control input-sm" id="inputUser" placeholder="i.e. john01" 
                                           value="<?php echo isset($adminData->username) ? $adminData->username : ''; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                                <span class="<?php echo $editClass; ?>">
                                    <div class="col-sm-4 col-xs-12 validationHolder">
                                        <input type="password" name="password" class="form-control input-sm" id="inputPassword" placeholder="Password">
                                    </div>
                                    <label for="inputConfirm" class="col-sm-2 control-label">Confirm Password</label>
                                    <div class="col-sm-4 col-xs-12 validationHolder">
                                        <input type="password" name="confirm" class="form-control input-sm" id="inputConfirm" placeholder="Confirm Password">
                                    </div>
                                </span>
                                <?php if ($this->edit) { ?>
                                    <div class="col-sm-10 edit-control">
                                        <span class="label label-success">Valid</span> &nbsp;
                                        <a href="#" class="editBtn"><i class="fa fa-pencil" aria-hidden="true"></i> Change password</a> &nbsp;
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label for="inputRole" class="col-sm-2 control-label">Role</label>
                                <div class="col-sm-4 col-xs-12">
                                    <select name="role_id" class="form-control input-sm <?php echo $editClass; ?> admin_role">
                                       <option value=""> -- Select an option -- </option>
                                        <?php
                                        foreach ($roleArray as $k => $role) {
                                            ?>
                                            <option value="<?= $role->id; ?>">
                                                <?= $role->title;
                                               /* echo ucfirst($role);*/
                                                ?>
                                            </option>
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
                                            <span class="label label-<?php echo $parentMessage; ?>"><?php echo ($adminData->role_title); ?></span> &nbsp;
                                            <a href="#" class="editBtn"><i class="fa fa-pencil" aria-hidden="true"></i> Change User Role</a>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputStatus" class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-4 col-xs-12">
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

                            <?php echo $this->csrfToken(); ?>
                            <input type="hidden" name="uid" value="<?php echo isset($adminData->id) ? $adminData->id : 0; ?>">
                        </div>
                    </div>

                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">User Permission</h3>
                            </div>
                            <div class="permission">
                            <div class="box-body">

                                <?php
                                if (!empty($moduleList)):
                                    foreach ($moduleList as $k => $module):
                                        //$view = 0;
                                        /*if (!empty($permission[$k]->module_id)):
                                            if ($permission[$k]->module_id == $module->id):
                                                if ($permission[$k]->permission == 1):
                                                    $view = 1;
                                                endif;
                                                /*if ($permission[$k]->permission_add == 1) $add = 1;
                                                else $add = 0;
                                                if ($permission[$k]->permission_edit == 1) $edit = 1;
                                                else $edit = 0;
                                                if ($permission[$k]->permission_delete == 1) $delete = 1;
                                                else $delete = 0;
                                            endif;
                                        endif;*/
                                        ?>


                                        <div class="form-group">
                                            <label for="module_id" class="col-sm-2 control-label">Module</label>
                                            <div class="col-sm-4 col-xs-12 validationHolder">
                                                <h5 class="permission_text"><?= $module->title?></h5>
                                                <input type="hidden" name="module_id[]" class="form-control input-sm"
                                                       placeholder="module_id"
                                                       value="<?= $module->id?>">
                                            </div>
                                            <div class="col-sm-6 col-xs-12 validationHolder" style="padding-left: 50px">
                                                <select name="view[]" class="form-control input-sm">
                                                    <?php
                                                    foreach ($permissionStatus as $status => $value) {
                                                        ?>
                                                        <option value="<?php echo $status; ?>"<?php echo ($status === $permission[$k]->permission) ? ' selected' : ''; ?>>
                                                        <?=$value;?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <!--<input type="hidden" name="view[]" value="<?/*=$view*/?>"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value"
                                                    <?php /*if($view == 1 ) echo "checked"*/?>><span class="permission_text">View</span>-->
                                                <!--<input type="hidden" name="add[]" value="<?/*=$add*/?>"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value"
                                                    <?php /*if($add == 1 ) echo "checked"*/?>> <span class="permission_text">Add</span>
                                                <input type="hidden" name="edit[]" value="<?/*=$edit*/?>"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value"
                                                    <?php /*if($edit == 1 ) echo "checked"*/?>> <span class="permission_text">Edit</span>
                                                <input type="hidden" name="delete[]" value="<?/*=$delete*/?>"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value"
                                                    <?php /*if($delete == 1 ) echo "checked"*/?>><span class="permission_text">Delete</span>
                                            -->

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
                                &nbsp;
                                <a href="admin/delete/<?php echo $adminData->id; ?>" class="popup"><i class="fa fa-trash" aria-hidden="true"></i> Delete this user</a>
                            <?php } ?>
                            <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-xs-12 pad-left-0">
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
        <?php //pr($this->values);   ?>
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