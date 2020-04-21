<?php
$errors = $this->val('errorLines');
$lineLimit = (!empty($_GET['line'])) ? $this->request->getUrlData("line") : 20 ;
$totalLine = $this->val('totalLine');
$lineNumber = !empty($errors) ? ($totalLine - (count($errors) - 1)) : 0;

//pr($this->values);die;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Errors
        </h1>
        <ol class="breadcrumb hidden-sm hidden-xs">
            <li><a href="admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li> Errors</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning" id="filter">
                    <div class="box-header">
                        <div class="row">
                            <form class="form-inline">
                                <div class="col-lg-2 col-md-3 col-sm-3">
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="line" value="<?php echo $lineLimit; ?>" class="form-control pull-right" />
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                                            <a href="<?php echo BASE_URL; ?>admin/errors/" type="button" class="btn btn-default btn-sm"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!empty($errors)) { ?>
                                    <div class="col-lg-10 col-md-9 col-sm-9 text-right">
                                        <a href="admin/error/clear" class="btn btn-danger"><i class="fa fa-trash-o"></i> Clear Error Log</a>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <?php
                                if (!empty($errors)) { ?>
                                <tr>
                                    <th>LN</th>
                                    <th>Error</th>
                                    <th>File</th>
                                    <th class="text-center">Line</th>
                                    <th class="text-center">Date Time</th>
                                </tr>
                                    <?php
                                    
                                    foreach (array_filter($errors) as $error)
                                    {
                                        //pr($error);
                                        preg_match('#(?P<datetime>[\d]{4}-[\d]{2}-[\d]{2}\s[\d]{2}:[\d]{2}:[\d]{2})\s?\#\s?(?P<message>[\S\s]*?)Thrown in(?P<file>[\S\s]*?)on line\s?(?P<line>[\d]*?)\s#', $error, $parts);
                                        //pr($parts);
                                        if (!empty($parts)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $lineNumber; ?></td>
                                                <td><?php echo $parts['message']; ?></td>
                                                <td><?php echo $parts['file']; ?></td>
                                                <td class="text-center"><?php echo $parts['line']; ?></td>
                                                <td class="text-center"><?php echo $parts['datetime']; ?> (<span class="text-red">-<?php echo vanilaTime(strtotime($parts['datetime'])) ?></span>)</td>
                                            </tr>
                                        <?php } else {
                                            ?>
                                            <tr>
                                                <td class="text-center text-bold text-red text-uppercase">
                                                    Error Message parse failed !<br> please use shell to monitor error log
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        $lineNumber++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td class="text-center text-bold text-green text-uppercase">
                                            Hoorray !!!<br> There are no more errors on our site ! No mercy for bugs.
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>