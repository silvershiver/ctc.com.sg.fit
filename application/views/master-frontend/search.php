<style>
#flightClass {
    -webkit-box-shadow: 0 1px 1px rgba(204, 204, 204, 1) inset, 0 1px 0 rgba(255,255,255,1);
    -moz-box-shadow: 0 1px 1px rgba(204, 204, 204, 1) inset, 0 1px 0 rgba(255,255,255,1);
    box-shadow: 0 1px 1px rgba(204, 204, 204, 1) inset, 0 1px 0 rgba(255,255,255,1);
    padding: 5px;
    border-radius: 10px;
}
.ui-icon-arrow-x {
	position: absolute;
    width: 13px;
    height: 10px;
    overflow: hidden;
    display: inline-block;
    cursor: pointer;
    color:#ffffff;
    background: url('<?php echo base_url();?>assets/images/ico/spinner.png') 0 0 no-repeat;
}
.spoil_c4 {
	padding: 10px;
}
.ui-icon-triangle-1 {
	position: absolute;
    top: 5px;
    right: 8px;
    background: url('<?php echo base_url();?>assets/images/ico/spinner.png') 0 0 no-repeat;
    width: 13px;
    height: 8px;
    overflow: hidden;
    text-indent: -99999px;
    display: inline-block;
    cursor: pointer;
}

