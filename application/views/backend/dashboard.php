<?php $this->session->set_userdata('is_from_backend', 1);?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC Travel - Main Dashboard</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/back-end/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/ui/drilldown.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/core/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/back-end/assets/js/pages/datatables_basic.js"></script>
</head>
<body>
	<?php require_once(APPPATH."views/master/main_navbar.php"); ?>
	<?php require_once(APPPATH."views/master/second_navbar.php"); ?>
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Dashboard</span> - Analytic
				</h4>
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="#">Home</a></li>
					<li><a href="<?php echo base_url(); ?>backend/dashboard">Dashboard</a></li>
				</ul>
			</div>
			<?php require_once(APPPATH."views/master/heading_element.php"); ?>
		</div>
	</div>
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="row">
					<div class="col-lg-12">
<div class="panel panel-flat">
	<div class="panel-body">
		<div class="form-group">
			<div class="col-lg-12">
			    <ul class="nav nav-tabs">
			      	<li class="active"><a data-toggle="tab" href="#transaction">Transaction Management</a></li>
				  	<li><a data-toggle="tab" href="#latestJoined">Latest Customer Joined</a></li>
			    </ul>
			    <div class="tab-content">
				    <div id="transaction" class="tab-pane fade in active">
<table class="table cruiseTable">
  	<thead>
        <tr>
            <th style="text-align:left">Created</th>
		  	<th style="text-align:left">Booking order ID</th>
		  	<th style="text-align:left">Total price</th>
		  	<th style="text-align:left">Purchased by</th>
		  	<th style="text-align:left">Status</th>
		  	<th style="text-align:left; width:50px">Payment</th>
		  	<th style="text-align:left">Payment State</th>
        </tr>
    </thead>
    <tbody>
        <?php
	    $transaction_cruises = $this->All->select_template_with_order("created", "DESC", "confirmedBookOrder");
	    if( $transaction_cruises == TRUE ) {
		    foreach( $transaction_cruises AS $transaction_cruise ) {

	    		$granPrice = $transaction_cruise->granTotalPrice;
	    		$bookingOrderID = $transaction_cruise->BookingOrderID;

	    		$qry_bk = $this->db->query("select * From payment_reference where bookOrderID = ?", array($transaction_cruise->BookingOrderID));

			    //check transaction status
			    if( $transaction_cruise->status == "CONFIRMED" ) {
				    $link_show = TRUE;
			    }
			    else {
				    $link_show = FALSE;
			    }
			    //end of check transaction status
	    ?>
        <tr>
	        <td><?php echo date("Y-m-d H:i:s", strtotime($transaction_cruise->created)); ?></td>
	        <td>
		        <a href="<?php echo base_url(); ?>backend/dashboard/viewVoucher/<?php echo $transaction_cruise->BookingOrderID; ?>" target="_blank" style="text-decoration:underline">
		        	<?php echo $transaction_cruise->BookingOrderID; ?>
		    	</a>
			    <!-- Transaction details modal -->
				<div id="td<?php echo $transaction_cruise->id; ?>" class="modal fade">
					<div class="modal-dialog" style="width:75%">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h5 class="modal-title">Transaction details - <?php echo $transaction_cruise->BookingOrderID; ?></h5>
							</div>
							<?php echo form_open_multipart('backend/category/add_new_progress', array('class' => 'form-horizontal')); ?>
							<div class="modal-body">
								<!--CRUISE TRANSACTION DETAILS-->
								<?php
								$cruiseTransactions = $this->All->select_template("cruise_confirmedBookOrder_ID", $transaction_cruise->id, "cruise_historyOrder");
								if( $cruiseTransactions == TRUE ) {
								?>
								<fieldset class="content-group">
									<div class="form-group">
										<div class="col-lg-12">
											<div style="text-align:center">
												<span style="color:green; font-size:16px"><b>Cruise Transaction details</b></span>
											</div>
											<table class="table">
											  	<thead>
											        <tr>
											            <th style="text-align:left">Cruise title</th>
													  	<th style="text-align:left">Pax</th>
													  	<th style="text-align:left">Price</th>
													  	<th style="text-align:left">Extra Price</th>
													  	<th style="text-align:left">Cruise Date & Duration</th>
											        </tr>
											    </thead>
											    <tbody>
												    <?php
													foreach( $cruiseTransactions AS $cruiseTransaction ) {
														//get cruise title details
														$cruiseTitles = $this->All->select_template("ID", $cruiseTransaction->cruiseTitleID, "cruise_title");
														foreach( $cruiseTitles AS $cruiseTitle ) {
															$cruiseTitlePrint = $cruiseTitle->CRUISE_TITLE;
															$cruiseDeparturePortPrint = $cruiseTitle->DEPARTURE_PORT;
														}
														//end of get cruise title details
													?>
												    <tr>
													    <td>
														    <?php echo $cruiseTitlePrint; ?>
														    <br />
														    (Stateroom: <?php echo $this->All->getStateroomDetails($cruiseTransaction->stateroomID); ?>)
														</td>
													    <td>
														    <?php echo $cruiseTransaction->noofAdult; ?> Adult(s)
														    &
														    <?php echo $cruiseTransaction->noofChild; ?> Child(s)
														</td>
													    <td>$<?php echo number_format($cruiseTransaction->cruisePrice, 2); ?></td>
													    <td>
														    $<?php echo number_format($cruiseTransaction->extraPrice, 2); ?>
														</td>
													    <td>
														    <?php echo date("l, Y-M-d", strtotime($cruiseTransaction->cruiseDate)); ?>
														    <br />
														    Duration: <?php echo $cruiseTransaction->durationNight; ?> Night(s)
														</td>
												    </tr>
												    <tr>
													    <th>Name</th>
													    <th>NRIC</th>
													    <th>Date of Birth</th>
													    <th>Contact</th>
													    <th>Passport</th>
												    </tr>

												    <!--ADULT-->
												    <?php
													$a = 1;
													$adults = $this->All->select_template_w_2_conditions(
														"historyOrderID", $cruiseTransaction->id,
														"type_adul_or_child", "ADULT",
														"cruise_traverlerInfo"
													);
													if( $adults == TRUE ) {
														foreach( $adults AS $adult ) {
													?>
												    <tr><th colspan="5">Adult <?php echo $a; ?></th></tr>
												    <tr>
													    <td><?php echo $adult->traveler_title; ?>. <?php echo $adult->traveler_fullname; ?></td>
													    <td><?php echo $adult->traveler_nric; ?><br />(<?php echo $adult->traveler_nationality; ?>)</td>
													    <td><?php echo $adult->traveler_dob; ?></td>
													    <td>E: <?php echo $adult->traveler_email; ?><br />T: <?php echo $adult->traveler_contact; ?></td>
													    <td>
														    No: <?php echo $adult->traveler_passportNo; ?><br />
														    Issue: <?php echo $adult->traveler_issueDate; ?><br />
														    Expiry: <?php echo $adult->traveler_expiryDate; ?>
														</td>
												    </tr>
												    <?php
													    	$a++;
													    }
													}
													?>
													<!--END OF ADULT-->

													<!--CHILD-->
													<?php
													if( $cruiseTransaction->noofChild != 0 ) {
														$c = 1;
														$childs = $this->All->select_template_w_2_conditions(
															"historyOrderID", $cruiseTransaction->id,
															"type_adul_or_child", "CHILD",
															"cruise_traverlerInfo"
														);
														foreach( $childs AS $child ) {
													?>
												    <tr><th colspan="5">Child <?php echo $c; ?></th></tr>
												    <tr>
													    <td><?php echo $child->traveler_fullname; ?></td>
													    <td><?php echo $child->traveler_nric; ?><br />(<?php echo $child->traveler_nationality; ?>)</td>
													    <td><?php echo $child->traveler_dob; ?></td>
													    <td>E: ---<br />T: ---</td>
													    <td>
														    No: <?php echo $child->traveler_passportNo; ?><br />
														    Issue: <?php echo $child->traveler_issueDate; ?><br />
														    Expiry: <?php echo $child->traveler_expiryDate; ?>
														</td>
												    </tr>
												    <?php
													  		$c++;
													    }
													}
													?>
												    <!--END OF CHILD-->

												    <tr style="background-color:grey"><td colspan="5">&nbsp;</td></tr>
												    <?php
													}
													?>
											    </tbody>
											</table>
										</div>
									</div>
								</fieldset>
								<?php
								}
								?>
								<!--END OF CRUISE TRANSACTION DETAILS-->

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
				<!-- End of Transaction details modal -->
		    </td>
	        <td>$<?php echo number_format($transaction_cruise->granTotalPrice, 2); ?></td>
	        <td><?php echo $this->All->getContactPurchasedBy($transaction_cruise->BookingOrderID); ?></td>
	        <td>
		        <?php
		        	$flightBook = true; $hotelBook = true;
		        	$flightTransactions = $this->All->select_template("bookingRefID", $transaction_cruise->BookingOrderID, "flight_history_order");

		        	if($flightTransactions == TRUE) {
		        		if ($flightTransactions[0]->flight_PNR != "" && $flightTransactions[0]->status == "CONFIRMED") {
		        		} else {
		        			$flightBook = false;
		        		}
		        	}
		        	$hotelTransBook = $this->All->select_template("bookingRefID", $transaction_cruise->BookingOrderID, "hotel_historyOder");
		        	$hotelTransactions = $this->All->select_template("bookingorderid", $transaction_cruise->BookingOrderID, "hotel_booking_jsondata");
		        	if ($hotelTransBook) {
		        		if($hotelTransactions == TRUE) {
				        	$arrJSON = json_decode($hotelTransactions[0]->bookingjsondata, true);
				        	if(isset($arrJSON['BOOKINGS'])) {
							    $bookingRef = $arrJSON['BOOKINGS']['BOOKING']['BOOKINGREFERENCES']['BOOKINGREFERENCE'];

							    $bkID = "";
							    foreach($bookingRef as $bookRefd) {
							        if($bookRefd['REFERENCESOURCE'] == 'api') {
							            $bkID = $bookRefd['content'];
							        }
							    }

				        		if ($bkID != "") {
				        		} else {
				        			$hotelBook = false;
				        		}
				        	}
				        } else {
				        	$hotelBook = false;
				        }
		        	}

		        if ($flightBook && $hotelBook && $qry_bk->num_rows() > 0 && $qry_bk->row()->TM_Status == 'YES') {
		        	$status_confirmed = 'CONFIRMED';
		        	$color_status = 'style="color:green"';
		        } else if (($flightBook && $hotelBook) && $qry_bk->num_rows() == 0) {
		        	$status_confirmed = 'PENDING';
		        	$color_status = 'style="color:orange"';
		        } else {
		        	$status_confirmed = 'FAILED';
		        	$color_status = 'style="color:red"';
		        }
		        ?>
		        <span <?php echo $color_status;?>><b><?php echo $status_confirmed;?></b></span>
		    </td>
		    <td>
		    	<?php
		    	if( $status_confirmed == 'CONFIRMED' ) {
		    		echo 'PAID';
		    	}
		    	else if( $status_confirmed == 'PENDING' ) {

						$urlpay = base_url()."payment/testpay/".$bookingOrderID;

		    			echo '<form action="'.$urlpay.'" method="post"><input type="hidden" name="grandprice" value="'.$granPrice.'"><button type="submit">Issue Payment</button></form>';
		    	} else {
		    		echo '<span style="color:red"><b>FAILED</b></span>';
		    	}
		    	?>
		    </td>
		    <td>
		    	<?php if($qry_bk->num_rows() && $qry_bk->row()->TM_CCNum == '411111xxxxxx1111') {
		    		echo 'Testing';
		    	} else if($qry_bk->num_rows() && $qry_bk->row()->TM_CCNum !== '411111xxxxxx1111') {
		    		echo 'Live';
		    	} else {
		    		echo 'N/A';
		    	}
		    	?>
		    </td>
        </tr>
        <?php
	        }
	    }
	    ?>
    </tbody>
