<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>UPDATE CRUISE BRAND</title>
</head>

<body>

	<form>
    <?php 
	
		$cruise_id = $this->uri->segment(4); 
		$brand_query = $this->cruise->get_cruise_brands($cruise_id);
		foreach($brand_query->result() as $brand){
			?>
            
            
            <input name="cruise_brand" type="text" value="<?php echo $brand->NAME;?>">
            
            <textarea name="cruise_brand_desc"><?php echo $brand->DESC;?></textarea>
            <?php
		}//end foreach
	?>
    </form>

</body>
</html>

<!-- Edit brand modal -->
<div id="editBrand1" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Edit brand details</h5>
			</div>
			<?php echo form_open_multipart('#', array('class' => 'form-horizontal')); ?>
				<div class="modal-body">	
					<fieldset class="content-group" style="margin-bottom:0px !important">
						<div class="form-group">
							<div class="col-lg-12">
								<input type="text" name="brand_name" class="form-control" placeholder="Enter brand name" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<textarea name="brand_desc" class="form-control" style="resize:none; height:100px" placeholder="Enter brand description"></textarea>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!-- End of edit brand modal-->
