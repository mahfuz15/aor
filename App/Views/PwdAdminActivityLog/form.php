<?php
$pwdAdminActivityLog = $this->pwdAdminActivityLog;

$statuses = [1 => 'Active', 0 => 'Disabled'];
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php
            if (isset($pwdAdminActivityLog->id)) {
                echo '<i class="fa fa-list" aria-hidden="true"></i> ' . $pwdAdminActivityLog->admin_id;
            } else {
                echo '<i class="fa fa-list" aria-hidden="true"></i> New Pwd Admin Activity Log';
            }
            ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= BASE_URL . PANEL; ?>/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= BASE_URL . PANEL; ?>/pwd/activitylogs/" class="active"> PwdAdminActivityLogs </a></li>
            <li> <?php echo isset($pwdAdminActivityLog->id) ? 'Edit' : 'Add'; ?> Pwd Admin Activity Log</li>
        </ol>
    </section>
    <section class="content pt-0">
        <div class="row">
            <form class="form-horizontal" method="post" id="PwdAdminActivityLogForm" name="pwdAdminActivityLogForm" enctype="multipart/form-data">
                <div class="col-md-8 col-xs-12">
                    <div class="box box-default no-border">
                        <div class="box-header no-border">
                            <h3 class="box-title">Update Pwd Admin Activity Log</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="date" class="col-sm-2 control-label">Date</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="date" class="form-control input-sm" id="date" placeholder="Date" value="<?php echo $this->objval("pwdAdminActivityLog", "date"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="time" class="col-sm-2 control-label">Time</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="time" class="form-control input-sm" id="time" placeholder="Time" value="<?php echo $this->objval("pwdAdminActivityLog", "time"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="week_of_year" class="col-sm-2 control-label">Week_of_year</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="week_of_year" class="form-control input-sm" id="week_of_year" placeholder="Week_of_year" value="<?php echo $this->objval("pwdAdminActivityLog", "week_of_year"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="admin_id" class="col-sm-2 control-label">Admin_id</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="admin_id" class="form-control input-sm" id="admin_id" placeholder="Admin_id" value="<?php echo $this->objval("pwdAdminActivityLog", "admin_id"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ip" class="col-sm-2 control-label">Ip</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="ip" class="form-control input-sm" id="ip" placeholder="Ip" value="<?php echo $this->objval("pwdAdminActivityLog", "ip"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="path" class="col-sm-2 control-label">Path</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="path" class="form-control input-sm" id="path" placeholder="Path" value="<?php echo $this->objval("pwdAdminActivityLog", "path"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="search" class="col-sm-2 control-label">Search</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="search" class="form-control input-sm" id="search" placeholder="Search" value="<?php echo $this->objval("pwdAdminActivityLog", "search"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="uagt" class="col-sm-2 control-label">Uagt</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <textarea type="text" name="uagt" row="3" class="form-control input-sm" id="uagt" placeholder="Uagt" ><?php echo $this->objval("pwdAdminActivityLog", "uagt"); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ref" class="col-sm-2 control-label">Ref</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="ref" class="form-control input-sm" id="ref" placeholder="Ref" value="<?php echo $this->objval("pwdAdminActivityLog", "ref"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="language_id" class="col-sm-2 control-label">Language_id</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="language_id" class="form-control input-sm" id="language_id" placeholder="Language_id" value="<?php echo $this->objval("pwdAdminActivityLog", "language_id"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="product_id" class="col-sm-2 control-label">Product_id</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="product_id" class="form-control input-sm" id="product_id" placeholder="Product_id" value="<?php echo $this->objval("pwdAdminActivityLog", "product_id"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="file" class="col-sm-2 control-label">File</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="file" class="form-control input-sm" id="file" placeholder="File" value="<?php echo $this->objval("pwdAdminActivityLog", "file"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="os" class="col-sm-2 control-label">Os</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="os" class="form-control input-sm" id="os" placeholder="Os" value="<?php echo $this->objval("pwdAdminActivityLog", "os"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="browser" class="col-sm-2 control-label">Browser</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <input type="text" name="browser" class="form-control input-sm" id="browser" placeholder="Browser" value="<?php echo $this->objval("pwdAdminActivityLog", "browser"); ?>">
                                </div>
                            </div>
                            <?php echo $this->csrfToken(); ?>

                            <!--
                            <div class="box-footer">
                                <a href="<?/*= BASE_URL . PANEL; */?>/pwd/activitylogs" class="btn btn-default btn-sm"><i class="fa fa-close" aria-hidden="true"></i> Close</a>
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                            </div>
                            -->
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
                                                <option value="<?= $k; ?>" <?= ($k === $this->objval('pwdAdminActivityLog', 'status')) ? 'selected' : ''; ?>><?= $status; ?></option>
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