<?php
	$total_hotel_grand  = 0;
	$total_flight_grand = 0;
	$total_cruise_grand = 0;
	$total_ltour_grand  = 0;
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
	<title>CTC Travel | Payment Notification</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css?id=<?php echo uniqid(); ?>" type="text/css" media="screen,projection,print" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fontawesome.css?id=<?php echo uniqid(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/newtable.css?id=<?php echo uniqid(); ?>" type="text/css" />
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
	<style>
	.grand-total {margin-top:50px;}
	.not-print {
		 text-align:left; margin-top:20px;
	}
		@media print {
			* {
			    /*display:inline;*/
			}
			.main {
				padding: 0 !important; margin: 0 !important;
			}
			.wrap { padding: 0 !important; margin: 0 !important; }
			.not-print {
				margin-top:0; margin-bottom: 0;
			}
			.grand-total {margin-top: 0 !important;}
			script, style {
			    display:none;
			}
			header nav, footer {
				display: none;
			}
			article {margin-bottom: 0 !important;}
			@page {
			  size: A4;
			  margin: 1.08cm 1.5cm 2.1cm 1.5cm;
			}
			/*@page :left {
			  margin-left: 1.5cm;
			}

			@page :right {
			  margin-left: 1.5cm;
			}*/

			h1 {
			  page-break-before: always;
			  margin: 2px !important;
			  padding: 2px !important;
			}
			/* To avoid breaks directly after a heading, use page-break-after. */
			h1, h2, h3, h4, h5, br, hr, section, article {
			  page-break-after: avoid;
			}
			table, figure {
			  page-break-inside: avoid;
			}
			div {
				/*display: tabl;*/
				page-break-before: avoid;
		        page-break-after: always;
		    }
		    div > table {
		    	page-break-inside: avoid;
		    }

		    div > table > tr {
		    	/*display: table-row;*/
		    	page-break-inside: avoid;
		    	page-break-before: avoid;
		    	page-break-after: auto;
		    }/*

		    div > table > tr > td > img {
		    	page-break-before: always;
		    	page-break-inside: avoid;
		    }*/
			/*table { page-break-inside:auto; page-break-before: always;}
	   		tr    { page-break-inside:auto; page-break-after:auto; }
	   		.tab {  page-break-inside:auto; page-break-after:auto;}*/
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
			font-size: 14px
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
						<li><a href="<?php echo base_url(); ?>" title="">Home</a></li>
						<li><a href="#" title="">Confirmation Order</a></li>
					</ul>
				</nav>
				<?php
				$bookingOrderID = base64_decode(base64_decode(base64_decode($this->uri->segment(3))));
				$paymentReferences = $this->All->select_template("bookOrderID", $bookingOrderID, "payment_reference");
				if( $paymentReferences == TRUE ) {
					foreach( $paymentReferences AS $paymentReference ) {
						$tmStatus 	= $paymentReference->TM_Status;
						$tmError  	= $paymentReference->TM_Error;
						$tmErrorMsg = $paymentReference->TM_ErrorMsg;
					}
				}
				?>
				<section class="full-width">
					<section id="hotels_cart" class="tab-content" style="width:100%">
						<article>
						<?php
						if( $paymentReferences == TRUE ) {
						?>
							<?php
							if( $tmStatus == "YES" ) {
							?>
								<h2 style="text-align:center"><br />Thank you for your booking.<br /></h2>
								<br />
							<?php
							}
							else {
							?>
								<h2 style="text-align:center"><br />Payment is unsuccessful.<br /></h2>
								<br />
							<?php
							}
							?>
							<?php
							if( $tmStatus == "YES" ) {
							?>
								<?php
								$confirms = $this->All->select_template("BookingOrderID", $bookingOrderID, "confirmedBookOrder");
								if( $confirms == TRUE ) {
									foreach( $confirms AS $confirm ) {
										$confirmBookingID = $confirm->id;
										$grandTotalList   = ceil($confirm->granTotalPrice);
									}
								}
								?>
								<?php require_once(APPPATH."views/payment_success/success_cruise.php"); ?>
								<?php require_once(APPPATH."views/payment_success/success_landtour.php"); ?>
								<?php require_once(APPPATH."views/payment_success/success_hotel.php"); ?>
								<?php require_once(APPPATH."views/payment_success/success_flight.php"); ?>
								<?php require_once(APPPATH."views/payment_success/success_contact_info.php"); ?>
								<h2 style="text-align:right" class="grand-total">Grand Total List</h2>
								<div>
									<div style="float:right !important; font-size:20px; margin-top:2px; text-align: left">
										<b style="color:green">
											Total Price: $<?php echo number_format($grandTotalList, 2); ?>
										</b>
									</div>
									<div style="clear:both"></div>
								</div>

									<!--CRUISE SPECIAL INSTRUCTION-->
									<?php
									$cruiseChecks = $this->All->select_template(
										"cruise_confirmedBookOrder_ID", $confirmBookingID, "cruise_historyOrder"
									);
									if( $cruiseChecks == TRUE ) {
										$cruiseSpecials = $this->All->select_template_with_where_and_order(
											"type", "CRUISE", "order_no", "ASC",  "special_instruction"
										);
										if( $cruiseSpecials == TRUE ) {
									?>
										<div>
											<h2 style="color:black">Special Instruction for Cruise</h2>
											<ul style="font-size:11px; margin-left:18px">
												<?php
												foreach( $cruiseSpecials AS $cruiseSpecial ) {
												?>
													<li style="list-style-type:square;">
														<?php echo $cruiseSpecial->instruction_content; ?>
													</li>
												<?php
												}
												?>
											</ul>
										</div>
									<?php
										}
									}
									?>
									<!--END OF CRUISE SPECIAL INSTRUCTION-->

									<!--LANDTOUR SPECIAL INSTRUCTION-->
									<?php
									$landtourChecks = $this->All->select_template(
										"landtour_confirmedBookOrder_ID", $confirmBookingID, "landtour_history_order"
									);
									if( $landtourChecks == TRUE ) {
										$landtourSpecials = $this->All->select_template_with_where_and_order(
											"type", "LANDTOUR", "order_no", "ASC",  "special_instruction"
										);
										if( $landtourSpecials == TRUE ) {
									?>
										<div>
											<br /><br />
											<h2 style="color:black">Special Instruction for Landtour</h2>
											<ul style="font-size:11px; margin-left:18px">
												<?php
												foreach( $landtourSpecials AS $landtourSpecial ) {
												?>
													<li style="list-style-type:square;">
														<?php echo $landtourSpecial->instruction_content; ?>
													</li>
												<?php
												}
												?>
											</ul>
										</div>
									<?php
										}
									}
									?>
									<!--END OF LANDTOUR SPECIAL INSTRUCTION-->
									<!--ADDITIONAL INSTRUCTIONS-->
									<div style="text-align:center; font-size:18px; font-weight:bold">
										<br />
										Your booking is being processed, our online team will revert on your booking confirmation shortly and you may contact us at +65 6216 3456.
									</div>
									<!--END OF ADDITIONAL INSTRUCTIONS-->
						<?php
							}
							else {
						?>
								<h1>Error Notification</h1>
								<div style="text-align:center">
									<span style="font-size:16px; font-weight:bold">
										<span style="color:red">TRANSACTION FAILED (Error Code: <?php echo $tmError; ?>)</span>
									</span>
								</div>
						<?php
							}
						}
						else {
						?>
							<h1>Error Notification</h1>
							<div style="text-align:center">
								<span style="font-size:16px; font-weight:bold">
									<span style="color:red">Internal error occurred. Please contact info@ctc.com.sg</span>
								</span>
							</div>
						<?php
						}
						?>
						</article>
					</section>
					<?php
					if( $paymentReferences == TRUE ) {
						if( $tmStatus == "YES" ) {
					?>
							<div style="text-align:center">
								<a href="<?php echo base_url(); ?>" class="gradient-button" style="border:none">
									Back to home
								</a>
								&nbsp;&nbsp;
								<!-- <a href="#" onClick="window.print()" class="gradient-button" style="border:none">
									Print Voucher
								</a> -->
							</div>
						<?php
						}
						else {
						?>
							<div style="text-align:center">
								<a href="<?php echo base_url(); ?>" class="gradient-button" style="border:none">
									Back to home
								</a>
								&nbsp;&nbsp;
								<a href="<?php echo base_url(); ?>checkout/index" class="gradient-button" style="border:none">
									Back to checkout
								</a>
							</div>
						<?php
						}
					}
					else {
					?>
						<div style="text-align:center">
							<a href="<?php echo base_url(); ?>" class="gradient-button" style="border:none">
								Back to home
							</a>
							&nbsp;&nbsp;
							<a href="<?php echo base_url(); ?>checkout/index" class="gradient-button" style="border:none">
								Back to checkout
							</a>
						</div>
					<?php
					}
					?>
				</section>
			</div>
		</div>
	</div>
	<?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
	<script src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/sequence.jquery-min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/sequence.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.js"></script>
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
	<script type="text/javascript">
		/* removing all session storage */
		sessionStorage.clear();

		$("a#specialRequest").click(function(){
			 var $this = $(this);
			 $this.next().toggle();
			 return false;
		});
	</script>
</body>
</html>