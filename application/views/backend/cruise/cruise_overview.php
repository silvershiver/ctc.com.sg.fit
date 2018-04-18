<?php
	$cruises = $this->All->select_template("ID", $this->uri->segment(4), "cruise_title");
	foreach( $cruises AS $cruise ) {
		$shipgetID 	   		   	 = $cruise->SHIP_ID;
		$shipgetCRUISE_TOUR_CODE = $cruise->CRUISE_TOUR_CODE;
		$shipgetCRUISE_TITLE   	 = $cruise->CRUISE_TITLE;
		$shipgetCRUISE_DESC    	 = $cruise->CRUISE_DESC;
		$shipgetDEPARTURE_PORT 	 = $cruise->DEPARTURE_PORT;
		$shipgetDEPARTURE_DATE 	 = $cruise->DEPARTURE_DATE;
		$shipgetPORTS_OF_CALL  	 = $cruise->PORTS_OF_CALL;
		$shipgetNIGHTS 		   	 = $cruise->NIGHTS;
		$shipgetSTARTING_PRICE   = $cruise->STARTING_PRICE;
	}
	?>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/uploaders/dropzone.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/anytime.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/legacy.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/jquery-ui.multidatespicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#datepickerFROMLOW").datepicker({dateFormat:"yy-mm-dd"});
			$("#datepickerTOLOW").datepicker({dateFormat:"yy-mm-dd"});
			$("#datepickerFROMSHOULDER").datepicker({dateFormat:"yy-mm-dd"});
			$("#datepickerTOSHOULDER").datepicker({dateFormat:"yy-mm-dd"});
			$("#datepickerFROMPEAK").datepicker({dateFormat:"yy-mm-dd"});
			$("#datepickerTOPEAK").datepicker({dateFormat:"yy-mm-dd"});
			$('#characterLeft').text('<?php echo strlen($shipgetCRUISE_DESC); ?> character(s)');
			$('#ship_desc').keyup(function () {
		    	var len = $(this).val().length;
				$('#characterLeft').text(len + ' character(s) type');
			});
  		});
  	</script>
	<script type="text/javascript">
		$(function() {
			$("#arrivalTime").AnyTime_picker({ format: "%H:%i" });
			$("#departureTime").AnyTime_picker({ format: "%H:%i" });	
		});
		$(function() {
			$("#departure_date").multiDatesPicker({
				dateFormat: "yy-mm-dd",
				altField: '#altField'
			});
		});
		//save change edit record process
		$(function () {
			<?php 
			$staterooms = $this->All->select_template_with_where2_and_order(
				"CRUISE_BRAND_ID", 	$this->All->getCruiseBrandID($shipgetID), 
				"CRUISE_SHIP_ID", 	$shipgetID, 
				"orderNo", "ASC", 
				"cruise_stateroom"
			);
			if( $staterooms == TRUE ) {
				foreach( $staterooms AS $stateroom ) {
			?>
			$("#saveEdit_sectionsid_<?php echo $stateroom->ID; ?>").click(function() {
				var stateroomID = $("#stateroomID_<?php echo $stateroom->ID; ?>").val();
				var qtyEdit     = $("#qtyEdit_sectionsid_<?php echo $stateroom->ID; ?>").val();
				if( qtyEdit.length > 0 ) {
					var dataString = 'titleID=<?php echo $this->uri->segment(4); ?>&shipID=<?php echo $shipgetID; ?>&brandID=<?php echo $this->All->getCruiseBrandID($shipgetID); ?>&sttID='+stateroomID+'&qty='+qtyEdit;
					$.ajax({
						type: "POST",
						url: "<?php echo base_url(); ?>backend/product/updateIndividualStateroom",
						data: dataString,
						cache: false,
						dataType:'JSON',
						success: function(result) {
							alert(result.message);
							$("#qty_sectionsid_<?php echo $stateroom->ID; ?>").text(result.stateQty);
							$("#qtyEdit_sectionsid_<?php echo $stateroom->ID; ?>").val(result.stateQty);
							$("#UnableEditMode_sectionsid_<?php echo $stateroom->ID; ?>").show();
							$("#EnableEditMode_sectionsid_<?php echo $stateroom->ID; ?>").hide();
							$("#qty_sectionsid_<?php echo $stateroom->ID; ?>").show();
							$("#qtyEdit_sectionsid_<?php echo $stateroom->ID; ?>").hide();
						}
					});
				}
				else {
					alert("Please enter stateroom quantity");
				}
		        return false;
			});
			<?php
				}
			}
			?>
		});
		//end of save change edit record process
		//cancel edit record process
		$(function () {
			<?php 
			$staterooms = $this->All->select_template_with_where2_and_order(
				"CRUISE_BRAND_ID", 	$this->All->getCruiseBrandID($shipgetID), 
				"CRUISE_SHIP_ID", 	$shipgetID, 
				"orderNo", "ASC", 
				"cruise_stateroom"
			);
			if( $staterooms == TRUE ) {
				foreach( $staterooms AS $stateroom ) {
			?>
			$("#cancelEdit_sectionsid_<?php echo $stateroom->ID; ?>").click(function() {
				$("#UnableEditMode_sectionsid_<?php echo $stateroom->ID; ?>").show();
				$("#EnableEditMode_sectionsid_<?php echo $stateroom->ID; ?>").hide();
				$("#qty_sectionsid_<?php echo $stateroom->ID; ?>").show();
				$("#qtyEdit_sectionsid_<?php echo $stateroom->ID; ?>").hide();
		        return false;
			});
			<?php
				}
			}
			?>
		});
		//end of cancel edit record process
		//update statement record
		$(document).ready(function() {
			$("table#stateroomTable .editButtonSTT").click(function() {
				var attributeID = $(this).attr('id');
				$("#UnableEditMode_"+attributeID).hide();
				$("#EnableEditMode_"+attributeID).show();
				$("#qty_"+attributeID).hide();
				$("#qtyEdit_"+attributeID).show();
		        return false;
		    });
		});
		//end of update statement record
		//image upload
		$(document).ready(function() {
			Dropzone.autoDiscover = false;
			$("#dropzone_multiple").dropzone({
				acceptedFiles: 'image/*',
				url: '<?php echo base_url(); ?>backend/product/uploadImage/<?php echo $this->uri->segment(4); ?>',
		        paramName: "file",
		        dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
		        maxFiles: 10,
		        maxFilesize: 10,
		        maxfilesexceeded: function(file)
				{
					alert('You have uploaded more than 10 images. Only 10 files can be uploaded at the same stime');
				},
				success: function (response) {
					var x = JSON.parse(response.xhr.responseText);
					$('#cruiseImageTable tbody tr:last').after('<tr id="deleteRowImage"><td><a href="<?php echo base_url(); ?>assets/cruise_img/'+x.fileName+'" target="_blank" style="text-decoration:underline">'+x.fileName+'</a></td><td style="text-align:center"><span style="color:black"><b>DEFAULT</b></span><br /><span style="font-size:11px"><i><a href="<?php echo base_url(); ?>backend/product/setPrimaryImage/'+x.fileID+'/<?php echo $this->uri->segment(4); ?>">(Click to set to primary)</a></i></span></td><td>'+x.fileSize+'</td><td>'+x.fileType+'</td><td>'+x.fileCreated+'</td><td><a href="<?php echo base_url(); ?>backend/product/deleteCruiseImage/'+x.fileID+'" id="deleteCruiseImage" class="btn btn-primary btn-labeled"><b><i class="icon-trash"></i></b> Delete image</a></td></tr>');
				}
		    });
	    });
		//end of image upload
		//PDF upload
		$(document).ready(function() {
			Dropzone.autoDiscover = false;
			$("#dropzone_pdf").dropzone({
				acceptedFiles: 'application/pdf',
				url: '<?php echo base_url(); ?>backend/product/uploadPDF/<?php echo $this->uri->segment(4); ?>',
		        paramName: "file",
		        dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
		        maxFiles: 1,
		        maxFilesize: 10,
		        maxfilesexceeded: function(file)
				{
					alert('You have uploaded more than 1 pdf. Only 1 PDF file can be uploaded at the same stime');
				},
				success: function (response) {
					var x = JSON.parse(response.xhr.responseText);
					$('#cruisePDFTable tbody tr:last').after('<tr id="deleteRowPDF"><td><a href="<?php echo base_url(); ?>assets/cruise_pdf/'+x.fileName+'" target="_blank" style="text-decoration:underline">'+x.fileName+'</a></td><td>'+x.fileSize+'</td><td>'+x.fileType+'</td><td>'+x.fileCreated+'</td><td><a href="<?php echo base_url(); ?>backend/product/deleteCruisePDF/'+x.fileID+'" id="deleteCruisePDF" class="btn btn-primary btn-labeled"><b><i class="icon-trash"></i></b> Delete PDF</a></td></tr>');
				}
		    });
	    });
		//end of image PDF
		//delete itinerary details
	  	$(document).ready(function() {
		  	$('a#deleteItineraryDetails').click(function(){
		        $.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Cruise itinerary removed');
		            }
		        );
		        $(this).closest("tr#deleteRow").remove();
		        return false;
		    });
		});
		$(document).on('click', 'a#deleteItineraryDetails', function(e){
			$.get(
	            $(this).attr('href'),
	            {},
	            function(data) {
	                alert('Cruise itinerary removed');
	            }
	        );
	        $(this).closest("tr#deleteRow").remove();
	        return false;
		});
	  	//end of delete itinerary details
	  	//delete cruise image
	  	$(document).ready(function() {
		  	$('a#deleteCruiseImage').click(function(){
		        $.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Image deleted');
		            }
		        );
		        $(this).closest("tr#deleteRowImage").remove();
		        return false;
		    });
		});
		$(document).on('click', 'a#deleteCruiseImage', function(e){
			$.get(
	            $(this).attr('href'),
	            {},
	            function(data) {
	               alert('Image deleted');
	            }
	        );
	        $(this).closest("tr#deleteRowImage").remove();
	        return false;
		});
	  	//end of delete cruise image
	  	//delete cruise pdf
	  	$(document).ready(function() {
		  	$('a#deleteCruisePDF').click(function(){
		        $.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('PDF deleted');
		            }
		        );
		        $(this).closest("tr#deleteRowPDF").remove();
		        return false;
		    });
		});
	  	//end of delete cruise pdf
	  	
	  	
	  	/*-----LOW PERIOD-----*/
			
			/*-----INSERT FUNCTION-----*/
			$(document).on('submit', '#lowFORMDATE', function() {
				var datepickerFROM = $("#datepickerFROMLOW").val();
				var datepickerTO   = $("#datepickerTOLOW").val();
				var dataString 	   = 'datepicker_from='+datepickerFROM+'&datepicker_to='+datepickerTO+'&period_type=LOW&brand_id=<?php echo $this->All->getCruiseBrandID($shipgetID); ?>&shipd_id=<?php echo $shipgetID; ?>&noof_night=<?php echo $shipgetNIGHTS; ?>';
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backend/product/insertLOWDate",
					data: dataString,
					cache: false,
					dataType:'JSON',
					success: function(result) {
						if( result.errorCode == 1 ) {
							alert(result.message);
							return false;
						}
						else {
							$('#lowDateRuleTABLE tbody tr:last').after('<tr class="deleteRow"><td style="width:300px; text-align:left; padding:5px">From: <span style="color:green"><b>'+result.fromDate+'</b></span></td><td style="width:300px; text-align:left; padding:5px">To: <span style="color:green"><b>'+result.toDate+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><a href="<?php echo base_url(); ?>backend/product/deleteDateLoW/'+result.dateID+'" id="deleteDateLOW" style="text-decoration:underline">Delete date</a></td></tr>');
							return false;
						}
					}
				});
				return false;
			});
			<?php
			$staterooms = $this->cruise->get_staterooms($this->All->getCruiseBrandID($shipgetID), $shipgetID);
			foreach($staterooms->result() as $strm) {
			?>
			$(document).ready(function() {
				$('a#lowExtraChargeButton<?php echo $strm->ID; ?>').click(function() {
					var lowChargeName  = $("#lowChargeName<?php echo $strm->ID; ?>").val();
					var lowChargePrice = $("#lowChargePrice<?php echo $strm->ID; ?>").val();
					var lowStateroomID = $("#hidden_stateroomLOWExtraID_<?php echo $strm->ID; ?>").val();
					if( lowChargeName == "" && lowChargePrice == "" ) {
						alert("Name and price are required");
					}
					else {
						var dataString = 'stateroomID='+lowStateroomID+'&low_charge_name='+lowChargeName+'&low_charge_price='+lowChargePrice+'&period_type=LOW&brand_id=<?php echo $this->All->getCruiseBrandID($shipgetID); ?>&shipd_id=<?php echo $shipgetID; ?>&noof_night=<?php echo $shipgetNIGHTS; ?>';
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>backend/product/insertLOWExtraCharge",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 1 ) {
									alert(result.message);
									return false;
								}
								else {
									$("#lowExtraChargeTABLE<?php echo $strm->ID; ?> tbody tr:last").after('<tr class="deleteRow"><td style="width:300px; text-align:left; padding:5px"><span style="color:green"><b>'+result.extraPriceName+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><span style="color:green"><b>$'+result.extraPriceValue+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><a href="<?php echo base_url(); ?>backend/product/deleteExtraChargeLoW/'+result.extraPriceID+'" id="deleteExtraChargeLoW" style="text-decoration:underline">Delete extra charge</a></td></tr>');
									alert("New extra charge (LOW) has been added");
									return false;
								}
							}
						});
					}
					return false;
				});		
			});
			$(document).ready(function() {
				$('a#lowDiscountButton<?php echo $strm->ID; ?>').click(function() {
					var discountPrice 		= $("#lowDiscountPrice<?php echo $strm->ID; ?>").val();
					var discountStateroomID = $("#hidden_stateroomLOWDiscountID_<?php echo $strm->ID; ?>").val();
					if( discountPrice == "" ) {
						alert("Price is required");
					}
					else {
						var dataString = 'stateroomID='+discountStateroomID+'&discount_price='+discountPrice+'&period_type=LOW&brand_id=<?php echo $this->All->getCruiseBrandID($shipgetID); ?>&shipd_id=<?php echo $shipgetID; ?>&noof_night=<?php echo $shipgetNIGHTS; ?>';
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>backend/product/insertLOWDiscount",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 1 ) {
									alert(result.message);
									return false;
								}
								else {
									$("#lowDiscountTABLE<?php echo $strm->ID; ?> tbody tr:last").after('<tr class="deleteRow"><td style="width:300px; text-align:left; padding:5px"><span style="color:green"><b>$'+result.discountPriceValue+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><a href="<?php echo base_url(); ?>backend/product/deleteDiscountLoW/'+result.discountPriceID+'" id="deleteDiscountLoW" style="text-decoration:underline">Delete discount</a></td></tr>');
									alert("New discount price (LOW) has been added");
									return false;
								}
							}
						});
					}
					return false;
				});
			});
			<?php
			}
			?>
			/*-----END OF INSERT FUNCTION-----*/
			
			/*-----DELETE FUNCTION-----*/
			$(document).ready(function() {
			  	$('a#deleteDateLOW').click(function(){
			        $.get(
			            $(this).attr('href'),
			            {},
			            function(data) {
			                alert('Date (LOW) removed');
			            }
			        );
			        $(this).closest("tr.deleteRow").remove();
			        return false;
			    });
			});
			$(document).on('click', 'a#deleteDateLOW', function(e){
				$.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Date (LOW) removed');
		            }
		        );
		        $(this).closest("tr.deleteRow").remove();
		        return false;
			});
			$(document).ready(function() {
			  	$('a#deleteExtraChargeLoW').click(function(){
			        $.get(
			            $(this).attr('href'),
			            {},
			            function(data) {
			                alert('Extra charge price (LOW) removed');
			            }
			        );
			        $(this).closest("tr.deleteRow").remove();
			        return false;
			    });
			});
			$(document).on('click', 'a#deleteExtraChargeLoW', function(e){
				$.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Extra charge price (LOW) removed');
		            }
		        );
		        $(this).closest("tr.deleteRow").remove();
		        return false;
			});
			$(document).ready(function() {
			  	$('a#deleteDiscountLoW').click(function(){
			        $.get(
			            $(this).attr('href'),
			            {},
			            function(data) {
			                alert('Discount price (LOW) removed');
			            }
			        );
			        $(this).closest("tr.deleteRow").remove();
			        return false;
			    });
			});
			$(document).on('click', 'a#deleteDiscountLoW', function(e){
				$.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Discount price (LOW) removed');
		            }
		        );
		        $(this).closest("tr.deleteRow").remove();
		        return false;
			});
			/*-----END OF DELETE FUNCTION-----*/
			
		/*-----END OF LOW PERIOD-----*/
		
		
		/*-----SHOULDER PERIOD-----*/
		
			/*-----INSERT FUNCTION-----*/
			$(document).on('submit', '#shoulderFORMDATE', function() {
				var datepickerFROM = $("#datepickerFROMSHOULDER").val();
				var datepickerTO   = $("#datepickerTOSHOULDER").val();
				var dataString 	   = 'datepicker_from='+datepickerFROM+'&datepicker_to='+datepickerTO+'&period_type=SHOULDER&brand_id=<?php echo $this->All->getCruiseBrandID($shipgetID); ?>&shipd_id=<?php echo $shipgetID; ?>&noof_night=<?php echo $shipgetNIGHTS; ?>';
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backend/product/insertSHOULDERDate",
					data: dataString,
					cache: false,
					dataType:'JSON',
					success: function(result) {
						if( result.errorCode == 1 ) {
							alert(result.message);
						}
						else {
							$('#shoulderDateRuleTABLE tbody tr:last').after('<tr class="deleteRow"><td style="width:300px; text-align:left; padding:5px">From: <span style="color:green"><b>'+result.fromDate+'</b></span></td><td style="width:300px; text-align:left; padding:5px">To: <span style="color:green"><b>'+result.toDate+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><a href="<?php echo base_url(); ?>backend/product/deleteDateSHOULDER/'+result.dateID+'" id="deleteDateSHOULDER" style="text-decoration:underline">Delete date</a></td></tr>');
						}
					}
				});
				return false;
			});
			<?php
			$staterooms = $this->cruise->get_staterooms($this->All->getCruiseBrandID($shipgetID), $shipgetID);
			foreach($staterooms->result() as $strm) {
			?>
			$(document).ready(function() {
				$('a#shoulderExtraChargeButton<?php echo $strm->ID; ?>').click(function() {
					var shoulderChargeName  = $("#shoulderChargeName<?php echo $strm->ID; ?>").val();
					var shoulderChargePrice = $("#shoulderChargePrice<?php echo $strm->ID; ?>").val();
					var shoulderStateroomID = $("#hidden_stateroomShoulder_ID_<?php echo $strm->ID; ?>").val();
					if( shoulderChargeName == "" && shoulderChargePrice == "" ) {
						alert("Name and price are required");
					}
					else {
						var dataString = 'stateroomID='+shoulderStateroomID+'&shoulder_charge_name='+shoulderChargeName+'&shoulder_charge_price='+shoulderChargePrice+'&period_type=SHOULDER&brand_id=<?php echo $this->All->getCruiseBrandID($shipgetID); ?>&shipd_id=<?php echo $shipgetID; ?>&noof_night=<?php echo $shipgetNIGHTS; ?>';
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>backend/product/insertSHOULDERExtraCharge",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 1 ) {
									alert(result.message);
									return false;
								}
								else {
									$("#shoulderExtraChargeTABLE<?php echo $strm->ID; ?> tbody tr:last").after('<tr class="deleteRow"><td style="width:300px; text-align:left; padding:5px"><span style="color:green"><b>'+result.extraPriceName+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><span style="color:green"><b>$'+result.extraPriceValue+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><a href="<?php echo base_url(); ?>backend/product/deleteExtraChargeShoulder/'+result.extraPriceID+'" id="deleteExtraChargeShoulder" style="text-decoration:underline">Delete extra charge</a></td></tr>');
									alert("New extra charge (SHOULDER) has been added");
									return false;
								}
							}
						});
					}
					return false;
				});		
			});
			$(document).ready(function() {
				$('a#shoulderDiscountButton<?php echo $strm->ID; ?>').click(function() {
					var discountPrice 		= $("#shoulderDiscountPrice<?php echo $strm->ID; ?>").val();
					var discountStateroomID = $("#hidden_stateroomID_<?php echo $strm->ID; ?>").val();
					if( discountPrice == "" ) {
						alert("Price is required");
					}
					else {
						var dataString = 'stateroomID='+discountStateroomID+'&discount_price='+discountPrice+'&period_type=LOW&brand_id=<?php echo $this->All->getCruiseBrandID($shipgetID); ?>&shipd_id=<?php echo $shipgetID; ?>&noof_night=<?php echo $shipgetNIGHTS; ?>';
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>backend/product/insertSHOULDERDiscount",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 1 ) {
									alert(result.message);
									return false;
								}
								else {
									$("#shoulderDiscountTABLE<?php echo $strm->ID; ?> tbody tr:last").after('<tr class="deleteRow"><td style="width:300px; text-align:left; padding:5px"><span style="color:green"><b>$'+result.discountPriceValue+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><a href="<?php echo base_url(); ?>backend/product/deleteDiscountShoulder/'+result.discountPriceID+'" id="deleteDiscountShoulder" style="text-decoration:underline">Delete discount</a></td></tr>');
									alert("New discount price (SHOULDER) has been added");
									return false;
								}
							}
						});
					}
					return false;
				});
			});
			<?php
			}
			?>
			/*-----END OF INSERT FUNCTION-----*/
			
			/*-----DELETE FUNCTION-----*/
			$(document).ready(function() {
			  	$('a#deleteDateSHOULDER').click(function(){
			        $.get(
			            $(this).attr('href'),
			            {},
			            function(data) {
			                alert('Date (SHOULDER) removed');
			            }
			        );
			        $(this).closest("tr.deleteRow").remove();
			        return false;
			    });
			});
			$(document).on('click', '#deleteDateSHOULDER', function(e){
				$.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Date (SHOULDER) removed');
		            }
		        );
		        $(this).closest("tr.deleteRow").remove();
		        return false;
			});
			$(document).ready(function() {
			  	$('a#deleteExtraChargeShoulder').click(function(){
			        $.get(
			            $(this).attr('href'),
			            {},
			            function(data) {
			                alert('Extra charge price (SHOULDER) removed');
			            }
			        );
			        $(this).closest("tr.deleteRow").remove();
			        return false;
			    });
			});
			$(document).on('click', 'a#deleteExtraChargeShoulder', function(e){
				$.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Extra charge price (SHOULDER) removed');
		            }
		        );
		        $(this).closest("tr.deleteRow").remove();
		        return false;
			});
			$(document).ready(function() {
			  	$('a#deleteDiscountShoulder').click(function(){
			        $.get(
			            $(this).attr('href'),
			            {},
			            function(data) {
			                alert('Discount price (SHOULDER) removed');
			            }
			        );
			        $(this).closest("tr.deleteRow").remove();
			        return false;
			    });
			});
			$(document).on('click', 'a#deleteDiscountShoulder', function(e){
				$.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Discount price (SHOULDER) removed');
		            }
		        );
		        $(this).closest("tr.deleteRow").remove();
		        return false;
			});
			/*-----END OF DELETE FUNCTION-----*/
		
		/*-----END OF SHOULDER PERIOD-----*/
		
		
		/*-----PEAK PERIOD-----*/
			
			/*-----INSERT FUNCTION-----*/
			$(document).on('submit', '#peakFORMDATE', function() {
				var datepickerFROM = $("#datepickerFROMPEAK").val();
				var datepickerTO   = $("#datepickerTOPEAK").val();
				var dataString 	   = 'datepicker_from='+datepickerFROM+'&datepicker_to='+datepickerTO+'&period_type=PEAK&brand_id=<?php echo $this->All->getCruiseBrandID($shipgetID); ?>&shipd_id=<?php echo $shipgetID; ?>&noof_night=<?php echo $shipgetNIGHTS; ?>';
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backend/product/insertPEAKDate",
					data: dataString,
					cache: false,
					dataType:'JSON',
					success: function(result) {
						if( result.errorCode == 1 ) {
							alert(result.message);
						}
						else {
							$('#peakDateRuleTABLE tbody tr:last').after('<tr class="deleteRow"><td style="width:300px; text-align:left; padding:5px">From: <span style="color:green"><b>'+result.fromDate+'</b></span></td><td style="width:300px; text-align:left; padding:5px">To: <span style="color:green"><b>'+result.toDate+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><a href="<?php echo base_url(); ?>backend/product/deleteDatePEAK/'+result.dateID+'" id="deleteDatePEAK" style="text-decoration:underline">Delete date</a></td></tr>');
						}
					}
				});
				return false;
			});
			<?php
			$staterooms = $this->cruise->get_staterooms($this->All->getCruiseBrandID($shipgetID), $shipgetID);
			foreach($staterooms->result() as $strm) {
			?>
			$(document).ready(function() {
				$('a#peakExtraChargeButton<?php echo $strm->ID; ?>').click(function() {
					var peakChargeName  = $("#peakChargeName<?php echo $strm->ID; ?>").val();
					var peakChargePrice = $("#peakChargePrice<?php echo $strm->ID; ?>").val();
					var peakStateroomID = $("#hidden_stateroomPEAKDiscountID_<?php echo $strm->ID; ?>").val();
					if( peakChargeName == "" && peakChargePrice == "" ) {
						alert("Name and price are required");
					}
					else {
						var dataString = 'stateroomID='+peakStateroomID+'&peak_charge_name='+peakChargeName+'&peak_charge_price='+peakChargePrice+'&period_type=PEAK&brand_id=<?php echo $this->All->getCruiseBrandID($shipgetID); ?>&shipd_id=<?php echo $shipgetID; ?>&noof_night=<?php echo $shipgetNIGHTS; ?>';
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>backend/product/insertPEAKExtraCharge",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 1 ) {
									alert(result.message);
									return false;
								}
								else {
									$("#peakExtraChargeTABLE<?php echo $strm->ID; ?> tbody tr:last").after('<tr class="deleteRow"><td style="width:300px; text-align:left; padding:5px"><span style="color:green"><b>'+result.extraPriceName+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><span style="color:green"><b>$'+result.extraPriceValue+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><a href="<?php echo base_url(); ?>backend/product/deleteExtraChargePeak/'+result.extraPriceID+'" id="deleteExtraChargePeak" style="text-decoration:underline">Delete extra charge</a></td></tr>');
									alert("New extra charge (PEAK) has been added");
									return false;
								}
							}
						});
					}
					return false;
				});		
			});
			$(document).ready(function() {
				$('a#peakDiscountButton<?php echo $strm->ID; ?>').click(function() {
					var discountPrice 		= $("#peakDiscountPrice<?php echo $strm->ID; ?>").val();
					var discountStateroomID = $("#hidden_stateroomPEAKDiscountID_<?php echo $strm->ID; ?>").val();
					if( discountPrice == "" ) {
						alert("Price is required");
					}
					else {
						var dataString = 'stateroomID='+discountStateroomID+'&discount_price='+discountPrice+'&period_type=PEAK&brand_id=<?php echo $this->All->getCruiseBrandID($shipgetID); ?>&shipd_id=<?php echo $shipgetID; ?>&noof_night=<?php echo $shipgetNIGHTS; ?>';
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>backend/product/insertPEAKDiscount",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 1 ) {
									alert(result.message);
									return false;
								}
								else {
									$("#peakDiscountTABLE<?php echo $strm->ID; ?> tbody tr:last").after('<tr class="deleteRow"><td style="width:300px; text-align:left; padding:5px"><span style="color:green"><b>$'+result.discountPriceValue+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><a href="<?php echo base_url(); ?>backend/product/deleteDiscountPeak/'+result.discountPriceID+'" id="deleteDiscountPeak" style="text-decoration:underline">Delete discount</a></td></tr>');
									alert("New discount price (PEAK) has been added");
									return false;
								}
							}
						});
					}
					return false;
				});
			});
			<?php
			}
			?>
			/*-----END OF INSERT FUNCTION-----*/
			
			/*-----DELETE FUNCTION-----*/
			$(document).ready(function() {
			  	$('a#deleteDatePEAK').click(function(){
			        $.get(
			            $(this).attr('href'),
			            {},
			            function(data) {
			                alert('Date (PEAK) removed');
			            }
			        );
			        $(this).closest("tr.deleteRow").remove();
			        return false;
			    });
			});
			$(document).on('click', '#deleteDatePEAK', function(e){
				$.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Date (PEAK) removed');
		            }
		        );
		        $(this).closest("tr.deleteRow").remove();
		        return false;
			});
			$(document).ready(function() {
			  	$('a#deleteExtraChargePeak').click(function(){
			        $.get(
			            $(this).attr('href'),
			            {},
			            function(data) {
			                alert('Extra charge price (PEAK) removed');
			            }
			        );
			        $(this).closest("tr.deleteRow").remove();
			        return false;
			    });
			});
			$(document).on('click', 'a#deleteExtraChargePeak', function(e){
				$.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Extra charge price (PEAK) removed');
		            }
		        );
		        $(this).closest("tr.deleteRow").remove();
		        return false;
			});
			$(document).ready(function() {
			  	$('a#deleteDiscountPeak').click(function(){
			        $.get(
			            $(this).attr('href'),
			            {},
			            function(data) {
			                alert('Discount price (PEAK) removed');
			            }
			        );
			        $(this).closest("tr.deleteRow").remove();
			        return false;
			    });
			});
			$(document).on('click', 'a#deleteDiscountPeak', function(e){
				$.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Discount price (PEAK) removed');
		            }
		        );
		        $(this).closest("tr.deleteRow").remove();
		        return false;
			});
			/*-----END OF DELETE FUNCTION-----*/
			
		/*-----END OF PEAK PERIOD-----*/
		
		
  	</script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/form_tags_input.js"></script>
	<script type="text/javascript">	
		//submit form cruise itinerary
		$(document).on('submit', '#addItineraryFrom', function() {
			var port_itinerary  = $("#port_itinerary").val();
			var arrival_time    = $("#arrivalTime").val();
			var departure_time  = $("#departureTime").val();
			var remarkItinerary = $("#ityRemark").val();
			var dataString = 'cruiseTitleID=<?php echo $this->uri->segment(4); ?>&portItinerary='+port_itinerary+'&arrivalTime='+arrival_time+'&departureTime='+departure_time+'&remarkItinerary='+remarkItinerary;
			if( port_itinerary == '' ) { 
				alert("Please enter port itinerary based on ports of call available");
				return false;
			}
			else {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backend/product/insert_cruiseItinerary",
					data: dataString,
					cache: false,
					dataType:'JSON',
					success: function(result) {
						if( result.errorCode == 1 ) {
							alert(result.message);
						}
						else {
							$('#itineraryTable tbody tr:last').after('<tr id="deleteRow"><td style="text-align:center">'+result.dayPrint+'</td><td><a href="<?php echo base_url(); ?>backend/product/deleteItineraryDetails/'+result.cruiseItineraryID+'" id="deleteItineraryDetails" style="text-decoration:underline">'+result.portPrint+'</a><br /><span><i>('+result.remarkItinerary+')</i></span></td><td style="text-align:center">'+result.arrivalTimePrint+'</td><td style="text-align:center">'+result.departureTimePrint+'</td></tr>');
						}
					}
				});
			}
			return false;
		});
		//end of submit form cruise itinerary
		//submit form
		$(document).on('submit', '#editCruiseDetails', function() {
			var ship_tour_code = $("#ship_tour_code").val();
			var ship_title 	   = $("#ship_title").val();
			var ship_desc  	   = $("#ship_desc").val();
			var departure_port = $("#departure_port").val();
			var departure_date = $("#departure_date").val();
			var ports_of_call  = $("#ports_of_call").val();
			var dataString = 'cruiseTourCode='+ship_tour_code+'&cruiseTitleID=<?php echo $this->uri->segment(4); ?>&brandID=<?php echo $this->All->getCruiseBrandID($shipgetID); ?>&shipID=<?php echo $shipgetID; ?>&noof_night=<?php echo $shipgetNIGHTS; ?>&ship_title='+ship_title+'&ship_desc='+ship_desc+'&departure_port='+departure_port+'&departure_date='+departure_date+'&ports_of_call='+ports_of_call;
			if( ship_tour_code.trim() == '' ) 	   	{ alert("Please enter tour code"); 		}
			else if( ship_title.trim() == '' ) 	   	{ alert("Please enter ship title"); 		}
			else if( ship_desc.trim() == '' ) 	   	{ alert("Please enter ship description"); 	}
			else if( departure_port.trim() == '' ) 	{ alert("Please enter departure port"); 	}
			else if( departure_date.trim() == '' ) 	{ alert("Please enter departure date"); 	}
			else if( ports_of_call.trim() == '' ) 	{ alert("Please enter port(s) of call"); 	}
			else {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backend/product/update_cruiseDetails",
					data: dataString,
					cache: false,
					dataType:'JSON',
					success: function(result) {
						alert(result.message);
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
  	<style>
	  	.editbox { display:none; }
		.EnableEditMode { display:none; }
	</style>
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
						<a href="<?php echo base_url(); ?>backend/product/cruise_overview/<?php echo $this->uri->segment(4); ?>">
							Cruise Overview Details
						</a>
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
				<div class="row">
					<div class="col-lg-12">
						<?php echo $this->session->flashdata('sessionSHOULDERPrice'); ?>
						<?php echo $this->session->flashdata('sessionLOWPrice'); ?>
						<?php echo $this->session->flashdata('sessionPEAKPrice'); ?>
						<?php echo $this->session->flashdata('childAgeRule_session'); ?>
						<?php echo $this->session->flashdata('childAgeRule_error'); ?>
						<?php echo $this->session->flashdata('childAgeRule_delete'); ?>
						<?php echo $this->session->flashdata('updateStartingPrice'); ?>
						<?php echo $this->session->flashdata('setPrimaryImage_session'); ?>
						<div class="row">
							<div class="col-lg-4">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Cruise ship brand</h3>
										<div style="font-size:16px"><?php echo $this->All->getCruiseBrandName($shipgetID); ?></div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Cruise ship name</h3>
										<div style="font-size:16px"><?php echo $this->All->getCruiseShipName($shipgetID); ?></div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>No. of night</h3>
										<div style="font-size:16px"><?php echo $shipgetNIGHTS; ?> night(s)</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Edit cruise details</h3>
<form action="#" method="post" class="form-horizontal" id="editCruiseDetails">
	<div class="panel-body">
		<input type="hidden" name="hidden_cruise_titleID" value="<?php echo $this->uri->segment(4); ?>" />
		<fieldset class="content-group">
			<div class="form-group">
				<div class="col-lg-12">
					<label>Enter tour code</label>
					<input type="text" name="ship_tour_code" id="ship_tour_code" class="form-control" value="<?php echo $shipgetCRUISE_TOUR_CODE; ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>Enter ship name / title</label>
					<input type="text" name="ship_title" id="ship_title" class="form-control" value="<?php echo $shipgetCRUISE_TITLE; ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>Enter ship description (Max: 1000 characters)</label>
					<textarea name="ship_desc" id="ship_desc" class="form-control" maxlength="1032" style="resize:none; height:250px" maxlength="180"><?php echo $shipgetCRUISE_DESC; ?></textarea>
					<div id="characterLeft"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>Enter departure port (Press enter to insert)</label>
					<input type="text" name="departure_port" id="departure_port" class="tagsinput-max-tags" value="<?php echo $shipgetDEPARTURE_PORT; ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>Enter ports of call (Press enter to insert)</label>
					<input type="text" name="ports_of_call" id="ports_of_call" data-role="tagsinput" class="tagsinput-typeahead" value="<?php echo $shipgetPORTS_OF_CALL; ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>Please enter departure dates</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="icon-calendar22"></i></span>
						<input type="text" name="departure_date" id="departure_date" class="form-control" value="<?php echo $shipgetDEPARTURE_DATE; ?>" readonly />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</fieldset>
	</div>
</form>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Edit cruise itinerary</h3>
										<p style="text-align:right"><i>* Click port name in order to delete cruise itinerary</i></p>
<table class="table datatable-basic" id="itineraryTable">
	<thead>
		<tr>
			<th style="text-align:center" width="10%">Day</th>
			<th width="50%">Port</th>
			<th style="text-align:center" width="20%" class="text-center">Arrival time</th>
			<th style="text-align:center" width="20%" class="text-center">Departure time</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$itinerarys = $this->All->select_template_with_where_and_order(
			"CRUISE_TITLE_ID", $this->uri->segment(4), "DAY", "ASC", "cruise_itinerary");
		if( $itinerarys == TRUE ) {
			foreach( $itinerarys AS $itinerary ) {
		?>
		<tr id="deleteRow">
         	<td style="text-align:center"><?php echo $itinerary->DAY; ?></td>
		 	<td>
			 	<a href="<?php echo base_url(); ?>backend/product/deleteItineraryDetails/<?php echo $itinerary->ID; ?>" id="deleteItineraryDetails" style="text-decoration:underline">
				 	<?php echo $itinerary->PORT; ?>
				</a>
				<?php
				if( $itinerary->REMARK != "" ) {
				?>
				 	<br />
				 	<span><i>(<?php echo $itinerary->REMARK; ?>)</i></span>
				<?php
				}
				?>
			 </td>
		 	<td style="text-align:center"><?php echo $itinerary->ARRIVAL_TIME; ?></td>
		 	<td style="text-align:center"><?php echo $itinerary->DEPARTURE_TIME; ?></td>
		</tr>
		<?php
			}
		}
		?>
	</tbody>
	<tfoot>
		<form id="addItineraryFrom">
			<tr>
	         	<td colspan="2">
			 		<input type="text" name="port_itinerary" id="port_itinerary" class="tagsinput-max-tags2" placeholder="Enter port name (Press enter to insert)" />
			 	</td>
			 	<td style="text-align:center">
				 	<input type="text" name="arrivalTime" id="arrivalTime" class="form-control" placeholder="Time" maxlength="4" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
			 	</td>
			 	<td style="text-align:center">
				 	<input type="text" name="departureTime" id="departureTime" class="form-control" placeholder="Time" maxlength="4" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
			 	</td>
			</tr>
			<tr>
				<td colspan="4" style="border-top:none">
					<div style="margin-top:-15px">
						<input type="text" name="ityRemark" id="ityRemark" class="form-control" placeholder="Enter remark" />
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align:right">
					<button type="submit" class="btn btn-primary">Add new itinerary</button>
				</td>
			</tr>
		</form>
	</tfoot>
</table>
									</div>
								</div>
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Manual Starting Price</h3>
<form action="<?php echo base_url(); ?>backend/product/updateStartingPrice" method="post" class="form-horizontal">
	<div class="panel-body" style="padding:10px; margin-bottom:-40px">
		<input type="hidden" name="hidden_cruise_titleID" value="<?php echo $this->uri->segment(4); ?>" />
		<fieldset class="content-group">
			<div class="form-group">
				<div class="col-lg-12">
					<label>Enter price</label>
					<input type="text" name="manual_starting_price" id="manual_starting_price" class="form-control" value="<?php echo $shipgetSTARTING_PRICE; ?>" required onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</fieldset>
	</div>
</form>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Child Age Rule</h3>
<div style="float:right; margin-top:-40px; margin-bottom:20px">
	<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#newChildRule">
		<b><i class="icon-add"></i></b> Add rule
	</button>
	<!--NEW RULE FORM-->
	<div id="newChildRule" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Add new rule</h5>
				</div>
				<?php echo form_open_multipart('backend/product/childAgeNew', array("class" => "form-horizontal")); ?>
					<input type="hidden" name="hiddenCruiseTitleID" value="<?php echo $this->uri->segment(4); ?>" />
					<div class="modal-body">
						<fieldset class="content-group">
							<div class="form-group">
								<label class="control-label col-lg-3">
									* Enter child age
								</label>
								<div class="col-lg-9">
									<input type="text" name="value_child_age_form" maxlength="2" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" required class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3">
									* Status
								</label>
								<div class="col-lg-9">
									<select name="status_child_age_form" class="form-control">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="modal-footer" style="margin-top:-20px">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Add new rule</button>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	<!--END OF NEW RULE FORM-->
</div>
										<table class="table datatable-basic" id="childAgeTable">
											<thead>
												<tr>
													<th width="30%" style="text-align:center">Chila Age</th>
													<th width="15%" style="text-align:center">Status</th>
													<th width="10%" style="text-align:center">Created</th>
													<th width="10%" style="text-align:center">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$childages = $this->All->select_template(
													"cruise_title_id", $this->uri->segment(4), "cruise_child_age"
												);
												if( $childages == TRUE ) {
													foreach( $childages AS $childage ) {
												?>
												<tr>
													<td style="text-align:center">
														Maximum age consider as child: 
														<?php echo $childage->child_age_value; ?> years old
													</td>
													<td style="text-align:center">
														<span style="color:green"><b>ACTIVE</b></span>
													</td>
													<td style="text-align:center">
														<?php echo date("Y F d H:i:s", strtotime($childage->created)); ?>
													</td>
													<td style="text-align:center">
														<a href="<?php echo base_url(); ?>backend/product/deleteChildAgeRule/<?php echo $this->uri->segment(4); ?>" class="btn btn-primary btn-labeled" onclick="return confirm('Are you sure you want to delete this rule?');">
															<b><i class="icon-trash"></i></b> Delete rule
														</a>
													</td>
												</tr>
												<?php
													}
												}
												else {
												?>
												<tr>
													<td colspan="4" style="text-align:center">
														<span style="color:red">
															<b>No rule applied for child age found for this cruise.</b>
														</span>
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
							<div class="col-lg-12">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3 id="editCruiseImageAnchor">Edit cruise images</h3>
<div style="float:right; margin-top:-40px; margin-bottom:20px">
	<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#uploadNewImage">
		<b><i class="icon-add"></i></b> Add image(s)
	</button>
	<!--NEW UPLOAD FORM-->
	<div id="uploadNewImage" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Upload new image</h5>
				</div>
				<div class="modal-body">
					<?php echo form_open_multipart('#', array('class' => 'dropzone', 'id' => 'dropzone_multiple')); ?>
						<input type="hidden" name="hidden_cruise_title_id" value="<?php echo $this->uri->segment(4); ?>" />
					<?php echo form_close(); ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!--END OF NEW UPLOAD FORM-->
</div>
<div style="clear:both"></div>
<div style="text-align:right">
	<span style="color:green">
		<b><i>Recommended cruise image size: (Width:850px) X (Height:450px)</i></b>
	</span>
</div>
<table class="table datatable-basic" id="cruiseImageTable">
	<thead>
		<tr>
			<th width="30%">Image</th>
			<th width="15%" style="text-align:center">Status</th>
			<th width="5%">File type</th>
			<th width="10%">File size (in KB)</th>
			<th width="10%">Created</th>
			<th width="10%">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$images = $this->All->select_template("cruise_title_id", $this->uri->segment(4), "cruise_image");
		if( $images == TRUE ) {
			foreach( $images AS $image ) {
		?>
		<tr id="deleteRowImage">
         	<td>
	         	<a href="<?php echo base_url(); ?>assets/cruise_img/<?php echo $image->file_name; ?>" target="_blank" style="text-decoration:underline">
		         	<?php echo $image->file_name; ?>
		         </a>
	        </td>
	        <td style="text-align:center">
		        <?php
			    if( $image->imgStatus == "PRIMARY" ) {
				?>
					<span style="color:green"><b>PRIMARY</b></span>
					<br />
					<span style="font-size:11px">
		        		<i><a href="<?php echo base_url(); ?>backend/product/setPrimaryImage/<?php echo $image->id; ?>/<?php echo $this->uri->segment(4); ?>">(Click to set to primary)</a></i>
					</span>
				<?php
			    }
			    else {
			    ?>
		        	<span style="color:black"><b>DEFAULT</b></span>
					<br />
					<span style="font-size:11px">
		        		<i><a href="<?php echo base_url(); ?>backend/product/setPrimaryImage/<?php echo $image->id; ?>/<?php echo $this->uri->segment(4); ?>">(Click to set to primary)</a></i>
					</span>
		        <?php
			    }
			    ?>
		    </td>
		 	<td><?php echo $image->file_size; ?></td>
		 	<td><?php echo $image->file_type; ?></td>
		 	<td><?php echo date("Y-m-d H:i:s", strtotime($image->created)); ?></td>
		 	<td>
			    <a href="<?php echo base_url(); ?>backend/product/deleteCruiseImage/<?php echo $image->id; ?>" id="deleteCruiseImage" class="btn btn-primary btn-labeled">
					<b><i class="icon-trash"></i></b> Delete image
				</a>
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
							<div class="col-lg-12">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Download cruise Itinerary</h3>
<div style="float:right; margin-top:-40px; margin-bottom:20px">
	<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#uploadNewPDF">
		<b><i class="icon-add"></i></b> Upload itinerary (PDF)
	</button>
	<!--NEW UPLOAD FORM-->
	<?php
	$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$check_res  = mysqli_query(
		$connection,
		"SELECT COUNT(*) AS totalPDF FROM cruise_pdf WHERE cruise_title_id = ".$this->uri->segment(4).""
	);
	$check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
	if( $check_row["totalPDF"] > 0 ) {
	?>
	<div id="uploadNewPDF" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Upload new PDF</h5>
				</div>
				<div class="modal-body" style="text-align:center">
					<b>Only 1 PDF file can be uploaded at the moment. Thank you.</b>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
	else {
	?>
	<div id="uploadNewPDF" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Upload new PDF</h5>
				</div>
				<div class="modal-body">
					<?php echo form_open_multipart('#', array('class' => 'dropzone', 'id' => 'dropzone_pdf')); ?>
						<input type="hidden" name="hidden_cruise_title_id" value="<?php echo $this->uri->segment(4); ?>" />
					<?php echo form_close(); ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
	?>
	<!--END OF NEW UPLOAD FORM-->
</div>
<div style="clear:both"></div>
<table class="table datatable-basic" id="cruisePDFTable">
	<thead>
		<tr>
			<th width="30%">Image</th>
			<th width="5%" style="text-align:center">File type</th>
			<th width="10%" style="text-align:center">File size (in KB)</th>
			<th width="10%" style="text-align:center">Created</th>
			<th width="10%" style="text-align:center">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$pdfs = $this->All->select_template("cruise_title_id", $this->uri->segment(4), "cruise_pdf");
		if( $pdfs == TRUE ) {
			foreach( $pdfs AS $pdf ) {
		?>
		<tr id="deleteRowPDF">
         	<td>
	         	<a href="<?php echo base_url(); ?>assets/cruise_pdf/<?php echo $pdf->file_name; ?>" target="_blank" style="text-decoration:underline">
		         	<?php echo $pdf->file_name; ?>
		         </a>
	         </td>
		 	<td style="text-align:center"><?php echo $pdf->file_size; ?></td>
		 	<td style="text-align:center"><?php echo $pdf->file_type; ?></td>
		 	<td style="text-align:center"><?php echo date("Y-m-d H:i:s", strtotime($pdf->created)); ?></td>
		 	<td style="text-align:center">
			    <a href="<?php echo base_url(); ?>backend/product/deleteCruisePDF/<?php echo $pdf->id; ?>" id="deleteCruisePDF" class="btn btn-primary btn-labeled">
					<b><i class="icon-trash"></i></b> Delete PDF
				</a>
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
							<div class="col-lg-12">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Edit cruise prices</h3>
<div class="form-group">
	<div class="col-lg-12">
	    <ul class="nav nav-tabs">
	      	<li class="active"><a data-toggle="tab" href="#low">Low</a></li>
		  	<li><a data-toggle="tab" href="#shoulder">Shoulder</a></li>
		  	<li><a data-toggle="tab" href="#peak">Peak</a></li>
	    </ul>
		<div class="tab-content">		
			<!-- LOW Manage Date -->
			<div id="lowDATE" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h5 class="modal-title">LOW - Manage Date</h5>
						</div>
						<form method="post" class="form-horizontal" id="lowFORMDATE">
							<div class="modal-body">	
								<fieldset class="content-group">
									<div class="form-group">
										<label class="control-label col-lg-3">
											* From date
										</label>
										<div class="col-lg-9">
											<input type="text" name="lowFROMDATE" id="datepickerFROMLOW" required readonly class="form-control" value="<?php echo date("Y-m-d"); ?>" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-3">
											* To date
										</label>
										<div class="col-lg-9">
											<input type="text" name="toFROMDATE" id="datepickerTOLOW" required readonly class="form-control" value="<?php echo date("Y-m-d", strtotime("+ 1 day")); ?>" />
										</div>
									</div>
									<hr />
									<table id="lowDateRuleTABLE">
										<tbody>
											<tr>
												<th style="width:200px">From date</th>
												<th style="width:200px">To date</th>
												<th style="width:200px">Action</th>
											</tr>
											<?php
											$dateLOWs = $this->All->select_template_w_4_conditions(
												"cruise_brand_id", 	$this->All->getCruiseBrandID($shipgetID), 
												"cruise_ship_id", 	$shipgetID, 
												"no_of_nights", 	$shipgetNIGHTS, 
												"period_type", 		"LOW", 
												"cruise_prices_date_rule"
											);
											if( $dateLOWs == TRUE ) {
												foreach( $dateLOWs AS $dateLOW ) {
											?>
											<tr class="deleteRow">
												<td style="width:300px; text-align:left; padding:5px">
													From:
													<span style="color:green">
														<b><?php echo date("Y-F-d", strtotime($dateLOW->date_from)); ?></b>
													</span>
												</td>
												<td style="width:300px; text-align:left; padding:5px">
													To: 
													<span style="color:green">
														<b><?php echo date("Y-F-d", strtotime($dateLOW->date_to)); ?></b>
													</span>
												</td>
												<td style="width:300px; text-align:left; padding:5px">
													<a href="<?php echo base_url(); ?>backend/product/deleteDateLoW/<?php echo $dateLOW->id; ?>" id="deleteDateLOW" style="text-decoration:underline">Delete date</a>
												</td>
											</tr>
											<?php
												}
											}
											?>
										</tbody>
									</table>
								</fieldset>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Add new date</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End of LOW Manage Date -->				
			<!-- Start of low prices -->
			<div id="low" class="tab-pane fade in active">
				<?php echo form_open_multipart('backend/product_process/insert_cruise_prices/', array('class' => 'form-horizontal', 'novalidate' => 'novalidate')); ?>
					<input type="hidden" name="hidden_redirect" value="editMode" />
					<input type="hidden" name="hidden_cruisetitleID" value="<?php echo $this->uri->segment(4); ?>" />
				    <div class="panel-heading" style="padding:0px"><h3>LOW</h3></div>
				    <div style="float:right; margin-top:-40px">
					    <button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#lowDATE">
							<b><i class="icon-add"></i></b> Manage date(s)
						</button>
				    </div>
				    <div style="clear:both"></div>
				    <input type="hidden" name="hidden_ship_id" 		value="<?php echo $shipgetID; ?>" />
				    <input type="hidden" name="hidden_brand_id" 	value="<?php echo $this->All->getCruiseBrandID($shipgetID); ?>" />
				    <input type="hidden" name="hidden_period_type" 	value="LOW" />
				    <input type="hidden" name="hidden_nights_no" 	value="<?php echo $shipgetNIGHTS; ?>" />
				    <table class="table datatable-basic">
				        <thead>
				            <tr>
				              	<th></th>
							  	<th style="text-align:left">Stateroom</th>
							  	<th style="text-align:left">Single</th>
							  	<th style="text-align:left">1 Pax</th>
							  	<th colspan="2" style="text-align:left">2 Pax</th>
							  	<th colspan="2" style="text-align:left">3 Pax</th>
							  	<th colspan="2" style="text-align:left">4 Pax</th>
							  	<th style="text-align:left">&nbsp;</th>
				            </tr>
				        </thead>
				        <tbody>
					        <tr>
			                	<td>&nbsp;</td>
			                	<td>&nbsp;</td>          
			                    <td>&nbsp;</td>
			                    <td>&nbsp;</td>
			                    <td style="text-align:left"><b>Adult</b></td>
			                    <td style="text-align:left"><b>Child</b></td>
			                    <td style="text-align:left"><b>Adult</b></td>
			                    <td style="text-align:left"><b>Child</b></td>
			                    <td style="text-align:left"><b>Adult</b></td>
			                    <td style="text-align:left"><b>Child</b></td>
			                    <td style="text-align:left"><b>&nbsp;</b></td>
			                </tr>
				        	<?php
							$staterooms = $this->cruise->get_staterooms($this->All->getCruiseBrandID($shipgetID), $shipgetID);
							$row_id = 0;
							foreach($staterooms->result() as $strm) {
								$row_id++;
								$getPrices = $this->All->select_template_w_5_conditions(
									"SHIP_ID", $shipgetID, "BRAND_ID", $this->All->getCruiseBrandID($shipgetID), 
									"STATEROOM_ID", $strm->ID, 
									"PERIOD_TYPE", "LOW", "NIGHTS_NO", $shipgetNIGHTS,
									"cruise_prices"
								);
								if( $getPrices == TRUE ) {
									foreach( $getPrices AS $getPrice ) {
										$attS  = $getPrice->ATT_SINGLE;
										$att1  = $getPrice->ATT_1;
										$att2A = $getPrice->ATT_2_ADULT;
										$att2C = $getPrice->ATT_2_CHILD;
										$att3A = $getPrice->ATT_3_ADULT;
										$att3C = $getPrice->ATT_3_CHILD;
										$att4A = $getPrice->ATT_4_ADULT;
										$att4C = $getPrice->ATT_4_CHILD;
									}
								}
								else {
									$attS  = "";
									$att1  = "";
									$att2A = "";
									$att2C = "";
									$att3A = "";
									$att3C = "";
									$att4A = "";
									$att4C = "";
								}
							?>
								<tr>
				                	<td><?php echo $row_id; ?></td>
				                	<td><?php echo $strm->STATEROOM_NAME; ?></td>  
				                	<td>
					                	<input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][1]" value="<?php echo $attS; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>        
				                    <td>
					                	<input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][2]" value="<?php echo $att1; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
				                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][3]" value="<?php echo $att2A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
				                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][4]" value="<?php echo $att2C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
				                   	<td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][5]" value="<?php echo $att3A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
				                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][6]" value="<?php echo $att3C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
				                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][7]" value="<?php echo $att4A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
				                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][8]" value="<?php echo $att4C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
				                    <td style="width:275px">
<button type="button" class="btn btn-primary btn-labeled btn-xs" data-toggle="modal" data-target="#lowEXTRA<?php echo $strm->ID; ?>">
	<b><i class="icon-add"></i></b> Extra Charge
</button>
<!-- LOW Manage Extra Charge -->
<div id="lowEXTRA<?php echo $strm->ID; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title"><?php echo $strm->STATEROOM_NAME; ?> - Extra Charge (Low Period Type)</h5>
			</div>
			<input type="hidden" id="hidden_stateroomLOWExtraID_<?php echo $strm->ID; ?>" value="<?php echo $strm->ID; ?>" />
			<div class="modal-body">	
				<fieldset class="content-group">
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Extra charge name
						</label>
						<div class="col-lg-9">
							<input type="text" name="lowChargeName" id="lowChargeName<?php echo $strm->ID; ?>" required class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Extra charge price
						</label>
						<div class="col-lg-9">
							<input type="text" name="lowChargePrice" id="lowChargePrice<?php echo $strm->ID; ?>" required class="form-control" />
						</div>
					</div>
					<hr />
					<table id="lowExtraChargeTABLE<?php echo $strm->ID; ?>">
						<tbody>
							<tr>
								<th style="width:200px">Extra charge name</th>
								<th style="width:200px">Extra charge price</th>
								<th style="width:200px">Action</th>
							</tr>
							<?php
							$extrapriceLOWs = $this->All->select_template_w_5_conditions(
								"cruise_brand_id", 	$this->All->getCruiseBrandID($shipgetID), 
								"cruise_ship_id", 	$shipgetID, 
								"no_of_nights", 	$shipgetNIGHTS,
								"stateroomID", 		$strm->ID,
								"period_type", 		"LOW", 
								"cruise_extra_price"
							);
							if( $extrapriceLOWs == TRUE ) {
								foreach( $extrapriceLOWs AS $extrapriceLOW ) {
							?>
							<tr class="deleteRow">
								<td style="width:300px; text-align:left; padding:5px">
									<span style="color:green">
										<b><?php echo $extrapriceLOW->extra_price_name; ?></b>
									</span>
								</td>
								<td style="width:300px; text-align:left; padding:5px">
									<span style="color:green">
										<b>$<?php echo number_format($extrapriceLOW->extra_price_value, 2); ?></b>
									</span>
								</td>
								<td style="width:300px; text-align:left; padding:5px">
									<a href="<?php echo base_url(); ?>backend/product/deleteExtraChargeLoW/<?php echo $extrapriceLOW->id; ?>" id="deleteExtraChargeLoW" style="text-decoration:underline">Delete extra charge</a>
								</td>
							</tr>
							<?php
								}
							}
							?>
						</tbody>
					</table>
				</fieldset>
			</div>
			<div class="modal-footer">
				<a class="btn btn-link" data-dismiss="modal">Close</a>
				<a id="lowExtraChargeButton<?php echo $strm->ID; ?>" class="btn btn-primary">
					Add new extra charge
				</a>
			</div>
		</div>
	</div>
</div>
<!-- End of LOW Manage Extra Charge -->
<button type="button" class="btn btn-primary btn-labeled btn-xs" data-toggle="modal" data-target="#lowDISCOUNT<?php echo $strm->ID; ?>">
	<b><i class="icon-add"></i></b> Discount
</button>
<!-- LOW Manage Discount -->
<div id="lowDISCOUNT<?php echo $strm->ID; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title"><?php echo $strm->STATEROOM_NAME; ?> - Discount (Low Period Type)</h5>
			</div>
			<input type="hidden" id="hidden_stateroomLOWDiscountID_<?php echo $strm->ID; ?>" value="<?php echo $strm->ID; ?>" />
			<div class="modal-body">	
				<fieldset class="content-group">
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Enter discount price
						</label>
						<div class="col-lg-9">
							<input type="text" name="lowDiscountPrice" id="lowDiscountPrice<?php echo $strm->ID; ?>" required class="form-control" />
						</div>
					</div>
					<hr />
					<table id="lowDiscountTABLE<?php echo $strm->ID; ?>">
						<tbody>
							<tr>
								<th style="width:200px">Discount price</th>
								<th style="width:200px">Action</th>
							</tr>
							<?php
							$discountLOWs = $this->All->select_template_w_5_conditions(
								"cruise_brand_id", 	$this->All->getCruiseBrandID($shipgetID), 
								"cruise_ship_id", 	$shipgetID, 
								"no_of_nights", 	$shipgetNIGHTS,
								"stateroomID", 		$strm->ID,
								"period_type", 		"LOW", 
								"cruise_discount"
							);
							if( $discountLOWs == TRUE ) {
								foreach( $discountLOWs AS $discountLOW ) {
							?>
							<tr class="deleteRow">
								<td style="width:300px; text-align:left; padding:5px">
									<span style="color:green">
										<b>$<?php echo number_format($discountLOW->extra_price_value, 2); ?></b>
									</span>
								</td>
								<td style="width:300px; text-align:left; padding:5px">
									<a href="<?php echo base_url(); ?>backend/product/deleteDiscountLoW/<?php echo $discountLOW->id; ?>" id="deleteDiscountLoW" style="text-decoration:underline">Delete discount</a>
								</td>
							</tr>
							<?php
								}
							}
							?>
						</tbody>
					</table>
				</fieldset>
			</div>
			<div class="modal-footer">
				<a class="btn btn-link" data-dismiss="modal">Close</a>
				<a id="lowDiscountButton<?php echo $strm->ID; ?>" class="btn btn-primary">
					Add new discount
				</a>
			</div>
		</div>
	</div>
</div>
<!-- End of LOW Manage Discount -->
				                    </td>
				                </tr>
				            <?php
							}
							?>
				        </tbody>
				    </table>     
					<div class="modal-footer-2"></div>
				    <div class="modal-footer">
				    	<input type="hidden" name="price_period" value="3">
						<button type="submit" class="btn btn-primary btn-block">Save LOW prices</button>
					</div>  
				<?php echo form_close(); ?>
			</div>
			<!-- End of low prices -->
			
			<!-- SHOULDER Manage Date -->
			<div id="shoulderDATE" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h5 class="modal-title">SHOULDER - Manage Date</h5>
						</div>
						<form method="post" class="form-horizontal" id="shoulderFORMDATE">
							<div class="modal-body">	
								<fieldset class="content-group">
									<div class="form-group">
										<label class="control-label col-lg-3">
											* From date
										</label>
										<div class="col-lg-9">
											<input type="text" name="shoulderFROMDATE" id="datepickerFROMSHOULDER" required readonly class="form-control" value="<?php echo date("Y-m-d"); ?>" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-3">
											* To date
										</label>
										<div class="col-lg-9">
											<input type="text" name="shoulderTODATE" id="datepickerTOSHOULDER" required readonly class="form-control" value="<?php echo date("Y-m-d", strtotime("+ 1 day")); ?>" />
										</div>
									</div>
									<hr />
									<table id="shoulderDateRuleTABLE">
										<tbody>
											<tr>
												<th style="width:200px">From date</th>
												<th style="width:200px">To date</th>
												<th style="width:200px">Action</th>
											</tr>
											<?php
											$dateSHOULDERs = $this->All->select_template_w_4_conditions(
												"cruise_brand_id", 	$this->All->getCruiseBrandID($shipgetID), 
												"cruise_ship_id", 	$shipgetID, 
												"no_of_nights", 	$shipgetNIGHTS, 
												"period_type", 		"SHOULDER", 
												"cruise_prices_date_rule"
											);
											if( $dateSHOULDERs == TRUE ) {
												foreach( $dateSHOULDERs AS $dateSHOULDER ) {
											?>
											<tr class="deleteRow">
												<td style="width:300px; text-align:left; padding:5px">
													From: 
													<span style="color:green">
														<b><?php echo date("Y-F-d", strtotime($dateSHOULDER->date_from)); ?></b>
													</span>
												</td>
												<td style="width:300px; text-align:left; padding:5px">
													To: 
													<span style="color:green">
														<b><?php echo date("Y-F-d", strtotime($dateSHOULDER->date_to)); ?></b>
													</span>
												</td>
												<td style="width:300px; text-align:left; padding:5px">
													<a href="<?php echo base_url(); ?>backend/product/deleteDateSHOULDER/<?php echo $dateSHOULDER->id; ?>" id="deleteDateSHOULDER" style="text-decoration:underline">Delete date</a>
												</td>
											</tr>
											<?php
												}
											}
											?>
										</tbody>
									</table>
								</fieldset>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Add new date</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End of SHOULDER Manage Date -->
			<!-- Start of shoulder prices --> 
			<div id="shoulder" class="tab-pane fade">
				<?php echo form_open_multipart('backend/product_process/insert_cruise_prices/', array('class' => 'form-horizontal', 'novalidate' => 'novalidate')); ?>
					<input type="hidden" name="hidden_redirect" value="editMode" />
					<input type="hidden" name="hidden_cruisetitleID" value="<?php echo $this->uri->segment(4); ?>" />
				    <div class="panel-heading" style="padding:0px"><h3>SHOULDER</h3></div>
				    <div style="float:right; margin-top:-40px">
					    <button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#shoulderDATE">
							<b><i class="icon-add"></i></b> Manage date(s)
						</button>
				    </div>
				    <div style="clear:both"></div>
				    <input type="hidden" name="hidden_ship_id" 		value="<?php echo $shipgetID; ?>" />
					<input type="hidden" name="hidden_brand_id" 	value="<?php echo $this->All->getCruiseBrandID($shipgetID); ?>" />
					<input type="hidden" name="hidden_period_type" 	value="SHOULDER" />
					<input type="hidden" name="hidden_nights_no" 	value="<?php echo $shipgetNIGHTS; ?>" />
				    <table class="table datatable-basic">
				      	<thead>
				            <tr>
				              	<th></th>
							  	<th style="text-align:left">Stateroom</th>
							  	<th style="text-align:left">Single</th>
							  	<th style="text-align:left">1 Pax</th>
							  	<th colspan="2" style="text-align:left">2 Pax</th>
							  	<th colspan="2" style="text-align:left">3 Pax</th>
							  	<th colspan="2" style="text-align:left">4 Pax</th>
							  	<th style="text-align:left">&nbsp;</th>
				            </tr>
				        </thead>
				        <tbody>
					        <tr>
			                	<td>&nbsp;</td>
			                	<td>&nbsp;</td>          
			                    <td>&nbsp;</td>
			                    <td>&nbsp;</td>
			                    <td style="text-align:left"><b>Adult</b></td>
			                    <td style="text-align:left"><b>Child</b></td>
			                    <td style="text-align:left"><b>Adult</b></td>
			                    <td style="text-align:left"><b>Child</b></td>
			                    <td style="text-align:left"><b>Adult</b></td>
			                    <td style="text-align:left"><b>Child</b></td>
			                    <td style="text-align:left"><b>&nbsp;</b></td>
			                </tr>
				        <?php 
						$staterooms = $this->cruise->get_staterooms($this->All->getCruiseBrandID($shipgetID), $shipgetID);
						$row_id 	= 0;
						foreach($staterooms->result() as $strm) {
							$row_id++;
							$getPrices = $this->All->select_template_w_5_conditions(
								"SHIP_ID", $shipgetID, "BRAND_ID", $this->All->getCruiseBrandID($shipgetID), 
								"STATEROOM_ID", $strm->ID, 
								"PERIOD_TYPE", "SHOULDER", "NIGHTS_NO", $shipgetNIGHTS,
								"cruise_prices"
							);
							if( $getPrices == TRUE ) {
								foreach( $getPrices AS $getPrice ) {
									$attS  = $getPrice->ATT_SINGLE;
									$att1  = $getPrice->ATT_1;
									$att2A = $getPrice->ATT_2_ADULT;
									$att2C = $getPrice->ATT_2_CHILD;
									$att3A = $getPrice->ATT_3_ADULT;
									$att3C = $getPrice->ATT_3_CHILD;
									$att4A = $getPrice->ATT_4_ADULT;
									$att4C = $getPrice->ATT_4_CHILD;
								}
							}
							else {
								$attS  = "";
								$att1  = "";
								$att2A = "";
								$att2C = "";
								$att3A = "";
								$att3C = "";
								$att4A = "";
								$att4C = "";
							}
						?>
							<tr>
			                	<td><?php echo $row_id; ?></td>
			                	<td><?php echo $strm->STATEROOM_NAME; ?></td>  
			                	<td>
				                	<input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][1]" value="<?php echo $attS; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>        
			                    <td>
				                	<input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][2]" value="<?php echo $att1; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
			                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][3]" value="<?php echo $att2A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
			                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][4]" value="<?php echo $att2C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
			                   	<td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][5]" value="<?php echo $att3A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
			                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][6]" value="<?php echo $att3C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
			                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][7]" value="<?php echo $att4A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
			                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][8]" value="<?php echo $att4C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
			                    <td style="width:275px">
