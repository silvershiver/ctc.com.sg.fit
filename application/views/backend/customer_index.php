<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTCFITApp - Customer Management</title>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/datatables_basic.js"></script>
</head>
<body>
	<?php require_once(APPPATH."views/master/main_navbar.php"); ?>
	<?php require_once(APPPATH."views/master/second_navbar.php"); ?>
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Customer Management</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/customer">Customer Management</a></li>
				</ul>
			</div>
			<?php require_once(APPPATH."views/master/heading_element.php"); ?>
		</div>
	</div>
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">This is summary of customer list</h5>
						<!--
						<div style="float:right; margin-right:10px; margin-top:-25px">
							<button type="button" class="btn btn-primary btn-labeled">
								<b><i class="icon-box-add"></i></b> Export data (.csv)
							</button>
						</div>
						<div style="clear:both"></div>
						-->
					</div>
					<table class="table datatable-basic">
						<thead>
							<tr>
								<th>First name</th>
								<th>Last name</th>
								<th>Email address</th>
								<th>Contact no.</th>
								<th>Loyalty point</th>
								<th>Created</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>first name 1</td>
								<td>last name 1</td>
								<td>customer1@gmail.com</td>
								<td>12345678</td>
								<td><span class="label label-success">100</span></td>
								<td>2015-January-10 10:10:10</td>
								<td class="text-center">
									<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#editCategory">
										<b><i class="icon-pencil3"></i></b> Update
									</button>
									<button type="button" class="btn btn-primary btn-labeled">
										<b><i class="icon-trash"></i></b> Delete
									</button>
								</td>
							</tr>
							<tr>
								<td>first name 2</td>
								<td>last name 2</td>
								<td>customer1@gmail.com</td>
								<td>12345678</td>
								<td><span class="label label-success">200</span></td>
								<td>2015-January-10 10:10:10</td>
								<td class="text-center">
									<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#editCategory">
										<b><i class="icon-pencil3"></i></b> Update
									</button>
									<button type="button" class="btn btn-primary btn-labeled">
										<b><i class="icon-trash"></i></b> Delete
									</button>
								</td>
							</tr>
							<tr>
								<td>first name 3</td>
								<td>last name 3</td>
								<td>customer1@gmail.com</td>
								<td>12345678</td>
								<td><span class="label label-success">300</span></td>
								<td>2015-January-10 10:10:10</td>
								<td class="text-center">
									<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#editCategory">
										<b><i class="icon-pencil3"></i></b> Update
									</button>
									<button type="button" class="btn btn-primary btn-labeled">
										<b><i class="icon-trash"></i></b> Delete
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- /basic datatable -->

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
