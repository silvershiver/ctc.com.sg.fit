<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTCFITApp - Edit Content Details</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/datatables_basic.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/editor_ckeditor.js"></script>
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
					<span class="text-semibold">Content Management</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/content">Content Management</a></li>
				</ul>
			</div>
			<?php require_once(APPPATH."views/master/heading_element.php"); ?>
		</div>
	</div>
	<!-- /page header -->

	<!-- Page container -->
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Edit content details</h5>
						<br />
<?php
$contents = $this->All->select_template("id", $this->uri->segment(4), "content_management");
foreach( $contents AS $content ) {
	$content_id 	 = $content->id;
	$content_title 	 = $content->content_title;
	$content_details = $content->content_details;
	$content_status  = $content->content_status;
}
?>
<?php echo $this->session->flashdata('success_edit_content'); ?>
<?php echo form_open_multipart('backend/content/save_changes_progress', array('class' => 'form-horizontal')); ?>
	<input type="hidden" name="hidden_content_id" value="<?php echo $content_id; ?>" />
	<div>
		<div style="float:right; margin-top:-50px">
			<a href="<?php echo base_url(); ?>backend/content/media/<?php echo $content_id; ?>" class="btn btn-primary btn-labeled">
				<b><i class="icon-media"></i></b> Media Management
			</a>
		</div>
		<div style="clear:both"></div>
	</div>
	<div>
		<fieldset class="content-group">
			<div class="form-group">
				<label class="control-label col-lg-3">
					* Page title
				</label>
				<div class="col-lg-9">
					<input type="text" name="page_title" required class="form-control" value="<?php echo $content_title; ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3">
					Content
				</label>
				<div class="col-lg-9">
					<textarea name="page_content" id="editor-full" rows="4" cols="4"><?php echo $content_details; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3">
					* Content status
				</label>
				<div class="col-lg-9">
					<select name="choose_status" class="form-control">
						<?php
						if( $content_status == 1 ) {
						?>
						<option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
						<?php	
						}
						else {
						?>
						<option value="1">Active</option>
                        <option value="0" selected>Inactive</option>
						<?php
						}
						?>                  
                    </select>
				</div>
			</div>
		</fieldset>
	</div>		
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
		<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->
	</div>
</body>
</html>