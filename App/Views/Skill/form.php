<?php
$skill = $this->skill;

$statuses = [1 => 'Active', 0 => 'Disabled'];
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php
            if (isset($skill->id)) {
            echo '<i class="fa fa-list" aria-hidden="true"></i> ' . $skill->name;
            } else {
            echo '<i class="fa fa-list" aria-hidden="true"></i> New Skill';
            }
            ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= BASE_URL . PANEL; ?>/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= BASE_URL . PANEL; ?>/skills/" class="active"> Skill </a></li>
            <li> <?php echo isset($skill->id) ? 'Edit' : 'Add'; ?> Skill</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <form class="form-horizontal" method="post" id="SkillForm" name="skillForm" enctype="multipart/form-data">
                <div class="col-md-8 col-xs-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Update Skill</h3>
                        </div>
                        <div class="box-body">
                            		    <div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="name" class="form-control input-sm" id="name" placeholder="Name" value="<?php echo $this->objval("skill", "name"); ?>">
				</div>
			    </div>
                            <?php echo $this->csrfToken(); ?>

                            <div class="box-footer">
                                <a href="<?= BASE_URL . PANEL; ?>/skills/" class="btn btn-default btn-sm"><i class="fa fa-close" aria-hidden="true"></i> Close</a>
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
                                            <option value="<?= $k; ?>" <?= ($k === $this->objval('skill', 'status')) ? 'selected' : ''; ?>><?= $status; ?></option>
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