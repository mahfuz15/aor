<?php
$pwdAdminActivityLog = $this->pwdAdminActivityLog;
$languages = $this->languages;


?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-list" aria-hidden="true"></i> PwdAdminActivityLogs
            <small>Manage Pwd Admin Activity Logs</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= BASE_URL . PANEL; ?>/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li> PwdAdminActivityLog</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default no-border" id="filter">
                    <div class="box-header">
                        <div class="row text-right">
                            <form class="form-inline">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="query" name="q" value="<?php echo $this->request->getUrlData('q'); ?>" class="form-control pull-right search-field" placeholder="Search PwdAdminActivityLog" />
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                                            <a href="<?php echo BASE_URL . PANEL; ?>/pwd/activitylogs/" class="btn btn-default btn-sm"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped table-hover">
                            <tbody>
                            <tr>
                                <th>SL</th>
                                <th class="text-center">Weak</th>
                                <th class="text-center" width="20%">Date & Time</th>
                                <th class="text-center"width="20%">admin ID & IP</th>
                                <th class="text-center">Path</th>
                                <th class="text-center">Search</th>
                                <th class="text-center">Ref</th>
                                <th class="text-center">Language</th>
                                <th class="text-center">ProductID</th>
                                <th class="text-center">File</th>
                                <th class="text-center">Os</th>
                                <th class="text-center">Browser</th>
                            </tr>
                            <?php
                            $sl = $this->pagination->getOffSet() + 1;
                            if (!empty($this->values["pwdAdminActivityLog"])):
                                foreach ($pwdAdminActivityLog as $activityLog):
                                    ?>
                                    <tr>
                                        <td>
                                            <span>
                                                <a href="<?= BASE_URL . PANEL.'/pwd/activitylog/'. $activityLog->id; ?>" style="color: red">
                                                    <i class="fa fa-edit" aria-hidden="true"></i> <?php echo $sl++; ?>
                                                </a>
                                            </span>
                                        </td>
                                        <td class="text-center"><?php echo $activityLog->week_of_year; ?></td>
                                        <td class="text-center" width="30%"><?php echo $activityLog->date; ?><br>
                                            <?php echo $activityLog->time; ?>
                                        </td>
                                        <td class="text-center"width="30%"><?php echo "Admin ID:". $activityLog->admin_id; ?><br>
                                            <?php echo "IP:". $activityLog->ip; ?>
                                        </td>
                                        <td class="text-center"><?php echo $activityLog->path; ?></td>
                                        <td class="text-center"><?php echo $activityLog->search; ?></td>
                                        <td class="text-center"><?php echo $activityLog->ref; ?></td>
                                        <td class="text-center"><?php echo $languages[$activityLog->language_id]; ?></td>
                                        <td class="text-center"><?php echo $activityLog->product_id; ?></td>
                                        <td class="text-center"><?php echo $activityLog->file; ?></td>
                                        <td class="text-center"><?php echo $activityLog->os; ?></td>
                                        <td class="text-center"><?php echo $activityLog->browser; ?></td>
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
