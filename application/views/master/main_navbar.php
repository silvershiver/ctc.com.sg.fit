<div class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="<?php echo base_url(); ?>backend/dashboard">
			<img src="<?php echo base_url(); ?>assets/images/ctcfitapplogo.png" style="width:100px; height:30px; margin-top:-7px" />
		</a>
		<ul class="nav navbar-nav pull-right visible-xs-block">
			<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
		</ul>
	</div>
	<div class="navbar-collapse collapse" id="navbar-mobile">
		<p class="navbar-text"><span class="label bg-success-400">Status: ONLINE</span></p>
		<ul class="nav navbar-nav navbar-right">


				<?php //var_dump($_SESSION); if()
					if($_SESSION)
					{
						if($_SESSION['user_session_access_support_centre'] == '1')
						{ ?>
							<li class="dropdown dropdown-user">
								<a href="<?php echo base_url(); ?>backend/support" class="dropdown-toggle">
									<span>Contact / Support Centre</span>
								</a>
							</li>
						<?php }
					}
				?>

			<!--
			<li class="dropdown dropdown-user">
				<a href="<?php echo base_url(); ?>backend/subscription" class="dropdown-toggle">
					<span>Subscription Centre</span>
				</a>
			</li>
			-->


				<?php //var_dump($_SESSION); if()
					if($_SESSION)
					{
						if($_SESSION['user_session_access_content_management'] == '1')
						{ ?>
							<li class="dropdown dropdown-user">
								<a href="<?php echo base_url(); ?>backend/content" class="dropdown-toggle">
									<span>Content Management</span>
								</a>
							</li>
						<?php }
					}
				?>


				<?php //var_dump($_SESSION); if()
					if($_SESSION)
					{
						if($_SESSION['user_session_access_online_help'] == '1')
						{ ?>
							<li class="dropdown dropdown-user">
								<a class="dropdown-toggle" data-toggle="dropdown">
									<span>Online Help</span>
									<i class="caret"></i>
								</a>
								<ul class="dropdown-menu dropdown-menu-right">
									<!--
									<li>
										<a href="<?php echo base_url(); ?>backend/wiki">
											<i class="icon-help"></i>Wiki
										</a>
									</li>
									<li>
										<a href="<?php echo base_url(); ?>backend/faq">
											<i class="icon-info3"></i>FAQ
										</a>
									</li>
									-->
									<li>
										<a href="mailto:immanuel@pixely.sg">
											<i class="icon-alert"></i>Email Support
										</a>
									</li>
								</ul>
							</li>
						<?php }
					}
				?>


			<li class="dropdown dropdown-user">
				<a class="dropdown-toggle" data-toggle="dropdown">
					<span>
						Welcome,
						<?php echo $this->session->userdata('user_session_admin_full_name'); ?>
					</span>
					<i class="caret"></i>
				</a>
				<ul class="dropdown-menu dropdown-menu-right">


					<?php //var_dump($_SESSION); if()
						if($_SESSION)
						{
							if($_SESSION['user_session_access_edit_profile'] == '1')
							{ ?>
								<li>
									<a href="<?php echo base_url(); ?>backend/account">
										<i class="icon-user-plus"></i> My profile
									</a>
								</li>
							<?php }
						}
					?>

					<li class="divider"></li>
					<li>
						<a href="<?php echo base_url(); ?>backend/login/out">
							<i class="icon-switch2"></i> Logout
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>