<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function getListArea()
	{
		$requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
		$requestData .= '<Request>';
		$requestData .= 	'<Source>';
		$requestData .= 		'<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
		$requestData .= 		'<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
		$requestData .= 			'<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
		$requestData .= 		'</RequestorPreferences>';
		$requestData .= 	'</Source>';
		$requestData .= 	'<RequestDetails>';
		$requestData .= 		'<SearchAreaRequest>';
		$requestData .= 			'<AreaName></AreaName>';
		$requestData .= 		'</SearchAreaRequest>';
		$requestData .= 	'</RequestDetails>';
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
		$array_output = $this->All->XMLtoArray($output);
		$array_list   = $array_output["RESPONSE"]["RESPONSEDETAILS"]["SEARCHAREARESPONSE"]["AREADETAILS"]["AREA"];
		$count_array_list = count($array_list);
		for( $x=0; $x<$count_array_list; $x++ ) {
			$data_fields = array(
				"area_code" => $array_list[$x]["CODE"],
				"area_name" => $array_list[$x]["content"],
				"created"   => date("Y-m-d H:i:s"),
				"modified"  => date("Y-m-d H:i:s")
			);
			$insert_area = $this->All->insert_template($data_fields, "hotel_list_area_gta");
		}
		echo "Insert data DONE";
		echo "<pre>";
		print_r($array_list);
		echo "</pre>";
	}

	public function getListCityInArea()
	{
		$requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
		$requestData .= '<Request>';
		$requestData .= 	'<Source>';
		$requestData .= 		'<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
		$requestData .= 		'<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
		$requestData .= 			'<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
		$requestData .= 		'</RequestorPreferences>';
		$requestData .= 	'</Source>';
		$requestData .= 	'<RequestDetails>';
		$requestData .= 		'<SearchCitiesInAreaRequest AreaCode="AABS">';
		//$requestData .= 			'<CityName><![CDATA[DAM]]></CityName>';
		$requestData .= 		'</SearchCitiesInAreaRequest>';
		$requestData .= 	'</RequestDetails>';
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
		$array_output = $this->All->XMLtoArray($output);
		//$array_list   = $array_output["RESPONSE"]["RESPONSEDETAILS"]["SEARCHAREARESPONSE"]["AREADETAILS"]["AREA"];
		//$count_array_list = count($array_list);
		/*
		for( $x=0; $x<$count_array_list; $x++ ) {
			$data_fields = array(
				"area_code" => $array_list[$x]["CODE"],
				"area_name" => $array_list[$x]["content"],
				"created"   => date("Y-m-d H:i:s"),
				"modified"  => date("Y-m-d H:i:s")
			);
			$insert_area = $this->All->insert_template($data_fields, "hotel_list_area_gta");
		}
		echo "Insert data DONE";
		*/
		echo "<pre>";
		print_r($array_output);
		echo "</pre>";
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */