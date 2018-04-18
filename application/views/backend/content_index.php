<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Content Management</title>
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
						<h5 class="panel-title">Add new content</h5>
						<br />
<?php echo $this->session->flashdata('success_added_new_content'); ?>
<?php echo form_open_multipart('backend/content/add_new_content_webpages', array('class' => 'form-horizontal')); ?>
	<div>
		<fieldset class="content-group">
			<div class="form-group">
				<label class="control-label col-lg-3">
					* Page title
				</label>
				<div class="col-lg-9">
					<input type="text" name="page_title" required class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3">
					Content
				</label>
				<div class="col-lg-9">
					<textarea name="page_content" id="editor-full" rows="4" cols="4"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3">
					* Content status
				</label>
				<div class="col-lg-9">
					<select name="choose_status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
				</div>
			</div>
		</fieldset>
	</div>		
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Add new content</button>
	</div>
<?php echo form_close(); ?>
					</div>
					<div class="panel-heading" style="text-align:center">
						<h5 class="panel-title">Content List Summary</h5>
					</div>
<?php echo $this->session->flashdata('success_delete_content'); ?>
<table class="table datatable-basic">
	<thead>
		<tr>
			<th>Page title</th>
			<th>URL</th>
			<th>Status</th>
			<th>Created</th>
			<th class="text-center" style="width:350px">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$contents = $this->All->select_template_with_order("content_title", "ASC", "content_management");
		if( $contents == TRUE ) {
			foreach( $contents AS $content ) {
		?>
		<tr>
			<td><?php echo $content->content_title; ?></td>
			<td>/<?php echo $content->content_slug_url; ?></td>
			<td>
				<?php
				if( $content->content_status == 1 ) {
				?>
				<span class="label label-success">ACTIVE</span>
				<?php	
				}
				else {
				?>
				<span class="label label-danger">INACTIVE</span>
				<?php
				}
				?>
			</td>
			<td><?php echo date("Y-F-d H:i:s", strtotime($content->created)); ?></td>
			<td class="text-center">
				<a href="<?php echo base_url(); ?>backend/content/media/<?php echo $content->id; ?>" class="btn btn-primary btn-labeled">
					<b><i class="icon-media"></i></b> Media
				</a>
				<a href="<?php echo base_url(); ?>backend/content/edit_mode/<?php echo $content->id; ?>" class="btn btn-primary btn-labeled">
					<b><i class="icon-pencil3"></i></b> Edit
				</a>
				<a href="<?php echo base_url(); ?>backend/content/delete_mode/<?php echo $content->id; ?>" class="btn btn-primary btn-labeled" onclick="return confirm('Are you sure you want to delete this content?');">
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