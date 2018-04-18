<?php
	//prevent notice + message error
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	//end of prevent notice + message error
	function UR_exists($url){
	   $headers=get_headers($url);
	   return stripos($headers[0],"200 OK")?true:false;
	}

	$currentURL = current_url();
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CTC Travel | Hotel Details</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css" media="screen,projection,print" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/tipr/tipr.css?<?php echo uniqid(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/imageSlider/slider.css" type="text/css" />
	<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/newcruise.css" type="text/css" /> -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fontawesome.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/newtable.css?1" type="text/css" />
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
	<link rel="manifest" href="<?php echo base_url(); ?>assets/favicons/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/favicons/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<style>
		.container-content{
	        margin:0;
	        padding:0;
	        color: #FF0000;
	        font-size: 14px;
	    }
		html{
		    box-sizing:border-box;
		    & * {
		        box-sizing:inherit;
		    }
		}
		.age_type {
		    background: #f4f4f4;
		    border: 1px solid #ddd;
		    border-bottom: none;
		    padding: 5px 10px;
		    font-weight: bold;
		}
		.tab_container {
		    border: 1px solid #ddd;
		    padding: 0 10px 10px 10px;
		    margin-bottom: 20px;
		}
		.form_div { margin: 20px 0 20px 0; }
		.traveller_info_form>div>div>div>div {
		    width: 230px;
		    float: left;
		    font-weight: bold;
		}

		.imgContainer {
			line-height: 9px;
		}
		.image {
		   	display:inline-block;
		    padding: 3px;
		    width: 275;
		    height: 200px;
		    /*@media (#{$tablet}){
		        width: 50%;
		    }
		    @media (#{$mobile}){
		        width: 100%;
		    }*/
		    img {
		        vertical-align:top;
		        width: 275px;
		        height: 200px;
		    }
		}

		.image-small {
			display:inline-block;
		    padding: 2px;
		    width: 73px;
		    height: 50px;
		    /*@media (#{$tablet}){
		        width: 50%;
		    }
		    @media (#{$mobile}){
		        width: 100%;
		    }*/
		    img {
		        vertical-align:top;
		        width: 75px; height: 50px;
		    }
		}
		h5 { color: #F7941D !important; } .fontSizeAdjust { font-size: 15px }

		label.dropdown select {
			padding: 10px 42px 10px 10px;
			background: #f8f8f8;
			color: #444;
			border: 1px solid #aaa;
			border-radius: 0;
			display: inline-block;
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			cursor: pointer;
			outline: none;
			height:40px;
			width:150px
		}
		label.dropdown select:-moz-focusring { color: transparent; text-shadow: 0 0 0 #444; }
		label.dropdown select::-ms-expand { display: none; }
		label.dropdown:before {
			content: '';
			right: 5px;
			top: -7px;
			width: 30px;
			height: 33px;
			position: absolute;
			pointer-events: none;
			display: block;
		}
		label.dropdown { position: relative; }
		label.dropdown:after {
			content: '>';
			font: 16px Consolas, monospace;
			color: #444;
			-webkit-transform: rotate(90deg);
			-moz-transform: rotate(90deg);
			-ms-transform: rotate(90deg);
			transform: rotate(90deg);
			right: 2px;
			top: -15px;
			/*border-bottom: 1px solid #aaa;*/
			position: absolute;
			pointer-events: none;
			width: 35px;
			padding: 0 0 5px 0;
			text-indent: 14px;
		}
		@media screen\0 {
			label.dropdown:after {
				width: 38px;
				text-indent: 15px;
		        right: 0;
			}
		}
		@media screen and (min--moz-device-pixel-ratio:0) {
			label.dropdown select { padding-right: 40px; }
			label.dropdown:before { right: 6px; }
			label.dropdown:after {
				text-indent: 14px;
				right: 6px;
				top: -5px;
				width: 36px;
			}
		}

		a.gallery-small img {
			opacity: 0.3;
		} a.gallery-small:hover img {
			opacity: 1;
		}

		.nav {
		    padding-left: 0;
		    margin-bottom: 10px;
		    list-style: none;
		}
		.nav>li {
		    position: relative;
		    display: block;
		}
		.nav-pills>li {
		    float: left;
		    margin-bottom: 10px;
		    width: 203px;
		}

		.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
		    color: #FFFFFF;
		    cursor: default;
		    background-color:#337ab7;
		    border-bottom-color: transparent;
		    font-weight: bold;
		}

		.nav-pills>li>a {
			text-decoration: none;
		    margin-right: 2px;
		    line-height: 1.42857143;
		    background-color: #fff;
		    border: 1px solid #ddd;
		    border-radius: 4px 4px 0 0;
		}
		.nav>li>a {
		    position: relative;
		    display: block;
		    padding: 10px 15px;
		}
		.tab-contents >.active {
		    display: block !important;
		}
		.tab-contents >.tab-pane {
		    display: none;
		}
		.fade {
		    opacity: 0;
		    -webkit-transition: opacity .15s linear;
		    -o-transition: opacity .15s linear;
		    transition: opacity .15s linear;
		}
		.fade.in {
		    opacity: 1;
		}
		.book_cart {
		    font-size: 12px;
		    padding: 10px;
		    background-color: #F7941D;
		    border:none;
		}
	</style>
	<!-- Magnific Popup core CSS file -->

	<link rel="stylesheet" href="<?php echo base_url();?>assets/magnipop/magnific-popup.css">
</head>
<body>
	<?php require_once(APPPATH."views/master-frontend/header.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>
	<div class="main" role="main">
		<div class="wrap clearfix">
			<div class="content clearfix">
				<?php
				$img = array();
				$details = $this->All->select_template_w_2_conditions(
					"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
					"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
					"hotel_gta_item_information"
				);

				if( $details == TRUE ) {
					foreach( $details AS $detail ) {

						/* do some quick check */

						if ($detail->item_content == "" || $detail->star_rating == "") {
							redirect('search/nodataresult');
							exit();
						}
						//hotel image
						$images = $this->All->select_template_w_3_conditions(
							"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
							"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
							"type", 'image',
							"hotel_gta_item_information_image_link"
							//"hotel_gta_item_information_image_link"
						);
						if( $images == TRUE ) {
							foreach( $images AS $image ) {
								$img[] =
									array (
										'link' => $image->image,
										'width' => $image->width,
										'height' => $image->height
									);
							}
						}
						else {
							$img[] = array('link' => base_url()."assets/default.png", 'width'=>'300', 'height'=>'300');
						}
						//end of hotel image
						$nameHotel 	   = $detail->item_content;
						//$locations 	   = $detail->location_text;
						$city 	   	   = $detail->city_content;
						if( $detail->AddressLine2 != "" ) { $address2 = $detail->AddressLine2; } else { $address2 = ""; }
						if( $detail->AddressLine3 != "" ) { $address3 = $detail->AddressLine3; } else { $address3 = ""; }
						if( $detail->AddressLine4 != "" ) { $address4 = $detail->AddressLine4; } else { $address4 = ""; }
						$address1  	   = $detail->AddressLine1;
						$fullAddress   = $address1.' '.$address2.' '.$address3.' '.$address4;
						$starRating    = $detail->star_rating;
						$telephone     = $detail->telephone;
						$fax  		   = $detail->fax;
						$email_address = $detail->email_address;
						$website  	   = $detail->website;
						$addressLine1  = $detail->AddressLine1;
						$addressLine2  = $detail->AddressLine2;
						$addressLine3  = $detail->AddressLine3;
						$addressLine4  = $detail->AddressLine4;
					}
				} else {
					redirect('search/nodataresult');
					exit();
				}
				$count_img = count($img);

				$destinationCodeGET = base64_decode(base64_decode(base64_decode($this->uri->segment(3))));
				$hotelcheckinGET 	= base64_decode(base64_decode(base64_decode($this->uri->segment(5))));
				$hotelcheckoutGET 	= base64_decode(base64_decode(base64_decode($this->uri->segment(6))));
				$durationGET 		= base64_decode(base64_decode(base64_decode($this->uri->segment(7))));
				$paxroomsGET 		= base64_decode(base64_decode(base64_decode($this->uri->segment(9))));
				$noofroomGET		= base64_decode(base64_decode(base64_decode($this->uri->segment(8))));
				$itemcodeGET		= base64_decode(base64_decode(base64_decode($this->uri->segment(4))));
				$country_nameGET	= base64_decode(base64_decode(base64_decode($this->uri->segment(11))));
				$country_codeGET	= base64_decode(base64_decode(base64_decode($this->uri->segment(12))));
				$childAgesGET = base64_decode(base64_decode(base64_decode($this->uri->segment(13))));

				//echo $country_nameGET;die();
				$arrayA = explode(",", $paxroomsGET);

				$arrayCA = explode(";", $childAgesGET);

				for ($i=0; $i< $noofroomGET ; $i++) {
					$arrayB[$i+1]['hotel_noofadult']    = substr($arrayA[$i], 0, 1);
					$arrayB[$i+1]['hotel_noofchildren'] = substr($arrayA[$i], 1, 1);
					$arrayB[$i+1]['hotel_noofinfant']   = substr($arrayA[$i], 2, 1);
					$arrayB[$i+1]['hotel_childrenAges'] = $arrayCA[$i];
				}

				//XML Request
				$requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
				$requestData .= '<Request>';
				$requestData .= 	'<Source>';
				$requestData .= 		'<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
				$requestData .= 		'<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD" Country="SG">';//$country_codeGET
				$requestData .= 			'<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
				$requestData .= 		'</RequestorPreferences>';
				$requestData .= '	</Source>';
				$requestData .= '	<RequestDetails>';
				$requestData .= '		<SearchHotelPricePaxRequest>';
				$requestData .= 			'<ItemDestination DestinationType="city" DestinationCode="'.$destinationCodeGET.'"/>';
				$requestData .= 			'<ImmediateConfirmationOnly/>';
				$requestData .= 			'<ItemCode>'.$itemcodeGET.'</ItemCode>';
				$requestData .= 			'<PeriodOfStay>';
				$requestData .= 			'	<CheckInDate>'.$hotelcheckinGET.'</CheckInDate>';
				$requestData .= 			'	<Duration><![CDATA['.$durationGET.']]></Duration>';
				$requestData .= 			'</PeriodOfStay>';
				$requestData .= 			'<IncludeRecommended/>';
				$requestData .= 			'<IncludePriceBreakdown/>';
				$requestData .= 			'<IncludeChargeConditions DateFormatResponse = "true"/>';
				$requestData .= 			'<PaxRooms>';
				for( $px=1; $px<=$noofroomGET; $px++ ) {
					if( $arrayB[$px]["hotel_noofchildren"] != 0 ) {
						$requestData .= '<PaxRoom Adults="'.$arrayB[$px]["hotel_noofadult"].'" Cots="'.$arrayB[$px]["hotel_noofinfant"].'" RoomIndex="'.$px.'" >';

							$requestData .= '<ChildAges>';
								for ($i=0; $i<$arrayB[$px]["hotel_noofchildren"]; $i++) {
									$hca = explode(",", $arrayB[$px]['hotel_childrenAges']);
									$requestData .= '<Age>'.$hca[$i].'</Age>';
								}
							$requestData .= '</ChildAges>';
						$requestData .= '</PaxRoom>';
					} else {
						$requestData .= '<PaxRoom Adults="'.$arrayB[$px]["hotel_noofadult"].'" Cots="'.$arrayB[$px]["hotel_noofinfant"].'" RoomIndex="'.$px.'" />';
					}
				}
				$requestData .= 			'</PaxRooms>';
				$requestData .= '		</SearchHotelPricePaxRequest>';
				$requestData .= '	</RequestDetails>';
				$requestData .= '</Request>';
				$url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
				curl_setopt($ch, CURLOPT_ENCODING , "gzip");
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
				curl_close($ch);
				$parseResult 		= simplexml_load_string($output, "SimpleXMLElement", LIBXML_NOCDATA);

				// // // print_r($output);
				// // // echo '$parseResult<br /><br />';
				// // // print_r($parseResult);
				$array_final_result = json_decode(json_encode($parseResult), true);

/*
				$requestData = '<Request>';
				$requestData .= '    <Source>';
				$requestData .= 		'<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
				$requestData .= 		'<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD" Country="'.$country_codeGET.'">';
				$requestData .= 			'<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
				$requestData .= 		'</RequestorPreferences>';
				$requestData .= '</Source>';
				$requestData .= '<RequestDetails>';
				$requestData .= '<SearchChargeConditionsRequest>';
				$requestData .= '<DateFormatResponse/>';
				$requestData .= '<ChargeConditionsHotel>';
				$requestData .= '<City><![CDATA[sin]]></City>';
				$requestData .= 			'<Item>'.$itemcodeGET.'</Item>';
				$requestData .= 			'<PeriodOfStay>';
				$requestData .= 			'	<CheckInDate>'.$hotelcheckinGET.'</CheckInDate>';
				$requestData .= 			'	<Duration><![CDATA['.$durationGET.']]></Duration>';
				$requestData .= '</PeriodOfStay>';
				$requestData .= '<Rooms>';
				$requestData .= '<Room Description="Deluxe Room" Id = "001:ALL1:11141:S10880:12684:104781" NumberOfCots = "0" NumberOfRooms = "1">';
				$requestData .= '<ExtraBeds/>';
				$requestData .= '</Room>';
				$requestData .= '</Rooms>';
				$requestData .= '</ChargeConditionsHotel>';
				$requestData .= '</SearchChargeConditionsRequest>';
				$requestData .= '</RequestDetails>';
				$requestData .= '</Request>';
				$url = "https://interface.demo.gta-travel.com/rbsrsapi/RequestListenerServlet";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
				curl_close($ch);
				$parseResult 		= simplexml_load_string($output, "SimpleXMLElement", LIBXML_NOCDATA);

				// // // print_r($output);
				// // // echo '$parseResult<br /><br />';
				// // // print_r($parseResult);
				$array_final_result = json_decode(json_encode($parseResult), true);*/

				$paxroomCategory    = $array_final_result["ResponseDetails"]["SearchHotelPricePaxResponse"]["HotelDetails"]["Hotel"]["PaxRoomSearchResults"]["PaxRoom"];

				/* location Detail, taken from api instead from database */
				$locationName = "";
				$locationData = $array_final_result["ResponseDetails"]["SearchHotelPricePaxResponse"]["HotelDetails"]["Hotel"]['LocationDetails']['Location'];

				if( isset($locationData[0]) && count($locationData) > 1) {
					foreach($locationData as $locData) {
						$locationName .= $locData ." - ";
					}
				} else {
					$locationName .= $locationData ." - ";
				}

				$locationName = rtrim($locationName, " - ");
				if($locationName == '') {
				?>
				<section class="three-fourth">
					<nav class="inner-nav">
						<ul>
							<li class="availability"><a href="#availability" title="Availability">Notification</a></li>
						</ul>
					</nav>
					<section id="availability" class="tab-content">
						<article>
							<div class="container-content">
						        Sorry, the data that you're looking for is not found at the moment. Please refresh your browser or you can contact our administrator for more further information.
						    </div>
						</article>
					</section>
				</section>
				<aside class="right-sidebar">
					<article class="default clearfix">
						<h2>Need Help Booking?</h2>
						<p>Call our customer services team on the number below to speak to one of our advisors who will help you with all of your holiday needs.</p>
						<p>Please call our sale consultant if your total purchase is above $3000</p>
						<p class="number">+65 6216 3456</p>
					</article>
				</aside>
				<?php
					exit();
				}
				//End of XML Request
				?>
				<nav role="navigation" class="breadcrumbs clearfix">
					<ul class="crumbs">
						<li><a href="#" title="" style="cursor:default">You are here:</a></li>
						<li><a href="#" title="" style="cursor:default">Home</a></li>
						<li><a href="#" title="" style="cursor:default"><?php echo $city; ?></a></li>
						<li><a href="#" title="" style="cursor:default"><?php echo $nameHotel; ?></a></li>
					</ul>
				</nav>
				<!-- HOTEL DETAILS CONTENT -->
				<section class="three-fourth">
					<div class="rslides_container" style="margin-bottom:3px;">
						<!--Copyright image-->
						<div style="text-align:right; font-size:13px; margin-bottom:5px">
							<b><i>Image from VFM Leonardo, Inc.</i></b>
						</div>
						 <div class="imgContainer">
						<!-- End of Copyright image -->
							<?php
							for( $a=0; $a<$count_img; $a++ ) {
								if($count_img < 6) {
									if ($a > 2) {
										echo '<div class="image-small">
												<a class="gallery-small magnific" data-width="'.$img[$a]['width'].'" data-height="'.$img[$a]['height'].'" href="'.str_replace('http://', 'https://', $img[$a]['link']).'" ><img src="'.str_replace('http://', 'https://', $img[$a]['link']).'" width="73" height="50" alt=""></a>
											</div>';
									} else {
							?>
							<div class="image">
								<a class="magnific" data-fancybox="gallery" href="<?php echo str_replace('http://', 'https://', $img[$a]['link']);?>" data-width="<?php echo $img[$a]['width'];?>" data-height="<?php echo $img[$a]['height'];?>" >
									<img src="<?php echo str_replace('http://', 'https://', $img[$a]['link']);?>" width="275" height="200" alt="">
								</a>
							</div>
							<?php
									}
								} else {
									if($a > 5) {
										echo '<div class="image-small">
												<a class="gallery-small magnific" data-fancybox="gallery" href="'.str_replace('http://', 'https://', $img[$a]['link']).'"  data-width="'.$img[$a]['width'].'" data-height="'.$img[$a]['height'].'" ><img src="'.str_replace('http://', 'https://', $img[$a]['link']).'" width="73" height="50" alt=""></a>
											</div>';
									} else {
							?>
										<div class="image">
											<a class="magnific" data-fancybox="gallery" href="<?php echo str_replace('http://', 'https://', $img[$a]['link']);?>" data-width="<?php echo $img[$a]['width'];?>" data-height="<?php echo $img[$a]['height'];?>" >
												<img src="<?php echo str_replace('http://', 'https://', $img[$a]['link']);?>" width="275" height="200" alt="">
											</a>
										</div>
							<?php
									}
								}
							} ?>
						</div>
						<!-- <ul class="rslides" id="slides1" style="height:425px">
							<?php
							for( $a=0; $a<$count_img; $a++ ) {
							?>
						  		<li><img src="<?php echo $img[$a]; ?>" /></li>
						  	<?php
							}
							?>
						</ul> -->
					</div>
					<nav class="inner-nav">
						<ul>
							<li class="availability"><a href="#availability" title="Availability">Details</a></li>
							<li class="description"><a href="#description" title="Description">Description</a></li>
							<li class="facilities"><a href="#facilities" title="Facilities">Facilities</a></li>
							<li class="location"><a href="#location" title="Location">Location</a></li>
							<li class="things-to-do"><a href="#things-to-do" title="Things to do">Extra info</a></li>
						</ul>
					</nav>
					<section id="availability" class="tab-content">
						<article>
							<h1>Hotel Information Details</h1>
							<table style="width:100%">
								<tr>
									<td width="50%" style="border:none; font-size:10px; padding:5px 10px" valign="top">
										<div class="package-summary-body">
											<h5><i class="fa fa-heart"></i> &nbsp;Name</h5>
											<p class="fontSizeAdjust"><?php echo $nameHotel; ?></p>
											<h5><i class="fa fa-sort-amount-desc"></i> &nbsp;Star Rating</h5>
											<p class="fontSizeAdjust">
												<?php
												for($s=1; $s<=$starRating; $s++) {
												?>
												<span class="stars" style="float:left">
													<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
												</span>
												<?php
												}
												?>
												<span style="clear:both"></span>
											</p>
											<br />
											<h5><i class="fa fa-calendar"></i> &nbsp;Booking date</h5>
											<p class="fontSizeAdjust">
												<?php echo date("M d, Y", strtotime($hotelcheckinGET)); ?>
												-
												<?php echo date("M d, Y", strtotime($hotelcheckoutGET)); ?>
											</p>
											<h5><i class="fa fa-calendar"></i> &nbsp;Stay</h5>
											<p class="fontSizeAdjust"><?php echo $durationGET; ?> Night(s)</p>
										</div>
									</td>
									<td width="50%" style="border:none; font-size:10px; padding:5px 10px" valign="top">
										<div class="package-summary-body">
											<h5><i class="fa fa-globe"></i> &nbsp;Location</h5>
											<p class="fontSizeAdjust"><?php echo $locationName; ?> - <?php echo $city; ?></p>
											<h5><i class="fa fa-globe"></i> &nbsp;Address</h5>
											<p class="fontSizeAdjust"><?php echo $fullAddress; ?></p>
											<h5><i class="fa fa-info-circle"></i> &nbsp;Info</h5>
											<p class="fontSizeAdjust">
												Domestic rates provided to local citizens and holders of local ID only. Failure to present local identification may result in additional charges at the hotel.
											</p>
										</div>
									</td>
								</tr>
							</table>
					<!--ROOM TYPES-->
					<div style="float:left"><h1>Room types</h1></div>
					<div style="float:right">
						<?php
						$imageLink = $this->All->getHotelImagePicture(
							base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
							base64_decode(base64_decode(base64_decode($this->uri->segment(3))))
						);
	                    if(UR_exists($imageLink) === false) {
	                        $imageLink = base_url()."assets/default.png";
	                    }
	                    ?>
						<?php echo form_open(base_url('cart/do_add_cartHotel'), array('method'=>'POST', 'class'=>'form', 'id'=>'form-check-cart'));?>
						<input type="hidden" name="itemcode" value="<?php echo $this->uri->segment(4);?>">
						<input type="hidden" name="noofRoom" value="<?php echo $this->uri->segment(8);?>">
						<input type="hidden" name="checkinDate" value="<?php echo $this->uri->segment(5);?>">
						<input type="hidden" name="nameHotel" value="<?php echo base64_encode(base64_encode(base64_encode($nameHotel)));?>">
						<input type="hidden" name="hotelImage" id="hotelImage" value="<?php echo base64_encode(base64_encode(base64_encode($imageLink)));?>">
						<input type="hidden" name="checkoutDate" value="<?php echo $this->uri->segment(6);?>">
						<input type="hidden" name="duration_day" value="<?php echo $this->uri->segment(7);?>">
						<input type="hidden" name="destinationCode" value="<?php echo $this->uri->segment(10);?>">
						<input type="hidden" name="citycode" value="<?php echo $this->uri->segment(3);?>">
						<input type="hidden" name="countrycode" value="<?php echo $this->uri->segment(12);?>">
						<input type="hidden" name="countryname" value="<?php echo $this->uri->segment(11);?>">
						<input type="hidden" id="json_data" name="json_data" value="">
						<input type="hidden" name="curr_url" value="<?php echo $currentURL;?>">
						<button class="btn gradient-button" style="float:right; border:none" id="check_cart" type="button">
							Check My Cart
						</button>
						<div class="addmsg" style="margin-right:30px; margin-top:10px; display: none; float:right; font-size:14px; color: GREEN">You have selected an item</div>

						<?php echo form_close();?>
					</div>
					<div style="clear:both"></div>
					<h6>Instruction : Please select room type for all room tabs and click "Check My Cart" to finalize your order</h6>
					<?php
						$totalRoom = 0;
						if( isset($paxroomCategory[0]) ) {
							$totalRoom = count($paxroomCategory);
						} else {
							$totalRoom = 1;
						}
						echo '<ul class="nav nav-pills">';
							for( $type_x=1; $type_x<=$totalRoom; $type_x++ ) {
								$activeClass = "";
								if($type_x == 1)
									$activeClass = 'class="active"';
								echo '<li '.$activeClass.'>
										<a data-toggle="pill" class="pills" href="#rooms'.$type_x.'" data-checked="0">Room #'.$type_x.'
											<br>
											<div style="float:left">
											<span class="selectedRoom'.$type_x.'">Select Room
											</span><input type="hidden" id="selectedRoom'.$type_x.'" value="">
											</div>
											<div style="float:right" class="status'.$type_x.'">
											<img src="'.base_url().'assets/close.png" width="15px"></div>
											<div style="clear:both"></div>
										</a>
								</li>';
							}
						echo '</ul>';
						echo '<div class="tab-contents">';
						for( $type_x=0; $type_x<$totalRoom; $type_x++ )
						{
						?>
							<div id="rooms<?php echo ($type_x + 1);?>" class="tab-pane fade <?php echo $type_x == 0 ? 'in active':'';?>">
								<table border="0" cellpadding="0" cellspacing="0" id="priceChartTable" style="width:100%">
									<tbody>
									<?php
									if ( isset($paxroomCategory[0]) )
									{
									?>
										<!--MULTIPLE ROOM INDEX-->
										<tr class="available_price header_price<?php echo ($type_x + 1);?>">
										    <td colspan="4" style="background:#eff0f1; vertical-align:top;">
											    <div>
												    Room Pax :
												    <?php echo $arrayB[$type_x+1]["hotel_noofadult"]; ?> Adult(s)
												    <?php echo $arrayB[$type_x+1]["hotel_noofchildren"]; ?> Child(s)
												    <?php echo $arrayB[$type_x+1]["hotel_noofinfant"]; ?> Infant(s)
												</div>
										    </td>
									    </tr>
										<?php
										$roomCategory = $paxroomCategory[$type_x]["RoomCategories"]["RoomCategory"];

										if( isset($roomCategory[0]) ) {
											$countRoomCategory = count($roomCategory);
											for($type_xx=0; $type_xx<$countRoomCategory; $type_xx++) {
												$meals = "none";
												if (isset($roomCategory[$type_xx]["Description"]['@attributes']) && isset($roomCategory[$type_xx]["Description"]["@attributes"]["Id"])) {
													$roomID = $roomCategory[$type_xx]["Description"]["@attributes"]["Id"];
												} else {
													$roomID = $roomCategory[$type_xx]["@attributes"]["Id"];
												}

												$roomPrice = $roomCategory[$type_xx]["ItemPrice"] + round((GTA_PRICE_MARKUP/100) * $roomCategory[$type_xx]["ItemPrice"], 2);
												$roomPrice = ceil($roomPrice);
										?>
											<!--NEW DESIGN-->
											<tr class="available_price sort_price" data-price="<?php echo $roomPrice;?>" data-roomidx="<?php echo ($type_x + 1);?>">
										    	<td style="background:#eff0f1; text-align:center">
											    	<?php
													$imagecats = $this->All->select_template_with_where_quadruple_limit(
														"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
														"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
														"text", 	 $checkCat,
														"type", "image",
														1, "hotel_gta_item_information_image_link"//"hotel_gta_item_information_image_link"
													);
													if( $imagecats == TRUE ) {
														foreach( $imagecats AS $imagecat ) { $imgValid = $imagecat->image; }
													}

													$imagecats = $this->All->select_template_with_where_quadruple_limit(
														"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
														"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
														"text", 	'Guest Room',
														"type", "image",
														1, "hotel_gta_item_information_image_link"//"hotel_gta_item_information_image_link"
													);

													$imgValid2 = "";
													if( $imagecats == TRUE ) {
														foreach( $imagecats AS $imagecat ) { $imgValid2 = $imagecat->image; }
													}

													if (UR_exists($imgValid) === false && UR_exists($imgValid2) === false) {
														$imgValid = base_url()."assets/default.png";
													} else if (UR_exists($imgValid) === false && UR_exists($imgValid2) && strpos(strtoupper($roomCategory["Description"]), 'SUITE') === false) {
														$imgValid = $imgValid2;
													}

													/*$linkurl = base_url()."cart/do_add_cartHotel";
													$linkurl .= "/". $this->uri->segment(4); // itemCode v
													$linkurl .= "/". base64_encode(base64_encode(base64_encode($roomCategory[$type_xx]["ItemPrice"]))); // pricePerRoom
													$linkurl .= "/". base64_encode(base64_encode(base64_encode(strtoupper($roomCategory[$type_xx]["Description"])))); //roomtype
													$linkurl .= "/". $this->uri->segment(8); // noofRoom
													$linkurl .= "/". $this->uri->segment(5); // checkinDate
													$linkurl .= "/". base64_encode(base64_encode(base64_encode($nameHotel))); // hotelName v
													$linkurl .= "/". base64_encode(base64_encode(base64_encode($imgValid))); // hotelImage v
													$linkurl .= "/". $this->uri->segment(6); // checkoutDate
													$linkurl .= "/". $this->uri->segment(7); // duration_day
													$linkurl .= "/". base64_encode(base64_encode(base64_encode($roomID)));
													$linkurl .= "/". $this->uri->segment(10); // destinationCode
													$linkurl .= "/". $this->uri->segment(3); //citycode // 14
													$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofadult"]))); // adult
													$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofchildren"]))); // child
													$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofinfant"]))); // noofinfant
													$linkurl .= "/". $this->uri->segment(12); // country code
													$linkurl .= "/". $this->uri->segment(11); // country name*/

													if(UR_exists($imgValid) === false || $imgValid == "") {
														$imgValid = base_url()."assets/default.png";
													}
													?>
											    	<img src="<?php echo str_replace('http://', 'https://', $imgValid); ?>" width="140px" height="100px" />
											    	<div style="font-size:12px; margin-top:5px">Capacity</div>
											    	<div style="font-size:12px; margin-top:5px">
											    		<?php
											    		$totalPx = $arrayB[$type_x+1]["hotel_noofadult"] + $arrayB[$type_x+1]["hotel_noofchildren"] + $arrayB[$type_x+1]["hotel_noofinfant"];
											    		for($i = 0; $i < $totalPx; $i++) {
											    			echo '<img src="'.base_url().'assets/adult.png" width="24px" height="24px" style="display:initial; margin-left:-10px" />';
											    		}
											    		?>
											    	</div>
										    	</td>
										    	<td style="background:#eff0f1; vertical-align:top; padding: 15px 7px !important">
											    	<div style="font-size:12px"><?php echo strtoupper($roomCategory[$type_xx]["Description"]); ?></div>
											    	<?php
												    if( $roomCategory[$type_xx]["Meals"]["Basis"] != "None" ) {
												    	$meal = $roomCategory[$type_xx]["Meals"]["Breakfast"];
												    ?>
												    	<div style="font-size:12px; margin-top:5px; width:160px">
													    	<div>
														    	<div style="float:left">
															    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
														    	</div>
														    	<div style="float:left; font-size:12px; margin-top:1px">
															    	&nbsp;<?php echo $roomCategory[$type_xx]["Meals"]["Breakfast"]; ?> Breakfast
															    </div>
														    	<div style="clear:both"></div>
													    	</div>
													    </div>
												    <?php
													} else {
														$meal = "none";
													?>
														<div style="font-size:12px; margin-top:5px">
													    	<div>
														    	<div style="float:left">
															    	<img src="<?php echo base_url(); ?>assets/close.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
														    	</div>
														    	<div style="float:left; font-size:12px; margin-top:1px">
															    	&nbsp;No Breakfast
															    </div>
														    	<div style="clear:both"></div>
													    	</div>
													    </div>
													<?php
													}
													?>
													<?php
												    if( isset($roomCategory[$type_xx]['SharingBedding']) && $roomCategory[$type_xx]["SharingBedding"] != "false") {
												    ?>
												    <div style="font-size:12px; margin-top:5px">
												    	<div>
													    	<div style="float:left">
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px">
													    	<span class="tip" style="text-decoration:underline" data-tip="At this hotel an additional bed is not provided in the room, child will need to share the existing bedding. If you want to guarantee a separate bed, please adjust your search to include an additional adult instead of a child, or you may click book now to continue.">&nbsp;Sharing Bedding</span>
													    	</div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
												    <?php
													} else if( isset($roomCategory[$type_xx]['SharingBedding']) && $roomCategory[$type_xx]["SharingBedding"] == "false") {
													?>
													 <div style="font-size:12px; margin-top:5px">
												    	<div>
													    	<div style="float:left">
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px">&nbsp;<span class="tip" style="text-decoration:underline" data-tip="Extra bed(s) must be requested for children">Use Extra Bed</span>
													    	</div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
													<?php
													}
													?>
													<?php
												    if( isset($roomCategory[$type_xx]["EssentialInformation"]) ) {
												    ?>
												    <div style="font-size:12px; margin-top:5px">
												    	<div>
													    	<div style="float:left">
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px">
														    	<?php
															    $info_div{"essential_info_one".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																	<div>
																		<ul style='margin-left:10px'>
																";
																if( isset($roomCategory[$type_xx]["EssentialInformation"][0]) ) {
																	$countEssentialInfo = count($roomCategory[$type_xx]["EssentialInformation"]);
																	for($ei=0; $ei<$countEssentialInfo; $ei++) {
																		$info_div{"essential_info".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																			<li style='list-style-type:square; font-size:14px'>
																				".$roomCategory[$type_xx]["EssentialInformation"][$ei]["Information"]["Text"]."
																			</li>
																			<li style='list-style-type:square; font-size:14px'>
																				Valid from ".date("d M Y", strtotime($roomCategory[$type_xx]["EssentialInformation"][$ei]["Information"]["DateRange"]["FromDate"]))." to ".date("d M Y", strtotime($roomCategory[$type_xx]["EssentialInformation"][$ei]["Information"]["DateRange"]["ToDate"]))."
																			</li>
																		";
																	}
																}
																else {
																	$info_div{"essential_info_one".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																		<li style='list-style-type:square; font-size:14px'>
																			".$roomCategory[$type_xx]["EssentialInformation"]["Information"]["Text"]."
																		</li>
																		<li style='list-style-type:square; font-size:14px'>
																			Valid from ".date("d M Y", strtotime($roomCategory[$type_xx]["EssentialInformation"]["Information"]["DateRange"]["FromDate"]))." to ".date("d M Y", strtotime($roomCategory[$type_xx]["EssentialInformation"]["Information"]["DateRange"]["ToDate"]))."
																		</li>

																	";
																}
																$info_div{"essential_info_one".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																			<li style='list-style-type:square; font-size:14px'>
																				To take advantages of this offer, please Call our customer services team on +65 6216 3456
																			</li>
																		</ul>
																	</div>
																";
															    ?>
														    	&nbsp;<span class="tip" style="text-decoration:underline" data-tip="<?php echo $info_div{"essential_info_one".$roomCategory[$type_xx]["@attributes"]["Id"]}; ?>">Essential Info</span>
														    </div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
												    <?php
													}
													?>
													<?php
												    if( isset($roomCategory[$type_xx]["ChargeConditions"]) ) {
												    ?>
												    <div style="font-size:12px; margin-top:5px">
												    	<div style="width:160px">
													    	<div style="float:left">
														    	<!--
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
														    	-->
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px; st">
														    	<?php
															    $chargeConditions = $roomCategory[$type_xx]["ChargeConditions"]["ChargeCondition"];
															    $cancellation_status = "";
							 									$cancelCondition = "";

															    if(isset($chargeConditions[0]['Condition'][1]) && $chargeConditions[0]["Condition"][1]["@attributes"]["Charge"] == "false" ) {
															    	$free_cancellation_date = date("d M Y", strtotime($chargeConditions[0]["Condition"][1]["@attributes"]["FromDate"]));
															    	$cancelCondition .= "Cancellation are free until ". $free_cancellation_date .", ";
															    } else if(isset($chargeConditions[1]) && $chargeConditions[0]["Condition"][1]["@attributes"]["Charge"] == "true" ) {
															    	$half_cancellation_date_start = date("d M Y", strtotime($chargeConditions[0]["Condition"][1]["@attributes"]['ToDate']));
															    	$half_cancellation_date_end = date("d M Y",strtotime($chargeConditions[0]["Condition"][1]["@attributes"]['FromDate']));
														    		$cancelCondition .= "From ".$half_cancellation_date_start." to ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][1]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][1]["@attributes"]['ChargeAmount']." applies<br>";
															    }

															    if( $chargeConditions[0]["Condition"][0]["@attributes"]["Charge"] == "true" ) {
															    	if (!isset($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate'])) {
															    		$cancelCondition .= "Full charges will apply if cancelled";
															    	} else {

															    		if($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate'] == $chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']) {
															    			$half_cancellation_date_end = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']));
																    		$cancelCondition .= "From ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][0]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][0]["@attributes"]['ChargeAmount']." applies";
															    		}
														    			else {
														    				$half_cancellation_date_start = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate']));
																	    	$half_cancellation_date_end = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']));
																    		$cancelCondition .= "From ".$half_cancellation_date_start." to ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][0]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][0]["@attributes"]['ChargeAmount']." applies";
														    			}
															    	}

															    	$cancellation_status .= "<span style='color:green'><b>Allowed<br>(<i>*".$cancelCondition."</i>)</b></span>";

															    } else {
															    	$cancelCondition .= "<br>Full charges will apply if cancelled";
															    	$cancellation_status = "<span style='color:green'><b>Not allowed".$cancelCondition."</b></span>";
															    }

															    $amendmentCondition = "";
															    $amendment_status = "";

															    if (!isset($chargeConditions[1]["Condition"][0]["@attributes"]['ToDate'])) {
														    		if (isset($chargeConditions[1]["Condition"][0]["@attributes"]['FromDate'])) {
														    			$amendmentCondition .= "<br>Amendment not allowed on ". $chargeConditions[1]["Condition"][0]["@attributes"]['FromDate'];
														    		}
														    	} else if (isset($chargeConditions[1]['@attributes'])) {
																	if($chargeConditions[1]["Condition"][0]["@attributes"]['ToDate'] == $chargeConditions[1]["Condition"][0]["@attributes"]['FromDate']) {
														    			$amendmentCondition .= "<br>Amendment not allowed on ". $chargeConditions[1]["Condition"][0]["@attributes"]['FromDate'];
														    		}
													    			else {
													    				$amendmentCondition .= "<br>Amendment not allowed on ". $chargeConditions[1]["Condition"][0]["@attributes"]['ToDate']. " until ". $chargeConditions[1]["Condition"][0]["@attributes"]['FromDate'];
													    			}
														    	}

														    	/* any charge of amendment? */
														    	if( $chargeConditions[1]["Condition"][0]["@attributes"]["Charge"] == "true" ) {
															    	if (!isset($chargeConditions[1]["Condition"][0]["@attributes"]['ToDate'])) {
															    		$amendmentCondition .= "Full charges will apply if any amendment";
															    	} else {

															    		if($chargeConditions[1]["Condition"][0]["@attributes"]['ToDate'] == $chargeConditions[1]["Condition"][0]["@attributes"]['FromDate']) {
															    			$half_amendment_date_end = date("d M Y", strtotime($chargeConditions[1]["Condition"][0]["@attributes"]['FromDate']));
																    		$amendmentCondition .= "From ". $half_amendment_date_end.", for any amendment, Charge of ".$chargeConditions[1]["Condition"][0]["@attributes"]["Currency"] . $chargeConditions[1]["Condition"][0]["@attributes"]['ChargeAmount']." applies";
															    		}
														    			else {
														    				$half_amendment_date_start = date("d M Y", strtotime($chargeConditions[1]["Condition"][0]["@attributes"]['ToDate']));
																	    	$half_amendment_date_end = date("d M Y", strtotime($chargeConditions[1]["Condition"][0]["@attributes"]['FromDate']));
																    		$amendmentCondition .= "From ".$half_amendment_date_start." to ". $half_amendment_date_end.", for any amandment, Charge of ".$chargeConditions[1]["Condition"][0]["@attributes"]["Currency"] . $chargeConditions[1]["Condition"][0]["@attributes"]['ChargeAmount']." applies";
														    			}
															    	}


															    } else {
															    	$amendmentCondition .= "<br>Full charges will apply if any amendment";
															    }

															    if( $chargeConditions[1]["@attributes"]["Allowable"] == "true" ) {


																    $amendment_status = "<span style='color:green'><b>Allowed</b>".$amendmentCondition."</span>";
															    }
															    else {
																    $amendment_status = "<span style='color:green'><b>Not allowed</b>".$amendmentCondition."</span>";
															    }

															    if( $roomCategory[$type_xx]["ChargeConditions"]["PassengerNameChange"]["@attributes"]["Allowable"] == "true" ) {
																    $passenger_name_change_status = "<span style='color:green'><b>Allowed</b></span>";
															    }
															    else {
																    $passenger_name_change_status = "<span style='color:green'><b>Not allowed</b></span>";
															    }
															    $charge_div{"charge_conditions_one".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																	<div>
																		<ul style='margin-left:10px'>
																";
																$charge_div{"charge_conditions_one".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																	<li style='list-style-type:square; font-size:14px'>
																		Cancellation condition: ".$cancellation_status."
																	</li>
																";
																$charge_div{"charge_conditions_one".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																	<li style='list-style-type:square; font-size:14px'>
																		Change amendment details: ".$amendment_status."
																	</li>
																";
																$charge_div{"charge_conditions_one".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																	<li style='list-style-type:square; font-size:14px'>
																		Change passenger name: ".$passenger_name_change_status."
																	</li>
																";
																$charge_div{"charge_conditions_one".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																		</ul>
																	</div>
																";
															    ?>

															    <!-- &nbsp;<span class="tip" style="text-decoration:underline" data-tip="<?php echo $charge_div{"charge_conditions_one".$roomCategory[$type_xx]["@attributes"]["Id"]}; ?>">Charge Conditions</span> -->

														    </div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
												    <?php
													}
													?>
											    </td>
											    <td style="background:#eff0f1; text-align:center; vertical-align:top; width:">
											    	<div style="font-size:12px">Price for <?php echo $durationGET;?> night(s)</div>
											    	<!--FOR DISCOUNT RATE-->
											    	<!--<div style="font-size:14px; margin-top:5px; text-decoration:line-through;">$1,234</div>-->
											    	<!--END OF FOR DISCOUNT RATE-->
											    	<div style="font-size:18px; margin-top:5px; color:#F7941D">
												    	<b>$<?php
												    		echo number_format($roomPrice, 2);
												    		?></b>
												    </div>
											    	<!-- <div style="font-size:12px; margin-top:5px">
												    	<div>
													    	No. of Rooms: <?php echo $noofroomGET;?>
													    	<input type="hidden" name="roomQtySelect" value="<?php echo $noofroomGET;?>">
													    	<select name="roomQtySelect">
														    	<option value="1" <?php echo ($noofroomGET == 1) ? "SELECTED" : ""; ?>>1</option>
														    	<option value="2" <?php echo ($noofroomGET == 2) ? "SELECTED" : ""; ?>>2</option>
														    	<option value="3" <?php echo ($noofroomGET == 3) ? "SELECTED" : ""; ?>>3</option>
														    	<option value="4" <?php echo ($noofroomGET == 4) ? "SELECTED" : ""; ?>>4</option>
														    </select>
													    </div>
											    	</div> -->
											    </td>
											    <td style="background: #eff0f1; text-align:center; vertical-align:top">
											    	<input type="hidden" id="meal_basis_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode(strtoupper($meal))));?>"/>
											    	<input type="hidden" id="roomtype_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
														base64_encode(base64_encode(base64_encode(strtoupper($roomCategory[$type_xx]["Description"]))));?>"/>
													<input type="hidden" id="roomtypeid_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
													base64_encode(base64_encode(base64_encode($roomCategory[$type_xx]["@attributes"]["Id"])));?>"/>
													<input type="hidden" id="roomprice_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
													base64_encode(base64_encode(base64_encode($roomPrice)));?>">
													<input type="hidden" id="noofadult_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofadult"])));?>">
													<input type="hidden" id="noofchildren_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofchildren"])));?>">
													<input type="hidden" id="childages_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]['hotel_childrenAges'])));?>">
													<input type="hidden" id="noofinfant_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofinfant"])));?>">
													<input type="hidden" id="roomimage_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($imgValid)));?>">

												    <button type="button" class="book_cart" data-idx=<?php echo $type_xx;?> data-roomidx="<?php echo $type_x + 1;?>" data-roomname="<?php echo strtoupper($roomCategory[$type_xx]["Description"]);?>" data-roomprice="<?php echo number_format($roomPrice, 2);?>" data-roomidx="<?php echo $type_x + 1;?>" style="color:white; padding:13px; font-size:14px; font-weight:bold; text-decoration:none; cursor:pointer;background-color:#F7941D;">Book Now
												    	</button>
													    <!-- <a style="color:white; padding:13px; font-size:14px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo str_replace('http://', 'https://', $linkurl);?>">
														    Book now
														</a> -->
														<!-- <button onclick="alert('not available in production testing yet')">
													    Book now
														</button> -->
													<div style="font-size:12px; margin-top:3px">Limited rooms available!</div>
												</td>
											</tr>
											<!--END OF NEW DESIGN-->
										<?php
											}
										}
										else {
											$roomPrice = $roomCategory["ItemPrice"] + round((GTA_PRICE_MARKUP/100) * $roomCategory["ItemPrice"], 2);
											$roomPrice = ceil($roomPrice);
										?>
											<!--NEW DESIGN-->
											<tr class="available_price sort_price" data-price="<?php echo $roomPrice;?>" data-roomidx="<?php echo ($type_x + 1);?>">
										    	<td style="background:#eff0f1; text-align:center">
											    	<?php
													$imagecats = $this->All->select_template_with_where_quadruple_limit(
														"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
														"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
														"text", 	$checkCat,
														"type", "image",
														1, "hotel_gta_item_information_image_link"//"hotel_gta_item_information_image_link"
													);

													if( $imagecats == TRUE ) {
														foreach( $imagecats AS $imagecat ) { $imgValid = $imagecat->image; }
													}

													$imagecats = $this->All->select_template_with_where_quadruple_limit(
														"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
														"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
														"text", 	'Guest Room',
														"type", "image",
														1, "hotel_gta_item_information_image_link"//"hotel_gta_item_information_image_link"
													);

													$imgValid2 = "";
													if( $imagecats == TRUE ) {
														foreach( $imagecats AS $imagecat ) { $imgValid2 = $imagecat->image; }
													}

													if ((UR_exists($imgValid) === false && UR_exists($imgValid2) === false) || $imgValid == "") {
														$imgValid = base_url()."assets/default.png";
													} else if (UR_exists($imgValid) === false && UR_exists($imgValid2) && strpos(strtoupper($roomCategory["Description"]), 'SUITE') === false) {
														$imgValid = $imgValid2;
													}
													?>

											    	<img src="<?php echo str_replace('http://', 'https://', $imgValid); ?>" width="140px" height="100px" />
											    	<div style="font-size:12px; margin-top:5px">Capacity</div>
											    	<div style="font-size:12px; margin-top:5px">
												    	<img src="<?php echo base_url(); ?>assets/adult.png?<?php echo uniqid(); ?>" width="24px" height="24px" style="display:initial" />
												    	<img src="<?php echo base_url(); ?>assets/adult.png?<?php echo uniqid(); ?>" width="24px" height="24px" style="display:initial; margin-left:-10px" />
											    	</div>
										    	</td>
										    	<td style="background:#eff0f1; vertical-align:top; padding: 15px 7px !important">
											    	<div style="font-size:12px"><?php echo strtoupper($roomCategory["Description"]); ?></div>
											    	<?php
												    if( $roomCategory["Meals"]["Basis"] != "None" ) {
												    	$meal = $roomCategory["Meals"]["Breakfast"];
												    ?>
												    	<div style="font-size:12px; margin-top:5px; width: 160px">
													    	<div>
														    	<div style="float:left">
															    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
														    	</div>
														    	<div style="float:left; font-size:12px; margin-top:1px">
															    	&nbsp;<?php echo $roomCategory["Meals"]["Breakfast"]; ?> Breakfast
															    </div>
														    	<div style="clear:both"></div>
													    	</div>
													    </div>
												    <?php
													} else {
														$meal = "none";
														?>
															<div style="font-size:12px; margin-top:5px">
														    	<div>
															    	<div style="float:left">
																    	<img src="<?php echo base_url(); ?>assets/close.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
															    	</div>
															    	<div style="float:left; font-size:12px; margin-top:1px">
																    	&nbsp;No Breakfast
																    </div>
															    	<div style="clear:both"></div>
														    	</div>
														    </div>
														<?php
														}
														?>
													<?php
												    if( isset($roomCategory['SharingBedding']) && $roomCategory["SharingBedding"] != "false") {
												    ?>
												    <div style="font-size:12px; margin-top:5px">
												    	<div>
													    	<div style="float:left">
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px"><span class="tip" style="text-decoration:underline" data-tip="At this hotel an additional bed is not provided in the room, child will need to share the existing bedding. If you want to guarantee a separate bed, please adjust your search to include an additional adult instead of a child, or you may click book now to continue.">&nbsp;Sharing Bedding</span></div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
												    <?php
													} else if( isset($roomCategory[$type_xx]['SharingBedding']) && $roomCategory[$type_xx]["SharingBedding"] == "false") {
														?>
														 <div style="font-size:12px; margin-top:5px">
													    	<div>
														    	<div style="float:left">
															    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
														    	</div>
														    	<div style="float:left; font-size:12px; margin-top:1px">&nbsp;<span class="tip" style="text-decoration:underline" data-tip="Extra bed(s) must be requested for children">Use Extra Bed</span>
														    	</div>
														    	<div style="clear:both"></div>
													    	</div>
													    </div>
													<?php
													}
													?>
													<?php
												    if( isset($roomCategory["EssentialInformation"]) ) {
												    ?>
												    <div style="font-size:12px; margin-top:5px">
												    	<div>
													    	<div style="float:left">
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px">
														    	<?php
															    $info_div{"essential_info_two".$roomCategory["@attributes"]["Id"]} .= "
																	<div>
																		<ul style='margin-left:10px'>
																";
																if( isset($roomCategory["EssentialInformation"][0]) ) {
																	$countEssentialInfo = count($roomCategory["EssentialInformation"]);
																	for($ei=0; $ei<$countEssentialInfo; $ei++) {
																		$info_div{"essential_info_two".$roomCategory["@attributes"]["Id"]} .= "
																			<li style='list-style-type:square; font-size:14px'>
																				".$roomCategory["EssentialInformation"][$ei]["Information"]["Text"]."
																			</li>
																			<li style='list-style-type:square; font-size:14px'>
																				Valid from ".date("d M Y", strtotime($roomCategory["EssentialInformation"][$ei]["Information"]["DateRange"]["FromDate"]))." to ".date("d M Y", strtotime($roomCategory["EssentialInformation"][$ei]["Information"]["DateRange"]["ToDate"]))."
																			</li>

																		";
																	}
																}
																else {
																	$info_div{"essential_info_two".$roomCategory["@attributes"]["Id"]} .= "
																		<li style='list-style-type:square; font-size:14px'>
																			".$roomCategory["EssentialInformation"]["Information"]["Text"]."
																		</li>
																		<li style='list-style-type:square; font-size:14px'>
																				Valid from ".date("d M Y", strtotime($roomCategory["EssentialInformation"]["Information"]["DateRange"]["FromDate"]))." to ".date("d M Y", strtotime($roomCategory["EssentialInformation"]["Information"]["DateRange"]["ToDate"]))."
																			</li>
																	";
																}
																$info_div{"essential_info_two".$roomCategory["@attributes"]["Id"]} .= "
																			<li style='list-style-type:square; font-size:14px'>
																					To take advantages of this offer, please Call our customer services team on +65 6216 3456
																				</li>
																		</ul>
																	</div>
																";
															    ?>
														    	&nbsp;<span class="tip" style="text-decoration:underline" data-tip="<?php echo $info_div{"essential_info_two".$roomCategory["@attributes"]["Id"]}; ?>">Essential Info</span>
														    </div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
												    <?php
													}
													?>
													<?php
												    if( isset($roomCategory["ChargeConditions"]) ) {
												    ?>
												    <div style="font-size:12px; margin-top:5px">
												    	<div style="width:160px">
													    	<div style="float:left">
														    	<!--
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
														    	-->
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px">
														    	<?php
															    $chargeConditions = $roomCategory["ChargeConditions"]["ChargeCondition"];
															    $cancelCondition = "";

															    if(isset($chargeConditions[0]['Condition'][1]) && $chargeConditions[0]["Condition"][1]["@attributes"]["Charge"] == "false" ) {
															    	$free_cancellation_date = date("d M Y", strtotime($chargeConditions[0]["Condition"][1]["@attributes"]["FromDate"]));
															    	$cancelCondition .= "Cancellation are free until ". $free_cancellation_date .", ";
															    } else if(isset($chargeConditions[1]) && $chargeConditions[0]["Condition"][1]["@attributes"]["Charge"] == "true" ) {
															    	$half_cancellation_date_start = date("d M Y", strtotime($chargeConditions[0]["Condition"][1]["@attributes"]['ToDate']));
															    	$half_cancellation_date_end = date("d M Y",strtotime($chargeConditions[0]["Condition"][1]["@attributes"]['FromDate']));
														    		$cancelCondition .= "From ".$half_cancellation_date_start." to ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][1]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][1]["@attributes"]['ChargeAmount']." applies<br>";
															    }

															    if( $chargeConditions[0]["Condition"][0]["@attributes"]["Charge"] == "true" ) {
															    	if (!isset($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate'])) {
															    		$cancelCondition .= "Full charges will apply if cancelled";
															    	} else {

															    		if($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate'] == $chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']) {
															    			$half_cancellation_date_end = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']));
																    		$cancelCondition .= "From ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][0]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][0]["@attributes"]['ChargeAmount']." applies";
															    		}
														    			else {
														    				$half_cancellation_date_start = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate']));
																	    	$half_cancellation_date_end = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']));
																    		$cancelCondition .= "From ".$half_cancellation_date_start." to ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][0]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][0]["@attributes"]['ChargeAmount']." applies";
														    			}
															    	}

															    	$cancellation_status .= "<span style='color:green'><b>Allowed<br>(<i>*".$cancelCondition."</i>)</b></span>";

															    } else {
															    	$cancelCondition .= "<br>Full charges will apply if cancelled";
															    	$cancellation_status = "<span style='color:green'><b>Not allowed".$cancelCondition."</b></span>";
															    }

															    if( $chargeConditions[0]["Condition"]["@attributes"]["Charge"] == "true" ) {
																    $cancellation_status = "<span style='color:green'><b>Allowed (<i>*Charge is applied</i>)</b></span>";
															    }
															    else {
																    $cancellation_status = "<span style='color:green'><b>Not allowed</b></span>";
															    }
															    if( $chargeConditions[1]["@attributes"]["Allowable"] == "true" ) {
																    $amendment_status = "<span style='color:green'><b>Allowed</b></span>";
															    }
															    else {
																    $amendment_status = "<span style='color:green'><b>Not allowed</b></span>";
															    }
															    if( $roomCategory["ChargeConditions"]["PassengerNameChange"]["@attributes"]["Allowable"] == "true" ) {
																    $passenger_name_change_status = "<span style='color:green'><b>Allowed</b></span>";
															    }
															    else {
																    $passenger_name_change_status = "<span style='color:green'><b>Not allowed</b></span>";
															    }
															    $charge_div{"charge_conditions_two".$roomCategory["@attributes"]["Id"]} .= "
																	<div>
																		<ul style='margin-left:10px'>
																";
																$charge_div{"charge_conditions_two".$roomCategory["@attributes"]["Id"]} .= "
																	<li style='list-style-type:square; font-size:14px'>
																		Cancellation condition: ".$cancellation_status."
																	</li>
																";
																$charge_div{"charge_conditions_two".$roomCategory["@attributes"]["Id"]} .= "
																	<li style='list-style-type:square; font-size:14px'>
																		Change amendment details: ".$amendment_status."
																	</li>
																";
																$charge_div{"charge_conditions_two".$roomCategory["@attributes"]["Id"]} .= "
																	<li style='list-style-type:square; font-size:14px'>
																		Change passenger name: ".$passenger_name_change_status."
																	</li>
																";
																$charge_div{"charge_conditions_two".$roomCategory["@attributes"]["Id"]} .= "
																		</ul>
																	</div>
																";
															    ?>

															    <!-- &nbsp;<span class="tip" style="text-decoration:underline" data-tip="<?php echo $charge_div{"charge_conditions_two".$roomCategory["@attributes"]["Id"]}; ?>">Charge Conditions</span> -->

														    </div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
												    <?php
													}
													?>
											    </td>
											    <td style="background:#eff0f1; text-align:center; vertical-align:top;">
											    	<div style="font-size:12px">Price for <?php echo $durationGET;?> night(s)</div>
											    	<!--FOR DISCOUNT RATE-->
											    	<!--<div style="font-size:14px; margin-top:5px; text-decoration:line-through;">$1,234</div>-->
											    	<!--END OF FOR DISCOUNT RATE-->
											    	<div style="font-size:18px; margin-top:5px; color:#F7941D">
												    	<b>$<?php

												    		echo number_format($roomPrice, 2);?></b>
												    </div>
											    	<!-- <div style="font-size:12px; margin-top:5px">
												    	<div>
													    	Rooms:
													    	<select name="roomQtySelect">
														    	<option value="1" <?php echo ($noofroomGET == 1) ? "SELECTED" : ""; ?>>1</option>
														    	<option value="2" <?php echo ($noofroomGET == 2) ? "SELECTED" : ""; ?>>2</option>
														    	<option value="3" <?php echo ($noofroomGET == 3) ? "SELECTED" : ""; ?>>3</option>
														    	<option value="4" <?php echo ($noofroomGET == 4) ? "SELECTED" : ""; ?>>4</option>
														    </select>
													    </div>
											    	</div> -->
											    </td>
											    <td style="background: #eff0f1; text-align:center; vertical-align:top">
												    	<?php
												    	/*$linkurl = base_url()."cart/do_add_cartHotel";
														$linkurl .= "/". $this->uri->segment(4); // itemCode v
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($roomCategory["ItemPrice"]))); // pricePerRoom
														$linkurl .= "/". base64_encode(base64_encode(base64_encode(strtoupper($roomCategory["Description"])))); //roomtype
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($noofroomGET))); // noofRoom
														$linkurl .= "/". $this->uri->segment(5); // checkinDate
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($nameHotel))); // hotelName v
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($imgValid))); // hotelImage v
														$linkurl .= "/". $this->uri->segment(6); // checkoutDate
														$linkurl .= "/". $this->uri->segment(7); // duration_day
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($roomCategory["@attributes"]["Id"])));
														$linkurl .= "/". $this->uri->segment(10); // destinationCode
														$linkurl .= "/". $this->uri->segment(3); //citycode // 14
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofadult"]))); // adult
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofchildren"]))); // child
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofinfant"]))); // noofinfant
														$linkurl .= "/". $this->uri->segment(12); // country code
														$linkurl .= "/". $this->uri->segment(11); // country name*/
												    	?>
													    <!-- <a style="color:white; padding:13px; font-size:14px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo $linkurl;?>">
														</a> -->
														<input type="hidden" id="meal_basis_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode(strtoupper($meal))));?>"/>
														<input type="hidden" id="roomtype_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
														base64_encode(base64_encode(base64_encode(strtoupper($roomCategory["Description"]))));?>">
														<input type="hidden" id="roomtypeid_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
														base64_encode(base64_encode(base64_encode($roomCategory["@attributes"]["Id"])));?>">
														<input type="hidden" id="roomprice_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
														base64_encode(base64_encode(base64_encode($roomPrice)));?>">
														<input type="hidden" id="noofadult_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofadult"])));?>">
														<input type="hidden" id="noofchildren_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofchildren"])));?>">

														<input type="hidden" id="childages_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]['hotel_childrenAges'])));?>">

														<input type="hidden" id="noofinfant_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofinfant"])));?>">
														<input type="hidden" id="roomimage_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($imgValid)));?>">
														<button type="button" class="book_cart" data-idx="<?php echo $type_xx;?>" data-roomidx="<?php echo $type_x + 1;?>" data-roomname="<?php echo strtoupper($roomCategory["Description"]);?>" data-roomprice="<?php echo number_format($roomPrice, 2);?>"  data-roomidx="<?php echo $type_x + 1;?>" style="color:white; padding:13px; font-size:14px; font-weight:bold; text-decoration:none; cursor:pointer">Book Now
													    </button>
													    <!-- <button onclick="alert('not available in production testing yet')">
														    Book now
														</button> -->
													<div style="font-size:12px; margin-top:3px">Limited rooms available!</div>
												</td>
											</tr>
											<!--END OF NEW DESIGN-->
										<?php
										}
										?>
									<?php
									}
									else
									{
										/*<!--SINGLE ROOM INDEX-->*/
										$roomCategory = $paxroomCategory["RoomCategories"]["RoomCategory"];

										if( isset($roomCategory[0]) ) {
									?>
										<tr class="available_price header_price<?php echo ($type_x + 1);?>">
										    <td colspan="4" style="background:#eff0f1; vertical-align:top;">
											    <div>
												    Room Pax:
												    <?php echo $arrayB[1]["hotel_noofadult"]; ?> Adult(s)
												    <?php echo $arrayB[1]["hotel_noofchildren"]; ?> Child(s)
												    <?php echo $arrayB[1]["hotel_noofinfant"]; ?> Infant(s)
												</div>
										    </td>
									    </tr>
										<?php
											$countRoomCategory = count($roomCategory);
											for($type_xx=0; $type_xx<$countRoomCategory; $type_xx++) {
												if (isset($roomCategory[$type_xx]["Description"]['@attributes']) && isset($roomCategory[$type_xx]["Description"]['@attributes']['Id'])) {
													$roomID = $roomCategory[$type_xx]["Description"]["@attributes"]["Id"];
												} else {
													$roomID = $roomCategory[$type_xx]["@attributes"]["Id"];
												}

												$roomPrice = $roomCategory[$type_xx]["ItemPrice"] + round((GTA_PRICE_MARKUP/100) * $roomCategory[$type_xx]["ItemPrice"], 2);
												$roomPrice = ceil($roomPrice);
											?>
											<!--NEW DESIGN-->
											<tr class="available_price sort_price" data-price="<?php echo $roomPrice;?>" data-roomidx="<?php echo ($type_x + 1);?>">
										    	<td style="background:#eff0f1; text-align:center">
											    	<?php
											    	//$checkCat = 'Guest Room';
											    	//if (strpos(strtoupper($roomCategory[$type_xx]["Description"]), 'SUITE') !== false) {
											    		$checkCat = 'Suite';
													//}
													$imagecats = $this->All->select_template_with_where_quadruple_limit(
														"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
														"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
														"text", $checkCat,
														"type", "image",
														1, "hotel_gta_item_information_image_link"//"hotel_gta_item_information_image_link"
													);
													if( $imagecats == TRUE ) {
														foreach( $imagecats AS $imagecat ) { $imgValid = $imagecat->image; }
													}

													$imagecats = $this->All->select_template_with_where_quadruple_limit(
														"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
														"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
														"text", 	'Guest Room',
														"type", "image",
														1, "hotel_gta_item_information_image_link"//"hotel_gta_item_information_image_link"
													);

													$imgValid2 = "";
													if( $imagecats == TRUE ) {
														foreach( $imagecats AS $imagecat ) { $imgValid2 = $imagecat->image; }
													}

													if ((UR_exists($imgValid) === false && UR_exists($imgValid2) === false)  || $imgValid == "") {
														$imgValid = base_url()."assets/default.png";
													} else if (UR_exists($imgValid) === false && UR_exists($imgValid2) && strpos(strtoupper($roomCategory["Description"]), 'SUITE') === false) {
														$imgValid = $imgValid2;
													}
													?>
											    	<img src="<?php echo str_replace('http://', 'https://', $imgValid); ?>" width="140px" height="100px" />
											    	<div style="font-size:12px; margin-top:5px">Capacity</div>
											    	<div style="font-size:12px; margin-top:5px">
												    	<img src="<?php echo base_url(); ?>assets/adult.png?<?php echo uniqid(); ?>" width="24px" height="24px" style="display:initial" />
												    	<img src="<?php echo base_url(); ?>assets/adult.png?<?php echo uniqid(); ?>" width="24px" height="24px" style="display:initial; margin-left:-10px" />
											    	</div>
										    	</td>
										    	<td style="background:#eff0f1; vertical-align:top; padding: 15px 7px !important">
											    	<div style="font-size:12px"><?php echo strtoupper($roomCategory[$type_xx]["Description"]); ?></div>
											    	<?php
												    if( $roomCategory[$type_xx]["Meals"]["Basis"] != "None" ) {
												    	$meal = $roomCategory[$type_xx]["Meals"]["Breakfast"];
												    ?>
												    	<div style="font-size:12px; margin-top:5px; width: 160px">
													    	<div>
														    	<div style="float:left">
															    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
														    	</div>
														    	<div style="float:left; font-size:12px; margin-top:1px">
															    	&nbsp;<?php echo $roomCategory[$type_xx]["Meals"]["Breakfast"]; ?> Breakfast
															    </div>
														    	<div style="clear:both"></div>
													    	</div>
													    </div>
												    <?php
													} else {
														$meal = "none";
														?>
															<div style="font-size:12px; margin-top:5px">
														    	<div>
															    	<div style="float:left">
																    	<img src="<?php echo base_url(); ?>assets/close.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
															    	</div>
															    	<div style="float:left; font-size:12px; margin-top:1px">
																    	&nbsp;No Breakfast
																    </div>
															    	<div style="clear:both"></div>
														    	</div>
														    </div>
														<?php
														}
														?>
													<?php
												    if( isset($roomCategory[$type_xx]['SharingBedding']) && $roomCategory[$type_xx]["SharingBedding"] != "false") {
												    ?>
												    <div style="font-size:12px; margin-top:5px">
												    	<div>
													    	<div style="float:left">
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px"><span class="tip" style="text-decoration:underline" data-tip="At this hotel an additional bed is not provided in the room, child will need to share the existing bedding. If you want to guarantee a separate bed, please adjust your search to include an additional adult instead of a child, or you may click book now to continue.">&nbsp;Sharing Bedding</span></span></div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
												    <?php
													}
												 else if( isset($roomCategory[$type_xx]['SharingBedding']) && $roomCategory[$type_xx]["SharingBedding"] == "false") {
													?>
													 <div style="font-size:12px; margin-top:5px">
												    	<div>
													    	<div style="float:left">
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px">&nbsp;<span class="tip" style="text-decoration:underline" data-tip="Extra bed(s) must be requested for children">Use Extra Bed</span>
													    	</div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
													<?php
													}
													?>
													<?php
												    if( isset($roomCategory[$type_xx]["EssentialInformation"]) ) {
												    ?>
												    <div style="font-size:12px; margin-top:5px">
												    	<div>
													    	<div style="float:left">
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px">
														    	<?php
															    $info_div{"essential_info_three".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																	<div>
																		<ul style='margin-left:10px'>
																";
																if( isset($roomCategory[$type_xx]["EssentialInformation"][0]) ) {
																	$countEssentialInfo = count($roomCategory[$type_xx]["EssentialInformation"]);
																	for($ei=0; $ei<$countEssentialInfo; $ei++) {
																		$info_div{"essential_info_three".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																			<li style='list-style-type:square; font-size:14px'>
																				".$roomCategory[$type_xx]["EssentialInformation"][$ei]["Information"]["Text"]."
																			</li>
																			<li style='list-style-type:square; font-size:14px'>
																				Valid from ".date("d M Y", strtotime($roomCategory[$type_xx]["EssentialInformation"][$ei]["Information"]["DateRange"]["FromDate"]))." to ".date("d M Y", strtotime($roomCategory[$type_xx]["EssentialInformation"][$ei]["Information"]["DateRange"]["ToDate"]))."
																			</li>
																		";
																	}
																}
																else {
																	if(isset($roomCategory[$type_xx]["EssentialInformation"]['Information'])) {
																		if(isset($roomCategory[$type_xx]["EssentialInformation"]['Information'][0]) && count($roomCategory[$type_xx]["EssentialInformation"]['Information'])) {
																			for ($idxx = 0; $idxx < count($roomCategory[$type_xx]["EssentialInformation"]['Information']); $idxx++) {
																				$info_div{"essential_info_three".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																					<li style='list-style-type:square; font-size:14px'>
																						".$roomCategory[$type_xx]["EssentialInformation"]["Information"][$idxx]["Text"]."
																						(Valid from ".date("d M Y", strtotime($roomCategory[$type_xx]["EssentialInformation"]["Information"][$idxx]["DateRange"]["FromDate"]))." to ".date("d M Y", strtotime($roomCategory[$type_xx]["EssentialInformation"]["Information"][$idxx]["DateRange"]["ToDate"])).")
																					</li>
																				";
																			}
																		} else {
																			$info_div{"essential_info_three".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																				<li style='list-style-type:square; font-size:14px'>
																					".$roomCategory[$type_xx]["EssentialInformation"]["Information"]["Text"]."
																				</li>
																				<li style='list-style-type:square; font-size:14px'>
																					Valid from ".date("d M Y", strtotime($roomCategory[$type_xx]["EssentialInformation"]["Information"]["DateRange"]["FromDate"]))." to ".date("d M Y", strtotime($roomCategory[$type_xx]["EssentialInformation"]["Information"]["DateRange"]["ToDate"]))."
																				</li>
																			";
																		}
																	} else {
																		/* not found the case of this else yet */
																	}
																}
																$info_div{"essential_info_three".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "									<li style='list-style-type:square; font-size:14px'>
																				To take advantages of this offer, please Call our customer services team on +65 6216 3456
																			</li>
																		</ul>
																	</div>
																";
															    ?>
														    	&nbsp;<span class="tip" style="text-decoration:underline" data-tip="<?php echo $info_div{"essential_info_three".$roomCategory[$type_xx]["@attributes"]["Id"]}; ?>">Essential Info</span>
														    </div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
												    <?php
													}
													?>
													<?php
												    if( isset($roomCategory[$type_xx]["ChargeConditions"]) ) {
												    ?>
												    <div style="font-size:12px; margin-top:5px">
												    	<div style="width:160px">
													    	<div style="float:left">
														    	<!--
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
														    	-->
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px">
														    	<?php
															    $chargeConditions = $roomCategory[$type_xx]["ChargeConditions"]["ChargeCondition"];
															    $cancellation_status = "";
																	$cancelCondition = "";

															    if(isset($chargeConditions[0]['Condition'][1]) && $chargeConditions[0]["Condition"][1]["@attributes"]["Charge"] == "false" ) {
															    	$free_cancellation_date = date("d M Y", strtotime($chargeConditions[0]["Condition"][1]["@attributes"]["FromDate"]));
															    	$cancelCondition .= "Cancellation are free until ". $free_cancellation_date .", ";
															    } else if(isset($chargeConditions[1]) && $chargeConditions[0]["Condition"][1]["@attributes"]["Charge"] == "true" ) {
															    	$half_cancellation_date_start = date("d M Y", strtotime($chargeConditions[0]["Condition"][1]["@attributes"]['ToDate']));
															    	$half_cancellation_date_end = date("d M Y",strtotime($chargeConditions[0]["Condition"][1]["@attributes"]['FromDate']));
														    		$cancelCondition .= "From ".$half_cancellation_date_start." to ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][1]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][1]["@attributes"]['ChargeAmount']." applies<br>";
															    }

															    if( $chargeConditions[0]["Condition"][0]["@attributes"]["Charge"] == "true" ) {
															    	if (!isset($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate'])) {
															    		$cancelCondition .= "Full charges will apply if cancelled";
															    	} else {

															    		if($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate'] == $chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']) {
															    			$half_cancellation_date_end = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']));
																    		$cancelCondition .= "From ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][0]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][0]["@attributes"]['ChargeAmount']." applies";
															    		}
														    			else {
														    				$half_cancellation_date_start = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate']));
																	    	$half_cancellation_date_end = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']));
																    		$cancelCondition .= "From ".$half_cancellation_date_start." to ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][0]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][0]["@attributes"]['ChargeAmount']." applies";
														    			}
															    	}

															    	$cancellation_status .= "<span style='color:green'><b>Allowed<br>(<i>*".$cancelCondition."</i>)</b></span>";

															    } else {
															    	$cancelCondition .= "<br>Full charges will apply if cancelled";
															    	$cancellation_status = "<span style='color:green'><b>Not allowed".$cancelCondition."</b></span>";
															    }

															    if( $chargeConditions[0]["Condition"]["@attributes"]["Charge"] == "true" ) {
																    $cancellation_status = "<span style='color:green'><b>Allowed (<i>*Charge is applied</i>)</b></span>";
															    }
															    else {
																    $cancellation_status = "<span style='color:green'><b>Not allowed</b></span>";
															    }
															    if( $chargeConditions[1]["@attributes"]["Allowable"] == "true" ) {
																    $amendment_status = "<span style='color:green'><b>Allowed</b></span>";
															    }
															    else {
																    $amendment_status = "<span style='color:green'><b>Not allowed</b></span>";
															    }
															    if( $roomCategory[$type_xx]["ChargeConditions"]["PassengerNameChange"]["@attributes"]["Allowable"] == "true" ) {
																    $passenger_name_change_status = "<span style='color:green'><b>Allowed</b></span>";
															    }
															    else {
																    $passenger_name_change_status = "<span style='color:green'><b>Not allowed</b></span>";
															    }
															    $charge_div{"charge_conditions_three".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																	<div>
																		<ul style='margin-left:10px'>
																";
																$charge_div{"charge_conditions_three".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																	<li style='list-style-type:square; font-size:14px'>
																		Cancellation condition: ".$cancellation_status."
																	</li>
																";
																$charge_div{"charge_conditions_three".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																	<li style='list-style-type:square; font-size:14px'>
																		Change amendment details: ".$amendment_status."
																	</li>
																";
																$charge_div{"charge_conditions_three".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																	<li style='list-style-type:square; font-size:14px'>
																		Change passenger name: ".$passenger_name_change_status."
																	</li>
																";
																$charge_div{"charge_conditions_three".$roomCategory[$type_xx]["@attributes"]["Id"]} .= "
																		</ul>
																	</div>
																";
															    ?>

															    <!-- &nbsp;<span class="tip" style="text-decoration:underline" data-tip="<?php echo $charge_div{"charge_conditions_three".$roomCategory[$type_xx]["@attributes"]["Id"]}; ?>">Charge Conditions</span> -->

														    </div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
												    <?php
													}
													?>
											    </td>
											    <td style="background:#eff0f1; text-align:center; vertical-align:top;">
											    	<div style="font-size:12px">Price for <?php echo $durationGET;?> night(s)</div>
											    	<!--FOR DISCOUNT RATE-->
											    	<!--<div style="font-size:14px; margin-top:5px; text-decoration:line-through;">$1,234</div>-->
											    	<!--END OF FOR DISCOUNT RATE-->
											    	<div style="font-size:18px; margin-top:5px; color:#F7941D">
												    	<b>$<?php

												    		echo number_format($roomPrice, 2);

												    		?></b>
												    </div>
											    	<!-- <div style="font-size:12px; margin-top:5px">
												    	<div>
													    	Rooms:
													    	<select name="roomQtySelect">
														    	<option value="1" <?php echo ($noofroomGET == 1) ? "SELECTED" : ""; ?>>1</option>
														    	<option value="2" <?php echo ($noofroomGET == 2) ? "SELECTED" : ""; ?>>2</option>
														    	<option value="3" <?php echo ($noofroomGET == 3) ? "SELECTED" : ""; ?>>3</option>
														    	<option value="4" <?php echo ($noofroomGET == 4) ? "SELECTED" : ""; ?>>4</option>
														    </select>
													    </div>
											    	</div> -->
											    </td>
											    <td style="background: #eff0f1; text-align:center; vertical-align:top">
												    	<?php
												    	/*$linkurl = base_url()."cart/do_add_cartHotel";
														$linkurl .= "/". $this->uri->segment(4); // itemCode v
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($roomCategory[$type_xx]["ItemPrice"]))); // pricePerRoom
														$linkurl .= "/". base64_encode(base64_encode(base64_encode(strtoupper($roomCategory[$type_xx]["Description"])))); //roomtype
														$linkurl .= "/". $this->uri->segment(8); // noofRoom
														$linkurl .= "/". $this->uri->segment(5); // checkinDate
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($nameHotel))); // hotelName v
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($imgValid))); // hotelImage v
														$linkurl .= "/". $this->uri->segment(6); // checkoutDate
														$linkurl .= "/". $this->uri->segment(7); // duration_day
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($roomID)));
														$linkurl .= "/". $this->uri->segment(10); // destinationCode
														$linkurl .= "/". $this->uri->segment(3); //citycode // 14
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofadult"]))); // adult
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofchildren"]))); // child
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofinfant"]))); // noofinfant
														$linkurl .= "/". $this->uri->segment(12); // country code
														$linkurl .= "/". $this->uri->segment(11); // country name*/
												    	?>
													    <!-- <a style="color:white; padding:13px; font-size:14px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo str_replace('http://', 'https://', $linkurl);?>">
														    Book now
														</a> -->
														<input type="hidden" id="meal_basis_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode(strtoupper($meal))));?>"/>
														<input type="hidden" id="roomtype_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
														base64_encode(base64_encode(base64_encode(strtoupper($roomCategory[$type_xx]["Description"]))));?>">
														<input type="hidden" id="roomtypeid_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
														base64_encode(base64_encode(base64_encode($roomCategory[$type_xx]["@attributes"]["Id"])));?>">
														<input type="hidden" id="roomprice_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
														base64_encode(base64_encode(base64_encode($roomPrice)));?>">
														<input type="hidden" id="noofadult_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofadult"])));?>">
														<input type="hidden" id="noofchildren_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofchildren"])));?>">
														<input type="hidden" id="childages_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]['hotel_childrenAges'])));?>">

														<input type="hidden" id="noofinfant_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofinfant"])));?>">
														<input type="hidden" id="roomimage_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($imgValid)));?>">

														<button type="button" class="book_cart" data-idx="<?php echo $type_xx;?>" data-roomidx="<?php echo $type_x + 1;?>" data-roomname="<?php echo $nameHotel;?>" data-roomprice="<?php echo number_format($roomPrice, 2);?>" style="color:white; padding:20px; font-size:14px; font-weight:bold; text-decoration:none; cursor:pointer; background-color:#F7941D;" >Book Now
													    </button>

														<!-- <button onclick="alert('not available in production testing yet')">
														    Book now
														</button> -->
													<div style="font-size:12px; margin-top:3px">Limited rooms available!</div>
												</td>
											</tr>
											<!--END OF NEW DESIGN-->
										<?php
											}
										}
										else {
											$roomPrice = $roomCategory["ItemPrice"] + round((GTA_PRICE_MARKUP/100) * $roomCategory["ItemPrice"], 2);
											$roomPrice = ceil($roomPrice);
									?>
										<!--NEW DESIGN-->
										<tr class="available_price header_price<?php echo ($type_x + 1);?>">
										    <td colspan="4" style="background:#eff0f1; vertical-align:top;">
											    <div>
												    Room Pax:
												    <?php echo $arrayB[1]["hotel_noofadult"]; ?> Adult(s)
												    <?php echo $arrayB[1]["hotel_noofchildren"]; ?> Child(s)
												    <?php echo $arrayB[1]["hotel_noofinfant"]; ?> Infant(s)
												</div>
										    </td>
									    </tr>
										<tr class="available_price sort_price" data-price="<?php echo $roomPrice;?>" data-roomidx="<?php echo ($type_x + 1);?>">
									    	<td style="background:#eff0f1; text-align:center">
										    	<?php
										    	//$checkCat = 'Guest Room';
										    	//if (strpos(strtoupper($roomCategory["Description"]), 'SUITE') !== false) {
										    		$checkCat = 'Suite';
												//}
												$imagecats = $this->All->select_template_with_where_quadruple_limit(
													"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
													"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
													"text", 	 $checkCat,
													"type", "image",
													1, "hotel_gta_item_information_image_link"//"hotel_gta_item_information_image_link"
												);
												if( $imagecats == TRUE ) {
													foreach( $imagecats AS $imagecat ) { $imgValid = $imagecat->image; }
												}

												$imagecats = $this->All->select_template_with_where_quadruple_limit(
														"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
														"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
														"text", 	'Guest Room',
														"type", "image",
														1, "hotel_gta_item_information_image_link"//"hotel_gta_item_information_image_link"
													);

													$imgValid2 = "";
													if( $imagecats == TRUE ) {
														foreach( $imagecats AS $imagecat ) { $imgValid2 = $imagecat->image; }
													}

													if ((UR_exists($imgValid) === false && UR_exists($imgValid2) === false)  || $imgValid == "") {
														$imgValid = base_url()."assets/default.png";
													} else if (UR_exists($imgValid) === false && UR_exists($imgValid2) && strpos(strtoupper($roomCategory["Description"]), 'SUITE') === false) {
														$imgValid = $imgValid2;
													}
												?>
										    	<img src="<?php echo str_replace('http://', 'https://', $imgValid); ?>" width="140px" height="100px" />
										    	<div style="font-size:12px; margin-top:5px">Capacity</div>
										    	<div style="font-size:12px; margin-top:5px">
											    	<img src="<?php echo base_url(); ?>assets/adult.png?<?php echo uniqid(); ?>" width="24px" height="24px" style="display:initial" />
											    	<img src="<?php echo base_url(); ?>assets/adult.png?<?php echo uniqid(); ?>" width="24px" height="24px" style="display:initial; margin-left:-10px" />
										    	</div>
									    	</td>
									    	<td style="background:#eff0f1; vertical-align:top;">
										    	<div style="font-size:12px"><?php echo strtoupper($roomCategory["Description"]); ?></div>
										    	<?php
											    if( $roomCategory["Meals"]["Basis"] != "None" ) {
											    	$meal = $roomCategory["Meals"]["Breakfast"];
											    ?>
											    	<div style="font-size:12px; margin-top:5px; width: 160px">
												    	<div>
													    	<div style="float:left">
														    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
													    	</div>
													    	<div style="float:left; font-size:12px; margin-top:1px">
														    	&nbsp;<?php echo $roomCategory["Meals"]["Breakfast"]; ?> Breakfast
														    </div>
													    	<div style="clear:both"></div>
												    	</div>
												    </div>
											    <?php
												} else {
													$meal = "none";
												?>
															<div style="font-size:12px; margin-top:5px">
														    	<div>
															    	<div style="float:left">
																    	<img src="<?php echo base_url(); ?>assets/close.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
															    	</div>
															    	<div style="float:left; font-size:12px; margin-top:1px">
																    	&nbsp;No Breakfast
																    </div>
															    	<div style="clear:both"></div>
														    	</div>
														    </div>
														<?php
														}
														?>
												<?php
											    if( isset($roomCategory['SharingBedding']) && $roomCategory["SharingBedding"] != "false") {
											    ?>
											    <div style="font-size:12px; margin-top:5px">
											    	<div>
												    	<div style="float:left">
													    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
												    	</div>
												    	<div style="float:left; font-size:12px; margin-top:1px"><span class="tip" style="text-decoration:underline" data-tip="At this hotel an additional bed is not provided in the room, child will need to share the existing bedding. If you want to guarantee a separate bed, please adjust your search to include an additional adult instead of a child, or you may click book now to continue.">&nbsp;Sharing Bedding</span></span></div>
												    	<div style="clear:both"></div>
											    	</div>
											    </div>
											    <?php
												} else if( isset($roomCategory[$type_xx]['SharingBedding']) && $roomCategory[$type_xx]["SharingBedding"] == "false") {
														?>
														 <div style="font-size:12px; margin-top:5px">
													    	<div>
														    	<div style="float:left">
															    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
														    	</div>
														    	<div style="float:left; font-size:12px; margin-top:1px">&nbsp;<span class="tip" style="text-decoration:underline" data-tip="Extra bed(s) must be requested for children">Use Extra Bed</span>
														    	</div>
														    	<div style="clear:both"></div>
													    	</div>
													    </div>
														<?php
														}
														?>
												<?php
											    if( isset($roomCategory["EssentialInformation"]) ) {
											    ?>
											    <div style="font-size:12px; margin-top:5px">
											    	<div>
												    	<div style="float:left">
													    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
												    	</div>
												    	<div style="float:left; font-size:12px; margin-top:1px">
													    	<?php
														    $info_div{"essential_info_four".$roomCategory["@attributes"]["Id"]} .= "
																<div>
																	<ul style='margin-left:10px'>
															";
															if( isset($roomCategory["EssentialInformation"][0]) ) {
																$countEssentialInfo = count($roomCategory["EssentialInformation"]);
																for($ei=0; $ei<$countEssentialInfo; $ei++) {
																	$info_div{"essential_info_four".$roomCategory["@attributes"]["Id"]} .= "
																		<li style='list-style-type:square; font-size:14px'>
																			".$roomCategory["EssentialInformation"][$ei]["Information"]["Text"]."
																		</li>
																		<li style='list-style-type:square; font-size:14px'>
																			Valid from ".date("d M Y", strtotime($roomCategory["EssentialInformation"][$ei]["Information"]["DateRange"]["FromDate"]))." to ".date("d M Y", strtotime($roomCategory["EssentialInformation"][$ei]["Information"]["DateRange"]["ToDate"]))."
																		</li>
																	";
																}
															}
															else {
																$info_div{"essential_info_four".$roomCategory["@attributes"]["Id"]} .= "
																	<li style='list-style-type:square; font-size:14px'>
																		".$roomCategory["EssentialInformation"]["Information"]["Text"]."
																	</li>
																	<li style='list-style-type:square; font-size:14px'>
																		Valid from ".date("d M Y", strtotime($roomCategory["EssentialInformation"]["Information"]["DateRange"]["FromDate"]))." to ".date("d M Y", strtotime($roomCategory["EssentialInformation"]["Information"]["DateRange"]["ToDate"]))."
																	</li>
																";
															}
															$info_div{"essential_info_four".$roomCategory["@attributes"]["Id"]} .= "
																		<li style='list-style-type:square; font-size:14px'>
																			To take advantages of this offer, please Call our customer services team on +65 6216 3456
																		</li>
																	</ul>
																</div>
															";
														    ?>
													    	&nbsp;<span class="tip" style="text-decoration:underline" data-tip="<?php echo $info_div{"essential_info_four".$roomCategory["@attributes"]["Id"]}; ?>">Essential Info</span>
													    </div>
												    	<div style="clear:both"></div>
											    	</div>
											    </div>
											    <?php
												}
												?>
												<?php
											    if( isset($roomCategory["ChargeConditions"]) ) {
											    ?>
											    <div style="font-size:12px; margin-top:5px">
											    	<div style="width:160px">
												    	<div style="float:left">
													    	<!--
													    	<img src="<?php echo base_url(); ?>assets/check.png?<?php echo uniqid(); ?>" width="16px" height="16px" />
													    	-->
												    	</div>
												    	<div style="float:left; font-size:12px; margin-top:1px">
													    	<?php
														    $chargeConditions = $roomCategory["ChargeConditions"]["ChargeCondition"];
														    $cancellation_status = "";
																$cancelCondition = "";

														    if(isset($chargeConditions[0]['Condition'][1]) && $chargeConditions[0]["Condition"][1]["@attributes"]["Charge"] == "false" ) {
														    	$free_cancellation_date = date("d M Y", strtotime($chargeConditions[0]["Condition"][1]["@attributes"]["FromDate"]));
														    	$cancelCondition .= "Cancellation are free until ". $free_cancellation_date .", ";
														    } else if(isset($chargeConditions[1]) && $chargeConditions[0]["Condition"][1]["@attributes"]["Charge"] == "true" ) {
														    	$half_cancellation_date_start = date("d M Y", strtotime($chargeConditions[0]["Condition"][1]["@attributes"]['ToDate']));
														    	$half_cancellation_date_end = date("d M Y",strtotime($chargeConditions[0]["Condition"][1]["@attributes"]['FromDate']));
													    		$cancelCondition .= "From ".$half_cancellation_date_start." to ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][1]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][1]["@attributes"]['ChargeAmount']." applies<br>";
														    }

														    if( $chargeConditions[0]["Condition"][0]["@attributes"]["Charge"] == "true" ) {
														    	if (!isset($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate'])) {
														    		$cancelCondition .= "Full charges will apply if cancelled";
														    	} else {

														    		if($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate'] == $chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']) {
														    			$half_cancellation_date_end = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']));
															    		$cancelCondition .= "From ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][0]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][0]["@attributes"]['ChargeAmount']." applies";
														    		}
													    			else {
													    				$half_cancellation_date_start = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['ToDate']));
																    	$half_cancellation_date_end = date("d M Y", strtotime($chargeConditions[0]["Condition"][0]["@attributes"]['FromDate']));
															    		$cancelCondition .= "From ".$half_cancellation_date_start." to ". $half_cancellation_date_end.", for any cancellation, Charge of ".$chargeConditions[0]["Condition"][0]["@attributes"]["Currency"] . $chargeConditions[0]["Condition"][0]["@attributes"]['ChargeAmount']." applies";
													    			}
														    	}

														    	$cancellation_status .= "<span style='color:green'><b>Allowed<br>(<i>*".$cancelCondition."</i>)</b></span>";

														    } else {
														    	$cancelCondition .= "<br>Full charges will apply if cancelled";
														    	$cancellation_status = "<span style='color:green'><b>Not allowed".$cancelCondition."</b></span>";
														    }


														    if( $chargeConditions[0]["Condition"]["@attributes"]["Charge"] == "true" ) {
															    $cancellation_status = "<span style='color:green'><b>Allowed (<i>*Charge is applied</i>)</b></span>";
														    }
														    else {
															    $cancellation_status = "<span style='color:green'><b>Not allowed</b></span>";
														    }
														    if( $chargeConditions[1]["@attributes"]["Allowable"] == "true" ) {
															    $amendment_status = "<span style='color:green'><b>Allowed</b></span>";
														    }
														    else {
															    $amendment_status = "<span style='color:green'><b>Not allowed</b></span>";
														    }
														    if( $roomCategory["ChargeConditions"]["PassengerNameChange"]["@attributes"]["Allowable"] == "true" ) {
															    $passenger_name_change_status = "<span style='color:green'><b>Allowed</b></span>";
														    }
														    else {
															    $passenger_name_change_status = "<span style='color:green'><b>Not allowed</b></span>";
														    }
														    $charge_div{"charge_conditions_four".$roomCategory["@attributes"]["Id"]} .= "
																<div>
																	<ul style='margin-left:10px'>
															";
															$charge_div{"charge_conditions_four".$roomCategory["@attributes"]["Id"]} .= "
																<li style='list-style-type:square; font-size:14px'>
																	Cancelation condition: ".$cancellation_status."
																</li>
															";
															$charge_div{"charge_conditions_four".$roomCategory["@attributes"]["Id"]} .= "
																<li style='list-style-type:square; font-size:14px'>
																	Change amendment details: ".$amendment_status."
																</li>
															";
															$charge_div{"charge_conditions_four".$roomCategory["@attributes"]["Id"]} .= "
																<li style='list-style-type:square; font-size:14px'>
																	Change passenger name: ".$passenger_name_change_status."
																</li>
															";
															$charge_div{"charge_conditions_four".$roomCategory["@attributes"]["Id"]} .= "
																	</ul>
																</div>
															";
														    ?>

														    <!-- &nbsp;<span class="tip" style="text-decoration:underline" data-tip="<?php echo $charge_div{"charge_conditions_four".$roomCategory["@attributes"]["Id"]}; ?>">Charge Conditions</span> -->

													    </div>
												    	<div style="clear:both"></div>
											    	</div>
											    </div>
											    <?php
												}
												?>
										    </td>
										    <td style="background:#eff0f1; text-align:center; vertical-align:top;">
										    	<div style="font-size:12px">Price for <?php echo $durationGET;?> night(s)</div>
										    	<!--FOR DISCOUNT RATE-->
										    	<!--<div style="font-size:14px; margin-top:5px; text-decoration:line-through;">$1,234</div>-->
										    	<!--END OF FOR DISCOUNT RATE-->
										    	<div style="font-size:18px; margin-top:5px; color:#F7941D">
											    	<b>$<?php

												    		echo number_format($roomPrice, 2);
												    		 ?></b>
											    </div>
										    	<!-- <div style="font-size:12px; margin-top:5px">
											    	<div>
												    	Rooms:
												    	<select name="roomQtySelect">
													    	<option value="1" <?php echo ($noofroomGET == 1) ? "SELECTED" : ""; ?>>1</option>
													    	<option value="2" <?php echo ($noofroomGET == 2) ? "SELECTED" : ""; ?>>2</option>
													    	<option value="3" <?php echo ($noofroomGET == 3) ? "SELECTED" : ""; ?>>3</option>
													    	<option value="4" <?php echo ($noofroomGET == 4) ? "SELECTED" : ""; ?>>4</option>
													    </select>
												    </div>
										    	</div> -->
										    </td>
										    <td style="background: #eff0f1; text-align:center; vertical-align:top">
											    <?php
												    	/*$linkurl = base_url()."cart/do_add_cartHotel";
														$linkurl .= "/". $this->uri->segment(4); // itemCode v
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($roomCategory[$type_xx]["ItemPrice"]))); // pricePerRoom
														$linkurl .= "/". base64_encode(base64_encode(base64_encode(strtoupper($roomCategory[$type_xx]["Description"])))); //roomtype
														$linkurl .= "/". $this->uri->segment(8); // noofRoom
														$linkurl .= "/". $this->uri->segment(5); // checkinDate
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($nameHotel))); // hotelName v
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($imgValid))); // hotelImage v
														$linkurl .= "/". $this->uri->segment(6); // checkoutDate
														$linkurl .= "/". $this->uri->segment(7); // duration_day
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($roomID)));
														$linkurl .= "/". $this->uri->segment(10); // destinationCode
														$linkurl .= "/". $this->uri->segment(3); //citycode // 14
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofadult"]))); // adult
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofchildren"]))); // child
														$linkurl .= "/". base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofinfant"]))); // noofinfant
														$linkurl .= "/". $this->uri->segment(12); // country code
														$linkurl .= "/". $this->uri->segment(11); // country name*/
											    ?>
												    <!-- <a style="color:white; padding:13px; font-size:14px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo str_replace('http://', 'https://', $linkurl);?>">
													    Book now
													</a> -->
													<input type="hidden" id="meal_basis_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode(strtoupper($meal))));?>"/>
													<input type="hidden" id="roomtype_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
														base64_encode(base64_encode(base64_encode(strtoupper($roomCategory["Description"]))));?>">
													<input type="hidden" id="roomtypeid_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
													base64_encode(base64_encode(base64_encode($roomCategory["@attributes"]["Id"])));?>">
													<input type="hidden" id="roomprice_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo
													base64_encode(base64_encode(base64_encode($roomPrice)));?>">
													<input type="hidden" id="noofadult_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofadult"])));?>">
													<input type="hidden" id="noofchildren_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofchildren"])));?>">
													<input type="hidden" id="childages_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]['hotel_childrenAges'])));?>">
													<input type="hidden" id="noofinfant_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($arrayB[$type_x+1]["hotel_noofinfant"])));?>">
													<input type="hidden" id="roomimage_<?php echo $type_x+1;?>_<?php echo $type_xx;?>" value="<?php echo base64_encode(base64_encode(base64_encode($imgValid)));?>">

													<button type="button" class="book_cart" data-idx="<?php echo $type_xx;?>" data-roomidx="<?php echo $type_x + 1;?>" data-roomname="<?php echo $nameHotel;?>" data-roomprice="<?php echo number_format($roomPrice, 2);?>" data-roomidx="<?php echo $type_x + 1;?>" style="color:white; padding:20px; font-size:14px; font-weight:bold; text-decoration:none; cursor:pointer; backround:#F7941D">Book Now
													</button>
													<!-- <button onclick="alert('not available in production testing yet')">
														    Book now
														</button> -->
												</div>
												<div style="font-size:12px; margin-top:3px">Limited rooms available!</div>
											</td>
										</tr>
										<!--END OF NEW DESIGN-->
									<?php
										}
									?>
									<!--END OF SINGLE ROOM INDEX-->

								<?php
								}
								?>
									</tbody>
								</table>
							</div>
						<?php
						}
						echo '</div>';//tab content
						?>

						<!--END OF ROOM TYPES-->
						</article>
					</section>
					<!--//availability-->
					<!--description-->
					<section id="description" class="tab-content">
						<article>
							<h1>General</h1>
							<div class="text-wrap">
								<ul>
									<?php
									$reports = $this->All->select_template_w_2_conditions(
										"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
										"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
										"hotel_gta_item_information_report"
									);
									if( $reports == TRUE ) {
										foreach( $reports AS $report ) {
											if($report->content === ".") {} else {
									?>
									<li><?php echo $report->content; ?></li>
									<?php
											}
										}
									}
									?>
								</ul>

							</div>
							<h1>Check-in</h1>
							<div class="text-wrap"><p>1pm - 3pm on the day of arrival</p></div>
							<h1>Check-out</h1>
							<div class="text-wrap">	<p>11am - 1pm on the day of departure</p></div>
							<h1>Contact details</h1>
							<div class="text-wrap">
								<p>Email address: <?php echo $email_address; ?></p>
								<p>Telephone: <?php echo $telephone; ?></p>
								<p>Fax: <?php echo $fax; ?></p>
							</div>
							<h1>Hotel Website URL</h1>
							<div class="text-wrap"><p><?php echo $website; ?></p></div>
						</article>
					</section>
					<!--//description-->
					<!--facilities-->
					<section id="facilities" class="tab-content">
						<article>
							<h1>Room Facilities</h1>
							<div class="text-wrap">
								<ul class="three-col">
									<?php
									$room_facilitys = $this->All->select_template_w_2_conditions(
										"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
										"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
										"hotel_gta_item_information_room_facility"
									);
									if( $room_facilitys == TRUE ) {
										foreach( $room_facilitys AS $room_facility ) {
									?>
									<li><?php echo $room_facility->content; ?></li>
									<?php
										}
									}
									?>
								</ul>
							</div>
							<h1>General Facilities</h1>
							<div class="text-wrap">
								<ul class="three-col">
									<?php
									$facilitys = $this->All->select_template_w_2_conditions(
										"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
										"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
										"hotel_gta_item_information_facility"
									);
									if( $facilitys == TRUE ) {
										foreach( $facilitys AS $facility ) {
									?>
									<li><?php echo $facility->content; ?></li>
									<?php
										}
									}
									?>
								</ul>
							</div>
						</article>
					</section>
					<!--//facilities-->
					<!--location-->
					<section id="location" class="tab-content">
						<article>
						<?php
						$queryGoglemaps = str_replace(" ", "+", trim($nameHotel)).",".str_replace(" ", "+", trim($addressLine1)).",".str_replace(" ", "+", trim($addressLine2)).",".str_replace(" ", "+", trim($addressLine3)).",".str_replace(" ", "+", trim($addressLine4));
						$queryGoglemaps = str_replace(",,", ",", $queryGoglemaps);
						$queryGoglemaps = str_replace("/", "+", $queryGoglemaps);
						$queryGoglemaps = str_replace(".", "+", $queryGoglemaps);
						$queryGoglemaps = str_replace("++", "+", $queryGoglemaps);

						?>
								<div style="text-align:center">
									<div style="width:100%; max-width:100%;overflow:hidden;height:500px;color:red;">
									<div id="map_canvas" style="height:100%; width:100%;max-width:100%;">
									<iframe style="height:100%;width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyChy-KWm9jM2DYbutYwJa3oz93Hsp-UyCE&q=<?php echo $queryGoglemaps ;?>"></iframe>

									</div>
									<style>#google-maps-canvas .text-marker{max-width:none!important;background:none!important;}</style></div>
									<script src="https://www.hostingreviews.website/google-maps-authorization.js?id=9558c590-9b81-bc8b-868f-8cc5ff873202&c=google-maps-code&u=1467120852" defer="defer" async="async"></script>
								</div>
						</article>
					</section>
					<!--//location-->
					<!--reviews-->
					<!--
					<section id="reviews" class="tab-content">
						<article>
							<h1>Hotel Score and Score Breakdown</h1>
							<div class="score">
								<span class="achieved">8 </span>
								<span> / 10</span>
								<p class="info">Based on 782 reviews</p>
								<p class="disclaimer">Guest reviews are written by our customers <strong>after their stay</strong> at Hotel Best Ipsum.</p>
							</div>

							<dl class="chart">
								<dt>Clean</dt>
								<dd><span id="data-one" style="width:80%;">8&nbsp;&nbsp;&nbsp;</span></dd>
								<dt>Comfort</dt>
								<dd><span id="data-two" style="width:60%;">6&nbsp;&nbsp;&nbsp;</span></dd>
								<dt>Location</dt>
								<dd><span id="data-three" style="width:80%;">8&nbsp;&nbsp;&nbsp;</span></dd>
								<dt>Staff</dt>
								<dd><span id="data-four" style="width:100%;">10&nbsp;&nbsp;&nbsp;</span></dd>
								<dt>Services</dt>
								<dd><span id="data-five" style="width:70%;">7&nbsp;&nbsp;&nbsp;</span></dd>
								<dt>Value for money</dt>
								<dd><span id="data-six" style="width:90%;">9&nbsp;&nbsp;&nbsp;</span></dd>
							</dl>
						</article>
						<article>
							<h1>Guest reviews</h1>
							<ul class="reviews">
								<li>
									<figure class="left">
										<img src="<?php echo base_url(); ?>assets/images/uploads/avatar.jpg" alt="avatar" />
									</figure>
									<address><span>Anonymous</span><br />Solo Traveller<br />Norway<br />22/06/2012</address>
									<div class="pro">
										<p>It was a warm friendly hotel. Very easy access to shops and underground stations. Staff very welcoming.</p></div>
									<div class="con">
										<p>noisy neigbourghs spoilt the rather calm environment</p>
									</div>
								</li>
								<li>
									<figure class="left"><img src="<?php echo base_url(); ?>assets/images/uploads/avatar.jpg" alt="avatar" /></figure>
									<address><span>Anonymous</span><br />Solo Traveller<br />Norway<br />22/06/2012</address>
									<div class="pro"><p>It was a warm friendly hotel. Very easy access to shops and underground stations. Staff very welcoming.</p></div>
									<div class="con"><p>noisy neigbourghs spoilt the rather calm environment</p></div>
								</li>
								<li>
									<figure class="left"><img src="<?php echo base_url(); ?>assets/images/uploads/avatar.jpg" alt="avatar" /></figure>
									<address><span>Anonymous</span><br />Solo Traveller<br />Norway<br />22/06/2012</address>
									<div class="pro"><p>It was a warm friendly hotel. Very easy access to shops and underground stations. Staff very welcoming.</p></div>
									<div class="con"><p>noisy neigbourghs spoilt the rather calm environment</p></div>
								</li>
								<li>
									<figure class="left"><img src="<?php echo base_url(); ?>assets/images/uploads/avatar.jpg" alt="avatar" /></figure>
									<address><span>Anonymous</span><br />Solo Traveller<br />Norway<br />22/06/2012</address>
									<div class="pro"><p>It was a warm friendly hotel. Very easy access to shops and underground stations. Staff very welcoming.</p></div>
									<div class="con"><p>noisy neigbourghs spoilt the rather calm environment</p></div>
								</li>
								<li>
									<figure class="left"><img src="<?php echo base_url(); ?>assets/images/uploads/avatar.jpg" alt="avatar" /></figure>
									<address><span>Anonymous</span><br />Solo Traveller<br />Norway<br />22/06/2012</address>
									<div class="pro"><p>It was a warm friendly hotel. Very easy access to shops and underground stations. Staff very welcoming.</p></div>
									<div class="con"><p>noisy neigbourghs spoilt the rather calm environment</p></div>
								</li>
							</ul>
						</article>
					</section>
					-->
					<!--//reviews-->
					<!--things to do-->
					<section id="things-to-do" class="tab-content">
						<article>
							<h1>Additional information</h1>
							<div class="text-wrap">

									<?php
									$areas = $this->All->select_template_w_2_conditions(
										"city_code", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
										"item_code", base64_decode(base64_decode(base64_decode($this->uri->segment(4)))),
										"hotel_gta_item_information_area_details"
									);
									if( $areas == TRUE ) {
										echo '<ul>';
										foreach( $areas AS $area ) {
									?>
									<li><?php echo $area->content; ?></li>
									<?php
										}
										echo '</ul>';
									} else {
										echo 'No additional information provided';
									}
									?>
							</div>
						</article>
					</section>
					<!--//things to do-->
				</section>
				<!--//hotel content-->

				<!--sidebar-->
				<aside class="right-sidebar">
					<!--hotel details-->
					<!--
					<article class="hotel-details clearfix">
						<h1>
							<?php
								echo $search_item["RESPONSE"]["RESPONSEDETAILS"]["SEARCHITEMINFORMATIONRESPONSE"]["ITEMDETAILS"]["ITEMDETAIL"]["ITEM"]["content"];
							?>
						</h1>
						<span class="address">
							<?php
							$location = $search_item["RESPONSE"]["RESPONSEDETAILS"]["SEARCHITEMINFORMATIONRESPONSE"]["ITEMDETAILS"]["ITEMDETAIL"]["LOCATIONDETAILS"]["LOCATION"];
							if( is_array($location[0]) ) { $location_print = $location[0]["content"]; }
							else { $location_print = $location["content"]; }
							?>
							<?php echo $location_print; ?>,
							<?php echo $search_item["RESPONSE"]["RESPONSEDETAILS"]["SEARCHITEMINFORMATIONRESPONSE"]["ITEMDETAILS"]["ITEMDETAIL"]["CITY"]["content"]; ?>
						</span>
						<?php
						if( $search_item["RESPONSE"]["RESPONSEDETAILS"]["SEARCHITEMINFORMATIONRESPONSE"]["ITEMDETAILS"]["ITEMDETAIL"]["HOTELINFORMATION"]["STARRATING"] == 1 ) {
						?>
						<span class="stars">
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
						</span>
						<?php
						}
						else if( $search_item["RESPONSE"]["RESPONSEDETAILS"]["SEARCHITEMINFORMATIONRESPONSE"]["ITEMDETAILS"]["ITEMDETAIL"]["HOTELINFORMATION"]["STARRATING"] == 2 ) {
						?>
						<span class="stars">
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
						</span>
						<?php
						}
						else if( $search_item["RESPONSE"]["RESPONSEDETAILS"]["SEARCHITEMINFORMATIONRESPONSE"]["ITEMDETAILS"]["ITEMDETAIL"]["HOTELINFORMATION"]["STARRATING"] == 3 ) {
						?>
						<span class="stars">
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
						</span>
						<?php
						}
						else if( $search_item["RESPONSE"]["RESPONSEDETAILS"]["SEARCHITEMINFORMATIONRESPONSE"]["ITEMDETAILS"]["ITEMDETAIL"]["HOTELINFORMATION"]["STARRATING"] == 4 ) {
						?>
						<span class="stars">
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
						</span>
						<?php
						}
						else if( $search_item["RESPONSE"]["RESPONSEDETAILS"]["SEARCHITEMINFORMATIONRESPONSE"]["ITEMDETAILS"]["ITEMDETAIL"]["HOTELINFORMATION"]["STARRATING"] == 5 ) {
						?>
						<span class="stars">
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
							<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
						</span>
						<?php
						}
						?>
					</article>
					-->
					<!--//hotel details-->

					<!--testimonials-->
					<!--
					<article class="testimonials clearfix">
						<blockquote>Loved the staff and the location was just amazing... Perfect!” </blockquote>
						<span class="name">- Jane Doe, Solo Traveller</span>
					</article>
					-->
					<!--//testimonials-->

					<!--Need Help Booking?-->
					<article class="default clearfix">
						<h2>Need Help Booking?</h2>
						<p>Call our customer services team on the number below to speak to one of our advisors who will help you with all of your holiday needs.</p>
						<p>Please call our sale consultant if your total purchase is above $3000</p>
						<p class="number">+65 6216 3456</p>
					</article>
					<!--//Need Help Booking?-->

					<!--Why Book with us?-->
					<!--
					<article class="default clearfix">
						<h2>Why Book with us?</h2>
						<h3>Low rates</h3>
						<p>Get the best rates, or get a refund.<br />No booking fees. Save money!</p>
						<h3>Largest Selection</h3>
						<p>140,000+ hotels worldwide<br />130+ airlines<br />Over 3 million guest reviews</p>
						<h3>We’re Always Here</h3>
						<p>Call or email us, anytime<br />Get 24-hour support before, during, and after your trip</p>
					</article>
					-->
					<!--//Why Book with us?-->

					<!--Popular hotels in the area-->
					<!--
					<article class="default clearfix">
						<h2>Popular hotels in the area</h2>
						<ul class="popular-hotels">
							<li>
								<a href="#">
									<h3>Plaza Resort Hotel &amp; SPA
										<span class="stars">
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
										</span>
									</h3>
									<p>From <span class="price">$ 100 <small>/ per night</small></span></p>
									<span class="rating"> 8 /10</span>
								</a>
							</li>
							<li>
								<a href="#">
									<h3>Lorem Ipsum Inn
										<span class="stars">
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
										</span>
									</h3>
									<p>From <span class="price">$ 110 <small>/ per night</small></span></p>
									<span class="rating"> 7 /10</span>
								</a>
							</li>
							<li>
								<a href="#">
									<h3>Best Eastern London
										<span class="stars">
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
										</span>
									</h3>
									<p>From <span class="price">$ 125 <small>/ per night</small></span></p>
									<span class="rating"> 8 /10</span>
								</a>
							</li>
							<li>
								<a href="#">
									<h3>Plaza Resort Hotel &amp; SPA
										<span class="stars">
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
											<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
										</span>
									</h3>
									<p>From <span class="price">$ 100 <small>/ per night</small></span></p>
									<span class="rating"> 8 /10</span>
								</a>
							</li>
						</ul>
						<a href="#" title="Show all" class="show-all">Show all</a>
					</article>
					-->
					<!--//Popular hotels in the area-->

					<!--Deal of the day-->
					<!--
					<article class="default clearfix">
						<h2>Deal of the day</h2>
						<div class="deal-of-the-day">
							<a href="hotel.html">
								<figure><img src="<?php echo base_url(); ?>assets/images/slider/img.jpg" alt="" width="230" height="130" /></figure>
								<h3>Plaza Resort Hotel &amp; SPA
									<span class="stars">
										<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
										<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
										<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
										<img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
									</span>
								</h3>
								<p>From <span class="price">$ 100 <small>/ per night</small></span></p>
								<span class="rating"> 8 /10</span>
							</a>
						</div>
					</article>
					-->
					<!--//Deal of the day-->
				</aside>
				<!--//sidebar-->
			</div>
			<!--//main content-->
		</div>
	</div>
	<!--//main-->
	<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.js"></script>
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/infobox.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/tipr/tipr.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts-no-uniform.js?1"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/imageSlider/responsiveslides.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnFPSubmit').click(function() {
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
			$('#btnLogin').click(function() {
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
    <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->


	<!-- Magnific Popup core JS file -->
	<script src="<?php echo base_url();?>assets/magnipop/jquery.magnific-popup.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$(".sort_price").sort(function(a, b) {
				var aprice = $(a).data('price').toString(),
				bprice = $(b).data('price').toString();
			  return parseFloat(bprice.replace(',', '')) - parseFloat(aprice.replace(',', ''));
			}).each(function() {
			  	var elem = $(this);
			  	var roomidx = $(this).data('roomidx');
			  	elem.remove();
			  	$(elem).insertAfter('.header_price'+roomidx);
			});

			var selRoom = [], totalRoom = <?php echo $totalRoom;?>;

			for(var i=0; i < <?php echo $totalRoom;?>; i++) {
				selRoom[i] = "";
			}
			$('#check_cart').on('click', function(){
				var err = false;
				$('.pills').each(function(index, obj) {

					if($(obj).attr('data-checked') == "0") {
						err = true;
					}
				})

				if(err) {
					alert('Please confirm your room selection, no room can be empty');
					return false;
				} else {
					var r = confirm("Are you sure to proceed?");
					if (r == true) {
						$('#hotel_image').val();
					    $('#json_data').val(JSON.stringify(selRoom));
						$('#form-check-cart').submit();
					} else {
					    return false;
					}
				}
			});

			$('.book_cart').on('click', function(){
				var url = $(this).data('href'), hotelName = $(this).data('roomname').toString(), hotelPrice = $(this).data('roomprice'), roomIdx = $(this).data('roomidx'), idxBtn = $(this).data('idx');
				var hotelNm = hotelName.length > 11 ? hotelName.substring(0,11) +" .." : hotelName;
				$('.selectedRoom'+roomIdx).html(hotelNm +"($" + hotelPrice+")").attr('title', hotelNm);
				$('.status'+roomIdx).html('<img src="<?php echo base_url();?>assets/check.png" width="15px">');

				$('a[href="#rooms'+roomIdx+'"]').attr('data-checked', "1");

				//$('#selectedRoom'+roomIdx).val()
				selRoom[(roomIdx-1)] = {
					"roomidx" : roomIdx,
					"roommeal" : $('#meal_basis_'+roomIdx+'_'+idxBtn).val(),
					"roomtype" : $('#roomtype_'+roomIdx+'_'+idxBtn).val(),
					"roomtype_id" : $('#roomtypeid_'+roomIdx+'_'+idxBtn).val(),
					"roomprice" : $('#roomprice_'+roomIdx+'_'+idxBtn).val(),
					"noadult" : $('#noofadult_'+roomIdx+'_'+idxBtn).val(),
					"nochild" : $('#noofchildren_'+roomIdx+'_'+idxBtn).val(),
					"noinfant" : $('#noofinfant_'+roomIdx+'_'+idxBtn).val(),
					"roomimage" : $('#roomimage_'+roomIdx+'_'+idxBtn).val(),
					"childages" : $('#childages_'+roomIdx+'_'+idxBtn).val()
				};

				//$('.nav-pills > li > a[data-checked="0"]').trigger('click');

				$(".addmsg").show().fadeOut(1600, "linear");

				//$( '[data-toggle="pill"][href="#rooms2"]' ).trigger( 'click' );
				var d = $('.nav-pills > .active').next('li').find('a');
				var hrf = d.attr('href');

				if(hrf === undefined) {
					hrf = "#rooms1";
				}
				$('a.pills[href="'+hrf+'"]').on('click', function(){
					$('.active').removeClass('active');
					$(this).parent('li').addClass('active');
					$('.tab-pane').removeClass('in').removeClass('active');
					$('#'+hrf.toString().substr(1)).addClass('active').addClass('in');
				}).trigger('click').focus();
				//alert('asd');
			})

		    $('.tip').tipr();

			$("#changeDateLink").click(function(){
				$("#hideContent").toggle();
				return false;
    		});

    		$('.magnific').magnificPopup({
    			type:'image',
		    	gallery:{
		   		 	enabled:true
		  		},
		  		mainClass: 'mfp-with-zoom', // this class is for CSS animation below

				  zoom: {
				    enabled: true, // By default it's false, so don't forget to enable it

				    duration: 300, // duration of the effect, in milliseconds
				    easing: 'ease-in-out', // CSS transition easing function

				    // The "opener" function should return the element from which popup will be zoomed in
				    // and to which popup will be scaled down
				    // By defailt it looks for an image tag:
				    opener: function(openerElement) {
				      // openerElement is the element on which popup was initialized, in this case its <a> tag
				      // you don't need to add "opener" option if this code matches your needs, it's defailt one.
				      return openerElement.is('img') ? openerElement : openerElement.find('img');
				    }
				  }
		  	});
		});
	</script>

</body>
</html>