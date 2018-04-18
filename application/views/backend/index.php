<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Welcome to CTC FIT App Control Panel</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/drilldown.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/login.js"></script>
</head>
<body class="pace-done">
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo base_url(); ?>backend">
				Welcome to CTC Travel Control Panel
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
<?php echo form_open_multipart('backend/login/progress', array('class' => 'form-horizontal')); ?>
	<div class="panel panel-body login-form">
		<div class="text-center">
			<div class="border-warning-400 text-warning-400">
				<img src="<?php echo base_url(); ?>assets/images/ctcfitapplogo.png" style="width:250px; height:60px; margin-top:-6px" />
			</div>
			<h5 class="content-group-lg">
				<small class="display-block">Enter your credentials</small>
			</h5>
			<?php echo $this->session->flashdata('wrong_login_process'); ?>
			<?php echo $this->session->flashdata('reset_password_success'); ?>
		</div>
		<div class="form-group has-feedback has-feedback-left">
			<input type="text" name="email_login" class="form-control" placeholder="Enter email address" value="<?php echo $this->session->userdata('io_email_ctcfitapp'); ?>" />
			<div class="form-control-feedback">
				<i class="icon-user text-muted"></i>
			</div>
			<?php echo form_error("email_login"); ?>
		</div>
		<div class="form-group has-feedback has-feedback-left">
			<input type="password" name="password_login" class="form-control" placeholder="Enter password" value="<?php echo $this->session->userdata('io_password_ctcfitapp'); ?>" />
			<div class="form-control-feedback">
				<i class="icon-lock2 text-muted"></i>
			</div>
			<?php echo form_error("password_login"); ?>
		</div>
		<div class="form-group login-options">
			<div class="row">
				<div class="col-sm-6" style="margin-top: -23px">
					<label class="checkbox-inline">
<?php
if( $this->session->userdata('rm_email_ctcfitapp') == TRUE && $this->session->userdata('rm_password_ctcfitapp') == TRUE ) {
?>
	<input type="checkbox" name="remember_me" value="1" class="styled" checked="checked"> Remember
<?php
}
else {
?>
	<input type="checkbox" name="remember_me" value="1" class="styled"> Remember
<?php
}
?>
					</label>
				</div>
				<div class="col-sm-6 text-right" style="margin-top: -15px">
					<a href="<?php echo base_url(); ?>backend/forgot_password">Forgot password?</a>
				</div>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" class="btn bg-blue btn-block">
				Login <i class="icon-circle-right2 position-right"></i>
			</button>
		</div>
	</div>
<?php echo form_close(); ?>
			</div>
		</div>
		<div class="footer text-muted">
			Copyright &copy; <?php echo date("Y"); ?> <a href="<?php echo base_url(); ?>">CTC Travel</a>
		</div>
	</div>
</body>
</html>