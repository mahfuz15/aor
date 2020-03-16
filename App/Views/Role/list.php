<?php
$roles = $this->roles;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-unlock" aria-hidden="true"></i> Roles
            <small>Master Maintenance</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= BASE_URL . PANEL; ?>/">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li> Roles</li>
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
                                        <input type="text" id="query" name="q" value="<?php echo $this->request->getUrlData('q'); ?>" class="form-control pull-right search-field" placeholder="Search Roles title"/>
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i>Filter
                                            </button>
                                            <a href="<?php echo BASE_URL . PANEL; ?>/<?= strtolower(SITE) ?>/roles/" class="btn btn-default btn-sm">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3 col-sm-4 pull-right">
                                    <a href="<?= BASE_URL . PANEL; ?>/<?= strtolower(SITE) ?>/role/add" class="btn btn-success btn-sm">
                                        <i class="fa fa-plus"></i> Add Role
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped table-hover">
                            <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            <?php
                            $sl = $this->pagination->getOffSet() + 1;
                            if (!empty($this->values["roles"])):
                                foreach ($roles as $role):
                                    $link = BASE_URL . PANEL . '/'.strtolower(SITE).'/role/edit/' . $role->id;
                                    ?>
                                    <tr>
                                        <td>
                                            <span><?php echo $sl++; ?></span>
                                        </td>
                                        <td>
                                            <a href="<?= $link; ?>">
                                                <?php echo $role->title; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?= $link; ?>">
                                                <?php echo $role->description; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $this->statusIcon($role->status); ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-info btn-xs color-white" href="<?= $link; ?>">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </a>
                                            <a class="popup btn btn-danger btn-xs color-white" href="<?= BASE_URL . PANEL; ?>/<?= strtolower(SITE)?>/role/delete/<?php echo $role->id; ?>">
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