<button type="button" class="btn btn-primary btn-labeled btn-xs" data-toggle="modal" data-target="#shoulderEXTRA<?php echo $strm->ID; ?>">
	<b><i class="icon-add"></i></b> Extra Charge
</button>
<!-- SHOULDER Manage Extra Charge -->
<div id="shoulderEXTRA<?php echo $strm->ID; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title"><?php echo $strm->STATEROOM_NAME; ?> - Extra Charge (Shoulder Period Type)</h5>
			</div>
			<input type="hidden" id="hidden_stateroomShoulder_ID_<?php echo $strm->ID; ?>" value="<?php echo $strm->ID; ?>" />
			<div class="modal-body">	
				<fieldset class="content-group">
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Extra charge name
						</label>
						<div class="col-lg-9">
							<input type="text" name="shoulderChargeName" id="shoulderChargeName<?php echo $strm->ID; ?>" required class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Extra charge price
						</label>
						<div class="col-lg-9">
							<input type="text" name="shoulderChargePrice" id="shoulderChargePrice<?php echo $strm->ID; ?>" required class="form-control" />
						</div>
					</div>
					<hr />
					<table id="shoulderExtraChargeTABLE<?php echo $strm->ID; ?>">
						<tbody>
							<tr>
								<th style="width:200px">Extra charge name</th>
								<th style="width:200px">Extra charge price</th>
								<th style="width:200px">Action</th>
							</tr>
							<?php
							$extrapriceSHOULDERs = $this->All->select_template_w_5_conditions(
								"cruise_brand_id", 	$this->All->getCruiseBrandID($shipgetID), 
								"cruise_ship_id", 	$shipgetID, 
								"no_of_nights", 	$shipgetNIGHTS,
								"stateroomID", 		$strm->ID,
								"period_type", 		"SHOULDER", 
								"cruise_extra_price"
							);
							if( $extrapriceSHOULDERs == TRUE ) {
								foreach( $extrapriceSHOULDERs AS $extrapriceSHOULDER ) {
							?>
							<tr class="deleteRow">
								<td style="width:300px; text-align:left; padding:5px">
									<span style="color:green">
										<b><?php echo $extrapriceSHOULDER->extra_price_name; ?></b>
									</span>
								</td>
								<td style="width:300px; text-align:left; padding:5px">
									<span style="color:green">
										<b>$<?php echo number_format($extrapriceSHOULDER->extra_price_value, 2); ?></b>
									</span>
								</td>
								<td style="width:300px; text-align:left; padding:5px">
									<a href="<?php echo base_url(); ?>backend/product/deleteExtraChargeShoulder/<?php echo $extrapriceSHOULDER->id; ?>" id="deleteExtraChargeShoulder" style="text-decoration:underline">Delete extra charge</a>
								</td>
							</tr>
							<?php
								}
							}
							?>
						</tbody>
					</table>
				</fieldset>
			</div>
			<div class="modal-footer">
				<a class="btn btn-link" data-dismiss="modal">Close</a>
				<a id="shoulderExtraChargeButton<?php echo $strm->ID; ?>" class="btn btn-primary">
					Add new extra charge
				</a>
			</div>
		</div>
	</div>
