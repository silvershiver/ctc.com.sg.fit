<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css?1" type="text/css" media="screen,projection,print" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/js/uilatest/jquery-ui.min.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" />
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
	<style>#divLoading {display : none;} .tt-open {height: auto; max-height:200px; overflow-y: auto; }</style>
</head>
<body>
	<?php require_once(APPPATH."views/master-frontend/header.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/slider.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/search.php"); ?>
	<?php
	if( $this->session->flashdata('success_signup') == TRUE ) {
	?>
		<div class="lightbox" style="display:block;">
			<div class="lb-wrap">
				<a href="#" class="close">x</a>
				<div class="lb-content">
					<form>
						<h1>Notification</h1>
						<?php echo $this->session->flashdata('success_signup'); ?>
					</form>
				</div>
			</div>
		</div>
	<?php
	}
	?>
	<?php
	if( $this->session->flashdata('error_same_register') == TRUE ) {
	?>
		<div class="lightbox" style="display:block;">
			<div class="lb-wrap">
				<a href="#" class="close">x</a>
				<div class="lb-content">
					<form>
						<h1>Notification</h1>
						<?php echo $this->session->flashdata('error_same_register'); ?>
					</form>
				</div>
			</div>
		</div>
	<?php
	}
	?>
	<div class="main" role="main" style="padding:0px; margin:0px">
		<div class="wrap clearfix">
			<?php
			$features = $this->All->select_template_with_where3_and_order(
				"is_feature", 1, "is_suspend", 0, "is_deleted", 0, "lt_title", "ASC", "landtour_product"
			);
			if( $features == TRUE ) {
			?>
				<!--Featured Product-->
				<section class="offers clearfix full">
					<h1 style="text-align:center">Explore our featured products</h1>
					<?php
					foreach( $features AS $feature ) {
					?>
						<article class="one-fourth" style="height:310px; margin-right:15px">
							<figure>
								<a href="<?php echo base_url(); ?>landtour/details/<?php echo $feature->slug_url; ?>">
									<img src="<?php echo $this->All->getLandtourImage($feature->id); ?>" alt="" width="270" height="152" />
								</a>
							</figure>
							<div class="details">
								<h4 style="text-align:center"><?php echo $feature->lt_title; ?></h4>
								<br />
								<div style="color:green; font-size:15px; margin-top:-15px">
									<b>Starting Price: $<?php echo number_format($feature->starting_price, 2); ?></b>
								</div>
								<a href="<?php echo base_url(); ?>landtour/details/<?php echo $feature->slug_url; ?>" title="Explore our feature product" class="gradient-button">More info</a>
							</div>
						</article>
					<?php
					}
					?>
				</section>
				<!--End of Featured Product-->
			<?php
			}
			?>
		</div>
	</div>
	<?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
	<script src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/sequence.jquery-min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/sequence.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js?<?php echo uniqid(); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/typehead/js/typeahead.bundle.js?1"></script>
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
      	$(document).ready(function() {
        	$('input[type=radio]').each(function(){
          		if (!$(this).prop("checked") == true ) {
		  			s = $(this).attr('value');
		  			$(s).hide();
          		}
        	});
			$('input[type=radio]:not(.choiceFlightType)').on("change", function() {
          		$(".showHide").hide();
		  		s = $(this).attr('value');
		  		$(s).show();
        	});
      	});
    </script>
    <script type="text/javascript">
      	$(document).ready(function() {
	  		if( sessionStorage.getItem('checkboxValue') == "#fourth" ) {
		  		$.uniform.update($('#fourthClick').attr('checked', true));
		  		$.uniform.update($('#thirdClick').attr('checked', false));
		  		$.uniform.update($('#secondClick').attr('checked', false));
		  		$.uniform.update($('#firstClick').attr('checked', false));
		  		$("#fourth").show();
		  		$("#third").hide();
		        $("#second").hide();
		        $("#first").hide();
	  		}
	  		else if( sessionStorage.getItem('checkboxValue') == "#third" ) {
		  		$.uniform.update($('#fourthClick').attr('checked', false));
		  		$.uniform.update($('#thirdClick').attr('checked', true));
		  		$.uniform.update($('#secondClick').attr('checked', false));
		  		$.uniform.update($('#firstClick').attr('checked', false));
		  		$("#fourth").hide();
		  		$("#third").show();
		        $("#second").hide();
		        $("#first").hide();
	  		}
	  		else if( sessionStorage.getItem('checkboxValue') == "#second" ) {
		  		$.uniform.update($('#fourthClick').attr('checked', false));
		  		$.uniform.update($('#thirdClick').attr('checked', false));
		  		$.uniform.update($('#secondClick').attr('checked', true));
		  		$.uniform.update($('#firstClick').attr('checked', false));
		  		$("#fourth").hide();
		  		$("#third").hide();
		        $("#second").show();
		        $("#first").hide();
	  		}
	  		else if( sessionStorage.getItem('checkboxValue') == "#first" ) {
		  		$.uniform.update($('#fourthClick').attr('checked', false));
		  		$.uniform.update($('#thirdClick').attr('checked', false));
		  		$.uniform.update($('#secondClick').attr('checked', false));
		  		$.uniform.update($('#firstClick').attr('checked', true));
		  		$("#fourth").hide();
		  		$("#third").hide();
		        $("#second").hide();
		        $("#first").show();
	  		}
	  		else {
		  		$.uniform.update($('#fourthClick').attr('checked',true));
		  		$("#fourth").show();
		  		$("#third").hide();
		        $("#second").hide();
		        $("#first").hide();
	  		}
	      	$('input[type=radio][name=radio]').change(function() {
		        if (this.value == '#fourth') {
			        sessionStorage.setItem("checkboxValue", this.value);
		            $("#fourth").show();
		            $("#third").hide();
		            $("#second").hide();
		            $("#first").hide();
		        }
		        else if (this.value == '#third') {
			        sessionStorage.setItem("checkboxValue", this.value);
			        $("#fourth").hide();
		            $("#third").show();
		            $("#second").hide();
		            $("#first").hide();
		        }
		        else if (this.value == '#second') {
			        sessionStorage.setItem("checkboxValue", this.value);
					$("#fourth").hide();
		            $("#third").hide();
		            $("#second").show();
		            $("#first").hide();
		        }
		        else if (this.value == '#first') {
			        sessionStorage.setItem("checkboxValue", this.value);
			        $("#fourth").hide();
		            $("#third").hide();
		            $("#second").hide();
		            $("#first").show();
		        }
		    });

	  		/*$('#radioFlightType').on('click', function() {
	      		alert(this.value);
	      		if(this.value == 'one_way') {
	      			alert('b');
	      			sessionStorage.setItem('datepickerFlightCheckIn', $('#datepickerFlightCheckIn').val());
	      			sessionStorage.setItem("flightValue", this.value);
	      		} else {
	      			alert('a');
	      			sessionStorage.setItem("flightValue", this.value);
	      			sessionStorage.setItem('datepickerFlightCheckIn', $('#datepickerFlightCheckIn').val());
	      			sessionStorage.setItem('datepickerFlightCheckOut', $('#datepickerFlightCheckOut').val());
	      		}
	      	});*/

	      	if(sessionStorage.getItem('flightAdult')) {
	  			$('#flightAdult').val(sessionStorage.getItem('flightAdult'));
	  			$.uniform.update($('#flightAdult'));
	  		}
		    $('#flightAdult').on('change', function() {
		    	sessionStorage.setItem("flightAdult", this.value);
		    });

		    if(sessionStorage.getItem('flightChild')) {
	  			$('#flightChild').val(sessionStorage.getItem('flightChild'));
	  			$.uniform.update($('#flightChild'));
	  		}
	  		$('#flightChild').on('change', function() {
		    	sessionStorage.setItem("flightChild", this.value);
		    });

		    if(sessionStorage.getItem('flightInfant')) {
	  			$('#flightInfant').val(sessionStorage.getItem('flightInfant'));
	  			$.uniform.update($('#flightInfant'));
	  		}
		    $('#flightInfant').on('change', function() {
		    	sessionStorage.setItem("flightInfant", this.value);
		    });

		    if(sessionStorage.getItem('flightClass')) {
	  			$('#flightClass').val(sessionStorage.getItem('flightClass'));
	  			$.uniform.update($('#flightClass'));
	  		}
		    $('#flightClass').on('change', function() {
		    	sessionStorage.setItem("flightClass", this.value);
		    })
      	});
    </script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".form").hide();
			$(".form:first").show();
			$(".f-item:first").addClass("active");
			$(".f-item:first span").addClass("checked");
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
			var states 		 = [<?php echo $this->All->list_city_country(); ?>];
			var states_hotel = [<?php echo $this->All->list_typehea_hotel(); ?>];
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
			$("#checkout_flight").hide();
			$('input[type=radio][name=radioType].choiceFlightType').on('change', function() {
		        if (this.value == 'one_way') {
	      			sessionStorage.setItem("flightValue", this.value);
		            $("#checkout_flight").hide();
		        }
		        else if (this.value == 'return') {
		            $("#checkout_flight").show();
		            sessionStorage.setItem("flightValue", this.value);
		        }
		    });

		    if(sessionStorage.getItem('flightValue') == 'return') {
	  			$.uniform.update($('input:radio[name="radioType"][value="one_way"]').attr('checked', false));
	  			$.uniform.update($('input:radio[name="radioType"][value="return"]').attr('checked', true));
	  			/*$('#radioFlightType').trigger('click');*/
	  			$("#checkout_flight").show();
	  			if(sessionStorage.getItem('datepickerFlightCheckIn')) {
	  				$('#datepickerFlightCheckIn').val(sessionStorage.getItem('datepickerFlightCheckIn'));
	  			}
	            if(sessionStorage.getItem('datepickerFlightCheckOut')) {
		  			$('#datepickerFlightCheckOut').val(sessionStorage.getItem('datepickerFlightCheckOut'));
		  		}

	  		} else {
	  			$.uniform.update($('input:radio[name="radioType"][value="one_way"]').attr('checked', true));
	  			$.uniform.update($('input:radio[name="radioType"][value="return"]').attr('checked', false));
	  			if(sessionStorage.getItem('datepickerFlightCheckIn')) {
		  			$('#datepickerFlightCheckIn').val(sessionStorage.getItem('datepickerFlightCheckIn'));
		  		}

	  			/*$('#radioFlightType').trigger('click');*/
	  		}


		});





		$(document).ready(function(){
			$("#hotel_noofroom").change(function() {
				var noofadult = this.value*2;
				$("#hotel_noofadult").val(noofadult).change();
    		})
		});
	</script>
	<script>selectnav('nav'); </script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#search_submit_flight").click(function(){
		        if( $("input#flight_destination").val() != "" ) {
	             	$("#divLoading").show();
				}
	        });


		});
	</script>
</body>
</html>