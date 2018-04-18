<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTCFITApp - Content Media Management</title>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/uploaders/dropzone.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/uploader_dropzone.js"></script>
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
					<span class="text-semibold">Content Media Management</span>
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/content">Content Media Management</a></li>
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
						<h5 class="panel-title">Upload your media asset(s)</h5>
						<br />
<?php echo $this->session->flashdata('success_upload_media'); ?>
<!--UPLOAD FORM-->
<div>
	<fieldset class="content-group">
		<div class="form-group">
			<label class="control-label col-lg-12">
				<span style="color:green">
					<b>
						* Note: Media assets library extensions accepted: mp4, mp3, jpg, gif, png, pdf, doc, xlsx, xls, ppt. 
						Maximum size for each file is 10MB.
					</b>
				</span>
			</label>
		</div>
		<div class="form-group">
			<div class="col-lg-12">
<?php echo form_open_multipart('backend/content/upload_media_progress', array('class' => 'dropzone', 'id' => 'dropzone_multiple')); ?>
	<input type="hidden" name="hidden_content_id" value="<?php echo $this->uri->segment(4); ?>" />
<?php echo form_close(); ?>
			</div>
		</div>
	</fieldset>
</div>
<!--END OF UPLOAD FORM-->	
					</div>
					<div class="panel-heading" style="text-align:center">
						<h5 class="panel-title">Media List</h5>
					</div>
<?php echo $this->session->flashdata('success_delete_media'); ?>
<table class="table datatable-basic">
	<thead>
		<tr>
			<th>File image</th>
			<th>Filename</th>
			<th>Filesize</th>
			<th>Filetype</th>
			<th>Created</th>
			<th class="text-center" style="width:50px">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$medias = $this->All->select_template_with_order("file_name", "ASC", "content_media");
		if( $medias == TRUE ) {
			foreach( $medias AS $media ) {
		?>
		<tr>
			<td>
				<a target="_blank" href="<?php echo base_url(); ?>assets/media_library/<?php echo $media->file_name ?>">
					<img src="<?php echo base_url(); ?>assets/media_library/<?php echo $media->file_name ?>" width="75px" height="75px" />
				</a>
			</td>
			<td>
				<a target="_blank" href="<?php echo base_url(); ?>assets/media_library/<?php echo $media->file_name ?>">
					<?php echo $media->file_name; ?>
				</a>
			</td>
			<td><?php echo $media->file_size; ?></td>
			<td><?php echo $media->file_type; ?></td>
			<td><?php echo date("Y-F-d H:i:s", strtotime($media->created)); ?></td>
			<td class="text-center">
				<a href="<?php echo base_url(); ?>backend/content/do_delete_media/<?php echo $media->id; ?>/<?php echo $this->uri->segment(4); ?>" onclick="return confirm('Are you sure you want to delete this media?');" class="btn btn-primary btn-labeled">
					<b><i class="icon-trash"></i></b> Delete
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
		<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->
	</div>
</body>
</html>