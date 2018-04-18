<noscript>
  <style>html{display:none;}</style>
  <meta http-equiv="refresh" content="0.0;url=<?php echo base_url();?>welcome/jsrequire">
</noscript>

<script>
  	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  	ga('create', 'UA-3204420-1', 'auto');
  	ga('send', 'pageview');
</script>
<!--header-->
<header>
	<!--SESSION CHECK-->
	<?php if( $this->session->flashdata('success_add_subscribe') == TRUE ) { ?>
	<div class="lightbox" style="display:block;">
		<div class="lb-wrap">
			<a href="#" class="close">x</a>
			<div class="lb-content">
				<form>
					<h1>Notification</h1>
					<?php echo $this->session->flashdata('success_add_subscribe'); ?>
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
	<!--END OF SESSION CHECK-->
	<div class="wrap clearfix">
		<h1 class="logo">
			<a href="<?php echo base_url(); ?>">
				<img src="<?php echo base_url(); ?>/assets/images/ctcfitapplogo.png" style="margin-top:-5px; margin-bottom:5px;
" height="70">
			</a>
		</h1>
		<!--ribbon-->
		<div class="ribbon">
			<nav>
				<ul class="profile-nav">
					<li class="active"><a href="#" title="My Account">My Account</a></li>
					<?php
					if( $this->session->userdata('normal_session_id') == TRUE ) {
					?>
						<li><a href="<?php echo base_url(); ?>account/my_profile">My Profile</a></li>
						<li><a href="<?php echo base_url(); ?>login/dologout">Logout</a></li>
					<?php
					}
					else {
					?>
						<li><a href="#" id="login_modal">Login</a></li>
					<?php
					}
					?>
				</ul>
				<ul class="lang-nav">
					<li class="active" style="border-bottom: 1px solid #58B9B4;">
						<a href="<?php echo base_url(); ?>cart/index" title="My Cart">My Cart</a>
					</li>
				</ul>
				<ul class="currency-nav">
					<li class="active"><a href="#" title="SGD">Singapore Dollar</a></li>
				</ul>
			</nav>
		</div>
		<!--//ribbon-->
		<!--search-->
		<div class="search">
			<form id="search-form" method="get" action="search-form">
				<input type="search" placeholder="Search entire site here" name="site_search" id="site_search" />
				<input type="submit" id="submit-site-search" value="submit-site-search" name="submit-site-search"/>
			</form>
		</div>
		<!--//search-->
		<!--contact-->
		<div class="contact">
			<span>Customer Hotline</span>
			<span class="number">+65 6216-3456</span>
		</div>
		<!--//contact-->
	</div>
	<!--main navigation-->
	<!--
	<nav class="main-nav" role="navigation">
		<ul class="wrap" id="nav">
			<li><?php echo anchor('#', 'Hotels'); ?></li>
            <li><?php echo anchor('#', 'Flights'); ?></li>
			<li><?php echo anchor('#', 'Cruises'); ?></li>
            <li><?php echo anchor('#', 'Land Tours'); ?></li>
            <li><?php echo anchor('#', 'Hot Deals'); ?></li>
            <li><?php echo anchor('contact', 'Contact us'); ?></li>
		</ul>
	</nav>
	-->
	<!--//main navigation-->
</header>
<!--//header-->