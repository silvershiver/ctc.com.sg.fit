<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/XMLTransactionHander.class.php';

class Search extends MY_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    var $instanceurl = "/var/www/html/ctctravel.org/fit/";

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Landtour");
    }

    public function nodataresult()
    {
        $this->load->view('nodata_index');
    }

    public function cruise_filter()
    {
        //post input parameters
        $noofAdult    = $this->input->post("hidden_noofAdult");
        $noofChildren = $this->input->post("hidden_noofChild");
        $hidden_cruiseMonthDate = $this->input->post("hidden_cruiseMonthDate");
        $hidden_cruiseType_port = $this->input->post("hidden_cruiseType_port");
        $filterBrands  = $this->input->post("filterBrand");
        $filterLengths = $this->input->post("filterLength");
        //end of post input parameters

        //cruise type brand ID
        if( count($filterBrands) > 0 ) {
            $shipIDArrs = "";
            foreach( $filterBrands AS $filterBrand ) {
                $shipIDArrs .= $filterBrand.',';
            }
            $array_implode = trim($shipIDArrs, ",");
            $brandSQL = $this->All->multipleBrandID($array_implode);
            if( $brandSQL != "" ) {
                $cruiseShipID = trim($brandSQL, ",");
                $cruiseTypeUsed = "AND SHIP_ID IN (".$cruiseShipID.")";
            }
            else {
                $cruiseTypeUsed = "";
            }
        }
        else {
            $cruiseTypeUsed = "";
        }
        //end of cruise type brand ID

        //cruise departure port
        if( $hidden_cruiseType_port == "ALL" ) {
            $cruisePortUsed = "";
        }
        else {
            $cruisePortUsed = "AND DEPARTURE_PORT = '".$hidden_cruiseType_port."'";
        }
        //end of cruise departure port

        //cruise month date
        $arrayMonthDate = explode("-", $hidden_cruiseMonthDate);
        $yearGet  = $arrayMonthDate[0];
        $monthGet = $this->All->getMonthFormat($arrayMonthDate[1]);
        $formatDateMySQL = $yearGet.'-'.$monthGet;
        $cruiseMonthDateUsed = "AND DEPARTURE_DATE LIKE '%".$formatDateMySQL."%'";
        //end of cruise month date

        //cruise length
        if( count($filterLengths) > 0 ) {
            $lengthArrays = "";
            foreach( $filterLengths AS $filterLength ) {
                $lengthArrays .= $filterLength.',';
            }
            $length_implode = trim($lengthArrays, ",");
            $cruiseLengthUsed = "AND NIGHTS IN(".$length_implode.")";
        }
        else {
            $cruiseLengthUsed = "";
        }
        //end of cruise length

        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT * FROM cruise_title
                WHERE IS_SUSPEND = 0 $cruiseTypeUsed $cruisePortUsed $cruiseMonthDateUsed $cruiseLengthUsed
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            while( $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                $arrayResults[] = $check_row;
            }
        }
        else {
            $arrayResults = array();
        }

        $data["cruiseFinalResult"] = $arrayResults;
        $data["cruiseTypeArr"]     = $filterBrands;
        $data["cruiseType_port"]   = $hidden_cruiseType_port;
        $data["cruiseMonthDate"]   = $hidden_cruiseMonthDate;
        $data["cruiseLength"]      = $filterLengths;
        $data["noofAdult"]         = $noofAdult;
        $data["noofChildren"]      = $noofChildren;
        $this->load->view('search_cruise_filter', $data);

    }

    public function cruise_result()
    {
        //post input parameters
        $arrayFilterBrand  = array();
        $arrayFilterLength = array();
        $arrayResults      = array();
        $cruiseType        = $this->input->post("cruiseType_BrandName");
        $cruiseType_port   = $this->input->post("cruiseType_port");
        $cruiseMonthDate   = $this->input->post("cruiseMonthDate");
        $cruiseLength      = $this->input->post("cruiseLength");
        $noofAdult         = $this->input->post("noofAdult");
        $noofChildren      = $this->input->post("noofChildren");
        //end of post input parameters

        //cruise type brand ID
        if( $cruiseType == "ALL" ) {
            $cruiseTypeUsed = "";
        }
        else {
            $shipIDArrs = "";
            $listShipIDs = $this->All->select_template("PARENT_BRAND", $cruiseType, "cruise_ships");
            if( $listShipIDs == TRUE ) {
                foreach( $listShipIDs AS $listShipID ) {
                    $shipIDArrs .= $listShipID->ID.',';
                }
                $shipIDArrs1 = trim($shipIDArrs, ",");
                $cruiseTypeUsed = "AND SHIP_ID IN (".$shipIDArrs1.")";
            }
            else {
                $cruiseTypeUsed = "AND SHIP_ID IN (".$cruiseType.")";
            }
        }
        //end of cruise type brand ID

        //cruise departure port
        if( $cruiseType_port == "ALL" ) {
            $cruisePortUsed = "";
        }
        else {
            $cruisePortUsed = "AND DEPARTURE_PORT = '".$cruiseType_port."'";
        }
        //end of cruise departure port

        //cruise month date
        $arrayMonthDate = explode("-", $cruiseMonthDate);
        $yearGet  = $arrayMonthDate[0];
        $monthGet = $this->All->getMonthFormat($arrayMonthDate[1]);
        $formatDateMySQL = $yearGet.'-'.$monthGet;
        $cruiseMonthDateUsed = "AND DEPARTURE_DATE LIKE '%".$formatDateMySQL."%'";
        //end of cruise month date

        //cruise length
        if( $cruiseLength == "ALL" ) {
            $cruiseLengthUsed = "";
        }
        else {
            if( $cruiseLength == "1_2" ) {
                $cruiseLengthUsed = "AND NIGHTS >= 1 AND NIGHTS <= 2";
            }
            else if( $cruiseLength == "3_6" ) {
                $cruiseLengthUsed = "AND NIGHTS >= 3 AND NIGHTS <= 6";
            }
            else if( $cruiseLength == "7_9" ) {
                $cruiseLengthUsed = "AND NIGHTS >= 7 AND NIGHTS <= 9";
            }
            else if( $cruiseLength == "10_14" ) {
                $cruiseLengthUsed = "AND NIGHTS >= 10 AND NIGHTS <= 14";
            }
            else if( $cruiseLength == "OVER_14" ) {
                $cruiseLengthUsed = "AND NIGHTS >= 14";
            }
        }
        //end of cruise length

        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT * FROM cruise_title
                WHERE IS_SUSPEND = 0 $cruiseTypeUsed $cruisePortUsed $cruiseMonthDateUsed $cruiseLengthUsed
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            while( $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                $arrayResults[] = $check_row;
            }
        }

        $data["cruiseFinalResult"] = $arrayResults;
        $data["cruiseType"]        = $cruiseType;
        $data["cruiseType_port"]   = $cruiseType_port;
        $data["cruiseMonthDate"]   = $cruiseMonthDate;
        $data["cruiseLength"]      = $cruiseLength;
        $data["noofAdult"]         = $noofAdult;
        $data["noofChildren"]      = $noofChildren;
        $this->load->view('search_cruise_index', $data);
    }

    public function landtour_filter()
    {
        //parameters
        $startDate   = $this->input->post("hidden_start_date");
        $endDate     = $this->input->post("hidden_end_date");
        $destination = $this->input->post("hidden_landtour_destination");
        $poi         = $this->input->post("hidden_poi");
        $cksPOI      = $this->input->post("filterPOI");
        $cksCountry  = $this->input->post("filterCountry");
        if( is_array($cksPOI) ) {
            $categoryIN = "AND lt_category_id IN(".implode(",", $cksPOI).")";
        }
        else {
            $categoryIN = "";
        }
        if( is_array($cksCountry) ) {
            $countryIN = "AND location IN(".implode(",", $cksCountry).")";
        }
        else {
            $countryIN  = "";
        }
        //end of parameters
        //query syntax
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT * FROM landtour_product
                WHERE is_suspend = 0 AND is_deleted = 0
                AND start_date <= '".$startDate."' AND end_date >= '".$endDate."' $categoryIN $countryIN
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            while( $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                $arrayResults[] = $check_row;
            }
        }
        else {
            $arrayResults = "";
        }
        $data["landtourFinalResult"]  = $arrayResults;
        $data["point_of_interest"]    = $poi;
        $data["landtour_destination"] = $destination;
        $data["from_date"]            = $startDate;
        $data["to_date"]              = $endDate;
        $data["checkboxsPOI"]         = $cksPOI;
        $data["checkboxsCountry"]     = $cksCountry;
        $this->load->view('search_landtour_index', $data);
        //end o fquery syntax
    }

    public function landtour_result()
    {
        error_reporting( E_ALL & ~( E_NOTICE | E_STRICT | E_DEPRECATED | E_WARNING | E_PARSE ) );
        if( $this->input->post("datepicker4") >= $this->input->post("datepicker5") ) {
            $this->session->set_flashdata(
                'error_date',
                '<span>Check-in date must be earlier than Check-out date</span>'
            );
            redirect("/");
        }
        else {
            //parameters
            $point_of_interest    = $this->input->post("landtour_point_interest");
            $landtour_destination = $this->input->post("landtour_destination");
            $from_date            = $this->input->post("datepicker4");
            $to_date              = $this->input->post("datepicker5");
            $destination_explode  = explode("-", $landtour_destination);
            $destination_country  = $destination_explode[0];
            $destination_city     = $destination_explode[1];
            //end of parameters
            //if else syntax
            if( $point_of_interest == "ALL" ) {
                $point_of_interest_tag = "";
            }
            else {
                $point_of_interest_tag = "AND lt_category_id = ".$point_of_interest."";
            }
            if( $landtour_destination == "ALL" ) {
                $location = "";
            }
            else {
                $location = "AND location LIKE '%".$landtour_destination."%'";
            }
            //end of if else syntax
            //query syntax
            $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            $check_res  = mysqli_query(
                $connection,
                "
                    SELECT * FROM landtour_product
                    WHERE is_suspend = 0 AND is_deleted = 0 AND start_date <= '".$from_date."' AND end_date >= '".$to_date."'
                    $location $point_of_interest_tag
                "
            );
            if( mysqli_num_rows($check_res) > 0 ) {
                while( $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                    $arrayResults[] = $check_row;
                }
            }
            $data["landtourFinalResult"]   = $arrayResults;
            $data["point_of_interest"]     = $point_of_interest;
            $data["landtour_destination"]  = $landtour_destination;
            $data["from_date"]             = $from_date;
            $data["to_date"]               = $to_date;
            $data["checkboxsPOI"]          = "";
            $data["checkboxsCountry"]      = "";
            $this->load->view('search_landtour_index', $data);
            //end o fquery syntax
        }
    }

    public function flight_result()
    {
        error_reporting( E_ALL & ~( E_NOTICE | E_STRICT | E_DEPRECATED | E_WARNING | E_PARSE ) );
        if( $this->input->post("radioType") == "return" ) {
            if( $this->input->post("datepicker6") >= $this->input->post("datepicker7") ) {
                $this->session->set_flashdata('error_date', '<span>Departure date must be earlier than Return date</span>');
                redirect("/");
            }
            else {
                //input flight
                $leaving_from  = $this->input->post("flight_going_from");
                preg_match('#\((.*?)\)#', $leaving_from, $match);
                $leaving_input = $match[1];
                $going_to    = $this->input->post("flight_going_to");
                preg_match('#\((.*?)\)#', $going_to, $match);
                $going_input = $match[1];

                if(strlen($match[1]) > 3) {
                    preg_match_all('/(?:\()(.*?)(?:\))/i', $going_to, $match);
                    $ky = count($match);
                    $going_input = $match[$ky-1][1];
                }

                $checkin              = $this->input->post("datepicker6")."T00:00:00";
                $checkin_month_input  = date("m", strtotime($checkin));
                $checkin_date_input   = date("d", strtotime($checkin));
                $checkin_time         = "$checkin_month_input-$checkin_date_input"."T00:00:00";
                $checkout             = $this->input->post("datepicker7")."T00:00:00";
                $checkout_month_input = date("m", strtotime($checkout));
                $checkout_date_input  = date("d", strtotime($checkout));
                $checkout_time        = "$checkout_month_input-$checkout_date_input"."T00:00:00";
                //end of input flight
                $array_search_contents = array();
                $file_datas  = require_once($this->instanceurl.'webservices/abacus/SWSWebservices.class.php');

                 $resultsFlight = search_flight_return ($checkin, $checkout, $leaving_input, $going_input,
                    $this->input->post("flightAdult"), $this->input->post("flightChild"),
                    $this->input->post("flightInfant"), $this->input->post("flightClass")
                );
                $parseResult            = simplexml_load_string($resultsFlight);
                $arrayFinalFlight       = json_decode(json_encode($parseResult), true);
                $arrayFinalFlight       = $arrayFinalFlight["PricedItineraries"]["PricedItinerary"];
                $countArrayFinalFlight  = count($arrayFinalFlight);
                $data['flight_results'] = $arrayFinalFlight;
                $data['totalFlight']    = $countArrayFinalFlight;
                /*--End of Return Results--*/
                $data["from_city"]               = $this->All->get_airport_city_name($leaving_input);
                $data["to_city"]                 = $this->All->get_airport_city_name($going_input);
                $data["input_leaving_from"]      = $this->input->post("flight_going_from");
                $data["input_going_to"]          = $this->input->post("flight_going_to");
                $data["input_flight_type"]       = $this->input->post("radioType");
                $data["input_check_in"]          = $this->input->post("datepicker6");
                $data["input_check_out"]         = $this->input->post("datepicker7");
                $data["no_passenger"]            = $this->input->post("name_of_passenger");
                $data["flightAdult"]             = $this->input->post("flightAdult");
                $data["flightChild"]             = $this->input->post("flightChild");
                $data["flightInfant"]            = $this->input->post("flightInfant");
                $data["flightClass"]             = $this->input->post("flightClass");
                $data["filterAirlines"]          = "";
                $this->load->view('search_flight_return_index', $data);
            }
        }
        else {
            //input flight
            $leaving_from  = $this->input->post("flight_going_from");
            preg_match('#\((.*?)\)#', $leaving_from, $match);
            $leaving_input = $match[1];
            $going_to    = $this->input->post("flight_going_to");

            preg_match('#\((.*?)\)#', $going_to, $match);
            $going_input = $match[1];
            if(strlen($match[1]) > 3) {
                preg_match_all('/(?:\()(.*?)(?:\))/i', $going_to, $match);
                $ky = count($match);
                $going_input = $match[$ky-1][1];
            }
            $checkin = $this->input->post("datepicker6")."T00:00:00";
            $checkin_month_input = date("m", strtotime($checkin));
            $checkin_date_input  = date("d", strtotime($checkin));
            $checkin_time = "$checkin_month_input-$checkin_date_input"."T06:00:00";
            $flightAdult  = $this->input->post("flightAdult");
            $flightChild  = $this->input->post("flightChild");
            $flightInfant = $this->input->post("flightInfant");
            $flightClass  = $this->input->post("flightClass");
            //end of input flight

            /*echo $this->input->post("flight_going_from");
            echo '<br>--';
            echo $this->input->post("flight_going_to");
            echo '<br>--';
            echo $going_to;
            echo '<br>--';
            echo $going_input;
            */
            $array_search_contents = array();
            $file_datas  = require_once($this->instanceurl.'webservices/abacus/SWSWebservices.class.php');
            $results     = search_flight(
                $going_input, $leaving_input,
                $checkin, $this->input->post("flightAdult"), $this->input->post("flightChild"), $this->input->post("flightInfant"),
                $this->input->post("flightClass")
            );

            /*$results     = testFl(
                $going_input, $leaving_input,
                '2017-12-30T00:00:00', $this->input->post("flightAdult"), $this->input->post("flightChild"), $this->input->post("flightInfant"),
                $this->input->post("flightClass")
            );*/
            $parseResult = simplexml_load_string($results);
            $arrayFinal  = json_decode(json_encode($parseResult), true);
            $arrayFinal  = $arrayFinal["PricedItineraries"]["PricedItinerary"];
            $countArrayFinal = count($arrayFinal);

            /*
                Legend:
                ================================
                AI   => AirItinerary
                AIPI => AirItineraryPricingInfo
                BF   => BaseFare
                FC   => FareConstruction
                EF   => EquivFare
                TF   => TotalFare
                FB   => FareBreakdowns
                PF   => PassengerFare
                PT   => PassengerType
            */
            $data["flight_results"]     = $arrayFinal;
            $data["totalFlight"]        = $countArrayFinal;
            $data["from_city"]          = $this->All->get_airport_city_name($leaving_input);
            $data["to_city"]            = $this->All->get_airport_city_name($going_input);
            $data["input_leaving_from"] = $this->input->post("flight_going_from");
            $data["input_going_to"]     = $this->input->post("flight_going_to");
            $data["input_flight_type"]  = $this->input->post("radioType");
            $data["input_check_in"]     = $this->input->post("datepicker6");
            $data["input_check_out"]    = $this->input->post("datepicker7");
            $data["no_passenger"]       = $this->input->post("name_of_passenger");
            $data["flightAdult"]        = $this->input->post("flightAdult");
            $data["flightChild"]        = $this->input->post("flightChild");
            $data["flightInfant"]       = $this->input->post("flightInfant");
            $data["flightClass"]        = $this->input->post("flightClass");
            $data["filterAirlines"]     = "";
            $this->load->view('search_flight_index', $data);
        }
    }

    public function hotel_api()
    {
        $data['nodata'] = 0;

        $this->load->library('pagination');
        $rating = 5;
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $destinationCode = $this->input->post('hid_destinationCode');

            $city = $this->All->select_template("city_code", $destinationCode, "hotel_gta_item");
            if($city) {
                $timestart = microtime(true);
                $data['city_name'] = $city[0]->city_name;

                $minprice = $this->input->post('minprice');
                $maxprice = $this->input->post('maxprice');
                $rating = $this->input->post('rate');

                $this->db->select('hotel_gta_item.item_code');
                $this->db->join('hotel_gta_item_information', 'hotel_gta_item_information.item_code = hotel_gta_item.item_code AND hotel_gta_item_information.city_code=hotel_gta_item.city_code');
                $this->db->where('hotel_gta_item.city_code', $destinationCode);
                if($rating != "" || $rating != "0")
                    $this->db->where('hotel_gta_item_information.star_rating', $rating);
                $qry = $this->db->get('hotel_gta_item');
                $total_all_item = $qry->num_rows() ? $qry->num_rows() : 0;

                /* $limits = 25; */
                /*$offset = $this->uri->segment(4) == 1 ? 0 : $this->uri->segment(4);
                $this->db->select('hotel_gta_item.item_code');
                $this->db->join('hotel_gta_item_information', 'hotel_gta_item_information.item_code = hotel_gta_item.item_code AND hotel_gta_item_information.city_code=hotel_gta_item.city_code');
                $this->db->where('hotel_gta_item.city_code', $destinationCode);
                $this->db->where('hotel_gta_item_information.star_rating', $rating);
                $this->db->limit($limits, $offset * $limits);
                $qry = $this->db->get('hotel_gta_item');*/

                $total_item = $qry->num_rows() ? $qry->num_rows() : 0;
                $result_item = $qry->result();

                //input hotel
                $hotel_checkin    = $this->input->post("hid_hotel_checkin");
                $hotel_checkout   = $this->input->post("hid_hotel_checkout");
                $destinationType  = "city";

                $countryName = $this->input->post("hid_countryname");
                $countryCode = $this->input->post("hid_countrycode");
                $hotelDestination = $this->input->post("hid_hotel_destination");


                $days = floor(strtotime($hotel_checkout)/(60*60*24)) - floor(strtotime($hotel_checkin)/(60*60*24));
                $days = abs($days);
                $number_of_room     = $this->input->post("hid_hotel_noofroom");
                $totalPaxQty = 0;
                for ($i=1; $i<=$number_of_room; $i++) {
                    $paxRooms[$i]['hotel_noofadult']    = $this->input->post("hid_hotel_noofadult_".$i);
                    $paxRooms[$i]['hotel_noofchildren'] = $this->input->post("hid_hotel_noofchildren_".$i);
                    $paxRooms[$i]['hotel_noofinfant']   = $this->input->post("hid_hotel_noofinfant_".$i);
                    $paxRooms[$i]['hotel_childrenAges'] = $this->input->post("hid_hotel_childrenAges_".$i);

                    /*$totalPaxQty += ($paxRooms[$i]['hotel_noofadult'] + $paxRooms[$i]['hotel_noofchildren'] + $paxRooms[$i]['hotel_noofinfant']);*/
                }

                /*$itemCodeList = '';
                $withItem = false;
                if ($total_item) {
                    $withItem = true;
                    foreach ($result_item as $data_item_city) {
                        $itemCodeList .= '<ItemCode>'.$data_item_city->item_code.'</ItemCode>';
                    }
                }*/

                //end of input hotel
                //process API
                $requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
                $requestData .= '<Request>';
                $requestData .=     '<Source>';
                $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD" Country="SG">';//$countryCode
                $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                $requestData .=         '</RequestorPreferences>';
                $requestData .= '   </Source>';
                $requestData .= '   <RequestDetails>';
                $requestData .= '       <SearchHotelPricePaxRequest>';
                $requestData .=             '<ItemDestination DestinationType="city" DestinationCode="'.$destinationCode.'"/>';

                $requestData .=             '<ImmediateConfirmationOnly/>';
                /*if ($withItem) {
                    $requestData .= '<ItemCodes>';
                    $requestData .= $itemCodeList;
                    $requestData .= '</ItemCodes>';
                }*/
                $requestData .=             '<PeriodOfStay>';
                $requestData .=             '   <CheckInDate>'.$hotel_checkin.'</CheckInDate>';
                $requestData .=             '   <Duration><![CDATA['.$days.']]></Duration>';
                $requestData .=             '</PeriodOfStay>';
                $requestData .=             '<IncludeRecommended/>';
                $requestData .=             '<IncludePriceBreakdown/>';
                $requestData .=             '<IncludeChargeConditions DateFormatResponse = "true"/>';
                $requestData .=             '<PaxRooms>';
                foreach ($paxRooms as $key => $paxRoom) {
                    if ($paxRoom["hotel_noofchildren"] != 0) {
                        $childAgesArr = explode(",", $paxRoom['hotel_childrenAges']);
                        $requestData .= '   <PaxRoom Adults="'.$paxRoom["hotel_noofadult"].'" Cots="'.$paxRoom["hotel_noofinfant"].'" RoomIndex="'.$key.'" >';

                            $requestData .= '<ChildAges>';
                                for ($i=0; $i<$paxRoom["hotel_noofchildren"]; $i++) {
                                    $requestData .= '<Age>'.$childAgesArr[$i].'</Age>';
                                }
                            $requestData .= '</ChildAges>';
                        $requestData .= '</PaxRoom>';
                    }
                    else {
                        $requestData .= '   <PaxRoom Adults="'.$paxRoom["hotel_noofadult"].'" Cots="'.$paxRoom["hotel_noofinfant"].'" RoomIndex="'.$key.'" />';
                    }
                }
                $requestData .=             '</PaxRooms>';
                if($rating != "" || $rating != "0")
                    $requestData .= '<StarRatingRange><Min>'.$rating.'</Min><Max>'.$rating.'</Max></StarRatingRange>';
                $requestData .= '       </SearchHotelPricePaxRequest>';
                $requestData .= '   </RequestDetails>';
                $requestData .= '</Request>';
                $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
                curl_setopt($ch, CURLOPT_ENCODING , "gzip");
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

                $output = curl_exec($ch);
                $info = curl_getinfo($ch);

                curl_close($ch);
                //end of process API

                $parseResult = simplexml_load_string($output);
                $array_final_result = json_decode(json_encode($parseResult), true);

                if(isset($array_final_result["ResponseDetails"]) && isset($array_final_result["ResponseDetails"]["SearchHotelPricePaxResponse"]["HotelDetails"]["Hotel"])) {

                    $data["hotel_search_array"] = $array_final_result["ResponseDetails"]["SearchHotelPricePaxResponse"]["HotelDetails"]["Hotel"];

                    $total_all_item = count($data['hotel_search_array']);
                } else {
                    $data['hotel_search_array'] = false;
                    $total_all_item = 0;
                    $data['nodata'] = 1;
                }

                $data["destination"]        = $destinationCode;
                $data["hotel_checkin"]      = $hotel_checkin;
                $data["hotel_checkout"]     = $hotel_checkout;
                $data["no_of_rooms"]        = $number_of_room;
                $data["paxRoomSelection"]   = $paxRooms;
                $data["durations"]          = $days;
                $data["search_full_text"]   = $hotelDestination;
                $data["hotel_destination"]  = $hotelDestination;
                $data["country_name"]       = $countryName;
                $data["country_code"]       = $countryCode;

                $data['total_rows'] = $total_all_item;
                //$config['total_rows'];
                /*$config['base_url'] = base_url().'search/hotel_api/';
                $config['uri_segment'] = 4;
                $config['use_page_numbers'] = TRUE;
                $config['total_rows'] = $total_all_item;

                $config['per_page'] = 25;
                $config['first_link'] = false;
                $config['last_link'] = false;
                $config['attributes'] = array('class' => 'search-paginate');
                $config['cur_tag_open'] = '<span class="current"><b>';
                $config['cur_tag_close'] = '</b></span>';
                $config['num_tag_open'] = '<span>';
                $config['num_tag_close'] = '</span>';*/
                /*$config['first_tag_open'] = '<span class="firstpage">';
                $config['first_tag_close'] = '</span>';
                $config['last_tag_open'] = '<span class="lastpage">';
                $config['last_tag_close'] = '</span>';
                */
                /*$config['prev_tag_open'] = '<span>';
                $config['prev_tag_close'] = '</span>';
                $config['next_tag_open'] = '<span>';
                $config['next_tag_close'] = '</span>';
                $config['first_link'] = 'First Page';
                $config['last_link'] = 'Last Page';

                $this->pagination->initialize($config);*/
            } else {
                $data['nodata'] = 1;
            }
        }  else {
            $data['nodata'] = 1;
        }


        echo $this->load->view('search_hotel_api', $data, true);
    }

    public function hotel_result()
    {
        //header("Content-type: text/xml");
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        /*$timestart = microtime(true);*/
        if( $this->input->post("hotel_checkin") >= $this->input->post("hotel_checkout") ) {
            //session and redirect
            $this->session->set_flashdata(
                'error_date',
                '<span>Check-in date must be earlier than Check-out date</span>'
            );
            redirect("/");
            //end of session and redirect
        }
        else {

            //input hotel
            $hotel_checkin    = $this->input->post("hotel_checkin");
            $hotel_checkout   = $this->input->post("hotel_checkout");
            $destinationType  = "city";
            $hotelDestination = $this->input->post("hotel_destination");
            $matches = array();
            //$hotelDestination="(Man) ((MANILA) sport) (text3) 1322 (text4)";
            $num_matched = preg_match_all('/\((.*)\)/U', $hotelDestination, $match);
            //preg_match('#\((.*?)\)#', $hotelDestination, $match);
            $regex = "/.*\(([^)]*)\)/";
            preg_match($regex,$hotelDestination,$match);
            $destinationCode  = $match[1];
            $explodeHotelDestination = explode("-", ($hotelDestination));
            end($explodeHotelDestination);
            $last_id=key($explodeHotelDestination);
            $countryName = trim($explodeHotelDestination[$last_id]);
            /*str_replace(" ", " ", $explodeHotelDestination[1]);*/

            $countryCode = $this->All->getCountryCode($countryName);
            $days = floor(strtotime($hotel_checkout)/(60*60*24)) - floor(strtotime($hotel_checkin)/(60*60*24));
            $days = abs($days);
            $number_of_room     = $this->input->post("hotel_noofroom");
            $totalPaxQty = 0;
            for ($i=1; $i<=$number_of_room; $i++) {
                $paxRooms[$i]['hotel_noofadult']    = $this->input->post("hotel_noofadult_".$i);
                $paxRooms[$i]['hotel_noofchildren'] = $this->input->post("hotel_noofchildren_".$i);
                $paxRooms[$i]['hotel_childrenAges'] = $this->input->post('childAges_'.$i);
                $paxRooms[$i]['hotel_noofinfant']   = $this->input->post("hotel_noofinfant_".$i);

                $totalPaxQty += ($paxRooms[$i]['hotel_noofadult'] + $paxRooms[$i]['hotel_noofchildren'] + $paxRooms[$i]['hotel_noofinfant']);
            }

            if($totalPaxQty > 9) {
                //session and redirect
                $this->session->set_flashdata(
                    'error_pax',
                    '<span>Max 9pax in 1 check-in session</span>'
                );
                redirect("/");
            }
            $country_name = $this->All->get_country_hotel_bycitycode($destinationCode);

            /*$this->db->select('item_code');
            $this->db->where('city_code', $destinationCode);
            $this->db->limit(100);
            $qry = $this->db->get('tb_hotel_gta_item');

            $itemCodeList = '';
            $withItem = false;
            if ($qry->num_rows()) {
                $withItem = true;
                foreach ($qry->result() as $data_item_city) {
                    $itemCodeList .= '<ItemCode>'.$data_item_city->item_code.'</ItemCode>';
                }
            }
            //end of input hotel
            //process API
            $requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
            $requestData .= '<Request>';
            $requestData .=     '<Source>';
            $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
            $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD" Country="'.$countryCode.'">';
            $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
            $requestData .=         '</RequestorPreferences>';
            $requestData .= '   </Source>';
            $requestData .= '   <RequestDetails>';
            $requestData .= '       <SearchHotelPricePaxRequest>';
            $requestData .=             '<ItemDestination DestinationType="city" DestinationCode="'.$destinationCode.'"/>';

            $requestData .=             '<ImmediateConfirmationOnly/>';
            if ($withItem) {
                $requestData .= '<ItemCodes>';
                $requestData .= $itemCodeList;
                $requestData .= '</ItemCodes>';
            }
            $requestData .=             '<PeriodOfStay>';
            $requestData .=             '   <CheckInDate>'.$hotel_checkin.'</CheckInDate>';
            $requestData .=             '   <Duration><![CDATA['.$days.']]></Duration>';
            $requestData .=             '</PeriodOfStay>';
            $requestData .=             '<IncludePriceBreakdown/>';
            $requestData .=             '<IncludeChargeConditions/>';
            $requestData .=             '<PaxRooms>';
            foreach ($paxRooms as $key => $paxRoom) {
                if ($paxRoom["hotel_noofchildren"] != 0) {
                    $requestData .= '   <PaxRoom Adults="'.$paxRoom["hotel_noofadult"].'" Cots="'.$paxRoom["hotel_noofinfant"].'" RoomIndex="'.$key.'" >';

                        $requestData .= '<ChildAges>';
                            for ($i=0; $i<$paxRoom["hotel_noofchildren"]; $i++) {
                                $requestData .= '<Age>8</Age>';
                            }
                        $requestData .= '</ChildAges>';
                    $requestData .= '</PaxRoom>';
                }
                else {
                    $requestData .= '   <PaxRoom Adults="'.$paxRoom["hotel_noofadult"].'" Cots="'.$paxRoom["hotel_noofinfant"].'" RoomIndex="'.$key.'" />';
                }
            }
            $requestData .=             '</PaxRooms>';
            $requestData .= '       </SearchHotelPricePaxRequest>';
            $requestData .= '   </RequestDetails>';
            $requestData .= '</Request>';
            $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
            $output = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);
            //end of process API
            $parseResult = simplexml_load_string($output);
            $array_final_result = json_decode(json_encode($parseResult), true);

            $timeend = microtime(true);

            $city = $this->All->select_template("city_code", $destinationCode, "tb_hotel_gta_item");
            $data['city_name'] = $city->item_content;

            $data["hotel_search_array"] = $array_final_result["ResponseDetails"]["SearchHotelPricePaxResponse"]["HotelDetails"]["Hotel"];*/
            $data["hotel_checkin"]      = $hotel_checkin;
            $data["hotel_checkout"]     = $hotel_checkout;
            $data["destination"]        = $destinationCode;
            $data["no_of_rooms"]        = $number_of_room;
            $data["paxRoomSelection"]   = $paxRooms;
            $data["durations"]          = $days;
            $data["search_full_text"]   = $hotelDestination;
            $data["hotel_destination"]  = $hotelDestination;
            $data["country_name"]       = $countryName;
            $data["country_code"]       = $countryCode;
            // // // echo '<pre>';
            // // // print_r($data);

            $city = $this->All->select_template("city_code", $destinationCode, "tb_countrycity");
            $data["city_name"]       = $city[0]->city_name;

            $this->db->select('item_code');
            $this->db->where('city_code', $destinationCode);
            $qry = $this->db->get('hotel_gta_item');

            $this->load->view('search_hotel_index', $data);
        }
    }

    public function xml_document()
    {
        $destinationCode = "JKT";
        $itemCode        = "ARC";
        $this->load->helper('xml');
        $this->output->set_content_type('text/xml');
        $requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
            $requestData .= '<Source>';
                $requestData .= '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                $requestData .= '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
                    $requestData .= '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                $requestData .= '</RequestorPreferences>';
            $requestData .= '</Source>';
            $requestData .= '<RequestDetails>';
                $requestData .= '<SearchItemInformationRequest ItemType="hotel">';
                    $requestData .= '<ItemDestination DestinationType="city" DestinationCode="'.$destinationCode.'"/>';
                    $requestData .= '<ItemCode>"'.$itemCode.'"</ItemCode>';
                $requestData .= '</SearchItemInformationRequest>';
            $requestData .= '</RequestDetails>';
        $requestData .= '</Request>';
        $this->output->set_output($requestData);
    }

    public function test_parsing()
    {
        $destinationCode = "1BAD";
        $itemCode        = "COM";
        $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
        $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
        $requestData .=         '</RequestorPreferences>';
        $requestData .=     '</Source>';
        $requestData .=     '<RequestDetails>';
        $requestData .=         '<SearchItemInformationRequest ItemType="hotel">';
        $requestData .=             '<ItemDestination DestinationType="city" DestinationCode="'.$destinationCode.'"/>';
        $requestData .=             '<ItemCode>'.$itemCode.'</ItemCode>';
        $requestData .=         '</SearchItemInformationRequest>';
        $requestData .=     '</RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        //$array_output = $this->All->XMLtoArray($output);
        $parseResult = simplexml_load_string($output, "SimpleXMLElement", LIBXML_NOCDATA);
        $array_output = json_decode(json_encode($parseResult), true);
        echo "<pre>";
        print_r($array_output);
        echo "</pre>";
    }

    public function test_parsing2()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $clientID    = '62';
        $email       = 'XML.PIXELY@CTC.COM';
        $password    = 'PASS';
        $language    = 'en';
        $requestMode = 'SYNCHRONOUS';
        $destinationType = 'city';
        $destinationCode = 'BKK';
        $checkinDate     = '2016-03-23';
        $duration        = '2';
        $roomCode        = 'SB';
        $numberOfRooms   = '1';
        $requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
            $requestData .= '<Source>';
                $requestData .= '<RequestorID Client="'.$clientID.'" EMailAddress="'.$email.'" Password="'.$password.'"/>';
                $requestData .= '<RequestorPreferences Language="'.$language.'">';
                    $requestData .= '<RequestMode>'.$requestMode.'</RequestMode>';
                $requestData .= '</RequestorPreferences>';
            $requestData .= '</Source>';
            $requestData .= '<RequestDetails>';
                $requestData .= '<SearchHotelPriceRequest>';
                    $requestData .= '<ItemDestination DestinationType="'.$destinationType.'" DestinationCode="'.$destinationCode.'"/>';
                    $requestData .= '<PeriodOfStay>';
                        $requestData .= '<CheckInDate>'.$checkinDate.'</CheckInDate>';
                        $requestData .= '<Duration>'.$duration.'</Duration>';
                    $requestData .= '</PeriodOfStay>';
                    $requestData .= '<Rooms>';
                        $requestData .= '<Room Code="'.$roomCode.'" NumberOfRooms="'.$numberOfRooms.'"/>';
                    $requestData .= '</Rooms>';
                $requestData .= '</SearchHotelPriceRequest>';
            $requestData .= '</RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info   = curl_getinfo($ch);
        curl_close($ch);
        $array_output = $this->All->XMLtoArray($output);
        echo "<pre>";
        print_r($array_output);
        echo "</pre>";
    }

    public function test_parsing3()
    {
        $destinationCode = "SIN";
        $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD">';
        $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
        $requestData .=         '</RequestorPreferences>';
        $requestData .=     '</Source>';
        $requestData .=     '<RequestDetails>';
        $requestData .=         '<SearchHotelPricePaxRequest>';
        $requestData .=             '<ItemDestination DestinationType="city" DestinationCode="'.$destinationCode.'"/>';
        $requestData .=             '<PeriodOfStay>';
        $requestData .=             '   <CheckInDate>2016-04-08</CheckInDate>';
        $requestData .=             '   <Duration>1</Duration>';
        $requestData .=             '</PeriodOfStay>';
        $requestData .=             '<IncludePriceBreakdown/>';
        $requestData .=             '<IncludeChargeConditions/>';
        $requestData .=             '<PaxRooms>';
        $requestData .=             '   <PaxRoom Adults="2" Cots="0" RoomIndex="1" />';
        $requestData .=             '</PaxRooms>';
        $requestData .=         '</SearchHotelPricePaxRequest>';
        $requestData .=     '</RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $array_output = $this->All->XMLtoArray($output);
        echo "<pre>";
        print_r($array_output);
        echo "</pre>";
    }

    public function insert_addNewBooking()
    {
        $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD">';
        $requestData .=             '<RequestMode>ASYNCHRONOUS</RequestMode>';
        $requestData .=             '<ResponseURL>/ProcessResponse/GetXML</ResponseURL>';
        $requestData .=         '</RequestorPreferences>';
        $requestData .=     '</Source>';
        $requestData .=     '<RequestDetails>';
        $requestData .=         '<AddBookingRequest Currency="SGD">';
        $requestData .=             '<BookingName>FF01234</BookingName>';
        $requestData .=             '<BookingReference>FF01234AA</BookingReference>';
        $requestData .=             '<BookingDepartureDate>2016-04-08</BookingDepartureDate>';
        $requestData .=             '<PaxNames>';
        $requestData .=             '   <PaxName PaxId="1"><![CDATA[Mr Fandy Fandry ]]></PaxName>';
        $requestData .=             '   <PaxName PaxId="2"><![CDATA[Mrs Steffi Tan ]]></PaxName>';
        $requestData .=             '</PaxNames>';
        $requestData .=             '<BookingItems>';
        $requestData .=             '   <BookingItem ItemType="hotel" ExpectedPrice ="244.50">';
        $requestData .=             '       <ItemReference>1</ItemReference>';
        $requestData .=             '       <ItemCity Code="SIN" />';
        $requestData .=             '       <Item Code="DUX" />';
        $requestData .=             '       <HotelItem>';
        $requestData .=             '           <PeriodOfStay>';
        $requestData .=             '               <CheckInDate>2016-04-08</CheckInDate>';
        $requestData .=             '               <CheckOutDate>2016-04-09</CheckOutDate>';
        $requestData .=             '           </PeriodOfStay>';
        $requestData .=             '           <HotelPaxRoom Adults="2" Id="001:DUX">';
        $requestData .=             '               <PaxIds>';
        $requestData .=             '                   <PaxId>1</PaxId>';
        $requestData .=             '                   <PaxId>2</PaxId>';
        $requestData .=             '               </PaxIds>';
        $requestData .=             '           </HotelPaxRoom>';
        $requestData .=             '       </HotelItem>';
        $requestData .=             '   </BookingItem>';
        $requestData .=             '</BookingItems>';
        $requestData .=         '</AddBookingRequest>';
        $requestData .=     '</RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $array_output = $this->All->XMLtoArray($output);
        echo "<pre>";
        print_r($array_output);
        echo "</pre>";
    }

    public function get_search_item_info()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $destinationCode = "JKT";
        $itemCode        = "ARC";
        //XML request
        $requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
            $requestData .= '<Source>';
                $requestData .= '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                $requestData .= '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
                    $requestData .= '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                $requestData .= '</RequestorPreferences>';
            $requestData .= '</Source>';
            $requestData .= '<RequestDetails>';
                $requestData .= '<SearchItemInformationRequest ItemType="hotel">';
                    $requestData .= '<ItemDestination DestinationType="city" DestinationCode="'.$destinationCode.'"/>';
                    $requestData .= '<ItemCode>"'.$itemCode.'"</ItemCode>';
                $requestData .= '</SearchItemInformationRequest>';
            $requestData .= '</RequestDetails>';
        $requestData .= '</Request>';
        //End of XML request
        /*--Execute Search Transaction--*/
        $requestURL = 'https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet';
        $XMLTransactionHander = new XMLTransactionHander;
        $responseDoc = $XMLTransactionHander->executeRequest( $requestURL, $requestData );
        $array_final_result = array();
        // Process Response XML Data
        if( $responseDoc != NULL ) {
            $responseElement = $responseDoc->documentElement;
            $xpath = new DOMXPath( $responseDoc );
            $errorsElements = $xpath->query( 'ResponseDetails/SearchItemInformationResponse/Errors', $responseElement );
            if( $errorsElements->length > 0 ) {
                echo '<p>Invalid Search Request</p>';
            }
            else {
                $x = 0;
                $searchItemsReponseElements = $xpath->query( 'ResponseDetails/SearchItemInformationResponse', $responseElement );
                foreach( $searchItemsReponseElements as $searchItemsReponseElement ) {
                    $itemElements = $xpath->query( 'ItemDetails/LocationDetails', $searchItemsReponseElement );
                    foreach( $itemElements AS $itemElement ) {
                        $itemDetails = $xpath->query( 'ItemDetail', $itemElement );
                    }
                    /*
                    foreach( $itemElements AS $itemElement ) {
                        foreach( $countryElement->attributes AS $attribute ) {
                            $array_final_result[$x]["attributes"][$attribute->name] = $attribute->value;
                        }
                        $array_final_result[$x]["Name"] = $countryElement->textContent;
                        $x++;
                    }
                    */
                }
                echo "<pre>";
                print_r($itemElements);
                echo "</pre>";
            }
        }
        else {
            echo '<p>Invalid Search Request: '.$XMLTransactionHander->errno.'</p>';
        }
        /*--End of Execute Search Transaction--*/
    }

    public function filter_hotel_by()
    {
        $data_hotel = json_decode($_POST['data_hotel_form']);
        if(isset($_POST['hotelfacilities'])) $hotelfacilities = $_POST['hotelfacilities'];
        else $hotelfacilities = '';
        if(isset($_POST['roomfacilities'])) $roomfacilities = $_POST['roomfacilities'];
        else $roomfacilities = '';

        $results = $this->All->checkHotelAttributes($data_hotel, $hotelfacilities, $roomfacilities);
        if($results != '') {
            $count_result = count($results);
            $result = '';
            if($count_result >0) {
                for($n=0; $n<$count_result; $n++) {
                    $result .= $results[$n][0].'--'.$results[$n][1].'###';
                }
                $result = substr($result, 0, -3);
            }
        }
        else $result = 'FALSE';
        echo $result;
    }

    public function get_search_popup()
    {
        $countRoom = $_POST['countRoom'];
        $data['countRoom'] = $countRoom;
        $this->load->view('master-frontend/popup-pax', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */