<script type="text/javascript">
	$(document).ready(function(){
		var okSubmit = true;
		<?php
		for($cr=1; $cr<=$countRoom; $cr++) {
		?>
			$("#hotel_noofchildren_<?php echo $cr ?>").change(function() {
				var renderHTML = '';
				if( $(this).val() == 1 ) {
					$(".contentSelectAge<?php echo $cr ?>").remove();
					<?php
					$onecount = 1;
					for( $one=1; $one<=$onecount; $one++ ) {
					?>
						renderHTML +=
						'<div class="contentSelectAge<?php echo $cr ?>">'+
							'<div style="margin-top:5px">'+
								'<div style="float:left; margin-top:5px; margin-right:10px">'+
									'<span>Child <?php echo $one; ?>:</span>'+
								'</div>'+
								'<div style="float:left">'+
									'<select name="childAges_<?php echo $cr ?>[]">'+
										'<option value="2">2 years old</option>'+'<option value="3">3 years old</option>'+
										'<option value="4">4 years old</option>'+'<option value="5">5 years old</option>'+
										'<option value="6">6 years old</option>'+'<option value="7">7 years old</option>'+
										'<option value="8">8 years old</option>'+'<option value="9">9 years old</option>'+
										'<option value="10">10 years old</option>'+'<option value="11">11 years old</option>'+
									'</select>'+
								'</div>'+
								'<div style="clear:both"></div>'+
							'</div>'+
						'</div>';
					<?php
					}
					?>
					$("#noofchildSelect<?php echo $cr ?>").after(renderHTML);
				}
				else if( $(this).val() == 2 ) {
					$(".contentSelectAge<?php echo $cr ?>").remove();
					<?php
					$twocount = 2;
					for( $two=1; $two<=$twocount; $two++ ) {
					?>
						renderHTML +=
						'<div class="contentSelectAge<?php echo $cr ?>">'+
							'<div style="margin-top:5px">'+
								'<div style="float:left; margin-top:5px; margin-right:10px">'+
									'<span>Child <?php echo $two; ?>:</span>'+
								'</div>'+
								'<div style="float:left">'+
									'<select name="childAges_<?php echo $cr ?>[]">'+
										'<option value="2">2 years old</option>'+'<option value="3">3 years old</option>'+
										'<option value="4">4 years old</option>'+'<option value="5">5 years old</option>'+
										'<option value="6">6 years old</option>'+'<option value="7">7 years old</option>'+
										'<option value="8">8 years old</option>'+'<option value="9">9 years old</option>'+
										'<option value="10">10 years old</option>'+'<option value="11">11 years old</option>'+
									'</select>'+
								'</div>'+
								'<div style="clear:both"></div>'+
							'</div>'+
						'</div>';
					<?php
					}
					?>
					$("#noofchildSelect<?php echo $cr ?>").after(renderHTML);
				}
				else if( $(this).val() == 3 ) {
					$(".contentSelectAge<?php echo $cr ?>").remove();
					<?php
					$threecount = 3;
					for( $three=1; $three<=$threecount; $three++ ) {
					?>
						renderHTML +=
						'<div class="contentSelectAge<?php echo $cr ?>">'+
							'<div style="margin-top:5px">'+
								'<div style="float:left; margin-top:5px; margin-right:10px">'+
									'<span>Child <?php echo $three; ?>:</span>'+
								'</div>'+
								'<div style="float:left">'+
									'<select name="childAges_<?php echo $cr ?>[]">'+
										'<option value="2">2 years old</option>'+'<option value="3">3 years old</option>'+
										'<option value="4">4 years old</option>'+'<option value="5">5 years old</option>'+
										'<option value="6">6 years old</option>'+'<option value="7">7 years old</option>'+
										'<option value="8">8 years old</option>'+'<option value="9">9 years old</option>'+
										'<option value="10">10 years old</option>'+'<option value="11">11 years old</option>'+
									'</select>'+
								'</div>'+
								'<div style="clear:both"></div>'+
							'</div>'+
						'</div>';
					<?php
					}
					?>
					$("#noofchildSelect<?php echo $cr ?>").after(renderHTML);
				}
				else if( $(this).val() == 4 ) {
					$(".contentSelectAge<?php echo $cr ?>").remove();
					<?php
					$fourcount = 4;
					for( $four=1; $four<=$fourcount; $four++ ) {
					?>
						renderHTML +=
						'<div class="contentSelectAge<?php echo $cr ?>">'+
							'<div style="margin-top:5px">'+
								'<div style="float:left; margin-top:5px; margin-right:10px">'+
									'<span>Child <?php echo $four; ?>:</span>'+
								'</div>'+
								'<div style="float:left">'+
									'<select name="childAges_<?php echo $cr ?>[]">'+
										'<option value="2">2 years old</option>'+'<option value="3">3 years old</option>'+
										'<option value="4">4 years old</option>'+'<option value="5">5 years old</option>'+
										'<option value="6">6 years old</option>'+'<option value="7">7 years old</option>'+
										'<option value="8">8 years old</option>'+'<option value="9">9 years old</option>'+
										'<option value="10">10 years old</option>'+'<option value="11">11 years old</option>'+
									'</select>'+
								'</div>'+
								'<div style="clear:both"></div>'+
							'</div>'+
						'</div>';
					<?php
					}
					?>
					$("#noofchildSelect<?php echo $cr ?>").after(renderHTML);
				}
				else if( $(this).val() == 5 ) {
					$(".contentSelectAge<?php echo $cr ?>").remove();
					<?php
					$fivecount = 5;
					for( $five=1; $five<=$fivecount; $five++ ) {
					?>
						renderHTML +=
						'<div class="contentSelectAge<?php echo $cr ?>">'+
							'<div style="margin-top:5px">'+
								'<div style="float:left; margin-top:5px; margin-right:10px">'+
									'<span>Child <?php echo $five; ?>:</span>'+
								'</div>'+
								'<div style="float:left">'+
									'<select name="childAges_<?php echo $cr ?>[]">'+
										'<option value="2">2 years old</option>'+'<option value="3">3 years old</option>'+
										'<option value="4">4 years old</option>'+'<option value="5">5 years old</option>'+
										'<option value="6">6 years old</option>'+'<option value="7">7 years old</option>'+
										'<option value="8">8 years old</option>'+'<option value="9">9 years old</option>'+
										'<option value="10">10 years old</option>'+'<option value="11">11 years old</option>'+
									'</select>'+
								'</div>'+
								'<div style="clear:both"></div>'+
							'</div>'+
						'</div>';
					<?php
					}
					?>
					$("#noofchildSelect<?php echo $cr ?>").after(renderHTML);
				}
				else if( $(this).val() == 6 ) {
					$(".contentSelectAge<?php echo $cr ?>").remove();
					<?php
					$sixcount = 5;
					for( $six=1; $six<=$sixcount; $six++ ) {
					?>
						renderHTML +=
						'<div class="contentSelectAge<?php echo $cr ?>">'+
							'<div style="margin-top:5px">'+
								'<div style="float:left; margin-top:5px; margin-right:10px">'+
									'<span>Child <?php echo $six; ?>:</span>'+
								'</div>'+
								'<div style="float:left">'+
									'<select name="childAges_<?php echo $cr ?>[]">'+
										'<option value="2">2 years old</option>'+'<option value="3">3 years old</option>'+
										'<option value="4">4 years old</option>'+'<option value="5">5 years old</option>'+
										'<option value="6">6 years old</option>'+'<option value="7">7 years old</option>'+
										'<option value="8">8 years old</option>'+'<option value="9">9 years old</option>'+
										'<option value="10">10 years old</option>'+'<option value="11">11 years old</option>'+
									'</select>'+
								'</div>'+
								'<div style="clear:both"></div>'+
							'</div>'+
						'</div>';
					<?php
					}
					?>
					$("#noofchildSelect<?php echo $cr ?>").after(renderHTML);
				}
				else if( $(this).val() == 0 ) {
					$(".contentSelectAge<?php echo $cr ?>").remove();
				}
			});
		<?php
		}
		?>

		$("input#register").on('click', function(e){
			e.preventDefault();
			var okSubmit = true;
			if( $("input#hotel_destination").val() == "" ) {
				alert("Please choose your hotel destination.");
				return false;
			}
			else {
				if(okSubmit === false) {
					alert('Please check your input first');
					return false;
				} else {
					var total_pax = 0;
					$('.f-item-room').each(function() {
						var idx = $(this).data('item');
						var adult_no = parseInt($('#hotel_noofadult_' +idx).val()),
							child_no = parseInt($('#hotel_noofchildren_'+idx).val()),
							infant_no = parseInt($('#hotel_noofinfant_'+idx).val());

						total_pax += adult_no + child_no + infant_no;
					});

					if (total_pax > 9 || total_pax > "9") {
						okSubmit = false;
						alert('Maximum Pax allowed is 9pax total for 1 check-in session');
						return false;
					} else {
						okSubmit = true;
						$("#divLoading").show();
					}

					if(okSubmit) {
						$('form#search-hotel-form').submit();
             			return true;
             		} else {
             			return false;
             		}
             		return false;
             	}
            }
        });
	});
