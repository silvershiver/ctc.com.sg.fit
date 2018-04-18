<?php
//db connection
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '!@#fandyfandry$%^';
$conn = mysql_connect($dbhost, $dbuser, $dbpass); 
if(! $conn ) {
	die('Could not connect: ' . mysql_error());
}
//end db connection	

/*
$json 		  = file_get_contents('http://iatacodes.org/api/v4/airports?api_key=d0af32a5-f5a2-46c5-8fa5-2de7ae9709a2');
$obj  		  = json_decode($json);
$response 	  = $obj->response;
$country_data = sizeof($response);
//echo "<pre>";
//print_r($response);
//echo "</pre>";
mysql_select_db('ctcfitapp');
for( $x = 0; $x < $country_data; $x++ )
{
	$sql_insert_res = 
		"
			INSERT INTO flight_airportV2 (code, name, city_code, country_code, icao, created, modified) 
			VALUES ('".$response[$x]->code."', '".$response[$x]->name."', '".$response[$x]->city_code."', '".$response[$x]->country_code."', '".$response[$x]->icao."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')
		"
	;
	$sql_insert_row = mysql_query($sql_insert_res);
}
*/


mysql_select_db('ctcfitapp');
$list_res = mysql_query("SELECT * FROM flight_airportV2");
while( $list_row = mysql_fetch_array($list_res, MYSQL_ASSOC) ) {
	//get city name
	$city_res = mysql_query("SELECT * FROM flight_city WHERE code = '".$list_row["city_code"]."'");
	$city_row = mysql_fetch_array($city_res, MYSQL_ASSOC);
	//end of city name
	//get country name
	$country_res = mysql_query("SELECT * FROM flight_country WHERE code = '".$list_row["country_code"]."'");
	$country_row = mysql_fetch_array($country_res, MYSQL_ASSOC);
	//end of country name
	//update
	$update = mysql_query(
		"
			UPDATE flight_airportV2 SET city_name = '".$city_row["name"]."', country_name = '".$country_row["name"]."' 
			WHERE id = ".$list_row["id"]."
		"
	);
	//end of update
}
?>