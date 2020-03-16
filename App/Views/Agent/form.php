<?php
$agent = $this->agent;

$statuses = [1 => 'Active', 0 => 'Disabled'];
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php
            if (isset($agent->id)) {
            //echo '<i class="fa fa-list" aria-hidden="true"></i> ' . $agent->title;
            echo '<i class="fa fa-list" aria-hidden="true"></i> ';
            } else {
            echo '<i class="fa fa-list" aria-hidden="true"></i> New Agent';
            }
            ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= BASE_URL . PANEL; ?>/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= BASE_URL . PANEL; ?>/agents/" class="active"> Agent </a></li>
            <li> <?php echo isset($agent->id) ? 'Edit' : 'Add'; ?> Agent</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <form class="form-horizontal" method="post" id="AgentForm" name="agentForm" enctype="multipart/form-data">
                <div class="col-md-8 col-xs-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Update Agent</h3>
                        </div>
                        <div class="box-body">
                            		    <!-- <div class="form-group">
				<label for="username" class="col-sm-2 control-label">Username</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="username" class="form-control input-sm" id="username" placeholder="Username" value="<?php echo $this->objval("agent", "username"); ?>">
				</div>
			    </div> -->
            		    <div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="email" class="form-control input-sm" id="email" placeholder="Email" value="<?php echo $this->objval("agent", "email"); ?>">
				</div>
			    </div>
            		    <!-- <div class="form-group">
				<label for="password" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="password" class="form-control input-sm" id="password" placeholder="Password" value="<?php echo $this->objval("agent", "password"); ?>">
				</div>
			    </div>
            		    <div class="form-group">
				<label for="role_id" class="col-sm-2 control-label">Role_id</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="role_id" class="form-control input-sm" id="role_id" placeholder="Role_id" value="<?php echo $this->objval("agent", "role_id"); ?>">
				</div>
			    </div>
            		    <div class="form-group">
				<label for="created_by" class="col-sm-2 control-label">Created_by</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="created_by" class="form-control input-sm" id="created_by" placeholder="Created_by" value="<?php echo $this->objval("agent", "created_by"); ?>">
				</div>
			    </div>
            		    <div class="form-group">
				<label for="created_at" class="col-sm-2 control-label">Created_at</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="created_at" class="form-control input-sm" id="created_at" placeholder="Created_at" value="<?php echo $this->objval("agent", "created_at"); ?>">
				</div>
			    </div>
            		    <div class="form-group">
				<label for="updated_at" class="col-sm-2 control-label">Updated_at</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="updated_at" class="form-control input-sm" id="updated_at" placeholder="Updated_at" value="<?php echo $this->objval("agent", "updated_at"); ?>">
				</div>
			    </div>
            		    <div class="form-group">
				<label for="last_log" class="col-sm-2 control-label">Last_log</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="last_log" class="form-control input-sm" id="last_log" placeholder="Last_log" value="<?php echo $this->objval("agent", "last_log"); ?>">
				</div>
			    </div>
            		    <div class="form-group">
				<label for="session_id" class="col-sm-2 control-label">Session_id</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="session_id" class="form-control input-sm" id="session_id" placeholder="Session_id" value="<?php echo $this->objval("agent", "session_id"); ?>">
				</div>
			    </div> -->
                            <?php echo $this->csrfToken(); ?>

                            <div class="box-footer">
                                <a href="<?= BASE_URL . PANEL; ?>/agents/" class="btn btn-default btn-sm"><i class="fa fa-close" aria-hidden="true"></i> Close</a>
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>	
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
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
                                            <option value="<?= $k; ?>" <?= ($k === $this->objval('agent', 'status')) ? 'selected' : ''; ?>><?= $status; ?></option>
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