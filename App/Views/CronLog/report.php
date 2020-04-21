<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-reply-all" aria-hidden="true"></i> CronJob Report
        </h1>
        <ol class="breadcrumb">
            <li><a href="admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>CronJobs</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- LINE CHART -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <i class="fa fa-stack-exchange"></i>
                        <h3 class="box-title">CronJobs <small>last 30 days</small></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-4">
                            <table class="table table-striped">
                                <tr>
                                    <td>Total Crons</td>
                                    <td><?= $this->totalCron ?? 0; ?></td>
                                </tr>
                                <tr>
                                    <td>Imap Calls</td>
                                    <td><?= $this->imapCron ?? 0; ?></td>
                                </tr>
                                <tr>
                                    <td>Smtp Calls</td>
                                    <td><?= $this->smtpCron ?? 0; ?></td>
                                </tr>
                                <tr>
                                    <td>Idle Crons</td>
                                    <td><?= $this->idleCron ?? 0; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-4">
                            <table class="table table-striped">
                                <tr>
                                    <td>Avg Seconds/Cron</td>
                                    <td><?= round($this->avgSpentTime ?? 0, 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Avg Seconds/Imap</td>
                                    <td><?= round($this->avgImapTime ?? 0, 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Avg Seconds/Smtp</td>
                                    <td><?= round($this->avgSmtpTime ?? 0, 2); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-4">
                            <table class="table table-striped">
                                <tr>
                                    <td>Mail Read/Cron</td>
                                    <td><?=  (int) $this->avgMailReceived ?? 0; ?></td>
                                </tr>
                                <tr>
                                    <td>Mail Sent/Cron</td>
                                    <td><?=  (int) $this->avgMailSent ?? 0; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>
