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
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css"
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
</head>
<body>
	<?php require_once(APPPATH."views/master-frontend/header.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>
	<?php
	$sellingType = base64_decode(base64_decode(base64_decode($this->uri->segment(5))));
	$stringFour  = base64_decode(base64_decode(base64_decode($this->uri->segment(4))));
	$stringThree = base64_decode(base64_decode(base64_decode($this->uri->segment(3))));
	if( strpos($stringFour, '-') !== false ) {
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$getid_res = mysqli_query(
			$connection,
			"
				SELECT * FROM landtour_system_prices WHERE landtour_product_id = ".$stringThree."
				AND DATE(price_date) = '".$stringFour."'
			"
		);
		if( mysqli_num_rows($getid_res) > 0 ) {
			$getid_row = mysqli_fetch_array($getid_res, MYSQL_ASSOC);
			$lt_system_preferenceID = $getid_row["id"];
		}
	}
	else {
		$lt_system_preferenceID = $stringFour;
	}
	?>
	<?php
	$cob = "";
	$details = $this->All->select_template(
		"id", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))), "landtour_product"
	);
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
			$slug_url		= $detail->slug_url;
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
	//landtour priceDate
	$priceDates = $this->All->select_template("id", $lt_system_preferenceID, "landtour_priceDate");
	if( $priceDates == TRUE ) {
		foreach( $priceDates AS $priceDate ) {
			$dateUsed = $priceDate->priceDate;
		}
	}
	//end of landtour priceDate
	//landtour system prices
	$others = $this->All->select_template("id", $lt_system_preferenceID, "landtour_system_prices");
	if( $others == TRUE ) {
		foreach( $others AS $other ) {
			$adultSingle_price 	= $other->adultSingle_price;
			$adultTwin_price   	= $other->adultTwin_price;
			if( $other->adultTriple_price == "" ) {
				$adultTriple_price 	= 0;
			}
			else {
				$adultTriple_price 	= $other->adultTriple_price;	
			}
			$child_wb_price    	= $other->child_wb_price;
			$child_wob_price   	= $other->child_wob_price;
			$half_price 		= $other->child_half_twin_price;
			$infant_price 		= $other->infant_price;
			$price_date			= $other->price_date;
			$roomCombinationQty = $other->roomCombinationQty;
			$current_price_date = date("d/m/Y", strtotime($other->price_date));
		}
	}
	//end of landtour system prices
	$childWBPrice = "";
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
							<a href="<?php echo base_url(); ?>">Home</a>
						</li>
						<li style="margin-left:0px; font-size:1.3em">
							<a href="<?php echo base_url(); ?>landtour/details/<?php echo $slug_url; ?>" title="">Land Tour</a>
						</li>
						<li style="margin-left:0px; font-size:1.3em">
							<a href="<?php echo current_url(); ?>" title="">Details - Check Rates</a>
						</li>
					</ul>
				</nav>
				<!--END OF BREADCUMBS-->
				<!--Land tour three-fourth content-->
				<section class="three-fourth">
					<!--INFO DETAILS-->
					<section id="infodetails" class="tab-content" style="width:100%">
						<article>
							<div><h1>Land Tour Itinerary Details</h1></div>
							<table>
								<tr>
									<td>
										<h5><i class="fa fa-heart"></i> &nbsp;Title</h5>
										<p class="fontSizeAdjust">
											<?php echo $lt_title; ?> (<?php echo $lt_tourID; ?>)
											-
											(Category: <?php echo $this->All->getLandtourCategoryName($lt_category_id); ?>)
										</p>
									</td>
								</tr>
								<tr>
									<td>
										<h5><i class="fa fa-info-circle"></i> &nbsp;Select other dates</h5>
										<p class="fontSizeAdjust" style="text-align:justify">
											<div>
												<?php
												$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
												$otherdatesRes = mysqli_query(
													$connection,
													"
														SELECT * FROM landtour_priceDate
														WHERE landtour_product_id = ".$stringThree."
														AND selling_type = '".strtoupper($sellingType)."'
														AND DATE(priceDate) >= '".date("Y-m-d", strtotime("+7 days"))."'
														ORDER BY priceDate ASC
													"
												);
												if( mysqli_num_rows($otherdatesRes) > 0 ) {
													while( $otherdatesRow = mysqli_fetch_array($otherdatesRes, MYSQL_ASSOC) ) {
														$formatDate = date("d/m/Y", strtotime($otherdatesRow["priceDate"]));
														if( $current_price_date == $formatDate ) {
												?>
												<div style="float:left; width:100px; border:1px solid #F7941D; text-align:center; margin-right:20px; margin-bottom:20px">
													<a href="<?php echo base_url(); ?>landtour/second_details/<?php echo $this->uri->segment(3); ?>/<?php echo base64_encode(base64_encode(base64_encode($otherdatesRow["priceDate"]))); ?>/<?php echo $this->uri->segment(5); ?>" style="text-decoration:none">
														<span style="font-size:16px">

															<?php echo date("d/m/Y", strtotime($otherdatesRow["priceDate"])); ?>
														</span>
													</a>
												</div>
												<?php
														}
														else {
												?>
												<div style="float:left; width:100px; border:1px solid black; text-align:center; margin-right:20px; margin-bottom:20px">
													<a href="<?php echo base_url(); ?>landtour/second_details/<?php echo $this->uri->segment(3); ?>/<?php echo base64_encode(base64_encode(base64_encode($otherdatesRow["priceDate"]))); ?>/<?php echo $this->uri->segment(5); ?>" style="text-decoration:none">
														<span style="font-size:16px">

															<?php echo date("d/m/Y", strtotime($otherdatesRow["priceDate"])); ?>																</span>
													</a>
												</div>
												<?php
														}
													}
												}
												?>
												<div style="clear:both"></div>
											</div>
										</p>
									</td>
								</tr>
							</table>

							<br />
