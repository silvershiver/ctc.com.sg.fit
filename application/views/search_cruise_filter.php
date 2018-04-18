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
	<title>CTC Travel | Search Cruise Filter Result</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css" media="screen,projection,print" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/magnific-popup.css" />
	<!--<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/bootstrap-select.min.css">-->
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
	
	<!--MAIN-->
	<div class="main" role="main">		
		<div class="wrap clearfix">
			<!--main content-->
			<div class="content clearfix">
				
				<!--CRUISE CHANGE SEARCH-->
				<div class="main-search" id="changeSearchContent" style="margin:0px; margin-bottom:0px; margin-top:15px; display:none">
					<div class="search_container">
						<!--CATEGORY BOOKING SEARCH-->
						<div class="column radios">
							<h4><span>01</span> What?</h4>
							<div class="f-item" >
								<input type="radio" name="radio" id="hotel" value="form1" checked />
								<label for="hotel">Cruise</label>
							</div>
						</div>
						<!--END OF CATEGORY BOOKING SEARCH-->
						<div class="forms">		
<?php echo form_open_multipart('search/cruise_result', array('class' => 'form-horizontal')); ?>
	<!--column-->
	<div class="column">
		<h4><span>02</span> How?</h4>
		<div class="f-item">
			
			<label>Choose cruise type</label>
			<?php
			if( $cruiseType == "ALL" ) {
			?>
				<select name="cruiseType_BrandName">
					<option value="ALL" SELECTED>I Don't Mind</option>
					<?php
					$cruiseTypes = $this->All->select_template_with_order("NAME", "ASC", "cruise_brand");
					if( $cruiseTypes == TRUE ) {
					?>
					<option value="<?php echo $cruiseType->ID; ?>">
						<?php echo $cruiseType->NAME; ?>
					</option>
					<?php
					}
					?>
				</select>
			<?php
			} 
			else {
			?>
				<select name="cruiseType_BrandName">
					<option value="ALL">I Don't Mind</option>
					<?php
					$cruiseTypes = $this->All->select_template_with_order("NAME", "ASC", "cruise_brand");
					if( $cruiseTypes == TRUE ) {
						foreach( $cruiseTypes AS $cruiseType ) {
							if( $cruiseType->ID == $cruiseType ) {
					?>
					<option value="<?php echo $cruiseType->ID; ?>" SELECTED>
						<?php echo $cruiseType->NAME; ?>
					</option>
					<?php
							}
							else {
					?>
					<option value="<?php echo $cruiseType->ID; ?>">
						<?php echo $cruiseType->NAME; ?>
					</option>
					<?php
							}
						}
					}
					?>
				</select>
			<?php
			}
			?>
			
			<br />
			
			<label>Choose cruise port</label>
			<?php
			if( $cruiseType_port == "ALL" ) {
			?>
				<select name="cruiseType_port">
					<option value="ALL" SELECTED>I Don't Mind</option>
					<?php
					$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
					$port_res  = mysqli_query(
						$connection,
						"
							SELECT DISTINCT(DEPARTURE_PORT) AS DEPARTURE_PORT
							FROM cruise_title WHERE DEPARTURE_PORT IS NOT NULL ORDER BY DEPARTURE_PORT ASC
						"
					);  
					if( mysqli_num_rows($port_res) > 0 ) {
						while( $port_row  = mysqli_fetch_array($port_res, MYSQL_ASSOC) ) {
					?>
					<option value="<?php echo strtoupper($port_row["DEPARTURE_PORT"]); ?>">
						<?php echo strtoupper($port_row["DEPARTURE_PORT"]); ?>
					</option>
					<?php
						}
					}
					?>
				</select>
			<?php
			}
			else {
			?>
				<select name="cruiseType_port">
					<option value="ALL">I Don't Mind</option>
					<?php
					$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
					$port_res  = mysqli_query(
						$connection,
						"
							SELECT DISTINCT(DEPARTURE_PORT) AS DEPARTURE_PORT
							FROM cruise_title WHERE DEPARTURE_PORT IS NOT NULL ORDER BY DEPARTURE_PORT ASC
						"
					);  
					if( mysqli_num_rows($port_res) > 0 ) {
						while( $port_row  = mysqli_fetch_array($port_res, MYSQL_ASSOC) ) {
							if( $cruiseType_port == strtoupper($port_row["DEPARTURE_PORT"]) ) {
					?>
					<option value="<?php echo strtoupper($port_row["DEPARTURE_PORT"]); ?>" SELECTED>
						<?php echo strtoupper($port_row["DEPARTURE_PORT"]); ?>
					</option>
					<?php
							}
							else {
					?>
					<option value="<?php echo strtoupper($port_row["DEPARTURE_PORT"]); ?>">
						<?php echo strtoupper($port_row["DEPARTURE_PORT"]); ?>
					</option>
					<?php
							}
						}
					}
					?>
				</select>
			<?php
			}
			?>
			
			<br />
			
		</div>
	</div>
	<!--//column-->		
	<!--column-->
	<div class="column">
		<h4><span>03</span> When?</h4>
		<div class="f-item">
			<label>Cruise departure date</label>
			<select name="cruiseMonthDate" style="height:19px">
				<?php
				$startDate = date("Y-m-d");
				$endDate   = date('Y-m-d', strtotime('+1 years'));
				$montharr  = $this->All->get_months($startDate, $endDate);
				foreach(array_keys($montharr) as $year) {
					foreach($montharr[$year] as $month) {
						$monthYear = "{$year}-{$month}";
						if( $monthYear == $cruiseMonthDate ) {
				?>
				<option value="<?php echo $monthYear; ?>" SELECTED>
					<?php echo $monthYear; ?>
				</option>
				<?php
						}
						else {
				?>
				<option value="<?php echo $monthYear; ?>">
					<?php echo $monthYear; ?>
				</option>
				<?php
						}
					}
				}
				?>
			</select>
			<br />
			<label>Cruise length</label>
			<select name="cruiseLength" style="height:19px">
				<option value="ALL" 	<?php if( $cruiseLength == "ALL" ) { echo 'SELECTED'; } ?>>I Don't Mind</option>
				<option value="1_2" 	<?php if( $cruiseLength == "1_2" ) { echo 'SELECTED'; } ?>>1-2 Nights</option>
				<option value="3_6" 	<?php if( $cruiseLength == "3_6" ) { echo 'SELECTED'; } ?>>3-6 Nights</option>
				<option value="7_9" 	<?php if( $cruiseLength == "7_9" ) { echo 'SELECTED'; } ?>>7-9 Nights</option>
				<option value="10_14"   <?php if( $cruiseLength == "10_14" ) { echo 'SELECTED'; } ?>>10-14 Nights</option>
				<option value="OVER_14" <?php if( $cruiseLength == "OVER_14" ) { echo 'SELECTED'; } ?>>Over 14 Nights</option>
			</select>
			<br />
		</div>
	</div>
	<!--//column-->	
	<!--column-->
	<div class="column twins last">
		<h4><span>04</span> Who?</h4>
		<div class="f-item">
			<label>No. of person</label>
			<select name="noofPerson" style="height:19px">
				<option value="1" <?php if( $noofPerson == "1" ) { echo 'SELECTED'; } ?>>1 person</option>
				<option value="2" <?php if( $noofPerson == "2" ) { echo 'SELECTED'; } ?>>2 person(s)</option>
				<option value="3" <?php if( $noofPerson == "3" ) { echo 'SELECTED'; } ?>>3 person(s)</option>
				<option value="4" <?php if( $noofPerson == "4" ) { echo 'SELECTED'; } ?>>4 person(s)</option>
				<option value="5" <?php if( $noofPerson == "5" ) { echo 'SELECTED'; } ?>>5 person(s)</option>
				<option value="6" <?php if( $noofPerson == "6" ) { echo 'SELECTED'; } ?>>6 person(s)</option>
				<option value="7" <?php if( $noofPerson == "7" ) { echo 'SELECTED'; } ?>>7 person(s)</option>
				<option value="8" <?php if( $noofPerson == "8" ) { echo 'SELECTED'; } ?>>8 person(s)</option>
				<option value="9" <?php if( $noofPerson == "9" ) { echo 'SELECTED'; } ?>>9 person(s)</option>
			</select>
		</div>
	</div>
	<!--//column-->
	<input type="submit" value="Proceed to results" class="search-submit" id="search-submit" />
