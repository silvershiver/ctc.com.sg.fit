<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CTC Travel | Search Hotel Result</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css?1" type="text/css" media="screen,projection,print" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" />
	<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/magnific-popup.css" /> -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/typehead/css/typehead.css" type="text/css" media="screen" />
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>assets/favicons/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/favicons/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/favicons/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/favicons/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/favicons/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/favicons/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/favicons/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/favicons/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/favicons/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>assets/favicons/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/favicons/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/favicons/favicon-16x16.png">
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.raty.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js?<?php echo uniqid(); ?>"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.magnific-popup.js"></script> -->
	<script type="text/javascript" src="<?php echo base_url();?>assets/typehead/js/typeahead.bundle.js?1"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ba-throttle-debounce.min.js"></script>
	<link rel="manifest" href="<?php echo base_url(); ?>assets/favicons/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/favicons/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<style type="text/css">
		.tt-open {height: auto; max-height:200px; overflow-y: auto; }
		#text-loaded {
		  animation: blinker 2s linear infinite;
		}

		@keyframes blinker {
		  50% { opacity: 0.3; }
		}

		.refine-search-results {
			index : 2;
			opacity: 0.5;
		}
		.
		.refine-search-results .f-item {
		    float: left;
		    display: block;
		    width: 100%;
		    padding: 0 0 6px;
		}
		.refine-search-results .f-item label {
		    font-size: 1.3em;
		    padding: 0 0 8px;
		    display: inline-block;
		    width: 100%;
		    font-family: 'OpenSansRegular';
		    white-space: nowrap;
		}
		.refine-search-results .f-item input[type="text"] {
		    float: left;
		    display: block;
		    -webkit-box-shadow: 0 1px 1px rgba(204, 204, 204, 1) inset, 0 1px 0 rgba(255,255,255,1);
		    -moz-box-shadow: 0 1px 1px rgba(204, 204, 204, 1) inset, 0 1px 0 rgba(255,255,255,1);
		    box-shadow: 0 1px 1px rgba(204, 204, 204, 1) inset, 0 1px 0 rgba(255,255,255,1);

		}
		.disablePointerEvent {
			pointer-events: none;
		}
	</style>
	<style type="text/css">@keyframes lds-ellipsis3 {
		  0%, 25% {
		    left: 32px;
		    -webkit-transform: scale(0);
		    transform: scale(0);
		  }
		  50% {
		    left: 32px;
		    -webkit-transform: scale(1);
		    transform: scale(1);
		  }
		  75% {
		    left: 100px;
		  }
		  100% {
		    left: 168px;
		    -webkit-transform: scale(1);
		    transform: scale(1);
		  }
		}
		@-webkit-keyframes lds-ellipsis3 {
		  0%, 25% {
		    left: 32px;
		    -webkit-transform: scale(0);
		    transform: scale(0);
		  }
		  50% {
		    left: 32px;
		    -webkit-transform: scale(1);
		    transform: scale(1);
		  }
		  75% {
		    left: 100px;
		  }
		  100% {
		    left: 168px;
		    -webkit-transform: scale(1);
		    transform: scale(1);
		  }
		}
		@keyframes lds-ellipsis2 {
		  0% {
		    -webkit-transform: scale(1);
		    transform: scale(1);
		  }
		  25%, 100% {
		    -webkit-transform: scale(0);
		    transform: scale(0);
		  }
		}
		@-webkit-keyframes lds-ellipsis2 {
		  0% {
		    -webkit-transform: scale(1);
		    transform: scale(1);
		  }
		  25%, 100% {
		    -webkit-transform: scale(0);
		    transform: scale(0);
		  }
		}
		@keyframes lds-ellipsis {
		  0% {
		    left: 32px;
		    -webkit-transform: scale(0);
		    transform: scale(0);
		  }
		  25% {
		    left: 32px;
		    -webkit-transform: scale(1);
		    transform: scale(1);
		  }
		  50% {
		    left: 100px;
		  }
		  75% {
		    left: 168px;
		    -webkit-transform: scale(1);
		    transform: scale(1);
		  }
		  100% {
		    left: 168px;
		    -webkit-transform: scale(0);
		    transform: scale(0);
		  }
		}
		@-webkit-keyframes lds-ellipsis {
		  0% {
		    left: 32px;
		    -webkit-transform: scale(0);
		    transform: scale(0);
		  }
		  25% {
		    left: 32px;
		    -webkit-transform: scale(1);
		    transform: scale(1);
		  }
		  50% {
		    left: 100px;
		  }
		  75% {
		    left: 168px;
		    -webkit-transform: scale(1);
		    transform: scale(1);
		  }
		  100% {
		    left: 168px;
		    -webkit-transform: scale(0);
		    transform: scale(0);
		  }
		}
		.lds-css {
		  	text-align: center;
		  	margin: 0 auto;
		}
		.lds-ellipsis {
		  	position: relative;
		}
		.lds-ellipsis > div {
		  position: absolute;
		  -webkit-transform: translate(-50%, -50%);
		  transform: translate(-50%, -50%);
		  width: 40px;
		  height: 40px;
		}
		.lds-ellipsis div > div {
		  width: 40px;
		  height: 40px;
		  border-radius: 50%;
		  background: #f00;
		  position: absolute;
		  top: 100px;
		  left: 32px;
		  -webkit-animation: lds-ellipsis 2s cubic-bezier(0, 0.5, 0.5, 1) infinite forwards;
		  animation: lds-ellipsis 2s cubic-bezier(0, 0.5, 0.5, 1) infinite forwards;
		}
		.lds-ellipsis div:nth-child(1) div {
		  -webkit-animation: lds-ellipsis2 2s cubic-bezier(0, 0.5, 0.5, 1) infinite forwards;
		  animation: lds-ellipsis2 2s cubic-bezier(0, 0.5, 0.5, 1) infinite forwards;
		  background: #ff7841;
		}
		.lds-ellipsis div:nth-child(2) div {
		  -webkit-animation-delay: -1s;
		  animation-delay: -1s;
		  background: #141414;
		}
		.lds-ellipsis div:nth-child(3) div {
		  -webkit-animation-delay: -0.5s;
		  animation-delay: -0.5s;
		  background: #545454;
		}
		.lds-ellipsis div:nth-child(4) div {
		  -webkit-animation-delay: 0s;
		  animation-delay: 0s;
		  background: #f7f7f7;
		}
		.lds-ellipsis div:nth-child(5) div {
		  -webkit-animation: lds-ellipsis3 2s cubic-bezier(0, 0.5, 0.5, 1) infinite forwards;
		  animation: lds-ellipsis3 2s cubic-bezier(0, 0.5, 0.5, 1) infinite forwards;
		  background: #ff7841;
		}
		.lds-ellipsis {
		  width: 200px !important;
		  height: 200px !important;
		  -webkit-transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
		  transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
		}
		.facboard { float:left; width: 20%; margin-bottom: 10px }.facimg { float:left; margin-left:3px; }
	</style>
