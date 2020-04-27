<?php
$candidates = $this->candidates;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-list" aria-hidden="true"></i> Candidates
            <small>Manage Candidate</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= BASE_URL . PANEL; ?>/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li> Candidates</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning" id="filter">
                    <div class="box-header">
                        <div class="row text-right">
                            <form class="form-inline">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="query" name="q" value="<?php echo $this->request->getUrlData('q'); ?>" class="form-control pull-right" placeholder="Search Candidates" />
                                               <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                                            <a href="<?php echo BASE_URL . PANEL; ?>/candidates/" class="btn btn-default btn-sm"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3 col-sm-4 pull-right">
                                    <a href="<?= BASE_URL . PANEL; ?>/candidate/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Candidate</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <!-- <th class="text-center">Id</th> -->
<th class="text-center">Title</th>
<th class="text-center">Skills</th>
<!-- <th class="text-center">Description</th> -->
<th class="text-center">Resume_link</th>
<th class="text-center">Location</th>
<th class="text-center">State</th>
<th class="text-center">City</th>
<th class="text-center">Candidate Name</th>
<th class="text-center">Candidate Email</th>
<th class="text-center">Candidate Phone</th>
<th class="text-center">Job Status</th>
<th class="text-center">Status</th>
<th class="text-center">Joined_by</th>
<th class="text-center">Joined_at</th>
<th class="text-center">Updated_at</th>
                                    <th class="text-center">action</th>
                                </tr>
                                <?php
                                $sl = $this->pagination->getOffSet() + 1;
                                if (!empty($this->values["candidates"])):
                                    foreach ($candidates as $candidate):
                                    ?>
                                    <tr>
                                        <td><span><?php echo $sl++; ?></span></td>
                                        <!-- <td class="text-center"><?php echo $candidate->id; ?></td> -->
											<td class="text-center"><a href="<?= (BASE_URL . PANEL.'/candidate/edit/'. $candidate->id); ?>"><?php echo $candidate->title; ?></a></td>
											<td class="text-center"><?php echo $candidate->skills; ?></td>
											<!-- <td class="text-center"><?php echo $candidate->description; ?></td> -->
											<td class="text-center"><?php echo $candidate->resume_link; ?></td>
											<td class="text-center"><?php echo $candidate->location; ?></td>
											<td class="text-center"><?php echo $candidate->state; ?></td>
											<td class="text-center"><?php echo $candidate->city; ?></td>
											<td class="text-center"><?php echo $candidate->candidate_name; ?></td>
                                            <td class="text-center"><?php echo $candidate->candidate_email; ?></td>
                                            <td class="text-center"><?php echo $candidate->candidate_phone; ?></td>
											<td class="text-center"><?php echo $candidate->job_status; ?></td>
                                            <td class="text-center"><?php echo $this->statusIcon($candidate->status); ?></td>
											<td class="text-center"><?php echo $candidate->joined_by; ?></td>
											<td class="text-center"><?php echo $candidate->joined_at; ?></td>
											<td class="text-center"><?php echo $candidate->updated_at; ?></td>
											
                                        <td class="text-center"><a class="popup" href="<?= BASE_URL . PANEL; ?>/candidate/delete/<?php echo $candidate->id; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                    </tr>
                                    <?php
                                    endforeach;
                                endif;
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
