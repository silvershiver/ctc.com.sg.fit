<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landtour extends CI_Controller {

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
		$this->load->view('landtour_details');
	}

	public function getPriceRate()
	{
		$three = $this->input->post("hidden_uri_three");
		$four  = $this->input->post("hidden_uri_four");
		$five  = $this->input->post("hidden_uri_five");
		$six   = $this->input->post("hidden_uri_six");
		$stringArr 	   = array();
		$implodeString = "";
		for( $x=1; $x<=$six; $x++ ) {
			$stringArr[] = $this->input->post("adultQty".$x).".".$this->input->post("cwbQty".$x).".".$this->input->post("cwobQty".$x).".".$this->input->post("infantQty".$x).".".$this->input->post("halfQty".$x);
		}
		$implodeString = implode("~", $stringArr);
		redirect("landtour/second_details/$three/$four/$five/$six/$implodeString");
	}

	public function second_details()
	{
		$this->load->view('landtour_second_details');
	}

	public function getLandtourListPrice()
	{
		$string 	  = "";
		$landtourID   = $this->input->post("landtourID");
		$selectDate   = $this->input->post("selectDate");
		$selectAdult  = $this->input->post("selectAdult");
		$selectChild  = $this->input->post("selectChild");
		$selectInfant = $this->input->post("selectInfant");
		$checked	  = $this->input->post("checkedWB");
		$string = $this->All->landtourShowPrice($landtourID, $selectDate, $selectAdult, $selectChild, $selectInfant, $checked);
		$array = array(
			"errorCode" => 0,
			"string"    => $string
		);
		echo json_encode($array);
	}

	public function saveTicketToCart()
	{
		$noAdultTicket 	   = $this->input->post("form_adultTicket");
		$noChildTicket 	   = $this->input->post("form_childTicket");
		$slug_url	   	   = $this->input->post("hidden_ticket_slug_url");
		$landtourID	   	   = $this->input->post("hidden_ticket_landtourID");
		$lt_system_priceID = $this->input->post("hidden_ticket_systemID");
		$selectedDate 	   = $this->input->post("hidden_ticket_priceDate");
		$sellingType	   = "ticket";
		if( $noAdultTicket == 0 && $noChildTicket == 0 ) {
			$this->session->set_flashdata(
				'errorEmptyQuantity',
				'<div style="text-align:center; color:red; font-size:16px; margin-bottom:10px">
					Please choose at least 1 ticket for adult or child.
				</div>'
			);
			redirect("landtour/details/$slug_url/ticket#pointerRefresh");
		}
		else {
			$checks = $this->All->select_template_w_2_conditions(
				"landtour_product_id", $landtourID, "price_date", $selectedDate, "landtour_system_prices"
			);
			if( $checks == TRUE ) {
				foreach( $checks AS $check ) {
					$ticketAdultQty = $check->ticketAdultQty;
					$ticketChildQty = $check->ticketChildQty;
				}
			}
			if( ($noAdultTicket > $ticketAdultQty) || ($noChildTicket > $ticketChildQty) ) {
				$this->session->set_flashdata(
					'errorInvalidQuantity',
					'<div style="text-align:center; color:red; font-size:16px; margin-bottom:10px">
						Invalid quantity. Adult quantity is only available '.$ticketAdultQty.' ticket(s) & Child quantity is only available '.$ticketChildQty.' ticket(s).
					</div>'
				);
				redirect("landtour/details/$slug_url/ticket#pointerRefresh");
			}
			else {
				if( $this->session->userdata('normal_session_id') == TRUE ) {
					//insert into cart
					$data_fields = array(
						"landtour_product_id" 	   => $landtourID,
						"landtour_system_price_id" => $lt_system_priceID,
						"selectedDate"   		   => $selectedDate,
						"sellingType"   		   => $sellingType,
						"countRoom"  			   => NULL,
						"paxDetails"		  	   => $noAdultTicket."~".$noChildTicket,
						"user_access_id"  		   => $this->session->userdata('normal_session_id'),
						"created" 		  		   => date("Y-m-d H:i:s"),
						"modified" 		  		   => date("Y-m-d H:i:s")
					);
					$insertCart = $this->All->insert_template($data_fields, "landtour_cart");
					//session and redirect
					redirect("cart/index#landtour_cart");
					//end of session and redirect
				}
				else {
					//add to cart
					$arrayLandtourCart = $this->session->userdata('shoppingCartLandtourCookie');
					if( count($arrayLandtourCart) > 0 ) {
						$first_item = array(
							"landtour_product_id" 	   => $landtourID,
							"landtour_system_price_id" => $lt_system_priceID,
							"selectedDate"	 		   => $selectedDate,
							"sellingType"	 		   => $sellingType,
							"countRoom"  			   => "",
							"paxDetails" 			   => $noAdultTicket."~".$noChildTicket,
							"created" 		 		   => date("Y-m-d H:i:s"),
							"modified" 		 		   => date("Y-m-d H:i:s")
						);
						$currentItems = $this->session->userdata('shoppingCartLandtourCookie');
						$currentItems[] = $first_item;
						$this->session->set_userdata('shoppingCartLandtourCookie', $currentItems);
						//session and redirect
						redirect("cart/index#landtour_cart");
						//end of session and redirect
					}
					else {
						$first_item = array(
							"landtour_product_id" 	   => $landtourID,
							"landtour_system_price_id" => $lt_system_priceID,
							"selectedDate"	 		   => $selectedDate,
							"sellingType"	 		   => $sellingType,
							"countRoom"  			   => "",
							"paxDetails" 			   => $noAdultTicket."~".$noChildTicket,
							"created" 		 		   => date("Y-m-d H:i:s"),
							"modified" 		 		   => date("Y-m-d H:i:s")
						);
						$cart_items[] = $first_item;
						$this->session->set_userdata('shoppingCartLandtourCookie', $cart_items);
						//session and redirect
						redirect("cart/index#landtour_cart");
						//end of session and redirect
					}
					//end of add to cart
				}
			}
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */