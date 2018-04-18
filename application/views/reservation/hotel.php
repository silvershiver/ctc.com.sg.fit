<?php
$success_hotels = $this->All->select_template(
	"hotel_confirmedBookOrder_ID", $confirmBookingID, "hotel_historyOder"
);
if( $success_hotels == TRUE ) {
?>
	<div style="text-align:left">
		<h1>Hotel Order Details</h1>
	</div>
	<?php echo form_open_multipart('', array('class' => 'form-horizontal')); ?>
		<ul class="room-types">
	        <?php
	        foreach( $success_hotels AS $success_hotel ) {
	        ?>
	            <!--NEW DESIGN-->
	            <li style="border-bottom:none">
	                <div class="meta" style="width:65%">
	                    <div class="tab">
	                        <table border="0" cellpadding="0" cellspacing="0">
	                            <tr class="days">
	                                <th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
	                                    <div style="font-size:12px; margin:10px">
		                                    <?php
			                                if( UR_exists($success_hotel->hotel_Image) === false ) {
				                            ?>
				                            	<img src="<?php echo base_url()."assets/default.png"; ?>"  width="100" height="100" />
				                            <?php
											}
											else {
											?>
												<img src="<?php echo $success_hotel->hotel_Image; ?>"  width="100" height="100" />
											<?php
											}
			                                ?>
	                                    </div>
	                                </th>
	                            </tr>
	                            <tr>
	                                <td colspan="2" style="text-align:left; padding-bottom:0px">
	                                    <div style="font-size:12px">
	                                        <div style="font-size:16px; color:black">
												<b>&nbsp;&nbsp;Hotel name</b>
											</div>
											<div style="font-size:12px">
												&nbsp;&nbsp;<?php echo $success_hotel->hotel_Fullname; ?>
											</div>                                     
	                                    </div>
	                                </td>
	                                <td colspan="2" style="text-align:left; padding-bottom:0px">
	                                    <div style="font-size:12px">
		                                    <div style="font-size:16px; color:black">
												<b>Length of stay & Quantity</b>
											</div>
											<div style="font-size:12px">
		                                        <?php echo $success_hotel->duration; ?> night(s)
		                                        &
		                                        <?php echo $success_hotel->hotel_RoomQuantity; ?> room(s)
											</div>
	                                    </div>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td style="text-align:left; width:35%; padding-bottom:0px">
	                                    <div style="font-size:12px">
		                                    <div style="font-size:16px; color:black">
												<b>&nbsp;&nbsp;Check-in date</b>
											</div>
											<div style="font-size:12px">
	                                        	&nbsp;&nbsp;<?php echo date("l, d F Y", strtotime($success_hotel->check_in_date)); ?>
											</div>
	                                    </div>
	                                </td>
	                                <td colspan="2" style="text-align:left; width:250px; padding-bottom:0px">
	                                    <div style="font-size:12px">
		                                    <div style="font-size:16px; color:black">
												<b>Check-out length</b>
											</div>
	                                        <div style="font-size:12px">
	                                        	<?php echo date("l, d F Y", strtotime($success_hotel->check_out_date)); ?>
	                                        </div>
	                                    </div>
	                                </td>
	                            </tr>
	                        </table>
	                    </div>
	                </div>
	                <div class="room-information" style="width:30%; border:none; padding:0px">
	                    <div class="tab">
	                        <table border="0" cellpadding="0" cellspacing="0">
	                            <tr>
	                                <table border="0" cellpadding="0" cellspacing="0">
	                                    <tr>
	                                        <td style="width:35%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
	                                            <b>Item details</b>
	                                        </td>
	                                        <td style="width:3%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:center">
	                                            <b>Qty</b>
	                                        </td>
	                                        <td style="width:30%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
	                                            <b>Price per night ($)</b>
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
	                                            <?php echo $success_hotel->hotel_RoomQuantity; ?>
	                                            X
	                                            <?php echo $success_hotel->hotel_RoomType; ?>
	                                        </td>
	                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
	                                            <?php echo $success_hotel->duration; ?>
	                                        </td>
	                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
	                                            <?php
	                                            $pricePerNight = ($success_hotel->hotel_PricePerRoom/$success_hotel->duration)*$success_hotel->hotel_RoomQuantity;
	                                            ?>
	                                            <?php echo number_format($pricePerNight, 2); ?>
	                                        </td>
	                                    </tr>
	                                    <!--END OF ADULT-->
	                                    <!--TOTAL CHARGE-->
	                                    <tr>
	                                        <td class='time' colspan="2" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
	                                            <b>Total price</b>
	                                        </td>
	                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
	                                            <b>
	                                                <?php
	                                                echo number_format($pricePerNight*$success_hotel->duration, 2);
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
	            </li>
	            <!--END OF NEW DESIGN-->
	
	            <!--PAX NAME-->
	            <?php
	            if( $success_hotel->hotel_RoomTypeID != NULL ) {
	            ?>
	            <li style="margin-top:-35px">
	                <div style="color:#41AFAA; font-size:16px">
	                    <b>Guest name(s)</b>
	                </div>
	                <br />
	                <?php
	                $na = 1;
	                $details = $this->All->select_template_w_2_conditions(
	                    "bookingID", $bookingOrderID, "RoomTypeID", $success_hotel->hotel_RoomTypeID, "hotel_paxName"
	                );
	                foreach( $details AS $detail ) {
	                ?>
	                <div style="float:left; width:50%; margin-bottom:5px; font-size:16px">
	                    <?php echo $na; ?>. (<?php echo $detail->adult_or_child; ?>) <?php echo $detail->paxName; ?>
	                </div>
	                <?php
	                    $na++;
	                }
	                ?>
	            </li>
	            <?php
	            }
	            ?>
	            <!--END OF PAX NAME-->
	
	            <!--SPECIAL REQUEST-->
	            <?php
	            if( $success_hotel->hotelAPISpecialRequest != NULL ) {
	            ?>
	            <li style="margin-top:-5px">
	                <div style="color:#41AFAA; font-size:16px">
	                    <b>Special request(s)</b>
	                </div>
	                <br />
	                <?php
	                $no = 1;
	                $requests = explode(",", $success_hotel->hotelAPISpecialRequest);
	                foreach( $requests AS $request ) {
	                    $details = $this->All->select_template("remarkCode", $request, "hotel_specialRequest");
	                    foreach( $details AS $detail ) {
	                        $requestName = $detail->remarkContent;
	                    }
	                ?>
	                <div style="float:left; width:50%; margin-bottom:5px; font-size:16px">
	                    <?php echo $no; ?>. <?php echo $requestName; ?>
	                </div>
	                <?php
	                    $no++;
	                }
	                ?>
	            </li>
	            <?php
	            }
	            ?>
	            <!--END OF SPECIAL REQUEST-->
	
	        <?php
	        }
	        ?>
	        <br /><br />
	        <hr />
	    </ul>
	<?php echo form_close(); ?>
<?php
}
?>