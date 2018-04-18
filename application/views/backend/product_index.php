<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTCFITApp - Product Management</title>
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
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/prism.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/editor_ckeditor.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/uploaders/dropzone.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/uploader_dropzone.js"></script>
	<!-- /theme JS files -->
	<script>
		Dropzone.options.myDropzone= {
		    url: <?php echo base_url().'backend/product/upload'; ?>,
		    autoProcessQueue: false,
		    uploadMultiple: true,
		    parallelUploads: 100,
		    maxFiles: 100,
		    maxFilesize: 1,
		    acceptedFiles: 'image/*',
		    addRemoveLinks: true,
			init: function() {
				dzClosure = this; // Makes sure that 'this' is understood inside the functions below.
		        // for Dropzone to process the queue (instead of default form behavior):
		        document.getElementById("submit-all").addEventListener("click", function(e) {
		            // Make sure that the form isn't actually being sent.
		            e.preventDefault();
		            e.stopPropagation();
		            dzClosure.processQueue();
		        });
		        //send all the form data along with the files:
		        this.on("sendingmultiple", function(data, xhr, formData) {
		            formData.append("firstname", jQuery("#firstname").val());
		            formData.append("lastname", jQuery("#lastname").val());
		        });
			}
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#select_category").on('change', function() {
			    if( $(this).val() == 'hotel_value' ) {
				    $("#hotel_content_ad_form").show();
			        $("#flight_content_ad_form").hide();
			    } 
			    else if( $(this).val() == 'flight_value' ) {
			        $("#hotel_content_ad_form").show();
			        $("#flight_content_ad_form").hide();
			    }
			});
		});
	</script>
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
					<span class="text-semibold">Product Management</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/product">Product Management</a></li>
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

				<!-- Basic datatable -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Add new product</h5>
						<br />
<?php echo form_open_multipart('#', array('class' => 'form-horizontal')); ?>
	<div class="panel-body">
		<fieldset class="content-group">
			<div class="form-group">
				<label class="control-label col-lg-3">
					* Choose product category
				</label>
				<div class="col-lg-4">
					<select name="select_category" id="select_category" class="form-control">
	                    <option value="hotel_value">Hotels</option>
	                    <option value="flight_value">Flights</option>
	                </select>
				</div>
			</div>
			<div id="hotel_content_ad_form">
				<div class="form-group">
					<label class="control-label col-lg-3">
						* Hotel name / title / code
					</label>
					<div class="col-lg-9">
						<input type="text" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">
						* Hotel details / description
					</label>
					<div class="col-lg-9">
						<textarea name="editor-full" id="editor-full" rows="4" cols="4"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">&nbsp;</label>
					<div class="col-lg-3">
						Check-in date
						<input type="text" class="form-control">
					</div>
					<label class="control-label col-lg-1">&nbsp;</label>
					<div class="col-lg-3">
						Check-out date
						<input type="text" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">&nbsp;</label>
					<div class="col-lg-3">
						Original price
						<input type="text" class="form-control">
					</div>
					<label class="control-label col-lg-1">&nbsp;</label>
					<div class="col-lg-3">
						After discount price
						<input type="text" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">&nbsp;</label>
					<div class="col-lg-3">
						** Price for extra bed
						<input type="text" class="form-control">
					</div>
					<label class="control-label col-lg-1">&nbsp;</label>
					<div class="col-lg-3">&nbsp;</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3" style="height:100px">
						* Room Features
					</label>
					<div style="margin-left:100px">
						&nbsp;&nbsp;
						<a style="text-decoration:underline">Select all</a>
						&nbsp;&nbsp;
						<a style="text-decoration:underline">Unselect all</a>
						<br />
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;air conditioning
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;desk
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;internet access - wireless
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;non smoking rooms
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;television
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;coffee/tea maker
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;hair dryer
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;ironing facilities
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;satellite/cable TV
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;television LCD/plasma screen
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;daily newspaper
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;in room safe
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;mini bar
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;shower
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-lg-3">
						* Hotel / Room image(s)
					</label>
					<div class="col-lg-9">
						<div class="dropzone" id="myDropzone"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">
						* Remark / Terms & Conditions / Policies
					</label>
					<div class="col-lg-9">
						<textarea name="editor-full" id="editor-full1" rows="4" cols="4"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">
						* Special Conditions / Useful Information
					</label>
					<div class="col-lg-9">
						<textarea name="editor-full" id="editor-full2" rows="4" cols="4"></textarea>
					</div>
				</div>
			</div>
			<div id="flight_content_ad_form">
				<div class="form-group">
					<label class="control-label col-lg-3">
						* Hotel name / title / code
					</label>
					<div class="col-lg-9">
						<input type="text" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">
						* Hotel details / description
					</label>
					<div class="col-lg-9">
						<textarea name="editor-full" id="editor-full" rows="4" cols="4"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">&nbsp;</label>
					<div class="col-lg-3">
						Check-in date
						<input type="text" class="form-control">
					</div>
					<label class="control-label col-lg-1">&nbsp;</label>
					<div class="col-lg-3">
						Check-out date
						<input type="text" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">&nbsp;</label>
					<div class="col-lg-3">
						Original price
						<input type="text" class="form-control">
					</div>
					<label class="control-label col-lg-1">&nbsp;</label>
					<div class="col-lg-3">
						After discount price
						<input type="text" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">&nbsp;</label>
					<div class="col-lg-3">
						** Price for extra bed
						<input type="text" class="form-control">
					</div>
					<label class="control-label col-lg-1">&nbsp;</label>
					<div class="col-lg-3">&nbsp;</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3" style="height:100px">
						* Room Features
					</label>
					<div style="margin-left:100px">
						&nbsp;&nbsp;
						<a style="text-decoration:underline">Select all</a>
						&nbsp;&nbsp;
						<a style="text-decoration:underline">Unselect all</a>
						<br />
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;air conditioning
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;desk
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;internet access - wireless
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;non smoking rooms
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;television
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;coffee/tea maker
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;hair dryer
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;ironing facilities
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;satellite/cable TV
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;television LCD/plasma screen
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;daily newspaper
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;in room safe
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;mini bar
					</div>
					<div class="col-lg-2">
						<input type="checkbox" name="" checked /> &nbsp;&nbsp;shower
					</div>
				</div>		
				<div class="form-group">
					<label class="control-label col-lg-3">
						* Hotel / Room image(s)
					</label>
					<div class="col-lg-9">
						<div class="dropzone" id="myDropzone"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">
						* Remark / Terms & Conditions / Policies
					</label>
					<div class="col-lg-9">
						<textarea name="editor-full" id="editor-full1" rows="4" cols="4"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">
						* Special Conditions / Useful Information
					</label>
					<div class="col-lg-9">
						<textarea name="editor-full" id="editor-full2" rows="4" cols="4"></textarea>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="modal-footer" style="margin-top:-30px">
		<button type="button" class="btn btn-primary">Add new hotel</button>
	</div>
<?php echo form_close(); ?>
					</div>
				</div>
				<!-- /basic datatable -->

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