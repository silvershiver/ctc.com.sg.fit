<!-- 
	
    Period Types
    Low | ID: 3
    Shoulder: | ID: 2
    Peak | ID: 1
	
    Prices for ATT1, 2, 3, 4
    
   	*Set date rules to apply for period types across date ranges and specific dates
    Compulsory to set or prices wont appear.
    
-->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - <?php echo $title; ?></title>
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
					<span class="text-semibold"><a href="<?php echo base_url(); ?>backend/product/cruise_index">Cruise management</a></span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/product/cruise_index">Cruise management</a></li>
					<li><a href="<?php echo base_url(); ?>backend/product/cruise_manage_brand"><?php echo $title; ?></a></li>
				</ul>
			</div><!-- //page title -->
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
            <div class="heading-elements">
            	<div style="float:right; margin-right:10px; margin-top:-25px">
                
        <a href="<?php echo base_url();?>backend/product/cruise_add_new_prices" class="btn btn-primary btn-labeled">
		<b><i class="glyphicon glyphicon-plus"></i></b> Add New Cruise Prices
		</a>
                
                </div>
            </div>
			
		</div>
	</div>
	<!-- /page header -->

	<!-- Page container -->
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
            	<div class="col-md-12">
				<div class="panel panel-flat">
                
                <h3 style="padding-left: 8px;"><?php echo $title;?></h3>
                
					<?php echo $this->session->flashdata('session_add_new_category'); ?>
					<?php echo $this->session->flashdata('session_update_category'); ?>
					
					<table class="table datatable-basic">
						<thead>
							<tr>
								<th width="25%">Brand</th>
                                <th width="25%">Ship</th>
								<th width="25%">Description</th>
								<th width="25%"></th>
							</tr>
						</thead>
                    
<?php 
	//get cruise ships
	$ship_query = $this->cruise->get_cruise_ships();
	foreach($ship_query->result() as $data){
?>
	<tr>
    	 <td><?php echo $this->cruise->get_cruise_brands($data->PARENT_BRAND)->row()->NAME;?></td>
         <td>
		 <a href="<?php echo base_url();?>backend/product_process/update_cruise_ship/<?php echo $data->ID;?>"><?php echo $data->SHIP_NAME;?></a>
		 </td>
        <td><?php echo $data->SHIP_DESC;?></td>
        
        <td style="text-align:right;">
        <a href="<?php echo base_url();?>backend/product_process/update_cruise_ship_prices/<?php echo $data->ID;?>" class="btn btn-primary btn-labeled">
		<b><i class="glyphicon glyphicon-pencil"></i></b> Update 
        </a>
        
		<a href="<?php echo base_url();?>backend/product_process/delete_cruise_ship_prices/<?php echo $data->ID;?>" class="btn btn-primary btn-labeled" onclick="return confirm('Are you sure you want to delete this ship?');">
		<b><i class="icon-trash"></i></b> Delete
		</a>
        </td>
	</tr>
<?php 
	}//end foreach
?>
					
						

								</td>
							</tr>
						</tbody>
					</table>
               	
				</div><!-- //panel -->
                </div><!-- //panel col-12 -->
                
			</div>
		</div>
		<!-- /page content -->

		<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->

	</div>
	<!-- /page container -->

</body>
</html>