<?php 

// Include code for making remote connection
include('XMLTransactionHander.class.php'); 

// Client settings
$clientID 	 = '62';
$email 		 = 'XML.PIXELY@CTC.COM';
$password 	 = 'PASS';
$language 	 = 'en';
$requestMode = 'SYNCHRONOUS';
$responseCallbackURL =  'http://54.251.177.123/ctcfitapp1/webservices/test-gta/CallbackResponseHandler.php';

// Build Search Request Data
$destinationType = 'city'; //'city';
$destinationCode = 'SIN'; //'lon';
$checkinDate 	 = '2016-03-19'; // '2006-05-10';
$duration 	 	 = '1'; //'2';
$roomCode 		 = 'db'; //'db';
$numberOfRooms 	 = '1'; //'1';

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

/*--Execute Search Transaction--*/
$requestURL = 'https://interface.demo.gta-travel.com/rbsrsapi/RequestListenerServlet';
$XMLTransactionHander = new XMLTransactionHander;
//echo $requestData;
$responseDoc = $XMLTransactionHander->executeRequest( $requestURL, $requestData );


$array_final_result = array();

// Process Response XML Data
if( $responseDoc != NULL ) {
    $responseElement = $responseDoc->documentElement;
    $xpath = new DOMXPath( $responseDoc );
    $errorsElements = $xpath->query( 'ResponseDetails/SearchHotelPriceResponse/Errors', $responseElement );
    if( $errorsElements->length > 0 ) {
        echo '<p>Invalid Search Request</p>';
    }
    else {
	    $x = 0;
	    $searchHotelPriceReponseElements = $xpath->query( 'ResponseDetails/SearchHotelPriceResponse', $responseElement );
	    foreach( $searchHotelPriceReponseElements as $searchHotelPriceReponseElement ) {
		    $hotelElements = $xpath->query( 'HotelDetails/Hotel', $searchHotelPriceReponseElement );
	        foreach( $hotelElements as $hotelElement ) {
			    $itemPrice = $xpath->query( 'ItemPrice', 	$hotelElement );
			    $locationDetails = $xpath->query( 'LocationDetails', 	$hotelElement );
			    //hotel xml tags
			    foreach( $hotelElement->attributes AS $attribute ) {
				 	$array_final_result[$x]["attributes"][$attribute->name] = $attribute->value;
			    }
			    //end of hotel xml tags
			    //city xml tags
			    $city = $xpath->query('City', $hotelElement);
			    foreach( $city AS $city_arrs ) {
				    foreach( $city_arrs->attributes AS $city_arr ) {
					    $array_final_result[$x]["City"][$city_arr->name] = $city_arr->value;
				    }
					$array_final_result[$x]["City"]["value"] = $city_arrs->textContent;
				}
				//end of city xml tags
				//item xml tags
				$item = $xpath->query('Item', $hotelElement);
				foreach( $item AS $item_arrs ) {
				    foreach( $item_arrs->attributes AS $item_arr ) {
					    $array_final_result[$x]["Item"][$item_arr->name] = $item_arr->value;
				    }
					$array_final_result[$x]["Item"]["value"] = $item_arrs->textContent;
				}
				//end of item xml tags
			    $array_final_result[$x]["item_price"]   = $itemPrice->item(0)->textContent;
			    $array_final_result[$x]["locationDetails"][] = $locationDetails->item(0)->textContent;
				$x++;
			}
		}		
		echo "<pre>";
		print_r($array_final_result);
		echo "</pre>";
    }
}
else {
    echo '<p>Invalid Search Request: '.$XMLTransactionHander->errno.'</p>';
}
?>
