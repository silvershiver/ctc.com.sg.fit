<div class="navbar navbar-default" id="navbar-second">
	<ul class="nav navbar-nav no-border visible-xs-block">
		<li>
			<a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle">
				<i class="icon-menu7"></i>
			</a>
		</li>
	</ul>
	<div class="navbar-collapse collapse" id="navbar-second-toggle">
		<ul class="nav navbar-nav">

			<?php //var_dump($_SESSION); if()
				if($_SESSION)
				{
					if($_SESSION['user_session_access_dashboard'] == '1')
					{ ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>backend/dashboard">
								<i class="icon-display4 position-left"></i> Dashboard
							</a>
						</li>
					<?php }
				}
			?>

			<?php //var_dump($_SESSION); if()
				if($_SESSION)
				{
					if($_SESSION['user_session_access_admin'] == '1')
					{ ?>
						<li class="dropdown mega-menu mega-menu-wide">
							<a href="<?php echo base_url(); ?>backend/administrator" class="dropdown-toggle">
								<i class="icon-user-check position-left"></i> Administrator
							</a>
						</li>
					<?php }
				}
			?>

			<?php //var_dump($_SESSION); if()
				if($_SESSION)
				{
					if($_SESSION['user_session_access_customer'] == '1')
					{ ?>
						<li class="dropdown mega-menu mega-menu-wide">
							<a href="<?php echo base_url(); ?>backend/customer" class="dropdown-toggle">
								<i class="icon-users4 position-left"></i> Customer
							</a>
						</li>
					<?php }
				}
			?>

			<?php
				if($_SESSION)
				{
					if($_SESSION['user_session_access_category'] == '1')
					{ ?>
						<li class="dropdown mega-menu mega-menu-wide">
							<a href="<?php echo base_url(); ?>backend/category" class="dropdown-toggle">
								<i class="icon-stack2 position-left"></i> Category
							</a>
						</li>
					<?php }
				}
			?>

			<?php //var_dump($_SESSION); if()
				if($_SESSION)
				{
					if($_SESSION['user_session_access_product'] == '1')
					{ ?>
						<li class="dropdown">
							<a href="<?php echo base_url(); ?>backend/product" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-bag position-left"></i> Product <span class="caret"></span>
							</a>
							<ul class="dropdown-menu width-200">
								<li class="dropdown-header">Choose category</li>

								<?php //var_dump($_SESSION); if()
									if($_SESSION)
									{
										if($_SESSION['user_session_access_cruises'] == '1')
										{ ?>
											<li>
												<a href="<?php echo base_url(); ?>backend/product/cruise_index">
													<i class="icon-pencil7"></i> Cruises
												</a>
											</li>
										<?php }
									}
								?>

								<?php //var_dump($_SESSION); if()
									if($_SESSION)
									{
										if($_SESSION['user_session_access_flights'] == '1')
										{ ?>
											<li>
												<a href="<?php echo base_url(); ?>backend/product/flight_index">
													<i class="icon-pencil7"></i> Flights
												</a>
											</li>
										<?php }
									}
								?>

								<?php //var_dump($_SESSION); if()
									if($_SESSION)
									{
										if($_SESSION['user_session_access_hotels'] == '1')
										{ ?>
											<li>
												<a href="<?php echo base_url(); ?>backend/product/hotel_index">
													<i class="icon-pencil7"></i> Hotels
												</a>
											</li>
										<?php }
									}
								?>



								<!--
								<li>
									<a href="<?php echo base_url(); ?>backend/product/passes_index">
										<i class="icon-pencil7"></i> Passes
									</a>
								</li>
								-->
								<?php //var_dump($_SESSION); if()
									if($_SESSION)
									{
										if($_SESSION['user_session_access_landtours'] == '1')
										{ ?>
											<li>
												<a href="<?php echo base_url(); ?>backend/product/landtour_index">
													<i class="icon-pencil7"></i> Land Tours
												</a>
											</li>
										<?php }
									}
								?>


								<!--
								<li>
									<a href="<?php echo base_url(); ?>backend/product/transfer_index">
										<i class="icon-pencil7"></i> Transfers
									</a>
								</li>
								-->
							</ul>
						</li>
					<?php }
				}
			?>




			<!--
			<li class="dropdown mega-menu mega-menu-wide">
				<a href="<?php echo base_url(); ?>backend/storage" class="dropdown-toggle">
					<i class="icon-price-tag2 position-left"></i> Tags
				</a>
			</li>
			-->
			<!--
			<li class="dropdown mega-menu mega-menu-wide">
				<a href="<?php echo base_url(); ?>backend/insurance" class="dropdown-toggle">
					<i class="icon-safe position-left"></i> Travel Insurance
				</a>
			</li>
			-->
			<!--
			<li class="dropdown mega-menu mega-menu-wide">
				<a href="<?php echo base_url(); ?>backend/third_party" class="dropdown-toggle">
					<i class="icon-safe position-left"></i> Third Party API
				</a>
			</li>
			-->


			<?php //var_dump($_SESSION); if()
				if($_SESSION)
				{
					if($_SESSION['user_session_access_main_banner'] == '1')
					{ ?>
						<li class="dropdown mega-menu mega-menu-wide">
							<a href="<?php echo base_url(); ?>backend/mainbanner" class="dropdown-toggle">
								<i class="icon-file-picture position-left"></i> Main Banner
							</a>
						</li>
					<?php }
				}
			?>

			<?php //var_dump($_SESSION); if()
				if($_SESSION)
				{
					if($_SESSION['user_session_access_gta_settings'] == '1')
					{ ?>
						<li class="dropdown mega-menu mega-menu-wide">
							<a href="<?php echo base_url(); ?>backend/gta/settings" class="dropdown-toggle">
								<i class="icon-gear position-left"></i> GTA Settings
							</a>
						</li>
					<?php }
				}
			?>

		</ul>
		<!--
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a href="<?php echo base_url(); ?>backend/changelog">
					<i class="icon-history position-left"></i>
					Changelog of version
					<span class="label label-inline position-right bg-success-400">1.1</span>
				</a>
			</li>
		</ul>
		-->
	</div>
</div>