<?php
$landtours = $this->All->select_template("id", $this->uri->segment(4), "landtour_product");
foreach( $landtours AS $landtour ) {
	$landtourID	    = $landtour->id;
	$lt_category_id = $landtour->lt_category_id;
	$lt_tourID 		= $landtour->lt_tourID;
	$lt_title   	= $landtour->lt_title;
	$lt_hightlight  = $landtour->lt_hightlight;
	$lt_itinerary 	= $landtour->lt_itinerary;
	$start_date 	= $landtour->start_date;
	$start_country 	= $landtour->start_country;
	$start_city 	= $landtour->start_city;
	$end_date   	= $landtour->end_date;
	$end_country   	= $landtour->end_country;
	$end_city   	= $landtour->end_city;
	$location		= $landtour->location;
	$is_suspend 	= $landtour->is_suspend;
	$tags 			= $landtour->tags;
	$starting_price = $landtour->starting_price;
	$is_feature 	= $landtour->is_feature;
	$slug_url 		= $landtour->slug_url;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Land Tour Overview</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/style_custom.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- <link href="<?php echo base_url(); ?>assets/back-end/assets/css/summernote.css" rel="stylesheet" type="text/css"> -->
	<link href="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/editors/summernote/summernote.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery_ui/datepicker.min.js"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/tags/tagsinput.min.js"></script> -->
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/tags/tokenfield.min.js"></script> -->
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/editors/summernote/summernote.js"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/editors/summernote/summernote-ext-fontstyle.js"></script> -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#editlandtour_highlight_summernote').summernote({
				height:250,
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
			$('#editlandtour_iti_desc_summernote').summernote({
				height:250,
				toolbar: [
					['style', ['fontname', 'bold', 'italic', 'underline', 'clear']],
				    ['fontsize', ['fontsize']],
				    ['color', ['color']],
				    ['para', ['style', 'ul', 'ol', 'paragraph']],
				    ['height', ['height']],
				    ['insert', ['picture', 'link', 'table', 'hr']],
				    ['misc', ['fullscreen','codeview', 'undo', 'redo', 'help']]
				],
				dialogsInBody: true,
				onpaste: function (e) {
			        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

			        e.preventDefault();

			        document.execCommand('insertText', false, bufferText);
			    }
			});
			$('#editlandtour_iti_extra_summernote').summernote({
				height:250,
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
			<?php
			$ones = $this->All->select_template_with_where_and_order(
				"landtour_product_id", $this->uri->segment(4), "itinerary_day_no", "ASC", "landtour_itinerary"
			);
			if( $ones == TRUE ) {
				foreach( $ones AS $one ) {
			?>
					//$('#desc_edit_itinerary<?php echo $one->id; ?>').html('test only 123');
					//$('#desc_edit_itinerary<?php echo $one->id; ?>').summernote('html', 'hellow world');
					$('#desc_edit_itinerary<?php echo $one->id; ?>').summernote({
						dialogsInBody: true,
						//airMode: true,
						height:300,
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
					    },
					    /*
					    callbacks: {
							onInit: function(e) {
								$("#desc_edit_itinerary<?php echo $one->id; ?>").summernote("fullscreen.toggle");
    						}
  						}
  						*/
					});
					$('#extra_edit_itinerary<?php echo $one->id; ?>').summernote({
						dialogsInBody: true,
						//airMode: true,
						height:300,
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
					    },
					    /*
					    callbacks: {
							onInit: function(e) {
								$("#extra_edit_itinerary<?php echo $one->id; ?>").summernote("fullscreen.toggle");
    						}
  						}
  						*/
					});
			<?php
				}
			}
			?>
			$('.note-editable').css('font-size','1.3em');
		});
	</script>
	<script type="text/javascript">
		$(function() {
			$("#datepickerLTStart").datepicker({dateFormat:"yy-mm-dd"});
			$("#datepickerLTEnd").datepicker({dateFormat:"yy-mm-dd"});
			$("#price_date").datepicker({dateFormat:"yy-mm-dd"});
			$('#characterLeft').text('<?php echo strlen($lt_hightlight); ?> character(s)');
			$('#characterLeft1').text('<?php echo strlen($lt_itinerary); ?> character(s)');
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
	<script type="text/javascript">
		$(function() {
			$("#arrivalTime").AnyTime_picker({ format: "%H:%i" });
			$("#departureTime").AnyTime_picker({ format: "%H:%i" });
		});
		$(function() {
			$("#departure_date").multiDatesPicker({dateFormat: "yy-mm-dd"});
		});
		//update statement record
		$(document).ready(function() {
			$("table#stateroomTable .editButtonSTT").click(function() {
				var attributeID = $(this).attr('id');
				$("#UnableEditMode_"+attributeID).hide();
				$("#EnableEditMode_"+attributeID).show();
				$("#qty_"+attributeID).hide();
				$("#qtyEdit_"+attributeID).show();
		        return false;
		    });
		});
		//end of update statement record
		//image upload
		$(document).ready(function() {
			Dropzone.autoDiscover = false;
			$("#dropzone_multiple").dropzone({
				acceptedFiles: 'image/*',
				url: '<?php echo base_url(); ?>backend/landtour_process/uploadImage/<?php echo $this->uri->segment(4); ?>',
		        paramName: "file",
		        dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
		        maxFiles: 10,
		        maxFilesize: 10,
		        maxfilesexceeded: function(file)
				{
					alert('You have uploaded more than 10 images. Only 10 files can be uploaded at the same stime');
				},
				success: function (response) {
					var x = JSON.parse(response.xhr.responseText);
					$('#landtourImageTable tbody tr:last').after('<tr id="deleteRowImage"><td><a href="<?php echo base_url(); ?>assets/landtour_img/'+x.fileName+'" target="_blank" style="text-decoration:underline">'+x.fileName+'</a></td><td style="text-align:center"><span style="color:black"><b>DEFAULT</b></span><br /><span style="font-size:11px"><i><a href="<?php echo base_url(); ?>backend/landtour_process/setPrimaryImage/'+x.fileID+'/<?php echo $this->uri->segment(4); ?>">(Click to set to primary)</a></i></span></td><td>'+x.fileSize+'</td><td>'+x.fileType+'</td><td>'+x.fileCreated+'</td><td><a href="<?php echo base_url(); ?>backend/landtour_process/deleteLandtourImage/'+x.fileID+'" id="deleteLandtourImage" class="btn btn-primary btn-labeled"><b><i class="icon-trash"></i></b> Delete image</a></td></tr>');
				}
		    });
	    });
		//end of image upload
		//PDF upload
		$(document).ready(function() {
			Dropzone.autoDiscover = false;
			$("#dropzone_pdf").dropzone({
				acceptedFiles: 'application/pdf',
				url: '<?php echo base_url(); ?>backend/landtour_process/uploadPDF/<?php echo $this->uri->segment(4); ?>',
		        paramName: "file",
		        dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
		        maxFiles: 1,
		        maxFilesize: 10,
		        maxfilesexceeded: function(file)
				{
					alert('You have uploaded more than 1 pdf. Only 1 PDF file can be uploaded at the same stime');
				},
				success: function (response) {
					var x = JSON.parse(response.xhr.responseText);
					window.location = '<?php echo base_url(); ?>backend/product/landtour_overview/<?php echo $this->uri->segment(4); ?>';
				}
		    });
	    });
		//end of PDF upload
	  	//delete land tour image
	  	$(document).ready(function() {
		  	$('a#deleteLandtourImage').click(function(){
		        $.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Image deleted');
		            }
		        );
		        $(this).closest("tr#deleteRowImage").remove();
		        return false;
		    });
		});
		$(document).on('click', 'a#deleteLandtourImage', function(e){
			$.get(
	            $(this).attr('href'),
	            {},
	            function(data) {
	               alert('Image deleted');
	            }
	        );
	        $(this).closest("tr#deleteRowImage").remove();
	        return false;
		});
	  	//end of delete land tour image
	  	//delete date
	  	$(document).ready(function() {
		  	$('a#deleteDate').click(function(){
		        $.get(
		            $(this).attr('href'),
		            {},
		            function(data) {
		                alert('Land tour price date removed');
		            }
		        );
		        window.location = '<?php echo base_url(); ?>backend/product/landtour_overview/<?php echo $this->uri->segment(4); ?>';
		        return false;
		    });
		});
		$(document).on('click', '#deleteDate', function(e){
			$.get(
	            $(this).attr('href'),
	            {},
	            function(data) {
	                alert('Land tour price date removed');
	            }
	        );
	        window.location = '<?php echo base_url(); ?>backend/product/landtour_overview/<?php echo $this->uri->segment(4); ?>';
	        return false;
		});
	  	//end of delete date
  	</script>
	<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/form_tags_input.js"></script>-->
	<script type="text/javascript">
		//submit form
		$(document).on('submit', '#editLandtourDetails', function() {
			var lt_ID		 = $("#hidden_landtour_productID").val();
			var lt_tourID 	 = $("#lt_tourID").val();
			var lt_title 	 = $("#lt_title").val();
			var lt_highlight = encodeURIComponent($("#editlandtour_highlight_summernote").val());
			var start_date 	 = $("#datepickerLTStart").val();
			var end_date     = $("#datepickerLTEnd").val();
			var location	 = $("#lt_location").val();
			var tags		 = $("#tags").val();
			var radioFeature = $("#feature_product_radio:checked").val();
			var lt_itinerary = "";
			var st_country   = "";
			var st_city      = "";
			var en_country   = "";
			var en_city      = "";
			var dataString   = 'isFeature='+radioFeature+'&lt_ID=<?php echo $this->uri->segment(4); ?>&lt_tourID='+lt_tourID+'&lt_title='+lt_title+'&lt_highlight='+lt_highlight+'&lt_itinerary='+lt_itinerary+'&location='+location+'&start_date='+start_date+'&st_country='+st_country+'&st_city='+st_city+'&end_date='+end_date+'&en_country='+en_country+'&en_city='+en_city+'&tags='+tags;
			if( lt_tourID.trim() == '' ) 	   		{ alert("Please enter land tour ID"); 			}
			else if( lt_title.trim() == '' ) 	   	{ alert("Please enter land tour title"); 		}
			else if( lt_highlight.trim() == '' ) 	{ alert("Please enter land tour highlight"); 	}
			else if( start_date.trim() == '' ) 		{ alert("Please enter start date"); 			}
			else if( end_date.trim() == '' ) 		{ alert("Please enter end date"); 				}
			else if( location.trim() == '' ) 		{ alert("Please enter location"); 				}
			else {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backend/landtour_process/update_landtour_product",
					data: dataString,
					cache: false,
					dataType:'JSON',
					success: function(result) {
						alert(result.message);
					}
				});
			}
			return false;
		});
		//end of submit form
		//add manage date
		$(document).on('submit', '#formManageDate', function() {
			var price_date   = $("#price_date").val();
			var selling_type = $("#selling_type").val();
			var dataString = 'landtour_product_id=<?php echo $this->uri->segment(4); ?>&price_date='+price_date+'&selling_type='+selling_type;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>backend/landtour_process/insertPriceDate",
				data: dataString,
				cache: false,
				dataType:'JSON',
				success: function(result) {
					if( result.errorCode == 1 ) {
						alert(result.message);
					}
					else {
						window.location = '<?php echo base_url(); ?>backend/product/landtour_overview/<?php echo $this->uri->segment(4); ?>';
						//$('#priceDateTABLE tbody tr:last').after('<tr class="deleteRow"><td style="width:400px; text-align:left"><span style="color:green"><b>'+result.priceDate+'</b></span></td><td style="width:300px; text-align:left"><a href="<?php echo base_url(); ?>backend/landtour_process/deleteDate/'+result.dateID+'" id="deleteDate" style="text-decoration:underline">Delete date</a></td></tr>');
					}
				}
			});
			return false;
		});
		//end of add manage date
	</script>
	<script>
		$(function() {
			/*var substringMatcher = function(strs) {
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
		    }, $('.tagsinput-typeaheadCity1')));*/
	    });
	</script>
	<script type="text/javascript">
		//submit form land tour itinerary
		$(document).on('submit', '#addItineraryFrom', function() {
			var itinerary_day  		 = $("#itinerary_day").val();
			var itinerary_title    	 = $("#itinerary_title").val();
			//var itinerary_desc 		 = $("#editlandtour_iti_desc_summernote").code();
			//$("#editlandtour_iti_desc_summernote").val();
			//var itinerary_extra_info = $("#editlandtour_iti_extra_summernote").code();

			var itinerary_desc = $('#editlandtour_iti_desc_summernote').summernote('code');
			var itinerary_extra_info = $('#editlandtour_iti_extra_summernote').summernote('code');

			var dataString = 'landtourProductID=<?php echo $this->uri->segment(4); ?>&itinerary_day='+itinerary_day+'&itinerary_title='+itinerary_title+'&itinerary_desc='+itinerary_desc+'&itinerary_extra_info='+itinerary_extra_info;
			if( itinerary_title == '' ) {
				alert("Please insert itinerary title");
				$("#itinerary_title").focus();
				return false;
			}
			else if( itinerary_desc == '<p><br></p>' ) {
				alert("Please insert itinerary description / remark");
				$("#itinerary_desc").focus();
				return false;
			}
			else {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backend/product/insert_landtourItinerary",
					data: dataString,
					cache: false,
					dataType:'JSON',
					success: function(result) {
						if( result.errorCode == 1 ) {
							alert(result.message);
						}
						else {
							alert(result.message);
							window.location = '<?php echo base_url(); ?>backend/product/landtour_overview/<?php echo $this->uri->segment(4); ?>';
						}
					}
				});
			}
			return false;
		});
		//end of submit form land tour itinerary
	</script>
	<style>
	  	.date_field {position: relative; z-index:9999;}
	  	.ui-datepicker{z-index: 9999 !important};
  	</style>
  	<style>
	  	.editbox { display:none; }
		.EnableEditMode { display:none; }
		.note-toolbar-wrapper {
			height: auto !important;
		}
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
					<li>
						<a href="<?php echo base_url(); ?>backend/product/landtour_overview/<?php echo $this->uri->segment(4); ?>">
							Land Tour Overview Details
						</a>
					</li>
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
					<div style="float:right; margin-right:10px; margin-top:-25px">
						<a href="<?php echo base_url(); ?>landtour/details/<?php echo $slug_url; ?>" target="_blank" class="btn btn-primary">
							<b><i class="icon-screen3"></i></b> &nbsp; Land Tour Preview
						</a>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="row">
					<div class="col-lg-12">
						<?php echo $this->session->flashdata('sessionSHOULDERPrice'); ?>
						<?php echo $this->session->flashdata('sessionLOWPrice'); ?>
						<?php echo $this->session->flashdata('sessionPEAKPrice'); ?>
						<?php echo $this->session->flashdata('childAgeRule_session'); ?>
						<?php echo $this->session->flashdata('childAgeRule_error'); ?>
						<?php echo $this->session->flashdata('childAgeRule_delete'); ?>
						<?php echo $this->session->flashdata('updateStartingPrice'); ?>
						<?php echo $this->session->flashdata('setPrimaryImage_session'); ?>
						<?php echo $this->session->flashdata('updateLandtourPrices'); ?>
						<?php echo $this->session->flashdata('updateItineraryDetails'); ?>
						<?php echo $this->session->flashdata('deleteItinerary'); ?>
						<?php echo $this->session->flashdata('deleteItineraryPDF'); ?>
						<div class="row">
							<div class="col-lg-6">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Edit land tour details</h3>
<form action="#" method="post" class="form-horizontal" id="editLandtourDetails">
	<div class="panel-body">
		<input type="hidden" name="hidden_landtour_productID" id="hidden_landtour_productID" value="<?php echo $this->uri->segment(4); ?>" />
		<fieldset class="content-group">
			<div class="form-group">
				<div class="col-lg-12">
					<label>* Set as Feature Land Tour Product</label>
					<div style="margin-bottom:0px; margin-top:-5px">
						<?php
						if( $is_feature == 1 ) {
						?>
							<label class="radio-inline">
								<input type="radio" name="feature_product_radio" id="feature_product_radio" value="0" />
								NO
							</label>
							<label class="radio-inline">
								<input type="radio" name="feature_product_radio" id="feature_product_radio" value="1" checked />
								YES
							</label>
						<?php
						}
						else {
						?>
							<label class="radio-inline">
								<input type="radio" name="feature_product_radio" id="feature_product_radio" value="0" checked />
								NO
							</label>
							<label class="radio-inline">
								<input type="radio" name="feature_product_radio" id="feature_product_radio" value="1" />
								YES
							</label>
						<?php
						}
						?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>* Land Tour ID</label>
					<input type="text" name="lt_tourID" id="lt_tourID" class="form-control" value="<?php echo $lt_tourID; ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>* Land Tour Title</label>
					<input type="text" name="lt_title" id="lt_title" class="form-control" value="<?php echo $lt_title; ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>* Land Tour Highlight</label>
					<textarea name="lt_hightlight" id="editlandtour_highlight_summernote" class="form-control" maxlength="1000" style="resize:none; height:200px"><?php echo $lt_hightlight; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>* Land Tour Location</label>
					<select name="lt_location" id="lt_location" required class="form-control">
						<option value="">Select land tour location</option>
						<?php
						$lists = $this->All->select_template_with_order(
							"country_name", "ASC", "landtour_location"
						);
						if( $lists == TRUE ) {
							foreach( $lists AS $list ) {
								if( $location == $list->country_name ) {
						?>
						<option value="<?php echo $list->country_name; ?>" SELECTED>
							<?php echo $list->country_name; ?>
						</option>
						<?php
								}
								else {
						?>
						<option value="<?php echo $list->country_name; ?>">
							<?php echo $list->country_name; ?>
						</option>
						<?php
								}
							}
						}
						?>
                    </select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>* Land Tour Start Date</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="icon-calendar22"></i></span>
						<input type="text" name="start_date" id="datepickerLTStart" class="form-control" value="<?php echo $start_date; ?>" readonly />
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>* Land Tour End Date</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="icon-calendar22"></i></span>
						<input type="text" name="end_date" id="datepickerLTEnd" class="form-control" value="<?php echo $end_date; ?>" readonly />
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12">
					<label>Land Tour Tag(s)</label>
					<input type="text" name="tags" id="tags" class="form-control" data-role="tagsinput" placeholder="Enter tag(s) for this product. (Press enter to insert)" value="<?php echo $tags; ?>" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</fieldset>
	</div>
</form>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Edit land tour itinerary</h3>
<table class="table datatable-basic" id="itineraryTable">
	<thead>
		<tr>
			<th style="text-align:center" width="17%">Day</th>
			<th width="83%">Details</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$itinerarys = $this->All->select_template_with_where_and_order(
			"landtour_product_id", $this->uri->segment(4), "itinerary_day_no", "ASC", "landtour_itinerary"
		);
		if( $itinerarys == TRUE ) {
			foreach( $itinerarys AS $itinerary ) {
		?>
		<tr id="deleteRow">
         	<td style="text-align:center"><?php echo $itinerary->itinerary_day_no; ?></td>
		 	<td>
			 	<a data-toggle="modal" data-target="#itineraryDetails<?php echo $itinerary->id; ?>" style="text-decoration:underline">
				 	<?php echo $itinerary->itinerary_title; ?>
				</a>
				<!--ITINERARY DETAILS-->
				<div id="itineraryDetails<?php echo $itinerary->id; ?>" class="modal fade">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h5 class="modal-title">
									Edit Itinerary Details
									(Day - <?php echo $itinerary->itinerary_day_no; ?>)
								</h5>
							</div>
							<?php echo form_open_multipart('backend/landtour_process/edit_itinerary/', array('class' => 'form-horizontal')); ?>
								<input type="hidden" name="hidden_itinerary_id" value="<?php echo $itinerary->id; ?>" />
								<input type="hidden" name="hidden_landtour_productID" value="<?php echo $this->uri->segment(4); ?>" />
								<div class="modal-body">
									<fieldset class="content-group">
										<div class="form-group">
											<label class="control-label col-lg-12">
												<b>Itinerary title</b>
												<br />
												<input type="text" name="edit_itinerary_title" required class="form-control" value="<?php echo $itinerary->itinerary_title; ?>" />
											</label>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-12">
												<b>Itinerary description</b>
												<br />
												<textarea name="edit_itinerary_desc" id="desc_edit_itinerary<?php echo $itinerary->id; ?>" class="form-control"><?php echo $itinerary->itinerary_desc; ?></textarea>
											</label>
										</div>
										<div class="form-group" style="margin-top:-20px">
											<label class="control-label col-lg-12">
												<b>Itinerary extra info</b>
												<br />
												<textarea name="edit_itinerary_extra_info" id="extra_edit_itinerary<?php echo $itinerary->id; ?>" class="form-control"><?php echo $itinerary->itinerary_extra_info; ?></textarea>
											</label>
										</div>
									</fieldset>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
									<a href="<?php echo base_url(); ?>backend/landtour_process/delete_itinerary/<?php echo $itinerary->id; ?>/<?php echo $this->uri->segment(4); ?>" class="btn btn-danger">Delete this itinerary</a>
									<button type="submit" class="btn btn-primary">Save changes</button>
								</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
				<!--END OF ITINERARY DETAILS-->
			 </td>
		</tr>
		<?php
			}
		}
		?>
	</tbody>
	<tfoot>
		<form id="addItineraryFrom">
			<tr>
	         	<td>
			 		<input type="text" name="itinerary_day" id="itinerary_day" class="form-control" style="text-align:center" readonly value="Day <?php echo $this->All->getLatestDayItinerary($this->uri->segment(4)); ?>" />
			 	</td>
			 	<td>
			 		<input type="text" name="itinerary_title" id="itinerary_title" class="form-control" placeholder="Enter itinerary title" />
			 	</td>
			</tr>
			<tr>
				<td colspan="4" style="border-top:none">
					<div style="margin-top:-30px">
						<br />
						<b>Itinerary description</b>
						<textarea name="itinerary_desc" id="editlandtour_iti_desc_summernote" class="form-control" placeholder="Enter itinerary description / remark"></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="4" style="border-top:none">
					<div style="margin-top:-30px">
						<br />
						<b>Itinerary extra info (Optional)</b>
						<textarea name="itinerary_extra_info" id="editlandtour_iti_extra_summernote" class="form-control" placeholder="Enter itinerary extra info (optional)"></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align:right">
					<button type="submit" class="btn btn-primary">Add new itinerary</button>
				</td>
			</tr>
		</form>
	</tfoot>
