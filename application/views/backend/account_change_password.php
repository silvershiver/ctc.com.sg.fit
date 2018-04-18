<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTCFITApp - Change Password</title>
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<!-- Core JS files -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/drilldown.js"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<!-- /theme JS files -->
</head>
<body class="sidebar-xs">

	<!-- Main navbar -->
	<?php require_once(APPPATH."views/master/main_navbar.php"); ?>
	<!-- /main navbar -->

	<!-- Second navbar -->
	<?php require_once(APPPATH."views/master/second_navbar.php"); ?>
	<!-- /second navbar -->

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Change - Password</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/account/change_password">My account - Change Password</a></li>
				</ul>
			</div>
			<?php require_once(APPPATH."views/master/heading_element.php"); ?>
		</div>
	</div>
	<!-- /page header -->

	<!-- Page container -->
	<div class="page-container">
		<!-- Page content -->
		<div class="page-content">
			<!-- Secondary sidebar -->
			<div class="sidebar sidebar-secondary sidebar-default">
				<div class="sidebar-content">
					<!-- Sub navigation -->
					<div class="sidebar-category">
						<div class="category-content no-padding">
							<ul class="navigation navigation-alt navigation-accordion">
								<li class="navigation-header">Related Links</li>
								<li>
									<a href="<?php echo base_url(); ?>backend/account">
										<i class="icon-user-plus"></i> My profile
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>backend/account/change_password">
										<i class="icon-coins"></i> Change password
									</a>
								</li>
							</ul>
						</div>
					</div>
					<!-- /sub navigation -->
				</div>
			</div>
			<!-- /secondary sidebar -->
			<!-- Main content -->
			<div class="content-wrapper">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">Update your password below</h5>
		                	</div>
							<div class="panel-body">
<?php echo $this->session->flashdata('password_updated'); ?>
<?php echo form_open_multipart('backend/account/do_change_password', array('class' => 'form-horizontal')); ?>
	<div class="form-group">
    	<label class="control-label col-lg-2">* Current password</label>
    	<div class="col-lg-6">
            <input type="password" name="current_password" class="form-control" />
            <?php echo form_error("current_password"); ?>
        </div>
    </div>
    <div class="form-group">
    	<label class="control-label col-lg-2">* New password</label>
    	<div class="col-lg-6">
            <input type="password" name="new_password" class="form-control" />
            <?php echo form_error("new_password"); ?>
        </div>
    </div>
    <div class="form-group">
    	<label class="control-label col-lg-2">* Confirm new password</label>
    	<div class="col-lg-6">
            <input type="password" name="confirm_new_password" class="form-control" />
            <?php echo form_error("confirm_new_password"); ?>
        </div>
    </div>
	<div class="text-right">
		<button type="submit" class="btn btn-primary">
			Save changes <i class="icon-arrow-right14 position-right"></i>
		</button>
	</div>
<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->

	</div>
</body>
</html>