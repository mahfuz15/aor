<?php
$agents = $this->agents;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-list" aria-hidden="true"></i> Agents
            <small>Manage Agent</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= BASE_URL . PANEL; ?>/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li> Agents</li>
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
                                        <input type="text" id="query" name="q" value="<?php echo $this->request->getUrlData('q'); ?>" class="form-control pull-right" placeholder="Search Agents" />
                                               <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                                            <a href="<?php echo BASE_URL . PANEL; ?>/agents/" class="btn btn-default btn-sm"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3 col-sm-4 pull-right">
                                    <a href="<?= BASE_URL . PANEL; ?>/agent/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Agent</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Created_by</th>
                                    <th class="text-center">Created_at</th>
                                    <th class="text-center">Updated_at</th>
                                    <th class="text-center">Last_log</th>
                                    <th class="text-center">action</th>
                                </tr>
                                <?php
                                $sl = $this->pagination->getOffSet() + 1;
                                if (!empty($this->values["agents"])):
                                    foreach ($agents as $agent):
                                    ?>
                                    <tr>
                                        <td><span><?php echo $sl++; ?></span></td>
                                        <td class="text-center"><a href="admin/agent/edit/<?php echo $agent->id; ?>"><?php echo $agent->email; ?></a></td>
                                        <td class="text-center"><?php echo $agent->username; ?></td>
                                        <td class="text-center"><?php echo $this->statusIcon($agent->status); ?></td>
                                        <td class="text-center"><?php echo $agent->created_by; ?></td>
                                        <td class="text-center"><?php echo $agent->created_at; ?></td>
                                        <td class="text-center"><?php echo $agent->updated_at; ?></td>
                                        <td class="text-center"><?php echo $agent->last_log; ?></td>
											
                                        <td class="text-center"><a class="popup" href="<?= BASE_URL . PANEL; ?>/agent/delete/<?php echo $agent->id; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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
