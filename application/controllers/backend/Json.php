<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Controller {

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
	public function countryList()
	{
		$arrayCountryList = array();
		$finalOutput = "";
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"SELECT DISTINCT(country_name) AS country_name FROM landtour_location ORDER BY country_name ASC"
		);
		if( mysqli_num_rows($check_res) > 0 ) {
			while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
				$arrayCountryList[] = "'".$check_row["country_name"]."'";
			}
		}
		if( count($arrayCountryList) > 0 ) {
			$finalOutput = implode(", ", $arrayCountryList);
		}
		return $finalOutput;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */