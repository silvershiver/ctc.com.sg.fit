<!----------------------HOTELS TAB---------------------->
<?php
if( $this->session->userdata('shoppingCartCookie') == TRUE ) {
    if( count($this->session->userdata('shoppingCartCookie')) > 0 ) {
?>
            <h1>Confirmed Booking Order - Hotel</h1>
            <?php echo $this->session->flashdata('updatePriceCart'); ?>
            <div style="background-color:#eff0f1">
                <div style="float:left; padding:10px; margin-top:5px">
                    <img src="<?php echo base_url(); ?>assets/info.png" width="40" height="40" />
                </div>
                <div style="float:left; padding:10px; width:65%; font-size:12px; margin-top:7px">
                    <b>Please note: Cot(s) will be requested at the hotel, however cots are not guaranteed and are subject to availability at check-in. Also, maximum age for cot is 2 years old.</b>
                </div>
                <div style="clear:both"></div>
            </div>
            <br />
            <ul class="room-types">
                <?php
                $arrayHotel = $this->session->userdata('shoppingCartCookie');

                $arrayHotelCount = count($arrayHotel);
                $total_hotel_grand = 0;
                for($h=0; $h<$arrayHotelCount; $h++) {
                    $total_hotel_grand_item = 0;
                ?>
                    <!--new design-->
                    <li>
                        <div class="meta" style="width:75%">
                            <div class="tab">
                                <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                                    <tr class="days">
                                        <th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
                                            <div style="font-size:12px">
                                                <img src="<?php echo $arrayHotel[$h]["hotel_Image"]; ?>" width="150" height="115" />
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align:left; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Hotel name</h5>
                                                <?php echo $arrayHotel[$h]["hotel_Fullname"]; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Check-in date</h5>
                                                <?php echo date("l, d M Y", strtotime($arrayHotel[$h]["check_in_date"])); ?>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Check-out date</h5>
                                                <?php echo date("l, d M Y", strtotime($arrayHotel[$h]["check_out_date"])); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="days">
                                        <th width="25%" style="text-align:left; background-color:#efefef" colspan="3">
                                            &nbsp;
                                        </th>
                                    </tr>
                                </table>
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left; width: 5%">#</td>
                                        <td style="width:40%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
                                            <b>Room type</b>
                                        </td>
                                        <td style="width:9%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:center">
                                            <b>Duration</b>
                                        </td>
                                        <td style="width:20%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:right">
                                            <b>Price per night ($)</b>
                                        </td>
                                        <td style="width:20%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:right">
                                            <b>Total Price ($)</b>
                                        </td>
                                    </tr>
                                    <?php
                                    foreach ($arrayHotel[$h]['hotel_room'] as $hotelroom)
                                    {
                                    ?>
                                    <tr>
                                        <td style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left"><?php echo $hotelroom['room_index'];?></td>
                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
                                            <?php echo $hotelroom["hotel_RoomType"]; ?>
                                            (Total Pax: <?php echo $hotelroom["hotel_AdultQuantity"]+$hotelroom["hotel_ChildQuantity"]+$hotelroom["hotel_InfantQuantity"]; ?>)
                                        </td>
                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
                                            <?php echo $arrayHotel[$h]["duration"]; ?> night(s)
                                        </td>
                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                            <?php
                                            $pricePerNight = ($hotelroom["hotel_PricePerRoom"]/$arrayHotel[$h]["duration"]);
                                            $total_hotel_grand += $pricePerNight*$arrayHotel[$h]["duration"];
                                            $total_hotel_grand_item  += $pricePerNight*$arrayHotel[$h]["duration"];
                                            ?>
                                            <?php echo number_format($pricePerNight, 2); ?>
                                        </td>
                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                            <?php echo number_format($hotelroom["hotel_PricePerRoom"], 2); ?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">&nbsp;</td>
                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
                                            &nbsp;
                                        </td>
                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px" colspan="2">
                                            <b>Grand Total Price</b>
                                        </td>
                                        <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                            <b>
                                                <?php
                                                echo number_format($total_hotel_grand_item, 2);
                                                ?>
                                            </b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="room-information" style="height:290px; width:19%; overflow-y: auto">
                            <div class="tab">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                            <div style="font-size:12px">
                                                <div>
                                                    <b>Stay Length</b>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                            <div style="font-size:12px">
                                                <div>
                                                    <b><?php echo $arrayHotel[$h]["duration"]; ?> night(s)</b>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                            <div style="font-size:12px">
                                                <div>
                                                    <b>Room Qty</b>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                            <div style="font-size:12px">
                                                <div>
                                                    <b><?php echo $arrayHotel[$h]["hotel_RoomQuantity"]; ?> room(s)</b>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#e0f2f4; text-align:left; padding:0" colspan="2">&nbsp;</td>
                                    </tr>
                                    <?php
                                    foreach ($arrayHotel[$h]['hotel_room'] as $hotelroom) {
                                    ?>
                                    <tr>
                                        <td colspan="2" style="background-color:#ffffff"><div style="font-size:12px">Room #<?php echo $hotelroom['room_index'];?></div></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                            <div style="font-size:12px">
                                                <b>Max Adult</b><br>
                                                <b>Max Child</b><br>
                                                <b>Max Infant</b>
                                            </div>
                                        </td>
                                        <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                            <div style="font-size:12px">
                                                <?php echo $hotelroom["hotel_AdultQuantity"]; ?><br>
                                                <?php echo $hotelroom["hotel_ChildQuantity"]; ?><br>
                                                <?php echo $hotelroom["hotel_InfantQuantity"]; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#e0f2f4; text-align:left; padding:0" colspan="2">&nbsp;</td>
                                    </tr>
                                    <?php } ?>

                                </table>
                            </div>
                        </div>
                        <div style="clear:both;"></div>
                    </li>
                    <!--end of new design-->
                <?php
                }
                ?>
            </ul>
            <?php
                }
            }
            else {
                $this->db->distinct();
                $this->db->select('hotel_Image, id, hotel_Fullname, check_in_date, check_out_date, duration, hotel_RoomQuantity, hotel_ItemCode, hotel_ItemCityCode, hotel_AdultQuantity, hotel_ChildQuantity, hotel_InfantQuantity');
                $this->db->from('hotel_cart');
                $this->db->where('user_access_id', $this->session->userdata('normal_session_id'));
                $this->db->group_by('hotel_ItemCode, hotel_ItemCityCode');
                $this->db->order_by('hotel_Fullname');

                $cart_hotel_group = $this->db->get()->result();

                $this->db->select('hotel_PricePerRoom, hotel_RoomType, room_index, hotel_RoomTypeID, hotel_AdultQuantity, hotel_ChildQuantity, hotel_InfantQuantity, hotel_RoomImage, hotel_ItemCode, hotel_ItemCityCode');
                $this->db->from('hotel_cart');
                $this->db->where('user_access_id', $this->session->userdata('normal_session_id'));
                $this->db->order_by('room_index', 'ASC');

                $cart_hotels = $this->db->get()->result();

                if( $cart_hotel_group == TRUE ) {
            ?>
                    <h1>Confirmed Booking Order - Hotel</h1>
                    <div style="background-color:#eff0f1">
                        <div style="float:left; padding:10px">
                            <img src="<?php echo base_url(); ?>assets/info.png" width="50" height="50" />
                        </div>
                        <div style="float:left; padding:10px; width:65%; font-size:12px; margin-top:10px">
                            <b>Please note: Cot(s) will be requested at the hotel, however cots are not guaranteed and are subject to availability at check-in. Also, maximum age for cot is 2 years old.</b>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    <br />
                    <ul class="room-types">
                        <?php
                        $total_hotel_grand = 0;
                        foreach( $cart_hotel_group AS $cart_hotel ) {
                            $total_hotel_grand_item = 0;
                        ?>
                        <!--new design-->
                        <li>
                            <div class="meta" style="width:75%">
                                <div class="tab">
                                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                                        <tr class="days">
                                            <th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
                                                <div style="font-size:12px">
                                                    <img src="<?php echo $cart_hotel->hotel_Image; ?>" width="150" height="115" />
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="text-align:left; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Hotel name</h5>
                                                    <?php echo $cart_hotel->hotel_Fullname; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Check-in date</h5>
                                                    <?php echo date("l, d M Y", strtotime($cart_hotel->check_in_date)); ?>
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Check-out date</h5>
                                                    <?php echo date("l, d M Y", strtotime($cart_hotel->check_out_date)); ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="days">
                                            <th width="25%" style="text-align:left; background-color:#efefef" colspan="3">
                                                &nbsp;
                                            </th>
                                        </tr>
                                    </table>
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="width:40%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
                                                <b>Room type</b>
                                            </td>
                                            <td style="width:9%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:center">
                                                <b>Duration</b>
                                            </td>
                                            <td style="width:20%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:right">
                                                <b>Price per night ($)</b>
                                            </td>
                                            <td style="width:20%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:right">
                                                <b>Total Price ($)</b>
                                            </td>
                                        </tr>
                                        <?php
                                        foreach($cart_hotels as $hotel_data) {
                                            if($hotel_data->hotel_ItemCode == $cart_hotel->hotel_ItemCode && $hotel_data->hotel_ItemCityCode == $cart_hotel->hotel_ItemCityCode) {
                                        ?>
                                        <tr>
                                            <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
                                                <?php echo $hotel_data->hotel_RoomType; ?>
                                            </td>
                                            <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px">
                                                <?php echo $cart_hotel->duration; ?> night(s)
                                            </td>
                                            <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                                <?php
                                                $pricePerNight = ($hotel_data->hotel_PricePerRoom/$cart_hotel->duration);
                                                ?>
                                                <?php echo number_format($pricePerNight, 2); ?>
                                            </td>
                                            <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                                <b>
                                                    <?php
                                                    $total_hotel_grand += $pricePerNight*$cart_hotel->duration;
                                                    $total_hotel_grand_item += $pricePerNight*$cart_hotel->duration;
                                                    echo number_format($pricePerNight*$cart_hotel->duration, 2);
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                        <?php }
                                        }
                                        ?>
                                        <tr>
                                            <td style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">&nbsp;</td>
                                            <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px" colspan="2">
                                                <b>Grand Total Price</b>
                                            </td>
                                            <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                                <b>
                                                    <?php
                                                    echo number_format($total_hotel_grand_item, 2);
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="room-information" style="height:290px; width:19%; overflow-y: auto">
                                <div class="tab">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                                <div style="font-size:12px">
                                                    <div>
                                                        <b>Stay Length</b>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                                <div style="font-size:12px">
                                                    <div>
                                                        <b><?php echo $cart_hotel->duration; ?> night(s)</b>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                                <div style="font-size:12px">
                                                    <div>
                                                        <b>Room Qty</b>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                                <div style="font-size:12px">
                                                    <div>
                                                        <b><?php echo $cart_hotel->hotel_RoomQuantity; ?> room(s)</b>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                                <div style="font-size:12px">
                                                    <div>
                                                        <b>Max Adult</b>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                                <div style="font-size:12px">
                                                    <div>
                                                        <b><?php echo $cart_hotel->hotel_AdultQuantity; ?></b>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                                <div style="font-size:12px">
                                                    <div>
                                                        <b>Max Child</b>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                                <div style="font-size:12px">
                                                    <div>
                                                        <b><?php echo $cart_hotel->hotel_ChildQuantity; ?></b>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                                <div style="font-size:12px">
                                                    <div>
                                                        <b>Max Infant</b>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="background-color:#e0f2f4; text-align:left; padding-bottom:0px">
                                                <div style="font-size:12px">
                                                    <div>
                                                        <b><?php echo $cart_hotel->hotel_InfantQuantity; ?></b>
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
                            <div style="clear:both;"></div>
                        </li>
                        <!--end of new design-->
                        <?php
                        }
                        ?>
                    </ul>

                <?php
                }
            }
            ?>

            <!--HOTEL CRUISE TRAVELLER INFORMATION-->
            <?php
            if( $this->session->userdata('shoppingCartCookie') == TRUE ) {
                if( count($this->session->userdata('shoppingCartCookie')) > 0 ) {
            ?>

                <h3 style="margin-top:30px">Traveller Information</h3>
                <!--EXTRA CODE-->
                <?php
                $arrayHotelExtra = $this->session->userdata('shoppingCartCookie');
                for($d=0; $d<$arrayHotelCount; $d++) {
                    $ctr = 1;
                    foreach($arrayHotelExtra[$d]['hotel_room'] as $hotelRoom) {
                ?>
                        <br />
                        <div style="font-size:14px">
                            <div style="margin-bottom:-10px; text-align:left; color:#41AFAA">
                                <b>
                                    Hotel: <?php echo $arrayHotelExtra[$d]["hotel_Fullname"]; ?>
                                    (<?php echo $hotelRoom["hotel_RoomType"]; ?>)
                                </b>
                            </div>
                            <br />
                            <div style="text-align:left">
                                <span><b>Room #<?php echo $ctr;?> : Enter guest name</b></span>
                                <br /><br />
                                <div>
                                    <?php
                                    for( $paxA=1; $paxA<=$hotelRoom["hotel_AdultQuantity"]; $paxA++ ) {
                                    ?>
                                    <div style="float:left; width:49%; margin-bottom:10px">
                                        <span>Adult <?php echo $paxA; ?>:</span>
                                        <br />
                                        <input type="text" name="paxNameAdult[<?php echo ($ctr-1);?>][<?php echo $hotelRoom["hotel_RoomTypeID"].':'.$d; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" onkeypress="return onlyAlphabetsspace(event,this);">
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    $hotelChildAges = explode(",", $hotelRoom['childages']);
                                    for( $paxC=1; $paxC<=$hotelRoom["hotel_ChildQuantity"]; $paxC++ ) {
                                    ?>
                                    <div style="float:left; width:49%; margin-bottom:10px">
                                        <span>Child <?php echo $paxC; ?> (Age <?php echo $hotelChildAges[$paxC-1];?>):</span>
                                        <br />
                                        <input type="text" name="paxNameChild[<?php echo ($ctr-1);?>][<?php echo $hotelRoom["hotel_RoomTypeID"].':'.$d; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" onkeypress="return onlyAlphabetsspace(event,this);">
                                        <input type="hidden" name="paxNameChildAge[<?php echo ($ctr-1);?>][<?php echo $hotelRoom["hotel_RoomTypeID"].':'.$d; ?>][]" value="<?php echo $hotelChildAges[($paxC-1)];?>">
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <div style="clear:both"></div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div style="margin-bottom:5px; text-align:left; font-size: 14px">
                            <a style="text-decoration:none; cursor:pointer" id="specialRequestLink_<?php echo $d;?>_<?php echo $ctr; ?>">
                                + Special request (optional)
                            </a>
                        </div>
                        <div style="font-size:14px; margin-top:10px; display:none" id="contentSpecialRequest_<?php echo $d;?>_<?php echo $ctr; ?>">
                            <div>
                                <?php
                                $remarks = $this->All->select_template_with_order("id", "ASC", "hotel_specialRequest");
                                if( $remarks == TRUE ) {
                                    $ctr_rm = 1;
                                    foreach( $remarks AS $remark ) {
                                ?>
                                <div style="float:left; width:50%; margin-bottom:5px">
                                    <input type="checkbox" name="remarkCK[<?php echo $d; ?>][<?php echo ($ctr-1);?>][]" value="<?php echo $remark->remarkCode; ?>" id="remarkCK_<?php echo $d; ?>_<?php echo ($ctr-1);?>_<?php echo $ctr_rm;?>"/>
                                    &nbsp;
                                    <label for="remarkCK_<?php echo $d; ?>_<?php echo ($ctr-1);?>_<?php echo $ctr_rm;?>">
                                        <?php echo $remark->remarkContent; ?>
                                    </label>
                                </div>
                                <?php
                                        $ctr_rm++;
                                    }
                                }
                                ?>
                                <div>** Not all special requests available in selected hotel(s)</div>
                                <div style="clear:both"></div>
                            </div>
                        </div>
                <?php
                        $ctr++;
                    }
                }
                ?>
                <!--END OF EXTRA CODE-->
            <?php
                }
            }
            else {
                $extraHotels = $this->All->select_template(
                    "user_access_id", $this->session->userdata('normal_session_id'), "hotel_cart"
                );
                if( $extraHotels == TRUE ) {
            ?>
            <h3>Traveller Information</h3>
            <div class="age_type" style="font-size:14px">
                Please enter your passenger details and ensure the details matches your passport.
                <span style="text-transform: capitalize; color:red">
                    <b>(* required field)</b>
                </span>
            </div>
            <div class="tab_container" id="tabs-0" style="font-size:14px">
                <!--TRAVELLER FORM-->
                <div class="form_div particular-form" id="particular-1">
                    <div>
                    <!--EXTRA CODE-->
                    <?php
                        $ctr = 1;
                        foreach($extraHotels AS $extraHotel) {
                    ?>
                    <br />
                    <div style="font-size:14px">
                        <div style="margin-bottom:-10px; text-align:left; color:#41AFAA">
                            <b>
                                Hotel: <?php echo $extraHotel->hotel_Fullname; ?>
                                (<?php echo $extraHotel->hotel_RoomType; ?>)
                            </b>
                        </div>
                        <br />
                        <div style="text-align:left">
                            <span><b>Room #<?php echo $ctr;?> : Enter guest name</b></span>
                            <br /><br />
                            <div>
                                <?php
                                for( $paxA=1; $paxA<=$extraHotel->hotel_AdultQuantity; $paxA++ ) {
                                ?>
                                <div style="float:left; width:49%; margin-bottom:10px">
                                    <span>Adult <?php echo $paxA; ?>:</span>
                                    <br />
                                    <input type="text" name="paxNameAdult[<?php echo ($ctr-1);?>][<?php echo $extraHotel->hotel_RoomTypeID.':'.$ctr; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%">
                                </div>
                                <?php
                                }
                                ?>
                                <?php
                                $hotelChildAges = explode(",", $extraHotel->hotel_childAges);
                                for( $paxC=1; $paxC<=$extraHotel->hotel_ChildQuantity; $paxC++ ) {
                                ?>
                                <div style="float:left; width:49%; margin-bottom:10px">
                                    <span>Child <?php echo $paxC; ?> (Age <?php echo $hotelChildAges[$paxC-1];?>):</span>
                                    <br />
                                    <input type="text" name="paxNameChild[<?php echo ($ctr-1);?>][<?php echo $extraHotel->hotel_RoomTypeID.':'.$ctr; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%">
                                    <input type="hidden" name="paxNameChildAge[<?php echo ($ctr-1);?>][<?php echo $extraHotel->hotel_RoomTypeID.':'.$ctr; ?>][]" value="<?php echo $hotelChildAges[($paxC-1)];?>">
                                </div>
                                <?php
                                }
                                ?>
                                <div style="clear:both"></div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div style="margin-bottom:5px; text-align:left; font-size: 14px">
                        <a style="text-decoration:none; cursor:pointer" id="specialRequestLink<?php echo $extraHotel->id; ?>">
                            + Special request (optional)
                        </a>
                    </div>
                    <div style="font-size:14px; margin-top:10px; display:none" id="contentSpecialRequest<?php echo $extraHotel->id; ?>">
                        <div>
                            <?php
                            $remarks = $this->All->select_template_with_order("id", "ASC", "hotel_specialRequest");
                            if( $remarks == TRUE ) {
                                foreach( $remarks AS $remark ) {
                            ?>
                            <div style="float:left; width:50%; margin-bottom:5px">
                                <input type="checkbox" name="remarkCK[<?php echo $extraHotel->id; ?>][]" value="<?php echo $remark->remarkCode; ?>" id="remarkCK_<?php echo $remark->remarkCode;?>"/>
                                &nbsp;
                                <label for="remarkCK_<?php echo $remark->remarkCode;?>"><?php echo $remark->remarkContent; ?></label>
                            </div>
                            <?php
                                }
                            }
                            ?>
                            <div>** Not all special requests available in selected hotel(s)</div>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                    <?php
                            $ctr++;
                    }
                    ?>
                    <!--END OF EXTRA CODE-->
            </div>
            <?php } ?>
<?php
}
?>
<!----------------------END OF HOTELS TAB---------------------->