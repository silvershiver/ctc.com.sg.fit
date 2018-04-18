<!--LOGIN FORM-->
<div class="lightbox" id="lightbox_login" style="display:none;">
	<div class="lb-wrap">
		<a href="#" class="close">x</a>
		<div class="lb-content">
<form id="myloginform">
	<h1>Log in</h1>
	<div class="f-item">
		<label for="email">E-mail address</label>
		<input type="email" name="email" id="login_email" required value="<?php echo $this->session->userdata('ctcfit_app_email'); ?>" />
	</div>
	<div class="f-item">
		<label for="password">Password</label>
		<input type="password" name="password" id="login_password" required value="<?php echo $this->session->userdata('ctcfit_app_password'); ?>" />
	</div>
	<div class="f-item checkbox">
		<?php
		if( $this->session->userdata('ctcfit_app_email') == TRUE && $this->session->userdata('ctcfit_app_password') == TRUE ) {
		?>
		<input type="checkbox" id="login_checkbox" name="login_checkbox" value="1" checked="checked" />
		<label for="remember_me">Remember me next time</label>
		<?php
		}
		else {
		?>
		<input type="checkbox" id="login_checkbox" name="login_checkbox" value="1" />
		<label for="remember_me">Remember me next time</label>
		<?php
		}
		?>
	</div>
	<div id="login_ajax_msg" style="text-align:center; margin-bottom:10px; font-size:14px"></div>
	<p style="text-align:center">
		<a href="#" id="fp_modal" title="Forgot password?">Forgot password?</a><br />
		Don't have an account yet? <a href="#" id="signup_modal" title="Sign up">Sign up.</a>
	</p>
	<input type="submit" id="btnLogin" name="login" value="login" class="gradient-button"/>
</form>
		</div>
	</div>
</div>
<!--END OF LOGIN FORM-->