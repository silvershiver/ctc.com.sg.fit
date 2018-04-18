<?php 

//db connection
$servername = "localhost";
$username 	= "root";
$password 	= "!@#fandyfandry$%^";
$dbhandle   = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
$selected   = mysql_select_db("ctcfitapp", $dbhandle) or die("Could not select ctcfitapp");
//end of db connection

// Include code for making remote connection
include('XMLTransactionHander.class.php'); 

// Client settings
$clientID 	 = '62';
$email 		 = 'XML.PIXELY@CTC.COM';
$password 	 = 'PASS';
$language 	 = 'en';
$requestMode = 'SYNCHRONOUS';
$responseCallbackURL =  'http://54.251.177.123/ctcfitapp1/webservices/test-gta/CallbackResponseHandler.php';

/*
<?xml version="1.0" encoding="UTF-8"?>
<Request>
	<Source>
		<RequestorID Client="123456" EMailAddress="clientName@client.co.uk" Password="clientPassword" />
		<RequestorPreferences Language="en">
		  	<RequestMode>SYNCHRONOUS</RequestMode> 
		</RequestorPreferences>
	</Source>
	<RequestDetails>
		<SearchCountryRequest>
			<CountryName><![CDATA[GREE]]></CountryName>
		</SearchCountryRequest>
	</RequestDetails>
</Request>
*/

$requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
$requestData .= '<Request>';
	$requestData .= '<Source>';
		$requestData .= '<RequestorID Client="'.$clientID.'" EMailAddress="'.$email.'" Password="'.$password.'"/>';
		$requestData .= '<RequestorPreferences Language="en">';
			$requestData .= '<RequestMode>'.$requestMode.'</RequestMode>';
		$requestData .= '</RequestorPreferences>';
	$requestData .= '</Source>';
	$requestData .= '<RequestDetails>';
		$requestData .= '<SearchCountryRequest>';
			$requestData .= '<CountryName></CountryName>';
		$requestData .= '</SearchCountryRequest>';
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
    $errorsElements = $xpath->query( 'ResponseDetails/SearchCountryResponse/Errors', $responseElement );
    if( $errorsElements->length > 0 ) {
        echo '<p>Invalid Search Request</p>';
    }
    else {
	    
	    $x = 0;
	    $searchCountryReponseElements = $xpath->query( 'ResponseDetails/SearchCountryResponse', $responseElement );
	    foreach( $searchCountryReponseElements as $searchCountryReponseElement ) {
			$countryElements = $xpath->query( 'CountryDetails/Country ', $searchCountryReponseElement );
			foreach( $countryElements AS $countryElement ) {
				foreach( $countryElement->attributes AS $attribute ) {
				 	$array_final_result[$x]["attributes"][$attribute->name] = $attribute->value;
			    }
			    $array_final_result[$x]["Name"] = $countryElement->textContent;
			    $x++;
			}
		}
		
		//array hold all country data
		$array_country = array();
		$country_res = mysql_query("SELECT * FROM hotel_list_country_gta ORDER BY country_code ASC");
		while( $country_row = mysql_fetch_array($country_res, MYSQL_ASSOC) ) {
			$array_country[] = $country_row["country_code"];
		}
		//end of array hold all country data
		
		//insert and update into hotel_list_country_gta
		for( $x=0; $x<sizeof($array_final_result); $x++ ) {
			if( !in_array($array_final_result[$x]["attributes"]["Code"], $array_country) ) {
				$insert_query = mysql_query(
					"
						INSERT INTO hotel_list_country_gta (country_code, country_name, created, modified)
						VALUES ('".$array_final_result[$x]["attributes"]["Code"]."', '".$array_final_result[$x]["Name"]."', 									'".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')
					"
				);
			}
		}
		//end of update into hotel_list_country_gta
		
    }
}
else {
    echo '<p>Invalid Search Request: '.$XMLTransactionHander->errno.'</p>';
}

//print result
echo "<pre>";
print_r($array_final_result);
echo "</pre>";
//end of print result

// End of Process Response XML Data

?>
