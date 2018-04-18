<?php $bookingOrder = $this->uri->segment(4); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>CTC Travel - Cruise Voucher</title>
	<style type="text/css">p { text-align: center; }</style>
</head>
<body>
<div style="width: 880px; margin:0 auto">
  	<table width="100%">
    	<tr>
			<td valign="bottom">
				<img width="120" src="<?php echo base_url(); ?>assets/default.png" />
			</td>
			<td valign="bottom">
				<div style="text-align:center">
					<div style="font-size:25px;"><strong>Commonwealth Travel Service Corporation Pte Ltd</strong></div>
					<div style="padding: 5px; font-size: 13px; border-radius:10px;">
			            <div>133 New Bridge Road, #03-03/04/05/06 Chinatown Point Singapore 059413</div>
			            <div>Tel: 6532 0532 Fax: 6532 0235 Website: www.ctc.com.sg</div>
			            <div>Email: enquiry@ctc.com.sg International Tours-6536 3995 Free & Easy-6536 3345 China-6536 4733 M.I.C.E.-6216 3455 Online Travel Center-6216 3456</div>
			            <div>Ticketing-6532 5552 Company Registration No. 199000981G</div>
          			</div>
        		</div>
        	</td>
    	</tr>
  	</table>
  	<p style="text-align:center;font-family:Courier; font-size: 18px;"><strong><u>PAX STATEMENT</u></strong></p>
  	<?php
	$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	//booking details
	$bookingDetails = $this->All->select_template("BookingOrderID", $bookingOrder, "confirmedBookOrder");
	foreach( $bookingDetails AS $bookingDetail ) {
		$idUsed 	 = $bookingDetail->id;
		$grand_total = $bookingDetail->granTotalPrice;
		$bookingDate = $bookingDetail->created;
	}
	//end of booking details
	//contact purchase
	$contacts = $this->All->select_template_w_2_conditions("bookOrderID", $bookingOrder, "contactPurchase", 1, "cruise_traverlerInfo");
	foreach( $contacts AS $contact ) {
		$traveler_title    	  = $contact->traveler_title;
		$traveler_fullname 	  = $contact->traveler_fullname;
		$traveler_nric 	   	  = $contact->traveler_nric;
		$traveler_dob 	   	  = $contact->traveler_dob;
		$traveler_nationality = $contact->traveler_nationality;
		$traveler_address 	  = $contact->traveler_address;
		$traveler_passportNo  = $contact->traveler_passportNo;
		$traveler_contact 	  = $contact->traveler_contact;
		$traveler_email 	  = $contact->traveler_email;
	} 
	//end of contact purchase
	?>
  	<table cellpadding="1" cellspacing="0">
    	<tr>
			<td width="80" valign="top"><strong style="font-family:Courier; font-size: 13px;">BOOKING NO</strong></td>
			<td width="10" valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td width="400" valign="top"><span style="font-family:Courier; font-size: 13px;"><?php echo $bookingOrder; ?></span></td>
			<td width="10" valign="top">&nbsp;</td>
			<td width="120" valign="top"><strong style="font-family:Courier; font-size: 13px;">BOOKING DATE</strong></td>
			<td width="10" valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $bookingDate; ?></span>
			</td>
    	</tr>
		<tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">NAME</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top"><span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
				<?php echo $traveler_title; ?>. <?php echo $traveler_fullname; ?>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">NRIC</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $traveler_nric; ?></span>
			</td>
    	</tr>
    	<tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">DOB</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top"><span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
				<?php echo $traveler_dob; ?>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">NATIONALITY</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $traveler_nationality; ?></span>
			</td>
    	</tr>
		<tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">ADDRESS</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $traveler_address; ?></span>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">PASSPORT NO</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $traveler_passportNo; ?></span>
			</td>
    	</tr>
		<tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">CONTACT NO</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $traveler_contact; ?></span>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">EMAIL</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $traveler_email; ?></span>
			</td>
    	</tr>
    	<tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">PASSENGER(S)</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top"></td>
			<td valign="top">&nbsp;</td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">&nbsp;</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">&nbsp;</strong></td>
			<td valign="top"><span style="font-family:Courier; font-size: 13px; text-transform: uppercase">&nbsp;</span></td>
    	</tr>
  	</table>
  	<br />
  	<table class="responsive large-only booking_pricing custom_table custom_member_information_table" id="land_package_departure_price" style="width: 100% !important;">
		<tr>
			<th style="width: 40%; text-align: left">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">PASSENGERS</span>
			</th>
			<th style="width: 45%; text-align: left">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">&nbsp;</span>
			</th>
		</tr>
	    <tr>
	    	<td colspan="3" style="border-top: 1px solid black"></td>
	    </tr>
	    
	    <?php
	 	$passenger1_res  = mysqli_query(
		$connection,
			"
				SELECT * FROM cruise_traverlerInfo 
				WHERE bookOrderID = '".$bookingOrder."' ORDER BY type_adul_or_child ASC LIMIT 0,2
			"
		);
		if( mysqli_num_rows($passenger1_res) > 0 ) {
		?>
		<tr>
			<?php
			$one = 1;
			while( $passenger1_row = mysqli_fetch_array($passenger1_res, MYSQL_ASSOC) ) {
			?>
	        <td style="vertical-align: top;">
	            <strong>
	            	<span style="font-family:Courier; font-size: 13px;"><?php echo $one; ?>.</span>
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		(<?php echo $passenger1_row["type_adul_or_child"]; ?>)
	            	</span>
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		<?php echo $passenger1_row["traveler_title"]; ?>
	            	</span> 
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		<?php echo $passenger1_row["traveler_fullname"]; ?>
	            	</span>
	            </strong>
	        </td>
	        <?php
		        $one++;
		    }
		    ?>
	    </tr>
	    <?php
		}
		?>
		
	    <?php
	 	$passenger2_res  = mysqli_query(
		$connection,
			"
				SELECT * FROM cruise_traverlerInfo 
				WHERE bookOrderID = '".$bookingOrder."' ORDER BY type_adul_or_child ASC LIMIT 2,2
			"
		);
		if( mysqli_num_rows($passenger2_res) > 0 ) {
		?>
		<tr>
			<?php
			$two = 3;
			while( $passenger2_row = mysqli_fetch_array($passenger2_res, MYSQL_ASSOC) ) {
			?>
	        <td style="vertical-align: top;">
	            <strong>
	            	<span style="font-family:Courier; font-size: 13px;"><?php echo $two; ?>.</span>
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		(<?php echo $passenger2_row["type_adul_or_child"]; ?>)
	            	</span>
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		<?php echo $passenger2_row["traveler_title"]; ?>
	            	</span> 
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		<?php echo $passenger2_row["traveler_fullname"]; ?>
	            	</span>
	            </strong>
	        </td>
	        <?php
		        $two++;
		    }
		    ?>
	    </tr>
	    <?php
		}
		?>
	    
	    <?php
	 	$passenger3_res  = mysqli_query(
		$connection,
			"
				SELECT * FROM cruise_traverlerInfo 
				WHERE bookOrderID = '".$bookingOrder."' ORDER BY type_adul_or_child ASC LIMIT 4,2
			"
		);
		if( mysqli_num_rows($passenger3_res) > 0 ) {
		?>
		<tr>
			<?php
			$three = 5;
			while( $passenger3_row = mysqli_fetch_array($passenger3_res, MYSQL_ASSOC) ) {
			?>
	        <td style="vertical-align: top;">
	            <strong>
	            	<span style="font-family:Courier; font-size: 13px;"><?php echo $three; ?>.</span>
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		(<?php echo $passenger3_row["type_adul_or_child"]; ?>)
	            	</span>
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		<?php echo $passenger3_row["traveler_title"]; ?>
	            	</span> 
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		<?php echo $passenger3_row["traveler_fullname"]; ?>
	            	</span>
	            </strong>
	        </td>
	        <?php
		        $three++;
		    }
		    ?>
	    </tr>
	    <?php
		}
		?>
	    
	    <?php
	 	$passenger4_res  = mysqli_query(
		$connection,
			"
				SELECT * FROM cruise_traverlerInfo 
				WHERE bookOrderID = '".$bookingOrder."' ORDER BY type_adul_or_child ASC LIMIT 6,2
			"
		);
		if( mysqli_num_rows($passenger4_res) > 0 ) {
		?>
		<tr>
			<?php
			$four = 7;
			while( $passenger4_row = mysqli_fetch_array($passenger4_res, MYSQL_ASSOC) ) {
			?>
	        <td style="vertical-align: top;">
	            <strong>
	            	<span style="font-family:Courier; font-size: 13px;"><?php echo $four; ?>.</span>
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		(<?php echo $passenger4_row["type_adul_or_child"]; ?>)
	            	</span>
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		<?php echo $passenger4_row["traveler_title"]; ?>
	            	</span> 
	            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	            		<?php echo $passenger4_row["traveler_fullname"]; ?>
	            	</span>
	            </strong>
	        </td>
	        <?php
		        $four++;
		    }
		    ?>
	    </tr>
	    <?php
		}
		?>
	    
	    <tr>
		    <td colspan="3" style="border-top: none;vertical-align: top;">&nbsp;</td>
		</tr>
	    <tr>
	    	<td colspan="3" style="border-top: 1px solid black"></td>
	    </tr>
	</table>
	<table width="100%" cellpadding="1" cellspacing="0" style="border-top: 1px solid black;">
    	<tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">CRUISE FARES</strong> </td>
			<td valign="top"></td>
			<td width="80" valign="top"></td>
			<td align="right" valign="top" style="width: 100px">
				<strong style="font-family:Courier; font-size: 13px;"><u>AMOUNT</u></strong>
			</td>
    	</tr>
    	<tr>
			<td valign="top">
				<strong style="font-family:Courier; font-size: 13px;">
					&nbsp;
				</strong>
			</td>
			<td valign="top"></td>
			<td width="80" valign="top"></td>
			<td align="right" valign="top" style="width: 100px">
				<strong style="font-family:Courier; font-size: 13px;"><u>&nbsp;</u></strong>
			</td>
    	</tr>
    	
    	<!--FIRST RECORD-->
    	<?php
	    $itemDetails = $this->All->select_template("cruise_confirmedBookOrder_ID", $idUsed, "cruise_historyOrder");
	    foreach( $itemDetails AS $itemDetail ) { 
		    //cruiseTitle
		    $titles = $this->All->select_template("ID", $itemDetail->cruiseTitleID, "cruise_title");
			foreach( $titles AS $title ) {
				$cruise_tourCode = $title->CRUISE_TOUR_CODE;
			}
		    //end of cruiseTitle
	    ?>
    	<tr>
			<td valign="top">
				<strong style="font-family:Courier; font-size: 13px;">
					<?php echo $this->All->getCruiseTitleName($itemDetail->cruiseTitleID); ?>
					- 
					<?php echo $this->All->getCruiseShipName($itemDetail->shipID); ?> 
					- 
					<?php echo $this->All->getCruiseBrandName($itemDetail->shipID); ?> (<?php echo $cruise_tourCode; ?>)
				</strong>
			</td>
			<td valign="top"></td>
			<td width="80" valign="top"></td>
			<td align="right" valign="top" style="width: 100px">
				<strong style="font-family:Courier; font-size: 13px;">&nbsp;</strong>
			</td>
    	</tr>
    	<tr>
	    	<td colspan="4" style="border-top: 1px solid black"></td>
	    </tr>
	    <tr>
			<td valign="top">
				<strong style="font-family:Courier; font-size: 13px;">
					NO. OF PAX: <?php echo $itemDetail->noofAdult; ?> Adult(s) 
					& 
					<?php echo $itemDetail->noofChild; ?> Child(s)
				</strong>
			</td>
			<td valign="top"></td>
			<td width="80" valign="top"></td>
			<td align="right" valign="top" style="width: 100px">
				<strong style="font-family:Courier; font-size: 13px;"><u>&nbsp;</u></strong>
			</td>
    	</tr>
		<tr>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px;">
					<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
						CATEGORY: <?php echo $this->All->getStateroomDetails2($itemDetail->stateroomID, $itemDetail->brandID, $itemDetail->shipID); ?>
					</span>
				</span>
			</td>
			<td align="right" valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					1 Cabin
				</span>
			</td>
			<td align="right" valign="top"></td>
			<td align="right" valign="top"></td>
		</tr>
		<tr>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px;">
					<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
						<?php echo $itemDetail->noofAdult; ?> ADULT(s)
					</span>
				</span>
			</td>
			<td align="right" valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php
					$adultCartPrice = number_format($this->All->getIndividualPriceBasedAdult($itemDetail->stateroomID, $itemDetail->shipID, $itemDetail->brandID, $itemDetail->durationNight, $itemDetail->cruisePriceType, $itemDetail->noofAdult, $itemDetail->noofChild), 2);
					if( $adultCartPrice == "0.00" ) {
						echo "FREE";
					}
					else {
						echo "$".$adultCartPrice;	
					}
					?>
				</span>
			</td>
			<td align="left" valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					&nbsp;* 1
				</span>
			</td>
			<td align="right" valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<b>$<?php echo $adultCartPrice; ?></b>
				</span>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px;">
					<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
						<?php echo $itemDetail->noofChild; ?> CHILD(s)
					</span>
				</span>
			</td>
			<td align="right" valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php
					if( $itemDetail->noofChild > 0 ) {
						$childCartPrice = number_format($this->All->getIndividualPriceBasedChild($itemDetail->stateroomID, $itemDetail->shipID, $itemDetail->brandID, $itemDetail->durationNight, $itemDetail->cruisePriceType, $itemDetail->noofAdult, $itemDetail->noofChild), 2);
					}
					else {
						$childCartPrice = 0;
					}
					if( $childCartPrice == "0.00" ) {
						echo "FREE";
					}
					else {
						echo "$".$childCartPrice;	
					}
					?>
				</span>
			</td>
			<td align="left" valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					&nbsp;* 1
				</span>
			</td>
			<td align="right" valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<b>$<?php echo $childCartPrice; ?></b>
				</span>
			</td>
		</tr>
		<?php
		$cruiseExtra = "";
		if( $itemDetail->extraIDs != "" && $itemDetail->extraIDs != "-" ) {
			$extraT = $this->All->getSumExtraPrices($itemDetail->extraIDs);
			$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			$extraCharges_res = mysqli_query(
				$connection, "SELECT * FROM cruise_extra_price WHERE id IN(".$itemDetail->extraIDs.")"
			);
			if( mysqli_num_rows($extraCharges_res) > 0 ) {
				while( $extraCharges_row = mysqli_fetch_array($extraCharges_res, MYSQL_ASSOC) ) {
					$cruiseExtra += $extraCharges_row["extra_price_value"];
		?>
		<tr>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px;">
					<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
						<?php echo $extraCharges_row["extra_price_name"]; ?>
					</span>
				</span>
			</td>
			<td align="right" valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					$<?php echo number_format($extraCharges_row["extra_price_value"], 2); ?>
				</span>
			</td>
			<td align="left" valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php
					$totalA = $itemDetail->noofAdult+$itemDetail->noofChild;
					?>
					&nbsp;* <?php echo $totalA; ?>
				</span>
			</td>
			<td align="right" valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<b>$<?php echo number_format($extraCharges_row["extra_price_value"]*$totalA, 2); ?></b>
				</span>
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
		<tr>
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		</tr>
		<?php
		}
		?>
		<!--END OF FIRST RECORD-->
		
	    <tr>
	      	<td valign="top"></td>
		  	<td valign="top"></td>
		  	<td align="right" valign="top"></td>
		  	<td valign="top"></td>
	    </tr>
	    <tr>
	      	<td valign="top"></td>
		  	<td valign="top"></td>
		  	<td align="right" valign="top"></td>
		  	<td valign="top"></td>
	    </tr>
	    <tr>
	      	<td valign="top">&nbsp;</td>
		  	<td valign="top"></td>
		  	<td align="right" valign="top">&nbsp;</td>
		  	<td align="right" valign="top">&nbsp;</td>
	    </tr>
	    <tr>
	      	<td valign="top" colspan="4">
		      	<span style="font-family:Courier; font-size: 13px;">GST @ 0% on $</span>
		      	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
		      		<?php echo number_format($grand_total, 2); ?>
		      	</span>
		      </td>
	    </tr>
	    <tr>
	      	<td valign="top"><strong style="font-family:Courier; font-size: 13px;">TOTAL :</strong> </td>
		  	<td align="right" valign="top"><span style="font-family:Courier; font-size: 13px;"></span></td>
		  	<td align="right" valign="top"><span style="font-family:Courier; font-size: 13px;">$</span></td>
		  	<td align="right" valign="top">
			  	<span style="font-family:Courier; font-size: 13px; border-top: 1px solid black; border-bottom: 4px black double">
			  		<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
			  			<?php echo number_format($grand_total, 2); ?>
			  		</span>
			  	</span>
			</td>
	    </tr>
	    <tr>
	      	<td valign="top">&nbsp;</td>
		  	<td valign="top"></td>
		  	<td valign="top"></td>
		  	<td valign="top"></td>
	    </tr>
	    <tr>
	      	<td valign="top"><strong style="font-family:Courier; font-size: 13px;">NETT :</strong> </td>
		  	<td align="right" valign="top"><span style="font-family:Courier; font-size: 13px;"></span></td>
		  	<td align="right" valign="top"><span style="font-family:Courier; font-size: 13px;">$</span></td>
		  	<td align="right" valign="top">
			  	<span style="font-family:Courier; font-size: 13px; border-top: 1px solid black; border-bottom: 4px black double">
			  		<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
			  			<?php echo number_format($grand_total, 2); ?>
			  		</span>
			  	</span>
			</td>
	    </tr>
  	</table>
  	<BR>
  	<div><strong style="font-family:Courier; font-size: 13px;">SPECIAL INSTRUCTION</strong></div>
  	<ol>
	  	<li style="font-family:Courier; font-size: 13px;">
  			Full payment is required upon booking
  		</li>
  		<li style="font-family:Courier; font-size: 13px;">
  			Cruise fare is non-refundable once booked
  		</li>
  		<li style="font-family:Courier; font-size: 13px;">
  			Any amendment is subject to approval and charges
  		</li>
  		<li style="font-family:Courier; font-size: 13px;">
  			Dining time to be advice
  		</li>
  		<li style="font-family:Courier; font-size: 13px;">
  			Cruise fare exclude shore excursion and travel insurance
  		</li>
  		<li style="font-family:Courier; font-size: 13px;">
  			Gratuities are payable onboard for selected cruises
  		</li>
  		<li style="font-family:Courier; font-size: 13px;">
  			Visitor entry visa at own arrangement for individual port-of-call; if required
  		</li>
  	</ol>
  	<br />
  	
  	<?php
	$payments = $this->All->select_template("bookOrderID", $bookingOrder, "payment_reference");
	foreach( $payments AS $payment ) {
		$p_created = $payment->created;
		$p_TM_PaymentType = $payment->TM_PaymentType;
	}
 	?>
	<table width="100%" cellpadding="1" cellspacing="0" style="border-top: 1px solid black;">
		<tr>
			<td colspan="6" align="center"><strong style="font-family:Courier; font-size: 13px;"><u>PAYMENT TRANSACTIONS</u></strong></td>
		</tr>
	    <tr>
	      	<td><strong style="font-family:Courier; font-size: 13px;"><u>TRANSACTION</u></strong></td>
		  	<td><strong style="font-family:Courier; font-size: 13px;"><u>REF NO</u></strong></td>
		  	<td><strong style="font-family:Courier; font-size: 13px;"><u>DATE</u></strong></td>
		  	<td><strong style="font-family:Courier; font-size: 13px;"><u>PAYMENT TYPE</u></strong></td>
		  	<td><strong style="font-family:Courier; font-size: 13px;"><u>AMOUNT</u></strong></td>
	    </tr>
	    <tr>
	      	<td>
		      	<span style="font-family:Courier; font-size: 13px;">
		      		<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">RECEIPT</span>
		      	</span>
		   	</td>
		  	<td>
			  	<span style="font-family:Courier; font-size: 13px;"><?php echo $bookingOrder; ?></span>
			</td>
		  	<td>
			  	<span style="font-family:Courier; font-size: 13px;">
			  		<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
			  			<?php echo date("d M Y", strtotime($p_created)); ?>
			  		</span>
			  	</span>
			</td>
		  	<td>
			  	<span style="font-family:Courier; font-size: 13px;">
			  		<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
			  			<?php
				  		if( $p_TM_PaymentType == 2 ) {
					  		echo "MASTER CARD";
				  		}
				  		else if( $p_TM_PaymentType == 3 ) {
					  		echo "VISA CARD";
				  		}
				  		else if( $p_TM_PaymentType == 5 ) {
					  		echo "AMEX CARD";
				  		}
				  		else if( $p_TM_PaymentType == 22 ) {
					  		echo "DINERS CARD";
				  		}
				  		else if( $p_TM_PaymentType == 23 ) {
					  		echo "JCB CARD";
				  		}
				  		else if( $p_TM_PaymentType == 25 ) {
					  		echo "CHINA UNIONPAY";
				  		}
				  		?>
			  		</span>
			  	</span>
			</td>
		  	<td>
			  	<span style="font-family:Courier; font-size: 13px;">
			  		<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
			  			SGD $<?php echo number_format($grand_total, 2); ?>
			  		</span>
			  	</span>
			</td>
	    </tr>
  	</table>
  	<br />
  	<table width="100%" cellpadding="1" cellspacing="0">
	    <tr>
	      	<td>
		      	<div style="border-top: 1px solid black; font-family:Courier; font-size: 13px; text-decoration:none"> 
			      	<strong>IMPORTANT NOTES</strong><br />
				  	1) Please ensure name and details provided are as per passport.<br />
				  	2) Please ensure Visa is apply if needed.<br />
				  	3) Passport must be valid for at least 6 months from your return date.<br />
				  	4) Flight Schedule/Taxes are subject to changes.<br />
				  	5) Tour   subjected to special instructions and group size.
				</div>
			</td>
	    </tr>
	</table>
</div>
</body>
</html>