<!--SIGNUP FORM-->
<div class="lightbox" id="lightbox_signup" style="display:none;">
	<div class="lb-wrap" style="max-width:600px !important; width:40%; left:30%; top: 5% !important; overflow-y:scroll;height: 590px; overflow-x: hidden">
		<div class="lb-content">

        <a href="#" class="close" style="margin:10px !important">x</a>
			<?php echo form_open_multipart('signup/do_signup_process', array('class' => 'form-horizontal form-signup')); ?>
				<h1>Register to CTC</h1>
				<div class="f-item">
					<label for="f_name">First Name</label>
					<input type="text" name="first_name" id="first_name" required value="<?php echo $this->session->flashdata('reg_first_name'); ?>" />
				</div>
				<div class="f-item">
					<label for="l_name">Last name</label>
					<input type="text" name="last_name" id="last_name" required value="<?php echo $this->session->flashdata('reg_last_name'); ?>" />
				</div>
				<div class="f-item">
					<label for="email">E-mail address</label>
					<input type="email" name="email_address" id="email_address" required value="<?php echo $this->session->flashdata('reg_email_address'); ?>" />
				</div>
				<div class="f-item">
					<label for="password">Password</label>
					<input type="password" name="password" id="password1" pattern=".{8,}" required title="Minimum: 8 characters" />
				</div>
				<div class="f-item">
					<label for="password">Retype password</label>
					<input type="password" name="confirm_password" id="password2" pattern=".{8,}" required title="Minimum: 8 characters" />
				</div>
				<div class="f-item checkbox">
					<input type="checkbox" id="newsletter" name="newsletter" />
					<label for="newsletter">
						Tell me about inspiring travel news, and exclusive discounts! (Subscription to CTC)
					</label>
				</div>
				<p>
					By clicking "Create Account" you confirm that you accept the
					<a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
				</p>
				<input type="submit" id="register" name="register" value="Create Account" class="gradient-button" />
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
window.onload = function () {
	document.getElementById("password1").onchange = validatePassword;
	document.getElementById("password2").onchange = validatePassword;
}
function validatePassword(){
var pass2=document.getElementById("password2").value;
var pass1=document.getElementById("password1").value;
if(pass1!=pass2)
	document.getElementById("password2").setCustomValidity("Passwords Don't Match");
else
	document.getElementById("password2").setCustomValidity('');
//empty string means no validation error
}
</script>
<!--END OF SIGNUP FORM-->