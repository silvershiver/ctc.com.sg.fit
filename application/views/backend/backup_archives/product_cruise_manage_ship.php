<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Cruise Ship Management</title>
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
					<span class="text-semibold">Cruise Management</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/product/cruise_index">Cruise Management</a></li>
					<li><a href="<?php echo base_url(); ?>backend/product/cruise_ship">Cruise Ship Management</a></li>
				</ul>
			</div>
			<?php require_once(APPPATH."views/master/heading_element.php"); ?>
		</div>
	</div>
	<!-- /page header -->

	<!-- Page container -->
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Summary of cruise ship list</h5>																				<div style="float:right; margin-right:10px; margin-top:-25px">
							<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#addBrand">
								<b><i class="icon-add"></i></b> Add new cruise ship
							</button>
<!-- Add new cruise ship -->
<div id="addBrand" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo form_open_multipart('#', array('class' => 'form-horizontal')); ?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Add new cruise ship</h5>
				</div>
				<div class="modal-body">
					<fieldset class="content-group">
						<div class="form-group">
							<label class="control-label col-lg-4">Choose brand</label>
							<div class="col-lg-8">
								<select name="select_brand" class="form-control">
									<?php
									$brands = $this->All->select_template_with_order("NAME", "ASC", "cruise_brand");
									if( $brands == TRUE ) {
										foreach( $brands AS $brand ) {
									?>
									<option value="<?php echo $brand->ID; ?>">
										<?php echo $brand->NAME; ?>
									</option>
									<?php
										}
									}
									?>
				                </select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4">
								Ship name
							</label>
							<div class="col-lg-8">
								<input type="text" name="cruise_ship_name" required class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4">
								Ship description
							</label>
							<div class="col-lg-8">
								<textarea name="cruise_ship_name" class="form-control" style="resize:none; height:150px"></textarea>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add new cruise ship</button>
				</div>
			<?php echo form_close(); ?>								
		</div>
	</div>
</div>
<!-- End of add new cruise ship -->
						</div>
						<div style="float:right; margin-right:10px; margin-top:-25px">
							<a href="<?php echo base_url(); ?>backend/product/cruise_index" class="btn btn-primary btn-labeled">
								<b><i class="icon-box-add"></i></b> Back to cruise management
							</a>
						</div>
						<div style="clear:both"></div>
					</div>
					<table class="table datatable-basic">
						<thead>
							<tr>
								<th>Brand name</th>
								<th>Ship name</th>
								<th>Ship description</th>
								<th>Created</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>ROYAL CARIBBEAN</td>
								<td>Ship name 1</td>
								<td>Ship description 1</td>	
								<td>2016-03-10: 10:10:10</td>
								<td class="text-center" style="width:250px">
									<a class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#eShip">
										<b><i class="icon-pencil3"></i></b> Update
									</a>
<!--- Edit cruise ship modal -->
<div id="eShip" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo form_open_multipart('#', array('class' => 'form-horizontal')); ?>			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Edit cruise ship</h5>
				</div>
				<div class="modal-body">
					<fieldset class="content-group">
						<div class="form-group">
							<label class="control-label col-lg-4">
								Brand name
							</label>
							<div class="col-lg-8">
								<select name="select_brand" class="form-control">
									<?php
									$brands = $this->All->select_template_with_order("NAME", "ASC", "cruise_brand");
									if( $brands == TRUE ) {
										foreach( $brands AS $brand ) {
									?>
									<option value="<?php echo $brand->ID; ?>">
										<?php echo $brand->NAME; ?>
									</option>
									<?php
										}
									}
									?>
				                </select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4">
								Ship name
							</label>
							<div class="col-lg-8">
								<input type="text" name="device_type_name" required class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4">
								Ship description
							</label>
							<div class="col-lg-8">
								<textarea name="device_type_desc" class="form-control" style="resize:none; height:150px"></textarea>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			<?php echo form_close(); ?>		
		</div>
	</div>
</div>
<!--- End of edit cruise brand modal -->
									<a href="#" onclick="return confirm('Are you sure you want to delete this brand? Please unlink all related cruise details on this brand.')" class="btn btn-primary btn-labeled">
										<b><i class="icon-trash"></i></b> Delete
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- /basic datatable -->

			</div>
		</div>
		
		<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->
		
	</div>
	<!-- /page container -->

</body>
</html>