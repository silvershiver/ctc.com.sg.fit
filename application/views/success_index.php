<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CTC Travel | Order Confirmation</title>
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
	<style>.select_custom { width:100px; }</style>
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
						<li><a href="#" title="">Order Confirmation</a></li>                                 
					</ul>
				</nav>
				<section class="full-width">
					<section class="tab-content" style="width:auto">
						<article>					
							<h1 style="text-align:center">Confirmed Booking Order - Landtour</h1>
							<ul class="room-types">
								<?php
								$total_hotel_grand = 0;
								$order_hotels = $this->All->select_template(
									"hotel_confirmedBookOrder_ID", base64_decode(base64_decode(base64_decode($this->uri->segment(3)))), 
									"hotel_historyOder"
								);
								if( $order_hotels == TRUE ) {
									foreach( $order_hotels AS $order_hotel ) {
								?>
								<!--cart item-->
								<li>
									<!--
									<figure class="left" style="width:auto">
										<img src="<?php echo $order_hotel->hotel_Image; ?>" alt="" width="125" height="115" />
										<a href="<?php echo $order_hotel->hotel_Image; ?>" class="image-overlay" rel="prettyPhoto[gallery1]"></a>
									</figure>
									-->
									<div class="meta" style="width:auto">
										<h2><?php echo $order_hotel->hotel_Fullname; ?></h2>
										<table>
											<tr>
												<td>Check-in</td>
												<td style="text-align:center">
													<b style="color:green"><?php echo date("d M Y", strtotime($order_hotel->check_in_date)); ?></b>
												</td>
												<td>Check-out</td>
												<td style="text-align:center">
													<b style="color:green"><?php echo date("d M Y", strtotime($order_hotel->check_out_date)); ?></b>
												</td>
											</tr>
											<tr>
												<td>Room type</td>
												<td style="text-align:center">
													<b style="color:green"><?php echo $order_hotel->hotel_RoomType; ?></b>
												</td>
												<td>Duration</td>
												<td style="text-align:center">
													<b style="color:green"><?php echo $order_hotel->duration; ?> day(s)</b>
												</td>
											</tr>
										</table>
									</div>
									<div class="room-information" style="height:112px">
										<div class="row">
											<span class="first">Max:</span>
											<span class="second"><img src="<?php echo base_url(); ?>assets/images/ico/person.png" alt="" /><img src="<?php echo base_url(); ?>assets/images/ico/person.png" alt="" /></span>
										</div>
										<div class="row">
											<span class="first">Rooms:</span>
											<span class="second">
												0<?php echo $order_hotel->hotel_RoomQuantity; ?>
											</span>
										</div>				
										<div class="row">
											<span class="first">Price:</span>
											<span class="second">
												<?php echo number_format($order_hotel->hotel_PricePerRoom, 2); ?>
											</span>
										</div>
										<div class="row">
											<span class="first">Total:</span>
											<span class="second">
												<?php
												$total_hotel_grand += $order_hotel->hotel_PricePerRoom*$order_hotel->duration*$order_hotel->hotel_RoomQuantity;
												echo number_format($order_hotel->hotel_PricePerRoom*$order_hotel->duration*$order_hotel->hotel_RoomQuantity, 2); 
												?>
											</span>
										</div>
									</div>
								</li>
								<!--end of cart item-->
								<?php
									}
								}
								?>
							</ul>
							<h1 style="text-align:center">Grand Total List</h1>
							<div>
								<table>
									<tr>
										<td style="text-align:center; font-size:16px">
											Status: <b style="color:green">CONFIRMED</b>
										</td>
									</tr>
									<tr>
										<td style="text-align:center; font-size:16px">
											Grand total price: <b style="color:green">$<?php echo number_format($total_hotel_grand, 2); ?></b>
										</td>
									</tr>
								</table>
								<br />
								<div style="text-align:center">
									<button onclick="window.print();" class="gradient-button" style="border:none">
										Print Itinerary
									</button>
									&nbsp;
								</div>
							</div>
						</article>
					</section>
					<!--END OF HOTELS TAB-->					
				</section>
			</div>
		</div>
	</div>
	<?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
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
	<script>selectnav('nav'); </script>
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