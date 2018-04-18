<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Land Tour Product Management</title>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/uploaders/dropzone.min.js?12"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			<?php
			$cruise_scripts = $this->cruise->get_cruise_titles()->result();
			foreach($cruise_scripts as $cruise_script){
			?>
		    $("#dropzone_multiple<?php echo $cruise_script->ID; ?>").dropzone({
		        paramName: "file",
		        dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
		        maxFilesize: 10,
		        acceptedFiles: 'image/*'
		    });

		    <?php
			}
			?>
	    });
	</script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/datatables_basic.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#select_category").on('change', function() {
			    if( $(this).val() == 'hotel_value' ) {
				    $("#hotel_content_ad_form").show();
			        $("#flight_content_ad_form").hide();
			    }
			    else if( $(this).val() == 'flight_value' ) {
			        $("#hotel_content_ad_form").show();
			        $("#flight_content_ad_form").hide();
			    }
			});
		});
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
					<span class="text-semibold">Land Tour Management</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/product/landtour_index">Land Tour Management</a></li>
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
				<?php echo $this->session->flashdata('suspendLandTour'); ?>
				<?php echo $this->session->flashdata('activeLandtour'); ?>
				<?php echo $this->session->flashdata('isDeletedLandtour'); ?>
				<?php
				if( $this->uri->segment(4) == TRUE ) {
				?>
				<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Notification</span>
					Land tour product saved
				</div>
				<?php
				}
				?>
				<div class="panel panel-flat">
					<h3 style="padding-left:8px; text-align:center">Land Tour Item List</h3>
<table class="table datatable-basic">
	<thead>
		<tr>
			<th>Title</th>
			<th>Feature</th>
			<th>Category</th>
			<th>Date</th>
			<th>Status</th>
			<th class="text-center">Actions</th>
		</tr>
	</thead>
	<tbody>
    <?php
	$listItems = $this->All->select_template_with_where_and_order("is_deleted", 0, "id", "DESC", "landtour_product");
	if( $listItems == TRUE ) {
		foreach( $listItems as $listItem ) {
		?>
			<tr>
				<td>
					<a href="<?php echo base_url(); ?>backend/product/landtour_overview/<?php echo $listItem->id; ?>"><?php echo $listItem->lt_title; ?></a>
					<br />
					<span>(<?php echo $listItem->lt_tourID; ?>)</span>
				</td>
				<td>
					<?php echo ($listItem->is_feature == 1) ? "<span style='color:green'><b>FEATURED</b></span>" : "<span style='color:red'><b>NO</b></span>"; ?>
				</td>
				<td><?php echo $this->All->getLandtourCategoryName($listItem->lt_category_id); ?></td>
				<td>
					<span>Start date</span>
					<br />
					<span style="color:green"><b><?php echo date("Y F d", strtotime($listItem->start_date)); ?></b></span>
					<br /><br />
					<span>End date</span>
					<br />
					<span style="color:green"><b><?php echo date("Y F d", strtotime($listItem->end_date)); ?></b></span>
				</td>
				<td>
					<?php
					if( $listItem->is_suspend == 0 ) {
					?>
						<span style="color:green"><b>ACTIVE</b></span>
					<?php
					}
					else {
					?>
						<span style="color:red"><b>INACTIVE</b></span>
					<?php
					}
					?>
				</td>
                <td style="text-align:center">
                    <?php
                    if( $listItem->is_suspend == 0 ) {
                    	echo anchor('backend/landtour_process/make_cruise_inactive/'.$listItem->id, "<b><i class='icon-cross'></i></b> Make it inactive", array('onclick'=>"return confirm('Are you sure you want to suspend this land tour?')"));
                    }
                    else {
                     	echo anchor('backend/landtour_process/make_cruise_active/'.$listItem->id, "<b><i class='icon-check'></i></b> Make it active", array('onclick'=>"return confirm('Are you sure you want to active this land tour?')"));
                    }
					?>
					&nbsp;&nbsp;&nbsp;
					<?php
					echo anchor('#', "<b><i class='icon-pencil3'></i></b> Image(s)", array("data-toggle" => "modal", "data-target" => "#manageImage".$listItem->id));
					?>
					&nbsp;&nbsp;&nbsp;
					<?php
					echo anchor('backend/landtour_process/delete_cruise_from_list/'.$listItem->id, "<b><i class='icon-trash'></i></b> Delete", array('onclick'=>"return confirm('Are you sure you want to delete this land tour from the list?')"));
					?>
					<!-- Add image modal -->
					<div id="manageImage<?php echo $listItem->id; ?>" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h5 class="modal-title">Manage image(s)</h5>
								</div>
								<?php echo form_open_multipart('backend/landtour_process/upload_landtour_img_progress', array('class' => 'dropzone', 'id' => 'dropzone_multiple'.$listItem->id)); ?>
									<input type="hidden" name="hidden_land_tour_id" value="<?php echo $listItem->id; ?>" />
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
					<script>

					        $('#dropzone_multiple<?php echo $listItem->id;?>').dropzone({
						        paramName: "file",
						        dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
						        maxFilesize: 10,
						        acceptedFiles: 'image/*'
						    });
					</script>
					<!-- End of Add image modal -->
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
		</div>
		<?php require_once(APPPATH."views/master/footer.php"); ?>
	</div>
</body>
</html>