<?php
	/* just to make sure */
	$first_name 	= "";
	$last_name 		= "";
	$address	 	= "";
	$email_address 	= "";
	$contact_no 	= "";
	$nric_no 		= "";
	$passport_no 	= "";
	$country 		= "";
	if( $this->session->userdata("normal_session_id") == TRUE ) {
		$this->db->select('*');
	    $this->db->from('user_access');
	    $this->db->where('id', $this->session->userdata('normal_session_id'));
	    $query = $this->db->get();
	    if( $query->num_rows() > 0 ) {
	        $dataProfile 	= $query->row();
	        $first_name 	= $dataProfile->first_name;
	        $last_name 		= $dataProfile->last_name;
	        $address 		= $dataProfile->admin_address;
	        $email_address 	= $dataProfile->email_address;
	        $contact_no 	= $dataProfile->admin_contact;
	        $nric_no 		= $dataProfile->nric;
	        $passport_no 	= $dataProfile->passport_no;
	        $country 		= $dataProfile->nationality;
	        $this->db->select('*');
		    $this->db->from('country');
		    $this->db->where('country_name', $country);
		    $query = $this->db->get();
		    if( $query->num_rows() == 0 ) {
		    	$country = 'Singapore';
		    }
	    }
	}
    $countryList = array('Singapore' => 'Singapore');
    $this->db->select('*');
    $this->db->from('country');
    $querycountry = $this->db->get();
    if( $querycountry->num_rows() > 0 ) {
    	$countryList = $querycountry->result_array();    	
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
	<title>CTC Travel | My Profile</title>
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
	<?php require_once(APPPATH."views/master-frontend/header.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>
	<div class="main" role="main">		
		<div class="wrap clearfix">
			<div class="content clearfix">
				
				<!--BREADCUMBS-->
				<nav role="navigation" class="breadcrumbs clearfix">
					<ul class="crumbs">
						<li><a href="#" title="">You are here:</a></li>
						<li><a href="#" title="">Home</a></li>
						<li><a href="#" title="">My Details</a></li>                                 
					</ul>
				</nav>
				<!--END OF BREADCUMBS-->

				<!--hotel three-fourth content-->
				<section class="three-fourth">
					<!--inner navigation-->
					<nav class="inner-nav">
						<ul>
							<li class="description">
								<a href="#info_details_tab" title="My Profile">My Profile</a>
							</li>
							<li class="description">
								<a href="#change_password_tab" title="Change Password">Change Password</a>
							</li>
							<!-- <li class="description">
								<a href="#my_bookings_tab" title="My Bookings">My Bookings</a>
							</li>
							<li class="description">
								<a href="#my_reviews_tab" title="My Reviews">My Reviews</a>
							</li> -->
						</ul>
					</nav>
					<!--//inner navigation-->		
					<!--MY PROFILE TAB-->
					<section id="info_details_tab" class="tab-content three-fourth">
						<article>					
							<h1>Edit your profile</h1>
							<?php echo $this->session->flashdata('profile_updated');?>
							<?php echo $this->session->flashdata('error_update_profile');?>
							
							<?php echo form_open(site_url('account/saveprofile'), array(
								'class' => "booking",
								'id'=> 'form-profile',
								'style' => "box-shadow:none")
							);
							?>
								<fieldset>
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="first_name">First name</label>
											<input type="text" id="first_name" name="first_name" style="height:18px" required value="<?php echo $first_name;?>"/>
										</div>
										<div class="f-item" style="width: 48%">
											<label for="last_name">Last name</label>
											<input type="text" id="last_name" name="last_name" style="height:18px"  value="<?php echo $last_name;?>"/>
										</div>
									</div>		
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="email">Email address</label>
											<input type="email" id="email" name="email" style="height:18px" required value="<?php echo $email_address;?>" />
										</div>
										<div class="f-item" style="width: 48%">
											<label for="contact_no">Contact no.</label>
											<input type="text" id="contact_no" name="contact_no" style="height:18px" required value="<?php echo $contact_no;?>"/>
										</div>
									</div>
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="nric">NRIC</label>
											<input type="text" id="nric" name="nric" style="height:18px"  required value="<?php echo $nric_no;?>"/>
										</div>
										<div class="f-item" style="width: 48%">
											<label for="passport_no">Passport no.</label>
											<input type="text" id="passport_no" name="passport_no" style="height:18px"  required value="<?php echo $passport_no;?>"/>
										</div>

										
									</div>
									<div class="row twins">
										<div class="f-item" style="width: 48%">
											<label for="country">Country</label>
											<select name="country" id="country">
											<?php
											foreach($countryList as $countries) {
												echo '<option value="'.$countries['country_name'].'" '.($country == $countries['country_name'] ? 'selected' : '').'>'.$countries['country_name'].'</option>';		
									    	}
									    	?>
											</select>
										</div>
										<div class="f-item" style="width: 48%">
											<label for="address">Address</label>
											<textarea name="address" id="address" style="height:60px"><?php echo $address;?></textarea>
										</div>
									</div>
								</fieldset>								
								<div style="text-align:center">
									<input type="submit" class="gradient-button" name="saveprofile" value="Save changes" id="save-profile" />
								</div>
							<?php echo form_close();?>
							<br />
						</article>
					</section>
					<!--END OF MY PROFILE TAB-->
					
					<!--CHANGE PASSWORD TAB-->
					<section id="change_password_tab" class="tab-content">
						<article>					
							<h1>Change password</h1>							
							<?php echo $this->session->flashdata('password_updated');?>
							<?php echo $this->session->flashdata('error_update_password');?>
							<?php echo form_open(site_url('account/savepassword'), array(
								'class' => "booking",
								'id'=> 'form-password',
								'style' => "box-shadow:none")
							);
							?>
								<fieldset>
									<div class="row twins">
										<div class="f-item" style="width: 75%">
											<label for="curr_password">Current password</label>
											<input type="password" id="current_password" name="current_password" style="height:18px" required/>
										</div>
										<div class="f-item" style="width: 75%">
											<label for="new_password">New password</label>
											<input type="password" id="new_password" name="new_password" style="height:18px" required/>
										</div>
									</div>		
									<div class="row twins">
										<div class="f-item" style="width: 75%">
											<label for="retype_password">Retype new password</label>
											<input type="password" id="retype_password" name="retype_password" style="height:18px" required/>
										</div>
									</div>
								</fieldset>							
								<div style="text-align:center">
									<input type="submit" name="savepassword" class="gradient-button" value="Save changes" id="save-password" />
								</div>
							<?php echo form_close();?>
							<br />
						</article>
					</section>
					<!--END OF CHANGE PASSWORD TAB-->
					
					<!--MY BOOKINGS TAB
					<section id="my_bookings_tab" class="tab-content">
						<article class="bookings">
							<h1><a href="#">Hotel ABC</a></h1>
							<div class="b-info">
								<table>
									<tr>
										<th style="width:30%">Booking no.</th>
										<td>123378673755</td>
									</tr>
									<tr>
										<th style="width:25%">Room</th>
										<td>Twin room with balcony</td>
									</tr>
									<tr>
										<th style="width:25%">Check-in Date</th>
										<td>23-05-14</td>
									</tr>
									<tr>
										<th style="width:25%">Check-out Date</th>
										<td>30-05-14</td>
									</tr>
									<tr>
										<th style="width:25%">Total Price:</th>
										<td><strong>$ 55,00</strong></td>
									</tr>
								</table>
							</div>
							
							<div class="actions">
								<a href="#" class="gradient-button">Print booking</a>
								<a href="#" class="gradient-button">Cancel booking</a>
								<a href="#" class="gradient-button">Report</a>
							</div>
						</article>
					</section>
					END OF MY BOOKINGS TAB-->
					
					<!--MY REVIEWS TAB
					<section id="my_reviews_tab" class="tab-content three-fourth">
						<article class="myreviews">
							<h1>Hotel ABC</h1>
							<div class="score">
								<span class="achieved">8 </span>
								<span> / 10</span>
							</div>
							<div class="reviews">
								<div class="pro"><p>It was a warm friendly hotel. Very easy access to shops and underground stations. Staff very welcoming.</p></div>
								<div class="con"><p>noisy neigbourghs spoilt the rather calm environment</p></div>
							</div>
						</article>
						<article class="myreviews">
							<h1>Hotel ABC</h1>
							<div class="score">
								<span class="achieved">8 </span>
								<span> / 10</span>
							</div>
							<div class="reviews">
								<div class="pro"><p>It was a warm friendly hotel. Very easy access to shops and underground stations. Staff very welcoming.</p></div>
								<div class="con"><p>noisy neigbourghs spoilt the rather calm environment</p></div>
							</div>
						</article>
						<article class="myreviews">
							<h1>Hotel ABC</h1>
							<div class="score">
								<span class="achieved">8 </span>
								<span> / 10</span>
							</div>
							<div class="reviews">
								<div class="pro"><p>It was a warm friendly hotel. Very easy access to shops and underground stations. Staff very welcoming.</p></div>
								<div class="con"><p>noisy neigbourghs spoilt the rather calm environment</p></div>
							</div>
						</article>
					</section>
					END OF MY REVIEWS TAB-->
					
				</section>
				<!--//hotel content-->
				<!--RIGHT SIDEBAR-->
				<aside class="right-sidebar">
					<article class="default clearfix">
						<h2>Need Help Booking?</h2>
						<p>Call our customer services team on the number below to speak to one of our advisors who will help you with all of your holiday needs.</p>
						<p>Please call our sale consultant if your total purchase is above $3000</p>
						<p class="number">+65 6216-3456</p>
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
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js"></script>
	<script>selectnav('nav'); </script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#form-profile').on('submit', function() {				
				if ( $('#first_name', '#form-profile').val() == "") {
					alert('First name is required');
					return false;
				} else if($("#email", '#form-profile').val() == "") {
					alert('email address is required');
					return false;

				} else if($("#nric", '#form-profile').val() == "") {
					alert('NRIC is required');
					return false;

				} else if($("#passport_no", '#form-profile').val() == "") {
					alert('Passport No. is required');
					return false;
				} else {
					return true;
				}
			});
			$('#form-password').on('submit', function() {
				if ( $('#current_password').val() == "" || $("#new_password").val() == "" || $("#retype_password").val() == "") {
					alert('Check your password. Current / New / Retype password is required');
					return false;
				} else if ($("#new_password").val() !== $("#retype_password").val() ) {
					alert('Check your password.  New & Retype password is not match');
					return false;
				} else {
					return true;
				}
			});
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