<?php 

// Include code for making remote connection
include('XMLTransactionHander.class.php'); 


// Process Response

// Client settings
$clientID = 'DAMSON';
$email 	  = 'fandy@pixely.sg';
$password = 'COMMON';
$language = 'English';
$requestMode = 'SYNCHRONOUS'; // 'ASYNCHRONOUS';
$responseCallbackURL =  'http://54.251.177.123/ctcfitapp1/test_gta_api/CallbackResponseHandler.php';

// Build Search Request Data
$destinationType = 'city'; //'city';
$destinationCode = 'lon'; //'lon';
$checkinDate = '2006-05-10'; // '2006-05-10';
$duration = '2'; //'2';
$roomCode = 'db'; //'db';
$numberOfRooms = '1'; //'1';



/**********************************************************/
/** String concatenation example of building XML Request **/
/**********************************************************/
$requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
$requestData .= '<Request>';

// Create Request Header
$requestData .= '<Source>';

// Add Requestor ID data
$requestData .= '<RequestorID Client="'.$clientID.'" EMailAddress="'.$email.'" Password="'.$password.'"/>';

// Add Requestor Preferences data
$requestData .= '<RequestorPreferences Language="'.$language.'">';
$requestData .= '<RequestMode>'.$requestMode.'</RequestMode>';
/*** UNCOMMENT IF USING ASYNCHRONOUS Callback Mode ***/
//$requestData .= '<ResponseURL>'.$responseCallbackURL.'</ResponseURL>';
$requestData .= '</RequestorPreferences>';
$requestData .= '</Source>';

// Create Request Body
$requestData .= '<RequestDetails>';
$requestData .= '<SearchHotelPriceRequest>';

// Add destination
$requestData .= '<ItemDestination DestinationType="'.$destinationType.'" DestinationCode="'.$destinationCode.'"/>';

// Add period of stay
$requestData .= '<PeriodOfStay>';
$requestData .= '<CheckInDate>'.$checkinDate.'</CheckInDate>';
$requestData .= '<Duration>'.$duration.'</Duration>';
$requestData .= '</PeriodOfStay>';

// Add rooms
$requestData .= '<Rooms>';
$requestData .= '<Room Code="'.$roomCode.'" NumberOfRooms="'.$numberOfRooms.'"/>';
$requestData .= '</Rooms>';
$requestData .= '</SearchHotelPriceRequest>';
$requestData .= '</RequestDetails>';

$requestData .= '</Request>';

//echo $requestData;




/*********************************************/
/** XML DOM example of building XML Request **/
/*********************************************/
$requestDoc = new DOMDocument('1.0', 'UTF-8');
$requestElement = $requestDoc->appendChild( $requestDoc->createElement('Request') );

// Create Request Header
$sourceElement = $requestElement->appendChild( $requestDoc->createElement('Source') );

// Add Requestor ID data
$requestorIDElement = $sourceElement->appendChild( $requestDoc->createElement('RequestorID') );
$requestorIDElement->setAttribute( 'Client', $clientID );
$requestorIDElement->setAttribute( 'EMailAddress', $email );
$requestorIDElement->setAttribute( 'Password', $password );

// Add Requestor Preferences data
$requestorPreferencesElement = $sourceElement->appendChild( $requestDoc->createElement('RequestorPreferences') );
$requestorPreferencesElement->setAttribute( 'Language', $language );
$requestModeElement = $requestorPreferencesElement->appendChild( $requestDoc->createElement('RequestMode') );
$requestModeElement->appendChild( $requestDoc->createTextNode( $requestMode ) );
/*** UNCOMMENT IF USING ASYNCHRONOUS Callback Mode ***/
//$responseURLElement = $requestorPreferencesElement->appendChild( $requestDoc->createElement('ResponseURL') );
//$responseURLElement->appendChild( $requestDoc->createTextNode( $responseCallbackURL ) );

// Create Request Body
$requestDetailsElement = $requestElement->appendChild( $requestDoc->createElement('RequestDetails') );
$hotelPriceRequestElement = $requestDetailsElement->appendChild( $requestDoc->createElement('SearchHotelPriceRequest') );

// Add destination
$itemDestinationElement = $hotelPriceRequestElement->appendChild( $requestDoc->createElement('ItemDestination') );
$itemDestinationElement->setAttribute( 'DestinationType', $destinationType );
$itemDestinationElement->setAttribute( 'DestinationCode', $destinationCode );

// Add period of stay
$periodOfStayElement = $hotelPriceRequestElement->appendChild( $requestDoc->createElement('PeriodOfStay') );
$checkinDateElement = $periodOfStayElement->appendChild( $requestDoc->createElement('CheckInDate') );
$checkinDateElement->appendChild( $requestDoc->createTextNode( $checkinDate ) );
$durationElement = $periodOfStayElement->appendChild( $requestDoc->createElement('Duration') );
$durationElement->appendChild( $requestDoc->createTextNode( $duration ) );

// Add rooms
$roomsElement = $hotelPriceRequestElement->appendChild( $requestDoc->createElement('Rooms') );
$roomElement = $roomsElement->appendChild( $requestDoc->createElement('Room') );
$roomElement->setAttribute( 'Code', $roomCode );
$roomElement->setAttribute( 'NumberOfRooms', $numberOfRooms );

$requestData = $requestDoc->saveXML();

//echo $requestData;


/*********************************************/
/*         Execute Search Transaction        */
/*********************************************/
$requestURL = 'https://interface.demo.gta-travel.com/gtaapi/RequestListenerServlet';
$XMLTransactionHander = new XMLTransactionHander;
$responseDoc = $XMLTransactionHander->executeRequest( $requestURL, $requestData );

// Process Response XML Data
if( $responseDoc != NULL ) {
    $responseElement = $responseDoc->documentElement;
    $xpath = new DOMXPath( $responseDoc );    

    $errorsElements = $xpath->query( 'ResponseDetails/SearchHotelPriceResponse/Errors', $responseElement );
    if( $errorsElements->length > 0 ) {
        // Process Errors
        echo '<p>Invalid Search Request</p>';
    } else {
        // Process Response Data
        $searchHotelPriceReponseElements = 

        $searchHotelPriceReponseElements = $xpath->query( 'ResponseDetails/SearchHotelPriceResponse', $responseElement );
        foreach( $searchHotelPriceReponseElements as $searchHotelPriceReponseElement ) {
            $hotelElements = $xpath->query( 'HotelDetails/Hotel', $searchHotelPriceReponseElement );
            echo '<table>';
            foreach( $hotelElements as $hotelElement ) {
                // Process each Hotel
                echo '<tr>';
                $city = $xpath->query( 'City', $hotelElement );
                $item = $xpath->query( 'Item', $hotelElement );
                $itemPrice = $xpath->query( 'ItemPrice', $hotelElement );
                $confirmation = $xpath->query( 'Confirmation', $hotelElement );
                echo '<td>'.$city->item(0)->textContent.'</td>';
                echo '<td>'.$item->item(0)->textContent.'</td>';
                echo '<td>'.$itemPrice->item(0)->textContent.'</td>';
                echo '<td>'.$confirmation->item(0)->textContent.'</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    }
} else {
    echo '<p>Invalid Search Request: '.$XMLTransactionHander->errno.'</p>';
}
?>