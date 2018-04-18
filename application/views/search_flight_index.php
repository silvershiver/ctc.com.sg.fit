<?php
	/*--FILTER CLICK PRICE--*/
	$arrayBtn = array();
	if( $totalFlight > 0 ) {
		for($a=0; $a<$totalFlight; $a++) {
			$arrayBtn[] = $a;
		}
	}

	/*--END OF FILTER CLICK PRICE--*/
	/*--FILTER PRICE--*/

	if( $totalFlight > 0 ) {

		for($a=0; $a<$totalFlight; $a++) {
			if( isset($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][0]) ) {
				$flightSegment = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"];
				$countFlightSegment = count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]);
				$departureFlightCodeArr = array();

				for( $fs=0; $fs<$countFlightSegment; $fs++ ) {
					$flightCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"];
					$flightOperatingAirline = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["FlightNumber"];
					$departureFlightCodeArr{$a}[] = $flightCode;

				}

				if (count(array_unique($departureFlightCodeArr{$a})) === 1) {
				} else {
					unset($flight_results[$a]);
				}
			} else {
				$flightCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];

			}
		}
	}
	$flight_results   = array_values($flight_results);

	//echo "<pre>";
	//print_r($flight_results);
	//echo "</pre>";
	$totalFlight 	  = count($flight_results);
	$arrayFilterPrice = array();
	$arrayFilterTransfer = array();
	$arrayFilterTime = array();
	$arrayFilterAirlines = array();
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
			$adultFare[$a]   = 0;
			$childFare[$a]   = 0;
			$infantFare[$a]  = 0;

			$adultTaxFare[$a]  = 0;
			$childTaxFare[$a]  = 0;
			$infantTaxFare[$a]  = 0;
			$tmpflightAdult[$a] = 0; $tmpflightChild[$a] = 0; $tmpflightInfant[$a] = 0;

			$priceInfo  	 = $flight_results[$a]["AirItineraryPricingInfo"]["ItinTotalFare"];
			$printEquiveFare = ceil($priceInfo["EquivFare"]["@attributes"]["Amount"]);
			$printTaxesFare  = ceil($priceInfo["Taxes"]["Tax"]["@attributes"]["Amount"]);


			if(isset($flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown'][0]) && count($flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']) > 1) {
				$PTCBreakDown = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown'];
				$totalFare = 0;

				foreach($PTCBreakDown as $idxPTC=>$priceData) {

					$passType = $priceData['PassengerTypeQuantity']['@attributes']['Code'];
					$baseFareAmount = $priceData['PassengerFare']['BaseFare']['@attributes']['Amount'];
					$taxFareAmount = $priceData['PassengerFare']['Taxes']['TotalTax']['@attributes']['Amount'];
					$baseFareAmount = $baseFareAmount + ($baseFareAmount * (FLIGHT_ADMIN_PERCENT/100));
                    $taxFareAmount = $taxFareAmount + ($taxFareAmount * (FLIGHT_ADMIN_PERCENT/100));
                    $TotFare = 0;

					if ($passType == 'ADT') {
						if($flightChild != 0 && $idxPTC == 1) {
							$tmpflightChild[$a] += $priceData['PassengerTypeQuantity']['@attributes']['Quantity'];

							$TotFare = ceil($baseFareAmount) + ceil($taxFareAmount);
							$totalFare += ($flightChild * $TotFare);

							$childFare[$a] += ceil($baseFareAmount);
							$childTaxFare[$a] += ceil($taxFareAmount);
						} else if ($flightInfant != 0 && $idxPTC == 1) {
							$tmpflightInfant[$a] += $priceData['PassengerTypeQuantity']['@attributes']['Quantity'];

							$TotFare = ceil($baseFareAmount) + ceil($taxFareAmount);
							$totalFare += ($flightInfant * $TotFare);

							$infantFare[$a] += ceil($baseFareAmount);
							$infantTaxFare[$a] += ceil($taxFareAmount);
						} else {
							$tmpflightAdult[$a] += $priceData['PassengerTypeQuantity']['@attributes']['Quantity'];

							$TotFare = ceil($baseFareAmount) + ceil($taxFareAmount);
							$totalFare += ($flightAdult * $TotFare);
							$adultFare[$a] += ceil($baseFareAmount);
							$adultTaxFare[$a] += ceil($taxFareAmount);
						}


					}
					else if ($passType == 'CNN') {
						if ($flightInfant != 0 && $idxPTC == 2) {
							$tmpflightInfant[$a] += $priceData['PassengerTypeQuantity']['@attributes']['Quantity'];

							$TotFare = ceil($baseFareAmount) + ceil($taxFareAmount);
							$totalFare += ($flightInfant * $TotFare);

							$infantFare[$a] += ceil($baseFareAmount);
							$infantTaxFare[$a] += ceil($taxFareAmount);
						} else {
							$tmpflightChild[$a] += $priceData['PassengerTypeQuantity']['@attributes']['Quantity'];

							$TotFare = ceil($baseFareAmount) + ceil($taxFareAmount);
							$totalFare += ($flightChild * $TotFare);

							$childFare[$a] += ceil($baseFareAmount);
							$childTaxFare[$a] += ceil($taxFareAmount);
							//$totalFare += ceil($infantFare[$a] + $infantTaxFare[$a]);
						}

					}
					else if($passType == 'INF') {
						$tmpflightInfant[$a] += $priceData['PassengerTypeQuantity']['@attributes']['Quantity'];

						$TotFare = ceil($baseFareAmount) + ceil($taxFareAmount);
						$totalFare += ($flightInfant * $TotFare);

						$infantFare[$a] += ceil($baseFareAmount);
						$infantTaxFare[$a] += ceil($taxFareAmount);
						//$totalFare += ceil($infantFare[$a] + $infantTaxFare[$a]);

					}
				}
			}
			else {
				$totalFare = 0;
				$TotFare = 0;
				$passType = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Code'];
				$baseFareAmount = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['BaseFare']['@attributes']['Amount'];
				$taxFareAmount = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['Taxes']['TotalTax']['@attributes']['Amount'];

				$baseFareAmount = $baseFareAmount + ($baseFareAmount * (FLIGHT_ADMIN_PERCENT/100));
                $taxFareAmount = $taxFareAmount + ($taxFareAmount * (FLIGHT_ADMIN_PERCENT/100));

				if($passType == 'ADT') {
					$tmpflightAdult[$a] += $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Quantity'];

					$TotFare = ceil($baseFareAmount) + ceil($taxFareAmount);
					$totalFare += ($flightAdult * $TotFare);

					$adultFare[$a] += ceil($baseFareAmount);
					$adultTaxFare[$a] += ceil($taxFareAmount);
					//$totalFare += ceil($adultFare[$a] + $adultTaxFare[$a]);

					/*$adultFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'];
					$adultBaggageInfo[$a][] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['TPA_Extensions']['BaggageInformationList']['BaggageInformation']['Allowance']['@attributes']['Weight'].' '.$flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['TPA_Extensions']['BaggageInformationList']['BaggageInformation']['Allowance']['@attributes']['Unit'];

					if(count($adultFareBasisCode[$a]) > 1) {
							$adultFareBasisCode[$a] = array_unique($adultFareBasisCode[$a]);
							if(count($childFareBasisCode[$a]) > 1) {
								$adultFareBasisCode[$a] = implode(",", $adultFareBasisCode[$a]);
							} else {
								$adultFareBasisCode[$a] = $adultFareBasisCode[$a][0];
							}
						}	*/
				}
				else if($passType == 'CNN') {
					$tmpflightChild[$a] += $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Quantity'];

					$TotFare = ceil($baseFareAmount) + ceil($taxFareAmount);

					$totalFare += ($flightChild * $TotFare);

					$childFare[$a] += ceil($baseFareAmount);
					$childTaxFare[$a] += ceil($taxFareAmount);
					//$totalFare += ceil($childFare[$a] + $childTaxFare[$a]);

					/*$childFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'];
					$childBaggageInfo[$a][] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['TPA_Extensions']['BaggageInformationList']['BaggageInformation']['Allowance']['@attributes']['Weight'].' '.$flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['TPA_Extensions']['BaggageInformationList']['BaggageInformation']['Allowance']['@attributes']['Unit'];

					if(count($childFareBasisCode[$a]) > 1) {
							$childFareBasisCode[$a] = array_unique($childFareBasisCode[$a]);
							if(count($childFareBasisCode[$a]) > 1) {
								$childFareBasisCode[$a] = implode(",", $childFareBasisCode[$a]);
							} else {
								$childFareBasisCode[$a] = $childFareBasisCode[$a][0];
							}
						}	*/
				}
				else if($passType == 'INF') {
					$tmpflightInfant[$a] += $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Quantity'];

					$TotFare = ceil($baseFareAmount) + ceil($taxFareAmount);

					$totalFare += ($flightInfant * $TotFare);

					$infantFare[$a] += ceil($baseFareAmount);
					$infantTaxFare[$a] += ceil($taxFareAmount);
					//$totalFare += ceil($infantFare[$a] + $infantTaxFare[$a]);

					/*$infantFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'];
					$infantBaggageInfo[$a][] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['TPA_Extensions']['BaggageInformationList']['BaggageInformation']['Allowance']['@attributes']['Weight'].' '.$flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerFare']['TPA_Extensions']['BaggageInformationList']['BaggageInformation']['Allowance']['@attributes']['Unit'];

					if(count($infantFareBasisCode[$a]) > 1) {
						$infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
						if(count($infantFareBasisCode[$a]) > 1) {
							$infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
						} else {
							$infantFareBasisCode[$a] = $infantFareBasisCode[$a][0];
						}
					}*/
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

			/*--END OF FILTER PRICE--*/
			/*--FILTER TRANSFER--*/
			if( isset($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][0]) ) {
				$countFlightSegment = count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]);
				$arrayFilterTransfer[$a] = $countFlightSegment-1;
			}
			else {
				$arrayFilterTransfer[$a] = "DIRECT";
			}
			/*--END OF FILTER TRANSFER--*/
			/*--FILTER TIME--*/
			if( isset($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][0]) ) {
				$flightSegment = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"];
				$countFlightSegment = count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]);
				$multiTransit = "YES";
				for( $fs=0; $fs<$countFlightSegment; $fs++ ) {
					$departureTime = str_replace("T", " ", $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][0]["@attributes"]["DepartureDateTime"]);
					$departureTimeFormat = date("H:i:s", strtotime($departureTime));
					$arrayFilterTime[$a] = $departureTimeFormat;
				}
			}
			else {
				$departureTime = str_replace("T", " ", $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["@attributes"]["DepartureDateTime"]);
				$departureTimeFormat = date("H:i:s", strtotime($departureTime));
				$arrayFilterTime[$a] = $departureTimeFormat;
			}

			/*--END OF FILTER TIME--*/
			/*--FILTER AIRLINES--*/
			if( isset($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][0]) ) {
				$flightSegment = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"];
				$countFlightSegment = count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]);
				$multiTransit = "YES";
				for( $fs=0; $fs<$countFlightSegment; $fs++ ) {
					$fligtName = $this->Flight->getAirlinesNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"]);
					$flightCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"];
					$arrayFilterAirlines[$flightCode] = '
						<div style="float:left; margin-left:10px; margin-right:10px">
							<img src="'.base_url().'assets/airlines_image/'.$flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"].'.gif" width="50" height="20" />
						</div>
						<div style="float:left">
							<span style="font-size:13px"><b>'.$fligtName.'</b></span>
						</div>
					';
				}
			}
			else {
				$fligtName  = $this->Flight->getAirlinesNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"]);
				$flightCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];
				$arrayFilterAirlines[$flightCode] = '
					<div style="float:left; margin-left:10px; margin-right:10px">
						<img src="'.base_url().'assets/airlines_image/'.$flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"].'.gif" width="50" height="20" />
					</div>
					<div style="float:left">
						<span style="font-size:13px"><b>'.$fligtName.'</b></span>
					</div>
				';
			}
			/*--END OF FILTER AIRLINES--*/
		}
	}

	$printTaxesFare = 0;
    $printGrandTotal = 0;
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 	 ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->s
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CTC Travel | Search Flight Result</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css" media="screen,projection,print" />
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
	</style>
	<style>
		h5 { color: #F7941D !important; } .fontSizeAdjust { font-size: 15px }
	</style>
	<style>
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

		.showAirline, .showPrice, .showTransfer, .showTime {
			display: "";
		}
		.hideAirline, .hidePrice, .hideTransfer, .hideTime {
			display: none;
		}

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
	<style>#divLoading {display : none;}</style>
</head>
<body>
	<?php require_once(APPPATH."views/master-frontend/header.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
	<?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>

	<div id="divLoading2" style="margin:0px; padding:0px; position:fixed; right:0px; top:0px; width:100%; height:100%; background-color: rgb(102, 102, 102); z-index:30001; opacity:0.8;">
		<p style="position:absolute; color:white; top:50%; left:40%; padding:0px">
			Processing data.. Please wait
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
					$arrFlightClass = array('Y'=>'Economy Class',
							'S' => 'Premium Economy Class',
							'C' => 'Business Class',
							'J' => 'Premium Business Class',
							'F' => 'First Class',
							'P' => 'Premium First Class');
					echo $arrFlightClass[$flightClass];
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

<!--DEBUG CODE-->
<?php
	//echo "<pre>";
	//print_r($flight_results);
	//echo "</pre>";
?>
<!--END OF DEBUG CODE-->

				<!--CONTENT-->
				<section class="full-width">
					<div class="deals clearfix flights">
						<!--Single Booking-->
						<div style="width:96.5%">
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
								<div class="sort-by" style="background-color:#fafafa; height:85px" id="priceFilterContent">
									<div style="display:block; color:black; padding:20px; font-size:13px; margin-top:-5px">
										<b>Filter flight ticket price by dragging the slider below</b>
										<div style="text-align:center">
											<label for="amount">Show flight ticket price below:</label>
											<span id="amount"></span>
										</div>
										<div id="sliderPrice" style="margin-top:5px"></div>
									</div>
								</div>
								<div class="sort-by" style="background-color:#fafafa; height:auto" id="transferFilterContent">
									<div style="color:black; padding:20px; font-size:13px; margin-top:-5px">
										<div style="margin-right:40px">
											<div style="margin-bottom:10px">No. of transfer</div>
											<div style="margin-bottom:5px; float:left; margin-right:30px">
												<input type="checkbox" name="flightTransfer[]" id="flightTransferDirect" value="DIRECT" checked /> &nbsp;&nbsp;Direct
											</div>
											<div style="margin-bottom:5px; float:left; margin-right:30px">
												<input type="checkbox" name="flightTransfer[]" id="flightTransfer1" value="1" checked /> &nbsp;&nbsp;1 Transfer
											</div>
											<div style="margin-bottom:5px; float:left; margin-right:30px">
												<input type="checkbox" name="flightTransfer[]" id="flightTransfer2" value="2" checked /> &nbsp;&nbsp;2 Transfers
											</div>
											<div style="margin-bottom:5px; float:left; margin-right:30px">
												<input type="checkbox" name="flightTransfer[]" id="flightTransfer3" value="3" checked /> &nbsp;&nbsp;3 Transfers
											</div>
											<div style="clear:both"></div>
										</div>
									</div>
								</div>
								<div class="sort-by" style="background-color:#fafafa; height:auto" id="airlineFilterContent">
									<input type="hidden" name="hidden_leavingFrom"   value="<?php echo $input_leaving_from; ?>" />
									<input type="hidden" name="hidden_goingTo"  	 value="<?php echo $input_going_to; ?>" />
									<input type="hidden" name="hidden_inputCheckin"  value="<?php echo $input_check_in; ?>" />
									<input type="hidden" name="hidden_inputCheckout" value="<?php echo $input_check_out; ?>" />
									<input type="hidden" name="hidden_flightType" 	 value="<?php echo $input_flight_type; ?>" />
									<input type="hidden" name="hidden_flightAdult"   value="<?php echo $flightAdult; ?>" />
									<input type="hidden" name="hidden_flightChild"   value="<?php echo $flightChild; ?>" />
									<input type="hidden" name="hidden_flightInfant"  value="<?php echo $flightInfant; ?>" />
									<input type="hidden" name="hidden_flightClass"   value="<?php echo $flightClass; ?>" />
									<div style="color:black; padding:20px; font-size:13px; margin-top:-5px">
										<?php
										if( count($arrayFilterAirlines) > 0 ) {
											foreach( $arrayFilterAirlines AS $key => $value ) {
										?>
										<div style="float:left; width:30%; margin-bottom:5px; margin-right:5px">
											<div>
												<div style="float:left; margin-top:2px">
													<input type="checkbox" name="flightCode[]" id="flightCodeCK<?php echo $key; ?>" value="<?php echo $key; ?>" checked />
												</div>
												<?php echo $value; ?>
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
													<input type="checkbox" checked name="flightTime[]" id="flightTimeCK4" value="04001100" />
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
													<input type="checkbox" checked name="flightTime[]" id="flightTimeCK11" value="11001500" />
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
													<input type="checkbox" checked name="flightTime[]" id="flightTimeCK15" value="15001830" />
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
													<input type="checkbox" checked name="flightTime[]" id="flightTimeCK18" value="18300400" />
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
								<div class="details">

<!--FLIGHT DETAILS-->
<?php
if( $totalFlight > 0 ) {
	for($a=0; $a<$totalFlight; $a++) {
		$printGrandTotal = 0;
		$printTaxesFare = 0;
		if( isset($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][0]) ) {
			$flightSegment = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"];
			$countFlightSegment = count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]);
			$multiTransit = "YES";
			for ( $fs=0; $fs<$countFlightSegment; $fs++ ) {
		?>
				<!--TRANSIT MODE-->
				<table style="width:100%" class="flightListNo<?php echo $a; ?> showPrice showTransfer showAirline showTime filterFlight" id="filterAirline<?php echo $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][0]["OperatingAirline"]["@attributes"]["Code"]; ?>">
					<tr>
						<td style="text-align:left" colspan="4">
							<div>
								<div style="float:left; margin-right:10px">
									<img src="<?php echo base_url(); ?>assets/airlines_image/<?php echo $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"]; ?>.gif" width="80" height="30" />
								</div>
								<div style="float:left">
									<span style="font-size:15px">
										<?php
										$flightNameArr[] = $this->Flight->getAirlinesNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"]);
										$flightCodeArr[] = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"];
										$flightOperatingAirlineArr[] = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["FlightNumber"];

										/* new addition 7.3.2017 bto */
										$flightResBookDesigCodeArr[] = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["@attributes"]['ResBookDesigCode'];
										$flightAirEquipTypeArr[] = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]['Equipment']['@attributes']['AirEquipType'];
										$flightMarriageGrpArr[] = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]['MarriageGrp'];
										$flightETicketArr[] = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]['TPA_Extensions']['eTicket']['@attributes']['Ind'];

										//passing data
										$fligtNamePassing = implode("~", $flightNameArr);
										$fligtCodePassing = implode("~", $flightCodeArr);
										$fligtOperatingAirlinePassing = implode("~", $fligtOperatingAirlinePassingArr);
										$flightResBookDesigCodePassing = implode("~", $flightResBookDesigCodePassingArr);
										$flightAirEquipTypePassing = implode("~", $flightAirEquipTypePassingArr);
										$flightMarriageGrpPassing = implode("~", $flightMarriageGrpPassingArr);
										$flightETicketPassing = implode("~", $flightETicketPassingArr);
										//end of passing data

										$fligtName = $this->Flight->getAirlinesNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"]);
										$flightCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["Code"];
										$flightCodeFilter = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][0]["OperatingAirline"]["@attributes"]["Code"];
										$flightOperatingAirline = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["OperatingAirline"]["@attributes"]["FlightNumber"];

										/* new addition 7.3.2017 bto */
										$flightResBookDesigCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["@attributes"]['ResBookDesigCode'];
										$flightAirEquipType = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]['Equipment']['@attributes']['AirEquipType'];
										$flightMarriageGrp = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]['MarriageGrp'];
										$flightETicket = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]['TPA_Extensions']['eTicket']['@attributes']['Ind'];

										/* 22 mei 2017 */
										$flightTerminal_from = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]['DepartureAirport']['@attributes']['TerminalID'];
										$flightTerminal_to = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]['ArrivalAirport']['@attributes']['TerminalID'];

										$flightTimezone_from = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]['DepartureTimeZone']['@attributes']['GMTOffset'];
										$flightTimezone_to = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]['ArrivalTimeZone']['@attributes']['GMTOffset'];


										//passing data
										$passing_flightName = $fligtNamePassing;
										$passing_flightCode = $fligtCodePassing;
										$passing_flightOperatingAirline = $fligtOperatingAirlinePassing;

										/* new addition 7.3.2017 bto */
										$passing_flightresbookdesigncode = $flightResBookDesigCodePassing;
										$passing_flightairequiptype = $flightAirEquipTypePassing;
										$passing_flightmarriagegrp = $flightMarriageGrpPassing;
										$passing_flighteticket = $flightETicketPassing;
										//end of passing data

										//passing data to jquery
										$departureFlightNameArr{$a}[] = $fligtName;
										$departureFlightName  = implode("~", $departureFlightNameArr{$a});
										$departureFlightCodeArr{$a}[] = $flightCode.' '.$flightOperatingAirline;
										$departureFlightCode  = implode("~", $departureFlightCodeArr{$a});
										//end of passing data to jquery

										/* new addition 7.3.2017 bto */
										$departureFlightResBookDesigCodeArr{$a}[] = $flightResBookDesigCode;
										$departureFlightResBookDesigCode  = implode("~", $departureFlightResBookDesigCodeArr{$a});
										$departureFlightAirEquipTypeArr{$a}[] = $flightAirEquipType;
										$departureFlightAirEquipType  = implode("~", $departureFlightAirEquipTypeArr{$a});

										$departureFlightMarriageGrpArr{$a}[] = $flightMarriageGrp;
										$departureFlightMarriageGrp  = implode("~", $departureFlightMarriageGrpArr{$a});

										$departureFlightEticketArr{$a}[] = $flightETicket;
										$departureFlightETicket = implode("~", $departureFlightEticketArr{$a});

										/* 22 Mei 2017. bto : handle terminal ID & timezone */
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
										if( count($departureFlightNameArr{$a}) == 1 ) {
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
						$departureTimeOne = str_replace("T", " ", $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["@attributes"]["DepartureDateTime"]);
						$arrivalTimeOne   = str_replace("T", " ", $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["@attributes"]["ArrivalDateTime"]);
						$departureAirportCodeArr[] = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"];
						$arrivalAirportCodeArr[] = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"];
						//passing data
						$departureTimePassing = implode("~", $departureTimeArr);
						$arrivalTimePassing   = implode("~", $arrivalTimeArr);
						$departureAirportCodePassing = implode("~", $departureAirportCodeArr);
						$arrivalAirportCodePassing   = implode("~", $arrivalAirportCodeArr);
						//end of passing data
						//passing data
						$passing_departureTime 		  = $departureTimePassing;
						$passing_arrivalTime   		  = $arrivalTimePassing;
						$passing_departureAirportCode = $departureAirportCodePassing;
						$passing_arrivalAirportCode   = $arrivalAirportCodePassing;
						//end of passing data
						//passing data to jquery
						$departureDateArr{$a}[] = date("Y-m-d", strtotime($departureTimeOne));
						$departureDate 	 	 	= implode("~", $departureDateArr{$a});
						$departureTimeArr{$a}[] = date("H:i:s", strtotime($departureTimeOne));
						$departureTime 	 	 	= implode("~", $departureTimeArr{$a});
						$arrivalDateArr{$a}[]   = date("Y-m-d", strtotime($arrivalTimeOne));
						$arrivalDate 	  	 	= implode("~", $arrivalDateArr{$a});
						$arrivalTimeArr{$a}[]   = date("H:i:s", strtotime($arrivalTimeOne));
						$arrivalTime 	  	 	= implode("~", $arrivalTimeArr{$a});
						//end pf passing data to jquery
						?>
						<td style="text-align:left; padding-right:10px; width:30%">
							<div style="font-size:14px"><b><?php echo date("Y F d, H:i:s", strtotime($departureTimeOne)); ?></b></div>
							<div style="font-size:14px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]; ?>)</b></div>
							<div style="font-size:14px">
								<b>Airport: <?php echo $this->Flight->getAirportNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]); ?></b>
							</div>
							<?php
							//passing data to jquery
							$departureCityNameFromArr{$a}[] = $this->Flight->getCityNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]);
							$departureCityNameFrom 	 = implode("~", $departureCityNameFromArr{$a});
							$departureCityCodeFromArr{$a}[] = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"];
							$departureCityCodeFrom 	 = implode("~", $departureCityCodeFromArr{$a});
							$departureAirportFromArr{$a}[]  = $this->Flight->getAirportNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["DepartureAirport"]["@attributes"]["LocationCode"]);
							$departureAirportFrom 		 = implode("~", $departureAirportFromArr{$a});
							//end pf passing data to jquery
							?>
						</td>
						<td style="text-align:left; padding-right:10px; width:30%">
							<div style="font-size:14px"><b><?php echo date("Y F d, H:i:s", strtotime($arrivalTimeOne)); ?></b></div>
							<div style="font-size:14px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]; ?>)</b></div>
							<div style="font-size:14px">
								<b>Airport: <?php echo $this->Flight->getAirportNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]); ?></b>
							</div>
							<?php
							//passing data to jquery
							$departureCityNameToArr{$a}[] = $this->Flight->getCityNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]);
							$departureCityNameTo 	   = implode("~", $departureCityNameToArr{$a});
							$departureCityCodeToArr{$a}[] = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"];
							$departureCityCodeTo 	   = implode("~", $departureCityCodeToArr{$a});
							$departureAirportToArr{$a}[]  = $this->Flight->getAirportNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["ArrivalAirport"]["@attributes"]["LocationCode"]);
							$departureAirportTo 	   = implode("~", $departureAirportToArr{$a});
							//end pf passing data to jquery
							?>
						</td>
						<td style="text-align:left; padding-right:10px; width:20%">
							<?php
							$timeTaken = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["@attributes"]["ElapsedTime"];
							$timeTakenArr[] = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][$fs]["@attributes"]["ElapsedTime"];
							//passing data
							$timeTakenPassing = implode("~", $timeTakenArr);
							//end of passing data
							//passing data
							$passing_timeTaken = $timeTakenPassing;
							//end of passing data
							//passing data to jquery
							$departureTimeTakenArr{$a}[] = $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes');
							$departureTimeTaken 	  = implode("~", $departureTimeTakenArr{$a});
							//end pf passing data to jquery
							?>
							<div style="font-size:14px"><b>Flight Time taken</b></div>
							<div style="font-size:14px; color:green">
								<b><?php echo $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes'); ?></b>
							</div>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<?php
						/* for case adult, infant child, we take just index 0, just the parent baggage */
						if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {

							if(count($flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']) > 1) {
								$PTCBreakDown = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown'];
								foreach($PTCBreakDown as $priceData) {
									$passType = $priceData['PassengerTypeQuantity']['@attributes']['Code'];

									if($passType == 'ADT') {
										$adultFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'];

										if(count($adultFareBasisCode[$a]) > 1) {
											$adultFareBasisCode[$a] = array_unique($adultFareBasisCode[$a]);
											if(count($adultFareBasisCode[$a]) > 1) {
												$adultFareBasisCode[$a] = implode(",", $adultFareBasisCode[$a]);
											} else {
												$adultFareBasisCode[$a] = $adultFareBasisCode[$a][0];
											}
										}
										$departureFareBasisCodeArr{$a}[] = $adultFareBasisCode[$a];
									}
									else if($passType == 'CNN') {

										$childFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'];

										if(count($childFareBasisCode[$a]) > 1) {
											$childFareBasisCode[$a] = array_unique($childFareBasisCode[$a]);
											if(count($childFareBasisCode[$a]) > 1) {
												$childFareBasisCode[$a] = implode(",", $childFareBasisCode[$a]);
											} else {
												$childFareBasisCode[$a] = $childFareBasisCode[$a][0];
											}
										}

										$departureFareBasisCodeChildArr{$a}[] = $childFareBasisCode[$a];

									}
									else if($passType == 'INF') {

										$infantFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'];

										if(count($infantFareBasisCode[$a]) > 1) {
											$infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
											if(count($infantFareBasisCode[$a]) > 1) {
												$infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
											} else {
												$infantFareBasisCode[$a] = $infantFareBasisCode[$a][0];
											}
										}
										$departureFareBasisCodeInfantArr{$a}[] = $infantFareBasisCode[$a];
									}
								}
							}
                            /*if (array_key_exists('FareBasisCodes', $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"])) {
                                $FareBasisCodesArr[] = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]['FareBasisCodes']['FareBasisCode'][$fs];
                                $departureFareBasisCodeArr{$a}[] =  $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]['FareBasisCodes']['FareBasisCode'][$fs];
                            }
*/
							if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]['Pieces'])) {
								$baggageArr[] = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Weight"] ." Luggage(s)";
							} else {
								$baggageArr[] = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Weight"] ." ". $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Unit"];
							}
						} else {
							$passType = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Code'];
							if ($passType == 'ADT') {
								$adultFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'];

								if(count($adultFareBasisCode[$a]) > 1) {
									$adultFareBasisCode[$a] = array_unique($adultFareBasisCode[$a]);
									if(count($adultFareBasisCode[$a]) > 1) {
										$adultFareBasisCode[$a] = implode(",", $adultFareBasisCode[$a]);
									} else {
										$adultFareBasisCode[$a] = $adultFareBasisCode[$a][0];
									}
								}
								$departureFareBasisCodeArr{$a}[] = $adultFareBasisCode[$a];
							} else if ($passType == 'CNN') {
								$childFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'];

								if(count($childFareBasisCode[$a]) > 1) {
									$childFareBasisCode[$a] = array_unique($childFareBasisCode[$a]);
									if(count($childFareBasisCode[$a]) > 1) {
										$childFareBasisCode[$a] = implode(",", $childFareBasisCode[$a]);
									} else {
										$childFareBasisCode[$a] = $childFareBasisCode[$a][0];
									}
								}
								$departureFareBasisCodeChildArr{$a}[] = $childFareBasisCode[$a];
							} else {
								$infantFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'];

								if(count($infantFareBasisCode[$a]) > 1) {
									$infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
									if(count($infantFareBasisCode[$a]) > 1) {
										$infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
									} else {
										$infantFareBasisCode[$a] = $infantFareBasisCode[$a][0];
									}
								}
								$departureFareBasisCodeInfantArr{$a}[] = $infantFareBasisCode[$a];
							}
                            /*if (array_key_exists('FareBasisCodes', $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"])) {
                                $FareBasisCodesArr[] = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]['FareBasisCodes']['FareBasisCode'][$fs];
                                $departureFareBasisCodeArr{$a}[] =  $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]['FareBasisCodes']['FareBasisCode'][$fs];
                            }*/

							if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]['Pieces'])) {
								$baggageArr[] = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Weight"] ." Luggage(s)";
							} else {
								$baggageArr[] = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Weight"] ." ". $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Unit"];
							}
						}

                        /*$departureFareBasisCode       = implode("~", $departureFareBasisCodeArr{$a});*/
						?>
						<td style="text-align:left; padding-right:10px; width:30%">
							<div style="font-size:14px">
								<span style="color:green">
									<b>Baggage: <?php
									/* for case adult, infant child, we take just index 0, just the parent baggage */
									if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {
										if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]['Pieces'])) {
											echo $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Pieces"] ." Luggage(s)";

											//passing data to jquery
											$departureBaggageArr{$a}[] = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
										} else {
											echo $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Weight"] ." kg";
											//passing data to jquery
											$departureBaggageArr{$a}[] = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Weight"]." kg";
										}
									} else {
										if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]['Pieces'])) {
											echo $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Pieces"] ." Luggage(s)";

											//passing data to jquery
											$departureBaggageArr{$a}[] = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
										} else {
											echo $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Weight"] ." kg";
											//passing data to jquery
											$departureBaggageArr{$a}[] = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Weight"]." kg";
										}
									}
									?></b>
									<?php

									$departureBaggage 	    = implode("~", $departureBaggageArr{$a});
									//end pf passing data to jquery
									?>
								</span>
							</div>
						</td>
						<td style="text-align:left; padding-right:10px; width:30%">
							<div style="font-size:14px">
								<span style="color:green">
									<b>
										Meal:
										<?php
										/* for case adult, infant child, we take just index 0, just the parent baggage */
										if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {
											if( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["FareInfos"]["FareInfo"][$fs]["TPA_Extensions"]['Meal']) ) {
												$mealArr[] = "YES";
												$meal = "YES";
												$mealCode = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["FareInfos"]["FareInfo"][$fs]["TPA_Extensions"]['Meal']['@attributes']['Code'];
												echo "YES";
											}
											else {
												$mealCode = "-";
												$mealArr[] = "NO";
												$meal = "NO";
												echo "NO";
											}
										} else {
											if( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"][$fs]["TPA_Extensions"]['Meal']) ) {
												$mealArr[] = "YES";
												$meal = "YES";
												$mealCode = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"][$fs]["TPA_Extensions"]['Meal']['@attributes']['Code'];
												echo "YES";
											}
											else {
												$mealCode = "-";
												$mealArr[] = "NO";
												$meal = "NO";
												echo "NO";
											}
										}
										//passing data to jquery
										$departureMealArr{$a}[] = $meal;
										$departureMealCodeArr{$a}[] = $mealCode;
										$departureMeal 	 = implode("~", $departureMealArr{$a});
										$departuremealcode = implode("~", $departureMealCodeArr{$a});
										//end pf passing data to jquery
										?>
									</b>
								</span>
							</div>
						</td>
						<?php
						//passing data
						$baggagePassing = implode("~", $baggageArr);
						$mealPassing 	= implode("~", $mealArr);
						//end of passing data
						//passing data
						$passing_baggage = $baggagePassing;
						$passing_meal 	 = $mealPassing;
						//end of passing data

                        /* farebasiscode 24 Mei 2017 */
                        /*$farebasisPassing = implode("~", $FareBasisCodesArr);
                        $departureFareBasisCode = implode("~", $departureFareBasisCodeArr{$a});*/

                        /* FBC 13 Juni 2017 , update for multiple fare rules for child infant */
                        $departureFareBasisCodeAdult = implode("~", $departureFareBasisCodeArr{$a});
                        $departureFareBasisCodeChild = implode("~", $departureFareBasisCodeChildArr{$a});
                        $departureFareBasisCodeInfant = implode("~", $departureFareBasisCodeInfantArr{$a});
						?>
					</tr>
					<tr><td>&nbsp;</td></tr>
				</table>
				<!--END OF TRANSIT MODE-->
		<?php
			}
		}
		else {
			$multiTransit = "NO";
		?>
			<!--TRANSIT MODE-->
			<table style="width:100%" class="flightListNo<?php echo $a; ?> showPrice showTransfer showAirline showTime filterFlight" id="filterAirline<?php echo $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"]; ?>">
				<tr>
					<td style="text-align:left" colspan="4">
						<div>
							<div style="float:left; margin-right:10px">
								<img src="<?php echo base_url(); ?>assets/airlines_image/<?php echo $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"]; ?>.gif" width="80" height="30" />
							</div>
							<div style="float:left">
								<?php
								$totalTime = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["@attributes"]["ElapsedTime"];
								?>
								<span style="font-size:15px">
									<?php
									$fligtName  = $this->Flight->getAirlinesNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"]);
									$flightCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];
									$flightCodeFilter = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["OperatingAirline"]["@attributes"]["Code"];
									$flightOperatingAirline = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["OperatingAirline"]["@attributes"]["FlightNumber"];

									/* new addition 7.3.2017 bto */
									$flightResBookDesigCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["@attributes"]['ResBookDesigCode'];
									$flightAirEquipType = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]['Equipment']['@attributes']['AirEquipType'];
									$flightMarriageGrp = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]['MarriageGrp'];
									$flightETicket = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]['TPA_Extensions']['eTicket']['@attributes']['Ind'];

									/* 22 Mei 2017 */
									$flightTerminal_from = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]['DepartureAirport']['@attributes']['TerminalID'];
									$flightTerminal_to = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]['ArrivalAirport']['@attributes']['TerminalID'];

									$flightTimezone_from = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]['DepartureTimeZone']['@attributes']['GMTOffset'];
									$flightTimezone_to = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]['ArrivalTimeZone']['@attributes']['GMTOffset'];

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
									$departureFlightName = $fligtName;
									$departureFlightCode = $flightCode.' '.$flightOperatingAirline;
									//end pf passing data to jquery

									/* new addition 7.3.2017 bto */
									$departureFlightResBookDesigCode = $flightResBookDesigCode;
									$departureFlightAirEquipType = $flightAirEquipType;
									$departureFlightMarriageGrp = $flightMarriageGrp;
									$departureFlightEticket = $flightETicket;
									$departureTerminalID_from = $flightTerminal_from;
									$departureTerminalID_to = $flightTerminal_to;
									$departureTimezone_from = $flightTimezone_from;
									$departureTimezone_to = $flightTimezone_to;
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
					$departureTimeOne = str_replace("T", " ", $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["@attributes"]["DepartureDateTime"]);
					$arrivalTimeOne   = str_replace("T", " ", $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["@attributes"]["ArrivalDateTime"]);
					$departureAirportCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"];
					$arrivalAirportCode = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"];
					//passing data
					$passing_departureTime = $departureTime;
					$passing_arrivalTime   = $arrivalTime;
					$passing_departureAirportCode = $departureAirportCode;
					$passing_arrivalAirportCode   = $arrivalAirportCode;
					//end of passing data
					//passing data to jquery
					$departureDate = date("Y-m-d", strtotime($departureTimeOne));
					$arrivalDate   = date("Y-m-d", strtotime($arrivalTimeOne));
					$departureTime = date("H:i:s", strtotime($departureTimeOne));
					$arrivalTime   = date("H:i:s", strtotime($arrivalTimeOne));
					//end pf passing data to jquery
					?>
					<td style="text-align:left; padding-right:10px; width:30%">
						<div style="font-size:14px"><b><?php echo date("Y F d, H:i:s", strtotime($departureTimeOne)); ?></b></div>
						<div style="font-size:14px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $departureAirportCode; ?>)</b></div>
						<div style="font-size:14px">
							<b>Airport: <?php echo $this->Flight->getAirportNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"]); ?></b>
						</div>
						<?php
						//passing data to jquery
						$departureCityNameFrom = $this->Flight->getCityNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"]);
						$departureCityCodeFrom = $departureAirportCode;
						$departureAirportFrom  = str_replace("International", "Int'l", $this->Flight->getAirportNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["DepartureAirport"]["@attributes"]["LocationCode"]));
						//end pf passing data to jquery
						?>
					</td>
					<td style="text-align:left; padding-right:10px; width:30%">
						<div style="font-size:14px"><b><?php echo date("Y F d, H:i:s", strtotime($arrivalTimeOne)); ?></b></div>
						<div style="font-size:14px"><b><?php echo $this->Flight->getCityNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"]); ?> (<?php echo $arrivalAirportCode; ?>)</b></div>
						<div style="font-size:14px">
							<b>Airport: <?php echo $this->Flight->getAirportNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"]); ?></b>
						</div>
						<?php
						//passing data to jquery
						$departureCityNameTo = $this->Flight->getCityNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"]);
						$departureCityCodeTo = $arrivalAirportCode;
						$departureAirportTo  = str_replace("International", "Int'l", $this->Flight->getAirportNameBasedOnCode($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["ArrivalAirport"]["@attributes"]["LocationCode"]));
						//end pf passing data to jquery
						?>
					</td>
					<td style="text-align:left; padding-right:10px; width:20%">
						<?php
						$timeTaken = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"]["@attributes"]["ElapsedTime"];
						//passing data
						$passing_timeTaken = $timeTaken;
						//end of passing data
						//passing data to jquery
						$departureTimeTaken = $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes');
						//end pf passing data to jquery
						?>
						<div style="font-size:14px"><b>Flight Time taken</b></div>
						<div style="font-size:14px; color:green">
							<b><?php echo $this->Flight->convertToHoursMins($timeTaken, $format='%02d hours %02d minutes'); ?></b>
						</div>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td style="text-align:left; padding-right:10px; width:30%">
						<div style="font-size:14px">
							<span style="color:green">
								<?php
								/* for case adult, infant child, we take just index 0, just the parent baggage */
								if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {
                                    /*if (array_key_exists('FareBasisCodes', $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"])) {
                                        $FareBasisCodes = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]['FareBasisCodes']['FareBasisCode'];
                                    }*/

                                    if(count($flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']) > 1) {
										$PTCBreakDown = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown'];
										foreach($PTCBreakDown as $priceData) {
											$passType = $priceData['PassengerTypeQuantity']['@attributes']['Code'];

											if($passType == 'ADT') {
												$adultFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'];

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

												$childFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'];

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

												$infantFareBasisCode[$a] = $priceData['FareBasisCodes']['FareBasisCode'];

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


									if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]['Pieces'])) {
										$baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
									} else {
										$baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Weight"]." ".$flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Unit"];
									}
								} else {
                                    /*if (array_key_exists('FareBasisCodes', $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"])) {
                                        $FareBasisCodes = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]['FareBasisCodes']['FareBasisCode'];
                                    }*/

                                    $passType = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['PassengerTypeQuantity']['@attributes']['Code'];
									if ($passType == 'ADT') {
										$adultFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'];

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
										$childFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'];

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
										$infantFareBasisCode[$a] = $flight_results[$a]["AirItineraryPricingInfo"]['PTC_FareBreakdowns']['PTC_FareBreakdown']['FareBasisCodes']['FareBasisCode'];

										if(count($infantFareBasisCode[$a]) > 1) {
											$infantFareBasisCode[$a] = array_unique($infantFareBasisCode[$a]);
											if(count($infantFareBasisCode[$a]) > 1) {
												$infantFareBasisCode[$a] = implode(",", $infantFareBasisCode[$a]);
											} else {
												$infantFareBasisCode[$a] = $infantFareBasisCode[$a][0];
											}
										}/*
										$departureFareBasisCodeInfantArr{$a}[] = $infantFareBasisCode[$a];*/
									}


									if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]['Pieces'])) {
										$baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Pieces"]." Luggage(s)";
									} else {
										$baggage = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Weight"]." ".$flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["PassengerFare"]["TPA_Extensions"]["BaggageInformationList"]["BaggageInformation"]["Allowance"]["@attributes"]["Unit"];
									}
								}

								?>
								<b>Baggage: <?php echo $baggage; ?></b>
							</span>
							<?php
							//passing data to jquery
							$departureBaggage = $baggage;
							//end pf passing data to jquery
							?>
						</div>
					</td>
					<td style="text-align:left; padding-right:10px; width:30%">
						<div style="font-size:14px">
							<span style="color:green">
								<b>
									Meal:
									<?php
									/* for case adult, infant child, we take just index 0, just the parent baggage */
									if (isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {
										if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["FareInfos"]["FareInfo"]["TPA_Extensions"]['Meal']) ) {
											$meal = "YES";
											$mealCode = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0]["FareInfos"]["FareInfo"]["TPA_Extensions"]['Meal']['@attributes']['Code'];
											echo "YES";
										}
										else {
											$mealCode = "-";
											$meal = "NO";
											echo "NO";
										}
									} else {
										if ( isset($flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"]["TPA_Extensions"]['Meal']) ) {
											$mealCode = $flight_results[$a]["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"]["FareInfos"]["FareInfo"]["TPA_Extensions"]['Meal']['@attributes']['Code'];
											$meal = "YES";
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
					$passing_meal 	 = $meal;
					//end of passing data
					//passing data to jquery
					$departureMeal = $meal;
					$departuremealcode = $mealCode;
					//end pf passing data to jquery

                    /* 24 Mei 2017 */
                    /*$farebasisPassing = $FareBasisCodes;
                    $departureFareBasisCode = $FareBasisCodes;*/

                    /* 13 june 2017 */
                    $departureFareBasisCodeAdult = $adultFareBasisCode[$a];
                    $departureFareBasisCodeChild = $childFareBasisCode[$a];
                    $departureFareBasisCodeInfant = $infantFareBasisCode[$a];
					?>
				</tr>
			</table>
			<!--END OF TRANSIT MODE-->
		<?php
		}
		?>
		<div id="filterAirline<?php echo $flightCodeFilter; ?>" class="flightListNo<?php echo $a; ?>  showPrice showTransfer showAirline showTime filterFlight">
			<?php
			$priceInfo  = $flight_results[$a]["AirItineraryPricingInfo"]["ItinTotalFare"];
			/*
			$equiveFare = $this->Flight->getRateConvertion($priceInfo["EquivFare"]["@attributes"]["CurrencyCode"]);
			$taxesFare  = $this->Flight->getRateConvertion($priceInfo["Taxes"]["Tax"]["@attributes"]["CurrencyCode"]);
			$printEquiveFare = ceil($priceInfo["EquivFare"]["@attributes"]["Amount"]/$equiveFare);
			$printTaxesFare  = ceil($priceInfo["Taxes"]["Tax"]["@attributes"]["Amount"]/$taxesFare);
			*/
			$printEquiveFare = ceil($priceInfo["EquivFare"]["@attributes"]["Amount"]);
			//$printTaxesFare  = ceil($priceInfo["Taxes"]["Tax"]["@attributes"]["Amount"]);
			//$totalFare = ceil($priceInfo["TotalFare"]["@attributes"]["Amount"]);
			$printAdminFee   = ceil((($totalFare)*FLIGHT_ADMIN_PERCENT)/100);//ceil((($printEquiveFare+$printTaxesFare)*FLIGHT_ADMIN_PERCENT)/100);
			//$printGrandTotal = $totalFare + $printAdminFee; //$printEquiveFare+$printTaxesFare+$printAdminFee;

			$basePriceDetailFare = "";
			/*$flightAdult = $tmpflightAdult[$a];
            $flightChild = $tmpflightChild[$a];
            $flightInfant = $tmpflightInfant[$a];*/

			if ($flightAdult > 0) {
				$printTaxesFare += $adultTaxFare[$a];
	            $totalFare = $flightAdult * ($adultFare[$a] + $adultTaxFare[$a]);
	            $printGrandTotal += $totalFare;

				$basePriceDetailFare .= "<div style='float:left; width:150px; text-align:left'>Adult Fare</div>
				<div style='float:left; width:50px;  text-align:left'>x".$flightAdult."</div>
				<div style='float:left; width:50px; text-align:left'>$".number_format($totalFare, 2)."</div>
				<div style='clear:both'></div>";
			}
			if ($flightChild > 0) {
				$printTaxesFare += $childTaxFare[$a];
	            $totalFare = $flightChild * ($childFare[$a] + $childTaxFare[$a]);
	            $printGrandTotal += $totalFare;

				$basePriceDetailFare .= "<div style='float:left; width:150px; text-align:left'>Children Fare</div>
				<div style='float:left; width:50px;  text-align:left'>x".$flightChild."</div>
				<div style='float:left; width:50px; text-align:left'>$".number_format($totalFare, 2)."</div>
				<div style='clear:both'></div>";
			}
			if ($flightInfant > 0) {
				$printTaxesFare += $infantTaxFare[$a];
	            $totalFare = $flightInfant * ($infantFare[$a] + $infantTaxFare[$a]);
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
			<div style="background-color:#fafafa; padding: 20px; margin-top: 15px">
				<?php if ($detailAirline[$a] != "") { ?>
                <div style="text-align:center; background-color:#F7941D; color:#FFFFFF; padding:5px; width:200px; margin-top: 10px; float:left; margin-bottom: 15px" title="<?php echo $detailAirline[$a];?>"> (Important) </div>
                <?php } ?>

				<div style="text-align:center; background-color:#F7941D; padding:5px; width:200px; float:right">
					<a href="#<?php echo $a; ?>" id="clickPrice<?php echo $a; ?>" style="color:white; font-size:16px; font-weight:bold; text-decoration:none; text-align:center; cursor:pointer" class="tip" data-tip="<?php echo $contentPrice; ?>">
						SGD <?php echo number_format($printGrandTotal, 2); ?>
					</a>
					<?php $departureTotalPrice = $printGrandTotal; /*number_format($printGrandTotal, 2);*/ ?>
				</div>
				<div style="text-align:center; padding:5px; float:right; margin-right:10px">
					<div style="font-size:14px">
						<?php
						$totalTime = $flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["@attributes"]["ElapsedTime"];
						?>
						<span><b>Total Transit: </b></span>
						<span style="color:green">
							<?php
							if( isset($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"][0]) ) {
							?>
								<b>
									<?php
										$totalTransit = count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"])-1;
										echo count($flight_results[$a]["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"])-1;
									?>
								</b>
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
						<span title="Total flight + transit time"><b>Total Travel Time: </b></span>
						<span style="color:green">
							<b><?php echo $this->Flight->convertToHoursMins($totalTime, $format='%02d hours %02d minutes'); ?></b>
						</span>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<hr>
			<br /><br />
		</div>
		<div style="display:none" id="departureFlightName<?php echo $a; ?>"><?php echo $departureFlightName; ?></div>
		<div style="display:none" id="departureFlightCode<?php echo $a; ?>"><?php echo $departureFlightCode; ?></div>
		<div style="display:none" id="departureDateFrom<?php echo $a; ?>"><?php echo $departureDate; ?></div>
		<div style="display:none" id="departureDateTo<?php echo $a; ?>"><?php echo $arrivalDate; ?></div>
		<div style="display:none" id="departureTimeFrom<?php echo $a; ?>"><?php echo $departureTime; ?></div>
		<div style="display:none" id="departureTimeTo<?php echo $a; ?>"><?php echo $arrivalTime; ?></div>
		<div style="display:none" id="departureCityNameFrom<?php echo $a; ?>"><?php echo $departureCityNameFrom; ?></div>
		<div style="display:none" id="departureCityNameTo<?php echo $a; ?>"><?php echo $departureCityNameTo; ?></div>
		<div style="display:none" id="departureCityCodeFrom<?php echo $a; ?>"><?php echo $departureCityCodeFrom; ?></div>
		<div style="display:none" id="departureCityCodeTo<?php echo $a; ?>"><?php echo $departureCityCodeTo; ?></div>
		<div style="display:none" id="departureAirportNameFrom<?php echo $a; ?>"><?php echo $departureAirportFrom; ?></div>
		<div style="display:none" id="departureAirportNameTo<?php echo $a; ?>"><?php echo $departureAirportTo; ?></div>
		<div style="display:none" id="departureTimeTaken<?php echo $a; ?>"><?php echo $departureTimeTaken; ?></div>
		<div style="display:none" id="departureBaggage<?php echo $a; ?>"><?php echo $departureBaggage; ?></div>
		<div style="display:none" id="departureMeal<?php echo $a; ?>"><?php echo $departureMeal; ?></div>
		<div style="display:none" id="departureTotalTransit<?php echo $a; ?>"><?php echo $totalTransit; ?></div>
		<div style="display:none" id="departureTotalFlightTime<?php echo $a; ?>"><?php echo $this->Flight->convertToHoursMins($totalTime, $format='%02d hours %02d minutes'); ?></div>
		<div style="display:none" id="departureTotalPrice<?php echo $a; ?>"><?php echo $departureTotalPrice; ?></div>

		<!-- new addition 7.3.2017 bto -->
		<div style="display:none" id="departureFlightResBookDesigCode<?php echo $a; ?>"><?php echo $departureFlightResBookDesigCode; ?></div>
		<div style="display:none" id="departureFlightAirEquipType<?php echo $a; ?>"><?php echo $departureFlightAirEquipType; ?></div>
		<div style="display:none" id="departureFlightMarriageGrp<?php echo $a; ?>"><?php echo $departureFlightMarriageGrp; ?></div>
		<div style="display:none" id="departureFlightEticket<?php echo $a; ?>"><?php echo $departureFlightEticket ? 1 : 0; ?></div>

		<div style="display:none" id="departurePriceAdultTaxFare<?php echo $a; ?>"><?php echo ($adultTaxFare[$a]);?></div>
		<div style="display:none" id="departurePriceAdultBaseFare<?php echo $a; ?>"><?php echo ($adultFare[$a]);?></div>
		<div style="display:none" id="departurePriceChildTaxFare<?php echo $a; ?>"><?php echo ($childTaxFare[$a]); ?></div>
		<div style="display:none" id="departurePriceChildBaseFare<?php echo $a; ?>"><?php echo ($childFare[$a]); ?></div>
		<div style="display:none" id="departurePriceInfantTaxFare<?php echo $a; ?>"><?php echo ($infantTaxFare[$a]); ?></div>
		<div style="display:none" id="departurePriceInfantBaseFare<?php echo $a; ?>"><?php echo ($infantFare[$a]); ?></div>
		<div style="display:none" id="TotalPriceAdminFare<?php echo $a; ?>"><?php echo $printAdminFee; ?></div>
		<!-- 22 Mei 17 -->
		<div style="display:none" id="departureTerminalID_from<?php echo $a; ?>"><?php echo $departureTerminalID_from; ?></div>
		<div style="display:none" id="departureTimezone_from<?php echo $a; ?>"><?php echo $departureTimezone_from; ?></div>
		<div style="display:none" id="departureTerminalID_to<?php echo $a; ?>"><?php echo $departureTerminalID_to; ?></div>
		<div style="display:none" id="departureTimezone_to<?php echo $a; ?>"><?php echo $departureTimezone_to; ?></div>
        <!-- 24 Mei 2017 -->
        <!-- edited 13 June 2017 -->
        <div style="display:none" id="departureFareBasisCode<?php echo $a; ?>"><?php echo $departureFareBasisCodeAdult; ?></div>
        <div style="display:none" id="departureFareBasisCodeChild<?php echo $a; ?>"><?php echo $departureFareBasisCodeChild; ?></div>
        <div style="display:none" id="departureFareBasisCodeInfant<?php echo $a; ?>"><?php echo $departureFareBasisCodeInfant; ?></div>
        <!-- 4 Aug 2017 meal codes -->
        <div style="display:none" id="departureMealCode<?php echo $a;?>"><?php echo $departuremealcode;?></div>
<?php
	}
}
else {
?>
	<div style="font-size:14px; color:red">
		No flight available at the moment. Please use another dates to get more flight result.
	</div>
<?php
}
?>
<!--END OF FLIGHT DETAILS-->

								</div>
							</article>
						</div>
						<!--End of Single Booking-->
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
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js?1234"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/typehead/js/typeahead.bundle.js"></script>
	<script>selectnav('nav'); </script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.main').show();
			$('#divLoading2').remove();

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

			$("#changeSearchAnchor").click(function(){
				$("#changeSearchContent").toggle();
				return false;
    		});
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

		     $('.tip').tipr();
		});
	</script>
	<script>selectnav('nav'); </script>
	<script type="text/javascript">
		$(document).ready(function(){
			/* recheck any hide class then hide */
	        function filterFlight() {
	        	$('.filterFlight').each(function() {
	        		if($(this).hasClass('hidePrice') ||
	        			$(this).hasClass('hideAirline') ||
	        			$(this).hasClass('hideTransfer') ||
	        			$(this).hasClass('hideTime')
	        			) {
	        			$(this).hide();
	        		} else {
	        			$(this).show();
	        		}
	        	});
	        }

	        $("#sliderPrice").slider({
				range: "min",
				value: 1000,
				min: 1,
				max: 1000,
				slide: function( event, ui ) {
					$("#amount").html("$0 - $" + ui.value);
				},
				stop: function(event, ui) {
					<?php
					if( count($arrayFilterPrice) > 0 ) {
						foreach( $arrayFilterPrice AS $key => $value ) {
					?>
							if($("table.flightListNo<?php echo $key; ?>").hasClass('hidePrice') ||
				        		$("table.flightListNo<?php echo $key; ?>").hasClass('showPrice')
				        		) {
				        		$("table.flightListNo<?php echo $key; ?>").removeClass('hidePrice').removeClass('showPrice');
				        	}
				        	if($("div.flightListNo<?php echo $key; ?>").hasClass('hidePrice') ||
				        		$("div.flightListNo<?php echo $key; ?>").hasClass('showPrice')
				        		) {
				        		$("div.flightListNo<?php echo $key; ?>").removeClass('hidePrice').removeClass('showPrice');
				        	}
							var priceSelected = <?php echo $value; ?>;
							if( priceSelected > 0 && priceSelected < ui.value ) {
								$("table.flightListNo<?php echo $key; ?>").show().addClass('showPrice');
								$("div.flightListNo<?php echo $key; ?>").show().addClass('showPrice');
							}
							else {
								$("table.flightListNo<?php echo $key; ?>").hide().addClass('hidePrice');
								$("div.flightListNo<?php echo $key; ?>").hide().addClass('hidePrice');
							}
					<?php
						}
					}
					?>

					filterFlight();
    			}
			});
			$("#amount").html("$0 - $" + $("#sliderPrice").slider("value"));

	        var substringMatcher = function(strs) {
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
			var states 		 = [<?php echo $this->All->list_city_country(); ?>];
			var states_hotel = [<?php echo $this->All->list_typehea_hotel(); ?>];
			var statesHotelBlood = new Bloodhound({
			  	datumTokenizer: Bloodhound.tokenizers.whitespace,
			  	queryTokenizer: Bloodhound.tokenizers.whitespace,
			  	local: states_hotel
			});
			/*$('#flight-going .typeahead').typeahead(
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
			$('#flight-leaving .typeahead').typeahead(
				{
					hint: true,
					highlight: true,
					minLength: 3
				},
				{
					name: 'states',
					source: substringMatcher(states)
				}
			);*/
			$('#hotel_destination .typeahead').typeahead(
				{
					hint: true,
					highlight: true,
					minLength: 3
				},
				{
					name: 'statesHotelBlood',
					source: statesHotelBlood
				}
			);
	        $("#checkout_flight").hide();
			$('input[type=radio][name=radioType].choiceFlightType').change(function() {
		        if (this.value == 'one_way') {
		            $("#checkout_flight").hide();
		        }
		        else if (this.value == 'return') {
		            $("#checkout_flight").show();
		        }
		    });
		    $("#search_submit_flight").click(function(){
		        if( $("input#flight_destination").val() != "" ) {
	             	$("#divLoading").show();
				}
	        });
	        /*--Checkbox Filter Airline--*/
	        <?php
			if( count($arrayFilterAirlines) > 0 ) {
				foreach( $arrayFilterAirlines AS $key => $value ) {
			?>
			        $('#flightCodeCK<?php echo $key; ?>').change(function() {
			        	if($("table#filterAirline<?php echo $key; ?>").hasClass('hideAirline') ||
			        		$("table#filterAirline<?php echo $key; ?>").hasClass('showAirline')
			        		) {
			        		$("table#filterAirline<?php echo $key; ?>").removeClass('hideAirline').removeClass('showAirline');
			        	}
			        	if($("div#filterAirline<?php echo $key; ?>").hasClass('hideAirline') ||
			        		$("div#filterAirline<?php echo $key; ?>").hasClass('showAirline')
			        		) {
			        		$("div#filterAirline<?php echo $key; ?>").removeClass('hideAirline').removeClass('showAirline');
			        	}
				        if ($(this).prop('checked')) {

				            $("table#filterAirline<?php echo $key; ?>").show().addClass('showAirline');
				            $("div#filterAirline<?php echo $key; ?>").show().addClass('showAirline');
				        }
				        else {
				            $("table#filterAirline<?php echo $key; ?>").hide().addClass('hideAirline');
				            $("div#filterAirline<?php echo $key; ?>").hide().addClass('hideAirline');
				        }
				        filterFlight();
				    });
		    <?php
				}
			}
			?>
	        /*--End of checkbox filter airline--*/
	        /*--Checkbox Filter Time--*/
	        <?php
		    if( count($arrayFilterTime) > 0 ) {
			?>
				$('#flightTimeCK4').change(function() {
					if ($(this).prop('checked')) {
						<?php
						foreach( $arrayFilterTime AS $key => $value ) {
							if( strtotime($value) >= strtotime("04:00:00") && strtotime($value) <= strtotime("11:00:00") ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}

						$("table.flightListNo<?php echo $key; ?>").show().addClass('showTime');
			            $("div.flightListNo<?php echo $key; ?>").show().addClass('showTime');


						<?php
							}
						}
						?>
					}
					else {
						<?php
						foreach( $arrayFilterTime AS $key => $value ) {
							if( strtotime($value) >= strtotime("04:00:00") && strtotime($value) <= strtotime("11:00:00") ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}

						$("table.flightListNo<?php echo $key; ?>").hide().addClass('hideTime');
			            $("div.flightListNo<?php echo $key; ?>").hide().addClass('hideTime');
						<?php
							}
						}
						?>
					}
					filterFlight();
			    });
			    $('#flightTimeCK11').change(function() {
					if ($(this).prop('checked')) {
						<?php
						foreach( $arrayFilterTime AS $key => $value ) {
							if( strtotime($value) >= strtotime("11:00:00") && strtotime($value) <= strtotime("15:00:00") ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
						$("table.flightListNo<?php echo $key; ?>").show().addClass('showTime');
			            $("div.flightListNo<?php echo $key; ?>").show().addClass('showTime');
						<?php
							}
						}
						?>
					}
					else {
						<?php
						foreach( $arrayFilterTime AS $key => $value ) {
							if( strtotime($value) >= strtotime("11:00:00") && strtotime($value) <= strtotime("15:00:00") ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}

						$("table.flightListNo<?php echo $key; ?>").hide().addClass('hideTime');
			            $("div.flightListNo<?php echo $key; ?>").hide().addClass('hideTime');
						<?php
							}
						}
						?>
					}
					filterFlight();
			    });
			    $('#flightTimeCK15').change(function() {
					if ($(this).prop('checked')) {
						<?php
						foreach( $arrayFilterTime AS $key => $value ) {
							if( strtotime($value) >= strtotime("15:00:00") && strtotime($value) <= strtotime("18:30:00") ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
						$("table.flightListNo<?php echo $key; ?>").show().addClass('showTime');
			            $("div.flightListNo<?php echo $key; ?>").show().addClass('showTime');
						<?php
							}
						}
						?>
					}
					else {
						<?php
						foreach( $arrayFilterTime AS $key => $value ) {
							if( strtotime($value) >= strtotime("15:00:00") && strtotime($value) <= strtotime("18:30:00") ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
						$("table.flightListNo<?php echo $key; ?>").hide().addClass('hideTime');
			            $("div.flightListNo<?php echo $key; ?>").hide().addClass('hideTime');
						<?php
							}
						}
						?>
					}
					filterFlight();
			    });
			    $('#flightTimeCK18').change(function() {
					if ($(this).prop('checked')) {
						<?php
						foreach( $arrayFilterTime AS $key => $value ) {
							if( strtotime($value) >= strtotime("18:30:00") && strtotime($value) <= strtotime("23:30:00") ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
						$("table.flightListNo<?php echo $key; ?>").show().addClass('showTime');
			            $("div.flightListNo<?php echo $key; ?>").show().addClass('showTime');
						<?php
							}
						}
						?>
					}
					else {
						<?php
						foreach( $arrayFilterTime AS $key => $value ) {
							if( strtotime($value) >= strtotime("18:30:00") && strtotime($value) <= strtotime("23:30:00") ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTime') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTime')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTime').removeClass('hideTime');
			        	}
						$("table.flightListNo<?php echo $key; ?>").hide().addClass('hideTime');
			            $("div.flightListNo<?php echo $key; ?>").hide().addClass('hideTime');
						<?php
							}
						}
						?>
					}
					filterFlight();
			    });
			<?php
			}
		    ?>
	        /*--End of Checkbox Filter Time--*/
	        /*--Checkbox Filter Transfer--*/
	        <?php
		    if( count($arrayFilterTransfer) > 0 ) {
			?>
				$('#flightTransferDirect').change(function() {
					if ($(this).prop('checked')) {
						<?php
						foreach( $arrayFilterTransfer AS $key => $value ) {
							if( $value == "DIRECT" ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}

						$("table.flightListNo<?php echo $key; ?>").show().addClass('showTransfer');
			            $("div.flightListNo<?php echo $key; ?>").show().addClass('showTransfer');
						<?php
							}
						}
						?>
					}
					else {
						<?php
						foreach( $arrayFilterTransfer AS $key => $value ) {
							if( $value == "DIRECT" ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}

						$("table.flightListNo<?php echo $key; ?>").hide().addClass('hideTransfer');
			            $("div.flightListNo<?php echo $key; ?>").hide().addClass('hideTransfer');
						<?php
							}
						}
						?>
					}

					filterFlight();
			    });
			    $('#flightTransfer1').change(function() {
					if ($(this).prop('checked')) {
						<?php
						foreach( $arrayFilterTransfer AS $key => $value ) {
							if( $value == "1" ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
						$("table.flightListNo<?php echo $key; ?>").show().addClass('showTransfer');
			            $("div.flightListNo<?php echo $key; ?>").show().addClass('showTransfer');
						<?php
							}
						}
						?>
					}
					else {
						<?php
						foreach( $arrayFilterTransfer AS $key => $value ) {
							if( $value == "1" ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
						$("table.flightListNo<?php echo $key; ?>").hide().addClass('hideTransfer');
			            $("div.flightListNo<?php echo $key; ?>").hide().addClass('hideTransfer');
						<?php
							}
						}
						?>
					}
					filterFlight();
				});
				$('#flightTransfer2').change(function() {
					if ($(this).prop('checked')) {
						<?php
						foreach( $arrayFilterTransfer AS $key => $value ) {
							if( $value == "2" ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
						$("table.flightListNo<?php echo $key; ?>").show().addClass('showTransfer');
			            $("div.flightListNo<?php echo $key; ?>").show().addClass('showTransfer');
						<?php
							}
						}
						?>
					}
					else {
						<?php
						foreach( $arrayFilterTransfer AS $key => $value ) {
							if( $value == "2" ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
						$("table.flightListNo<?php echo $key; ?>").hide().addClass('hideTransfer');
			            $("div.flightListNo<?php echo $key; ?>").hide().addClass('hideTransfer');
						<?php
							}
						}
						?>
					}
					filterFlight();
				});
				$('#flightTransfer3').change(function() {
					if ($(this).prop('checked')) {
						<?php
						foreach( $arrayFilterTransfer AS $key => $value ) {
							if( $value == "3" ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
						$("table.flightListNo<?php echo $key; ?>").show().addClass('showTransfer');
			            $("div.flightListNo<?php echo $key; ?>").show().addClass('showTransfer');
						<?php
							}
						}
						?>
					}
					else {
						<?php
						foreach( $arrayFilterTransfer AS $key => $value ) {
							if( $value == "3" ) {
						?>
						if($("table.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("table.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("table.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
			        	if($("div.flightListNo<?php echo $key; ?>").hasClass('showTransfer') ||
			        		$("div.flightListNo<?php echo $key; ?>").hasClass('hideTransfer')
			        		) {
			        		$("div.flightListNo<?php echo $key; ?>").removeClass('showTransfer').removeClass('hideTransfer');
			        	}
						$("table.flightListNo<?php echo $key; ?>").hide().addClass('hideTransfer');
			            $("div.flightListNo<?php echo $key; ?>").hide().addClass('hideTransfer');
						<?php
							}
						}
						?>
					}
					filterFlight();
				});
			<?php
			}
			?>
	        /*--End of Checkbox Filter Transfer--*/
	        /*--Checkbox Click Button Add to Cart - Single Trip--*/
	        var passingData = {
			    departureFlightName 	 : '',
			    departureFlightCode 	 : '',
			    departureDateFrom 		 : '',
			    departureDateTo 		 : '',
			    departureTimeFrom		 : '',
			    departureTimeTo			 : '',
			    departureCityNameFrom 	 : '',
			    departureCityNameTo 	 : '',
			    departureCityCodeFrom 	 : '',
			    departureCityCodeTo 	 : '',
			    departureAirportNameFrom : '',
			    departureAirportNameTo 	 : '',
			    departureTimeTaken 		 : '',
			    departureBaggage 		 : '',
			    departureMeal 		 	 : '',
			    departureTotalTransit 	 : '',
			    departureTotalFlightTime : '',
			    departureTotalPrice 	 : '',
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
                departureFareBasisCodeChild : '',
                departureFareBasisCodeInfant : '',
				arrivalFlightName 	 	 : '',
			    arrivalFlightCode 	 	 : '',
			    arrivalDateFrom 		 : '',
			    arrivalDateTo 		 	 : '',
			    arrivalTimeFrom		 	 : '',
			    arrivalTimeTo			 : '',
			    arrivalCityNameFrom 	 : '',
			    arrivalCityNameTo 	 	 : '',
			    arrivalCityCodeFrom 	 : '',
			    arrivalCityCodeTo 	 	 : '',
			    arrivalAirportNameFrom 	 : '',
			    arrivalAirportNameTo 	 : '',
			    arrivalTimeTaken 		 : '',
			    arrivalBaggage 		 	 : '',
			    arrivalMeal 		 	 : '',
			    arrivalTotalTransit 	 : '',
			    arrivalTotalFlightTime 	 : '',
			    arrivalTotalPrice 	 	 : '',
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
				arrivalTerminalID_from : '',
				arrivalTimezone_from : '',
				arrivalTerminalID_to : '',
				arrivalTimezone_to : '',
                arrivalFareBasisCode : '',
                arrivalFareBasisCodeChild : '',
                arrivalFareBasisCodeInfant : '',
				TotalPriceAdminFare : '',
				departuremealcode : '',
				arrivalmealcode : '',
			    noofAdult 	 	 		 : '<?php echo $flightAdult; ?>',
			    noofChild 	 	 		 : '<?php echo $flightChild; ?>',
			    noofInfant 	 	 		 : '<?php echo $flightInfant; ?>',
			    flightClass				 : '<?php echo $flightClass; ?>'
			};
	        <?php
		    if( count($arrayBtn) > 0 ) {
			    foreach( $arrayBtn AS $valueAP ) {
			?>
					$("#clickPrice<?php echo $valueAP; ?>").on('click', function(){
						$('#divLoading3').show();
						if( this == "<?php echo base_url(); ?>search/flight_result#<?php echo $valueAP; ?>" ) {
							passingData["departureFlightName"] 	  	= $("#departureFlightName<?php echo $valueAP; ?>").text();
							passingData["departureFlightCode"] 	  	= $("#departureFlightCode<?php echo $valueAP; ?>").text();
						    passingData["departureDateFrom"]   	 	= $("#departureDateFrom<?php echo $valueAP; ?>").text();
						    passingData["departureDateTo"] 	   	  	= $("#departureDateTo<?php echo $valueAP; ?>").text();
						    passingData["departureTimeFrom"]   	  	= $("#departureTimeFrom<?php echo $valueAP; ?>").text();
						    passingData["departureTimeTo"] 		  	= $("#departureTimeTo<?php echo $valueAP; ?>").text();
						    passingData["departureCityNameFrom"] 	= $("#departureCityNameFrom<?php echo $valueAP; ?>").text();
						    passingData["departureCityNameTo"] 	  	= $("#departureCityNameTo<?php echo $valueAP; ?>").text();
						    passingData["departureCityCodeFrom"] 	= $("#departureCityCodeFrom<?php echo $valueAP; ?>").text();
						    passingData["departureCityCodeTo"] 	  	= $("#departureCityCodeTo<?php echo $valueAP; ?>").text();
						    passingData["departureAirportNameFrom"] = $("#departureAirportNameFrom<?php echo $valueAP; ?>").text();
						    passingData["departureAirportNameTo"]   = $("#departureAirportNameTo<?php echo $valueAP; ?>").text();
						    passingData["departureTimeTaken"] 	  	= $("#departureTimeTaken<?php echo $valueAP; ?>").text();
						    passingData["departureBaggage"] 		= $("#departureBaggage<?php echo $valueAP; ?>").text();
						    passingData["departureMeal"] 			= $("#departureMeal<?php echo $valueAP; ?>").text();
						    passingData["departureTotalTransit"] 	= $("#departureTotalTransit<?php echo $valueAP; ?>").text();
						    passingData["departureTotalFlightTime"] = $("#departureTotalFlightTime<?php echo $valueAP; ?>").text();
						    passingData["departureTotalPrice"]	  	= $("#departureTotalPrice<?php echo $valueAP; ?>").text();

						    /* new addition 7.3.2017 bto */
						    passingData["departureFlightResBookDesigCode"]= $("#departureFlightResBookDesigCode<?php echo $valueAP; ?>").text();
						    passingData["departureFlightAirEquipType"]	  = $("#departureFlightAirEquipType<?php echo $valueAP; ?>").text();
						    passingData["departureFlightMarriageGrp"]	  = $("#departureFlightMarriageGrp<?php echo $valueAP; ?>").text();
						    passingData["departureFlightEticket"]	  	  = $("#departureFlightEticket<?php echo $valueAP; ?>").text();
						    /* new addition 19 Mei 2017 to handle price detail */
						   /* new addition 19 Mei 2017 to handle price detail */
						    passingData["departurePriceAdultTaxFare"] = $("#departurePriceAdultTaxFare<?php echo $valueAP;?>").text();
						    passingData["departurePriceAdultBaseFare"] = $("#departurePriceAdultBaseFare<?php echo $valueAP;?>").text();
						    passingData["departurePriceChildTaxFare"] = $("#departurePriceChildTaxFare<?php echo $valueAP;?>").text();
						    passingData["departurePriceChildBaseFare"] = $("#departurePriceChildBaseFare<?php echo $valueAP;?>").text();
						    passingData["departurePriceInfantTaxFare"] = $("#departurePriceInfantTaxFare<?php echo $valueAP;?>").text();
						    passingData["departurePriceInfantBaseFare"] = $("#departurePriceInfantBaseFare<?php echo $valueAP;?>").text();

						    /* 22 mei */
						    passingData["departureTimezone_from"] = $('#departureTimezone_from<?php echo $valueAP;?>').text();
						    passingData["departureTerminalID_from"] = $('#departureTerminalID_from<?php echo $valueAP;?>').text();
						    passingData["departureTimezone_to"] = $('#departureTimezone_to<?php echo $valueAP;?>').text();
						    passingData["departureTerminalID_to"] = $('#departureTerminalID_to<?php echo $valueAP;?>').text();

						    passingData["TotalPriceAdminFare"] = $("#TotalPriceAdminFare<?php echo $valueAP;?>").text();

                            /* 24 Mei, edited 13 june */
                            passingData["departureFareBasisCode"] = $("#departureFareBasisCode<?php echo $valueAP;?>").text();
                            passingData["departureFareBasisCodeChild"] = $("#departureFareBasisCodeChild<?php echo $valueAP;?>").text();
                            passingData["departureFareBasisCodeInfant"] = $("#departureFareBasisCodeInfant<?php echo $valueAP;?>").text();

                            /* 4 Aug 2017 bto : add meals code */
                            passingData['departuremealcode'] = $('#departureMealCode<?php echo $valueAP;?>').text();

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
						//$('#divLoading3').hide();
    				});
			<?php
				}
			}
			?>
	        /*--End of Checkbox Click Button Add to Cart - Single Trip--*/
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