</table>
									</div>
								</div>
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Manual Starting Price</h3>
<form action="<?php echo base_url(); ?>backend/landtour_process/updateStartingPrice" method="post" class="form-horizontal">
	<div class="panel-body" style="padding:10px; margin-bottom:-40px">
		<input type="hidden" name="hidden_landtour_productID" value="<?php echo $this->uri->segment(4); ?>" />
		<fieldset class="content-group">
			<div class="form-group">
				<div class="col-lg-12">
					<label>Enter price</label>
					<input type="text" name="manual_starting_price" id="manual_starting_price" class="form-control" value="<?php echo $starting_price; ?>" required onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</fieldset>
	</div>
</form>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3 id="editCruiseImageAnchor">Edit land tour images</h3>
<div style="float:right; margin-top:-40px; margin-bottom:20px">
	<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#uploadNewImage">
		<b><i class="icon-add"></i></b> Add image(s)
	</button>
	<!--NEW UPLOAD FORM-->
	<div id="uploadNewImage" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Upload new image</h5>
				</div>
				<div class="modal-body">
					<?php echo form_open_multipart('#', array('class' => 'dropzone', 'id' => 'dropzone_multiple')); ?>
						<input type="hidden" name="hidden_landtour_productID" value="<?php echo $this->uri->segment(4); ?>" />
					<?php echo form_close(); ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!--END OF NEW UPLOAD FORM-->
