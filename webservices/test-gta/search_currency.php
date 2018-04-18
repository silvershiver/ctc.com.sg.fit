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


$requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
$requestData .= '<Request>';
	$requestData .= '<Source>';
		$requestData .= '<RequestorID Client="'.$clientID.'" EMailAddress="'.$email.'" Password="'.$password.'"/>';
		$requestData .= '<RequestorPreferences>';
			$requestData .= '<RequestMode>'.$requestMode.'</RequestMode>';
		$requestData .= '</RequestorPreferences>';
	$requestData .= '</Source>';
	$requestData .= '<RequestDetails>';
		$requestData .= '<SearchCurrencyRequest>';
			$requestData .= '<CurrencyName><![CDATA[A]]></CurrencyName>';
		$requestData .= '</SearchCurrencyRequest>';
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
    $errorsElements = $xpath->query( 'ResponseDetails/SearchCurrencyResponse/Errors', $responseElement );
    if( $errorsElements->length > 0 ) {
        echo '<p>Invalid Search Request</p>';
    }
    else {
	    
	    $x = 0;
	    $searchCurrencyReponseElements = $xpath->query( 'ResponseDetails/SearchCurrencyResponse', $responseElement );
	    foreach( $searchCurrencyReponseElements as $searchCurrencyReponseElement ) {
			$currencyElements = $xpath->query( 'CurrencyDetails/Currency', $searchCurrencyReponseElement );
			foreach( $currencyElements AS $currencyElement ) {
				foreach( $currencyElement->attributes AS $attribute ) {
				 	$array_final_result[$x]["attributes"][$attribute->name] = $attribute->value;
			    }
			    $array_final_result[$x]["Name"] = $currencyElement->textContent;
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
// End of Process Response XML Data

?>
