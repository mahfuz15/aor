<?php
$permissionStatus= array(
    0 => 'Select',
    1 => 'View', 
    2 => 'View , Add', 
    3 => 'View , Add , Edit', 
    4 => 'View , Add , Edit, Delete',
    5 => 'View, Edit',
);
$role = $this->role;
$permission = $this->rolePermissions;
$moduleList = $this->moduleList;
$view = 0;
$statuses = [1 => 'Active', 0 => 'Disabled'];
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php
            if (isset($role->id)) {
                echo '<i class="fa fa-unlock" aria-hidden="true"></i> ' . $role->title;
            } else {
                echo '<i class="fa fa-unlock" aria-hidden="true"></i> New Role';
            }
            ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?= BASE_URL . PANEL; ?>/">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?= BASE_URL . PANEL; ?>/<?= strtolower(SITE) ?>/roles/" class="active"> Role </a>
            </li>
            <li> <?php echo isset($role->id) ? 'Edit' : 'Add'; ?> Role</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <form class="form-horizontal" method="post" id="RoleForm" name="roleForm" enctype="multipart/form-data">
                <div class="col-md-8 col-xs-12">
                    <div class="box box-default no-border">
                        <div class="box-header no-border">
                            <h3 class="box-title">Update Role</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Title <span class="require">*</span></label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="title" class="form-control input-sm" id="title" placeholder="Role title" value="<?php echo $this->objval("role", "title"); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <textarea type="text" name="description"  rows="2" class="form-control input-sm" id="description" placeholder="Role description"><?php echo $this->objval("role", "description"); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="box box-default no-border">
                            <div class="box-header no-border">
                                <h3 class="box-title">User Permission</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group" >
                                    <div class="col-sm-2 col-xs-12 validationHolder  col-md-offset-1">
                                        <label for="module_id" class="control-label">Module</label>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 validationHolder">
                                        <label for="language_id" class="col-sm-2 control-label">Select</label>
                                    </div>
                                </div>
                                <?php
                                if (!empty($moduleList)):
                                    foreach ($moduleList as $k => $module):?>
                                        <div class="form-group custom-group">
                                            <div class="col-sm-2 col-xs-12 validationHolder col-md-offset-1">
                                                <input type="hidden" name="module_id[]" class="form-control input-sm" placeholder="module_id" value="<?= $module->id?>"><h5 class="permission_text"><?= $module->title?></h5>
                                            </div>
                                            <div class="col-sm-8 col-xs-12 validationHolder " style="padding-left: 50px">
                                                <?php //pr($permission[$k]->permission); ?>
                                                <select name="view[]" class="form-control input-sm">
                                                    <?php
                                                    foreach ($permissionStatus as $status => $value) {
                                                        ?>
                                                        <option value="<?php echo $status; ?>"<?php if(isset($permission[$k]->permission)){ echo ($status === $permission[$k]->permission) ? 'selected' : ''; }?>>
                                                            <?=$value;?>
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
                            <?php echo $this->csrfToken(); ?>
                            <div class="box-footer">
                                <a href="<?= BASE_URL . PANEL; ?>/<?= strtolower(SITE) ?>/roles/" class="btn btn-default btn-sm">
                                    <i class="fa fa-close" aria-hidden="true"></i> Close
                                </a>
                                <button type="submit" class="btn btn-success btn-sm pull-right">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="box box-default no-border">
                        <div class="box-header no-border">
                            <h3 class="box-title">Extra Settings</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <select name="status" class="form-control">
                                        <?php
                                        if (!empty($statuses)):
                                            foreach ($statuses as $k => $status):
                                                ?>
                                                <option value="<?= $k; ?>" <?= ($k === $this->objval('role', 'status')) ? 'selected' : ''; ?>><?= $status; ?></option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>