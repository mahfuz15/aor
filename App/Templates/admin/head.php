<?php
$userPreference = $this->userPreference();

$theme = $userPreference->theme_name ?? 'black';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo BASE_URL; ?>">

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Administration Panel - <?php echo SITE; ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="images/branding/favicon.ico" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/favicon.ico" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/favicon.ico" />
        <link rel="apple-touch-icon-precomposed" href="images/favicon.ico" />

<!--        <link href="<?php echo ASSETS; ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
        <script src="<?php echo ASSETS; ?>vendor/ckeditor/ckeditor.js"></script>

        <link rel="stylesheet" href="<?php echo ASSETS; ?>vendor/select2/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo ASSETS; ?>lte-admin/css/AdminLTE.css">
        <link rel="stylesheet" href="<?php echo ASSETS; ?>lte-admin/css/skins/skin-black.min.css">
       <!-- <link rel="stylesheet" href="<?php /*echo ASSETS; */?>lte-admin/css/skins/skin-<?php /*echo $theme; */?>.min.css">-->
<!--        <link rel="stylesheet" href="<?php echo ASSETS; ?>vendor/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="<?php echo ASSETS; ?>vendor/daterangepicker/daterangepicker-bs3.css">-->
        <link href="<?php echo ASSETS; ?>lte-admin/css/admin.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>lte-admin/css/custom.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>lte-admin/css/custom.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>css/custom.css" rel="stylesheet">

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo ASSETS; ?>vendor/jquery/jquery.js"></script>
<!--        <script src="<?php echo ASSETS; ?>vendor/bootstrap/dependency/popper.min.js"></script>
        <script src="<?php echo ASSETS; ?>vendor/bootstrap/js/bootstrap.min.js"></script>-->

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>

<!--        <script src="<?php echo ASSETS; ?>vendor/datetime/moment-with-locales.js"></script>
        <script src="<?php echo ASSETS; ?>vendor/datetime/bootstrap-datetimepicker.js"></script>
        <script src="<?php echo ASSETS; ?>vendor/daterangepicker/daterangepicker.js"></script>
        <script src="<?php echo ASSETS; ?>vendor/daterangepicker/moment.js"></script>-->

        <script>
            var BASE_URL = '<?php echo BASE_URL; ?>';
        </script>
    </head>
    <body id="collapseSideBar" class="<?php
    if ($this->isLoggedIn('admin') || !isset($format)) {
        echo 'hold-transition skin-' . $theme . ' sidebar-mini sidebar-collapse'; // sidebar-mini sidebar-collapse
    } else {
        echo 'hold-transition login-page';
    }
    ?>">
        <?php
        //pr($this);
        //echo $theme; ?>