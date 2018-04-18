<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTCFITApp - Changelog Version</title>
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<!-- Core JS files -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/drilldown.js"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/prism.min.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/layout_sidebar_sticky.js"></script>
	<!-- /theme JS files -->
</head>
<body data-spy="scroll" data-target=".sidebar-fixed" class="sidebar-opposite-visible">

	<!-- Main navbar -->
	<?php require_once(APPPATH."views/master/main_navbar.php"); ?>
	<!-- /main navbar -->

	<!-- Second navbar -->
	<?php require_once(APPPATH."views/master/second_navbar.php"); ?>
	<!-- /second navbar -->

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Changelog Version</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/changelog">Changelog</a></li>
				</ul>
			</div>
			<?php require_once(APPPATH."views/master/heading_element.php"); ?>
		</div>
	</div>
	<!-- /page header -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Version 1.1 -->
				<div class="panel panel-flat" id="v_1_1">
					<div class="panel-heading">
						<h5 class="panel-title">Version 1.1</h5>
						<div class="heading-elements">
							<span class="text-muted heading-text">October 17, 2015</span>
							<span class="label bg-blue heading-text">v. 1.1</span>
		            	</div>
					</div>
					<div class="panel-body">
						<div class="content-group-lg">
							<p class="content-group">First update is the most simplified and includes urgent bug fixes of core components, plugins and libraries. Also version 1.1 includes updates of some components to the latest stable versions. The only new thing here is RTL version of all 4 layouts, that support almost all available components and layout features. Below you can find general list of all changes and details about upgrading.</p>

<pre class="language-javascript"><code>// Newly added
[new] RTL layout for all 4 main layout variations
[new] bootbox.less - new LESS file for extended Bootstrap modal dialogs

// Updated components
[updated] CKEditor - latest version
[updated] Select2 - latest 3.5.x version, 4.0 is coming
[updated] Bootstrap Multiselect - latest version
[updated] Datatables - latest version

// Core fixes
[fixed] Sidebar - side border overlaped content in light sidebar (layout 1 and 2)
[fixed] Breadcrumbs - in colored version links had wrong background color on hover/active
[fixed] Breadcrumbs - dropdown menu didn't have borders in breadcrumb line component
[fixed] Labels - striped labels didn't have right border variation as supposed to
[fixed] Navbars - unnecessary dropdown menu re-position in navbar component
[fixed] Button groups - extra space between buttons in toolbar
[fixed] Tables - extra border in framed table in responsive table container

// Components fixes
[fixed] Bootstrap Select - wrong rounded corners inside input group
[fixed] Bootstrap Select - no styling of dropdown menu
[fixed] SelectBox - wrong rounded corners inside input group
[fixed] Tags Input - input field didn't have bottom spacing
[fixed] Typeahead - small menu width if text options are too short
[fixed] Sweet alerts - title was too big for motification size
[fixed] Anytime picker - wrong title margin and unnecessary close button
[fixed] jQuery UI Datepicker - extra RTL-related code in less file
[fixed] Fullcalendar - extra RTL-related code in less file
[fixed] Chats - wrong variables in LESS file
[fixed] Dropzone Uploader - success/error markers moved down in thumbnails is name is visible
[fixed] Colors - default BS styles overrided text hover state
[fixed] SelectBox page - extra panel control buttons
</code></pre>
						</div>
					</div>
				</div>
				<!-- /version 1.1 -->

			</div>
			<!-- /main content -->

			<!-- Opposite sidebar -->
			<div class="sidebar sidebar-opposite sidebar-default">
				<div class="sidebar-fixed">
					<div class="sidebar-content">
		        		<!-- Support -->
						<div class="sidebar-category no-margin">
							<div class="category-title">
								<span>Changelog</span>
								<i class="icon-menu7 pull-right"></i>
							</div>
							<div class="category-content">
								<a href="#" class="btn bg-danger-400 btn-block" target="_blank">
									<i class="icon-bubbles4 position-left"></i> Need support?
								</a>
							</div>
						</div>
						<!-- /support -->	        			
	        			<!-- Navigation -->
						<div class="sidebar-category">
							<div class="category-content no-padding">
								<ul class="nav navigation">
									<li class="navigation-divider no-margin-top"></li>
									<li class="navigation-header">
										<i class="icon-history pull-right"></i> Version history
									</li>
									<li>
										<a href="#v_1_1">
											Version 1.1 <span class="text-muted text-regular pull-right">17.11.2015</span>
										</a>
									</li>
									<li>
										<a href="#release">
											Initial release <span class="text-muted text-regular pull-right">01.10.2015</span>
										</a>
									</li>
									<li class="navigation-divider"></li>
									<li class="navigation-header">
										<i class="icon-gear pull-right"></i> Extras
									</li>
									<li>
										<a href="#" target="_blank">
											<i class="icon-lifebuoy text-slate-400"></i> Suggestion
										</a>
									</li>
					            </ul>
				            </div>
			            </div>
			            <!-- /navigation -->

		            </div>
	            </div>
			</div>
			<!-- /opposite sidebar -->

		</div>
		<!-- /page content -->

		<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->

	</div>
	<!-- /page container -->

</body>
</html>
