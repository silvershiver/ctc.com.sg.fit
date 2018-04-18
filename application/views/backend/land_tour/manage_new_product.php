<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Land Tour Product Management</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/style_custom.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/summernote.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery_ui/datepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/tags/tagsinput.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/tags/tokenfield.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/prism.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/drilldown.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/uploaders/dropzone.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/anytime.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/pickers/pickadate/legacy.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/jquery-ui.multidatespicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/editors/summernote/summernote.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/editors/summernote/summernote-ext-fontstyle.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.summernote').summernote({
				height: 250,
				toolbar: [
					['style', ['fontname', 'bold', 'italic', 'underline', 'clear']],
				    ['fontsize', ['fontsize']],
				    ['color', ['color']],
				    ['para', ['style', 'ul', 'ol', 'paragraph']],
				    ['height', ['height']],
				    ['insert', ['picture', 'link', 'table', 'hr']],
				    ['misc', ['fullscreen','codeview', 'undo', 'redo', 'help']]
				],
				onpaste: function (e) {
			        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

			        e.preventDefault();

			        document.execCommand('insertText', false, bufferText);
			    }

			});
			$('.note-editable').css('font-size','1.3em');
		});
	</script>
	<script type="text/javascript">
		$(function() {
			$("#start_date").multiDatesPicker({dateFormat: "yy-mm-dd"});
			$("#end_date").multiDatesPicker({dateFormat: "yy-mm-dd"});
			$('#characterLeft').text('0 character(s)');
			$('#characterLeft1').text('0 character(s)');
			$('#lt_highlight').keyup(function () {
		    	var len = $(this).val().length;
				$('#characterLeft').text(len + ' character(s) type');
			});
			$('#lt_itinerary').keyup(function () {
		    	var len = $(this).val().length;
				$('#characterLeft1').text(len + ' character(s) type');
			});
		});
  	</script>
	<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/form_tags_input.js"></script>-->
	<script type="text/javascript">
		//submit form
		$(document).on('submit', '#submitNewLandTour', function() {
			//parameter
			var lt_category  	= $("#lt_category").val();
			var lt_tourID  	 	= $("#lt_tourID").val();
			var lt_title     	= $("#lt_title").val();
			var lt_highlight 	= $("#summernote").val();
			var start_date   	= $("#start_date").val();
			var end_date  	 	= $("#end_date").val();
			var tags  		 	= $("#tags").val();
			var location	 	= $("#location").val();
			var radioFeature	= $("#feature_product_radio:checked").val();
			var lt_itinerary 	= "";
			var st_country   	= "";
			var st_city  	 	= "";
			var en_country   	= "";
			var en_city  	 	= "";
			//end of parameter
			var dataString = 'isFeature='+radioFeature+'&lt_category='+lt_category+'&lt_tourID='+lt_tourID+'&lt_title='+lt_title+'&lt_highlight='+lt_highlight+'&lt_itinerary='+lt_itinerary+'&location='+location+'&start_date='+start_date+'&st_country='+st_country+'&st_city='+st_city+'&end_date='+end_date+'&en_country='+en_country+'&en_city='+en_city+'&tags='+tags;
			if( lt_category.trim() == '' ) 		   	{ alert("Please choose a land tour category"); 	}
			else if( lt_tourID.trim() == '' ) 	   	{ alert("Please enter land tour ID"); 			}
			else if( lt_title.trim() == '' ) 	   	{ alert("Please enter land tour title"); 		}
			else if( lt_highlight.trim() == '' ) 	{ alert("Please enter land tour highlight"); 	}
			else if( start_date.trim() == '' ) 		{ alert("Please enter start date"); 			}
			else if( end_date.trim() == '' ) 		{ alert("Please enter end date"); 				}
			else if( location.trim() == '' ) 		{ alert("Please enter location"); 				}
			else {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backend/landtour_process/insert_landtour_product",
					data: dataString,
					cache: false,
					success: function(result) {
						//alert(result);
						window.location = '<?php echo base_url(); ?>backend/product/landtour_index/successLT';
					}
				});
			}
			return false;
		});
		//end of submit form
	</script>
	<script>
		$(function() {

			var substringMatcher = function(strs) {
		        return function findMatches(q, cb) {
		            var matches, substringRegex;
		            matches = [];
		            substrRegex = new RegExp(q, 'i');
		            $.each(strs, function(i, str) {
		                if (substrRegex.test(str)) {
		                    matches.push({ value: str });
		                }
		            });
		            cb(matches);
		        };
		    };

			var country = [<?php echo $this->All->countryList(); ?>];
			var city 	= [<?php echo $this->All->cityList(); ?>];

		    $('.tagsinput-typeaheadCountry').tagsinput('input').typeahead(
		        {
		            hint: true,
		            highlight: true,
		            minLength: 1
		        },
		        {
		            name: 'country',
		            displayKey: 'value',
		            source: substringMatcher(country)
		        }
		    ).bind('typeahead:selected', $.proxy(function (obj, datum) {
		        this.tagsinput('add', datum.value);
		        this.tagsinput('input').typeahead('val', '');
		    }, $('.tagsinput-typeaheadCountry')));

		    $('.tagsinput-typeaheadCountry1').tagsinput('input').typeahead(
		        {
		            hint: true,
		            highlight: true,
		            minLength: 1
		        },
		        {
		            name: 'country',
		            displayKey: 'value',
		            source: substringMatcher(country)
		        }
		    ).bind('typeahead:selected', $.proxy(function (obj, datum) {
		        this.tagsinput('add', datum.value);
		        this.tagsinput('input').typeahead('val', '');
		    }, $('.tagsinput-typeaheadCountry1')));

		    $('.tagsinput-typeaheadCity').tagsinput('input').typeahead(
		        {
		            hint: true,
		            highlight: true,
		            minLength: 1
		        },
		        {
		            name: 'city',
		            displayKey: 'value',
		            source: substringMatcher(city)
		        }
		    ).bind('typeahead:selected', $.proxy(function (obj, datum) {
		        this.tagsinput('add', datum.value);
		        this.tagsinput('input').typeahead('val', '');
		    }, $('.tagsinput-typeaheadCity')));

		    $('.tagsinput-typeaheadCity1').tagsinput('input').typeahead(
		        {
		            hint: true,
		            highlight: true,
		            minLength: 1
		        },
		        {
		            name: 'city',
		            displayKey: 'value',
		            source: substringMatcher(city)
		        }
		    ).bind('typeahead:selected', $.proxy(function (obj, datum) {
		        this.tagsinput('add', datum.value);
		        this.tagsinput('input').typeahead('val', '');
		    }, $('.tagsinput-typeaheadCity1')));

	    });
	</script>
	<style>
	  	.date_field {position: relative; z-index:9999;}
	  	.ui-datepicker{z-index: 9999 !important};
  	</style>
