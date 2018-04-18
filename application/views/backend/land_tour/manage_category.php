<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Land Tour - Manage Category</title>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
	<script type="text/javascript">
		// Sortable rows
		$(function  () {
			$("#tabledivbodyLTCategory").sortable({
				items: "tr", cursor: 'move', opacity: 0.6,
				update: function() {
					var order = $("#tabledivbodyLTCategory").sortable("serialize");
					$.ajax({
				        type: "POST", dataType: "json", url: "<?php echo base_url(); ?>backend/landtour_process/doCategoryOrder",
				        data: order,
				        success: function(response) {
				            if (response.status == "success") { alert("Record(s) position has been changed"); } 
				            else { alert('Some error occurred'); }
				        }
				    });
	    		}
			});
		});
		// End of Sortable rows
	</script>
	<style>
		body.dragging, body.dragging * { cursor: move !important; }
		.dragged { position: absolute; opacity: 0.5; z-index: 2000; }
		ol.example li.placeholder { position: relative; }
		ol.example li.placeholder:before { position: absolute; }
		.editbox { display:none; }
		.EnableEditMode { display:none; }
	</style>
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
					<li><a href="<?php echo base_url(); ?>backend/product/landtour_category">Manage Category</a></li>
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
				<?php echo $this->session->flashdata('isDeletedLandtourCategory'); ?>
				<div style="text-align:left">
					<i>&nbsp;&nbsp;&nbsp;** Please drag and drop the table row below for sorting record ordering</i>
				</div>
            	<div class="col-md-8 ">
					<div class="panel panel-flat">				
						<table class="table text-nowrap">
							<thead>
								<tr>
									<th width="25%">Category name</th>
									<th width="40%">Category description</th>
									<th width="20%">Category status</th>
									<th width="15%">Action</th>
								</tr>
							</thead>
							<tbody id="tabledivbodyLTCategory">
								<?php
								$lists = $this->All->select_template_with_where_and_order(
									"is_deleted", 0, "sortNo", "ASC", "landtour_category"
								);
								if( $lists == TRUE ) {
									foreach( $lists AS $list ) {
								?>
								<tr id="sectionsid_<?php echo $list->id; ?>">
									<td>
										<a href="" data-toggle="modal" data-target="#editCategory<?php echo $list->id; ?>" style="text-decoration:underline">
											<?php echo $list->category_name; ?>
										</a>
										<!-- Edit land tour category modal -->
										<div id="editCategory<?php echo $list->id; ?>" class="modal fade">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h5 class="modal-title">Edit category details</h5>
													</div>
													<?php echo form_open_multipart('backend/landtour_process/update_category', array('class' => 'form-horizontal')); ?>
													<input type="hidden" name="hidden_landtourCategoryID" value="<?php echo $list->id; ?>" />
													<div class="modal-body">			
														<fieldset class="content-group">
															<div class="form-group">
																<label class="control-label col-lg-4">
																	* Category name
																</label>
																<div class="col-lg-8">
																	<input type="text" name="category_name" required class="form-control" value="<?php echo $list->category_name; ?>" />
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-lg-4">
																	* Category Description
																</label>
																<div class="col-lg-8">
																	<textarea name="category_desc" class="form-control" style="resize:none"><?php echo $list->category_desc; ?></textarea>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-lg-4">
																	* Status
																</label>
																<div class="col-lg-8">
																	<select name="category_status" required class="form-control">
																		<?php
																		if( $list->category_status == 1 ) {
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
														<a href="<?php echo base_url(); ?>backend/landtour_process/delete_category/<?php echo $list->id; ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="btn btn-danger">Delete this category</a>
														<button type="submit" class="btn btn-primary">Save changes</button>
													</div>
													<?php echo form_close(); ?>
												</div>
											</div>
										</div>
										<!-- End of Edit land tour category modal -->
									</td>
									<td><?php echo $list->category_desc; ?></td>
									<td>
										<?php
										if( $list->category_status == 1 ) {
										?>
											<b style="color:green">ACTIVE</b>
										<?php
										}
										else {
										?>
											<b style="color:red">INACTIVE</b>
										<?php
										}
										?>
									</td>
									<td>
										<a href="<?php echo base_url(); ?>backend/landtour_process/delete_category/<?php echo $list->id; ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
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
                	<div class="panel">       
                		<div class="add_new_sidebar">              
							<h3 style="padding-left:18px">Add new category</h3>
							<?php echo form_open_multipart('backend/landtour_process/insert_category/', array('class' => 'form-horizontal')); ?>
							<div class="modal-body">	
								<fieldset class="content-group" style="margin-bottom:0px !important">
									<div class="form-group">
										<div class="col-lg-12">
											<input type="text" name="category_name" class="form-control" placeholder="Enter category name" value="<?php echo set_value('category_name'); ?>" />
											<?php echo form_error('category_name'); ?>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<textarea name="category_desc" class="form-control" style="resize:none; height:100px" placeholder="Enter category description" maxlength="180"><?php echo set_value('category_desc'); ?></textarea>
											<?php echo form_error('category_desc'); ?>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<select name="category_status" class="form-control">
												<option value="">Choose category status</option>
												<option value="1">Active</option>
												<option value="0">Inactive</option>
											</select>
											<?php echo form_error('category_status'); ?>
										</div>
									</div>
								</fieldset>
							</div>        
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
							<?php echo form_close(); ?>      						
			                <?php 
							$alert = $this->session->flashdata('alert');
							if( !empty($alert) ) {
							?>
			                    <div style="color: #FF000F; text-align:center; padding: 0px 6px; ">
									<?php echo $alert; ?>
			                    </div>
			                    <div style="clear:both;"></div>
			                <?php
							}
							?>
                    	</div>
                	</div>
                </div>
			</div>
		</div>
		<?php require_once(APPPATH."views/master/footer.php"); ?>
	</div>
</body>
</html>