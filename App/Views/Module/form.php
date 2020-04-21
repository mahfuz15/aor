<?php
$module = $this->module;


$statuses = [1 => 'Active', 0 => 'Disabled'];
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php
            if (isset($module->id)) {
                echo '<i class="fa fa-cubes" aria-hidden="true"></i> ' . $module->title;
            } else {
                echo '<i class="fa fa-cubes" aria-hidden="true"></i> Add New Module';
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
                <a href="<?= BASE_URL . PANEL; ?>/pwd/modules/" class="active"> Modules
                </a>
            </li>
            <li> <?php echo isset($module->id) ? 'Edit' : 'Add'; ?> Module</li>
        </ol>
    </section>
    <section class="content pt-0">
        <div class="row">
            <form class="form-horizontal" method="post" id="ModuleForm" name="moduleForm" enctype="multipart/form-data">
                <div class="col-md-8 col-xs-12">
                    <div class="box box-default no-border">
                        <div class="box-header no-border">
                            <h3 class="box-title">Update Module</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Title <span class="require">*</span></label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="title" class="form-control input-sm" id="title" placeholder="Module title" value="<?php echo $this->objval("module", "title"); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="route" class="col-sm-2 control-label">Route <span class="require">*</span></label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="route" class="form-control input-sm" id="route" placeholder="Module route" value="<?php echo $this->objval("module", "route"); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alias" class="col-sm-2 control-label">Alias <span class="require">*</span></label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="alias" class="form-control input-sm" id="alias" placeholder="Module alias" value="<?php echo $this->objval("module", "alias"); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="icon" class="col-sm-2 control-label">Icon <span class="require">*</span></label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="icon" class="form-control input-sm" id="icon" placeholder="Module icon" value="<?php echo $this->objval("module", "icon"); ?>" required>
                                </div>
                            </div>
                            <?php echo $this->csrfToken(); ?>

                            <div class="box-footer">
                                <a href="<?= BASE_URL . PANEL; ?>/pwd/modules/" class="btn btn-default btn-sm">
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
                                                <option value="<?= $k; ?>" <?= ($k === $this->objval('module', 'status')) ? 'selected' : ''; ?>><?= $status; ?></option>
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