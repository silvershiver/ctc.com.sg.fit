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
	<?php require_once(APPPATH."views/master/main_navbar.php"); ?>
	<?php require_once(APPPATH."views/master/second_navbar.php"); ?>
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
            	<div class="col-md-8 ">
					<div class="panel panel-flat">
						<h3 style="padding-left: 18px;"><?php echo $title;?></h3>
						<?php echo $this->session->flashdata('session_add_new_category'); ?>
						<?php echo $this->session->flashdata('session_update_category'); ?>
						<?php echo $this->session->flashdata('thisShipIDExist'); ?>
						<?php echo $this->session->flashdata('successDeleteShipID'); ?>
<table class="table datatable-basic">
	<thead>
		<tr>
			<th width="25%">Brand</th>
            <th width="25%">Ship</th>
			<th width="30%">Description</th>
			<th  width="20%" class="text-center">Actions</th>
		</tr>
	</thead>
	<tbody>         
	<?php 
	//get cruise ships
	$ship_query = $this->cruise->get_cruise_ships();
	foreach( $ship_query->result() as $data ) {
	?>
	<tr>
    	<td><?php echo $this->cruise->get_cruise_brands($data->PARENT_BRAND)->row()->NAME;?></td>
        <td>
			<a href="<?php echo base_url();?>backend/product_process/update_cruise_ship/<?php echo $data->ID;?>">
				<?php echo $data->SHIP_NAME;?>
			</a>
		</td>
        <td><?php echo $data->SHIP_DESC;?></td>
        <td>
			<a href="<?php echo base_url();?>backend/product_process/delete_cruise_ship/<?php echo $data->ID;?>" class="btn btn-primary btn-labeled" onclick="return confirm('Are you sure you want to delete this ship?');">
				<b><i class="icon-trash"></i></b> Delete
			</a>
        </td>
	</tr>
	<?php
	}
	?>
	</tbody>
</table>
               	
				</div><!-- //panel -->
                </div><!-- //panel col-8 -->
                
                <div class="col-md-4">
                <div class="panel">
                
				<div class="add_new_sidebar">
                    
   <h3 style="padding-left: 18px;">Add New Ship</h3>
   <?php echo form_open_multipart('backend/product_process/insert_cruise_ship/', array('class' => 'form-horizontal')); ?>
		<div class="modal-body">	
		<fieldset class="content-group" style="margin-bottom:0px !important">
        	<div class="form-group">
				<div class="col-lg-12">
				<select name="ship_brand" class="form-control">
                	<option value="">Please select ship brand</option>
                    <?php 
						//get brand
						$brands_query = $this->cruise->get_cruise_brands();
						foreach($brands_query->result() as $brand){
							?>
                            <option value="<?php echo $brand->ID;?>"><?php echo $brand->NAME;?></option>
                            <?php
						}//foreach
					?>
                </select>
                <?php echo form_error('ship_brand'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
				<input type="text" name="ship_name" class="form-control" placeholder="Enter ship name" value="<?php echo set_value('ship_name'); ?>" />
                <?php echo form_error('ship_name'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
				<textarea name="ship_desc" class="form-control" style="resize:none; height:100px" placeholder="Enter ship description" maxlength="180"><?php echo set_value('ship_desc'); ?></textarea>
                <?php echo form_error('ship_desc'); ?>
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
					if(!empty($alert)){
						?>
                        <div style="color: #FF000F; text-align:center; padding: 0px 6px; ">
							<?php echo $alert; ?>
                        </div>
                        <div style="clear:both;"></div>
                        <?php
					}//if alert
				?>          
                                    
                    </div>
                	
                </div><!-- //panel -->
                </div><!-- //panel col-4 -->
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