<?php
if( $this->session->userdata('shoppingCartCruiseCookie') == TRUE || $cruiseCheck == "YES" ||
	$this->session->userdata('shoppingCartLandtourCookie') == TRUE || $landtourCheck == "YES" ||
	$this->session->userdata('shoppingCartCookie') == TRUE || $hotelCheck == "YES" ||
	$this->session->userdata('shoppingCartFlightCookie') == TRUE || $flightCheck == "YES" ) {
?>
	<!----------------------CONTACT PERSON FORM---------------------->
	<br /><br />
	<h3>Contact Person Information</h3>
	<div class="age_type" style="font-size:14px">Please enter your passenger details and ensure the details matches your passport.</div>
	<div class="tab_container" id="tabs-0" style="font-size:14px">
		<div class="form_div particular-form" id="particular-1">

	        <div>
		        <div>
			        <div>
				        <div>
							<div style="margin-top:10px; margin-bottom:5px">Title</div>
							<div>
								<select name="titleCP" id="titleCP" required style="width:325px; height:37px">
					                <option value="">- Select a value -</option>
					                <option value="Mr">Mr</option>
					                <option value="Ms">Ms</option>
					            </select>
							</div>
		        		</div>
			        </div>
			    </div>
			</div>
			<div>
		        <div style="float:left; width:33%">
		        	<div>
						<div style="margin-top:10px; margin-bottom:5px">Name</div>
						<input type="text" name="nameCP" id="nameCP" class="upper" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:300px" placeholder="GARY" onkeypress="return onlyAlphabetsspace(event,this);" >
	        		</div>
		        </div>
		        <div style="float:left; width:33%">
			        <div>
						<div style="margin-top:10px; margin-bottom:5px">Contact</div>
						<input type="text" name="contactCP" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:300px" minlength="7" maxlength="25" onkeypress="return onlyNumber(event, this);">
	        		</div>
		        </div>
		        <div style="float:left; width:33%">
			        <div>
						<div style="margin-top:10px; margin-bottom:5px">Email</div>
						<input type="email" name="emailCP" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:300px">
	        		</div>
		        </div>
		        <div style="clear:both"></div>
	        </div>

	        <!-- <div> -->
				<!-- <div style="float:left; width:33%">
			        <div>
						<div style="margin-top:10px; margin-bottom:5px">Address</div>
						<input type="text" name="addressCP" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:280px">
	        		</div>
		        </div> --><!--
		        <div style="clear:both"></div>
	        </div> -->
	        <div>
				<div style="margin-top:10px; margin-bottom:5px">Remarks:</div>
				<textarea name="remarksCP" id="remarksCP" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;"></textarea>
	        </div>
		</div>
	</div>
	<!----------------------END OF CONTACT PERSON FORM---------------------->

	<!-- emergency contact person -->
	<br /><br />
	<h3>Emergency Contact Person Information</h3>
	<div class="tab_container" id="tabs-0" style="font-size:14px">
		<div class="form_div particular-form" id="particular-1">
			<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; magrin-bottom: 10px;">
				<div style="margin-top:10px; margin-bottom:5px; float:left">Relationship</div>
				<div style="float:left; margin-left:10px"><input type="text" name="emergency_relationship" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:300px">
		        </div>
		        <div style="clear:both"></div>
	        </div>
	        <div>
		        <div>
					<div style="margin-top:10px; margin-bottom:5px">Title</div>
					<div>
						<select name="e_titleCP" required style="width:325px; height:37px">
			                <option value="">- Select a value -</option>
			                <option value="Mr">Mr</option>
			                <option value="Ms">Ms</option>
			            </select>
					</div>
        		</div>
			</div>
			<div>
		        <div style="float:left; width:33%">
		        	<div>
						<div style="margin-top:10px; margin-bottom:5px">Name</div>
						<input type="text" name="e_nameCP" class="upper" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:300px" placeholder="GARY" onkeypress="return onlyAlphabetsspace(event,this);" >
	        		</div>
		        </div>
		        <div style="float:left; width:33%">
			        <div>
						<div style="margin-top:10px; margin-bottom:5px">Contact</div>
						<input type="text" name="e_contactCP" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:300px" onkeypress="return onlyNumber(event, this);">
	        		</div>
		        </div>
		        <div style="float:left; width:33%">
			        <div>
						<div style="margin-top:10px; margin-bottom:5px">Email</div>
						<input type="email" name="e_emailCP" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:300px">
	        		</div>
		        </div>
		        <div style="clear:both"></div>
	        </div>
		</div>
	</div>
	<!----------------------END OF E. CONTACT PERSON FORM---------------------->
<?php
}
?>