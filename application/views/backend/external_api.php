<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>IoTStream - External API</title>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/tasks_grid.js"></script>
	<!-- /theme JS files -->
</head>
<body class="sidebar-xs">

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
					<span class="text-semibold">External API</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/external_api">External API</a></li>
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

			<!-- Secondary sidebar -->
			<div class="sidebar sidebar-secondary sidebar-default">
				<div class="sidebar-content">

					<!-- Search API -->
					<div class="sidebar-category">
						<div class="category-title">
							<span>Search API</span>
							<ul class="icons-list">
								<li><a href="#" data-action="collapse"></a></li>
							</ul>
						</div>
						<div class="category-content">
							<form action="#">
								<div class="has-feedback has-feedback-left">
									<input type="search" class="form-control" placeholder="Type and hit Enter">
									<div class="form-control-feedback">
										<i class="icon-search4 text-size-base text-muted"></i>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- /search API -->

					<!-- Language navigation -->
					<div class="sidebar-category">
						<div class="category-title">
							<span>Select language / platform</span>
						</div>

						<div class="category-content no-padding">
							<ul class="navigation navigation-alt navigation-accordion">
								<li><a href="#"><i class="icon-files-empty"></i> PHP</a></li>
								<li><a href="#"><i class="icon-files-empty"></i> Java (TM)</a></li>
								<li><a href="#"><i class="icon-files-empty"></i> C#</a></li>
								<li><a href="#"><i class="icon-files-empty"></i> Perl</a></li>
								<li><a href="#"><i class="icon-files-empty"></i> Ruby</a></li>
							</ul>
						</div>
					</div>
					<!-- End of language navigation -->

				</div>
			</div>
			<!-- /secondary sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">
				<div class="row">
					<div class="col-md-12">
						<div class="panel border-left-lg border-left-primary">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<h6 class="no-margin-top">
											<a href="#">Getting started of using the APIs</a>
										</h6>
										<p style="text-align:justify">
											API support is included with all Control Center accounts. However, you must request an API key for access to the system. Trial Users who have been using an M2M Developer Kit, can request an API key by clicking the link on the left side of this page. Other users can request an API key by contacting your account representative. Control Center maintains a sandbox environment, completely separate from the production environment. If needed, a sandbox account can be created for you, so you can familiarize yourself with the APIs and try your applications on test data. Here's the process:
										</p>
										<p style="text-align:justify">
											<ul>
												<li>Request access</li>
												<p style="text-align:justify">
													After clicking the 'request API key' link, Trial Users will receive an API license key and a URL from your account representative. If needed, your account representative will create a test account with some sample data in the sandbox environment and then send you the access information to that sandbox account, including a license key, user credentials, and a URL.
												</p>
												<li>Set up development environment</li>
												<p style="text-align:justify">
													Next, you'll need to download the WSDL and XML schema files for the API. You can access these files through Control Center. On the home page, click on API Integration to display the online technical documentation. Click on Overview > Get WSDL Files. Then, follow the Tutorial instructions for your preferred coding environment (Java, C#, Perl, PHP, or Ruby). 
												</p>
												<li>Create / test code</li>
												<p style="text-align:justify">
													The online technical documentation provides code samples as well as detailed function descriptions to help you create your own code. When you're ready, you can test the code in the sandbox (if a sandbox account has been created for you) or in your production account. Be aware that the sandbox and production environments are completely separate: using the sandbox environment means there's no way you can damage production data with your test code. 
												</p>
												<li>Go live If you are using a sandbox account to test your code</li>
												<p style="text-align:justify">
													You can contact your account representative when you're ready to put your code into production. Your account representative will then send you a license key and a URL for the production environment. Be aware that you cannot migrate any data from the sandbox environment to the production environment or vice versa. A caveat. Jasper Wireless may, at its discretion, disrupt or remove access to the API sandbox (testing) environment for any reason. We will do our best to notify you in advance if we anticipate a service interruption. Also, we cannot guarantee continuous support for the sandbox environment.
												</p>
											</ul>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel border-left-lg border-left-primary">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<h6 class="no-margin-top">
											<a href="#">GetTerminalDetails Request</a>
										</h6>
										<p class="mb-15">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book
										</p>
										<p><b><u>URL Access:</u></b></p>
					                	<p style="margin-top:-10px">http://54.251.177.123/json/GetTerminalDetails</p>
					                	<p><b><u>Method:</u></b></p>
					                	<p style="margin-top:-10px">POST</p>
					                	<p><b><u>Input Required:</u></b></p>
					                	<p style="margin-top:-10px">
						                	<ul>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
						                	</ul>
					                	</p>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<ul>
									<li>*Remark: test abc lorem ipsum</li>
								</ul>
								<ul class="pull-right">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle">
											View details
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel border-left-lg border-left-primary">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<h6 class="no-margin-top">
											<a href="#">GetTerminalDetails Request</a>
										</h6>
										<p class="mb-15">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book
										</p>
										<p><b><u>URL Access:</u></b></p>
					                	<p style="margin-top:-10px">http://54.251.177.123/json/GetTerminalDetails</p>
					                	<p><b><u>Method:</u></b></p>
					                	<p style="margin-top:-10px">POST</p>
					                	<p><b><u>Input Required:</u></b></p>
					                	<p style="margin-top:-10px">
						                	<ul>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
						                	</ul>
					                	</p>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<ul>
									<li>*Remark: test abc lorem ipsum</li>
								</ul>
								<ul class="pull-right">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle">
											View details
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel border-left-lg border-left-primary">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<h6 class="no-margin-top">
											<a href="#">GetTerminalDetails Request</a>
										</h6>
										<p class="mb-15">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book
										</p>
										<p><b><u>URL Access:</u></b></p>
					                	<p style="margin-top:-10px">http://54.251.177.123/json/GetTerminalDetails</p>
					                	<p><b><u>Method:</u></b></p>
					                	<p style="margin-top:-10px">POST</p>
					                	<p><b><u>Input Required:</u></b></p>
					                	<p style="margin-top:-10px">
						                	<ul>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
						                	</ul>
					                	</p>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<ul>
									<li>*Remark: test abc lorem ipsum</li>
								</ul>
								<ul class="pull-right">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle">
											View details
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel border-left-lg border-left-primary">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<h6 class="no-margin-top">
											<a href="#">GetTerminalDetails Request</a>
										</h6>
										<p class="mb-15">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book
										</p>
										<p><b><u>URL Access:</u></b></p>
					                	<p style="margin-top:-10px">http://54.251.177.123/json/GetTerminalDetails</p>
					                	<p><b><u>Method:</u></b></p>
					                	<p style="margin-top:-10px">POST</p>
					                	<p><b><u>Input Required:</u></b></p>
					                	<p style="margin-top:-10px">
						                	<ul>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
						                	</ul>
					                	</p>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<ul>
									<li>*Remark: test abc lorem ipsum</li>
								</ul>
								<ul class="pull-right">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle">
											View details
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel border-left-lg border-left-primary">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<h6 class="no-margin-top">
											<a href="#">GetTerminalDetails Request</a>
										</h6>
										<p class="mb-15">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book
										</p>
										<p><b><u>URL Access:</u></b></p>
					                	<p style="margin-top:-10px">http://54.251.177.123/json/GetTerminalDetails</p>
					                	<p><b><u>Method:</u></b></p>
					                	<p style="margin-top:-10px">POST</p>
					                	<p><b><u>Input Required:</u></b></p>
					                	<p style="margin-top:-10px">
						                	<ul>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
						                	</ul>
					                	</p>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<ul>
									<li>*Remark: test abc lorem ipsum</li>
								</ul>
								<ul class="pull-right">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle">
											View details
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel border-left-lg border-left-primary">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<h6 class="no-margin-top">
											<a href="#">GetTerminalDetails Request</a>
										</h6>
										<p class="mb-15">
											Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book
										</p>
										<p><b><u>URL Access:</u></b></p>
					                	<p style="margin-top:-10px">http://54.251.177.123/json/GetTerminalDetails</p>
					                	<p><b><u>Method:</u></b></p>
					                	<p style="margin-top:-10px">POST</p>
					                	<p><b><u>Input Required:</u></b></p>
					                	<p style="margin-top:-10px">
						                	<ul>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
							                	<li>[inputABC] => "input of the textfield ABC"</li>
						                	</ul>
					                	</p>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<ul>
									<li>*Remark: test abc lorem ipsum</li>
								</ul>
								<ul class="pull-right">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle">
											View details
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- /main content -->
			</div>
			<!-- /page content -->
		</div>
			<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->
		</div>
		<!-- /page container -->
</body>
</html>