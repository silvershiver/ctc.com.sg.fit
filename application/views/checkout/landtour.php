<!--LAND TOUR CONFIRMATION-->
<?php
$childWBPrice = "";
if( $this->session->userdata('shoppingCartLandtourCookie') == FALSE ) {

		$totalGrandPrice = 0;
		$totalPaxPrice   = 0;
		if( $this->session->userdata('normal_session_id') == TRUE ) {
			$carts = $this->All->select_template_with_where_and_order(
				"user_access_id", $this->session->userdata('normal_session_id'), "id", "ASC", "landtour_cart"
			);
			if( $carts == TRUE ) {
				$itemeRecordRef = 1;
				$c = 0;
				foreach( $carts AS $cart ) {
					$totalPaxAdult{$cart->id}    = 0;
					$totalPaxChild{$cart->id}    = 0;
					$totalPaxHalf{$cart->id}     = 0;
					$totalPaxInfant{$cart->id}   = 0;
					$totalTicketAdult{$cart->id} = 0;
					$totalTicketChild{$cart->id} = 0;
					$totalAllPaxPrice{$cart->id} = 0;
					//get landtour title details
					$landtours = $this->All->select_template("id", $cart->landtour_product_id, "landtour_product");
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
					$others = $this->All->select_template("id", $cart->landtour_system_price_id, "landtour_system_prices");
					if( $others == TRUE ) {
						foreach( $others AS $other ) {
							$adultSingle_price 	= $other->adultSingle_price;
							$adultTwin_price   	= $other->adultTwin_price;
							$adultTriple_price 	= $other->adultTriple_price;
							$child_wb_price    	= $other->child_wb_price;
							$child_wob_price   	= $other->child_wob_price;
							$half_price 		= $other->child_half_twin_price;
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
		<h1>Confirmed Booking Order - Land Tour</h1>
	<ul class="room-types">

		<li>
			<div class="meta" style="width:75%">
				<div class="tab">
					<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
						<tr class="days">
							<th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
								<div style="font-size:12px">
									<img src="<?php echo $this->All->getLandtourImage($cart->landtour_product_id); ?>" width="150" height="115" />
								</div>
							</th>
						</tr>
						<tr>
							<td colspan="3" style="text-align:left; padding-bottom:0px">
								<div style="font-size:15px">
									<h5>Land tour title</h5>
									<?php echo $lt_title; ?> (<?php echo $lt_tourID; ?>)
								</div>
							</td>
						</tr>
						<tr>
							<td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
								<div style="font-size:15px">
									<h5>Departure date</h5>
									<?php echo date("d/m/Y", strtotime($cart->selectedDate)); ?>
								</div>
							</td>
							<td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px"></td>
						</tr>
						<tr>
							<td colspan="3" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
								<?php
								if( $cart->sellingType == "ticket" ) {
									$ticketDetails = explode("~", $cart->paxDetails);
								?>
									<div style="font-size:15px">
										<h5>No. of ticket</h5><?php echo $ticketDetails[0]+$ticketDetails[1]; ?> ticket(s)
									</div>
								<?php
								}
								else {
								?>
									<div style="font-size:15px">
										<h5>No. of room</h5><?php echo $cart->countRoom; ?> room(s)
									</div>
								<?php
								}
								?>
								<br />
							</td>
						</tr>
					</table>
					<?php
					if( $cart->sellingType == "ticket" ) {
					?>
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td style="width:40%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
									<b>Description</b>
								</td>
								<td style="width:9%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:center">
									<b>Quantity</b>
								</td>
								<td colspan="2" style="width:20%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:right">
									<b>Unit Price</b>
								</td>
							</tr>
							<tr>
								<td class='time' colspan="4" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
									Ticket Details
								</td>
							</tr>
							<?php $paxDetails = explode("~", $cart->paxDetails); ?>
							<?php
							if( $paxDetails[0] > 0 ) {
								$totalTicketAdult{$cart->id} += $paxDetails[0];
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
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										$<?php echo number_format($ticketAdultPrice, 2); ?>
									</td>
								</tr>
							<?php
							}
							?>
							<?php
							if( $paxDetails[1] > 0 ) {
								$totalTicketChild{$cart->id} += $paxDetails[1];
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
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										$<?php echo number_format($ticketChildPrice, 2); ?>
									</td>
								</tr>
							<?php
							}
							?>
							<tr>
								<td class='time' colspan="3" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
									<b>Grand Total</b>
								</td>
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
									<?php
									$totalPaxPrice = ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
									$totalGrandPrice += ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
									$totalAllPaxPrice{$cart->id} += ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
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
							<tr>
								<td style="width:40%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
									<b>Description</b>
								</td>
								<td style="width:9%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:center">
									<b>Quantity</b>
								</td>
								<td colspan="2" style="width:20%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:right">
									<b>Unit Price</b>
								</td>
							</tr>
							<?php
							$paxDetails = explode("~", $cart->paxDetails);
							for($r=1; $r<=$cart->countRoom; $r++) {
								$paxGetQty  = explode(".", $paxDetails[$r-1]);
							?>
								<tr>
									<td class='time' colspan="4" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										Room <?php echo $r; ?> Details
									</td>
								</tr>
								<?php
								if( $paxGetQty[0] > 0 ) {
									$totalPaxAdult{$cart->id} += $paxGetQty[0];
									if( $paxGetQty[0] == 1 && $paxGetQty[4] == 1 ) { $adultPrice = $adultTwin_price; }
									else if( $paxGetQty[0] == 1 && $paxGetQty[1] == 1 ) { $adultPrice = $adultTwin_price; }
									else if( $paxGetQty[0] == 1 ) { $adultPrice = $adultSingle_price; }
									else if( $paxGetQty[0] == 2 ) { $adultPrice = $adultTwin_price; }
									else if( $paxGetQty[0] == 3 ) { $adultPrice = $adultTriple_price; }
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
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
											$<?php echo number_format($adultPrice, 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<?php
								if( $paxGetQty[1] > 0 ) {
									$totalPaxChild{$cart->id} += $paxGetQty[1];
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
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
											$<?php echo number_format($childWBPrice, 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<?php
								if( $paxGetQty[2] > 0 ) {
									$totalPaxChild{$cart->id} += $paxGetQty[2];
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
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
											$<?php echo number_format($child_wob_price, 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<?php
								if( $paxGetQty[4] > 0 ) {
									$totalPaxHalf{$cart->id} += $paxGetQty[4];
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
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
											$<?php echo number_format($half_price, 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<?php
								if( $paxGetQty[3] > 0 ) {
									$totalPaxInfant{$cart->id} += $paxGetQty[3];
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
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
											$<?php echo number_format($infant_price, 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<tr>
									<td class='time' colspan="3" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										<b>Grand Total</b>
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										<?php
										$totalPaxPrice = ($adultPrice*$paxGetQty[0])+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price)+($paxGetQty[4]*$half_price);
										$totalGrandPrice += ($adultPrice*$paxGetQty[0])+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price)+($paxGetQty[4]*$half_price);
										$totalAllPaxPrice{$cart->id} += ($adultPrice*$paxGetQty[0])+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price)+($paxGetQty[4]*$half_price);
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
			<div class="room-information" style="height:112px; width:19%">
				<div class="tab">
					<?php
					if( $cart->sellingType == "ticket" ) {
					?>
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>ADULT(S)</b>
										</div>
									</div>
								</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>0<?php echo $totalTicketAdult{$cart->id}; ?></b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>CHILD(S)</b>
										</div>
									</div>
								</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>0<?php echo $totalTicketChild{$cart->id}; ?></b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>PRICE:</b>
										</div>
									</div>
								</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>
												<?php
												$total_ltour_grand += $totalAllPaxPrice{$cart->id};
												?>
											$<?php echo number_format($totalAllPaxPrice{$cart->id}, 2); ?></b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
							</tr>
						</table>
					<?php
					}
					else {
					?>
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>ADULT(S)</b>
										</div>
									</div>
								</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>0<?php echo $totalPaxAdult{$cart->id}; ?></b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>CHILD(S)</b>
										</div>
									</div>
								</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>0<?php echo $totalPaxChild{$cart->id}; ?></b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>INFANT(S)</b>
										</div>
									</div>
								</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>0<?php echo $totalPaxInfant{$cart->id}; ?></b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>PRICE:</b>
										</div>
									</div>
								</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>
												<?php
												$total_ltour_grand += $totalAllPaxPrice{$cart->id};
												?>
											$<?php echo number_format($totalAllPaxPrice{$cart->id}, 2); ?></b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
							</tr>
						</table>
					<?php
					}
					?>
				</div>
			</div>
			<div style="clear:both"></div>
			<div style="margin-top:10px">
				<div class="age_type" style="font-size:14px">
					Please enter your passenger details and ensure the details matches your passport.
					<span style="text-transform: capitalize; color:red">
						<b>(* required field)</b>
					</span>
				</div>
				<?php
			    if( $cart->sellingType == "ticket" ) {
				?>
					<div style="padding:10px">
						<div style="margin-top:8px"><b>Enter ticket Pax details</b></div>
					<?php
						$paxDetails    = explode("~", $cart->paxDetails);
						$adultTicketNO = $paxDetails[0];
						$childTicketNO = $paxDetails[1];
						if( $adultTicketNO > 0 ) {
							for( $ad=1; $ad<=$adultTicketNO; $ad++ )
							{
					?>
							<div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
			                    <div class="form_div particular-form">
			                    	<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
	                                    <div>
	                                        <span style="color:green"><b>Adult <?php echo $ad ; ?> </b></span>
	                                    </div>
	                                </div>

									<div>
	                                    <div style="margin-top:10px; margin-bottom:5px">Title</div>
	                                    <div>
	                                        <select name="LT_TicketTitleAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:210px; height:37px" id="tickettitleAdult_<?php echo $ad;?>">
	                                            <option value="">- Choose title -</option>
	                                            <option value="Mr">Mr</option>
	                                            <option value="Ms">Ms</option>
	                                        </select>
	                                    </div>
	                                </div>
	                                <div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
	                                            <input type="text" name="LT_TicketgivennameAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_TicketgivennameAdult_<?php echo $ad;?>">
	                                        </div>
	                                    </div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
	                                            <input type="text" name="LT_TicketsurnameAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameAdult_<?php echo $ad;?>">
	                                        </div>
	                                    </div>
	                                    <div style="clear:both"></div>
	                                    <div>
	                                        <ul class="info-li">
	                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
	                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
	                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
	                                        </ul>
	                                    </div>
	                                </div>
	                                <div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
	                                            <input type="text" name="LT_Ticketpassport_noAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="Ticket_passport_noAdult_<?php echo $ad;?>">
	                                        </div>
	                                    </div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
	                                            <select name="LT_Ticket_dob_yearAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Year -</option>
	                                                <?php
	                                                $dobYear = 2005;
	                                                for( $xYear=1920; $xYear<=$dobYear; $xYear++ ) {
	                                                ?>
	                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                            <select name="LT_Ticket_dob_monthAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Month -</option>
	                                                <option value="01">Jan</option>
	                                                <option value="02">Feb</option>
	                                                <option value="03">Mar</option>
	                                                <option value="04">Apr</option>
	                                                <option value="05">May</option>
	                                                <option value="06">Jun</option>
	                                                <option value="07">Jul</option>
	                                                <option value="08">Aug</option>
	                                                <option value="09">Sep</option>
	                                                <option value="10">Oct</option>
	                                                <option value="11">Nov</option>
	                                                <option value="12">Dec</option>
	                                            </select>
	                                            <select name="LT_Ticket_dob_dayAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Day -</option>
	                                                <?php
	                                                $dobDay = 31;
	                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
	                                                ?>
	                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div style="clear:both"></div>
	                                </div>
	                                <div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
	                                            <select name="LT_Ticket_nationalityAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
	                                                <?php
	                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
	                                                foreach( $nationalities AS $nationality ) {
	                                                    if( $nationality->nicename == "Singapore" ) {
	                                                ?>
	                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
	                                                    <?php echo $nationality->nicename; ?>
	                                                </option>
	                                                <?php
	                                                    }
	                                                    else {
	                                                ?>
	                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
	                                                    <?php echo $nationality->nicename; ?>
	                                                </option>
	                                                <?php
	                                                    }
	                                                }
	                                                ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
	                                            <select name="LT_Ticket_passportIssueCountryAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
	                                                <?php
	                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
	                                                foreach( $nationalities AS $nationality ) {
	                                                    if( $nationality->nicename == "Singapore" ) {
	                                                ?>
	                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
	                                                    <?php echo $nationality->nicename; ?>
	                                                </option>
	                                                <?php
	                                                    }
	                                                    else {
	                                                ?>
	                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
	                                                    <?php echo $nationality->nicename; ?>
	                                                </option>
	                                                <?php
	                                                    }
	                                                }
	                                                ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div style="clear:both"></div>
	                                </div>
	                                <div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
	                                            <select name="LT_Ticket_passport_expiryYearAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Year -</option>
	                                                <?php
	                                                $expiryYear = 2031;
	                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
	                                                ?>
	                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                            <select name="LT_Ticket_passport_expiryMonthAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Month -</option>
	                                                <option value="01">Jan</option>
	                                                <option value="02">Feb</option>
	                                                <option value="03">Mar</option>
	                                                <option value="04">Apr</option>
	                                                <option value="05">May</option>
	                                                <option value="06">Jun</option>
	                                                <option value="07">Jul</option>
	                                                <option value="08">Aug</option>
	                                                <option value="09">Sep</option>
	                                                <option value="10">Oct</option>
	                                                <option value="11">Nov</option>
	                                                <option value="12">Dec</option>
	                                            </select>
	                                            <select name="LT_Ticket_passport_expiryDateAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Day -</option>
	                                                <?php
	                                                $expiryDate = 31;
	                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
	                                                ?>
	                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
	                                            <select name="LT_Ticket_passport_issueYearAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Year -</option>
	                                                <?php
	                                                $issueYear = date("Y");
	                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
	                                                ?>
	                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                            <select name="LT_Ticket_passport_issueMonthAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Month -</option>
	                                                <option value="01">Jan</option>
	                                                <option value="02">Feb</option>
	                                                <option value="03">Mar</option>
	                                                <option value="04">Apr</option>
	                                                <option value="05">May</option>
	                                                <option value="06">Jun</option>
	                                                <option value="07">Jul</option>
	                                                <option value="08">Aug</option>
	                                                <option value="09">Sep</option>
	                                                <option value="10">Oct</option>
	                                                <option value="11">Nov</option>
	                                                <option value="12">Dec</option>
	                                            </select>
	                                            <select name="LT_Ticket_passport_issueDayAdult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Day -</option>
	                                                <?php
	                                                $issueDate = 31;
	                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
	                                                ?>
	                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div style="clear:both"></div>
	                                    <div>
	                                        <ul class="info-li">
	                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
	                                        </ul>
	                                    </div>
	                                </div>
	                                <div>
	                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
	                                    <textarea name="LT_Ticket_passengerRemarks_Adult[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_Adult_<?php echo $pr."_".$paxA;?>"></textarea>
	                                </div>
								</div>
							</div>
						<?php
							}
						}

						if( $childTicketNO > 0 ) {
							for( $ch=1; $ch<=$childTicketNO; $ch++ ) {
						?>
		        			<div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
	                            <div class="form_div particular-form">
	                                <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
	                                    <div>
	                                        <span style="color:green"><b>Child <?php echo $ch ; ?></b></span>
	                                    </div>
	                                </div>

	                                <div>
	                                    <div style="margin-top:10px; margin-bottom:5px">Title</div>
	                                    <div>
	                                        <select name="LT_Ticket_titleChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:210px; height:37px" id="ticket_titleChild_<?php echo $ch;?>">
	                                            <option value="">- Choose title -</option>
	                                            <option value="Mr">Mr</option>
	                                            <option value="Ms">Ms</option>
	                                        </select>
	                                    </div>
	                                </div>
	                                <div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
	                                            <input type="text" name="LT_Ticket_givennameChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_Ticket_givennameChild_<?php echo $ch;?>">
	                                        </div>
	                                    </div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
	                                            <input type="text" name="LT_Ticket_surnameChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_Ticket_surnameChild_<?php echo $ch;?>">
	                                        </div>
	                                    </div>
	                                    <div style="clear:both"></div>
	                                    <div>
	                                        <ul class="info-li">
	                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
	                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
	                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
	                                        </ul>
	                                    </div>
	                                </div>
	                                <div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
	                                            <input type="text" name="LT_Ticket_passport_noChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="Ticket_passport_noChild_<?php echo $ch;?>">
	                                        </div>
	                                    </div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
	                                            <select name="LT_Ticket_dob_yearChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Year -</option>
	                                                <?php
	                                                $dobYear = 2005;
	                                                for( $xYear=1920; $xYear<=$dobYear; $xYear++ ) {
	                                                ?>
	                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                            <select name="LT_Ticket_dob_monthChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Month -</option>
	                                                <option value="01">Jan</option>
	                                                <option value="02">Feb</option>
	                                                <option value="03">Mar</option>
	                                                <option value="04">Apr</option>
	                                                <option value="05">May</option>
	                                                <option value="06">Jun</option>
	                                                <option value="07">Jul</option>
	                                                <option value="08">Aug</option>
	                                                <option value="09">Sep</option>
	                                                <option value="10">Oct</option>
	                                                <option value="11">Nov</option>
	                                                <option value="12">Dec</option>
	                                            </select>
	                                            <select name="LT_Ticket_dob_dayChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Day -</option>
	                                                <?php
	                                                $dobDay = 31;
	                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
	                                                ?>
	                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div style="clear:both"></div>
	                                </div>
	                                <div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
	                                            <select name="LT_Ticket_nationalityChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
	                                                <?php
	                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
	                                                foreach( $nationalities AS $nationality ) {
	                                                    if( $nationality->nicename == "Singapore" ) {
	                                                ?>
	                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
	                                                    <?php echo $nationality->nicename; ?>
	                                                </option>
	                                                <?php
	                                                    }
	                                                    else {
	                                                ?>
	                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
	                                                    <?php echo $nationality->nicename; ?>
	                                                </option>
	                                                <?php
	                                                    }
	                                                }
	                                                ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
	                                            <select name="LT_Ticket_passportIssueCountryChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
	                                                <?php
	                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
	                                                foreach( $nationalities AS $nationality ) {
	                                                    if( $nationality->nicename == "Singapore" ) {
	                                                ?>
	                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
	                                                    <?php echo $nationality->nicename; ?>
	                                                </option>
	                                                <?php
	                                                    }
	                                                    else {
	                                                ?>
	                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
	                                                    <?php echo $nationality->nicename; ?>
	                                                </option>
	                                                <?php
	                                                    }
	                                                }
	                                                ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div style="clear:both"></div>
	                                </div>
	                                <div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
	                                            <select name="LT_Ticket_passport_expiryYearChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Year -</option>
	                                                <?php
	                                                $expiryYear = 2031;
	                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
	                                                ?>
	                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                            <select name="LT_Ticket_passport_expiryMonthChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Month -</option>
	                                                <option value="01">Jan</option>
	                                                <option value="02">Feb</option>
	                                                <option value="03">Mar</option>
	                                                <option value="04">Apr</option>
	                                                <option value="05">May</option>
	                                                <option value="06">Jun</option>
	                                                <option value="07">Jul</option>
	                                                <option value="08">Aug</option>
	                                                <option value="09">Sep</option>
	                                                <option value="10">Oct</option>
	                                                <option value="11">Nov</option>
	                                                <option value="12">Dec</option>
	                                            </select>
	                                            <select name="LT_Ticket_passport_expiryDateChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Day -</option>
	                                                <?php
	                                                $expiryDate = 31;
	                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
	                                                ?>
	                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div style="float:left; width:50%">
	                                        <div>
	                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
	                                            <select name="LT_Ticket_passport_issueYearChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Year -</option>
	                                                <?php
	                                                $issueYear = date("Y");
	                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
	                                                ?>
	                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                            <select name="LT_Ticket_passport_issueMonthChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Month -</option>
	                                                <option value="01">Jan</option>
	                                                <option value="02">Feb</option>
	                                                <option value="03">Mar</option>
	                                                <option value="04">Apr</option>
	                                                <option value="05">May</option>
	                                                <option value="06">Jun</option>
	                                                <option value="07">Jul</option>
	                                                <option value="08">Aug</option>
	                                                <option value="09">Sep</option>
	                                                <option value="10">Oct</option>
	                                                <option value="11">Nov</option>
	                                                <option value="12">Dec</option>
	                                            </select>
	                                            <select name="LT_Ticket_passport_issueDayChild[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
	                                                <option value="">- Day -</option>
	                                                <?php
	                                                $issueDate = 31;
	                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
	                                                ?>
	                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
	                                                <?php
	                                                }
	                                                ?>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div style="clear:both"></div>
	                                    <div>
	                                        <ul class="info-li">
	                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
	                                        </ul>
	                                    </div>
	                                </div>
	                                <div>
	                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
	                                    <textarea name="LT_Ticket_passengerRemarks_Child[<?php echo $c+1; ?>00000<?php echo $cart->landtour_product_id; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="Ticket_passengerRemarks_Child_<?php echo $ch;?>"></textarea>
	                                </div>
	                            </div>
	                        </div>
						<?php
							}
						}
						?>
					</div>
				<?php
				}
				else {
					/* ROOM DETAILS */
				    ?>
				    	<div style="padding:10px">
					    	<?php
							$paxDetails = explode("~", $cart->paxDetails);
							for($pr=1; $pr<=$cart->countRoom; $pr++) {
								$paxGetQty  = explode(".", $paxDetails[$pr-1]);
							?>
								<div style="margin-bottom:10px; font-size: 14px">
                                    <div style="margin-bottom:10px">
                                    	<span><b>Room  <?php echo $pr; ?> Pax Details*</b></span>
                                    </div>
                                    <?php
                                    if( $paxGetQty[0] > 0 ) {
                                        for( $paxA=1; $paxA<=$paxGetQty[0]; $paxA++ ) {
                                    ?>
                                    	<div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
                                            <div class="form_div particular-form">
                                                <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
                                                    <div>
                                                        <span style="color:green"><b>Adult <?php echo $paxA ; ?> </b></span>
                                                    </div>
                                                </div>

                                                <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Title</div>
                                                    <div>
                                                        <select name="LT_titleAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:210px; height:37px" id="titleAdult_<?php echo $pr."_".$paxA;?>">
                                                            <option value="">- Choose title -</option>
                                                            <option value="Mr">Mr</option>
                                                            <option value="Ms">Ms</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div style="float:left; width:50%">
                                                        <div>
                                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
                                                            <input type="text" name="LT_givennameAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_givennameAdult_<?php echo $pr."_".$paxA;?>">
                                                        </div>
                                                    </div>
                                                    <div style="float:left; width:50%">
                                                        <div>
                                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
                                                            <input type="text" name="LT_surnameAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameAdult_<?php echo $pr."_".$paxA;?>">
                                                        </div>
                                                    </div>
                                                    <div style="clear:both"></div>
                                                    <div>
                                                        <ul class="info-li">
                                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
                                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
                                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div style="float:left; width:50%">
                                                        <div>
                                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
                                                            <input type="text" name="LT_passport_noAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="passport_noAdult_<?php echo $pr."_".$paxA;?>">
                                                        </div>
                                                    </div>
                                                    <div style="float:left; width:50%">
                                                        <div>
                                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
                                                            <select name="LT_dob_yearAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
                                                                <option value="">- Year -</option>
                                                                <?php
                                                                $dobYear = 2005;
                                                                for( $xYear=1920; $xYear<=$dobYear; $xYear++ ) {
                                                                ?>
                                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select name="LT_dob_monthAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
                                                                <option value="">- Month -</option>
                                                                <option value="01">Jan</option>
                                                                <option value="02">Feb</option>
                                                                <option value="03">Mar</option>
                                                                <option value="04">Apr</option>
                                                                <option value="05">May</option>
                                                                <option value="06">Jun</option>
                                                                <option value="07">Jul</option>
                                                                <option value="08">Aug</option>
                                                                <option value="09">Sep</option>
                                                                <option value="10">Oct</option>
                                                                <option value="11">Nov</option>
                                                                <option value="12">Dec</option>
                                                            </select>
                                                            <select name="LT_dob_dayAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
                                                                <option value="">- Day -</option>
                                                                <?php
                                                                $dobDay = 31;
                                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
                                                                ?>
                                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div style="clear:both"></div>
                                                </div>
                                                <div>
                                                    <div style="float:left; width:50%">
                                                        <div>
                                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
                                                            <select name="LT_nationalityAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
                                                                <?php
                                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                                foreach( $nationalities AS $nationality ) {
                                                                    if( $nationality->nicename == "Singapore" ) {
                                                                ?>
                                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                                    <?php echo $nationality->nicename; ?>
                                                                </option>
                                                                <?php
                                                                    }
                                                                    else {
                                                                ?>
                                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                                    <?php echo $nationality->nicename; ?>
                                                                </option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div style="float:left; width:50%">
                                                        <div>
                                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
                                                            <select name="LT_passportIssueCountryAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
                                                                <?php
                                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                                foreach( $nationalities AS $nationality ) {
                                                                    if( $nationality->nicename == "Singapore" ) {
                                                                ?>
                                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                                    <?php echo $nationality->nicename; ?>
                                                                </option>
                                                                <?php
                                                                    }
                                                                    else {
                                                                ?>
                                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                                    <?php echo $nationality->nicename; ?>
                                                                </option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div style="clear:both"></div>
                                                </div>
                                                <div>
                                                    <div style="float:left; width:50%">
                                                        <div>
                                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
                                                            <select name="LT_passport_expiryYearAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
                                                                <option value="">- Year -</option>
                                                                <?php
                                                                $expiryYear = 2031;
                                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
                                                                ?>
                                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select name="LT_passport_expiryMonthAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
                                                                <option value="">- Month -</option>
                                                                <option value="01">Jan</option>
                                                                <option value="02">Feb</option>
                                                                <option value="03">Mar</option>
                                                                <option value="04">Apr</option>
                                                                <option value="05">May</option>
                                                                <option value="06">Jun</option>
                                                                <option value="07">Jul</option>
                                                                <option value="08">Aug</option>
                                                                <option value="09">Sep</option>
                                                                <option value="10">Oct</option>
                                                                <option value="11">Nov</option>
                                                                <option value="12">Dec</option>
                                                            </select>
                                                            <select name="LT_passport_expiryDateAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
                                                                <option value="">- Day -</option>
                                                                <?php
                                                                $expiryDate = 31;
                                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
                                                                ?>
                                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div style="float:left; width:50%">
                                                        <div>
                                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
                                                            <select name="LT_passport_issueYearAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
                                                                <option value="">- Year -</option>
                                                                <?php
                                                                $issueYear = date("Y");
                                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
                                                                ?>
                                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <select name="LT_passport_issueMonthAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
                                                                <option value="">- Month -</option>
                                                                <option value="01">Jan</option>
                                                                <option value="02">Feb</option>
                                                                <option value="03">Mar</option>
                                                                <option value="04">Apr</option>
                                                                <option value="05">May</option>
                                                                <option value="06">Jun</option>
                                                                <option value="07">Jul</option>
                                                                <option value="08">Aug</option>
                                                                <option value="09">Sep</option>
                                                                <option value="10">Oct</option>
                                                                <option value="11">Nov</option>
                                                                <option value="12">Dec</option>
                                                            </select>
                                                            <select name="LT_passport_issueDayAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
                                                                <option value="">- Day -</option>
                                                                <?php
                                                                $issueDate = 31;
                                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
                                                                ?>
                                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div style="clear:both"></div>
                                                    <div>
                                                        <ul class="info-li">
                                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
                                                    <textarea name="LT_passengerRemarks_Adult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_Adult_<?php echo $pr."_".$paxA;?>"></textarea>
                                                </div>
                                            </div>
                                        </div>
							    	<?php
							        	}
							        }
							        if( $paxGetQty[1] > 0 ) {
							        	for( $paxB=1; $paxB<=$paxGetQty[1]; $paxB++ ) {
								    ?>
							        	<div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
		                                    <div class="form_div particular-form">
		                                        <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
		                                            <div>
		                                                <span style="color:green"><b>Child <?php echo $paxB ; ?> (with Bed)</b></span>
		                                            </div>
		                                        </div>

		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Title</div>
		                                            <div>
		                                                <select name="LT_titleChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:210px; height:37px" id="titleChildWB_<?php echo $pr."_".$paxB;?>">
		                                                    <option value="">- Choose title -</option>
		                                                    <option value="MSTR">Master</option>
															<option value="Miss">Miss</option>
		                                                </select>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
		                                                    <input type="text" name="LT_givennameChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_givennameChildWB_<?php echo $pr."_".$paxB;?>">
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
		                                                    <input type="text" name="LT_surnameChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameChildWB_<?php echo $pr."_".$paxB;?>">
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                            <div>
		                                                <ul class="info-li">
		                                                    <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
		                                                </ul>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
		                                                    <input type="text" name="LT_passport_noChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="passport_noChildWB_<?php echo $pr."_".$paxB;?>">
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
		                                                    <select name="LT_dob_yearChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $dobYear = date("Y");
		                                                        for( $xYear=date("Y")-12; $xYear<=$dobYear; $xYear++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_dob_monthChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_dob_dayChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $dobDay = 31;
		                                                        for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
		                                                    <select name="LT_nationalityChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
		                                                        <?php
		                                                        $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                        foreach( $nationalities AS $nationality ) {
		                                                            if( $nationality->nicename == "Singapore" ) {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                            else {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
		                                                    <select name="LT_passportIssueCountryChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
		                                                        <?php
		                                                        $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                        foreach( $nationalities AS $nationality ) {
		                                                            if( $nationality->nicename == "Singapore" ) {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                            else {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
		                                                    <select name="LT_passport_expiryYearChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $expiryYear = 2031;
		                                                        for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_passport_expiryMonthChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_passport_expiryDateChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $expiryDate = 31;
		                                                        for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
		                                                    <select name="LT_passport_issueYearChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $issueYear = date("Y");
		                                                        for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_passport_issueMonthChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_passport_issueDayChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $issueDate = 31;
		                                                        for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                            <div>
		                                                <ul class="info-li">
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
		                                                </ul>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
		                                            <textarea name="LT_passengerRemarks_ChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_WB_<?php echo $pr."_".$paxB;?>"></textarea>
		                                        </div>
		                                    </div>
		                                </div>
								    <?php
							        	}
							        }

							        if( $paxGetQty[2] > 0 ) {
							        	for( $paxC=1; $paxC<=$paxGetQty[2]; $paxC++ ) {
								    ?>
							        	<div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
		                                    <div class="form_div particular-form">
		                                        <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
		                                            <div>
		                                                <span style="color:green"><b>Child <?php echo $paxC ; ?> (Without Bed)</b></span>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Title</div>
		                                            <div>
		                                                <select name="LT_titleChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:210px; height:37px" id="titleChildWOB_<?php echo $pr."_".$paxC;?>">
		                                                    <option value="">- Choose title -</option>
		                                                    <option value="MSTR">Master</option>
															<option value="Miss">Miss</option>
		                                                </select>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
		                                                    <input type="text" name="LT_givennameChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_givennameChildWOB_<?php echo $pr."_".$paxC;?>">
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
		                                                    <input type="text" name="LT_surnameChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameChildWOB_<?php echo $pr."_".$paxC;?>">
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                            <div>
		                                                <ul class="info-li">
		                                                    <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
		                                                </ul>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
		                                                    <input type="text" name="LT_passport_noChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="passport_noChildWOB_<?php echo $pr."_".$paxC;?>">
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
		                                                    <select name="LT_dob_yearChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $dobYear = date("Y");
		                                                        for( $xYear=date("Y")-12; $xYear<=$dobYear; $xYear++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_dob_monthChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_dob_dayChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $dobDay = 31;
		                                                        for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
		                                                    <select name="LT_nationalityChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
		                                                        <?php
		                                                        $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                        foreach( $nationalities AS $nationality ) {
		                                                            if( $nationality->nicename == "Singapore" ) {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                            else {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
		                                                    <select name="LT_passportIssueCountryChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
		                                                        <?php
		                                                        $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                        foreach( $nationalities AS $nationality ) {
		                                                            if( $nationality->nicename == "Singapore" ) {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                            else {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
		                                                    <select name="LT_passport_expiryYearChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $expiryYear = 2031;
		                                                        for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_passport_expiryMonthChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_passport_expiryDateChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $expiryDate = 31;
		                                                        for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
		                                                    <select name="LT_passport_issueYearChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $issueYear = date("Y");
		                                                        for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_passport_issueMonthChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_passport_issueDayChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $issueDate = 31;
		                                                        for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                            <div>
		                                                <ul class="info-li">
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
		                                                </ul>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
		                                            <textarea name="LT_passengerRemarks_ChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_ChildWOB_<?php echo $pr."_".$paxC;?>"></textarea>
		                                        </div>
		                                    </div>
		                                </div>
								    <?php
							        	}
							        }

							        if( $paxGetQty[4] > 0 ) {
							        	for( $paxH=1; $paxH<=$paxGetQty[4]; $paxH++ ) {
								    ?>
							        	<div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
		                                    <div class="form_div particular-form">
		                                        <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
		                                            <div>
		                                                <span style="color:green"><b>Child <?php echo $paxH ; ?> (Half Twin Bed)</b></span>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Title</div>
		                                            <div>
		                                                <select name="LT_titleChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:210px; height:37px" id="titleChildHALF_<?php echo $pr."_".$paxH;?>">
		                                                    <option value="">- Choose title -</option>
		                                                    <option value="MSTR">Master</option>
															<option value="Miss">Miss</option>
		                                                </select>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
		                                                    <input type="text" name="LT_givennameChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_givennameChildHALF_<?php echo $pr."_".$paxH;?>">
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
		                                                    <input type="text" name="LT_surnameChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameChildHALF_<?php echo $pr."_".$paxH;?>">
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                            <div>
		                                                <ul class="info-li">
		                                                    <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
		                                                </ul>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
		                                                    <input type="text" name="LT_passport_noChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="passport_noChildHALF_<?php echo $pr."_".$paxH;?>">
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
		                                                    <select name="LT_dob_yearChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $dobYear = date("Y");
		                                                        for( $xYear=date("Y")-12; $xYear<=$dobYear; $xYear++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_dob_monthChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_dob_dayChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $dobDay = 31;
		                                                        for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
		                                                    <select name="LT_nationalityChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
		                                                        <?php
		                                                        $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                        foreach( $nationalities AS $nationality ) {
		                                                            if( $nationality->nicename == "Singapore" ) {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                            else {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
		                                                    <select name="LT_passportIssueCountryChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
		                                                        <?php
		                                                        $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                        foreach( $nationalities AS $nationality ) {
		                                                            if( $nationality->nicename == "Singapore" ) {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                            else {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
		                                                    <select name="LT_passport_expiryYearChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $expiryYear = 2031;
		                                                        for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_passport_expiryMonthChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_passport_expiryDateChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $expiryDate = 31;
		                                                        for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
		                                                    <select name="LT_passport_issueYearChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $issueYear = date("Y");
		                                                        for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_passport_issueMonthChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_passport_issueDayChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $issueDate = 31;
		                                                        for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                            <div>
		                                                <ul class="info-li">
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
		                                                </ul>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
		                                            <textarea name="LT_passengerRemarks_ChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_ChildHALF_<?php echo $pr."_".$paxH;?>"></textarea>
		                                        </div>
		                                    </div>
		                                </div>
								    <?php
							        	}
							        }

							        if( $paxGetQty[3] > 0 ) {
							        	for( $paxD=1; $paxD<=$paxGetQty[3]; $paxD++ ) {
								    ?>
							        	<div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
		                                    <div class="form_div particular-form">
		                                        <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
		                                            <div>
		                                                <span style="color:green"><b>Infant <?php echo $ad ; ?> </b></span>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Title</div>
		                                            <div>
		                                                <select name="LT_titleInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:210px; height:37px" id="titleChildWOB_<?php echo $pr."_".$paxD;?>">
		                                                    <option value="">- Choose title -</option>
		                                                    <option value="Mr">Mr</option>
		                                                    <option value="Ms">Ms</option>
		                                                </select>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
		                                                    <input type="text" name="LT_givennameInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_givennameInfant_<?php echo $pr."_".$paxD;?>">
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
		                                                    <input type="text" name="LT_surnameInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameInfant_<?php echo $pr."_".$paxD;?>">
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                            <div>
		                                                <ul class="info-li">
		                                                    <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
		                                                </ul>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
		                                                    <input type="text" name="LT_passport_Infant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="passport_Infant_<?php echo $pr."_".$paxD;?>">
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
		                                                    <select name="LT_dob_yearInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $dobYear = 2005;
		                                                        for( $xYear=1920; $xYear<=$dobYear; $xYear++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_dob_monthInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_dob_dayInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $dobDay = 31;
		                                                        for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
		                                                    <select name="LT_nationalityInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
		                                                        <?php
		                                                        $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                        foreach( $nationalities AS $nationality ) {
		                                                            if( $nationality->nicename == "Singapore" ) {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                            else {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
		                                                    <select name="LT_passportIssueCountryInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:80%; height:37px">
		                                                        <?php
		                                                        $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                        foreach( $nationalities AS $nationality ) {
		                                                            if( $nationality->nicename == "Singapore" ) {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                            else {
		                                                        ?>
		                                                        <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                            <?php echo $nationality->nicename; ?>
		                                                        </option>
		                                                        <?php
		                                                            }
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                        </div>
		                                        <div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
		                                                    <select name="LT_passport_expiryYearInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $expiryYear = 2031;
		                                                        for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_passport_expiryMonthInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_passport_expiryDateInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $expiryDate = 31;
		                                                        for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="float:left; width:50%">
		                                                <div>
		                                                    <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
		                                                    <select name="LT_passport_issueYearInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Year -</option>
		                                                        <?php
		                                                        $issueYear = date("Y");
		                                                        for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                    <select name="LT_passport_issueMonthInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Month -</option>
		                                                        <option value="01">Jan</option>
		                                                        <option value="02">Feb</option>
		                                                        <option value="03">Mar</option>
		                                                        <option value="04">Apr</option>
		                                                        <option value="05">May</option>
		                                                        <option value="06">Jun</option>
		                                                        <option value="07">Jul</option>
		                                                        <option value="08">Aug</option>
		                                                        <option value="09">Sep</option>
		                                                        <option value="10">Oct</option>
		                                                        <option value="11">Nov</option>
		                                                        <option value="12">Dec</option>
		                                                    </select>
		                                                    <select name="LT_passport_issueDayInfant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" required style="width:75px; height:37px">
		                                                        <option value="">- Day -</option>
		                                                        <?php
		                                                        $issueDate = 31;
		                                                        for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
		                                                        ?>
		                                                        <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
		                                                        <?php
		                                                        }
		                                                        ?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div style="clear:both"></div>
		                                            <div>
		                                                <ul class="info-li">
		                                                    <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
		                                                </ul>
		                                            </div>
		                                        </div>
		                                        <div>
		                                            <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
		                                            <textarea name="LT_passengerRemarks_Infant[<?php echo $d+1; ?>00000<?php echo $pr; ?>00000<?php echo $cart->landtour_product_id; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_Infant_<?php echo $pr."_".$paxD;?>"></textarea>
		                                        </div>
		                                    </div>
		                                </div>
								    <?php
							        	}
							        }
							        ?>
						        	<div style="clear:both"></div>
                                </div>
                                <br />
							<?php
							}
							?>
				    	</div>
				    <?php
					}
					?>
			</div>
		</li>
		<?php
					$c++;
				}
			}
		}
		else {
		?>

		<?php
		}
		?>
	</ul>

<?php
}
else {
	/* NOT LOGIN */
?>
	<?php
	$totalGrandPrice = 0;
	$totalPaxPrice   = 0;
	$arrayLandtour   = $this->session->userdata('shoppingCartLandtourCookie');
	$arrayLandtourCount = count($arrayLandtour);
	if( $arrayLandtourCount > 0 ) {
	?>
		<h1>Confirmed Booking Order - Land Tour</h1>
		<ul class="room-types">
			<?php
			for($c=0; $c<$arrayLandtourCount; $c++) {
				$totalPaxAdult{$c}    = 0;
				$totalPaxChild{$c}    = 0;
				$totalPaxInfant{$c}   = 0;
				$totalPaxHalf{$c}     = 0;
				$totalTicketAdult{$c} = 0;
				$totalTicketChild{$c} = 0;
				$totalAllPaxPrice{$c} = 0;
				//get landtour title details
				$landtours = $this->All->select_template("id", $arrayLandtour[$c]["landtour_product_id"], "landtour_product");
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
				$others = $this->All->select_template(
					"id", $arrayLandtour[$c]["landtour_system_price_id"], "landtour_system_prices"
				);
				if( $others == TRUE ) {
					foreach( $others AS $other ) {
						$adultSingle_price 	= $other->adultSingle_price;
						$adultTwin_price   	= $other->adultTwin_price;
						$adultTriple_price 	= $other->adultTriple_price;
						$child_wb_price    	= $other->child_wb_price;
						$child_wob_price   	= $other->child_wob_price;
						$half_price 		= $other->child_half_twin_price;
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
			<li>
				<div class="meta" style="width:75%">
					<div class="tab">
						<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
							<tr class="days">
								<th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
									<div style="font-size:12px">
										<?php $ltImage = $this->All->getLandtourImage($arrayLandtour[$c]["landtour_product_id"]);?>
										<img src="<?php echo $ltImage ?>" width="150" height="115" />
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
										<?php echo date("d/m/Y", strtotime($arrayLandtour[$c]["selectedDate"])); ?>
									</div>
								</td>
								<td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
								</td>
							</tr>
							<tr>
								<td colspan="3" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
									<?php
									if( $arrayLandtour[$c]["sellingType"] == "ticket" ) {
										$ticketDetails = explode("~", $arrayLandtour[$c]["paxDetails"]);
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
											<?php echo $arrayLandtour[$c]["countRoom"]; ?> room(s)
										</div>
									<?php
									}
									?>
									<br />
								</td>
							</tr>
						</table>
						<?php
						if( $arrayLandtour[$c]["sellingType"] == "ticket" ) {
						?>
							<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="width:40%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
										<b>Description</b>
									</td>
									<td style="width:9%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:center">
										<b>Quantity</b>
									</td>
									<td colspan="2" style="width:20%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:right">
										<b>Unit Price</b>
									</td>
								</tr>
								<tr>
									<td class='time' colspan="4" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										Ticket Details
									</td>
								</tr>
								<?php $paxDetails = explode("~", $arrayLandtour[$c]["paxDetails"]); ?>
								<?php
								if( $paxDetails[0] > 0 ) {
									$totalTicketAdult{$c} += $paxDetails[0];
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
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
											$<?php echo number_format($ticketAdultPrice, 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<?php
								if( $paxDetails[1] > 0 ) {
									$totalTicketChild{$c} += $paxDetails[1];
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
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
											$<?php echo number_format($ticketChildPrice, 2); ?>
										</td>
									</tr>
								<?php
								}
								?>
								<tr>
									<td class='time' colspan="3" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										<b>Grand Total</b>
									</td>
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
										<?php
										$totalPaxPrice = ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
										$totalGrandPrice += ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
										$totalAllPaxPrice{$c} += ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
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
								<tr>
									<td style="width:40%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
										<b>Description</b>
									</td>
									<td style="width:9%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:center">
										<b>Quantity</b>
									</td>
									<td colspan="2" style="width:20%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:right">
										<b>Unit Price</b>
									</td>
								</tr>
								<?php
								$paxDetails = explode("~", $arrayLandtour[$c]["paxDetails"]);
								for($r=1; $r<=$arrayLandtour[$c]["countRoom"]; $r++) {
									$paxGetQty  = explode(".", $paxDetails[$r-1]);
								?>
									<tr>
										<td class='time' colspan="4" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											Room <?php echo $r; ?> Details
										</td>
									</tr>
									<?php
									if( $paxGetQty[0] > 0 ) {
										$totalPaxAdult{$c} += $paxGetQty[0];
										if( $paxGetQty[0] == 1 && $paxGetQty[4] == 1 ) { $adultPrice = $adultTwin_price; }
										else if( $paxGetQty[0] == 1 && $paxGetQty[1] == 1 ) { $adultPrice = $adultTwin_price; }
										else if( $paxGetQty[0] == 1 ) { $adultPrice = $adultSingle_price; }
										else if( $paxGetQty[0] == 2 ) { $adultPrice = $adultTwin_price; }
										else if( $paxGetQty[0] == 3 ) { $adultPrice = $adultTriple_price; }
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
											<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
												$<?php echo number_format($adultPrice, 2); ?>
											</td>
										</tr>
									<?php
									}
									?>
									<?php
									if( $paxGetQty[1] > 0 ) {
										$totalPaxChild{$c} += $paxGetQty[1];
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
											<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
												$<?php echo number_format($childWBPrice, 2); ?>
											</td>
										</tr>
									<?php
									}
									?>
									<?php
									if( $paxGetQty[2] > 0 ) {
										$totalPaxChild{$c} += $paxGetQty[2];
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
											<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
												$<?php echo number_format($child_wob_price, 2); ?>
											</td>
										</tr>
									<?php
									}
									?>
									<?php
									if( $paxGetQty[4] > 0 ) {
										$totalPaxHalf{$c} += $paxGetQty[4];
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
											<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
												$<?php echo number_format($half_price, 2); ?>
											</td>
										</tr>
									<?php
									}
									?>
									<?php
									if( $paxGetQty[3] > 0 ) {
										$totalPaxInfant{$c} += $paxGetQty[3];
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
											<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
												$<?php echo number_format($infant_price, 2); ?>
											</td>
										</tr>
									<?php
									}
									?>
									<tr>
										<td class='time' colspan="3" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
											<b>Grand Total</b>
										</td>
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
											<?php
											$totalPaxPrice = ($adultPrice*$paxGetQty[0])+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price)+($paxGetQty[4]*$half_price);
											$totalGrandPrice += ($adultPrice*$paxGetQty[0])+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price)+($paxGetQty[4]*$half_price);
											$totalAllPaxPrice{$c} += ($adultPrice*$paxGetQty[0])+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price)+($paxGetQty[4]*$half_price);
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
				<div class="room-information" style="height:112px; width:19%">
					<div class="tab">
						<?php
						if( $arrayLandtour[$c]["sellingType"] == "ticket" ) {
						?>
							<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>ADULT(S)</b>
											</div>
										</div>
									</td>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>0<?php echo $totalTicketAdult{$c}; ?></b>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>CHILD(S)</b>
											</div>
										</div>
									</td>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>0<?php echo $totalTicketChild{$c}; ?></b>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>PRICE:</b>
											</div>
										</div>
									</td>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>
													<?php
													$total_ltour_grand += $totalAllPaxPrice{$c};
													?>
												$<?php echo number_format($totalAllPaxPrice{$c}, 2); ?></b>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
								</tr>
							</table>
						<?php
						}
						else {
						?>
							<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>ADULT(S)</b>
											</div>
										</div>
									</td>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>0<?php echo $totalPaxAdult{$c}; ?></b>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>CHILD(S)</b>
											</div>
										</div>
									</td>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>0<?php echo $totalPaxChild{$c}+$totalPaxHalf{$c}; ?></b>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>INFANT(S)</b>
											</div>
										</div>
									</td>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>0<?php echo $totalPaxInfant{$c}; ?></b>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>PRICE:</b>
											</div>
										</div>
									</td>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
										<div style="font-size:12px">
											<div>
												<b>
													<?php
													$total_ltour_grand += $totalAllPaxPrice{$c};
													?>
												$<?php echo number_format($totalAllPaxPrice{$c}, 2); ?></b>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
									<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
								</tr>
							</table>
						<?php
						}
						?>
					</div>
				</div>
				<div style="clear:both"></div>
				<div style="margin-top:10px">
					<div class="age_type" style="font-size:14px">
						Please enter your passenger details and ensure the details matches your passport.
						<span style="text-transform: capitalize; color:red">
							<b>(* required field)</b>
						</span>
					</div>
					<?php
				    if( $arrayLandtour[$c]["sellingType"] == "ticket" ) {
					?>
						<div style="padding:10px">
							<div style="margin-top:8px"><b>Enter ticket Pax details</b></div>
							<?php
							$paxDetails    = explode("~", $arrayLandtour[$c]["paxDetails"]);
							$adultTicketNO = $paxDetails[0];
							$childTicketNO = $paxDetails[1];
							if( $adultTicketNO > 0 ) {
								for( $ad=1; $ad<=$adultTicketNO; $ad++ ) {
							?>
								<div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
                            		<div class="form_div particular-form">
                            			<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
		                                    <div>
		                                        <span style="color:green"><b>Adult <?php echo $ad ; ?> </b></span>
		                                    </div>
		                                </div>

		                                <div>
	                                    <div style="margin-top:10px; margin-bottom:5px">Title</div>
		                                    <div>
		                                        <select name="LT_TicketTitleAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:210px; height:37px" id="tickettitleAdult_<?php echo $ad;?>">
		                                            <option value="">- Choose title -</option>
		                                            <option value="Mr">Mr</option>
		                                            <option value="Ms">Ms</option>
		                                        </select>
		                                    </div>
		                                </div>
		                                <div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
		                                            <input type="text" name="LT_TicketgivennameAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_TicketgivennameAdult_<?php echo $ad;?>">
		                                        </div>
		                                    </div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
		                                            <input type="text" name="LT_TicketsurnameAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameAdult_<?php echo $ad;?>">
		                                        </div>
		                                    </div>
		                                    <div style="clear:both"></div>
		                                    <div>
		                                        <ul class="info-li">
		                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
		                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
		                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
		                                        </ul>
		                                    </div>
		                                </div>
		                                <div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
		                                            <input type="text" name="LT_Ticketpassport_noAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="Ticket_passport_noAdult_<?php echo $ad;?>">
		                                        </div>
		                                    </div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
		                                            <select name="LT_Ticket_dob_yearAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Year -</option>
		                                                <?php
		                                                $dobYear = 2005;
		                                                for( $xYear=1920; $xYear<=$dobYear; $xYear++ ) {
		                                                ?>
		                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                            <select name="LT_Ticket_dob_monthAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Month -</option>
		                                                <option value="01">Jan</option>
		                                                <option value="02">Feb</option>
		                                                <option value="03">Mar</option>
		                                                <option value="04">Apr</option>
		                                                <option value="05">May</option>
		                                                <option value="06">Jun</option>
		                                                <option value="07">Jul</option>
		                                                <option value="08">Aug</option>
		                                                <option value="09">Sep</option>
		                                                <option value="10">Oct</option>
		                                                <option value="11">Nov</option>
		                                                <option value="12">Dec</option>
		                                            </select>
		                                            <select name="LT_Ticket_dob_dayAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Day -</option>
		                                                <?php
		                                                $dobDay = 31;
		                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
		                                                ?>
		                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                    <div style="clear:both"></div>
		                                </div>
		                                <div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
		                                            <select name="LT_Ticket_nationalityAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
		                                                <?php
		                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                foreach( $nationalities AS $nationality ) {
		                                                    if( $nationality->nicename == "Singapore" ) {
		                                                ?>
		                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                    <?php echo $nationality->nicename; ?>
		                                                </option>
		                                                <?php
		                                                    }
		                                                    else {
		                                                ?>
		                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                    <?php echo $nationality->nicename; ?>
		                                                </option>
		                                                <?php
		                                                    }
		                                                }
		                                                ?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
		                                            <select name="LT_Ticket_passportIssueCountryAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
		                                                <?php
		                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                foreach( $nationalities AS $nationality ) {
		                                                    if( $nationality->nicename == "Singapore" ) {
		                                                ?>
		                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                    <?php echo $nationality->nicename; ?>
		                                                </option>
		                                                <?php
		                                                    }
		                                                    else {
		                                                ?>
		                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                    <?php echo $nationality->nicename; ?>
		                                                </option>
		                                                <?php
		                                                    }
		                                                }
		                                                ?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                    <div style="clear:both"></div>
		                                </div>
		                                <div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
		                                            <select name="LT_Ticket_passport_expiryYearAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Year -</option>
		                                                <?php
		                                                $expiryYear = 2031;
		                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
		                                                ?>
		                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                            <select name="LT_Ticket_passport_expiryMonthAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Month -</option>
		                                                <option value="01">Jan</option>
		                                                <option value="02">Feb</option>
		                                                <option value="03">Mar</option>
		                                                <option value="04">Apr</option>
		                                                <option value="05">May</option>
		                                                <option value="06">Jun</option>
		                                                <option value="07">Jul</option>
		                                                <option value="08">Aug</option>
		                                                <option value="09">Sep</option>
		                                                <option value="10">Oct</option>
		                                                <option value="11">Nov</option>
		                                                <option value="12">Dec</option>
		                                            </select>
		                                            <select name="LT_Ticket_passport_expiryDateAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Day -</option>
		                                                <?php
		                                                $expiryDate = 31;
		                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
		                                                ?>
		                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
		                                            <select name="LT_Ticket_passport_issueYearAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Year -</option>
		                                                <?php
		                                                $issueYear = date("Y");
		                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
		                                                ?>
		                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                            <select name="LT_Ticket_passport_issueMonthAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Month -</option>
		                                                <option value="01">Jan</option>
		                                                <option value="02">Feb</option>
		                                                <option value="03">Mar</option>
		                                                <option value="04">Apr</option>
		                                                <option value="05">May</option>
		                                                <option value="06">Jun</option>
		                                                <option value="07">Jul</option>
		                                                <option value="08">Aug</option>
		                                                <option value="09">Sep</option>
		                                                <option value="10">Oct</option>
		                                                <option value="11">Nov</option>
		                                                <option value="12">Dec</option>
		                                            </select>
		                                            <select name="LT_Ticket_passport_issueDayAdult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Day -</option>
		                                                <?php
		                                                $issueDate = 31;
		                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
		                                                ?>
		                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                    <div style="clear:both"></div>
		                                    <div>
		                                        <ul class="info-li">
		                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
		                                        </ul>
		                                    </div>
		                                </div>
		                                <div>
		                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
		                                    <textarea name="LT_Ticket_passengerRemarks_Adult[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_Adult_<?php echo $ad;?>"></textarea>
		                                </div>


                            		</div>
		                        </div>
							<?php
								}
							}
							if( $childTicketNO > 0 ) {
								for( $ch=1; $ch<=$childTicketNO; $ch++ ) {
							?>
								<div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
                            		<div class="form_div particular-form">
                            			<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
		                                    <div>
		                                        <span style="color:green"><b>Child <?php echo $ch ; ?></b></span>
		                                    </div>
		                                </div>

		                                <div>
	                                    	<div style="margin-top:10px; margin-bottom:5px">Title</div>
		                                    <div>
		                                        <select name="LT_Ticket_titleChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:210px; height:37px" id="ticket_titleChild_<?php echo $ch;?>">
		                                            <option value="">- Choose title -</option>
		                                            <option value="Mr">Mr</option>
		                                            <option value="Ms">Ms</option>
		                                        </select>
		                                    </div>
		                                </div>
		                                <div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
		                                            <input type="text" name="LT_Ticket_givennameChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_Ticket_givennameChild_<?php echo $ch;?>">
		                                        </div>
		                                    </div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
		                                            <input type="text" name="LT_Ticket_surnameChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_Ticket_surnameChild_<?php echo $ch;?>">
		                                        </div>
		                                    </div>
		                                    <div style="clear:both"></div>
		                                    <div>
		                                        <ul class="info-li">
		                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
		                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
		                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
		                                        </ul>
		                                    </div>
		                                </div>
		                                <div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
		                                            <input type="text" name="LT_Ticket_passport_noChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="Ticket_passport_noChild_<?php echo $ch;?>">
		                                        </div>
		                                    </div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
		                                            <select name="LT_Ticket_dob_yearChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Year -</option>
		                                                <?php
		                                                $dobYear = 2005;
		                                                for( $xYear=1920; $xYear<=$dobYear; $xYear++ ) {
		                                                ?>
		                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                            <select name="LT_Ticket_dob_monthChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Month -</option>
		                                                <option value="01">Jan</option>
		                                                <option value="02">Feb</option>
		                                                <option value="03">Mar</option>
		                                                <option value="04">Apr</option>
		                                                <option value="05">May</option>
		                                                <option value="06">Jun</option>
		                                                <option value="07">Jul</option>
		                                                <option value="08">Aug</option>
		                                                <option value="09">Sep</option>
		                                                <option value="10">Oct</option>
		                                                <option value="11">Nov</option>
		                                                <option value="12">Dec</option>
		                                            </select>
		                                            <select name="LT_Ticket_dob_dayChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Day -</option>
		                                                <?php
		                                                $dobDay = 31;
		                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
		                                                ?>
		                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                    <div style="clear:both"></div>
		                                </div>
		                                <div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
		                                            <select name="LT_Ticket_nationalityChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
		                                                <?php
		                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                foreach( $nationalities AS $nationality ) {
		                                                    if( $nationality->nicename == "Singapore" ) {
		                                                ?>
		                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                    <?php echo $nationality->nicename; ?>
		                                                </option>
		                                                <?php
		                                                    }
		                                                    else {
		                                                ?>
		                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                    <?php echo $nationality->nicename; ?>
		                                                </option>
		                                                <?php
		                                                    }
		                                                }
		                                                ?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
		                                            <select name="LT_Ticket_passportIssueCountryChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
		                                                <?php
		                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
		                                                foreach( $nationalities AS $nationality ) {
		                                                    if( $nationality->nicename == "Singapore" ) {
		                                                ?>
		                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
		                                                    <?php echo $nationality->nicename; ?>
		                                                </option>
		                                                <?php
		                                                    }
		                                                    else {
		                                                ?>
		                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
		                                                    <?php echo $nationality->nicename; ?>
		                                                </option>
		                                                <?php
		                                                    }
		                                                }
		                                                ?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                    <div style="clear:both"></div>
		                                </div>
		                                <div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
		                                            <select name="LT_Ticket_passport_expiryYearChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Year -</option>
		                                                <?php
		                                                $expiryYear = 2031;
		                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
		                                                ?>
		                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                            <select name="LT_Ticket_passport_expiryMonthChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Month -</option>
		                                                <option value="01">Jan</option>
		                                                <option value="02">Feb</option>
		                                                <option value="03">Mar</option>
		                                                <option value="04">Apr</option>
		                                                <option value="05">May</option>
		                                                <option value="06">Jun</option>
		                                                <option value="07">Jul</option>
		                                                <option value="08">Aug</option>
		                                                <option value="09">Sep</option>
		                                                <option value="10">Oct</option>
		                                                <option value="11">Nov</option>
		                                                <option value="12">Dec</option>
		                                            </select>
		                                            <select name="LT_Ticket_passport_expiryDateChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Day -</option>
		                                                <?php
		                                                $expiryDate = 31;
		                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
		                                                ?>
		                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                    <div style="float:left; width:50%">
		                                        <div>
		                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
		                                            <select name="LT_Ticket_passport_issueYearChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Year -</option>
		                                                <?php
		                                                $issueYear = date("Y");
		                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
		                                                ?>
		                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                            <select name="LT_Ticket_passport_issueMonthChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Month -</option>
		                                                <option value="01">Jan</option>
		                                                <option value="02">Feb</option>
		                                                <option value="03">Mar</option>
		                                                <option value="04">Apr</option>
		                                                <option value="05">May</option>
		                                                <option value="06">Jun</option>
		                                                <option value="07">Jul</option>
		                                                <option value="08">Aug</option>
		                                                <option value="09">Sep</option>
		                                                <option value="10">Oct</option>
		                                                <option value="11">Nov</option>
		                                                <option value="12">Dec</option>
		                                            </select>
		                                            <select name="LT_Ticket_passport_issueDayChild[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
		                                                <option value="">- Day -</option>
		                                                <?php
		                                                $issueDate = 31;
		                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
		                                                ?>
		                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
		                                                <?php
		                                                }
		                                                ?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                    <div style="clear:both"></div>
		                                    <div>
		                                        <ul class="info-li">
		                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
		                                        </ul>
		                                    </div>
		                                </div>
		                                <div>
		                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
		                                    <textarea name="LT_Ticket_passengerRemarks_Child[<?php echo $c+1; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="Ticket_passengerRemarks_Child_<?php echo $ch;?>"></textarea>
		                                </div>


                            		</div>
                            	</div>
							<?php
								}
							}
							?>
							<div style="clear:both"></div>
						</div>
					<?php
					}
					else {
				    ?>
				    	<div style="padding:10px">
					    	<?php
							$paxDetails = explode("~", $arrayLandtour[$c]["paxDetails"]);
							for($pr=1; $pr<=$arrayLandtour[$c]["countRoom"]; $pr++) {
								$paxGetQty  = explode(".", $paxDetails[$pr-1]);
							?>
								<div style="margin-bottom:10px; font-size: 14px">
						        	<div style="margin-bottom:10px"><span><b>Room  <?php echo $pr; ?> Passenger Details*</b></span></div>
						        	<?php
							        if( $paxGetQty[0] > 0 ) {
							        	for( $paxA=1; $paxA<=$paxGetQty[0]; $paxA++ ) {
								    ?>
									    <div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
		                            		<div class="form_div particular-form">
		                            			<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
				                                    <div>
				                                        <span style="color:green"><b>Adult <?php echo $paxA ; ?> </b></span>
				                                    </div>
				                                </div>

				                                <div>
			                                    <div style="margin-top:10px; margin-bottom:5px">Title</div>
				                                    <div>
				                                        <select name="LT_titleAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:210px; height:37px" id="titleAdult_<?php echo $pr."_".$paxA;?>">
				                                            <option value="">- Choose title -</option>
				                                            <option value="Mr">Mr</option>
				                                            <option value="Ms">Ms</option>
				                                        </select>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
				                                            <input type="text" name="LT_givennameAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_givennameAdult_<?php echo $pr."_".$paxA;?>">
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
				                                            <input type="text" name="LT_surnameAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameAdult_<?php echo $pr."_".$paxA;?>">
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                    <div>
				                                        <ul class="info-li">
				                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
				                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
				                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
				                                        </ul>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
				                                            <input type="text" name="LT_passport_noAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="passport_noAdult_<?php echo $pr."_".$paxA;?>">
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
				                                            <select name="LT_dob_yearAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $dobYear = 2005;
				                                                for( $xYear=1920; $xYear<=$dobYear; $xYear++ ) {
				                                                ?>
				                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_dob_monthAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_dob_dayAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $dobDay = 31;
				                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
				                                                ?>
				                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
				                                            <select name="LT_nationalityAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
				                                                <?php
				                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
				                                                foreach( $nationalities AS $nationality ) {
				                                                    if( $nationality->nicename == "Singapore" ) {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                    else {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
				                                            <select name="LT_passportIssueCountryAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
				                                                <?php
				                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
				                                                foreach( $nationalities AS $nationality ) {
				                                                    if( $nationality->nicename == "Singapore" ) {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                    else {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
				                                            <select name="LT_passport_expiryYearAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $expiryYear = 2031;
				                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
				                                                ?>
				                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_passport_expiryMonthAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_passport_expiryDateAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $expiryDate = 31;
				                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
				                                                ?>
				                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
				                                            <select name="LT_passport_issueYearAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $issueYear = date("Y");
				                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
				                                                ?>
				                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_passport_issueMonthAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_passport_issueDayAdult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $issueDate = 31;
				                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
				                                                ?>
				                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                    <div>
				                                        <ul class="info-li">
				                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
				                                        </ul>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
				                                    <textarea name="LT_passengerRemarks_Adult[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_Adult_<?php echo $pr."_".$paxA;?>"></textarea>
				                                </div>


		                            		</div>
		                            	</div>
								    <?php
							        	}
							        }

							        if( $paxGetQty[1] > 0 ) {
							        	for( $paxB=1; $paxB <=$paxGetQty[1]; $paxB++ ) {
								    ?>
							        	<div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
		                            		<div class="form_div particular-form">
		                            			<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
				                                    <div>
				                                        <span style="color:green"><b>Child <?php echo $paxB ; ?> (with Bed)</b></span>
				                                    </div>
				                                </div>

				                                <div>
			                                    	<div style="margin-top:10px; margin-bottom:5px">Title</div>
				                                    <div>
				                                        <select name="LT_titleChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:210px; height:37px" id="titleChildWB_<?php echo $pr."_".$paxB;?>">
				                                            <option value="">- Choose title -</option>
				                                            <option value="MSTR">Master</option>
															<option value="Miss">Miss</option>
				                                        </select>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
				                                            <input type="text" name="LT_givennameChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_givennameChildWB_<?php echo $pr."_".$paxB;?>">
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
				                                            <input type="text" name="LT_surnameChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameChildWB_<?php echo $pr."_".$paxB;?>">
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                    <div>
				                                        <ul class="info-li">
				                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
				                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
				                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
				                                        </ul>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
				                                            <input type="text" name="LT_passport_noChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="passport_noChildWB_<?php echo $pr."_".$paxB;?>">
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
				                                            <select name="LT_dob_yearChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $dobYear = date("Y");
				                                                for( $xYear=date("Y")-12; $xYear<=$dobYear; $xYear++ ) {
				                                                ?>
				                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_dob_monthChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_dob_dayChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $dobDay = 31;
				                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
				                                                ?>
				                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
				                                            <select name="LT_nationalityChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
				                                                <?php
				                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
				                                                foreach( $nationalities AS $nationality ) {
				                                                    if( $nationality->nicename == "Singapore" ) {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                    else {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
				                                            <select name="LT_passportIssueCountryChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
				                                                <?php
				                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
				                                                foreach( $nationalities AS $nationality ) {
				                                                    if( $nationality->nicename == "Singapore" ) {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                    else {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
				                                            <select name="LT_passport_expiryYearChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $expiryYear = 2031;
				                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
				                                                ?>
				                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_passport_expiryMonthChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_passport_expiryDateChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $expiryDate = 31;
				                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
				                                                ?>
				                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
				                                            <select name="LT_passport_issueYearChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $issueYear = date("Y");
				                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
				                                                ?>
				                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_passport_issueMonthChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_passport_issueDayChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $issueDate = 31;
				                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
				                                                ?>
				                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                    <div>
				                                        <ul class="info-li">
				                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
				                                        </ul>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
				                                    <textarea name="LT_passengerRemarks_ChildWB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_WB_<?php echo $pr."_".$paxB;?>"></textarea>
				                                </div>
		                            		</div>
		                            	</div>
								    <?php
							        	}
							        }
							        ?>
							        <?php
							        if( $paxGetQty[2] > 0 ) {
							        	for( $paxC=1; $paxC<=$paxGetQty[2]; $paxC++ ) {
								    ?>
									    <div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
									    	<div class="form_div particular-form">
										    	<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
				                                    <div>
				                                        <span style="color:green"><b>Child <?php echo $pr; ?> (Without Bed)</b></span>
				                                    </div>
				                                </div>
											    <div>
			                                    	<div style="margin-top:10px; margin-bottom:5px">Title</div>
				                                    <div>
				                                        <select name="LT_titleChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:210px; height:37px" id="titleChildWOB_<?php echo $pr."_".$paxC;?>">
				                                            <option value="">- Choose title -</option>
				                                            <option value="MSTR">Master</option>
															<option value="Miss">Miss</option>
				                                        </select>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
				                                            <input type="text" name="LT_givennameChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_givennameChildWOB_<?php echo $pr."_".$paxC;?>">
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
				                                            <input type="text" name="LT_surnameChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameChildWOB_<?php echo $pr."_".$paxC;?>">
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                    <div>
				                                        <ul class="info-li">
				                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
				                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
				                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
				                                        </ul>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
				                                            <input type="text" name="LT_passport_noChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="passport_noChildWOB_<?php echo $pr."_".$paxC;?>">
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
				                                            <select name="LT_dob_yearChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $dobYear = date("Y");
				                                                for( $xYear=date("Y")-12; $xYear<=$dobYear; $xYear++ ) {
				                                                ?>
				                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_dob_monthChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_dob_dayChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $dobDay = 31;
				                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
				                                                ?>
				                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
				                                            <select name="LT_nationalityChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
				                                                <?php
				                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
				                                                foreach( $nationalities AS $nationality ) {
				                                                    if( $nationality->nicename == "Singapore" ) {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                    else {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
				                                            <select name="LT_passportIssueCountryChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
				                                                <?php
				                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
				                                                foreach( $nationalities AS $nationality ) {
				                                                    if( $nationality->nicename == "Singapore" ) {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                    else {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
				                                            <select name="LT_passport_expiryYearChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $expiryYear = 2031;
				                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
				                                                ?>
				                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_passport_expiryMonthChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_passport_expiryDateChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $expiryDate = 31;
				                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
				                                                ?>
				                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
				                                            <select name="LT_passport_issueYearChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $issueYear = date("Y");
				                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
				                                                ?>
				                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_passport_issueMonthChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_passport_issueDayChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $issueDate = 31;
				                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
				                                                ?>
				                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                    <div>
				                                        <ul class="info-li">
				                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
				                                        </ul>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
				                                    <textarea name="LT_passengerRemarks_ChildWOB[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_ChildWOB_<?php echo $pr."_".$paxC;?>"></textarea>
				                                </div>
				                            </div>
			                            </div>
								    <?php
							        	}
							        }
							        ?>
							        <?php
							        if( $paxGetQty[4] > 0 ) {
							        	for( $paxH=1; $paxH<=$paxGetQty[4]; $paxH++ ) {
								    ?>
									    <div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
									    	<div class="form_div particular-form">
										    	<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
				                                    <div>
				                                    	<span style="color:green"><b>Child <?php echo $paxH ; ?> (Half Twin Bed)</b></span>
				                                    </div>
					                            </div>
									        	<div>
			                                    	<div style="margin-top:10px; margin-bottom:5px">Title</div>
				                                    <div>
				                                        <select name="LT_titleChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:210px; height:37px" id="titleChildHALF_<?php echo $pr."_".$paxH;?>">
				                                            <option value="">- Choose title -</option>
				                                            <option value="MSTR">Master</option>
															<option value="Miss">Miss</option>
				                                        </select>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
				                                            <input type="text" name="LT_givennameChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_givennameChildHALF_<?php echo $pr."_".$paxH;?>">
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
				                                            <input type="text" name="LT_surnameChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameChildHALF_<?php echo $pr."_".$paxH;?>">
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                    <div>
				                                        <ul class="info-li">
				                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
				                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
				                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
				                                        </ul>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
				                                            <input type="text" name="LT_passport_noChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="passport_noChildHALF_<?php echo $pr."_".$paxH;?>">
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
				                                            <select name="LT_dob_yearChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $dobYear = date("Y");
				                                                for( $xYear=date("Y")-12; $xYear<=$dobYear; $xYear++ ) {
				                                                ?>
				                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_dob_monthChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_dob_dayChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $dobDay = 31;
				                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
				                                                ?>
				                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
				                                            <select name="LT_nationalityChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
				                                                <?php
				                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
				                                                foreach( $nationalities AS $nationality ) {
				                                                    if( $nationality->nicename == "Singapore" ) {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                    else {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
				                                            <select name="LT_passportIssueCountryChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
				                                                <?php
				                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
				                                                foreach( $nationalities AS $nationality ) {
				                                                    if( $nationality->nicename == "Singapore" ) {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                    else {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
				                                            <select name="LT_passport_expiryYearChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $expiryYear = 2031;
				                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
				                                                ?>
				                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_passport_expiryMonthChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_passport_expiryDateChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $expiryDate = 31;
				                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
				                                                ?>
				                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
				                                            <select name="LT_passport_issueYearChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $issueYear = date("Y");
				                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
				                                                ?>
				                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_passport_issueMonthChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_passport_issueDayChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $issueDate = 31;
				                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
				                                                ?>
				                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                    <div>
				                                        <ul class="info-li">
				                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
				                                        </ul>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
				                                    <textarea name="LT_passengerRemarks_ChildHALF[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_ChildHALF_<?php echo $pr."_".$paxH;?>"></textarea>
				                                </div>
					                        </div>
				                        </div>
								    <?php
							        	}
							        }
							        ?>
							        <?php
							        if( $paxGetQty[3] > 0 ) {
							        	for( $paxD=1; $paxD<=$paxGetQty[3]; $paxD++ ) {
								    ?>
									    <div class="tab_container" style="font-size:14px; float:left; width:46%; margin-right:20px">
									    	<div class="form_div particular-form">
										    	<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
				                                    <div>
				                                        <span style="color:green"><b>Infant <?php echo $ad ; ?> </b></span>
				                                    </div>
				                                </div>
									        	<div>
			                                    	<div style="margin-top:10px; margin-bottom:5px">Title</div>
				                                    <div>
				                                        <select name="LT_titleInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:210px; height:37px" id="titleChildWOB_<?php echo $pr."_".$paxD;?>">
				                                            <option value="">- Choose title -</option>
				                                            <option value="Mr">Mr</option>
				                                            <option value="Ms">Ms</option>
				                                        </select>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
				                                            <input type="text" name="LT_givennameInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Given Name" id="LT_givennameInfant_<?php echo $pr."_".$paxD;?>">
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
				                                            <input type="text" name="LT_surnameInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="Surname" id="LT_surnameInfant_<?php echo $pr."_".$paxD;?>">
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                    <div>
				                                        <ul class="info-li">
				                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
				                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the orders are issued.</li>
				                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
				                                        </ul>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
				                                            <input type="text" name="LT_passport_Infant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6" id="passport_Infant_<?php echo $pr."_".$paxD;?>">
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
				                                            <select name="LT_dob_yearInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $dobYear = 2005;
				                                                for( $xYear=1920; $xYear<=$dobYear; $xYear++ ) {
				                                                ?>
				                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_dob_monthInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_dob_dayInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $dobDay = 31;
				                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
				                                                ?>
				                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
				                                            <select name="LT_nationalityInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
				                                                <?php
				                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
				                                                foreach( $nationalities AS $nationality ) {
				                                                    if( $nationality->nicename == "Singapore" ) {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                    else {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
				                                            <select name="LT_passportIssueCountryInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:80%; height:37px">
				                                                <?php
				                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
				                                                foreach( $nationalities AS $nationality ) {
				                                                    if( $nationality->nicename == "Singapore" ) {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                    else {
				                                                ?>
				                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
				                                                    <?php echo $nationality->nicename; ?>
				                                                </option>
				                                                <?php
				                                                    }
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                </div>
				                                <div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
				                                            <select name="LT_passport_expiryYearInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $expiryYear = 2031;
				                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
				                                                ?>
				                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_passport_expiryMonthInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_passport_expiryDateInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $expiryDate = 31;
				                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
				                                                ?>
				                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="float:left; width:50%">
				                                        <div>
				                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
				                                            <select name="LT_passport_issueYearInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Year -</option>
				                                                <?php
				                                                $issueYear = date("Y");
				                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
				                                                ?>
				                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                            <select name="LT_passport_issueMonthInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Month -</option>
				                                                <option value="01">Jan</option>
				                                                <option value="02">Feb</option>
				                                                <option value="03">Mar</option>
				                                                <option value="04">Apr</option>
				                                                <option value="05">May</option>
				                                                <option value="06">Jun</option>
				                                                <option value="07">Jul</option>
				                                                <option value="08">Aug</option>
				                                                <option value="09">Sep</option>
				                                                <option value="10">Oct</option>
				                                                <option value="11">Nov</option>
				                                                <option value="12">Dec</option>
				                                            </select>
				                                            <select name="LT_passport_issueDayInfant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" required style="width:75px; height:37px">
				                                                <option value="">- Day -</option>
				                                                <?php
				                                                $issueDate = 31;
				                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
				                                                ?>
				                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
				                                                <?php
				                                                }
				                                                ?>
				                                            </select>
				                                        </div>
				                                    </div>
				                                    <div style="clear:both"></div>
				                                    <div>
				                                        <ul class="info-li">
				                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
				                                        </ul>
				                                    </div>
				                                </div>
				                                <div>
				                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
				                                    <textarea name="LT_passengerRemarks_Infant[<?php echo $c+1; ?>00000<?php echo $pr; ?>00000<?php echo $arrayLandtour[$c]["landtour_product_id"]; ?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_Infant_<?php echo $pr."_".$paxD;?>"></textarea>
				                                </div>
				                            </div>
			                            </div>
								    <?php
							        	}
							        }
							        ?>
						    		<div style="clear:both"></div>
						    	</div>
					        	<br />
							<?php
							}
							?>
				    	</div>
				    <?php
					}
					?>
            		<br />
				</div>
			</li>
	<?php
			}
			echo '</ul>';
		}
	?>
<?php
}
?>
<!--END OF LAND TOUR CONFIRMATION-->