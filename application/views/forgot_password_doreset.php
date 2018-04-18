<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CTC Travel | Reset Password</title>
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
	<?php
	if( $this->session->flashdata('success_signup') == TRUE ) {
	?>
	<div class="lightbox" style="display:block;">
		<div class="lb-wrap">
			<a href="#" class="close">x</a>
			<div class="lb-content">
				<form>
					<h1>Notification</h1>
					<?php echo $this->session->flashdata('success_signup'); ?>
				</form>
			</div>
		</div>
	</div>
	<?php
	}
	?>
	<!--END OF SESSION CHECK-->
	
	<?php
	$parameter = base64_decode(base64_decode(base64_decode($this->uri->segment(3))));
	$checks = $this->All->select_template_w_2_conditions(
		"email_address", $parameter, "is_fp_request", 1, "user_access"
	);
	if( $checks == TRUE ) {
	?>
		<!--MAIN-->
		<div class="main" role="main">
			<div class="wrap clearfix">
				<div style="height:180px">&nbsp;</div>
				<section class="boxes clearfix">
					<aside style="width:100%">
						<article class="default">
							<h2>Reset Password</h2>
<?php echo $this->session->flashdata('password_not_match'); ?>
<?php echo form_open_multipart('forgot_password/do_execute_reset', array('class' => 'form-horizontal')); ?>
	<input type="hidden" name="hidden_encrypt_email" value="<?php echo $this->uri->segment(3); ?>" />
	<fieldset>
		<div id="message"></div>
		<div class="f-item">
			<label for="name">Enter new password (Minimum 8 characters)</label>
			<input type="password" name="password" style="width:40%" pattern=".{8,}" required title="Minimum: 8 characters" />
		</div>
		<div class="f-item">
			<label for="email">Retype new password</label>
			<input type="password" name="confirm_password" style="width:40%" pattern=".{8,}" required title="Minimum: 8 characters" />
		</div>
		<input type="submit" value="Reset" id="submit" name="submit" class="gradient-button" />
	</fieldset>
<?php echo form_close(); ?>
						</article>
					</aside>
				</section>
			</div>
		</div>
		<!--END OF MAIN-->
	<?php	
	}
	else {
	?>
		<!--MAIN-->
		<div class="main" role="main">
			<div class="wrap clearfix">
				<div style="height:180px">&nbsp;</div>
				<section class="boxes clearfix">
					<article class="full-fourth">
						<h2>Notification</h2>
						<?php
						if( $this->session->flashdata('success_reset_password') == TRUE ) {
						?>
							<p><?php echo $this->session->flashdata('success_reset_password'); ?></p>
						<?php	
						}
						else {
						?>
							<p>This link has been expired.</p>
						<?php
						}
						?>			
					</article>
				</section>
			</div>
		</div>
		<!--END OF MAIN-->
	<?php
	}
	?>

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
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.js"></script>
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
    