</div>
<div style="clear:both"></div>
<div style="text-align:right">
	<span style="color:green">
		<b><i>Recommended land tour image size: (Width:850px) X (Height:450px)</i></b>
	</span>
</div>
<table class="table datatable-basic" id="landtourImageTable">
	<thead>
		<tr>
			<th width="30%">Image</th>
			<th width="15%" style="text-align:center">Status</th>
			<th width="5%">File type</th>
			<th width="10%">File size (in KB)</th>
			<th width="10%">Created</th>
			<th width="10%">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$images = $this->All->select_template("landtour_product_id", $this->uri->segment(4), "landtour_image");
		if( $images == TRUE ) {
			foreach( $images AS $image ) {
		?>
		<tr id="deleteRowImage">
         	<td>
	         	<a href="<?php echo base_url(); ?>assets/landtour_img/<?php echo $image->file_name; ?>" target="_blank" style="text-decoration:underline">
		         	<?php echo $image->file_name; ?>
		         </a>
	        </td>
	        <td style="text-align:center">
		        <?php
			    if( $image->imgStatus == "PRIMARY" ) {
				?>
					<span style="color:green"><b>PRIMARY</b></span>
					<br />
					<span style="font-size:11px">
		        		<i><a href="<?php echo base_url(); ?>backend/landtour_process/setPrimaryImage/<?php echo $image->id; ?>/<?php echo $this->uri->segment(4); ?>">(Click to set to primary)</a></i>
					</span>
				<?php
			    }
			    else {
			    ?>
		        	<span style="color:black"><b>DEFAULT</b></span>
					<br />
					<span style="font-size:11px">
		        		<i><a href="<?php echo base_url(); ?>backend/landtour_process/setPrimaryImage/<?php echo $image->id; ?>/<?php echo $this->uri->segment(4); ?>">(Click to set to primary)</a></i>
					</span>
		        <?php
			    }
			    ?>
		    </td>
		 	<td><?php echo $image->file_size; ?></td>
		 	<td><?php echo $image->file_type; ?></td>
		 	<td><?php echo date("Y-m-d H:i:s", strtotime($image->created)); ?></td>
		 	<td>
			    <a href="<?php echo base_url(); ?>backend/landtour_process/deleteLandtourImage/<?php echo $image->id; ?>" id="deleteLandtourImage" class="btn btn-primary btn-labeled">
					<b><i class="icon-trash"></i></b> Delete image
				</a>
		 	</td>
		</tr>
		<?php
			}
		}
		?>
	</tbody>
</table>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Download Land Tour Itinerary</h3>
<div style="float:right; margin-top:-40px; margin-bottom:20px">
	<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#uploadNewPDF">
		<b><i class="icon-add"></i></b> Upload itinerary (PDF)
	</button>
	<!--NEW UPLOAD FORM-->
	<?php
	$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$check_res  = mysqli_query(
		$connection,
		"SELECT COUNT(*) AS totalPDF FROM landtour_pdf WHERE landtour_id = ".$this->uri->segment(4).""
	);
	$check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
	if( $check_row["totalPDF"] > 0 ) {
	?>
		<!--NEW UPLOAD FORM-->
		<div id="uploadNewPDF" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h5 class="modal-title">Upload new PDF</h5>
					</div>
					<div class="modal-body" style="text-align:center">
						<b>Only 1 PDF file can be uploaded at the moment. Thank you.</b>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!--END OF NEW UPLOAD FORM-->
	<?php
	}
	else {
	?>
		<!--NEW UPLOAD FORM-->
		<div id="uploadNewPDF" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h5 class="modal-title">Upload new PDF</h5>
					</div>
					<div class="modal-body">
						<form action="https://www.ctc.com.sg/landtour-testing/#" class="dropzone" id="dropzone_pdf" enctype="multipart/form-data" method="post" accept-charset="utf-8">
							<input type="hidden" name="hidden_landtour_product_id" value="<?php echo $this->uri->segment(4); ?>" />
						</form>				</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!--END OF NEW UPLOAD FORM-->
	<?php
	}
	?>
