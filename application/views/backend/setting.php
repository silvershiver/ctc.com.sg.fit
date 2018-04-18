<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTCFITApp - Setting Management</title>
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
					<span class="text-semibold">Setting - Management</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/setting">Setting - Management</a></li>
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
			<!-- Main content -->
			<div class="content-wrapper">
				<!-- Grid -->
				<div class="row">
					<div class="col-md-12">
						<!-- Horizontal form -->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">Update your details below</h5>
		                	</div>
							<div class="panel-body">
								<form class="form-horizontal" action="#">
									<div class="form-group">
			                        	<label class="control-label col-lg-2">Site name</label>
			                        	<div class="col-lg-8">
				                            <input  name="" class="form-control" />
			                            </div>
			                        </div>
			                        <div class="form-group">
			                        	<label class="control-label col-lg-2">Site version</label>
			                        	<div class="col-lg-8">
				                            <input  name="" class="form-control" />
			                            </div>
			                        </div>
			                        <div class="form-group">
			                        	<label class="control-label col-lg-2">Meta keyword</label>
			                        	<div class="col-lg-8">
				                            <input  name="" class="form-control" />
			                            </div>
			                        </div>
									<div class="form-group">
			                        	<label class="control-label col-lg-2">Meta description</label>
			                        	<div class="col-lg-8">
				                            <textarea name="" class="form-control" style="resize:none"></textarea>
			                            </div>
			                        </div>
			                        <div class="form-group">
			                        	<label class="control-label col-lg-2">API Key 1</label>
			                        	<div class="col-lg-8">
				                            <input  name="" class="form-control" />
			                            </div>
			                        </div>
			                        <div class="form-group">
			                        	<label class="control-label col-lg-2">API Key 2</label>
			                        	<div class="col-lg-8">
				                            <input  name="" class="form-control" />
			                            </div>
			                        </div>
			                        <div class="form-group">
			                        	<label class="control-label col-lg-2">API Key 3</label>
			                        	<div class="col-lg-8">
				                            <input  name="" class="form-control" />
			                            </div>
			                        </div>
			                        <div class="form-group">
			                        	<label class="control-label col-lg-2">API Key 4</label>
			                        	<div class="col-lg-8">
				                            <input  name="" class="form-control" />
			                            </div>
			                        </div>
			                        <div class="form-group">
			                        	<label class="control-label col-lg-2">API Key 5</label>
			                        	<div class="col-lg-8">
				                            <input  name="" class="form-control" />
			                            </div>
			                        </div>
									<div class="text-right">
										<button type="submit" class="btn btn-primary">
											Save changes <i class="icon-arrow-right14 position-right"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
						<!-- /horizotal form -->
					</div>
				</div>
				<!-- /grid -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

		<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->

	</div>
	<!-- /page container -->

</body>
</html>
