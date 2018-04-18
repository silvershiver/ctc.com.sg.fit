<!--HOTEL BOOKING CONFIRMED RESULT-->
<?php
$success_hotels = $this->All->select_template("hotel_confirmedBookOrder_ID", $confirmBookingID, "hotel_historyOder");
$gtabookingdata = $this->All->select_template("bookingorderid", $bookingOrderID, "hotel_booking_jsondata");
if( $success_hotels == TRUE && $gtabookingdata == TRUE) {
    $arrJSON = json_decode($gtabookingdata[0]->bookingjsondata, true);

    if (isset($arrJSON['BOOKINGS'])) {
        $bookingRef = $arrJSON['BOOKINGS']['BOOKING']['BOOKINGREFERENCES']['BOOKINGREFERENCE'];
        $bkID = "";
        foreach($bookingRef as $bookRefd) {
            if($bookRefd['REFERENCESOURCE'] == 'api') {
                $bkID = "#". $bookRefd['content'];
            }
        }
    }
    else
        $bkID = "(Contact Administrator)";


?>
    <style>
	    .room-types li {
		    border-bottom: none;
	    }
    </style>
    <div style="float: left"><h1>Hotel Confirmed Order</h1></div>
    <div style="float:right; border-bottom: 1px solid #ccc; padding: 0 0 10px; margin: 0 0 15px;">
        <span style="font-size:16px; font-weight:bold">
            Booking No. <span style="color:green">#<?php echo $bookingOrderID; ?></span>
            | Booking Ref. ID: <span style="color:green"><?php echo $bkID; ?></span>
        </span>
    </div>
    <div style="clear:both"></div>
    <?php echo form_open_multipart('', array('class' => 'form-horizontal')); ?>
    <ul class="room-types">
        <?php

        $na = 1;
        foreach( $success_hotels AS $success_hotel ) {
        ?>
            <!--NEW DESIGN-->
            <li style="border-bottom:none">
                <div class="meta" style="width:65%">
                    <div class="tab">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr class="days">
                                <th width="20%" style="text-align:left; background-color:#efefef" rowspan="4">
                                    <div style="font-size:12px">
                                        <img src="<?php echo $success_hotel->hotel_Image; ?>"  width="150" height="115" />
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:left; padding-bottom:0px">
                                    <div style="font-size:12px; margin-bottom: -25px">
                                        <h5>Hotel name</h5>
                                        <?php echo $success_hotel->hotel_Fullname; ?>
                                    </div>
                                </td>
                                <td colspan="2" style="text-align:left; padding-bottom:0px">
                                    <div style="font-size:12px; margin-bottom: -25px">
                                        <h5>Length of stay & Quantity</h5>
                                        <?php echo $success_hotel->duration; ?> night(s)
                                        &
                                        <?php echo $success_hotel->hotel_RoomQuantity; ?> room(s)
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:12px">
                                        <h5>Check-in date</h5>
                                        <?php echo date("l, d F Y", strtotime($success_hotel->check_in_date)); ?>
                                    </div>
                                </td>
                                <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                    <div style="font-size:12px">
                                        <h5>Check-out length</h5>
                                        <?php echo date("l, d F Y", strtotime($success_hotel->check_out_date)); ?>
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
                                            <?php echo $success_hotel->hotel_RoomType; ?>
                                        </td>
                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
                                            <?php echo $success_hotel->duration; ?>
                                        </td>
                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                            <?php
                                            $pricePerNight = ($success_hotel->hotel_PricePerRoom/$success_hotel->duration);
                                            $pricePerNight = ceil($pricePerNight);
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
                $details = $this->All->select_template_w_3_conditions(
                    "bookingID", $bookingOrderID, "RoomTypeID", $success_hotel->hotel_RoomTypeID, "flag_room", $success_hotel->room_index, "hotel_paxName"
                );
                foreach( $details AS $detail ) {
                ?>
                <div style="float:left; width:50%; margin-bottom:5px; font-size:16px">
                    <?php echo $na; ?>. (Room <?php echo $detail->flag_room;?>) - <?php echo $detail->adult_or_child; ?> - <?php echo $detail->paxName; ?>
                </div>
                <?php
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
            <li style="margin-top:-35px">
                <br /><br />
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
            <hr />
            <?php
            }
            ?>
            <!--END OF SPECIAL REQUEST-->

        <?php

                    $na++;
        }
        ?>
    </ul>
<?php
}
?>
<!--END OF HOTEL BOOKING CONFIRMED RESULT-->