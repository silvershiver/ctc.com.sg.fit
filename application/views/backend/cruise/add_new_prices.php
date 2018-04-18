<!-- 
	
    Period Types
    Low | ID: 3
    Shoulder: | ID: 2
    Peak | ID: 1
	
    Prices for ATT1, 2, 3, 4
    
   	*Set date rules to apply for period types across date ranges and specific dates
    Compulsory to set or prices wont appear.
    
-->
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
	$night_type = $this->session->userdata('night_type');
	if(isset($_POST['night_type'])){
		$this->session->set_userdata('night_type', $_POST['night_type']);
		$night_type = $this->session->userdata('night_type');	
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/drilldown.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/anytime.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/legacy.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#datepickerFROMLOW").datepicker({dateFormat:"yy-mm-dd"});
			$("#datepickerTOLOW").datepicker({dateFormat:"yy-mm-dd"});			
			$("#datepickerFROMSHOULDER").datepicker({dateFormat:"yy-mm-dd"});
			$("#datepickerTOSHOULDER").datepicker({dateFormat:"yy-mm-dd"});
			$("#datepickerFROMPEAK").datepicker({dateFormat:"yy-mm-dd"});
			$("#datepickerTOPEAK").datepicker({dateFormat:"yy-mm-dd"});
  		});
  	</script>
  	<script type="text/javascript">
	  	
	  	/*-----LOW PERIOD-----*/
	  	
	  		/*-----INSERT FUNCTION-----*/
	  		$(document).on('submit', '#lowFORMDATE', function() {
				var datepickerFROM = $("#datepickerFROMLOW").val();
				var datepickerTO   = $("#datepickerTOLOW").val();
				var dataString 	   = 'datepicker_from='+datepickerFROM+'&datepicker_to='+datepickerTO+'&period_type=LOW&brand_id=<?php echo $this->session->userdata('ship_brand'); ?>&shipd_id=<?php echo $this->session->userdata('ship_name'); ?>&noof_night=<?php echo $this->session->userdata('night_type'); ?>';
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
			$staterooms = $this->cruise->get_staterooms($ship_brand, $ship_name);
			foreach($staterooms->result() as $strm) {
			?>
			$(document).ready(function() {
				$('a#lowExtraChargeButton<?php echo $strm->ID; ?>').click(function() {
					var lowChargeName  = $("#lowChargeName<?php echo $strm->ID; ?>").val();
					var lowChargePrice = $("#lowChargePrice<?php echo $strm->ID; ?>").val();
					var lowStateroomID = $("#hidden_stateroomID_<?php echo $strm->ID; ?>").val();
					if( lowChargeName == "" && lowChargePrice == "" ) {
						alert("Name and price are required");
					}
					else {
						var dataString = 'stateroomID='+lowStateroomID+'&low_charge_name='+lowChargeName+'&low_charge_price='+lowChargePrice+'&period_type=LOW&brand_id=<?php echo $this->session->userdata('ship_brand'); ?>&shipd_id=<?php echo $this->session->userdata('ship_name'); ?>&noof_night=<?php echo $this->session->userdata('night_type'); ?>';
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
									alert("New extra charge has been added");
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
					var discountStateroomID = $("#hidden_stateroomID_<?php echo $strm->ID; ?>").val();
					if( discountPrice == "" ) {
						alert("Price is required");
					}
					else {
						var dataString = 'stateroomID='+discountStateroomID+'&discount_price='+discountPrice+'&period_type=LOW&brand_id=<?php echo $this->session->userdata('ship_brand'); ?>&shipd_id=<?php echo $this->session->userdata('ship_name'); ?>&noof_night=<?php echo $this->session->userdata('night_type'); ?>';
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
									$("#lowDiscountTABLE<?php echo $strm->ID; ?> tbody tr:last").after('<tr class="deleteRow"><td style="width:300px; text-align:left; padding:5px"><span style="color:green"><b>$'+result.discountPriceValue+'</b></span></td><td style="width:300px; text-align:left; padding:5px"><a href="<?php echo base_url(); ?>backend/product/deleteDiscountLoW/'+result.discountPriceID+'" id="deleteDiscountLoW" style="text-decoration:underline">Delete extra charge</a></td></tr>');
									alert("New discount price has been added");
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
			                alert('Date removed');
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
		                alert('Date removed');
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
			                alert('Extra charge price removed');
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
		                alert('Extra charge price removed');
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
			                alert('Discount price removed');
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
		                alert('Discount price removed');
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
				var dataString 	   = 'datepicker_from='+datepickerFROM+'&datepicker_to='+datepickerTO+'&period_type=SHOULDER&brand_id=<?php echo $this->session->userdata('ship_brand'); ?>&shipd_id=<?php echo $this->session->userdata('ship_name'); ?>&noof_night=<?php echo $this->session->userdata('night_type'); ?>';
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
			$staterooms = $this->cruise->get_staterooms($ship_brand, $ship_name);
			foreach($staterooms->result() as $strm) {
			?>
			$(document).ready(function() {
				$('a#shoulderExtraChargeButton<?php echo $strm->ID; ?>').click(function() {
					var shoulderChargeName  = $("#shoulderChargeName<?php echo $strm->ID; ?>").val();
					var shoulderChargePrice = $("#shoulderChargePrice<?php echo $strm->ID; ?>").val();
					var shoulderStateroomID = $("#hidden_stateroomID_<?php echo $strm->ID; ?>").val();
					if( shoulderChargeName == "" && shoulderChargePrice == "" ) {
						alert("Name and price are required");
					}
					else {
						var dataString = 'stateroomID='+shoulderStateroomID+'&shoulder_charge_name='+shoulderChargeName+'&shoulder_charge_price='+shoulderChargePrice+'&period_type=SHOULDER&brand_id=<?php echo $this->session->userdata('ship_brand'); ?>&shipd_id=<?php echo $this->session->userdata('ship_name'); ?>&noof_night=<?php echo $this->session->userdata('night_type'); ?>';
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
									alert("New extra charge has been added");
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
						var dataString = 'stateroomID='+discountStateroomID+'&discount_price='+discountPrice+'&period_type=SHOULDER&brand_id=<?php echo $this->session->userdata('ship_brand'); ?>&shipd_id=<?php echo $this->session->userdata('ship_name'); ?>&noof_night=<?php echo $this->session->userdata('night_type'); ?>';
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
									alert("New discount price has been added");
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
			                alert('Date removed');
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
		                alert('Date removed');
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
			                alert('Extra charge price removed');
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
		                alert('Extra charge price removed');
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
			                alert('Discount price removed');
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
		                alert('Discount price removed');
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
				var dataString 	   = 'datepicker_from='+datepickerFROM+'&datepicker_to='+datepickerTO+'&period_type=PEAK&brand_id=<?php echo $this->session->userdata('ship_brand'); ?>&shipd_id=<?php echo $this->session->userdata('ship_name'); ?>&noof_night=<?php echo $this->session->userdata('night_type'); ?>';
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
			$staterooms = $this->cruise->get_staterooms($ship_brand, $ship_name);
			foreach($staterooms->result() as $strm) {
			?>
			$(document).ready(function() {
				$('a#peakExtraChargeButton<?php echo $strm->ID; ?>').click(function() {
					var peakChargeName  = $("#peakChargeName<?php echo $strm->ID; ?>").val();
					var peakChargePrice = $("#peakChargePrice<?php echo $strm->ID; ?>").val();
					var peakStateroomID = $("#hidden_stateroomID_<?php echo $strm->ID; ?>").val();
					if( peakChargeName == "" && peakChargePrice == "" ) {
						alert("Name and price are required");
					}
					else {
						var dataString = 'stateroomID='+peakStateroomID+'&peak_charge_name='+peakChargeName+'&peak_charge_price='+peakChargePrice+'&period_type=PEAK&brand_id=<?php echo $this->session->userdata('ship_brand'); ?>&shipd_id=<?php echo $this->session->userdata('ship_name'); ?>&noof_night=<?php echo $this->session->userdata('night_type'); ?>';
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
									alert("New extra charge has been added");
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
					var discountStateroomID = $("#hidden_stateroomID_<?php echo $strm->ID; ?>").val();
					if( discountPrice == "" ) {
						alert("Price is required");
					}
					else {
						var dataString = 'stateroomID='+discountStateroomID+'&discount_price='+discountPrice+'&period_type=PEAK&brand_id=<?php echo $this->session->userdata('ship_brand'); ?>&shipd_id=<?php echo $this->session->userdata('ship_name'); ?>&noof_night=<?php echo $this->session->userdata('night_type'); ?>';
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
									alert("New discount price has been added");
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
			                alert('Date removed');
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
		                alert('Date removed');
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
			                alert('Extra charge price removed');
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
		                alert('Extra charge price removed');
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
			                alert('Discount price removed');
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
		                alert('Discount price removed');
		            }
		        );
		        $(this).closest("tr.deleteRow").remove();
		        return false;
			});
			/*-----END OF DELETE FUNCTION-----*/
		
		/*-----END OF PEAK PERIOD-----*/


	</script>
  	<style>
	  	.date_field {position: relative; z-index:9999;}
	  	.ui-datepicker{z-index: 9999 !important};
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
	<!-- /page header -->

	<!-- Page container -->
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
            	<div class="col-md-12">
	            	<?php echo $this->session->flashdata('sessionSHOULDERPrice'); ?>
					<?php echo $this->session->flashdata('sessionLOWPrice'); ?>
					<?php echo $this->session->flashdata('sessionPEAKPrice'); ?>
					<div class="panel panel-flat"> 
					  	<h5 class="panel-title" style="margin-left:30px; margin-top:20px">
						  	<?php echo $title;?>
						</h5>
						<div class="modal-body">
							<form action="#" method="post" class="form-horizontal">
								<fieldset class="content-group" style="margin-bottom:0px !important">
						        	<div class="form-group">
										<div class="col-lg-3">
											<select name="ship_brand" onChange="submit()" class="form-control">
							                	<option value="">Please select ship brand</option>
							                    <?php 
													//get brand
													$brands_query = $this->cruise->get_cruise_brands();
													foreach($brands_query->result() as $brand){
														?>
							                            <option value="<?php echo $brand->ID;?>" 
														<?php if($brand->ID == $ship_brand){ echo 'selected';}?>>
															<?php echo $brand->NAME;?></option>
							                            <?php
													}//foreach
												?>
							                </select>
										</div>
										<div class="col-lg-3">		                
							                <?php if(!empty($ship_brand)){?>
							                <select name="ship_name" onChange="submit()" class="form-control">
							                	<option value="">Please select ship name</option>
							                    <?php 
													//get ships
													$ships_query = $this->cruise->get_cruise_ships($ship_brand, 'PARENT_BRAND');
													foreach($ships_query->result() as $ship){
														?>
							                            <option value="<?php echo $ship->ID;?>" 
							                            <?php if($ship->ID == $ship_name){ echo "selected"; } ?> >
															<?php echo $ship->SHIP_NAME;?></option>
							                            <?php
													}//foreach
												?>
							                </select>
							                <?php } // if not empty ship name ?>
										</div>
										<div class="col-lg-3">
											<?php if(!empty($ship_name)){?>
							                <select name="night_type" onChange="submit()" class="form-control">
							                	<option value="">Please select nights</option>
							                    <?php 
													//get number of nights
													$night_count = 0;
													while($night_count < 12){
														$night_count++;
														?>
							                            <option value="<?php echo $night_count;?>" 
							                            <?php if($night_type == $night_count){ echo "selected"; } ?>>
							                            	<?php echo $night_count;?> Night(s)
							                            </option>
							                            <?php
													}//while
												?>
							                </select>
							                <?php } // if not empty night_type ?>
										</div>
						        	</div>
								</fieldset>
							</form>
						</div>
					</div>
            	</div>
            	<div class="col-md-12">
					<div class="panel panel-flat"> 
						<div class="panel-body">
<?php if(!empty($ship_brand) AND !empty($ship_name) AND !empty($night_type)) { ?>
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
												"cruise_brand_id", 	$ship_brand, 
												"cruise_ship_id", 	$ship_name, 
												"no_of_nights", 	$night_type, 
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
				    <div class="panel-heading" style="padding:0px"><h3>LOW</h3></div>
				    <div style="float:right; margin-top:-40px">
					    <button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#lowDATE">
							<b><i class="icon-add"></i></b> Manage date(s)
						</button>
				    </div>
				    <div style="clear:both"></div>
				    <input type="hidden" name="hidden_ship_id" 		value="<?php echo $ship_name; ?>" />
				    <input type="hidden" name="hidden_brand_id" 	value="<?php echo $ship_brand; ?>" />
				    <input type="hidden" name="hidden_period_type" 	value="LOW" />
				    <input type="hidden" name="hidden_nights_no" 	value="<?php echo $night_type; ?>" />
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
							$staterooms = $this->cruise->get_staterooms($ship_brand, $ship_name);
							$row_id = 0;
							foreach($staterooms->result() as $strm) {
								$row_id++;
								$getPrices = $this->All->select_template_w_5_conditions(
									"SHIP_ID", $ship_name, "BRAND_ID", $ship_brand, "STATEROOM_ID", $strm->ID, 
									"PERIOD_TYPE", "LOW", "NIGHTS_NO", $night_type,
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
				                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][3]" value="<?php echo $att2A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
				                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][4]" value="<?php echo $att2C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
				                   	<td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][5]" value="<?php echo $att3A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
				                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][6]" value="<?php echo $att3C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
				                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][7]" value="<?php echo $att4A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
				                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][8]" value="<?php echo $att4C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
				                    <td style="width:275px">
<a class="btn btn-primary btn-labeled btn-xs" data-toggle="modal" data-target="#lowEXTRA<?php echo $strm->ID; ?>">
	<b><i class="icon-add"></i></b> Extra Charge
</a>
<!-- LOW Manage Extra Charge -->
<div id="lowEXTRA<?php echo $strm->ID; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title"><?php echo $strm->STATEROOM_NAME; ?> - Extra Charge (Low Period Type)</h5>
			</div>
			<input type="hidden" id="hidden_stateroomID_<?php echo $strm->ID; ?>" value="<?php echo $strm->ID; ?>" />
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
								"cruise_brand_id", 	$ship_brand, 
								"cruise_ship_id", 	$ship_name, 
								"no_of_nights", 	$night_type,
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
<a class="btn btn-primary btn-labeled btn-xs" data-toggle="modal" data-target="#lowDISCOUNT<?php echo $strm->ID; ?>">
	<b><i class="icon-add"></i></b> Discount
</a>
<!-- LOW Manage Discount -->
<div id="lowDISCOUNT<?php echo $strm->ID; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title"><?php echo $strm->STATEROOM_NAME; ?> - Discount (Low Period Type)</h5>
			</div>
			<input type="hidden" id="hidden_stateroomID_<?php echo $strm->ID; ?>" value="<?php echo $strm->ID; ?>" />
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
								"cruise_brand_id", 	$ship_brand, 
								"cruise_ship_id", 	$ship_name, 
								"no_of_nights", 	$night_type,
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
												"cruise_brand_id", 	$ship_brand, 
												"cruise_ship_id", 	$ship_name, 
												"no_of_nights", 	$night_type, 
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
				    <div class="panel-heading" style="padding:0px"><h3>SHOULDER</h3></div>
				    <div style="float:right; margin-top:-40px">
					    <button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#shoulderDATE">
							<b><i class="icon-add"></i></b> Manage date(s)
						</button>
				    </div>
				    <div style="clear:both"></div>
				    <input type="hidden" name="hidden_ship_id" 		value="<?php echo $ship_name; ?>" />
					<input type="hidden" name="hidden_brand_id" 	value="<?php echo $ship_brand; ?>" />
					<input type="hidden" name="hidden_period_type" 	value="SHOULDER" />
					<input type="hidden" name="hidden_nights_no" 	value="<?php echo $night_type; ?>" />
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
						$staterooms = $this->cruise->get_staterooms($ship_brand, $ship_name);
						$row_id 	= 0;
						foreach($staterooms->result() as $strm) {
							$row_id++;
							$getPrices = $this->All->select_template_w_5_conditions(
								"SHIP_ID", $ship_name, "BRAND_ID", $ship_brand, "STATEROOM_ID", $strm->ID, 
								"PERIOD_TYPE", "SHOULDER", "NIGHTS_NO", $night_type,
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
			                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][3]" value="<?php echo $att2A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
			                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][4]" value="<?php echo $att2C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
			                   	<td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][5]" value="<?php echo $att3A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
			                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][6]" value="<?php echo $att3C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
			                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][7]" value="<?php echo $att4A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
			                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][8]" value="<?php echo $att4C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
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
			<input type="hidden" id="hidden_stateroomID_<?php echo $strm->ID; ?>" value="<?php echo $strm->ID; ?>" />
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
								"cruise_brand_id", 	$ship_brand, 
								"cruise_ship_id", 	$ship_name, 
								"no_of_nights", 	$night_type,
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
								"cruise_brand_id", 	$ship_brand, 
								"cruise_ship_id", 	$ship_name, 
								"no_of_nights", 	$night_type,
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
												"cruise_brand_id", 	$ship_brand, 
												"cruise_ship_id", 	$ship_name, 
												"no_of_nights", 	$night_type, 
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
			    	<div class="panel-heading" style="padding:0px"><h3>PEAK</h3></div>
				    <div style="float:right; margin-top:-40px">
					    <button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#peakDATE">
							<b><i class="icon-add"></i></b> Manage date(s)
						</button>
				    </div>
				    <div style="clear:both"></div>
				    <input type="hidden" name="hidden_ship_id" 		value="<?php echo $ship_name; ?>" />
					<input type="hidden" name="hidden_brand_id" 	value="<?php echo $ship_brand; ?>" />
					<input type="hidden" name="hidden_period_type" 	value="PEAK" />
					<input type="hidden" name="hidden_nights_no" 	value="<?php echo $night_type; ?>" />
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
							$staterooms = $this->cruise->get_staterooms($ship_brand, $ship_name);
							$row_id = 0;
							foreach($staterooms->result() as $strm){
								$row_id++;
								$getPrices = $this->All->select_template_w_5_conditions(
										"SHIP_ID", $ship_name, "BRAND_ID", $ship_brand, "STATEROOM_ID", $strm->ID, 
										"PERIOD_TYPE", "PEAK", "NIGHTS_NO", $night_type,
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
					                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][3]" value="<?php echo $att2A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
					                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][4]" value="<?php echo $att2C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
					                   	<td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][5]" value="<?php echo $att3A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
					                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][6]" value="<?php echo $att3C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
					                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][7]" value="<?php echo $att4A; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
					                    <td><input type="text" class="form-control" name="stateroom[<?php echo $strm->ID; ?>][8]" value="<?php echo $att4C; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center"></td>
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
			<input type="hidden" id="hidden_stateroomID_<?php echo $strm->ID; ?>" value="<?php echo $strm->ID; ?>" />
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
								"cruise_brand_id", 	$ship_brand, 
								"cruise_ship_id", 	$ship_name, 
								"no_of_nights", 	$night_type,
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
								"cruise_brand_id", 	$ship_brand, 
								"cruise_ship_id", 	$ship_name, 
								"no_of_nights", 	$night_type,
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
<?php } ?>               	
						</div>
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