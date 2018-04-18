<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Category Management</title>
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
					<span class="text-semibold">Category Management</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/category">Category Management</a></li>
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
						<h5 class="panel-title">This is summary of category list</h5>
						<div style="float:right; margin-top:-25px">
							<?php //var_dump($_SESSION); if()
								if($_SESSION)
								{
									if($_SESSION['user_session_access_add_category'] == '1')
									{ ?>
										<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#addCategory">
											<b><i class="icon-add"></i></b> Add new category
										</button>
									<?php }
								}
							?>

							<!-- Add new category modal -->
							<div id="addCategory" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h5 class="modal-title">Add new category</h5>
										</div>
<?php echo form_open_multipart('backend/category/add_new_progress', array('class' => 'form-horizontal')); ?>
	<div class="modal-body">
		<fieldset class="content-group">
			<div class="form-group">
				<label class="control-label col-lg-3">
					* Category name
				</label>
				<div class="col-lg-9">
					<input type="text" name="category_name" required class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3">
					Category description
				</label>
				<div class="col-lg-9">
					<textarea name="category_desc" class="form-control" style="resize:none"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3">
					Category status
				</label>
				<div class="col-lg-9">
					<select name="category_status" required class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Add new category</button>
	</div>
<?php echo form_close(); ?>
									</div>
								</div>
							</div>
							<!-- End of add new category modal -->
						</div>
						<!--
						<div style="float:right; margin-right:10px">
							<button type="button" class="btn btn-primary btn-labeled">
								<b><i class="icon-box-add"></i></b> Export data (.csv)
							</button>
						</div>
						-->
						<div style="clear:both"></div>
					</div>
					<?php echo $this->session->flashdata('session_add_new_category'); ?>
					<?php echo $this->session->flashdata('session_update_category'); ?>
					<table class="table datatable-basic">
						<thead>
							<tr>
								<th>Category name</th>
								<th>Category description</th>
								<th>Category status</th>
								<th>Created</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$indexs = $this->All->select_template_with_order("category_name", "ASC", "category");
							if( $indexs == TRUE ) {
								foreach( $indexs AS $index ) {
							?>
							<tr>
								<td><?php echo $index->category_name; ?></td>
								<td><?php echo $index->category_desc; ?></td>
								<td>
									<?php
									if( $index->category_status == 1 ) {
									?>
									<span class="label label-success">Active</span>
									<?php
									}
									else {
									?>
									<span class="label label-danger">Inactive</span>
									<?php
									}
									?>
								</td>
								<td><?php echo date("Y-F-d H:i:s", strtotime($index->created)); ?></td>
								<td class="text-center">
									<a href="" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#editCategory<?php echo $index->id; ?>">
										<b><i class="icon-pencil3"></i></b> Update
									</a>
									<a href="#" class="btn btn-primary btn-labeled">
										<b><i class="icon-trash"></i></b> Delete
									</a>
<!-- Edit category modal -->
<div id="editCategory<?php echo $index->id; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Edit category details</h5>
			</div>
			<?php echo form_open_multipart('backend/category/update_category_progress', array('class' => 'form-horizontal')); ?>
			<input type="hidden" name="hidden_category_id" value="<?php echo $index->id; ?>" />
			<div class="modal-body">
				<fieldset class="content-group">
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Category name
						</label>
						<div class="col-lg-9">
							<input type="text" name="category_name" required class="form-control" value="<?php echo $index->category_name; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Description
						</label>
						<div class="col-lg-9">
							<textarea name="category_desc" class="form-control" style="resize:none"><?php echo $index->category_desc; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Category status
						</label>
						<div class="col-lg-9">
							<select name="category_status" required class="form-control">
								<?php
								if( $index->category_status == 1 ) {
								?>
								<option value="1" SELECTED>Active</option>
		                        <option value="0">Inactive</option>
								<?php
								}
								else {
								?>
								<option value="1">Active</option>
		                        <option value="0" SELECTED>Inactive</option>
								<?php
								}
								?>
		                    </select>
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
<!-- End of edit category modal-->
								</td>
							</tr>
							<?php
								}
							}
							?>
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
