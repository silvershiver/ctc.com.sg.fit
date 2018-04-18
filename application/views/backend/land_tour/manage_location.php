<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Land Tour - Manage Location</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/style_custom.css" rel="stylesheet" type="text/css">
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
					<span class="text-semibold">
						<a href="<?php echo base_url(); ?>backend/product/landtour_index">Land Tour management</a>
					</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/product/landtour_index">Land Tour management</a></li>
					<li><a href="<?php echo base_url(); ?>backend/product/landtour_location">Manage Location</a></li>
				</ul>
			</div>
			<div class="heading-elements">
				<div class="heading-btn-group" style="margin-top:25px">
					<div style="float:right; margin-right:10px; margin-top:-25px">
						<button type="button" class="btn btn-primary btn-icon dropdown-toggle" data-toggle="dropdown">
							<b><i class="icon-menu7"></i></b> &nbsp; Land Tour Option Menu <span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li>
								<a href="<?php echo base_url(); ?>backend/product/landtour_add_new">
									<i class="icon-add"></i>Add new land tour product
								</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>backend/product/landtour_category">
									<i class="icon-add"></i> Manage Category
								</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>backend/product/landtour_location">
									<i class="icon-add"></i> Manage Location
								</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>backend/product/landtour_special_instruction">
									<i class="icon-add"></i> Manage Special Instruction
								</a>
							</li>
						</ul>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="page-container">
		<div class="page-content">	
			<div class="content-wrapper">
				<?php echo $this->session->flashdata('session_add_new_category'); ?>
				<?php echo $this->session->flashdata('updateOK'); ?>
				<?php echo $this->session->flashdata('deleteOK'); ?>
            	<div class="col-md-8 ">
					<div class="panel panel-flat">				
						<table class="table datatable-basic">
							<thead>
								<tr>
									<th width="35%">Country name</th>
									<!--<th width="50%">City / location / area name</th>-->
									<th width="15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$lists = $this->All->select_template_with_order("id", "ASC", "landtour_location");
								if( $lists == TRUE ) {
									foreach( $lists AS $list ) {
								?>
								<tr>
									<td>
										<a href="" data-toggle="modal" data-target="#editLocation<?php echo $list->id; ?>" style="text-decoration:underline">
											<?php echo $list->country_name; ?>
										</a>
										<!-- Edit land tour location modal -->
										<div id="editLocation<?php echo $list->id; ?>" class="modal fade">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h5 class="modal-title">Edit category details</h5>
													</div>
													<?php echo form_open_multipart('backend/landtour_process/update_location', array('class' => 'form-horizontal')); ?>
													<input type="hidden" name="hidden_landtourLocationID" value="<?php echo $list->id; ?>" />
													<div class="modal-body">
														<fieldset class="content-group">
															<div class="form-group">
																<label class="control-label col-lg-4">
																	* Country name
																</label>
																<div class="col-lg-8">
																	<input type="text" name="country_name" required class="form-control" value="<?php echo $list->country_name; ?>" />
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-lg-4">
																	* City name
																</label>
																<div class="col-lg-8">
																	<textarea name="city_name" class="form-control" style="resize:none"><?php echo $list->city_name; ?></textarea>
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
										<!-- End of Edit land tour location modal -->
									</td>
									<!--<td><?php echo $list->city_name; ?></td>-->
									<td>
										<a href="<?php echo base_url(); ?>backend/landtour_process/delete_location/<?php echo $list->id; ?>" onclick="return confirm('Are you sure you want to delete this record?')"><b><i class='icon-trash'></i></b> Delete</a>
									</td>
								</tr>
								<?php
									}
								}
								?>
							</tbody>
						</table>
					</div>
                </div>
                <div class="col-md-4">
	                <?php echo $this->session->flashdata('insertLocationOK'); ?>
	                <?php echo $this->session->flashdata('wrongInsert'); ?>
                	<div class="panel">       
                		<div class="add_new_sidebar">              
							<h3 style="padding-left:18px">Add new location</h3>
							<?php echo form_open_multipart('backend/landtour_process/insert_location/', array('class' => 'form-horizontal')); ?>
							<div class="modal-body">	
								<fieldset class="content-group" style="margin-bottom:-20px !important">
									<div class="form-group">
										<div class="col-lg-12">
											<input type="text" name="country_name" class="form-control" placeholder="Enter country name" value="<?php echo set_value('country_name'); ?>" />
											<?php echo form_error('country_name'); ?>
										</div>
									</div>
									<!--
									<div class="form-group">
										<div class="col-lg-12">
											<input type="text" name="city_name" class="form-control" placeholder="Enter city name / location name / area name" value="<?php echo set_value('city_name'); ?>" />
											<?php echo form_error('city_name'); ?>
										</div>
									</div>
									-->
								</fieldset>
							</div>        
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
							<?php echo form_close(); ?>      						
                    	</div>
                	</div>
                </div>
			</div>
		</div>
		<?php require_once(APPPATH."views/master/footer.php"); ?>
	</div>
</body>
</html>