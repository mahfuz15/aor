<body>
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Brand</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item active">
                <a href="<?= BASE_URL; ?>" class="nav-link">
                    Home
                </a>
            </li>
            <?php if(!$this->isLoggedIn('agent')) { ?>
            <li class="nav-item">
                <a href="<?= BASE_URL; ?>agent/login/" class="nav-link">
                    <span>Login</span>
                </a>
            </li>
            <?php } else { ?>
            <li class="nav-item">
                <a href="<?= BASE_URL; ?>agent/candidates/" class="nav-link">
                    <span>My Candidate</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= BASE_URL; ?>agent/logout/" class="nav-link">
                    <span>Logout</span>
                </a>
            </li>
            <?php } ?>
        </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
        
    </nav>

    <?php
    $notifications = $this->message();
    //pr($notifications);
    if (!empty($notifications)) {
        //echo $this->showNotification($notifications);
        ?>
        <input type="hidden" id="notification_message_object" value='<?= json_encode($notifications); ?>' data-notify-delay="100" data-notify-position="top-center">
        <?php
    }
    ?>
    <!-- <div class="container"> -->