</script>
<h1>Search - Hotel Guests</h1>
<?php
for($cr=1; $cr<=$countRoom; $cr++) {
?>
	<div class="f-item f-item-room" data-item="<?php echo $cr;?>">
		<div style="float:left; width:20%; color:black; font-size:14px">
			<div><b>Room <?php echo $cr ?></b></div>
		</div>
		<div style="float:left; width:20%; color:black; font-size:14px; margin-right: 5%">
			<div style="margin-bottom:3px"><b>No. of adult</b></div>
			<div>
				<select name="hotel_noofadult_<?php echo $cr ?>" id="hotel_noofadult_<?php echo $cr ?>">
					<?php
					for($a=0; $a<9; $a++) {
						if( $a == 2 ) {
					?>
						<option value="<?php echo $a; ?>" selected><?php echo $a; ?></option>
					<?php
						}
						else {
					?>
						<option value="<?php echo $a; ?>"><?php echo $a; ?></option>
					<?php
						}
					}
					?>
				</select>
			</div>
		</div>
		<div style="float:left; width:20%; color:black; font-size:14px; margin-right: 5%">
			<div style="margin-bottom:3px"><b>No. of child</b></div>
			<div>
				<div id="noofchildSelect<?php echo $cr ?>">
					<select name="hotel_noofchildren_<?php echo $cr ?>" id="hotel_noofchildren_<?php echo $cr ?>">
						<?php
						for($c=0; $c<7; $c++) {
						?>
						<option value="<?php echo $c; ?>"><?php echo $c; ?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div style="float:left; width:20%; color:black; font-size:14px; margin-right: 5%">
			<div style="margin-bottom:3px"><b>No. of infant</b></div>
			<div>
				<select name="hotel_noofinfant_<?php echo $cr ?>" id="hotel_noofinfant_<?php echo $cr ?>">
					<?php
					for($c=0; $c<9; $c++) {
					?>
					<option value="<?php echo $c; ?>"><?php echo $c; ?></option>
					<?php
					}
					?>
				</select>
			</div>
		</div>
		<div style="clear:both"></div>
	</div>
	<hr />
<?php
}
?>
<div class="f-item" style="margin-top:20px">
	<div style="color:black; width:200px; text-align:center; font-size:14px; margin-left:40%; margin-right:40%; margin-top:7px">
		<input type="button" id="register" name="register" value="Proceed to search result" class="gradient-button" />
	</div>
	<div style="clear:both"></div>
</div>
<!--LOADING GIF-->
<div id="divLoading" style="margin:0px; padding:0px; position:fixed; right:0px; top:0px; width:100%; height:100%; background-color: rgb(102, 102, 102); z-index:30001; opacity:0.8;">
	<p style="position:absolute; color:white; top:50%; left:45%; padding:0px">
		Searching for hotel...Please wait...
		<br />
		<img src="<?php echo base_url(); ?>assets/progress_bar/ajax-loader.gif" style="margin-top:5px">
	</p>
</div>
<!--END OF LOADING GIF-->