</div>
<!-- End of SHOULDER Manage Extra Charge -->
<button type="button" class="btn btn-primary btn-labeled btn-xs" data-toggle="modal" data-target="#shoulderDISCOUNT<?php echo $strm->ID; ?>">
	<b><i class="icon-add"></i></b> Discount
</button>
<!-- SHOULDER Manage Discount -->
<div id="shoulderDISCOUNT<?php echo $strm->ID; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title"><?php echo $strm->STATEROOM_NAME; ?> - Discount (Shoulder Period Type)</h5>
			</div>
			<input type="hidden" id="hidden_stateroomID_<?php echo $strm->ID; ?>" value="<?php echo $strm->ID; ?>" />
			<div class="modal-body">	
				<fieldset class="content-group">
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Enter discount price
						</label>
						<div class="col-lg-9">
							<input type="text" name="shoulderDiscountPrice" id="shoulderDiscountPrice<?php echo $strm->ID; ?>" required class="form-control" />
						</div>
					</div>
					<hr />
					<table id="shoulderDiscountTABLE<?php echo $strm->ID; ?>">
						<tbody>
							<tr>
								<th style="width:200px">Discount price</th>
								<th style="width:200px">Action</th>
							</tr>
							<?php
							$discountSHOULDERs = $this->All->select_template_w_5_conditions(
								"cruise_brand_id", 	$this->All->getCruiseBrandID($shipgetID), 
								"cruise_ship_id", 	$shipgetID, 
								"no_of_nights", 	$shipgetNIGHTS,
								"stateroomID", 		$strm->ID,
								"period_type", 		"SHOULDER", 
								"cruise_discount"
							);
							if( $discountSHOULDERs == TRUE ) {
								foreach( $discountSHOULDERs AS $discountSHOULDER ) {
							?>
							<tr class="deleteRow">
								<td style="width:300px; text-align:left; padding:5px">
									<span style="color:green">
										<b>$<?php echo number_format($discountSHOULDER->extra_price_value, 2); ?></b>
									</span>
								</td>
								<td style="width:300px; text-align:left; padding:5px">
									<a href="<?php echo base_url(); ?>backend/product/deleteDiscountShoulder/<?php echo $discountSHOULDER->id; ?>" id="deleteDiscountShoulder" style="text-decoration:underline">Delete discount</a>
								</td>
							</tr>
							<?php
								}
							}
							?>
						</tbody>
					</table>
				</fieldset>
			</div>
			<div class="modal-footer">
				<a class="btn btn-link" data-dismiss="modal">Close</a>
				<a id="shoulderDiscountButton<?php echo $strm->ID; ?>" class="btn btn-primary">
					Add new discount
				</a>
			</div>
		</div>
	</div>
</div>
<!-- End of SHOULDER Manage Discount -->
				                </td>
			                </tr>
				        <?php
						}
						?>
				        </tbody>
				    </table>
					<div class="modal-footer-2"></div>
					<div class="modal-footer">
			    		<input type="hidden" name="price_period" value="2">
						<button type="submit" class="btn btn-primary btn-block">Save SHOULDER prices</button>
					</div>
			    <?php echo form_close(); ?>
			</div>
			<!-- End of Start of shoulder prices -->
			
			<!-- PEAK Manage Date -->
			<div id="peakDATE" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h5 class="modal-title">PEAK - Manage Date</h5>
						</div>
						<form method="post" class="form-horizontal" id="peakFORMDATE">
							<div class="modal-body">	
								<fieldset class="content-group">
									<div class="form-group">
										<label class="control-label col-lg-3">
											* From date
										</label>
										<div class="col-lg-9">
											<input type="text" name="peakFROMDATE" id="datepickerFROMPEAK" required readonly class="form-control" value="<?php echo date("Y-m-d"); ?>" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-3">
											* To date
										</label>
										<div class="col-lg-9">
											<input type="text" name="peakTODATE" id="datepickerTOPEAK" required readonly class="form-control" value="<?php echo date("Y-m-d", strtotime("+ 1 day")); ?>" />
										</div>
									</div>
									<hr />
									<table id="peakDateRuleTABLE">
										<tbody>
											<tr>
												<th style="width:200px">From date</th>
												<th style="width:200px">To date</th>
												<th style="width:200px">Action</th>
											</tr>
											<?php
											$datePEAKs = $this->All->select_template_w_4_conditions(
												"cruise_brand_id", 	$this->All->getCruiseBrandID($shipgetID), 
												"cruise_ship_id", 	$shipgetID, 
												"no_of_nights", 	$shipgetNIGHTS, 
												"period_type", 		"PEAK", 
												"cruise_prices_date_rule"
											);
											if( $datePEAKs == TRUE ) {
												foreach( $datePEAKs AS $datePEAK ) {
											?>
											<tr class="deleteRow">
												<td style="width:300px; text-align:left; padding:5px">
													From: 
													<span style="color:green">
														<b><?php echo date("Y-F-d", strtotime($datePEAK->date_from)); ?></b>
													</span>
												</td>
												<td style="width:300px; text-align:left; padding:5px">
													To: 
													<span style="color:green">
														<b><?php echo date("Y-F-d", strtotime($datePEAK->date_to)); ?></b>
													</span>
												</td>
												<td style="width:300px; text-align:left; padding:5px">
													<a href="<?php echo base_url(); ?>backend/product/deleteDatePEAK/<?php echo $datePEAK->id; ?>" id="deleteDatePEAK" style="text-decoration:underline">Delete date</a>
												</td>
											</tr>
											<?php
												}
											}
											?>
										</tbody>
									</table>
								</fieldset>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Add new date</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End of PEAK Manage Date -->			 
			<!-- Start of peak prices -->
			<div id="peak" class="tab-pane fade">
			    <?php echo form_open_multipart('backend/product_process/insert_cruise_prices/', array('class' => 'form-horizontal', 'novalidate' => 'novalidate')); ?>
			    	<input type="hidden" name="hidden_redirect" value="editMode" />
			    	<input type="hidden" name="hidden_cruisetitleID" value="<?php echo $this->uri->segment(4); ?>" />
			    	<div class="panel-heading" style="padding:0px"><h3>PEAK</h3></div>
				    <div style="float:right; margin-top:-40px">
					    <button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#peakDATE">
							<b><i class="icon-add"></i></b> Manage date(s)
						</button>
				    </div>
				    <div style="clear:both"></div>
				    <input type="hidden" name="hidden_ship_id" 		value="<?php echo $shipgetID; ?>" />
					<input type="hidden" name="hidden_brand_id" 	value="<?php echo $this->All->getCruiseBrandID($shipgetID); ?>" />
					<input type="hidden" name="hidden_period_type" 	value="PEAK" />
					<input type="hidden" name="hidden_nights_no" 	value="<?php echo $shipgetNIGHTS; ?>" />
				    <table class="table datatable-basic">
				        <thead>
				            <tr>
				              	<th></th>
							  	<th style="text-align:left">Stateroom</th>
							  	<th style="text-align:left">Single</th>
							  	<th style="text-align:left">1 Pax</th>
							  	<th colspan="2" style="text-align:left">2 Pax</th>
							  	<th colspan="2" style="text-align:left">3 Pax</th>
							  	<th colspan="2" style="text-align:left">4 Pax</th>
							  	<th style="text-align:left">&nbsp;</th>
				            </tr>
				        </thead>
				        <tbody>
					        <tr>
			                	<td>&nbsp;</td>
			                	<td>&nbsp;</td>          
			                    <td>&nbsp;</td>
			                    <td>&nbsp;</td>
			                    <td style="text-align:left"><b>Adult</b></td>
			                    <td style="text-align:left"><b>Child</b></td>
			                    <td style="text-align:left"><b>Adult</b></td>
			                    <td style="text-align:left"><b>Child</b></td>
			                    <td style="text-align:left"><b>Adult</b></td>
			                    <td style="text-align:left"><b>Child</b></td>
			                    <td style="text-align:left"><b>&nbsp;</b></td>
			                </tr>
				        <?php //get staterooms and prices
							$staterooms = $this->cruise->get_staterooms($this->All->getCruiseBrandID($shipgetID), $shipgetID);
							$row_id = 0;
							foreach($staterooms->result() as $strm){
								$row_id++;
								$getPrices = $this->All->select_template_w_5_conditions(
										"SHIP_ID", $shipgetID, "BRAND_ID", $this->All->getCruiseBrandID($shipgetID), 
										"STATEROOM_ID", $strm->ID, 
										"PERIOD_TYPE", "PEAK", "NIGHTS_NO", $shipgetNIGHTS,
										"cruise_prices"
									);
									if( $getPrices == TRUE ) {
										foreach( $getPrices AS $getPrice ) {
											$attS  = $getPrice->ATT_SINGLE;
											$att1  = $getPrice->ATT_1;
											$att2A = $getPrice->ATT_2_ADULT;
											$att2C = $getPrice->ATT_2_CHILD;
											$att3A = $getPrice->ATT_3_ADULT;
											$att3C = $getPrice->ATT_3_CHILD;
											$att4A = $getPrice->ATT_4_ADULT;
											$att4C = $getPrice->ATT_4_CHILD;
										}
									}
									else {
										$attS  = "";
										$att1  = "";
										$att2A = "";
										$att2C = "";
										$att3A = "";
										$att3C = "";
										$att4A = "";
										$att4C = "";
									}
								?>
									<tr>
					                	<td><?php echo $row_id; ?></td>
					                	<td><?php echo $strm->STATEROOM_NAME; ?></td>  
					                	<td>
						                	<input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][1]" value="<?php echo $attS; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>        
					                    <td>
						                	<input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][2]" value="<?php echo $att1; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
					                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][3]" value="<?php echo $att2A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
					                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][4]" value="<?php echo $att2C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
					                   	<td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][5]" value="<?php echo $att3A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
					                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][6]" value="<?php echo $att3C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
					                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][7]" value="<?php echo $att4A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
					                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][8]" value="<?php echo $att4C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" /></td>
					                    <td style="width:275px">
