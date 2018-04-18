<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Administrator Management</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/chosen/chosen.css" id="theme" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/datatables_basic.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/chosen/chosen.jquery.js"></script>
	<script type="text/javascript">
		window.onload = function () {
			document.getElementById("password1").onchange = validatePassword;
			document.getElementById("password2").onchange = validatePassword;
		}
		function validatePassword(){
			var pass2=document.getElementById("password2").value;
			var pass1=document.getElementById("password1").value;
			if(pass1!=pass2)
				document.getElementById("password2").setCustomValidity("Passwords Don't Match");
			else
			document.getElementById("password2").setCustomValidity('');
		//empty string means no validation error
		}
</script>
</head>
<body>
	<?php require_once(APPPATH."views/master/main_navbar.php"); ?>
	<?php require_once(APPPATH."views/master/second_navbar.php"); ?>
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Administrator Management</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/administrator">Administrator Management</a></li>
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
						<h5 class="panel-title">This is summary of administrator list</h5>
						<div style="float:right">

							<?php //var_dump($_SESSION); if()
								if($_SESSION)
								{
									if($_SESSION['user_session_access_add_admin'] == '1')
									{ ?>
										<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#addAdministratorModal">
											<b><i class="icon-add"></i></b> Add new administrator
										</button>
									<?php }
								}
							?>

