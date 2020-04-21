<?php
$skills = $this->skills;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-list" aria-hidden="true"></i> Skills
            <small>Manage Skill</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= BASE_URL . PANEL; ?>/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li> Skills</li>
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
                                        <input type="text" id="query" name="q" value="<?php echo $this->request->getUrlData('q'); ?>" class="form-control pull-right" placeholder="Search Skills" />
                                               <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                                            <a href="<?php echo BASE_URL . PANEL; ?>/skills/" class="btn btn-default btn-sm"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3 col-sm-4 pull-right">
                                    <a href="<?= BASE_URL . PANEL; ?>/skill/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Skill</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th>SL</th>
<th class="text-center">Name</th>
<th class="text-center">Status</th>
                                    <th class="text-center">action</th>
                                </tr>
                                <?php
                                $sl = $this->pagination->getOffSet() + 1;
                                if (!empty($this->values["skills"])):
                                    foreach ($skills as $skill):
                                    ?>
                                    <tr>
                                        <td><span><?php echo $sl++; ?></span></td>
											<td class="text-center"><a href="<?= (BASE_URL . PANEL.'/skill/edit/'. $skill->id); ?>"><?php echo $skill->name; ?></a></td>
											<td class="text-center"><?php echo $this->statusIcon($skill->status); ?></td>
											
                                        <td class="text-center"><a class="popup" href="<?= BASE_URL . PANEL; ?>/skill/delete/<?php echo $skill->id; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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