<button type="button" class="btn btn-primary btn-labeled btn-xs" data-toggle="modal" data-target="#peakEXTRA<?php echo $strm->ID; ?>">
	<b><i class="icon-add"></i></b> Extra Charge
</button>
<!-- PEAK Manage Extra Charge -->
<div id="peakEXTRA<?php echo $strm->ID; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title"><?php echo $strm->STATEROOM_NAME; ?> - Extra Charge (Peak Period Type)</h5>
			</div>
			<input type="hidden" id="hidden_stateroomPEAKDiscountID_<?php echo $strm->ID; ?>" value="<?php echo $strm->ID; ?>" />
			<div class="modal-body">	
				<fieldset class="content-group">
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Extra charge name
						</label>
						<div class="col-lg-9">
							<input type="text" name="peakChargeName" id="peakChargeName<?php echo $strm->ID; ?>" required class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Extra charge price
						</label>
						<div class="col-lg-9">
							<input type="text" name="peakChargePrice" id="peakChargePrice<?php echo $strm->ID; ?>" required class="form-control" />
						</div>
					</div>
					<hr />
					<table id="peakExtraChargeTABLE<?php echo $strm->ID; ?>">
						<tbody>
							<tr>
								<th style="width:200px">Extra charge name</th>
								<th style="width:200px">Extra charge price</th>
								<th style="width:200px">Action</th>
							</tr>
							<?php
							$extrapricePEAKs = $this->All->select_template_w_5_conditions(
								"cruise_brand_id", 	$this->All->getCruiseBrandID($shipgetID), 
								"cruise_ship_id", 	$shipgetID, 
								"no_of_nights", 	$shipgetNIGHTS,
								"stateroomID", 		$strm->ID,
								"period_type", 		"PEAK", 
								"cruise_extra_price"
							);
							if( $extrapricePEAKs == TRUE ) {
								foreach( $extrapricePEAKs AS $extrapricePEAK ) {
							?>
							<tr class="deleteRow">
								<td style="width:300px; text-align:left; padding:5px">
									<span style="color:green">
										<b><?php echo $extrapricePEAK->extra_price_name; ?></b>
									</span>
								</td>
								<td style="width:300px; text-align:left; padding:5px">
									<span style="color:green">
										<b>$<?php echo number_format($extrapricePEAK->extra_price_value, 2); ?></b>
									</span>
								</td>
								<td style="width:300px; text-align:left; padding:5px">
									<a href="<?php echo base_url(); ?>backend/product/deleteExtraChargePeak/<?php echo $extrapricePEAK->id; ?>" id="deleteExtraChargePeak" style="text-decoration:underline">Delete extra charge</a>
								</td>
							</tr>
							<?php
								}
							}
							?>
						</tbody>
					</table>
				</fieldset>
			</div>
			<div class="modal-footer">
				<a class="btn btn-link" data-dismiss="modal">Close</a>
				<a id="peakExtraChargeButton<?php echo $strm->ID; ?>" class="btn btn-primary">
					Add new extra charge
				</a>
			</div>
		</div>
	</div>
