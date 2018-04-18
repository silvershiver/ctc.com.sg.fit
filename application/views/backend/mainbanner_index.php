<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTCFITApp - Main Banner Management</title>
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
			<?php 
			$lists = $this->All->select_template_with_order("banner_filename", "ASC", "main_banner");
			if( $lists == TRUE ) {
				foreach( $lists AS $list ) {
			?>
			$('#tabledivbodySortMainBanner').sortable({
				items: "tr", cursor: 'move', opacity: 0.6,
				update: function() {
					var order = $("#tabledivbodySortMainBanner").sortable("serialize");
					$.ajax({
				        type: "POST", dataType: "json", url: "<?php echo base_url(); ?>backend/mainbanner/doStateroomOrder",
				        data: order,
				        success: function(response) {
				            if (response.status == "success") { alert("Record(s) position has been changed"); } 
				            else { alert('Some error occurred'); }
				        }
				    });
        		}
			});
			<?php
				}
			}
			?>
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
<body class="sidebar-xs">
	<?php require_once(APPPATH."views/master/main_navbar.php"); ?>
	<?php require_once(APPPATH."views/master/second_navbar.php"); ?>
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Banner - Management</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/mainbanner">Banner - Management</a></li>
				</ul>
			</div>
			<?php require_once(APPPATH."views/master/heading_element.php"); ?>
		</div>
	</div>
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">Add new banner</h5>
		                	</div>
							<div class="panel-body">
								<?php echo $this->session->flashdata('addBannerSuccess'); ?>
								<?php echo form_open_multipart('backend/mainbanner/addBanner/', array('class' => 'form-horizontal')); ?>
									<div class="form-group">
			                        	<label class="control-label col-lg-2">Banner Size Info</label>
			                        	<div class="col-lg-8">
				                            <div style="margin-top:8px; color:green">
					                            <b>Recommended size: (W)1000px X (H)574px</b>
					                        </div>
				                            <div>*Note: If no banner image uploaded, this image below will be put as default.</div>
				                            <div>
					                            <img src="<?php echo base_url(); ?>assets/images/slider/imgNEWA.jpg" width="400" height="250" />
				                            </div>
			                            </div>
			                        </div>
			                        <div class="form-group">
			                        	<label class="control-label col-lg-2">Choose Banner File</label>
			                        	<div class="col-lg-8">
				                            <input type="file" name="choose_banner_file" required accept="image/*" class="form-control" />
			                            </div>
			                        </div>
									<div class="text-right">
										<button type="submit" class="btn btn-primary">
											Upload File <i class="icon-arrow-right14 position-right"></i>
										</button>
									</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<?php echo $this->session->flashdata('deleteBannerSuccess'); ?>
								<h5 class="panel-title">Banner List</h5>
								<table class="table cruiseTable">
								  	<thead>
								        <tr>
								            <th style="text-align:left">Image Preview</th>
										  	<th style="text-align:left">Size</th>
										  	<th style="text-align:left">Type</th>
										  	<th style="text-align:left">Created on</th>
										  	<th style="text-align:left">Action</th>
								        </tr>
								    </thead>
								    <tbody id="tabledivbodySortMainBanner">
									    <?php
										$lists = $this->All->select_template_with_order("orderNo", "ASC", "main_banner");
										if( $lists == TRUE ) {
											foreach( $lists AS $list ) {
										?>
									    <tr id="sectionsid_<?php echo $list->id; ?>">
										    <th>
											    <img src="<?php echo base_url(); ?>assets/main-banner/<?php echo $list->banner_filename; ?>" width="300" height="150" />
										    </th>
										    <th>
											    (W)<?php echo $list->banner_size_width; ?>px 
											    x 
											    (H)<?php echo $list->banner_size_height; ?>px
											</th>
										    <th>.<?php echo $list->banner_type; ?></th>
										    <th><?php echo $list->created; ?></th>
										    <th>
												<a href="<?php echo base_url(); ?>backend/mainbanner/doDeleteBanner/<?php echo $list->id; ?>" onclick="return confirm('Are you sure you want to delete this banner?');" class="btn btn-primary btn-labeled">
													<b><i class="icon-trash"></i></b> Delete
												</a>
										    </th>
									    </tr>
									    <?php
										    }
										}   
										?>
								    </tbody>
								</table>
		                	</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require_once(APPPATH."views/master/footer.php"); ?>
	</div>
</body>
</html>