</head>
<body>
	<?php require_once(APPPATH."views/master-frontend/header.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>
	<div class="main" role="main">
		<div class="wrap clearfix">
			<div class="content clearfix">
			<!--HOTEL CHANGE SEARCH-->
			<div class="main-search" id="changeSearchContent" style="margin:0px; margin-bottom:0px; margin-top:40px; display:none">
				<div class="search_container">
					<div class="column radios">
						<h4><span>01</span> What?</h4>
						<div class="f-item" >
							<input type="radio" name="radio" id="hotel" value="form1" checked />
							<label for="hotel">Hotel</label>
						</div>
					</div>
					<div class="forms">
						<?php echo form_open_multipart('search/hotel_result', array('class' => 'form-horizontal', 'id'=>'search-hotel-form')); ?>
							<div class="column">
								<h4><span>02</span> Where?</h4>
								<div class="f-item" id="hotel_destination">
									<label for="destination1">Your destination</label>
									<input type="text" class="typeahead" placeholder="City, region or district" name="hotel_destination" value="<?php echo $search_full_text; ?>" required />
								</div>
							</div>
							<div class="column twins">
								<h4><span>03</span> When?</h4>
								<div class="f-item datepicker">
									<label for="datepicker1">Check-in date</label>
									<div class="datepicker-wrap">
										<input type="text" id="datepickerHotelCheckIn" name="hotel_checkin" value="<?php echo $hotel_checkin; ?>" required readonly />
									</div>
								</div>
								<div class="f-item datepicker">
									<label for="datepicker2">Check-out date</label>
									<div class="datepicker-wrap">
										<input type="text" id="datepickerHotelCheckOut" name="hotel_checkout" value="<?php echo $hotel_checkout; ?>" required readonly />
									</div>
								</div>
							</div>
							<div class="column triplets">
								<h4><span>04</span> Who?</h4>
								<div class="f-item spinner">
									<label for="spinner1">Room(s)</label>
									<select name="hotel_noofroom" id="hotel_noofroom">
										<?php
										for($r=1; $r<10; $r++) {
											if( $no_of_rooms == $r ) {
										?>
											<option value="<?php echo $r; ?>" SELECTED><?php echo $r; ?></option>
										<?php
											}
											else {
										?>
											<option value="<?php echo $r; ?>"><?php echo $r; ?></option>
										<?php
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="lightbox-booking" style="display:none;">
								<div class="lb-wrap" style="max-width:900px; width:85%; left:18%">
									<a href="#" class="close">x</a>
									<div class="lb-content">
										<div class="box-content-booking">
										</div>
									</div>
								</div>
							</div>
							<button type="button" class="search-submit search-popup2">Proceed to results</button>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<!--END OF HOTEL CHANGE SEARCH-->
			<!--BREADCUMBS-->
			<nav role="navigation" class="breadcrumbs clearfix">
				<ul class="crumbs">
					<li><a href="#" style="cursor:default">You are here:</a></li>
					<li><a href="#" style="cursor:default">Home</a></li>
					<li><a href="#" style="cursor:default">Search Hotel</a></li>
					<li><a href="#" style="cursor:default"><?php echo $country_name; ?></a></li>
					<li><a href="#" style="cursor:default"><?php echo $city_name; ?></a></li>
					<li>Search results</li>
				</ul>
				<ul class="top-right-nav">
					<li><a href="#" id="changeSearchAnchor" title="Change search">Change search</a></li>
				</ul>
			</nav>
			<!--END OF BREADCUMBS-->
			<!--SIDEBAR-->
			<aside class="left-sidebar">
				<div style="height: 100%; z-index:5; position: absolute; width: 100%" id="opener"></div>
				<article class="refine-search-results">
					<h2>Advanced Search Filter</h2>
					<dl>
						<dt>Search by price</dt>
						<dd>
							<input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;" />
							<div id="slider-range"></div>
						</dd>
						<dt>Hotel name</dt>
						<dd>
							<input type="text" name="" placeholder="Enter hotel name" id="search-hotel-name"/>
						</dd>
						<dt>Star rating</dt>
						<dd>
							<div id="star" data-rating="0"></div>
						</dd>
						<form method="post" id="hotel_attribute_form">
							<dt>Hotel facilities</dt>
							<dd>
								<div class="facboard">
									<input type="checkbox" id="ch1" value="*AC" class="hotel_attribute" name="hotelfacilities[]"><label for="ch1"><img src="<?php echo base_url();?>assets/fac_icon/ac.gif" alt="Air Conditioner" class="facimg">
								</div>
								<div class="facboard">
									<input type="checkbox" id="ch2" value="*IP,*OP,*KP" class="hotel_attribute" name="hotelfacilities[]"><label for="ch2"><img src="<?php echo base_url();?>assets/fac_icon/sp.gif" alt="Swimming Pool" class="facimg">
								</div>
								<div class="facboard">
									<input type="checkbox" id="ch3" value="*IN,*SV,*TV,*FI" class="hotel_attribute" name="hotelfacilities[]"><label for="ch3"><img src="<?php echo base_url();?>assets/fac_icon/tv.gif" alt="Television" class="facimg">
								</div>
								<div class="facboard">
									<input type="checkbox" id="ch4" value="*BS" class="hotel_attribute" name="hotelfacilities[]"><label for="ch4"><img src="<?php echo base_url();?>assets/fac_icon/bs.gif" alt="Baby Sitting" class="facimg">
									</label>
								</div>
								<div class="facboard">
									<input type="checkbox" id="ch5" value="*RS" class="hotel_attribute" name="hotelfacilities[]"><label for="ch5"><img src="<?php echo base_url();?>assets/fac_icon/rs.gif" alt="Room Service" class="facimg">
								</div>
								<div class="facboard">
									<input type="checkbox" id="ch6" value="*MB" class="hotel_attribute" name="hotelfacilities[]"><label for="ch6"><img src="<?php echo base_url();?>assets/fac_icon/rt.gif" alt="Restaurant" class="facimg">
								</div>
								<div class="facboard">
									<input type="checkbox" id="ch7" value="*TE" class="hotel_attribute" name="hotelfacilities[]"><label for="ch7"><img src="<?php echo base_url();?>assets/fac_icon/tc.gif" alt="Tennis Court" class="facimg">
								</div>
								<div class="facboard">
									<input type="checkbox" id="ch8" value="*LT" class="hotel_attribute" name="hotelfacilities[]"><label for="ch8"><img src="<?php echo base_url();?>assets/fac_icon/wf.gif" alt="WiFi" class="facimg">
								</div>
								<div class="facboard">
									<input type="checkbox" id="ch9" value="*DF" class="hotel_attribute" name="hotelfacilities[]"><label for="ch9"><img src="<?php echo base_url();?>assets/fac_icon/df.gif" alt="Disabled Facilities" class="facimg">
								</div>
								<div class="facboard">
									<input type="checkbox" id="ch10" value="*GY" class="hotel_attribute" name="hotelfacilities[]"><label for="ch10"><img src="<?php echo base_url();?>assets/fac_icon/gym.gif" alt="Fitness Center / Gymnasium" class="facimg">
								</div>
								<div class="facboard">
									<input type="checkbox" id="ch11" value="*CP,*HP" class="hotel_attribute" name="hotelfacilities[]"><label for="ch11"><img src="<?php echo base_url();?>assets/fac_icon/pk.gif" alt="Car Parking" class="facimg">
								</div>
								<br style="clear:both"/>
							</dd>
							<input type="hidden" id="data_hotel_form" name="data_hotel_form" value="">
						</form>
					</dl>
				</article>
			</aside>
			<!--END OF SIDEBAR-->
			<!--SEARCH RESULT CONTENT-->
			<section class="three-fourth">
				<div class="sort-by">
					<h3>Details:</h3>
					<ul class="sort">
						<li style="width:100px">
							No. of room: <?php echo $no_of_rooms; ?>
						</li>
						<li style="width:240px">
							Date: <?php echo date("Y M d", strtotime($hotel_checkin)); ?> - <?php echo date("Y M d", strtotime($hotel_checkout)); ?>
						</li>
						<li style="width:140px">
							Duration: <?php echo $durations; ?> Night(s)
						</li>
					</ul>
				</div>
				<!-- <div id="progress-bar" class="progress-bar" style="height: 50px; width: 100%; margin-bottom: 20px; overflow: hidden; background-color: #f5f5f5; border-radius: 4px; display: none; padding: 10px; box-sizing: border-box;">
					<div id="text-loaded" style="text-align: center; width: 100%; float: left; line-height: 30px; height: 30px; font-size: 12px; color: #3FBFB8;">0% Complete</div>
					<div id="load-bar" style="width:0%; height: 100%; background: linear-gradient(#eeffee, #fe9025, #eeffee); text-align: center;">
				    </div>
				</div> -->

				<div class="search_zone">

				</div>
				<div class="loaders" style="margin-left: 40%; margin-top:-42px">
					<div style="position: relative;top: 165px; font-size: 1.4em; text-align: center; font-weight: bold; width: 210px">Searching for hotels<br><span style="font-size:1em !important">Please wait a moment</span></div>
					<div class="lds-css ng-scope">
					  <div style="width:100%;height:100%" class="lds-ellipsis">
					    <div>
					      <div></div>
					    </div>
					    <div>
					      <div></div>
					    </div>
					    <div>
					      <div></div>
					    </div>
					    <div>
					      <div></div>
					    </div>
					    <div>
					      <div></div>
					    </div>
					  </div>
				</div>
			</section>
			<!--END OF SEARCH RESULT CONTENT-->
			</div>
		</div>
	</div>
	<?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
	<form id="serializeForm">
		<?php
		$number_of_room 	= $this->input->post("hotel_noofroom");
		$totalPaxQty = 0;
		for ($i=1; $i<=$number_of_room; $i++) {
			$paxRooms[$i]['hotel_noofadult'] 	= $this->input->post("hotel_noofadult_".$i);
			$paxRooms[$i]['hotel_noofchildren'] = $this->input->post("hotel_noofchildren_".$i);
			$paxRooms[$i]['hotel_noofinfant'] 	= $this->input->post("hotel_noofinfant_".$i);
			$paxRooms[$i]['hotel_childrenAges'] 	= $this->input->post("childAges_".$i);

			$totalPaxQty += ($paxRooms[$i]['hotel_noofadult'] + $paxRooms[$i]['hotel_noofchildren'] + $paxRooms[$i]['hotel_noofinfant']);
		?>
			<input type="hidden" name="hid_hotel_noofadult_<?php echo $i;?>" value="<?php echo $paxRooms[$i]['hotel_noofadult'];?>">
			<input type="hidden" name="hid_hotel_noofchildren_<?php echo $i;?>" value="<?php echo $paxRooms[$i]['hotel_noofchildren'];?>">
			<input type="hidden" name="hid_hotel_noofinfant_<?php echo $i;?>" value="<?php echo $paxRooms[$i]['hotel_noofinfant'];?>">
			<input type="hidden" name="hid_hotel_childrenAges_<?php echo $i;?>" value="<?php echo implode(",", $paxRooms[$i]['hotel_childrenAges']);?>">
		<?php
		}
		?>
		<input type="hidden" name="hid_hotel_noofroom" value="<?php echo $this->input->post('hotel_noofroom');?>">
		<input type="hidden" name="hid_hotel_checkin" value="<?php echo $this->input->post('hotel_checkin');?>">
		<input type="hidden" name="hid_hotel_checkout" value="<?php echo $this->input->post('hotel_checkout');?>">
		<input type="hidden" name="hid_total_pax" value="<?php echo $totalPaxQty;?>">
		<input type="hidden" name="hid_destinationCode" value="<?php echo $destination;?>">
		<input type="hidden" name="hid_countryname" value="<?php echo $country_name;?>">
		<input type="hidden" name="hid_countrycode" value="<?php echo $country_code;?>">
		<input type="hidden" name="hid_hotel_destination" value="<?php echo $hotel_destination;?>">
	</form>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$(document).on("click", ".search-popup2", function (e)
			{
				var countRoom = $("#hotel_noofroom").val();
			    var address = $(".address-hotel.tt-input").val();
			    $('.search_mark').html('hotel');
				//$('#divLoading', ".main-search").show();
				$('#divLoading', ".search_zone").show();
			    $.ajax({
			        url : path_url + '/search/get_search_popup',
			        type : "post",
			        dataType:"html",
			        data : {
			            'countRoom' : countRoom,
			        },
			        success : function (result){
			    		//$('#divLoading', ".main-search").hide();
			    		setTimeout(function(){
			    			$('#divLoading', ".box-content-booking").hide();
			    			$('#divLoading', ".search_zone").hide();
			    		}, 1000);
			    		/* revert back the text */
			    		$('.lightbox-booking').show();
			            $('.box-content-booking').html(result);
			        }
			    });
			});

			$('#btnFPSubmit').click(function()
			{
				if( $("#email_fp").val() == "" ) {
					var msg = "<span style='color:red'>Please enter your email address.</span>";
					$("#forgot_password_ajax_msg").html(msg);
					return false;
				}
				else {
					$.ajax({
						type: "POST",
			            url: '<?php echo base_url(); ?>forgot_password/do_submission',
			            data: {
			                email: $("#email_fp").val()
			            },
			            success: function(data)
			            {
				            if( data == 0 ) {
					            var msg = "<span style='color:red'>This email address has never registered before. Please try another email address.</span>";
					            $("#forgot_password_ajax_msg").html(msg);
					            return false;
				            }
				            else if( data == 1 ) {
					            var msg = "<span style='color:yellow'>An email has been sent to you in order to retrieve your password.</span>";
					            $("#email_form_fp").hide();
					            $("#btn_form_fp").hide();
					            $("#forgot_password_ajax_msg").html(msg);
					            return false;
				            }
			            }
					});
			        return false;
			    }
			});

			$('#btnLogin').click(function()
			{
				$.ajax({
		            type: "POST",
		            url: '<?php echo base_url(); ?>login/do_login_process',
		            data: {
		                email: $("#login_email").val(),
		                password: $("#login_password").val(),
		                remember_me: $('#login_checkbox:checked').val()
		            },
		            success: function(data)
		            {
			            if( data == 0 ) {
				            var msg = "<span style='color:red'>Invalid login account. Please try again.</span>";
				            $("#login_ajax_msg").html(msg);
				            return false;
			            }
			            else if( data == 1 ) {
				            var msg = "<span style='color:yellow'>Login successfully.</span>";
				            $("#login_ajax_msg").html(msg);
				            window.location = '<?php echo current_url(); ?>';
				            return false;
			            }
		            }
		        });
		        return false;
			});
		});
	</script>

	<script>selectnav('nav'); </script>
	<script type="text/javascript">
		var filter = {
			accommodation: [],
			hotelfacilities: [],
			roomfacilities: [],
			meal: []
		};
		var listHotels = [];
		var dataGetHotel = {};
		var loaded = 0;
		var finishLoad = false;
		var intervalBar;
		var page = 0;
		var numberPerPage = 10;
		var currentList = [];

		function loadbarFunc()
		{
			loaded ++;
			$('#load-bar').width(loaded + '%');
			$('#text-loaded').text('Searching for hotels... (' + loaded + '%)');
			/*if (loaded == 90 && !finishLoad) {
				clearInterval(intervalBar);
			}*/
			if (loaded > 99 ) {
				clearInterval(intervalBar);
				$('#progress-bar').hide(500, function() {
					$('#load-bar').width('0%');
				});
			}
		}

		var pageSize = 25;
        var showPage = function (page) {
        	/*  */
        	$('.hotel_content').removeClass('hidePage');
        	$('.hotel_content').removeClass('showPage');

        	$('.hotel_content').each(function() {
        		var element = $(this);
	        	if( element.hasClass('hideRate') ||
	        		element.hasClass('hideHotel') ||
	        		element.hasClass('hidePrice') ||
	        		element.hasClass('hideFacilities')
	        	) {
				  element.addClass('hidePage').removeClass('showPage');

				} else {
					element.addClass('showPage');
					/*element.addClass('showPage');*/
				}
			});

            $(".showPage").each(function(n) {

                if (n >= pageSize * (page - 1) && n < pageSize * page) {
                	//$(this).removeClass('hidePage');
                } else {
                	$(this).addClass('hidePage').removeClass('showPage');
                	//return false;
                	//$(this).hide();
                }
            });

            filterHotelRateOnly();

        }

        $(document).on('click', ".pager span a", function() {
            $(".pager span a").removeClass("current");
            $('[data-val="'+$(this).text()+'"]').addClass('current');
            showPage(parseInt($(this).text()));

        });

		function generatedata(page)
		{
			$('#opener').show();
			$('.loaders').show();
			$('.refine-search-results').css('opacity', 0.25);

			//var intervalBar = setInterval(loadbarFunc2, 500);
			$('.search_zone').html('');

			var datas = $('#serializeForm').serializeArray();
			min = $("#slider-range").slider("values", 0);
		    max = $("#slider-range").slider("values", 1);
			datas.push({name : 'minprice', value : min});
			datas.push({name : 'maxprice', value : max});
			datas.push({name : 'rate', value : $('#star').data('rating')});

			$.ajax({
				type: "POST",
				url: '<?php echo base_url().'search/hotel_api/'.substr(base64_encode(time()),0,10).'/'; ?>'+page,
				data: datas, //$('#serializeForm').serialize(), ///$(this).attr('id'), //--> send id of checked checkbox on other page
				success: function(data) {
					//finishLoad = true;
					//loaded = 99;
					maxPrice = 1000;
					$('.search_zone').html(data);
					$('#opener').hide();

					$('.refine-search-results').css('opacity', 1);

					var i=0;
					var total_dt = $('.hotel_content').length;

					if(total_dt > 0 && $('#nodt').val() != "1") {
						$(".hotel_content").sort(function(a, b) {
							var aprice = $(a).data('price').toString(),
							bprice = $(b).data('price').toString();
						  return parseFloat(aprice.replace(',', '')) - parseFloat(bprice.replace(',', ''));
						}).each(function() {
							i += 1;
							if (i == (total_dt)) {
								var thisprice = $(this).data('price').toString();
								maxPrice = Math.ceil(parseFloat(thisprice.replace(",","")));
								$("#amount").val("$0 - $" + maxPrice);

								$("#slider-range").slider("option", "max", maxPrice); // left handle should be at the left end, but it doesn't move
	    						//$("#slider-range").slider("value", $("#slider-range").val()); //force the view refresh, re-setting the current value
	    						$("#slider-range").slider("values", 0, 0);
	           					$("#slider-range").slider("values", 1, maxPrice);
			            		showProducts(min, maxPrice);
							}
							//console.log(i);
						  	var elem = $(this);
						  	elem.remove();
						  	$(elem).appendTo("#hotel_result");
						});

						showPage(1);
					}
				},
				 error: function() {
					$('.loaders').hide();
					alert('Sorry, some error occuring');
				},
				complete: function() {
					$('.loaders').hide();
					// // // alert('it completed');
				}
			});
		}

		$(document).ready(function() {
			var states_hotel = [<?php echo $this->All->list_typehea_hotel(); ?>];
			$('#hotel_destination .typeahead').typeahead(
				{
					hint: true,
					highlight: true,
					minLength: 3
				},
				{
					name: 'states',
					source: substringMatcher(states_hotel)
				}
			);

			var base_url = window.location.origin + '/fit/';
			$('#star').raty({
				score    : $('#star').data('rating'),
				starOff : base_url+'assets/images/ico/star-rating-off.png',
				starOn  : base_url+'assets/images/ico/star-rating-on.png',
				/*cancel: true,
				cancelOff : base_url+'assets/images/ico/cancel-off.png',
				cancelOn : base_url+'assets/images/ico/cancel-on.png',
				*/
				click: function(score, evt) {
					filter.star = score || 0;
					$('#star').data('rating', filter.star);

		            /*var h1 = document.getElementsByClassName('hotelName');
		            for (i = 0; i < h1.length; i++) {
		                var stars = h1[i].getElementsByClassName("stars")[0];
		                var starscore = stars.getAttribute('data-score')
		                var parentDet = h1[i].parentElement.parentElement;
		                if (starscore == score) {
		                	parentDet.classList.remove("hideRate");
		                	parentDet.classList.remove("showRate");
		                    parentDet.style.display = "";
		                    parentDet.className  += " showRate";
		                } else {
		                	parentDet.classList.remove("hideRate");
		                	parentDet.classList.remove("showRate");
		                    parentDet.style.display = "none";
		                    parentDet.className  += " hideRate";
		                }
		            }*/

		            /*filterHotelRate();*/
		            generatedata(1);
			  	}
			});

			$("#changeSearchAnchor").click(function(){
				$("#changeSearchContent").toggle();
				return false;
    		});

        	/*$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
				disableOn: 700,
				type: 'iframe',
				mainClass: 'mfp-fade',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: false
        	});
			*/

			$("#hotel_noofroom").change(function() {
				var noofadult = this.value*2;
				$("#hotel_noofadult").val(noofadult).change();
    		})

			dataGetHotel.hotel_checkin = '<?php echo $hotel_checkin; ?>';
			dataGetHotel.hotel_checkout = '<?php echo $hotel_checkout; ?>';
			dataGetHotel.hotel_destination = '<?php echo $hotel_destination; ?>';
			dataGetHotel.hotel_noofroom = '<?php echo $no_of_rooms; ?>';
			dataGetHotel.paxRoom = '<?php echo json_encode($paxRoom ); ?>';

			var offetThreeFourth = $('.three-fourth').offset().top;
			var widthWindow = $( window ).width();
			$(window).scroll(function() {
				if (widthWindow < 831) return;
				if (offetThreeFourth < $(window).scrollTop())
			    	$('#progress-bar').css('margin-top', $(window).scrollTop() - offetThreeFourth + 20);
			    else
			    	$('#progress-bar').css('margin-top', 0);
			});

			$('.pager').on('click', 'a', function() {
				var value = $(this).attr('href').substring(1);
				switch (value) {
					case 'next':
						if (page <  Math.ceil(currentList.length / numberPerPage) - 1)
							page ++;
						break;
					case 'prev':
						if (page > 0)
							page--;
						break;
					default:
						if (page == value-1) return;
						page = value - 1;
						break;
				}
				$('.pager .current').removeClass('current');
				$('.pager span:nth-child('+ (page+3) +')').addClass('current');
				if (page ==  Math.ceil(currentList.length / numberPerPage) - 1)
					$('.pager a[href="#next"]').addClass('disablePointerEvent');
				else
					$('.pager a[href="#next"]').removeClass('disablePointerEvent');
				if (page == 0)
					$('.pager a[href="#prev"]').addClass('disablePointerEvent');
				else
					$('.pager a[href="#prev"]').removeClass('disablePointerEvent');
				renderHotels(currentList);
				return false;
			});

			var oldSearchHotelName = '';
			var valueSearchHotelName;
	        $('#search-hotel-name').keyup( $.debounce( 500, function() {
	            valueSearchHotelName = $(this).val().toUpperCase();
	            if ((valueSearchHotelName.length < 3 && valueSearchHotelName.length > 0))
	                return;
	            oldSearchHotelName = valueSearchHotelName;

	            var h1 = document.getElementsByClassName('hotelName');
	            for (i = 0; i < h1.length; i++) {
	                var title = h1[i].getElementsByTagName("span")[0];
	                var parentHotelDet = h1[i].parentElement.parentElement;
	                if (title.innerHTML.toUpperCase().indexOf(valueSearchHotelName) > -1) {
	                	parentHotelDet.classList.remove("hideHotel");
	                	parentHotelDet.classList.remove("hidePage");
	                	parentHotelDet.classList.remove("showHotel");
	                    parentHotelDet.style.display = "";
	                    parentHotelDet.className  += " showHotel";
	                } else {
	                	parentHotelDet.classList.remove("hideHotel");
	                	parentHotelDet.classList.remove("hidePage");
	                	parentHotelDet.classList.remove("showHotel");
	                    parentHotelDet.style.display = "none";
	                    parentHotelDet.className  += " hideHotel hidePage";
	                }
	            }
	            filterHotelRate();
	            showPage(1);
	            //filter.hotelName = valueSearchHotelName;
	            //filterAll();
	        }));

		});

		function filterHotelRate() {
			$('.pager').html('');

			var vis = 0;
        	$('.hotel_content').each(function() {
        		if (
        				(
        					!$(this).hasClass('hideRate') && !$(this).hasClass('hideHotel') && !$(this).hasClass('hidePrice') && !$(this).hasClass('hideFacilities')
        				)
        				&& $(this).hasClass('hidePage')
        			) {
        			vis+=1;
        		} else if ($(this).hasClass('hideRate') || $(this).hasClass('hideHotel') || $(this).hasClass('hidePrice') || $(this).hasClass('hideFacilities') || $(this).hasClass('hidePage')) {
        			$(this).hide();
        		} else  {
        			$(this).show();
        			vis += 1;
        		}
        	});

        	/* make sure the count is right! */
        	var vislen = $('.hotel_content:visible').length;

        	//if(vis == vislen) {
        		var pageSize = Math.ceil(vis / 25) , i = 1;
        		for (i = 1; i <= pageSize; i++) {
		            var cls="";
		            if(i==1) {
		                cls = 'class="current"';
		            }
		            $('.pager').append('<span><a href="#" '+cls+' data-val="'+ i +'"><b>'+i+'</b></a></span>');
		        }
        	//}
		}

		function filterHotelRateOnly() {
        	$('.hotel_content').each(function() {
        		if ($(this).hasClass('hideRate') || $(this).hasClass('hideHotel') || $(this).hasClass('hidePrice') || $(this).hasClass('hideFacilities') || $(this).hasClass('hidePage')) {
        			$(this).hide();
        		} else {
        			$(this).show();
        		}
        	});
		}

		function filterAll() {
			$('.deals').html('');
			$('.pager').html('');
			loaded = 0;
			intervalBar = setInterval(loadbarFunc, 50);
			$('#progress-bar').hide();
			$('#progress-bar').show();

			var filterListHotels = {};

			for (var i = 0; i < listHotels.length; i++) {
				if(listHotels[i].search_item.RESPONSE.RESPONSEDETAILS.SEARCHITEMINFORMATIONRESPONSE.ERRORS)
						continue;
				if (filter.accommodation.length > 0 && filter.accommodation.indexOf('all') < 0) {

					if (filter.accommodation.indexOf(listHotels[i]['search_item']['RESPONSE']['RESPONSEDETAILS']['SEARCHITEMINFORMATIONRESPONSE']['ITEMTYPE'].toLowerCase()) < 0)
						continue;
				}

				if (filter.hotelfacilities.length > 0) {
					var facilites_code = [];
					for (var key in listHotels[i]['search_item']['RESPONSE']['RESPONSEDETAILS']['SEARCHITEMINFORMATIONRESPONSE']['ITEMDETAILS']['ITEMDETAIL']['HOTELINFORMATION']['FACILITIES']['FACILITY']) {
					 	facilites_code.push(listHotels[i]['search_item']['RESPONSE']['RESPONSEDETAILS']['SEARCHITEMINFORMATIONRESPONSE']['ITEMDETAILS']['ITEMDETAIL']['HOTELINFORMATION']['FACILITIES']['FACILITY'][key]['CODE']);
					}
					var j = 0;
					for ( ; j < filter.hotelfacilities.length; j++) {
						if (facilites_code.indexOf(filter.hotelfacilities[j]) < 0) {
							break;
						}
					}
					if (j < filter.hotelfacilities.length)
						continue;
				}

				if (filter.roomfacilities.length > 0) {
					var roomfacilities_code = [];
					for (var key in listHotels[i]['search_item']['RESPONSE']['RESPONSEDETAILS']['SEARCHITEMINFORMATIONRESPONSE']['ITEMDETAILS']['ITEMDETAIL']['HOTELINFORMATION']['ROOMFACILITIES']['FACILITY']) {
					 	roomfacilities_code.push(listHotels[i]['search_item']['RESPONSE']['RESPONSEDETAILS']['SEARCHITEMINFORMATIONRESPONSE']['ITEMDETAILS']['ITEMDETAIL']['HOTELINFORMATION']['ROOMFACILITIES']['FACILITY'][key]['CODE']);
					}
					var j = 0;
					for ( ; j < filter.roomfacilities.length; j++) {
						if (roomfacilities_code.indexOf(filter.roomfacilities[j]) < 0) {
							break;
						}
					}
					if (j < filter.roomfacilities.length)
						continue;
				}

				if (filter.star && filter.star > 0) {
					if (listHotels[i]['STARRATING'] != filter.star)
						continue;
				}

				if (filter.meal.length > 0) {
					if (listHotels[i].meal_board_code != 'B')
						continue;
				}

				if (filter.hotelName) {
					if (listHotels[i]['ITEM']['content'].toLowerCase().indexOf(filter.hotelName.toLowerCase()) == -1)
						continue;
				}

				filterListHotels[i] = listHotels[i];
			}
			currentList = filterListHotels;
			setTimeout(function() {
				finishLoadFunc(currentList);
			}, 500);
		}

		function excerpt_word(str, nwords) {
		  	var words = str.split(' ');
		  	words.splice(nwords, words.length-1);
		  	return words.join(' ') +
		    	(words.length !== str.split(' ').length ? '&hellip;' : '');
		}

		function showProducts(minPrice, maxPrice)
		{
    		//$(".hotel_content").hide();
    		$('.hotel_content')
    		.removeClass('showPrice')
    		.addClass('hidePrice')
    		.filter(function() {

		        var price = parseFloat($(this).data("price").toString().replace(",",""));
		        return price >= minPrice && price <= maxPrice;
		    }).removeClass('hidePrice').removeClass('hidePage').addClass('showPrice');

		    filterHotelRate();
		}

		$(function() {
		    var options = {
		        range: true,
		        min: 0,
		        max: 1000,
		        values: [0, 1000],
		        slide: function(event, ui) {
		            var min = ui.values[0],
		                max = ui.values[1];

		            $("#amount").val("$" + min + " - $" + max);
		            showProducts(min, max);
		        }
		    }, min, max;

		    $("#slider-range").slider(options);

		    min = $("#slider-range").slider("values", 0);
		    max = $("#slider-range").slider("values", 1);

		    $("#amount").val("$" + min + " - $" + max);

		    showProducts(min, max);

			$('#hotel_attribute_form').submit(function(event) {
				///alert('masuk123');
				$('#data_hotel_form').val($('#data_hotel').val());
				$('#divLoading').show();
				var checkedVals = $('.hotel_attribute:checkbox:checked').map(function() {
				    return this.value;
				}).get();

				if (checkedVals != "") {
					$.ajax({
						type: "POST",
						url: '<?php echo base_url().'search/filter_hotel_by/'; ?>',
						data: $(this).serialize(), ///$(this).attr('id'), //--> send id of checked checkbox on other page
						success: function(data) {
							// // // alert('it worked');
							// // // alert(data);
							if(data != 'FALSE') {
								var datas = data.split('###');
								if(datas.length > 0) {
									$(".hotel_content").addClass('hideFacilities').hide();
									for(n=0; n<datas.length; n++) {
										$("#"+datas[n]).removeClass('hideFacilities').show();
									}

									$('#search-hotel-name').trigger('keyup');

									min = $("#slider-range").slider("values", 0);
								    max = $("#slider-range").slider("values", 1);
								    showProducts(min, max);
								    filterHotelRate();
								    showPage(1);

						        	setTimeout(function() {
										$('#divLoading').hide();
									}, 1000);
								}
							} else {
								$(".hotel_content").hide().addClass('hideFacilities');
								filterHotelRate();
								showPage(1);
							}

				        	setTimeout(function() {
								$('#divLoading').hide();
							}, 1000);
							// // // $('#container').html(data);/
						},
						 error: function() {
							$('#divLoading').hide();
							alert('Sorry, please check your internet connection');
						},
						complete: function() {

							// // // alert('it completed');
						}
					});
				} else {
					$('.hotel_content').show().removeClass('hideHotel').removeClass('hideFacilities');
					$('#search-hotel-name').trigger('keyup');

					min = $("#slider-range").slider("values", 0);
				    max = $("#slider-range").slider("values", 1);
				    //alert('c');
				    showProducts(min, max);
				    filterHotelRate();
				    showPage(1);
		        	setTimeout(function() {


						$('#divLoading').hide();
					}, 2000);
				}
				event.preventDefault();
				return false;
			});

			$('.hotel_attribute').click(function() {
				///alert('123');
				$('#hotel_attribute_form').trigger('submit');
				$(this).uniform.update();

			});

			generatedata(1);
		});

		var substringMatcher = function(strs) {
		    return function findMatches(q, cb) {
		    	var matches, substringRegex;
				matches = [];
				substrRegex = new RegExp(q, 'i');
				$.each(strs, function(i, str) {
		        	if (substrRegex.test(str)) {
						matches.push(str);
		        	}
		      	});
			  	cb(matches);
		    };
		};

		$(window).load(function() {
			var maxHeight = 0;
			$(".three-fourth .one-fourth").each(function(){
				if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
			});
			$(".three-fourth .one-fourth").height(maxHeight);


			//$("#star > img").attr("title", "gorgeous").trigger('click');
		});

	</script>
</body>
</html>