<!-- Add new administrator modal -->
<div id="addAdministratorModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Add new administrator</h5>
			</div>
			<?php echo form_open_multipart('backend/administrator/add_new_administrator', array('class' => 'form-horizontal')); ?>
			<div class="modal-body">
				<fieldset class="content-group">
					<div class="form-group">
						<label class="control-label col-lg-4">
							* Administrator name
						</label>
						<div class="col-lg-8">
							<input type="text" name="admin_name" class="form-control" required />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4">
							* Administrator email address
						</label>
						<div class="col-lg-8">
							<input type="email" name="admin_email_address" class="form-control" required />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4">
							* Administrator password
						</label>
						<div class="col-lg-8">
							<input type="password" name="admin_password" id="password1" class="form-control" pattern=".{8,}" title="Minimum: 8 characters" required />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4">
							* Retype password
						</label>
						<div class="col-lg-8">
							<input type="password" name="admin_retype_password" id="password2" class="form-control" pattern=".{8,}" title="Minimum: 8 characters" required />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4">
							Administrator contact no.
						</label>
						<div class="col-lg-8">
							<input type="contact_no" name="admin_contact_no" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4">
							Administrator address
						</label>
						<div class="col-lg-8">
							<textarea name="admin_address" class="form-control" style="resize:none"></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-4">
							* Role
						</label>
						<div class="col-lg-8">
							<select class="form-control chosen-role" name="role_admin" id="role_admin" data-placeholder="Select Role." data-rule-chosen-required="true">

								<option value="1">Administrator</option>
                                <option value="2">Staff</option>

                            </select>
						</div>
					</div>

					<div class="form-group">


							<button type="button" id="showbutton" class="btn btn-link" style="display: none"><u>show</u></button>

							<button type="button" id="hidebutton" class="btn btn-link"><u>hide</u></button>


					</div>

					<div class="form-group" id="menu_check" style="display: none">
						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Dashboard</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_dashboard" id="acc_dashboard" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Administrator</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_admin" id="acc_admin" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Add Administator
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_add_admin" id="acc_add_admin" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Customer
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_customer" id="acc_customer" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Category</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_category" id="acc_category" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Add Category
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_add_category" id="acc_add_category" style="margin-top: 15px;">
							</div>
						</div>


						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Product</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_product" id="acc_product" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Cruises
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_cruises" id="acc_cruises" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Flights
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_flights" id="acc_flights" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Hotels
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_hotels" id="acc_hotels" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Landtours
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_landtours" id="acc_landtours" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Main Banner</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_main_banner" id="acc_main_banner" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>GTA Settings</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_gta_settings" id="acc_gta_settings" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Contact / Support Centre</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_support_centre" id="acc_support_centre" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Content Management</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_content_management" id="acc_content_management" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Online help</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_online_help" id="acc_online_help" style="margin-top: 15px;">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Edit Profile / Change Password</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_edit_profile" id="acc_edit_profile" style="margin-top: 15px;">
							</div>
						</div>
					</div>






				</fieldset>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Add new administrator</button>
			</div>

			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!-- End of add new administrator modal -->
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
					<?php echo $this->session->flashdata('session_insert_administrator'); ?>
					<?php echo $this->session->flashdata('session_update_administrator'); ?>
					<?php echo $this->session->flashdata('session_delete_administrator'); ?>
					<table class="table datatable-basic">
						<thead>
							<tr>
								<th>Full name</th>
								<th>Email address</th>
								<th>Contact no.</th>
								<th>Address</th>
								<th>Status</th>
								<th>Created</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>

							<?php
							$admins = $this->All->select_template_with_where_and_order(
								"access_role", "SUPERADMIN", "admin_full_name", "ASC", "user_access"
							);
							if( $admins == TRUE ) {
								foreach( $admins AS $admin ) {
							?>
							<tr>
								<td><?php echo $admin->admin_full_name; ?></td>
								<td><?php echo $admin->email_address; ?></td>
								<td><?php echo $admin->admin_contact; ?></td>
								<td><?php echo $admin->admin_address; ?></td>
								<td>
									<?php
									if( $admin->is_block == 0 ) {
									?>
										<span class="label label-success">ACTIVATED</span>
									<?php
									}
									else {
									?>
										<span class="label label-danger">INACTIVATED</span>
									<?php
									}
									?>
								</td>
								<td><?php echo date("Y-m-d H:i:s", strtotime($admin->created)); ?></td>
								<td class="text-center">
									<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#editAdmin<?php echo $admin->id; ?>">
										<b><i class="icon-pencil3"></i></b> Update
									</button>
									<a href="<?php echo base_url(); ?>backend/administrator/do_delete_action/<?php echo $admin->id; ?>" class="btn btn-primary btn-labeled" onclick="return confirm('Are you sure you want to delete this administrator?');">
										<b><i class="icon-trash"></i></b> Delete
									</a>
<!-- Edit administrator modal -->
<div id="editAdmin<?php echo $admin->id; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Edit administrator details</h5>
			</div>
			<?php echo form_open_multipart('backend/administrator/edit_administrator', array('class' => 'form-horizontal')); ?>
			<input type="hidden" name="hidden_admin_id" value="<?php echo $admin->id; ?>" />
			<div class="modal-body">
				<fieldset class="content-group">
					<div class="form-group">
						<label class="control-label col-lg-4">
							* Administrator name
						</label>
						<div class="col-lg-8">
							<input type="text" name="admin_name" class="form-control" required value="<?php echo $admin->admin_full_name; ?>" />
						</div>

					</div>
					<div class="form-group">
						<label class="control-label col-lg-4">
							* Administrator email address
						</label>
						<div class="col-lg-8">
							<input type="email" name="admin_email_address" class="form-control" required value="<?php echo $admin->email_address; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4">
							Administrator contact no.
						</label>
						<div class="col-lg-8">
							<input type="contact_no" name="admin_contact_no" class="form-control" value="<?php echo $admin->admin_contact; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4">
							Administrator address
						</label>
						<div class="col-lg-8">
							<textarea name="admin_address" class="form-control" style="resize:none"><?php echo $admin->admin_address; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4">
							Administrator password
						</label>
						<div class="col-lg-8">
							<input type="password" name="admin_password" class="form-control" pattern=".{8,}" title="Minimum: 8 characters" placeholder="Leave empty if you do not change password" />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-4">
							Role Admin
						</label>
						<div class="col-lg-8">
							<input type="text" name="role_admin" class="form-control" value="<?php echo $admin->role_admin; ?>" readonly />
						</div>
					</div>

					<div class="form-group" id="menu_check_edit">
						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Dashboard</b>
							</label>
							<div class="col-lg-6">
								<input type="checkbox" name="acc_dashboard_edit" id="acc_dashboard_edit" style="margin-top: 15px;" <?php if($admin->acc_dashboard == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Administrator</b>
							</label>
							<div class="col-lg-6">
								<input type="checkbox" name="acc_admin_edit" id="acc_admin_edit" style="margin-top: 15px;" <?php if($admin->acc_admin == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Add Administator
							</label>
							<div class="col-lg-6">
								<input type="checkbox" name="acc_add_admin_edit" id="acc_add_admin_edit" style="margin-top: 15px;" <?php if($admin->acc_add_admin == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Customer
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_customer_edit" id="acc_customer_edit" style="margin-top: 15px;"  <?php if($admin->acc_customer == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Category</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_category_edit" id="acc_category_edit" style="margin-top: 15px;"  <?php if($admin->acc_category == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Add Category
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_add_category_edit" id="acc_add_category_edit" style="margin-top: 15px;"  <?php if($admin->acc_add_category == '1'){ echo "checked"; } ?>>
							</div>
						</div>


						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Product</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_product_edit" id="acc_product_edit" style="margin-top: 15px;"  <?php if($admin->acc_product == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Cruises
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_cruises_edit" id="acc_cruises_edit" style="margin-top: 15px;"  <?php if($admin->acc_cruises == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Flights
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_flights_edit" id="acc_flights_edit" style="margin-top: 15px;"  <?php if($admin->acc_flights == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Hotels
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_hotels_edit" id="acc_hotels_edit" style="margin-top: 15px;"  <?php if($admin->acc_hotels == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-2"></div>
							<label class="control-label col-lg-4">
								Landtours
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_landtours_edit" id="acc_landtours_edit" style="margin-top: 15px;"  <?php if($admin->acc_landtours == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Main Banner</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_main_banner_edit" id="acc_main_banner_edit" style="margin-top: 15px;"  <?php if($admin->acc_main_banner == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>GTA Settings</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_gta_settings_edit" id="acc_gta_settings_edit" style="margin-top: 15px;"  <?php if($admin->acc_gta_settings == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Contact / Support Centre</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_support_centre_edit" id="acc_support_centre_edit" style="margin-top: 15px;""  <?php if($admin->acc_support_centre == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Content Management</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_content_management_edit" id="acc_content_management_edit" style="margin-top: 15px;"  <?php if($admin->acc_content_management == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Online help</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_online_help_edit" id="acc_online_help_edit" style="margin-top: 15px;"  <?php if($admin->acc_online_help == '1'){ echo "checked"; } ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-1"></div>
							<label class="control-label col-lg-5">
								<b>Edit Profile / Change Password</b>
							</label>
							<div class="col-lg-6">
									<input type="checkbox" name="acc_edit_profile_edit" id="acc_edit_profile_edit" style="margin-top: 15px;"  <?php if($admin->acc_edit_profile == '1'){ echo "checked"; } ?>>
							</div>
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
<!-- End of edit administrator modal -->
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
	<script type="text/javascript">

		$( document ).ready(function() {



		    var role = $('#role_admin').val();

		    if(role == "1")
		    {
		    	$('#acc_dashboard').prop('checked', true);
				$('#acc_admin').prop('checked', true);
				$('#acc_add_admin').prop('checked', true);
				$('#acc_customer').prop('checked', true);
				$('#acc_category').prop('checked', true);
				$('#acc_add_category').prop('checked', true);
				$('#acc_product').prop('checked', true);
				$('#acc_cruises').prop('checked', true);
				$('#acc_flights').prop('checked', true);
				$('#acc_hotels').prop('checked', true);
				$('#acc_landtours').prop('checked', true);
				$('#acc_main_banner').prop('checked', true);
				$('#acc_gta_settings').prop('checked', true);
				$('#acc_support_centre').prop('checked', true);
				$('#acc_content_management').prop('checked', true);
				$('#acc_online_help').prop('checked', true);
				$('#acc_edit_profile').prop('checked', true);
		    }

		    $('#showbutton').hide();
			$('#hidebutton').show();
			$('#menu_check').show();



		});

		$( "#showbutton" ).click(function() {
			$('#showbutton').hide();
			$('#hidebutton').show();
			$('#menu_check').show();
		});

		$( "#hidebutton" ).click(function() {
			$('#hidebutton').hide();
			$('#showbutton').show();
			$('#menu_check').hide();
		});



		$( "#role_admin" ).change(function() {

			$('#hidebutton').show();
			$('#showbutton').hide();
			$('#menu_check').show();
			var role = $('#role_admin').val();

			if(role == '1')
			{
				$('#acc_dashboard').prop('checked', true);
				$('#acc_admin').prop('checked', true);
				$('#acc_add_admin').prop('checked', true);
				$('#acc_customer').prop('checked', true);
				$('#acc_category').prop('checked', true);
				$('#acc_add_category').prop('checked', true);
				$('#acc_product').prop('checked', true);
				$('#acc_cruises').prop('checked', true);
				$('#acc_flights').prop('checked', true);
				$('#acc_hotels').prop('checked', true);
				$('#acc_landtours').prop('checked', true);
				$('#acc_main_banner').prop('checked', true);
				$('#acc_gta_settings').prop('checked', true);
				$('#acc_support_centre').prop('checked', true);
				$('#acc_content_management').prop('checked', true);
				$('#acc_online_help').prop('checked', true);
				$('#acc_edit_profile').prop('checked', true);
			}
			else if(role=='2')
			{
				$('#acc_dashboard').prop('checked', true);
				$('#acc_admin').prop('checked', false);
				$('#acc_add_admin').prop('checked', false);
				$('#acc_customer').prop('checked', false);
				$('#acc_category').prop('checked', false);
				$('#acc_add_category').prop('checked', false);
				$('#acc_product').prop('checked', true);
				$('#acc_cruises').prop('checked', true);
				$('#acc_flights').prop('checked', false);
				$('#acc_hotels').prop('checked', false);
				$('#acc_landtours').prop('checked', true);
				$('#acc_main_banner').prop('checked', false);
				$('#acc_gta_settings').prop('checked', false);
				$('#acc_support_centre').prop('checked', true);
				$('#acc_content_management').prop('checked', false);
				$('#acc_online_help').prop('checked', true);
				$('#acc_edit_profile').prop('checked', true);
			}
		});

		var checkbox_product = $("#acc_product");

		checkbox_product.change(function(event) {
		    var checkbox = event.target;
		    if (checkbox.checked) {
		        //Checkbox has been checked
		    } else {
		        //Checkbox has been unchecked
		        $('#acc_landtours').prop('checked', false);
				$('#acc_cruises').prop('checked', false);
				$('#acc_flights').prop('checked', false);
				$('#acc_hotels').prop('checked', false);
		    }
		});


		var checkbox_cruises = $("#acc_cruises");

		checkbox_cruises.change(function(event) {
		    var checkbox_cruises = event.target;
		    if (checkbox_cruises.checked) {
		        //Checkbox has been checked
		        $('#acc_product').prop('checked', true);
		    }
		});


		var checkbox_hotels = $('#acc_hotels');

		checkbox_hotels.change(function(event) {
		    var checkbox_hotels = event.target;
		    if (checkbox_hotels.checked) {
		        //Checkbox has been checked
		        $('#acc_product').prop('checked', true);
		    }
		});


		var checkbox_flights = $('#acc_flights');

		checkbox_flights.change(function(event) {
		    var checkbox_flights = event.target;
		    if (checkbox_flights.checked) {
		        //Checkbox has been checked
		        $('#acc_product').prop('checked', true);
		    }
		});


		var checkbox_landtours = $('#acc_landtours');

		checkbox_landtours.change(function(event) {
		    var checkbox_landtours = event.target;
		    if (checkbox_landtours.checked) {
		        //Checkbox has been checked
		        $('#acc_product').prop('checked', true);
		    }
		});

		var checkbox_category = $('#acc_category');

		checkbox_category.change(function(event) {
		    var checkbox_category = event.target;
		    if (checkbox_category.checked) {
		        //Checkbox has been checked

		    }
		    else
		    {
		    	$('#acc_add_category').prop('checked', false);
		    }
		});

		var checkbox_add_category = $('#acc_add_category');

		checkbox_add_category.change(function(event) {
		    var checkbox_add_category = event.target;
		    if (checkbox_add_category.checked) {
		        //Checkbox has been checked
		        $('#acc_category').prop('checked', true);
		    }

		});

		var checkbox_admin = $('#acc_admin');

		checkbox_admin.change(function(event) {
		    var checkbox_admin = event.target;
		    if (checkbox_admin.checked) {
		        //Checkbox has been checked

		    }
		    else
		    {
		    	$('#acc_add_admin').prop('checked', false);
		    	$('#acc_customer').prop('checked', false);
		    }
		});

		var checkbox_add_admin = $('#acc_add_admin');

		checkbox_add_admin.change(function(event) {
		    var checkbox_add_admin = event.target;
		    if (checkbox_add_admin.checked) {
		        //Checkbox has been checked
		        $('#acc_admin').prop('checked', true);
		    }

		});


		var checkbox_customer = $('#acc_customer');

		checkbox_customer.change(function(event) {
		    var checkbox_customer = event.target;
		    if (checkbox_customer.checked) {
		        //Checkbox has been checked
		        $('#acc_admin').prop('checked', true);
		    }

		});


		//FORM EDIT


			var checkbox_product_edit = $("input#acc_product_edit");
			//console.log(checkbox_product_edit);
			checkbox_product_edit.change(function(event) {
			    var checkbox_edit = event.target;

			    if (checkbox_edit.checked) {
			        //Checkbox has been checked

			    } else {
			        //Checkbox has been unchecked

			        $('input#acc_landtours_edit').prop('checked', false);
					$('input#acc_cruises_edit').prop('checked', false);
					$('input#acc_flights_edit').prop('checked', false);
					$('input#acc_hotels_edit').prop('checked', false);
			    }
			});




		var checkbox_cruises_edit = $("input#acc_cruises_edit");

		checkbox_cruises_edit.change(function(event) {
		    var checkbox_cruises_edit = event.target;
		    if (checkbox_cruises_edit.checked) {
		        //Checkbox has been checked
		        $('input#acc_product_edit').prop('checked', true);
		    }
		});


		var checkbox_hotels_edit = $('input#acc_hotels_edit');

		checkbox_hotels_edit.change(function(event) {
		    var checkbox_hotels_edit = event.target;
		    if (checkbox_hotels_edit.checked) {
		        //Checkbox has been checked
		        $('input#acc_product_edit').prop('checked', true);
		    }
		});


		var checkbox_flights_edit = $('input#acc_flights_edit');

		checkbox_flights_edit.change(function(event) {
		    var checkbox_flights_edit = event.target;
		    if (checkbox_flights_edit.checked) {
		        //Checkbox has been checked
		        $('input#acc_product_edit').prop('checked', true);
		    }
		});


		var checkbox_landtours_edit = $('input#acc_landtours_edit');

		checkbox_landtours_edit.change(function(event) {
		    var checkbox_landtours_edit = event.target;
		    if (checkbox_landtours_edit.checked) {
		        //Checkbox has been checked
		        $('input#acc_product_edit').prop('checked', true);
		    }
		});

		var checkbox_category_edit = $('input#acc_category_edit');

		checkbox_category_edit.change(function(event) {
		    var checkbox_category_edit = event.target;
		    if (checkbox_category_edit.checked) {
		        //Checkbox has been checked

		    }
		    else
		    {
		    	$('input#acc_add_category_edit').prop('checked', false);
		    }
		});

		var checkbox_add_category_edit = $('input#acc_add_category_edit');

		checkbox_add_category_edit.change(function(event) {
		    var checkbox_add_category_edit = event.target;
		    if (checkbox_add_category_edit.checked) {
		        //Checkbox has been checked

		        $('input#acc_category_edit').prop('checked', true);
		    }

		});

		var checkbox_admin_edit = $('input#acc_admin_edit');

		checkbox_admin_edit.change(function(event) {
		    var checkbox_admin_edit = event.target;
		    if (checkbox_admin_edit.checked) {
		        //Checkbox has been checked

		    }
		    else
		    {
		    	$('input#acc_add_admin_edit').prop('checked', false);
		    	$('input#acc_customer_edit').prop('checked', false);
		    }
		});

		var checkbox_add_admin_edit = $('input#acc_add_admin_edit');

		checkbox_add_admin_edit.change(function(event) {
		    var checkbox_add_admin_edit = event.target;
		    if (checkbox_add_admin_edit.checked) {
		        //Checkbox has been checked
		        $('input#acc_admin_edit').prop('checked', true);
		    }

		});


		var checkbox_customer_edit = $('input#acc_customer_edit');

		checkbox_customer_edit.change(function(event) {
		    var checkbox_customer_edit = event.target;
		    if (checkbox_customer_edit.checked) {
		        //Checkbox has been checked
		        $('input#acc_admin_edit').prop('checked', true);
		    }

		});

		// END FORM EDIT

		/*START CHOSEN*/
	        var config = {
	          '.chosen-role'           : {search_contains:true,no_results_text:'Oops, Not Found',width: "300px"},
	          '.chosen-role2'           : {search_contains:true,no_results_text:'Oops, Not Found',width: "300px"},

	        }
	        for (var selector in config) {
	          $(selector).chosen(config[selector]);
	        }
	        /*END CHOSEN*/
	</script>
</body>
</html>