<?php echo form_close(); ?>	
						</div>
					</div>
				</div>
				<!--END OF CRUISE CHANGE SEARCH-->
				
				<!--BREADCUMBS-->
				<nav role="navigation" class="breadcrumbs clearfix">
					<ul class="crumbs">
						<li><a href="#">You are here:</a></li>
						<li><a href="#">Home</a></li>
						<li><a href="#">Cruise</a></li>
						<li>Search results</li>                                       
					</ul>
					<ul class="top-right-nav">
						<li><a href="#" id="changeSearchAnchor" title="Change search">Change search</a></li>
					</ul>
				</nav>
				<!--END OF BREADCUMBS-->
			
				<!--sidebar-->
				<?php echo form_open_multipart('search/cruise_filter', array('class' => 'form-horizontal')); ?>
				<input type="hidden" name="hidden_noofAdult" value="<?php echo $noofAdult; ?>" />
				<input type="hidden" name="hidden_noofChild" value="<?php echo $noofChildren; ?>" />
				<input type="hidden" name="hidden_cruiseMonthDate" value="<?php echo $cruiseMonthDate; ?>" />
				<input type="hidden" name="hidden_cruiseType_port" value="<?php echo $cruiseType_port; ?>" />
				<aside class="left-sidebar">
					<article class="refine-search-results">
						<h2>Advanced Search Filter</h2>
						<dl>		
							<!--Search by-->
							<dt>Search by cruise brand</dt>
							<dd id="FilterCKBrand">
								<?php
								$cruiseTypeFilters = $this->All->select_template_with_order("NAME", "ASC", "cruise_brand");
								if( $cruiseTypeFilters == TRUE ) {
									foreach( $cruiseTypeFilters AS $cruiseTypeFilter ) {
										if( in_array($cruiseTypeFilter->ID, $cruiseTypeArr) ) {
								?>
								<div class="checkbox">
									<input type="checkbox" id="fB" name="filterBrand[]" value="<?php echo $cruiseTypeFilter->ID; ?>" checked />
									<label for="ch6"><?php echo $cruiseTypeFilter->NAME; ?></label>
								</div>
								<?php
										}
										else {
								?>
								<div class="checkbox">
									<input type="checkbox" id="fB" name="filterBrand[]" value="<?php echo $cruiseTypeFilter->ID; ?>" />
									<label for="ch6"><?php echo $cruiseTypeFilter->NAME; ?></label>
								</div>
								<?php
										}
									}
								}
								?>
							</dd>
							<!--End of Search by-->
						</dl>
						<br />
						<dl>
							<!--Search by-->
							<dt>Search by length of night(s)</dt>
							<dd>
							
								<?php
								if( in_array("1,2", $cruiseLength) ) {
								?>
									<div class="checkbox">
										<input type="checkbox" id="ch6" name="filterLength[]" value="1,2" checked />
										<label for="ch6">1-2 Nights</label>
									</div>
								<?php
								}
								else {
								?>
									<div class="checkbox">
										<input type="checkbox" id="ch6" name="filterLength[]" value="1,2" />
										<label for="ch6">1-2 Nights</label>
									</div>
								<?php
								}
								?>
								
								<?php
								if( in_array("3,4,5,6", $cruiseLength) ) {
								?>
									<div class="checkbox">
										<input type="checkbox" id="ch6" name="filterLength[]" value="3,4,5,6" checked />
										<label for="ch6">3-6 Nights</label>
									</div>
								<?php
								}
								else {
								?>
									<div class="checkbox">
										<input type="checkbox" id="ch6" name="filterLength[]" value="3,4,5,6" />
										<label for="ch6">3-6 Nights</label>
									</div>
								<?php
								}
								?>
								
								<?php
								if( in_array("7,8,9", $cruiseLength) ) {
								?>
									<div class="checkbox">
										<input type="checkbox" id="ch6" name="filterLength[]" value="7,8,9" checked />
										<label for="ch6">7-9 Nights</label>
									</div>
								<?php
								}
								else {
								?>
									<div class="checkbox">
										<input type="checkbox" id="ch6" name="filterLength[]" value="7,8,9" />
										<label for="ch6">7-9 Nights</label>
									</div>
								<?php
								}
								?>
								
								<?php
								if( in_array("10,11,12,13,14", $cruiseLength) ) {
								?>
									<div class="checkbox">
										<input type="checkbox" id="ch6" name="filterLength[]" value="10,11,12,13,14" checked />
										<label for="ch6">10-14 Nights</label>
									</div>
								<?php
								}
								else {
								?>
									<div class="checkbox">
										<input type="checkbox" id="ch6" name="filterLength[]" value="10,11,12,13,14" />
										<label for="ch6">10-14 Nights</label>
									</div>
								<?php
								}
								?>
								
								<?php
								if( in_array("15,16,17,18,19,20,21,22,23", $cruiseLength) ) {
								?>
									<div class="checkbox">
										<input type="checkbox" id="ch6" name="filterLength[]" value="15,16,17,18,19,20,21,22,23" checked />
										<label for="ch6">Over 14 Nights</label>
									</div>
								<?php
								}
								else {
								?>
									<div class="checkbox">
										<input type="checkbox" id="ch6" name="filterLength[]" value="15,16,17,18,19,20,21,22,23" />
										<label for="ch6">Over 14 Nights</label>
									</div>
								<?php
								}
								?>
								
							</dd>
							<!--End of Search by-->
						</dl>
						<br />
						<div style="text-align:center">
							<button type="submit" class="gradient-button" style="border:none">Filter Result</button>
						</div>
					</article>
				</aside>
				<?php echo form_close(); ?>
				<!--//sidebar-->
			
				<!--three-fourth content-->
				<section class="three-fourth">
					<div class="sort-by">
						<h3>Details:</h3>
						<ul class="sort">
							<li style="width:150px">
								<?php echo $noofAdult; ?> Adult(s) & <?php echo $noofChildren; ?> Child(s)
							</li>
							<li style="width:150px">
								Date:
								<?php echo $cruiseMonthDate; ?>
							</li>
							<li style="width:150px">
								Length: <span style="color:green"><b>Based on filter</b></span>
							</li>
						</ul>
					</div>
					<div class="deals clearfix">
