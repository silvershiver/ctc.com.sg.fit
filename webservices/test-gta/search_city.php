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
		<SearchCityRequest CountryCode="GR">
			<CityName><![CDATA[AM]]></CityName>
		</SearchCityRequest>
	</RequestDetails>
</Request>
*/

$country_res = mysql_query("SELECT * FROM hotel_list_country_gta ORDER BY country_code ASC");
while( $country_row = mysql_fetch_array($country_res, MYSQL_ASSOC) ) {
	
	//inputs
	$requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
	$requestData .= '<Request>';
		$requestData .= '<Source>';
			$requestData .= '<RequestorID Client="'.$clientID.'" EMailAddress="'.$email.'" Password="'.$password.'"/>';
			$requestData .= '<RequestorPreferences Language="en">';
				$requestData .= '<RequestMode>'.$requestMode.'</RequestMode>';
			$requestData .= '</RequestorPreferences>';
		$requestData .= '</Source>';
		$requestData .= '<RequestDetails>';
			$requestData .= '<SearchCityRequest CountryCode="'.$country_row["country_code"].'">';
				$requestData .= '<CityName></CityName>';
			$requestData .= '</SearchCityRequest>';
		$requestData .= '</RequestDetails>';
	$requestData .= '</Request>';
	//end of inputs
	
	/*--Execute Search Transaction--*/
	$requestURL = 'https://interface.demo.gta-travel.com/rbsrsapi/RequestListenerServlet';
	$XMLTransactionHander = new XMLTransactionHander;
	$responseDoc = $XMLTransactionHander->executeRequest( $requestURL, $requestData );
	$array_final_result = array();
	/*--End of execute search transaction--*/

	// Process Response XML Data
	if( $responseDoc != NULL ) {
	    $responseElement = $responseDoc->documentElement;
	    $xpath = new DOMXPath( $responseDoc );
	    $errorsElements = $xpath->query( 'ResponseDetails/SearchCityResponse/Errors', $responseElement );
	    if( $errorsElements->length > 0 ) {
	        echo '<p>Invalid Search Request</p>';
	    }
	    else {
		    $x = 0;
		    $searchCityReponseElements = $xpath->query( 'ResponseDetails/SearchCityResponse', $responseElement );
		    foreach( $searchCityReponseElements as $searchCityReponseElement ) {
				$cityElements = $xpath->query( 'CityDetails/City ', $searchCityReponseElement );
				foreach( $cityElements AS $cityElement ) {
					foreach( $cityElement->attributes AS $attribute ) {
					 	$array_final_result[$x]["attributes"][$attribute->name] = $attribute->value;
				    }
				    $array_final_result[$x]["Name"] = $cityElement->textContent;
				    $x++;
				}
			}
			
			//array hold all country data
			$array_city = array();
			$city_res = mysql_query("SELECT * FROM hotel_list_city_gta ORDER BY city_code ASC");
			while( $city_row = mysql_fetch_array($city_res, MYSQL_ASSOC) ) {
				$array_city[] = $city_row["city_code"];
			}
			//end of array hold all country data
			
			//insert and update into hotel_list_country_gta
			for( $x=0; $x<sizeof($array_final_result); $x++ ) {
				if( !in_array($array_final_result[$x]["attributes"]["Code"], $array_city) ) {
					$insert_query = mysql_query(
						"
							INSERT INTO hotel_list_city_gta (city_code, city_name, country_code, created, modified)
							VALUES ('".$array_final_result[$x]["attributes"]["Code"]."', '".$array_final_result[$x]["Name"]."', 									'".$country_row["country_code"]."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')
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
	// End of Process Response XML Data
}

//print result
echo "<pre>";
print_r($array_final_result);
echo "</pre>";
//end of print result

// End of Process Response XML Data

?>
