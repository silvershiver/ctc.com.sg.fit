<!--CRUISE CONFIRMATION-->
<?php
if( $this->session->userdata('shoppingCartCruiseCookie') == TRUE ) {
	if( count($this->session->userdata('shoppingCartCruiseCookie')) > 0 ) {
?>
		<h1>Confirmed Booking Order - Cruise</h1>

		<?php
			$array1 = $this->session->userdata('shoppingCartCruiseCookie');
			$array = array_map(function($element) {
	        	return $element['stateroomID'].":".$element['cruiseTitleID'];
	        }, $array1);
			$array2 = (array_count_values($array));
		?>

		<!--Validate quantity-->
		<?php
		$arrayBOOL  = "";
		$arrayCheck = $this->All->calculateQtyAvaWithOutLogin($array2);
		for($a=0; $a<count($arrayCheck); $a++) {
			if( $arrayCheck[$a]["errorCode"] == 1 ) {
				$arrayBOOL .= $arrayCheck[$a]["errorCode"];
			}
		}
		if (strpos($arrayBOOL, "1") !== false) {
		?>
		<div style="background: #fef2b8; padding:15px; margin-bottom: 20px; font-size: 16px">
			Notification:
			<br />
			<div style="padding-left:30px">We are apologised but please update your order item(s) again.</div>
			<div style="padding-left:30px">
				<ul style="padding-left:30px">
					<?php
					for($b=0; $b<count($arrayCheck); $b++) {
						if( $arrayCheck[$b]["errorCode"] == 1 ) {
					?>
					<li style="font-size:16px; list-style-type:square">
						Stateroom: <?php echo $this->All->getStateroomDetails2($arrayCheck[$b]["stateroomID"], $arrayCheck[$b]["brandID"], $arrayCheck[$b]["shipID"]); ?> (<?php echo $this->All->getCruiseTitleName($arrayCheck[$b]["cruiseTitleID"]); ?>) is out of stock.
							<?php
							if( $arrayCheck[$b]["minus"] > 0 ) {
							?>
								Only left <?php echo $arrayCheck[$b]["minus"]; ?> room(s) only.
							<?php
							}
							?>
					</li>
					<?php
						}
					}
					?>
				</ul>
			</div>
			<div style="padding-left:30px">
				Please update your item purchased <a href="<?php echo base_url(); ?>cart/index#cruises_cart" style="color:blue">here</a>
			</div>
		</div>
		<?php
		}
		?>
		<!--End of validate quantity-->

		<ul class="room-types">
			<?php
			$arrayCruise = $this->session->userdata('shoppingCartCruiseCookie');
			$arrayCruiseCount = count($arrayCruise);
			for($c=0; $c<$arrayCruiseCount; $c++) {
				//get cruise title details
				$cruiseTitles = $this->All->select_template("ID", $arrayCruise[$c]["cruiseTitleID"], "cruise_title");
				foreach( $cruiseTitles AS $cruiseTitle ) {
					$cruiseTitlePrint 		  = $cruiseTitle->CRUISE_TITLE;
					$cruiseDeparturePortPrint = $cruiseTitle->DEPARTURE_PORT;
				}
				//end of get cruise title details
?>
			<!--new design-->
			<li>
				<div class="meta" style="width:75%">
					<div class="tab">
						<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
							<tr class="days">
								<th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
									<div style="font-size:12px">
										<img src="<?php echo $this->All->getCruiseImage($arrayCruise[$c]["cruiseTitleID"]); ?>" alt="" width="150" height="115" />
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
										<?php echo date("l, d M Y", strtotime($arrayCruise[$c]["cruiseDate"])); ?>
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
							<tr>
								<td style="width:40%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
									<b>Item details</b>
								</td>
								<td style="width:9%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:center">
									<b>Quantity</b>
								</td>
								<td style="width:20%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:right">
									<b>Unit Price ($)</b>
								</td>
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
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
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
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
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
							if( $arrayCruise[$c]["extraIDs"] != "" && $arrayCruise[$c]["extraIDs"] != "-" ) {
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
						</table>
					</div>
					<div class="age_type" style="font-size:14px">
						Please enter your passenger details and ensure the details matches your passport.
						<span style="text-transform: capitalize; color:red">
							<b>(* required field)</b>
						</span>
					</div>
					<div class="tab_container" id="tabs-0" style="font-size:14px">
						<!--ADULT FORM-->
						<?php
						$noofAdult = $arrayCruise[$c]["noofAdult"];
						for( $a=1; $a<=$noofAdult; $a++ ) {
						?>
					    <div class="form_div particular-form" id="particular-1">
							<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; magrin-bottom: 10px;">
						        <div style="float:right">
							        <span style="color:green"><b>Adult <?php echo $a; ?> Info Details</b></span>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Title<span class="required_field">*</span>:
										</div>
										<div>
											<select name="C_paxTitleAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" required style="width:200px; height:37px">
								                <option value="">- Select a value -</option>
								                <option value="Mr">Mr</option>
								                <option value="Ms">Ms</option>
								                <option value="Mrs">Mrs</option>
								            </select>
										</div>
					        		</div>
						        </div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Date Of Birth <span class="required_field">*</span>:
										</div>
										<select name="C_paxDobyearAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
										<select name="C_paxDobmonthAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
							            <select name="C_paxDobdayAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
										<div style="margin-top:10px; margin-bottom:5px">
											Full Name <span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxFullnameAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											NRIC<span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxNricAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Nationality <span class="required_field">*</span>:
										</div>
										<select name="C_paxNationalityAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" style="width:87%; height:37px">
											<?php
											$nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
											foreach( $nationalities AS $nationality ) {
												if( $nationality->nicename == "Singapore" ) {
											?>
											<option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
												<?php echo $nationality->nicename; ?> (+<?php echo $nationality->phonecode; ?>)
											</option>
											<?php
												}
												else {
											?>
											<option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
												<?php echo $nationality->nicename; ?> (+<?php echo $nationality->phonecode; ?>)
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
										<div style="margin-top:10px; margin-bottom:5px">
											Passport Number <span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxPassportnoAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Issue Date <span class="required_field">*</span>:
										</div>
										<select name="C_paxIssueyearAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
											<option value="">- Year -</option>
											<?php
								            $issueYear = 2016;
								            for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
									        ?>
									        <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
									        <?php
								            }
								            ?>
										</select>
								        <select name="C_paxIssuemonthAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxIssuedayAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Expiry Date <span class="required_field">*</span>:
										</div>
										<select name="C_paxExpireyearAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxExpiremonthAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxExpiredayAdult[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
						        <div style="clear:both"></div>
					        </div>
					    </div>
					    <?php
						}
						?>
						<!--END OF ADULT FORM-->
						<!--CHILD FORM-->
						<?php
						$noofChild = $arrayCruise[$c]["noofChild"];
						if( $noofChild != 0 ) {
							for( $ch=1; $ch<=$noofChild; $ch++ ) {
						?>
					    <div class="form_div particular-form" id="particular-1">
							<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; magrin-bottom: 10px;">
						        <div style="float:right">
							        <span style="color:green"><b>Child <?php echo $ch; ?> Info Details</b></span>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Title<span class="required_field">*</span>:
										</div>
										<div>
											<select name="C_paxTitleChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:200px; height:37px">
								                <option value="">- Select a value -</option>
								                <option value="Mr">Mr</option>
								                <option value="Ms">Ms</option>
								                <option value="Mrs">Mrs</option>
								            </select>
										</div>
					        		</div>
						        </div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Date Of Birth <span class="required_field">*</span>:
										</div>
										<select name="C_paxDobyearChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
										<select name="C_paxDobmonthChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
							            <select name="C_paxDobdayChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
										<div style="margin-top:10px; margin-bottom:5px">
											Full Name <span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxFullnameChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											NRIC<span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxNricChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Nationality <span class="required_field">*</span>:
										</div>
										<select name="C_paxNationalityChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" style="width:87%; height:37px">
											<?php
											$nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
											foreach( $nationalities AS $nationality ) {
												if( $nationality->nicename == "Singapore" ) {
											?>
											<option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
												<?php echo $nationality->nicename; ?> (+<?php echo $nationality->phonecode; ?>)
											</option>
											<?php
												}
												else {
											?>
											<option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
												<?php echo $nationality->nicename; ?> (+<?php echo $nationality->phonecode; ?>)
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
										<div style="margin-top:10px; margin-bottom:5px">
											Passport Number <span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxPassportnoChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Issue Date <span class="required_field">*</span>:
										</div>
										<select name="C_paxIssueyearChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
											<option value="">- Year -</option>
											<?php
								            $issueYear = 2016;
								            for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
									        ?>
									        <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
									        <?php
								            }
								            ?>
										</select>
								        <select name="C_paxIssuemonthChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxIssuedayChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Expiry Date <span class="required_field">*</span>:
										</div>
										<select name="C_paxExpireyearChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxExpiremonthChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxExpiredayChild[<?php echo $c+1; ?>00000<?php echo $arrayCruise[$c]["cruiseTitleID"]; ?>][]" class="require" required style="width:110px; height:37px">
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
						        <div style="clear:both"></div>
					        </div>
					    </div>
					    <?php
						    }
						}
						?>
						<!--END OF CHILD FORM-->
					</div>
				</div>
				<div class="room-information" style="height:112px; width:19%">
					<div class="tab">
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
											<b>0<?php echo $arrayCruise[$c]["noofAdult"]; ?></b>
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
											<b>0<?php echo $arrayCruise[$c]["noofChild"]; ?></b>
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
											<b>$<?php echo number_format($arrayCruise[$c]["cruisePrice"], 2); ?></b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>TOTAL:</b>
										</div>
									</div>
								</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>
												<?php
													$total_cruise_grand += $arrayCruise[$c]["cruisePrice"]+($this->All->get_sumExtraChargeByID($arrayCruise[$c]["extraIDs"])*$qtyCharge);
													echo "$".number_format($arrayCruise[$c]["cruisePrice"]+($this->All->get_sumExtraChargeByID($arrayCruise[$c]["extraIDs"])*$qtyCharge), 2);
												?>
											</b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
							</tr>
						</table>
					</div>
				</div>
			</li>
			<!--end of new design-->
<?php
			}
?>
		</ul>
<?php
	}
	else {
?>
	<div>test</div>
<?php
	}
}
else {
	$array_stateroomQTY  = array();
	$array_qty_available = array();
	$cart_cruises = $this->All->select_template("user_access_id", $this->session->userdata('normal_session_id'), "cruise_cart");
	if( $cart_cruises == TRUE ) {
?>
		<h1>Confirmed Booking Order - Cruise</h1>
		<!--Validate quantity-->
		<?php
		$arrayBOOL  = "";
		$arrayCheck = $this->All->calculateQtyAva($this->session->userdata('normal_session_id'));
		for($a=0; $a<count($arrayCheck); $a++) {
			if( $arrayCheck[$a]["errorCode"] == 1 ) {
				$arrayBOOL .= $arrayCheck[$a]["errorCode"];
			}
		}
		?>
		<?php
		if (strpos($arrayBOOL, "1") !== false) {
		?>
		<div style="background: #fef2b8; padding:15px; margin-bottom: 20px; font-size: 16px">
			Notification:
			<br />
			<div style="padding-left:30px">We are apologised but please update your order item(s) again.</div>
			<div style="padding-left:30px">
				<ul style="padding-left:30px">
					<?php
					for($b=0; $b<count($arrayCheck); $b++) {
						if( $arrayCheck[$b]["errorCode"] == 1 ) {
					?>
					<li style="font-size:16px; list-style-type:square">
						Stateroom: <?php echo $this->All->getStateroomDetails2($arrayCheck[$b]["stateroomID"], $arrayCheck[$b]["brandID"], $arrayCheck[$b]["shipID"]); ?> (<?php echo $this->All->getCruiseTitleName($arrayCheck[$b]["cruiseTitleID"]); ?>) is out of stock.
							<?php
							if( $arrayCheck[$b]["minus"] > 0 ) {
							?>
								Only left <?php echo $arrayCheck[$b]["minus"]; ?> room(s) only.
							<?php
							}
							?>
					</li>
					<?php
						}
					}
					?>
				</ul>
			</div>
			<div style="padding-left:30px">
				Please update your item purchased <a href="<?php echo base_url(); ?>cart/index#cruises_cart" style="color:blue">here</a>
			</div>
		</div>
		<?php
		}
		?>
		<!--End of validate quantity-->

		<ul class="room-types">
			<?php
			$c = 0;
			foreach( $cart_cruises AS $cart_cruise ) {
				//get cruise title details
				$cruiseTitles = $this->All->select_template("ID", $cart_cruise->cruiseTitleID, "cruise_title");
				foreach( $cruiseTitles AS $cruiseTitle ) {
					$cruiseTitlePrint = $cruiseTitle->CRUISE_TITLE;
					$cruiseDeparturePortPrint = $cruiseTitle->DEPARTURE_PORT;
				}
				//end of get cruise title details
				//stateroomQTY
				$stateroomQTY = $this->All->getCruiseCartQty(
					$cart_cruise->cruiseTitleID, $cart_cruise->stateroomID, $this->session->userdata('normal_session_id')
				);
				$array_stateroomQTY[] = $stateroomQTY;
				//end of stateroomQTY
				//quantity room
				$quantity = $this->All->calculateRoomQuantityAvailability($cart_cruise->cruiseTitleID, $cart_cruise->stateroomID);
				//end of quantity room
				$array_qty_available[] = $quantity;
			?>
			<!--new design-->
			<li>
				<div class="meta" style="width:75%">
					<div class="tab">
						<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
							<tr class="days">
								<th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
									<div style="font-size:12px">
										<img src="<?php echo $this->All->getCruiseImage($cart_cruise->cruiseTitleID); ?>" alt="" width="150" height="115" />
									</div>
								</th>
							</tr>
							<tr>
								<td colspan="3" style="text-align:left; padding-bottom:0px">
									<div style="font-size:15px">
										<h5>Cruise title</h5>
										<?php echo $cruiseTitlePrint; ?>
										(<?php echo $this->All->getCruiseTitleTourCode($cart_cruise->cruiseTitleID); ?>)
									</div>
								</td>
							</tr>
							<tr>
								<td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
									<div style="font-size:15px">
										<h5>Departure date</h5>
										<?php echo date("l, d F Y", strtotime($cart_cruise->cruiseDate)); ?>
									</div>
								</td>
								<td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
									<div style="font-size:15px">
										<h5>Cruise length</h5>
										<?php echo $cart_cruise->durationNight; ?> NIGHT(S)
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div style="font-size:15px">
										<h5>Stateroom</h5>
										<?php echo $this->All->getStateroomDetails($cart_cruise->stateroomID); ?>
									</div>
								</td>
							</tr>
						</table>
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td style="width:40%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
									<b>Item details</b>
								</td>
								<td style="width:9%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:center">
									<b>Quantity</b>
								</td>
								<td style="width:20%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:right">
									<b>Unit Price ($)</b>
								</td>
							</tr>
							<!--ADULT-->
							<?php
							if( $cart_cruise->noofAdult != 0 ) {
							?>
							<tr>
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
									Pax purchased: <?php echo $cart_cruise->noofAdult; ?> Adult(s)
								</td>
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
									1
								</td>
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
									<?php
									$adultCartPrice = number_format($this->All->getIndividualPriceBasedAdult($cart_cruise->stateroomID, $cart_cruise->shipID, $cart_cruise->brandID, $cart_cruise->durationNight, $cart_cruise->cruisePriceType, $cart_cruise->noofAdult, $cart_cruise->noofChild), 2);
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
							if( $cart_cruise->noofChild != 0 ) {
							?>
							<tr>
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
									Pax purchased: <?php echo $cart_cruise->noofChild; ?> Child(s)
								</td>
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
									1
								</td>
								<td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
									<?php
									$childCartPrice = number_format($this->All->getIndividualPriceBasedChild($cart_cruise->stateroomID, $cart_cruise->shipID, $cart_cruise->brandID, $cart_cruise->durationNight, $cart_cruise->cruisePriceType, $cart_cruise->noofAdult, $cart_cruise->noofChild), 2);
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
							if( $cart_cruise->extraIDs != "" && $cart_cruise->extraIDs != "-" ) {
								$qtyCharge = $cart_cruise->noofAdult+$cart_cruise->noofChild;
								$extraT = $this->All->getSumExtraPrices($cart_cruise->extraIDs)*$qtyCharge;
								$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
								$extraCharges_res = mysqli_query(
									$connection, "SELECT * FROM cruise_extra_price WHERE id IN(".$cart_cruise->extraIDs.")"
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
						</table>
					</div>
					<div class="age_type" style="font-size:14px">
						Please enter your passenger details and ensure the details matches your passport.
						<span style="text-transform: capitalize; color:red">
							<b>(* required field)</b>
						</span>
					</div>
					<div class="tab_container" id="tabs-0" style="font-size:14px">
						<!--ADULT FORM-->
						<?php
						$noofAdult = $cart_cruise->noofAdult;
						for( $a=1; $a<=$noofAdult; $a++ ) {
						?>
					    <div class="form_div particular-form" id="particular-1">
							<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; magrin-bottom: 10px;">
						        <div style="float:right">
							        <span style="color:green"><b>Adult <?php echo $a; ?> Info Details</b></span>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Title<span class="required_field">*</span>:
										</div>
										<div>
											<select name="C_paxTitleAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" required style="width:200px; height:37px">
								                <option value="">- Select a value -</option>
								                <option value="Mr">Mr</option>
								                <option value="Ms">Ms</option>
								                <option value="Mrs">Mrs</option>
								            </select>
										</div>
					        		</div>
						        </div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Date Of Birth <span class="required_field">*</span>:
										</div>
										<select name="C_paxDobyearAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
										<select name="C_paxDobmonthAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
							            <select name="C_paxDobdayAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
										<div style="margin-top:10px; margin-bottom:5px">
											Full Name <span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxFullnameAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											NRIC<span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxNricAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Nationality <span class="required_field">*</span>:
										</div>
										<select name="C_paxNationalityAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" style="width:87%; height:37px">
											<?php
											$nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
											foreach( $nationalities AS $nationality ) {
												if( $nationality->nicename == "Singapore" ) {
											?>
											<option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
												<?php echo $nationality->nicename; ?> (+<?php echo $nationality->phonecode; ?>)
											</option>
											<?php
												}
												else {
											?>
											<option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
												<?php echo $nationality->nicename; ?> (+<?php echo $nationality->phonecode; ?>)
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
										<div style="margin-top:10px; margin-bottom:5px">
											Passport Number <span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxPassportnoAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Issue Date <span class="required_field">*</span>:
										</div>
										<select name="C_paxIssueyearAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
											<option value="">- Year -</option>
											<?php
								            $issueYear = 2016;
								            for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
									        ?>
									        <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
									        <?php
								            }
								            ?>
										</select>
								        <select name="C_paxIssuemonthAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxIssuedayAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Expiry Date <span class="required_field">*</span>:
										</div>
										<select name="C_paxExpireyearAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxExpiremonthAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxExpiredayAdult[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
						        <div style="clear:both"></div>
					        </div>
					    </div>
					    <?php
						}
						?>
						<!--END OF ADULT FORM-->
						<!--CHILD FORM-->
						<?php
						$noofChild = $cart_cruise->noofChild;
						if( $noofChild != 0 ) {
							for( $ch=1; $ch<=$noofChild; $ch++ ) {
						?>
					    <div class="form_div particular-form" id="particular-1">
							<div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; magrin-bottom: 10px;">
						        <div style="float:right">
							        <span style="color:green"><b>Chikd <?php echo $c; ?> Info Details</b></span>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Title<span class="required_field">*</span>:
										</div>
										<div>
											<select name="C_paxTitleChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:200px; height:37px">
								                <option value="">- Select a value -</option>
								                <option value="Mr">Mr</option>
								                <option value="Ms">Ms</option>
								                <option value="Mrs">Mrs</option>
								            </select>
										</div>
					        		</div>
						        </div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Date Of Birth <span class="required_field">*</span>:
										</div>
										<select name="C_paxDobyearChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
										<select name="C_paxDobmonthChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
							            <select name="C_paxDobdayChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
										<div style="margin-top:10px; margin-bottom:5px">
											Full Name <span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxFullnameChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											NRIC<span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxNricChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Nationality <span class="required_field">*</span>:
										</div>
										<select name="C_paxNationalityChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" style="width:87%; height:37px">
											<?php
											$nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
											foreach( $nationalities AS $nationality ) {
												if( $nationality->nicename == "Singapore" ) {
											?>
											<option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
												<?php echo $nationality->nicename; ?> (+<?php echo $nationality->phonecode; ?>)
											</option>
											<?php
												}
												else {
											?>
											<option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
												<?php echo $nationality->nicename; ?> (+<?php echo $nationality->phonecode; ?>)
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
										<div style="margin-top:10px; margin-bottom:5px">
											Passport Number <span class="required_field">*</span>:
										</div>
										<input type="text" name="C_paxPassportnoChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:78%">
					        		</div>
						        </div>
						        <div style="clear:both"></div>
					        </div>
					        <div>
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Issue Date <span class="required_field">*</span>:
										</div>
										<select name="C_paxIssueyearChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
											<option value="">- Year -</option>
											<?php
								            $issueYear = 2016;
								            for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
									        ?>
									        <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
									        <?php
								            }
								            ?>
										</select>
								        <select name="C_paxIssuemonthChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxIssuedayChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
						        <div style="float:left; width:50%">
							        <div>
										<div style="margin-top:10px; margin-bottom:5px">
											Expiry Date <span class="required_field">*</span>:
										</div>
										<select name="C_paxExpireyearChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxExpiremonthChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
								        <select name="C_paxExpiredayChild[<?php echo $c+1; ?>00000<?php echo $cart_cruise->cruiseTitleID; ?>][]" class="require" required style="width:110px; height:37px">
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
						        <div style="clear:both"></div>
					        </div>
					    </div>
					    <?php
						    }
						}
						?>
						<!--END OF CHILD FORM-->
					</div>
				</div>
				<div class="room-information" style="height:112px; width:19%">
					<div class="tab">
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
											<b>0<?php echo $cart_cruise->noofAdult; ?></b>
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
											<b>0<?php echo $cart_cruise->noofChild; ?></b>
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
											<b>$<?php echo number_format($cart_cruise->cruisePrice, 2); ?></b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>TOTAL:</b>
										</div>
									</div>
								</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
									<div style="font-size:12px">
										<div>
											<b>
												<?php
													$total_cruise_grand += $cart_cruise->cruisePrice+($this->All->get_sumExtraChargeByID($cart_cruise->extraIDs)*$qtyCharge);
													echo "$".number_format($cart_cruise->cruisePrice+($this->All->get_sumExtraChargeByID($cart_cruise->extraIDs)*$qtyCharge), 2);
												?>
											</b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
								<td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">&nbsp;</td>
							</tr>
						</table>
					</div>
				</div>
			</li>
			<!--end of new design-->
			<?php
				$c++;
			}
			?>
		</ul>
<?php
	}
}
?>
<!--END OF CRUISE CONFIRMATION-->