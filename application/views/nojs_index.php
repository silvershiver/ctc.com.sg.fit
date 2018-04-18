<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>CTC Travel | <?php echo $title;?></title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css" media="screen,projection,print" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>assets/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>assets/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/favicons/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <style>
    body {background: #FFFFFF;}
    .nojs{
       margin:100px 0; background: #cccccc;
       padding-top:50px;
       color: #FF0000;
       font-size: 14px;
    }
    </style>
</head>
<body>
    <header>
        <div class="wrap clearfix">
            <h1 class="logo">
                <a href="<?php echo base_url(); ?>">
                    <img src="<?php echo base_url(); ?>/assets/images/ctcfitapplogo.png" style="margin-top:-5px; margin-bottom:5px;
    " height="70">
                </a>
            </h1>
            <!--contact-->
            <div class="contact">
                <span>Customer Hotline</span>
                <span class="number">+65 6216-3456</span>
            </div>
            <!--//contact-->
        </div>
</header>
<!--//header-->
    <div class="nojs" style="text-align: center">
        <h3>Oh no. Your javascript is disabled.</h3><br>
        <h4>You must enable javascript to use this site and for best experiences</h4>
    </div>
    <?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
</body>
</html>