</div>
<!-- End of PEAK Manage Extra Charge -->
<button type="button" class="btn btn-primary btn-labeled btn-xs" data-toggle="modal" data-target="#peakDISCOUNT<?php echo $strm->ID; ?>">
	<b><i class="icon-add"></i></b> Discount
</button>
<!-- PEAK Manage Discount -->
<div id="peakDISCOUNT<?php echo $strm->ID; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title"><?php echo $strm->STATEROOM_NAME; ?> - Discount (Peak Period Type)</h5>
			</div>
			<input type="hidden" id="hidden_stateroomID_<?php echo $strm->ID; ?>" value="<?php echo $strm->ID; ?>" />
			<div class="modal-body">	
				<fieldset class="content-group">
					<div class="form-group">
						<label class="control-label col-lg-3">
							* Enter discount price
						</label>
						<div class="col-lg-9">
							<input type="text" name="peakDiscountPrice" id="peakDiscountPrice<?php echo $strm->ID; ?>" required class="form-control" />
						</div>
					</div>
					<hr />
					<table id="peakDiscountTABLE<?php echo $strm->ID; ?>">
						<tbody>
							<tr>
								<th style="width:200px">Discount price</th>
								<th style="width:200px">Action</th>
							</tr>
							<?php
							$discountPEAKs = $this->All->select_template_w_5_conditions(
								"cruise_brand_id", 	$this->All->getCruiseBrandID($shipgetID), 
								"cruise_ship_id", 	$shipgetID, 
								"no_of_nights", 	$shipgetNIGHTS,
								"stateroomID", 		$strm->ID,
								"period_type", 		"PEAK", 
								"cruise_discount"
							);
							if( $discountPEAKs == TRUE ) {
								foreach( $discountPEAKs AS $discountPEAK ) {
							?>
							<tr class="deleteRow">
								<td style="width:300px; text-align:left; padding:5px">
									<span style="color:green">
										<b>$<?php echo number_format($discountPEAK->extra_price_value, 2); ?></b>
									</span>
								</td>
								<td style="width:300px; text-align:left; padding:5px">
									<a href="<?php echo base_url(); ?>backend/product/deleteDiscountPeak/<?php echo $discountPEAK->id; ?>" id="deleteDiscountPeak" style="text-decoration:underline">Delete discount</a>
								</td>
							</tr>
							<?php
								}
							}
							?>
						</tbody>
					</table>
				</fieldset>
			</div>
			<div class="modal-footer">
				<a class="btn btn-link" data-dismiss="modal">Close</a>
				<a id="peakDiscountButton<?php echo $strm->ID; ?>" class="btn btn-primary">
					Add new discount
				</a>
			</div>
		</div>
	</div>
