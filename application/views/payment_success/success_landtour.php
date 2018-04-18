<!--LANDTOUR SUCCESS-->
<?php
$childWBPrice = "";
$landtourConfirms = $this->All->select_template(
	"landtour_confirmedBookOrder_ID", $confirmBookingID, "landtour_history_order"
);
if( $landtourConfirms == TRUE ) {
?>
	<h1>Landtour Confirmed Order</h1>
	<div style="float:right; margin-top:-45px">
		<span style="font-size:16px; font-weight:bold">
			Booking ID: <span style="color:green">#<?php echo $bookingOrderID; ?></span>
		</span>
	</div>
	<div style="clear:both"></div>
	<?php echo form_open_multipart('', array('class' => 'form-horizontal')); ?>
	<ul class="room-types">
		<?php
		$total_landtour_grand  = 0;
		$totalGrandPrice 	   = 0;
		$totalGrandPriceTicket = 0;
		$totalPaxPrice   	   = 0;
		$itemRef 			   = $countCruiseBuy+1;
		$success_landtours = $this->All->select_template(
			"landtour_confirmedBookOrder_ID", $confirmBookingID, "landtour_history_order"
		);
		if( $success_landtours == TRUE ) {
			foreach( $success_landtours AS $success_landtour ) {
				//get landtour title details
				$landtours = $this->All->select_template("id", $success_landtour->landtour_product_id, "landtour_product");
				foreach( $landtours AS $landtour ) {
					$lt_category_id = $landtour->lt_category_id;
					$lt_tourID 	    = $landtour->lt_tourID;
					$lt_title 	    = $landtour->lt_title;
					$lt_hightlight  = $landtour->lt_hightlight;
					$lt_itinerary   = $landtour->lt_itinerary;
					$start_date     = $landtour->start_date;
					$start_country  = $landtour->start_country;
					$start_city     = $landtour->start_city;
					$end_date 	    = $landtour->end_date;
					$end_country    = $landtour->end_country;
					$end_city 	    = $landtour->end_city;
				}
				//end of get landtour title details
				//landtour system prices
				$others = $this->All->select_template("id", $success_landtour->landtour_system_price_id, "landtour_system_prices");
				if( $others == TRUE ) {
					foreach( $others AS $other ) {
						$adultSingle_price 	= $other->adultSingle_price;
						$adultTwin_price   	= $other->adultTwin_price;
						$adultTriple_price 	= $other->adultTriple_price;
						$child_wb_price    	= $other->child_wb_price;
						$child_wob_price   	= $other->child_wob_price;
						$half_price			= $other->child_half_twin_price;
						$infant_price 		= $other->infant_price;
						$price_date			= $other->price_date;
						$current_price_date = date("d/m/Y", strtotime($other->price_date));
						$roomCombinationQty = $other->roomCombinationQty;
						$ticketAdultPrice 	= $other->ticketAdultPrice;
						$ticketChildPrice 	= $other->ticketChildPrice;
					}
				}
				//end of landtour system prices
		?>
		<!--NEW DESIGN-->
		<li>
			<div class="meta" style="width:65%">
				<div class="tab">
					<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr class="days">
							<th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
								<div style="font-size:12px">
									<img src="<?php echo $this->All->getLandtourImage($success_landtour->landtour_product_id); ?>" alt="" width="150" height="115" />
								</div>
							</th>
						</tr>
						<tr>
							<td colspan="3" style="text-align:left; padding-bottom:0px">
								<div style="font-size:15px">
									<h5>Landtour title</h5>
									<?php echo $lt_title; ?> (<?php echo $lt_tourID; ?>)
								</div>
							</td>
						</tr>
						<tr>
							<td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
								<div style="font-size:15px">
									<h5>Departure date</h5>
									<?php echo date("d/m/Y", strtotime($success_landtour->selected_date)); ?>
								</div>
							</td>
							<td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px"></td>
						</tr>
						<tr>
							<td colspan="3" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
								<?php
								if( $success_landtour->sellingType == "ticket" ) {
									$ticketDetails = explode("~", $success_landtour->paxDetails);
								?>
									<div style="font-size:15px">
										<h5>No. of ticket</h5>
										<?php echo $ticketDetails[0]+$ticketDetails[1]; ?> ticket(s)
									</div>
								<?php
								}
								else {
								?>
									<div style="font-size:15px">
										<h5>No. of room</h5>
										<?php echo $success_landtour->countRoom; ?> room(s)
									</div>
								<?php
								}
								?>
								<br />
							</td>
						</tr>
					</table>
					<?php
					if( $success_landtour->sellingType == "ticket" ) {
					?>
						<table border="0" cellpadding="0" cellspacing="0">
							<tr class='days'>
								<th width="50%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
									<b>Description</b>
								</th>
								<th width="20%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px">
									<b>Quantity</b>
								</th>
								<th colspan="2" width="45%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align: right">
									<b>Unit Price</b>
								</th>
							</tr>
							<tr>
								<td class='time' colspan="4" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
									Ticket Details
								</td>
							</tr>
							<?php $paxDetails = explode("~", $success_landtour->paxDetails); ?>
							<?php
							if( $paxDetails[0] > 0 ) {
							?>
								<tr>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										Adult Ticket
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
										<?php echo $paxDetails[0]; ?>
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
										&nbsp;
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										$<?php echo number_format($ticketAdultPrice*$paxDetails[0], 2); ?>
									</td>
								</tr>
							<?php
							}
							?>
							<?php
							if( $paxDetails[1] > 0 ) {
							?>
								<tr>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										Child Ticket
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
										<?php echo $paxDetails[1]; ?>
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
										&nbsp;
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										$<?php echo number_format($ticketChildPrice*$paxDetails[1], 2); ?>
									</td>
								</tr>
							<?php
							}
							?>
							<tr>
								<td class='time' colspan="3" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
									<b>Price Pax</b>
								</td>
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
									<?php
									$totalPaxPrice 	  	    = ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
									$totalGrandPriceTicket += ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
									?>
									$<?php echo number_format($totalPaxPrice, 2); ?>
								</td>
							</tr>
						</table>
					<?php
					}
					else {
					?>
						<table border="0" cellpadding="0" cellspacing="0">
							<tr class='days'>
								<th width="50%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
									<b>Description</b>
								</th>
								<th width="20%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px">
									<b>Quantity</b>
								</th>
								<th colspan="2" width="45%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align: right">
									<b>Unit Price</b>
								</th>
							</tr>
							<?php
							$paxDetails = explode("~", $success_landtour->paxDetails);
							for($r=1; $r<=$success_landtour->countRoom; $r++) {
								$paxGetQty  = explode(".", $paxDetails[$r-1]);
							?>
								<tr>
									<td class='time' colspan="4" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										Room <?php echo $r; ?> Details
									</td>
								</tr>
								<?php
								if( $paxGetQty[0] > 0 ) {
									if( $paxGetQty[0] == 1 && $paxGetQty[4] == 1 ) { $adultPrice = $adultTwin_price; }
									else if( $paxGetQty[0] == 1 && $paxGetQty[1] == 1 ) { $adultPrice = $adultTwin_price; }
									else if( $paxGetQty[0] == 1 ) 		{ $adultPrice = $adultSingle_price; }
									else if( $paxGetQty[0] == 2 ) 	{ $adultPrice = $adultTwin_price; }
									else if( $paxGetQty[0] == 3 ) 	{ $adultPrice = $adultTriple_price; }
								?>
									<tr>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											Adult Pax
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
											<?php echo $paxGetQty[0]; ?>
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
											&nbsp;
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											$<?php echo number_format($adultPrice*$paxGetQty[0], 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<?php
								if( $paxGetQty[1] > 0 ) {
									if( $paxGetQty[0] == 1 && $paxGetQty[1] == 1 ) {
										$childWBPrice = $half_price;
									}
									else {
										$childWBPrice = $child_wb_price;
									}
								?>
									<tr>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											Child with Bed Pax
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
											<?php echo $paxGetQty[1]; ?>
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
											&nbsp;
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											$<?php echo number_format($paxGetQty[1]*$childWBPrice, 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<?php
								if( $paxGetQty[2] > 0 ) {
								?>
									<tr>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											Child without Bed Pax
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
											<?php echo $paxGetQty[2]; ?>
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
											&nbsp;
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											$<?php echo number_format($paxGetQty[2]*$child_wob_price, 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<?php
								if( $paxGetQty[4] > 0 ) {
								?>
									<tr>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											Child half twin Pax
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
											<?php echo $paxGetQty[4]; ?>
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
											&nbsp;
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											$<?php echo number_format($paxGetQty[4]*$half_price, 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<?php
								if( $paxGetQty[3] > 0 ) {
								?>
									<tr>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											Infant Pax
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
											<?php echo $paxGetQty[3]; ?>
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
											&nbsp;
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											$<?php echo number_format($paxGetQty[3]*$infant_price, 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<tr>
									<td class='time' colspan="3" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										<b>Price Pax</b>
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										<?php
										$totalPaxPrice = ($adultPrice*$paxGetQty[0])+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price)+($paxGetQty[4]*$half_price);
										$totalGrandPrice += ($adultPrice*$paxGetQty[0])+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price)+($paxGetQty[4]*$half_price);
										?>
										$<?php echo number_format($totalPaxPrice, 2); ?>
									</td>
								</tr>
							<?php
							}
							?>
						</table>
					<?php
					}
					?>
				</div>
			</div>
			<div class="room-information" style="width:28%; height:auto">
				<div class="tab">
					<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<td colspan="5" style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
								<div style="font-size:12px">
									<?php
									if( $success_landtour->sellingType == "ticket" ) {
										$paxDetails    = explode("~", $success_landtour->paxDetails);
										$adultTicketNO = $paxDetails[0];
										$childTicketNO = $paxDetails[1];
									?>
											<!--LIST-->
											<div>
												<b style="font-size:15px">TICKET</b>
											</div>
											<div>
												<div style="font-size:15px">List of ticket name:</div>
												<ul>
													<?php
													$landtourPaxTickets = $this->All->select_template_w_2_conditions(
														"bookingID", $bookingOrderID,
														"itemRecordRef", $itemRef,
														"landtour_paxname_ticket"
													);
													if( $landtourPaxTickets == TRUE ) {
														foreach( $landtourPaxTickets AS $landtourPaxTicket ) {
															$roomPaxName = $landtourPaxTicket->pax_name;
												        	$roomPaxType = $landtourPaxTicket->pax_type;
												    ?>
												    	<ol style="color:green; font-size:14px">
													    	<b>- (<?php echo $roomPaxType; ?>) - <?php echo $roomPaxName; ?></b>
													    </ol>
												    <?php
														}
													}
													?>
												</ul>
											</div>
											<br />
											<!--END OF LIST-->
									<?php
									}
									else {
										$paxDetails = explode("~", $success_landtour->paxDetails);
										for($pr=1; $pr<=$success_landtour->countRoom; $pr++) {
											$paxGetQty  = explode(".", $paxDetails[$pr-1]);
									?>
											<!--LIST-->
											<div>
												<b style="font-size:15px">ROOM <?php echo $pr; ?></b>
											</div>
											<div>
												<div style="font-size:15px">List of guest name:</div>
												<ul>
													<?php
													$landtourPaxs = $this->All->select_template_w_3_conditions(
														"bookingID", $bookingOrderID,
														"roomIndex", $pr,
														"itemRecordRef", $itemRef,
														"landtour_paxname"
													);
											        if( $landtourPaxs == TRUE ) {
											        	foreach( $landtourPaxs AS $landtourPax ) {
												        	$roomPaxName = $landtourPax->pax_name;
												        	$roomPaxType = $landtourPax->pax_type;
												    ?>
												    	<ol style="color:green; font-size:14px">
													    	<b>- (<?php echo $roomPaxType; ?>) - <?php echo $roomPaxName; ?></b>
													    </ol>
												    <?php
											        	}
											        }
											        ?>
												</ul>
											</div>
											<br />
											<!--END OF LIST-->
									<?php
										}
									}
									?>
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
											<?php
											if( $success_landtour->sellingType == "ticket" ) {
											?>
												$<?php echo number_format($totalPaxPrice, 2); ?>
											<?php
											}
											else {
											?>
												$<?php echo number_format($totalPaxPrice, 2); ?>
											<?php
											}
											?>
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
				$itemRef++;
			}
		}
		?>
	</ul>
	<?php echo form_close(); ?>
<?php
}
?>
<!--END OF LANDTOUR SUCCESS-->