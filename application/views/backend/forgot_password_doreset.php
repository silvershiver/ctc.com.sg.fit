<?php error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTCFITApp - Reset Password</title>
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<!-- Core JS files -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/drilldown.js"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<!-- /theme JS files -->
</head>
<body>
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo base_url(); ?>backend">
				Welcome to CTCFITApp Control Panel
			</a>
			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>
		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="<?php echo base_url(); ?>">
						Back to front-end site
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="page-container login-container">
		<div class="page-content">
			<div class="content-wrapper">
<?php
if( $hidden_email_encrypt == TRUE ) {
	$email_decrypt = base64_decode(base64_decode(base64_decode($hidden_email_encrypt)));
	$check_email   = $this->All->select_template_w_2_conditions("email_address", $email_decrypt, "is_fp_request", "1", "user_access");
}
else {
	$email_decrypt = base64_decode(base64_decode(base64_decode($this->uri->segment(4))));
	$check_email   = $this->All->select_template_w_2_conditions("email_address", $email_decrypt, "is_fp_request", "1", "user_access"); 
}
if( $check_email == TRUE ) {
?>
<?php echo form_open_multipart('backend/forgot_password/do_reset_password', array('class' => 'form-horizontal')); ?>
	<input type="hidden" name="hidden_email_encrypt" value="<?php echo $this->uri->segment(4); ?>" />
	<input type="hidden" name="hidden_email_address" value="<?php echo $email_decrypt; ?>" />
	<div class="panel panel-body login-form">
		<div class="text-center">
			<h5 class="content-group">
				Reset your password <small class="display-block">Please fill the form below</small>
			</h5>
		</div>
		<div class="form-group has-feedback">
			<input type="password" name="new_password" class="form-control" placeholder="New password" />
			<div class="form-control-feedback">
				<i class="icon-lock2 text-muted"></i>
			</div>
			<?php echo form_error("new_password"); ?>
		</div>
		<div class="form-group has-feedback">
			<input type="password" name="confirm_new_password" class="form-control" placeholder="Confirm new password" />
			<div class="form-control-feedback">
				<i class="icon-lock2 text-muted"></i>
			</div>
			<?php echo form_error("confirm_new_password"); ?>
		</div>
		<button type="submit" class="btn bg-blue btn-block">
			Reset password <i class="icon-arrow-right14 position-right"></i>
		</button>
	</div>
<?php echo form_close(); ?>
<?php
}
else {
?>
	<div class="panel panel-body login-form">
		<div class="text-center">
			<h5 class="content-group">
				Reset your password 
				<small class="display-block" style="color:red">This request request has been expired.</small>
			</h5>
		</div>
	</div>
<?php
}
?>
			</div>
		</div>
		<!-- Footer -->
		<div class="footer text-muted">
			Copyright &copy; 2015. <a href="#">IoTStream</a>
		</div>
		<!-- /footer -->
	</div>
	<!-- /page container -->

</body>
</html>