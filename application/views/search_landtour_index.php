<?php
	//prevent notice + message error
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	//end of prevent notice + message error
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CTC Travel | Search Land Tour Result</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css?<?php echo uniqid(); ?>" type="text/css" media="screen,projection,print" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/magnific-popup.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/typehead/css/typehead.css" type="text/css" media="screen" />
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
	<?php require_once(APPPATH."views/master-frontend/header.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>
	<div class="main" role="main">		
		<div class="wrap clearfix">
			<div class="content clearfix">
				
<!--LANDTOUR CHANGE SEARCH-->
<div class="main-search" id="changeSearchContent" style="margin:0px; margin-bottom:0px; margin-top:15px; display:none">
	<div class="search_container">
		<div class="column radios">
			<h4><span>01</span> What?</h4>
			<div class="f-item" >
				<input type="radio" name="radio" id="hotel" value="form1" checked />
				<label for="hotel">Land Tour</label>
			</div>
		</div>
		<div class="forms">
			<?php echo form_open_multipart('search/landtour_result', array('class' => 'form-horizontal')); ?>
				<div class="column">
					<h4><span>02</span> Interest?</h4>
					<div class="f-item">
						<label>Choose Point-of-Interest</label>
						<select name="landtour_point_interest">
							<?php
							if( $point_of_interest == "ALL" ) {
							?>
								<option value="ALL">I Don't Mind</option>
								<?php
								$arrayCategory 		= $this->Landtour->getLandtourCategory_mainSearch();
								$countArrayCategory = count($arrayCategory);
								if( $countArrayCategory > 0 ) {
									foreach( $arrayCategory AS $keyCategory => $valueCategory ) {
								?>
								<option value="<?php echo $keyCategory; ?>"><?php echo $valueCategory; ?></option>
								<?php
									}
								}
								?>
							<?php
							}
							else {
							?>
								<option value="ALL">I Don't Mind</option>
								<?php
								$arrayCategory 		= $this->Landtour->getLandtourCategory_mainSearch();
								$countArrayCategory = count($arrayCategory);
								if( $countArrayCategory > 0 ) {
									foreach( $arrayCategory AS $keyCategory => $valueCategory ) {
										if( $point_of_interest == $keyCategory ) {
								?>
								<option value="<?php echo $keyCategory; ?>" SELECTED><?php echo $valueCategory; ?></option>
								<?php
										}
										else {
								?>
								<option value="<?php echo $keyCategory; ?>"><?php echo $valueCategory; ?></option>
								<?php
										}
									}
								}
							}
							?>
						</select>
					</div>
				</div>
				<div class="column">
					<h4><span>03</span> Where?</h4>
					<div class="f-item" id="landtour_destination">
						<label for="destination2">Your destination</label>
						<select name="landtour_destination">
							<?php
							if( $landtour_destination == "ALL" ) {
							?>
								<option value="ALL">I Don't Mind</option>
								<?php
								$arrayCategoryLocation 		= $this->Landtour->getLandtourDestinationCountry_mainSearch();
								$countArrayCategoryLocation = count($arrayCategoryLocation);
								if( $countArrayCategoryLocation > 0 ) {
									foreach( $arrayCategoryLocation AS $keyCategoryLocation => $valueCategoryLocation ) {
								?>
								<option value="<?php echo $keyCategoryLocation; ?>">
									<?php echo $valueCategoryLocation; ?>
								</option>
								<?php
									}
								}
								?>
							<?php
							}
							else {
							?>
								<option value="ALL">I Don't Mind</option>
								<?php
								$arrayCategoryLocation 		= $this->Landtour->getLandtourDestinationCountry_mainSearch();
								$countArrayCategoryLocation = count($arrayCategoryLocation);
								if( $countArrayCategoryLocation > 0 ) {
									foreach( $arrayCategoryLocation AS $keyCategoryLocation => $valueCategoryLocation ) {
										if( $landtour_destination == $valueCategoryLocation ) {
								?>
								<option value="<?php echo $keyCategoryLocation; ?>" SELECTED>
									<?php echo $valueCategoryLocation; ?>
								</option>
								<?php
										}
										else {
								?>
								<option value="<?php echo $keyCategoryLocation; ?>">
									<?php echo $valueCategoryLocation; ?>
								</option>
								<?php
										}
									}
								}
								?>
							<?php
							}
							?>
						</select>
					</div>
				</div>
				<div class="column twins last">
					<h4><span>04</span> Who?</h4>
					<div class="f-item datepicker">
						<label for="datepicker1">From date</label>
						<div class="datepicker-wrap">
							<input type="text" id="datepickerLandtourCheckIn" name="datepicker4" required style="height:18px" value="<?php echo date("Y-m-d", strtotime($from_date)); ?>" />
						</div>
					</div>
					<div class="f-item datepicker">
						<label for="datepicker2">To date</label>
						<div class="datepicker-wrap">
							<input type="text" id="datepickerLandtourCheckOut" name="datepicker5" required style="height:18px" value="<?php echo date("Y-m-d", strtotime($to_date)); ?>" />
						</div>
					</div>
				</div>
				<input type="submit" value="Proceed to results" class="search-submit" id="search-submit" />
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--END OF LANDTOUR CHANGE SEARCH-->
				
				<!--BREADCUMBS-->
				<nav role="navigation" class="breadcrumbs clearfix">
					<ul class="crumbs">
						<li style="margin-left:0px; font-size:1.3em"><a href="#">You are here:</a></li>
						<li style="margin-left:0px; font-size:1.3em">
							<a href="<?php echo base_url(); ?>">Home</a>
						</li>
						<li style="margin-left:0px; font-size:1.3em">Search results</li>                                
					</ul>
					<ul class="top-right-nav">
						<li><a href="#" id="changeSearchAnchor" title="Change search">Change search</a></li>
					</ul>
				</nav>
				<!--END OF BREADCUMBS-->
			
				<!--SIDEBAR FILTER-->
				<?php echo form_open_multipart('search/landtour_filter', array('class' => 'form-horizontal')); ?>
					<input type="hidden" name="hidden_start_date" value="<?php echo $from_date; ?>" />
					<input type="hidden" name="hidden_end_date" value="<?php echo $to_date; ?>" />
					<input type="hidden" name="hidden_landtour_destination" value="<?php echo $landtour_destination; ?>" />
					<input type="hidden" name="hidden_poi" value="<?php echo $point_of_interest; ?>" />
					<aside class="left-sidebar">
						<article class="refine-search-results">
							<h2>Advanced Search Filter</h2>
							<dl>
								<dt>Search by point of interest</dt>
								<?php
								if( is_array($checkboxsPOI) ) {
								?>
									<dd id="FilterCKBrand">
										<?php
										$arrayCategory 		= $this->Landtour->getLandtourCategory_mainSearch();
										$countArrayCategory = count($arrayCategory);
										if( $countArrayCategory > 0 ) {
											foreach( $arrayCategory AS $keyCategory => $valueCategory ) {
												if( in_array($keyCategory, $checkboxsPOI) ) {
										?>								
										<div class="checkbox">
											<input type="checkbox" id="fB" name="filterPOI[]" checked="checked" value="<?php echo $keyCategory; ?>" />
											&nbsp;
											<span style="font-size:12px"><?php echo $valueCategory; ?></span>
										</div>
										<?php
												}
												else {
										?>
										<div class="checkbox">
											<input type="checkbox" id="fB" name="filterPOI[]" value="<?php echo $keyCategory; ?>" />
											&nbsp;
											<span style="font-size:12px"><?php echo $valueCategory; ?></span>
										</div>
										<?php
												}
											}
										}
										?>
									</dd>
								<?php
								}
								else {
								?>
									<dd id="FilterCKBrand">
										<?php
										$arrayCategory 		= $this->Landtour->getLandtourCategory_mainSearch();
										$countArrayCategory = count($arrayCategory);
										if( $countArrayCategory > 0 ) {
											foreach( $arrayCategory AS $keyCategory => $valueCategory ) {
										?>								
										<div class="checkbox">
											<input type="checkbox" id="fB" name="filterPOI[]" value="<?php echo $keyCategory; ?>" />
											&nbsp;
											<span style="font-size:12px"><?php echo $valueCategory; ?></span>
										</div>
										<?php
											}
										}
										?>
									</dd>
								<?php
								}
								?>
							</dl>
							<br />
							<dl>
								<dt>Search by country destination</dt>
								<?php
								if( is_array($checkboxsCountry) ) {
								?>
									<dd>
										<?php
										$arrayCategoryLocation 		= $this->Landtour->getLandtourDestinationCountry_mainSearch();
										$countArrayCategoryLocation = count($arrayCategoryLocation);
										if( $countArrayCategoryLocation > 0 ) {
											foreach( $arrayCategoryLocation AS $keyCategoryLocation => $valueCategoryLocation ) {
												$realLocation = "'".$valueCategoryLocation."'";
												if( in_array($realLocation, $checkboxsCountry) ) {
										?>
										<div class="checkbox">
											<input type="checkbox" id="ch6" name="filterCountry[]" checked="checked" value="'<?php echo $valueCategoryLocation; ?>'" />
											&nbsp;
											<span style="font-size:12px"><?php echo strtoupper($valueCategoryLocation); ?></span>
										</div>
										<?php
												}
												else {
										?>
										<div class="checkbox">
											<input type="checkbox" id="ch6" name="filterCountry[]" value="'<?php echo $valueCategoryLocation; ?>'" />
											&nbsp;
											<span style="font-size:12px"><?php echo strtoupper($valueCategoryLocation); ?></span>
										</div>
										<?php	
												}
											}
										}
										?>
									</dd>
								<?php
								}
								else {
								?>
									<dd>
										<?php
										$arrayCategoryLocation 		= $this->Landtour->getLandtourDestinationCountry_mainSearch();
										$countArrayCategoryLocation = count($arrayCategoryLocation);
										if( $countArrayCategoryLocation > 0 ) {
											foreach( $arrayCategoryLocation AS $keyCategoryLocation => $valueCategoryLocation ) {
										?>
										<div class="checkbox">
											<input type="checkbox" id="ch6" name="filterCountry[]" value="'<?php echo $valueCategoryLocation; ?>'" />
											&nbsp;
											<span style="font-size:12px"><?php echo strtoupper($valueCategoryLocation); ?></span>
										</div>
										<?php
											}
										}
										?>
									</dd>
								<?php
								}
								?>
							</dl>
							<br />
							<div style="text-align:center">
								<button type="submit" class="gradient-button" style="border:none">Filter Result</button>
							</div>
						</article>
					</aside>
				<?php echo form_close(); ?>				
				<!--END OF SIDEBAR FILTER-->
				<section class="three-fourth">
					<div class="sort-by">
						<h3>Details:</h3>
						<ul class="sort">
							<li style="width:250px; list-style-type:none; font-size:1.3em; margin-left:0px">
								Date: <?php echo date("d-M-Y", strtotime($from_date)); ?>
								- 
								<?php echo date("d-M-Y", strtotime($to_date)); ?>
							</li>
						</ul>
					</div>
					<div class="deals clearfix">
						<?php
						if( is_array($landtourFinalResult) ) {
							$countResult = count($landtourFinalResult);
							for($a=0; $a<$countResult; $a++) {
						?>
							<article class="full-width">
								<figure>
									<a target="_blank" href="<?php echo base_url(); ?>landtour/details/<?php echo $landtourFinalResult[$a]["slug_url"]; ?>">
										<img src="<?php echo $this->All->getLandtourImage($landtourFinalResult[$a]["id"]); ?>" width="270" height="152" />
									</a>
								</figure>
								<div class="details">
									<h1 style="font-size:14px"><?php echo $landtourFinalResult[$a]["lt_title"]; ?></h1>
									<span class="address">
										Category: 
										<b style="color:green">
											<?php echo $this->All->getLandtourCategoryName($landtourFinalResult[$a]["lt_category_id"]); ?>
										</b>
									</span>
									<span class="price">
										<br />
										Price from:
										<br />	
										<em>$<?php echo number_format($landtourFinalResult[$a]["starting_price"], 2); ?></em>
									</span>
									<div class="description">
										<p style="margin-top:-10px">
											<div style="font-size:13px">
												<div style="float:left; width:35%">
													Dates available:
												</div>
												<div style="float:left">
													<span style="color:green">
														<b>
															<?php echo date("Y F d", strtotime($landtourFinalResult[$a]["start_date"])); ?>
															- 
															<?php echo date("Y F d", strtotime($landtourFinalResult[$a]["end_date"])); ?>
														</b>
													</span>
												</div>
												<div style="clear:both"></div>
											</div>
											<div style="font-size:13px">
												<div style="float:left; width:35%">
													Location: 
												</div>
												<div style="float:left">
													<span style="color:green">
														<b><?php echo $landtourFinalResult[$a]["location"]; ?></b>
													</span>
												</div>
												<div style="clear:both"></div>
											</div>
										</p>
									</div>
									<a target="_blank" href="<?php echo base_url(); ?>landtour/details/<?php echo $landtourFinalResult[$a]["slug_url"]; ?>" title="Book now" class="gradient-button">
										Book now
									</a>
								</div>
							</article>
						<?php
							}
						}
						else {
						?>
							<article class="full-width">
								<div style="text-align:center; color:red; padding:15px; font-size:16px">
									No land tour package found. Please search another land tour with different search parameters.
								</div>
							</article>
						<?php
						}
						?>
						<div class="bottom-nav">
							<a href="#" class="scroll-to-top" title="Back up">Back up</a> 
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
	<style>
		@media print {
			.footer_print { display: none !important; }
	  		.gradient-button { display: none !important; }
	  	}
	  	.row-fb .fbd, .row-twitter .twd {
		  	height: 43px;
		  	width: auto;
		  	position: relative;
		  	top: 8px;
	  	}
	</style>
	<?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
	<script type="text/javascript" src="https://www.ctc.com.sg/cruise/assets/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="https://www.ctc.com.sg/cruise/assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="https://www.ctc.com.sg/cruise/assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="https://www.ctc.com.sg/cruise/assets/js/modernizr.js"></script>
	<script type="text/javascript" src="https://www.ctc.com.sg/cruise/assets/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="https://www.ctc.com.sg/cruise/assets/js/jquery.raty.min.js"></script>
	<script type="text/javascript" src="https://www.ctc.com.sg/cruise/assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="https://www.ctc.com.sg/cruise/assets/js/selectnav.js"></script>
	<script type="text/javascript" src="https://www.ctc.com.sg/cruise/assets/js/scripts.js"></script>
	<script type="text/javascript" src="https://www.ctc.com.sg/cruise/assets/js/jquery.magnific-popup.js"></script>
	<script type="text/javascript" src="https://www.ctc.com.sg/cruise/assets/js/jquery.redirect.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/typehead/js/typeahead.bundle.js"></script>
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
			            url: 'https://www.ctc.com.sg/cruise/forgot_password/do_submission',
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
		            url: 'https://www.ctc.com.sg/cruise/login/do_login_process',
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
				            window.location = 'https://www.ctc.com.sg/cruise/search/cruise_result';
				            return false;
			            }
		            }
		        });
		        return false;
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function($) {
		  	var requiredCheckboxes = $(':checkbox[required]');
		  	requiredCheckboxes.on('change', function(e) {
		    	var checkboxGroup = requiredCheckboxes.filter('[name="' + $(this).attr('name') + '"]');
				var isChecked = checkboxGroup.is(':checked');
				checkboxGroup.prop('required', !isChecked);
		  	});
		});
		$(document).ready(function() {
			var base_url = window.location.origin + '/ctcfitapp1/';
			$('#star').raty({
				score    : 3,
				starOff : base_url+'assets/images/ico/star-rating-off.png',
				starOn  : base_url+'assets/images/ico/star-rating-on.png',
				click: function(score, evt) {
					alert('ID: ' + $(this).attr('id') + '\nscore: ' + score + '\nevent: ' + evt);
			  	}
			});
		});
		$(window).load(function () {
			var maxHeight = 0;			
			$(".three-fourth .one-fourth").each(function(){
				if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
			});
			$(".three-fourth .one-fourth").height(maxHeight);	
		});	
	</script>
	<script>selectnav('nav'); </script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#changeSearchAnchor").click(function(){
				$("#changeSearchContent").toggle();
				return false;
    		});
		});
	</script>
	<script type="text/javascript">
      	$(document).ready(function() {
        	$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
				disableOn: 700,
				type: 'iframe',
				mainClass: 'mfp-fade',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: false
        	});
      	});
      	$(document).ready(function(){			
			var substringMatcher = function(strs) {
			    return function findMatches(q, cb) {
			    	var matches, substringRegex;
					matches = [];
					substrRegex = new RegExp(q, 'i');
					$.each(strs, function(i, str) {
			        	if (substrRegex.test(str)) {
							matches.push(str);
			        	}
			      	});
				  	cb(matches);
			    };
			};
			var states 		 	= [<?php echo $this->All->list_city_country(); ?>];
			var states_hotel 	= [<?php echo $this->All->list_typehea_hotel(); ?>];
			var states_landtour = [<?php echo $this->All->list_typehead_landtour(); ?>];
			var statesLandtourBlood = new Bloodhound({
			  	datumTokenizer: Bloodhound.tokenizers.whitespace,
			  	queryTokenizer: Bloodhound.tokenizers.whitespace,
			  	local: states_landtour
			});

			$('#flight-leaving .typeahead').typeahead(
				{
					hint: true,
					highlight: true,
					minLength: 3
				},
				{
					name: 'states',
					source: substringMatcher(states)
				}
			);
			$('#flight-going .typeahead').typeahead(
				{
					hint: true,
					highlight: true,
					minLength: 3
				},
				{
					name: 'states',
					source: substringMatcher(states)
				}
			);
			$('#hotel_destination .typeahead').typeahead(
				{
					hint: true,
					highlight: true,
					minLength: 3
				},
				{
					name: 'states',
					source: substringMatcher(states_hotel)
				}
			);
			$('#landtour_destination .typeahead').typeahead(
				{
					hint: true,
					highlight: true,
					minLength: 3
				},
				{
					name: 'statesLandtourBlood',
					source: substringMatcher(states_landtour)
				}
			);
			$("#checkout_flight").hide();
			$('input[type=radio][name=radioType]').change(function() {
		        if (this.value == 'one_way') {
		            $("#checkout_flight").hide();
		        }
		        else if (this.value == 'return') {
		            $("#checkout_flight").show();
		        }
		    });
		});
	</script>
</body>
</html>