</table>
				    </div>
				    <div id="latestJoined" class="tab-pane fade">
					    <table class="table latestJoinedTable">
							<thead>
								<tr>
									<th>Joined date</th>
									<th>Name</th>
									<th>Email</th>
									<th>Contact</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$users = $this->All->select_template_with_where_and_order(
									"access_role", "NORMAL", "created", "DESC", "user_access"
								);
								if( $users == TRUE ) {
									foreach( $users AS $user ) {
								?>
								<tr>
									<td style="width:200px">
										<span class="text-muted text-size-small"><?php echo $user->created; ?></span>
									</td>
									<td>
										<div class="media-body">
											<div class="media-heading">
												<a href="#" class="letter-icon-title">
													<?php echo $user->first_name; ?> <?php echo $user->last_name; ?>
												</a>
											</div>
										</div>
									</td>
									<td style="width:200px">
										<span class="text-muted text-size-small"><?php echo $user->email_address; ?></span>
									</td>
									<td style="width:200px">
										<span class="text-muted text-size-small"><?php echo $user->admin_contact; ?></span>
									</td>
								</tr>
								<?php
									}
								}
								?>
							</tbody>
						</table>
				    </div>
			    </div>
			</div>
		</div>
	</div>
</div>
<!-- End of Transactions -->

					</div>
				</div>
			</div>
		</div>
		<!-- /page content -->

		<!-- Footer -->
		<?php require_once(APPPATH."views/master/footer.php"); ?>
		<!-- /footer -->

	</div>
	<!-- /page container -->

</body>
</html>