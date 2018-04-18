<!--CRUISE-->
<?php
$countCruiseBuy = $this->Others->countCruiseHistoryOrder($confirmBookingID);
$cruisesConfirms = $this->All->select_template(
	"cruise_confirmedBookOrder_ID", $confirmBookingID, "cruise_historyOrder"
);
if( $cruisesConfirms == TRUE ) {
?>
	<h1>Cruise Confirmed Order</h1>
	<div style="float:right; margin-top:-45px">
		<span style="font-size:16px; font-weight:bold">
			Booking ID: <span style="color:green">#<?php echo $bookingOrderID; ?></span>
		</span>
	</div>
	<div style="clear:both"></div>
	<?php echo form_open_multipart('', array('class' => 'form-horizontal')); ?>
	<ul class="room-types">
		<?php
		$total_cruise_grand = 0;
		$itemRefCruise = 1;
		$success_cruises = $this->All->select_template(
			"cruise_confirmedBookOrder_ID", $confirmBookingID, "cruise_historyOrder"
		);
		if( $success_cruises == TRUE ) {
			foreach( $success_cruises AS $success_cruise ) {
				//get cruise title details
				$cruiseTitles = $this->All->select_template("ID", $success_cruise->cruiseTitleID, "cruise_title");
				foreach( $cruiseTitles AS $cruiseTitle ) {
					$cruiseTitlePrint = $cruiseTitle->CRUISE_TITLE;
					$cruiseDeparturePortPrint = $cruiseTitle->DEPARTURE_PORT;
				}
				//end of get cruise title details
		?>
		<!--NEW DESIGN-->
		<li>
			<div class="meta" style="width:65%">
				<div class="tab">
					<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr class="days">
							<th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
								<div style="font-size:12px">
									<img src="<?php echo $this->All->getCruiseImage($success_cruise->cruiseTitleID); ?>" alt="" width="150" height="115" />
								</div>
							</th>
						</tr>
						<tr>
							<td colspan="4" style="text-align:left; padding-bottom:0px">
								<div style="font-size:15px">
									<h5>Cruise title</h5>
									<?php echo $cruiseTitlePrint; ?>
									(<?php echo $this->All->getCruiseTitleTourCode($success_cruise->cruiseTitleID); ?>)
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
								<div style="font-size:15px">
									<h5>Departure date</h5>
									<?php echo date("l, d F Y", strtotime($success_cruise->cruiseDate)); ?>
								</div>
							</td>
							<td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
								<div style="font-size:15px">
									<h5>Cruise length</h5>
									<?php echo $success_cruise->durationNight; ?> NIGHT(S)
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<div style="font-size:15px">
									<h5>Pax statement</h5>
									<?php echo $success_cruise->noofAdult; ?> ADULT(S) & <?php echo $success_cruise->noofChild; ?> CHILD(S)
								</div>
							</td>		
							<td colspan="2">
								<div style="font-size:15px">
									<h5>Stateroom type</h5>
									<?php echo $this->All->getStateroomDetails($success_cruise->stateroomID); ?>
								</div>
							</td>
						</tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td style="width:60%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
										<b>Item details</b>
									</td>
									<td style="width:9%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:center">
										<b>Qty</b>
									</td>
									<td style="width:20%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:right">
										<b>Price ($)</b>
									</td>
								</tr>
								<!--ADULT-->
								<?php
								if( $success_cruise->noofAdult != 0 ) {
								?>
								<tr>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										<?php echo $success_cruise->noofAdult; ?> Adult(s)
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
										1
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										<?php
										$adultCartPrice = number_format($this->All->getIndividualPriceBasedAdult($success_cruise->stateroomID, $success_cruise->shipID, $success_cruise->brandID, $success_cruise->durationNight, $success_cruise->cruisePriceType, $success_cruise->noofAdult, $success_cruise->noofChild), 2);
										$adultCartPriceRaw = $this->All->getIndividualPriceBasedAdult($success_cruise->stateroomID, $success_cruise->shipID, $success_cruise->brandID, $success_cruise->durationNight, $success_cruise->cruisePriceType, $success_cruise->noofAdult, $success_cruise->noofChild);
										if( $adultCartPrice == "0.00" ) {
											echo "FREE";
										}
										else {
											echo $adultCartPrice;	
										}
										?>
									</td>
								</tr>
								<?php
								}
								?>
								<!--END OF ADULT-->
								<!--CHILD-->
								<?php
								if( $success_cruise->noofChild != 0 ) {
								?>
								<tr>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										<?php echo $success_cruise->noofChild; ?> Child(s)
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
										1
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										<?php
										$childCartPrice = number_format($this->All->getIndividualPriceBasedChild($success_cruise->stateroomID, $success_cruise->shipID, $success_cruise->brandID, $success_cruise->durationNight, $success_cruise->cruisePriceType, $success_cruise->noofAdult, $success_cruise->noofChild), 2);
										$childCartPriceRaw = $this->All->getIndividualPriceBasedChild($success_cruise->stateroomID, $success_cruise->shipID, $success_cruise->brandID, $success_cruise->durationNight, $success_cruise->cruisePriceType, $success_cruise->noofAdult, $success_cruise->noofChild);
										if( $childCartPrice == "0.00" ) {
											echo "FREE";
										}
										else {
											echo $childCartPrice;	
										}
										?>
									</td>
								</tr>
								<?php
								}
								else {
									$childCartPrice = 0;
									$childCartPriceRaw = 0;
								}
								?>
								<!--END OF CHILD-->
								<!--EXTRA CHARGES-->
								<?php
								$cruiseExtra = 0;
								if( $success_cruise->extraIDs != "" && $success_cruise->extraIDs != "-" ) {
									$qtyCharge = $success_cruise->noofAdult+$success_cruise->noofChild;
									$extraT = $this->All->getSumExtraPrices($success_cruise->extraIDs)*$qtyCharge;
									$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
									$extraCharges_res = mysqli_query(
										$connection, "SELECT * FROM cruise_extra_price WHERE id IN(".$success_cruise->extraIDs.")"
									);
									if( mysqli_num_rows($extraCharges_res) > 0 ) {
										while( $extraCharges_row = mysqli_fetch_array($extraCharges_res, MYSQL_ASSOC) ) {
											$cruiseExtra += $extraCharges_row["extra_price_value"]*$qtyCharge;
								?>
								<tr>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										<?php echo $extraCharges_row["extra_price_name"]; ?>
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
										<?php echo $qtyCharge; ?>
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										<?php echo number_format($extraCharges_row["extra_price_value"]*$qtyCharge, 2); ?>
									</td>
								</tr>
								<?php
										}
									}
								}
								else {
									$qtyCharge = 0;
									$extraT = 0;
								}
								?>
								<!--END OF EXTRA CHARGES-->
								<!--TOTAL CHARGE-->
								<tr>
									<td class='time' colspan="2" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										<b>Total price</b>
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										<b>
											<?php
											$total_cruise_grand += $adultCartPriceRaw+$childCartPriceRaw+$extraT;
											echo number_format($adultCartPriceRaw+$childCartPriceRaw+$extraT, 2);
											?>
										</b>
									</td>
								</tr>
								<!--END OF TOTAL CHARGE-->
							</table>
						</tr>
					</table>
				</div>
			</div>
			<div class="room-information" style="width:28%; height:auto">
				<div class="tab">
					<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<td colspan="5" style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
								<div style="font-size:12px">
									<!--LIST-->
									<div>
										<b style="font-size:15px">PAX DETAILS</b>
									</div>
									<div>
										<div style="font-size:15px">
											<ul>
												<?php
												$cruisePaxNames = $this->All->select_template_w_2_conditions(
													"bookingID", $bookingOrderID, 
													"itemRecordRef", $itemRefCruise, 
													"cruise_paxName"
												);
												if( $cruisePaxNames == TRUE ) {
													foreach( $cruisePaxNames AS $cruisePaxName ) {
														$roomCruisePaxName = $cruisePaxName->pax_fullname;
											        	$roomCruisePaxType = $cruisePaxName->pax_type;
											    ?>
											    	<ol style="color:green; font-size:14px">
												    	<b>- (<?php echo $roomCruisePaxType; ?>) - <?php echo $roomCruisePaxName; ?></b>
												    </ol>
											    <?php
													}
												}
												?>
											</ul>
										</div>
									</div>
									<br />
									<!--END OF LIST-->
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="3" style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
								<div style="font-size:15px">
									<div>
										<b>TOTAL PRICE:</b>
									</div>
								</div>
							</td>
							<td colspan="2" style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
								<div style="font-size:15px">
									<div>
										<b>
											$<?php echo number_format($total_cruise_grand, 2); ?>
										</b>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
							<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
							<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
							<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
							<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
						</tr>
					</table>
				</div>
			</div>
		</li>
		<br /><br />
		<!--END OF NEW DESIGN-->
		<?php
				$itemRefCruise++;
			}
		}
		?>
	</ul>
	<?php echo form_close(); ?>
<?php
}
?>
<!--END OF CRUISE-->