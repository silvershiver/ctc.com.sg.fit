<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CTC Travel | Contact us</title>
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
	
	<!--SESSION CHECK-->
	<?php if( $this->session->flashdata('success_send_contact_support') == TRUE ) { ?>
	<div class="lightbox" style="display:block;">
		<div class="lb-wrap">
			<a href="#" class="close">x</a>
			<div class="lb-content">
				<form>
					<h1>Notification</h1>
					<?php echo $this->session->flashdata('success_send_contact_support'); ?>
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
	<!--END OF SESSION CHECK-->
	
	<!--MAIN-->
	<div class="main" role="main">		
		<div class="wrap clearfix">
			<div class="content clearfix">
				<nav role="navigation" class="breadcrumbs clearfix">
					<ul class="crumbs">
						<li><a href="<?php echo base_url(); ?>" title="Home">Home</a></li> 
						<li><a href="<?php echo base_url(); ?>contact" title="Contact">Contact</a></li>                                       
					</ul>
				</nav>
				<section class="three-fourth">
					<h1>Contact us</h1>
					<div class="map-wrap">
						<div id="google_maps">
							<iframe width="825" height="720" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=133+New+Bridge+Road+Singapore&amp;aq=1&amp;oq=133+new+bridge+road&amp;sll=37.0625,-95.677068&amp;sspn=41.903538,74.882813&amp;ie=UTF8&amp;hq=&amp;hnear=133+New+Bridge+Rd,+Singapore+059413&amp;t=m&amp;ll=1.285378,103.845005&amp;spn=0.015446,0.020578&amp;z=16&amp;output=embed"></iframe>
							<br/>
		                    <small>
		                        <a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=133+New+Bridge+Road+Singapore&amp;aq=1&amp;oq=133+new+bridge+road&amp;sll=37.0625,-95.677068&amp;sspn=41.903538,74.882813&amp;ie=UTF8&amp;hq=&amp;hnear=133+New+Bridge+Rd,+Singapore+059413&amp;t=m&amp;ll=1.285378,103.845005&amp;spn=0.015446,0.020578&amp;z=16" style="color:#0000FF;text-align:left">View Larger Map</a>
		                    </small>
                		</div>
					</div>
				</section>
				<aside class="right-sidebar lower">
					<!--contact form-->
					<article class="default">
						<h2>Send us a message</h2>
						<?php echo form_open_multipart('contact/do_submission', array('class' => 'form-horizontal')); ?>
							<fieldset>
								<div id="message"></div>
								<div class="f-item">
									<label for="name">Your full name</label>
									<input type="text" name="contact_fullname" required />
								</div>
								<div class="f-item">
									<label for="email">Your e-mail</label>
									<input type="email" name="contact_email_address" required />
								</div>
								<div class="f-item">
									<label for="comments">Your message</label>
									<textarea name="contact_message" rows="10" cols="10" required></textarea>
								</div>
								<input type="submit" value="Send" id="submit" name="submit" class="gradient-button" />
							</fieldset>
						<?php echo form_close(); ?>
					</article>
					<!--
					<article class="default">
						<h2>Or contact us directly</h2>
						<p class="phone-green">1- 555 - 555 - 555</p>
						<p class="email-green"><a href="#">booking@mail.com</a></p>
					</article>
					-->
				</aside>
			</div>
		</div>
	</div>
	<!--END OF MAIN-->

	<!--FOOTER-->
	<?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
	<!--END OF FOOTER-->
	
	<script src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/sequence.jquery-min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/sequence.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/infobox.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js"></script>
	<script type="text/javascript">	
		$(document).ready(function(){
			$(".form").hide();
			$(".form:first").show();
			$(".f-item:first").addClass("active");
			$(".f-item:first span").addClass("checked");
		});
	</script>
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