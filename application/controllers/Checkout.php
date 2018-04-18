<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends My_Controller {

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

        if (
            !$this->session->userdata('shoppingCartCruiseCookie') &&
            !$this->session->userdata('shoppingCartCookie') &&
            !$this->session->userdata('shoppingCartFlightCookie') &&
            !$this->session->userdata('shoppingCartLandtourCookie') &&
            !$this->session->userdata('normal_session_id')
        ) {
                redirect(base_url().'cart/emptyCart');
                die();
        }
    }

    public function checkPrice($isAjax = "")
    {
        if($isAjax == 'check') {
            $isAjax = true;
        }
        else {
            $isAjax = false;
        }

        $updateFlight     = false;
        $updateSomething  = false;
        $file_datas = require_once($this->instanceurl.'webservices/abacus/SWSWebservices.class.php');
        if( $this->session->userdata('normal_session_id') == TRUE )
        {
            $cart_hotels = $this->All->select_template(
                "user_access_id", $this->session->userdata('normal_session_id'), "hotel_cart"
            );
            $flights_cart = $this->All->select_template(
                "user_access_id", $this->session->userdata('normal_session_id'), "flight_cart"
            );
            if( $flights_cart == TRUE )
            {
                $x = 0;
                foreach ( $flights_cart AS $flight_cart ) {
                    if($flight_cart->departureDateFrom < date("Y-m-d")) {
                        redirect(base_url().'cart/emptyCart');
                        die();
                    }
                    $totalfinalprice = 0;
                    $transitarray = explode("~", $flight_cart->departureFlightName);
                    $istransit = count($transitarray) > 1 ? true : false;
                    if ($istransit)
                    {
                        //if( strpos($arrayCart[$x]["departureFlightName"], '~') !== FALSE ) {
                        $arrTotalAdult = $flight_cart->noofAdult;
                        $arrTotalChild = $flight_cart->noofChild;
                        $arrTotalInfant = $flight_cart->noofInfant;
                        $numberInParty = $arrTotalAdult + $arrTotalChild;

                        if ($flight_cart->arrivalFlightCode == "")
                        {
                            /* direct flight */
                            $explodeCount = count(explode("~", $flight_cart->departureFlightName));
                            if ($explodeCount)
                            {
                                $arrTotalPrice = $flight_cart->departureTotalPrice;
                                $arrFlightClass = $flight_cart->departureFlightResBookDesigCode;
                                $arrMarriageGroup = $flight_cart->departureFlightMarriageGrp;
                                $totalPrice = $flight_cart->departureTotalPrice;

                                $useArrivalPrice = false;
                                if ($totalPrice == "" || $totalPrice == 0)
                                {
                                    /* departure price empty, maybe it inserted to arrival price. just check */
                                    $useArrivalPrice = true;
                                    $totalPrice = $flight_cart->arrivalTotalPrice;
                                }

                                $result = checkAirAvailabilityPriceTransit(
                                    $flight_cart->departureFlightCode,
                                    $flight_cart->departureDateFrom,
                                    $flight_cart->departureTimeFrom,
                                    $flight_cart->departureDateTo,
                                    $flight_cart->departureTimeTo,
                                    $numberInParty, $arrFlightClass,
                                    $flight_cart->departureCityCodeTo,
                                    $flight_cart->departureCityCodeFrom,
                                    $flight_cart->departureFlightMarriageGrp,
                                    $arrTotalAdult, $arrTotalChild, $arrTotalInfant
                                    );

                                $parseResult = simplexml_load_string($result);
                                $arrayFinal  = json_decode(json_encode($parseResult), true);
                                //$arrayFinal  = $arrayFinal["OriginDestinationOptions"]['OriginDestinationOption'];
                                $countArrayFinal = count($arrayFinal);

                                if ($arrayFinal && $arrayFinal['ApplicationResults']['@attributes']['status'] == 'Complete')
                                {
                                    //$finalprice = ceil($arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['@attributes']['TotalAmount']);
                                    //$adminfee = ceil((($finalprice)*FLIGHT_ADMIN_PERCENT)/100);
                                    //$totalfinalprice = $finalprice + $adminfee;

                                    $passenger_breakdown = $arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['AirItineraryPricingInfo'];

                                //if ($totalPrice != $totalfinalprice) {
                                    /* update price */
                                    $adultFare = 0; $adultTaxFare = 0; $childFare = 0;
                                    $childTaxFare = 0; $infantFare = 0; $infantTaxFare = 0;

                                    if($useArrivalPrice) {
                                         if(array_key_exists('0', $passenger_breakdown)) {

                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];
                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $adultFare = $baseFare;
                                                    $adultTaxFare = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $childFare = $baseFare;
                                                    $childTaxFare = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $infantFare = $baseFare;
                                                    $infantTaxFare = $taxFare;
                                                }

                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];

                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $adultFare = $baseFare;
                                                $adultTaxFare = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $childFare = $baseFare;
                                                $childTaxFare = $taxFare;
                                            } else if($passType == 'INF') {
                                                $infantFare = $baseFare;
                                                $infantTaxFare = $taxFare;
                                            }
                                        }

                                        $data_Arr = array(
                                            'arrivalTotalPrice' => $totalfinalprice,
                                            'TotalPriceAdminFare' => $adminfee,
                                            'arrivalPriceAdultBaseFare' => $adultFare,
                                            'arrivalPriceAdultTaxFare' => $adultTaxFare,
                                            'arrivalPriceChildBaseFare' => $childFare,
                                            'arrivalPriceChildTaxFare' => $childTaxFare,
                                            'arrivalPriceInfantBaseFare' => $infantFare,
                                            'arrivalPriceInfantTaxFare' => $infantTaxFare
                                        );
                                    } else {
                                        if(array_key_exists('0', $passenger_breakdown)) {
                                            $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                            $infantFare = 0; $infantTaxFare = 0;
                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];

                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $adultFare = $baseFare;
                                                    $adultTaxFare = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $childFare = $baseFare;
                                                    $childTaxFare = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $infantFare = $baseFare;
                                                    $infantTaxFare = $taxFare;
                                                }
                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];

                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $adultFare = $baseFare;
                                                $adultTaxFare = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $childFare = $baseFare;
                                                $childTaxFare = $taxFare;
                                            } else if($passType == 'INF') {
                                                $infantFare = $baseFare;
                                                $infantTaxFare = $taxFare;
                                            }
                                        }

                                        $data_Arr = array(
                                            'departureTotalPrice' => $totalfinalprice,
                                            'TotalPriceAdminFare' => $adminfee,
                                            'departurePriceAdultBaseFare' => $adultFare,
                                            'departurePriceAdultTaxFare' => $adultTaxFare,
                                            'departurePriceChildBaseFare' => $childFare,
                                            'departurePriceChildTaxFare' => $childTaxFare,
                                            'departurePriceInfantBaseFare' => $infantFare,
                                            'departurePriceInfantTaxFare' => $infantTaxFare
                                        );
                                    }

                                    if($totalPrice != $totalfinalprice) {
                                        if ($useArrivalPrice) {
                                        } else {

                                        }
                                        $this->All->update_template($data_Arr, 'id', $flight_cart->id, 'flight_cart');

                                        $updatedFlightCode[] = $flight_cart->departureFlightCode;
                                        $updateSomething = true;
                                        $updateFlight = true;
                                    }
                                    //}
                                } else {
                                    /* not available */
                                }
                            }
                        } else {
                            /* return flight */
                            $totalPrice = $flight_cart->departureTotalPrice;
                            $useArrivalPrice = false;
                            if($totalPrice == "" || $totalPrice == 0) {
                                /* departure price empty, maybe it inserted to arrival price. just check */
                                $useArrivalPrice = true;
                                $totalPrice = $flight_cart->arrivalTotalPrice;
                            }

                            $result = checkAirAvailabilityPriceTransit(
                                    $flight_cart->departureFlightCode,
                                    $flight_cart->departureDateFrom,
                                    $flight_cart->departureTimeFrom,
                                    $flight_cart->departureDateTo,
                                    $flight_cart->departureTimeTo,
                                    $numberInParty,
                                    $flight_cart->departureFlightResBookDesigCode,
                                    $flight_cart->departureCityCodeTo,
                                    $flight_cart->departureCityCodeFrom,
                                    $flight_cart->departureFlightMarriageGrp,
                                    $arrTotalAdult, $arrTotalChild, $arrTotalInfant,
                                    $flight_cart->arrivalFlightCode,
                                    $flight_cart->arrivalDateFrom,
                                    $flight_cart->arrivalTimeFrom,
                                    $flight_cart->arrivalCityCodeFrom,
                                    $flight_cart->arrivalCityCodeTo,
                                    $flight_cart->arrivalFlightResBookDesigCode,
                                    $flight_cart->arrivalFlightAirEquipType,
                                    $flight_cart->arrivalFlightMarriageGrp
                                    );

                            $parseResult = simplexml_load_string($result);
                            $arrayFinal  = json_decode(json_encode($parseResult), true);
                            //$arrayFinal  = $arrayFinal["OriginDestinationOptions"]['OriginDestinationOption'];
                            $countArrayFinal = count($arrayFinal);

                            if ($arrayFinal && $arrayFinal['ApplicationResults']['@attributes']['status'] == 'Complete') {
                                $finalprice = ceil($arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['@attributes']['TotalAmount']);
                                $adminfee = ceil((($finalprice)*FLIGHT_ADMIN_PERCENT)/100);
                                //$totalfinalprice = $finalprice + $adminfee;

                                $passenger_breakdown = $arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['AirItineraryPricingInfo'];

                                // if ($totalPrice != $totalfinalprice) {
                                    $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                    $infantFare = 0; $infantTaxFare = 0;
                                    /* update price */
                                    if($useArrivalPrice) {
                                        if(array_key_exists('0', $passenger_breakdown)) {

                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];
                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $adultFare = $baseFare;
                                                    $adultTaxFare = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $childFare = $baseFare;
                                                    $childTaxFare = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $infantFare = $baseFare;
                                                    $infantTaxFare = $taxFare;
                                                }
                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];

                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $adultFare = $baseFare;
                                                $adultTaxFare = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $childFare = $baseFare;
                                                $childTaxFare = $taxFare;
                                            } else if($passType == 'INF') {
                                                $infantFare = $baseFare;
                                                $infantTaxFare = $taxFare;
                                            }
                                        }

                                        $data_Arr = array(
                                            'arrivalTotalPrice' => $totalfinalprice,
                                            'TotalPriceAdminFare' => $adminfee,
                                            'arrivalPriceAdultBaseFare' => $adultFare,
                                            'arrivalPriceAdultTaxFare' => $adultTaxFare,
                                            'arrivalPriceChildBaseFare' => $childFare,
                                            'arrivalPriceChildTaxFare' => $childTaxFare,
                                            'arrivalPriceInfantBaseFare' => $infantFare,
                                            'arrivalPriceInfantTaxFare' => $infantTaxFare
                                        );
                                    } else {
                                        if(array_key_exists('0', $passenger_breakdown)) {
                                            $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                            $infantFare = 0; $infantTaxFare = 0;
                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];

                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $adultFare = $baseFare;
                                                    $adultTaxFare = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $childFare = $baseFare;
                                                    $childTaxFare = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $infantFare = $baseFare;
                                                    $infantTaxFare = $taxFare;
                                                }
                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];

                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $adultFare = $baseFare;
                                                $adultTaxFare = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $childFare = $baseFare;
                                                $childTaxFare = $taxFare;
                                            } else if($passType == 'INF') {
                                                $infantFare = $baseFare;
                                                $infantTaxFare = $taxFare;
                                            }
                                        }

                                        $data_Arr = array(
                                            'departureTotalPrice' => $totalfinalprice,
                                            'TotalPriceAdminFare' => $adminfee,
                                            'departurePriceAdultBaseFare' => $adultFare,
                                            'departurePriceAdultTaxFare' => $adultTaxFare,
                                            'departurePriceChildBaseFare' => $childFare,
                                            'departurePriceChildTaxFare' => $childTaxFare,
                                            'departurePriceInfantBaseFare' => $infantFare,
                                            'departurePriceInfantTaxFare' => $infantTaxFare
                                        );
                                    }

                                    if ($totalPrice != $totalfinalprice) {
                                        if ($useArrivalPrice) {
                                        } else {

                                        }
                                        $this->All->update_template($data_Arr, 'id', $flight_cart->id, 'flight_cart');

                                        $updatedFlightCode[] = $arrayCart[$x]["departureFlightCode"];
                                        $updateSomething = true;
                                        $updateFlight = true;
                                    }
                                //}
                            } else {
                                /* N/A */
                            }
                        }

                    } else if( $istransit !== TRUE ) {
                        /* single flight */
                        if ($flight_cart->arrivalFlightCode == "") {
                            /* direct flight */

                            $flightCodeNumArray = explode(" ", $flight_cart->departureFlightCode);
                            /* check availability */
                            $flightCode = $flightCodeNumArray[0];
                            $flightNumber = $flightCodeNumArray[1];
                            $departureDate = $flight_cart->departureDateFrom;
                            $departureTime = date("H:i", strtotime($flight_cart->departureTimeFrom));
                            $arrivalDate = $flight_cart->departureDateTo;
                            $arrivalTime = date("H:i", strtotime($flight_cart->departureTimeTo));
                            $totalAdult = $flight_cart->noofAdult;
                            $totalChild = $flight_cart->noofChild;
                            $totalInfant = $flight_cart->noofInfant;
                            $numberInParty = $totalAdult + $totalChild; //infant not use seat
                            $ResBookDesigCode = $flight_cart->departureFlightResBookDesigCode;
                            $destinationCode = $flight_cart->departureCityCodeTo;
                            $originCode = $flight_cart->departureCityCodeFrom;
                            $totalPrice = $flight_cart->departureTotalPrice;

                            $useArrivalPrice = false;
                            if ($totalPrice == "" || $totalPrice == 0)
                            {
                                /* departure price empty, maybe it inserted to arrival price. just check */
                                $useArrivalPrice = true;
                                $totalPrice = $flight_cart->arrivalTotalPrice;
                            }

                            if($totalPrice == "" || $totalPrice == 0) {
                                /* departure price empty, maybe it inserted to arrival price. just check */
                                $totalPrice = $flight_cart->arrivalTotalPrice;
                            }
                            $marriageGroup = $flight_cart->departureFlightMarriageGrp;

                            $result = checkAirAvailability($flightCode, $flightNumber, $departureDate, $departureTime, $numberInParty, $ResBookDesigCode, $destinationCode, $originCode);

                            $parseResult = simplexml_load_string($result);
                            $arrayFinal  = json_decode(json_encode($parseResult), true);
                            $arrayFinal  = $arrayFinal["OriginDestinationOptions"]['OriginDestinationOption'];
                            $countArrayFinal = count($arrayFinal);

                            for($i = 0; $i < $countArrayFinal; $i++) {
                                if(array_key_exists($i, $arrayFinal)) {
                                    //$flightNumber = $arrayFinal['FlightSegment']['@attributes']['FlightNumber'];
                                    $availFlightCode = $arrayFinal[$i]['FlightSegment']['MarketingAirline']['@attributes']['Code'];
                                    $availFlightNumber = $arrayFinal[$i]['FlightSegment']['MarketingAirline']['@attributes']['FlightNumber'];
                                    if($availFlightCode == $flightCode && $availFlightNumber == $flightNumber) {
                                        $availableSeat = $arrayFinal[$i]['FlightSegment']['BookingClassAvail']['@attributes']['Availability'];
                                        $totalTravelTime = $arrayFinal[$i]['FlightSegment']['FlightDetails']['@attributes']['TotalTravelTime'];
                                        $meal = $arrayFinal[$i]['FlightSegment']['Meal']['@attributes']['MealCode'];
                                        break; // no need to check further
                                    }
                                } else if (array_key_exists('@attributes', $arrayFinal)) {
                                    $availFlightCode = $arrayFinal['FlightSegment']['MarketingAirline']['@attributes']['Code'];
                                    $availFlightNumber = $arrayFinal['FlightSegment']['MarketingAirline']['@attributes']['FlightNumber'];
                                    if($availFlightCode == $flightCode && $availFlightNumber == $flightNumber) {
                                        $availableSeat = $arrayFinal['FlightSegment']['BookingClassAvail']['@attributes']['Availability'];
                                        $totalTravelTime = $arrayFinal['FlightSegment']['FlightDetails']['@attributes']['TotalTravelTime'];
                                        $meal = $arrayFinal['FlightSegment']['Meal']['@attributes']['MealCode'];
                                        break; // no need to check further
                                    }
                                }
                            }

                            if($availableSeat < $numberInParty) {
                                /* session expired, maybe? */
                                $this->session->set_flashdata(
                                    'empty_cart',
                                    '<div style="background-color:#eff0f1; color:red; margin-bottom:5px">
                                        <div style="float:left; padding:10px">
                                            <img src="'.base_url().'/assets/info.png" width="30" height="30">
                                        </div>
                                        <div style="color: red; float:left; padding:0px; font-size:14px; margin-top:15px">
                                            There is no available seats for your flight
                                        </div>
                                    </div>'
                                );

                                if($isAjax) {
                                    echo json_encode(array('error'=>true,'message'=>'There is no available seats for your flight'));
                                    exit();
                                } else {
                                    redirect(base_url().'cart/emptyCart');
                                    die();
                                }
                            }

                            $result = checkAirAvailabilityPrice($flightCode, $flightNumber, $departureDate, $departureTime, $arrivalDate, $arrivalTime, $numberInParty, $ResBookDesigCode, $destinationCode, $originCode, $marriageGroup, $totalAdult, $totalChild, $totalInfant);

                            $parseResult = simplexml_load_string($result);
                            $arrayFinal  = json_decode(json_encode($parseResult), true);
                            //$arrayFinal  = $arrayFinal["OriginDestinationOptions"]['OriginDestinationOption'];
                            $countArrayFinal = count($arrayFinal);

                            if ($arrayFinal && $arrayFinal['ApplicationResults']['@attributes']['status'] == 'Complete') {
                                $finalprice = ceil($arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['@attributes']['TotalAmount']);
                                $adminfee = ceil((($finalprice)*FLIGHT_ADMIN_PERCENT)/100);
                                //$totalfinalprice = $finalprice + $adminfee;

                                $passenger_breakdown = $arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['AirItineraryPricingInfo'];

                                //if ($totalPrice != $totalfinalprice) {
                                    /* update price */
                                    $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                            $infantFare = 0; $infantTaxFare = 0;
                                    if($useArrivalPrice) {
                                         if(array_key_exists('0', $passenger_breakdown)) {

                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];
                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];
                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $adultFare = $baseFare;
                                                    $adultTaxFare = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $childFare = $baseFare;
                                                    $childTaxFare = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $infantFare = $baseFare;
                                                    $infantTaxFare = $taxFare;
                                                }

                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];

                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];
                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $adultFare = $baseFare;
                                                $adultTaxFare = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $childFare = $baseFare;
                                                $childTaxFare = $taxFare;
                                            } else if($passType == 'INF') {
                                                $infantFare = $baseFare;
                                                $infantTaxFare = $taxFare;
                                            }
                                        }

                                        $data_Arr = array(
                                            'arrivalTotalPrice' => $totalfinalprice,
                                            'TotalPriceAdminFare' => $adminfee,
                                            'arrivalPriceAdultBaseFare' => $adultFare,
                                            'arrivalPriceAdultTaxFare' => $adultTaxFare,
                                            'arrivalPriceChildBaseFare' => $childFare,
                                            'arrivalPriceChildTaxFare' => $childTaxFare,
                                            'arrivalPriceInfantBaseFare' => $infantFare,
                                            'arrivalPriceInfantTaxFare' => $infantTaxFare
                                        );
                                    } else {
                                        if(array_key_exists('0', $passenger_breakdown)) {
                                            $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                            $infantFare = 0; $infantTaxFare = 0;
                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];

                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $adultFare = $baseFare;
                                                    $adultTaxFare = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $childFare = $baseFare;
                                                    $childTaxFare = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $infantFare = $baseFare;
                                                    $infantTaxFare = $taxFare;
                                                }
                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];

                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $adultFare = $baseFare;
                                                $adultTaxFare = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $childFare = $baseFare;
                                                $childTaxFare = $taxFare;
                                            } else if($passType == 'INF') {
                                                $infantFare = $baseFare;
                                                $infantTaxFare = $taxFare;
                                            }
                                        }

                                        $data_Arr = array(
                                            'departureTotalPrice' => $totalfinalprice,
                                            'TotalPriceAdminFare' => $adminfee,
                                            'departurePriceAdultBaseFare' => $adultFare,
                                            'departurePriceAdultTaxFare' => $adultTaxFare,
                                            'departurePriceChildBaseFare' => $childFare,
                                            'departurePriceChildTaxFare' => $childTaxFare,
                                            'departurePriceInfantBaseFare' => $infantFare,
                                            'departurePriceInfantTaxFare' => $infantTaxFare
                                        );
                                    }

                                    if ($totalPrice != $totalfinalprice) {
                                        if ($useArrivalPrice) {
                                        } else {

                                        }
                                        $this->All->update_template($data_Arr, 'id', $flight_cart->id, 'flight_cart');
                                        $updatedFlightCode[] = $flight_cart->departureFlightCode;
                                        $updateSomething = true;
                                        $updateFlight = true;
                                    }
                                //}
                            }
                        } else {
                            $flightCodeNumArray = explode(" ", $flight_cart->departureFlightCode);
                            /* check availability */
                            $flightCode = $flightCodeNumArray[0];
                            $flightNumber = $flightCodeNumArray[1];
                            $departureDate = $flight_cart->departureDateFrom;
                            $departureTime = date("H:i", strtotime($flight_cart->departureTimeFrom));
                            $arrivalDate = $flight_cart->departureDateTo;
                            $arrivalTime = date("H:i", strtotime($flight_cart->departureTimeTo));
                            $totalAdult = $flight_cart->noofAdult;
                            $totalChild = $flight_cart->noofChild;
                            $totalInfant = $flight_cart->noofInfant;
                            $numberInParty = $totalAdult + $totalChild; //infant not use seat
                            $ResBookDesigCode = $flight_cart->departureFlightResBookDesigCode;
                            $destinationCode = $flight_cart->departureCityCodeTo;
                            $originCode = $flight_cart->departureCityCodeFrom;
                            $totalPrice = $flight_cart->departureTotalPrice;

                            $useArrivalPrice = false;
                            if($totalPrice == "" || $totalPrice == 0) {
                                /* departure price empty, maybe it inserted to arrival price. just check */
                                $totalPrice = $flight_cart->arrivalTotalPrice;
                                $useArrivalPrice = true;
                            }
                            $marriageGroup = $flight_cart->departureFlightMarriageGrp;

                            $result = checkAirAvailabilityPrice($flightCode, $flightNumber, $departureDate, $departureTime, $arrivalDate, $arrivalTime, $numberInParty, $ResBookDesigCode, $destinationCode, $originCode, $marriageGroup, $totalAdult, $totalChild, $totalInfant,
                                $flight_cart->arrivalFlightCode,
                                $flight_cart->arrivalDateFrom,
                                $flight_cart->arrivalTimeFrom,
                                $flight_cart->arrivalFlightResBookDesigCode,
                                $flight_cart->arrivalCityCodeTo,
                                $flight_cart->arrivalCityCodeFrom,
                                $flight_cart->arrivalFlightMarriageGrp
                                );

                            $parseResult = simplexml_load_string($result);
                            $arrayFinal  = json_decode(json_encode($parseResult), true);
                            //$arrayFinal  = $arrayFinal["OriginDestinationOptions"]['OriginDestinationOption'];
                            $countArrayFinal = count($arrayFinal);

                            if ($arrayFinal && $arrayFinal['ApplicationResults']['@attributes']['status'] == 'Complete') {
                                $finalprice = ceil($arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['@attributes']['TotalAmount']);
                                $adminfee = ceil((($finalprice)*FLIGHT_ADMIN_PERCENT)/100);
                                //$totalfinalprice = $finalprice + $adminfee;

                                $passenger_breakdown = $arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['AirItineraryPricingInfo'];

                                //if ($totalPrice != $totalfinalprice) {
                                    /* update price */
                                    if($useArrivalPrice) {
                                         if(array_key_exists('0', $passenger_breakdown)) {
                                            $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                            $infantFare = 0; $infantTaxFare = 0;
                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];
                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $adultFare = $baseFare;
                                                    $adultTaxFare = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $childFare = $baseFare;
                                                    $childTaxFare = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $infantFare = $baseFare;
                                                    $infantTaxFare = $taxFare;
                                                }

                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];

                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $adultFare = $baseFare;
                                                $adultTaxFare = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $childFare = $baseFare;
                                                $childTaxFare = $taxFare;
                                            } else if($passType == 'INF') {
                                                $infantFare = $baseFare;
                                                $infantTaxFare = $taxFare;
                                            }
                                        }

                                        $data_Arr = array(
                                            'arrivalTotalPrice' => $totalfinalprice,
                                            'TotalPriceAdminFare' => $adminfee,
                                            'arrivalPriceAdultBaseFare' => $adultFare,
                                            'arrivalPriceAdultTaxFare' => $adultTaxFare,
                                            'arrivalPriceChildBaseFare' => $childFare,
                                            'arrivalPriceChildTaxFare' => $childTaxFare,
                                            'arrivalPriceInfantBaseFare' => $infantFare,
                                            'arrivalPriceInfantTaxFare' => $infantTaxFare
                                        );
                                    } else {
                                        if(array_key_exists('0', $passenger_breakdown)) {
                                            $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                            $infantFare = 0; $infantTaxFare = 0;
                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];

                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $adultFare = $baseFare;
                                                    $adultTaxFare = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $childFare = $baseFare;
                                                    $childTaxFare = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $infantFare = $baseFare;
                                                    $infantTaxFare = $taxFare;
                                                }
                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];

                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $adultFare = $baseFare;
                                                $adultTaxFare = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $childFare = $baseFare;
                                                $childTaxFare = $taxFare;
                                            } else if($passType == 'INF') {
                                                $infantFare = $baseFare;
                                                $infantTaxFare = $taxFare;
                                            }
                                        }

                                        $data_Arr = array(
                                            'departureTotalPrice' => $totalfinalprice,
                                            'TotalPriceAdminFare' => $adminfee,
                                            'departurePriceAdultBaseFare' => $adultFare,
                                            'departurePriceAdultTaxFare' => $adultTaxFare,
                                            'departurePriceChildBaseFare' => $childFare,
                                            'departurePriceChildTaxFare' => $childTaxFare,
                                            'departurePriceInfantBaseFare' => $infantFare,
                                            'departurePriceInfantTaxFare' => $infantTaxFare
                                        );
                                    }

                                    if ($totalPrice != $totalfinalprice) {
                                        if ($useArrivalPrice) {
                                        } else {

                                        }
                                        $this->All->update_template($data_Arr, 'id', $flight_cart->id, 'flight_cart');

                                        $updatedFlightCode[] = $flight_cart->departureFlightCode;
                                        $updateSomething = true;
                                        $updateFlight = true;
                                    }
                                //}
                            } else {
                                /* N/A */
                            }
                        }
                    }
                    /* end of departure data */

                    /* no need check arrival data as re3turn is depend on departure data*/

                }
            }

            if( $cart_hotels == TRUE ) {
                $updateMsg = "";
                $newarrayCart = array();
                $x = 0;
                /* check Total Quantity First */
                $totalPaxQty = 0;
                foreach ( $cart_hotels AS $cart_hotel ) {
                    $totalPaxQty += $cart_hotel->hotel_AdultQuantity + $cart_hotel->hotel_ChildQuantity;

                }

                if($totalPaxQty > 9) {
                    //session and redirect
                    $this->session->set_flashdata(
                        'error_checkout',
                        '<span>Max 9 pax(s) total in 1 check-in session for all items. Please remove some of your booking order</span>'
                    );
                    redirect("cart/index#hotel_cart");
                }

                $updateHotelPrice = false;
                foreach ( $cart_hotels AS $cart_hotel )
                {
                    $destinationCodeGET = $cart_hotel->hotel_ItemCityCode;
                    $hotelcheckinGET    = $cart_hotel->check_in_date;
                    $hotelcheckoutGET   = $cart_hotel->check_out_date;
                    $durationGET        = $cart_hotel->duration;
                    $noofroomGET        = $cart_hotel->hotel_RoomQuantity;
                    $itemcodeGET        = $cart_hotel->hotel_ItemCode;
                    $country_name = $this->All->get_country_hotel_bycitycode($destinationCodeGET);
                    $country_codeGET = $this->All->getCountryCode($country_name);

                    //XML Request
                    $requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
                    $requestData .= '<Request>';
                    $requestData .=     '<Source>';
                    $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                    $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD" Country="SG">';//'.$country_codeGET.'
                    $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                    $requestData .=         '</RequestorPreferences>';
                    $requestData .= '   </Source>';
                    $requestData .= '   <RequestDetails>';
                    $requestData .= '       <SearchHotelPricePaxRequest>';
                    $requestData .=             '<ItemDestination DestinationType="city" DestinationCode="'.$destinationCodeGET.'"/>';
                    $requestData .=             '<ImmediateConfirmationOnly/>';
                    $requestData .=             '<ItemCode>'.$itemcodeGET.'</ItemCode>';
                    $requestData .=             '<PeriodOfStay>';
                    $requestData .=             '   <CheckInDate>'.$hotelcheckinGET.'</CheckInDate>';
                    $requestData .=             '   <Duration><![CDATA['.$durationGET.']]></Duration>';
                    $requestData .=             '</PeriodOfStay>';
                    $requestData .=             '<IncludeRecommended/>';
                    $requestData .=             '<IncludePriceBreakdown/>';
                    $requestData .=             '<IncludeChargeConditions/>';
                    $requestData .=             '<PaxRooms>';
                    if( $cart_hotel->hotel_ChildQuantity != 0 ) {
                        $requestData .= '<PaxRoom  Id="'.$cart_hotel->hotel_RoomTypeID.'" Adults="'.$cart_hotel->hotel_AdultQuantity.'" Cots="'.$cart_hotel->hotel_InfantQuantity.'" RoomIndex="'.($x+1).'" >';

                            $requestData .= '<ChildAges>';
                                for ($i=0; $i<$cart_hotel->hotel_ChildQuantity; $i++) {
                                    $requestData .= '<Age>8</Age>';
                                }
                            $requestData .= '</ChildAges>';
                        $requestData .= '</PaxRoom>';
                    } else {
                        $requestData .= '<PaxRoom Id="'.$cart_hotel->hotel_RoomTypeID.'" Adults="'.$cart_hotel->hotel_AdultQuantity.'" Cots="'.$cart_hotel->hotel_InfantQuantity.'" RoomIndex="'.($x+1).'" />';
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
                    $parseResult        = simplexml_load_string($output, "SimpleXMLElement", LIBXML_NOCDATA);

                    // // // print_r($output);
                    // // // echo '$parseResult<br /><br />';
                    // // // print_r($parseResult);
                    $array_final_result = json_decode(json_encode($parseResult), true);

                    $paxroomCategory    = $array_final_result["ResponseDetails"]["SearchHotelPricePaxResponse"]["HotelDetails"]["Hotel"]["PaxRoomSearchResults"]["PaxRoom"]["RoomCategories"]["RoomCategory"];

                    $itemPrice = $paxroomCategory["ItemPrice"];
                    $itemPrice = $itemPrice + round((GTA_PRICE_MARKUP / 100) * $itemPrice, 2);

                    if ($cart_hotel->hotel_PricePerRoom != $itemPrice) {
                        $updateHotelPrice = true;
                        $updateMsg .= '<li style="list-style-type:square; margin-left:20px; font-size:12px">Hotel Room ('.$itemcodeGET .')'. $cart_hotel->hotel_RoomType.' price is updated from $'.$cart_hotel->hotel_PricePerRoom.' to $'.$itemPrice.'</li>';
                    } else {
                        $itemPrice = $cart_hotel->hotel_PricePerRoom;
                    }
                    $pricePerRoom = $itemPrice;

                    $updatedate = array(
                        "hotel_PricePerRoom"   => $pricePerRoom,
                        "modified"             => date("Y-m-d H:i:s")
                    );
                    $updateHotelCart = $this->All->update_template($updatedate, "id", $cart_hotel->id, "hotel_cart");
                    $x++;
                }

                if($updateHotelPrice) {
                    $this->session->set_flashdata(
                        'updatePriceCart',
                        '<div style="background-color:#eff0f1; margin-bottom:10px">
                            <div style="float:left; padding:10px; width:65%; font-size:12px; margin-top:0px">
                                <b>
                                    Please note that there are some price changes in your cart.
                                    <ul>
                                        '.$updateMsg.'
                                    </ul>
                                </b>
                            </div>
                            <div style="clear:both"></div>
                        </div>'
                    );
                }
            }

        }

        /* non login session */
        $emptyFlightCart = false;
        /* flight check */
        if( $this->session->userdata('shoppingCartFlightCookie') == TRUE )
        {
            $count_session_data = count($this->session->userdata('shoppingCartFlightCookie'));
            if ( $count_session_data > 0 )
            {
                $arrayCartFlight = $this->session->userdata('shoppingCartFlightCookie');
                $updatedFlightCode = array();
                for ( $x=0; $x<$count_session_data; $x++ )
                {
                    $totalfinalprice = 0;
                    $transitarray = explode("~", $arrayCartFlight[$x]["departureFlightName"]);
                    $istransit = count($transitarray) > 1 ? true : false;

                    //if( strpos($arrayCartFlight[$x]["departureFlightName"], '~') !== FALSE ) {
                    $totalAdult = $arrayCartFlight[$x]['noofAdult'];
                    $totalChild = $arrayCartFlight[$x]['noofChild'];
                    $totalInfant =$arrayCartFlight[$x]['noofInfant'];
                    $numberInParty = $totalAdult + $totalChild;

                    if ($istransit)
                    {
                        if ($arrayCartFlight[$x]["arrivalFlightCode"] == "")
                        {
                            /* direct flight */
                            $explodeCount = count(explode("~", $arrayCartFlight[$x]["departureFlightName"]));
                            if ($explodeCount)
                            {
                                $arrTotalPrice = $arrayCartFlight[$x]['departureTotalPrice'];
                                $arrFlightClass = $arrayCartFlight[$x]['departureFlightResBookDesigCode'];
                                $arrMarriageGroup = $arrayCartFlight[$x]['departureFlightMarriageGrp'];
                                $totalPrice = $arrayCartFlight[$x]['departureTotalPrice'];

                                $useArrivalPrice = false;
                                if ($totalPrice == "" || $totalPrice == 0)
                                {
                                    /* departure price empty, maybe it inserted to arrival price. just check */
                                    $useArrivalPrice = true;
                                    $totalPrice = $arrayCartFlight[$x]['arrivalTotalPrice'];
                                }

                                $result = checkAirAvailabilityPriceTransit(
                                    $arrayCartFlight[$x]['departureFlightCode'],
                                    $arrayCartFlight[$x]['departureDateFrom'],
                                    $arrayCartFlight[$x]['departureTimeFrom'],
                                    $arrayCartFlight[$x]['departureDateTo'],
                                    $arrayCartFlight[$x]['departureTimeTo'],
                                    $numberInParty, $arrFlightClass,
                                    $arrayCartFlight[$x]['departureCityCodeTo'],
                                    $arrayCartFlight[$x]['departureCityCodeFrom'],
                                    $arrayCartFlight[$x]['departureFlightMarriageGrp'],
                                    $totalAdult, $totalChild, $totalInfant
                                    );

                                $parseResult = simplexml_load_string($result);
                                $arrayFinal  = json_decode(json_encode($parseResult), true);
                                $countArrayFinal = count($arrayFinal);

                                if ($arrayFinal && $arrayFinal['ApplicationResults']['@attributes']['status'] == 'Complete')
                                {
                                    $passenger_breakdown = $arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['AirItineraryPricingInfo'];

                                    //$arrayCartFlight[$x]['TotalPriceAdminFare'] = $adminfee;

                                    //if ($totalPrice != $totalfinalprice) {
                                        /* update price */
                                        //$totalfinalprice = 0;

                                        $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                        $infantFare = 0; $infantTaxFare = 0;

                                        if($useArrivalPrice) {
                                            //
                                            if(array_key_exists('0', $passenger_breakdown)) {
                                                for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                    $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                    $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];
                                                    $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                    $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                    $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                    $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                    $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                    if ($passType == 'ADT') {
                                                        $arrayCartFlight[$x]['arrivalPriceAdultBaseFare'] = $baseFare;
                                                        $arrayCartFlight[$x]['arrivalPriceAdultTaxFare'] = $taxFare;
                                                    } else if ($passType == 'CNN') {
                                                        $arrayCartFlight[$x]['arrivalPriceChildBaseFare'] = $baseFare;
                                                        $arrayCartFlight[$x]['arrivalPriceChildTaxFare'] = $taxFare;
                                                    } else if ($passType == 'INF') {
                                                        $arrayCartFlight[$x]['arrivalPriceInfantBaseFare'] = $baseFare;
                                                        $arrayCartFlight[$x]['arrivalPriceInfantTaxFare'] = $taxFare;
                                                    }

                                                }
                                            } else {
                                                $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];
                                                $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $arrayCartFlight[$x]['arrivalPriceAdultBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceAdultTaxFare'] = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $arrayCartFlight[$x]['arrivalPriceChildBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceChildTaxFare'] = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $arrayCartFlight[$x]['arrivalPriceInfantBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceInfantTaxFare'] = $taxFare;
                                                }
                                            }

                                        } else {
                                            //$arrayCartFlight[$x]['departureTotalPrice'] = $totalfinalprice;
                                            if(array_key_exists('0', $passenger_breakdown)) {
                                                $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                                $infantFare = 0; $infantTaxFare = 0;
                                                for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                    $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                    $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];

                                                    $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                    $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                    $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                    $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                    $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                    if($passType == 'ADT') {
                                                        $arrayCartFlight[$x]['departurePriceAdultBaseFare'] = $baseFare;
                                                        $arrayCartFlight[$x]['departurePriceAdultTaxFare'] = $taxFare;
                                                    } else if($passType == 'CNN') {
                                                        $arrayCartFlight[$x]['departurePriceChildBaseFare'] = $baseFare;
                                                        $arrayCartFlight[$x]['departurePriceChildTaxFare'] = $taxFare;
                                                    } else if($passType == 'INF') {
                                                        $arrayCartFlight[$x]['departurePriceInfantBaseFare'] = $baseFare;
                                                        $arrayCartFlight[$x]['departurePriceInfantTaxFare'] = $taxFare;
                                                    }
                                                }
                                            } else {
                                                $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];
                                                $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $arrayCartFlight[$x]['departurePriceAdultBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceAdultTaxFare'] = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $arrayCartFlight[$x]['departurePriceChildBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceChildTaxFare'] = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $arrayCartFlight[$x]['departurePriceInfantBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceInfantTaxFare'] = $taxFare;
                                                }
                                            }
                                        }

                                        if($totalPrice != $totalfinalprice) {
                                            if($useArrivalPrice) {
                                                $arrayCartFlight[$x]['arrivalTotalPrice'] = $totalfinalprice;
                                            } else {
                                                $arrayCartFlight[$x]['departureTotalPrice'] = $totalfinalprice;
                                            }

                                            $updatedFlightCode[] = $arrayCartFlight[$x]["departureFlightCode"];
                                            $updateSomething = true;
                                            $updateFlight = true;
                                        }
                                    //}
                                } else {
                                    /* not available */
                                }
                            }
                        } else {
                            /* return flight */
                            $totalPrice = $arrayCartFlight[$x]['departureTotalPrice'];

                            $useArrivalPrice = false;
                            if($totalPrice == "" || $totalPrice == 0) {
                                /* departure price empty, maybe it inserted to arrival price. just check */
                                $totalPrice = $arrayCartFlight[$x]['arrivalTotalPrice'];
                                $useArrivalPrice = true;
                            }

                            $result = checkAirAvailabilityPriceTransit(
                                    $arrayCartFlight[$x]['departureFlightCode'],
                                    $arrayCartFlight[$x]['departureDateFrom'],
                                    $arrayCartFlight[$x]['departureTimeFrom'],
                                    $arrayCartFlight[$x]['departureDateTo'],
                                    $arrayCartFlight[$x]['departureTimeTo'],
                                    $numberInParty,
                                    $arrayCartFlight[$x]['departureFlightResBookDesigCode'],
                                    $arrayCartFlight[$x]['departureCityCodeTo'],
                                    $arrayCartFlight[$x]['departureCityCodeFrom'],
                                    $arrayCartFlight[$x]['departureFlightMarriageGrp'],
                                    $totalAdult, $totalChild, $totalInfant,
                                    $arrayCartFlight[$x]['arrivalFlightCode'],
                                    $arrayCartFlight[$x]['arrivalDateFrom'],
                                    $arrayCartFlight[$x]['arrivalTimeFrom'],
                                    $arrayCartFlight[$x]['arrivalCityCodeFrom'],
                                    $arrayCartFlight[$x]['arrivalCityCodeTo'],
                                    $arrayCartFlight[$x]['arrivalFlightResBookDesigCode'],
                                    $arrayCartFlight[$x]['arrivalFlightAirEquipType'],
                                    $arrayCartFlight[$x]['arrivalFlightMarriageGrp']
                                    );

                            $parseResult = simplexml_load_string($result);
                            $arrayFinal  = json_decode(json_encode($parseResult), true);

                            //$arrayFinal  = $arrayFinal["OriginDestinationOptions"]['OriginDestinationOption'];
                            $countArrayFinal = count($arrayFinal);

                            if ($arrayFinal && $arrayFinal['ApplicationResults']['@attributes']['status'] == 'Complete') {
                                /*$finalprice = ceil($arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['@attributes']['TotalAmount']);
                                $adminfee = ceil((($finalprice)*FLIGHT_ADMIN_PERCENT)/100);*/
                                $totalfinalprice = 0;//$finalprice + $adminfee;

                                $passenger_breakdown = $arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['AirItineraryPricingInfo'];

                                //$arrayCartFlight[$x]['TotalPriceAdminFare'] = $adminfee;

                                //if ($totalPrice != $totalfinalprice) {
                                    /* update price */
                                    if($useArrivalPrice) {
                                        //$arrayCartFlight[$x]['arrivalTotalPrice'] = $totalfinalprice;

                                        if(array_key_exists('0', $passenger_breakdown)) {
                                            $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                            $infantFare = 0; $infantTaxFare = 0;
                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];
                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $arrayCartFlight[$x]['arrivalPriceAdultBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceAdultTaxFare'] = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $arrayCartFlight[$x]['arrivalPriceChildBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceChildTaxFare'] = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $arrayCartFlight[$x]['arrivalPriceInfantBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceInfantTaxFare'] = $taxFare;
                                                }

                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];
                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $arrayCartFlight[$x]['arrivalPriceAdultBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['arrivalPriceAdultTaxFare'] = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $arrayCartFlight[$x]['arrivalPriceChildBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['arrivalPriceChildTaxFare'] = $taxFare;
                                            } else if($passType == 'INF') {
                                                $arrayCartFlight[$x]['arrivalPriceInfantBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['arrivalPriceInfantTaxFare'] = $taxFare;
                                            }
                                        }
                                    } else {
                                        //$arrayCartFlight[$x]['departureTotalPrice'] = $totalfinalprice;

                                        if(array_key_exists('0', $passenger_breakdown)) {
                                            $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                            $infantFare = 0; $infantTaxFare = 0;
                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];

                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];
                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $arrayCartFlight[$x]['departurePriceAdultBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceAdultTaxFare'] = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $arrayCartFlight[$x]['departurePriceChildBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceChildTaxFare'] = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $arrayCartFlight[$x]['departurePriceInfantBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceInfantTaxFare'] = $taxFare;
                                                }
                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];
                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];
                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $arrayCartFlight[$x]['departurePriceAdultBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['departurePriceAdultTaxFare'] = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $arrayCartFlight[$x]['departurePriceChildBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['departurePriceChildTaxFare'] = $taxFare;
                                            } else if($passType == 'INF') {
                                                $arrayCartFlight[$x]['departurePriceInfantBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['departurePriceInfantTaxFare'] = $taxFare;
                                            }
                                        }
                                    }

                                    if ($totalPrice != $totalfinalprice) {
                                        $updatedFlightCode[] = $arrayCartFlight[$x]["departureFlightCode"];
                                        $updateSomething = true;
                                        $updateFlight = true;

                                        if($useArrivalPrice) {
                                            $arrayCartFlight[$x]['arrivalTotalPrice'] = $totalfinalprice;
                                        } else {
                                            $arrayCartFlight[$x]['departureTotalPrice'] = $totalfinalprice;
                                        }
                                    }
                                //}
                            } else {
                                /* N/A */
                            }
                        }

                    }
                    else if( $istransit !== TRUE )
                    {
                        /* single flight */
                        if ($arrayCartFlight[$x]["arrivalFlightCode"] == "") {
                            /* direct flight */

                            $flightCodeNumArray = explode(" ", $arrayCartFlight[$x]["departureFlightCode"]);
                            /* check availability */
                            $flightCode = $flightCodeNumArray[0];
                            $flightNumber = $flightCodeNumArray[1];
                            $departureDate = $arrayCartFlight[$x]['departureDateFrom'];
                            $departureTime = date("H:i", strtotime($arrayCartFlight[$x]['departureTimeFrom']));
                            $arrivalDate = $arrayCartFlight[$x]['departureDateTo'];
                            $arrivalTime = date("H:i", strtotime($arrayCartFlight[$x]['departureTimeTo']));
                            $totalAdult = $arrayCartFlight[$x]['noofAdult'];
                            $totalChild = $arrayCartFlight[$x]['noofChild'];
                            $totalInfant = $arrayCartFlight[$x]['noofInfant'];
                            $numberInParty = $totalAdult + $totalChild; //infant not use seat
                            $ResBookDesigCode = $arrayCartFlight[$x]['departureFlightResBookDesigCode'];
                            $destinationCode = $arrayCartFlight[$x]['departureCityCodeTo'];
                            $originCode = $arrayCartFlight[$x]['departureCityCodeFrom'];
                            $totalPrice = $arrayCartFlight[$x]['departureTotalPrice'];

                            $useArrivalPrice = false;
                            if($totalPrice == "" || $totalPrice == 0) {
                                /* departure price empty, maybe it inserted to arrival price. just check */
                                $useArrivalPrice = true;
                                $totalPrice = $arrayCartFlight[$x]['arrivalTotalPrice'];
                            }
                            $marriageGroup = $arrayCartFlight[$x]['departureFlightMarriageGrp'];

                            $result = checkAirAvailability($flightCode, $flightNumber, $departureDate, $departureTime, $numberInParty, $ResBookDesigCode, $destinationCode, $originCode);

                            $parseResult = simplexml_load_string($result);
                            $arrayFinal  = json_decode(json_encode($parseResult), true);
                            $arrayFinal  = $arrayFinal["OriginDestinationOptions"]['OriginDestinationOption'];
                            $countArrayFinal = count($arrayFinal);

                            for($i = 0; $i < $countArrayFinal; $i++) {
                                if(array_key_exists($i, $arrayFinal)) {
                                    //$flightNumber = $arrayFinal['FlightSegment']['@attributes']['FlightNumber'];
                                    $availFlightCode = $arrayFinal[$i]['FlightSegment']['MarketingAirline']['@attributes']['Code'];
                                    $availFlightNumber = $arrayFinal[$i]['FlightSegment']['MarketingAirline']['@attributes']['FlightNumber'];
                                    if($availFlightCode == $flightCode && $availFlightNumber == $flightNumber) {
                                        $availableSeat = $arrayFinal[$i]['FlightSegment']['BookingClassAvail']['@attributes']['Availability'];
                                        $totalTravelTime = $arrayFinal[$i]['FlightSegment']['FlightDetails']['@attributes']['TotalTravelTime'];
                                        $meal = $arrayFinal[$i]['FlightSegment']['Meal']['@attributes']['MealCode'];
                                        break; // no need to check further
                                    }
                                } else if (array_key_exists('@attributes', $arrayFinal)) {
                                    $availFlightCode = $arrayFinal['FlightSegment']['MarketingAirline']['@attributes']['Code'];
                                    $availFlightNumber = $arrayFinal['FlightSegment']['MarketingAirline']['@attributes']['FlightNumber'];
                                    if($availFlightCode == $flightCode && $availFlightNumber == $flightNumber) {
                                        $availableSeat = $arrayFinal['FlightSegment']['BookingClassAvail']['@attributes']['Availability'];
                                        $totalTravelTime = $arrayFinal['FlightSegment']['FlightDetails']['@attributes']['TotalTravelTime'];
                                        $meal = $arrayFinal['FlightSegment']['Meal']['@attributes']['MealCode'];
                                        break; // no need to check further
                                    }
                                }
                            }

                            if($availableSeat < $numberInParty) {
                                /* session expired, maybe? */
                                $this->session->set_flashdata(
                                    'empty_cart',
                                    '<div style="background-color:#eff0f1; color:red; margin-bottom:5px">
                                        <div style="float:left; padding:10px">
                                            <img src="'.base_url().'/assets/info.png" width="30" height="30">
                                        </div>
                                        <div style="color: red; float:left; padding:0px; font-size:14px; margin-top:15px">
                                            There is no available seats for your flight
                                        </div>
                                    </div>'
                                );

                                if($isAjax) {
                                    echo json_encode(array('error'=>true,'message'=>'There is no available seats for your flight'));
                                    exit();
                                } else {
                                    redirect(base_url().'cart/emptyCart');
                                }
                            }

                            $result = checkAirAvailabilityPrice($flightCode, $flightNumber, $departureDate, $departureTime, $arrivalDate, $arrivalTime, $numberInParty, $ResBookDesigCode, $destinationCode, $originCode, $marriageGroup, $totalAdult, $totalChild, $totalInfant);

                            $parseResult = simplexml_load_string($result);

                            $arrayFinal  = json_decode(json_encode($parseResult), true);

                            //$arrayFinal  = $arrayFinal["OriginDestinationOptions"]['OriginDestinationOption'];
                            $countArrayFinal = count($arrayFinal);

                            if ($arrayFinal && $arrayFinal['ApplicationResults']['@attributes']['status'] == 'Complete') {

                                $finalprice = ceil($arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['@attributes']['TotalAmount']);

                                $passenger_breakdown = $arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['AirItineraryPricingInfo'];

                                /*$adminfee = ceil((($finalprice)*FLIGHT_ADMIN_PERCENT)/100);
                                $totalfinalprice = $finalprice + $adminfee;
                                $arrayCartFlight[$x]['TotalPriceAdminFare'] = $adminfee;*/

                                //if ($totalPrice != $totalfinalprice) {
                                    /* update price */
                                    if($useArrivalPrice) {
                                       // $arrayCartFlight[$x]['arrivalTotalPrice'] = $totalfinalprice;

                                        if(array_key_exists('0', $passenger_breakdown)) {
                                            $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                            $infantFare = 0; $infantTaxFare = 0;
                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];
                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];
                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $arrayCartFlight[$x]['arrivalPriceAdultBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceAdultTaxFare'] = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $arrayCartFlight[$x]['arrivalPriceChildBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceChildTaxFare'] = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $arrayCartFlight[$x]['arrivalPriceInfantBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceInfantTaxFare'] = $taxFare;
                                                }

                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];
                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];
                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $arrayCartFlight[$x]['arrivalPriceAdultBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['arrivalPriceAdultTaxFare'] = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $arrayCartFlight[$x]['arrivalPriceChildBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['arrivalPriceChildTaxFare'] = $taxFare;
                                            } else if($passType == 'INF') {
                                                $arrayCartFlight[$x]['arrivalPriceInfantBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['arrivalPriceInfantTaxFare'] = $taxFare;
                                            }
                                        }
                                    } else {
                                        if(array_key_exists('0', $passenger_breakdown)) {
                                            $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                            $infantFare = 0; $infantTaxFare = 0;
                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];

                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];

                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += ceil($baseFare + $taxFare) * $passQty;

                                                if($passType == 'ADT') {
                                                    $arrayCartFlight[$x]['departurePriceAdultBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceAdultTaxFare'] = $taxFare;

                                                } else if($passType == 'CNN') {
                                                    $arrayCartFlight[$x]['departurePriceChildBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceChildTaxFare'] = $taxFare;

                                                } else if($passType == 'INF') {
                                                    $arrayCartFlight[$x]['departurePriceInfantBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceInfantTaxFare'] = $taxFare;
                                                }
                                            }

                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];
                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];
                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $arrayCartFlight[$x]['departurePriceAdultBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['departurePriceAdultTaxFare'] = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $arrayCartFlight[$x]['departurePriceChildBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['departurePriceChildTaxFare'] = $taxFare;
                                            } else if($passType == 'INF') {
                                                $arrayCartFlight[$x]['departurePriceInfantBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['departurePriceInfantTaxFare'] = $taxFare;
                                            }
                                        }

                                    }

                                    if ($totalPrice != $totalfinalprice) {
                                        /* update price */
                                        if($useArrivalPrice) {
                                           $arrayCartFlight[$x]['arrivalTotalPrice'] = $totalfinalprice;
                                        } else {
                                            $arrayCartFlight[$x]['departureTotalPrice'] = $totalfinalprice;
                                        }

                                        $updatedFlightCode[] = $arrayCartFlight[$x]["departureFlightCode"];
                                        $updateSomething = true;
                                        $updateFlight = true;
                                    }

                                //}
                            }
                        } else {
                            $flightCodeNumArray = explode(" ", $arrayCartFlight[$x]["departureFlightCode"]);
                            /* check availability */
                            $flightCode = $flightCodeNumArray[0];
                            $flightNumber = $flightCodeNumArray[1];
                            $departureDate = $arrayCartFlight[$x]['departureDateFrom'];
                            $departureTime = date("H:i", strtotime($arrayCartFlight[$x]['departureTimeFrom']));
                            $arrivalDate = $arrayCartFlight[$x]['departureDateTo'];
                            $arrivalTime = date("H:i", strtotime($arrayCartFlight[$x]['departureTimeTo']));
                            $totalAdult = $arrayCartFlight[$x]['noofAdult'];
                            $totalChild = $arrayCartFlight[$x]['noofChild'];
                            $totalInfant = $arrayCartFlight[$x]['noofInfant'];
                            $numberInParty = $totalAdult + $totalChild; //infant not use seat
                            $ResBookDesigCode = $arrayCartFlight[$x]['departureFlightResBookDesigCode'];
                            $destinationCode = $arrayCartFlight[$x]['departureCityCodeTo'];
                            $originCode = $arrayCartFlight[$x]['departureCityCodeFrom'];
                            $totalPrice = $arrayCartFlight[$x]['departureTotalPrice'];

                            $useArrivalPrice = false;
                            if($totalPrice == "" || $totalPrice == 0) {
                                /* departure price empty, maybe it inserted to arrival price. just check */
                                $useArrivalPrice = true;
                                $totalPrice = $arrayCartFlight[$x]['arrivalTotalPrice'];
                            }
                            $marriageGroup = $arrayCartFlight[$x]['departureFlightMarriageGrp'];

                            $result = checkAirAvailabilityPrice($flightCode, $flightNumber, $departureDate, $departureTime, $arrivalDate, $arrivalTime, $numberInParty, $ResBookDesigCode, $destinationCode, $originCode, $marriageGroup, $totalAdult, $totalChild, $totalInfant,
                                $arrayCartFlight[$x]['arrivalFlightCode'],
                                $arrayCartFlight[$x]['arrivalDateFrom'],
                                $arrayCartFlight[$x]['arrivalTimeFrom'],
                                $arrayCartFlight[$x]['arrivalFlightResBookDesigCode'],
                                $arrayCartFlight[$x]['arrivalCityCodeTo'],
                                $arrayCartFlight[$x]['arrivalCityCodeFrom'],
                                $arrayCartFlight[$x]['arrivalFlightMarriageGrp']
                                );

                            $parseResult = simplexml_load_string($result);
                            $arrayFinal  = json_decode(json_encode($parseResult), true);
                            //$arrayFinal  = $arrayFinal["OriginDestinationOptions"]['OriginDestinationOption'];
                            $countArrayFinal = count($arrayFinal);

                            if ($arrayFinal && $arrayFinal['ApplicationResults']['@attributes']['status'] == 'Complete') {
                                $finalprice = ceil($arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['@attributes']['TotalAmount']);
                                $adminfee = ceil((($finalprice)*FLIGHT_ADMIN_PERCENT)/100);
                                //$totalfinalprice = $finalprice + $adminfee;

                                $passenger_breakdown = $arrayFinal['OTA_AirPriceRS']['PriceQuote']['PricedItinerary']['AirItineraryPricingInfo'];

                                $arrayCartFlight[$x]['TotalPriceAdminFare'] = $adminfee;

                                if ($totalPrice != $totalfinalprice) {
                                    /* update price */
                                    if($useArrivalPrice) {
                                        /*$arrayCartFlight[$x]['arrivalTotalPrice'] = $totalfinalprice;*/

                                        $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                        $infantFare = 0; $infantTaxFare = 0;
                                        if(array_key_exists('0', $passenger_breakdown)) {
                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];
                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];
                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $arrayCartFlight[$x]['arrivalPriceAdultBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceAdultTaxFare'] = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $arrayCartFlight[$x]['arrivalPriceChildBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceChildTaxFare'] = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $arrayCartFlight[$x]['arrivalPriceInfantBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['arrivalPriceInfantTaxFare'] = $taxFare;
                                                }

                                            }
                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];
                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];
                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);
                                            if($passType == 'ADT') {
                                                $arrayCartFlight[$x]['arrivalPriceAdultBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['arrivalPriceAdultTaxFare'] = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $arrayCartFlight[$x]['arrivalPriceChildBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['arrivalPriceChildTaxFare'] = $taxFare;
                                            } else if($passType == 'INF') {
                                                $arrayCartFlight[$x]['arrivalPriceInfantBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['arrivalPriceInfantTaxFare'] = $taxFare;
                                            }
                                        }

                                    } else {
                                        //$arrayCartFlight[$x]['departureTotalPrice'] = $totalfinalprice;

                                        if(array_key_exists('0', $passenger_breakdown)) {
                                            $adultFare = 0; $adultTaxFare = 0; $childFare = 0; $childTaxFare = 0;
                                            $infantFare = 0; $infantTaxFare = 0;
                                            for ($idxp = 0; $idxp < count($passenger_breakdown); $idxp++) {
                                                $passType = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Code'];
                                                $passQty = $passenger_breakdown[$idxp]['PassengerTypeQuantity']['@attributes']['Quantity'];

                                                $baseFare = $passenger_breakdown[$idxp]['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                                $taxFare = $passenger_breakdown[$idxp]['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];
                                                $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                                $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                                if($passType == 'ADT') {
                                                    $arrayCartFlight[$x]['departurePriceAdultBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceAdultTaxFare'] = $taxFare;
                                                } else if($passType == 'CNN') {
                                                    $arrayCartFlight[$x]['departurePriceChildBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceChildTaxFare'] = $taxFare;
                                                } else if($passType == 'INF') {
                                                    $arrayCartFlight[$x]['departurePriceInfantBaseFare'] = $baseFare;
                                                    $arrayCartFlight[$x]['departurePriceInfantTaxFare'] = $taxFare;
                                                }
                                            }

                                        } else {
                                            $passType = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Code'];
                                            $passQty = $passenger_breakdown['PassengerTypeQuantity']['@attributes']['Quantity'];
                                            $baseFare = $passenger_breakdown['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                                            $taxFare = $passenger_breakdown['ItinTotalFare']['Taxes']['@attributes']['TotalAmount'];
                                            $baseFare = $baseFare + (($baseFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $taxFare = $taxFare + (($taxFare *FLIGHT_ADMIN_PERCENT)/100);
                                            $totalfinalprice += $passQty * ceil($baseFare + $taxFare);

                                            if($passType == 'ADT') {
                                                $arrayCartFlight[$x]['departurePriceAdultBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['departurePriceAdultTaxFare'] = $taxFare;
                                            } else if($passType == 'CNN') {
                                                $arrayCartFlight[$x]['departurePriceChildBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['departurePriceChildTaxFare'] = $taxFare;
                                            } else if($passType == 'INF') {
                                                $arrayCartFlight[$x]['departurePriceInfantBaseFare'] = $baseFare;
                                                $arrayCartFlight[$x]['departurePriceInfantTaxFare'] = $taxFare;
                                            }
                                        }
                                    }

                                    if ($totalPrice != $totalfinalprice) {
                                        /* update price */
                                        if ($useArrivalPrice) {
                                            $arrayCartFlight[$x]['arrivalTotalPrice'] = $totalfinalprice;
                                        } else {
                                            $arrayCartFlight[$x]['departureTotalPrice'] = $totalfinalprice;
                                        }
                                        $updatedFlightCode[] = $arrayCartFlight[$x]["departureFlightCode"];
                                        $updateSomething = true;
                                        $updateFlight = true;
                                    }
                                }
                            } else {
                                /* N/A */
                            }
                        }
                    }
                    /* end of departure data */

                    /* no need check arrival data as re3turn is depend on departure data*/
                }
            } else {
                /* session expired, maybe? */
                $emptyFlightCart = true;
            }
        }

        /* hotel Check */
        $emptyHotelCart = false;
        if( $this->session->userdata('shoppingCartCookie') == TRUE ) {

            $arrayCart = $this->session->userdata('shoppingCartCookie');
            if( count($arrayCart) > 0 ) {
            $updateMsg = "";

            $totalPaxQty = 0;
            for($x=0; $x<count($arrayCart); $x++) {
                foreach ($arrayCart[$x]['hotel_room'] as $hotelRoom) {
                    $totalPaxQty += $hotelRoom["hotel_AdultQuantity"] + $hotelRoom["hotel_ChildQuantity"];
                }
            }

            if($totalPaxQty > 9) {
                //session and redirect
                $this->session->set_flashdata(
                    'error_checkout',
                    '<span>Max 9 pax(s) total in 1 check-in session for all items. Please remove some of your booking order</span>'
                );
                redirect("cart/index#hotel_cart");
            }

            $updateHotelPrice = false;
            for($x=0; $x<count($arrayCart); $x++) {
                $newarrayCart = array();
                foreach ($arrayCart[$x]['hotel_room'] as $hotelRoom) {
                    $destinationCodeGET = $arrayCart[$x]['hotel_ItemCityCode'];
                    $hotelcheckinGET    = $arrayCart[$x]['check_in_date'];
                    $hotelcheckoutGET   = $arrayCart[$x]['check_out_date'];
                    $durationGET        = $arrayCart[$x]['duration'];
                    $noofroomGET        = $arrayCart[$x]['hotel_RoomQuantity'];
                    $itemcodeGET        = $arrayCart[$x]['hotel_ItemCode'];
                    $country_name = $this->All->get_country_hotel_bycitycode($destinationCodeGET);
                    $country_codeGET = $this->All->getCountryCode($country_name);
                    $hotel_childAgeGet = $hotelRoom['childages'];

                    //XML Request
                    $requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
                    $requestData .= '<Request>';
                    $requestData .=     '<Source>';
                    $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                    $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD" Country="SG">';//'.$country_codeGET.'
                    $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                    $requestData .=         '</RequestorPreferences>';
                    $requestData .= '   </Source>';
                    $requestData .= '   <RequestDetails>';
                    $requestData .= '       <SearchHotelPricePaxRequest>';
                    $requestData .=             '<ItemDestination DestinationType="city" DestinationCode="'.$destinationCodeGET.'"/>';
                    $requestData .=             '<ImmediateConfirmationOnly/>';
                    $requestData .=             '<ItemCode>'.$itemcodeGET.'</ItemCode>';
                    $requestData .=             '<PeriodOfStay>';
                    $requestData .=             '   <CheckInDate>'.$hotelcheckinGET.'</CheckInDate>';
                    $requestData .=             '   <Duration><![CDATA['.$durationGET.']]></Duration>';
                    $requestData .=             '</PeriodOfStay>';
                    $requestData .=             '<IncludeRecommended/>';
                    $requestData .=             '<IncludePriceBreakdown/>';
                    $requestData .=             '<IncludeChargeConditions/>';
                    $requestData .=             '<PaxRooms>';

                    if( $hotelRoom["hotel_ChildQuantity"] != 0 ) {
                        $requestData .= '<PaxRoom  Id="'.$hotelRoom['hotel_RoomTypeID'].'" Adults="'.$hotelRoom["hotel_AdultQuantity"].'" Cots="'.$hotelRoom["hotel_InfantQuantity"].'" RoomIndex="'.($x+1).'" >';

                            $requestData .= '<ChildAges>';
                                for ($i=0; $i<$hotelRoom["hotel_ChildQuantity"]; $i++) {
                                    $hotel_childAgeGet = explode(",", $hotelRoom['childages']);
                                    $requestData .= '<Age>'.$hotel_childAgeGet[$i].'</Age>';
                                }
                            $requestData .= '</ChildAges>';
                        $requestData .= '</PaxRoom>';
                    } else {
                        $requestData .= '<PaxRoom Id="'.$hotelRoom['hotel_RoomTypeID'].'" Adults="'.$hotelRoom["hotel_AdultQuantity"].'" Cots="'.$hotelRoom["hotel_InfantQuantity"].'" RoomIndex="'.($x+1).'" />';
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
                    $parseResult        = simplexml_load_string($output, "SimpleXMLElement", LIBXML_NOCDATA);
                    $array_final_result = json_decode(json_encode($parseResult), true);

                    $paxroomCategory    = $array_final_result["ResponseDetails"]["SearchHotelPricePaxResponse"]["HotelDetails"]["Hotel"]["PaxRoomSearchResults"]["PaxRoom"]["RoomCategories"]["RoomCategory"];

                    $itemPrice = $paxroomCategory["ItemPrice"];
                    $itemPrice = $itemPrice + round((GTA_PRICE_MARKUP / 100) * $itemPrice, 2);

                    $hotelName = $arrayCart[$x]['hotel_Fullname'];
                    $hotelImage = $arrayCart[$x]['hotel_Image'];
                    $itemCode = $arrayCart[$x]['hotel_ItemCode'];
                    $destinationCode = $arrayCart[$x]['hotel_ItemCityCode'];
                    $pricePerRoom = $itemPrice;
                    $noofRoom = $arrayCart[$x]['hotel_RoomQuantity'];
                    $checkinDate = $arrayCart[$x]['check_in_date'];
                    $checkoutDate = $arrayCart[$x]['check_out_date'];
                    $duration_day = $arrayCart[$x]['duration'];

                    if (floatval($hotelRoom['hotel_PricePerRoom']) !== floatval($itemPrice)) {
                        $updateHotelPrice = true;
                        //echo floatval($hotelRoom['hotel_PricePerRoom']). " ".floatval($itemPrice);
                        $updateMsg .= '<li style="list-style-type:square; margin-left:20px; font-size:12px">Hotel Room ('.$itemcodeGET .')'. $hotelRoom['hotel_RoomType'].' price is updated from $'.$hotelRoom['hotel_PricePerRoom'].' to $'.$itemPrice.'</li>';
                    } else {
                        $itemPrice = $hotelRoom['hotel_PricePerRoom'];
                    }

                    $hotel_RoomImage = $hotelRoom['hotel_RoomImage'];
                    $roomType = $hotelRoom['hotel_RoomType'];
                    $roomTypeID = $hotelRoom['hotel_RoomTypeID'];
                    $noofadult = $hotelRoom['hotel_AdultQuantity'];
                    $noofchild = $hotelRoom['hotel_ChildQuantity'];
                    $noofinfant = $hotelRoom['hotel_InfantQuantity'];
                    $roomidx = $hotelRoom['room_index'];
                    $mealbasis = $hotelRoom['room_meal'];

                    $new_array = array(
                        "hotel_PricePerRoom"   => $itemPrice,
                        "hotel_RoomType"       => $roomType,
                        "hotel_RoomTypeID"     => $roomTypeID,
                        "hotel_AdultQuantity"  => trim($noofadult),
                        "hotel_ChildQuantity"  => trim($noofchild),
                        "hotel_InfantQuantity" => trim($noofinfant),
                        "hotel_RoomImage" => trim($hotel_RoomImage),
                        "room_index" => $roomidx,
                        "room_meal" => $mealbasis,
                        "childages" => trim($hotelRoom['childages'])
                    );
                    //$cart_items[] = $old_array;
                    $newarrayCart[] = $new_array;
                }
                $cart_items[] = array(
                    "hotel_Fullname"       => $hotelName,
                    "hotel_Image"          => $hotelImage,
                    "hotel_ItemCode"       => $itemCode,
                    "hotel_ItemCityCode"   => $destinationCode,
                    "check_in_date"        => $checkinDate,
                    "check_out_date"       => $checkoutDate,
                    "duration"             => $duration_day,
                    "created"              => date("Y-m-d H:i:s"),
                    "modified"             => date("Y-m-d H:i:s"),
                    "hotel_RoomQuantity"   => $noofRoom,
                    "hotel_room" => $newarrayCart
                );
            }
            //echo '<pre>';var_dump($cart_items);die();
            if($updateHotelPrice) {
                //$cart_items = $newarrayCart;
                $this->session->set_userdata('shoppingCartCookie', $cart_items);

                $this->session->set_flashdata(
                    'updatePriceCart',
                    '<div style="background-color:#eff0f1; margin-bottom:10px">
                        <div style="float:left; padding:10px; width:65%; font-size:12px; margin-top:0px">
                            <b>
                                Please note that there are some price changes in your cart.
                                <ul>
                                    '.$updateMsg.'
                                </ul>
                            </b>
                        </div>
                        <div style="clear:both"></div>
                    </div>'
                );
            }
            } else {
                /* session expired, maybe? */
                    $emptyHotelCart = true;
            }
        }
        /* cruise check here */
        $emptyCruiseCart = false;
        /* end */

        if ($emptyFlightCart || $emptyHotelCart || $emptyCruiseCart) {
            $this->session->set_flashdata(
                'empty_cart',
                '<div style="background-color:#eff0f1; color:red; margin-bottom:5px">
                    <div style="float:left; padding:10px">
                        <img src="'.base_url().'/assets/info.png" width="30" height="30">
                    </div>
                    <div style="color: red; float:left; padding:0px; font-size:14px; margin-top:15px">
                        Your Cart session has been expired and it\'s empty now.
                    </div>
                </div>'
            );

            if ($isAjax) {
                echo json_encode(array('error'=>true, 'message'=>'Your Cart session has been expired and it\'s empty now.'));
            } else {
                redirect(base_url().'cart/emptyCart');
            }
            exit();
        }

        if($updateSomething) {
            if ($isAjax) {
                echo json_encode(array('error'=>false, 'pricechange' => true));
            } else {
                if( $this->session->userdata('shoppingCartFlightCookie') == TRUE ) {
                    /* update cart session */
                    $this->session->set_userdata('shoppingCartFlightCookie', $arrayCartFlight);
                }
                if( $this->session->userdata('shoppingCartCookie') == TRUE ) {
                    /* update cart session */
                    $this->session->set_userdata('shoppingCartCookie', $arrayCart);
                }
                if( $this->session->userdata('shoppingCartCruiseCookie') == TRUE ) {
                    /* update cart session */
                    $this->session->set_userdata('shoppingCartCruiseCookie', $arrayCartCruise);
                }

                $this->session->set_flashdata(
                'updated_cart',
                '<div style="background-color:#eff0f1">
                    <div style="float:left; padding:10px">
                        <img src="'.base_url().'/assets/info.png" width="30" height="30">
                    </div>
                    <div style="color: red; float:left; padding:2px; font-size:14px; margin-top:15px; margin-bottom: 5px">
                        <b>There is some price update for item(s) in your cart. Make sure you have check again before confirming your issues. If you have any question, please contact us</b>
                    </div>
                    <div style="clear:both"></div>
                </div>'
                );

                /*$this->session->set_flashdata(
                'updated_cart',
                '<div style="background-color:#eff0f1">
                    <div style="float:left; padding:10px">
                        <img src="'.base_url().'/assets/info.png" width="30" height="30">
                    </div>
                    <div style="color: red; float:left; padding:2px; font-size:14px; margin-top:15px; margin-bottom: 5px">
                        <b>Price Updated for flight '. implode(", ", array_unique($updatedFlightCode)) .'. Make sure you have check again before confirming your issues. If you have any question, please contact us</b>
                    </div>
                    <div style="clear:both"></div>
                </div>'
                );*/
            }
        } else {
            if ($isAjax) {
                echo json_encode(array('error'=>false, 'message'=>''));
            } else {

            }
        }
    }

    public function checkPriceCruise()
    {
        if( $this->session->userdata('normal_session_id') == TRUE )
        {
            $cart_cruises = $this->All->select_template(
                "user_access_id", $this->session->userdata('normal_session_id'), "cruise_cart"
            );
            if( $cart_cruises == TRUE ) {
                foreach( $cart_cruises AS $cart_cruise ) {
                    $adult = $cart_cruise->noofAdult;
                    $child = $cart_cruise->noofChild;
                    $cruise_prices = $this->All->select_template_w_5_conditions(
                        "SHIP_ID",      $cart_cruise->shipID,
                        "BRAND_ID",     $cart_cruise->brandID,
                        "STATEROOM_ID", $cart_cruise->stateroomID,
                        "PERIOD_TYPE",  $cart_cruise->cruisePriceType,
                        "NIGHTS_NO",    $cart_cruise->durationNight,
                        "cruise_prices"
                    );
                    if( $cruise_prices == TRUE ) {
                        foreach( $cruise_prices AS $cruise_price ) {
                            if( $adult == 1 && $child == 0 ) {
                                $priceUpdate = $cruise_price->ATT_SINGLE;
                            }
                            else if( $adult == 2 && $child == 0 ) {
                                $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT;
                            }
                            else if( $adult == 3 && $child == 0 ) {
                                $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT+$cruise_price->ATT_3_ADULT;
                            }
                            else if( $adult == 4 && $child == 0 ) {
                                $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT+$cruise_price->ATT_3_ADULT+$cruise_price->ATT_4_ADULT;
                            }
                            else if( $adult == 1 && $child == 1 ) {
                                $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_CHILD;
                            }
                            else if( $adult == 2 && $child == 1 ) {
                                $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT+$cruise_price->ATT_3_CHILD;
                            }
                            else if( $adult == 3 && $child == 1 ) {
                                $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT+$cruise_price->ATT_3_ADULT+$cruise_price->ATT_4_CHILD;
                            }
                            else if( $adult == 1 && $child == 2 ) {
                                $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_CHILD+$cruise_price->ATT_3_CHILD;
                            }
                            else if( $adult == 2 && $child == 2 ) {
                                $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT+$cruise_price->ATT_3_CHILD+$cruise_price->ATT_4_CHILD;
                            }
                            else if( $adult == 1 && $child == 3 ) {
                                $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_CHILD+$cruise_price->ATT_3_CHILD+$cruise_price->ATT_4_CHILD;
                            }
                            $data_fields = array(
                                "cruisePrice" => $priceUpdate,
                                "modified"    => date("Y-m-d H:i:s")
                            );
                            $updateCruiseCart = $this->All->update_template($data_fields, "id", $cart_cruise->id, "cruise_cart");
                        }
                    }
                }
            }
        }
        else {
            $arrayCruise = $this->session->userdata('shoppingCartCruiseCookie');
            $arrayCruiseCount = count($arrayCruise);
            if( $arrayCruise == TRUE ) {
                if( $arrayCruiseCount > 0 ) {
                    for($c=0; $c<$arrayCruiseCount; $c++) {
                        $adult = $arrayCruise[$c]["noofAdult"];
                        $child = $arrayCruise[$c]["noofChild"];
                            $cruise_prices = $this->All->select_template_w_5_conditions(
                            "SHIP_ID",      $arrayCruise[$c]["shipID"],
                            "BRAND_ID",     $arrayCruise[$c]["brandID"],
                            "STATEROOM_ID", $arrayCruise[$c]["stateroomID"],
                            "PERIOD_TYPE",  $arrayCruise[$c]["cruisePriceType"],
                            "NIGHTS_NO",    $arrayCruise[$c]["durationNight"],
                            "cruise_prices"
                        );
                        if( $cruise_prices == TRUE ) {
                            foreach( $cruise_prices AS $cruise_price ) {
                                if( $adult == 1 && $child == 0 ) {
                                    $priceUpdate = $cruise_price->ATT_SINGLE;
                                }
                                else if( $adult == 2 && $child == 0 ) {
                                    $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT;
                                }
                                else if( $adult == 3 && $child == 0 ) {
                                    $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT+$cruise_price->ATT_3_ADULT;
                                }
                                else if( $adult == 4 && $child == 0 ) {
                                    $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT+$cruise_price->ATT_3_ADULT+$cruise_price->ATT_4_ADULT;
                                }
                                else if( $adult == 1 && $child == 1 ) {
                                    $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_CHILD;
                                }
                                else if( $adult == 2 && $child == 1 ) {
                                    $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT+$cruise_price->ATT_3_CHILD;
                                }
                                else if( $adult == 3 && $child == 1 ) {
                                    $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT+$cruise_price->ATT_3_ADULT+$cruise_price->ATT_4_CHILD;
                                }
                                else if( $adult == 1 && $child == 2 ) {
                                    $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_CHILD+$cruise_price->ATT_3_CHILD;
                                }
                                else if( $adult == 2 && $child == 2 ) {
                                    $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_ADULT+$cruise_price->ATT_3_CHILD+$cruise_price->ATT_4_CHILD;
                                }
                                else if( $adult == 1 && $child == 3 ) {
                                    $priceUpdate = $cruise_price->ATT_1+$cruise_price->ATT_2_CHILD+$cruise_price->ATT_3_CHILD+$cruise_price->ATT_4_CHILD;
                                }
                                $arrayCruise[$c]['cruisePrice'] = $priceUpdate;
                            }
                        }
                    }
                }
            }
        }
    }

    public function index()
    {
        $this->checkPrice();
        $this->checkPriceCruise();
        $this->load->view('checkout_index');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */