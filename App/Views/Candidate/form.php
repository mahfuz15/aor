<?php
$candidate = $this->candidate;

$job_statuses = [0 => 'Pending', 1 => 'Hunting', 2 => 'Working'];
$statuses = [1 => 'Active', 0 => 'Disabled'];

?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php
            if (isset($candidate->id)) {
            echo '<i class="fa fa-list" aria-hidden="true"></i> ' . $candidate->title;
            } else {
            echo '<i class="fa fa-list" aria-hidden="true"></i> New Candidate';
            }
            ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= BASE_URL . PANEL; ?>/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= BASE_URL . PANEL; ?>/candidates/" class="active"> Candidate </a></li>
            <li> <?php echo isset($candidate->id) ? 'Edit' : 'Add'; ?> Candidate</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <form class="form-horizontal" method="post" id="CandidateForm" name="candidateForm" enctype="multipart/form-data">
                <div class="col-md-8 col-xs-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Update Candidate</h3>
                        </div>
                        <div class="box-body">
                            		    <div class="form-group">
				<label for="title" class="col-sm-2 control-label">Title</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="title" class="form-control input-sm" id="title" placeholder="Title" value="<?php echo $this->objval("candidate", "title"); ?>">
				</div>
			    </div>
            		    <div class="form-group">
				<label for="skills" class="col-sm-2 control-label">Skills</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="skills" class="form-control input-sm" id="skillTag" data-role="tagsinput" placeholder="Skills" value="<?php echo $this->objval("candidate", "skills"); ?>">
                </div>
			    </div>
            		    <div class="form-group">
				<label for="description" class="col-sm-2 control-label">Description</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <textarea name="description" rows="10" class="form-control" id="description"><?php echo $this->objval("candidate", "description"); ?></textarea>
				</div>
			    </div>
                        <div class="form-group">
				<label for="resume" class="col-sm-2 control-label">Resume</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="file" name="resume" id="resume">
				</div>
			    </div>
                    <div class="form-group">
				<label for="candidate_name" class="col-sm-2 control-label">Candidate Name</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="candidate_name" class="form-control input-sm" id="candidate_name" placeholder="Candidate Name" value="<?php echo $this->objval("candidate", "candidate_name"); ?>">
				</div>
			    </div>
						<div class="form-group">
				<label for="candidate_email" class="col-sm-2 control-label">Candidate Email</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="email" name="candidate_email" class="form-control input-sm" id="candidate_email" placeholder="Candidate Email" value="<?php echo $this->objval("candidate", "candidate_email"); ?>">
				</div>
			    </div>
                    <div class="form-group">
				<label for="candidate_phone" class="col-sm-2 control-label">Candidate Phone</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <input type="text" name="candidate_phone" class="form-control input-sm" id="candidate_phone" placeholder="Candidate_phone" value="<?php echo $this->objval("candidate", "candidate_phone"); ?>">
				</div>
			    </div>
            		    <div class="form-group">
				<label for="location" class="col-sm-2 control-label">Location</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <!-- <input type="text" name="location" class="form-control input-sm" id="location" placeholder="Location" value="<?php echo $this->objval("candidate", "location"); ?>"> -->
                    <select name="geo_location" class="form-control countries order-alpha" id="countryId">
                        <option value="">Select Country</option>
                    </select>
                    <?php if($this->objval("candidate", "location") != '') { ?>
                        <p id="locationVal"></p>
                    <?php } ?>
                </div>
			    </div>
            		    <div class="form-group">
				<label for="state" class="col-sm-2 control-label">State</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <!-- <input type="text" name="state" class="form-control input-sm" id="state" placeholder="State" value="<?php echo $this->objval("candidate", "state"); ?>"> -->
                    <select name="geo_state" class="form-control states order-alpha" id="stateId">
                        <option value="">Select State</option>
                    </select>
                    <?php if($this->objval("candidate", "state") != '') { ?>
                        <p id="stateVal"></p>
                    <?php } ?>
                </div>
			    </div>
            		    <div class="form-group">
				<label for="city" class="col-sm-2 control-label">City</label>
				<div class="col-sm-10 col-xs-12 validationHolder">
				    <!-- <input type="text" name="city" class="form-control input-sm" id="city" placeholder="City" value="<?php echo $this->objval("candidate", "city"); ?>"> -->
                    <select name="geo_city" class="form-control cities order-alpha" id="cityId">
                        <option value="">Select City</option>
                    </select>
                    <?php if($this->objval("candidate", "city") != '') { ?>
                        <p id="cityVal"></p>
                    <?php } ?>
                </div>
			    </div>
                            <input type="hidden" name="resume_link" id="resume_link" value="<?php echo $this->objval("candidate", "resume_link"); ?>">
                            <input type="hidden" name="location" id="location" value="<?php echo $this->objval("candidate", "location"); ?>">
                            <input type="hidden" name="state" id="state" value="<?php echo $this->objval("candidate", "state"); ?>">
                            <input type="hidden" name="city" id="city" value="<?php echo $this->objval("candidate", "city"); ?>">
                            <!-- <input type="hidden" name="unavailableSkills" id="unavailableSkills" value=""> -->
                            <?php echo $this->csrfToken(); ?>

                            <div class="box-footer">
                                <a href="<?= BASE_URL . PANEL; ?>/candidates/" class="btn btn-default btn-sm"><i class="fa fa-close" aria-hidden="true"></i> Close</a>
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
                                <label for="job_status" class="col-sm-2 control-label">Job Status</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <select name="job_status" class="form-control">
                                        <?php
                                        if (!empty($job_statuses)):
                                            foreach ($job_statuses as $k => $status):
                                            ?>
                                            <option value="<?= $k; ?>" <?= ($k === $this->objval('candidate', 'job_status')) ? 'selected' : ''; ?>><?= $status; ?></option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10 col-xs-12 validationHolder">
                                    <select name="status" class="form-control">
                                        <?php
                                        if (!empty($statuses)):
                                            foreach ($statuses as $k => $status):
                                            ?>
                                            <option value="<?= $k; ?>" <?= ($k === $this->objval('candidate', 'status')) ? 'selected' : ''; ?>><?= $status; ?></option>
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