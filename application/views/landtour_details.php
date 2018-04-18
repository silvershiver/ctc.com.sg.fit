<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CTC Travel | Land Tour Details</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css?<?php echo uniqid(); ?>" type="text/css"
		media="screen,projection,print" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/tipr/tipr.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/imageSlider/slider.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/newcruise.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fontawesome.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/newtable.css" type="text/css" />
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
		.form_div {
			margin: 20px 0 20px 0;
		}
		.traveller_info_form>div>div>div>div {
		    width: 230px;
		    float: left;
		    font-weight: bold;
		}
	</style>
	<style>
		h5 { color: #F7941D !important; } .fontSizeAdjust { font-size: 15px }
	</style>
	<style>
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
		label.dropdown select:-moz-focusring {
			color: transparent;
			text-shadow: 0 0 0 #444;
		}
		label.dropdown select::-ms-expand {
			display: none;
		}
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
	</style>
	<style>
		.event a {
			background-color: #42B373 !important;
			background-image :none !important;
			color: #ffffff !important;
		}
		.infoCSS ul li {
			list-style-type: disc;
			margin-left: 25px;
		}

		.reset-this {
		    html, body, div, span, applet, object, iframe,
			h1, h2, h3, h4, h5, h6, blockquote, pre,
			a, abbr, acronym, address, big, cite, code,
			del, dfn, em, img, ins, kbd, q, s, samp,
			small, strike, strong, sub, sup, tt, var,
			b, u, i, center,
			dl, dt, dd, ol, ul, li,
			fieldset, form, label, legend,
			table, caption, tbody, tfoot, thead, tr, th, td,
			article, aside, canvas, details, embed,
			figure, figcaption, footer, header, hgroup,
			menu, nav, output, ruby, section, summary,
			time, mark, audio, video {
				margin: 0;
				padding: 0;
				border: 0;
				font-size: 100%;
				font: inherit;
				vertical-align: baseline;
			}
			/* HTML5 display-role reset for older browsers */
			article, aside, details, figcaption, figure,
			footer, header, hgroup, menu, nav, section {
				display: block;
			}
			body {
				line-height: 1;
				font-size: 1.3em !important;
			}
			ol, ul {
				list-style: none;
			}
			blockquote, q {
				quotes: none;
			}
			blockquote:before, blockquote:after,
			q:before, q:after {
				content: '';
				content: none;
			}
			table {
				border-collapse: collapse;
				border-spacing: 0;
			}
			p {

			}
		}
		.reset-this > p {
			font-size: 1.3em;
			padding: 0 !important;
			display: inline-block;
			line-height: 25px !important;
		}
		.reset-this > ul {
			font-size: 1.3em !important;
			line-height: 21px !important;
		}
	</style>
</head>
<body>
	<?php require_once(APPPATH."views/master-frontend/header.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>
	<?php
	$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$cob = "";
	$details = $this->All->select_template("slug_url", $this->uri->segment(3), "landtour_product");
	if( $details == TRUE ) {
		foreach( $details AS $detail ) {
			$ltID	   		= $detail->id;
			$lt_tourID 		= $detail->lt_tourID;
			$lt_title  		= $detail->lt_title;
			$lt_category_id = $detail->lt_category_id;
			$lt_hightlight  = $detail->lt_hightlight;
			$lt_itinerary   = $detail->lt_itinerary;
			$start_country  = $detail->start_country;
			$start_city     = $detail->start_city;
			$start_date     = $detail->start_date;
			$end_country    = $detail->end_country;
			$end_city   	= $detail->end_city;
			$end_date   	= $detail->end_date;
			$location		= $detail->location;
		}
	}
	$childWithBed = FALSE;
	$prices = $this->All->select_template("landtour_product_id", $ltID, "landtour_system_prices");
	if( $prices == TRUE ) {
		foreach( $prices AS $price ) {
			$cob = $price->child_wb_price;
		}
	}
	if( $cob != NULL ) {
		$childWithBed = TRUE;
	}
	else {
		$childWithBed = FALSE;
	}
	?>
	<div class="main" role="main">
		<div class="wrap clearfix">
			<!--main content-->
			<div class="content clearfix">
				<!--BREADCUMBS-->
				<nav role="navigation" class="breadcrumbs clearfix">
					<ul class="crumbs">
						<li style="margin-left:0px; font-size:1.3em"><a href="#" title="">You are here:</a></li>
						<li style="margin-left:0px; font-size:1.3em">
							<a href="<?php echo base_url(); ?>" title="">Home</a>
						</li>
						<li style="margin-left:0px; font-size:1.3em">
							<a href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>">Land Tour</a>
						</li>
						<li style="margin-left:0px; font-size:1.3em">
							<a href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>">Details</a>
						</li>
					</ul>
				</nav>
				<!--END OF BREADCUMBS-->
				<!--Land tour three-fourth content-->
				<section class="three-fourth">
					<!--IMAGE SLIDER-->
					<div class="rslides_container">
						<ul class="rslides" id="slides1" style="height:450px">
							<?php
							$images = $this->All->select_template("landtour_product_id", $ltID, "landtour_image");
							if( $images == TRUE ) {
								foreach( $images AS $image ) {
							?>
							<li style="list-style-type:none; margin-left:0px; width:850px; height: 450px">
						  		<img src="<?php echo base_url()."assets/landtour_img/".$image->file_name; ?>" style="width:850px; height: 450px" />
						  	</li>
							<?php
								}
							}
							?>
						</ul>
					</div>
					<!--END OF IMAGE SLIDER-->
					<!--INFO DETAILS-->
					<section id="infodetails" class="tab-content" style="width:100%; margin-top:0px">
						<article>
							<div><h1>Land Tour Itinerary Details</h1></div>
							<div>
								<h5><i class="fa fa-heart"></i> &nbsp;Title</h5>
								<p class="fontSizeAdjust">
									<?php echo $lt_title; ?> (<?php echo $lt_tourID; ?>)
									-
									(Category: <?php echo $this->All->getLandtourCategoryName($lt_category_id); ?>)
								</p>
							</div>
							<div class="infoCSS">
								<h5><i class="fa fa-info-circle"></i> &nbsp;Info Highlight</h5>
								<p class="fontSizeAdjust" style="text-align:justify; margin-top:-20px">
									<!--<div style="font-size:14px; font-family:'Helvetica Neue'; font-weight:normal">-->
									<div class="reset-this">
										<?php echo html_entity_decode($lt_hightlight); ?>
									</div>
								</p>
							</div>
							<div class="infoCSS">
								<h5><i class="fa fa-info-circle"></i> &nbsp;Itinerary</h5>
								<?php
								$listItinerarys = $this->All->select_template_with_where_and_order(
									"landtour_product_id", $ltID, "itinerary_day_no", "ASC", "landtour_itinerary"
								);
								if( $listItinerarys == TRUE ) {
									foreach( $listItinerarys AS $listItinerary ) {
								?>
								<!--
								<p class="fontSizeAdjust" style="text-align:justify; font-size:14px; font-family:'Helvetica Neue'">
								-->
									<p>
										<b>
											Day <?php echo $listItinerary->itinerary_day_no; ?>:
											<?php echo $listItinerary->itinerary_title; ?>
										</b>
										<br />
										<div><?php echo $listItinerary->itinerary_desc; ?></div>
										<?php
										if( $listItinerary->itinerary_extra_info != NULL ) {
										?>
											<br />
											<span><?php echo $listItinerary->itinerary_extra_info; ?></span>
										<?php
										}
										?>
									</p>
								<?php
									}
								}
								else {
								?>
									<!--
									<p class="fontSizeAdjust" style="text-align:justify; font-size:14px; font-family:'Helvetica Neue'">
									-->
									<p>
										No itinerary available
									</p>
								<?php
								}
								?>
							</div>


<!--DEPARTURES & PRICES-->
<h1 id="pointerRefresh">Departures & Prices</h1>
<?php
	$noadult  		  = 1;
	$nochild  		  = 0;
	$noinfant 		  = 0;
	$arrayDates 	  = $this->All->date_range_newFormatRoom($ltID);
	$arrayDateTickets = $this->All->date_range_newFormatTicket($ltID);
	$arrayTypes 	  = $this->All->getSellingType_landtourID($ltID);
	$roomType 		  = $this->All->trueFalseShowRoomType($ltID);
	$ticketType 	  = $this->All->trueFalseShowTicketType($ltID);
?>
<div style="margin-bottom:15px">
	<?php
	if( $this->uri->segment(4) == TRUE ) {
	?>
		<?php
		if( $this->uri->segment(4) == "room" ) {
		?>
			<?php
			if( $roomType == "TRUE" && $ticketType == "TRUE" ) {
			?>
				<div style="float:left; width:175px; text-align:left">
					<div style="font-size:12px; padding:8px; background-color:#41C0B8; width:140px">
						<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/room#pointerRefresh">Show room price
						</a>
					</div>
				</div>
				<div style="float:left; width:175px; text-align:left">
					<div style="font-size:12px; padding:8px; background-color:#F7941D; width:140px">
						<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/ticket#pointerRefresh">Show ticket price
						</a>
					</div>
				</div>
			<?php
			}
			else if( $roomType == "TRUE" && $ticketType == "FALSE" ) {
			?>
				<div style="float:left; width:175px; text-align:left">
					<div style="font-size:12px; padding:8px; background-color:#41C0B8; width:140px">
						<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/room#pointerRefresh">Show room price
						</a>
					</div>
				</div>
			<?php
			}
			else if( $roomType == "FALSE" && $ticketType == "TRUE" ) {
			?>
				<div style="float:left; width:175px; text-align:left">
					<div style="font-size:12px; padding:8px; background-color:#41C0B8; width:140px">
						<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/ticket#pointerRefresh">Show ticket price
						</a>
					</div>
				</div>
			<?php
			}
			else { }
			?>
		<?php
		}
		else if( $this->uri->segment(4) == "ticket" ) {
		?>
			<?php
			if( $roomType == "TRUE" && $ticketType == "TRUE" ) {
			?>
				<div style="float:left; width:175px; text-align:left">
					<div style="font-size:12px; padding:8px; background-color:#F7941D; width:140px">
						<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/room#pointerRefresh">Show room price
						</a>
					</div>
				</div>
				<div style="float:left; width:175px; text-align:left">
					<div style="font-size:12px; padding:8px; background-color:#41C0B8; width:140px">
						<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/ticket#pointerRefresh">Show ticket price
						</a>
					</div>
				</div>
			<?php
			}
			else if( $roomType == "TRUE" && $ticketType == "FALSE" ) {
			?>
				<div style="float:left; width:175px; text-align:left">
					<div style="font-size:12px; padding:8px; background-color:#41C0B8; width:140px">
						<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/room#pointerRefresh">Show room price
						</a>
					</div>
				</div>
			<?php
			}
			else if( $roomType == "FALSE" && $ticketType == "TRUE" ) {
			?>
				<div style="float:left; width:175px; text-align:left">
					<div style="font-size:12px; padding:8px; background-color:#41C0B8; width:140px">
						<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/ticket#pointerRefresh">Show ticket price
						</a>
					</div>
				</div>
			<?php
			}
			else {}
			?>
		<?php
		}
		?>
	<?php
	}
	else {
	?>
		<?php
		if( $roomType == "TRUE" && $ticketType == "TRUE" ) {
		?>
			<div style="float:left; width:175px; text-align:left">
				<div style="font-size:12px; padding:8px; background-color:#41C0B8; width:140px">
					<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/room#pointerRefresh">Show room price
					</a>
				</div>
			</div>
			<div style="float:left; width:175px; text-align:left">
				<div style="font-size:12px; padding:8px; background-color:#F7941D; width:140px">
					<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/ticket#pointerRefresh">Show ticket price
					</a>
				</div>
			</div>
		<?php
		}
		else if( $roomType == "TRUE" && $ticketType == "FALSE" ) {
		?>
			<div style="float:left; width:175px; text-align:left">
				<div style="font-size:12px; padding:8px; background-color:#41C0B8; width:140px">
					<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/room#pointerRefresh">Show room price
					</a>
				</div>
			</div>
		<?php
		}
		else if( $roomType == "FALSE" && $ticketType == "TRUE" ) {
		?>
			<div style="float:left; width:175px; text-align:left">
				<div style="font-size:12px; padding:8px; background-color:#41C0B8; width:140px">
					<a style="color:white; padding:8px; font-size:15px; font-weight:bold; text-decoration:none; cursor:pointer" href="<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/ticket#pointerRefresh">Show ticket price
					</a>
				</div>
			</div>
		<?php
		}
		else if( $roomType == "FALSE" && $ticketType == "FALSE" ) {
		?>
			<div style="text-align:center; color:red; font-size:18px">
				No price available at the moment
			</div>
		<?php
		}
		?>
	<?php
	}
	?>
	<div style="clear:both"></div>
</div>
<?php
if( $this->uri->segment(4) == TRUE ) {
	if( $this->uri->segment(4) == "ticket" ) {
?>
		<div class='tab'>
			<?php echo $this->session->flashdata("errorEmptyQuantity"); ?>
			<?php echo $this->session->flashdata("errorInvalidQuantity"); ?>
			<table border='0' cellpadding='0' cellspacing='0' style="width:100%">
				<tr class='days afterPrice'>
					<th width="20%" style="text-align:center">
						<div style="font-size:12px">Departure Date</div>
					</th>
					<th width="30%" style="text-align:center">
						<div style="font-size:12px">Adult Ticket Price</div>
					</th>
					<th width="30%" style="text-align:center">
						<div style="font-size:12px">Child Ticket Price</div>
					</th>
					<th width="25%" style="text-align:center">
						<div style="font-size:12px">&nbsp;</div>
					</th>
				</tr>
				<?php
				if( $this->uri->segment(5) == TRUE ) {
					$priceTicketRes  = mysqli_query(
						$connection,
						"
							SELECT * FROM landtour_priceDate
							WHERE landtour_product_id = ".$ltID." AND selling_type = 'TICKET'
							AND priceDate = '".base64_decode(base64_decode(base64_decode($this->uri->segment(5))))."'
							ORDER BY priceDate ASC
						"
					);
				}
				else {
					$priceTicketRes  = mysqli_query(
						$connection,
						"
							SELECT * FROM landtour_priceDate
							WHERE landtour_product_id = ".$ltID." AND selling_type = 'TICKET'
							AND DATE(priceDate) >= '".date("Y-m-d", strtotime("+7 days"))."'
							ORDER BY priceDate ASC
						"
					);
				}
				if( mysqli_num_rows($priceTicketRes) > 0 ) {
					while( $priceTicketRow = mysqli_fetch_array($priceTicketRes, MYSQL_ASSOC) ) {
						//landtour_price
						$pricingSystems = $this->All->select_template_w_2_conditions(
							"landtour_product_id", $ltID,
							"price_date", $priceTicketRow["priceDate"],
							"landtour_system_prices"
						);
						if( $pricingSystems == TRUE ) {
							foreach( $pricingSystems AS $pricingSystem ) {
								$pID   			   = $pricingSystem->id;
								$pDate 			   = $pricingSystem->price_date;
								$pTicketAdultPrice = $pricingSystem->ticketAdultPrice;
								$pTicketChildPrice = $pricingSystem->ticketChildPrice;
							}
						}
						else {
							$pID   = "-";
							$pDate = "-";
							$pTicketAdultPrice = "-";
							$pTicketChildPrice = "-";
						}
						//end of landtour_price
				?>
				<?php echo form_open_multipart('landtour/saveTicketToCart'); ?>
				<input type="hidden" name="hidden_ticket_landtourID" value="<?php echo $ltID; ?>" />
				<input type="hidden" name="hidden_ticket_systemID" 	value="<?php echo $pID; ?>" />
				<input type="hidden" name="hidden_ticket_priceDate" value="<?php echo $pDate; ?>" />
				<input type="hidden" name="hidden_ticket_slug_url" 	value="<?php echo $this->uri->segment(3); ?>" />
				<tr>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo date("d/m/Y", strtotime($priceTicketRow["priceDate"])); ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php
						if( $pTicketAdultPrice == NULL || $pTicketAdultPrice == "-" ) {
						?>
							<span style="color:red; font-size:16px">
								<i>No price available<br />for this category</i>
							</span>
						<?php
						}
						else {
						?>
							<?php echo "$".$pTicketAdultPrice; ?>
							<br />
							<select name="form_adultTicket">
								<?php
								$q=10;
								for( $t=0; $t<$q; $t++ ) {
									if( $t == 1 ) {
								?>
									<option value="<?php echo $t; ?>"><?php echo $t; ?> Ticket</option>
								<?php
									}
									else {
								?>
									<option value="<?php echo $t; ?>"><?php echo $t; ?> Tickets</option>
								<?php
									}
								}
								?>
							</select>
						<?php
						}
						?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php
						if( $pTicketChildPrice == NULL || $pTicketChildPrice == "-" ) {
						?>
							<span style="color:red; font-size:16px">
								<i>No price available<br />for this category</i>
							</span>
						<?php
						}
						else {
						?>
							<?php echo "$".$pTicketChildPrice; ?>
							<br />
							<select name="form_childTicket">
								<?php
								$q=10;
								for( $t=0; $t<$q; $t++ ) {
									if( $t == 1 ) {
								?>
									<option value="<?php echo $t; ?>"><?php echo $t; ?> Ticket</option>
								<?php
									}
									else {
								?>
									<option value="<?php echo $t; ?>"><?php echo $t; ?> Tickets</option>
								<?php
									}
								}
								?>
							</select>
						<?php
						}
						?>
					</td>
					<td style="background:#eff0f1; text-align:center">
						<?php
						if( $pID == "-" ) {
						?>
							<!--ENQUIRY BUTTON IS HERE-->
						<?php
						}
						else {
						?>
							<input type="submit" class="gradient-button" value="Add to cart" />
						<?php
						}
						?>
					</td>
				</tr>
				<?php echo form_close(); ?>
				<?php
					}
				}
				else {
				?>
				<tr>
					<td colspan="4" style="background:#eff0f1; text-align:center; font-size:16px">
						<span style="color:red">No ticket found available</span>
					</td>
				</tr>
				<?php
				}
				?>
			</table>
		</div>
<?php
	}
	else if( $this->uri->segment(4) == "room" ) {
?>
		<div class='tab'>
			<table border='0' cellpadding='0' cellspacing='0' style="width:100%">
				<tr class='days afterPrice'>
					<th width="15%" style="text-align:center">
						<div style="font-size:12px">Departure<br />Date</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Adult<br />Single</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Adult<br />Twin</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Adult<br />Triple</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Child<br />with Bed</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Child<br />w/o Bed</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Child<br />Half Twin</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Infant</div>
					</th>
					<th width="15%" style="text-align:center">
						<div style="font-size:12px">&nbsp;</div>
					</th>
				</tr>
				<?php
				$pricingDatesRes  = mysqli_query(
					$connection,
					"
						SELECT * FROM landtour_priceDate
						WHERE landtour_product_id = ".$ltID." AND selling_type = 'ROOM'
						AND DATE(priceDate) >= '".date("Y-m-d", strtotime("+7 days"))."'
						ORDER BY priceDate ASC
					"
				);
				if( mysqli_num_rows($pricingDatesRes) > 0 ) {
					while( $pricingDatesRow = mysqli_fetch_array($pricingDatesRes, MYSQL_ASSOC) ) {
						//landtour_price
						$pricingSystems = $this->All->select_template_w_2_conditions(
							"landtour_product_id", $ltID,
							"price_date", $pricingDatesRow["priceDate"],
							"landtour_system_prices"
						);
						if( $pricingSystems == TRUE ) {
							foreach( $pricingSystems AS $pricingSystem ) {
								$pID   			   = $pricingSystem->id;
								$pDate 			   = $pricingSystem->price_date;
								$pAdultSinglePrice = $pricingSystem->adultSingle_price;
								$pAdultTwinPrice   = $pricingSystem->adultTwin_price;
								$pAdultTriplePrice = $pricingSystem->adultTriple_price;
								$pChildWBPrice 	   = $pricingSystem->child_wb_price;
								$pChildWOBPrice    = $pricingSystem->child_wob_price;
								$pChildHalfPrice   = $pricingSystem->child_half_twin_price;
								$pInfantPrice 	   = $pricingSystem->infant_price;
							}
						}
						else {
							$pID 			   = "-";
							$pDate 			   = "-";
							$pAdultSinglePrice = "-";
							$pAdultTwinPrice   = "-";
							$pAdultTriplePrice = "-";
							$pChildWBPrice 	   = "-";
							$pChildWOBPrice    = "-";
							$pChildHalfPrice   = "-";
							$pInfantPrice 	   = "-";
						}
						//end of landtour_price
				?>
				<tr>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo date("d/m/Y", strtotime($pricingDatesRow["priceDate"])); ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pAdultSinglePrice != NULL) ? "$".$pAdultSinglePrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pAdultTwinPrice != NULL) ? "$".$pAdultTwinPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pAdultTriplePrice != NULL) ? "$".$pAdultTriplePrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pChildWBPrice != NULL) ? "$".$pChildWBPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pChildWOBPrice != NULL) ? "$".$pChildWOBPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pChildHalfPrice != NULL) ? "$".$pChildHalfPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pInfantPrice != NULL) ? "$".$pInfantPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center">
						<?php
						if( $pID == "-" ) {
						?>
							<!--ENQUIRY BUTTON IS HERE-->
						<?php
						}
						else {
						?>
							<a href="<?php echo base_url(); ?>landtour/second_details/<?php echo base64_encode(base64_encode(base64_encode($ltID))); ?>/<?php echo base64_encode(base64_encode(base64_encode($pID))); ?>/<?php echo base64_encode(base64_encode(base64_encode("room"))); ?>" class="gradient-button" style="border:none">Book</a>
						<?php
						}
						?>
					</td>
				</tr>
				<?php
					}
				}
				else {
				?>
				<tr>
					<td colspan="9" style="background:#eff0f1; text-align:center; font-size:16px">
						<span style="color:red">No room found available</span>
					</td>
				</tr>
				<?php
				}
				?>
			</table>
		</div>
<?php
	}
}
else {
?>
	<?php
	if( $roomType == "TRUE" && $ticketType == "TRUE" ) {
	?>
		<div class='tab'>
			<table border='0' cellpadding='0' cellspacing='0' style="width:100%">
				<tr class='days afterPrice'>
					<th width="15%" style="text-align:center">
						<div style="font-size:12px">Departure<br />Date</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Adult<br />Single</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Adult<br />Twin</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Adult<br />Triple</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Child<br />with Bed</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Child<br />w/o Bed</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Child<br />Half Twin</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Infant</div>
					</th>
					<th width="15%" style="text-align:center">
						<div style="font-size:12px">&nbsp;</div>
					</th>
				</tr>
				<?php
				$pricingDatesRes  = mysqli_query(
					$connection,
					"
						SELECT * FROM landtour_priceDate
						WHERE landtour_product_id = ".$ltID." AND selling_type = 'ROOM'
						AND DATE(priceDate) >= '".date("Y-m-d", strtotime("+7 days"))."'
						ORDER BY priceDate ASC
					"
				);
				if( mysqli_num_rows($pricingDatesRes) > 0 ) {
					while( $pricingDatesRow = mysqli_fetch_array($pricingDatesRes, MYSQL_ASSOC) ) {
						//landtour_price
						$pricingSystems = $this->All->select_template_w_2_conditions(
							"landtour_product_id", $ltID,
							"price_date", $pricingDatesRow["priceDate"],
							"landtour_system_prices"
						);
						if( $pricingSystems == TRUE ) {
							foreach( $pricingSystems AS $pricingSystem ) {
								$pID   			   = $pricingSystem->id;
								$pDate 			   = $pricingSystem->price_date;
								$pAdultSinglePrice = $pricingSystem->adultSingle_price;
								$pAdultTwinPrice   = $pricingSystem->adultTwin_price;
								$pAdultTriplePrice = $pricingSystem->adultTriple_price;
								$pChildWBPrice 	   = $pricingSystem->child_wb_price;
								$pChildWOBPrice    = $pricingSystem->child_wob_price;
								$pChildHalfPrice   = $pricingSystem->child_half_twin_price;
								$pInfantPrice 	   = $pricingSystem->infant_price;
							}
						}
						else {
							$pID 			   = "-";
							$pDate 			   = "-";
							$pAdultSinglePrice = "-";
							$pAdultTwinPrice   = "-";
							$pAdultTriplePrice = "-";
							$pChildWBPrice 	   = "-";
							$pChildWOBPrice    = "-";
							$pChildHalfPrice   = "-";
							$pInfantPrice 	   = "-";
						}
						//end of landtour_price
				?>
				<tr>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo date("d/m/Y", strtotime($pricingDatesRow["priceDate"])); ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pAdultSinglePrice != NULL) ? "$".$pAdultSinglePrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pAdultTwinPrice != NULL) ? "$".$pAdultTwinPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pAdultTriplePrice != NULL) ? "$".$pAdultTriplePrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pChildWBPrice != NULL) ? "$".$pChildWBPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pChildWOBPrice != NULL) ? "$".$pChildWOBPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pChildHalfPrice != NULL) ? "$".$pChildHalfPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pInfantPrice != NULL) ? "$".$pInfantPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center">
						<?php
						if( $pID == "-" ) {
						?>
							<!--ENQUIRY BUTTON IS HERE-->
						<?php
						}
						else {
						?>
							<a href="<?php echo base_url(); ?>landtour/second_details/<?php echo base64_encode(base64_encode(base64_encode($ltID))); ?>/<?php echo base64_encode(base64_encode(base64_encode($pID))); ?>/<?php echo base64_encode(base64_encode(base64_encode("room"))); ?>" class="gradient-button" style="border:none">Book</a>
						<?php
						}
						?>
					</td>
				</tr>
				<?php
					}
				}
				else {
				?>
				<tr>
					<td colspan="9" style="background:#eff0f1; text-align:center; font-size:16px">
						<span style="color:red">No room found available</span>
					</td>
				</tr>
				<?php
				}
				?>
			</table>
		</div>
	<?php
	}
	else if( $roomType == "TRUE" && $ticketType == "FALSE" ) {
	?>
		<div class='tab'>
			<table border='0' cellpadding='0' cellspacing='0' style="width:100%">
				<tr class='days afterPrice'>
					<th width="15%" style="text-align:center">
						<div style="font-size:12px">Departure<br />Date</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Adult<br />Single</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Adult<br />Twin</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Adult<br />Triple</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Child<br />with Bed</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Child<br />w/o Bed</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Child<br />Half Twin</div>
					</th>
					<th width="10%" style="text-align:center">
						<div style="font-size:12px">Infant</div>
					</th>
					<th width="15%" style="text-align:center">
						<div style="font-size:12px">&nbsp;</div>
					</th>
				</tr>
				<?php
				$pricingDatesRes  = mysqli_query(
					$connection,
					"
						SELECT * FROM landtour_priceDate
						WHERE landtour_product_id = ".$ltID." AND selling_type = 'ROOM'
						AND DATE(priceDate) >= '".date("Y-m-d", strtotime("+7 days"))."'
						ORDER BY priceDate ASC
					"
				);
				if( mysqli_num_rows($pricingDatesRes) > 0 ) {
					while( $pricingDatesRow = mysqli_fetch_array($pricingDatesRes, MYSQL_ASSOC) ) {
						//landtour_price
						$pricingSystems = $this->All->select_template_w_2_conditions(
							"landtour_product_id", $ltID,
							"price_date", $pricingDatesRow["priceDate"],
							"landtour_system_prices"
						);
						if( $pricingSystems == TRUE ) {
							foreach( $pricingSystems AS $pricingSystem ) {
								$pID   			   = $pricingSystem->id;
								$pDate 			   = $pricingSystem->price_date;
								$pAdultSinglePrice = $pricingSystem->adultSingle_price;
								$pAdultTwinPrice   = $pricingSystem->adultTwin_price;
								$pAdultTriplePrice = $pricingSystem->adultTriple_price;
								$pChildWBPrice 	   = $pricingSystem->child_wb_price;
								$pChildWOBPrice    = $pricingSystem->child_wob_price;
								$pChildHalfPrice   = $pricingSystem->child_half_twin_price;
								$pInfantPrice 	   = $pricingSystem->infant_price;
							}
						}
						else {
							$pID 			   = "-";
							$pDate 			   = "-";
							$pAdultSinglePrice = "-";
							$pAdultTwinPrice   = "-";
							$pAdultTriplePrice = "-";
							$pChildWBPrice 	   = "-";
							$pChildWOBPrice    = "-";
							$pChildHalfPrice   = "-";
							$pInfantPrice 	   = "-";
						}
						//end of landtour_price
				?>
				<tr>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo date("d/m/Y", strtotime($pricingDatesRow["priceDate"])); ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pAdultSinglePrice != NULL) ? "$".$pAdultSinglePrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pAdultTwinPrice != NULL) ? "$".$pAdultTwinPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pAdultTriplePrice != NULL) ? "$".$pAdultTriplePrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pChildWBPrice != NULL) ? "$".$pChildWBPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pChildWOBPrice != NULL) ? "$".$pChildWOBPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pChildHalfPrice != NULL) ? "$".$pChildHalfPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo ($pInfantPrice != NULL) ? "$".$pInfantPrice : "---"; ?>
					</td>
					<td style="background:#eff0f1; text-align:center">
						<?php
						if( $pID == "-" ) {
						?>
							<!--ENQUIRY BUTTON IS HERE-->
						<?php
						}
						else {
						?>
							<a href="<?php echo base_url(); ?>landtour/second_details/<?php echo base64_encode(base64_encode(base64_encode($ltID))); ?>/<?php echo base64_encode(base64_encode(base64_encode($pID))); ?>/<?php echo base64_encode(base64_encode(base64_encode("room"))); ?>" class="gradient-button" style="border:none">Book</a>
						<?php
						}
						?>
					</td>
				</tr>
				<?php
					}
				}
				else {
				?>
				<tr>
					<td colspan="9" style="background:#eff0f1; text-align:center; font-size:16px">
						<span style="color:red">No room found available</span>
					</td>
				</tr>
				<?php
				}
				?>
			</table>
		</div>
	<?php
	}
	else if( $roomType == "FALSE" && $ticketType == "TRUE" ) {
	?>
		<div class='tab'>
			<?php echo $this->session->flashdata("errorEmptyQuantity"); ?>
			<table border='0' cellpadding='0' cellspacing='0' style="width:100%">
				<tr class='days afterPrice'>
					<th width="20%" style="text-align:center">
						<div style="font-size:12px">Departure Date</div>
					</th>
					<th width="30%" style="text-align:center">
						<div style="font-size:12px">Adult Ticket Price</div>
					</th>
					<th width="30%" style="text-align:center">
						<div style="font-size:12px">Child Ticket Price</div>
					</th>
					<th width="25%" style="text-align:center">
						<div style="font-size:12px">&nbsp;</div>
					</th>
				</tr>
				<?php
				$priceTicketRes  = mysqli_query(
					$connection,
					"
						SELECT * FROM landtour_priceDate
						WHERE landtour_product_id = ".$ltID." AND selling_type = 'TICKET'
						AND DATE(priceDate) >= '".date("Y-m-d", strtotime("+7 days"))."'
						ORDER BY priceDate ASC
					"
				);
				if( mysqli_num_rows($priceTicketRes) > 0 ) {
					while( $priceTicketRow = mysqli_fetch_array($priceTicketRes, MYSQL_ASSOC) ) {
						//landtour_price
						$pricingSystems = $this->All->select_template_w_2_conditions(
							"landtour_product_id", $ltID,
							"price_date", $priceTicketRow["priceDate"],
							"landtour_system_prices"
						);
						if( $pricingSystems == TRUE ) {
							foreach( $pricingSystems AS $pricingSystem ) {
								$pID   			   = $pricingSystem->id;
								$pDate 			   = $pricingSystem->price_date;
								$pTicketAdultPrice = $pricingSystem->ticketAdultPrice;
								$pTicketChildPrice = $pricingSystem->ticketChildPrice;
							}
						}
						else {
							$pID   = "-";
							$pDate = "-";
							$pTicketAdultPrice = "-";
							$pTicketChildPrice = "-";
						}
						//end of landtour_price
				?>
				<?php echo form_open_multipart('landtour/saveTicketToCart'); ?>
				<input type="hidden" name="hidden_ticket_landtourID" value="<?php echo $ltID; ?>" />
				<input type="hidden" name="hidden_ticket_systemID" 	value="<?php echo $pID; ?>" />
				<input type="hidden" name="hidden_ticket_priceDate" value="<?php echo $pDate; ?>" />
				<input type="hidden" name="hidden_ticket_slug_url" 	value="<?php echo $this->uri->segment(3); ?>" />
				<tr>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php echo date("d/m/Y", strtotime($priceTicketRow["priceDate"])); ?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php
						if( $pTicketAdultPrice == NULL || $pTicketAdultPrice == "-" ) {
						?>
							<span style="color:red; font-size:16px">
								<i>No price available<br />for this category</i>
							</span>
						<?php
						}
						else {
						?>
							<?php echo "$".$pTicketAdultPrice; ?>
							<br />
							<select name="form_adultTicket">
								<?php
								$q=10;
								for( $t=0; $t<$q; $t++ ) {
									if( $t == 1 ) {
								?>
									<option value="<?php echo $t; ?>"><?php echo $t; ?> Ticket</option>
								<?php
									}
									else {
								?>
									<option value="<?php echo $t; ?>"><?php echo $t; ?> Tickets</option>
								<?php
									}
								}
								?>
							</select>
						<?php
						}
						?>
					</td>
					<td style="background:#eff0f1; text-align:center; font-size:16px">
						<?php
						if( $pTicketChildPrice == NULL || $pTicketChildPrice == "-" ) {
						?>
							<span style="color:red; font-size:16px">
								<i>No price available<br />for this category</i>
							</span>
						<?php
						}
						else {
						?>
							<?php echo "$".$pTicketChildPrice; ?>
							<br />
							<select name="form_childTicket">
								<?php
								$q=10;
								for( $t=0; $t<$q; $t++ ) {
									if( $t == 1 ) {
								?>
									<option value="<?php echo $t; ?>"><?php echo $t; ?> Ticket</option>
								<?php
									}
									else {
								?>
									<option value="<?php echo $t; ?>"><?php echo $t; ?> Tickets</option>
								<?php
									}
								}
								?>
							</select>
						<?php
						}
						?>
					</td>
					<td style="background:#eff0f1; text-align:center">
						<?php
						if( $pID == "-" ) {
						?>
							<!--ENQUIRY BUTTON IS HERE-->
						<?php
						}
						else {
						?>
							<input type="submit" class="gradient-button" value="Add to cart" />
						<?php
						}
						?>
					</td>
				</tr>
				<?php echo form_close(); ?>
				<?php
					}
				}
				else {
				?>
				<tr>
					<td colspan="4" style="background:#eff0f1; text-align:center; font-size:16px">
						<span style="color:red">No ticket found available</span>
					</td>
				</tr>
				<?php
				}
				?>
			</table>
		</div>
	<?php
	}
	else {
	?>

	<?php
	}
	?>