</head>
<body>
	<?php require_once(APPPATH."views/master/main_navbar.php"); ?>
	<?php require_once(APPPATH."views/master/second_navbar.php"); ?>
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Land Tour Management</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/product/landtour_index">Land Tour management</a></li>
					<li><a href="<?php echo base_url(); ?>backend/product/landtour_add_new">Add new product</a></li>
				</ul>
			</div>
			<div class="heading-elements">
				<div class="heading-btn-group" style="margin-top:25px">
					<div style="float:right; margin-right:10px; margin-top:-25px">
						<button type="button" class="btn btn-primary btn-icon dropdown-toggle" data-toggle="dropdown">
							<b><i class="icon-menu7"></i></b> &nbsp; Land Tour Option Menu <span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li>
								<a href="<?php echo base_url(); ?>backend/product/landtour_add_new">
									<i class="icon-add"></i>Add new land tour product
								</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>backend/product/landtour_category">
									<i class="icon-add"></i> Manage Category
								</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>backend/product/landtour_location">
									<i class="icon-add"></i> Manage Location
								</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>backend/product/landtour_special_instruction">
									<i class="icon-add"></i> Manage Special Instruction
								</a>
							</li>
						</ul>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<?php echo $this->session->userdata('addNewCruise'); ?>
						<?php echo $this->session->unset_userdata('addNewCruise'); ?>
						<h5 class="panel-title">Add new product</h5>
						<form action="#" method="post" class="form-horizontal" id="submitNewLandTour">
							<div class="panel-body">
								<fieldset class="content-group">
									<div class="form-group">
										<div class="col-lg-12" style="margin-bottom:10px">
											<label>* Set as Feature Land Tour Product</label>
											<div style="margin-bottom:10px; margin-top:-5px">
												<label class="radio-inline">
													<input type="radio" name="feature_product_radio" id="feature_product_radio" value="0" checked />
													NO
												</label>
												<label class="radio-inline">
													<input type="radio" name="feature_product_radio" id="feature_product_radio" value="1" />
													YES
												</label>
											</div>
										</div>
										<div class="col-lg-12">
											<label>* Land Tour Category</label>
											<select name="lt_category" id="lt_category" class="form-control" style="width:50%">
							                	<option value="">Please select land tour category</option>
							                	<?php
								                $cats = $this->All->select_template_with_order(
								                	"category_name", "ASC", "landtour_category"
								                );
								                if( $cats == TRUE ) {
									                foreach( $cats AS $cat ) {
										        ?>
										        <option value="<?php echo $cat->id; ?>">
										        	<?php echo $cat->category_name; ?>
										        </option>
										        <?php
									                }
								                }
								                ?>
							                </select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<label>* Land Tour Code</label>
											<input type="text" name="lt_tourID" id="lt_tourID" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<label>* Land Tour Title</label>
											<input type="text" name="lt_title" id="lt_title" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<label>* Land Tour Highlight</label>
											<textarea name="lt_highlight" id="summernote" class="summernote"></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-4">
											<label>* Start Date</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar22"></i></span>
												<input type="text" name="start_date" id="start_date" class="form-control" readonly />
											</div>
										</div>
										<div class="col-lg-4">
											<label>* End Date</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar22"></i></span>
												<input type="text" name="end_date" id="end_date" class="form-control" readonly />
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-4">
											<label>* Land Tour Location</label>
											<select name="location" id="location" class="form-control">
												<option value="">Select land tour location</option>
												<?php
												$lists = $this->All->select_template_with_order(
													"country_name", "ASC", "landtour_location"
												);
												if( $lists == TRUE ) {
													foreach( $lists AS $list ) {
												?>
												<option value="<?php echo $list->country_name; ?>">
													<?php echo $list->country_name; ?>
												</option>
												<?php
													}
												}
												?>
						                    </select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<label>Land Tour Tags</label>
											<input type="text" name="tags" id="tags" class="form-control" data-role="tagsinput" placeholder="Enter tag(s) for this product. (Press enter to insert)" />
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</fieldset>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php require_once(APPPATH."views/master/footer.php"); ?>
	</div>
</body>
</html>