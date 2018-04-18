<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location extends CI_Controller {

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
	public function getListLocation()
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
		$requestData .= 		'<SearchFacilityRequest FacilityType="hotel">';
		$requestData .= 			'<FacilityName></FacilityName>';
		$requestData .= 			'<FacilityCode></FacilityCode>';
		$requestData .= 		'</SearchFacilityRequest>';
		$requestData .= 	'</RequestDetails>';
		$requestData .= '</Request>';
		$url = "https://interface.demo.gta-travel.com/rbsrsapi/RequestListenerServlet";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, true);		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		$array_output = $this->All->XMLtoArray($output);
		echo "<pre>";
		print_r($array_output);
		echo "</pre>";
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */