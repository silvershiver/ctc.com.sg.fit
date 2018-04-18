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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery_ui/datepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/tags/tagsinput.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/tags/tokenfield.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/prism.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/drilldown.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/anytime.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/legacy.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/jquery-ui.multidatespicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript">
		$(function() {
			$( "#departure_date" ).multiDatesPicker({
				dateFormat: "yy-mm-dd"
			});
			$('#characterLeft').text('0 character(s)');
			$('#ship_desc').keyup(function () {
		    	var len = $(this).val().length;
				$('#characterLeft').text(len + ' character(s) type');
			});
		});
  	</script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/form_tags_input.js"></script>
	<script type="text/javascript">
		//submit form
		$(document).on('submit', '#submitNewCruise', function() {
			var ship_brand 	   = $("#ship_brand").val();
			var ship_name  	   = $("#ship_name").val();
			var noof_night     = $("#noof_night").val();
			var ship_title 	   = $("#ship_title").val();
			var ship_desc  	   = $("#ship_desc").val();
			var departure_port = $("#departure_port").val();
			var departure_date = $("#departure_date").val();
			var ports_of_call  = $("#ports_of_call").val();
			var dataString = 'ship_brand='+ship_brand+'&ship_name='+ship_name+'&noof_night='+noof_night+'&ship_title='+ship_title+'&ship_desc='+ship_desc+'&departure_port='+departure_port+'&departure_date='+departure_date+'&ports_of_call='+ports_of_call;
			if( ship_brand.trim() == '' ) 		   	{ alert("Please choose a ship brand"); 		}
			else if( ship_name.trim() == '' ) 	   	{ alert("Please choose a ship name"); 		}
			else if( noof_night.trim() == '' ) 	   	{ alert("Please choose number of night"); 	}
			else if( ship_title.trim() == '' ) 	   	{ alert("Please enter ship title"); 		}
			else if( ship_desc.trim() == '' ) 	   	{ alert("Please enter ship description"); 	}
			else if( departure_port.trim() == '' ) 	{ alert("Please enter departure port"); 	}
			else if( departure_date.trim() == '' ) 	{ alert("Please enter departure date"); 	}
			else if( ports_of_call.trim() == '' ) 	{ alert("Please enter port(s) of call"); 	}
			else {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backend/product/insert_new_cruiseDetails",
					data: dataString,
					cache: false,
					success: function(result) {
						//alert(result);
						window.location = '<?php echo base_url(); ?>backend/product/cruise_add_new';
					}
				});
			}
			return false;
		});
		//end of submit form
		// Data ports of call
		<?php
		$port_of_call = "";
		$varPortsCall = array();
		$ports = $this->All->select_template_basic("cruise_title");
		foreach( $ports AS $port ) { $port_of_call .= $port->PORTS_OF_CALL; }
		$listPost = explode(";", $port_of_call);
		$listPost = array_unique($listPost);
		foreach( $listPost AS $key => $value ) { $varPortsCall[] = "'".$value."'"; }
		$arrayCruisPort = implode(",", $varPortsCall);
		?>
		var states = [<?php echo $arrayCruisPort; ?>];
    	// End of data ports of call
	</script>
	<style>
	  	.date_field {position: relative; z-index:9999;}
	  	.ui-datepicker{z-index: 9999 !important};
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
				<div class="panel panel-flat">
					<div class="panel-heading">
						<?php echo $this->session->userdata('addNewCruise'); ?>
						<?php echo $this->session->unset_userdata('addNewCruise'); ?>
						<?php echo $this->session->userdata('addNewCruise_error'); ?>
						<?php echo $this->session->unset_userdata('addNewCruise_error'); ?>
						<h5 class="panel-title">Add New Cruise</h5>
						<?php 
							//get selector values || SHIP BRAND
							$ship_brand = $this->session->userdata('ship_brand');
							if(isset($_POST['ship_brand'])){
								$this->session->set_userdata('ship_brand', $_POST['ship_brand']);
								$ship_brand = $this->session->userdata('ship_brand');	
							}
							//get selector values || SHIP NAME
							$ship_name = $this->session->userdata('ship_name');
							if(isset($_POST['ship_name'])){
								$this->session->set_userdata('ship_name', $_POST['ship_name']);
								$ship_name = $this->session->userdata('ship_name');	
							}
							//get selector values || NIGHTS
							$night_type = $this->session->userdata('noof_night');
							if(isset($_POST['noof_night'])){
								$this->session->set_userdata('noof_night', $_POST['noof_night']);
								$night_type = $this->session->userdata('noof_night');	
							}					
						?>
						<form action="#" method="post" class="form-horizontal" id="submitNewCruise">
							<div class="panel-body">
								<fieldset class="content-group">
									
									<div class="form-group">
										<div class="col-lg-12">
											<select name="ship_brand" id="ship_brand" class="form-control" style="width:50%" onChange="submit()">
							                	<option value="">Please select ship brand</option>
							                    <?php 
												$brands_query = $this->cruise->get_cruise_brands();
												foreach($brands_query->result() as $brand){
												?>
							                    	<option value="<?php echo $brand->ID;?>" <?php if($brand->ID == $ship_brand){ echo 'selected';}?>>
														<?php echo $brand->NAME;?></option>
							                    <?php
												}
												?>
							                </select>
										</div>
									</div>
									
									<?php if( !empty($ship_brand) ) { ?>
									<div class="form-group">
										<div class="col-lg-12">
											<select name="ship_name" id="ship_name" class="form-control" style="width:50%" onChange="submit()">
							                	<option value="">Please select ship name</option>
							                    <?php 
												$ships_query = $this->cruise->get_cruise_ships($ship_brand, 'PARENT_BRAND');
												foreach($ships_query->result() as $ship){
												?>
							                    	<option value="<?php echo $ship->ID;?>" 
							                            <?php if($ship->ID == $ship_name){ echo "selected"; } ?> >
														<?php echo $ship->SHIP_NAME;?>
													</option>
							                    <?php
												}
												?>
							                </select>
										</div>
									</div>
									<?php } // if not empty ship name ?>
									
									<?php if( !empty($ship_name) ) { ?>
									<div class="form-group">
										<div class="col-lg-12">
											<select name="noof_night" id="noof_night" class="form-control" style="width:50%" onChange="submit()">
							                	<option value="">Select number of night(s)</option>
						                        <?php 
												$night_count = 0;
												while($night_count < 12){
													$night_count++;
												?>
							                    <option value="<?php echo $night_count;?>" 
					                            	<?php if($night_type == $night_count){ echo "selected"; } ?>>
					                            	<?php echo $night_count;?> Night(s)
					                            </option>
							                    <?php
													}
												?>
							                </select>
										</div>
									</div>
									<?php } // if not empty night_type ?>
									
									<?php 
									if(!empty($ship_brand) AND !empty($ship_name) AND !empty($night_type)){ 
									?>
									<div class="form-group">
										<div class="col-lg-12">
											<input type="text" name="ship_title" id="ship_title" class="form-control" placeholder="Enter ship name / title" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<textarea name="ship_desc" id="ship_desc" class="form-control" style="resize:none; height:250px" placeholder="Enter ship description (Max: 1000 characters)" maxlength="1000"></textarea>
											<div id="characterLeft"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<input type="text" name="departure_port" id="departure_port" class="tagsinput-max-tags" placeholder="Enter departure port (Press enter to insert)" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<input type="text" name="ports_of_call" id="ports_of_call" data-role="tagsinput" class="tagsinput-typeahead" placeholder="Enter ports of call (Press enter to insert)" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar22"></i></span>
												<input type="text" name="departure_date" id="departure_date" class="form-control" placeholder="Please enter departure dates" readonly />
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
									<?php
									}
									?>
								</fieldset>
							</div>
						</form>
					</div>
				</div>
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