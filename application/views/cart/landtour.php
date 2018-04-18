<section id="landtour_cart" class="tab-content">
	<article>
		<h1>Land Tour Cart List</h1>
		<ul class="room-types">
			<?php
			$landtourFinalPrice = 0;
			$childWBPrice = "";
			if( $this->session->userdata('normal_session_id') == TRUE ) {
				$totalGrandPrice = 0;
				$totalPaxPrice   = 0;
				$carts = $this->All->select_template_with_where_and_order(
					"user_access_id", $this->session->userdata('normal_session_id'), "id", "ASC", "landtour_cart"
				);
				if( $carts == TRUE ) {
					foreach( $carts AS $cart ) {
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
								$half_price   		= $other->child_half_twin_price;
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
			<div class="tab">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr class="days">
						<th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
							<div style="font-size:12px">
								<img src="<?php echo $this->All->getLandtourImage($cart->landtour_product_id); ?>" alt="" width="150" height="115" />
							</div>
							<br />
							<div style="text-align:center">
								<a href="<?php echo base_url(); ?>cart/landtour_remove_item_cart/<?php echo $cart->id; ?>" class="gradient-button" title="Remove" style="position:static">
									Remove
								</a>
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
						<td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
							<?php
							if( $cart->sellingType == "ticket" ) {
								$ticketDetails = explode("~", $cart->paxDetails);
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
									<?php echo $cart->countRoom; ?> room(s)
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
						<?php $paxDetails = explode("~", $cart->paxDetails); ?>
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
									$<?php echo number_format($ticketAdultPrice, 2); ?>
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
							<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
								<?php
								$totalPaxPrice 	  = ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
								$totalGrandPrice += ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
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
									<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
										$<?php echo number_format($adultPrice, 2); ?>
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
										$<?php echo number_format($childWBPrice, 2); ?>
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
										$<?php echo number_format($child_wob_price, 2); ?>
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
										$<?php echo number_format($half_price, 2); ?>
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
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
									<?php
									$totalPaxPrice = ($adultPrice*$paxGetQty[0])+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price);
									$totalGrandPrice += ($adultPrice*$paxGetQty[0])+($paxGetQty[1]*$childWBPrice)+($paxGetQty[2]*$child_wob_price)+($paxGetQty[3]*$infant_price);
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
			<br /><br />
			<?php
					}
				}
				else {
			?>
				<article class="full-width">
					<div style="text-align:center; color:red; font-size:16px">
						No land tour item found on your cart.
					</div>
				</article>
			<?php
				}
			}
			else {
				$totalGrandPrice = 0;
				$totalPaxPrice   = 0;
				$arrayLandtour = $this->session->userdata('shoppingCartLandtourCookie');
				//echo "<pre>";
				//print_r($arrayLandtour);
				//echo "</pre>";
				$arrayLandtourCount = count($arrayLandtour);
				if( $arrayLandtourCount > 0 ) {
					for($c=0; $c<$arrayLandtourCount; $c++) {
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
				<div class="tab">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr class="days">
							<th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
								<div style="font-size:12px">
									<img src="<?php echo $this->All->getLandtourImage($arrayLandtour[$c]["landtour_product_id"]); ?>" alt="" width="150" height="115" />
								</div>
								<br />
								<div style="text-align:center">
									<a href="<?php echo base_url(); ?>cart/landtour_remove_item_cart_session/<?php echo $c; ?>" class="gradient-button" title="Remove" style="position:static">
										Remove
									</a>
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
							<td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
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
							<?php $paxDetails = explode("~", $arrayLandtour[$c]["paxDetails"]); ?>
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
										$<?php echo number_format($ticketAdultPrice, 2); ?>
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
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
									<?php
									$totalPaxPrice 	  = ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
									$totalGrandPrice += ($ticketAdultPrice*$paxDetails[0])+($ticketChildPrice*$paxDetails[1]);
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
										<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
											$<?php echo number_format($adultPrice, 2); ?>
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
											$<?php echo number_format($childWBPrice, 2); ?>
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
											$<?php echo number_format($child_wob_price, 2); ?>
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
											$<?php echo number_format($half_price, 2); ?>
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
				<br /><br />
			<?php
					}
				}
				else {
			?>
				<article class="full-width">
					<div style="text-align:center; color:red; font-size:16px">
						No land tour item found on your cart.
					</div>
				</article>
			<?php
				}
			}
			?>
		</ul>
	</article>
</section>