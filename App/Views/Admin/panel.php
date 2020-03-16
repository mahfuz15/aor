<?php
// $product = $this->total_product;
// $total_language = $this->total_language;
// $total_item_spec= $this->total_item_spec;
// $total_re_option = $this->total_re_option;

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small><?= SITE; ?> Dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL . PANEL; ?>/" class="active"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3>Dashboard content</h3>
                </div>
            </div>
        </div>
    </section>
</div>
<script id="dataTemplate" type="text/x-jQuery-tmpl">
    <tr>
    <td>${sl}</td>
    {{if subject}}
    <td>${subject}</td>
    {{/if}}
    <td>${mail_from}</td>
    {{if received_time}}
    <td class="text-right"><span class="label label-primary">${received_time}</span></td>
    {{/if}}
    </tr>
</script>

<script id="subscriberTemplate" type="text/x-jQuery-tmpl">
    <tr>
    <td>${sl}</td>
    <td>${sender_name}</td>
    <td class="text-right"><span class="label label-primary">${subscribed_time}</span></td>
    </tr>
</script>
<script src="<?php echo ASSETS; ?>lte-admin/js/jquery.tmpl.js"></script>
<script src="<?php echo ASSETS; ?>lte-admin/js/dashboard.js"></script>