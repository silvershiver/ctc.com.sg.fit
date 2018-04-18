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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
	<script type="text/javascript">
		//delete link
	  	$(document).ready(function() {
		  	$('a#deleteExtraChargeSTT').click(function(){
		        $.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Extra charge price removed');
		            }
		        );
		        $(this).closest("div.form-group").remove();
		        return false;
		    });
		});
		$(document).ready(function() {
		  	$('a#deleteDiscountSTT').click(function(){
		        $.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Discount value removed');
		            }
		        );
		        $(this).closest("div.form-group").remove();
		        return false;
		    });
		});
	  	//end of delete link
		//submit form extra charge
		<?php 
		$brands_query = $this->cruise->get_cruise_brands();
		foreach($brands_query->result() as $brand) {
			$ships_query = $this->cruise->get_cruise_ships($brand->ID, "PARENT_BRAND");
			foreach($ships_query->result() as $ship) {
				$strm_query = $this->cruise->get_staterooms($brand->ID, $ship->ID);
				foreach($strm_query->result() as $strm) {
		?>
		$(document).on('submit', '#stateroomEXTRACHARGE<?php echo $strm->ID; ?>', function() {
			var sttID = $("#hidden_stt_id<?php echo $strm->ID; ?>").val();
			var sttChargeName  = $("#sttChargeName<?php echo $strm->ID; ?>").val();
			var sttChargePrice = $("#sttChargePrice<?php echo $strm->ID; ?>").val();
			var dataString 	   = 'sttID='+sttID+'&sttChargeName='+sttChargeName+'&sttChargePrice='+sttChargePrice;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>backend/product/insertSTTExtraCharge",
				data: dataString,
				cache: false,
				dataType:'JSON',
				success: function(result) {
					if( result.errorCode == 1 ) {
						alert(result.message);
					}
					else {
						$("#ulListSTTExtraCharge<?php echo $strm->ID; ?>").append('<div class="form-group"><div class="col-lg-4" style="text-align:center"><span style="color:green"><b>'+result.extraPriceName+'</b></span></div><div class="col-lg-4" style="text-align:center"><span style="color:green"><b>$'+result.extraPriceValue+'</b></span></div><div class="col-lg-4" style="text-align:center"><a href="" style="text-decoration:underline">Delete extra charge</a></div></div><br />');
					}
				}
			});
			return false;
		});	
		$(document).on('submit', '#stateroomDISCOUNT<?php echo $strm->ID; ?>', function() {
			var sttID 		= $("#hidden_stt_id<?php echo $strm->ID; ?>").val();
			var sttDiscount = $("#sttDiscountValue<?php echo $strm->ID; ?>").val();
			var dataString 	= 'sttID='+sttID+'&sttDiscount='+sttDiscount;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>backend/product/insertSTTDiscount",
				data: dataString,
				cache: false,
				dataType:'JSON',
				success: function(result) {
					if( result.errorCode == 1 ) {
						alert(result.message);
					}
					else {
						$("#ulListSTTDiscountValue<?php echo $strm->ID; ?>").append('<div class="form-group"><div class="col-lg-4" style="text-align:center"><span style="color:green"><b>Discount value</b></span></div><div class="col-lg-4" style="text-align:center"><span style="color:green"><b>$'+result.discountValue+'</b></span></div><div class="col-lg-4" style="text-align:center"><a href="" style="text-decoration:underline">Delete discount</a></div></div><br />');
					}
				}
			});
			return false;
		});
		<?php
				}
			}
		}
		?>
		//end of submit form extra charge
		//save change edit record process
		$(function () {
			<?php 
			$brands_query = $this->cruise->get_cruise_brands();
			foreach($brands_query->result() as $brand) {
				$ships_query = $this->cruise->get_cruise_ships($brand->ID, "PARENT_BRAND");
				foreach($ships_query->result() as $ship) {
					$strm_query = $this->cruise->get_staterooms($brand->ID, $ship->ID);
					foreach($strm_query->result() as $strm) {
			?>
			$("#saveEdit_sectionsid_<?php echo $strm->ID; ?>").click(function() {
				var stateroomID = $("#stateroomID_<?php echo $strm->ID; ?>").val();
				var nameEdit = $("#nameEdit_sectionsid_<?php echo $strm->ID; ?>").val();
				var occuEdit = $("#occupantEdit_sectionsid_<?php echo $strm->ID; ?>").val();
				if(nameEdit.length>0&& occuEdit.length>0) {
					var dataString = 'sttID='+stateroomID+'&sttName='+nameEdit+'&sttOccupant='+occuEdit;
					$.ajax({
						type: "POST",
						url: "<?php echo base_url(); ?>backend/product/updateNewStateroom",
						data: dataString,
						cache: false,
						dataType:'JSON',
						success: function(result) {
							alert(result.message);
							$("#name_sectionsid_<?php echo $strm->ID; ?>").text(result.stateName);
							$("#occupant_sectionsid_<?php echo $strm->ID; ?>").text(result.stateOccupant);
							$("#nameEdit_sectionsid_<?php echo $strm->ID; ?>").val(result.stateName);
							$("#occupantEdit_sectionsid_<?php echo $strm->ID; ?>").val(result.stateOccupant);
							$("#UnableEditMode_sectionsid_<?php echo $strm->ID; ?>").show();
							$("#EnableEditMode_sectionsid_<?php echo $strm->ID; ?>").hide();
							$("#name_sectionsid_<?php echo $strm->ID; ?>").show();
							$("#occupant_sectionsid_<?php echo $strm->ID; ?>").show();
							$("#nameEdit_sectionsid_<?php echo $strm->ID; ?>").hide();
							$("#occupantEdit_sectionsid_<?php echo $strm->ID; ?>").hide();
						}
					});
				}
				else {
					alert("Please fill up all the textfields");
				}
		        return false;
			});
			$(document).on('click', '#saveEdit_sectionsid_<?php echo $strm->ID; ?>', function(e){
				var stateroomID = $("#stateroomID_<?php echo $strm->ID; ?>").val();
				var nameEdit = $("#nameEdit_sectionsid_<?php echo $strm->ID; ?>").val();
				var occuEdit = $("#occupantEdit_sectionsid_<?php echo $strm->ID; ?>").val();
				if(nameEdit.length>0&& occuEdit.length>0) {
					var dataString = 'sttID='+stateroomID+'&sttName='+nameEdit+'&sttOccupant='+occuEdit;
					$.ajax({
						type: "POST",
						url: "<?php echo base_url(); ?>backend/product/updateNewStateroom",
						data: dataString,
						cache: false,
						dataType:'JSON',
						success: function(result) {
							alert(result.message);
							$("#name_sectionsid_<?php echo $strm->ID; ?>").text(result.stateName);
							$("#occupant_sectionsid_<?php echo $strm->ID; ?>").text(result.stateOccupant);
							$("#nameEdit_sectionsid_<?php echo $strm->ID; ?>").val(result.stateName);
							$("#occupantEdit_sectionsid_<?php echo $strm->ID; ?>").val(result.stateOccupant);
							$("#UnableEditMode_sectionsid_<?php echo $strm->ID; ?>").show();
							$("#EnableEditMode_sectionsid_<?php echo $strm->ID; ?>").hide();
							$("#name_sectionsid_<?php echo $strm->ID; ?>").show();
							$("#occupant_sectionsid_<?php echo $strm->ID; ?>").show();
							$("#nameEdit_sectionsid_<?php echo $strm->ID; ?>").hide();
							$("#occupantEdit_sectionsid_<?php echo $strm->ID; ?>").hide();
						}
					});
				}
				else {
					alert("Please fill up all the textfields");
				}
		        return false;
			});
			<?php
					}
				}
			}
			?>
		});
		//end of save change edit record process	
		//cancel edit record process
		<?php 
		$brands_query = $this->cruise->get_cruise_brands();
		foreach($brands_query->result() as $brand) {
			$ships_query = $this->cruise->get_cruise_ships($brand->ID, "PARENT_BRAND");
			foreach($ships_query->result() as $ship) {
				$strm_query = $this->cruise->get_staterooms($brand->ID, $ship->ID);
				foreach($strm_query->result() as $strm) {
		?>
		$(document).on('click', '#cancelEdit_sectionsid_<?php echo $strm->ID; ?>', function(e){
			$("#UnableEditMode_sectionsid_<?php echo $strm->ID; ?>").show();
			$("#EnableEditMode_sectionsid_<?php echo $strm->ID; ?>").hide();
			$("#name_sectionsid_<?php echo $strm->ID; ?>").show();
			$("#occupant_sectionsid_<?php echo $strm->ID; ?>").show();
			$("#nameEdit_sectionsid_<?php echo $strm->ID; ?>").hide();
			$("#occupantEdit_sectionsid_<?php echo $strm->ID; ?>").hide();
	        return false;
		});
		<?php
				}
			}
		}
		?>
		//end of cancel edit record process
		//update statement record
		<?php 
		$brands_query = $this->cruise->get_cruise_brands();
		foreach($brands_query->result() as $brand) {
			$ships_query = $this->cruise->get_cruise_ships($brand->ID, "PARENT_BRAND");
			foreach($ships_query->result() as $ship) {
		?>
		$(document).ready(function() {
			$("table#stateroomTable<?php echo $ship->ID; ?> .editButtonSTT").click(function() {
				var attributeID = $(this).attr('id');
				$("#UnableEditMode_"+attributeID).hide();
				$("#EnableEditMode_"+attributeID).show();
				$("#name_"+attributeID).hide();
				$("#occupant_"+attributeID).hide();
				$("#nameEdit_"+attributeID).show();
				$("#occupantEdit_"+attributeID).show();
		        return false;
		    });
		});
		$(document).on('click', 'table#stateroomTable<?php echo $ship->ID; ?> .editButtonSTT', function(e){
			var attributeID = $(this).attr('id');
			$("#UnableEditMode_"+attributeID).hide();
			$("#EnableEditMode_"+attributeID).show();
			$("#name_"+attributeID).hide();
			$("#occupant_"+attributeID).hide();
			$("#nameEdit_"+attributeID).show();
			$("#occupantEdit_"+attributeID).show();
	        return false;
		});
		<?php
			}
		}
		?>
		//end of update statement record
		//delete stateroom record
	  	$(document).ready(function() {
		  	$('a#delete_cruise_stateroom').click(function(){
		        $.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Stateroom record deleted');
		            }
		        );
		        $(this).closest("tr.deleteRow").remove();
		        return false;
		    });
		});
		$(document).on('click', 'a#delete_cruise_stateroom', function(e){
			$.get(
	            $(this).attr('href'),
	            {},
	            function(data) {
	                alert('Stateroom record deleted');
	            }
	        );
	        $(this).closest("tr.deleteRow").remove();
		    return false;
		});
	  	//end of delete stateroom record
		//submit form add new stateroom
		<?php
		$brands_query = $this->cruise->get_cruise_brands();
		foreach($brands_query->result() as $brand) {
			$ships_query = $this->cruise->get_cruise_ships($brand->ID, "PARENT_BRAND");
			foreach($ships_query->result() as $ship) {
		?>
		$(document).on('submit', '#addStateroomFORM<?php echo $ship->ID; ?>', function() {
			var stateroomBrandID 	  = $("#brandID<?php echo $ship->ID; ?>").val();
			var stateroomShipID  	  = $("#shipID<?php echo $ship->ID; ?>").val();
			var stateroomName 	 	  = $("#stateroom_name<?php echo $ship->ID; ?>").val();
			var stateroomNoofoccupant = $("#stateroom_noofoccupant<?php echo $ship->ID; ?>").val();
			var dataString = 'brandID='+stateroomBrandID+'&shipID='+stateroomShipID+'&stateroomName='+stateroomName+'&stateroomOccupant='+stateroomNoofoccupant;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>backend/product/insertNewStateroom",
				data: dataString,
				cache: false,
				dataType:'JSON',
				success: function(result) {
					if( result.errorCode == 1 ) {
						alert(result.message);
					}
					else {
						$('#stateroomTable<?php echo $ship->ID; ?> tbody tr:last').after('<tr><td>'+result.stateName+'</td><td style="text-align:center;">'+result.stateOccupant+'</td><td style="text-align:center;"><div id="UnableEditMode_sectionsid_'+result.stateRoomID+'"><a href="<?php echo base_url();?>backend/product_process/delete_cruise_stateroom/'+result.stateRoomID+'/'+stateroomShipID+'/'+stateroomBrandID+'" id="delete_cruise_stateroom" onclick="return confirm(\'Are you sure you want to delete this stateroom?\');"><b><i class="icon-trash"></i></b></a></div></td></tr>');
					}
				}
			});
			return false;
		});
		<?php
			}
		}
		?>
		//end of submit form date rule
	</script>
	<script type="text/javascript">
		// Sortable rows
		$(function  () {
			<?php 
			$brands_query = $this->cruise->get_cruise_brands();
			foreach($brands_query->result() as $brand) {
				$ships_query = $this->cruise->get_cruise_ships($brand->ID, "PARENT_BRAND");
				foreach($ships_query->result() as $ship) {
					$shipName  = preg_replace('/\s+/', '', $ship->SHIP_NAME);
					$shipNameA = str_replace("'", "", $shipName);
					$shipNameB = str_replace("(", "", $shipNameA);
					$shipNameC = str_replace(")", "", $shipNameB);
			?>
			$('#tabledivbody<?php echo $shipNameC; ?>').sortable({
				items: "tr", cursor: 'move', opacity: 0.6,
				update: function() {
					var order = $("#tabledivbody<?php echo $shipNameC; ?>").sortable("serialize");
					$.ajax({
				        type: "POST", dataType: "json", url: "<?php echo base_url(); ?>backend/product/doStateroomOrder",
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
				<div class="row">
					<div class="col-lg-12">
						<h3 style="padding-left:8px; margin-top:-10px"><?php echo $title;?></h3>
						<div style="text-align:right">
							<i>** Please drag and drop the table row below for sorting record ordering</i>
						</div>
						<div class="row">
							<?php 
							$brands_query = $this->cruise->get_cruise_brands();
							foreach($brands_query->result() as $brand) {
								$ships_query = $this->cruise->get_cruise_ships($brand->ID, "PARENT_BRAND");
								foreach($ships_query->result() as $ship) {
									$shipName  = preg_replace('/\s+/', '', $ship->SHIP_NAME);
									$shipNameA = str_replace("'", "", $shipName);
									$shipNameB = str_replace("(", "", $shipNameA);
									$shipNameC = str_replace(")", "", $shipNameB);
							?>
							<div class="col-lg-6">
								<div class="panel panel-flat">
									<div class="panel-heading" style="text-align:center">
										<h5 style="padding-left: 8px;"><?php echo $brand->NAME;?></h5>
										<h6 class="panel-title"><?php echo $ship->SHIP_NAME; ?></h6>
									</div>								
									<div class="table-responsive">
<table class="table text-nowrap" id="stateroomTable<?php echo $ship->ID; ?>">
	<thead>
		<tr>
			<th>Stateroom Name</th>
			<th style="text-align:center">Occupant</th>
			<th style="text-align:center" width="20%" class="text-center">Action</th>
		</tr>
	</thead>
	<tbody id="tabledivbody<?php echo $shipNameC; ?>">
	    <?php
	    $strm_query = $this->cruise->get_staterooms($brand->ID, $ship->ID);
	    foreach($strm_query->result() as $strm) {
	    ?>
	    <tr class="deleteRow editRow" id="sectionsid_<?php echo $strm->ID; ?>">
	    	<td id="editTD">
		    	<div id="name_sectionsid_<?php echo $strm->ID; ?>"><?php echo $strm->STATEROOM_NAME; ?></div>
		    	<div class="editMode">
			    	<input type="text" class="form-control editbox" id="nameEdit_sectionsid_<?php echo $strm->ID; ?>" value="<?php echo $strm->STATEROOM_NAME; ?>">
			    </div>
		    </td>
	    	<td style="text-align:center" id="editTD">
		    	<div id="occupant_sectionsid_<?php echo $strm->ID; ?>"><?php echo $strm->STATEROOM_OCCUPANT; ?></div>
		    	<div class="editMode">
			    	<input type="text" class="form-control editbox" id="occupantEdit_sectionsid_<?php echo $strm->ID; ?>" style="text-align:center" value="<?php echo $strm->STATEROOM_OCCUPANT; ?>">
			    </div>
		    </td>
	        <td style="text-align:center;">
		        <div id="UnableEditMode_sectionsid_<?php echo $strm->ID; ?>">
		        	<a href="<?php echo base_url();?>backend/product_process/delete_cruise_stateroom/<?php echo $strm->ID; ?>/<?php echo $ship->ID; ?>/<?php echo $brand->ID; ?>" id="delete_cruise_stateroom" onclick="return confirm('Are you sure you want to delete this stateroom?');">
						<b><i class="icon-trash"></i></b>
					</a>
					&nbsp;&nbsp;
					<a href="#" class="editButtonSTT" id="sectionsid_<?php echo $strm->ID; ?>">
						<b><i class="icon-pencil"></i></b>
					</a>
		        </div>
		        <div id="EnableEditMode_sectionsid_<?php echo $strm->ID; ?>" class="EnableEditMode">
			        <input type="hidden" name="stateroomID" id="stateroomID_<?php echo $strm->ID; ?>" value="<?php echo $strm->ID; ?>">
		        	<button id="saveEdit_sectionsid_<?php echo $strm->ID; ?>" class="btn btn-primary btn-xs" style="margin-top: 3px;">Save change</button>
		        	<button id="cancelEdit_sectionsid_<?php echo $strm->ID; ?>" class="btn btn-primary btn-xs" style="margin-top: 3px;">Cancel</button>
		        </div>
	        </td>
	    </tr>
	    <?php
	    }
	    ?>
	    <tr></tr>
	</tbody>
    <tfoot>
	    <tr>
		    <?php echo form_open_multipart('#', array('class' => 'form-horizontal', 'id' => 'addStateroomFORM'.$ship->ID)); ?> 
	    	<td style="padding: 8px;" colspan="4">
		    	<div style="float:left; margin-right:10px">
			    	<input type="text" style="width:100%" name="stateroom_name" id="stateroom_name<?php echo $ship->ID; ?>" class="form-control" placeholder="Enter Name" required />
		    	</div>
		    	<div style="float:left; margin-right:10px">
			    	<input type="text" style="width:100%; text-align:center" name="stateroom_noofoccupant" id="stateroom_noofoccupant<?php echo $ship->ID; ?>" class="form-control" placeholder="Enter No. Occupant" maxlength="2" required pattern="[0-9]{1,2}" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" required />
		    	</div>
		    	<div style="float:left; margin-right:10px">
		    		<button type="submit" class="btn btn-primary btn-xs" style="margin-top: 3px;">Add new stateroom</button>
		    	</div>
	        	<div style="clear:both"></div>
				<input type="hidden" name="brand" id="brandID<?php echo $ship->ID; ?>" value="<?php echo $brand->ID;?>">
				<input type="hidden" name="ship" id="shipID<?php echo $ship->ID; ?>" value="<?php echo $ship->ID;?>">
	        </td>
	        <?php echo form_close(); ?>
	    </tr>
    </tfoot>
</table>
									</div>
								</div>
							</div>
							<?php
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->
	</div>
</body>
</html>