.ui-icon-triangle-2 {
	   position: absolute;
    top: 2px;
    right: 8px;
    background: url('<?php echo base_url();?>assets/images/ico/spinner.png') 0 -9px no-repeat;
    width: 13px;
    height: 8px;
    overflow: hidden;
    text-indent: -99999px;
    display: inline-block;
    cursor: pointer;
}
.quantity {
  position: relative;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button
{
  -webkit-appearance: none;
  margin: 0;
  opacity: 0;
}

input[type=number]
{
	padding-left: 10px;
  	-moz-appearance: textfield;
}

.quantity input:focus {
  outline: 0;
}

.quantity-nav {
  	height: 29px;
	position: absolute;
	top: 0;
	right: -5px;
}

.quantity-button {
  position: relative;
  cursor: pointer;
  width: 25px;
  text-align: center;
  color: #333;
  font-size: 13px;
  font-family: "Trebuchet MS", Helvetica, sans-serif !important;
  line-height: 1;
  -webkit-transform: translateX(-100%);
  transform: translateX(-100%);
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  -o-user-select: none;
  user-select: none;
}

.quantity-button.quantity-up {
  position: absolute;
  height: 50%;
  top: 0;
}

.quantity-button.quantity-down {
  position: absolute;
  bottom: -1px;
  height: 50%;
}
</style>
<!--search-->
<div class="main-search">
	<?php
	if( $this->session->flashdata('error_date') == TRUE ) {
	?>
		<div style="color:#a94442; background-color:#f2dede; border-color:#ebccd1; padding:10px; font-size:15px; text-align:center">
			<?php echo $this->session->flashdata('error_date'); ?>
		</div>
	<?php
	}
	?>
	<?php
	if( $this->session->flashdata('error_pax') == TRUE ) {
	?>
		<div style="color:#a94442; background-color:#f2dede; border-color:#ebccd1; padding:10px; font-size:15px; text-align:center">
			<?php echo $this->session->flashdata('error_pax'); ?>
		</div>
	<?php
	}
	?>
	<div class="search_container">

		<!--CATEGORY BOOKING SEARCH-->
		<div class="column radios">
			<h4><span>01</span> What?</h4>
			<div class="f-item">
				<input type="radio" name="radio" id="fourthClick" value="#fourth" checked />
				<label for="cruise">Cruise</label>
			</div>
			<div class="f-item">
				<input type="radio" name="radio" id="secondClick" value="#second" />
				<label for="land_tours">Land Tour</label>
			</div>
			<!--
			<div class="f-item" >
				<input type="radio" name="radio" id="firstClick"  value="#first" />
				<label for="hotel">Hotel</label>
			</div>
			-->
			<div class="f-item">
				<input type="radio" name="radio" id="thirdClick"  value="#third" />
				<label for="flight">Flight</label>
			</div>
		</div>
		<!--END OF CATEGORY BOOKING SEARCH-->

		<div class="forms">

			<!--HOTEL-->
			<div id="first" class="showHide" style="display:none">
				<?php echo form_open_multipart('search/hotel_result',
					array('class' => 'form-horizontal', 'id' => 'search-hotel-form')); ?>
					<div class="column">
						<h4><span>02</span> Where?</h4>
						<div class="f-item" id="hotel_destination">
							<label for="destination1">Your destination</label>
							<input type="text" class="typeahead address-hotel" placeholder="City, region or district" name="hotel_destination" id="hotel_destination" />
						</div>
					</div>
					<div class="column twins">
						<h4><span>03</span> When?</h4>
						<div class="f-item">
							<label for="datepicker1">Check-in date</label>
							<div style="position: relative">
								<input type="text" id="datepickerHotelCheckIn" name="hotel_checkin" value="<?php echo date("Y-m-d", strtotime("+5 day")); ?>" required readonly />
							</div>
						</div>
						<div class="f-item">
							<label for="datepicker2">Check-out date</label>
							<div style="position: relative">
								<input type="text" id="datepickerHotelCheckOut" name="hotel_checkout" value="<?php echo date("Y-m-d", strtotime("+6 day")); ?>" required readonly />
							</div>
						</div>
					</div>
					<div class="column triplets">
						<h4><span>04</span> Who?</h4>
						<div class="f-item spinner">
							<label for="spinner1">Room(s)</label>
							<select name="hotel_noofroom" id="hotel_noofroom">
								<?php
								for($r=1; $r<10; $r++) {
								?>
								<option value="<?php echo $r; ?>"><?php echo $r; ?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<!--CONFIRMATION BOOKING PURCHASED MODAL POP-UP-->
					<div class="lightbox-booking" style="display:none;">
						<div class="lb-wrap" style="max-width:900px; width:85%; left:18%">
							<a href="#" class="close">x</a>
							<div class="lb-content">
								<div class="box-content-booking">
								</div>
							</div>
						</div>
					</div>
					<!--END OF CONFIRMATION BOOKING PURCHASED MODAL POP-UP-->
					<button type="button" class="search-submit search-popup">Proceed to results</button>
				<?php echo form_close(); ?>
			</div>
			<!--END OF HOTEL-->

			<!--FLIGHT-->
			<div id="third" class="showHide" style="display:none">
				<?php echo form_open_multipart('search/flight_result', array('class' => 'form-horizontal', 'id'=>'form-book')); ?>
					<div class="column">
						<h4><span>02</span> Where?</h4>
						<div class="f-item" id="flight-leaving">
							<label for="destination3">From</label>
							<input type="hidden" name="flight_going_from" value="Singapore (SIN)" />
							<div style="font-size:15px; margin-bottom:14px"><b>Singapore (SIN)</b></div>
						</div>
						<div class="f-item" id="flight-going">
							<label for="destination4">To</label>
							<input type="text" class="typeahead" placeholder="City, region, or district" name="flight_going_to" id="flight_destination" required style="width:230px; height:16px" />
						</div>
					</div>
					<div class="column twins">
						<h4><span>03</span> When?</h4>
						<div class="f-item" style="width:100%">
							<label for="destination4">Flight Type</label>
							<div style="margin-top:3px">
								<div style="float:left">
									<input type="radio" name="radioType" class="choiceFlightType" id="radioFlightType" checked value="one_way" /> &nbsp;
								</div>
								<div style="float:left; margin-right:15px">
									<span style="font-size: 14px"><b>One-way</b></span>
								</div>
								<div style="float:left">
									<input type="radio" name="radioType" class="choiceFlightType" id="radioFlightType" value="return" /> &nbsp;
								</div>
								<div style="float:left">
									<span style="font-size: 14px"><b>Return</b></span>
								</div>
								<div style="clear:both"></div>
							</div>
						</div>
						<div style="height:67px">&nbsp;</div>
						<div class="f-item" id="checkin_flight">
							<label for="datepicker6">Departure</label>
							<div style="position: relative">
								<input type="text" id="datepickerFlightCheckIn" name="datepicker6" value="<?php echo date("Y-m-d", strtotime("+7 day")); ?>" required readonly />
								<!--
								<input type="text" id="datepickerFlightCheckIn" name="datepicker6" value="2017-12-30" required readonly />
								-->
							</div>
						</div>
						<div class="f-item" id="checkout_flight">
							<label for="datepicker7">Return</label>
							<div style="position: relative">
								<input type="text" id="datepickerFlightCheckOut" name="datepicker7" value="<?php echo date("Y-m-d", strtotime("+8 day")); ?>" required readonly />
							</div>
						</div>
					</div>
					<div class="column triplets">
						<h4><span>04</span> Who?</h4>
						<div class="f-item">
							<label for="flightAdult">Adult(s)</label>
							<div class="quantity">
								<input type="number" min="1" max="7" step="1" id="flightAdult" name="flightAdult"  title="Above Age 12" value="1" autocomplete="off" data-val="1">
							</div>
							<!-- <select name="flightAdult" id="flightAdult" title="Above Age 12">
								<?php
								for($a=1; $a<=7; $a++) {
								?>
								<option value="<?php echo $a; ?>"><?php echo $a; ?></option>
								<?php
								}
								?>
							</select>-->
						</div>
						<div class="f-item">
							<label for="flightChild">Child(s)</label>
							<div class="quantity">
								<input type="number" min="0" max="6" step="1" id="flightChild" name="flightChild"  title="Age 2-12" value="0" data-val="0">
							</div>

							<!-- <select name="flightChild" id="flightChild" title="Age 2-12">
								<?php
								for($c=0; $c<=6; $c++) {
								?>
									<option value="<?php echo $c; ?>"><?php echo $c; ?></option>
								<?php
								}
								?>
							</select> -->
						</div>
						<div class="f-item">
							<label for="flightInfant">Infant(s)</label>
							<div class="quantity">
								<input type="number" min="0" max="4" step="1" id="flightInfant" name="flightInfant"  title="below Age 2" value="0" data-val="0">
							</div>
							<!--
							<select name="flightInfant" id="flightInfant" title="below Age 2">
								<?php
								for($i=0; $i<=4; $i++) {
								?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php
								}
								?>
							</select> -->
						</div>

						<div class="f-item hidden-arrow" style="width: 240px; display: none; position: relative">
							<div class="ui-icon ui-icon-arrow-x show-on-adult" style="display: none; left:35px"></div>
							<div class="ui-icon ui-icon-arrow-x show-on-child" style="display: none; left:110px"></div>
							<div class="ui-icon ui-icon-arrow-x show-on-infant" style="display: none; left:200px"></div>
							<div style="background: #FFFFFF; position: absolute; width: 242px; border: 1px solid #ccc; height: 22px; z-index: 5; top:6px" class="spoil_c4">
								aa
							</div>
						</div>
						<div class="f-item" style="width:95%; z-index: 2" id="flightClass">
							<label for="flightClass">Class</label>
							<select name="flightClass" id="flightClass">
								<option value="Y">Economy Class</option>
								<option value="J">Business Class</option>
								<option value="F">First Class</option>
								<option value="W">Premium Economy</option>
							</select>
						</div>
					</div>
					<input type="submit" value="Proceed to results" class="search-submit" id="search_submit_flight" />
				<?php echo form_close(); ?>
			</div>
			<!--END OF FLIGHT-->

			<!--LAND TOURS-->
			<div id="second" class="showHide" style="display:none">
				<?php echo form_open_multipart('search/landtour_result', array('class' => 'form-horizontal')); ?>
					<div class="column">
						<h4><span>02</span> Interest?</h4>
						<div class="f-item">
							<label>Choose Point-of-Interest</label>
							<select name="landtour_point_interest">
								<option value="ALL">I Don't Mind</option>
								<?php
								$arrayCategory 		= $this->Landtour->getLandtourCategory_mainSearch();
								$countArrayCategory = count($arrayCategory);
								if( $countArrayCategory > 0 ) {
									foreach( $arrayCategory AS $keyCategory => $valueCategory ) {
								?>
								<option value="<?php echo $keyCategory; ?>"><?php echo $valueCategory; ?></option>
								<?php
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="column">
						<h4><span>03</span> Where?</h4>
						<div class="f-item" id="landtour_destination">
							<label for="destination2">Your destination</label>
							<select name="landtour_destination">
								<option value="ALL">I Don't Mind</option>
								<?php
								$arrayCategoryLocation 		= $this->Landtour->getLandtourDestinationCountry_mainSearch();
								$countArrayCategoryLocation = count($arrayCategoryLocation);
								if( $countArrayCategoryLocation > 0 ) {
									foreach( $arrayCategoryLocation AS $keyCategoryLocation => $valueCategoryLocation ) {
								?>
								<option value="<?php echo $keyCategoryLocation; ?>">
									<?php echo $valueCategoryLocation; ?>
								</option>
								<?php
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="column twins last">
						<h4><span>04</span> When?</h4>
						<div class="f-item datepicker">
							<label for="datepicker1">From date</label>
							<div class="datepicker-wrap">
								<input type="text" id="datepickerLandtourCheckIn" name="datepicker4" required style="height:18px" value="<?php echo date("Y-m-d", strtotime("+7 days")); ?>" />
							</div>
						</div>
						<div class="f-item datepicker">
							<label for="datepicker2">To date</label>
							<div class="datepicker-wrap">
								<input type="text" id="datepickerLandtourCheckOut" name="datepicker5" required style="height:18px" value="<?php echo date("Y-m-d", strtotime("+8 days")); ?>" />
							</div>
						</div>
					</div>
					<input type="submit" value="Proceed to results" class="search-submit" id="search-submit" />
				<?php echo form_close(); ?>
			</div>
			<!--END OF LAND TOURS-->

			<!--CRUISE-->
			<div id="fourth" class="showHide">
				<?php echo form_open_multipart('search/cruise_result', array('class' => 'form-horizontal')); ?>
					<!--column-->
					<div class="column">
						<h4><span>02</span> How?</h4>
						<div class="f-item">
							<label>Choose cruise type</label>
							<select name="cruiseType_BrandName">
								<option value="ALL">I Don't Mind</option>
								<?php
								$cruiseTypes = $this->All->select_template_with_where_and_order(
									"STATUS", 1, "NAME", "ASC", "cruise_brand"
								);
								if( $cruiseTypes == TRUE ) {
									foreach( $cruiseTypes AS $cruiseType ) {
								?>
								<option value="<?php echo $cruiseType->ID; ?>">
									<?php echo $cruiseType->NAME; ?>
								</option>
								<?php
									}
								}
								?>
							</select>
							<br />
							<label>Choose cruise port</label>
							<select name="cruiseType_port">
								<option value="ALL">I Don't Mind</option>
								<?php
								$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
								$port_res   = mysqli_query(
									$connection,
									"
										SELECT DISTINCT(DEPARTURE_PORT) AS DEPARTURE_PORT
										FROM cruise_title WHERE DEPARTURE_PORT IS NOT NULL ORDER BY DEPARTURE_PORT ASC
									"
								);
								if( mysqli_num_rows($port_res) > 0 ) {
									while( $port_row  = mysqli_fetch_array($port_res, MYSQL_ASSOC) ) {
								?>
								<option value="<?php echo $port_row["DEPARTURE_PORT"]; ?>">
									<?php echo strtoupper($port_row["DEPARTURE_PORT"]); ?>
								</option>
								<?php
									}
								}
								?>
							</select>
							<br />
						</div>
					</div>
					<!--//column-->
					<!--column-->
					<div class="column">
						<h4><span>03</span> When?</h4>
						<div class="f-item">
							<label>Cruise departure date</label>
							<select name="cruiseMonthDate" required style="height:19px">
								<?php
								$arrayDates = array();
								$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
							 	$check_res  = mysqli_query(
									$connection,
									"SELECT * FROM cruise_title WHERE IS_SUSPEND = 0"
								);
								if( mysqli_num_rows($check_res) > 0 ) {
									while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
										if (strpos($check_row["DEPARTURE_DATE"], ',') !== false) {
											$explodes = explode(", ", $check_row["DEPARTURE_DATE"]);
											foreach( $explodes AS $explode ) {
												if( strtotime($explode) >= strtotime(date("Y-m-d")) ) {
													$arrayDates[] = date("Y-m", strtotime($explode));
												}
											}
										}
										else {
											$arrayDates[] = date("Y-m", strtotime($check_row["DEPARTURE_DATE"]));
										}
									}
								}
								sort($arrayDates);
								foreach( array_unique($arrayDates) AS $value ) {
									echo "<option value='".date("Y-F", strtotime($value))."'>".date("Y-F", strtotime($value))."</option>";
								}
								?>
							</select>
							<br />
							<label>Cruise length</label>
							<select name="cruiseLength" style="height:19px">
								<option value="ALL">I Don't Mind</option>
								<option value="1_2">1-2 Nights</option>
								<option value="3_6">3-6 Nights</option>
								<option value="7_9">7-9 Nights</option>
								<option value="10_14">10-14 Nights</option>
								<option value="OVER_14">Over 14 Nights</option>
							</select>
							<br />
						</div>
					</div>
					<!--//column-->
					<!--column-->
					<div class="column twins last">
						<h4><span>04</span> Who?</h4>
						<div class="f-item">
							<label>No. of adult</label>
							<select name="noofAdult" style="height:19px">
								<option value="1">1 pax</option>
								<option value="2">2 pax(s)</option>
								<option value="3">3 pax(s)</option>
								<option value="4">4 pax(s)</option>
							</select>
						</div>
						<div class="f-item">
							<label>No. of children</label>
							<select name="noofChildren" style="height:19px">
								<option value="0">0 pax</option>
								<option value="1">1 pax</option>
								<option value="2">2 pax(s)</option>
								<option value="3">3 pax(s)</option>
								<option value="4">4 pax(s)</option>
							</select>
						</div>
					</div>
					<!--//column-->
					<input type="submit" value="Proceed to results" class="search-submit" id="search-submit" />
				<?php echo form_close(); ?>
			</div>
			<!--END OF CRUISE-->

		</div>
	</div>
	<!--LOADING GIF-->
	<div id="divLoading" style="margin:0px; padding:0px; position:fixed; right:0px; top:0px; width:100%; height:100%; background-color: rgb(102, 102, 102); z-index:999; opacity:0.8;">
		<p style="position:absolute; color:white; top:50%; left:45%; padding:0px">
			Searching for <span class="search_mark">flight</span>...Please wait...
			<br />
			<img src="<?php echo base_url(); ?>assets/progress_bar/ajax-loader.gif?<?php echo uniqid(); ?>" style="margin-top:5px">
		</p>
	</div>
	<!-- search -->
</div>
<!--//search -->
<script>
    window.onload = function() {
      document.getElementById('flightAdult').value = '1';
      document.getElementById('flightChild').value = '0';
      document.getElementById('flightInfant').value = '0';
    }
</script>