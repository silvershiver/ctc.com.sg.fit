<?php
//prevent notice + message error
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$pageSize = ceil($total_rows / 25);
//end of prevent notice + message error
if (!function_exists('UR_exists')) {
    function UR_exists($url)
    {
       $headers=get_headers($url);
       return stripos($headers[0],"200 OK")?true:false;
    }
}

if ($nodata == 1) {
    echo '<div class="deals clearfix" id="hotel_result"><article class="hotel_content full-width" style="padding:20px; text-align:center; color:#FF0000; font-size:12px">No Data Available<input type="hidden" id="nodt" value="1"></article></div>';
} else {
    $base64_hotelcheckin = base64_encode(base64_encode(base64_encode($hotel_checkin)));
    $base64_hotelcheckout = base64_encode(base64_encode(base64_encode($hotel_checkout)));
    $base64_duration = base64_encode(base64_encode(base64_encode($durations)));
    $base64_destination = base64_encode(base64_encode(base64_encode($destination)));
    $base64_country = base64_encode(base64_encode(base64_encode($country_name)));
    $base64_countrycode = base64_encode(base64_encode(base64_encode($country_code)));

    $table_hotel_facility = 'hotel_gta_item_information_facility';
    $table_room_facility = 'hotel_gta_item_information_room_facility';

    $arrFacs = array('*AC' => array('code'=>'AC', 'img'=>'ac.gif', 'content'=>'Air Conditioner'),
                    '*IP' => array('code'=>'SP', 'img'=>'sp.gif', 'content'=>'Swimming Pool'),
                    '*OP' => array('code'=>'SP', 'img'=>'sp.gif', 'content'=>'Swimming Pool'),
                    '*KP' => array('code'=>'SP', 'img'=>'sp.gif', 'content'=>'Swimming Pool'),
                    '*IN' => array('code'=>'TV', 'img'=>'tv.gif', 'content'=>'Television'),
                    '*TV' => array('code'=>'TV', 'img'=>'tv.gif', 'content'=>'Television'),
                    '*FI' => array('code'=>'TV', 'img'=>'tv.gif', 'content'=>'Television'),
                    '*SV' => array('code'=>'TV', 'img'=>'tv.gif', 'content'=>'Television'),
                    '*BS' => array('code'=>'BS', 'img'=>'bs.gif', 'content'=>'Baby Sitting'),
                    '*RS' => array('code'=>'RS', 'img'=>'rs.gif', 'content'=>'Room Service'),
                    '*MB' => array('code'=>'RT', 'img'=>'rt.gif', 'content'=>'Restaurant'),
                    '*TE' => array('code'=>'TE', 'img'=>'tc.gif', 'content'=>'Tennis'),
                    '*LT' => array('code'=>'LT', 'img'=>'wf.gif',  'content'=>'WiFi'),
                    '*DF' => array('code'=>'DF', 'img'=>'df.gif',  'content'=>'Disabled Facilities'),
                    '*GY' => array('code'=>'GY', 'img'=>'gym.gif',  'content'=>'Fitness Center / Gymnasium'),
                    '*CP' => array('code'=>'PK', 'img'=>'pk.gif', 'content'=>'Parking'),
                    '*HP' => array('code'=>'PK', 'img'=>'pk.gif', 'content'=>'Parking'),
    );

    /*$arrFacs = array('*AC' => 'ac.gif', '*IP,*OP,*KP' => 'sp.gif',
        '*IN,*SV,*TV,*FI' => 'tv.gif',
        '*BS' => 'bs.gif', '*RS' => 'rs.gif', '*MB' => 'rt.gif', '*TE' => 'tc.gif',
        '*LT' => 'wf.gif', '*DF' => 'df.gif', '*GY' => 'gym.gif', '*CP,*HP' => 'pk.gif'
    );*/
    $paginHtml = "";
    for ($x = 1; $x <= $pageSize; $x++) {
        $cls="";
        if($x==1) {
            $cls = 'class="current"';
        }
        $paginHtml .= '<span><a href="#" '.$cls.' data-val="'.$x.'"><b>'.$x.'</b></a></span>';
    }
?>
<style>
    .hotel_content {display:none;}
    .deals .full-width .address {max-width:75% !important;}
</style>
    <input type="hidden" id="nodt" value="0">
    <div class="pager">
        <?php echo $paginHtml; // echo $this->pagination->create_links(); ?>
    </div>
    <div style="clear:both"></div>

        <!--Copyright image-->
        <?php
        $countResult = 0;
        if(isset($hotel_search_array[0])) {
            $countResult = count ($hotel_search_array);
        } else {
            $countResult = 1;
            $hotel_search_array[0] = $hotel_search_array;
        }
        if( $countResult != 0 ) {
        ?>

            <div style="text-align:right; font-size:13px; margin-bottom:5px; margin-top:5px">
                <b><i>Image from VFM Leonardo, Inc.</i></b>
            </div>
        <?php
        }
        ?>
        <!--End of Copyright image-->
        <div class="deals clearfix" id="hotel_result">
            <?php
            /* list location detail */
            $locationArray = $this->All->select_template_basic('hotel_list_location_gta');
            $locArray = array();
            foreach ($locationArray as $dataLoc) {
                $locArray[$dataLoc->location_code] = $dataLoc->location_name;
            }

            if ( $countResult != 0 ) {
                for ($x=0; $x<$countResult; $x++ ) {
                    $itemCode = $hotel_search_array[$x]["Item"]["@attributes"]["Code"];
                    $cityCode = $hotel_search_array[$x]["City"]["@attributes"]["Code"];

                    //itemInformation
                    $informations = $this->All->select_template_w_2_conditions(
                        "item_code", $itemCode, "city_code", $cityCode, "hotel_gta_item_information"
                    );

                    $infos = $this->All->select_template_w_2_conditions(
                        "city_code", $cityCode, "item_code", $itemCode, "hotel_gta_item_information_report"
                    );
                    $printInfoContent = "";
                    if ( $infos == TRUE ) {
                        foreach( $infos AS $info ) {
                            if($info->content != "" && $info->content != ".")
                                $printInfoContent .= $info->content ." ";
                            else {
                                $printInfoContent;
                            }
                        }
                    }

                    $printHotelName = "-";
                    $printCityName = "";
                    $printCityName = $city_name;

                    $printAddressLine1 = $printAddressLine2 = $printAddressLine3 = $printAddressLine4 = "";
                    if ( $informations == TRUE ) {
                        /*foreach( $informations AS $information ) {*/
                            $printHotelName    = $informations[0]->item_content;
                            /*$printLocationText = $information->location_text;*/
                            $printAddressLine1 = $informations[0]->AddressLine1;
                            $printAddressLine2 = $informations[0]->AddressLine2;
                            $printAddressLine3 = $informations[0]->AddressLine3;
                            $printAddressLine4 = $informations[0]->AddressLine4;
                        /*}*/
                        $printFullAddress = $printAddressLine1.' '.$printAddressLine2.' '.$printAddressLine3.' '.$printAddressLine4;

                        $print_hotel_name = str_replace(" ", "_", $printHotelName);
                    } else {
                        continue; //skip empty hotel
                    }

                    $paxRoom  = $hotel_search_array[$x]["PaxRoomSearchResults"]["PaxRoom"];
                    /* location Detail, taken from api instead from database */
                    $locationName = "";
                    $locationData = $hotel_search_array[$x]['LocationDetails']['Location'];

                    if ( isset($locationData[0]) && !empty($locationData[0])) {
                        foreach ($locationData as $locData) {
                            if (isset($locArray[$locData['@attributes']['Code']])) {
                                $locationName .= $locArray[$locData['@attributes']['Code']] ." - ";
                            }
                        }
                    } else if (isset($locArray[$locationData['@attributes']['Code']])) {
                        $locationName .= $locArray[$locationData['@attributes']['Code']] ." - ";
                    }

                    $locationName = rtrim($locationName, "- ");

                    //end of report information
                    //starting price
                    $printStartingPrice = 99999999;
                    if ( isset($paxRoom[0]) ) {
                        foreach ($paxRoom as $roomd) {
                            if ( isset($roomd["RoomCategories"]["RoomCategory"][0]) ) {
                                foreach ($roomd['RoomCategories']['RoomCategory'] as $roomcat) {
                                    if($printStartingPrice >= $roomcat["ItemPrice"])
                                        $printStartingPrice = $roomcat["ItemPrice"];
                                }
                            }
                            else {
                                if($printStartingPrice >= $roomd["RoomCategories"]["RoomCategory"]["ItemPrice"])
                                    $printStartingPrice = $roomd["RoomCategories"]["RoomCategory"]["ItemPrice"];
                            }
                        }

                    }
                    else {
                        if ( isset($paxRoom["RoomCategories"]["RoomCategory"][0]) ) {
                            foreach ($paxRoom['RoomCategories']['RoomCategory'] as $roomcat) {
                                if($printStartingPrice >= $roomcat["ItemPrice"])
                                    $printStartingPrice = $roomcat["ItemPrice"];
                            }

                        }
                        else {
                            if($printStartingPrice >= $paxRoom["RoomCategories"]["RoomCategory"]["ItemPrice"])
                                $printStartingPrice = $paxRoom["RoomCategories"]["RoomCategory"]["ItemPrice"];
                        }

                    }

                    $printStartingPrice = $printStartingPrice + round( (GTA_PRICE_MARKUP / 100)* $printStartingPrice, 2);
                    $printStartingPrice = ceil($printStartingPrice);
                    //end of starting price
            ?>
            <article class="hotel_content full-width" data-price="<?php echo number_format($printStartingPrice, 2); ?>" id="<?php echo $cityCode.'--'.$itemCode; ?>">
                <figure style="width:270px; height: 172px">
                    <?php
                        $arrayPax = array();
                        //echo ceil($prints2) ." " . ceil((GTA_PRICE_MARKUP / 100)* $prints2);
                        /*
                        $arrayAdult = array();
                        $arrayChild = array();
                        $arrayInfant = array();*/
                        $childAges = "";
                        for ( $ip=1; $ip<=$no_of_rooms; $ip++ ) {
                            $arrayPax[] = $paxRoomSelection[$ip]["hotel_noofadult"].''.$paxRoomSelection[$ip]["hotel_noofchildren"].''.$paxRoomSelection[$ip]["hotel_noofinfant"];
                            if($paxRoomSelection[$ip]['hotel_noofchildren'] > 0 ) {
                                $childAges[] = $paxRoomSelection[$ip]['hotel_childrenAges'];
                            } else {
                                $childAges[] = '0';
                            }
                            /*$arrayAdult[] = $paxRoomSelection[$ip]["hotel_noofadult"];
                            $arrayChild[] = $paxRoomSelection[$ip]["hotel_noofchildren"];
                            $arrayInfant[] = $paxRoomSelection[$ip]["hotel_noofinfant"];*/
                        }

                        $implodePax = implode(",", $arrayPax);
                        if ($childAges != "")
                            $implodeChildAges = implode(";", $childAges);
                        /*
                        $implodeAdult = implode(",", $arrayAdult);
                        $implodeChild = implode(",", $arrayChild);
                        $implodeInfant =  implode(",", $arrayInfant);*/

                        $base64_itemcode = base64_encode(base64_encode(base64_encode($itemCode)));
                        $base64_room = base64_encode(base64_encode(base64_encode($no_of_rooms)));
                        $base64_pax = base64_encode(base64_encode(base64_encode($implodePax)));
                        $base64_childAges = "";
                        if($childAges != "") {
                            $base64_childAges = "/". base64_encode(base64_encode(base64_encode($implodeChildAges)));
                        }
                        $linkurl = base_url()."hotel/details/". base64_encode(base64_encode(base64_encode($cityCode)))."/". $base64_itemcode. "/". $base64_hotelcheckin . "/". $base64_hotelcheckout ."/". $base64_duration."/".$base64_room ."/". $base64_pax."/". $base64_destination."/". $base64_country."/". $base64_countrycode . $base64_childAges; // country code
                    ?>
                    <a href="<?php echo $linkurl; ?>" target="_blank">
                        <?php
                            $imageLink = $this->All->getHotelImagePicture($itemCode, $cityCode);
                            if(UR_exists($imageLink) === false) {
                                $imageLink = base_url()."assets/default.png";
                            }
                        ?>
                        <img src="<?php echo str_replace('http://', 'https://', $imageLink); ?>" width="270" height="172" />
                    </a>
                </figure>
                <div class="details">
                    <h1 class="hotelName">
                        <!-- <small><?php echo $cityCode.' - ' .$itemCode; ?></small> -->
                        <span class="title"><?php echo $printHotelName; ?></span>
                        <span class="stars" data-score="<?php echo $hotel_search_array[$x]["StarRating"] ;?>">
                            <?php
                            $hotelStarRating = $hotel_search_array[$x]["StarRating"];
                            for ($s=1; $s <= $hotelStarRating; $s++) {
                            ?>
                                <img src="<?php echo base_url(); ?>assets/images/ico/star.png" alt="" />
                            <?php
                            }
                            ?>
                        </span>
                    </h1>
                    <span class="address" style="float:left; width: 100%">
                        <div style="float:left; margin-right: 5px;"><?php echo $locationName; ?><?php echo $locationName == "" ? "" : "" ;?>
                        •</div>
                        <?php
                            $thisFac = array();
                            $thisFacCont = array();

                            $this->db->select('code, content');
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->order_by('content', 'ASC');
                            $qry = $this->db->get($table_hotel_facility);
                            $hotel_facilities = $qry->num_rows() ? $qry->result() : array();
                            foreach( $hotel_facilities AS $hotel_facility ) {
                                $thisFac[$arrFacs[$hotel_facility->code]['code']] = $arrFacs[$hotel_facility->code];
                            }

                            $this->db->select('code, content');
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->order_by('content', 'ASC');
                            $qry = $this->db->get($table_room_facility);
                            $room_facilities = $qry->num_rows() ? $qry->result() : array();
                            /*$room_facilities = $this->All->select_template_with_order(
                                "room_facility_name", "ASC", "hotel_list_roomfacility_gta"
                            );*/
                            foreach( $room_facilities AS $room_facility ) {
                                /*$thisFac[] = array('code'=>$room_facility->code, 'cont'=>$room_facility->content);*/
                                $thisFac[$arrFacs[$room_facility->code]['code']] = $arrFacs[$room_facility->code];
                            }

                            array_unique($thisFac);

                            foreach($thisFac as $facility) {
                                if(isset($facility['img']))
                                echo '<div title="'.$facility['content'].'" style="float:left; width:4%"><img src="'.base_url('assets/fac_icon/'.$facility['img']).'"></div>';
                            }
                        ?>

                        <div style="clear:both"></div>
                    </span>
                    <span class="price">
                        Starting price<br />per room
                        <em><span class="price_detail">$ <?php echo number_format($printStartingPrice, 2); ?></span></em>
                    </span>
                    <div class="description">
                        <p>
                            <?php echo word_limiter($printInfoContent, 25); ?>
                            <a href="<?php echo $linkurl; ?>" target="_blank">More info</a>
                        </p>
                    </div>
                    <a href="<?php echo $linkurl; ?>" title="Book now" class="gradient-button" target="_blank">Book now</a>
                </div>
            </article>
            <?php
                    $data_count_room_category += $countHotelRoom;
                    $data_hotels[] = array($cityCode, $itemCode/*, implode(",", array_keys(array_filter($thisFac))*/);
                }
            }
            else {
            ?>
                <div style="text-align:center; color:red; padding:15px; font-size:16px; background-color:white">
                    No hotel found. Please search another hotel with different search parameters.
                </div>
            <?php
            }

            $data_hotels_json = json_encode($data_hotels);
            ?>
            <input type="hidden" name="data_hotel" id="data_hotel" value='<?php echo $data_hotels_json; ?>' />

            <?php
            if( $data_count != 0 ) {
            ?>
            <div class="bottom-nav">
                <a href="#" class="scroll-to-top" title="Back up">Back up</a>
            </div>
            <?php
            }
            ?>
        </div>
        <div id="divLoading" style="display:none; margin:0px; padding:0px; position:fixed; right:0px; top:0px; width:100%; height:100%; background-color: rgb(102, 102, 102); z-index:30001; opacity:0.8;">
            <p style="position:absolute; color:white; top:50%; left:45%; padding:0px">
                Processing Request... Please wait...
                <img src="<?php echo base_url(); ?>assets/progress_bar/ajax-loader.gif" style="margin-top:5px">
            </p>
        </div>
        <div class="bottom-nav">

            <!-- <div style="float:left">There is total <strong><?php echo $total_rows;?></strong> hotels found.</div> -->
            <div style="float:right">
                <a href="#" class="scroll-to-top" title="Back up">Back up</a>
                <div class="pager">
                    <?php
                        echo $paginHtml;
                    ?>
                    <?php // echo $this->pagination->create_links();?>
                </div>
            </div>
            <div style="clear:both"></div>

        </div>


    <script>
    $(document).ready(function(){
        /*$('.search-paginate', '.pager').on('click', function(e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 500);
            $('#opener').show();
            $('.loaders').show();
            var page = $(this).data('ci-pagination-page');
            generatedata(page);
        });*/
    });

    </script>
<?php } ?>