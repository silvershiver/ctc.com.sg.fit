<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Cruise - Manage Special Instruction</title>
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
						<a href="<?php echo base_url(); ?>backend/product/cruise_index">Cruise management</a>
					</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li>
						<a href="<?php echo base_url(); ?>backend/dashboard">Home</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>backend/product/cruise_index">Cruise management</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>backend/product/cruise_manage_instruction">Manage Special Instruction</a>
					</li>
				</ul>
			</div>
			<div class="heading-elements">
				<div class="heading-btn-group" style="margin-top:25px">
					<div style="float:right; margin-right:10px; margin-top:-25px">
						<button type="button" class="btn btn-primary btn-icon dropdown-toggle" data-toggle="dropdown">
							<b><i class="icon-menu7"></i></b> &nbsp; Cruise Option Menu <span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li>
								<a href="<?php echo base_url(); ?>backend/product/cruise_add_new">
									<i class="icon-add"></i>Add New Cruise Package
								</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>backend/product/cruise_manage_stateroom">
									<i class="icon-add"></i> Manage Stateroom(s)
								</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>backend/product/cruise_add_new_prices">
									<i class="icon-add"></i> Manage Prices
								</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>backend/product/cruise_manage_brand">
									<i class="icon-add"></i> Manage Brand(s)
								</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>backend/product/cruise_manage_ship">
									<i class="icon-add"></i> Manage Ship(s)
								</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>backend/product/cruise_manage_instruction">
									<i class="icon-add"></i> Manage Special Instruction(s)
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
									<th width="15%">Order No.</th>
									<th width="70%">Special Instruction</th>
									<th width="15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$lists = $this->All->select_template_with_where_and_order(
									"type", "CRUISE", "order_no", "ASC", "special_instruction"
								);
								if( $lists == TRUE ) {
									foreach( $lists AS $list ) {
								?>
								<tr>
									<td>
										<a href="" data-toggle="modal" data-target="#editInstruction<?php echo $list->id; ?>" style="text-decoration:underline">
											<?php echo $list->order_no; ?>
										</a>
										<!-- Edit land tour special instruction modal -->
										<div id="editInstruction<?php echo $list->id; ?>" class="modal fade">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h5 class="modal-title">Edit special instruction</h5>
													</div>
													<?php echo form_open_multipart('backend/product_process/update_special_instruction', array('class' => 'form-horizontal')); ?>
													<input type="hidden" name="hidden_specialInstructionID" value="<?php echo $list->id; ?>" />
													<div class="modal-body">
														<fieldset class="content-group">
															<div class="form-group">
																<label class="control-label col-lg-4">
																	* Order no
																</label>
																<div class="col-lg-8">
																	<input type="text" name="order_no" required class="form-control" value="<?php echo $list->order_no; ?>" />
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-lg-4">
																	* Special instruction
																</label>
																<div class="col-lg-8">
																	<textarea name="content" class="form-control" style="resize:none"><?php echo $list->instruction_content; ?></textarea>
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
										<!-- End of Edit land tour special instruction modal -->
									</td>
									<td><?php echo $list->instruction_content; ?></td>
									<td>
										<a href="<?php echo base_url(); ?>backend/product_process/delete_special_instruction/<?php echo $list->id; ?>" onclick="return confirm('Are you sure you want to delete this record?')"><b><i class='icon-trash'></i></b> Delete</a>
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
	                <?php echo $this->session->flashdata('insertSpecialInstruction'); ?>
                	<div class="panel">       
                		<div class="add_new_sidebar">              
							<h3 style="padding-left:18px">Add new special instruction</h3>
							<?php echo form_open_multipart('backend/product_process/insert_special_instruction/', array('class' => 'form-horizontal')); ?>
							<div class="modal-body">	
								<fieldset class="content-group" style="margin-bottom:0px !important">
									<div class="form-group">
										<div class="col-lg-12">
											<input type="text" name="order_no" class="form-control" maxlength="2" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" placeholder="Enter order no. (Number Only)" value="<?php echo set_value('order_no'); ?>" />
											<?php echo form_error('order_no'); ?>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<input type="text" name="content" class="form-control" placeholder="Enter special instruction content" value="<?php echo set_value('content'); ?>" />
											<?php echo form_error('content'); ?>
										</div>
									</div>
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