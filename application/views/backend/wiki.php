<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTCFITApp - Wiki</title>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<!-- /theme JS files -->
</head>
<body>

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
					<span class="text-semibold">Wiki</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="#">Online help</a></li>
					<li><a href="<?php echo base_url(); ?>backend/wiki">Wiki</a></li>
				</ul>
			</div>
			<?php require_once(APPPATH."views/master/heading_element.php"); ?>
			</div>
		</div>
	</div>
	<!-- /page header -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Search field -->
				<div class="panel">
					<div class="panel-body">
						<h4 class="text-center content-group-lg">
							Welcome to Wiki
							<small class="display-block">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry.
							</small>
						</h4>

						<form action="#" class="main-search">
							<div class="input-group content-group">
								<div class="has-feedback has-feedback-left">
									<input type="text" class="form-control input-xlg" placeholder="Search our knowledgebase">
									<div class="form-control-feedback">
										<i class="icon-search4 text-muted text-size-base"></i>
									</div>
								</div>
								<div class="input-group-btn">
									<button type="submit" class="btn btn-primary btn-xlg">Search</button>
								</div>
							</div>

							<div class="row search-option-buttons">
								<div class="col-sm-6" >
									<ul class="list-inline list-inline-condensed no-margin-bottom">
										<li class="dropdown">
											<a href="#" class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown">
												<i class="icon-stack2 position-left"></i> All categories <span class="caret"></span>
											</a>
											<ul class="dropdown-menu">
												<li><a href="#">Category 1</a></li>
												<li><a href="#">Category 2</a></li>
												<li><a href="#">Category 3</a></li>
												<li><a href="#">Category 4</a></li>
												<li><a href="#">Category 5</a></li>
												<li><a href="#">Category 6</a></li>
												<li><a href="#">Category 7</a></li>
											</ul>
										</li>
										<li>
											<a href="#" class="btn btn-link btn-sm">
												<i class="icon-reload-alt position-left"></i> Refine your search
											</a>
										</li>
									</ul>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- /search field -->

				<!-- Info blocks -->
				<div class="row">
					<div class="col-md-4">
						<div class="panel">
							<div class="panel-body text-center">
								<div class="icon-object border-success text-success"><i class="icon-book"></i></div>
								<h5 class="text-semibold">Knowledge Base (Wiki)</h5>
								<p class="mb-15">Ouch found swore much dear conductively hid submissively hatchet vexed far inanimately alongside candidly much and jeez</p>
								<a href="#" class="btn bg-success-400">Browse articles</a>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="panel">
							<div class="panel-body text-center">
								<div class="icon-object border-warning text-warning"><i class="icon-lifebuoy"></i></div>
								<h5 class="text-semibold">Support center</h5>
								<p class="mb-15">Dear spryly growled much far jeepers vigilantly less and far hideous and some mannishly less jeepers less and and crud</p>
								<a href="#" class="btn bg-warning-400">Open a ticket</a>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="panel">
							<div class="panel-body text-center">
								<div class="icon-object border-blue text-blue"><i class="icon-reading"></i></div>
								<h5 class="text-semibold">FAQ</h5>
								<p class="mb-15">Diabolically somberly astride crass one endearingly blatant depending peculiar antelope piquantly popularly adept much</p>
								<a href="#" class="btn bg-blue">Browse FAQ</a>
							</div>
						</div>
					</div>
				</div>
				<!-- /info blocks -->


				<!-- Directory -->
				<h4 class="text-center content-group">
					Browse articles by category
					<small class="display-block">Yikes snuffed goat macaw overlay much and goodness and alas kookaburra a goldfish</small>
				</h4>

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h6 class="panel-title">Browse articles</h6>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-4">
										<div class="content-group">
											<h6 class="text-semibold heading-divided"><i class="icon-folder6 position-left"></i> Your statement &amp; documents <small class="position-right">(58)</small></h6>
											<div class="list-group list-group-borderless">
												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Incongruously gorilla <span class="label bg-teal-300">New</span>
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Playful amongst hence
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Sobbingly altruistic nasty
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Hung insecure far ferret
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-arrow-right22"></i> Show all articles (58)
												</a>
											</div>
										</div>
									</div>

									<div class="col-md-4">
										<div class="content-group">
											<h6 class="text-semibold heading-divided"><i class="icon-folder6 position-left"></i> Account settings <small class="position-right">(92)</small></h6>
											<div class="list-group list-group-borderless">
												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Reined and this vigorous <span class="label label-primary">Popular</span>
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Oh positively well crab
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Recast then impalpable cried
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Eclectic mechanically as on <span class="label label-danger">Closed</span>
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-arrow-right22"></i> Show all articles (92)
												</a>
											</div>
										</div>
									</div>

									<div class="col-md-4">
										<div class="content-group">
											<h6 class="text-semibold heading-divided"><i class="icon-folder6 position-left"></i> Protecting your copyright <small class="position-right">(15)</small></h6>
											<div class="list-group list-group-borderless">
												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> And dear dealt bat far redid
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Trout some after effective <span class="label label-default">On hold</span>
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> The one rhythmically whale
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Admirably spun a the belched <span class="label bg-indigo-300">Article</span>
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-arrow-right22"></i> Show all articles (15)
												</a>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="content-group">
											<h6 class="text-semibold heading-divided"><i class="icon-folder6 position-left"></i> Intellectual Property <small class="position-right">(12)</small></h6>
											<div class="list-group list-group-borderless">
												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Gagged more much around <span class="label label-danger">Closed</span>
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Much oh much along gnu
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Aardvark far the until alas <span class="label label-success">Review</span>
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Hence expeditiously goldfish
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-arrow-right22"></i> Show all articles (12)
												</a>
											</div>
										</div>
									</div>

									<div class="col-md-4">
										<div class="content-group">
											<h6 class="text-semibold heading-divided"><i class="icon-folder6 position-left"></i> Item support <small class="position-right">(34)</small></h6>
											<div class="list-group list-group-borderless">
												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Shark hello less well
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Far pious gosh cuttingly <span class="label label-success">Review</span>
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Tonally guardedly jeepers
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Since growled overheard
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-arrow-right22"></i> Show all articles (34)
												</a>
											</div>
										</div>
									</div>

									<div class="col-md-4">
										<div class="content-group">
											<h6 class="text-semibold heading-divided"><i class="icon-folder6 position-left"></i> Contacting authors <small class="position-right">(85)</small></h6>
											<div class="list-group list-group-borderless">
												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Jeepers circa sneered well
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Oh one ouch ouch armadillo <span class="label label-primary">Popular</span>
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Thus went far and pending <span class="label label-default">On hold</span>
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-file-text2"></i> Or cat together chose eagle
												</a>

												<a href="#" class="list-group-item">
													<i class="icon-arrow-right22"></i> Show all articles (85)
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /directory -->

				<!-- Submit a ticket -->
				<div class="panel panel-body stack-media-on-mobile">
					<div class="media-left">
						<a href="#" class="btn btn-link btn-icon text-teal">
							<i class="icon-question7 icon-2x no-edge-top"></i>
						</a>
					</div>

					<div class="media-body media-middle">
						<h6 class="media-heading text-semibold">Can't find what you're looking for?</h6>
						Lorem Ipsum is simply dummy text of the printing and typesetting industry.
					</div>

					<div class="media-right media-middle">
						<a href="#" class="btn bg-warning-400 btn-lg"><i class="icon-mail5 position-left"></i> Submit a ticket</a>
					</div>
				</div>
				<!-- /submit a ticket -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

		<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->

	</div>
	<!-- /page container -->

</body>
</html>
