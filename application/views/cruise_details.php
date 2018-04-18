<?php
/*
$arrayAll      = array();
$arrayMergeMin = array();
$availableDates = $this->All->select_template("ID", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))), "cruise_title");
foreach( $availableDates AS $availableDate ) {
	$cruiseDate = $availableDate->DEPARTURE_DATE;
}
$dateArray = explode(", ", $cruiseDate);
for($a=0; $a<count($dateArray); $a++) {
	$arrayAll[$dateArray[$a]] = $this->All->getListStateroomPriceLatest(1, 2, $dateArray[$a], 1, 1, 0);
}
foreach( $arrayAll AS $key => $value ) {
	array_push($arrayMergeMin, "data", $value);
}
echo "<pre>";
print_r($arrayAll);
echo "</pre>";
*/
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CTC Travel | Cruise Details</title>
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
		h5 {
			color: #F7941D !important;
		}
		.fontSizeAdjust {
			font-size: 15px
		}
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
	<div class="main" role="main">		
		<div class="wrap clearfix">
			<div class="content clearfix">				
				<nav role="navigation" class="breadcrumbs clearfix">
					<ul class="crumbs">
						<li><a href="#" title="">You are here:</a></li>
						<li><a href="#" title="">Home</a></li>
						<li><a href="#" title="">Cruise</a></li>               
						<li><a href="#" title="">Details</a></li>                    
					</ul>
				</nav>
				<!--hotel three-fourth content-->
				<section class="three-fourth">
					<!--IMAGE SLIDER-->
					<div class="rslides_container">
						<?php
						$imageCruises = $this->All->select_template(
							"cruise_title_id", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))), "cruise_image"
						);
						if( $imageCruises == TRUE ) {
						?>
							<ul class="rslides" id="slides1">
								<?php
								foreach( $imageCruises AS $imageCruise ) {
								?>
							  	<li style="width:850px; height: 450px">
							  		<img src="<?php echo base_url(); ?>assets/cruise_img/<?php echo $imageCruise->file_name; ?>" style="width:850px; height: 450px" />
							  	</li>
							  	<?php
								}
								?>
							</ul>
						<?php
						}
						else {
						?>
							<ul>
								<li style="color:red; text-align:center"><b>No image found</b></li>
							</ul>
						<?php
						}
						?>
					</div>
					<!--END OF IMAGE SLIDER-->	
					<!--info details-->
					<section id="infodetails" class="tab-content" style="width:100%">
						<article>
							<?php
							$cruiseTitleID = base64_decode(base64_decode(base64_decode($this->uri->segment(3))));
							$detailRs = $this->All->select_template(
								"ID", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))), "cruise_title"
							);
							foreach( $detailRs AS $detailR ) {
								$cruiseTourCode   = $detailR->CRUISE_TOUR_CODE;
								$cruiseTitle 	  = $detailR->CRUISE_TITLE;
								$cruiseDesc  	  = $detailR->CRUISE_DESC;
								$cruiseDepartPort = $detailR->DEPARTURE_PORT;
								$cruiseDepartDate = $detailR->DEPARTURE_DATE;
								$cruisePortsCall  = $detailR->PORTS_OF_CALL;
								$cruiseShipID  	  = $detailR->SHIP_ID;
								$cruiseNights  	  = $detailR->NIGHTS;
							}
							$array1s = explode(", ", $cruiseDepartDate);
							foreach( $array1s AS $array1 ) {
								$dateFormat[] = date("Y F d", strtotime($array1));
							}
							$aDate = implode(", ", $dateFormat);
							?>	
							<div><h1>Cruise Itinerary Details</h1></div>
							
							<table>
								<tr>
									<td width="50%" style="border:none; font-size:10px; padding:5px 10px" valign="top">
										<div class="package-summary-body">
											<h5><i class="fa fa-heart"></i> &nbsp;Title</h5>
											<p class="fontSizeAdjust"><?php echo $cruiseTitle; ?> (<?php echo $cruiseTourCode; ?>)</p>
											<h5><i class="fa fa-ship"></i> &nbsp;Cruise details</h5>
											<p class="fontSizeAdjust">
												<?php echo $this->All->getCruiseShipName($cruiseShipID); ?> 
												(<?php echo $this->All->getCruiseBrandName($cruiseShipID); ?>)
											</p>
											<h5><i class="fa fa-map-marker"></i> &nbsp;Departure port</h5>
											<p class="fontSizeAdjust"><?php echo $cruiseDepartPort; ?></p>									
											<h5><i class="fa fa-calendar"></i> &nbsp;Available date(s)</h5>
											<p class="fontSizeAdjust"><?php echo $aDate; ?></p>
										</div>
									</td>
									<td width="50%" style="border:none; font-size:10px; padding:5px 10px" valign="top">
										<div class="package-summary-body">
											<h5><i class="fa fa-info-circle"></i> &nbsp;Cruise info</h5>
											<p class="fontSizeAdjust">
												<?php
												if( $cruiseDesc == "" ) {
													echo "No info found";
												}
												else {
													echo $cruiseDesc;
												}
												?>
											</p>									
											<h5><i class="fa fa-globe"></i> &nbsp;Ports of call</h5>
											<p class="fontSizeAdjust">
												<?php echo str_replace(";", ", ", $cruisePortsCall); ?>
											</p>
										</div>
									</td>
								</tr>
							</table>
							
							<br />

