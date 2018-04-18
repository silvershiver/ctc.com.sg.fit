<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
	public function do_login_process()
	{
		$logins = $this->All->frontend_login($this->input->post("email"), sha1(SHA1_VAR.$this->input->post('password')));
		if( $logins == TRUE ) {
			//remember me
			$rememberme = $this->input->post('remember_me');
			if( $rememberme == 1 ) {
				$this->session->set_userdata('ctcfit_app_email',    $this->input->post('email'));
				$this->session->set_userdata('ctcfit_app_password', $this->input->post('password'));
			}
			else {
				$this->session->unset_userdata('ctcfit_app_email');
				$this->session->unset_userdata('ctcfit_app_password');
			}
			//end of remember me
			foreach( $logins AS $login ) {
				$user_id       = $login->id;
				$first_name    = $login->first_name;
				$last_name     = $login->last_name;
				$email_address = $login->email_address;
				$access_role   = $login->access_role;
			}
			$this->session->set_userdata('normal_session_id', 			 $user_id);
			$this->session->set_userdata('normal_session_first_name', 	 $first_name);
			$this->session->set_userdata('normal_session_last_name', 	 $last_name);
			$this->session->set_userdata('normal_session_email_address', $email_address);
			$this->session->set_userdata('normal_session_access_role', 	 $access_role);
			//migrate session into cruise chart
			$arrayCruise = $this->session->userdata('shoppingCartCruiseCookie');
			$arrayCruiseCount = count($arrayCruise);
			if( $arrayCruiseCount > 0 ) {
				for($c=0; $c<$arrayCruiseCount; $c++) {
					$data_fields = array(
						"brandID" 		  => $arrayCruise[$c]["brandID"],
						"shipID" 		  => $arrayCruise[$c]["shipID"],
						"cruiseTitleID"   => $arrayCruise[$c]["cruiseTitleID"],
						"durationNight"   => $arrayCruise[$c]["durationNight"],
						"cruiseDate" 	  => $arrayCruise[$c]["cruiseDate"],
						"stateroomID" 	  => $arrayCruise[$c]["stateroomID"],
						"cruisePrice" 	  => $arrayCruise[$c]["cruisePrice"],
						"cruisePriceType" => $arrayCruise[$c]["cruisePriceType"],
						"extraPrice" 	  => $arrayCruise[$c]["extraPrice"],
						"extraIDs" 		  => $arrayCruise[$c]["extraIDs"],
						"extraPeriod" 	  => $arrayCruise[$c]["extraPeriod"],
						"noofAdult" 	  => $arrayCruise[$c]["noofAdult"],
						"noofChild" 	  => $arrayCruise[$c]["noofChild"],
						"user_access_id"  => $user_id,
						"created" 		  => date("Y-m-d H:i:s"),
						"modified" 		  => date("Y-m-d H:i:s")
					);
					$insertCart = $this->All->insert_template($data_fields, "cruise_cart");
				}
			}
			$this->session->unset_userdata('shoppingCartCruiseCookie');
			//end of mograte session into cruise chart

			/* flight Array */
			$arrayFlight = $this->session->userdata('shoppingCartFlightCookie');
			$arrayFlightCount = count($arrayFlight);
			if( $arrayFlightCount > 0 ) {
				for($c=0; $c<$arrayFlightCount; $c++) {
					$first_item = array(
						"departureFlightName" 	 	=> $arrayFlight[$c]["departureFlightName"],
					    "departureFlightCode" 	 	=> $arrayFlight[$c]["departureFlightCode"],
					    "departureDateFrom" 		=> $arrayFlight[$c]["departureDateFrom"],
					    "departureDateTo" 		 	=> $arrayFlight[$c]["departureDateTo"],
					    "departureTimeFrom"		 	=> $arrayFlight[$c]["departureTimeFrom"],
					    "departureTimeTo"			=> $arrayFlight[$c]["departureTimeTo"],
					    "departureCityNameFrom" 	=> $arrayFlight[$c]["departureCityNameFrom"],
					    "departureCityNameTo" 	 	=> $arrayFlight[$c]["departureCityNameTo"],
					    "departureCityCodeFrom" 	=> $arrayFlight[$c]["departureCityCodeFrom"],
					    "departureCityCodeTo" 	  	=> $arrayFlight[$c]["departureCityCodeTo"],
					    "departureAirportNameFrom" 	=> $arrayFlight[$c]["departureAirportNameFrom"],
					    "departureAirportNameTo" 	=> $arrayFlight[$c]["departureAirportNameTo"],
					    "departureTimeTaken" 		=> $arrayFlight[$c]["departureTimeTaken"],
					    "departureBaggage" 		 	=> $arrayFlight[$c]["departureBaggage"],
					    "departureMeal" 		 	=> $arrayFlight[$c]["departureMeal"],
					    "departureTotalTransit" 	=> $arrayFlight[$c]["departureTotalTransit"],
					    "departureTotalFlightTime" 	=> $arrayFlight[$c]["departureTotalFlightTime"],
					    "departureTotalPrice" 	 	=> $arrayFlight[$c]["departureTotalPrice"],
					    "departureFlightResBookDesigCode" => $arrayFlight[$c]['departureFlightResBookDesigCode'],
					    "departureFlightAirEquipType" => $arrayFlight[$c]['departureFlightAirEquipType'],
					    "departureFlightMarriageGrp" => $arrayFlight[$c]['departureFlightMarriageGrp'],
					    "departureFlightEticket" => $arrayFlight[$c]['departureFlightEticket'],

						"departurePriceAdultTaxFare" => $arrayFlight[$c]['departurePriceAdultTaxFare'],
						"departurePriceAdultBaseFare" => $arrayFlight[$c]['departurePriceAdultBaseFare'],
						"departurePriceChildTaxFare" => $arrayFlight[$c]['departurePriceChildTaxFare'],
						"departurePriceChildBaseFare" => $arrayFlight[$c]['departurePriceChildBaseFare'],
						"departurePriceInfantTaxFare" => $arrayFlight[$c]['departurePriceInfantTaxFare'],
						"departurePriceInfantBaseFare" => $arrayFlight[$c]['departurePriceInfantBaseFare'],
						"departureTerminalID_from" => $arrayFlight[$c]['departureTerminalID_from'],
						"departureTimezone_from" => $arrayFlight[$c]['departureTimezone_from'],
						"departureTerminalID_to" => $arrayFlight[$c]['departureTerminalID_to'],
						"departureTimezone_to" => $arrayFlight[$c]['departureTimezone_to'],
					    "arrivalFlightName" 	 	=> $arrayFlight[$c]["arrivalFlightName"],
					    "arrivalFlightCode" 	 	=> $arrayFlight[$c]["arrivalFlightCode"],
					    "arrivalDateFrom" 		 	=> $arrayFlight[$c]["arrivalDateFrom"],
					    "arrivalDateTo" 		 	=> $arrayFlight[$c]["arrivalDateTo"],
					    "arrivalTimeFrom"		 	=> $arrayFlight[$c]["arrivalTimeFrom"],
					    "arrivalTimeTo"			 	=> $arrayFlight[$c]["arrivalTimeTo"],
					    "arrivalCityNameFrom" 	 	=> $arrayFlight[$c]["arrivalCityNameFrom"],
					    "arrivalCityNameTo" 	 	=> $arrayFlight[$c]["arrivalCityNameTo"],
					    "arrivalCityCodeFrom" 	 	=> $arrayFlight[$c]["arrivalCityCodeFrom"],
					    "arrivalCityCodeTo" 	 	=> $arrayFlight[$c]["arrivalCityCodeTo"],
					    "arrivalAirportNameFrom" 	=> $arrayFlight[$c]["arrivalAirportNameFrom"],
					    "arrivalAirportNameTo" 	 	=> $arrayFlight[$c]["arrivalAirportNameTo"],
					    "arrivalTimeTaken" 		 	=> $arrayFlight[$c]["arrivalTimeTaken"],
					    "arrivalBaggage" 		 	=> $arrayFlight[$c]["arrivalBaggage"],
					    "arrivalMeal" 		 	 	=> $arrayFlight[$c]["arrivalMeal"],
					    "arrivalTotalTransit" 	 	=> $arrayFlight[$c]["arrivalTotalTransit"],
					    "arrivalTotalFlightTime" 	=> $arrayFlight[$c]["arrivalTotalFlightTime"],
					    "arrivalTotalPrice" 	 	=> $arrayFlight[$c]["arrivalTotalPrice"],
					    "arrivalFlightResBookDesigCode" => $arrayFlight[$c]['arrivalFlightResBookDesigCode'],
					    "arrivalFlightAirEquipType" => $arrayFlight[$c]['arrivalFlightAirEquipType'],
					    "arrivalFlightMarriageGrp" => $arrayFlight[$c]['arrivalFlightMarriageGrp'],
					    "arrivalFlightEticket" => $arrayFlight[$c]['arrivalFlightEticket'],
					    "arrivalPriceAdultTaxFare" => $arrayFlight[$c]['arrivalPriceAdultTaxFare'],
						"arrivalPriceAdultBaseFare" => $arrayFlight[$c]['arrivalPriceAdultBaseFare'],
						"arrivalPriceChildTaxFare" => $arrayFlight[$c]['arrivalPriceChildTaxFare'],
						"arrivalPriceChildBaseFare" => $arrayFlight[$c]['arrivalPriceChildBaseFare'],
						"arrivalPriceInfantTaxFare" => $arrayFlight[$c]['arrivalPriceInfantTaxFare'],
						"arrivalPriceInfantBaseFare" => $arrayFlight[$c]['arrivalPriceInfantBaseFare'],
						"arrivalTerminalID_from" => $arrayFlight[$c]['arrivalTerminalID_from'],
						"arrivalTimezone_from" => $arrayFlight[$c]['arrivalTimezone_from'],
						"arrivalTerminalID_to" => $arrayFlight[$c]['arrivalTerminalID_to'],
						"arrivalTimezone_to" => $arrayFlight[$c]['arrivalTimezone_to'],
						"departureFareBasisCode" => $arrayFlight[$c]['departureFareBasisCode'],
						"departureFareBasisCodeChild" => $arrayFlight[$c]['departureFareBasisCodeChild'],
						"departureFareBasisCodeInfant" => $arrayFlight[$c]['departureFareBasisCodeInfant'],
						"arrivalFareBasisCode" => $arrayFlight[$c]['arrivalFareBasisCode'],
						"arrivalFareBasisCodeChild" => $arrayFlight[$c]['arrivalFareBasisCodeChild'],
						"arrivalFareBasisCodeInfant" => $arrayFlight[$c]['arrivalFareBasisCodeInfant'],
		                "departuremealcode" => $arrayFlight[$c]['departuremealcode'],
		                "arrivalmealcode" => $arrayFlight[$c]['arrivalmealcode'],

						"TotalPriceAdminFare" => $arrayFlight[$c]['TotalPriceAdminFare'],
					    "noofAdult" 	 	 		=> $arrayFlight[$c]["noofAdult"],
						"noofChild" 	 	 		=> $arrayFlight[$c]["noofChild"],
						"noofInfant" 	 	 		=> $arrayFlight[$c]["noofInfant"],
						"flightClass"				=> $arrayFlight[$c]["flightClass"],
						"created" 		  		 	=> date("Y-m-d H:i:s"),
						"modified" 		  		 	=> date("Y-m-d H:i:s"),
						"user_access_id" =>			$this->session->userdata('normal_session_id'),
						"isReturnFlight"			=> isset($arrayFlight[$c]['isReturnFlight']) ? "1" : "0"
					);
					//insert into cart
					$insertCart = $this->All->insert_template($first_item, "flight_cart");
				}
			}
			$this->session->unset_userdata('shoppingCartFlightCookie');
			//end of migrate session into flight chart

			//migrate session into hotel chart
			$arrayHotel = $this->session->userdata('shoppingCartCookie');
			$arrayHotelCount = count($arrayHotel);
			if( $arrayHotelCount > 0 ) {
				for($c=0; $c<$arrayHotelCount; $c++) {
					$data_fields = array(
						"hotel_Fullname"	  => $arrayHotel[$c]['hotel_Fullname'],
						"hotel_Image"	 	  => $arrayHotel[$c]['hotel_Image'],
						"hotel_ItemCode" 	  => $arrayHotel[$c]['hotel_ItemCode'],
						"hotel_ItemCityCode"  => $arrayHotel[$c]['hotel_ItemCityCode'],
						"hotel_PricePerRoom"  => $arrayHotel[$c]['hotel_PricePerRoom'],
						"hotel_RoomType" 	  => $arrayHotel[$c]['hotel_RoomType'],
						"hotel_RoomTypeID"    => $arrayHotel[$c]['hotel_RoomTypeID'],
						"hotel_RoomQuantity"  => $arrayHotel[$c]['hotel_RoomQuantity'],
						"hotel_AdultQuantity" => $arrayHotel[$c]['hotel_AdultQuantity'],
						"check_in_date" 	  => $arrayHotel[$c]['check_in_date'],
						"check_out_date" 	  => $arrayHotel[$c]['check_in_date'],
						"duration" 	 		  => $arrayHotel[$c]['duration'],
						"user_access_id" 	  => $this->session->userdata('normal_session_id'),
						"created" 			  => date("Y-m-d H:i:s"),
						"modified" 			  => date("Y-m-d H:i:s")
					);
					$insertCart = $this->All->insert_template($data_fields, "hotel_cart");
				}
			}
			$this->session->unset_userdata('shoppingCartCookie');
			//end of mograte session into hotel chart

			//migrate session into landtour chart
			$arrayLT = $this->session->userdata('shoppingCartLandtourCookie');
			$arrayLTCount = count($arrayLT);
			if( $arrayLTCount > 0 ) {
				for($c=0; $c < $arrayLTCount; $c++) {
					$data_fields = array(
						"landtour_product_id" 	   => $arrayLT['landtour_product_id'],
						"landtour_system_price_id" => $arrayLT['landtour_system_price_id'],
						"selectedDate"	 		   => $arrayLT['selectedDate'],
						"sellingType"	 		   => $arrayLT['sellingType'],
						"countRoom"  			   => $arrayLT['countRoom'],
						"paxDetails" 			   => $arrayLT['paxDetails'],
						"created" 		 		   => date("Y-m-d H:i:s"),
						"modified" 		 		   => date("Y-m-d H:i:s")
					);
					$insertCart = $this->All->insert_template($data_fields, "landtour_cart");
				}
			}
			$this->session->unset_userdata('shoppingCartLandtourCookie');
			//end of mograte session into cruise chart


			echo 1;
		}
		else {
			echo 0;
		}
	}

	public function dologout()
	{
		$this->session->unset_userdata('normal_session_id');
		redirect("/");
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */