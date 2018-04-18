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

$json 		  = file_get_contents('http://iatacodes.org/api/v4/countries?api_key=d0af32a5-f5a2-46c5-8fa5-2de7ae9709a2');
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
			INSERT INTO flight_country (code, code3, iso_numeric, name, created, modified) 
			VALUES ('".$response[$x]->code."', '".$response[$x]->code3."', '".$response[$x]->iso_numeric."', '".$response[$x]->name."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')
		"
	;
	$sql_insert_row = mysql_query($sql_insert_res);
}

?>