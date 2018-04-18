<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Cruise Transaction Management</title>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/uploaders/dropzone.min.js"></script>
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
					<li>
						<a href="<?php echo base_url(); ?>backend/product/cruise_manage_transaction">Cruise Transaction Management</a>
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
								<a href="<?php echo base_url(); ?>backend/product/cruise_manage_transaction">
									<i class="icon-add"></i> Manage Transaction
								</a>
							</li>
						</ul>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- /page header -->

	<!-- Page container -->
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="panel panel-flat">
					<h3 style="padding-left: 8px;"><?php echo $title;?></h3>           
					<table class="table datatable-basic">
						<thead>
							<tr>
								<th>CRUISE TITLE</th>
								<th>SHIP</th>
								<th>DEPARTURE PORT</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						//get cruise summary
						$cruise_titles = $this->cruise->get_cruise_titles()->result();
						foreach($cruise_titles as $cru_title){
							?>					
							<tr>
								<td><?php echo anchor('backend/product/cruise_overview/'.$cru_title->ID, $cru_title->CRUISE_TITLE); ?></td>
								<td><?php echo $this->cruise->get_cruise_ships($cru_title->SHIP_ID)->row()->SHIP_NAME;?></td>		
								<td><?php echo $cru_title->DEPARTURE_PORT;?></td>
                                <td style="text-align:center">
                                    <?php 
									echo anchor('backend/product/delete_cruise/'.$cru_title->ID, "<b><i class='icon-trash'></i></b> Delete", array('onclick'=>"return confirm('Are you sure you want to delete this user? All related data will be deleted too.')")); 
									?>
									&nbsp;&nbsp;&nbsp;
									<?php 
									echo anchor('backend/product/delete_cruise/'.$cru_title->ID, "<b><i class='icon-pencil3'></i></b> Image(s)", array("data-toggle" => "modal", "data-target" => "#manageImage".$cru_title->ID)); 
									?>
<!-- Add image modal -->
<div id="manageImage<?php echo $cru_title->ID; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Manage image</h5>
			</div>
			<?php echo form_open_multipart('backend/product/upload_cruise_img_progress', array('class' => 'dropzone', 'id' => 'dropzone_multiple'.$cru_title->ID)); ?>
				<input type="hidden" name="hidden_cruise_title_id" value="<?php echo $cru_title->ID; ?>" />
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!-- End of Add image modal -->
                                </td>
							</tr>						
						<?php
						}
						?>		
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->
		
	</div>
	<!-- /page container -->

</body>
</html>