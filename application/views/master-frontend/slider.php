<!--SLIDER-->
<section class="slider clearfix">
	<div id="sequence">
		<ul class="sequence-canvas">
			<?php
			$banners = $this->All->select_template_with_order("orderNo", "ASC", "main_banner");
			if( $banners == TRUE ) {
				foreach( $banners AS $banner ) {
			?>
				<li>
					<div class="info animate-in"></div>
					<img class="main-image animate-in" src="<?php echo base_url();?>assets/main-banner/<?php echo $banner->banner_filename; ?>" />
				</li>
			<?php
				}
			}
			else {
			?>
				<li>
					<div class="info animate-in"></div>
					<img class="main-image animate-in" src="<?php echo base_url();?>assets/images/slider/imgNEWA.jpg" />
				</li>
			<?php
			}
			?>
		</ul>
	</div>
</section>
<!--END OF SLIDER-->