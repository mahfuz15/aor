<?php
$modules = $this->modules;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-cubes" aria-hidden="true"></i> Modules
            <small>Master Maintenance</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?= BASE_URL . PANEL; ?>/">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li> Modules</li>
        </ol>
    </section>
    <section class="content pt-0">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default no-border" id="filter">
                    <div class="box-header">
                        <div class="row text-right">
                            <form class="form-inline">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="query" name="q" value="<?php echo $this->request->getUrlData('q'); ?>" class="form-control pull-right search-field" placeholder="Search Modules" />
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i> Filter
                                            </button>
                                            <a href="<?php echo BASE_URL . PANEL; ?>/modules/" class="btn btn-default btn-sm">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3 col-sm-4 pull-right">
                                    <a href="<?= BASE_URL . PANEL; ?>/module/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Module</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped table-hover">
                            <tbody>
                            <tr>
                                <th>SL</th>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Route</th>
                                <th>Alias</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            <?php
                            $sl = $this->pagination->getOffSet() + 1;
                            if (!empty($this->values["modules"])):
                                foreach ($modules as $module):
                                    $link = BASE_URL . PANEL.'/module/edit/'. $module->id;
                                    ?>
                                    <tr>
                                        <td><span><?php echo $sl++; ?></span></td>
                                        <td><?php echo $module->id; ?></td>
                                        <td>
                                            <a href="<?= $link; ?>">
                                                <?php echo $module->title; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?= $link; ?>">
                                                <?php echo $module->route; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?= $link; ?>">
                                                <?php echo $module->alias; ?>
                                            </a>
                                        </td>
                                        <td class="text-center"><?php echo $this->statusIcon($module->status); ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-info btn-xs color-white" href="<?= $link; ?>">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </a>
                                            <a class="popup btn btn-danger btn-xs color-white" href="<?= BASE_URL . PANEL; ?>/module/delete/<?php echo $module->id; ?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </td>
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