<?php
$countSearchResult = count($cruiseFinalResult);
if( $countSearchResult > 0 ) {
	for( $x=0; $x<$countSearchResult; $x++ ) {
?>
	<article class="full-width">
		<figure>
			<a href="#">
				<img src="<?php echo $this->All->getCruiseImage($cruiseFinalResult[$x]["ID"]); ?>" width="270" height="152" />
			</a>
		</figure>
		<div class="details">
			<h1>
				<?php echo $cruiseFinalResult[$x]["CRUISE_TITLE"]; ?>
			</h1>
			<span class="address">
				Departure Port: <b style="color:green"><?php echo $cruiseFinalResult[$x]["DEPARTURE_PORT"]; ?></b>
			</span>
			<!--<span class="rating"> 8 /10</span>-->
			<span class="price">
				<br />
				Price from:
				<br />
				<em>$ <?php echo $this->All->getStartingPrice($cruiseFinalResult[$x]["ID"]); ?></em>
			</span>
			<div class="description">
				<p>
					Ports of call:
					<br />
					<b>
						<?php 
							$portOfCall = $cruiseFinalResult[$x]["PORTS_OF_CALL"];
							$portOfCall = str_replace(",", ", ", $cruiseFinalResult[$x]["PORTS_OF_CALL"]);
							echo $portOfCall;
						?>
					</b>
				</p>
			</div>
			<a href="<?php echo base_url(); ?>cruise/details/<?php echo base64_encode(base64_encode(base64_encode($cruiseFinalResult[$x]["ID"]))); ?>/<?php echo base64_encode(base64_encode(base64_encode($cruiseType))); ?>/<?php echo base64_encode(base64_encode(base64_encode($cruiseType_port))); ?>/<?php echo base64_encode(base64_encode(base64_encode($cruiseMonthDate))); ?>/<?php echo base64_encode(base64_encode(base64_encode($cruiseLength))); ?>/<?php echo base64_encode(base64_encode(base64_encode($noofPerson))); ?>" title="Book now" class="gradient-button">Book now</a>
		</div>
	</article>
<?php
	}
}
else {
?>
	<article class="full-width">
		<div style="text-align:center; color:red; padding:15px; font-size:16px">
			No cruise found. Please search another cruise with different search parameters.
		</div>
	</article>
<?php
}
?>
						<div class="bottom-nav">
							<a href="#" class="scroll-to-top" title="Back up">Back up</a> 
							<!--
							<div class="pager">
								<span><a href="#">First page</a></span>
								<span><a href="#">&lt;</a></span>
								<span class="current">1</span>
								<span><a href="#">2</a></span>
								<span><a href="#">3</a></span>
								<span><a href="#">4</a></span>
								<span><a href="#">5</a></span>
								<span><a href="#">6</a></span>
								<span><a href="#">7</a></span>
								<span><a href="#">8</a></span>
								<span><a href="#">&gt;</a></span>
								<span><a href="#">Last page</a></span>
							</div>
							-->
						</div>
					</div>
				</section>
				<!--//three-fourth content-->
			</div>
			<!--//main content-->
		</div>
	</div>
	<!--//main-->
	
	<!--FOOTER-->
	<?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
	<!--END OF FOOTER-->
	
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
	<!--<script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap/bootstrap-select.min.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.raty.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.magnific-popup.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.redirect.js"></script>
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
			$("#hotel_noofroom").change(function() {
				var noofadult = this.value*2;
				$("#hotel_noofadult").val(noofadult).change();
    		})
		});
	</script>
</body>
</html>