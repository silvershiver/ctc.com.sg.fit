<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CTC Travel | Checkout & Booking</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css" media="screen,projection,print" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" />
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
</head>
<body>
	
	<!--HEADER-->
	<?php require_once(APPPATH."views/master-frontend/header.php"); ?>
	<!--END OF HEADER-->
	
	<!--LOGIN FORM-->
	<?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
	<!--END OF LOGIN FORM-->
	
	<!--SIGNUP FORM-->
	<?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
	<!--END OF SIGNUP FORM-->
	
	<!--FORGOT PASSWORD FORM-->
	<?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>
	<!--END OF FORGOT PASSWORD FORM-->
	
	<!--main-->
	<div class="main" role="main">		
		<div class="wrap clearfix">
			<!--main content-->
			<div class="content clearfix">
				
				<!--BREADCUMBS-->
				<nav role="navigation" class="breadcrumbs clearfix">
					<ul class="crumbs">
						<li><a href="#" title="">You are here:</a></li>
						<li><a href="#" title="">Home</a></li>
						<li><a href="#" title="">Checkout & Booking</a></li>                                 
					</ul>
				</nav>
				<!--END OF BREADCUMBS-->

				<!--hotel three-fourth content-->
				<section class="three-fourth">
					<!--inner navigation-->
					<nav class="inner-nav">
						<ul>
							<li class="description">
								<a href="#info_details_tab" title="Availability">Info Details</a>
							</li>
							<li class="description">
								<a href="#preview_order_tab" title="Description">Preview Order</a>
							</li>
							<li class="description">
								<a href="#payment_tab" title="Facilities">Payment</a>
							</li>
							<li class="description">
								<a href="#confirmation_tab" title="Location">Confirmation</a>
							</li>
						</ul>
					</nav>
					<!--//inner navigation-->		
					<!--INFO DETAILS TAB-->
					<section id="info_details_tab" class="tab-content three-fourth">
						<article>					
							<h1>Traveller info (Person 1)</h1>
							<form id="booking" method="post" action="#" class="booking" style="box-shadow:none">
								<fieldset>
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="first_name">First name</label>
											<input type="text" id="first_name" name="first_name" />
										</div>
										<div class="f-item" style="width: 48%">
											<label for="last_name">Last name</label>
											<input type="text" id="last_name" name="last_name" />
										</div>
									</div>		
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="email">Email address</label>
											<input type="email" id="email" name="email" />
										</div>
										<div class="f-item" style="width: 48%">
											<label for="confirm_email">Contact no.</label>
											<input type="text" id="confirm_email" name="confirm_email" />
										</div>
									</div>
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="email">NRIC / Passport no.</label>
											<input type="email" id="email" name="email" />
										</div>
										<div class="f-item" style="width: 48%">
											<label for="confirm_email">NRIC / Passport No.</label>
											<input type="text" id="confirm_email" name="confirm_email" />
										</div>
									</div>
								</fieldset>
							</form>
							<h1>Traveller info (Person 2)</h1>
							<form id="booking" method="post" action="#" class="booking" style="box-shadow:none">
								<fieldset>
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="first_name">First name</label>
											<input type="text" id="first_name" name="first_name" />
										</div>
										<div class="f-item" style="width: 48%">
											<label for="last_name">Last name</label>
											<input type="text" id="last_name" name="last_name" />
										</div>
									</div>		
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="email">Email address</label>
											<input type="email" id="email" name="email" />
										</div>
										<div class="f-item" style="width: 48%">
											<label for="confirm_email">Contact no.</label>
											<input type="text" id="confirm_email" name="confirm_email" />
										</div>
									</div>
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="email">NRIC / Passport no.</label>
											<input type="email" id="email" name="email" />
										</div>
										<div class="f-item" style="width: 48%">
											<label for="confirm_email">NRIC / Passport No.</label>
											<input type="text" id="confirm_email" name="confirm_email" />
										</div>
									</div>
								</fieldset>
							</form>
							<h1>Traveller info (Person 3)</h1>
							<form id="booking" method="post" action="#" class="booking" style="box-shadow:none">
								<fieldset>
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="first_name">First name</label>
											<input type="text" id="first_name" name="first_name" />
										</div>
										<div class="f-item" style="width: 48%">
											<label for="last_name">Last name</label>
											<input type="text" id="last_name" name="last_name" />
										</div>
									</div>		
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="email">Email address</label>
											<input type="email" id="email" name="email" />
										</div>
										<div class="f-item" style="width: 48%">
											<label for="confirm_email">Contact no.</label>
											<input type="text" id="confirm_email" name="confirm_email" />
										</div>
									</div>
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="email">NRIC / Passport no.</label>
											<input type="email" id="email" name="email" />
										</div>
										<div class="f-item" style="width: 48%">
											<label for="confirm_email">NRIC / Passport No.</label>
											<input type="text" id="confirm_email" name="confirm_email" />
										</div>
									</div>
								</fieldset>
							</form>
							<div style="text-align:center">
								<input type="submit" class="gradient-button" value="Proceed to next step" id="next-step" />
							</div>
							<br />
						</article>
					</section>
					<!--END OF INFO DETAILS TAB-->
					
					<!--PREVIEW TAB TAB-->
					<section id="preview_order_tab" class="tab-content">
						<article>					
							<h1>Hotel Room Order Details</h1>
							<ul class="room-types">
								<!--room-->
								<li>
									<figure class="left">
										<img src="<?php echo base_url(); ?>assets/images/slider/img.jpg" alt="" width="270" height="152" /><a href="<?php echo base_url(); ?>assets/images/slider/img.jpg" class="image-overlay" rel="prettyPhoto[gallery1]"></a>
									</figure>
									<div class="meta">
										<h2>Superior Double Room</h2>
										<p>From<br /><b>Thurs 29 Nov 2016</b></p>
										<p>To<br /><b>Fri 30 Nov 2016</b></p>
										<a href="javascript:void(0)" title="more info" class="more-info">+ more info</a>
									</div>
									<div class="room-information">
										<div class="row">
											<span class="first">Max:</span>
											<span class="second"><img src="<?php echo base_url(); ?>assets/images/ico/person.png" alt="" /><img src="<?php echo base_url(); ?>assets/images/ico/person.png" alt="" /></span>
										</div>
										<div class="row">
											<span class="first">Price:</span>
											<span class="second">$ 55</span>
										</div>
										<div class="row">
											<span class="first">Rooms:</span>
											<span class="second">01</span>
										</div>
									</div>
									<div class="more-information">
										<p>Stylish and individually designed room featuring a satellite TV, mini bar and a 24-hour room service menu.</p>
										<p><strong>Room Facilities:</strong> Safety Deposit Box, Air Conditioning, Desk, Ironing Facilities, Seating Area, Heating, Shower, Bath, Hairdryer, Toilet, Bathroom, Pay-per-view Channels, TV, Telephone</p>
										<p><strong>Bed Size(s):</strong> 1 Double </p>
										<p><strong>Room Size:</strong>  16 square metres</p>
									</div>
								</li>
								<!--//room-->
								<!--room-->
								<li>
									<figure class="left">
										<img src="<?php echo base_url(); ?>assets/images/slider/img.jpg" alt="" width="270" height="152" /><a href="<?php echo base_url(); ?>assets/images/slider/img.jpg" class="image-overlay" rel="prettyPhoto[gallery1]"></a>
									</figure>
									<div class="meta">
										<h2>Superior Double Room</h2>
										<p>From<br /><b>Thurs 29 Nov 2016</b></p>
										<p>To<br /><b>Fri 30 Nov 2016</b></p>
										<a href="javascript:void(0)" title="more info" class="more-info">+ more info</a>
									</div>
									<div class="room-information">
										<div class="row">
											<span class="first">Max:</span>
											<span class="second"><img src="<?php echo base_url(); ?>assets/images/ico/person.png" alt="" /><img src="<?php echo base_url(); ?>assets/images/ico/person.png" alt="" /></span>
										</div>
										<div class="row">
											<span class="first">Price:</span>
											<span class="second">$ 55</span>
										</div>
										<div class="row">
											<span class="first">Rooms:</span>
											<span class="second">01</span>
										</div>
									</div>
									<div class="more-information">
										<p>Stylish and individually designed room featuring a satellite TV, mini bar and a 24-hour room service menu.</p>
										<p><strong>Room Facilities:</strong> Safety Deposit Box, Air Conditioning, Desk, Ironing Facilities, Seating Area, Heating, Shower, Bath, Hairdryer, Toilet, Bathroom, Pay-per-view Channels, TV, Telephone</p>
										<p><strong>Bed Size(s):</strong> 1 Double </p>
										<p><strong>Room Size:</strong>  16 square metres</p>
									</div>
								</li>
								<!--//room-->
								
								<h1>Flight Order Details</h1>
								<br />
								
								<!--flight items-->
								<li>
									<figure class="left">
										<h2>Airline Details</h2>
										<p><b>AB 5047 MUC- LHR</b></p>
										<br />
										<h2>Duration of trip:</h2>
										<p><b>2 hours 00 minutes</b></p>
										<br />
										<a href="#" title="more info" class="more-info">
											1 Passenger. Airline's fare per passenger Tax included Service fees not included
										</a>
									</figure>
									<div class="meta">
										<h2>Departure</h2>
										<p><b>22:00 Friday, 5 April<br />Franz Josef Strauss (MUC)<br />(Munich - Germany)</b></p>
										<br />
										<h2>Arrival</h2>
										<p><b>22:00 Friday, 5 April<br />Franz Josef Strauss (MUC)<br />(Munich - Germany)</b></p>
									</div>
									<div class="room-information">
										<div class="row">
											<span class="first">Price:</span>
											<span class="second">$ 55</span>
										</div>
										<div class="row">
											<span class="first">Person:</span>
											<span class="second">01</span>
										</div>
									</div>
									<div class="more-information">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
								</li>
								<!--end of flight items-->
								<!--flight items-->
								<li>
									<figure class="left">
										<h2>Airline Details</h2>
										<p><b>AB 5047 MUC- LHR</b></p>
										<br />
										<h2>Duration of trip:</h2>
										<p><b>2 hours 00 minutes</b></p>
										<br />
										<a href="#" title="more info" class="more-info">
											1 Passenger. Airline's fare per passenger Tax included Service fees not included
										</a>
									</figure>
									<div class="meta">
										<h2>Departure</h2>
										<p><b>22:00 Friday, 5 April<br />Franz Josef Strauss (MUC)<br />(Munich - Germany)</b></p>
										<br />
										<h2>Arrival</h2>
										<p><b>22:00 Friday, 5 April<br />Franz Josef Strauss (MUC)<br />(Munich - Germany)</b></p>
									</div>
									<div class="room-information">
										<div class="row">
											<span class="first">Price:</span>
											<span class="second">$ 55</span>
										</div>
										<div class="row">
											<span class="first">Person:</span>
											<span class="second">01</span>
										</div>
									</div>
									<div class="more-information">
										<p>1 Passenger. Airline's fare per passenger Tax included Service fees not included</p>
									</div>
								</li>
								<!--end of flight items-->
							</ul>
						</article>
					</section>
					<!--END OF PREVIEW TAB TAB-->
					
					<!--PAYMENT TAB-->
					<section id="payment_tab" class="tab-content">
						<article>
							<h1>Payment</h1>
							<h2>Price Details</h2>
							<table>
								<thead>
									<tr>
										<td colspan="4" style="text-align:center">
											<b>Hotel Details</b>
										</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="background-color: #bdbdbd"><b>Item details</b></td>
										<td style="background-color: #bdbdbd"><b>Quantity</b></td>
										<td style="background-color: #bdbdbd"><b>Price</b></td>
										<td style="background-color: #bdbdbd"><b>Total price</b></td>
									</tr>
									<tr>
										<td>Hotel ABC</td>
										<td>1</td>
										<td>$50.00 per night</td>
										<td>$50.00</td>
									</tr>
									<tr>
										<td>Hotel ABC</td>
										<td>1</td>
										<td>$50.00 per night</td>
										<td>$50.00</td>
									</tr>
									<tr>
										<td>Hotel ABC</td>
										<td>1</td>
										<td>$50.00 per night</td>
										<td>$50.00</td>
									</tr>
								</tbody>
							</table>
							<br /><br />
							<table>
								<thead>
									<tr>
										<td colspan="4" style="text-align:center">
											<b>Flight Details</b>
										</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="background-color: #bdbdbd"><b>Item details</b></td>
										<td style="background-color: #bdbdbd"><b>Quantity</b></td>
										<td style="background-color: #bdbdbd"><b>Price</b></td>
										<td style="background-color: #bdbdbd"><b>Total price</b></td>
									</tr>
									<tr>
										<td>
											AB 5047 MUC- LHR
											<br />
											22:00 Friday, 5 April
											<br />
											(Singapore - Australia) (One-way)
										</td>
										<td>5</td>
										<td>$100.00</td>
										<td>$500.00</td>
									</tr>
									<tr>
										<td>
											AB 5047 MUC- LHR
											<br />
											22:00 Friday, 5 April - 22:00 Friday, 15 April
											<br />
											(Singapore - Australia) (Return)
										</td>
										<td>5</td>
										<td>$100.00</td>
										<td>$500.00</td>
									</tr>
								</tbody>
							</table>
							<br /><br />
							<div style="text-align:center">
								<h2>Grand total</h2>
								<span style="color:green; font-size:20px">$1150.00</span>
								<br /><br />
								<a href="<?php echo base_url(); ?>booking/index" class="gradient-button" title="Remove">
									Continue to payment
								</a>
							</div>
						</article>
					</section>
					<!--END OF PAYMENT TAB-->
					
					<!--CONFIRMATION TAB-->
					<section id="confirmation_tab" class="tab-content three-fourth">
						<article>
							<h1>Confirmation</h1>
							<form id="booking" method="post" action="#" class="booking">
								<div class="text-wrap">
									<table>
										<tr>
											<td style="border:none">
												<p>Thank you. Your booking is now confirmed.</p>
											</td>
											<td style="border:none">
												<div style="margin-top:-10px">
													<a href="#" class="gradient-button print" title="Print" onclick="printpage()">
														Print
													</a>
												</div>
											</td>
										</tr>
									</table>						
								</div>
								<h3>Traveller info</h3>
								<div class="text-wrap">
									<table>
										<tr>
											<td style="border:none">
												<p>Booking number:</p>
											</td>
											<td style="border:none">
												<p>904054553</p>
											</td>
										</tr>
										<tr>
											<td style="border:none">
												<p>Fist name:</p>
											</td>
											<td style="border:none">
												<p>John</p>
											</td>
										</tr>
										<tr>
											<td style="border:none">
												<p>Last name:</p>
											</td>
											<td style="border:none">
												<p>Livingston</p>
											</td>
										</tr>
										<tr>
											<td style="border:none">
												<p>E-mail address:</p>
											</td>
											<td style="border:none">
												<p>mail@google.com</p>
											</td>
										</tr>
										<tr>
											<td style="border:none">
												<p>Street Address and number:</p>
											</td>
											<td style="border:none">
												<p>Some street name 55</p>
											</td>
										</tr>
										<tr>
											<td style="border:none">
												<p>Town / City:</p>
											</td>
											<td style="border:none">
												<p>Sunnytown</p>
											</td>
										</tr>
										<tr>
											<td style="border:none">
												<p>ZIP code:</p>
											</td>
											<td style="border:none">
												<p>9500 - 100</p>
											</td>
										</tr>
										<tr>
											<td style="border:none">
												<p>Country:</p>
											</td>
											<td style="border:none">
												<p>Neverland</p>
											</td>
										</tr>
									</table>							
								</div>
								<h3>Special requirements</h3>
								<div class="text-wrap">
									<p>
										I would like to book a twin room with a definite sea view please. 
										Thank you and kind regards, John Livingston
									</p>
								</div>
								<h3>Payment</h3>
								<div class="text-wrap">
									<p>You have now confirmed and guaranteed your booking by credit card.<br />All payments are to be made at the hotel during your stay, unless otherwise stated in the hotel policies or in the room conditions.<br />Please note that your credit card may be pre-authorised prior to your arrival. </p>
									<p><strong class="dark">This hotel accepts the following forms of payment:</strong></p>
									<p>American Express, Visa, MasterCard</p>
								</div>
								<h3>Don’t forget</h3>
								<div class="text-wrap">
									<p>You can change or cancel your booking via our online self service tool myBookYourTravel:<br />
									<a href="#" class="turqouise-link">https://ctc.com.sg/booking/cancellation/432534523</a></p><br />
									<p><strong>We wish you a pleasant stay</strong><br /><i>CTC Travel team</i></p>
								</div>
							</form>
						</article>
					</section>
					<!--END OF CONFIRMATION TAB-->
					
				</section>
				<!--//hotel content-->
				<!--RIGHT SIDEBAR-->
				<aside class="right-sidebar">
					<article class="default clearfix">
						<h2>Need Help Booking?</h2>
						<p>Call our customer services team on the number below to speak to one of our advisors who will help you with all of your holiday needs.</p>
						<p class="number">1- 555 - 555 - 555</p>
					</article>
					<article class="default clearfix">
						<h2>Why Book with us?</h2>
						<h3>Low rates</h3>
						<p>Get the best rates, or get a refund.<br />No booking fees. Save money!</p>
						<h3>Largest Selection</h3>
						<p>140,000+ hotels worldwide<br />130+ airlines<br />Over 3 million guest reviews</p>
						<h3>We’re Always Here</h3>
						<p>Call or email us, anytime<br />Get 24-hour support before, during, and after your trip</p>
					</article>
				</aside>
				<!--END OF RIGHT SIDEBAR-->
			</div>
			<!--//main content-->
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
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/infobox.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js"></script>
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
		function initialize() {
			var secheltLoc = new google.maps.LatLng(49.47216, -123.76307);
			var myMapOptions = {
				 zoom: 15
				,center: secheltLoc
				,mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var theMap = new google.maps.Map(document.getElementById("map_canvas"), myMapOptions);
			var marker = new google.maps.Marker({
				map: theMap,
				draggable: true,
				position: new google.maps.LatLng(49.47216, -123.76307),
				visible: true
			});
			var boxText = document.createElement("div");
			boxText.innerHTML = "<strong>Best ipsum hotel</strong><br />1400 Pennsylvania Ave,<br />Washington DC<br />www.ctc.com.sg";
			var myOptions = {
				 content: boxText
				,disableAutoPan: false
				,maxWidth: 0
				,pixelOffset: new google.maps.Size(-140, 0)
				,zIndex: null
				,closeBoxURL: ""
				,infoBoxClearance: new google.maps.Size(1, 1)
				,isHidden: false
				,pane: "floatPane"
				,enableEventPropagation: false
			};
			google.maps.event.addListener(marker, "click", function (e) {
				ib.open(theMap, this);
			});
			var ib = new InfoBox(myOptions);
			ib.open(theMap, marker);
		}
	</script>
	<script>selectnav('nav'); </script>
</body>
</html>