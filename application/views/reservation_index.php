<?php
	//prevent notice + message error
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	//end of prevent notice + message error
	function UR_exists($url)
	{
	   $headers=get_headers($url);
	   return stripos($headers[0],"200 OK")? true : false;
	}
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
	<title>CTC Travel | Check order reservation</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css?<?php echo uniqid(); ?>" type="text/css" media="screen,projection,print" />
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
	<?php require_once(APPPATH."views/master-frontend/header.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>
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
						<li><a href="#" title="">Check order status</a></li>                                 
					</ul>
				</nav>
				<!--END OF BREADCUMBS-->

				<!--hotel three-fourth content-->
				<section class="three-fourth">				
					<!--CHECK ORDER FORM-->
					<section class="tab-content" style="width:auto">
						<article>					
							<h1>Check your order status</h1>
							<?php echo $this->session->flashdata('wrongEmailReservation'); ?>
							<?php echo $this->session->flashdata('wrongBookingIDReservation'); ?>
							<?php echo form_open_multipart('reservation/getRecord', array('class' => 'booking', 'style' => 'box-shadow:none')); ?>
								<fieldset>
									<div class="row twins">
										<!--
										<div class="f-item" style="width: 75%">
											<label for="first_name">Select product</label>
											<select name="choose_product" style="width:50%; height:30px" required>
												<option value="">Choose product</option>
												<option value="cruise">Cruise</option>
												<option value="flight">Flight</option>
												<option value="hotel">Hotel</option>
												<option value="land_tour">Land Tour</option>
											</select>
										</div>
										-->
										<div class="f-item" style="width: 75%">
											<label for="first_name">Enter your email address</label>
											<input type="email" required name="order_email_address" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" value="<?php echo base64_decode(base64_decode(base64_decode($this->uri->segment(3)))); ?>" />
										</div>
										<div class="f-item" style="width: 75%">
											<label for="last_name">Enter your booking reference ID</label>
											<input type="text" required name="order_booking_reference" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" value="<?php echo base64_decode(base64_decode(base64_decode($this->uri->segment(4)))); ?>" />
										</div>
										<div class="f-item" style="width: 75%; margin-top:-15px">
											<input type="submit" class="gradient-button" value="Find record" id="next-step" />
										</div>
									</div>
								</fieldset>
							<?php echo form_close(); ?>		
							<br />
							<?php
							if( $this->uri->segment(3) == TRUE && $this->uri->segment(4) == TRUE && $this->uri->segment(5) == TRUE ) {
								$bookingOrderID = base64_decode(base64_decode(base64_decode($this->uri->segment(4))));
								$confirms = $this->All->select_template("BookingOrderID", $bookingOrderID, "confirmedBookOrder");
								foreach( $confirms AS $confirm ) {
									$confirmBookingID = $confirm->id;
								}
								$total_cruise_grand = 0;
							?>
								<?php require_once(APPPATH."views/reservation/cruise.php"); ?>
								<?php require_once(APPPATH."views/reservation/landtour.php"); ?>
								<?php require_once(APPPATH."views/reservation/hotel.php"); ?>
								<?php require_once(APPPATH."views/reservation/flight.php"); ?>
								<?php require_once(APPPATH."views/reservation/contact_info.php"); ?>
								<br />
								<br />
							<?php
							}
							?>
						</article>
					</section>
					<!--END OF CHECK ORDER FORM-->
				</section>
				<!--//hotel content-->
				<!--RIGHT SIDEBAR-->
				<aside class="right-sidebar">
					<article class="default clearfix">
						<h2>Need Help Booking?</h2>
						<p>Call our customer services team on the number below to speak to one of our advisors who will help you with all of your holiday needs.</p>
						<p>Please call our sale consultant if your total purchase is above $3000</p>
						<p class="number">+65 6216 3459</p>
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
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/infobox.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts-no-uniform.js"></script>
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
</body>
</html>