<?php
$itinerarys = $this->All->select_template(
	"CRUISE_TITLE_ID", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))), 
	"cruise_itinerary"
);
if( $itinerarys == TRUE ) {
?>
	<h1>Sailing itinerary information</h1>
	<div class='tab'>
		<table border='0' cellpadding='0' cellspacing='0' style="width:100%">
			<tr class='days' style="background:#e3deda" id="choose_pax">
				<th width="25%" style="text-align:left; margin-bottom:-50px">
					<div style="font-size:13px">Day</div>
				</th>
				<th width="25%" style="text-align:left; margin-bottom:-50px">
					<div style="font-size:13px">Port***</div>
				</th>
				<th width="25%" style="text-align:left; margin-bottom:-50px">
					<div style="font-size:13px">Arrive</div>
				</th>
				<th width="25%" style="text-align:left; margin-bottom:-50px">
					<div style="font-size:13px">Depart</div>
				</th>
			</tr>
			<?php
			foreach( $itinerarys AS $itinerary ) {
			?>
			<tr style="background:#e0f2f4">
				<td style="width:120px; font-size:13px">
					<label for="spinner6">Day <?php echo $itinerary->DAY; ?></label>
				</td>
				<td style="width:120px; font-size:13px">
					<label for="spinner6">
						<?php 
							$itineraryPort = str_replace(",", ", ", $itinerary->PORT);
							$itineraryPort = str_replace(")", ") ", $itinerary->PORT);
							$itineraryPort = str_replace("(", "( ", $itinerary->PORT);
							echo $itineraryPort;
						?>
					</label>
				</td>
				<td style="width:120px; font-size:13px">
					<div style="text-align:left"><?php echo $itinerary->ARRIVAL_TIME; ?></div>
				</td>
				<td style="width:120px; font-size:13px">
					<div style="text-align:left"><?php echo $itinerary->DEPARTURE_TIME; ?></div>
				</td>
			</tr>
			<tr style="background:#e0f2f4">
				<td colspan="4" style="font-size:13px">
					<b>Remark:</b>
					<span><?php echo ($itinerary->REMARK == "") ? "---" : $itinerary->REMARK; ?></span>
				</td>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
	<br /><br />
<?php
}
?>

<?php
$ar_dates = explode(",", trim($cruiseDepartDate));
$cruiseBrandID = $this->All->getCruiseBrandID($cruiseShipID);
$noadult = base64_decode(base64_decode(base64_decode($this->uri->segment(8))));
$nochild = base64_decode(base64_decode(base64_decode($this->uri->segment(9))));
?>

<h1>Price Chart</h1>

<!--NEW DESIGN-->
<div class='tab'>
	<table border='0' cellpadding='0' cellspacing='0' id="priceChartTable" style="width:100%">
    	<tr class='days afterPrice' id="choose_pax">
			<th width="25%" style="text-align:right">
				<div style="font-size:12px">Choose no. of pax</div>
			</th>
			<th width="25%">
				<div>
					<label class="dropdown">
						<select name="adultPax" id="adultPax">
			                <option value="1" <?php if( $noadult == "1" ) { echo 'SELECTED'; } ?>>
			                	1 adult pax
			                </option>
							<option value="2" <?php if( $noadult == "2" ) { echo 'SELECTED'; } ?>>
								2 adult pax(s)
							</option>
							<option value="3" <?php if( $noadult == "3" ) { echo 'SELECTED'; } ?>>
								3 adult pax(s)
							</option>
							<option value="4" <?php if( $noadult == "4" ) { echo 'SELECTED'; } ?>>
								4 adult pax(s)
							</option>
			            </select>
					</label>
				</div>
			</th>
			<th width="25%">
				<div>
					<label class="dropdown">
						<select name="childPax" id="childPax">
			                <option value="0" <?php if( $nochild == "0" ) { echo 'SELECTED'; } ?>>
			                	0 child pax
			                </option>
							<option value="1" <?php if( $nochild == "1" ) { echo 'SELECTED'; } ?>>
								1 child pax
							</option>
							<option value="2" <?php if( $nochild == "2" ) { echo 'SELECTED'; } ?>>
								2 child pax(s)
							</option>
							<option value="3" <?php if( $nochild == "3" ) { echo 'SELECTED'; } ?>>
								3 child pax(s)
							</option>
							<option value="4" <?php if( $nochild == "4" ) { echo 'SELECTED'; } ?>>
								4 child pax(s)
							</option>
			            </select>
			        </label>
				</div>
			</th>
			<!--
			<th>
				<div style="float:left">
					<input type="checkbox" name="findCheap" id="findCheap" value="1" style="zoom:1.5" />
				</div>
				<div style="float:left; margin-top:2px">
					<span style="font-size:11px">Find cheapest price</span>
				</div>
				<div style="clear:both"></div>
			</th>
			-->
			<th></th>
    	</tr>
    	<tr class="afterPrice">
    		<td class='time' style="text-align:right; padding-top:0px; padding-bottom:0px">
				<div style="font-size:12px"><b>&nbsp;</b></div>
			</td>
			<td class='time' style="width:100%; padding-top:0px; padding-bottom:0px">
				<div style="float:left; margin-left:8px; width:10%">
					<input type="checkbox" name="findCheap" id="findCheap" value="1" style="zoom:1.5" />
				</div>
				<div style="float:left; margin-top:2px; width:80%">
					<span style="font-size:11px">&nbsp;<b>Find cheapest price</b></span>
				</div>
				<div style="clear:both"></div>
			</td>
			<td class='time' style="padding-top:0px; padding-bottom:0px">&nbsp;</td>
			<td class='time' style="padding-top:0px; padding-bottom:0px">&nbsp;</td>
    	</tr>
		<tr class="afterPrice">
			<td class='time' style="text-align:right">
				<div style="font-size:12px"><b>Choose date</b></div>
			</td>
			<td class='time' style="width:50%">
				<div>
					<label class="dropdown">
						<select name="cruiseDateP" id="cruiseDateP" style="width:150px">
			                <option value="###">Select cruise date -</option>
			                <?php
				            foreach( $ar_dates AS $ar_date ) {
					            if( strtotime($ar_date) >= strtotime(date("Y-m-d")) ) {
					        ?>
					        <option value="<?php echo preg_replace('/\s+/', '', $ar_date); ?>">
					        	<?php echo date("Y-F-d", strtotime($ar_date)); ?>
					        </option>
					        <?php
						        }
				            }
				            ?>
			            </select>
					</label>
				</div>
			</td>
			<td class='time'>&nbsp;</td>
			<td class='time'>&nbsp;</td>
    	</tr>
		<tr id="available_price" class="afterPrice">
			<td class='time' style="text-align:right; background:#eff0f1">
				<div style="font-size:12px"><b>&nbsp;</b></div>
			</td>
			<td class='time' colspan="2" style="text-align:left; background:#eff0f1">
				<div style="color:green; font-size:12px">
					<b>Stateroom</b>
				</div>
			</td>
			<td class='time' style="background:#eff0f1">
				<div style="color:green; font-size:12px; text-align:center">
					<b>Price</b>
				</div>
			</td>
    	</tr>
  </table>
</div>
<!--END OF NEW DESIGN-->

<br />

<!--
<?php echo form_open_multipart('#', array('id' => 'booking_particular_form', 'name' => 'booking_particular_form')); ?>
<table class="table" id="priceChartTable">
	<tbody style="border:1px solid grey">
		<tr id="choose_pax" class="afterPrice" style="text-align:right">
			<td rowspan="2" style="border:1px solid grey">
				<b>Choose no. of pax</b>
			</td>
		</tr>
		<tr id="choose_pax" class="afterPrice">
			<td colspan="2" style="border:1px solid grey">
				<div>
					<select name="adultPax" id="adultPax" style="width:100px">
		                <option value="1" <?php if( $noadult == "1" ) { echo 'SELECTED'; } ?>>
		                	1 adult pax
		                </option>
						<option value="2" <?php if( $noadult == "2" ) { echo 'SELECTED'; } ?>>
							2 adult pax(s)
						</option>
						<option value="3" <?php if( $noadult == "3" ) { echo 'SELECTED'; } ?>>
							3 adult pax(s)
						</option>
						<option value="4" <?php if( $noadult == "4" ) { echo 'SELECTED'; } ?>>
							4 adult pax(s)
						</option>
		            </select>
		            <select name="childPax" id="childPax" style="width:100px">
		                <option value="0" <?php if( $nochild == "0" ) { echo 'SELECTED'; } ?>>
		                	0 child pax
		                </option>
						<option value="1" <?php if( $nochild == "1" ) { echo 'SELECTED'; } ?>>
							1 child pax
						</option>
						<option value="2" <?php if( $nochild == "2" ) { echo 'SELECTED'; } ?>>
							2 child pax(s)
						</option>
						<option value="3" <?php if( $nochild == "3" ) { echo 'SELECTED'; } ?>>
							3 child pax(s)
						</option>
						<option value="4" <?php if( $nochild == "4" ) { echo 'SELECTED'; } ?>>
							4 child pax(s)
						</option>
		            </select>
		            &nbsp;&nbsp;&nbsp;
		            <input type="checkbox" name="findCheap" id="findCheap" value="1" /> Find cheapest price
				</div>
			</td>
		</tr>
		<tr class="afterPrice" style="text-align:right">
			<td rowspan="2" style="border:1px solid grey">
				<b>Choose date</b>
			</td>
		</tr>
		<tr class="afterPrice">
			<td colspan="2" style="border:1px solid grey">
				<div>
					<select name="cruiseDateP" id="cruiseDateP" style="width:250px">
		                <option value="###">- Select cruise date -</option>
		                <?php
			            foreach( $ar_dates AS $ar_date ) {
				        ?>
				        <option value="<?php echo preg_replace('/\s+/', '', $ar_date); ?>">
				        	<?php echo date("Y-F-d", strtotime($ar_date)); ?>
				        </option>
				        <?php
			            }
			            ?>
		            </select>
				</div>
			</td>
		</tr>
		<tr id="available_price" class="afterPrice" style="text-align:right">
			<td rowspan="2" style="border:1px solid grey">
				<b>Available price(s)</b>
			</td>
		</tr>
		<tr id="available_price" class="afterPrice">
			<td style="border:1px solid grey; text-align:left">
				<div><span style="color:green"><b>Stateroom available</b></span></div>
			</td>
			<td style="border:1px solid grey; text-align:center">
				<div><span style="color:green"><b>Price</b></span></div>
			</td>
		</tr>
	</tbody>
</table>
<br /><br />
<?php echo form_close(); ?>
-->
							
						<table class="table">
							<tbody>
								<tr style="text-align:center">
									<td style="border:1px solid grey; text-align:left">
										<div style="font-size:15px; margin-top:-10px">
											<b>Terms & Conditions</b>
										</div>
										<br />
										<ul style="font-size:11px; margin-left:18px">
											<li style="list-style-type:square;">Service Charge in SGD$ per person.</li>
											<li style="list-style-type:square;">Full payment is required upon booking.</li>
											<li style="list-style-type:square;">Price shown do not include the service charge, payable aboard the ship at the end of the cruise.</li>
											<li style="list-style-type:square;">Individual cruise line reserves the right to amend prices, surcharges etc whenever required without any prior notice.</li>
											<!--<li style="list-style-type:square;">Mandatory insurance fee is Sg$26 per passenger (Subject to change without notice.)</li>
											<li style="list-style-type:square;">Cruise fare is free of charge for children 12 years of age and under, sharing cabin with 3 full paying pronto price adults; They are required to pay only port charges, service charge and passenger insurance. Ages 14 and above pay adult cruise here.</li>-->
											<li style="list-style-type:square;"><b>Infant</b> guests are required to be at least six (6) months of age on embarkation day to be eligible to travel.</li>
											<li style="list-style-type:square;">Cruise <b>cannot accept</b> guests who will have entered their 24th week of pregnancy by the beginning of, or at any time during the cruise or cruise tour.
</li>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>
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
											<label for="spinner6">
												<?php 
													$itineraryPort = str_replace(",", ", ", $itinerary->PORT);
													$itineraryPort = str_replace(")", ") ", $itinerary->PORT);
													$itineraryPort = str_replace("(", "( ", $itinerary->PORT);
													echo $itineraryPort;
												?>
											</label>
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
				
				<!--sidebar-->
				<aside class="right-sidebar">	
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
						<p class="number">+65 6216-3456</p>
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
					
					<!--Itinerary-->
					<article class="default clearfix">
						<h2>Cruise Itinerary</h2>
						<h3 style="text-align:center">Get cruise latest itinerary</h3>
						<p style="text-align:center; margin-top:10px">
							<a href="<?php echo $this->All->getItinerary(base64_decode(base64_decode(base64_decode($this->uri->segment(3))))); ?>" download class="gradient-button" style="border:none">
								Download Itinerary
							</a>
						</p>
					</article>
					<!--End of Itinerary-->
				</aside>
			</div>
		</div>
	</div>
	<!--//main-->
	
	<!--FOOTER-->
	<?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
	<!--END OF FOOTER-->
	
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
		$(document).ready(function() {
			$('#findCheap').click(function() {
				if( this.checked ) {
					var selectAdult = $("#adultPax").val();
					var selectChild = $("#childPax").val();
					var dataString  = 'cruiseTitleID=<?php echo $cruiseTitleID; ?>&shipID=<?php echo $cruiseShipID; ?>&brandID=<?php echo $cruiseBrandID; ?>&noofnight=<?php echo $cruiseNights; ?>&noofadult='+selectAdult+'&noofchild='+selectChild;
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
					if( $(window).width() > 480 ) {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>cruise/getCruiseCheapestPrice",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#cruiseDateP').val(result.cruiseDate);
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
						//alert("checked (Still in development)");
					}
					else {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>cruise/getCruiseCheapestPriceMobile",
							data: dataString,
							cache: false,
							dataType:'JSON',
							success: function(result) {
								if( result.errorCode == 0 ) {
									$('#cruiseDateP').val(result.cruiseDate);
									$('#priceChartTable tr:last').after(result.string);
									return false;
								}
							}
						});
						//alert("checked (Still in development)");
					}
    			}
    			else {
	    			$('#cruiseDateP').val("###");
	    			$("tr#available_price").hide();
	    			//alert("not checked (Still in development)");
    			}
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
			if( $("#cruiseDateP").val() == "###" ) {
				$("tr#available_price").hide();
			}
			else {
				$("tr#choose_pax").show();
				$("tr#available_price").show();
				$("#priceChartTable").find("tr:not(.afterPrice)").remove();
				var selectDate  = $("#cruiseDateP").val();
				var selectAdult = $("#adultPax").val();
				var selectChild = $("#childPax").val();
				var dataString = 'cruiseTitleID=<?php echo $cruiseTitleID; ?>&shipID=<?php echo $cruiseShipID; ?>&brandID=<?php echo $cruiseBrandID; ?>&cruiseDate='+selectDate+'&noofnight=<?php echo $cruiseNights; ?>&noofadult='+selectAdult+'&noofchild='+selectChild;
				if( $(window).width() > 480 ) {
					$.ajax({
						type: "POST",
						url: "<?php echo base_url(); ?>cruise/getCruiseListPrice",
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
			//end of for back button browser
			
			$("#cruiseDateP").change(function(){
				if( $(this).val() == "###" ) {
					$("tr#available_price").hide();
				}
				else {
					$("tr#choose_pax").show();
					$("tr#available_price").show();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
					var selectDate  = $("#cruiseDateP").val();
					var selectAdult = $("#adultPax").val();
					var selectChild = $("#childPax").val();
					var dataString = 'cruiseTitleID=<?php echo $cruiseTitleID; ?>&shipID=<?php echo $cruiseShipID; ?>&brandID=<?php echo $cruiseBrandID; ?>&cruiseDate='+selectDate+'&noofnight=<?php echo $cruiseNights; ?>&noofadult='+selectAdult+'&noofchild='+selectChild;
					if( $(window).width() > 480 ) {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>cruise/getCruiseListPrice",
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
			<?php
			if( $noadult == 1 ) {
			?>	
				$("#childPax").children("option[value=1]").show();
				$("#childPax").children("option[value=2]").show();
				$("#childPax").children("option[value=3]").show();
				$("#childPax").children("option[value=4]").hide();
			<?php
			}
			else if( $noadult == 2 ) {
			?>
				$("#childPax").children("option[value=1]").show();
				$("#childPax").children("option[value=2]").show();
				$("#childPax").children("option[value=3]").show();
				$("#childPax").children("option[value=4]").hide();
			<?php	
			}
			else if( $noadult == 3 ) {
			?>
				$("#childPax").children("option[value=1]").show();
				$("#childPax").children("option[value=2]").show();
				$("#childPax").children("option[value=3]").show();
				$("#childPax").children("option[value=4]").hide();
			<?php	
			}
			else if( $noadult == 4 ) {
			?>
				$("#childPax").children("option[value=1]").show();
				$("#childPax").children("option[value=2]").show();
				$("#childPax").children("option[value=3]").show();
				$("#childPax").children("option[value=4]").hide();
			<?php	
			}
			?>
			
			$("#adultPax").change(function() {
				if( $(this).val() == "1" ) {
					$("#childPax").children("option[value=1]").show();
					$("#childPax").children("option[value=2]").show();
					$("#childPax").children("option[value=3]").show();
					$("#childPax").children("option[value=4]").hide();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
					var selectDate  = $("#cruiseDateP").val();
					var selectAdult = $("#adultPax").val();
					var selectChild = $("#childPax").val();
					$('#findCheap').attr('checked', false);
					if( selectDate == "###" ) {
						return false;
					}
					else {
						var dataString = 'cruiseTitleID=<?php echo $cruiseTitleID; ?>&shipID=<?php echo $cruiseShipID; ?>&brandID=<?php echo $cruiseBrandID; ?>&cruiseDate='+selectDate+'&noofnight=<?php echo $cruiseNights; ?>&noofadult='+selectAdult+'&noofchild='+selectChild;
						if( $(window).width() > 480 ) {
							$.ajax({
								type: "POST",
								url: "<?php echo base_url(); ?>cruise/getCruiseListPrice",
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
				else if( $(this).val() == "2" ) {
					$("#childPax").children("option[value=1]").show();
					$("#childPax").children("option[value=2]").show();
					$("#childPax").children("option[value=3]").hide();
					$("#childPax").children("option[value=4]").hide();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
					var selectDate  = $("#cruiseDateP").val();
					var selectAdult = $("#adultPax").val();
					var selectChild = $("#childPax").val();
					$('#findCheap').attr('checked', false);
					if( selectDate == "###" ) {
						return false;
					}
					else {
						var dataString = 'cruiseTitleID=<?php echo $cruiseTitleID; ?>&shipID=<?php echo $cruiseShipID; ?>&brandID=<?php echo $cruiseBrandID; ?>&cruiseDate='+selectDate+'&noofnight=<?php echo $cruiseNights; ?>&noofadult='+selectAdult+'&noofchild='+selectChild;
						if( $(window).width() > 480 ) {
							$.ajax({
								type: "POST",
								url: "<?php echo base_url(); ?>cruise/getCruiseListPrice",
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
				else if( $(this).val() == "3" ) {
					$("#childPax").children("option[value=1]").show();
					$("#childPax").children("option[value=2]").hide();
					$("#childPax").children("option[value=3]").hide();
					$("#childPax").children("option[value=4]").hide();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
					var selectDate  = $("#cruiseDateP").val();
					var selectAdult = $("#adultPax").val();
					var selectChild = $("#childPax").val();
					$('#findCheap').attr('checked', false);
					if( selectDate == "###" ) {
						return false;
					}
					else {
						var dataString = 'cruiseTitleID=<?php echo $cruiseTitleID; ?>&shipID=<?php echo $cruiseShipID; ?>&brandID=<?php echo $cruiseBrandID; ?>&cruiseDate='+selectDate+'&noofnight=<?php echo $cruiseNights; ?>&noofadult='+selectAdult+'&noofchild='+selectChild;
						if( $(window).width() > 480 ) {
							$.ajax({
								type: "POST",
								url: "<?php echo base_url(); ?>cruise/getCruiseListPrice",
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
				else if( $(this).val() == "4" ) {
					$('#childPax>option:eq(0)').prop('selected', true);
					$("#childPax").children("option[value=1]").hide();
					$("#childPax").children("option[value=2]").hide();
					$("#childPax").children("option[value=3]").hide();
					$("#childPax").children("option[value=4]").hide();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
					var selectDate  = $("#cruiseDateP").val();
					var selectAdult = $("#adultPax").val();
					var selectChild = $("#childPax").val();
					$('#findCheap').attr('checked', false);
					if( selectDate == "###" ) {
						return false;
					}
					else {
						var dataString = 'cruiseTitleID=<?php echo $cruiseTitleID; ?>&shipID=<?php echo $cruiseShipID; ?>&brandID=<?php echo $cruiseBrandID; ?>&cruiseDate='+selectDate+'&noofnight=<?php echo $cruiseNights; ?>&noofadult='+selectAdult+'&noofchild='+selectChild;
						if( $(window).width() > 480 ) {
							$.ajax({
								type: "POST",
								url: "<?php echo base_url(); ?>cruise/getCruiseListPrice",
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
			});
			$("#childPax").change(function(){
				if( $(this).val() == "1" ) {
					$("#adultPax").children("option[value=1]").show();
					$("#adultPax").children("option[value=2]").show();
					$("#adultPax").children("option[value=3]").show();
					$("#adultPax").children("option[value=4]").hide();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
					var selectDate  = $("#cruiseDateP").val();
					var selectAdult = $("#adultPax").val();
					var selectChild = $("#childPax").val();
					$('#findCheap').attr('checked', false);
					if( selectDate == "###" ) {
						return false;
					}
					else {
						var dataString = 'cruiseTitleID=<?php echo $cruiseTitleID; ?>&shipID=<?php echo $cruiseShipID; ?>&brandID=<?php echo $cruiseBrandID; ?>&cruiseDate='+selectDate+'&noofnight=<?php echo $cruiseNights; ?>&noofadult='+selectAdult+'&noofchild='+selectChild;
						if( $(window).width() > 480 ) {
							$.ajax({
								type: "POST",
								url: "<?php echo base_url(); ?>cruise/getCruiseListPrice",
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
				else if( $(this).val() == "2" ) {
					$("#adultPax").children("option[value=1]").show();
					$("#adultPax").children("option[value=2]").show();
					$("#adultPax").children("option[value=3]").hide();
					$("#adultPax").children("option[value=4]").hide();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
					var selectDate  = $("#cruiseDateP").val();
					var selectAdult = $("#adultPax").val();
					var selectChild = $("#childPax").val();
					$('#findCheap').attr('checked', false);
					if( selectDate == "###" ) {
						return false;
					}
					else {
						var dataString = 'cruiseTitleID=<?php echo $cruiseTitleID; ?>&shipID=<?php echo $cruiseShipID; ?>&brandID=<?php echo $cruiseBrandID; ?>&cruiseDate='+selectDate+'&noofnight=<?php echo $cruiseNights; ?>&noofadult='+selectAdult+'&noofchild='+selectChild;
						if( $(window).width() > 480 ) {
							$.ajax({
								type: "POST",
								url: "<?php echo base_url(); ?>cruise/getCruiseListPrice",
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
				else if( $(this).val() == "3" ) {
					$("#adultPax").children("option[value=1]").show();
					$("#adultPax").children("option[value=2]").hide();
					$("#adultPax").children("option[value=3]").hide();
					$("#adultPax").children("option[value=4]").hide();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
					var selectDate  = $("#cruiseDateP").val();
					var selectAdult = $("#adultPax").val();
					var selectChild = $("#childPax").val();
					$('#findCheap').attr('checked', false);
					if( selectDate == "###" ) {
						return false;
					}
					else {
						var dataString = 'cruiseTitleID=<?php echo $cruiseTitleID; ?>&shipID=<?php echo $cruiseShipID; ?>&brandID=<?php echo $cruiseBrandID; ?>&cruiseDate='+selectDate+'&noofnight=<?php echo $cruiseNights; ?>&noofadult='+selectAdult+'&noofchild='+selectChild;
						if( $(window).width() > 480 ) {
							$.ajax({
								type: "POST",
								url: "<?php echo base_url(); ?>cruise/getCruiseListPrice",
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
				else if( $(this).val() == "0" ) {
					$("#adultPax").children("option[value=1]").show();
					$("#adultPax").children("option[value=2]").show();
					$("#adultPax").children("option[value=3]").show();
					$("#adultPax").children("option[value=4]").show();
					$("#priceChartTable").find("tr:not(.afterPrice)").remove();
					var selectDate  = $("#cruiseDateP").val();
					var selectAdult = $("#adultPax").val();
					var selectChild = $("#childPax").val();
					$('#findCheap').attr('checked', false);
					if( selectDate == "###" ) {
						return false;
					}
					else {
						var dataString = 'cruiseTitleID=<?php echo $cruiseTitleID; ?>&shipID=<?php echo $cruiseShipID; ?>&brandID=<?php echo $cruiseBrandID; ?>&cruiseDate='+selectDate+'&noofnight=<?php echo $cruiseNights; ?>&noofadult='+selectAdult+'&noofchild='+selectChild;
						if( $(window).width() > 480 ) {
							$.ajax({
								type: "POST",
								url: "<?php echo base_url(); ?>cruise/getCruiseListPrice",
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
			});
		});
	</script>
	<!--
	<script type="text/javascript">
		$(document).ready(function() {
			if( $(window).width() > 480 ) {
				alert("width screen big");
			}
			else {
				alert("width screen small");
			}
		});
	</script>
	-->
</body>
</html>