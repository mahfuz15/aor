<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL; ?>">
                <img src="images/logo.png" class="img-fluid" style="max-height: 42px;" />
            </a>
            <a class="navbar-brand-scrolled" href="<?= BASE_URL; ?>">
                <img src="images/logo-dark.png" class="img-fluid" style="max-height: 28px;" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a href="<?= BASE_URL; ?>" class="nav-link">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL; ?>features/" class="nav-link">
                            Features
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL; ?>pricing/" class="nav-link">
                            Pricing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL; ?>faqs/" class="nav-link">
                            FAQs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL; ?>contact/" class="nav-link">
                            Contact
                        </a>
                    </li>
                    <li class="nav-item cta">
                        <a href="<?= BASE_URL; ?>login/" class="nav-link">
                            <span>Login</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
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