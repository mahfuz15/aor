<?php
$permissionStatus= array(0 => 'Select',1 => 'View', 2 => 'View , Add', 3 => 'View , Add , Edit', 4 => 'View , Add , Edit, Delete');
$userPermission = $this->userPermission;
$permission = $this->permission;
$moduleList = $this->moduleList;

?>

<div class="box-body">

    <?php
    if (!empty($moduleList)):
        foreach ($moduleList as $k => $module): ?>


            <div class="form-group">
                <label for="module_id" class="col-sm-2 control-label">Module</label>
                <div class="col-sm-4 col-xs-12 validationHolder">
                    <h5 class="permission_text"><?= $module->title ?></h5>
                    <input type="hidden" name="module_id[]" class="form-control input-sm"
                           placeholder="module_id"
                           value="<?= $module->id ?>">
                </div>
                <div class="col-sm-6 col-xs-12" style="padding-left: 50px">
                    <select name="view[]" class="form-control input-sm">
                        <?php
                        foreach ($permissionStatus as $status => $value) {
                            ?>
                            <option value="<?php echo $status; ?>"<?php if(isset($permission[$k]->permission)){echo ($status === $permission[$k]->permission) ? ' selected' : '';} ?>>
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