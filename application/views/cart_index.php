<?php
$total_hotel_grand  = 0;
$total_flight_grand = 0;
$total_cruise_grand = 0;
$total_ltour_grand  = 0;
$cruiseExtra = 0;
?>
<!--BLUE COLOR: #3498db-->
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CTC Travel | My Cart</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css" media="screen,projection,print" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" />
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
	<style>.select_custom { width:100px; }</style>
	<style>h5 { color: #F7941D !important; font-size: 14px }</style>
	<link href="<?php echo base_url(); ?>assets/bootstrap/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<style>
		.modal {
			    display: none; /* Hidden by default */
			    position: fixed; /* Stay in place */
			    z-index: 1; /* Sit on top */
			    padding-top: 30px; /* Location of the box */
			    left: 0;
			    top: 0;
			    width: 100%; /* Full width */
			    height: 100%; /* Full height */
			    overflow: auto; /* Enable scroll if needed */
			    background-color: rgb(0,0,0); /* Fallback color */
			    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
			}
			.modal-content {
			    background-color: #fefefe;
			    margin: auto;
			    padding: 20px;
			    border: 1px solid #888;
			    width: 90%;
			    height: 85%;
			    overflow-y: scroll;
			}

			.close {
			    color: #aaaaaa;
			    float: right;
			    font-size: 28px;
			    font-weight: bold;
			}
			.close:hover, .close:focus {
			    color: #000;
			    text-decoration: none;
			    cursor: pointer;
			}
			.tab-content{
				display: none;
			}
		.ui-accordion .ui-accordion-header {
			font-size: 14px !important;
		}
		.error-checkout {
		    color: #a94442;
		    background-color: #f2dede;
		    border-color: #ebccd1;
		    padding: 15px;
		    margin-bottom: 20px;
		    border: 1px solid transparent;
		    border-radius: 4px;
		}
	</style>
	<script>
	function checkagreement(stats)
	{
		$('#divLoading2').show();
		$('.errcheck').hide();
		if(stats == 1) {
			location.href="<?php echo base_url(); ?>checkout/index";
		} else {
			if($('#agreerules').is(':checked')) {
				location.href="<?php echo base_url(); ?>checkout/index";
			} else {
				$('#divLoading2').hide();
				$('.errcheck').show();
			}
		}

	}
	</script>
</head>
<body>
	<div id="divLoading2" style="display:none; margin:0px; padding:0px; position:fixed; right:0px; top:0px; width:100%; height:100%; background-color: rgb(102, 102, 102); z-index:30001; opacity:0.8; display: none">
		<p style="position:absolute; color:white; top:50%; left:35%; padding:0px">
			Checking out your Item for payment.. Please wait..
			<br />
			<img src="<?php echo base_url(); ?>assets/progress_bar/ajax-loader.gif" style="margin-top:5px; margin: auto">
		</p>
	</div>

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
						<li><a href="<?php echo current_url(); ?>" title="">My Cart</a></li>
					</ul>
				</nav>
				<section class="three-fourth">
					<?php if($this->session->flashdata('error_checkout') != "") {?>
						<div class="error-checkout"><?php echo $this->session->flashdata('error_checkout');?></div>
					<?php }?>

					<nav class="inner-nav">
						<ul>
							<li class="description">
								<a href="#cruises_cart" title="Cruises Cart">Cruises</a>
							</li>
							<li class="description">
								<a href="#landtour_cart" title="Location">Land Tours</a>
							</li>
							<li class="description">
								<a href="#hotel_cart" title="Location">Hotel</a>
							</li>
							<li class="description">
								<a href="#flight_cart" title="Location">Flight</a>
							</li>
						</ul>
					</nav>
					<!--CRUISES CART-->
					<?php require_once(APPPATH."views/cart/cruise.php"); ?>
					<!--END OF CRUISES CART-->
					<!--LAND TOUR CART-->
					<?php require_once(APPPATH."views/cart/landtour.php"); ?>
					<!--END OF LAND TOUR CART-->
					<!--HOTEL CART-->
					<?php require_once(APPPATH."views/cart/hotel.php"); ?>
					<!--END OF HOTEL CART-->
					<!--FLIGHT CART-->
					<?php require_once(APPPATH."views/cart/flight.php"); ?>
					<!--END OF FLIGHT CART-->
				</section>
				<!--RIGHT SIDEBAR-->
				<aside class="right-sidebar">
					<article class="default clearfix">
						<h2>Cart Summary</h2>

						<!--SUMMARY TOTAL PRICE HOTEL-->
						<?php
						if( $this->session->userdata('shoppingCartCookie') == TRUE ) {
							if( count($this->session->userdata('shoppingCartCookie')) > 0 ) {
						?>
							<h3 style="text-align:center">Hotel Total Price</h3>
							<p style="text-align:center; font-size:18px">
								$<?php echo number_format($total_hotel_grand, 2); ?>
							</p>
							<p style="text-align:center; font-size:18px; margin-top:-15px">
								( <?php echo $hotelPaxRoom;?> Pax(s) )
							</p>
						<?php
							}
						}
						else {
						?>
							<h3 style="text-align:center">Hotel Total Price</h3>
							<p style="text-align:center; font-size:18px">
								$<?php echo number_format($total_hotel_grand, 2); ?>
							</p>
							<p style="text-align:center; font-size:18px">
								( <?php echo $hotelPaxRoom;?> Pax(s) )
							</p>
						<?php
						}
						?>
						<!--END OF SUMMARY TOTAL PRICE HOTEL-->

						<!--SUMMARY TOTAL PRICE FLIGHT-->
						<?php
						if( $this->session->userdata('shoppingCartFlightCookie') == TRUE ) {
							if( count($this->session->userdata('shoppingCartFlightCookie')) > 0 ) {
						?>
							<h3 style="text-align:center">Flight Total Price</h3>
							<p style="text-align:center; font-size:18px">
								$<?php echo number_format($total_flight_grand, 2); ?>
							</p>
						<?php
							}
						}
						else {
						?>
							<h3 style="text-align:center">Flight Total Price</h3>
							<p style="text-align:center; font-size:18px">
								$<?php echo number_format($total_flight_grand, 2); ?>
							</p>
						<?php
						}
						?>
						<!--END OF SUMMARY TOTAL PRICE FLIGHT-->

						<!--SUMMARY TOTAL PRICE CRUISE-->
						<?php
						if( $this->session->userdata('shoppingCartCruiseCookie') == TRUE ) {
							if( count($this->session->userdata('shoppingCartCruiseCookie')) > 0 ) {
						?>
							<h3 style="text-align:center">Cruise Total Price</h3>
							<p style="text-align:center; font-size:18px">
								$<?php echo number_format($total_cruise_grand+$cruiseExtra, 2); ?>
							</p>
						<?php
							}
						}
						else {
						?>
							<h3 style="text-align:center">Cruise Total Price</h3>
							<p style="text-align:center; font-size:18px">
								$<?php echo number_format($total_cruise_grand+$cruiseExtra, 2); ?>
							</p>
						<?php
						}
						?>
						<!--END OF SUMMARY TOTAL PRICE CRUISE-->

						<!--SUMMARY TOTAL PRICE LAND TOUR-->
						<?php
						if( $this->session->userdata('shoppingCartLandtourCookie') == TRUE ) {
							if( count($this->session->userdata('shoppingCartLandtourCookie')) > 0 ) {
						?>
							<h3 style="text-align:center">Land Tour Total Price</h3>
							<p style="text-align:center; font-size:18px">
								$<?php echo number_format($totalGrandPrice, 2); ?>
							</p>
						<?php
							}
						}
						else {
						?>
							<h3 style="text-align:center">Land Tour Total Price</h3>
							<p style="text-align:center; font-size:18px">
								$<?php echo number_format($totalGrandPrice, 2); ?>
							</p>
						<?php
						}
						?>
						<!--END OF SUMMARY TOTAL PRICE LAND TOUR-->

						<!--
						<h3 style="text-align:center">Land Tour Total Price</h3>
						<p style="text-align:center; font-size:18px">$0.00</p>
						-->

						<h3 style="text-align:center">Grand total</h3>
						<p style="text-align:center; font-size:18px; color:green">
							<b>$<?php echo number_format($total_hotel_grand+$totalGrandPrice+$total_cruise_grand+$total_flight_grand+$cruiseExtra, 2); ?></b>
						</p>

						<p style="text-align:center">
							<button class="btn gradient-button view-rules" title="Checkout Payment" data-toggle="modal" data-target="#rulesModal" style="border:none">Checkout</button>
						</p>

					</article>
					<article class="default clearfix">
						<h2>Need Help Booking?</h2>
						<p>Call our customer services team on the number below to speak to one of our advisors who will help you with all of your holiday needs.</p>
						<p>Please call our sale consultant if your total purchase is above $3000</p>
						<p class="number">+65 6216-3456</p>
					</article>
				</aside>
				<!--END OF RIGHT SIDEBAR-->
			</div>
		</div>
	</div>
	<!-- Modal content-->
	<div id="divLoading3" style="display:none; margin:0px; padding:0px; position:fixed; right:0px; top:0px; width:100%; height:100%; background-color: rgb(102, 102, 102); z-index:30001; opacity:0.8;">
		<p style="position:absolute; color:white; top:45%; left:45%; padding:0px" class="loading-content">
			Loading.. Please Wait..
			<br />
			<img src="<?php echo base_url(); ?>assets/progress_bar/ajax-loader.gif" style="margin-top:5px">
		</p>
	</div>

	<!-- Modal -->
	<div id="rulesModal" class="modal fade" role="dialog" style="z-index: 1000 !important" tabindex="-1" aria-labelledby="Fare Flight Rules">
	  <div class="modal-dialog" id="rules-dialog">

	    <!-- Modal content-->
	    <div class="modal-content" style="display:none; width: 85%; margin: 0 auto; max-height: 500px !important; overflow-y: auto; padding: 25px">
	      <div class="modal-header">
	        <button id="btnRulesModal" type="button" class="close" data-dismiss="modal">&times;</button>

	        <h4 class="modal-title">Air Flight Rules</h4>
	        <span class="errcheck" style="color:red; display: none">* Please check the agreement first before checkout</span>
	      </div>
	      <div class="modal-body rules-body">
	      </div>
	      <div style="margin-bottom: 10px">
		      <article class="default clearfix" style="width: 100%;background: #fff;padding: 0;margin: 0;text-align: left">
					<h2 style="padding: 5px">Important Reminders</h2>
					<p style="padding:0"><b>1.</b> Names must be in sequence according to passport.</p>
					<p style="padding:0"><b>2.</b> Name change is strictly not permitted once reservation is made.</p>
					<p style="padding:0"><b>3.</b> Passports must be valid for at least 6 months for the duration of travel.</p>
					<p style="padding:0"><b>4.</b> Ensure that you have applied for entry visas for countries (if applicable)</p>
				</article>
	      </div>
	      <div class="modal-footer">
	      	<div style="float:left">
	          	<input type="checkbox" name="" required id="agreerules"/>
				&nbsp;
				<span style="font-size:13px; color:rgb(255, 145, 38)">
					<b>
						<label for="agreerules">
						I acknowledge that I have read and agree to the Fare Rules
						</label>
					</b>
				</span>
			</div>
			<div style="float:right">
				<button class="gradient-button go-print" style="border:none">Print Fare Rules</button>
				&nbsp;&nbsp;
				<a href="#" class="gradient-button" title="Remove" onclick="checkagreement(0)">Continue Checkout & Payment Page</a>
				&nbsp;&nbsp;
				<a href="#" class="close gradient-button" data-dismiss="modal" style="font:normal 11px/30px 'OpenSansBold' !important; color: #FFFFFF">Cancel</a>
			</div>
			<div style="clear:both"></div><br>

	      </div>
	    </div>
	  </div>
	</div>

	<!--FOOTER-->
	<?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
	<!--END OF FOOTER-->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/infobox.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.go-print').on('click', function(){
				var w = window.open("<?php echo base_url()?>cart/flightrules/1", "_blank");
			    w.focus();
			   	setTimeout(function () { w.print(); }, 1);
			});

			$('.view-rules').on('click', function(){
		        <?php if( $this->session->userdata('shoppingCartFlightCookie') == TRUE ) {?>
				$('#divLoading3').show();
		        $( ".rules-body" ).load( "<?php echo base_url();?>cart/flightrules",
		        	/*{
		        		fb : datafb,
		        		mc : datamc,
		        		df : datadf,
		        		oc : dataoc,
		        		dc : datadc
		        	}*/
		        	function(response, status, xhr) {
		        	if(status == 'error') {
		        		$(this).html('You are not authorized [102]');
		        	} else {
		        		if(response.nodata == true) {
		        			checkagreement(1);
		        		}
					}
					$('#divLoading3').hide();
					$('#rulesModal .modal-content').show();
					$('#rulesModal').modal({
					    show:true,
					    backdrop:true,
					    keyboard:true,
					    open: function(){
				        	/*$("#accordion").accordion({ autoHeight: true });*/
				      	}
					});
				});
				<?php } else {?>
					location.href="<?php echo base_url(); ?>checkout/index";
				<?php } ?>
		    });

		     /* rules */
		    var modal2  = document.getElementById('rulesModal');
		    var btn2  = document.getElementById("btnRulesModal");
		    var dlg = document.getElementById('rules-dialog');
		    btn2.onclick = function() {
		        modal2.style.display = "block";
		    }
		    /*
		    dlg.onclick = function() {
		        modal2.style.display = "none";
		    }*/
		    window.onclick = function(event) {
		        if (event.target == modal2) {
		            modal2.style.display = "none";
		        }
		    }


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
		                remember_me: $('#login_checkbox:checked').val(),
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
</body>
</html>