</div>
<!-- End of PEAK Manage Discount -->
				                    	</td>
					                </tr>
				                <?php
							}//end foreach
						?>
				        </tbody>
				    </table>
			        <div class="modal-footer-2"></div>
			        <div class="modal-footer">
			        	<input type="hidden" name="price_period" value="1">
						<button type="submit" class="btn btn-primary btn-block">Save PEAK prices</button>
					</div>
			    <?php echo form_close(); ?>
			</div>
			<!-- End peak prices -->
		</div>
	</div>
</div> 
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Edit stateroom quantity</h3>
<table class="table datatable-basic" id="stateroomTable">
	<thead>
		<tr>
			<th style="text-align:left" width="50%">Stateroom Name</th>
			<th style="text-align:center" width="15%">Occupant</th>
			<th style="text-align:center" width="15%" class="text-center">Quantity</th>
			<th style="text-align:center" width="20%" class="text-center">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$staterooms = $this->All->select_template_with_where2_and_order(
			"CRUISE_BRAND_ID", 	$this->All->getCruiseBrandID($shipgetID), 
			"CRUISE_SHIP_ID", 	$shipgetID, 
			"orderNo", "ASC", 
			"cruise_stateroom"
		);
		if( $staterooms == TRUE ) {
			foreach( $staterooms AS $stateroom ) {
		?>
		<tr class="deleteRow editRow" id="sectionsid_<?php echo $stateroom->ID; ?>">
         	<td style="text-align:left"><?php echo $stateroom->STATEROOM_NAME; ?></td>
		 	<td style="text-align:center"><?php echo $stateroom->STATEROOM_OCCUPANT; ?></td>
		 	<td style="text-align:center">
				<?php 
				$qty = $this->All->getStateroomQuantity(
					$this->uri->segment(4), $this->All->getCruiseBrandID($shipgetID), $shipgetID, $stateroom->ID
				);
				?>
				<div id="qty_sectionsid_<?php echo $stateroom->ID; ?>"><?php echo $qty; ?></div>
				<div class="editMode">
			    	<input type="text" class="form-control editbox" id="qtyEdit_sectionsid_<?php echo $stateroom->ID; ?>" style="text-align:center" value="<?php echo $qty; ?>">
			    </div>
			</td>
		 	<td style="text-align:center">
			 	<div id="UnableEditMode_sectionsid_<?php echo $stateroom->ID; ?>">
					<a href="#" class="editButtonSTT" id="sectionsid_<?php echo $stateroom->ID; ?>">
						<b><i class="icon-pencil"></i></b>
					</a>
		        </div>
		        <div id="EnableEditMode_sectionsid_<?php echo $stateroom->ID; ?>" class="EnableEditMode">
			        <input type="hidden" name="stateroomID" id="stateroomID_<?php echo $stateroom->ID; ?>" value="<?php echo $stateroom->ID; ?>">
		        	<button id="saveEdit_sectionsid_<?php echo $stateroom->ID; ?>" class="btn btn-primary btn-xs" style="margin-top: 3px;">Save change</button>
		        	<button id="cancelEdit_sectionsid_<?php echo $stateroom->ID; ?>" class="btn btn-primary btn-xs" style="margin-top: 3px;">Cancel</button>
		        </div>
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
						</div>
					</div>
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