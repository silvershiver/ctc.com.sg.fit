<?php
    $arrayBtnArrival = array();
    if( $totalFlight > 0 ) {
        for($a=0; $a<$totalFlight; $a++) {
            $arrayBtnArrival[] = $a;
        }
    }

    $departureFlightCodeArr = array();
    $arrivalFlightCodeArr   = array();
    if( $totalFlight > 0 ) {
        for($a=0; $a<$totalFlight; $a++) {
            $flightDeparture = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0];
            $flightArrival = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][1];

            if( isset($flightDeparture["FlightSegment"][0]) )
            {
                /* multi departure */
                $countFlightSegment = count($flightDeparture["FlightSegment"]);
                for( $fs=0; $fs<$countFlightSegment; $fs++ )
                {
                    $flightCode = (string) $flightDeparture["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"];

                    $departureFlightCodeArr{$a}[] = $flightCode;
                }

                if (count(array_unique($departureFlightCodeArr{$a})) === 1) {
                } else {
                    unset($flight_results[$a]);
                    continue;
                }
            } else {
                $flightCode = (string) $flightDeparture["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];
                $departureFlightCodeArr{$a}[] = $flightCode;

                /*if($flightCode == '3K' || $flightCode == 'BL') {
                    unset($flight_results[$a]);
                    continue;
                }*/
            }

            if( isset($flightArrival["FlightSegment"][0]) )
            {
                /* multi departure */
                $countFlightSegment = count($flightArrival["FlightSegment"]);
                for( $fs=0; $fs<$countFlightSegment; $fs++ )
                {
                    $flightCode = (string) $flightArrival["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"];
                    /*if($flightCode === '3K' || $flightCode == 'BL')  {
                        unset($flight_results[$a]);
                        continue;
                    } else {*/
                        $arrivalFlightCodeArr{$a}[] = $flightCode;
                    /*}*/
                }

                if (count(array_unique($arrivalFlightCodeArr{$a})) === 1) {
                } else {
                    unset($flight_results[$a]);
                }
            } else {
                $flightCode = (string) $flightArrival["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];
                $arrivalFlightCodeArr{$a}[] = $flightCode;
                /*if($flightCode == '3K') {
                    unset($flight_results[$a]);
                    continue;
                }*/
            }



            /*if($flight_results[$a]["TPA_Extensions"]['ValidatingCarrier']['@attributes']['Code'] == '3K' ||
                $flight_results[$a]["TPA_Extensions"]['ValidatingCarrier']['@attributes']['Code'] == 'BL') {
                unset($flight_results[$a]);
            } else {*/
                /* check same flight only */
                /*  */
                $arrivalArr = array_unique($arrivalFlightCodeArr{$a});
                $departureArr = array_unique($departureFlightCodeArr{$a});

    /*          var_dump($departureArr);
                echo 'asdsada<br><br>';
                var_dump($arrivalArr);*/
                foreach ($arrivalArr as $arrivalFlightArrValue) {
                    if (!in_array($arrivalFlightArrValue, $departureArr)) {
                        unset($flight_results[$a]);
                        break;
                    }
                }
            /*}*/

        }

    }

    $flight_results = array_values($flight_results);

    $totalFlight = count($flight_results);

    $arrayFilterPrice = array();
    $arrayFilterTimeDeparture = array();
    $arrayFilterTransfer = array();
    $arrayFilterAirline = array();

    if( $totalFlight > 0 ) {
        $adultFare = array();
        $childFare = array();
        $infantFare = array();

        $adultTaxFare = array();
        $childTaxFare = array();
        $infantTaxFare = array();

        $tmpflightAdult = array();
        $tmpflightChild = array();
        $tmpflightInfant = array();

        for($a=0; $a<$totalFlight; $a++) {
            $tmpflightAdult[$a] = 0; $tmpflightChild[$a] = 0; $tmpflightInfant[$a] = 0;
            /* FILTER CLICK PRICE */
            $adultFare[$a]  = 0;
            $childFare[$a]  = 0;
            $infantFare[$a] = 0;

            $adultTaxFare[$a]  = 0;
            $childTaxFare[$a]  = 0;
            $infantTaxFare[$a]  = 0;
            $detailAirline[$a] = "";

            $priceInfo  = $flight_results[$a]["AirItineraryPricingInfo"]["ItinTotalFare"];
            $printEquiveFare = ceil($priceInfo["EquivFare"]["@attributes"]["Amount"]);
            $printTaxesFare  = ceil($priceInfo["Taxes"]["Tax"]["@attributes"]["Amount"]);
            //$totalFare = ceil($priceInfo["TotalFare"]["@attributes"]["Amount"]);
            //$printAdminFee   = ceil((($totalFare)*FLIGHT_ADMIN_PERCENT)/100);
            $totalFare = 0;

            if( isset($flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown'][0])) {
                /* there some other data beside adult */
                $PTCBreakDown = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown'];
                foreach($PTCBreakDown as $priceData) {
                    $passType = $priceData['PassengerTypeQuantity']['@attributes']['Code'];
                    $baseFareAmount = $priceData['PassengerFare']['BaseFare']['@attributes']['Amount'];
                    $taxFareAmount = $priceData['PassengerFare']['Taxes']['TotalTax']['@attributes']['Amount'];

                    $baseFareAmount = $baseFareAmount + ($baseFareAmount * (FLIGHT_ADMIN_PERCENT/100));
                    $taxFareAmount = $taxFareAmount + ($taxFareAmount * (FLIGHT_ADMIN_PERCENT/100));

                    if($passType == 'ADT') {
                        $tmpflightAdult[$a] += $priceData['PassengerTypeQuantity']['@attributes']['Quantity'];
                        $adultFare[$a] += ceil($baseFareAmount);
                        $adultTaxFare[$a] += ceil($taxFareAmount);
                        $totalFare += ($adultFare[$a] + $adultTaxFare[$a]);
                    }
                    else if($passType == 'CNN') {
                        $tmpflightChild[$a] += $priceData['PassengerTypeQuantity']['@attributes']['Quantity'];
                        $childFare[$a] += ceil($baseFareAmount);
                        $childTaxFare[$a] += ceil($taxFareAmount);
                        $totalFare += ($childFare[$a] + $childTaxFare[$a]);
                    }
                    else if($passType == 'INF') {
                        $tmpflightInfant[$a] += $priceData['PassengerTypeQuantity']['@attributes']['Quantity'];
                        $infantFare[$a] += ceil($baseFareAmount);
                        $infantTaxFare[$a] += ceil($taxFareAmount);
                        $totalFare += ($infantFare[$a] + $infantTaxFare[$a]);
                    }
                    else {

                    }
                }
                /* there is a chance that flight count children with seat as adult like malindo air, validate it */
            }
            else {
                $passType = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Code'];
                $baseFareAmount = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['BaseFare']['@attributes']['Amount'];
                $taxFareAmount = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['Taxes']['TotalTax']['@attributes']['Amount'];

                $baseFareAmount = $baseFareAmount + ($baseFareAmount * (FLIGHT_ADMIN_PERCENT/100));
                $taxFareAmount = $taxFareAmount + ($taxFareAmount * (FLIGHT_ADMIN_PERCENT/100));

                if($passType == 'ADT') {
                    $tmpflightAdult[$a] += $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Quantity'];
                    $adultFare[$a] += ceil($baseFareAmount);
                    $adultTaxFare[$a] += ceil($taxFareAmount);
                    $totalFare += ($adultFare[$a] + $adultTaxFare[$a]);
                }
                else if($passType == 'CNN') {
                    $tmpflightChild[$a] += $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Quantity'];
                    $childFare[$a] += ceil($baseFareAmount);
                    $childTaxFare[$a] +=  ceil($taxFareAmount);
                    $totalFare += ($childFare[$a] + $childTaxFare[$a]);
                }
                else if($passType == 'INF') {
                    $tmpflightInfant[$a] += $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Quantity'];
                    $infantFare[$a] += ceil($baseFareAmount);
                    $infantTaxFare[$a] += ceil($taxFareAmount);
                    $totalFare += ($infantFare[$a] + $infantTaxFare[$a]);
                }
            }

            if (
                $tmpflightAdult[$a] != $flightAdult &&
                $tmpflightChild[$a] != $flightChild
            ) {
                $detailAirline[$a] = "This airline consider child price as Adult price";
            } else if (
                $tmpflightAdult[$a] != $flightAdult &&
                $tmpflightInfant[$a] != $flightInfant
            ) {
                $detailAirline[$a] = "This airline consider infant price as Adult price";
            } else if (
                $tmpflightChild[$a] != $flightChild &&
                $tmpflightInfant[$a] != $flightInfant
            ) {
                $detailAirline[$a] = "This airline consider infant price as Child price";
            }

            $printGrandTotal = $totalFare;//+$printAdminFee;
            $arrayFilterPrice[$a] = $printGrandTotal;
            /* END OF FILTER CLICK PRICE */

            /*--FILTER TIME--*/
            if( isset($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"][0]) ) {
                $flightSegment = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"];
                $countFlightSegment = count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"]);
                $multiTransit = "YES";
                for( $fs=0; $fs<$countFlightSegment; $fs++ ) {
                    $departureTime = str_replace("T", " ", $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"][$fs]["@attributes"]["DepartureDateTime"]);
                    $departureTimeFormat = date("H:i:s", strtotime($departureTime));
                    $arrayFilterTimeDeparture[$a] = $departureTimeFormat;
                }
            }
            else {
                $departureTime = str_replace("T", " ", $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"]["@attributes"]["DepartureDateTime"]);
                $departureTimeFormat = date("H:i:s", strtotime($departureTime));
                $arrayFilterTimeDeparture[$a] = $departureTimeFormat;
            }

            /*--END OF FILTER TIME--*/

            /*--FILTER TRANSFER--*/
            if( isset($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"][0]) ) {
                $countFlightSegment = count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"]);
                $arrayFilterTransfer[$a] = $countFlightSegment-1;
            }
            else {
                $arrayFilterTransfer[$a] = "DIRECT";
            }
            /*--END OF FILTER TRANSFER--*/

            /* FILTER AIRLINES */
            if( isset($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"][0]) ) {
                $flightSegment = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"];
                $countFlightSegment = count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"]);
                $multiTransit = "YES";
                for( $fs=0; $fs<$countFlightSegment; $fs++ ) {
                    $fligtName = $this->Flight->getAirlinesNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"]);
                    $flightCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"];
                    $arrayFilterAirline[$flightCode] = '
                        <div style="float:left; margin-left:10px; margin-right:10px">
                            <img src="'.base_url().'assets/airlines_image/'.$flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"].'.gif" width="75" height="20" />
                        </div>
                        <div style="float:left">
                            <span style="font-size:13px"><b>'.$fligtName.'</b></span>
                        </div>
                    ';
                }
            }
            else {
                $fligtName  = $this->Flight->getAirlinesNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"]);
                $flightCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];
                $arrayFilterAirline[$flightCode] = '
                    <div style="float:left; margin-left:10px; margin-right:10px">
                        <img src="'.base_url().'assets/airlines_image/'.$flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"].'.gif" width="75" height="20" />
                    </div>
                    <div style="float:left">
                        <span style="font-size:13px"><b>'.$fligtName.'</b></span>
                    </div>
                ';
            }

            /* END OF FILTER AIRLINES */
        }
    }

    $printTaxesFare = 0;
    $printGrandTotal = 0;
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE   ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>CTC Travel | Search Flight Return Result</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css?12345" type="text/css" media="screen,projection,print" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/tipr/tipr.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/imageSlider/slider.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/newcruise.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/fontawesome.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/progress_bar/style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/typehead/css/typehead.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>assets/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>assets/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url(); ?>assets/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <style>
        .age_type {
            background: #f4f4f4;
            border: 1px solid #ddd;
            border-bottom: none;
            padding: 5px 10px;
            font-weight: bold;
        }
        .tab_container {
            border: 1px solid #ddd;
            padding: 0 10px 10px 10px;
            margin-bottom: 20px;
        }
        .form_div { margin: 20px 0 20px 0; } .traveller_info_form>div>div>div>div { width: 230px; float: left; font-weight: bold; }

        h5 { color: #F7941D !important; } .fontSizeAdjust { font-size: 15px }
        label.dropdown select {
            padding: 10px 42px 10px 10px;
            background: #f8f8f8;
            color: #444;
            border: 1px solid #aaa;
            border-radius: 0;
            display: inline-block;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            cursor: pointer;
            outline: none;
            height:40px;
            width:150px
        }
        label.dropdown select:-moz-focusring { color: transparent; text-shadow: 0 0 0 #444; }
        label.dropdown select::-ms-expand { display: none; }
        label.dropdown:before {
            content: '';
            right: 5px;
            top: -7px;
            width: 30px;
            height: 33px;
            position: absolute;
            pointer-events: none;
            display: block;
        }
        label.dropdown { position: relative; }
        label.dropdown:after {
            content: '>';
            font: 16px Consolas, monospace;
            color: #444;
            -webkit-transform: rotate(90deg);
            -moz-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            transform: rotate(90deg);
            right: 2px;
            top: -15px;
            /*border-bottom: 1px solid #aaa;*/
            position: absolute;
            pointer-events: none;
            width: 35px;
            padding: 0 0 5px 0;
            text-indent: 14px;
        }
        @media screen\0 { label.dropdown:after { width: 38px; text-indent: 15px; right: 0; } }
        @media screen and (min--moz-device-pixel-ratio:0) {
            label.dropdown select { padding-right: 40px; }
            label.dropdown:before { right: 6px; }
            label.dropdown:after {
                text-indent: 14px;
                right: 6px;
                top: -5px;
                width: 36px;
            }
        }
        .hideDiffAirline {
            display:none;
        }
        #divLoading {display : none;}
        .ui-icon-arrow-x {
            position: absolute;
            width: 13px;
            height: 10px;
            overflow: hidden;
            display: inline-block;
            cursor: pointer;
            color:#ffffff;
            background: url('<?php echo base_url();?>assets/images/ico/spinner.png') 0 0 no-repeat;
        }
        .spoil_c4 {
            padding: 10px;
        }
        .ui-icon-triangle-1 {
            position: absolute;
            top: 10px;
            right: 8px;
            background: url('<?php echo base_url();?>assets/images/ico/spinner.png') 0 0 no-repeat;
            width: 13px;
            height: 8px;
            overflow: hidden;
            text-indent: -99999px;
            display: inline-block;
            cursor: pointer;
        }

        .ui-icon-triangle-2 {
               position: absolute;
            top: 5px;
            right: 8px;
            background: url('<?php echo base_url();?>assets/images/ico/spinner.png') 0 -9px no-repeat;
            width: 13px;
            height: 8px;
            overflow: hidden;
            text-indent: -99999px;
            display: inline-block;
            cursor: pointer;
        }
        .quantity {
          position: relative;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button
        {
          -webkit-appearance: none;
          margin: 0;
          opacity: 0;
        }

        input[type=number]
        {
            padding-left: 10px;
            -moz-appearance: textfield;
        }

        .quantity input:focus {
          outline: 0;
        }

        .quantity-nav {
            height: 29px;
            position: absolute;
            top: 0;
            right: -5px;
        }

        .quantity-button {
          position: relative;
          cursor: pointer;
          width: 25px;
          text-align: center;
          color: #333;
          font-size: 13px;
          font-family: "Trebuchet MS", Helvetica, sans-serif !important;
          line-height: 1;
          -webkit-transform: translateX(-100%);
          transform: translateX(-100%);
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          -o-user-select: none;
          user-select: none;
        }

        .quantity-button.quantity-up {
          position: absolute;
          height: 50%;
          top: 0;
        }

        .quantity-button.quantity-down {
          position: absolute;
          bottom: -1px;
          height: 50%;
        }
    </style>
</head>
<body>
    <?php require_once(APPPATH."views/master-frontend/header.php"); ?>
    <?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
    <?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
    <?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>

    <div id="divLoading2" style="margin:0px; padding:0px; position:fixed; right:0px; top:0px; width:100%; height:100%; background-color: rgb(102, 102, 102); z-index:30001; opacity:0.8;">
        <p style="position:absolute; color:white; top:50%; left:40%; padding:0px">
            Processing Data.. Please wait
            <br />
            <img src="<?php echo base_url(); ?>assets/progress_bar/ajax-loader.gif" style="margin-top:5px">
        </p>
    </div>
    <div id="divLoading3" style="margin:0px; padding:0px; position:fixed; right:0px; top:0px; width:100%; height:100%; background-color: rgb(102, 102, 102); z-index:30001; opacity:0.8; display: none">
        <p style="position:absolute; color:white; top:50%; left:40%; padding:0px">
            Adding item to cart.. Please wait
            <br />
            <img src="<?php echo base_url(); ?>assets/progress_bar/ajax-loader.gif" style="margin-top:5px">
        </p>
    </div>

    <div class="main" role="main" style="display: none">
        <div class="wrap clearfix">
            <div class="content clearfix">

                <!--FLIGHT CHANGE SEARCH-->
                <div class="main-search" id="changeSearchContent" style="margin:0px; margin-bottom:50px; margin-top:20px; display:none">
                    <div class="search_container">
                        <div class="column radios">
                            <h4><span>01</span> What?</h4>
                            <div class="f-item">
                                <input type="radio" name="radio" id="flight" value="form3" checked />
                                <label for="flight">Flight</label>
                            </div>
                        </div>
                        <div class="forms">
                            <div class="form" id="form3">
                                <?php echo form_open_multipart('search/flight_result', array('class' => 'form-horizontal')); ?>
                                    <div class="column">
                                        <h4><span>02</span> Where?</h4>
                                        <div class="f-item" id="flight-leaving">
                                            <label for="destination3">From</label>
                                            <input type="hidden" name="flight_going_from" value="Singapore (SIN)" />
                                            <div style="font-size:15px; margin-bottom:14px"><b>Singapore (SIN)</b></div>
                                        </div>
                                        <div class="f-item" id="flight-going">
                                            <label for="destination4">To</label>
                                            <input type="text" class="typeahead" placeholder="City, region, or district" name="flight_going_to" id="flight_destination" value="<?php echo $input_going_to; ?>" required style="width:230px; height:16px" />
                                        </div>
                                    </div>
                                    <div class="column twins">
                                        <h4><span>03</span> When?</h4>
                                        <div class="f-item" style="width:100%">
                                            <label for="destination4">Flight Type</label>
                                            <div style="margin-top:3px">
                                                <?php
                                                if( $input_flight_type == "one_way" ) {
                                                ?>
                                                    <div style="float:left">
                                                        <input type="radio" name="radioType" class="choiceFlightType" id="radioFlightType" checked value="one_way" /> &nbsp;
                                                    </div>
                                                    <div style="float:left; margin-right:15px">
                                                        <span style="font-size: 14px"><b>One-way</b></span>
                                                    </div>
                                                    <div style="float:left">
                                                        <input type="radio" name="radioType" class="choiceFlightType" id="radioFlightType" value="return" /> &nbsp;
                                                    </div>
                                                    <div style="float:left">
                                                        <span style="font-size: 14px"><b>Return</b></span>
                                                    </div>
                                                <?php
                                                }
                                                else {
                                                ?>
                                                    <div style="float:left">
                                                        <input type="radio" name="radioType" class="choiceFlightType" id="radioFlightType" value="one_way" /> &nbsp;
                                                    </div>
                                                    <div style="float:left; margin-right:15px">
                                                        <span style="font-size: 14px"><b>One-way</b></span>
                                                    </div>
                                                    <div style="float:left">
                                                        <input type="radio" name="radioType" class="choiceFlightType" id="radioFlightType" checked value="return" /> &nbsp;
                                                    </div>
                                                    <div style="float:left">
                                                        <span style="font-size: 14px"><b>Return</b></span>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <div style="clear:both"></div>
                                            </div>
                                        </div>
                                        <div style="height:67px">&nbsp;</div>
                                        <div class="f-item" id="checkin_flight">
                                            <label for="datepicker1">Departure</label>
                                            <div class="datepicker-wrap">
                                                <input type="text" id="datepickerFlightCheckIn" name="datepicker6" value="<?php echo $input_check_in; ?>" required readonly />
                                            </div>
                                        </div>
                                        <div class="f-item" id="checkout_flight">
                                            <label for="datepicker2">Return</label>
                                            <div class="datepicker-wrap">
                                                <input type="text" id="datepickerFlightCheckOut" name="datepicker7" value="<?php echo $input_check_out; ?>" required readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column triplets">
                                        <h4><span>04</span> Who?</h4>
                                        <div class="f-item">
                                            <label for="flightAdult">Adult(s)</label>
                                            <div class="quantity">
                                                <input type="number" min="1" max="7" step="1" id="flightAdult" name="flightAdult"  title="Above Age 12" value="1" autocomplete="off" data-val="1">
                                            </div>
                                            <!-- <select name="flightAdult" id="flightAdult">
                                                <?php
                                                for($a=1; $a<=5; $a++) {
                                                    if( $flightAdult == $a ) {
                                                ?>
                                                    <option value="<?php echo $a; ?>" SELECTED><?php echo $a; ?></option>
                                                <?php
                                                    }
                                                    else {
                                                ?>
                                                    <option value="<?php echo $a; ?>"><?php echo $a; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select> -->
                                        </div>
                                        <div class="f-item">
                                            <label for="flightChild">Child(s)</label>
                                            <div class="quantity">
                                                <input type="number" min="0" max="6" step="1" id="flightChild" name="flightChild"  title="Age 2-12" value="0" data-val="0">
                                            </div>
                                            <!-- <select name="flightChild" id="flightChild">
                                                <?php
                                                for($c=0; $c<=5; $c++) {
                                                    if( $flightChild == $c ) {
                                                ?>
                                                    <option value="<?php echo $c; ?>" SELECTED><?php echo $c; ?></option>
                                                <?php
                                                    }
                                                    else {
                                                ?>
                                                    <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select> -->
                                        </div>
                                        <div class="f-item">
                                            <label for="flightInfant">Infant(s)</label>
                                            <div class="quantity">
                                                <input type="number" min="0" max="4" step="1" id="flightInfant" name="flightInfant"  title="below Age 2" value="0" data-val="0">
                                            </div>
                                            <!-- <select name="flightInfant" id="flightInfant">
                                                <?php
                                                for($i=0; $i<=5; $i++) {
                                                    if( $flightInfant == $i ) {
                                                ?>
                                                    <option value="<?php echo $i; ?>" SELECTED><?php echo $i; ?></option>
                                                <?php
                                                    }
                                                    else {
                                                ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select> -->
                                        </div>
                                        <div class="f-item hidden-arrow" style="width: 240px; display: none; position: relative">
                                            <div class="ui-icon ui-icon-arrow-x show-on-adult" style="display: none; left:35px"></div>
                                            <div class="ui-icon ui-icon-arrow-x show-on-child" style="display: none; left:110px"></div>
                                            <div class="ui-icon ui-icon-arrow-x show-on-infant" style="display: none; left:200px"></div>
                                            <div style="background: #FFFFFF; position: absolute; width: 242px; border: 1px solid #ccc; height: 22px; z-index: 5; top:6px" class="spoil_c4">
                                                aa
                                            </div>
                                        </div>

                                        <div class="f-item" style="width:95%" id="checkout_flight">
                                            <label for="datepicker2">Class</label>
                                            <select name="flightClass" id="flightClass">
                                                <?php
                                                if( $flightClass == "Y" ) {
                                                ?>
                                                    <option value="Y" SELECTED>Economy Class</option>
                                                    <option value="S">Premium Economy Class</option>
                                                    <option value="C">Business Class</option>
                                                    <option value="J">Premium Business Class</option>
                                                    <option value="F">First Class</option>
                                                    <option value="P">Premium First Class</option>
                                                <?php
                                                }
                                                else if( $flightClass == "S" ) {
                                                ?>
                                                    <option value="Y">Economy Class</option>
                                                    <option value="S" SELECTED>Premium Economy Class</option>
                                                    <option value="C">Business Class</option>
                                                    <option value="J">Premium Business Class</option>
                                                    <option value="F">First Class</option>
                                                    <option value="P">Premium First Class</option>
                                                <?php
                                                }
                                                else if( $flightClass == "C" ) {
                                                ?>
                                                    <option value="Y">Economy Class</option>
                                                    <option value="S">Premium Economy Class</option>
                                                    <option value="C" SELECTED>Business Class</option>
                                                    <option value="J">Premium Business Class</option>
                                                    <option value="F">First Class</option>
                                                    <option value="P">Premium First Class</option>
                                                <?php
                                                }
                                                else if( $flightClass == "J" ) {
                                                ?>
                                                    <option value="Y">Economy Class</option>
                                                    <option value="S">Premium Economy Class</option>
                                                    <option value="C">Business Class</option>
                                                    <option value="J" SELECTED>Premium Business Class</option>
                                                    <option value="F">First Class</option>
                                                    <option value="P">Premium First Class</option>
                                                <?php
                                                }
                                                else if( $flightClass == "F" ) {
                                                ?>
                                                    <option value="Y">Economy Class</option>
                                                    <option value="S">Premium Economy Class</option>
                                                    <option value="C">Business Class</option>
                                                    <option value="J">Premium Business Class</option>
                                                    <option value="F" SELECTED>First Class</option>
                                                    <option value="P">Premium First Class</option>
                                                <?php
                                                }
                                                else if( $flightClass == "P" ) {
                                                ?>
                                                    <option value="Y">Economy Class</option>
                                                    <option value="S">Premium Economy Class</option>
                                                    <option value="C">Business Class</option>
                                                    <option value="J">Premium Business Class</option>
                                                    <option value="F">First Class</option>
                                                    <option value="P" SELECTED>Premium First Class</option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="submit" value="Proceed to results" class="search-submit" id="search_submit_flight" />
                                <?php echo form_close(); ?>
                                <!--LOADING GIF-->
                                <div id="divLoading" style="margin:0px; padding:0px; position:fixed; right:0px; top:0px; width:100%; height:100%; background-color: rgb(102, 102, 102); z-index:30001; opacity:0.8;">
                                    <p style="position:absolute; color:white; top:50%; left:40%; padding:0px">
                                        Searching for flight...Please wait...
                                        <br />
                                        <img src="<?php echo base_url(); ?>assets/progress_bar/ajax-loader.gif" style="margin-top:5px">
                                    </p>
                                </div>
                                <!--END OF LOADING GIF-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--END OF FLIGHT CHANGE SEARCH-->

                <!--BREADCUMBS-->
                <nav role="navigation" class="breadcrumbs clearfix">
                    <ul class="crumbs">
                        <li>
                            <a href="#" style="font-size:16px; background:none">
                                <b>
                                    Pax Statement:
                                    <?php echo $flightAdult; ?> Adult(s),
                                    <?php echo $flightChild; ?> Child(s),
                                    <?php echo $flightInfant; ?> Infant(s)
                                    -
                                    <?php
                                    if( $flightClass == "Y" ) { echo "Economy Class"; }
                                    else if( $flightClass == "S" ) { echo "Premium Economy Class"; }
                                    else if( $flightClass == "C" ) { echo "Business Class"; }
                                    else if( $flightClass == "J" ) { echo "Premium Business Class"; }
                                    else if( $flightClass == "F" ) { echo "First Class"; }
                                    else if( $flightClass == "P" ) { echo "Premium First Class"; }
                                    ?>
                                </b>
                            </a>
                        </li>
                    </ul>
                    <ul class="top-right-nav">
                        <li><a href="#" id="changeSearchAnchor" title="Change search">Change search</a></li>
                    </ul>
                </nav>
                <!--END OF BREADCUMBS-->

                <!--CONTENT-->
                <section class="full-width">
                    <div class="deals clearfix flights">
                        <!--Departure-->
                        <div style="float:left; width:100%; margin-right:50px">
                            <article class="one-half" style="padding:20px; width:100%">
                                <div class="sort-by" style="background-color:#1ba0e2">
                                    <div style="float:left; display:block; color:white; padding:20px; font-size:13px; margin-top:-5px">
                                        <b>
                                            Departure Flight: <?php echo date("l, F d, Y", strtotime($input_check_in)); ?>,
                                            Singapore to <?php echo $to_city; ?>
                                         </b>
                                    </div>
                                </div>
                                <div class="sort-by" style="background-color:#1ba0e2">
                                    <div style="float:left; display:block; color:white; padding:20px; font-size:13px; margin-top:-5px">
                                        <b>Filter result by</b>
                                    </div>
                                    <ul class="sort" style="border-right:none">
                                        <div style="margin-top:-3px">
                                            <a href="#" id="priceFilterBtn" class="gradient-button" style="border:none">Price</a>
                                            &nbsp;&nbsp;
                                            <a href="#" id="transferFilterBtn" class="gradient-button" style="border:none">Transfer</a>
                                            &nbsp;&nbsp;
                                            <a href="#" id="airlineFilterBtn" class="gradient-button" style="border:none">Airline</a>
                                            &nbsp;&nbsp;
                                            <a href="#" id="timeFilterBtn" class="gradient-button" style="border:none">Time</a>
                                        </div>
                                    </ul>
                                </div>
                                <div class="sort-by" style="background-color:#fafafa; height: 85px" id="priceFilterContent">
                                    <div style="display:block; color:black; padding:20px; font-size:13px; margin-top:-5px">
                                        <div style="text-align:center">
                                            <b>Filter flight ticket price by dragging the slider below</b>
                                        </div>
                                        <div style="text-align:center">
                                            <label for="amountDeparture">Show flight ticket price below:</label>
                                            <br />
                                            <span id="amountDeparture"></span>
                                        </div>
                                        <div id="sliderPriceDeparture" style="margin-top:5px"></div>

                                    </div>
                                </div>
                                <div class="sort-by" style="background-color:#fafafa; height:auto" id="transferFilterContent">
                                    <div style="color:black; padding:20px; font-size:13px; margin-top:-5px">
                                        <div style="margin-right:40px">
                                            <div style="margin-bottom:10px">No. of transfer</div>
                                            <div style="margin-bottom:5px; float:left; margin-right:30px">
                                                <input type="checkbox" name="flightTransfer[]" id="flightTransferDirectAD" value="DIRECT" checked /> &nbsp;&nbsp;Direct
                                            </div>
                                            <div style="margin-bottom:5px; float:left; margin-right:30px">
                                                <input type="checkbox" name="flightTransfer[]" id="flightTransferA1" value="1" checked /> &nbsp;&nbsp;1 Transfer
                                            </div>
                                            <div style="margin-bottom:5px; float:left; margin-right:30px">
                                                <input type="checkbox" name="flightTransfer[]" id="flightTransferA2" value="2" checked /> &nbsp;&nbsp;2 Transfers
                                            </div>
                                            <div style="margin-bottom:5px; float:left; margin-right:30px">
                                                <input type="checkbox" name="flightTransfer[]" id="flightTransferA3" value="3" checked /> &nbsp;&nbsp;3 Transfers
                                            </div>
                                            <div style="clear:both"></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="sort-by" style="background-color:#fafafa; height:auto" id="airlineFilterContent">
                                    <div style="color:black; padding:20px; font-size:13px; margin-top:-5px">
                                        <?php
                                        if( count($arrayFilterAirline) > 0 ) {
                                            foreach( $arrayFilterAirline AS $keyA => $valueA ) {
                                        ?>
                                        <div style="float:left; width:30%; margin-bottom:5px; margin-right:5px">
                                            <div>
                                                <div style="float:left; margin-top:2px">
                                                    <input type="checkbox" name="flightCodeD[]" id="flightCodeCKD<?php echo $keyA; ?>" value="<?php echo $keyA; ?>" checked />
                                                </div>
                                                <?php echo $valueA; ?>
                                                <div style="clear:both"></div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <div style="clear:both"></div>
                                    </div>
                                </div>
                                <div class="sort-by" style="background-color:#fafafa; height:auto" id="timeFilterContent">
                                    <div style="color:black; padding:20px; font-size:13px; margin-top:-5px">
                                        <div style="float:left; width:23%; margin-bottom:5px; margin-right:5px">
                                            <div>
                                                <div style="float:left; margin-top:2px; margin-right:5px">
                                                    <input type="checkbox" name="name" id="flightTimeCK4D" value="04001100" checked/>
                                                </div>
                                                <div style="float:left">
                                                    <span style="font-size:13px"><b>04:00 - 11:00</b></span>
                                                </div>
                                                <div style="clear:both"></div>
                                            </div>
                                        </div>
                                        <div style="float:left; width:23%; margin-bottom:5px; margin-right:5px">
                                            <div>
                                                <div style="float:left; margin-top:2px; margin-right:5px">
                                                    <input type="checkbox" name="name" id="flightTimeCK11D" value="11001500" checked/>
                                                </div>
                                                <div style="float:left">
                                                    <span style="font-size:13px"><b>11:00 - 15:00</b></span>
                                                </div>
                                                <div style="clear:both"></div>
                                            </div>
                                        </div>
                                        <div style="float:left; width:23%; margin-bottom:5px; margin-right:5px">
                                            <div>
                                                <div style="float:left; margin-top:2px; margin-right:5px">
                                                    <input type="checkbox" name="name" value="" id="flightTimeCK15D" value="15001830"  checked/>
                                                </div>
                                                <div style="float:left">
                                                    <span style="font-size:13px"><b>15:00 - 18:30</b></span>
                                                </div>
                                                <div style="clear:both"></div>
                                            </div>
                                        </div>
                                        <div style="float:left; width:23%; margin-bottom:5px; margin-right:5px">
                                            <div>
                                                <div style="float:left; margin-top:2px; margin-right:5px">
                                                    <input type="checkbox" name="name" id="flightTimeCK18D" value="18300400" checked/>
                                                </div>
                                                <div style="float:left">
                                                    <span style="font-size:13px"><b>18:30 - 04:00</b></span>
                                                </div>
                                                <div style="clear:both"></div>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                </div>
                                <!--LOOP HERE-->
                                <?php
                                if( $totalFlight > 0 )
                                {
                                    for($a=0; $a<$totalFlight; $a++)
                                    {
                                        $printGrandTotal = 0;
										$printTaxesFare = 0;
                                        $flightDeparture = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0];

                                        $flightArrival = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][1];

                                        $codeID = '';
                                        if(isset($flightDeparture["FlightSegment"][0]))  {
                                            $codeID = $flightDeparture["FlightSegment"][0]["OperatingAirline"]["@attributes"]["Code"];
                                        } else {
                                            $codeID = $flightDeparture["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];
                                        }
                                ?>
                                    <div class="details flightListNoD<?php echo $a; ?> showPrice showTransfer showAirline showTime filterFlight"
                                         id="filterAirlineD<?php echo $codeID; ?>" data-idxfl="<?php echo $a;?>">
                                         <div style="width:46%; float:left; margin-right:5px; padding: 10px; padding-bottom: 0; border-right: 2px outset" class="departureFlight">
                                         <h4>Departure from Singapore</h4>
                                        <?php

                                        $ctrFLight = 0;
                                        if( isset($flightDeparture["FlightSegment"][0]) )
                                        {
                                            /* multi departure */
                                            $flightSegment = $flightDeparture["FlightSegment"];
                                            $countFlightSegment = count($flightDeparture["FlightSegment"]);
                                            $multiTransit = "YES";
                                            for( $fs=0; $fs<$countFlightSegment; $fs++ )
                                            {
                                                $ctrFLight++;
                                        ?>
                                                <!--TRANSIT MODE-->
                                                <table style="width:100%">
                                                    <tr>
                                                        <td style="text-align:left" colspan="4">

                                                            <div>
                                                                <div style="float:left; margin-right:10px">
                                                                    <img src="<?php echo base_url(); ?>assets/airlines_image/<?php echo $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"]; ?>.gif" width="80" height="30" />
                                                                </div>
                                                                <div style="float:left">
                                                                    <span style="font-size:15px">
                                                                        <?php
                                                                        $flightNameArr[] = $this->Flight->getAirlinesNameBasedOnCode($flightDeparture["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"]);
                                                                        $flightCodeArr[] = $flightDeparture["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"];
                                                                        $flightOperatingAirlineArr[] = $flightDeparture["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["FlightNumber"];
                                                                        /* new addition 7.3.2017 bto */
                                                                        $flightResBookDesigCodeArr[] = $flightDeparture["FlightSegment"][$fs]["@attributes"]['ResBookDesigCode'];
                                                                        $flightAirEquipTypeArr[] = $flightDeparture["FlightSegment"][$fs]['Equipment']['@attributes']['AirEquipType'];
                                                                        $flightMarriageGrpArr[] = $flightDeparture["FlightSegment"][$fs]['MarriageGrp'];
                                                                        $flightETicketArr[] = $flightDeparture["FlightSegment"][$fs]['TPA_Extensions']['eTicket']['@attributes']['Ind'];

                                                                        //passing data
                                                                        $fligtNamePassing = implode("~", $flightNameArr);
                                                                        $fligtCodePassing = implode("~", $flightCodeArr);
                                                                        $fligtOperatingAirlinePassing = implode("~", $flightOperatingAirlineArr);
                                                                        //end of passing data

                                                                        $fligtName = $this->Flight->getAirlinesNameBasedOnCode($flightDeparture["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"]);
                                                                        $flightCode = $flightDeparture["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"];
                                                                        $flightCodeFilter = $flightDeparture["FlightSegment"][0]["OperatingAirline"]["@attributes"]["Code"];
                                                                        $flightOperatingAirline = $flightDeparture["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["FlightNumber"];
                                                                        $flightResBookDesigCode = $flightDeparture["FlightSegment"][$fs]["@attributes"]['ResBookDesigCode'];
                                                                        $flightAirEquipType = $flightDeparture["FlightSegment"][$fs]['Equipment']['@attributes']['AirEquipType'];
                                                                        $flightMarriageGrp = $flightDeparture["FlightSegment"][$fs]['MarriageGrp'];
                                                                        $flightETicket = $flightDeparture["FlightSegment"][$fs]['TPA_Extensions']['eTicket']['@attributes']['Ind'];

                                                                        /* 22 mei 2017 */
                                                                        $flightTerminal_from = $flightDeparture["FlightSegment"][$fs]['DepartureAirport']['@attributes']['TerminalID'];
                                                                        $flightTimezone_from = $flightDeparture["FlightSegment"][$fs]['DepartureTimeZone']['@attributes']['GMTOffset'];
                                                                        $flightTerminal_to = $flightDeparture["FlightSegment"][$fs]['ArrivalAirport']['@attributes']['TerminalID'];
                                                                        $flightTimezone_to = $flightDeparture["FlightSegment"][$fs]['ArrivalTimeZone']['@attributes']['GMTOffset'];


                                                                        //passing data
                                                                        $passing_flightName = $fligtNamePassing;
                                                                        $passing_flightCode = $fligtCodePassing;
                                                                        $passing_flightOperatingAirline = $fligtOperatingAirlinePassing;
                                                                        $passing_flightresbookdesigncode = $flightResBookDesigCodePassing;
                                                                        $passing_flightairequiptype = $flightAirEquipTypePassing;
                                                                        $passing_flightmarriagegrp = $flightMarriageGrpPassing;
                                                                        $passing_flighteticket = $flightETicketPassing;
                                                                        //end of passing data

                                                                        //passing data to jquery
                                                                        $DdepartureFlightNameArr{$a}[] = $fligtName;
                                                                        $DdepartureFlightName  = implode("~", $DdepartureFlightNameArr{$a});
                                                                        $DdepartureFlightCodeArr{$a}[] = $flightCode.' '.$flightOperatingAirline;
                                                                        $DdepartureFlightCode  = implode("~", $DdepartureFlightCodeArr{$a});
                                                                        //end pf passing data to jquery

                                                                        /* new addition 7.3.2017 bto */
                                                                        $departureFlightResBookDesigCodeArr{$a}[] = $flightResBookDesigCode;
                                                                        $departureFlightResBookDesigCode  = implode("~", $departureFlightResBookDesigCodeArr{$a});
                                                                        $departureFlightAirEquipTypeArr{$a}[] = $flightAirEquipType;
                                                                        $departureFlightAirEquipType  = implode("~", $departureFlightAirEquipTypeArr{$a});

                                                                        $departureFlightMarriageGrpArr{$a}[] = $flightMarriageGrp;
                                                                        $departureFlightMarriageGrp  = implode("~", $departureFlightMarriageGrpArr{$a});

                                                                        $departureFlightEticketArr{$a}[] = $flightETicket;
                                                                        $departureFlightETicket  = implode("~", $departureFlightEticketArr{$a});

                                                                        /* 22 mei 2017 */
                                                                        $departureTerminalIDArr_from{$a}[] = $flightTerminal_from;
                                                                        $departureTerminalID_from = implode("~", $departureTerminalIDArr_from{$a});

                                                                        $departureTerminalIDArr_to{$a}[] = $flightTerminal_to;
                                                                        $departureTerminalID_to = implode("~", $departureTerminalIDArr_to{$a});

                                                                        $departureTimezoneArr_from{$a}[] = $flightTimezone_from;
                                                                        $departureTimezone_from = implode("~", $departureTimezoneArr_from{$a});

                                                                        $departureTimezoneArr_to{$a}[] = $flightTimezone_to;
                                                                        $departureTimezone_to = implode("~", $departureTimezoneArr_to{$a});

                                                                        ?>
                                                                        <b>
                                                                            <?php echo $fligtName; ?> (<?php echo $flightCode; ?> <?php echo $flightOperatingAirline; ?>)
                                                                        </b>
                                                                        <?php
                                                                        if( count($DdepartureFlightNameArr{$a}) == 1 ) {
                                                                        ?>
                                                                            &nbsp;&nbsp;
                                                                            <span style="text-align:center; background-color:#1ba0e2; padding:5px; width:200px">
                                                                                <a href="#" style="color:white; font-size:16px; font-weight:bold; text-decoration:none; text-align:center">
                                                                                    Indirect&nbsp;
                                                                                </a>
                                                                            </span>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                                <div style="clear:both"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr><td>&nbsp;</td></tr>
                                                    <tr>
                                                        <?php
                                                        $departureTime = str_replace("T", " ", $flightDeparture["FlightSegment"][$fs]["@attributes"]["DepartureDateTime"]);
                                                        $arrivalTime   = str_replace("T", " ", $flightDeparture["FlightSegment"][$fs]["@attributes"]["ArrivalDateTime"]);
                                                        $departureTimeArr[] = str_replace("T", " ", $flightDeparture["FlightSegment"][$fs]["@attributes"]["DepartureDateTime"]);
                                                        $arrivalTimeArr[] = str_replace("T", " ", $flightDeparture["FlightSegment"][$fs]["@attributes"]["ArrivalDateTime"]);
                                                        $departureAirportCodeArr[] = $flightDeparture["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"];
                                                        $arrivalAirportCodeArr[] = $flightDeparture["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"];
                                                        //passing data
                                                        $departureTimePassing = implode("~", $departureTimeArr);
                                                        $arrivalTimePassing   = implode("~", $arrivalTimeArr);
                                                        $departureAirportCodePassing = implode("~", $departureAirportCodeArr);
                                                        $arrivalAirportCodePassing   = implode("~", $arrivalAirportCodeArr);
                                                        //end of passing data
                                                        //passing data
                                                        $passing_departureTime        = $departureTimePassing;
                                                        $passing_arrivalTime          = $arrivalTimePassing;
                                                        $passing_departureAirportCode = $departureAirportCodePassing;
                                                        $passing_arrivalAirportCode   = $arrivalAirportCodePassing;
                                                        //end of passing data
                                                        //passing data to jquery
                                                        $DdepartureDateArr{$a}[] = date("Y-m-d", strtotime($departureTime));
                                                        $DdepartureDate          = implode("~", $DdepartureDateArr{$a});
                                                        $DdepartureTimeArr{$a}[] = date("H:i:s", strtotime($departureTime));
                                                        $DdepartureTime          = implode("~", $DdepartureTimeArr{$a});
                                                        $DarrivalDateArr{$a}[]   = date("Y-m-d", strtotime($arrivalTime));
                                                        $DarrivalDate            = implode("~", $DarrivalDateArr{$a});
                                                        $DarrivalTimeArr{$a}[]   = date("H:i:s", strtotime($arrivalTime));
                                                        $DarrivalTime            = implode("~", $DarrivalTimeArr{$a});
                                                        //end pf passing data to jquery
                                                        ?>
                                                        <td style="text-align:left; padding-right:10px; width:30%">
                                                            <div style="font-size:13px"><b><?php echo date("Y F d, H:i:s", strtotime($departureTime)); ?></b></div>
                                                            <div style="font-size:13px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flightDeparture["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $flightDeparture["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]; ?>)</b></div>
                                                            <div style="font-size:13px">
                                                                <b>Airport: <?php echo $this->Flight->getAirportNameBasedOnCode($flightDeparture["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]); ?></b>
                                                            </div>
                                                            <?php
                                                            //passing data to jquery
                                                            $DdepartureCityNameFromArr{$a}[] = $this->Flight->getCityNameBasedOnCode($flightDeparture["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]);
                                                            $DdepartureCityNameFrom      = implode("~", $DdepartureCityNameFromArr{$a});
                                                            $DdepartureCityCodeFromArr{$a}[] = $flightDeparture["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"];
                                                            $DdepartureCityCodeFrom      = implode("~", $DdepartureCityCodeFromArr{$a});
                                                            $DdepartureAirportFromArr{$a}[]  = $this->Flight->getAirportNameBasedOnCode($flightDeparture["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]);
                                                            $DdepartureAirportFrom       = implode("~", $DdepartureAirportFromArr{$a});
                                                            //end pf passing data to jquery
                                                            ?>
                                                        </td>
                                                        <td style="text-align:left; padding-right:10px; width:30%">
                                                            <div style="font-size:13px"><b><?php echo date("Y F d, H:i:s", strtotime($arrivalTime)); ?></b></div>
                                                            <div style="font-size:13px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flightDeparture["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $flightDeparture["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]; ?>)</b></div>
                                                            <div style="font-size:13px">
                                                                <b>Airport: <?php echo $this->Flight->getAirportNameBasedOnCode($flightDeparture["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]); ?></b>
                                                            </div>
                                                            <?php
                                                            //passing data to jquery
                                                            $DdepartureCityNameToArr{$a}[] = $this->Flight->getCityNameBasedOnCode($flightDeparture["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]);
                                                            $DdepartureCityNameTo      = implode("~", $DdepartureCityNameToArr{$a});
                                                            $DdepartureCityCodeToArr{$a}[] = $flightDeparture["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"];
                                                            $DdepartureCityCodeTo      = implode("~", $DdepartureCityCodeToArr{$a});
                                                            $DdepartureAirportToArr{$a}[]  = $this->Flight->getAirportNameBasedOnCode($flightDeparture["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]);
                                                            $DdepartureAirportTo       = implode("~", $DdepartureAirportToArr{$a});
                                                            //end pf passing data to jquery
                                                            ?>
                                                        </td>
                                                        <td style="text-align:left; padding-right:10px; width:20%">
                                                            <?php
                                                            $timeTaken = $flightDeparture["FlightSegment"][$fs]["@attributes"]["ElapsedTime"];
                                                            $timeTakenArr[] = $flightDeparture["FlightSegment"][$fs]["@attributes"]["ElapsedTime"];
                                                            //passing data
                                                            $timeTakenPassing = implode("~", $timeTakenArr);
                                                            //end of passing data
                                                            //passing data
                                                            $passing_timeTaken = $timeTakenPassing;
                                                            //end of passing data
                                                            //passing data to jquery
                                                            $DdepartureTimeTakenArr{$a}[] = $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes');
                                                            $DdepartureTimeTaken      = implode("~", $DdepartureTimeTakenArr{$a});
                                                            //end pf passing data to jquery
                                                            ?>
                                                            <div style="font-size:13px"><b>Flight Time taken</b></div>
                                                            <div style="font-size:13px; color:green">
                                                                <b><?php echo $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes'); ?></b>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr><td>&nbsp;</td></tr>
                                                    <tr>
                                                        <?php
                                                        if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {

                                                                $PTCBreakDown = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown'];
                                                                foreach($PTCBreakDown as $priceData) {
                                                                    $passType = $priceData['PassengerTypeQuantity']['@attributes']['Code'];

                                                                    if($passType == 'ADT') {
                                                                        $adultFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][$fs];

                                                                        if(count($adultFareBasisCode[$a]) > 1) {
                                                                            $adultFareBasisCode[$a] = array_unique($adultFareBasisCode[$a]);
                                                                            if(count($adultFareBasisCode[$a]) > 1) {
                                                                                $adultFareBasisCode[$a] = implode(",", $adultFareBasisCode[$a]);
                                                                            } else {
                                                                                $adultFareBasisCode[$a] = $adultFareBasisCode[$a][0];
                                                                            }
                                                                        }
                                                                        $DdepartureFareBasisCodeArr{$a}[] = $adultFareBasisCode[$a];
                                                                    }
                                                                    else if($passType == 'CNN') {

                                                                        $childFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][$fs];

                                                                        if(count($childFareBasisCode[$a]) > 1) {
                                                                            $childFareBasisCode[$a] = array_unique($childFareBasisCode[$a]);
                                                                            if(count($childFareBasisCode[$a]) > 1) {
                                                                                $childFareBasisCode[$a] = implode(",", $childFareBasisCode[$a]);
                                                                            } else {
                                                                                $childFareBasisCode[$a] = $childFareBasisCode[$a][0];
                                                                            }
                                                                        }

                                                                        $DdepartureFareBasisCodeChildArr{$a}[] = $childFareBasisCode[$a];

                                                                    }
                                                                    else if($passType == 'INF') {

                                                                        $infantFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][$fs];

                                                                        if(count($infantFareBasisCode[$a]) > 1) {
                                                                            $infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
                                                                            if(count($infantFareBasisCode[$a]) > 1) {
                                                                                $infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
                                                                            } else {
                                                                                $infantFareBasisCode[$a] = $infantFareBasisCode[$a][0];
                                                                            }
                                                                        }
                                                                        $DdepartureFareBasisCodeInfantArr{$a}[] = $infantFareBasisCode[$a];
                                                                    }
                                                                }

                                                            if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]['Pieces'])) {
                                                                $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
                                                            } else {
                                                                $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Weight"]." ".$flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Unit"];
                                                            }
                                                        } else {
                                                            $passType = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Code'];
                                                            if ($passType == 'ADT') {
                                                                $adultFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][$fs];

                                                                if(count($adultFareBasisCode[$a]) > 1) {
                                                                    $adultFareBasisCode[$a] = array_unique($adultFareBasisCode[$a]);
                                                                    if(count($adultFareBasisCode[$a]) > 1) {
                                                                        $adultFareBasisCode[$a] = implode(",", $adultFareBasisCode[$a]);
                                                                    } else {
                                                                        $adultFareBasisCode[$a] = $adultFareBasisCode[$a][0];
                                                                    }
                                                                }
                                                                $DdepartureFareBasisCodeArr{$a}[] = $adultFareBasisCode[$a];
                                                            } else if ($passType == 'CNN') {
                                                                $childFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][$fs];

                                                                if(count($childFareBasisCode[$a]) > 1) {
                                                                    $childFareBasisCode[$a] = array_unique($childFareBasisCode[$a]);
                                                                    if(count($childFareBasisCode[$a]) > 1) {
                                                                        $childFareBasisCode[$a] = implode(",", $childFareBasisCode[$a]);
                                                                    } else {
                                                                        $childFareBasisCode[$a] = $childFareBasisCode[$a][0];
                                                                    }
                                                                }
                                                                $DdepartureFareBasisCodeChildArr{$a}[] = $childFareBasisCode[$a];
                                                            } else {
                                                                $infantFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][$fs];

                                                                if(count($infantFareBasisCode[$a]) > 1) {
                                                                    $infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
                                                                    if(count($infantFareBasisCode[$a]) > 1) {
                                                                        $infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
                                                                    } else {
                                                                        $infantFareBasisCode[$a] = $infantFareBasisCode[$a][0];
                                                                    }
                                                                }
                                                                $DdepartureFareBasisCodeInfantArr{$a}[] = $infantFareBasisCode[$a];
                                                            }

                                                            if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]['Pieces'])) {
                                                                $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
                                                            } else {
                                                                $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Weight"]." ".$flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Unit"];
                                                            }
                                                        }

                                                        $baggageArr[] = $baggage;
                                                        ?>
                                                        <td style="text-align:left; padding-right:10px; width:30%">
                                                            <div style="font-size:13px">
                                                                <span style="color:green">
                                                                    <b>Baggage: <?php echo $baggage; ?></b>
                                                                    <?php
                                                                    //passing data to jquery
                                                                    $DdepartureBaggageArr{$a}[] = $baggage;
                                                                    $DdepartureBaggage      = implode("~", $DdepartureBaggageArr{$a});
                                                                    //end pf passing data to jquery
                                                                    ?>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td style="text-align:left; padding-right:10px; width:30%">
                                                            <div style="font-size:13px">
                                                                <span style="color:green">
                                                                    <b>
                                                                        Meal:
                                                                        <?php
                                                                        $mealCode = "-";
                                                                        /* for case adult, infant child, we take just index 0, just the parent baggage */
                                                                        if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {
                                                                            if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["FareInfos"]["FareInfo"][($ctrFLight-1)]["TPA_Extensions"]['Meal']) ) {
                                                                                $mealCode =$flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["FareInfos"]["FareInfo"][($ctrFLight-1)]["TPA_Extensions"]['Meal']['@attributes']['Code'];
                                                                                $meal = "YES";
                                                                                echo "YES";
                                                                            }
                                                                            else {
                                                                                $mealCode = "-";
                                                                                $meal = "NO";
                                                                                echo "NO";
                                                                            }
                                                                        } else {
                                                                            if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"][($ctrFLight-1)]["TPA_Extensions"]['Meal']) ) {
                                                                                $mealCode = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"][($ctrFLight-1)]["TPA_Extensions"]['Meal']['@attributes']['Code'];
                                                                                $meal = "YES";
                                                                                echo "YES";
                                                                            }
                                                                            else {
                                                                                $mealCode = "-";
                                                                                $meal = "NO";
                                                                                echo "NO";
                                                                            }
                                                                        }
                                                                        //passing data to jquery
                                                                        $DdepartureMealArr{$a}[] = $meal;
                                                                        $DdepartureMeal      = implode("~", $DdepartureMealArr{$a});

                                                                        $DdepartureMealCodeArr{$a}[] = $mealCode;
                                                                        $DdepartureMealCode      = implode("~", $DdepartureMealCodeArr{$a});


                                                                        //end pf passing data to jquery
                                                                        ?>
                                                                    </b>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <?php
                                                        //passing data
                                                        $baggagePassing = implode("~", $baggageArr);
                                                        $mealPassing    = implode("~", $mealArr);
                                                        //end of passing data
                                                        //passing data
                                                        $passing_baggage = $baggagePassing;
                                                        $passing_meal    = $mealPassing;
                                                        //end of passing data

                                                        /* 24 Mei , edit 13 june 2017*/
                                                        $DdepartureFareBasisCode       = implode("~", $DdepartureFareBasisCodeArr{$a});
                                                        $DdepartureFareBasisCodeChild       = implode("~", $DdepartureFareBasisCodeChildArr{$a});
                                                        $DdepartureFareBasisCodeInfant       = implode("~", $DdepartureFareBasisCodeInfantArr{$a});
                                                        ?>
                                                    </tr>
                                                    <tr><td>&nbsp;</td></tr>
                                                </table>
                                                <!--END OF TRANSIT MODE-->
                                        <?php
                                            }
                                        } /* departure multi loop */
                                        else
                                        {
                                            /* NO TRANSIT */
                                            $multiTransit = "NO";
                                        ?>

                                            <table style="width:100%">
                                                <tr>
                                                    <td style="text-align:left" colspan="4">
                                                        <div>
                                                            <div style="float:left">
                                                                <img src="<?php echo base_url(); ?>assets/airlines_image/<?php echo $flightDeparture["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"]; ?>.gif" width="80" height="30" />
                                                            </div>
                                                            <div style="float:left; margin-left: 10px">
                                                            <?php
                                                            $totalTime = $flightDeparture["@attributes"]["ElapsedTime"];
                                                            ?>
                                                                <span style="font-size:15px">
                                                                    <?php
                                                                    $fligtName  = $this->Flight->getAirlinesNameBasedOnCode($flightDeparture["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"]);
                                                                    $flightCode = $flightDeparture["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];
                                                                    $flightCodeFilter = $flightDeparture["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];
                                                                    $flightOperatingAirline = $flightDeparture["FlightSegment"]["OperatingAirline"]["@attributes"]["FlightNumber"];

                                                                    /* new addition 7.3.2017 bto */
                                                                    $flightResBookDesigCode = $flightDeparture["FlightSegment"]["@attributes"]['ResBookDesigCode'];
                                                                    $flightAirEquipType = $flightDeparture["FlightSegment"]['Equipment']['@attributes']['AirEquipType'];
                                                                    $flightMarriageGrp = $flightDeparture["FlightSegment"]['MarriageGrp'];
                                                                    $flightETicket = $flightDeparture["FlightSegment"]['TPA_Extensions']['eTicket']['@attributes']['Ind'];

                                                                    /* 22 mei 2017 */
                                                                    $flightTerminal_from = $flightDeparture["FlightSegment"]['DepartureAirport']['@attributes']['TerminalID'];
                                                                    $flightTimezone_from = $flightDeparture["FlightSegment"]['DepartureTimeZone']['@attributes']['GMTOffset'];
                                                                    $flightTerminal_to = $flightDeparture["FlightSegment"]['ArrivalAirport']['@attributes']['TerminalID'];
                                                                    $flightTimezone_to = $flightDeparture["FlightSegment"]['ArrivalTimeZone']['@attributes']['GMTOffset'];

                                                                    $passing_flightName = $fligtName;
                                                                    $passing_flightCode = $flightCode;
                                                                    $passing_flightOperatingAirline = $flightOperatingAirline;

                                                                    /* new addition 7.3.2017 bto */
                                                                    $passing_flightresbookdesigncode = $flightResBookDesigCode;
                                                                    $passing_flightairequiptype = $flightAirEquipType;
                                                                    $passing_flightmarriagegrp = $flightMarriageGrp;
                                                                    $passing_flighteticket = $flightETicket;

                                                                    //end of passing data
                                                                    //passing data to jquery
                                                                    $DdepartureFlightName = $fligtName;
                                                                    $DdepartureFlightCode = $flightCode.' '.$flightOperatingAirline;

                                                                    /* new addition 7.3.2017 bto */
                                                                    $departureFlightResBookDesigCode = $flightResBookDesigCode;
                                                                    $departureFlightAirEquipType = $flightAirEquipType;
                                                                    $departureFlightMarriageGrp = $flightMarriageGrp;
                                                                    $departureFlightEticket = $flightETicket;

                                                                    /* 22 mei 2017 */
                                                                    $departureTerminalID_from = $flightTerminal_from;
                                                                    $departureTimezone_from = $flightTimezone_from;

                                                                    $departureTerminalID_to = $flightTerminal_to;
                                                                    $departureTimezone_to = $flightTimezone_to;
                                                                    //end pf passing data to jquery
                                                                    ?>
                                                                    <b>
                                                                        <?php echo $fligtName; ?> (<?php echo $flightCode; ?> <?php echo $flightOperatingAirline; ?>)
                                                                    </b>
                                                                    &nbsp;&nbsp;
                                                                    <span style="text-align:center; background-color:#1ba0e2; padding:5px; width:200px">
                                                                        <a href="#" style="color:white; font-size:16px; font-weight:bold; text-decoration:none; text-align:center">
                                                                            Direct&nbsp;
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <div style="clear:both"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr><td>&nbsp;</td></tr>
                                                <tr>
                                                    <?php
                                                    $departureTime = str_replace("T", " ", $flightDeparture["FlightSegment"]["@attributes"]["DepartureDateTime"]);
                                                    $arrivalTime   = str_replace("T", " ", $flightDeparture["FlightSegment"]["@attributes"]["ArrivalDateTime"]);
                                                    $departureAirportCode = $flightDeparture["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"];
                                                    $arrivalAirportCode = $flightDeparture["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"];
                                                    //passing data
                                                    $passing_departureTime = $departureTime;
                                                    $passing_arrivalTime   = $arrivalTime;
                                                    $passing_departureAirportCode = $departureAirportCode;
                                                    $passing_arrivalAirportCode   = $arrivalAirportCode;
                                                    //end of passing data
                                                    //passing data to jquery
                                                    $DdepartureDate = date("Y-m-d", strtotime($departureTime));
                                                    $DarrivalDate   = date("Y-m-d", strtotime($arrivalTime));
                                                    $DdepartureTime = date("H:i:s", strtotime($departureTime));
                                                    $DarrivalTime   = date("H:i:s", strtotime($arrivalTime));
                                                    //end pf passing data to jquery
                                                    ?>
                                                    <td style="text-align:left; padding-right:10px; width:30%">
                                                        <div style="font-size:13px"><b><?php echo date("Y F d, H:i:s", strtotime($departureTime)); ?></b></div>
                                                        <div style="font-size:13px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flightDeparture["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $departureAirportCode; ?>)</b></div>
                                                        <div style="font-size:13px">
                                                            <b>Airport: <?php echo str_replace("International", "Int'l", $this->Flight->getAirportNameBasedOnCode($flightDeparture["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"])); ?></b>
                                                        </div>
                                                        <?php
                                                        //passing data to jquery
                                                        $DdepartureCityNameFrom = $this->Flight->getCityNameBasedOnCode($flightDeparture["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"]);
                                                        $DdepartureCityCodeFrom = $departureAirportCode;
                                                        $DdepartureAirportFrom  = str_replace("International", "Int'l", $this->Flight->getAirportNameBasedOnCode($flightDeparture["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"]));
                                                        //end pf passing data to jquery
                                                        ?>
                                                    </td>
                                                    <td style="text-align:left; padding-right:10px; width:30%">
                                                        <div style="font-size:13px"><b><?php echo date("Y F d, H:i:s", strtotime($arrivalTime)); ?></b></div>
                                                        <div style="font-size:13px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flightDeparture["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $arrivalAirportCode; ?>)</b></div>
                                                        <div style="font-size:13px">
                                                            <b>Airport: <?php echo str_replace("International", "Int'l", $this->Flight->getAirportNameBasedOnCode($flightDeparture["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"])); ?></b>
                                                        </div>
                                                        <?php
                                                        //passing data to jquery
                                                        $DdepartureCityNameTo = $this->Flight->getCityNameBasedOnCode($flightDeparture["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"]);
                                                        $DdepartureCityCodeTo = $arrivalAirportCode;
                                                        $DdepartureAirportTo  = str_replace("International", "Int'l", $this->Flight->getAirportNameBasedOnCode($flightDeparture["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"]));
                                                        //end pf passing data to jquery
                                                        ?>
                                                    </td>
                                                    <td style="text-align:left; padding-right:10px; width:20%">
                                                        <?php
                                                        $timeTaken = $flightDeparture["FlightSegment"]["@attributes"]["ElapsedTime"];
                                                        //passing data
                                                        $passing_timeTaken = $timeTaken;
                                                        //end of passing data
                                                        //passing data to jquery
                                                        $DdepartureTimeTaken = $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes');
                                                        //end pf passing data to jquery
                                                        ?>
                                                        <div style="font-size:13px"><b>Flight Time taken</b></div>
                                                        <div style="font-size:13px; color:green">
                                                            <b><?php echo $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes'); ?></b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr><td>&nbsp;</td></tr>

                                                <tr><td>&nbsp;</td></tr>
                                                <tr>
                                                    <td style="text-align:left; padding-right:10px; width:30%">
                                                        <div style="font-size:13px">
                                                            <span style="color:green">
                                                                <?php
                                                                if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {

                                                                    if(count($flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']) > 1) {
                                                                        $PTCBreakDown = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown'];
                                                                        foreach($PTCBreakDown as $priceData) {
                                                                            $passType = $priceData['PassengerTypeQuantity']['@attributes']['Code'];

                                                                            if($passType == 'ADT') {
                                                                                $adultFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][0];

                                                                                if(count($adultFareBasisCode[$a]) > 1) {
                                                                                    $adultFareBasisCode[$a] = array_unique($adultFareBasisCode[$a]);
                                                                                    if(count($childFareBasisCode[$a]) > 1) {
                                                                                        $adultFareBasisCode[$a] = implode(",", $adultFareBasisCode[$a]);
                                                                                    } else {
                                                                                        $adultFareBasisCode[$a] = $adultFareBasisCode[$a][0];
                                                                                    }
                                                                                }
                                                                            }
                                                                            else if($passType == 'CNN') {

                                                                                $childFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][0];

                                                                                if(count($childFareBasisCode[$a]) > 1) {
                                                                                    $childFareBasisCode[$a] = array_unique($childFareBasisCode[$a]);
                                                                                    if(count($childFareBasisCode[$a]) > 1) {
                                                                                        $childFareBasisCode[$a] = implode(",", $childFareBasisCode[$a]);
                                                                                    } else {
                                                                                        $childFareBasisCode[$a] = $childFareBasisCode[$a][0];
                                                                                    }
                                                                                }

                                                                            }
                                                                            else if($passType == 'INF') {

                                                                                $infantFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][0];

                                                                                if(count($infantFareBasisCode[$a]) > 1) {
                                                                                    $infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
                                                                                    if(count($infantFareBasisCode[$a]) > 1) {
                                                                                        $infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
                                                                                    } else {
                                                                                        $infantFareBasisCode[$a] = $infantFareBasisCode[$a][0];
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]['Pieces'])) {
                                                                        $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
                                                                    } else {
                                                                        $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Weight"]." ".$flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Unit"];
                                                                    }
                                                                } else {

                                                                    $passType = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Code'];
                                                                    if ($passType == 'ADT') {
                                                                        $adultFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][0];

                                                                        if(count($adultFareBasisCode[$a]) > 1) {
                                                                            $adultFareBasisCode[$a] = array_unique($adultFareBasisCode[$a]);
                                                                            if(count($childFareBasisCode[$a]) > 1) {
                                                                                $adultFareBasisCode[$a] = implode(",", $adultFareBasisCode[$a]);
                                                                            } else {
                                                                                $adultFareBasisCode[$a] = $adultFareBasisCode[$a][0];
                                                                            }
                                                                        }
                                                                        /*$departureFareBasisCodeArr{$a}[] = $adultFareBasisCode[$a];*/
                                                                    } else if ($passType == 'CNN') {
                                                                        $childFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][0];

                                                                        if(count($childFareBasisCode[$a]) > 1) {
                                                                            $childFareBasisCode[$a] = array_unique($childFareBasisCode[$a]);
                                                                            if(count($childFareBasisCode[$a]) > 1) {
                                                                                $childFareBasisCode[$a] = implode(",", $childFareBasisCode[$a]);
                                                                            } else {
                                                                                $childFareBasisCode[$a] = $childFareBasisCode[$a][0];
                                                                            }
                                                                        }
                                                                        /*$departureFareBasisCodeChildArr{$a}[] = $childFareBasisCode[$a];*/
                                                                    } else {
                                                                        $infantFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][0];

                                                                        if(count($infantFareBasisCode[$a]) > 1) {
                                                                            $infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
                                                                            if(count($infantFareBasisCode[$a]) > 1) {
                                                                                $infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
                                                                            } else {
                                                                                $infantFareBasisCode[$a] = $infantFareBasisCode[$a][0];
                                                                            }
                                                                        }
                                                                        /*$departureFareBasisCodeInfantArr{$a}[] = $infantFareBasisCode[$a];*/
                                                                    }

                                                                    /*if (array_key_exists('FareBasisCodes', $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]))
                                                                    {
                                                                        $FareBasisCodes =  $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]['FareBasisCodes']['FareBasisCode'][0];
                                                                    }*/

                                                                    if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]['Pieces'])) {
                                                                        $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
                                                                    } else {
                                                                        $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Weight"]." ".$flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Unit"];
                                                                    }
                                                                }
                                                                ?>
                                                                <b>Baggage: <?php echo $baggage;?></b>
                                                            </span>
                                                            <?php
                                                            //passing data to jquery
                                                            $DdepartureBaggage = $baggage;
                                                            //end pf passing data to jquery
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td style="text-align:left; padding-right:10px; width:30%">
                                                        <div style="font-size:13px">
                                                            <span style="color:green">
                                                                <b>
                                                                    Meal:
                                                                    <?php
                                                                    $mealCode = "-";
                                                                    /* for case adult, infant child, we take just index 0, just the parent baggage */
                                                                    if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {
                                                                        if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["FareInfos"]["FareInfo"][0]["TPA_Extensions"]['Meal']) ) {
                                                                            $meal = "YES";
                                                                            $mealCode = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["FareInfos"]["FareInfo"][0]["TPA_Extensions"]['Meal']['@attributes']['Code'];
                                                                            echo "YES";
                                                                        }
                                                                        else {
                                                                            $mealCode = "-";
                                                                            $meal = "NO";
                                                                            echo "NO";
                                                                        }
                                                                    } else {
                                                                        if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"][0]["TPA_Extensions"]['Meal']) ) {
                                                                            $meal = "YES";
                                                                            $mealCode = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"][0]["TPA_Extensions"]['Meal']['@attributes']['Code'];
                                                                            echo "YES";
                                                                        }
                                                                        else {
                                                                            $mealCode = "-";
                                                                            $meal = "NO";
                                                                            echo "NO";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </b>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <?php
                                                    //passing data
                                                    $passing_baggage = $baggage;
                                                    $passing_meal    = $meal;
                                                    //end of passing data
                                                    //passing data to jquery
                                                    $DdepartureMeal = $meal;
                                                    $DdepartureMealCode = $mealCode;
                                                    //end pf passing data to jquery

                                                    /* 24 Mei 2017 */
                                                    $DdepartureFareBasisCode = $adultFareBasisCode[$a];
                                                    $DdepartureFareBasisCodeChild = $childFareBasisCode[$a];
                                                    $DdepartureFareBasisCodeInfant = $infantFareBasisCode[$a];
                                                    ?>
                                                </tr>
                                            </table>
                                        <?php
                                        } /* end single departure loop */
                                        ?>
                                        <div style="clear:both"></div>

                                        <div style="display:none" id="departureFlightName<?php echo $a; ?>"><?php echo $DdepartureFlightName; ?></div>
                                        <div style="display:none" id="departureFlightCode<?php echo $a; ?>"><?php echo $DdepartureFlightCode; ?></div>
                                        <div style="display:none" id="departureDateFrom<?php echo $a; ?>"><?php echo $DdepartureDate; ?></div>
                                        <div style="display:none" id="departureDateTo<?php echo $a; ?>"><?php echo $DarrivalDate; ?></div>
                                        <div style="display:none" id="departureTimeFrom<?php echo $a; ?>"><?php echo $DdepartureTime; ?></div>
                                        <div style="display:none" id="departureTimeTo<?php echo $a; ?>"><?php echo $DarrivalTime; ?></div>
                                        <div style="display:none" id="departureCityNameFrom<?php echo $a; ?>"><?php echo $DdepartureCityNameFrom; ?></div>
                                        <div style="display:none" id="departureCityNameTo<?php echo $a; ?>"><?php echo $DdepartureCityNameTo; ?></div>
                                        <div style="display:none" id="departureCityCodeFrom<?php echo $a; ?>"><?php echo $DdepartureCityCodeFrom; ?></div>
                                        <div style="display:none" id="departureCityCodeTo<?php echo $a; ?>"><?php echo $DdepartureCityCodeTo; ?></div>
                                        <div style="display:none" id="departureAirportNameFrom<?php echo $a; ?>"><?php echo $DdepartureAirportFrom; ?></div>
                                        <div style="display:none" id="departureAirportNameTo<?php echo $a; ?>"><?php echo $DdepartureAirportTo; ?></div>
                                        <div style="display:none" id="departureTimeTaken<?php echo $a; ?>"><?php echo $DdepartureTimeTaken; ?></div>
                                        <div style="display:none" id="departureBaggage<?php echo $a; ?>"><?php echo $DdepartureBaggage; ?></div>
                                        <div style="display:none" id="departureMeal<?php echo $a; ?>"><?php echo $DdepartureMeal; ?></div>
                                        <div style="display:none" id="departureMealCode<?php echo $a; ?>"><?php echo $DdepartureMealCode; ?></div>
                                        <div style="display:none" id="departureTotalTransit<?php echo $a; ?>"><?php echo $totalTransit; ?></div>
                                        <div style="display:none" id="departureTotalFlightTime<?php echo $a; ?>"><?php echo $this->Flight->convertToHoursMins($totalTime, $format='%02d hours %02d minutes'); ?></div>
                                        <?php $departureTotalPrice = 0;?>
                                        <div style="display:none" id="departureTotalPrice<?php echo $a; ?>"><?php echo $departureTotalPrice; ?></div>
                                        <!-- new addition 7.3.2017 bto -->
                                        <div style="display:none" id="departureFlightResBookDesigCode<?php echo $a; ?>"><?php echo $departureFlightResBookDesigCode; ?></div>
                                        <div style="display:none" id="departureFlightAirEquipType<?php echo $a; ?>"><?php echo $departureFlightAirEquipType; ?></div>
                                        <div style="display:none" id="departureFlightMarriageGrp<?php echo $a; ?>"><?php echo $departureFlightMarriageGrp; ?></div>
                                        <div style="display:none" id="departureFlightEticket<?php echo $a; ?>"><?php echo $departureFlightEticket ? 1 : 0; ?></div>

                                        <div style="display:none" id="departurePriceAdultTaxFare<?php echo $a; ?>">0</div>
                                        <div style="display:none" id="departurePriceAdultBaseFare<?php echo $a; ?>">0</div>
                                        <div style="display:none" id="departurePriceChildTaxFare<?php echo $a; ?>">0</div>
                                        <div style="display:none" id="departurePriceChildBaseFare<?php echo $a; ?>">0</div>
                                        <div style="display:none" id="departurePriceInfantTaxFare<?php echo $a; ?>">0</div>
                                        <div style="display:none" id="departurePriceInfantBaseFare<?php echo $a; ?>">0</div>
                                        <div style="display:none" id="departureTerminalID_from<?php echo $a; ?>"><?php echo $departureTerminalID_from;?></div>
                                        <div style="display:none" id="departureTimezone_from<?php echo $a; ?>"><?php echo $departureTimezone_from;?></div>
                                        <div style="display:none" id="departureTerminalID_to<?php echo $a; ?>"><?php echo $departureTerminalID_to;?></div>
                                        <div style="display:none" id="departureTimezone_to<?php echo $a; ?>"><?php echo $departureTimezone_to;?></div>
                                        <div style="display:none" id="departureFareBasisCode<?php echo $a; ?>"><?php echo $DdepartureFareBasisCode;?></div>
                                        <div style="display:none" id="departureFareBasisCodeChild<?php echo $a; ?>"><?php echo $DdepartureFareBasisCodeChild;?></div>
                                        <div style="display:none" id="departureFareBasisCodeInfant<?php echo $a; ?>"><?php echo $DdepartureFareBasisCodeInfant;?></div>
                                    </div>

                                        <!-- arrival section -->
                                        <div style="width:47%; float:left; padding:10px; padding-bottom: 0; margin-right:10px" class="arrivalFlight">
                                        <h4>Departure from overseas</h4>
                                        <?php
                                        if( isset($flightArrival["FlightSegment"][0]) )
                                        {
                                            /* multi departure */
                                            $flightSegment = $flightArrival["FlightSegment"];
                                            $countFlightSegment = count($flightArrival["FlightSegment"]);
                                            $multiTransit = "YES";
                                            for( $fs=0; $fs<$countFlightSegment; $fs++ )
                                            {
                                                $ctrFLight++;
                                        ?>
                                                <!--TRANSIT MODE-->
                                                <table style="width:100%">
                                                    <tr>
                                                        <td style="text-align:left" colspan="4">
                                                            <div>
                                                                <div style="float:left; margin-right:10px">
                                                                    <img src="<?php echo base_url(); ?>assets/airlines_image/<?php echo $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][1]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"]; ?>.gif" width="80" height="30" />
                                                                </div>
                                                                <div style="float:left">
                                                                    <span style="font-size:15px">
                                                                        <?php
                                                                        $flightNameArr[] = $this->Flight->getAirlinesNameBasedOnCode($flightArrival["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"]);
                                                                        $flightCodeArr[] = $flightArrival["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"];
                                                                        $flightOperatingAirlineArr[] = $flightArrival["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["FlightNumber"];
                                                                        /* new addition 7.3.2017 bto */
                                                                        $flightResBookDesigCodeArr[] = $flightArrival["FlightSegment"][$fs]["@attributes"]['ResBookDesigCode'];
                                                                        $flightAirEquipTypeArr[] = $flightArrival["FlightSegment"][$fs]['Equipment']['@attributes']['AirEquipType'];
                                                                        $flightMarriageGrpArr[] = $flightArrival["FlightSegment"][$fs]['MarriageGrp'];
                                                                        $flightETicketArr[] = $flightArrival["FlightSegment"][$fs]['TPA_Extensions']['eTicket']['@attributes']['Ind'];

                                                                        //passing data
                                                                        $fligtNamePassing = implode("~", $flightNameArr);
                                                                        $fligtCodePassing = implode("~", $flightCodeArr);
                                                                        $fligtOperatingAirlinePassing = implode("~", $flightOperatingAirlineArr);
                                                                        //end of passing data

                                                                        $fligtName = $this->Flight->getAirlinesNameBasedOnCode($flightArrival["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"]);
                                                                        $flightCode = $flightArrival["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"];
                                                                        $flightCodeFilter = $flightArrival["FlightSegment"][0]["OperatingAirline"]["@attributes"]["Code"];
                                                                        $flightOperatingAirline = $flightArrival["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["FlightNumber"];
                                                                        $flightResBookDesigCode = $flightArrival["FlightSegment"][$fs]["@attributes"]['ResBookDesigCode'];
                                                                        $flightAirEquipType = $flightArrival["FlightSegment"][$fs]['Equipment']['@attributes']['AirEquipType'];
                                                                        $flightMarriageGrp = $flightArrival["FlightSegment"][$fs]['MarriageGrp'];
                                                                        $flightETicket = $flightArrival["FlightSegment"][$fs]['TPA_Extensions']['eTicket']['@attributes']['Ind'];
                                                                        /* 22 mei 2017 */
                                                                        $flightTerminal_from = $flightArrival["FlightSegment"][$fs]['DepartureAirport']['@attributes']['TerminalID'];
                                                                        $flightTimezone_from = $flightArrival["FlightSegment"][$fs]['DepartureTimeZone']['@attributes']['GMTOffset'];

                                                                        $flightTerminal_to = $flightArrival["FlightSegment"][$fs]['ArrivalAirport']['@attributes']['TerminalID'];
                                                                        $flightTimezone_to = $flightArrival["FlightSegment"][$fs]['ArrivalTimeZone']['@attributes']['GMTOffset'];

                                                                        //passing data
                                                                        $passing_flightName = $fligtNamePassing;
                                                                        $passing_flightCode = $fligtCodePassing;
                                                                        $passing_flightOperatingAirline = $fligtOperatingAirlinePassing;
                                                                        $passing_flightresbookdesigncode = $flightResBookDesigCodePassing;
                                                                        $passing_flightairequiptype = $flightAirEquipTypePassing;
                                                                        $passing_flightmarriagegrp = $flightMarriageGrpPassing;
                                                                        $passing_flighteticket = $flightETicketPassing;
                                                                        //end of passing data

                                                                        //passing data to jquery
                                                                        $AdepartureFlightNameArr{$a}[] = $fligtName;
                                                                        $AdepartureFlightName  = implode("~", $AdepartureFlightNameArr{$a});
                                                                        $AdepartureFlightCodeArr{$a}[] = $flightCode.' '.$flightOperatingAirline;
                                                                        $AdepartureFlightCode  = implode("~", $AdepartureFlightCodeArr{$a});
                                                                        //end pf passing data to jquery

                                                                        /* new addition 7.3.2017 bto */
                                                                        $arrivalFlightResBookDesigCodeArr{$a}[] = $flightResBookDesigCode;
                                                                        $arrivalFlightResBookDesigCode  = implode("~", $arrivalFlightResBookDesigCodeArr{$a});
                                                                        $arrivalFlightAirEquipTypeArr{$a}[] = $flightAirEquipType;
                                                                        $arrivalFlightAirEquipType  = implode("~", $arrivalFlightAirEquipTypeArr{$a});

                                                                        $arrivalFlightMarriageGrpArr{$a}[] = $flightMarriageGrp;
                                                                        $arrivalFlightMarriageGrp  = implode("~", $arrivalFlightMarriageGrpArr{$a});

                                                                        $arrivalFlightEticketArr{$a}[] = $flightETicket;
                                                                        $arrivalFlightETicket  = implode("~", $arrivalFlightEticketArr{$a});

                                                                        /* 22 mei 2017 */
                                                                        $arrivalTerminalIDArr_from{$a}[] = $flightTerminal_from;
                                                                        $arrivalTerminalID_from = implode("~", $arrivalTerminalIDArr_from{$a});
                                                                        $arrivalTerminalIDArr_to{$a}[] = $flightTerminal_to;
                                                                        $arrivalTerminalID_to = implode("~", $arrivalTerminalIDArr_to{$a});

                                                                        $arrivalTimezoneArr_from{$a}[] = $flightTimezone_from;
                                                                        $arrivalTimezone_from  = implode("~", $arrivalTimezoneArr_from{$a});

                                                                        $arrivalTimezoneArr_to{$a}[] = $flightTimezone_to;
                                                                        $arrivalTimezone_to  = implode("~", $arrivalTimezoneArr_to{$a});

                                                                        ?>
                                                                        <b>
                                                                            <?php echo $fligtName; ?> (<?php echo $flightCode; ?> <?php echo $flightOperatingAirline; ?>)
                                                                        </b>
                                                                        <?php
                                                                        if( count($AdepartureFlightNameArr{$a}) == 1 ) {
                                                                        ?>
                                                                            &nbsp;&nbsp;
                                                                            <span style="text-align:center; background-color:#1ba0e2; padding:5px; width:200px">
                                                                                <a href="#" style="color:white; font-size:16px; font-weight:bold; text-decoration:none; text-align:center">
                                                                                    Indirect&nbsp;
                                                                                </a>
                                                                            </span>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                                <div style="clear:both"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr><td>&nbsp;</td></tr>
                                                    <tr>
                                                        <?php
                                                        $departureTime = str_replace("T", " ", $flightArrival["FlightSegment"][$fs]["@attributes"]["DepartureDateTime"]);
                                                        $arrivalTime   = str_replace("T", " ", $flightArrival["FlightSegment"][$fs]["@attributes"]["ArrivalDateTime"]);
                                                        $departureTimeArr[] = str_replace("T", " ", $flightArrival["FlightSegment"][$fs]["@attributes"]["DepartureDateTime"]);
                                                        $arrivalTimeArr[] = str_replace("T", " ", $flightArrival["FlightSegment"][$fs]["@attributes"]["ArrivalDateTime"]);
                                                        $departureAirportCodeArr[] = $flightArrival["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"];
                                                        $arrivalAirportCodeArr[] = $flightArrival["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"];

                                                        //passing data
                                                        $departureTimePassing = implode("~", $departureTimeArr);
                                                        $arrivalTimePassing   = implode("~", $arrivalTimeArr);
                                                        $departureAirportCodePassing = implode("~", $departureAirportCodeArr);
                                                        $arrivalAirportCodePassing   = implode("~", $arrivalAirportCodeArr);
                                                        //end of passing data
                                                        //passing data
                                                        $passing_departureTime        = $departureTimePassing;
                                                        $passing_arrivalTime          = $arrivalTimePassing;
                                                        $passing_departureAirportCode = $departureAirportCodePassing;
                                                        $passing_arrivalAirportCode   = $arrivalAirportCodePassing;
                                                        //end of passing data
                                                        //passing data to jquery
                                                        $AdepartureDateArr{$a}[] = date("Y-m-d", strtotime($departureTime));
                                                        $AdepartureDate          = implode("~", $AdepartureDateArr{$a});
                                                        $AdepartureTimeArr{$a}[] = date("H:i:s", strtotime($departureTime));
                                                        $AdepartureTime          = implode("~", $AdepartureTimeArr{$a});
                                                        $AarrivalDateArr{$a}[]   = date("Y-m-d", strtotime($arrivalTime));
                                                        $AarrivalDate            = implode("~", $AarrivalDateArr{$a});
                                                        $AarrivalTimeArr{$a}[]   = date("H:i:s", strtotime($arrivalTime));
                                                        $AarrivalTime            = implode("~", $AarrivalTimeArr{$a});
                                                        //end pf passing data to jquery
                                                        ?>
                                                        <td style="text-align:left; padding-right:10px; width:30%">
                                                            <div style="font-size:13px"><b><?php echo date("Y F d, H:i:s", strtotime($departureTime)); ?></b></div>
                                                            <div style="font-size:13px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flightArrival["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $flightArrival["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]; ?>)</b></div>
                                                            <div style="font-size:13px">
                                                                <b>Airport: <?php echo $this->Flight->getAirportNameBasedOnCode($flightArrival["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]); ?></b>
                                                            </div>
                                                            <?php
                                                            //passing data to jquery
                                                            $AdepartureCityNameFromArr{$a}[] = $this->Flight->getCityNameBasedOnCode($flightArrival["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]);
                                                            $AdepartureCityNameFrom      = implode("~", $AdepartureCityNameFromArr{$a});
                                                            $AdepartureCityCodeFromArr{$a}[] = $flightArrival["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"];
                                                            $AdepartureCityCodeFrom      = implode("~", $AdepartureCityCodeFromArr{$a});
                                                            $AdepartureAirportFromArr{$a}[]  = $this->Flight->getAirportNameBasedOnCode($flightArrival["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]);
                                                            $AdepartureAirportFrom       = implode("~", $AdepartureAirportFromArr{$a});
                                                            //end pf passing data to jquery
                                                            ?>
                                                        </td>
                                                        <td style="text-align:left; padding-right:10px; width:30%">
                                                            <div style="font-size:13px"><b><?php echo date("Y F d, H:i:s", strtotime($arrivalTime)); ?></b></div>
                                                            <div style="font-size:13px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flightArrival["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $flightArrival["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]; ?>)</b></div>
                                                            <div style="font-size:13px">
                                                                <b>Airport: <?php echo $this->Flight->getAirportNameBasedOnCode($flightArrival["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]); ?></b>
                                                            </div>
                                                            <?php
                                                            //passing data to jquery
                                                            $AdepartureCityNameToArr{$a}[] = $this->Flight->getCityNameBasedOnCode($flightArrival["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]);
                                                            $AdepartureCityNameTo      = implode("~", $AdepartureCityNameToArr{$a});
                                                            $AdepartureCityCodeToArr{$a}[] = $flightArrival["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"];
                                                            $AdepartureCityCodeTo      = implode("~", $AdepartureCityCodeToArr{$a});
                                                            $AdepartureAirportToArr{$a}[]  = $this->Flight->getAirportNameBasedOnCode($flightArrival["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]);
                                                            $AdepartureAirportTo       = implode("~", $AdepartureAirportToArr{$a});
                                                            //end pf passing data to jquery
                                                            ?>
                                                        </td>
                                                        <td style="text-align:left; padding-right:10px; width:20%">
                                                            <?php
                                                            $timeTaken = $flightArrival["FlightSegment"][$fs]["@attributes"]["ElapsedTime"];
                                                            $timeTakenArr[] = $flightArrival["FlightSegment"][$fs]["@attributes"]["ElapsedTime"];
                                                            //passing data
                                                            $timeTakenPassing = implode("~", $timeTakenArr);
                                                            //end of passing data
                                                            //passing data
                                                            $passing_timeTaken = $timeTakenPassing;
                                                            //end of passing data
                                                            //passing data to jquery
                                                            $AdepartureTimeTakenArr{$a}[] = $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes');
                                                            $AdepartureTimeTaken      = implode("~", $AdepartureTimeTakenArr{$a});
                                                            //end pf passing data to jquery
                                                            ?>
                                                            <div style="font-size:13px"><b>Flight Time taken</b></div>
                                                            <div style="font-size:13px; color:green">
                                                                <b><?php echo $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes'); ?></b>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr><td>&nbsp;</td></tr>
                                                    <tr>
                                                        <?php
                                                        /* for case adult, infant child, we take just index 0, just the parent baggage */
                                                        if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {

                                                                $PTCBreakDown = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown'];
                                                                foreach($PTCBreakDown as $priceData) {
                                                                    $passType = $priceData['PassengerTypeQuantity']['@attributes']['Code'];

                                                                    if($passType == 'ADT') {
                                                                        $adultFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][1];

                                                                        if(count($adultFareBasisCode[$a]) > 1) {
                                                                            $adultFareBasisCode[$a] = array_unique($adultFareBasisCode[$a]);
                                                                            if(count($childFareBasisCode[$a]) > 1) {
                                                                                $adultFareBasisCode[$a] = implode(",", $adultFareBasisCode[$a]);
                                                                            } else {
                                                                                $adultFareBasisCode[$a] = $adultFareBasisCode[$a][0];
                                                                            }
                                                                        }
                                                                        $AFareBasisCodeArr{$a}[] = $adultFareBasisCode[$a];
                                                                    }
                                                                    else if($passType == 'CNN') {

                                                                        $childFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][1];

                                                                        if(count($childFareBasisCode[$a]) > 1) {
                                                                            $childFareBasisCode[$a] = array_unique($childFareBasisCode[$a]);
                                                                            if(count($childFareBasisCode[$a]) > 1) {
                                                                                $childFareBasisCode[$a] = implode(",", $childFareBasisCode[$a]);
                                                                            } else {
                                                                                $childFareBasisCode[$a] = $childFareBasisCode[$a][0];
                                                                            }
                                                                        }

                                                                        $AFareBasisCodeChildArr{$a}[] = $childFareBasisCode[$a];

                                                                    }
                                                                    else if($passType == 'INF') {

                                                                        $infantFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][1];

                                                                        if(count($infantFareBasisCode[$a]) > 1) {
                                                                            $infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
                                                                            if(count($infantFareBasisCode[$a]) > 1) {
                                                                                $infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
                                                                            } else {
                                                                                $infantFareBasisCode[$a] = $infantFareBasisCode[$a][0];
                                                                            }
                                                                        }
                                                                        $AFareBasisCodeInfantArr{$a}[] = $infantFareBasisCode[$a];
                                                                    }
                                                                }

                                                                //$AFareBasisCodeArr{$a}[] =  $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]['FareBasisCodes']['FareBasisCode'][1];


                                                            if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][1]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]['Pieces'])) {
                                                                $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][1]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
                                                            } else {
                                                                $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][1]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Weight"]." ".$flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Unit"];
                                                            }
                                                        } else {


                                                                $passType = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Code'];
                                                                if ($passType == 'ADT') {
                                                                    $adultFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][1];

                                                                    if(count($adultFareBasisCode[$a]) > 1) {
                                                                        $adultFareBasisCode[$a] = array_unique($adultFareBasisCode[$a]);
                                                                        if(count($childFareBasisCode[$a]) > 1) {
                                                                            $adultFareBasisCode[$a] = implode(",", $adultFareBasisCode[$a]);
                                                                        } else {
                                                                            $adultFareBasisCode[$a] = $adultFareBasisCode[$a][0];
                                                                        }
                                                                    }
                                                                    $AFareBasisCodeArr{$a}[] = $adultFareBasisCode[$a];
                                                                } else if ($passType == 'CNN') {
                                                                    $childFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][1];

                                                                    if(count($childFareBasisCode[$a]) > 1) {
                                                                        $childFareBasisCode[$a] = array_unique($childFareBasisCode[$a]);
                                                                        if(count($childFareBasisCode[$a]) > 1) {
                                                                            $childFareBasisCode[$a] = implode(",", $childFareBasisCode[$a]);
                                                                        } else {
                                                                            $childFareBasisCode[$a] = $childFareBasisCode[$a][0];
                                                                        }
                                                                    }
                                                                    $AFareBasisCodeChildArr{$a}[] = $childFareBasisCode[$a];
                                                                } else {
                                                                    $infantFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][1];

                                                                    if(count($infantFareBasisCode[$a]) > 1) {
                                                                        $infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
                                                                        if(count($infantFareBasisCode[$a]) > 1) {
                                                                            $infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
                                                                        } else {
                                                                            $infantFareBasisCode[$a] = $infantFareBasisCode[$a][0];
                                                                        }
                                                                    }
                                                                    $AFareBasisCodeInfantArr{$a}[] = $infantFareBasisCode[$a];
                                                                }
                                                                /*$AFareBasisCodeArr{$a}[] =  $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]['FareBasisCodes']['FareBasisCode'][1];*/


                                                            if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]['Pieces'])) {
                                                                $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
                                                            } else {
                                                                $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Weight"]." ".$flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][0]["Allowance"]["@attributes"]["Unit"];
                                                            }
                                                        }

                                                        $baggageArr[] = $baggage;
                                                        ?>
                                                        <td style="text-align:left; padding-right:10px; width:30%">
                                                            <div style="font-size:13px">
                                                                <span style="color:green">
                                                                    <b>Baggage: <?php echo $baggage;?></b>
                                                                    <?php
                                                                    //passing data to jquery
                                                                    $AdepartureBaggageArr{$a}[] = $baggage;
                                                                    $AdepartureBaggage      = implode("~", $AdepartureBaggageArr{$a});
                                                                    //end pf passing data to jquery
                                                                    ?>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td style="text-align:left; padding-right:10px; width:30%">
                                                            <div style="font-size:13px">
                                                                <span style="color:green">
                                                                    <b>
                                                                        Meal:
                                                                        <?php
                                                                        /* for case adult, infant child, we take just index 0, just the parent baggage */
                                                                        if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][1])) {
                                                                            if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][1]["FareInfos"]["FareInfo"][($ctrFLight-1)]["TPA_Extensions"]['Meal']) ) {
                                                                                $meal = "YES";
                                                                                $mealCode = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][1]["FareInfos"]["FareInfo"][($ctrFLight-1)]["TPA_Extensions"]['Meal']['@attributes']['Code'];
                                                                                echo "YES";
                                                                            }
                                                                            else {
                                                                                $mealCode = "-";
                                                                                $meal = "NO";
                                                                                echo "NO";
                                                                            }
                                                                        } else {
                                                                            if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"][($ctrFLight-1)]["TPA_Extensions"]['Meal']) ) {
                                                                                $meal = "YES";
                                                                                $mealCode = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"][($ctrFLight-1)]["TPA_Extensions"]['Meal']['@attributes']['Code'];
                                                                                echo "YES";
                                                                            }
                                                                            else {
                                                                                $mealCode = "-";
                                                                                $meal = "NO";
                                                                                echo "NO";
                                                                            }
                                                                        }
                                                                        //passing data to jquery
                                                                        $AdepartureMealArr{$a}[] = $meal;
                                                                        $AdepartureMeal      = implode("~", $AdepartureMealArr{$a});

                                                                        $AdepartureMealCodeArr{$a}[] = $mealCode;
                                                                        $AdepartureMealCode      = implode("~", $AdepartureMealCodeArr{$a});
                                                                        //end pf passing data to jquery
                                                                        ?>
                                                                    </b>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <?php
                                                        //passing data
                                                        $baggagePassing = implode("~", $baggageArr);
                                                        $mealPassing    = implode("~", $mealArr);
                                                        //end of passing data
                                                        //passing data
                                                        $passing_baggage = $baggagePassing;
                                                        $passing_meal    = $mealPassing;
                                                        //end of passing data

                                                        $arrivalFareBasisCode = implode("~", $AFareBasisCodeArr{$a});
                                                        $arrivalFareBasisCodeChild = implode("~", $AFareBasisCodeChildArr{$a});
                                                        $arrivalFareBasisCodeInfant = implode("~", $AFareBasisCodeInfantArr{$a});
                                                        ?>
                                                    </tr>
                                                    <tr><td>&nbsp;</td></tr>
                                                </table>
                                                <!--END OF TRANSIT MODE-->
                                        <?php
                                            }
                                        } /* arrival multi loop */
                                        else
                                        {
                                            /* NO TRANSIT */
                                            $multiTransit = "NO";
                                        ?>
                                            <!-- arrival section -->
                                            <table style="width:100%">
                                                <tr>
                                                    <td style="text-align:left" colspan="4">
                                                        <div>
                                                            <div style="float:left">
                                                                <img src="<?php echo base_url(); ?>assets/airlines_image/<?php echo $flightArrival["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"]; ?>.gif" width="80" height="30" />
                                                            </div>
                                                            <div style="float:left; margin-left: 10px">
                                                            <?php
                                                            $totalTimeArrival = $flightArrival["@attributes"]["ElapsedTime"];
                                                            ?>
                                                                <span style="font-size:15px">
                                                                    <?php
                                                                    $fligtName  = $this->Flight->getAirlinesNameBasedOnCode($flightArrival["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"]);
                                                                    $flightCode = $flightArrival["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];
                                                                    $flightCodeFilter = $flightArrival["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];
                                                                    $flightOperatingAirline = $flightArrival["FlightSegment"]["OperatingAirline"]["@attributes"]["FlightNumber"];
                                                                    /* new addition 7.3.2017 bto */
                                                                    $flightResBookDesigCode = $flightArrival["FlightSegment"]["@attributes"]['ResBookDesigCode'];
                                                                    $flightAirEquipType = $flightArrival["FlightSegment"]['Equipment']['@attributes']['AirEquipType'];
                                                                    $flightMarriageGrp = $flightArrival["FlightSegment"]['MarriageGrp'];
                                                                    $flightETicket = $flightArrival["FlightSegment"]['TPA_Extensions']['eTicket']['@attributes']['Ind'];

                                                                    /* 22 mei 2017 */
                                                                    $flightTerminal_from = $flightArrival["FlightSegment"]['DepartureAirport']['@attributes']['TerminalID'];
                                                                    $flightTimezone_from = $flightArrival["FlightSegment"]['DepartureTimeZone']['@attributes']['GMTOffset'];
                                                                    $flightTerminal_to = $flightArrival["FlightSegment"]['ArrivalAirport']['@attributes']['TerminalID'];
                                                                    $flightTimezone_to = $flightArrival["FlightSegment"]['ArrivalTimeZone']['@attributes']['GMTOffset'];

                                                                    //passing data
                                                                    $passing_flightName = $fligtName;
                                                                    $passing_flightCode = $flightCode;
                                                                    $passing_flightOperatingAirline = $flightOperatingAirline;
                                                                    /* new addition 7.3.2017 bto */
                                                                    $passing_flightresbookdesigncode = $flightResBookDesigCode;
                                                                    $passing_flightairequiptype = $flightAirEquipType;
                                                                    $passing_flightmarriagegrp = $flightMarriageGrp;
                                                                    $passing_flighteticket = $flightETicket;

                                                                    //end of passing data
                                                                    //passing data to jquery
                                                                    $AdepartureFlightName = $fligtName;
                                                                    $AdepartureFlightCode = $flightCode.' '.$flightOperatingAirline;
                                                                    //end pf passing data to jquery

                                                                    /* new addition 7.3.2017 bto */
                                                                    $arrivalFlightResBookDesigCode = $flightResBookDesigCode;
                                                                    $arrivalFlightAirEquipType = $flightAirEquipType;
                                                                    $arrivalFlightMarriageGrp = $flightMarriageGrp;
                                                                    $arrivalFlightEticket = $flightETicket;
                                                                    /* 22 mei 2017 */
                                                                    $arrivalTerminalID_from = $flightTerminal_from;
                                                                    $arrivalTimezone_from = $flightTimezone_from;
                                                                    $arrivalTerminalID_to = $flightTerminal_to;
                                                                    $arrivalTimezone_to = $flightTimezone_to;
                                                                    //end pf passing data to jquery
                                                                    ?>
                                                                    <b>
                                                                        <?php echo $fligtName; ?> (<?php echo $flightCode; ?> <?php echo $flightOperatingAirline; ?>)
                                                                    </b>
                                                                    &nbsp;&nbsp;
                                                                    <span style="text-align:center; background-color:#1ba0e2; padding:5px; width:200px">
                                                                        <a href="#" style="color:white; font-size:16px; font-weight:bold; text-decoration:none; text-align:center">
                                                                            Direct&nbsp;
                                                                        </a>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <div style="clear:both"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr><td>&nbsp;</td></tr>
                                                <tr>
                                                    <?php
                                                    $departureTime = str_replace("T", " ", $flightArrival["FlightSegment"]["@attributes"]["DepartureDateTime"]);
                                                    $arrivalTime   = str_replace("T", " ", $flightArrival["FlightSegment"]["@attributes"]["ArrivalDateTime"]);
                                                    $departureAirportCode = $flightArrival["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"];
                                                    $arrivalAirportCode = $flightArrival["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"];
                                                    //passing data
                                                    $passing_departureTime = $departureTime;
                                                    $passing_arrivalTime   = $arrivalTime;
                                                    $passing_departureAirportCode = $departureAirportCode;
                                                    $passing_arrivalAirportCode   = $arrivalAirportCode;
                                                    //end of passing data
                                                    //passing data to jquery
                                                    $AdepartureDate = date("Y-m-d", strtotime($departureTime));
                                                    $AarrivalDate   = date("Y-m-d", strtotime($arrivalTime));
                                                    $AdepartureTime = date("H:i:s", strtotime($departureTime));
                                                    $AarrivalTime   = date("H:i:s", strtotime($arrivalTime));
                                                    //end pf passing data to jquery
                                                    ?>
                                                    <td style="text-align:left; padding-right:10px; width:30%">
                                                        <div style="font-size:13px"><b><?php echo date("Y F d, H:i:s", strtotime($departureTime)); ?></b></div>
                                                        <div style="font-size:13px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flightArrival["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $departureAirportCode; ?>)</b></div>
                                                        <div style="font-size:13px">
                                                            <b>Airport: <?php echo str_replace("International", "Int'l", $this->Flight->getAirportNameBasedOnCode($flightArrival["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"])); ?></b>
                                                        </div>
                                                        <?php
                                                        //passing data to jquery
                                                        $AdepartureCityNameFrom = $this->Flight->getCityNameBasedOnCode($flightArrival["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"]);
                                                        $AdepartureCityCodeFrom = $departureAirportCode;
                                                        $AdepartureAirportFrom  = str_replace("International", "Int'l", $this->Flight->getAirportNameBasedOnCode($flightArrival["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"]));
                                                        //end pf passing data to jquery
                                                        ?>
                                                    </td>
                                                    <td style="text-align:left; padding-right:10px; width:30%">
                                                        <div style="font-size:13px"><b><?php echo date("Y F d, H:i:s", strtotime($arrivalTime)); ?></b></div>
                                                        <div style="font-size:13px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flightArrival["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $arrivalAirportCode; ?>)</b></div>
                                                        <div style="font-size:13px">
                                                            <b>Airport: <?php echo str_replace("International", "Int'l", $this->Flight->getAirportNameBasedOnCode($flightArrival["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"])); ?></b>
                                                        </div>
                                                        <?php
                                                        //passing data to jquery
                                                        $AdepartureCityNameTo = $this->Flight->getCityNameBasedOnCode($flightArrival["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"]);
                                                        $AdepartureCityCodeTo = $arrivalAirportCode;
                                                        $AdepartureAirportTo  = str_replace("International", "Int'l", $this->Flight->getAirportNameBasedOnCode($flightArrival["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"]));
                                                        //end pf passing data to jquery
                                                        ?>
                                                    </td>
                                                    <td style="text-align:left; padding-right:10px; width:20%">
                                                        <?php
                                                        $timeTaken = $flightArrival["FlightSegment"]["@attributes"]["ElapsedTime"];
                                                        //passing data
                                                        $passing_timeTaken = $timeTaken;
                                                        //end of passing data
                                                        //passing data to jquery
                                                        $AdepartureTimeTaken = $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes');
                                                        //end pf passing data to jquery
                                                        ?>
                                                        <div style="font-size:13px"><b>Flight Time taken</b></div>
                                                        <div style="font-size:13px; color:green">
                                                            <b><?php echo $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes'); ?></b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr><td>&nbsp;</td></tr>

                                                <tr><td>&nbsp;</td></tr>
                                                <tr>
                                                    <td style="text-align:left; padding-right:10px; width:30%">
                                                        <div style="font-size:13px">
                                                            <span style="color:green">
                                                                <?php
                                                                /* for case adult, infant child, we take just index 0, just the parent baggage */
                                                                if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {
                                                                    if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]['FareBasisCodes']))
                                                                    {
                                                                        if(count($flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']) > 1) {
                                                                        $PTCBreakDown = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown'];
                                                                            foreach($PTCBreakDown as $priceData) {
                                                                                $passType = $priceData['PassengerTypeQuantity']['@attributes']['Code'];

                                                                                if($passType == 'ADT') {
                                                                                    $adultFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][1];

                                                                                    if(count($adultFareBasisCode[$a]) > 1) {
                                                                                        $adultFareBasisCode[$a] = array_unique($adultFareBasisCode[$a]);
                                                                                        if(count($childFareBasisCode[$a]) > 1) {
                                                                                            $adultFareBasisCode[$a] = implode(",", $adultFareBasisCode[$a]);
                                                                                        } else {
                                                                                            $adultFareBasisCode[$a] = $adultFareBasisCode[$a][0];
                                                                                        }
                                                                                    }
                                                                                }
                                                                                else if($passType == 'CNN') {

                                                                                    $childFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][1];

                                                                                    if(count($childFareBasisCode[$a]) > 1) {
                                                                                        $childFareBasisCode[$a] = array_unique($childFareBasisCode[$a]);
                                                                                        if(count($childFareBasisCode[$a]) > 1) {
                                                                                            $childFareBasisCode[$a] = implode(",", $childFareBasisCode[$a]);
                                                                                        } else {
                                                                                            $childFareBasisCode[$a] = $childFareBasisCode[$a][0];
                                                                                        }
                                                                                    }

                                                                                }
                                                                                else if($passType == 'INF') {

                                                                                    $infantFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'][1];

                                                                                    if(count($infantFareBasisCode[$a]) > 1) {
                                                                                        $infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
                                                                                        if(count($infantFareBasisCode[$a]) > 1) {
                                                                                            $infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
                                                                                        } else {
                                                                                            $infantFareBasisCode[$a] = $infantFareBasisCode[$a][0];
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    /*$FareBasisCodes =  $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]['FareBasisCodes']['FareBasisCode'][1];*/
                                                                    }

                                                                    if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][1]["Allowance"]["@attributes"]['Pieces'])) {
                                                                        $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][1]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
                                                                    } else {
                                                                        $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][1]["Allowance"]["@attributes"]["Weight"]." ".$flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][1]["Allowance"]["@attributes"]["Unit"];
                                                                    }
                                                                } else {
                                                                    if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]['FareBasisCodes']))
                                                                    {
                                                                        $passType = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Code'];
                                                                        if ($passType == 'ADT') {
                                                                            $adultFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][1];

                                                                            if(count($adultFareBasisCode[$a]) > 1) {
                                                                                $adultFareBasisCode[$a] = array_unique($adultFareBasisCode[$a]);
                                                                                if(count($childFareBasisCode[$a]) > 1) {
                                                                                    $adultFareBasisCode[$a] = implode(",", $adultFareBasisCode[$a]);
                                                                                } else {
                                                                                    $adultFareBasisCode[$a] = $adultFareBasisCode[$a][0];
                                                                                }
                                                                            }
                                                                            /*$departureFareBasisCodeArr{$a}[] = $adultFareBasisCode[$a];*/
                                                                        } else if ($passType == 'CNN') {
                                                                            $childFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][1];

                                                                            if(count($childFareBasisCode[$a]) > 1) {
                                                                                $childFareBasisCode[$a] = array_unique($childFareBasisCode[$a]);
                                                                                if(count($childFareBasisCode[$a]) > 1) {
                                                                                    $childFareBasisCode[$a] = implode(",", $childFareBasisCode[$a]);
                                                                                } else {
                                                                                    $childFareBasisCode[$a] = $childFareBasisCode[$a][0];
                                                                                }
                                                                            }
                                                                            /*$departureFareBasisCodeChildArr{$a}[] = $childFareBasisCode[$a];*/
                                                                        } else {
                                                                            $infantFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'][0];

                                                                            if(count($infantFareBasisCode[$a]) > 1) {
                                                                                $infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
                                                                                if(count($infantFareBasisCode[$a]) > 1) {
                                                                                    $infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
                                                                                } else {
                                                                                    $infantFareBasisCode[$a] = $infantFareBasisCode[$a][1];
                                                                                }
                                                                            }
                                                                            /*$departureFareBasisCodeInfantArr{$a}[] = $infantFareBasisCode[$a];*/
                                                                        }
                                                                    /*$FareBasisCodes =  $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]['FareBasisCodes']['FareBasisCode'][1];*/
                                                                    }

                                                                    if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][1]["Allowance"]["@attributes"]['Pieces'])) {
                                                                        $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][1]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
                                                                    } else {
                                                                        $baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][1]["Allowance"]["@attributes"]["Weight"]." ".$flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"][1]["Allowance"]["@attributes"]["Unit"];
                                                                    }
                                                                }

                                                                ?>
                                                                <b>Baggage: <?php echo $baggage;?></b>
                                                            </span>
                                                            <?php
                                                            //passing data to jquery
                                                            $AdepartureBaggage = $baggage;
                                                            //end pf passing data to jquery
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td style="text-align:left; padding-right:10px; width:30%">
                                                        <div style="font-size:13px">
                                                            <span style="color:green">
                                                                <b>
                                                                    Meal:
                                                                    <?php
                                                                    /* for case adult, infant child, we take just index 0, just the parent baggage */
                                                                    if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {
                                                                        if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["FareInfos"]["FareInfo"][1]["TPA_Extensions"]['Meal']) ) {
                                                                            $meal = "YES";
                                                                            $mealCode = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["FareInfos"]["FareInfo"][1]["TPA_Extensions"]['Meal']['@attributes']['Code'];
                                                                            echo "YES";
                                                                        }
                                                                        else {
                                                                            $mealCode = "-";
                                                                            $meal = "NO";
                                                                            echo "NO";
                                                                        }
                                                                    } else {
                                                                        if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"][1]["TPA_Extensions"]['Meal']) ) {
                                                                            $meal = "YES";
                                                                            $mealCode = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"][1]["TPA_Extensions"]['Meal']['@attributes']['Code'];
                                                                            echo "YES";
                                                                        }
                                                                        else {
                                                                            $mealCode = "-";
                                                                            $meal = "NO";
                                                                            echo "NO";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </b>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <?php
                                                    //passing data
                                                    $passing_baggage = $baggage;
                                                    $passing_meal    = $meal;
                                                    //end of passing data
                                                    //passing data to jquery
                                                    $AdepartureMeal = $meal;
                                                    $AdepartureMealCode = $mealCode;
                                                    //end pf passing data to jquery

                                                    $arrivalFareBasisCode = $adultFareBasisCode[$a];
                                                    $arrivalFareBasisCodeChild = $childFareBasisCode[$a];
                                                    $arrivalFareBasisCodeInfant = $infantFareBasisCode[$a]
                                                    ?>
                                                </tr>
                                            </table>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        echo "<div style='display:none'>".$AdepartureFlightName."</div>";

                                        $priceInfo  = $flight_results[$a]["AirItineraryPricingInfo"]["ItinTotalFare"];
                                        /*$equiveFare = $this->Flight->getRateConvertion($priceInfo["EquivFare"]["@attributes"]["CurrencyCode"]);
                                        $taxesFare  = $this->Flight->getRateConvertion($priceInfo["Taxes"]["Tax"]["@attributes"]["CurrencyCode"]);
                                        $printEquiveFare = floor($priceInfo["EquivFare"]["@attributes"]["Amount"]/$equiveFare);
                                        $printTaxesFare  = floor($priceInfo["Taxes"]["Tax"]["@attributes"]["Amount"]/$taxesFare);
                                        $printAdminFee   = floor((($printEquiveFare+$printTaxesFare)*FLIGHT_ADMIN_PERCENT)/100);
                                        $printGrandTotal = $printEquiveFare+$printTaxesFare+$printAdminFee;
                                        */

                                        $printEquiveFare = ceil($priceInfo["EquivFare"]["@attributes"]["Amount"]);
                                        //ceil($priceInfo["Taxes"]["Tax"]["@attributes"]["Amount"]);
                                        //$totalFare = ceil($priceInfo["TotalFare"]["@attributes"]["Amount"]);

                                        //$printAdminFee   = ceil((($totalFare)*FLIGHT_ADMIN_PERCENT)/100);//ceil((($printEquiveFare+$printTaxesFare)*FLIGHT_ADMIN_PERCENT)/100);
                                        // + $printAdminFee; //$printEquiveFare+$printTaxesFare+$printAdminFee;

                                        $basePriceDetailFare = "";

                                        $flightAdult = $tmpflightAdult[$a];
                                        $flightChild = $tmpflightChild[$a];
                                        $flightInfant = $tmpflightInfant[$a];

                                        if(count($adultFare)) {
                                            $printTaxesFare += ceil($adultTaxFare[$a]);
                                            $totalFare = $flightAdult * (ceil($adultFare[$a]) + ceil($adultTaxFare[$a]));
                                            $printGrandTotal += $totalFare;
                                            $basePriceDetailFare .= "<div style='float:left; width:150px; text-align:left'>Adult Fare</div>
                                            <div style='float:left; width:50px;  text-align:left'>x".$flightAdult."</div>
                                            <div style='float:left; width:50px; text-align:left'>$".number_format($totalFare, 2)."</div>
                                            <div style='clear:both'></div>";
                                        }
                                        if(count($childFare)) {
                                            $printTaxesFare += ceil($childTaxFare[$a]);
                                            $totalFare = $flightChild * (ceil($childFare[$a]) + ($childTaxFare[$a]));
                                            $printGrandTotal += $totalFare;
                                            $basePriceDetailFare .= "<div style='float:left; width:150px; text-align:left'>Children Fare</div>
                                            <div style='float:left; width:50px;  text-align:left'>x".$flightChild."</div>
                                            <div style='float:left; width:50px; text-align:left'>$".number_format($totalFare, 2)."</div>
                                            <div style='clear:both'></div>";
                                        }
                                        if(count($infantFare)) {
                                            $printTaxesFare += ceil($infantTaxFare[$a]);
                                            $totalFare = $flightInfant * (ceil($infantFare[$a]) + ceil($infantTaxFare[$a]));
                                            $printGrandTotal += $totalFare;
                                            $basePriceDetailFare .= "<div style='float:left; width:150px; text-align:left'>Infant Fare</div>
                                            <div style='float:left; width:50px;  text-align:left'>x".$flightInfant."</div>
                                            <div style='float:left; width:50px; text-align:left'>$".number_format($totalFare, 2)."</div>
                                            <div style='clear:both'></div>";
                                        }

                                        $contentPrice = "
                                            <div>
                                                <div style='float:left; width:250px; text-align:left'>
                                                    Price for:
                                                    $flightAdult Adult(s), $flightChild Child(s), $flightInfant Infant(s)
                                                </div>
                                                <div style='clear:both'></div>
                                            </div>
                                            <div>
                                                ".$basePriceDetailFare."
                                            </div>
                                            <div>
                                                <div style='float:left; width:150px; text-align:left'>Tax</div>
                                                <div style='float:left; width:50px;  text-align:left'>-</div>
                                                <div style='float:left; width:50px; text-align:left'>
                                                    Included
                                                </div>
                                                <div style='clear:both'></div>
                                            </div>
                                            <hr />
                                            <div style='color:green; font-weight:bold'>
                                                <div style='float:left; width:250px; text-align:left'>TOTAL PRICE: $".number_format($printGrandTotal, 2)."</div>
                                                <div style='clear:both'></div>
                                            </div>
                                        ";
                                        ?>
                                        <div style="display:none" id="arrivalFlightName<?php echo $a; ?>"><?php echo $AdepartureFlightName; ?></div>
                                        <div style="display:none" id="arrivalFlightCode<?php echo $a; ?>"><?php echo $AdepartureFlightCode; ?></div>
                                        <div style="display:none" id="arrivalDateFrom<?php echo $a; ?>"><?php echo $AdepartureDate; ?></div>
                                        <div style="display:none" id="arrivalDateTo<?php echo $a; ?>"><?php echo $AarrivalDate; ?></div>
                                        <div style="display:none" id="arrivalTimeFrom<?php echo $a; ?>"><?php echo $AdepartureTime; ?></div>
                                        <div style="display:none" id="arrivalTimeTo<?php echo $a; ?>"><?php echo $AarrivalTime; ?></div>
                                        <div style="display:none" id="arrivalCityNameFrom<?php echo $a; ?>"><?php echo $AdepartureCityNameFrom; ?></div>
                                        <div style="display:none" id="arrivalCityNameTo<?php echo $a; ?>"><?php echo $AdepartureCityNameTo; ?></div>
                                        <div style="display:none" id="arrivalCityCodeFrom<?php echo $a; ?>"><?php echo $AdepartureCityCodeFrom; ?></div>
                                        <div style="display:none" id="arrivalCityCodeTo<?php echo $a; ?>"><?php echo $AdepartureCityCodeTo; ?></div>
                                        <div style="display:none" id="arrivalAirportNameFrom<?php echo $a; ?>"><?php echo $AdepartureAirportFrom; ?></div>
                                        <div style="display:none" id="arrivalAirportNameTo<?php echo $a; ?>"><?php echo $AdepartureAirportTo; ?></div>
                                        <div style="display:none" id="arrivalTimeTaken<?php echo $a; ?>"><?php echo $AdepartureTimeTaken; ?></div>
                                        <div style="display:none" id="arrivalBaggage<?php echo $a; ?>"><?php echo $AdepartureBaggage; ?></div>
                                        <div style="display:none" id="arrivalMeal<?php echo $a; ?>"><?php echo $AdepartureMeal; ?></div>
                                        <div style="display:none" id="arrivalMealCode<?php echo $a; ?>"><?php echo $AdepartureMealCode; ?></div>
                                        <div style="display:none" id="arrivalTotalTransit<?php echo $a; ?>"><?php echo $totalTransit; ?></div>
                                        <div style="display:none" id="arrivalTotalFlightTime<?php echo $a; ?>"><?php echo $this->Flight->convertToHoursMins($totalTimeArrival, $format='%02d hours %02d minutes'); ?></div>
                                        <div style="display:none" id="arrivalTotalPrice<?php echo $a; ?>"><?php echo $printGrandTotal; ?></div><!-- new addition 7.3.2017 bto -->
                                        <div style="display:none" id="arrivalFlightResBookDesigCode<?php echo $a; ?>"><?php echo $arrivalFlightResBookDesigCode; ?></div>
                                        <div style="display:none" id="arrivalFlightAirEquipType<?php echo $a; ?>"><?php echo $arrivalFlightAirEquipType; ?></div>
                                        <div style="display:none" id="arrivalFlightMarriageGrp<?php echo $a; ?>"><?php echo $arrivalFlightMarriageGrp; ?></div>
                                        <div style="display:none" id="arrivalFlightEticket<?php echo $a; ?>"><?php echo $arrivalFlightEticket ? 1 : 0; ?></div>

                                        <div style="display:none" id="arrivalPriceAdultTaxFare<?php echo $a; ?>"><?php echo $flightAdult * ($adultTaxFare[$a]);?></div>
                                        <div style="display:none" id="arrivalPriceAdultBaseFare<?php echo $a; ?>"><?php echo $flightAdult * ($adultFare[$a]);?></div>
                                        <div style="display:none" id="arrivalPriceChildTaxFare<?php echo $a; ?>"><?php echo $flightChild * ($childTaxFare[$a]); ?></div>
                                        <div style="display:none" id="arrivalPriceChildBaseFare<?php echo $a; ?>"><?php echo $flightChild * ($childFare[$a]); ?></div>
                                        <div style="display:none" id="arrivalPriceInfantTaxFare<?php echo $a; ?>"><?php echo $flightInfant * ($infantTaxFare[$a]); ?></div>
                                        <div style="display:none" id="arrivalPriceInfantBaseFare<?php echo $a; ?>"><?php echo $flightInfant * ($infantFare[$a]); ?></div>
                                        <div style="display:none" id="TotalPriceAdminFare<?php echo $a; ?>"><?php echo $printAdminFee; ?></div>
                                        <div style="display:none" id="arrivalTerminalID_from<?php echo $a; ?>"><?php echo $arrivalTerminalID_from; ?></div>
                                        <div style="display:none" id="arrivalTimezone_from<?php echo $a; ?>"><?php echo $arrivalTimezone_from; ?></div>
                                        <div style="display:none" id="arrivalTerminalID_to<?php echo $a; ?>"><?php echo $arrivalTerminalID_to; ?></div>
                                        <div style="display:none" id="arrivalTimezone_to<?php echo $a; ?>"><?php echo $arrivalTimezone_to; ?></div>
                                        <div style="display:none" id="arrivalFareBasisCode<?php echo $a; ?>"><?php echo $arrivalFareBasisCode;?></div>
                                        <div style="display:none" id="arrivalFareBasisCodeChild<?php echo $a; ?>"><?php echo $arrivalFareBasisCodeChild;?></div>
                                        <div style="display:none" id="arrivalFareBasisCodeInfant<?php echo $a; ?>"><?php echo $arrivalFareBasisCodeInfant;?></div>
                                        <div style="clear:both"></div>
                                        </div> <!-- end arrival -->
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="filterTrfPriceNOD<?php echo $a;?> filterAirlineNOD<?php echo $codeID; ?>" style="background-color:#fafafa; border-radius: 5px; margin : 15px 0; padding:0 20px">
                                        <div style="text-align:center; padding:5px; float:left; margin-right:10px">
                                            <div style="font-size:13px">
                                                <?php
                                                $totalTime = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["@attributes"]["ElapsedTime"];
                                                ?>
                                                <span><b>Total Transit: </b></span>
                                                <span style="color:green">
                                                    <?php
                                                    if( isset($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"][0]) ) {
                                                        $totalTransit = count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"])-1;
                                                    ?>
                                                        <b><?php echo count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"])-1; ?></b>
                                                    <?php
                                                    }
                                                    else {
                                                        $totalTransit = 0;
                                                    ?>
                                                        <b>0</b>
                                                    <?php
                                                    }
                                                    ?>
                                                </span>
                                                |
                                                <span><b>Total Travel Time: </b></span>
                                                <span style="color:green">
                                                    <b><?php echo $this->Flight->convertToHoursMins($totalTime, $format='%02d hours %02d minutes'); ?></b>
                                                </span>
                                            </div>
                                        </div>
                                        <div style="text-align:center; padding:5px; float:right; margin-right:10px">
                                            <div style="font-size:13px">
                                                <?php
                                                $totalTime = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][1]["@attributes"]["ElapsedTime"];
                                                ?>
                                                <span><b>Total Transit: </b></span>
                                                <span style="color:green">
                                                    <?php
                                                    if( isset($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][1]["FlightSegment"][0]) ) {
                                                        $totalTransit = count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"])-1;
                                                    ?>
                                                        <b><?php echo count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][1]["FlightSegment"])-1; ?></b>
                                                    <?php
                                                    }
                                                    else {
                                                        $totalTransit = 0;
                                                    ?>
                                                        <b>0</b>
                                                    <?php
                                                    }
                                                    ?>
                                                </span>
                                                |
                                                <span><b>Total Travel Time: </b></span>
                                                <span style="color:green">
                                                    <b><?php echo $this->Flight->convertToHoursMins($totalTime, $format='%02d hours %02d minutes'); ?></b>
                                                </span>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                        <?php if ($detailAirline[$a] != "") { ?>
                                        <div style="text-align:center; background-color:#F7941D; color:#FFFFFF; padding:5px; width:200px; margin-top: 10px; float:left; margin-bottom: 15px" title="<?php echo $detailAirline[$a];?>"> (Important) </div>
                                        <?php } ?>

                                        <div style="text-align:center; background-color:#F7941D; padding:5px; width:200px; margin-top: 10px; float:right; margin-bottom: 15px">
                                                <a href="#<?php echo $a; ?>" id="clickPriceArrival<?php echo $a; ?>" style="color:white; font-size:16px; font-weight:bold; text-decoration:none; text-align:center; cursor:pointer" class="tip" data-tip="<?php echo $contentPrice; ?>">
                                                    SGD <?php echo number_format($printGrandTotal, 2); ?>
                                                </a>
                                                <?php
                                                $arrivalTotalPrice = number_format($printGrandTotal, 2);
                                                ?>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div class="filterTrfPriceNOD<?php echo $a;?> filterAirlineNOD<?php echo $codeID; ?>"><hr><br><br></div>
                                <?php
                                    }
                                } else {
                                    echo '<div style="font-size:13px; color:red">
        No flight available at the moment. Please use another dates to get more flight result.
    </div>';
                                }
                                ?>
                                <!--LOOP HERE-->
                            </article>
                        </div>
                        <!--End of Departure-->
                        <div class="bottom-nav">
                            <a href="#" class="scroll-to-top" title="Back up">Back up</a>
                        </div>
                    </div>
                </section>
                <!--End of CONTENT-->



            </div>
        </div>
    </div>
    <?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
    <script src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/sequence.jquery-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/sequence.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/tipr/tipr.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/typehead/js/typeahead.bundle.js"></script>
    <script>selectnav('nav'); </script>
    <script type="text/javascript">
        var localStorageDeparture = [];
        var localStorageArrival   = [];
        $(document).ready(function(){
            $('.main').show();
            $('#divLoading2').remove();

            function filterFlightDeparture()
            {
                $('.filterFlight').each(function() {
                    if($(this).hasClass('hidePrice') ||
                        $(this).hasClass('hideAirline') ||
                        $(this).hasClass('hideTransfer') ||
                        $(this).hasClass('hideTime')
                        ) {
                        $(this).hide();
                        var idxFlg = $(this).data('idxfl');
                        $('.filterTrfPriceNOD'+idxFlg).hide();
                    } else {
                        $(this).show();
                        $('.filterTrfPriceNOD'+idxFlg).show();
                    }
                });
            }

            $("#checkout_flight").show();
            $('input[type=radio][name=radioType].choiceFlightType').change(function() {
                if (this.value == 'one_way') {
                    $("#checkout_flight").hide();
                }
                else if (this.value == 'return') {
                    $("#checkout_flight").show();
                }
            });

            $("#changeSearchAnchor").click(function(){
                $("#changeSearchContent").toggle();
                return false;
            });

            /*-----SLIDER DEPARTURE-----*/
            $("#sliderPriceDeparture").slider({
                range: "min",
                value: 1000,
                min: 1,
                max: 1000,
                slide: function( event, ui ) {
                    $("#amountDeparture").html("$0 - $" + ui.value);
                },
                stop: function(event, ui) {
                    <?php
                    if( count($arrayFilterPrice) > 0 ) {
                        foreach( $arrayFilterPrice AS $keyD => $valueD ) {
                    ?>
                            if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('hidePrice') ||
                                $("div.flightListNoD<?php echo $keyD; ?>").hasClass('showPrice')
                                ) {
                                $("div.flightListNoD<?php echo $keyD; ?>").removeClass('hidePrice').removeClass('showPrice');
                            }

                            var priceSelected = '<?php echo $valueD; ?>';

                            if( priceSelected > 0 && priceSelected < ui.value ) {
                                $("div.flightListNoD<?php echo $keyD; ?>").show().addClass('showPrice');
                                $(".filterTrfPriceNOD<?php echo $keyD; ?>").show();
                            }
                            else {
                                $("div.flightListNoD<?php echo $keyD; ?>").hide().addClass('hidePrice');
                                $(".filterTrfPriceNOD<?php echo $keyD; ?>").hide();
                                localStorageDeparture["priceID#<?php echo $keyD; ?>"] = "<?php echo $keyD; ?>";
                                console.log(localStorageDeparture);
                            }
                    <?php
                        }
                    }
                    ?>

                    filterFlightDeparture();
                }
            });
            $("#amountDeparture").html("$0 - $" + $("#sliderPriceDeparture").slider("value"));
            /*-----END OF SLIDER DEPARTURE-----*/

            $('#btnFPSubmit').click(function() {
                if( $("#email_fp").val() == "" ) {
                    var msg = "<span style='color:red'>Please enter your email address.</span>";
                    $("#forgot_password_ajax_msg").html(msg);
                    return false;
                }
                else {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url(); ?>forgot_password/do_submission',
                        data: {
                            email: $("#email_fp").val()
                        },
                        success: function(data)
                        {
                            if( data == 0 ) {
                                var msg = "<span style='color:red'>This email address has never registered before. Please try another email address.</span>";
                                $("#forgot_password_ajax_msg").html(msg);
                                return false;
                            }
                            else if( data == 1 ) {
                                var msg = "<span style='color:yellow'>An email has been sent to you in order to retrieve your password.</span>";
                                $("#email_form_fp").hide();
                                $("#btn_form_fp").hide();
                                $("#forgot_password_ajax_msg").html(msg);
                                return false;
                            }
                        }
                    });
                    return false;
                }
            });
            $('#btnLogin').click(function() {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>login/do_login_process',
                    data: {
                        email: $("#login_email").val(),
                        password: $("#login_password").val(),
                        remember_me: $('#login_checkbox:checked').val()
                    },
                    success: function(data)
                    {
                        if( data == 0 ) {
                            var msg = "<span style='color:red'>Invalid login account. Please try again.</span>";
                            $("#login_ajax_msg").html(msg);
                            return false;
                        }
                        else if( data == 1 ) {
                            var msg = "<span style='color:yellow'>Login successfully.</span>";
                            $("#login_ajax_msg").html(msg);
                            window.location = '<?php echo current_url(); ?>';
                            return false;
                        }
                    }
                });
                return false;
            });

            /* Filter */
            $("#priceFilterContent").hide();
            $("#timeFilterContent").hide();
            $("#airlineFilterContent").hide();
            $("#priceFilterBtn").click(function(){
                $("#priceFilterContent").toggle();
                $("#transferFilterContent").hide();
                $("#airlineFilterContent").hide();
                $("#timeFilterContent").hide();
                return false;
            });
            $("#transferFilterBtn").click(function(){
                $("#transferFilterContent").toggle();
                $("#priceFilterContent").hide();
                $("#airlineFilterContent").hide();
                $("#timeFilterContent").hide();
                return false;
            });
            $("#airlineFilterBtn").click(function(){
                $("#airlineFilterContent").toggle();
                $("#priceFilterContent").hide();
                $("#transferFilterContent").hide();
                $("#timeFilterContent").hide();
                return false;
            });
            $("#timeFilterBtn").click(function(){
                $("#timeFilterContent").toggle();
                $("#priceFilterContent").hide();
                $("#airlineFilterContent").hide();
                $("#transferFilterContent").hide();
                return false;
            });

            /* tip toe */
            $('.tip').tipr();

            var passingData = {
                departureFlightName      : '',
                departureFlightCode      : '',
                departureDateFrom        : '',
                departureDateTo          : '',
                departureTimeFrom        : '',
                departureTimeTo          : '',
                departureCityNameFrom    : '',
                departureCityNameTo      : '',
                departureCityCodeFrom    : '',
                departureCityCodeTo      : '',
                departureAirportNameFrom : '',
                departureAirportNameTo   : '',
                departureTimeTaken       : '',
                departureBaggage         : '',
                departureMeal            : '',
                departureTotalTransit    : '',
                departureTotalFlightTime : '',
                departureTotalPrice      : '',
                departureFlightResBookDesigCode : '',
                departureFlightAirEquipType : '',
                departureFlightMarriageGrp : '',
                departureFlightEticket : '',
                departurePriceAdultTaxFare : '',
                departurePriceAdultBaseFare : '',
                departurePriceChildTaxFare : '',
                departurePriceChildBaseFare : '',
                departurePriceInfantTaxFare : '',
                departurePriceInfantBaseFare : '',
                departureTimezone_from : '',
                departureTerminalID_from : '',
                departureTimezone_to : '',
                departureTerminalID_to : '',

                departureFareBasisCode : '',
                arrivalFlightName        : '',
                arrivalFlightCode        : '',
                arrivalDateFrom          : '',
                arrivalDateTo            : '',
                arrivalTimeFrom          : '',
                arrivalTimeTo            : '',
                arrivalCityNameFrom      : '',
                arrivalCityNameTo        : '',
                arrivalCityCodeFrom      : '',
                arrivalCityCodeTo        : '',
                arrivalAirportNameFrom   : '',
                arrivalAirportNameTo     : '',
                arrivalTimeTaken         : '',
                arrivalBaggage           : '',
                arrivalMeal              : '',
                arrivalTotalTransit      : '',
                arrivalTotalFlightTime   : '',
                arrivalTotalPrice        : '',

                arrivalFlightResBookDesigCode : '',
                arrivalFlightAirEquipType : '',
                arrivalFlightMarriageGrp : '',
                arrivalFlightEticket : '',
                arrivalPriceAdultTaxFare : '',
                arrivalPriceAdultBaseFare : '',
                arrivalPriceChildTaxFare : '',
                arrivalPriceChildBaseFare : '',
                arrivalPriceInfantTaxFare : '',
                arrivalPriceInfantBaseFare : '',
                arrivalFareBasisCode : '',

                arrivalTerminalID_from : '',
                arrivalTimezone_from : '',
                arrivalTerminalID_to : '',
                arrivalTimezone_to : '',
                TotalPriceAdminFare : '',

                departuremealcode : '',
                arrivalmealcode : '',

                noofAdult                : '<?php echo $flightAdult; ?>',
                noofChild                : '<?php echo $flightChild; ?>',
                noofInfant               : '<?php echo $flightInfant; ?>',
                flightClass              : '<?php echo $flightClass; ?>',
                isReturnFlight           : ''
            };
            /*--OTHERS--*/

            /*--Checkbox Filter Transfer (DEPARTURE)--*/
            <?php if( count($arrayFilterTransfer) > 0 ) { ?>
                $('#flightTransferDirectAD').change(function() {
                    if ($(this).prop('checked')) {
                        <?php
                        foreach( $arrayFilterTransfer AS $keyD => $valueD ) {
                            if( $valueD == "DIRECT" ) {
                        ?>
                        if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTransfer') ||
                            $("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTransfer')
                            ) {
                            $("div.flightListNoD<?php echo $keyD; ?>").removeClass('hideTransfer').removeClass('showTransfer');
                        }

                            $("div.flightListNoD<?php echo $keyD; ?>").show().addClass('showTransfer');
                            $(".filterTrfPriceNOD<?php echo $keyD; ?>").show();
                        <?php
                            }
                        }
                        ?>
                    }
                    else {
                        <?php
                        foreach( $arrayFilterTransfer AS $keyD => $valueD ) {
                            if( $valueD == "DIRECT" ) {
                        ?>
                        if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTransfer') ||
                            $("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTransfer')
                            ) {
                            $("div.flightListNoD<?php echo $keyD; ?>").removeClass('hideTransfer').removeClass('showTransfer');
                        }

                        $("div.flightListNoD<?php echo $keyD; ?>").hide().addClass('hideTransfer');
                        $(".filterTrfPriceNOD<?php echo $keyD; ?>").hide();
                        <?php
                            }
                        }
                        ?>
                    }

                    filterFlightDeparture();
                });
                $('#flightTransferA1').change(function() {
                    if ($(this).prop('checked')) {
                        <?php
                        foreach( $arrayFilterTransfer AS $keyD => $valueD ) {
                            if( $valueD == "1" ) {
                        ?>

                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTransfer') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTransfer')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTransfer').removeClass('hideTransfer');
                                }
                        $("div.flightListNoD<?php echo $keyD; ?>").show().addClass('showTransfer');
                        $(".filterTrfPriceNOD<?php echo $keyD; ?>").show();
                        <?php
                            }
                        }
                        ?>
                    }
                    else {
                        <?php
                        foreach( $arrayFilterTransfer AS $keyD => $valueD ) {
                            if( $valueD == "1" ) {
                        ?>

                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTransfer') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTransfer')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTransfer').removeClass('hideTransfer');
                                }
                        $("div.flightListNoD<?php echo $keyD; ?>").hide().addClass('hideTransfer');
                        $(".filterTrfPriceNOD<?php echo $keyD; ?>").hide();
                        <?php
                            }
                        }
                        ?>
                    }

                    filterFlightDeparture();
                });
                $('#flightTransferA2').change(function() {
                    if ($(this).prop('checked')) {
                        <?php
                        foreach( $arrayFilterTransfer AS $keyD => $valueD ) {
                            if( $valueD == "2" ) {
                        ?>

                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTransfer') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTransfer')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTransfer').removeClass('hideTransfer');
                                }
                        $("div.flightListNoD<?php echo $keyD; ?>").show().addClass('showTransfer');
                        $(".filterTrfPriceNOD<?php echo $keyD; ?>").show();
                        <?php
                            }
                        }
                        ?>
                    }
                    else {
                        <?php
                        foreach( $arrayFilterTransfer AS $keyD => $valueD ) {
                            if( $valueD == "2" ) {
                        ?>
                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTransfer') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTransfer')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTransfer').removeClass('hideTransfer');
                                }
                        $("div.flightListNoD<?php echo $keyD; ?>").hide().addClass('hideTransfer');
                        $(".filterTrfPriceNOD<?php echo $keyD; ?>").hide();
                        <?php
                            }
                        }
                        ?>
                    }

                    filterFlightDeparture();
                });
                $('#flightTransferA3').change(function() {
                    if ($(this).prop('checked')) {
                        <?php
                        foreach( $arrayFilterTransfer AS $keyD => $valueD ) {
                            if( $valueD == "3" ) {
                        ?>

                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTransfer') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTransfer')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTransfer').removeClass('hideTransfer');
                                }
                        $("div.flightListNoD<?php echo $keyD; ?>").show().addClass('showTransfer');
                        $(".filterTrfPriceNOD<?php echo $keyD; ?>").show();
                        <?php
                            }
                        }
                        ?>
                    }
                    else {
                        <?php
                        foreach( $arrayFilterTransfer AS $keyD => $valueD ) {
                            if( $valueD == "3" ) {
                        ?>

                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTransfer') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTransfer')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTransfer').removeClass('hideTransfer');
                                }
                        $("div.flightListNoD<?php echo $keyD; ?>").hide().addClass('hideTransfer');
                        $(".filterTrfPriceNOD<?php echo $keyD; ?>").hide();
                        <?php
                            }
                        }
                        ?>
                    }

                    filterFlightDeparture();
                });
            <?php
            }
            ?>
            /*--End of Checkbox Filter Transfer (DEPARTURE)--*/

            /*--Checkbox Filter Airline (DEPARTURE)--*/
            <?php
            if( count($arrayFilterAirline) > 0 ) {
                foreach( $arrayFilterAirline AS $keyD => $valueD ) {
            ?>
                    $('#flightCodeCKD<?php echo $keyD; ?>').change(function() {

                        if($("div#filterAirlineD<?php echo $keyD; ?>").hasClass('hideAirline') ||
                            $("div#filterAirlineD<?php echo $keyD; ?>").hasClass('showAirline')
                            ) {
                            $("div#filterAirlineD<?php echo $keyD; ?>").removeClass('hideAirline').removeClass('showAirline');
                        }

                        if ($(this).prop('checked')) {
                            $("div#filterAirlineD<?php echo $keyD; ?>").show().addClass('showAirline');
                            $(".filterAirlineNOD<?php echo $keyD; ?>").show();
                        }
                        else {
                            $("div#filterAirlineD<?php echo $keyD; ?>").hide().addClass('hideAirline');
                            $(".filterAirlineNOD<?php echo $keyD; ?>").hide();
                            localStorageDeparture["airlineID#<?php echo $keyD; ?>"] = "<?php echo $keyD; ?>";
                            /*console.log(localStorageDeparture);*/
                        }

                        filterFlightDeparture();
                    });
            <?php
                }
            }
            ?>
            /*--End of Checkbox Filter Airline (DEPARTURE)--*/

            /*--Checkbox Filter Time (DEPARTURE)--*/
            <?php
            if( count($arrayFilterTimeDeparture) > 0 ) {
            ?>
                $('#flightTimeCK4D').change(function() {
                    if ($(this).prop('checked')) {
                        <?php
                        foreach( $arrayFilterTimeDeparture AS $keyD => $valueD ) {
                            if( strtotime($valueD) >= strtotime("04:00:00") && strtotime($valueD) <= strtotime("11:00:00") ) {
                        ?>
                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTime') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTime')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTime').removeClass('hideTime');
                                }

                        $("div.flightListNoD<?php echo $keyD; ?>").show().addClass('showTime');
                        $(".filterTrfPriceNOD<?php echo $keyD; ?>").show();
                        <?php
                            }
                        }
                        ?>
                    }
                    else {
                        <?php
                        foreach( $arrayFilterTimeDeparture AS $keyD => $valueD ) {
                            if( strtotime($valueD) >= strtotime("04:00:00") && strtotime($valueD) <= strtotime("11:00:00") ) {
                        ?>
                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTime') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTime')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTime').removeClass('hideTime');
                                }
                                $("div.flightListNoD<?php echo $keyD; ?>").hide().addClass('hideTime');
                                $(".filterTrfPriceNOD<?php echo $keyD; ?>").hide();
                        <?php
                            }
                        }
                        ?>
                    }
                    filterFlightDeparture();
                });
                $('#flightTimeCK11D').change(function() {
                    if ($(this).prop('checked')) {
                        <?php
                        foreach( $arrayFilterTimeDeparture AS $keyD => $valueD ) {
                            if( strtotime($valueD) >= strtotime("11:00:00") && strtotime($valueD) <= strtotime("15:00:00") ) {
                        ?>
                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTime') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTime')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTime').removeClass('hideTime');
                                }
                        $("div.flightListNoD<?php echo $keyD; ?>").show().addClass('showTime');
                        $(".filterTrfPriceNOD<?php echo $keyD; ?>").show();
                        <?php
                            }
                        }
                        ?>
                    }
                    else {
                        <?php
                        foreach( $arrayFilterTimeDeparture AS $keyD => $valueD ) {
                            if( strtotime($valueD) >= strtotime("11:00:00") && strtotime($valueD) <= strtotime("15:00:00") ) {
                        ?>
                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTime') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTime')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTime').removeClass('hideTime');
                                }
                                $("div.flightListNoD<?php echo $keyD; ?>").hide().addClass('hideTime');
                                $(".filterTrfPriceNOD<?php echo $keyD; ?>").hide();
                        <?php
                            }
                        }
                        ?>
                    }
                    filterFlightDeparture();
                });
                $('#flightTimeCK15D').change(function() {
                    if ($(this).prop('checked')) {
                        <?php
                        foreach( $arrayFilterTimeDeparture AS $keyD => $valueD ) {
                            if( strtotime($valueD) >= strtotime("15:00:00") && strtotime($valueD) <= strtotime("18:30:00") ) {
                        ?>
                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTime') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTime')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTime').removeClass('hideTime');
                                }
                                $("div.flightListNoD<?php echo $keyD; ?>").show().addClass('showTime');
                                $(".filterTrfPriceNOD<?php echo $keyD; ?>").show();
                        <?php
                            }
                        }
                        ?>
                    }
                    else {
                        <?php
                        foreach( $arrayFilterTimeDeparture AS $keyD => $valueD ) {
                            if( strtotime($valueD) >= strtotime("15:00:00") && strtotime($valueD) <= strtotime("18:30:00") ) {
                        ?>

                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTime') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTime')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTime').removeClass('hideTime');
                                }
                                $("div.flightListNoD<?php echo $keyD; ?>").hide().addClass('hideTime');
                                $(".filterTrfPriceNOD<?php echo $keyD; ?>").hide();
                        <?php
                            }
                        }
                        ?>
                    }
                    filterFlightDeparture();
                });
                $('#flightTimeCK18D').change(function() {
                    if ($(this).prop('checked')) {
                        <?php
                        foreach( $arrayFilterTimeDeparture AS $keyD => $valueD ) {
                            if( strtotime($valueD) >= strtotime("18:30:00") && strtotime($valueD) <= strtotime("23:30:00") ) {
                        ?>
                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTime') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTime')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTime').removeClass('hideTime');
                                }
                                $("div.flightListNoD<?php echo $keyD; ?>").show().addClass('showTime');
                                $(".filterTrfPriceNOD<?php echo $keyD; ?>").show();
                        <?php
                            }
                        }
                        ?>
                    }
                    else {
                        <?php
                        foreach( $arrayFilterTimeDeparture AS $keyD => $valueD ) {
                            if( strtotime($valueD) >= strtotime("18:30:00") && strtotime($valueD) <= strtotime("23:30:00") ) {
                        ?>
                                if($("div.flightListNoD<?php echo $keyD; ?>").hasClass('showTime') ||
                                    $("div.flightListNoD<?php echo $keyD; ?>").hasClass('hideTime')
                                    ) {
                                    $("div.flightListNoD<?php echo $keyD; ?>").removeClass('showTime').removeClass('hideTime');
                                }
                                $("div.flightListNoD<?php echo $keyD; ?>").hide().addClass('hideTime');
                                $(".filterTrfPriceNOD<?php echo $keyD; ?>").hide();
                        <?php
                            }
                        }
                        ?>
                    }
                    filterFlightDeparture();
                });
            <?php
            }
            ?>
            /*--End of Checkbox Filter Time (DEPARTURE)--*/

            /*--Checkbox Filter Click Button Add to Cart (ARRIVAL)--*/
            <?php
            if( count($arrayBtnArrival) > 0 ) {
                foreach( $arrayBtnArrival AS $valueAP ) {
            ?>
                    $("#clickPriceArrival<?php echo $valueAP; ?>").click(function(){
                        $('#divLoading3').show();
                        if( this == "<?php echo base_url(); ?>search/flight_result#<?php echo $valueAP; ?>" ) {
                            passingData["departureFlightName"]      = $("#departureFlightName<?php echo $valueAP; ?>").text();
                            passingData["departureFlightCode"]      = $("#departureFlightCode<?php echo $valueAP; ?>").text();
                            passingData["departureDateFrom"]        = $("#departureDateFrom<?php echo $valueAP; ?>").text();
                            passingData["departureDateTo"]          = $("#departureDateTo<?php echo $valueAP; ?>").text();
                            passingData["departureTimeFrom"]        = $("#departureTimeFrom<?php echo $valueAP; ?>").text();
                            passingData["departureTimeTo"]          = $("#departureTimeTo<?php echo $valueAP; ?>").text();
                            passingData["departureCityNameFrom"]    = $("#departureCityNameFrom<?php echo $valueAP; ?>").text();
                            passingData["departureCityNameTo"]      = $("#departureCityNameTo<?php echo $valueAP; ?>").text();
                            passingData["departureCityCodeFrom"]    = $("#departureCityCodeFrom<?php echo $valueAP; ?>").text();
                            passingData["departureCityCodeTo"]      = $("#departureCityCodeTo<?php echo $valueAP; ?>").text();
                            passingData["departureAirportNameFrom"] = $("#departureAirportNameFrom<?php echo $valueAP; ?>").text();
                            passingData["departureAirportNameTo"]   = $("#departureAirportNameTo<?php echo $valueAP; ?>").text();
                            passingData["departureTimeTaken"]       = $("#departureTimeTaken<?php echo $valueAP; ?>").text();
                            passingData["departureBaggage"]         = $("#departureBaggage<?php echo $valueAP; ?>").text();
                            passingData["departureMeal"]            = $("#departureMeal<?php echo $valueAP; ?>").text();
                            passingData["departureTotalTransit"]    = $("#departureTotalTransit<?php echo $valueAP; ?>").text();
                            passingData["departureTotalFlightTime"] = $("#departureTotalFlightTime<?php echo $valueAP; ?>").text();
                            passingData["departureTotalPrice"]      = $("#departureTotalPrice<?php echo $valueAP; ?>").text();
                            /* new addition 7.3.2017 bto */
                            passingData["departureFlightResBookDesigCode"]= $("#departureFlightResBookDesigCode<?php echo $valueAP; ?>").text();
                            passingData["departureFlightAirEquipType"]    = $("#departureFlightAirEquipType<?php echo $valueAP; ?>").text();
                            passingData["departureFlightMarriageGrp"]     = $("#departureFlightMarriageGrp<?php echo $valueAP; ?>").text();
                            passingData["departureFlightEticket"]         = $("#departureFlightEticket<?php echo $valueAP; ?>").text();

                            /* new addition 19 Mei 2017 to handle price detail */
                            passingData["departurePriceAdultTaxFare"] = $("#departurePriceAdultTaxFare<?php echo $valueAP;?>").text();
                            passingData["departurePriceAdultBaseFare"] = $("#departurePriceAdultBaseFare<?php echo $valueAP;?>").text();
                            passingData["departurePriceChildTaxFare"] = $("#departurePriceChildTaxFare<?php echo $valueAP;?>").text();
                            passingData["departurePriceChildBaseFare"] = $("#departurePriceChildBaseFare<?php echo $valueAP;?>").text();
                            passingData["departurePriceInfantTaxFare"] = $("#departurePriceInfantTaxFare<?php echo $valueAP;?>").text();
                            passingData["departurePriceInfantBaseFare"] = $("#departurePriceInfantBaseFare<?php echo $valueAP;?>").text();

                            /* 22 Mei 2017 */
                            passingData["departureTerminalID_from"] = $("#departureTerminalID_from<?php echo $valueAP;?>").text();
                            passingData["departureTimezone_from"] = $("#departureTimezone_from<?php echo $valueAP;?>").text();
                            passingData["departureTerminalID_to"] = $("#departureTerminalID_to<?php echo $valueAP;?>").text();
                            passingData["departureTimezone_to"] = $("#departureTimezone_to<?php echo $valueAP;?>").text();
                            /* * */

                            passingData["TotalPriceAdminFare"] = $("#TotalPriceAdminFare<?php echo $valueAP;?>").text();

                            passingData["arrivalFlightName"]      = $("#arrivalFlightName<?php echo $valueAP; ?>").text();
                            passingData["arrivalFlightCode"]      = $("#arrivalFlightCode<?php echo $valueAP; ?>").text();
                            passingData["arrivalDateFrom"]        = $("#arrivalDateFrom<?php echo $valueAP; ?>").text();
                            passingData["arrivalDateTo"]          = $("#arrivalDateTo<?php echo $valueAP; ?>").text();
                            passingData["arrivalTimeFrom"]        = $("#arrivalTimeFrom<?php echo $valueAP; ?>").text();
                            passingData["arrivalTimeTo"]          = $("#arrivalTimeTo<?php echo $valueAP; ?>").text();
                            passingData["arrivalCityNameFrom"]    = $("#arrivalCityNameFrom<?php echo $valueAP; ?>").text();
                            passingData["arrivalCityNameTo"]      = $("#arrivalCityNameTo<?php echo $valueAP; ?>").text();
                            passingData["arrivalCityCodeFrom"]    = $("#arrivalCityCodeFrom<?php echo $valueAP; ?>").text();
                            passingData["arrivalCityCodeTo"]      = $("#arrivalCityCodeTo<?php echo $valueAP; ?>").text();
                            passingData["arrivalAirportNameFrom"] = $("#arrivalAirportNameFrom<?php echo $valueAP; ?>").text();
                            passingData["arrivalAirportNameTo"]   = $("#arrivalAirportNameTo<?php echo $valueAP; ?>").text();
                            passingData["arrivalTimeTaken"]       = $("#arrivalTimeTaken<?php echo $valueAP; ?>").text();
                            passingData["arrivalBaggage"]         = $("#arrivalBaggage<?php echo $valueAP; ?>").text();
                            passingData["arrivalMeal"]            = $("#arrivalMeal<?php echo $valueAP; ?>").text();
                            passingData["arrivalTotalTransit"]    = $("#arrivalTotalTransit<?php echo $valueAP; ?>").text();
                            passingData["arrivalTotalFlightTime"] = $("#arrivalTotalFlightTime<?php echo $valueAP; ?>").text();
                            passingData["arrivalTotalPrice"]      = $("#arrivalTotalPrice<?php echo $valueAP; ?>").text();
                            /* new addition 7.3.2017 bto */
                            passingData["arrivalFlightResBookDesigCode"]= $("#arrivalFlightResBookDesigCode<?php echo $valueAP; ?>").text();
                            passingData["arrivalFlightAirEquipType"]      = $("#arrivalFlightAirEquipType<?php echo $valueAP; ?>").text();
                            passingData["arrivalFlightMarriageGrp"]   = $("#arrivalFlightMarriageGrp<?php echo $valueAP; ?>").text();
                            passingData["arrivalFlightEticket"]       = $("#arrivalFlightEticket<?php echo $valueAP; ?>").text();

                            /* new addition 19 Mei 2017 to handle price detail */
                            passingData["arrivalPriceAdultTaxFare"] = $("#arrivalPriceAdultTaxFare<?php echo $valueAP;?>").text();
                            passingData["arrivalPriceAdultBaseFare"] = $("#arrivalPriceAdultBaseFare<?php echo $valueAP;?>").text();
                            passingData["arrivalPriceChildTaxFare"] = $("#arrivalPriceChildTaxFare<?php echo $valueAP;?>").text();
                            passingData["arrivalPriceChildBaseFare"] = $("#arrivalPriceChildBaseFare<?php echo $valueAP;?>").text();
                            passingData["arrivalPriceInfantTaxFare"] = $("#arrivalPriceInfantTaxFare<?php echo $valueAP;?>").text();
                            passingData["arrivalPriceInfantBaseFare"] = $("#arrivalPriceInfantBaseFare<?php echo $valueAP;?>").text();
                            passingData["arrivalTerminalID_from"] = $("#arrivalTerminalID_from<?php echo $valueAP;?>").text();
                            passingData["arrivalTimezone_from"] = $("#arrivalTimezone_from<?php echo $valueAP;?>").text();

                            passingData["arrivalTerminalID_to"] = $("#arrivalTerminalID_to<?php echo $valueAP;?>").text();
                            passingData["arrivalTimezone_to"] = $("#arrivalTimezone_to<?php echo $valueAP;?>").text();

                            passingData["TotalPriceAdminFare"] = $("#TotalPriceAdminFare<?php echo $valueAP;?>").text();

                            passingData["isReturnFlight"] = "1";
                            /* 24 Mei */
                            passingData["departureFareBasisCode"] = $("#departureFareBasisCode<?php echo $valueAP;?>").text();
                            passingData["departureFareBasisCodeChild"] = $("#departureFareBasisCodeChild<?php echo $valueAP;?>").text();
                            passingData["departureFareBasisCodeInfant"] = $("#departureFareBasisCodeInfant<?php echo $valueAP;?>").text();
                            passingData["arrivalFareBasisCode"] = $("#arrivalFareBasisCode<?php echo $valueAP;?>").text();
                            passingData["arrivalFareBasisCodeChild"] = $("#arrivalFareBasisCodeChild<?php echo $valueAP;?>").text();
                            passingData["arrivalFareBasisCodeInfant"] = $("#arrivalFareBasisCodeInfant<?php echo $valueAP;?>").text();
                            passingData['departuremealcode'] = $("#departureMealCode<?php echo $valueAP;?>").text();
                            passingData['arrivalmealcode'] = $("#arrivalMealCode<?php echo $valueAP;?>").text();

                            /*console.log(passingData);*/
                            var data_to_send = JSON.stringify(passingData);
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>cart/do_add_cartFlight",
                                data: {data : data_to_send},
                                cache: false,
                                success: function(data){
                                    window.location.replace("<?php echo base_url(); ?>cart/index#flight_cart");
                                }
                            });
                        }
                    });
            <?php
                }
            }
            ?>
            /*--End of Checkbox Filter Click Button Add to Cart (ARRIVAL)--*/

           /* var substringMatcher = function(strs) {
                return function findMatches(q, cb) {
                    var matches, substringRegex;
                    matches = [];
                    substrRegex = new RegExp(q, 'i');
                    $.each(strs, function(i, str) {
                        if (substrRegex.test(str)) {
                            matches.push(str);
                        }
                    });
                    cb(matches);
                };
            };
            var states       = [<?php echo $this->All->list_city_country(); ?>];
            $('#flight-going .typeahead').typeahead(
                {
                    hint: true,
                    highlight: true,
                    minLength: 3
                },
                {
                    name: 'states',
                    source: substringMatcher(states)
                }
            );

*/
        });
    </script>
    <script>
        window.onload = function() {
          document.getElementById('flightAdult').value = '1';
          document.getElementById('flightChild').value = '0';
          document.getElementById('flightInfant').value = '0';
        }
    </script>
</body>
</html>