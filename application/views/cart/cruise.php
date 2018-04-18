<section id="cruises_cart" class="tab-content">
	<article>
		<h1>Cruise cart list</h1>
		<?php echo $this->session->flashdata('updateCruiseCart'); ?>
		<?php echo $this->session->flashdata('removeCruiseCart'); ?>
		<ul class="room-types">
			<?php
			$cruiseFinalPrice = 0;
			if( $this->session->userdata('normal_session_id') == TRUE ) {
				$cartCruises = $this->All->select_template(
					"user_access_id", $this->session->userdata('normal_session_id'), "cruise_cart"
				);
				if( $cartCruises == TRUE ) {
					foreach( $cartCruises AS $cartCruise ) {
						//get cruise title details
						$cruiseTitles = $this->All->select_template("ID", $cartCruise->cruiseTitleID, "cruise_title");
						foreach( $cruiseTitles AS $cruiseTitle ) {
							$cruiseTitlePrint = $cruiseTitle->CRUISE_TITLE;
						}
						//end of get cruise title details
			?>
			<!--NEW DESIGN-->
			<div class="tab">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr class="days">
						<th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
							<div style="font-size:12px">
								<img src="<?php echo $this->All->getCruiseImage($cartCruise->cruiseTitleID); ?>" alt="" width="150" height="115" />
							</div>
							<br />
							<div style="text-align:center">
								<a href="<?php echo base_url(); ?>cart/cruise_remove_item_cart/<?php echo base64_encode(base64_encode(base64_encode($cartCruise->id))); ?>" class="gradient-button" title="Remove" style="position:static">
									Remove
								</a>
							</div>
						</th>
					</tr>
					<tr>
						<td colspan="3" style="text-align:left; padding-bottom:0px">
							<div style="font-size:15px">
								<h5>Cruise title</h5>
								<?php echo $cruiseTitlePrint; ?> 
								(<?php echo $this->All->getCruiseTitleTourCode($cartCruise->cruiseTitleID); ?>)
							</div>
						</td>
					</tr>
					<tr>
						<td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
							<div style="font-size:15px">
								<h5>Departure date</h5>
								<?php echo date("l, d F Y", strtotime($cartCruise->cruiseDate)); ?>
							</div>
						</td>
						<td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
							<div style="font-size:15px">
								<h5>Cruise length</h5>
								<?php echo $cartCruise->durationNight; ?> NIGHT(S)
							</div>
						</td>
					</tr>
					<tr>		
						<td colspan="3">
							<div style="font-size:15px">
								<h5>Stateroom</h5>
								<?php echo $this->All->getStateroomDetails($cartCruise->stateroomID); ?>
							</div>
						</td>
					</tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr class='days'>
						<th width="50%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
							<b>Item details</b>
						</th>
						<th width="20%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px">
							<b>Quantity</b>
						</th>
						<th colspan="2" width="45%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align: right">
							<b>Unit Price ($)</b>
						</th>
					</tr>
					<!--ADULT-->
					<?php
					if( $cartCruise->noofAdult != 0 ) {
					?>
					<tr>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							Pax purchased: <?php echo $cartCruise->noofAdult; ?> Adult(s)
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
							1
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">&nbsp;</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							<?php
							$adultCartPrice = number_format($this->All->getIndividualPriceBasedAdult($cartCruise->stateroomID, $cartCruise->shipID, $cartCruise->brandID, $cartCruise->durationNight, $cartCruise->cruisePriceType, $cartCruise->noofAdult, $cartCruise->noofChild), 2);
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
					if( $cartCruise->noofChild != 0 ) {
					?>
					<tr>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							Pax purchased: <?php echo $cartCruise->noofChild; ?> Child(s)
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
							1
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">&nbsp;</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							<?php
							$childCartPrice = number_format($this->All->getIndividualPriceBasedChild($cartCruise->stateroomID, $cartCruise->shipID, $cartCruise->brandID, $cartCruise->durationNight, $cartCruise->cruisePriceType, $cartCruise->noofAdult, $cartCruise->noofChild), 2);
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
					}
					?>
					<!--END OF CHILD-->
					<!--EXTRA CHARGES-->
					<?php
					if( $cartCruise->extraIDs != "" && $cartCruise->extraIDs != "-" ) {
						$qtyCharge = $cartCruise->noofAdult+$cartCruise->noofChild;
						$extraT = $this->All->getSumExtraPrices($cartCruise->extraIDs);
						$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
						$extraCharges_res = mysqli_query(
							$connection, "SELECT * FROM cruise_extra_price WHERE id IN(".$cartCruise->extraIDs.")"
						);
						if( mysqli_num_rows($extraCharges_res) > 0 ) {
							while( $extraCharges_row = mysqli_fetch_array($extraCharges_res, MYSQL_ASSOC) ) {
								$cruiseExtra += $extraCharges_row["extra_price_value"];
					?>
					<tr>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							Extra: <?php echo $extraCharges_row["extra_price_name"]; ?>
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
							<?php echo $qtyCharge; ?>
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">&nbsp;</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							<?php echo number_format($extraCharges_row["extra_price_value"]*$qtyCharge, 2); ?>
						</td>
					</tr>
					<?php
							}
						}
					}
					else {
						$extraT = 0;
					}
					?>
					<!--END OF EXTRA CHARGES-->
					<tr>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							&nbsp;
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
							<b>Total price</b>
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
							&nbsp;
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							<b>
								<?php
									$adultT = str_replace(",", "", $adultCartPrice);
									$childT = str_replace(",", "", $childCartPrice);
									echo number_format($adultT+$childT+$extraT, 2);
								?>
							</b>
						</td>
					</tr>
				</table>
			</div>
			<br /><br />
			<!--END OF NEW DESIGN-->
			<?php
						$total_cruise_grand += $cartCruise->cruisePrice;
					}
				}
				else {
			?>
				<article class="full-width">
					<div style="text-align:center; color:red; font-size:16px">
						No cruise item found on your cart.
					</div>
				</article>
			<?php
				}
			}
			else {
				$arrayCruise = $this->session->userdata('shoppingCartCruiseCookie');
				$arrayCruiseCount = count($arrayCruise);
				if( $arrayCruiseCount > 0 ) {
					for($c=0; $c<$arrayCruiseCount; $c++) {
						//get cruise title details
						$cruiseTitles = $this->All->select_template("ID", $arrayCruise[$c]["cruiseTitleID"], "cruise_title");
						foreach( $cruiseTitles AS $cruiseTitle ) {
							$cruiseTitlePrint = $cruiseTitle->CRUISE_TITLE;
						}
						//end of get cruise title details
			?>
			<!--NEW DESIGN-->
			<div class="tab">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr class="days">
						<th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
							<div style="font-size:12px">
								<img src="<?php echo $this->All->getCruiseImage($arrayCruise[$c]["cruiseTitleID"]); ?>" alt="" width="150" height="115" />
								<br />
								<div style="text-align:center">
									<a href="<?php echo base_url(); ?>cart/cruise_remove_item_cart_session/<?php echo base64_encode(base64_encode(base64_encode($c))); ?>" class="gradient-button" title="Remove" style="position:static">
										Remove
									</a>
								</div>
								<div style="clear:both"></div>
							</div>
						</th>
					</tr>
					<tr>
						<td colspan="3" style="text-align:left; padding-bottom:0px">
							<div style="font-size:15px">
								<h5>Cruise title</h5>
								<?php echo $cruiseTitlePrint; ?> 
								(<?php echo $this->All->getCruiseTitleTourCode($arrayCruise[$c]["cruiseTitleID"]); ?>)
							</div>
						</td>
					</tr>
					<tr>
						<td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
							<div style="font-size:15px">
								<h5>Departure date</h5>
								<?php echo date("l, d F Y", strtotime($arrayCruise[$c]["cruiseDate"])); ?>
							</div>
						</td>
						<td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
							<div style="font-size:15px">
								<h5>Cruise length</h5>
								<?php echo $arrayCruise[$c]["durationNight"]; ?> NIGHT(S)
							</div>
						</td>
					</tr>
					<tr>	
						<td colspan="3">
							<div style="font-size:15px">
								<h5>Stateroom</h5>
								<?php echo $this->All->getStateroomDetails($arrayCruise[$c]["stateroomID"]); ?>
							</div>
						</td>
					</tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr class='days'>
						<th width="50%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
							<b>Item details</b>
						</th>
						<th width="20%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px">
							<b>Quantity</b>
						</th>
						<th colspan="2" width="45%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align: right">
							<b>Unit Price ($)</b>
						</th>
					</tr>
					<!--ADULT-->
					<?php
					if( $arrayCruise[$c]["noofAdult"] != 0 ) {
					?>
					<tr>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							Pax purchased: <?php echo $arrayCruise[$c]["noofAdult"]; ?> Adult(s)
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
							1
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">&nbsp;</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							<?php
							$adultCartPrice = number_format($this->All->getIndividualPriceBasedAdult($arrayCruise[$c]["stateroomID"], $arrayCruise[$c]["shipID"], $arrayCruise[$c]["brandID"], $arrayCruise[$c]["durationNight"], $arrayCruise[$c]["cruisePriceType"], $arrayCruise[$c]["noofAdult"], $arrayCruise[$c]["noofChild"]), 2);
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
					if( $arrayCruise[$c]["noofChild"] != 0 ) {
					?>
					<tr>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							Pax purchased: <?php echo $arrayCruise[$c]["noofChild"]; ?> Child(s)
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
							1
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">&nbsp;</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							<?php
							$childCartPrice = number_format($this->All->getIndividualPriceBasedChild($arrayCruise[$c]["stateroomID"], $arrayCruise[$c]["shipID"], $arrayCruise[$c]["brandID"], $arrayCruise[$c]["durationNight"], $arrayCruise[$c]["cruisePriceType"], $arrayCruise[$c]["noofAdult"], $arrayCruise[$c]["noofChild"]), 2);
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
					}
					?>
					<!--END OF CHILD-->
					<!--EXTRA CHARGES-->
					<?php
					if( $arrayCruise[$c]["extraPrice"] != "" && $arrayCruise[$c]["extraIDs"] != "-" ) {			
						$qtyCharge = $arrayCruise[$c]["noofAdult"]+$arrayCruise[$c]["noofChild"];			
						$extraT = $this->All->getSumExtraPrices($arrayCruise[$c]["extraIDs"])*$qtyCharge;
						$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
						$extraCharges_res = mysqli_query(
							$connection, "SELECT * FROM cruise_extra_price WHERE id IN(".$arrayCruise[$c]["extraIDs"].")"
						);
						if( mysqli_num_rows($extraCharges_res) > 0 ) {
							while( $extraCharges_row = mysqli_fetch_array($extraCharges_res, MYSQL_ASSOC) ) {
								$cruiseExtra += $extraCharges_row["extra_price_value"]*$qtyCharge;
					?>
					<tr>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							Extra: <?php echo $extraCharges_row["extra_price_name"]; ?>
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
							<?php echo $qtyCharge; ?>
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">&nbsp;</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
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
					<tr>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							&nbsp;
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
							<b>Total price</b>
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
							&nbsp;
						</td>
						<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
							<b>
								<?php
									$adultT = str_replace(",", "", $adultCartPrice);
									$childT = str_replace(",", "", $childCartPrice);
									echo number_format($adultT+$childT+$extraT, 2);
								?>
							</b>
						</td>
					</tr>
				</table>
			</div>
			<br /><br />
			<!--END OF NEW DESIGN-->
			<?php
						$total_cruise_grand += $arrayCruise[$c]["cruisePrice"];
					}
				}
				else {
			?>
				<article class="full-width">
					<div style="text-align:center; color:red; font-size:16px">
						No cruise item found on your cart.
					</div>
				</article>
			<?php
				}
			}
			?>			
		</ul>
	</article>
</section>