<!--MAIN LOGIC-->
<h1>Check for latest rates</h1>
<?php
$noadult  		 = 1;
$nochild  		 = 0;
$noinfant 		 = 0;
$totalGrandPrice = "";
$errorCount 	 = 0;
$arrayDates = $this->All->date_range_newFormatRoom($ltID);
?>
<div class='tab'>
	<?php echo form_open_multipart('landtour/getPriceRate'); ?>
	<input type="hidden" name="hidden_uri_three" 	value="<?php echo $this->uri->segment(3); ?>" />
	<input type="hidden" name="hidden_uri_four" 	value="<?php echo $this->uri->segment(4); ?>" />
	<input type="hidden" name="hidden_uri_five" 	value="<?php echo $this->uri->segment(5); ?>" />
	<input type="hidden" name="hidden_uri_six" 		value="<?php echo $this->uri->segment(6); ?>" />
	<table border='0' cellpadding='0' cellspacing='0' style="width:100%">
		<tr class='days afterPrice'>
			<th width="25%" style="text-align:center">
				<div style="font-size:12px">No. of Rooms Required:</div>
			</th>
			<th colspan="10" style="text-align:left">
				<div>
					<select name="roomRequired" id="roomRequired">
		                <option value="<?php echo base_url(); ?>landtour/second_details/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>/0" <?php echo ($this->uri->segment(6) == "0") ? "SELECTED" : ""; ?>>0 room</option>
						<option value="<?php echo base_url(); ?>landtour/second_details/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>/1" <?php echo ($this->uri->segment(6) == "1") ? "SELECTED" : ""; ?>>1 room</option>
						<option value="<?php echo base_url(); ?>landtour/second_details/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>/2" <?php echo ($this->uri->segment(6) == "2") ? "SELECTED" : ""; ?>>2 rooms</option>
						<option value="<?php echo base_url(); ?>landtour/second_details/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>/3" <?php echo ($this->uri->segment(6) == "3") ? "SELECTED" : ""; ?>>3 rooms</option>
						<option value="<?php echo base_url(); ?>landtour/second_details/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>/4" <?php echo ($this->uri->segment(6) == "4") ? "SELECTED" : ""; ?>>4 rooms</option>
						<option value="<?php echo base_url(); ?>landtour/second_details/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>/5" <?php echo ($this->uri->segment(6) == "5") ? "SELECTED" : ""; ?>>5 rooms</option>
		            </select>
				</div>
			</th>
		</tr>
		<?php
		if( $this->uri->segment(6) == TRUE ) {
		?>
			<tr id="room_selectionID">
				<td style="background:#eff0f1; text-align:right; font-size:14px; border-bottom:1px solid black; border-right:1px solid black">
					<b>Room</b>
				</td>
				<td colspan="2" style="background:#eff0f1; text-align:center; font-size:14px; border-bottom:1px solid black; border-right:1px solid black">
					Adult<br />(12 years & above)
				</td>
				<td colspan="4" style="background:#eff0f1; text-align:center; font-size:14px; border-bottom:1px solid black; border-right:1px solid black">
					Child<br />(2 - 11 years)
				</td>
				<td colspan="2" style="background:#eff0f1; text-align:center; font-size:14px; border-bottom:1px solid black; border-right:1px solid black">
					Child<br />Half twin
				</td>
				<td colspan="2" style="background:#eff0f1; text-align:center; font-size:14px; border-bottom:1px solid black">
					Infant<br />(Below 2 years)
				</td>
			</tr>
		<?php
		}
		?>
		<?php
		if( $this->uri->segment(6) == TRUE ) {
			for( $x=1; $x<=$this->uri->segment(6); $x++ ) {
		?>
			<tr id="room_selectionID">
				<td style="background:#eff0f1; text-align:right; font-size:14px; border-right:1px solid black">
					<b>Room <?php echo $x; ?></b>
					<input type="hidden" name="roomIndex<?php echo $x; ?>" value="<?php echo $x; ?>" />
				</td>
				<td colspan="2" style="background:#eff0f1; text-align:center; font-size:14px; border-right:1px solid black">
					<div>
						<?php
						if( $this->uri->segment(7) == TRUE ) {
							$explodeAdult = explode("~", $this->uri->segment(7));
							$adultGetQty  = explode(".", $explodeAdult[$x-1]);
						?>
							<select name="adultQty<?php echo $x; ?>" id="adultQty<?php echo $x; ?>" style="width:50px">
								<option value="1" <?php echo ($adultGetQty[0] == 1) ? 'SELECTED' : ''; ?>>1</option>
								<option value="2" <?php echo ($adultGetQty[0] == 2) ? 'SELECTED' : ''; ?>>2</option>
								<option value="3" <?php echo ($adultGetQty[0] == 3) ? 'SELECTED' : ''; ?>>3</option>
			            	</select>
						<?php
						}
						else {
						?>
							<select name="adultQty<?php echo $x; ?>" id="adultQty<?php echo $x; ?>" style="width:50px">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
			            	</select>
			            <?php
				        }
				        ?>
					</div>
				</td>
				<td colspan="2" style="background:#eff0f1; text-align:center; font-size:14px; border-right:1px solid black">
					<div>
						<?php
						if( $this->uri->segment(7) == TRUE ) {
							$explodeCWB = explode("~", $this->uri->segment(7));
							$cwbGetQty  = explode(".", $explodeCWB[$x-1]);
							if( $child_wb_price == NULL || $child_wb_price == "" ) {
						?>
							<select name="cwbQty<?php echo $x; ?>" id="cwbQty" style="width:50px" disabled>
								<option value="0" <?php echo ($cwbGetQty[1] == 0) ? 'SELECTED' : ''; ?>>0</option>
								<option value="1" <?php echo ($cwbGetQty[1] == 1) ? 'SELECTED' : ''; ?>>1</option>
								<option value="2" <?php echo ($cwbGetQty[1] == 2) ? 'SELECTED' : ''; ?>>2</option>
								<!--<option value="3" <?php echo ($cwbGetQty[1] == 3) ? 'SELECTED' : ''; ?>>3</option>-->
				            </select>
						<?php
							}
							else {
						?>
							<select name="cwbQty<?php echo $x; ?>" id="cwbQty" style="width:50px">
								<option value="0" <?php echo ($cwbGetQty[1] == 0) ? 'SELECTED' : ''; ?>>0</option>
								<option value="1" <?php echo ($cwbGetQty[1] == 1) ? 'SELECTED' : ''; ?>>1</option>
								<option value="2" <?php echo ($cwbGetQty[1] == 2) ? 'SELECTED' : ''; ?>>2</option>
								<!--<option value="3" <?php echo ($cwbGetQty[1] == 3) ? 'SELECTED' : ''; ?>>3</option>-->
				            </select>
						<?php
							}
						}
						else {
							if( $child_wb_price == NULL || $child_wb_price == "" ) {
						?>
							<select name="cwbQty<?php echo $x; ?>" id="cwbQty" style="width:50px" disabled>
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<!--<option value="3">3</option>-->
				            </select>
						<?php
							}
							else {
						?>
							<select name="cwbQty<?php echo $x; ?>" id="cwbQty" style="width:50px">
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<!--<option value="3">3</option>-->
				            </select>
			            <?php
				            }
				        }
				        ?>
			            <br />
				        With bed
					</div>
				</td>
				<td colspan="2" style="background:#eff0f1; text-align:center; font-size:14px; border-right:1px solid black">
					<div>
						<?php
						if( $this->uri->segment(7) == TRUE ) {
							$explodeCWOB = explode("~", $this->uri->segment(7));
							$cwobGetQty  = explode(".", $explodeCWOB[$x-1]);
							if( $child_wob_price == NULL || $child_wob_price == "" ) {
						?>
							<select name="cwobQty<?php echo $x; ?>" id="cwobQty" style="width:50px" disabled>
								<option value="0" <?php echo ($cwobGetQty[2] == 0) ? 'SELECTED' : ''; ?>>0</option>
								<option value="1" <?php echo ($cwobGetQty[2] == 1) ? 'SELECTED' : ''; ?>>1</option>
								<option value="2" <?php echo ($cwobGetQty[2] == 2) ? 'SELECTED' : ''; ?>>2</option>
								<!--<option value="3" <?php echo ($cwobGetQty[2] == 3) ? 'SELECTED' : ''; ?>>3</option>-->
				            </select>
						<?php
							}
							else {
						?>
							<select name="cwobQty<?php echo $x; ?>" id="cwobQty" style="width:50px">
								<option value="0" <?php echo ($cwobGetQty[2] == 0) ? 'SELECTED' : ''; ?>>0</option>
								<option value="1" <?php echo ($cwobGetQty[2] == 1) ? 'SELECTED' : ''; ?>>1</option>
								<option value="2" <?php echo ($cwobGetQty[2] == 2) ? 'SELECTED' : ''; ?>>2</option>
								<!--<option value="3" <?php echo ($cwobGetQty[2] == 3) ? 'SELECTED' : ''; ?>>3</option>-->
				            </select>
						<?php
							}
						}
						else {
							if( $child_wob_price == NULL || $child_wob_price == "" ) {
						?>
							<select name="cwobQty<?php echo $x; ?>" id="cwobQty" style="width:50px" disabled>
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<!--<option value="3">3</option>-->
				            </select>
						<?php
							}
							else {
						?>
							<select name="cwobQty<?php echo $x; ?>" id="cwobQty" style="width:50px">
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<!--<option value="3">3</option>-->
				            </select>
			            <?php
				            }
				        }
				        ?>
			            <br />
				        Without bed
					</div>
				</td>
				<td colspan="2" style="background:#eff0f1; text-align:center; font-size:14px; border-right:1px solid black">
					<div>
						<?php
						if( $this->uri->segment(7) == TRUE ) {
							$explodeHalf = explode("~", $this->uri->segment(7));
							$halfGetQty  = explode(".", $explodeHalf[$x-1]);
							if( $half_price == NULL || $half_price == "" ) {
						?>
							<select name="halfQty<?php echo $x; ?>" id="halfQty<?php echo $x; ?>" style="width:50px" disabled>
								<option value="0" <?php echo ($halfGetQty[4] == 0) ? 'SELECTED' : ''; ?>>0</option>
								<option value="1" <?php echo ($halfGetQty[4] == 1) ? 'SELECTED' : ''; ?>>1</option>
				            </select>
						<?php
							}
							else {
						?>
							<select name="halfQty<?php echo $x; ?>" id="halfQty<?php echo $x; ?>" style="width:50px">
								<option value="0" <?php echo ($halfGetQty[4] == 0) ? 'SELECTED' : ''; ?>>0</option>
								<option value="1" <?php echo ($halfGetQty[4] == 1) ? 'SELECTED' : ''; ?>>1</option>
				            </select>
						<?php
							}
						}
						else {
							if( $half_price == NULL || $half_price == "" ) {
						?>
							<select name="halfQty<?php echo $x; ?>" id="halfQty<?php echo $x; ?>" style="width:50px" disabled>
								<option value="0">0</option>
								<option value="1">1</option>
				            </select>
						<?php
							}
							else {
						?>
							<select name="halfQty<?php echo $x; ?>" id="halfQty<?php echo $x; ?>" style="width:50px">
								<option value="0">0</option>
								<option value="1">1</option>
				            </select>
			            <?php
				            }
				        }
				        ?>
					</div>
				</td>
				<td colspan="2" style="background:#eff0f1; text-align:center; font-size:14px">
					<div>
						<?php
						if( $this->uri->segment(7) == TRUE ) {
							$explodeInfant = explode("~", $this->uri->segment(7));
							$infantGetQty  = explode(".", $explodeInfant[$x-1]);
							if( $infant_price == NULL || $infant_price == "" ) {
						?>
							<select name="infantQty<?php echo $x; ?>" id="infantQty" style="width:50px" disabled>
								<option value="0" <?php echo ($infantGetQty[3] == 0) ? 'SELECTED' : ''; ?>>0</option>
								<option value="1" <?php echo ($infantGetQty[3] == 1) ? 'SELECTED' : ''; ?>>1</option>
								<option value="2" <?php echo ($infantGetQty[3] == 2) ? 'SELECTED' : ''; ?>>2</option>
								<option value="3" <?php echo ($infantGetQty[3] == 3) ? 'SELECTED' : ''; ?>>3</option>
				            </select>
						<?php
							}
							else {
						?>
							<select name="infantQty<?php echo $x; ?>" id="infantQty" style="width:50px">
								<option value="0" <?php echo ($infantGetQty[3] == 0) ? 'SELECTED' : ''; ?>>0</option>
								<option value="1" <?php echo ($infantGetQty[3] == 1) ? 'SELECTED' : ''; ?>>1</option>
								<option value="2" <?php echo ($infantGetQty[3] == 2) ? 'SELECTED' : ''; ?>>2</option>
								<option value="3" <?php echo ($infantGetQty[3] == 3) ? 'SELECTED' : ''; ?>>3</option>
				            </select>
						<?php
							}
						}
						else {
							if( $infant_price == NULL || $infant_price == "" ) {
						?>
							<select name="infantQty<?php echo $x; ?>" id="infantQty" style="width:50px" disabled>
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
				            </select>
						<?php
							}
							else {
						?>
							<select name="infantQty<?php echo $x; ?>" id="infantQty" style="width:50px">
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
				            </select>
			            <?php
				            }
				        }
				        ?>
					</div>
				</td>
			</tr>
		<?php
			}
		}
		?>
		<?php
		if( $this->uri->segment(6) == TRUE ) {
		?>
			<tr id="room_selectionID">
				<td colspan="9" style="text-align:center; background:white">
					<input type="submit" name="" class="gradient-button" value="Get Price Rate" />
				</td>
			</tr>
		<?php
		}
		?>
	</table>
	<?php echo form_close(); ?>
