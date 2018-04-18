<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cruise extends CI_Controller {

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
	public function details()
	{
		$this->load->view('cruise_details');
	}
	
	public function getCruiseCheapestPrice()
	{
		$string 	   = "";
		$cruiseTitleID = $this->input->post("cruiseTitleID");
		$shipID 	   = $this->input->post("shipID");
		$brandID 	   = $this->input->post("brandID");
		$noofnight     = $this->input->post("noofnight");
		$noofadult     = $this->input->post("noofadult");
		$noofchild     = $this->input->post("noofchild");
		$string = $this->All->dynamicCheapestPrice($shipID, $brandID, $noofnight, $noofadult, $noofchild, $cruiseTitleID);
		$array = array(
			"errorCode"  => 0,
			"string"     => $string["string"],
			"cruiseDate" => $string["cruiseDate"]
		);
		echo json_encode($array);
	}
	
	public function getCruiseCheapestPriceMobile()
	{
		$string 	   = "";
		$cruiseTitleID = $this->input->post("cruiseTitleID");
		$shipID 	   = $this->input->post("shipID");
		$brandID 	   = $this->input->post("brandID");
		$noofnight     = $this->input->post("noofnight");
		$noofadult     = $this->input->post("noofadult");
		$noofchild     = $this->input->post("noofchild");
		$string = $this->All->dynamicCheapestPriceMobile($shipID, $brandID, $noofnight, $noofadult, $noofchild, $cruiseTitleID);
		$array = array(
			"errorCode"  => 0,
			"string"     => $string["string"],
			"cruiseDate" => $string["cruiseDate"]
		);
		echo json_encode($array);
	}
	
	public function getCruiseListPrice()
	{
		$string 	   = "";
		$cruiseTitleID = $this->input->post("cruiseTitleID");
		$shipID 	   = $this->input->post("shipID");
		$brandID 	   = $this->input->post("brandID");
		$cruiseDate    = $this->input->post("cruiseDate");
		$noofnight     = $this->input->post("noofnight");
		$noofadult     = $this->input->post("noofadult");
		$noofchild     = $this->input->post("noofchild");
		$string = $this->All->dynamicContentPrice($shipID, $brandID, $cruiseDate, $noofnight, $noofadult, $noofchild, $cruiseTitleID);
		$array = array(
			"errorCode" => 0,
			"string"    => $string
		);
		echo json_encode($array);
	}
	
	public function getCruiseListPriceMobile()
	{
		$string 	   = "";
		$cruiseTitleID = $this->input->post("cruiseTitleID");
		$shipID 	   = $this->input->post("shipID");
		$brandID 	   = $this->input->post("brandID");
		$cruiseDate    = $this->input->post("cruiseDate");
		$noofnight     = $this->input->post("noofnight");
		$noofadult     = $this->input->post("noofadult");
		$noofchild     = $this->input->post("noofchild");
		$string = $this->All->dynamicContentPriceMobile($shipID, $brandID, $cruiseDate, $noofnight, $noofadult, $noofchild, $cruiseTitleID);
		$array = array(
			"errorCode" => 0,
			"string"    => $string
		);
		echo json_encode($array);
	}
	
	public function test_POST()
	{
		echo $this->input->post("testValue1");
		echo "<br /><br />";
		echo $this->input->post("testValue2");
		echo "<br /><br />";
		echo die("Stop");
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */