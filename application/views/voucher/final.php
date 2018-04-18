<?php
    $mealCodeArray = array(
        'P' => 'Alcoholic beverages for purchase', 
        'B' => 'Breakfast', 
        'O' => 'Cold meal', 
        'C' => 'Complimentary alcoholic beverages', 
        'K' => 'Continental Breakfast', 
        'D' => 'Dinner', 
        'F' => 'Food for purchase',    
        'G' => 'Food and Beverage / for purchase', 
        'H' => 'Hot Meal', 
        'L' => 'Lunch', 
        'MS' => 'Multi Meals', 
        'M' => 'Meal', 
        'N' => 'No meal service', 
        'R' => 'Refreshment', 
        'V' => 'Refreshment / for purchase', 
        'S' => 'Snack',
        'AVML' => 'Asian Vegetarian Meal', 
        'BBML' => 'Baby Meal', 
        'CAKE' => 'Birthday Cake (on SAS)',
        'BLML' => 'Bland Meal', 
        'CHML' => 'Children Meal', 
        'CLML' => 'Celebration Cake Meal',
        'DBML' => 'Diabetic Meal', 
        'FPML' => 'Fruit Platter Meal',
        'GFML' => 'Gluten Intolerant Meal', 
        'LCML' => 'Low Calorie Meal',
        'HFML' => 'High Fibre Meal', 
        'HNML' => 'Hindu Meal', 
        'JNML' => 'Jain Meal', 
        'KSML' => 'Kosher Meal', 
        'KSMLS' => 'Kosher Meal (Snack)', 
        'LFML' => 'Low Fat Meal', 
        'NLML' => 'Low Lactose Meal', 
        'PRML' => 'Low Purin Meal', 
        'LPML' => 'Low Protein Meal', 
        'LSML' => 'Low Salt Meal', 
        'MOML' => 'Moslem Meal', 
        'ORML' => 'Oriental Meal', 
        'PFML' => 'Peanut Free Meal', 
        'RFML' => 'Refugee Meal (on United Airlines)', 
        'SFML' => 'Seafood Meal',
        'VJML' => 'Vegetarian Jain Meal', 
        'VLML' => 'Vegetarian Lacto-ovo Meal',
        'VOML' => 'Vegetarian Oriental Meal', 
        'RVML' => 'Vegetarian Raw Meal',
        'VVML' => 'Vegetarian Vegan Meal', 
        'VGML' => 'Vegetarian Vegan Meal', 
        'SPML/No Beef' => 'No Beef Meal', 
        'SPML/Liquid Diet' => 'Liquid Diet Meal',
        'LRML' => 'Low Residue Meal', 
        'LR' => 'Low Residue Meal', 
        'SF' => 'Seafood Meal'
    );


     $airEquipTypeArr = array(
     	'319' => 'Airbus',     	
     	'320' => 'Airbus', 
     	'321' => 'Airbus',
     	'332' => 'AIRBUS INDUSTRIE A330-200',
     	'333' => 'AIRBUS INDUSTRIE 330-300',
     	'350' => 'Airbus A350', 
     	'359' => 'AIRBUS A359',
     	'388' => 'AIRBUS INDUSTRIE A380-800',
     	'738' => 'BOEING 737-800', 
     	'739' => 'BOEING 737-900', 
     	'73J' => 'BOEING 737', 
     	'773' => 'BOEING 777-300', 
     	'777' => 'BOEING 777',
     	'772' => 'BOEING 777-200', 
     	'77W' => 'BOEING 777-300ER', 
     	'789' => 'BOEING 787-9'
     );

	$file_datas  = require_once('/var/www/html/ctctravel.org/fit/webservices/abacus/SWSWebservices.class.php');
	$rules_arr = array();

	$total_hotel_grand  = 0;
	$total_flight_grand = 0;
	$total_cruise_grand = 0;
	$total_ltour_grand  = 0;
	$cruiseExtra = 0;
	//disbale all notice warning
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	//end of disbale all notice warning
	if(isset($bookrefd)) $bookRefID = $bookrefd;

	$bookingOrder = $bookRefID;//'599ff5dbef457';
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
	$cp_title   = ""; $cp_fullname = ""; $cp_nric = ""; $cp_dob = ""; $cp_nationality = ""; $cp_address = ""; $cp_passportNo = "";
	$cp_contact = ""; $cp_email    = ""; $cp_passport_issue_date = ""; $cp_passport_expire_date = ""; $cp_remarks = "";
	$contacts = $this->All->select_template_w_2_conditions("bookOrderID", $bookingOrder, 'category', 'main', 'contact_person_information');

	if( $contacts == TRUE ) {
		foreach( $contacts AS $contact ) {
			$cp_title    			 = $contact->cp_title;
			/*$cp_dob    	  			 = $contact->cp_dob;*/
			$cp_fullname   			 = $contact->cp_fullname;
			/*$cp_nric    			 = $contact->cp_nric;
			$cp_nationality 		 = $contact->cp_nationality;*/
			$cp_email    			 = $contact->cp_email;
			/*
			$cp_passport_issue_date  = $contact->cp_passport_issue_date;
			$cp_passport_expire_date = $contact->cp_passport_expire_date;
			$cp_passport_no    	  	 = $contact->cp_passport_no;
			*/
			$cp_contact_no    	  	 = $contact->cp_contact_no;
			/*$cp_address    	  		 = $contact->cp_address;*/
			$cp_remarks    	  		 = $contact->cp_remarks;
		}
	}

	/* emergency Contact */
	$e_contacts = $this->All->select_template_w_2_conditions("bookOrderID", $bookingOrder, 'category !=', 'main', 'contact_person_information');
	if( $e_contacts == TRUE ) {
		foreach( $e_contacts AS $e_contact ) {
			$e_cp_title    			 = $e_contact->cp_title;
			/*$e_cp_dob    	  			 = $e_contact->cp_dob;*/
			$e_cp_fullname   			 = $e_contact->cp_fullname;
			/*$cp_nric    			 = $contact->cp_nric;
			$cp_nationality 		 = $contact->cp_nationality;*/
			$e_cp_email    			 = $e_contact->cp_email;
			/*
			$cp_passport_issue_date  = $contact->cp_passport_issue_date;
			$cp_passport_expire_date = $contact->cp_passport_expire_date;
			$cp_passport_no    	  	 = $contact->cp_passport_no;
			*/
			$e_cp_contact_no    	  	 = $e_contact->cp_contact_no;
			/*$cp_address    	  		 = $contact->cp_address;*/
			$e_cp_remarks    	  		 = $e_contact->cp_passport_issue_date;
			$e_relation = $e_contact->category;
		}
	}
	//end of contact purchase
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>CTC Travel - Pax Statement</title>
	<style type="text/css">p { text-align: center; }
	html, body {
		font-family:Courier; font-size: 13px;
		text-transform: uppercase;
	}
	</style>
</head>
<body>
<div style="width: 880px; margin:0 auto">
  	<table width="100%">
    	<tr>
			<td valign="bottom">
				<img width="120" src="<?php echo base_url(); ?>assets/default.png" />
			</td>
			<td valign="bottom">
				<div style="text-align:center;">
					<div style="font-size:18px;">Commonwealth Travel Service Corporation Pte Ltd</div>
					<div style="padding: 5px; font-size: 13px; border-radius:10px;">
			            <div>133 New Bridge Road, #03-03/04/05/06 Chinatown Point Singapore 059413</div>
			            <div>Tel: 6532 0532 Fax: 6532 0235 Website: www.ctc.com.sg</div>
			            <div>Email: enquiry@ctc.com.sg Online Travel Center-6216 3456 International Tours-6536 3995 Free & Easy-6536 3345 China-6536 4733 M.I.C.E.-6216 3455</div>
			            <div>Ticketing-6532 5552 Company Registration No. 199000981G</div>
          			</div>
        		</div>
        	</td>
    	</tr>
  	</table>

  	<p style="text-align:center;font-family:Courier; font-size: 18px;"><strong><u>PAX STATEMENT</u></strong></p>
  	<table cellpadding="1" cellspacing="0" style="width:100%">
    	<tr>
			<td width="200" valign="top"><strong style="font-family:Courier; font-size: 13px;">BOOKING NO</strong></td>
			<td width="10" valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td width="400" valign="top">
				<span style="font-family:Courier; font-size: 13px;"><?php echo $bookingOrder; ?></span>
			</td>
			<td width="10" valign="top">&nbsp;</td>
			<td width="100" valign="top"><strong style="font-family:Courier; font-size: 13px;">BOOKING DATE</strong></td>
			<td width="10" valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top" width="200">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php echo date("Y-m-d H:i:s", strtotime($bookingDate)); ?>
				</span>
			</td>
    	</tr>
    	<tr>
    		<td colspan="7">
				<p style="text-align:left;font-family:Courier; font-size: 14px;">
				  	<strong><u>CONTACT PERSON INFORMATION</u></strong>
				</p>
    		</td>
    	</tr>
  	<!-- <table cellpadding="1" cellspacing="0" style="width:100%"> -->
		<tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">NAME</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top"><span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
				<?php echo $cp_title; ?>. <?php echo $cp_fullname; ?>
			</td>
			<td valign="top" colspan="5">&nbsp;</td>
			<!--
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">DOB</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $cp_dob; ?></span>
			</td> -->

			<!-- <td valign="top"><strong style="font-family:Courier; font-size: 13px;">NRIC</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $cp_nric; ?></span>
			</td> -->
    	</tr>
    	<!-- <tr>
			<td valign="top">&nbsp;</td> -->
			<!-- <td valign="top"><strong style="font-family:Courier; font-size: 13px;">NATIONALITY</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php echo $cp_nationality; ?>
				</span>
			</td> -->
    	<!-- </tr> -->
		<!-- <tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">ADDRESS</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php echo $cp_address; ?>
				</span>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">PASSPORT NO</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php echo $cp_passport_no; ?>
				</span>
			</td>
    	</tr> -->
		<tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">CONTACT NO</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php echo $cp_contact_no; ?>
				</span>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">EMAIL</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php echo $cp_email; ?>
				</span>
			</td>
    	</tr>
    	<tr>
    		<td valign="top">
    			<strong style="font-family:Courier; font-size: 13px;">Passenger Remarks</strong>
    		</td>
    		<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
    		<td colspan="5">
    			<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
    				<?php echo $cp_remarks != '' ? $cp_remarks : '-'; ?>
    			</span>
    		</td>
    	</tr>
    	<!-- <tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">PASSPORT ISSUE DATE</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php echo $cp_passport_issue_date; ?>
				</span>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">PASSPORT EXPIRY DATE</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php echo $cp_passport_expire_date; ?>
				</span>
			</td>
    	</tr> -->
		<tr>
			<td colspan="7">
				<p style="text-align:left;font-family:Courier; font-size: 14px;">
	  			<strong><u>EMERGENCY CONTACT PERSON INFORMATION</u></strong>
				</p>
			</td>
		</tr>
  		<tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">NAME</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top"><span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
				<?php echo $e_cp_title; ?>. <?php echo $e_cp_fullname; ?>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">RELATIONSHIP</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $e_relation; ?></span>
			</td>
    	</tr>
		<tr>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">CONTACT NO</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php echo $e_cp_contact_no; ?>
				</span>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">EMAIL</strong></td>
			<td valign="top"><strong style="font-family:Courier; font-size: 13px;">:</strong></td>
			<td valign="top">
				<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
					<?php echo $e_cp_email; ?>
				</span>
			</td>
    	</tr>
  	</table>

		<!--CRUISE FARES-->
		<?php
		$cruiseChecks = $this->All->select_template("cruise_confirmedBookOrder_ID", $idUsed, "cruise_historyOrder");
		if( $cruiseChecks == TRUE ) {
			$countCruiseBuy = $this->Others->countCruiseHistoryOrder($idUsed);
		?><table width="100%" cellpadding="1" cellspacing="0" style="border-top: 1px solid black;">
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
		    $itemRecordCruiseRef = 1;
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
							$adultCartPriceRaw = $this->All->getIndividualPriceBasedAdult($itemDetail->stateroomID, $itemDetail->shipID, $itemDetail->brandID, $itemDetail->durationNight, $itemDetail->cruisePriceType, $itemDetail->noofAdult, $itemDetail->noofChild);
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
				<?php
				if( $itemDetail->noofChild > 0 ) {
				?>
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
							$childCartPrice = number_format($this->All->getIndividualPriceBasedChild($itemDetail->stateroomID, $itemDetail->shipID, $itemDetail->brandID, $itemDetail->durationNight, $itemDetail->cruisePriceType, $itemDetail->noofAdult, $itemDetail->noofChild), 2);
							$childCartPriceRaw = $this->All->getIndividualPriceBasedChild($itemDetail->stateroomID, $itemDetail->shipID, $itemDetail->brandID, $itemDetail->durationNight, $itemDetail->cruisePriceType, $itemDetail->noofAdult, $itemDetail->noofChild);
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
				}
				else {
					$childCartPrice = 0;
					$childCartPriceRaw = 0;
				}
				?>
				<?php
				$cruiseExtra = "";
				if( $itemDetail->extraIDs != "" && $itemDetail->extraIDs != "-" ) {
					$qtyCharge = $itemDetail->noofAdult+$itemDetail->noofChild;
					$extraT = $this->All->getSumExtraPrices($itemDetail->extraIDs)*$qtyCharge;
					$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
					$extraCharges_res = mysqli_query(
						$connection, "SELECT * FROM cruise_extra_price WHERE id IN(".$itemDetail->extraIDs.")"
					);
					if( mysqli_num_rows($extraCharges_res) > 0 ) {
						while( $extraCharges_row = mysqli_fetch_array($extraCharges_res, MYSQL_ASSOC) ) {
							$cruiseExtra += $extraCharges_row["extra_price_value"]*$qtyCharge;
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
							&nbsp;* <?php echo $qtyCharge; ?>
						</span>
					</td>
					<td align="right" valign="top">
						<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
							<b>$<?php echo number_format($extraCharges_row["extra_price_value"]*$qtyCharge, 2); ?></b>
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
				<tr>
					<td valign="top" colspan="4">
						<span style="font-family:Courier; font-size: 13px;">
							<span style="font-family:Courier; font-size: 13px; text-transform: uppercase; text-decoration:underline">
								Guest List
							</span>
						</span>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="4">
						<span style="font-family:Courier; font-size: 13px;">
							<?php
							$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
						 	$check_res  = mysqli_query(
								$connection,
								"
									SELECT * FROM cruise_paxName WHERE bookingID = '".$bookingOrder."'
									AND cruise_title_id = ".$itemDetail->cruiseTitleID."
									AND itemRecordRef = ".$itemRecordCruiseRef."
								"
							);
							if( mysqli_num_rows($check_res) > 0 ) {
								$na = 1;
								while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
							?>
							<div style="float:left; width:35%">
								<span style="font-family:Courier; font-size: 11px; text-transform: uppercase">
									<?php echo $na; ?>.
									(<?php echo $check_row["pax_type"]; ?>)
									<?php echo $check_row["pax_title"]; ?>. <?php echo $check_row["pax_fullname"]; ?>
								</span>
							</div>
							<?php
									$na++;
								}
							}
							?>
						</span>
					</td>
				</tr>
				<tr>
			      	<td valign="top" colspan="4">
				      	<span style="font-family:Courier; font-size: 13px;">GST @ 0% on $</span>
				      	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
				      		<?php echo number_format($grand_total, 2); ?>
				      	</span>
				      </td>
			    </tr>
			<?php
				$itemRecordCruiseRef++;
			}
			?>
		    <tr>
		      	<td valign="top"><strong style="font-family:Courier; font-size: 13px;">TOTAL :</strong> </td>
			  	<td align="right" valign="top"><span style="font-family:Courier; font-size: 13px;"></span></td>
			  	<td align="right" valign="top"><span style="font-family:Courier; font-size: 13px;">$</span></td>
			  	<td align="right" valign="top">
				  	<span style="font-family:Courier; font-size: 13px; border-top: 1px solid black; border-bottom: 4px black double">
				  		<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
				  			<?php
					  		$total_cruise_grand += $adultCartPriceRaw+$childCartPriceRaw+$extraT;
					  		echo number_format($adultCartPriceRaw+$childCartPriceRaw+$extraT, 2);
					  		?>
				  		</span>
				  	</span>
				</td>
		    </tr>
		    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
		    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
		  </table>
		<?php
		}
		?>
		<!--END OF CRUISE FARES-->

		<!--LANDTOUR FARES-->
		<?php
        $childWBPrice = "";
        $landtourChecks = $this->All->select_template("landtour_confirmedBookOrder_ID", $idUsed, "landtour_history_order");
        if( $landtourChecks == TRUE ) {
        ?>
            <table width="100%" cellpadding="1" cellspacing="0" style="border-top: 1px solid black;">
                <tr>
                    <td valign="top"><strong style="font-family:Courier; font-size: 13px;">LAND TOUR FARES</strong> </td>
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
                        <strong style="font-family:Courier; font-size: 13px;">&nbsp;</strong>
                    </td>
                </tr>
            </table>
            <!--FIRST RECORD-->
            <?php
            $itemRecordRef = $countCruiseBuy+1;
            $itemDetails = $this->All->select_template("landtour_confirmedBookOrder_ID", $idUsed, "landtour_history_order");
            if( $itemDetails == TRUE ) {
                foreach( $itemDetails AS $itemDetail ) {
                    //landtourProduct
                    $products = $this->All->select_template("id", $itemDetail->landtour_product_id, "landtour_product");
                    foreach( $products AS $product ) {
                        $product_id             = $product->id;
                        $product_lt_tourID      = $product->lt_tourID;
                        $product_lt_title       = $product->lt_title;
                        $product_start_country  = $product->start_country;
                        $product_start_city     = $product->start_city;
                        $product_end_country    = $product->end_country;
                        $product_end_city       = $product->end_city;
                    }
                    //end of landtourProduct
                    //landtour system prices
                    $others = $this->All->select_template(
                        "id", $itemDetail->landtour_system_price_id, "landtour_system_prices"
                    );
                    if( $others == TRUE ) {
                        foreach( $others AS $other ) {
                            $adultSingle_price  = $other->adultSingle_price;
                            $adultTwin_price    = $other->adultTwin_price;
                            $adultTriple_price  = $other->adultTriple_price;
                            $child_wb_price     = $other->child_wb_price;
                            $child_wob_price    = $other->child_wob_price;
                            $child_half_price   = $other->child_half_twin_price;
                            $infant_price       = $other->infant_price;
                            $price_date         = $other->price_date;
                            $current_price_date = date("d/m/Y", strtotime($other->price_date));
                            $roomCombinationQty = $other->roomCombinationQty;
                            $ticketAdultPrice   = $other->ticketAdultPrice;
                            $ticketChildPrice   = $other->ticketChildPrice;
                        }
                    }
                    //end of landtour system prices
            ?>
                <table width="100%" cellpadding="1" cellspacing="0">
                    <tr>
                        <td valign="top">
                            <strong style="font-family:Courier; font-size: 13px;">
                                <?php echo $product_lt_title; ?> (<?php echo $product_lt_tourID; ?>)
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
                </table>

                <?php
                if( $itemDetail->sellingType == "ticket" ) {
                    $paxDetails = explode("~", $itemDetail->paxDetails);
                ?>
                    <table width="100%" cellpadding="1" cellspacing="0" >
                        <tr>
                            <td valign="top">
                                <strong style="font-family:Courier; font-size: 13px;">
                                    Ticket Details -
                                    <?php echo $paxDetails[0]; ?> Adult(s) &
                                    <?php echo ($paxDetails[1] != "") ? $paxDetails[1] : 0; ?> Child(s)
                                </strong>
                            </td>
                            <td valign="top"></td>
                            <td width="80" valign="top"></td>
                            <td align="right" valign="top" style="width: 100px">
                                <strong style="font-family:Courier; font-size: 13px;">&nbsp;</strong>
                            </td>
                        </tr>
                        <?php
                        if( $paxDetails[0] > 0 ) {
                        ?>
                            <tr>
                                <td valign="top">
                                    <span style="font-family:Courier; font-size: 13px;">
                                        <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                            ADULT TICKET
                                        </span>
                                    </span>
                                </td>
                                <td align="right" valign="top">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        $<?php echo number_format($ticketAdultPrice, 2); ?>
                                    </span>
                                </td>
                                <td align="left" valign="top">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        &nbsp;* <?php echo $paxDetails[0]; ?>
                                    </span>
                                </td>
                                <td align="right" valign="top">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        <b>
                                            $
                                            <?php
                                                $total_ltour_grand += $ticketAdultPrice*$paxDetails[0];
                                                echo number_format($ticketAdultPrice*$paxDetails[0], 2);
                                            ?>
                                        </b>
                                    </span>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <?php
                        if( $paxDetails[1] > 0 ) {
                        ?>
                            <tr>
                                <td valign="top">
                                    <span style="font-family:Courier; font-size: 13px;">
                                        <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                            CHILD TICKET
                                        </span>
                                    </span>
                                </td>
                                <td align="right" valign="top">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        $<?php echo number_format($ticketChildPrice, 2); ?>
                                    </span>
                                </td>
                                <td align="left" valign="top">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        &nbsp;* <?php echo $paxDetails[1]; ?>
                                    </span>
                                </td>
                                <td align="right" valign="top">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        <b>
                                            $
                                            <?php
                                                $total_ltour_grand += $ticketChildPrice*$paxDetails[1];
                                                echo number_format($ticketChildPrice*$paxDetails[1], 2);
                                            ?>
                                        </b>
                                    </span>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                        </tr>
                    </table>
                <?php
                }
                else {

                    $paxDetails = explode("~", $itemDetail->paxDetails);
                    for($r=1; $r<=$itemDetail->countRoom; $r++) {
                        $paxGetQty  = explode(".", $paxDetails[$r-1]);
                    ?>
                    <table width="100%" cellpadding="1" cellspacing="0" >
                        <tr>
                            <td valign="top">
                                <strong style="font-family:Courier; font-size: 13px;">
                                    ROOM <?php echo $r; ?> - NO. OF PAX: <?php echo $paxGetQty[0]; ?> Adult(s)
                                    &
                                    <?php echo $paxGetQty[1]+$paxGetQty[2]+$paxGetQty[4]; ?> Child(s)
                                    &
                                    <?php echo $paxGetQty[3]; ?> Infant(s)
                                </strong>
                            </td>
                            <td valign="top"></td>
                            <td width="80" valign="top"></td>
                            <td align="right" valign="top" style="width: 100px">
                                <strong style="font-family:Courier; font-size: 13px;">&nbsp;</strong>
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
                            <td valign="top">
                                <span style="font-family:Courier; font-size: 13px;">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        PAX ADULT
                                    </span>
                                </span>
                            </td>
                            <td align="right" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    $<?php echo number_format($adultPrice, 2); ?>
                                </span>
                            </td>
                            <td align="left" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    &nbsp;* <?php echo $paxGetQty[0]; ?>
                                </span>
                            </td>
                            <td align="right" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    <b>
                                        $
                                        <?php
                                            $total_ltour_grand += $adultPrice*$paxGetQty[0];
                                            echo number_format($adultPrice*$paxGetQty[0], 2);
                                        ?>
                                    </b>
                                </span>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php
                        if( $paxGetQty[1] > 0 ) {
                            if( $paxGetQty[0] == 1 && $paxGetQty[1] == 1 ) {
                                $childWBPrice = $child_half_price;
                            }
                            else {
                                $childWBPrice = $child_wb_price;
                            }
                        ?>
                        <tr>
                            <td valign="top">
                                <span style="font-family:Courier; font-size: 13px;">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        PAX CHILD WITH BED (<?php echo $half_price; ?>)
                                    </span>
                                </span>
                            </td>
                            <td align="right" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    $<?php echo number_format($childWBPrice, 2); ?>
                                </span>
                            </td>
                            <td align="left" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    &nbsp;* <?php echo $paxGetQty[1]; ?>
                                </span>
                            </td>
                            <td align="right" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    <b>
                                        $
                                        <?php
                                            $total_ltour_grand += $childWBPrice*$paxGetQty[1];
                                            echo number_format($childWBPrice*$paxGetQty[1], 2);
                                        ?>
                                    </b>
                                </span>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php
                        if( $paxGetQty[2] > 0 ) {
                        ?>
                        <tr>
                            <td valign="top">
                                <span style="font-family:Courier; font-size: 13px;">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        PAX CHILD WITHOUT BED
                                    </span>
                                </span>
                            </td>
                            <td align="right" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    $<?php echo number_format($child_wob_price, 2); ?>
                                </span>
                            </td>
                            <td align="left" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    &nbsp;* <?php echo $paxGetQty[2]; ?>
                                </span>
                            </td>
                            <td align="right" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    <b>
                                        $
                                        <?php
                                            $total_ltour_grand += $child_wob_price*$paxGetQty[2];
                                            echo number_format($child_wob_price*$paxGetQty[2], 2);
                                        ?>
                                    </b>
                                </span>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php
                        if( $paxGetQty[4] > 0 ) {
                        ?>
                        <tr>
                            <td valign="top">
                                <span style="font-family:Courier; font-size: 13px;">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        PAX HALF CHILD
                                    </span>
                                </span>
                            </td>
                            <td align="right" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    $<?php echo number_format($child_half_price, 2); ?>
                                </span>
                            </td>
                            <td align="left" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    &nbsp;* <?php echo $paxGetQty[4]; ?>
                                </span>
                            </td>
                            <td align="right" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    <b>
                                        $
                                        <?php
                                            $total_ltour_grand += $child_half_price*$paxGetQty[4];
                                            echo number_format($child_half_price*$paxGetQty[4], 2);
                                        ?>
                                    </b>
                                </span>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php
                        if( $paxGetQty[3] > 0 ) {
                        ?>
                        <tr>
                            <td valign="top">
                                <span style="font-family:Courier; font-size: 13px;">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        PAX INFANT
                                    </span>
                                </span>
                            </td>
                            <td align="right" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    $<?php echo number_format($infant_price, 2); ?>
                                </span>
                            </td>
                            <td align="left" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    &nbsp;* <?php echo $paxGetQty[3]; ?>
                                </span>
                            </td>
                            <td align="right" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    <b>
                                        $
                                        <?php
                                            $total_ltour_grand += $infant_price*$paxGetQty[3];
                                            echo number_format($infant_price*$paxGetQty[3], 2);
                                        ?>
                                    </b>
                                </span>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                        </tr>
                    </table>
                    <table width="100%" cellpadding="1" cellspacing="0" >
                        <tr>
                            <td valign="top" colspan="4">
                                <span style="font-family:Courier; font-size: 13px;">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase; text-decoration:underline">
                                        Guest List <?php echo $itemRecordRef; ?>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <span style="font-family:Courier; font-size: 13px;">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        <b>Name of Passenger(s)</b>
                                    </span>
                                </span>
                            </td>
                            <td align="left" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    <b>Passenger Type</b>
                                </span>
                            </td>
                            <td align="left" valign="top"><span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>Passenger Date of Birth</b></span></td>
                            <td align="left" valign="top"><span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>Passport Detail</b></span></td>
                        </tr>

                        <?php
                        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                        $check_res  = mysqli_query(
                            $connection,
                            "
                                SELECT * FROM landtour_paxname
                                WHERE bookingID = '".$bookingOrder."'
                                AND landtour_product_id = ".$itemDetail->landtour_product_id."
                                AND roomIndex = ".$r."
                            "
                        );
                        if( mysqli_num_rows($check_res) > 0 ) {
                            $na = 1;
                            while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                                $passName = $check_row['pax_surname'].'/'.$check_row['pax_givenname'];
                                $paxType = str_replace("CHILD_WITHOUT_BED", "CHILD_W/O_BED", $check_row["pax_type"]);
                                $paxType = str_replace("CHILD_WITH_BED", "CHILD_W_BED", $paxType);
                        ?>
                        <tr>
                            <td valign="top">
                               <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $na;?>. <?php echo $check_row['paxTitle'] != "" ? $passName . $check_row['paxTitle']: $passName;?><br>
                            	Nationality: <?php echo $check_row['paxNationality'];?></span>
                            </td>
                            <td align="left" valign="top">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $paxType;?></span>
                            </td>
                            <td align="left" valign="top"><span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $check_row['paxDOB'];?></span></td>
                            <td align="left" valign="top">
                            	<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                            	PASS NO: <?php echo strtoupper($check_row['paxPassportNo']);?>
                            	<br>Issue: <?php echo $check_row['paxPassportIssueCountry'];?>
                            	<br>Issue: <?php echo $check_row['paxPassportIssueDate'];?>
                            	<br>Expiry: <?php echo $check_row['paxPassportExpiryDate'];?>
                            	</span>
                            </td>
                        </tr>
                        <?php
                                $na++;
                            }
                        }
                        echo '</table>';
                    }
                }
                $itemRecordRef++;
            }
        }
        ?>
        <br><br>
        <table width="100%" cellpadding="1" cellspacing="0" style="border-top: 1px solid black;">
            <!--END OF FIRST RECORD-->
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
                            <?php echo number_format($total_ltour_grand, 2); ?>
                        </span>
                    </span>
                </td>
            </tr>
        <?php
        }
        ?>
        <!--END OF LANDTOUR FARES-->

    </table>
    <table width="100%" cellpadding="1" cellspacing="0" style="border-top: 1px solid black;">
		<!--END OF LANDTOUR FARES-->

		<!--HOTEL FARES-->
		<?php
        $hotelDetails = $this->All->select_template("hotel_confirmedBookOrder_ID", $idUsed, "hotel_historyOder");

        $gtabookingdata = $this->All->select_template("bookingorderid", $bookingOrder, "hotel_booking_jsondata");
        if( $hotelDetails == TRUE && $gtabookingdata == TRUE ) {
        	$arrJSON = json_decode($gtabookingdata[0]->bookingjsondata, true);
		    $bookingRef = $arrJSON['BOOKINGS']['BOOKING']['BOOKINGREFERENCES']['BOOKINGREFERENCE'];

		    $bkID = "";
		    foreach($bookingRef as $bookRefd) {
		        if($bookRefd['REFERENCESOURCE'] == 'api') {
		            $bkID = $bookRefd['content'];
		        }
		    }
	    ?>
			<tr>
	            <td valign="top">
	                <strong style="font-family:Courier; font-size: 13px;">
	                    &nbsp;
	                </strong>
	            </td>
	            <td valign="top"></td>
	            <td width="80" valign="top"></td>
	            <td align="right" valign="top" style="width: 100px">&nbsp;
	            </td>
	        </tr>
	    <?php
        $na = 1;
            foreach( $hotelDetails AS $hotelDetail ) {
	    ?>
		    	<!--LOOP-->
	            <tr>
	                <td valign="top">
	                    <strong style="font-family:Courier; font-size: 13px;">
	                        <?php echo $hotelDetail->hotel_Fullname; ?> (<?php echo $hotelDetail->hotel_ItemCode; ?>)
	                        -
	                        <?php echo $hotelDetail->hotel_ItemCityCode; ?>
	                    </strong>
	                </td>
	                <td align="right" valign="top" colspan="3">
	                    <strong style="font-family:Courier; font-size: 13px;">(Booking Ref. ID <?php echo $bkID;?>)</strong>
	                </td>
	            </tr>
	            <tr>
	                <td colspan="4" style="border-top: 1px solid black"></td>
	            </tr>
	            <tr>
		            <td valign="top"><strong style="font-family:Courier; font-size: 13px;">HOTEL FARES</strong> </td>
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
		                <strong style="font-family:Courier; font-size: 13px;">&nbsp;</strong>
		            </td>
		        </tr>
	            <tr>
	                <td valign="top">
	                    <span style="font-family:Courier; font-size: 13px;">
	                        <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                            Checkin: <?php echo date("Y F d", strtotime($hotelDetail->check_in_date)); ?>
	                        </span>
	                    </span>
	                </td>
	                <td align="right" valign="top">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        Checkout: <?php echo date("Y F d", strtotime($hotelDetail->check_out_date)); ?>
	                    </span>
	                </td>
	                <td align="right" valign="top" width="80"></td>
	                <td align="right" valign="top" width="100"></td>
	            </tr>
	            <tr>
	                <td valign="top">
	                    <span style="font-family:Courier; font-size: 13px;">
	                        <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                            ROOM TYPE: <?php echo $hotelDetail->hotel_RoomType; ?>
	                        </span>
	                    </span>
	                </td>
	                <td align="right" valign="top">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        <?php echo $hotelDetail->duration; ?> night(s) & <?php echo $hotelDetail->hotel_RoomQuantity; ?> room(s)
	                    </span>
	                </td>
	                <td align="right" valign="top"></td>
	                <td align="right" valign="top"></td>
	            </tr>
	            <tr>
	            	<td valign="top">
	            		<span style="font-family:Courier; font-size: 13px;">
	                        <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                            Meals : <?php echo $hotelDetail->room_meal; ?> Breakfast
	                        </span>
	                    </span>
	            	</td>
	            	<td></td>
	            	<td></td>
	            	<td></td>
	            </tr>
	            <tr>
	                <td valign="top">
	                    <span style="font-family:Courier; font-size: 13px;">
	                        <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                            Price per night
	                        </span>
	                    </span>
	                </td>
	                <td align="right" valign="top">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        <?php
	                        $pricePerNight = ($hotelDetail->hotel_PricePerRoom/$hotelDetail->duration);
	                        $pricePerNight = ceil($pricePerNight);
	                        ?>
	                        $<?php echo number_format($pricePerNight, 2); ?>
	                    </span>
	                </td>
	                <td align="left" valign="top">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        &nbsp;
	                    </span>
	                </td>
	                <td align="right" valign="top">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        <b>--</b>
	                    </span>
	                </td>
	            </tr>
	            <tr>
	                <td valign="top">
	                    <span style="font-family:Courier; font-size: 13px;">
	                        <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                            Pax Statement
	                        </span>
	                    </span>
	                </td>
	                <td align="right" valign="top">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        <?php echo $hotelDetail->hotel_AdultQuantity; ?> Adult(s)
	                        &
	                        <?php echo $hotelDetail->hotel_ChildQuantity; ?> Child(s)
	                        &
	                        <?php echo $hotelDetail->hotel_InfantQuantity; ?> Infant(s)
	                    </span>
	                </td>
	                <td align="left" valign="top">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        &nbsp;
	                    </span>
	                </td>
	                <td align="right" valign="top">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        <b>--</b>
	                    </span>
	                </td>
	            </tr>
	            <tr>
	                <td valign="top">
	                    <span style="font-family:Courier; font-size: 13px;">
	                        <span style="font-family:Courier; font-size: 13px; text-transform: uppercase; font-weight: bold">
	                            Total Price
	                            <?php
	                            $grand_totalHotel += $pricePerNight*$hotelDetail->duration;
	                            ?>
	                        </span>
	                    </span>
	                </td>
	                <td align="right" valign="top">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        $<?php echo number_format($pricePerNight*$hotelDetail->duration, 2); ?>
	                    </span>
	                </td>
	                <td align="left" valign="top">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        &nbsp;
	                    </span>
	                </td>
	                <td align="right" valign="top">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        <b>$<?php echo number_format($pricePerNight*$hotelDetail->duration, 2); ?></b>
	                    </span>
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


	            <tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
				</tr>
				<tr>
					<td valign="top" colspan="4">
						<span style="font-family:Courier; font-size: 13px;">
							<span style="font-family:Courier; font-size: 13px; text-transform: uppercase; text-decoration:underline">
								Guest List
							</span>
						</span>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="4">
						<span style="font-family:Courier; font-size: 13px;">
							<?php
							$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
						 	$check_res  = mysqli_query(
								$connection,
								"
									SELECT DISTINCT adult_or_child as paxage, paxname, flag_room  FROM hotel_paxName WHERE bookingID = '".$bookingOrder."' AND RoomTypeID='".$hotelDetail->hotel_RoomTypeID."' AND flag_room = '".$hotelDetail->room_index."'
								"
							);
							if( mysqli_num_rows($check_res) > 0 ) {
								while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
									for($i = 1; $i <= $hotelDetail->hotel_RoomQuantity; $i++) {
										if($check_row['flag_room'] == $i) {
							?>
								<div>
									<span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
										<?php echo $na; ?>.
										(<?php echo $check_row["paxage"]; ?>) Room <?php echo $check_row['flag_room'];?> -
										<?php echo $check_row["paxname"]; ?>
									</span>
								</div>
							<?php
										}
									}
								}
							}
							?>
						</span>
					</td>
				</tr>
                <tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
				</tr>
                <?php
                /*$specialRequests = $this->All->select_template("bookingRefID", $bookingOrder, "hotel_historyOder");
                if( $specialRequests == TRUE ) {
                    foreach( $specialRequests AS $specialRequest ) {*/
                        $sp = $hotelDetail->hotelAPISpecialRequest;
                    //}
                    if( $sp != NULL ) {
                        $explodeSP = explode(",", $sp);
                ?>
                <tr>
                    <td valign="top" colspan="4">
                        <div><strong style="font-family:Courier; font-size: 13px;">SPECIAL REQUEST</strong></div>
                        <ol>
                            <?php
                            if( count($explodeSP) > 0 ) {
                                foreach( $explodeSP AS $value ) {
                                    $specials = $this->All->select_template("remarkCode", $value, "hotel_specialRequest");
                                    if( $specials == TRUE ) {
                                        foreach( $specials AS $special ) {
                                            $remarkContent = $special->remarkContent;
                                        }
                                    }
                            ?>
                            <li style="font-family:Courier; font-size: 13px;">
                                <?php echo $remarkContent; ?>
                            </li>
                            <?php
                                }
                            }
                            ?>
                        </ol>
                        <div style="font-size:10px; margin-bottom: 20px">
	                        <b>*Note: All special requests are subject to hotel availability and confirmation upon check-in</b>
	                        <br />
	                    </div>
                    </td>
                </tr>
                <?php
                    }

                    $na++;
                ?>
	            <!--END OF LOOP-->
	    <?php
	        }
	    ?>

	        <tr><td valign="top" colspan="4" style="border-top:1px solid black">&nbsp;</td></tr>
	        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
	    <?php
	    }
        ?>
		<!--END OF HOTEL FARES-->

		<tr><td valign="top" colspan="4">&nbsp;</td></tr>
		<tr><td valign="top" colspan="4">&nbsp;</td></tr>
		<!--FLIGHT FARES-->
		<?php
			$flightConfirms = $this->All->select_template("bookingRefID", $bookingOrder, "flight_history_order");
        	/*$flightDetails  = $this->All->select_template("flight_confirmedBookOrder_ID", $idUsed, "flight_history_order");*/
             $arrFlightClassType = array('Y' => 'Economy Seat', 'S' => 'Premium Seat', 'C' => 'Business Seat', 'J' => 'Premium Business Seat', 'F' => 'First Class Seat', 'P' => 'Premium First Class Seat');
			if( $flightConfirms == TRUE ) {
				$xxx = 1;

	            foreach( $flightConfirms AS $flightConfirm )
	            {
	        ?>
        	        <!--NEW DESIGN HERE-->
        			<tr>
        	            <td valign="top" colspan="4">
        	                <span style="font-family:Courier; font-size: 13px;">
        	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
        	                        <b>[ -- Flight Information -- ]</b>
        	                        <br />
        	                        <span>PNR Reference Code: <b><?php echo $flightConfirm->flight_PNR;?></b></span>
        	                    </span>
        	                </span>
        	            </td>
        	        </tr>
        	        <tr>
        	            <td valign="top">
        	                <span style="font-family:Courier; font-size: 13px;">
        	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
        	                        <b>Name of Passenger(s)</b>
        	                    </span>
        	                </span>
        	            </td>
        	            <td align="left" valign="top">
        	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
        	                	<b>Passenger Type</b>
        	                </span>
        	            </td>
        	            <td align="left" valign="top"><span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>Passenger Date of Birth</b></span></td>
        	            <td align="left" valign="top"><span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>Passport Detail</b></span></td>
        	        </tr>
        	        <?php
                	$flightPassenger = $this->All->select_template_w_2_conditions("bookingOrderID", $bookingOrder, "passengerCartID", $xxx, "flight_passenger_pnr_details");
                    if( $flightPassenger == TRUE ) {
                        $idx = 1;
                        $passTypeDesc = array(
                        					'adult' => 'Adult<br>(12 Years Old & Above)',
                        					'child' => 'Children<br>(2 years above & Below 12 Years Old)',
                        					'infant' => 'Infant<br>(Below 2 Years Old)'
                        				);
                        foreach ($flightPassenger as $pass)
                        {
                        	$passName = $pass->passenger_surname.'/'.$pass->passenger_givenname;
        	        ?>
        	        <tr>
        	            <td valign="top">
        	               <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $idx;?>. <?php echo $pass->passengerTitle != "" ? $passName . $pass->passengerTitle: $passName;?><br>
                        Nationality: <?php echo $pass->passengerNationality;?></span>
        	            </td>
        	            <td align="left" valign="top">
        	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $passTypeDesc[strtolower($pass->passengerType)];?></span>
        	            </td>
        	            <td align="left" valign="top"><?php echo $pass->passengerDOB;?></td>
        	            <td align="left" valign="top"><b>PASS NO</b>: <?php echo strtoupper($pass->passengerPassportNo);?>
                        <br><b>Issue</b>: <?php echo $pass->passengerPassportIssueCountry;?>
                        <br><b>Issue</b>: <?php echo $pass->passengerPassportIssueDate;?>
                        <br><b>Expiry</b>: <?php echo $pass->passengerPassportExpiryDate;?>
                        </td>
        	        </tr>
        	        <?php
        	        	$idx++;
        	        	}
        	        }

        	        ?>
        	        <tr><td valign="top" colspan="4">&nbsp;</td></tr>
        	        <tr>
        	            <td valign="top" colspan="4">
        	                <span style="font-family:Courier; font-size: 13px;">
        	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
        	                        <b>Flight Itinerary</b>
        	                    </span>
        	                </span>
        	            </td>
        	        </tr>
        	        <tr>
        	            <td valign="top">
        	                <span style="font-family:Courier; font-size: 13px;">
        	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>Departing</b></span>
        	                </span>
        	            </td>
        	            <td align="left" valign="top">
        	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>Arriving</b></span>
        	            </td>
                        <td align="left" valign="top" style="width:150px">
                            <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>Flight Details</b></span>
                        </td>
        	            <td align="left" valign="top" style="width:150px">
        		            <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>STOP / EQP / FLYING TIME / SERVICES</b></span>
        	            </td>
        	        </tr>
                	<?php

                    if( strpos($flightConfirm->departureFlightName, '~') !== FALSE )
                    {
                        //indirect
                        $explodeCount = explode("~", $flightConfirm->departureFlightName);
                        for($xe=0; $xe<count($explodeCount); $xe++)
                        {
                            $arrDepartureFlightName         = explode("~", $flightConfirm->departureFlightName);
                            $arrDepartureFlightCode         = explode("~", $flightConfirm->departureFlightCode);
                            $arrDepartureTimeTaken          = explode("~", $flightConfirm->departureTimeTaken);
                            $arrDepartureDateFrom           = explode("~", $flightConfirm->departureDateFrom);
                            $arrDepartureDateTo             = explode("~", $flightConfirm->departureDateTo);
                            $arrDepartureTimeFrom           = explode("~", $flightConfirm->departureTimeFrom);
                            $arrDepartureTimeTo             = explode("~", $flightConfirm->departureTimeTo);
                            $arrDepartureCityNameFrom       = explode("~", $flightConfirm->departureCityNameFrom);
                            $arrDepartureCityNameTo         = explode("~", $flightConfirm->departureCityNameTo);
                            $arrDepartureCityCodeFrom       = explode("~", $flightConfirm->departureCityCodeFrom);
                            $arrDepartureCityCodeTo         = explode("~", $flightConfirm->departureCityCodeTo);
                            $arrDepartureAirportNameFrom    = explode("~", $flightConfirm->departureAirportNameFrom);
                            $arrDepartureAirportNameTo      = explode("~", $flightConfirm->departureAirportNameTo);
                            $arrDepartureBaggage            = explode("~", $flightConfirm->departureBaggage);
                            $arrDepartureMeal               = explode("~", $flightConfirm->departureMeal);
                            $arrDepartureMealCode               = explode("~", $flightConfirm->departuremealcode);
                            $arrDepartureFlightEquip               = explode("~", $flightConfirm->departureFlightAirEquipType);
                            $arrDepartureTerminalID_from			= explode("~", $flightConfirm->departureTerminalID_from);
                            $arrDepartureTerminalID_to			= explode("~", $flightConfirm->departureTerminalID_to);
                            $departureFlightClass = $flightConfirm->flightClass;

                            $arrDepartureTimeTaken[$xe] = str_replace("hours", "Hrs", strtolower($arrDepartureTimeTaken[$xe]));
                            $arrDepartureTimeTaken[$xe] = str_replace("minutes", "Mins", strtolower($arrDepartureTimeTaken[$xe]));

                            $airportNameDeparture = str_replace("International", "Int'l", $arrDepartureAirportNameFrom[$xe]);
                            $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $airportNameDeparture);
                            $airportNameDepartureTo = str_replace("International", "Int'l", $arrDepartureAirportNameTo[$xe]);
                            $airportNameDepartureTo = str_replace("Kuala Lumpur", "KL", $airportNameDepartureTo);

                            if ($xe >= 1)
                            {
                                echo '<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4">Transit Flight</td></tr>';
                            }
                    ?>
                            <tr>
                                <td valign="top">
                                    <span style="font-family:Courier; font-size: 13px;">
                                        <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        	<b><?php echo $airportNameDeparture; ?></b>
                                        	<br />
                                        	<span>Terminal <?php echo $arrDepartureTerminalID_from[$xe];?></span>
                                        	<br />
                                        	<span><?php echo date("d M Y", strtotime($arrDepartureDateFrom[$xe])); ?><span>
                                        	<br />
                                        	<span><?php echo date("H:i", strtotime($arrDepartureTimeFrom[$xe])); ?></span>
                                        </span>
                                    </span>
                                </td>
                                <td valign="top">
                                    <span style="font-family:Courier; font-size: 13px;">
                                        <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                        	<b><?php echo $airportNameDepartureTo; ?></b>
                                        	<br />
                                        	<span>Terminal <?php echo $arrDepartureTerminalID_to[$xe];?></span>
                                        	<br />
                                        	<span><?php echo date("d M Y", strtotime($arrDepartureDateTo[$xe])); ?><span>
                                        	<br />
                                        	<span><?php echo date("H:i", strtotime($arrDepartureTimeTo[$xe])); ?></span>
                                        </span>
                                    </span>
                                </td>
                                <td valign="top">
                                    <span><?php echo $arrDepartureFlightName[$xe];?></span>
                                    <br />
                                    <span><?php echo $arrDepartureFlightCode[$xe];?></span>
                                    <br />
                                    <span><?php echo $arrFlightClassType[$departureFlightClass];?></span>
                                </td>
                                <td valign="top">
                                	DIRECT<br/>
                                    <!-- <span></span>
                                    <br />
                                     -->
                                     <?php
                                     if($arrDepartureFlightEquip[$xe] != '' && isset($airEquipTypeArr[$arrDepartureFlightEquip[$xe]])) {
	                                     $airtype = $airEquipTypeArr[$arrDepartureFlightEquip[$xe]];
	                                     if($airtype === 'undefined' || $airtype == '') {
	                                     	if (substr($arrDepartureFlightEquip[$xe], 0, 1) === '7') { $airtype = 'Boeing' . $arrDepartureFlightEquip[$xe];}
	                                        else if (substr($arrDepartureFlightEquip[$xe], 0, 1) === '3') { $airtype = 'Airbus';}
	                                     }
	                                 } else $airtype = 'Airbus';

                                    ?>
                                    <span><?php echo $airtype;?></span>
                                    <br />
                                    <span><?php echo $arrDepartureTimeTaken[$xe];?></span>
                                    <br />
                                    <!-- <span><?php echo $arrFlightClassType[$departureFlightClass];?></span> -->
                                    <?php ?>
                                    <span>
                                    <?php
                                //if(strlen($arrDepartureMealCode[$xe]) != 1 && strlen($arrDepartureMealCode[$xe]) != 4) {
                                    //$arrMC = str_split($arrDepartureMealCode[$xe]);
                                    //for($idxArr=0; $idxArr < count($arrMC); $idxArr++) {
                                    //echo $mealCodeArray[$arrMC[$idxArr]];
                                    //}
                                //} else {
                                //    echo $mealCodeArray[$arrDepartureMealCode[$xe]];
                                //}
                                if(isset($mealCodeArray[$arrDepartureMealCode[$xe]])){
                                	echo $mealCodeArray[$arrDepartureMealCode[$xe]];
                                } else {
                                	$arrMC = str_split($arrDepartureMealCode[$xe]);
                                    for($idxArr=0; $idxArr < count($arrMC); $idxArr++) {
                                    echo $mealCodeArray[$arrMC[$idxArr]]." ";
                                    }
                                }
                                ?></span>
                                </td>
                            </tr>
                            <tr><td colspan="4"></td></tr>
            <?php
        		        } /* end for */
                    } else if( strpos($flightConfirm->departureFlightName, '~') !== TRUE )
                    {
                    	$airportNameDeparture = str_replace("International", "Int'l", $flightConfirm->departureAirportNameFrom);
                        $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $airportNameDeparture);

                        $airportNameDepartureTo = str_replace("International", "Int'l", $flightConfirm->departureAirportNameTo);
                        $airportNameDepartureTo = str_replace("Kuala Lumpur", "KL", $airportNameDepartureTo);
            ?>
                        <tr>
                            <td valign="top">
                            	<span style="font-family:Courier; font-size: 13px;">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    	<b><?php echo $airportNameDeparture; ?></b>
                                    	<br />
                                    	<span>Terminal <?php echo $flightConfirm->departureTerminalID_from;?></span>
                                    	<br />
                                    	<span><?php echo date("d M Y", strtotime($flightConfirm->departureDateFrom)); ?><span>
                                    	<br />
                                    	<span><?php echo date("H:i",strtotime($flightConfirm->departureTimeFrom)); ?></span>
                                    </span>
                                </span>
                            </td>
                            <td valign="top">
                            	<span style="font-family:Courier; font-size: 13px;">
                                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    	<b><?php echo $airportNameDepartureTo; ?></b>
                                    	<br />
                                    	<span>Terminal <?php echo $flightConfirm->departureTerminalID_to;?></span>
                                    	<br />
                                    	<span><?php echo date("d M Y", strtotime($flightConfirm->departureDateTo)); ?><span>
                                    	<br />
                                    	<span><?php echo date("H:i",strtotime($flightConfirm->departureTimeTo)); ?></span>
                                    </span>
                                </span>
                            </td>
                            <td valign="top">
                                <span><?php echo $flightConfirm->departureFlightName;?></span>
                                <br />
                                <span><?php echo $flightConfirm->departureFlightCode;?></span>
                                <br />
                                <span><?php echo $arrFlightClassType[$flightConfirm->flightClass];?></span>

                            </td>
                            <td valign="top">
                            	NON-STOP<br/>
                                <!-- <span></span>
                                <br />
                                 -->
                                 <?php
                                    if($flightConfirm->departureFlightAirEquipType != '' && isset($airEquipTypeArr[$flightConfirm->departureFlightAirEquipType])) {
	                                     $airtype = $airEquipTypeArr[$flightConfirm->departureFlightAirEquipType];
	                                     if($airtype === 'undefined' || $airtype == '') {
	                                     	if (substr($flightConfirm->departureFlightAirEquipType, 0, 1) === '7') { $airtype = 'Boeing' . $flightConfirm->departureFlightAirEquipType;}
	                                        else if (substr($flightConfirm->departureFlightAirEquipType, 0, 1) === '3') { $airtype = 'Airbus';}
	                                     }
	                                 } else $airtype = 'Airbus';

                                ?>
                                <span><?php echo $airtype;?></span>
                                <br />
                                <span><?php
                                $flightConfirm->departureTimeTaken = str_replace("hours", "Hrs", strtolower($flightConfirm->departureTimeTaken));
	                            $flightConfirm->departureTimeTaken = str_replace("minutes", "Mins", strtolower($flightConfirm->departureTimeTaken));
	                            echo $flightConfirm->departureTimeTaken;
	                            ?></span>
                                <br />
                                <!-- <span><?php echo $arrFlightClassType[$departureFlightClass];?></span> -->
                                <?php ?>
                                <span>
                                <?php
                                /*if(strlen($flight->departuremealcode) != 1 && strlen($flight->departuremealcode) != 4) {
                                    $arrMC = str_split($flight->departuremealcode);
                                    for($idxArr=0; $idxArr < count($arrMC); $idxArr++) {
                                        echo $mealCodeArray[$arrMC[$idxArr]];
                                    }
                                } else {
                                    echo $mealCodeArray[$flight->departuremealcode];
                                }*/
                                if(isset($mealCodeArray[$flightConfirm->departuremealcode])){
                                	echo $mealCodeArray[$flightConfirm->departuremealcode];
                                } else {
                                	$arrMC = str_split($flightConfirm->departuremealcode);
                                    for($idxArr=0; $idxArr < count($arrMC); $idxArr++) {
                                    echo $mealCodeArray[$arrMC[$idxArr]]." ";
                                    }
                                }
                                ?></span>
                            </td>
                        </tr>
                        <tr><td colspan="4"></td></tr>
            <?php
                    }

                if ($flightConfirm->arrivalFlightName != "")
                {
	        ?>
            <tr><td colspan="4">&nbsp;</td></tr>
        	        <tr>
        	            <td valign="top">
        	                <span style="font-family:Courier; font-size: 13px;">
        	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>Departing</b></span>
        	                </span>
        	            </td>
        	            <td align="left" valign="top">
        	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>Arriving</b></span>
        	            </td>
        	            <td align="left" valign="top">
        		            <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>Flight details</b></span>
        	            </td>
                        <td align="left" valign="top" style="width:100px">
                            <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>STOP / EQP / FLYING TIME / SERVICES</b></span>
                        </td>
        	        </tr>

            	<?php
            	if( $flightConfirm->arrivalFlightName != "" && $flightConfirm->arrivalFlightCode != "" )
            	{
            		if( strpos($flightConfirm->arrivalFlightName, '~') !== FALSE ) {
                        //indirect
                        $explodeCountA = explode("~", $flightConfirm->arrivalFlightName);
                        for($xe=0; $xe<count($explodeCountA); $xe++) {
                            $arrArrivalFlightName       = explode("~", $flightConfirm->arrivalFlightName);
                            $arrArrivalFlightCode       = explode("~", $flightConfirm->arrivalFlightCode);
                            $arrArrivalTimeTaken        = explode("~", $flightConfirm->arrivalTimeTaken);
                            $arrArrivalDateFrom         = explode("~", $flightConfirm->arrivalDateFrom);
                            $arrArrivalDateTo           = explode("~", $flightConfirm->arrivalDateTo);
                            $arrArrivalTimeFrom         = explode("~", $flightConfirm->arrivalTimeFrom);
                            $arrArrivalTimeTo           = explode("~", $flightConfirm->arrivalTimeTo);
                            $arrArrivalCityNameFrom     = explode("~", $flightConfirm->arrivalCityNameFrom);
                            $arrArrivalCityNameTo       = explode("~", $flightConfirm->arrivalCityNameTo);
                            $arrArrivalCityCodeFrom     = explode("~", $flightConfirm->arrivalCityCodeFrom);
                            $arrArrivalCityCodeTo       = explode("~", $flightConfirm->arrivalCityCodeTo);
                            $arrArrivalAirportNameFrom  = explode("~", $flightConfirm->arrivalAirportNameFrom);
                            $arrArrivalAirportNameTo    = explode("~", $flightConfirm->arrivalAirportNameTo);
                            $arrArrivalBaggage          = explode("~", $flightConfirm->arrivalBaggage);
                            $arrArrivalMeal             = explode("~", $flightConfirm->arrivalMeal);
                            $arrArrivalMealCode             = explode("~", $flightConfirm->arrivalmealcode);
                            $arrArrivalFlightEquip               = explode("~", $flightConfirm->arrivalFlightAirEquipType);

                            $arrArrivalTerminalID_from            = explode("~", $flightConfirm->arrivalTerminalID_from);
                            $arrArrivalTerminalID_to          = explode("~", $flightConfirm->arrivalTerminalID_to);
                            $arrivalFlightClass = $flightConfirm->flightClass;

                            $arrArrivalTimeTaken[$xe] = str_replace("hours", "Hrs", strtolower($arrArrivalTimeTaken[$xe]));
                            $arrArrivalTimeTaken[$xe] = str_replace("minutes", "Min", strtolower($arrArrivalTimeTaken[$xe]));

                            $airportNameArrival = str_replace("International", "Int'l", $arrArrivalAirportNameFrom[$xe]);
                            $airportNameArrival = str_replace("Kuala Lumpur", "KL", $airportNameArrival);
                            $airportNameArrivalTo = str_replace("International", "Int'l", $arrArrivalAirportNameTo[$xe]);
                            $airportNameArrivalTo = str_replace("Kuala Lumpur", "KL", $airportNameArrivalTo);

                            if($xe >= 1) {
                                echo '<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4">Transit Flight</td></tr>';
                            }
                ?>
                    <tr>
                        <td valign="top">
                            <span style="font-family:Courier; font-size: 13px;">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    <b><?php echo $airportNameArrival; ?></b>
                                    <br />
                                    <span>Terminal <?php echo $arrArrivalTerminalID_from[$xe];?></span>
                                    <br />
                                    <span><?php echo date("d M Y", strtotime($arrArrivalDateFrom[$xe])); ?><span>
                                    <br />
                                    <span><?php echo date("H:i", strtotime($arrArrivalTimeFrom[$xe])); ?></span>
                                </span>
                            </span>
                        </td>
                        <td valign="top">
                            <span style="font-family:Courier; font-size: 13px;">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    <b><?php echo $airportNameArrivalTo; ?></b>
                                    <br />
                                    <span>Terminal <?php echo $arrArrivalTerminalID_to[$xe];?></span>
                                    <br />
                                    <span><?php echo date("d M Y", strtotime($arrArrivalDateTo[$xe])); ?><span>
                                    <br />
                                    <span><?php echo date("H:i", strtotime($arrArrivalTimeTo[$xe])); ?></span>
                                </span>
                            </span>
                        </td>
                        <td valign="top">
                            <span><?php echo $arrArrivalFlightName[$xe];?></span>
                            <br />
                            <span><?php echo $arrArrivalFlightCode[$xe];?></span>
                            <br />
                            <span><?php echo $arrFlightClassType[$arrivalFlightClass];?></span>
                        </td>

                        <td valign="top">
                        	DIRECT<br/>
                            <!-- <span></span>
                            <br />
                             -->
                             <?php
                         		if($arrArrivalFlightEquip[$xe] != '' && isset($airEquipTypeArr[$arrArrivalFlightEquip[$xe]])) {
                                     $airtype = $airEquipTypeArr[$arrArrivalFlightEquip[$xe]];
                                     if($airtype === 'undefined' || $airtype == '') {
                                     	if (substr($arrArrivalFlightEquip[$xe], 0, 1) === '7') { $airtype = 'Boeing' . $arrArrivalFlightEquip[$xe];}
                                        else if (substr($arrArrivalFlightEquip[$xe], 0, 1) === '3') { $airtype = 'Airbus';}
                                     }
                                 } else $airtype = 'Airbus';

                            ?>
                            <span><?php echo $airtype?></span>
                            <br />
                            <span><?php echo $arrArrivalTimeTaken[$xe];?></span>
                            <br />
                            <!-- <span><?php echo $arrFlightClassType[$departureFlightClass];?></span> -->
                            <?php ?>
                            <span>
                            <?php
                            /*if(strlen($arrArrivalMealCode[$xe]) != 1 && strlen($arrArrivalMealCode[$xe]) != 4) {
                            	$arrMC = str_split($arrArrivalMealCode[$xe]);
                                for($idxArr=0; $idxArr < count($arrMC); $idxArr++) {
                                    echo $mealCodeArray[$arrMC[$idxArr]];
                                }
                            } else {
                                echo $mealCodeArray[$arrArrivalMealCode[$xe]];
                            }*/

                            if(isset($mealCodeArray[$arrArrivalMealCode[$xe]])){
                            	echo $mealCodeArray[$arrArrivalMealCode[$xe]];
                            } else {
                            	$arrMC = str_split($arrArrivalMealCode[$xe]);
                                for($idxArr=0; $idxArr < count($arrMC); $idxArr++) {
                                echo $mealCodeArray[$arrMC[$idxArr]]." ";
                                }
                            }
                            ?></span>
                        </td>
                    </tr>
                    <tr><td colspan="4"></td></tr>
                <?php
                        }   /* end for */
                    } else
                    {
                    	/* 1 way return without transit */
                    	$airportNameArrival = str_replace("International", "Int'l", $flightConfirm->arrivalAirportNameFrom);
                        $airportNameArrival = str_replace("Kuala Lumpur", "KL", $airportNameArrival);

                        $airportNameArrivalTo = str_replace("International", "Int'l", $flightConfirm->arrivalAirportNameTo);
                        $airportNameArrivalTo = str_replace("Kuala Lumpur", "KL", $airportNameArrivalTo);

                ?>
                    <tr>
                        <td valign="top">
                            <span style="font-family:Courier; font-size: 13px;">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    <b><?php echo $airportNameArrival; ?></b>
                                    <br />
                                    <span>Terminal <?php echo $flightConfirm->arrivalTerminalID_from;?></span>
                                    <br />
                                    <span><?php echo date("d M Y", strtotime($flightConfirm->arrivalDateFrom)); ?><span>
                                    <br />
                                    <span><?php echo date("H:i",strtotime($flightConfirm->arrivalTimeFrom)); ?></span>
                                </span>
                            </span>
                        </td>
                        <td valign="top">
                            <span style="font-family:Courier; font-size: 13px;">
                                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                                    <b><?php echo $airportNameArrivalTo; ?></b>
                                    <br />
                                    <span>Terminal <?php echo $flightConfirm->arrivalTerminalID_to;?></span>
                                    <br />
                                    <span><?php echo date("d M Y", strtotime($flightConfirm->arrivalDateTo)); ?><span>
                                    <br />
                                    <span><?php echo date("H:i",strtotime($flightConfirm->arrivalTimeTo)); ?></span>
                                </span>
                            </span>
                        </td>
                        <td valign="top">
                            <span><?php echo $flightConfirm->arrivalFlightName;?></span>
                            <br />
                            <span><?php echo $flightConfirm->arrivalFlightCode;?></span>
                            <br />
                            <span><?php echo $arrFlightClassType[$flightConfirm->flightClass];?></span>

                        </td>

                        <td valign="top">
                        	NON-STOP<br/>
                            <!-- <span></span>
                            <br />
                             -->
                             <?php
	                             if($flightConfirm->arrivalFlightAirEquipType != '' && isset($airEquipTypeArr[$flightConfirm->arrivalFlightAirEquipType])) {
	                                 $airtype = $airEquipTypeArr[$flightConfirm->arrivalFlightAirEquipType];
	                                 if($airtype === 'undefined' || $airtype == '') {
	                                 	if (substr($flightConfirm->arrivalFlightAirEquipType, 0, 1) === '7') { $airtype = 'Boeing' . $flightConfirm->arrivalFlightAirEquipType;}
	                                    else if (substr($flightConfirm->arrivalFlightAirEquipType, 0, 1) === '3') { $airtype = 'Airbus';}
	                                 }
	                             } else $airtype = 'Airbus';
                            ?>
                            <span><?php echo $airtype?></span>
                            <br />
                            <span><?php echo $flightConfirm->arrivalTimeTaken;?></span>
                            <br />
                            <!-- <span><?php echo $arrFlightClassType[$departureFlightClass];?></span> -->
                            <?php ?>
                            <span>
                            <?php
                            /*if(strlen($flightConfirm->arrivalmealcode) != 1 && strlen($flightConfirm->arrivalmealcode) != 4) {
                                $arrMC = str_split($flightConfirm->arrivalmealcode);
                                for($idxArr=0; $idxArr < count($arrMC); $idxArr++) {
                                    echo $mealCodeArray[$arrMC[$idxArr]];
                                }
                            } else {
                                echo $mealCodeArray[$flightConfirm->arrivalmealcode];
                            }*/

                            if(isset($mealCodeArray[$flightConfirm->arrivalmealcode])){
                            	echo $mealCodeArray[$flightConfirm->arrivalmealcode];
                            } else {
                            	$arrMC = str_split($flightConfirm->arrivalmealcode);
                                for($idxArr=0; $idxArr < count($arrMC); $idxArr++) {
                                echo $mealCodeArray[$arrMC[$idxArr]]." ";
                                }
                            }

                            ?></span>
                        </td>
                    </tr>
                    <tr><td colspan="4"></td></tr>

            <?php
                    }
            	} /* end flight confirm arrival data */
            } /* end flight confirm data */
            ?>
	        <tr><td valign="top" colspan="4">&nbsp;</td></tr>
	        <tr>
	            <td valign="top" colspan="4">
                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                        <b>In-Flight Services</b>
                    </span>
	            </td>

	        </tr>
	        <tr>
	            <td valign="top">
	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><b>Name of Passenger(s)</b></span>
	            </td>
	            <td valign="top" colspan="3">
	            	<b>Passenger(s) Remark</b>
	            </td>
	        </tr>
            <?php
	        if( $flightPassenger == TRUE ) {
                $idx = 1;
                $passTypeDesc = array(
                                    'adult' => 'Adult (Above 12 Years Old)',
                                    'child' => 'Children (Above 2-12 Years Old)',
                                    'infant' => 'Infant (Below 2 Years Old)'
                                );
                foreach ($flightPassenger as $pass)
                {
                	$passName = $pass->passenger_surname.'/'.$pass->passenger_givenname;
            ?>
            <tr>
                <td valign="top">
                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase"><?php echo $idx;?>. <?php echo $pass->passengerTitle != "" ? $passName.$pass->passengerTitle : $passName;?></span>
                </td>
                <td valign="top" colspan="3">
                	<span style="font-family:Courier; font-size: 13px;">
                		<?php echo $pass->passenger_remarks != "" ? $pass->passenger_remarks : '-';?>
                	</span>
                </td>
            </tr>
            <?php
                    $idx++;
                }
            }
            ?>
	        <!-- end of passenger meal pref -->
	        <tr><td valign="top" colspan="4">&nbsp;</td></tr>
	        <tr>
	            <td valign="top">
                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                        <b>Ticketing</b>
                    </span>
	            </td>
	            <td align="right" valign="top">
	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">&nbsp;</span>
	            </td>
	            <td align="right" valign="top"></td>
	            <td align="right" valign="top"></td>
	        </tr>
	        <tr>
	            <td valign="top">
	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">Method</span>
	            </td>
	            <td align="left" valign="top" colspan="3">Electronic Ticketing (E-Ticket)</td>
	        </tr>
	        <tr>
	            <td valign="top">
	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">Lead Time</span>
	            </td>
	            <td align="left" valign="top" colspan="3">-</td>
	        </tr>
	        <tr><td valign="top" colspan="4">&nbsp;</td></tr>
	        <tr>
	            <td valign="top">
	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                        <b>Charges and Payments</b>
	                </span>
	            </td>
	            <td align="right" valign="top">
	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">&nbsp;</span>
	            </td>
	            <td align="right" valign="top"></td>
	            <td align="right" valign="top"></td>
	        </tr>
	        <tr>
	            <td valign="top">
	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">Payment Method</span>
	            </td>
	            <td align="left" valign="top" colspan="3">Online Payment</td>
	        </tr>
	        <tr><td valign="top" colspan="4">&nbsp;</td></tr>
	        <tr>
	            <td valign="top">
                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                        <b>Flight Fares</b>
                    </span>
	            </td>
	            <td align="right" valign="top">
	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">&nbsp;</span>
	            </td>
	            <td align="right" valign="top"></td>
	            <td align="right" valign="top"></td>
	        </tr>

            <?php
                $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0; $infantFare = 0; $infantTaxFare = 0;
                $itemTotalPrice = 0; $taxTotalPrice = 0;
                if($flightConfirm->noofAdult > 0) {
                    /* take from departure / arrival */
                    if($flightConfirm->departurePriceAdultBaseFare) {
                        $adultFare = $flightConfirm->departurePriceAdultBaseFare;
                        $adultTaxFare = $flightConfirm->departurePriceAdultTaxFare;
                    } else if ($flightConfirm->arrivalPriceAdultBaseFare) {
                        $adultFare = $flightConfirm->arrivalPriceAdultBaseFare;
                        $adultTaxFare = $flightConfirm->arrivalPriceAdultTaxFare;
                    }

                    $itemTotalPrice += $adultFare;
                    $taxTotalPrice += $adultTaxFare;
            ?>
	        <tr>
	            <td valign="top" colspan="2">
                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                    <?php echo $flightConfirm->noofAdult;?> Adult(s) (12 Years Old & Above)</span>
	            </td>
	            <td align="left" valign="top" colspan="2">
		            <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">SGD <?php echo number_format($adultFare, 2);?></span>
		        </td>
	        </tr>
            <?php  }
                if($flightConfirm->noofChild > 0) {
                    /* take from departure / arrival */
                    if($flightConfirm->departurePriceChildBaseFare) {
                        $childFare = $flightConfirm->departurePriceChildBaseFare;
                        $childTaxFare = $flightConfirm->departurePriceChildTaxFare;
                    } else if ($flightConfirm->arrivalPriceAdultBaseFare) {
                        $childFare = $flightConfirm->arrivalPriceChildBaseFare;
                        $childTaxFare = $flightConfirm->arrivalPriceChildTaxFare;
                    }
                    $itemTotalPrice += $childFare;
                    $taxTotalPrice += $childTaxFare;
            ?>
	        <tr>
	            <td valign="top" colspan="2">
	                <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                        <?php echo $flightConfirm->noofChild;?> Child(s) (2 years above & Below 12 Years Old)</span>
	            </td>
	            <td align="left" valign="top" colspan="2">
		            <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">SGD <?php echo number_format($childFare, 2);?></span>
	            </td>
	        </tr>
            <?php  }
                if($flightConfirm->noofInfant > 0) {
                    if($flightConfirm->departurePriceInfantBaseFare) {
                        $infantFare = $flightConfirm->departurePriceInfantBaseFare;
                        $infantTaxFare = $flightConfirm->departurePriceInfantTaxFare;
                    } else if ($flightConfirm->arrivalPriceAdultBaseFare) {
                        $infantFare = $flightConfirm->arrivalPriceInfantBaseFare;
                        $infantTaxFare = $flightConfirm->arrivalPriceInfantTaxFare;
                    }
                    $itemTotalPrice += $infantFare;
                    $taxTotalPrice += $infantTaxFare;
            ?>
	        <tr>
	            <td valign="top" colspan="2">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
                        <?php echo $flightConfirm->noofInfant;?> Infant (Below 2 Years Old)</span>
	            </td>
	            <td align="left" valign="top" colspan="2">
		            <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">SGD <?php echo number_format($infantFare, 2);?></span>
	            </td>
	        </tr>
            <?php
                }
            ?>
	        <tr>
	            <td valign="top" colspan="2">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">Taxes</span>
	            </td>
	            <td align="left" valign="top" colspan="2">
		            <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">SGD <?php echo number_format($taxTotalPrice, 2);?></span>
	            </td>
	        </tr>
	        <tr>
	            <td valign="top" colspan="2">
	                    <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">
	                    	Total Due at Booking
	                    </span>
	            </td>
	            <td align="left" valign="top" colspan="2">
		            <span style="font-family:Courier; font-size: 13px; text-transform: uppercase">SGD <?php echo number_format(ceil($itemTotalPrice+$taxTotalPrice), 2);?></span>
	            </td>
	        </tr>
	    <?php
	    			echo '<tr><td valign="top" colspan="4">&nbsp;</td></tr>';
	    			echo '<tr><td valign="top" colspan="4" style="border-top:1px solid">&nbsp;</td></tr>';
	    		$xxx++;
    		}
    	}
        ?>
		<!--END OF NEW DESIGN HERE-->

		<!--END OF FLIGHT FARES-->
		<tr><td valign="top" colspan="4">&nbsp;</td></tr>
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

  	<br />

  	<?php
    $cruiseChecks = $this->All->select_template("cruise_confirmedBookOrder_ID", $idUsed, "cruise_historyOrder");
    if( $cruiseChecks == TRUE ) {
    ?>
        <div><strong style="font-family:Courier; font-size: 13px;">CRUISE - SPECIAL INSTRUCTIONS</strong></div>
        <ol>
            <?php
            $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            $special_instruction_res = mysqli_query(
                $connection, "SELECT * FROM special_instruction WHERE type = 'CRUISE' ORDER BY order_no ASC"
            );
            if( mysqli_num_rows($special_instruction_res) > 0 ) {
                $a = 1;
                while( $special_instruction_row = mysqli_fetch_array($special_instruction_res, MYSQL_ASSOC) ) {
            ?>
                    <li style="font-family:Courier; font-size: 13px;">
                        <?php echo $special_instruction_row["instruction_content"]; ?>
                    </li>
            <?php
                }
            }
            ?>
        </ol>
    <?php
    }
    ?>

  	<?php
	$landtourChecks = $this->All->select_template("landtour_confirmedBookOrder_ID", $idUsed, "landtour_history_order");
	if( $landtourChecks == TRUE ) {
	?>
  		<div><strong style="font-family:Courier; font-size: 13px;">LANDTOUR - SPECIAL INSTRUCTIONS</strong></div>
  		<ol>
		  	<?php
		    $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			$special_instruction_res = mysqli_query(
				$connection, "SELECT * FROM special_instruction WHERE type = 'LANDTOUR' ORDER BY order_no ASC"
			);
			if( mysqli_num_rows($special_instruction_res) > 0 ) {
				$a = 1;
				while( $special_instruction_row = mysqli_fetch_array($special_instruction_res, MYSQL_ASSOC) ) {
			?>
					<li style="font-family:Courier; font-size: 13px;">
				  		<?php echo $special_instruction_row["instruction_content"]; ?>
				  	</li>
			<?php
				}
			}
		    ?>
  		</ol>
  		<br />
  	<?php
	}
	?>

  	<?php
	$hotelChecks = $this->All->select_template("hotel_confirmedBookOrder_ID", $idUsed, "hotel_historyOder");
	if( $hotelChecks == TRUE ) {
	?>
		<?php
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$special_instruction_res = mysqli_query(
			$connection, "SELECT * FROM special_instruction WHERE type = 'HOTEL' ORDER BY order_no ASC"
		);
		if( mysqli_num_rows($special_instruction_res) > 0 ) {
		?>
	  		<div><strong style="font-family:Courier; font-size: 13px;">HOTEL - SPECIAL INSTRUCTIONS</strong></div>
	  		<ol>
			  	<?php
				$a = 1;
				while( $special_instruction_row = mysqli_fetch_array($special_instruction_res, MYSQL_ASSOC) ) {
				?>
					<li style="font-family:Courier; font-size: 13px;">
					  	<?php echo $special_instruction_row["instruction_content"]; ?>
					  </li>
				<?php
				}
			    ?>
	  		</ol>
	  		<br />
  	<?php
	  	}
	}
	?>

  	<?php
	$flightChecks = $this->All->select_template("hotel_confirmedBookOrder_ID", $idUsed, "hotel_historyOder");
	if( $flightChecks == TRUE ) {
	?>
		<?php
		$special_instruction_res = $this->db->query("SELECT * FROM special_instruction WHERE type = 'FLIGHT' ORDER BY order_no ASC"
		);
		if( $special_instruction_res->num_rows() > 0) {
		?>
	  		<div><strong style="font-family:Courier; font-size: 13px;">FLIGHT - SPECIAL INSTRUCTIONS</strong></div>
	  		<ol>
			  	<?php
				$a = 1;
                foreach ($special_instruction_res->result_array() as $special_instruction_row) {
				?>
					<li style="font-family:Courier; font-size: 13px;">
					  	<?php echo $special_instruction_row["instruction_content"]; ?>
					</li>
				<?php
				}
			    ?>
	  		</ol>
	  		<br />
  	<?php
	  	}
	}
	?>

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
  	<div><strong style="font-family:Courier; font-size: 13px;">IMPORTANT NOTES</strong></div>
  	<ol>
	  	<?php
	    $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$important_note_res = mysqli_query(
			$connection, "SELECT * FROM important_note ORDER BY order_no ASC"
		);
		if( mysqli_num_rows($important_note_res) > 0 ) {
			$a = 1;
			while( $important_note_row = mysqli_fetch_array($important_note_res, MYSQL_ASSOC) ) {
		?>
		<li style="font-family:Courier; font-size: 13px;">
  			<?php echo $important_note_row["note_content"]; ?>
  		</li>
		<?php
			}
		}
	    ?>
  	</ol>
  	<br />
  	<br />
  	<div style="font-family:Courier; font-size: 13px; text-align:center">
	  	For the full terms and conditions, do refer to
	  	<a href="https://www.ctc.com.sg/terms-conditions">https://www.ctc.com.sg/terms-conditions</a>
  	</div>
  	<br />
</div>
</body>
</html>