</div>

<?php
if( $this->uri->segment(7) == TRUE ) {
	for( $r=1; $r<=$this->uri->segment(6); $r++ ) {
		$explodePax = explode("~", $this->uri->segment(7));
		$paxGetQty  = explode(".", $explodePax[$r-1]);
		$totalPaxSelected = $paxGetQty[0]+$paxGetQty[1]+$paxGetQty[2]+$paxGetQty[3];
?>
		<?php
		if( $totalPaxSelected > $roomCombinationQty ) {
			$errorCount ++;
		?>
			<!--Notification-->
			<div style="background-color:#FFBABA; padding:10px; font-size:14px; color:red">
				Room <?php echo $r; ?> maximum capacity is <?php echo $roomCombinationQty; ?> pax(s). 
				Please update your pax statement for this room.
			</div>
			<br />
			<!--End of Notification-->
		<?php
		}
		?>
		<div class='tab' id="roomRateID">
			<table border='0' cellpadding='0' cellspacing='0' style="width:100%">
				<tr class='days afterPrice'>
					<th style="text-align:center">
						<div style="font-size:12px">Room <?php echo $r; ?> Price Rate</div>
					</th>
					<th style="text-align:right">
						<div style="font-size:12px">
							Pax Details:
							<?php echo $paxGetQty[0]; ?> Adult(s) -
							<?php echo $paxGetQty[1]+$paxGetQty[2]+$paxGetQty[4]; ?> Child(s) -
							<?php echo $paxGetQty[3]; ?> Infant(s)
						</div>
					</th>
				</tr>
				<?php
				if( $paxGetQty[0] > 0 ) {
					if( $paxGetQty[0] == 1 && $paxGetQty[4] == 1 ) {
						$adultPrice = $adultTwin_price;
					}
					else if( $paxGetQty[0] == 1 && $paxGetQty[1] == 1 ) {
						$adultPrice = $adultTwin_price;
					}
					else if( $paxGetQty[0] == 1 && $paxGetQty[2] == 1 ) {
						$adultPrice = $adultTwin_price;
					}
					else if( $paxGetQty[0] == 1 ) {
						$adultPrice = $adultSingle_price;
					}
					else if( $paxGetQty[0] == 2 ) {
						$adultPrice = $adultTwin_price;
					}
					else if( $paxGetQty[0] == 3 ) {
						$adultPrice = $adultTriple_price;
					}
				?>
					<tr class='days afterPrice'>
						<td style="text-align:center; background:#eff0f1;">
							<div style="font-size:12px">
								<?php echo $paxGetQty[0]; ?> @ Adult(s) Price
							</div>
						</td>
						<td style="text-align:right; background:#eff0f1;">
							<div style="font-size:12px">
								<?php
								if( $adultPrice != "" ) {
								?>
									$<?php echo number_format($adultPrice, 2); ?>
								<?php
								}
								else {
								?>
									<span style="color:red"><b>There is no availability for this currently.</b></span>
								<?php
								}
								?>
							</div>
						</td>
					</tr>
				<?php
				}
				?>
				<?php
				if( $paxGetQty[1] > 0 ) {
					if( $paxGetQty[0] == 1 && $paxGetQty[1] == 1 ) {
						$childWBPrice = $half_price;
					}
					else {
						$childWBPrice = $child_wb_price;
					}
				?>
					<tr class='days afterPrice'>
						<td style="text-align:center; background:#eff0f1;">
							<div style="font-size:12px">
								<?php echo $paxGetQty[1]; ?> @ Child(s) (With Bed) Price
							</div>
						</td>
						<td style="text-align:right; background:#eff0f1;">
							<div style="font-size:12px">
								$<?php echo number_format($childWBPrice, 2); ?>
							</div>
						</td>
					</tr>
				<?php
				}
				?>
				<?php
				if( $paxGetQty[2] > 0 ) {
				?>
					<tr class='days afterPrice'>
						<td style="text-align:center; background:#eff0f1;">
							<div style="font-size:12px">
								<?php echo $paxGetQty[2]; ?> @ Child(s) (Without Bed) Price
							</div>
						</td>
						<td style="text-align:right; background:#eff0f1;">
							<div style="font-size:12px">
								$<?php echo number_format($child_wob_price, 2); ?>
							</div>
						</td>
					</tr>
				<?php
				}
				?>
				<?php
				if( $paxGetQty[4] > 0 ) {
				?>
					<tr class='days afterPrice'>
						<td style="text-align:center; background:#eff0f1;">
							<div style="font-size:12px">
								<?php echo $paxGetQty[4]; ?> @ Child(s) (Half Twin) Price
							</div>
						</td>
						<td style="text-align:right; background:#eff0f1;">
							<div style="font-size:12px">
								$<?php echo number_format($half_price, 2); ?>
							</div>
						</td>
					</tr>
				<?php
				}
				?>
				<?php
				if( $paxGetQty[3] > 0 ) {
				?>
					<tr class='days afterPrice'>
						<td style="text-align:center; background:#eff0f1;">
							<div style="font-size:12px">
								<?php echo $paxGetQty[3]; ?> @ Infant(s) Price
							</div>
						</td>
						<td style="text-align:right; background:#eff0f1;">
							<div style="font-size:12px">
								$<?php echo number_format($infant_price, 2); ?>
							</div>
						</td>
					</tr>
				<?php
				}
				?>
				<tr class='days afterPrice'>
					<td style="text-align:center; background:#eff0f1;">
						<div style="font-size:12px">&nbsp;</div>
					</td>
					<td style="text-align:right; background:#eff0f1;">
						<?php
						$totalPrice = ($paxGetQty[0]*$adultPrice)+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price)+($paxGetQty[4]*$half_price);
						$totalGrandPrice += ($paxGetQty[0]*$adultPrice)+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price)+($paxGetQty[4]*$half_price);
						?>
						<div style="font-size:12px">
							<b>Total Price: $<?php echo number_format($totalPrice, 2); ?></b>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<br />
<?php
	}
}
?>

<?php
if( $this->uri->segment(7) == TRUE ) {
?>
	<div class='tab' id="roomRateID">
		<table border='0' cellpadding='0' cellspacing='0' style="width:100%">
			<tr class='days afterPrice'>
				<th style="text-align:center">
					<div style="font-size:12px">&nbsp;</div>
				</th>
				<th style="text-align:right">
					<div style="font-size:12px">
						Total Grand Price: $<?php echo number_format($totalGrandPrice, 2); ?>
					</div>
				</th>
			</tr>
		</table>
	</div>
<?php
}
?>

<?php
if( $this->uri->segment(7) == TRUE ) {
	if( $errorCount == 0 ) {
?>
		<div class='tab' id="roomRateID">
			<table border='0' cellpadding='0' cellspacing='0' style="width:100%">
				<tr class='days afterPrice'>
					<th style="text-align:center; background-color:white">
						<div style="font-size:12px">&nbsp;</div>
					</th>
					<th style="text-align:right; background-color:white">
						<div style="font-size:12px">
							<?php
							if( $totalGrandPrice > 0 ) {
							?>
								<a href="<?php echo base_url(); ?>cart/do_add_cartLandtour/<?php echo base64_decode(base64_decode(base64_decode($this->uri->segment(3)))); ?>/<?php echo $lt_system_preferenceID; ?>/<?php echo $price_date; ?>/<?php echo $this->uri->segment(5); ?>/<?php echo $this->uri->segment(6); ?>/<?php echo $this->uri->segment(7); ?>" class="gradient-button" style="border:none">
									Add to cart
								</a>
							<?php
							}
							?>
						</div>
					</th>
				</tr>
			</table>
		</div>
<?php
	}
}
?>

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
<!--END OF MAIN LOGIC-->
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
			$("select#roomRequired").change(function() {
				window.location = $(this).val();
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

			//child half twin validation
			<?php
			if( $this->uri->segment(6) == TRUE ) {
				for( $x=1; $x<=$this->uri->segment(6); $x++ ) {
			?>
					$("#adultQty<?php echo $x; ?>").on('change', function(){
						if( this.value > 1 ) {
							$('#halfQty<?php echo $x; ?>').empty();
							$('#halfQty<?php echo $x; ?>').attr('disabled', true);
							$('#halfQty<?php echo $x; ?>').append('<option value="0" <?php echo ($halfGetQty[4] == 0) ? 'SELECTED' : ''; ?>>0</option>');
						}
						else if( this.value <= 1 ) {
							$('#halfQty<?php echo $x; ?>').empty();
							$('#halfQty<?php echo $x; ?>').attr('disabled', false);
							$('#halfQty<?php echo $x; ?>').append('<option value="0" <?php echo ($halfGetQty[4] == 0) ? 'SELECTED' : ''; ?>>0</option>');
							$('#halfQty<?php echo $x; ?>').append('<option value="1" <?php echo ($halfGetQty[4] == 1) ? 'SELECTED' : ''; ?>>1</option>');
						}
					});
					$("#adultQty<?php echo $x; ?>").val($("#adultQty<?php echo $x; ?>").val()).trigger('change');
			<?php
				}
			}
			?>
			//end of child half twin validation

		});
	</script>
</body>
</html>