<?php
}
?>
<!--END OF DEPARTURES & PRICES-->


							<br />
							<!--
							<table class="table">
								<tbody>
									<tr style="text-align:center">
										<td style="border:1px solid grey; text-align:left">
											<div style="font-size:15px; margin-top:-10px">
												<b>Terms & Conditions</b>
											</div>
											<br />
											<ul style="font-size:11px; margin-left:18px">
												<li style="list-style-type:square; font-size:1.3em">
													All prices quoted are in Singapore Dollars
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													Highlighted row indicate discount is available
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													Prices do not include airport taxes, visa application and service fees, personal insurance, tipping, optional tours, personal expenses and all others not stated in the itinerary
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													All rates are subject to limited availability Itinerary and rates are subject to changes without prior notice
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													Peak season charges and all other relevant surcharges are not included
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													Tours and meals sequence are subject to changes without prior notice
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													Bookings must be made at least 7 working days prior to departure date
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													All bookings are subject to availability and confirmation
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													All extensions and deviations are strictly on request and are subject to seat availability, airline rules and regulations
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													Should there be an event of any discrepancies, prices at our retail counters will be taken as the final rate
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													Child Prices vary and are determined by : Child with bed (1 child sharing room with 2 adults); Child without bed ( 2 children sharing room with 2 adults, 1 child with bed & 1 child without bed); Child Half Twin (1 child sharing room with 1 adult)
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													For further enquiries on your travel programs, please contact CTC Online Travel Centre at 6216 3456 during office hours, or send us an email to enquiry@ctc.com.sg
												</li>
												<li style="list-style-type:square; font-size:1.3em">
													Alternatively, you may also contact our retail tour consultants at 6532 0532 or visit us at Chinatown Point #03-03/04/05/06 for any tour assistance required
												</li>
											</ul>
										</td>
									</tr>
								</tbody>
							</table>
							-->
						</article>
					</section>
					<!--end of info details-->
					<!--itinerary-->
					<section id="itinerary" class="tab-content">
						<article>
							<h1>Sailing itinerary information</h1>
							<div class="text-wrap">
								<table>
									<tr>
										<td style="width:120px">
											<div class="f-item">
												<label for="spinner6">Day</label>
											</div>
										</td>
										<td style="width:120px">
											<div class="f-item">
												<label for="spinner6">Port***</label>
											</div>
										</td>
										<td style="width:120px">
											<div class="f-item" style="text-align:center">
												<label for="spinner6">Arrive</label>
											</div>
										</td>
										<td style="width:120px">
											<div class="f-item" style="text-align:center">
												<label for="spinner7">Depart</label>
											</div>
										</td>
									</tr>
									<?php
									$itinerarys = $this->All->select_template(
										"CRUISE_TITLE_ID", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))),
										"cruise_itinerary"
									);
									if( $itinerarys == TRUE ) {
										foreach( $itinerarys AS $itinerary ) {
									?>
									<tr>
										<td style="width:120px">
											<label for="spinner6">Day <?php echo $itinerary->DAY; ?></label>
										</td>
										<td style="width:120px">
											<label for="spinner6"><?php echo $itinerary->PORT; ?></label>
										</td>
										<td style="width:120px">
											<div style="text-align:center"><?php echo $itinerary->ARRIVAL_TIME; ?></div>
										</td>
										<td style="width:120px">
											<div style="text-align:center"><?php echo $itinerary->DEPARTURE_TIME; ?></div>
										</td>
									</tr>
									<tr>
										<td colspan="4">
											<b>Remark:</b>
											<span><?php echo ($itinerary->REMARK == "") ? "---" : $itinerary->REMARK; ?></span>
										</td>
									</tr>
									<?php
										}
									}
									?>
								</table>
							</div>
						</article>
					</section>
					<!--end of itinerary-->
				</section>
				<!--//hotel content-->
				<!--SIDEBAR-->
				<aside class="right-sidebar">
					<!--Need Help Booking?-->
					<article class="default clearfix">
						<h2 style="text-align:center">Need Help Booking?</h2>
						<p>Call our customer services team on the number below to speak to one of our advisors who will help you with all of your holiday needs.</p>
						<p>Please call our sale consultant if your total purchase is above $3000</p>
						<p class="number">+65 6216-3456</p>
					</article>
					<!--//Need Help Booking?-->
					<!--Download itinerary-->
					<article class="default clearfix">
						<h2 style="text-align:center">Itinerary</h2>
						<p style="text-align:center">Download land tour itinerary below</p>
						<p style="text-align:center">
							<?php
							$pdfs = $this->All->select_template("landtour_id", $ltID, "landtour_pdf");
							if( $pdfs == TRUE ) {
								foreach( $pdfs AS $pdf ) {
									$pdf_file = $pdf->file_name;
								}
							?>
							<a href="<?php echo base_url(); ?>assets/landtour_pdf/<?php echo $pdf_file; ?>" class="gradient-button" target="_blank" style="border:none">Download</a>
							<?php
							}
							else {
							?>
							<span style="color:red"><b>No itinerary available</b></span>
							<?php
							}
							?>
						</p>
					</article>
					<!--End of download itinerary-->
					<!--Calendar date-->
					<article class="default clearfix">
						<h2 style="text-align:center">Calendar Date</h2>
						<?php
						if( $roomType == "TRUE" ) {
						?>
							<p style="text-align:center">Search available room date(s)</p>
							<p style="text-align:center">
								<div id="datepicker" style="margin-left:8px; margin-top:-15px"></div>
							</p>
						<?php
						}
						?>
						<?php
						if( $ticketType == "TRUE" ) {
						?>
							<br />
							<p style="text-align:center">Search available ticket date(s)</p>
							<p style="text-align:center">
								<div id="datepickerTicket" style="margin-left:8px; margin-top:-15px"></div>
							</p>
						<?php
						}
						?>
						<?php
						if( $roomType == "FALSE" && $ticketType == "FALSE" ) {
						?>
							<div style="color:red; text-align:center; font-size:1.3em"><b>No price available</b></div>
							<br />
						<?php
						}
						?>
					</article>
					<!--End of calendar date-->
				</aside>
				<!--END OF SIDEBAR-->
			</div>
		</div>
	</div>
	<?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/tipr/tipr.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts-no-uniform.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/imageSlider/responsiveslides.min.js"></script>
	<!--<script>selectnav('nav'); </script>-->
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
	<script type="text/javascript">
		$(document).ajaxStop( function() {
		     $('.tip').tipr();
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#changeDateLink").click(function(){
				$("#hideContent").toggle();
				return false;
    		});
		});
	</script>
	<script>
        $(function() {
			$(".rslides").responsiveSlides({
				auto: true,             // Boolean: Animate automatically, true or false
				speed: 500,            // Integer: Speed of the transition, in milliseconds
				timeout: 3000,          // Integer: Time between slide transitions, in milliseconds
				pager: true,           // Boolean: Show pager, true or false
				nav: true,             // Boolean: Show navigation, true or false
				random: false,          // Boolean: Randomize the order of the slides, true or false
				pause: true,           // Boolean: Pause on hover, true or false
				pauseControls: true,    // Boolean: Pause when hovering controls, true or false
				prevText: "Previous",   // String: Text for the "previous" button
				nextText: "Next",       // String: Text for the "next" button
				maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
				navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
				manualControls: "",     // Selector: Declare custom pager navigation
				namespace: "rslides",   // String: Change the default namespace used
				before: function(){},   // Function: Before callback
				after: function(){}     // Function: After callback
			});
  		});
    </script>
	<script type="text/javascript">
		$(function() {
			// Ticket available date(s)
			var ticketDates = {};
	        <?php
		    if( count($arrayDateTickets) > 0 ) {
				foreach( $arrayDateTickets AS $arrayDateTicket ) {
			?>
			ticketDates[ new Date( '<?php echo $arrayDateTicket; ?>' )] = new Date( '<?php echo $arrayDateTicket; ?>' );
			<?php
				}
			}
		    ?>
			$("#datepickerTicket").datepicker({
				onSelect: function () {
					var dateObject = $(this).datepicker('getDate');
					var dateFormat = btoa(btoa(btoa($.datepicker.formatDate('yy-mm-dd', dateObject))));
					var landtourID = "<?php echo base64_encode(base64_encode(base64_encode($ltID))); ?>";
					var ticket 	   = btoa(btoa(btoa("ticket")));
					window.location.href = "<?php echo base_url(); ?>landtour/details/<?php echo $this->uri->segment(3); ?>/ticket/"+dateFormat+"#pointerRefresh";
        		},
				beforeShowDay: function(date) {
					var highlight = ticketDates[date];
					if( highlight ) {
						return [true, "event", 'Click date for more details'];
            		}
            		else {
						return [false, '', ''];
            		}
        		}
			});
			// End of ticket available date(s)
			// Room available date(s)
	        var eventDates = {};
	        <?php
		    if( count($arrayDates) > 0 ) {
				foreach( $arrayDates AS $arrayDate ) {
			?>
			eventDates[ new Date( '<?php echo $arrayDate; ?>' )] = new Date( '<?php echo $arrayDate; ?>' );
			<?php
				}
			}
		    ?>
			$("#datepicker").datepicker({
				onSelect: function () {
					var dateObject = $(this).datepicker('getDate');
					var dateFormat = btoa(btoa(btoa($.datepicker.formatDate('yy-mm-dd', dateObject))));
					var landtourID = "<?php echo base64_encode(base64_encode(base64_encode($ltID))); ?>";
					var room 	   = btoa(btoa(btoa("room")));
					window.location.href = "<?php echo base_url(); ?>landtour/second_details/"+landtourID+"/"+dateFormat+"/"+room+"";
        		},
				beforeShowDay: function(date) {
					var highlight = eventDates[date];
					if( highlight ) {
						return [true, "event", 'Click date for more details'];
            		}
            		else {
						return [false, '', ''];
            		}
        		}
			});
			// End of room available date(s)
  		});
		$(document).ready(function() {

			//show and hide initial elements
			$("tr#choose_pax").show();
			//end of show and hide initial elements

			//for back button browser
			if( $("#landtourDateP").val() == "###" ) {
				$("tr#available_price").hide();
			}
			else {
				if( $('#childBed').is(":checked") ) {
					var checked = "TRUE";
				}
				else {
					var checked = "FALSE";
				}
				$("tr#available_price").show();
				$("#priceChartTable").find("tr:not(.afterPrice)").remove();
				var selectDate   = $("#landtourDateP").val();
				var selectAdult  = $("#adultPax").val();
				var selectChild  = $("#childPax").val();
				var selectInfant = $("#infantPax").val();
				var dataString = 'checkedWB='+checked+'&landtourID=<?php echo $ltID; ?>&selectDate='+selectDate+'&selectAdult='+selectAdult+'&selectChild='+selectChild+'&selectInfant='+selectInfant;
				if( $(window).width() > 480 ) {
					$.ajax({
						type: "POST",
						url: "<?php echo base_url(); ?>landtour/getLandtourListPrice",
						data: dataString,
						cache: false,
						dataType:'JSON',
						success: function(result) {
							if( result.errorCode == 0 ) {
								$('#priceChartTable tr:last').after(result.string);
								return false;
							}
						}
					});
				}
				/*
				//for mobile version
				else {
					$.ajax({
						type: "POST",
						url: "<?php echo base_url(); ?>cruise/getCruiseListPriceMobile",
						data: dataString,
						cache: false,
						dataType:'JSON',
						success: function(result) {
							if( result.errorCode == 0 ) {
								$('#priceChartTable tr:last').after(result.string);
								return false;
							}
						}
					});
				}
				*/
			}
			//end of for back button browser

			//selected by adultPax
			$("#adultPax").change(function() {
				if( $('#childBed').is(":checked") ) {
					var checked = "TRUE";
				}
				else {
					var checked = "FALSE";
				}
				$("tr#available_price").show();
				$("#priceChartTable").find("tr:not(.afterPrice)").remove();
				var selectDate   = $("#landtourDateP").val();
				var selectAdult  = $("#adultPax").val();
				var selectChild  = $("#childPax").val();
				var selectInfant = $("#infantPax").val();
				var dataString = 'checkedWB='+checked+'&landtourID=<?php echo $ltID; ?>&selectDate='+selectDate+'&selectAdult='+selectAdult+'&selectChild='+selectChild+'&selectInfant='+selectInfant;
				if( selectDate != "###" ) {
					var dataString = 'checkedWB='+checked+'&landtourID=<?php echo $ltID; ?>&selectDate='+selectDate+'&selectAdult='+selectAdult+'&selectChild='+selectChild+'&selectInfant='+selectInfant;
					if( $(window).width() > 480 ) {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>landtour/getLandtourListPrice",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
					}
					else {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>cruise/getCruiseListPriceMobile",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
					}
				}
			});
			//end of selected by adultPax

			//selected by childPax
			$("#childPax").change(function() {
				if( $('#childBed').is(":checked") ) {
					var checked = "TRUE";
				}
				else {
					var checked = "FALSE";
				}
				$("tr#available_price").show();
				$("#priceChartTable").find("tr:not(.afterPrice)").remove();
				var selectDate   = $("#landtourDateP").val();
				var selectAdult  = $("#adultPax").val();
				var selectChild  = $("#childPax").val();
				var selectInfant = $("#infantPax").val();
				var dataString = 'checkedWB='+checked+'&landtourID=<?php echo $ltID; ?>&selectDate='+selectDate+'&selectAdult='+selectAdult+'&selectChild='+selectChild+'&selectInfant='+selectInfant;
				if( selectDate != "###" ) {
					var dataString = 'checkedWB='+checked+'&landtourID=<?php echo $ltID; ?>&selectDate='+selectDate+'&selectAdult='+selectAdult+'&selectChild='+selectChild+'&selectInfant='+selectInfant;
					if( $(window).width() > 480 ) {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>landtour/getLandtourListPrice",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
					}
					else {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>cruise/getCruiseListPriceMobile",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
					}
				}
			});
			//end of selected by childPax

			//selected by infantPax
			$("#infantPax").change(function() {
				if( $('#childBed').is(":checked") ) {
					var checked = "TRUE";
				}
				else {
					var checked = "FALSE";
				}
				$("tr#available_price").show();
				$("#priceChartTable").find("tr:not(.afterPrice)").remove();
				var selectDate   = $("#landtourDateP").val();
				var selectAdult  = $("#adultPax").val();
				var selectChild  = $("#childPax").val();
				var selectInfant = $("#infantPax").val();
				var dataString = 'checkedWB='+checked+'&landtourID=<?php echo $ltID; ?>&selectDate='+selectDate+'&selectAdult='+selectAdult+'&selectChild='+selectChild+'&selectInfant='+selectInfant;
				if( selectDate != "###" ) {
					var dataString = 'checkedWB='+checked+'&landtourID=<?php echo $ltID; ?>&selectDate='+selectDate+'&selectAdult='+selectAdult+'&selectChild='+selectChild+'&selectInfant='+selectInfant;
					if( $(window).width() > 480 ) {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>landtour/getLandtourListPrice",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
					}
					else {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>cruise/getCruiseListPriceMobile",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
					}
				}
			});
			//end of selected by infantPax

			//selected by landtour date
			$("#landtourDateP").change(function(){
				if( $('#childBed').is(":checked") ) {
					var checked = "TRUE";
				}
				else {
					var checked = "FALSE";
				}
				if( $(this).val() == "###" ) {
					$("tr#available_price").hide();
				}
				else {
					$("tr#available_price").show();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
					var selectDate   = $("#landtourDateP").val();
					var selectAdult  = $("#adultPax").val();
					var selectChild  = $("#childPax").val();
					var selectInfant = $("#infantPax").val();
					var dataString = 'checkedWB='+checked+'&landtourID=<?php echo $ltID; ?>&selectDate='+selectDate+'&selectAdult='+selectAdult+'&selectChild='+selectChild+'&selectInfant='+selectInfant;
					if( $(window).width() > 480 ) {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>landtour/getLandtourListPrice",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
					}
					/*
					//Mobile version
					else {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>cruise/getCruiseListPriceMobile",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
					}
					*/
				}
			});
			//end of selected by landtour date

			//selected by check and uncheck child with bed or without bed
			$('#childBed').click(function(){
			    if( this.checked ) {
			    	//if checked
			    	$("tr#available_price").show();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
			    	var checked = "TRUE";
			    	var selectDate   = $("#landtourDateP").val();
					var selectAdult  = $("#adultPax").val();
					var selectChild  = $("#childPax").val();
					var selectInfant = $("#infantPax").val();
					if( selectDate != "###" ) {
						var dataString = 'checkedWB='+checked+'&landtourID=<?php echo $ltID; ?>&selectDate='+selectDate+'&selectAdult='+selectAdult+'&selectChild='+selectChild+'&selectInfant='+selectInfant;
						if( $(window).width() > 480 ) {
							$.ajax({
								type: "POST",
								url: "<?php echo base_url(); ?>landtour/getLandtourListPrice",
								data: dataString,
								cache: false,
								dataType:'JSON',
								success: function(result) {
									if( result.errorCode == 0 ) {
										$('#priceChartTable tr:last').after(result.string);
										return false;
									}
								}
							});
						}
						else {
							$.ajax({
								type: "POST",
								url: "<?php echo base_url(); ?>cruise/getCruiseListPriceMobile",
								data: dataString,
								cache: false,
								dataType:'JSON',
								success: function(result) {
									if( result.errorCode == 0 ) {
										$('#priceChartTable tr:last').after(result.string);
										return false;
									}
								}
							});
						}
					}
			    }
			    else {
				    //if not checked
				    $("tr#available_price").show();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
				    var checked = "FALSE";
				    var selectDate   = $("#landtourDateP").val();
					var selectAdult  = $("#adultPax").val();
					var selectChild  = $("#childPax").val();
					var selectInfant = $("#infantPax").val();
					var dataString = 'checkedWB='+checked+'&landtourID=<?php echo $ltID; ?>&selectDate='+selectDate+'&selectAdult='+selectAdult+'&selectChild='+selectChild+'&selectInfant='+selectInfant;
					if( $(window).width() > 480 ) {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>landtour/getLandtourListPrice",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
					}
					else {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>cruise/getCruiseListPriceMobile",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
					}
			    }
			});
			//end of selected by check and uncheck child with bed or without bed

		});
	</script>
</body>
</html>