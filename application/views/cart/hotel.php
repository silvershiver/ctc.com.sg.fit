<section id="hotel_cart" class="tab-content">
    <article>
        <h1>Hotel - Cart List</h1>
        <?php echo $this->session->flashdata('errorDuplicateCart'); ?>
        <?php echo $this->session->flashdata('removeHotelCart'); ?>
        <?php echo $this->session->flashdata('updateHotelCart'); ?>
        <?php
        $hotelPaxRoom = 0;
        $limithotelPax = 9;
        $total_hotel_grand = 0;

        if ( $this->session->userdata('normal_session_id') == TRUE ) {
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
                <div style="background-color:#eff0f1">
                    <div style="float:left; padding:10px">
                        <img src="<?php echo base_url(); ?>assets/info.png" width="50" height="50" />
                    </div>
                    <div style="float:left; padding:10px; width:75%; font-size:11px; margin-top:10px">
                        <b>Please note: Cot(s) will be requested at the hotel, however cots are not guaranteed and are subject to availability at check-in. Also, maximum age for cot is 2 years old.</b>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="checkout-error hidden bg-danger text-danger" style="text-align: center; padding: 10px; font-size: 14px; height: 30px; background: #ff0000; color:#ffffff">Error max pax is 9pax(s)</div>
                <br />
                <ul class="room-types">
                    <?php
                    foreach( $cart_hotel_group AS $cart_hotel ) {
                        $total_hotel_grand_item = 0;
                        $hotelPaxRoom += ($cart_hotel->hotel_AdultQuantity + $cart_hotel->hotel_ChildQuantity + $cart_hotel->hotel_InfantQuantity);
                    ?>
                    <!--cart item-->
                    <div class="tab">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr class="days">
                                <th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
                                    <div style="font-size:12px">
                                        <img src="<?php echo $cart_hotel->hotel_Image; ?>" alt="" width="150" height="115" />
                                    </div>
                                    <br />
                                    <div style="text-align:center">
                                        <a href="<?php echo base_url(); ?>cart/hotel_remove_item_cart/<?php echo $cart_hotel->hotel_ItemCityCode;?>/<?php echo $cart_hotel->hotel_ItemCode; ?>" class="gradient-button" title="Remove" style="position:static">
                                            Remove
                                        </a>
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
                            <tr>
                                <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Stay length</h5>
                                        <?php echo $cart_hotel->duration; ?> night(s)
                                    </div>
                                </td>
                                <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>No.of room</h5>
                                        <?php echo $cart_hotel->hotel_RoomQuantity; ?> room(s)
                                    </div>
                                </td>
                            </tr>
                            <tr class="days">
                                <th width="25%" style="text-align:left; background-color:#efefef" colspan="4">
                                    &nbsp;
                                </th>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr class='days'>
                                <th width="35%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
                                    <b>Room type</b>
                                </th>
                                <th width="45%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align: left">
                                    <b>Room details</b>
                                </th>
                                <th width="25%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align: right">
                                    <b>Price per night ($)</b>
                                </th>
                            </tr>
                             <tr><td colspan="3" style="padding:0"></td></tr>
                        <?php
                        foreach($cart_hotels as $hotel_data) {
                            if($hotel_data->hotel_ItemCode == $cart_hotel->hotel_ItemCode && $hotel_data->hotel_ItemCityCode == $cart_hotel->hotel_ItemCityCode) {?>
                                <tr>
                                    <td class='' style="width:30%; background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left" valign="top">
                                        <?php echo $hotel_data->hotel_RoomType; ?>
                                    </td>
                                    <td class='' style="width:30%; background-color:rgb(255, 145, 38); color:white; padding:10px; text-align: left" valign="top">
                                         <div style="font-size:12px">
                                            <?php echo $hotel_data->hotel_AdultQuantity; ?> Adult(s),&nbsp;
                                            <?php echo $hotel_data->hotel_ChildQuantity; ?> Child(s),&nbsp;
                                            <?php echo $hotel_data->hotel_InfantQuantity; ?> Infant(s)<br>
                                            Total Pax: <?php echo $hotel_data->hotel_AdultQuantity+$hotel_data->hotel_ChildQuantity+$hotel_data->hotel_InfantQuantity; ?>
                                        </div>
                                    </td>
                                    <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right;" valign="top"><?php
                                        $pricePerNight = ($hotel_data->hotel_PricePerRoom/$cart_hotel->duration);
                                        echo "$ ". number_format($pricePerNight, 2); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
                                        &nbsp;
                                    </td>
                                    <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align: right">
                                        <b>Total price (<?php echo $cart_hotel->duration;?> night(s))</b>
                                    </td>
                                    <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right;" valign="top">
                                        <b><?php
                                            $total_hotel_grand += $pricePerNight*$cart_hotel->duration;
                                            $total_hotel_grand_item += $pricePerNight*$cart_hotel->duration;
                                            echo "$ ".number_format($pricePerNight*$cart_hotel->duration, 2);
                                            ?></b>
                                    </td>
                                </tr>
                        <?php }
                        }?>
                        <tr>
                            <td colspan="2" class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right;" valign="top">
                                <b>Grand Total</b>
                            </td>
                            <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right;" valign="top"><b><?php echo "$ ".number_format($total_hotel_grand_item, 2);?></b></td>
                        </tr>
                        </table>
                    </div>
                    <br /><br />
                    <!--end of cart item-->
                <?php
                    }
                }
                else {
                ?>
                    <article class="full-width">
                        <div style="text-align:center; color:red; font-size:16px">
                            No hotel item found on your cart.
                        </div>
                    </article>
                <?php
                }
                ?>
            </ul>
        <?php
        } else  if( $this->session->userdata('shoppingCartCookie') == TRUE ) {
            if( count($this->session->userdata('shoppingCartCookie')) > 0 ) {
        ?>
                <div style="background-color:#eff0f1">
                    <div style="float:left; padding:10px">
                        <img src="<?php echo base_url(); ?>assets/info.png" width="50" height="50" />
                    </div>
                    <div style="float:left; padding:10px; width:75%; font-size:11px; margin-top:10px">
                        <b>Please note: Cot(s) will be requested at the hotel, however cots are not guaranteed and are subject to availability at check-in. Also, maximum age for cot is 2 years old.</b>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="checkout-error hidden bg-danger text-danger" style="text-align: center; padding: 10px; font-size: 14px; height: 30px; background: #ff0000; color:#ffffff">Error when do checkout. Max pax allowed is 9pax(s).</div>
                <br />
                <ul class="room-types">
                    <?php
                    $count_session_data = count($this->session->userdata('shoppingCartCookie'));
                    $arrayCart = $this->session->userdata('shoppingCartCookie');
                    $total_hotel_grand = 0;

                    for( $x=0; $x<$count_session_data; $x++ ) {
                        $total_hotel_grand_item = 0;
                    ?>
                    <!--hotel cart item-->
                    <div class="tab">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr class="days">
                                <th width="25%" style="text-align:left; background-color:#efefef" rowspan="4">
                                    <div style="font-size:12px">
                                        <img src="<?php echo $arrayCart[$x]["hotel_Image"]; ?>" alt="" width="150" height="115" />
                                    </div>
                                    <br />
                                    <div style="text-align:center">
                                        <a href="<?php echo base_url(); ?>cart/remove_item_cart_session/<?php echo $x; ?>" class="gradient-button" title="Remove" style="position:static">
                                            Remove
                                        </a>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td style="text-align:left; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Hotel name</h5>
                                        <?php echo $arrayCart[$x]["hotel_Fullname"]; ?>
                                    </div>
                                </td>
                                <td style="text-align:left; padding-bottom:0px">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Check-in date</h5>
                                        <?php echo date("l, d M Y", strtotime($arrayCart[$x]["check_in_date"])); ?>
                                    </div>
                                </td>
                                <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Check-out date</h5>
                                        <?php echo date("l, d M Y", strtotime($arrayCart[$x]["check_out_date"])); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Stay length</h5>
                                        <?php echo $arrayCart[$x]["duration"]; ?> night(s)
                                    </div>
                                </td>
                                <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>No.of room</h5>
                                        <?php echo $arrayCart[$x]["hotel_RoomQuantity"]; ?> room(s)
                                    </div>
                                </td>
                            </tr>
                            <tr class="days">
                                <th width="25%" style="text-align:left; background-color:#efefef" colspan="4">
                                    &nbsp;
                                </th>
                            </tr>
                        </table>
                        <table border="1" cellpadding="0" cellspacing="0">
                            <tr class='days'>
                                <th width="30%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align:left">
                                    <b>Room type</b>
                                </th>
                                <th width="40%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align: left">
                                    <b>Room details</b>
                                </th>
                                <th width="35%" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:14px; text-align: right">
                                    <b>Price per night ($)</b>
                                </th>
                            </tr>
                            <tr><td colspan="3" style="padding:0"></td></tr>
                            <?php
	                        $no = 1;
                            foreach($arrayCart[$x]['hotel_room'] as $roomData)
                            {
                                $hotelPaxRoom += ($roomData['hotel_AdultQuantity'] + $roomData['hotel_ChildQuantity'] + $roomData['hotel_InfantQuantity']);
                            ?>
                            <tr>
                                <td style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left" valign="top">
	                                ROOM #<?php echo $no; ?>:
	                                <br />
                                    <?php echo $roomData["hotel_RoomType"]; ?>
                                </td>
                                <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; text-align: left" valign="top">
                                     <div style="font-size:12px">
                                        <?php echo $roomData["hotel_AdultQuantity"]; ?> Adult(s),&nbsp;
                                        <?php echo $roomData["hotel_ChildQuantity"]; ?> Child(s),&nbsp;
                                        <?php echo $roomData["hotel_InfantQuantity"]; ?> Infant(s)<br>
                                        Stay length: <?php echo $arrayCart[$x]["duration"]; ?> night(s)
                                    </div>
                                </td>
                                <td style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:13px; text-align:right;" valign="top"><?php
                                    $pricePerNight = ($roomData["hotel_PricePerRoom"]/$arrayCart[$x]["duration"]);
                                    echo "$ ". number_format($pricePerNight, 2); ?>
                                </td>
                            </tr>
                            <!--
                            <tr>
                                <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:left">
                                    &nbsp;
                                </td>
                                <td style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align: right">
                                    <b>Total price (<?php echo $arrayCart[$x]["duration"];?> night(s))</b>
                                </td>
                                <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right; width:200px !important">
                                    <b><?php
                                        $total_hotel_grand += $pricePerNight*$arrayCart[$x]["duration"];
                                        $total_hotel_grand_item  += $pricePerNight*$arrayCart[$x]["duration"];
                                        echo "$ ".number_format($pricePerNight*$arrayCart[$x]["duration"], 2);
                                    ?></b>
                                </td>
                            </tr>
                            -->
                            <?php
	                            $no++;
                            }
                            ?>
                            <tr>
                                <td colspan="2" class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right; width:200px !important">
                                    <b>Grand Total</b>
                                </td>
                                <td class='time' style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right; width:200px !important"><?php echo "$ ".number_format($total_hotel_grand_item, 2);?></td>
                            </tr>
                        </table>
                    </div>
                    <br /><br />
                    <!--end of hotel cart item-->
                    <?php
                    }
                    ?>
                </ul>
            <?php
            }
            else {
            ?>
                <ul class="room-types">
                    <article class="full-width">
    					<div style="text-align:center; color:red; font-size:16px">
    						No hotel item found on your cart.
    					</div>
    				</article>
                </ul>
            <?php
            }
        }else {
            ?>
            <ul class="room-types">
                <article class="full-width">
                    <div style="text-align:center; color:red; font-size:16px">
                        No hotel item found on your cart.
                    </div>
                </article>
            </ul>
            <?php
            }
        ?>
    </article>
</section>