</div>
<div style="clear:both"></div>
<table class="table datatable-basic" id="landtourPDFTable">
	<thead>
		<tr>
			<th width="30%">Image</th>
			<th width="5%" style="text-align:center">File type</th>
			<th width="10%" style="text-align:center">File size (in KB)</th>
			<th width="10%" style="text-align:center">Created</th>
			<th width="10%" style="text-align:center">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$pdfs = $this->All->select_template("landtour_id", $this->uri->segment(4), "landtour_pdf");
		if( $pdfs == TRUE ) {
			foreach( $pdfs AS $pdf ) {
		?>
		<tr id="deleteRowPDF">
         	<td>
	         	<a href="<?php echo base_url(); ?>assets/landtour_pdf/<?php echo $pdf->file_name; ?>" target="_blank" style="text-decoration:underline">
		         	<?php echo $pdf->file_name; ?>
		         </a>
	         </td>
		 	<td style="text-align:center"><?php echo $pdf->file_size; ?></td>
		 	<td style="text-align:center"><?php echo $pdf->file_type; ?></td>
		 	<td style="text-align:center"><?php echo date("Y-m-d H:i:s", strtotime($pdf->created)); ?></td>
		 	<td style="text-align:center">
			    <a href="<?php echo base_url(); ?>backend/landtour_process/deleteLandtourPDF/<?php echo $pdf->id; ?>/<?php echo $this->uri->segment(4); ?>" class="btn btn-primary btn-labeled">
					<b><i class="icon-trash"></i></b> Delete PDF
				</a>
		 	</td>
		</tr>
		<?php
			}
		}
		else {
		?>
		<tr>
			<td colspan="5" style="text-align:center">
				<span style="color:red"><b>No PDF itinerary found</b></span>
			</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="panel">
									<div class="panel-body" style="margin-top:-15px">
										<h3>Edit Land Tour Prices</h3>
<div style="float:right; margin-top:-40px; margin-bottom:20px">
	<button type="button" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#manageDate">
		<b><i class="icon-add"></i></b> Manage date
	</button>
	<div id="manageDate" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title">Land Tour - Manage Date</h5>
				</div>
				<form method="post" class="form-horizontal" id="formManageDate">
					<div class="modal-body">
						<fieldset class="content-group">
							<div class="form-group">
								<label class="control-label col-lg-3">
									* Choose date
								</label>
								<div class="col-lg-9">
									<div class="input-group">
										<span class="input-group-addon"><i class="icon-calendar22"></i></span>
										<input type="text" name="price_date" id="price_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3">
									* Choose selling type
								</label>
								<div class="col-lg-9">
									<div class="input-group">
										<select name="selling_type" id="selling_type" class="form-control" style="width:200px">
											<option value="ROOM">ROOM</option>
											<option value="TICKET">TICKET</option>
										</select>
									</div>
								</div>
							</div>
							<hr />
							<table id="priceDateTABLE">
								<tbody>
									<tr>
										<th style="width:400px">Price date</th>
										<th style="width:200px">Action</th>
									</tr>
									<?php
									$dates = $this->All->select_template_with_where_and_order(
										"landtour_product_id", $this->uri->segment(4), "priceDate", "ASC", "landtour_priceDate"
									);
									if( $dates == TRUE ) {
										foreach( $dates AS $date ) {
									?>
									<tr class="deleteRow">
										<td style="width:400px; text-align:left;">
											<span style="color:green">
												<b>
													(<?php echo $date->selling_type; ?> Type)
													-
													<?php echo date("Y-F-d", strtotime($date->priceDate)); ?>
												</b>
											</span>
										</td>
										<td style="width:300px; text-align:left;">
											<a href="<?php echo base_url(); ?>backend/landtour_process/deleteDate/<?php echo $date->id; ?>/<?php echo $this->uri->segment(4); ?>" id="deleteDate" style="text-decoration:underline">Delete date</a>
										</td>
									</tr>
									<?php
										}
									}
									?>
								</tbody>
							</table>
						</fieldset>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Add new date</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="col-lg-12">
		<div class="tab-content">
			<div id="low" class="tab-pane in active">
				<?php echo form_open_multipart('backend/landtour_process/insert_landtour_prices/', array('class' => 'form-horizontal', 'novalidate' => 'novalidate')); ?>
					<input type="hidden" name="hidden_redirect" value="editMode" />
					<input type="hidden" name="hidden_landtour_productID" value="<?php echo $this->uri->segment(4); ?>" />
				    <table class="table datatable-basic">
				        <tbody>
					        <?php
						    $priceLists = $this->All->select_template_with_where_and_order(
						    	"landtour_product_id", $this->uri->segment(4), "priceDate", "ASC",
						    	"landtour_priceDate"
						    );
							if( $priceLists == TRUE ) {
								foreach( $priceLists AS $priceList ) {
									//get system prices
									$prices = $this->All->select_template_w_2_conditions(
										"landtour_product_id", $this->uri->segment(4),
										"price_date", $priceList->priceDate,
										"landtour_system_prices"
									);
									if( $prices == TRUE ) {
									    foreach( $prices AS $price ) {
										    $adultSingle_price 	   = $price->adultSingle_price;
										    $adultSingle_qty   	   = $price->adultSingle_qty;
										    $adultTwin_price   	   = $price->adultTwin_price;
										    $adultTwin_qty     	   = $price->adultTwin_qty;
										    $adultTriple_price 	   = $price->adultTriple_price;
										    $adultTriple_qty   	   = $price->adultTriple_qty;
										    $child_wb_price    	   = $price->child_wb_price;
										    $child_wb_qty 	   	   = $price->child_wb_qty;
										    $child_wob_price   	   = $price->child_wob_price;
										    $child_wob_qty 	   	   = $price->child_wob_qty;
										    $child_half_twin_price = $price->child_half_twin_price;
										    $child_half_twin_qty   = $price->child_half_twin_qty;
										    $infant_price 	 	   = $price->infant_price;
										    $infant_qty 	 	   = $price->infant_qty;
										    $roomQuantity 	 	   = $price->roomQuantity;
										    $roomCombinationQty    = $price->roomCombinationQty;
										    $ticketAdultPrice      = $price->ticketAdultPrice;
										    $ticketAdultQty    	   = $price->ticketAdultQty;
										    $ticketChildPrice      = $price->ticketChildPrice;
										    $ticketChildQty    	   = $price->ticketChildQty;
										}
									}
									else {
										$adultSingle_price 	   = "";
									    $adultSingle_qty   	   = "";
									    $adultTwin_price 	   = "";
									    $adultTwin_qty 		   = "";
									    $adultTriple_price 	   = "";
									    $adultTriple_qty 	   = "";
									    $child_wb_price  	   = "";
									    $child_wb_qty 	 	   = "";
									    $child_wob_price 	   = "";
									    $child_wob_qty 	 	   = "";
									    $child_half_twin_price = "";
									    $child_half_twin_qty   = "";
									    $infant_price 	 	   = "";
										$infant_qty 	   	   = "";
									    $roomQuantity 	 	   = "";
										$roomCombinationQty    = "";
										$ticketAdultPrice      = "";
									    $ticketAdultQty    	   = "";
									    $ticketChildPrice      = "";
									    $ticketChildQty    	   = "";
									}
									//end of get system prices
							?>
<?php
if( $priceList->selling_type == "TICKET" ) {
?>
	<tr>
		<td width:"200px">
			<div class="input-group">
				<span class="input-group-addon"><i class="icon-calendar22"></i></span>
				<input type="text" name="priceDate[]" class="form-control" value="<?php echo $priceList->priceDate; ?>" readonly />
			</div>
    	</td>
	  	<td style="text-align:left; text-align:center" colspan="2"><b>Adult Ticket Price</b></td>
	  	<td style="text-align:left; text-align:center"><b>Adult Ticket Qty</b></td>
	  	<td style="text-align:left; text-align:center" colspan="2"><b>Child Ticket Price</b></td>
	  	<td style="text-align:left; text-align:center"><b>Child Ticket Qty</b></td>
	</tr>
	<tr>
		<td width:"200px" style="text-align:center">
			<div style="text-align:center">
				<b><?php echo $priceList->selling_type; ?> TYPE</b>
				<input type="hidden" name="hidden_sellingType[]" value="<?php echo $priceList->selling_type; ?>" />
			</div>
    	</td>
    	<td colspan="2">
        	<input type="text" class="form-control" name="ticketAdultPrice[]" value="<?php echo $ticketAdultPrice; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
        <td>
        	<input type="text" class="form-control" name="ticketAdultQty[]" value="<?php echo $ticketAdultQty; ?>" maxlength="2" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
        <td colspan="2">
        	<input type="text" class="form-control" name="ticketChildPrice[]" value="<?php echo $ticketChildPrice; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
        <td>
        	<input type="text" class="form-control" name="ticketChildQty[]" value="<?php echo $ticketChildQty; ?>" maxlength="2" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
	</tr>
	<td colspan="8" style="border-bottom:2px solid black">&nbsp;</td>
	<input type="hidden" name="adultSinglePrice[]" value="" />
  	<input type="hidden" name="adultTwinPrice[]" value="" />
  	<input type="hidden" name="adultTriplePrice[]" value="" />
  	<input type="hidden" name="childWBPrice[]" value="" />
  	<input type="hidden" name="childWOBPrice[]" value="" />
  	<input type="hidden" name="childHalfTwinPrice[]" value="" />
  	<input type="hidden" name="infantPrice[]" value="" />
  	<input type="hidden" name="roomQuantity[]" value="" />
  	<input type="hidden" name="roomCombination[]" value="" />
<?php
}
else {
?>
	<tr>
		<td width:"200px">
			<div class="input-group">
				<span class="input-group-addon"><i class="icon-calendar22"></i></span>
				<input type="text" name="priceDate[]" class="form-control" value="<?php echo $priceList->priceDate; ?>" readonly />
			</div>
    	</td>
	  	<td style="text-align:left; text-align:center"><b>Adult Single<br />Price</b></td>
	  	<td style="text-align:left; text-align:center"><b>Adult Twin<br />Price</b></td>
	  	<td style="text-align:left; text-align:center"><b>Adult Triple<br />Price</b></td>
	  	<td style="text-align:left; text-align:center"><b>Child with bed<br />Price</b></td>
	  	<td style="text-align:left; text-align:center"><b>Child without bed<br />Price</b></td>
	  	<td style="text-align:left; text-align:center"><b>Child half twin<br />Price</b></td>
	  	<td style="text-align:left; text-align:center"><b>Infant<br />Price</b></td>
	</tr>
	<tr>
		<td width:"200px" style="text-align:center">
			<div style="text-align:center">
				<b><?php echo $priceList->selling_type; ?> TYPE</b>
				<input type="hidden" name="hidden_sellingType[]" value="<?php echo $priceList->selling_type; ?>" />
			</div>
    	</td>
    	<td>
        	<input type="text" class="form-control" name="adultSinglePrice[]" value="<?php echo $adultSingle_price; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
        <td>
        	<input type="text" class="form-control" name="adultTwinPrice[]" value="<?php echo $adultTwin_price; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
        <td>
            <input type="text" class="form-control" name="adultTriplePrice[]" value="<?php echo $adultTriple_price; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
        <td>
            <input type="text" class="form-control" name="childWBPrice[]" value="<?php echo $child_wb_price; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
       	<td>
           	<input type="text" class="form-control" name="childWOBPrice[]" value="<?php echo $child_wob_price; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
        <td>
            <input type="text" class="form-control" name="childHalfTwinPrice[]" value="<?php echo $child_half_twin_price; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
        <td>
            <input type="text" class="form-control" name="infantPrice[]" value="<?php echo $infant_price; ?>" maxlength="5" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
    </tr>
    <tr>
        <td width:"200px" align="right" style="border-bottom:2px solid black">Room Quantity :</td>
    	<td style="border-bottom:2px solid black">
        	<input type="text" class="form-control" name="roomQuantity[]" value="<?php echo $roomQuantity; ?>" maxlength="2" onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))" style="text-align:center" />
        </td>
        <td align="right" style="border-bottom:2px solid black">
            Room Capacity :
        </td>
        <td style="border-bottom:2px solid black">
            <select name="roomCombination[]" class="form-control" style="text-align:center">
                <?php
                if( $roomCombinationQty == 0 ) {
	            ?>
		            <option value="1">1 pax</option>
                    <option value="2">2 paxs</option>
                    <option value="3" selected>3 paxs</option>
                    <option value="4">4 paxs</option>
                    <option value="5">5 paxs</option>
                    <option value="6">6 paxs</option>
                    <option value="7">7 paxs</option>
                    <option value="8">8 paxs</option>
                    <option value="9">9 paxs</option>
	            <?php
                }
                else {
	            ?>
		            <option value="1" <?php echo ($roomCombinationQty == 1) ? 'SELECTED' : ''; ?>>1 pax</option>
                    <option value="2" <?php echo ($roomCombinationQty == 2) ? 'SELECTED' : ''; ?>>2 paxs</option>
                    <option value="3" <?php echo ($roomCombinationQty == 3) ? 'SELECTED' : ''; ?>>3 paxs</option>
                    <option value="4" <?php echo ($roomCombinationQty == 4) ? 'SELECTED' : ''; ?>>4 paxs</option>
                    <option value="5" <?php echo ($roomCombinationQty == 5) ? 'SELECTED' : ''; ?>>5 paxs</option>
                    <option value="6" <?php echo ($roomCombinationQty == 6) ? 'SELECTED' : ''; ?>>6 paxs</option>
                    <option value="7" <?php echo ($roomCombinationQty == 7) ? 'SELECTED' : ''; ?>>7 paxs</option>
                    <option value="8" <?php echo ($roomCombinationQty == 8) ? 'SELECTED' : ''; ?>>8 paxs</option>
                    <option value="9" <?php echo ($roomCombinationQty == 9) ? 'SELECTED' : ''; ?>>9 paxs</option>
	            <?php
                }
                ?>
            </select>
        </td>
        <td colspan="4" style="border-bottom:2px solid black">&nbsp;</td>
    </tr>
    <input type="hidden" name="ticketAdultPrice[]" value="" />
  	<input type="hidden" name="ticketAdultQty[]" value="" />
  	<input type="hidden" name="ticketChildPrice[]" value="" />
  	<input type="hidden" name="ticketChildQty[]" value="" />
<?php
}
?>
				            <?php
				            	}
				            }
				            ?>
				        </tbody>
				    </table>
					<div class="modal-footer-2"></div>
				    <div class="modal-footer">
				    	<input type="hidden" name="price_period" value="3">
						<button type="submit" class="btn btn-primary btn-block">Save Prices</button>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require_once(APPPATH."views/master/footer.php"); ?>
	</div>
</body>
</html>