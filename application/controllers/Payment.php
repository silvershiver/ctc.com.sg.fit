<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends My_Controller {

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

	var $instanceurl = "/var/www/html/ctctravel.org/fit/";

	public function __construct()
    {
        parent::__construct();

        /*if ($this->session->userdata('is_from_backend') && $this->session->userdata('is_from_backend') == 1) {
            /* fixed
        } else if (
            !$this->session->userdata('shoppingCartCruiseCookie') &&
            !$this->session->userdata('shoppingCartCookie') &&
            !$this->session->userdata('shoppingCartFlightCookie') &&
            !$this->session->userdata('shoppingCartLandtourCookie') &&
            !$this->session->userdata('normal_session_id')
        ) {
                redirect(base_url().'cart/emptyCart');
                die();
        }*/
    }

	public function testMail($bookOrderID = "")
	{
		$userEmailAddress    = $this->All->getEmailContactPurchaseInfo($bookOrderID);
		$data["bookRefID"]   = $bookOrderID;
		$data["dateCreated"] = date("Y F d");
		$html = $this->load->view('voucher/final', $data, true);
		$messageContent = $this->load->view('voucher/email_message', '', true);
		$pdfFilePath = $this->instanceurl."assets/final_pdf/".$bookOrderID.".pdf";
		$this->load->library('m_pdf');
		$this->m_pdf->pdf->WriteHTML($html);
		$save_as = $this->m_pdf->pdf->Output($pdfFilePath, "F");
		$attachment = chunk_split(base64_encode($save_as));
	    $this->load->library('email');
	    $config = array(
			'charset'  => 'utf-8',
			'wordwrap' => TRUE,
			'mailtype' => 'html'
		);
		$this->email->initialize($config);
		$this->email->from('info@ctc.com.sg', 'CTC Travel');
		$this->email->to($userEmailAddress);
		//$this->email->bcc('sylvia.tan@ctc.com.sg, immanuel@pixely.sg, fandyfandry@gmail.com, cindy.yan@ctc.com.sg');
		//$this->email->bcc('beto.thamrin@gmail.com');
		//$this->email->bcc('fandyfandry@gmail.com, junyao.shi@ctc.com.sg, gary.tan@ctc.com.sg');
		$this->email->subject('CTC Pax Statement');
		$this->email->message($messageContent);
		$this->email->attach($pdfFilePath);
		$this->email->send();
	}
	public function testPDF()
	{
		//$data = [];
        //load the view and saved it into $html variable
        $html=$this->load->view('voucher/cruise', $data, true);

        //this the the PDF filename that user will get to download
        $pdfFilePath = $this->instanceurl."assets/pdf/output_pdf_name.pdf";

        //load mPDF library
        $this->load->library('m_pdf');

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        //$this->m_pdf->pdf->Output($pdfFilePath, "D");
        $save_as = $this->m_pdf->pdf->Output($pdfFilePath, "F");
        $attachment = chunk_split(base64_encode($save_as));

        $this->load->library('email');
		$this->email->from('fandy@example.com', 'Fandy Fandry');
		$this->email->to('fandyfandry@gmail.com');
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');
		$this->email->attach($pdfFilePath);
		$this->email->send();

	}

	public function final_proceed()
	{
		$success_cruise_checkout = false;
		$success_landtour_checkout = false;
		$success_hotel_checkout = false;
		$success_flight_checkout = false;

		if ( $this->session->userdata('normal_session_id') == TRUE ) {
			/*--GENERAL LOGIC--*/
			$totalGranPrice = trim($this->input->post("hidden_grandTotalPrice"));
			$bookingOrderID = uniqid();
			$sp 			= $this->input->post("remarkCK");
			$data_fields = array(
				"granTotalPrice" => $totalGranPrice,
				"BookingOrderID" => $bookingOrderID,
				"status" 		 => "CONFIRMED",
				"user_access_id" => $this->session->userdata('normal_session_id'),
				"created" 		 => date("Y-m-d H:i:s"),
				"modified" 		 => date("Y-m-d H:i:s")
			);
			$insertConfirm = $this->All->insert_template($data_fields, "confirmedBookOrder");
			$last_insertConfirmID = $this->db->insert_id();
			/*--END OF GENERAL LOGIC--*/

			/*--INSERT CRUISE PAX NAMES--*/
			$cruiseChecks = $this->All->select_template(
				"user_access_id", $this->session->userdata('normal_session_id'), "cruise_cart"
			);
			if ( $cruiseChecks == TRUE ) {
				if ( count($this->input->post("C_paxFullnameAdult")) > 0 && is_array($this->input->post("C_paxFullnameAdult")) ) {
					foreach ( $this->input->post("C_paxFullnameAdult") AS $keyAdult => $valAdult ) {
						$explodeAdult = explode("00000", $keyAdult);
						$L_title   		= $this->input->post("C_paxTitleAdult");
						$L_dobYear 		= $this->input->post("C_paxDobyearAdult");
						$L_dobMonth 	= $this->input->post("C_paxDobmonthAdult");
						$L_dobDay   	= $this->input->post("C_paxDobdayAdult");
						$L_fullname 	= $this->input->post("C_paxFullnameAdult");
						$L_nric 		= $this->input->post("C_paxNricAdult");
						$L_nationality 	= $this->input->post("C_paxNationalityAdult");
						$L_passortNo 	= $this->input->post("C_paxPassportnoAdult");
						$L_issueYear 	= $this->input->post("C_paxIssueyearAdult");
						$L_issueMonth 	= $this->input->post("C_paxIssuemonthAdult");
						$L_issueDay 	= $this->input->post("C_paxIssuedayAdult");
						$L_expireYear 	= $this->input->post("C_paxExpireyearAdult");
						$L_expireMonth 	= $this->input->post("C_paxExpiremonthAdult");
						$L_expireDay 	= $this->input->post("C_paxExpiredayAdult");

						foreach ( $valAdult AS $keyA => $valA ) {
							$L_dobFull    = $L_dobYear[$keyAdult][$keyA]."-".$L_dobMonth[$keyAdult][$keyA]."-".$L_dobDay[$keyAdult][$keyA];
							$L_issueFull  = $L_issueYear[$keyAdult][$keyA]."-".$L_issueMonth[$keyAdult][$keyA]."-".$L_issueDay[$keyAdult][$keyA];
							$L_expireFull = $L_expireYear[$keyAdult][$keyA]."-".$L_expireMonth[$keyAdult][$keyA]."-".$L_expireDay[$keyAdult][$keyA];
							$data_fieldsPaxAdult = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "ADULT",
								"cruise_title_id" 			=> $explodeAdult[1],
								"itemRecordRef" 			=> $explodeAdult[0],
								"pax_title"  				=> $L_title[$keyAdult][$keyA],
								"pax_dob"  					=> $L_dobFull,
								"pax_fullname"  			=> $L_fullname[$keyAdult][$keyA],
								"pax_nric"  				=> $L_nric[$keyAdult][$keyA],
								"pax_nationality"  			=> $L_nationality[$keyAdult][$keyA],
								"pax_passport_no"  			=> $L_passortNo[$keyAdult][$keyA],
								"pax_passport_issue_date"  	=> $L_issueFull,
								"pax_passport_expire_date" 	=> $L_expireFull,
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameAdult = $this->All->insert_template($data_fieldsPaxAdult, "cruise_paxName");
						}
					}
				}
				if( count($this->input->post("C_paxFullnameChild")) > 0 && is_array($this->input->post("C_paxFullnameChild")) ) {
					foreach( $this->input->post("C_paxFullnameChild") AS $keyChild => $valChild ) {
						$explodeChild = explode("00000", $keyChild);
						$L_title   		= $this->input->post("C_paxTitleChild");
						$L_dobYear 		= $this->input->post("C_paxDobyearChild");
						$L_dobMonth 	= $this->input->post("C_paxDobmonthChild");
						$L_dobDay   	= $this->input->post("C_paxDobdayChild");
						$L_fullname 	= $this->input->post("C_paxFullnameChild");
						$L_nric 		= $this->input->post("C_paxNricChild");
						$L_nationality 	= $this->input->post("C_paxNationalityChild");
						$L_passortNo 	= $this->input->post("C_paxPassportnoChild");
						$L_issueYear 	= $this->input->post("C_paxIssueyearChild");
						$L_issueMonth 	= $this->input->post("C_paxIssuemonthChild");
						$L_issueDay 	= $this->input->post("C_paxIssuedayChild");
						$L_expireYear 	= $this->input->post("C_paxExpireyearChild");
						$L_expireMonth 	= $this->input->post("C_paxExpiremonthChild");
						$L_expireDay 	= $this->input->post("C_paxExpiredayChild");
						foreach( $valChild AS $keyC => $valC ) {
							$L_dobFull    = $L_dobYear[$keyChild][$keyC]."-".$L_dobMonth[$keyChild][$keyC]."-".$L_dobDay[$keyChild][$keyC];
							$L_issueFull  = $L_issueYear[$keyChild][$keyC]."-".$L_issueMonth[$keyChild][$keyC]."-".$L_issueDay[$keyChild][$keyC];
							$L_expireFull = $L_expireYear[$keyChild][$keyC]."-".$L_expireMonth[$keyChild][$keyC]."-".$L_expireDay[$keyChild][$keyC];
							$data_fieldsPaxChild = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "CHILD",
								"cruise_title_id" 			=> $explodeChild[1],
								"itemRecordRef" 			=> $explodeChild[0],
								"pax_title"  				=> $L_title[$keyChild][$keyC],
								"pax_dob"  					=> $L_dobFull,
								"pax_fullname"  			=> $L_fullname[$keyChild][$keyC],
								"pax_nric"  				=> $L_nric[$keyChild][$keyC],
								"pax_nationality"  			=> $L_nationality[$keyChild][$keyC],
								"pax_passport_no"  			=> $L_passortNo[$keyChild][$keyC],
								"pax_passport_issue_date"  	=> $L_issueFull,
								"pax_passport_expire_date" 	=> $L_expireFull,
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameChild = $this->All->insert_template($data_fieldsPaxChild, "cruise_paxName");
						}
					}
				}

			}
			/*--END OF INSERT CRUISE PAX NAMES--*/

			/*--INSERT LANDTOUR PAX NAMES--*/
			$landtourCarts = $this->All->select_template(
				"user_access_id", $this->session->userdata('normal_session_id'), "landtour_cart"
			);
			if ( $landtourCarts == TRUE ) {
				if ( count($this->input->post("LT_paxNameAdult")) > 0 && is_array($this->input->post("LT_paxNameAdult")) ) {
					foreach ( $this->input->post("LT_paxNameAdult") AS $keyAdult => $valAdult ) {
						$explodeAdult = explode("00000", $keyAdult);
						foreach ( $valAdult AS $keyA => $valA ) {
							$data_fieldsPaxAdult = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "ADULT",
								"landtour_product_id" 		=> $explodeAdult[2],
								"landtour_history_order_id" => "",
								"roomIndex"					=> $explodeAdult[1],
								"itemRecordRef" 			=> $explodeAdult[0],
								"pax_name"  				=> $valA,
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameAdult = $this->All->insert_template($data_fieldsPaxAdult, "landtour_paxname");
						}
					}
				}
				if ( count($this->input->post("LT_paxNameChildWB")) > 0 && is_array($this->input->post("LT_paxNameChildWB")) ) {
					foreach ( $this->input->post("LT_paxNameChildWB") AS $keyChildWB => $valChildWB ) {
						$explodeChildWB = explode("00000", $keyChildWB);
						foreach ( $valChildWB AS $keyB => $valB ) {
							$data_fieldsPaxChildWB = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "CHILD_WITH_BED",
								"landtour_product_id" 		=> $explodeChildWB[2],
								"landtour_history_order_id" => "",
								"roomIndex"					=> $explodeChildWB[1],
								"itemRecordRef" 			=> $explodeChildWB[0],
								"pax_name"  				=> $valB,
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameChildWB = $this->All->insert_template($data_fieldsPaxChildWB, "landtour_paxname");
						}
					}
				}
				if ( count($this->input->post("LT_paxNameChildWOB")) > 0 && is_array($this->input->post("LT_paxNameChildWOB")) ) {
					foreach ( $this->input->post("LT_paxNameChildWOB") AS $keyChildWOB => $valChildWOB ) {
						$explodeChildWOB = explode("00000", $keyChildWOB);
						foreach ( $valChildWOB AS $keyC => $valC ) {
							$data_fieldsPaxChildWOB = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "CHILD_WITHOUT_BED",
								"landtour_product_id" 		=> $explodeChildWOB[2],
								"landtour_history_order_id" => "",
								"roomIndex"					=> $explodeChildWOB[1],
								"itemRecordRef" 			=> $explodeChildWOB[0],
								"pax_name"  				=> $valC,
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameChildWOB = $this->All->insert_template($data_fieldsPaxChildWOB, "landtour_paxname");
						}
					}
				}
				if ( count($this->input->post("LT_paxNameInfant")) > 0 && is_array($this->input->post("LT_paxNameInfant")) ) {
					foreach ( $this->input->post("LT_paxNameInfant") AS $keyInfant => $valInfant ) {
						$explodeInfant = explode("00000", $keyInfant);
						foreach ( $valInfant AS $keyIN => $valIN ) {
							$data_fieldsPaxInfant = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "INFANT",
								"landtour_product_id" 		=> $explodeInfant[2],
								"landtour_history_order_id" => "",
								"roomIndex"					=> $explodeInfant[1],
								"itemRecordRef" 			=> $explodeInfant[0],
								"pax_name"  				=> $valIN,
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameInfant = $this->All->insert_template($data_fieldsPaxInfant, "landtour_paxname");
						}
					}
				}
				if ( count($this->input->post("LT_ticketNameAdult")) > 0 && is_array($this->input->post("LT_ticketNameAdult")) ) {
					foreach ( $this->input->post("LT_ticketNameAdult") AS $keyTicketAdult => $valTicketAdult ) {
						$explodeTicketAdult = explode("00000", $keyTicketAdult);
						foreach ( $valTicketAdult AS $keyTA => $valTA ) {
							$data_fieldsPaxTA = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "ADULT",
								"landtour_product_id" 		=> $explodeTicketAdult[1],
								"landtour_history_order_id" => NULL,
								"roomIndex"					=> NULL,
								"itemRecordRef" 			=> $explodeTicketAdult[0],
								"pax_name"  				=> $valTA,
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameTicketAdult = $this->All->insert_template($data_fieldsPaxTA, "landtour_paxname_ticket");
						}
					}
				}
				if ( count($this->input->post("LT_ticketNameChild")) > 0 && is_array($this->input->post("LT_ticketNameChild")) ) {
					foreach ( $this->input->post("LT_ticketNameChild") AS $keyTicketChild => $valTicketChild ) {
						$explodeTicketChild = explode("00000", $keyTicketChild);
						foreach ( $valTicketChild AS $keyTC => $valTC ) {
							$data_fieldsPaxTC = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "CHILD",
								"landtour_product_id" 		=> $explodeTicketChild[1],
								"landtour_history_order_id" => NULL,
								"roomIndex"					=> NULL,
								"itemRecordRef" 			=> $explodeTicketChild[0],
								"pax_name"  				=> $valTC,
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameTicketChild = $this->All->insert_template($data_fieldsPaxTC, "landtour_paxname_ticket");
						}
					}
				}
			}
			/*--END OF INSERT LANDTOUR PAX NAMES--*/

			/*--INSERT HOTEL PAX NAMES & HISTORY ORDER--*/
			$hotelCarts = $this->All->select_template(
				"user_access_id", $this->session->userdata('normal_session_id'), "hotel_cart"
			);
			if ( $hotelCarts == TRUE ) {
				$ctr = 0;
				foreach ( $hotelCarts AS $hotelCart ) {
					foreach ( $this->input->post("paxNameAdult") AS $keyRoom => $roomArr ) {
						foreach ($roomArr as $keyAdult => $valAdult) {
							$arrKey 	= explode(":", $keyAdult);
							$lastIdx 	= array_pop($arrKey);
							$roomTypeID = implode(':', explode(':', $keyAdult, -1));
							foreach ( $valAdult AS $keyA => $valA ) {
								$data_fieldsPaxAdult = array(
									"bookingID" 	 	  => $bookingOrderID,
									"adult_or_child" 	  => "ADULT",
									"RoomTypeID" 	 	  => $roomTypeID,
									"paxName" 		 	  => $valA,
									"flag_historyoder_id" => $lastIdx,
									"flag_room" => ($keyRoom + 1),
									"created" 		 	  => date("Y-m-d H:i:s"),
									"modified" 		 	  => date("Y-m-d H:i:s")
								);
								$insertPaxNameAdult = $this->All->insert_template($data_fieldsPaxAdult, "hotel_paxName");
							}
						}
					}

					if ($this->input->post('paxNameChild')) {
						$paxChildAge = $this->input->post('paxNameChildAge');

						foreach ( $this->input->post("paxNameChild") AS $keyRoom => $roomArr )
						{
							foreach ($roomArr as $keyChild => $valChild) {
								$arrKey = explode(":", $keyChild);
								$lastIdx = array_pop($arrKey);
								$roomTypeID = implode(':', explode(':', $keyChild, -1));
								foreach ( $valChild AS $keyC => $valC ) {
									$data_fieldsPaxChild = array(
										"bookingID" 	 	  => $bookingOrderID,
										"adult_or_child" 	  => "CHILD",
										"RoomTypeID" 	 	  => $roomTypeID,
										"paxName" 		 	  => $valC,
										"flag_historyoder_id" => $lastIdx,
										"flag_room" => ($keyRoom + 1),
										"age" => $paxChildAge[$keyRoom]["$keyChild"][$keyC],
										"created" 		 	  => date("Y-m-d H:i:s"),
										"modified" 		 	  => date("Y-m-d H:i:s")
									);
									$insertPaxNameChild = $this->All->insert_template($data_fieldsPaxChild, "hotel_paxName");
								}
							}

						}
					}

					//end of insert paxName
					/*--SPECIAL REQUEST--*/
					$arraySP   = $sp[$hotelCart->id];
					$implodeSP = implode(",", $arraySP);
					/*--END OF SPECIAL REQUEST--*/
					$data_fieldsHistory = array(
						"hotel_confirmedBookOrder_ID" => $last_insertConfirmID,
						"bookingRefID" 			 	  => $bookingOrderID,
						"hotel_Fullname" 			  => $hotelCart->hotel_Fullname,
						"hotel_Image" 		      	  => $hotelCart->hotel_Image,
						"hotel_ItemCode" 		  	  => $hotelCart->hotel_ItemCode,
						"hotel_ItemCityCode" 		  => $hotelCart->hotel_ItemCityCode,
						"hotel_PricePerRoom" 		  => $hotelCart->hotel_PricePerRoom,
						"hotel_RoomType" 			  => $hotelCart->hotel_RoomType,
						"hotel_RoomTypeID"			  => $hotelCart->hotel_RoomTypeID,
						"hotel_RoomQuantity"		  => $hotelCart->hotel_RoomQuantity,
						"hotel_AdultQuantity"		  => $hotelCart->hotel_AdultQuantity,
						"hotel_ChildQuantity"		  => $hotelCart->hotel_ChildQuantity,
						"hotel_InfantQuantity"		  => $hotelCart->hotel_InfantQuantity,
						"check_in_date"				  => $hotelCart->check_in_date,
						"check_out_date"			  => $hotelCart->check_out_date,
						"duration" 		  		  	  => $hotelCart->duration,
						"user_access_id" 			  => $this->session->userdata('normal_session_id'),
						"special_request" 			  => $this->input->post("member_remarksHotel"),
						"hotelAPISpecialRequest"	  => $implodeSP,
						"room_index" => $hotelCart->room_index,
						"room_meal" => $hotelCart->room_meal,
						"GTA_Markup_Rate" => GTA_PRICE_MARKUP,
						"created" 					  => date("Y-m-d H:i:s"),
						"modified" 					  => date("Y-m-d H:i:s")
					);
					$insertHistoryOrder  = $this->All->insert_template($data_fieldsHistory, "hotel_historyOder");
					$last_historyOrderID = $this->db->insert_id();
					$data_field = array("flag_historyoder_id" => $last_historyOrderID);
					$this->All->update_template_two(
						$data_field, 'bookingID', $bookingOrderID, 'flag_historyoder_id', $ctr, 'hotel_paxName'
					);
					$ctr++;
				}
				$success_hotel_checkout = true;
			}
			/*--END OF INSERT HOTEL PAX NAMES & HISTORY ORDER--*/

			/*--INSERT FLIGHT PAX NAMES & HISTORY ORDER--*/
			$flights_cart = $this->All->select_template(
				"user_access_id", $this->session->userdata('normal_session_id'), "flight_cart"
			);
			if ( $flights_cart == TRUE ) {
				//adult passenger
				$pax_titleAdult 				= $this->input->post("titleAdult");
				$pax_givennameAdult 					= $this->input->post("givennameAdult");
				$pax_surnameAdult 					= $this->input->post("surnameAdult");
				/*$pax_nameAdult = $this->input->post('nameAdult');*/
				$pax_passport_noAdult 			= $this->input->post("passport_noAdult");
				$pax_nationalityAdult 			= $this->input->post("nationalityAdult");
				$pax_passportIssueCountryAdult 	= $this->input->post("passportIssueCountryAdult");
				$pax_dob_yearAdult 				= $this->input->post("dob_yearAdult");
				$pax_dob_monthAdult 			= $this->input->post("dob_monthAdult");
				$pax_dob_dayAdult 				= $this->input->post("dob_dayAdult");
				$pax_passport_expiryYearAdult  	= $this->input->post("passport_expiryYearAdult");
				$pax_passport_expiryMonthAdult 	= $this->input->post("passport_expiryMonthAdult");
				$pax_passport_expiryDateAdult  	= $this->input->post("passport_expiryDateAdult");
				$pax_passport_issueYearAdult   	= $this->input->post("passport_issueYearAdult");
				$pax_passport_issueMonthAdult  	= $this->input->post("passport_issueMonthAdult");
				$pax_passport_issueDayAdult    	= $this->input->post("passport_issueDayAdult");
				$pax_remarksAdult = $this->input->post('passengerRemarks_Adult');

				/* need to rewrite this to query looping */
				$a = 1;

				foreach( $flights_cart AS $flight_cart ) {
					if( count($pax_givennameAdult[$a]) > 0 ) {
						foreach( $pax_givennameAdult[$a] AS $key => $value ) {
					/*if( count($pax_nameAdult[$a]) > 0 ) {
						foreach( $pax_nameAdult[$a] AS $key => $value ) {*/

							/*$names = explode(" ", $pax_nameAdult[$a][$key]);
								$result = array_filter($names);
								$paxname = strtoupper(implode(" ", $result));
							*/
							$paxname = $pax_givennameAdult[$a][$key]." ".$pax_surnameAdult[$a][$key];

							$dobAdult = $pax_dob_yearAdult[$a][$key].'-'.$pax_dob_monthAdult[$a][$key].'-'.$pax_dob_dayAdult[$a][$key];
							$expiredAdult = $pax_passport_expiryYearAdult[$a][$key].'-'.$pax_passport_expiryMonthAdult[$a][$key].'-'.$pax_passport_expiryDateAdult[$a][$key];
							$issuedAdult  = $pax_passport_issueYearAdult[$a][$key].'-'.$pax_passport_issueMonthAdult[$a][$key].'-'.$pax_passport_issueDayAdult[$a][$key];
							$data_fieldsPaxAdult = array(
								"bookingOrderID" 	 			=> $bookingOrderID,
								"passengerType" 				=> "ADULT",
								"passengerTitle" 	 			=> $pax_titleAdult[$a][$key],
								"passengerName" 		 		=> $paxname,
								"passenger_givenname"			=> $pax_givennameAdult[$a][$key],
								"passenger_surname"			=> $pax_surnameAdult[$a][$key],
								"passengerPassportNo" 		 	=> $pax_passport_noAdult[$a][$key],
								"passengerDOB" 		 			=> $dobAdult,
								"passengerNationality" 		 	=> $pax_nationalityAdult[$a][$key],
								"passengerPassportIssueCountry" => $pax_passportIssueCountryAdult[$a][$key],
								"passengerPassportExpiryDate" 	=> $expiredAdult,
								"passengerPassportIssueDate" 	=> $issuedAdult,
								"passenger_remarks" => $pax_remarksAdult[$a][$key],
								"passengerCartID" 		 		=> $a,
								"created" 		 				=> date("Y-m-d H:i:s"),
								"modified" 		 				=> date("Y-m-d H:i:s")
							);
							$insertAdult = $this->All->insert_template($data_fieldsPaxAdult, "flight_passenger_pnr_details");
						}
					}
					$a++;
				}
				//end of adult passenger
				//child passenger
				$pax_titleChild 				= $this->input->post("titleChild");
				/*$pax_nameChild 					= $this->input->post("nameChild");*/
				$pax_givennameChild 					= $this->input->post("givennameChild");
				$pax_surnameChild 					= $this->input->post("surnameChild");

				$pax_passport_noChild 			= $this->input->post("passport_noChild");
				$pax_nationalityChild 			= $this->input->post("nationalityChild");
				$pax_passport_issueCountryChild = $this->input->post("passport_issueCountryChild");
				$pax_dob_yearChild 				= $this->input->post("dob_yearChild");
				$pax_dob_monthChild 			= $this->input->post("dob_monthChild");
				$pax_dob_dayChild 				= $this->input->post("dob_dayChild");
				$pax_passport_expiryYearChild  	= $this->input->post("passport_expiryYearChild");
				$pax_passport_expiryMonthChild 	= $this->input->post("passport_expiryMonthChild");
				$pax_passport_expiryDayChild  	= $this->input->post("passport_expiryDayChild");
				$pax_passport_issueYearChild   	= $this->input->post("passport_issueYearChild");
				$pax_passport_issueMonthChild  	= $this->input->post("passport_issueMonthChild");
				$pax_passport_issueDayChild    	= $this->input->post("passport_issueDayChild");
				$pax_remarksChild = $this->input->post('passengerRemarks_Child');

				$a = 1;
				foreach( $flights_cart AS $flight_cart ) {
					if(isset($pax_givennameChild[$a]) && count($pax_givennameChild[$a]) > 0 ) {
						foreach( $pax_givennameChild[$a] AS $key => $value ) {
					/*if($pax_nameChild[$a] && count($pax_nameChild[$a]) > 0 ) {
						foreach( $pax_nameChild[$a] AS $key => $value ) {*/
							/*$names = explode(" ", $pax_nameChild[$a][$key]);
								$result = array_filter($names);
								$paxname = strtoupper(implode(" ", $result));*/

							$paxname = $pax_givennameChild[$a][$key]." ".$pax_surnameChild[$a][$key];

							$dobChild 	 = $pax_dob_yearChild[$a][$key].'-'.$pax_dob_monthChild[$a][$key].'-'.$pax_dob_dayChild[$a][$key];
							$expiredChild = $pax_passport_expiryYearChild[$a][$key].'-'.$pax_passport_expiryMonthChild[$a][$key].'-'.$pax_passport_expiryDayChild[$a][$key];
							$issuedChild  = $pax_passport_issueYearChild[$a][$key].'-'.$pax_passport_issueMonthChild[$a][$key].'-'.$pax_passport_issueDayChild[$a][$key];
							$data_fieldsPaxChild = array(
								"bookingOrderID" 	 			=> $bookingOrderID,
								"passengerType" 				=> "CHILD",
								"passengerTitle" 	 			=> $pax_titleChild[$a][$key],
								"passengerName" 		 		=> $paxname,
								"passenger_givenname"			=> $pax_givennameChild[$a][$key],
								"passenger_surname"			=> $pax_surnameChild[$a][$key],
								"passengerPassportNo" 		 	=> $pax_passport_noChild[$a][$key],
								"passengerDOB" 		 			=> $dobChild,
								"passengerNationality" 		 	=> $pax_nationalityChild[$a][$key],
								"passengerPassportIssueCountry" => $pax_passport_issueCountryChild[$a][$key],
								"passengerPassportExpiryDate" 	=> $expiredChild,
								"passengerPassportIssueDate" 	=> $issuedChild,
								"passenger_remarks" => $pax_remarksChild[$a][$key],
								"passengerCartID" 		 		=> $a,
								"created" 		 				=> date("Y-m-d H:i:s"),
								"modified" 		 				=> date("Y-m-d H:i:s")
							);
							$insertChild = $this->All->insert_template($data_fieldsPaxChild, "flight_passenger_pnr_details");
						}
					}
					$a++;
				}
				//end of child passenger
				//infant passenger
				$pax_titleInfant 				 = $this->input->post("titleInfant");
				/*$pax_nameInfant 				 = $this->input->post("nameInfant");*/
				$pax_givennameInfant 				 = $this->input->post("givennameInfant");
				$pax_surnameInfant 				 = $this->input->post("surnameInfant");

				$pax_passport_noInfant 			 = $this->input->post("passport_noInfant");
				$pax_nationalityInfant 			 = $this->input->post("nationalityInfant");
				$pax_passport_issueCountryInfant = $this->input->post("passport_issueCountryInfant");
				$pax_dob_yearInfant 			 = $this->input->post("dob_yearInfant");
				$pax_dob_monthInfant 			 = $this->input->post("dob_monthInfant");
				$pax_dob_dayInfant 				 = $this->input->post("dob_dayInfant");
				$pax_passport_expiryYearInfant   = $this->input->post("passport_expiryYearInfant");
				$pax_passport_expiryMonthInfant  = $this->input->post("passport_expiryMonthInfant");
				$pax_passport_expiryDayInfant  	 = $this->input->post("passport_expiryDayInfant");
				$pax_passport_issueYearInfant    = $this->input->post("passport_issueYearInfant");
				$pax_passport_issueMonthInfant   = $this->input->post("passport_issueMonthInfant");
				$pax_passport_issueDayInfant     = $this->input->post("passport_issueDayInfant");
				$pax_remarksInfant = $this->input->post('passengerRemarks_Infant');

				$a = 1;
				foreach( $flights_cart AS $flight_cart ) {
					if(isset($pax_givennameInfant[$a]) && count($pax_givennameInfant[$a]) > 0 ) {
						foreach( $pax_givennameInfant[$a] AS $key => $value ) {
					/*if($pax_nameInfant[$a] && count($pax_nameInfant[$a]) > 0 ) {
						foreach( $pax_nameInfant[$a] AS $key => $value ) {*/
							/*$names = explode(" ", $pax_nameInfant[$a][$key]);
								$result = array_filter($names);
								$paxname = strtoupper(implode(" ", $result));*/

							$paxname = $pax_givennameInfant[$a][$key]." ".$pax_surnameInfant[$a][$key];

							$dobInfant 	   = $pax_dob_yearInfant[$a][$key].'-'.$pax_dob_monthInfant[$a][$key].'-'.$pax_dob_dayInfant[$a][$key];
							$expiredInfant = $pax_passport_expiryYearInfant[$a][$key].'-'.$pax_passport_expiryMonthInfant[$a][$key].'-'.$pax_passport_expiryDayInfant[$a][$key];
							$issuedInfant  = $pax_passport_issueYearInfant[$a][$key].'-'.$pax_passport_issueMonthInfant[$a][$key].'-'.$pax_passport_issueDayInfant[$a][$key];
							$data_fieldsPaxInfant = array(
								"bookingOrderID" 	 			=> $bookingOrderID,
								"passengerType" 				=> "INFANT",
								"passengerTitle" 	 			=> $pax_titleInfant[$a][$key],
								"passengerName" 		 		=> $paxname,
								"passenger_givenname"			=> $pax_givennameInfant[$a][$key],
								"passenger_surname"			=> $pax_surnameInfant[$a][$key],
								"passengerPassportNo" 		 	=> $pax_passport_noInfant[$a][$key],
								"passengerDOB" 		 			=> $dobInfant,
								"passengerNationality" 		 	=> $pax_nationalityInfant[$a][$key],
								"passengerPassportIssueCountry" => $pax_passport_issueCountryInfant[$a][$key],
								"passengerPassportExpiryDate" 	=> $expiredInfant,
								"passengerPassportIssueDate" 	=> $issuedInfant,
								"passenger_remarks" => $pax_remarksInfant[$a][$key],
								"passengerCartID" 		 		=> $a,
								"created" 		 				=> date("Y-m-d H:i:s"),
								"modified" 		 				=> date("Y-m-d H:i:s")
							);
							$insertInfant = $this->All->insert_template($data_fieldsPaxInfant, "flight_passenger_pnr_details");
						}
					}
					$a++;
				}
				//end of infant passenger
				$file_datas  = require_once($this->instanceurl.'webservices/abacus/SWSWebservices.class.php');
				$flight_PNR = "";
				$ha = 0;
				foreach( $flights_cart AS $flight_cart ) {
					$passengerDetails = $this->All->select_template_w_2_conditions(
						"bookingOrderID", $bookingOrderID, "passengerCartID", ($ha + 1),
						"flight_passenger_pnr_details"
					);
					/* get PNR, still only support 1 single FLight */
					$depFlightCode 	  = $flight_cart->departureFlightCode;
					$depFlightCodeArr = explode("~", $depFlightCode);
					if (count($depFlightCodeArr) > 1) {
						/* ok, so ... there is a return.. */
						$returnRefID = book_flight_multiflight(
							$flight_cart->departureFlightAirEquipType,
							$flight_cart->arrivalFlightAirEquipType,
							$flight_cart->departureDateFrom,
							$flight_cart->departureTimeFrom,
							$flight_cart->departureDateTo,
							$flight_cart->departureTimeTo,

							$flight_cart->departureCityCodeFrom,
							$flight_cart->departureCityCodeTo,
							$flight_cart->departureFlightCode,
							$flight_cart->departureFlightResBookDesigCode,
							$flight_cart->departureFlightAirEquipType,
							$flight_cart->departureFlightMarriageGrp,
							$flight_cart->arrivalDateFrom,
							$flight_cart->arrivalTimeFrom,
							$flight_cart->arrivalDateTo,
							$flight_cart->arrivalTimeTo,
							$flight_cart->arrivalCityCodeFrom,
							$flight_cart->arrivalCityCodeTo,
							$flight_cart->arrivalFlightCode,
							$flight_cart->arrivalFlightResBookDesigCode,
							$flight_cart->arrivalFlightAirEquipType,
							$flight_cart->arrivalFlightMarriageGrp,
							$flight_cart->noofAdult,
							$flight_cart->noofChild,
							$flight_cart->noofInfant,
							$this->input->post("emailCP"),
							$this->input->post("contactCP"),
							$this->input->post("nationalityCP"),
							$passengerDetails,
							$this->input->post('remarksCP')
						);
						if($returnRefID != '' && $returnRefID != 'error') {
							/* save the PNR */
							$flight_PNR = $returnRefID;
							/* we got PNR! save to flight_history_order in next session */
						}
						else {
							$this->session->set_flashdata('error_checkout',
										'<article class="full-width-2">
											<div style="text-align:center; color:red; padding:15px; font-size:16px">
												Flight Booking error. Please try again.
											</div>
										</article>');
							//echo 'E';
							redirect("checkout");
							exit;
						}
					}
					else {
						/* check if it one way or transfer / return flight */
						/* single flight */
						$sepFlightCode = explode(" ", $depFlightCode);
						$flightCode    = $sepFlightCode[0];
						$flightNo 	   = $sepFlightCode[1];
						if ($flight_cart->arrivalFlightCode != "") {
							/* return */
							$arrvFlightCode = $flight_cart->arrivalFlightCode;
							$arrvFlightCodeArr = explode("~", $arrvFlightCode);
							if(count($arrvFlightCodeArr)) {
								$returnRefID = book_flight_multiflight(
									$flight_cart->departureFlightAirEquipType,
									$flight_cart->arrivalFlightAirEquipType,
									$flight_cart->departureDateFrom,
									$flight_cart->departureTimeFrom,
									$flight_cart->departureDateTo,
									$flight_cart->departureTimeTo,
									$flight_cart->departureCityCodeFrom,
									$flight_cart->departureCityCodeTo,
									$flight_cart->departureFlightCode,
									$flight_cart->departureFlightResBookDesigCode,
									$flight_cart->departureFlightAirEquipType,
									$flight_cart->departureFlightMarriageGrp,
									$flight_cart->arrivalDateFrom,
									$flight_cart->arrivalTimeFrom,
									$flight_cart->arrivalDateTo,
									$flight_cart->arrivalTimeTo,
									$flight_cart->arrivalCityCodeFrom,
									$flight_cart->arrivalCityCodeTo,
									$flight_cart->arrivalFlightCode,
									$flight_cart->arrivalFlightResBookDesigCode,
									$flight_cart->arrivalFlightAirEquipType,
									$flight_cart->arrivalFlightMarriageGrp,
									$flight_cart->noofAdult,
									$flight_cart->noofChild,
									$flight_cart->noofInfant,
									$this->input->post("emailCP"),
	    							$this->input->post("contactCP"),
	    							$this->input->post("nationalityCP"),
	    							$passengerDetails,
									$this->input->post('remarksCP')
								);

								if($returnRefID != '' && $returnRefID != 'error') {
									/* save the PNR */
									$flight_PNR = $returnRefID;
									/* we got PNR! save to flight_history_order in next session */
								}
								else {
									$this->session->set_flashdata('error_checkout',
												'<article class="full-width-2">
													<div style="text-align:center; color:red; padding:15px; font-size:16px">
														Flight Booking error. Please try again.
													</div>
												</article>');
									//echo 'E';
									redirect("checkout");
									exit;
								}
							}
						}
						else {
							/* single flight, just departure. yep */
							$sepFlightCode = explode(" ", $depFlightCode);
							$flightCode    = $sepFlightCode[0];
							$flightNo 	   = $sepFlightCode[1];
							$returnRefID = book_flight_SINGLE(
								$flight_cart->departureDateFrom,
								$flight_cart->departureTimeFrom,
								$flight_cart->departureCityCodeTo,
								$flightCode,
								$flightNo,
								$flight_cart->departureCityCodeFrom,
								$flight_cart->noofAdult,
								$flight_cart->noofChild,
								$flight_cart->noofInfant,
								'O',
								$flight_cart->flightClass,
								$passengerDetails,
								$this->input->post("emailCP"),
			    				$this->input->post("contactCP"),
								$this->input->post('remarksCP')
							);
						}

						if($returnRefID != '' && $returnRefID != 'error') {
							/* save the PNR */
							$flight_PNR = $returnRefID;
							/* we got PNR! save to flight_history_order in next session */
						}
						else {
							$this->session->set_flashdata('error_checkout',
										'<article class="full-width-2">
											<div style="text-align:center; color:red; padding:15px; font-size:16px">
												Flight Booking error. Please try again.
											</div>
										</article>');
							//echo 'A';
							redirect("checkout");
							exit;
						}
					}
					$data_fieldsHistory = array(
						"flight_confirmedBookOrder_ID" => $last_insertConfirmID,
						"bookingRefID" 				   => $bookingOrderID,
						"departureFlightName" 	   	   => $flight_cart->departureFlightName,
			            "departureFlightCode" 	   	   => $flight_cart->departureFlightCode,
			            "departureDateFrom" 	   	   => $flight_cart->departureDateFrom,
			            "departureDateTo" 		   	   => $flight_cart->departureDateTo,
			            "departureTimeFrom" 	  	   => $flight_cart->departureTimeFrom,
			            "departureTimeTo" 		   	   => $flight_cart->departureTimeTo,
			            "departureCityNameFrom"    	   => $flight_cart->departureCityNameFrom,
			            "departureCityNameTo" 	   	   => $flight_cart->departureCityNameTo,
			            "departureCityCodeFrom"    	   => $flight_cart->departureCityCodeFrom,
			            "departureCityCodeTo" 	   	   => $flight_cart->departureCityCodeTo,
			            "departureAirportNameFrom" 	   => $flight_cart->departureAirportNameFrom,
			            "departureAirportNameTo"   	   => $flight_cart->departureAirportNameTo,
			            "departureTimeTaken" 	   	   => $flight_cart->departureTimeTaken,
			            "departureBaggage" 		   	   => $flight_cart->departureBaggage,
			            "departureMeal" 		   	   => $flight_cart->departureMeal,
			            "departureTotalTransit"	   	   => $flight_cart->departureTotalTransit,
			            "departureTotalFlightTime" 	   => $flight_cart->departureTotalFlightTime,
			            "departureTotalPrice" 	   	   => $flight_cart->departureTotalPrice,
			            "departureFlightAirEquipType" => $flight_cart->departureFlightAirEquipType,

			            "departurePriceAdultTaxFare" => $flight_cart->departurePriceAdultTaxFare,
						"departurePriceAdultBaseFare" => $flight_cart->departurePriceAdultBaseFare,
						"departurePriceChildTaxFare" => $flight_cart->departurePriceChildTaxFare,
						"departurePriceChildBaseFare" => $flight_cart->departurePriceChildBaseFare,
						"departurePriceInfantTaxFare" => $flight_cart->departurePriceInfantTaxFare,
						"departurePriceInfantBaseFare" => $flight_cart->departurePriceInfantBaseFare,

						"departureTerminalID_from" => $flight_cart->departureTerminalID_from,
						"departureTimezone_from" => $flight_cart->departureTimezone_from,
						"departureTerminalID_to" => $flight_cart->departureTerminalID_to,
						"departureTimezone_to" => $flight_cart->departureTimezone_to,

			            "arrivalFlightName" 	   	   => $flight_cart->arrivalFlightName,
			            "arrivalFlightCode" 	   	   => $flight_cart->arrivalFlightCode,
			            "arrivalDateFrom" 		   	   => $flight_cart->arrivalDateFrom,
			            "arrivalDateTo" 		   	   => $flight_cart->arrivalDateTo,
			            "arrivalTimeFrom" 		   	   => $flight_cart->arrivalTimeFrom,
			            "arrivalTimeTo" 		   	   => $flight_cart->arrivalTimeTo,
			            "arrivalCityNameFrom" 	   	   => $flight_cart->arrivalCityNameFrom,
			            "arrivalCityNameTo" 	   	   => $flight_cart->arrivalCityNameTo,
			            "arrivalCityCodeFrom" 	   	   => $flight_cart->arrivalCityCodeFrom,
			            "arrivalCityCodeTo" 	   	   => $flight_cart->arrivalCityCodeTo,
			            "arrivalAirportNameFrom"   	   => $flight_cart->arrivalAirportNameFrom,
			            "arrivalAirportNameTo" 	   	   => $flight_cart->arrivalAirportNameTo,
			            "arrivalTimeTaken" 		   	   => $flight_cart->arrivalTimeTaken,
			            "arrivalBaggage" 		   	   => $flight_cart->arrivalBaggage,
			            "arrivalMeal" 			   	   => $flight_cart->arrivalMeal,
			            "arrivalTotalTransit" 	   	   => $flight_cart->arrivalTotalTransit,
			            "arrivalTotalFlightTime"   	   => $flight_cart->arrivalTotalFlightTime,
			            "arrivalTotalPrice" 	   	   => $flight_cart->arrivalTotalPrice,
			            "arrivalFlightAirEquipType" => $flight_cart->arrivalFlightAirEquipType,

			            "arrivalPriceAdultTaxFare" => $flight_cart->arrivalPriceAdultTaxFare,
						"arrivalPriceAdultBaseFare" => $flight_cart->arrivalPriceAdultBaseFare,
						"arrivalPriceChildTaxFare" => $flight_cart->arrivalPriceChildTaxFare,
						"arrivalPriceChildBaseFare" => $flight_cart->arrivalPriceChildBaseFare,
						"arrivalPriceInfantTaxFare" => $flight_cart->arrivalPriceInfantTaxFare,
						"arrivalPriceInfantBaseFare" => $flight_cart->arrivalPriceInfantBaseFare,

						"arrivalTerminalID_from" => $flight_cart->arrivalTerminalID_from,
						"arrivalTimezone_from" => $flight_cart->arrivalTimezone_from,
						"arrivalTerminalID_to" => $flight_cart->arrivalTerminalID_to,
						"arrivalTimezone_to" => $flight_cart->arrivalTimezone_to,

						"departureFareBasisCode" => $flight_cart->departureFareBasisCode,
						"arrivalFareBasisCode" => $flight_cart->arrivalFareBasisCode,

						"TotalPriceAdminFare" => $flight_cart->TotalPriceAdminFare,
						"departuremealcode" => $flight_cart->departuremealcode,
						"arrivalmealcode" => $flight_cart->arrivalmealcode,

			            "noofAdult" 			   	   => $flight_cart->noofAdult,
			            "noofChild" 			   	   => $flight_cart->noofChild,
			            "noofInfant" 			   	   => $flight_cart->noofInfant,
			            "flightClass" 			   	   => $flight_cart->flightClass,
			            "user_access_id"			   => $this->session->userdata('normal_session_id'),
			            "created" 				   	   => date("Y-m-d H:i:s"),
			            "modified" 				   	   => date("Y-m-d H:i:s"),
			            "flight_PNR"				   => $flight_PNR
					);
					$insertHistoryOrder  = $this->All->insert_template($data_fieldsHistory, "flight_history_order");
					$last_historyOrderID = $this->db->insert_id();
					$ha++;
				}
				$success_flight_checkout = TRUE;
			}
			/*--END OF INSERT FLIGHT PAX NAMES & HISTORY ORDER--*/

			/*--INSERT INTO LANDTOUR_HISTORY_ORDER--*/
			$landtourCarts = $this->All->select_template(
				"user_access_id", $this->session->userdata('normal_session_id'), "landtour_cart"
			);
			if ( $landtourCarts == TRUE ) {
				foreach( $landtourCarts AS $landtourCart ) {
					$data_fieldsHistory = array(
						"landtour_confirmedBookOrder_ID" => $last_insertConfirmID,
						"bookOrderID"					 => $bookingOrderID,
						"landtour_product_id" 			 => $landtourCart->landtour_product_id,
						"landtour_system_price_id"		 => $landtourCart->landtour_system_price_id,
						"selected_date" 				 => $landtourCart->selectedDate,
						"countRoom" 		         	 => $landtourCart->countRoom,
						"paxDetails" 			  	   	 => $landtourCart->paxDetails,
						"sellingType"					 => $landtourCart->sellingType,
						"user_access_id" 			  	 => $this->session->userdata('normal_session_id'),
						"special_request"			   	 => $this->input->post("member_remarksLandtour"),
						"status"				   		 => "CONFIRMED",
						"created" 					     => date("Y-m-d H:i:s"),
						"modified" 					   	 => date("Y-m-d H:i:s")
					);
					$insertHistoryOrder  = $this->All->insert_template($data_fieldsHistory, "landtour_history_order");
				}

				$success_landtour_checkout = true;
			}
			/*--END OF INSERT INTO LANDTOUR_HISTORY_ORDER--*/

			/*--INSERT INTO CRUISE_HISTORY_ORDER--*/
			$cruiseCarts = $this->All->select_template(
				"user_access_id", $this->session->userdata('normal_session_id'), "cruise_cart"
			);
			if ( $cruiseCarts == TRUE ) {
				foreach ( $cruiseCarts AS $cruiseCart ) {
					$data_fieldsHistory = array(
						"cruise_confirmedBookOrder_ID" => $last_insertConfirmID,
						"brandID" 			 		   => $cruiseCart->brandID,
						"shipID" 				  	   => $cruiseCart->shipID,
						"cruiseTitleID" 		       => $cruiseCart->cruiseTitleID,
						"durationNight" 		  	   => $cruiseCart->durationNight,
						"cruiseDate" 		  		   => $cruiseCart->cruiseDate,
						"stateroomID" 			  	   => $cruiseCart->stateroomID,
						"cruisePrice" 			  	   => $cruiseCart->cruisePrice,
						"cruisePriceType"			   => $cruiseCart->cruisePriceType,
						"extraPrice"				   => $cruiseCart->extraPrice,
						"extraIDs"				   	   => $cruiseCart->extraIDs,
						"extraPeriod"				   => $cruiseCart->extraPeriod,
						"noofAdult" 		  		   => $cruiseCart->noofAdult,
						"noofChild" 		  		   => $cruiseCart->noofChild,
						"user_access_id" 			   => $this->session->userdata('normal_session_id'),
						"created" 					   => date("Y-m-d H:i:s"),
						"modified" 					   => date("Y-m-d H:i:s")
					);
					$insertHistoryOrder  = $this->All->insert_template($data_fieldsHistory, "cruise_historyOrder");
					$last_historyOrderID = $this->db->insert_id();
				}
				$success_cruise_checkout = true;
			}
			/*--END OF INSERT INTO CRUISE_HISTORY_ORDER--*/

			/*--INSERT INTO CONTACT PERSON INFORMATION--*/
			if ($success_cruise_checkout || $success_landtour_checkout || $success_hotel_checkout || $success_flight_checkout) {
				$data_fieldsContactPerson = array(
					"bookOrderID" 		   	  => $bookingOrderID,
					"cp_title" 	   			  => $this->input->post("titleCP"),
					/*"cp_dob"    			  => $this->input->post('dob_cp'),*/
					"cp_fullname" 	   		  => $this->input->post("nameCP"),
					/*"cp_givenname" 	=> $this->input->post("givennameCP"),
					"cp_surname" => $this->input->post("surnameCP"),*/

					/*"cp_nric" 		   		  => $this->input->post("nricCP"),*/
					/*"cp_nationality" 		  => $this->input->post("nationalityCP"),*/
					"cp_email"				  => $this->input->post("emailCP"),
					/*"cp_passport_issue_date"  => $issCP,
					"cp_passport_expire_date" => $expCP,
					"cp_passport_no" 	   	  => $this->input->post("passport_noCP"),
					*/
					"cp_contact_no"  		  => $this->input->post("contactCP"),
					/*"cp_address"   			  => $this->input->post("addressCP"),*/
					"cp_remarks"  			  => $this->input->post("remarksCP"),
					"created" 			   	  => date("Y-m-d H:i:s"),
					"modified" 			   	  => date("Y-m-d H:i:s")
				);
				$insertContactPerson = $this->All->insert_template($data_fieldsContactPerson, "contact_person_information");
				/* emergency contact person */
				$data_fieldsEContactPerson = array(
					"bookOrderID" 		   	  => $bookingOrderID,
					"cp_title" 	   			  => $this->input->post("e_titleCP"),
					/*"cp_dob"    			  => $this->input->post('e_dob_cp'),*/
					"cp_fullname" 	   		  => $this->input->post("e_nameCP"),
					/*"cp_givenname" 	=> $this->input->post("e_givennameCP"),
					"cp_surname" => $this->input->post("e_surnameCP"),*/

					/*"cp_nric" 		   		  => $this->input->post("nricCP"),*/
					/*"cp_nationality" 		  => $this->input->post("e_nationalityCP"),*/
					"cp_email"				  => $this->input->post("e_emailCP"),
					/*"cp_passport_issue_date"  => $issCP,
					"cp_passport_expire_date" => $expCP,
					"cp_passport_no" 	   	  => $this->input->post("passport_noCP"),
					*/
					"cp_contact_no"  		  => $this->input->post("e_contactCP"),
					/*"cp_address"   			  => $this->input->post("addressCP"),*/
					/*"cp_remarks"  			  => $this->input->post("remarksCP"),*/
					'category' => $this->input->post('emergency_relationship'),
					"created" 			   	  => date("Y-m-d H:i:s"),
					"modified" 			   	  => date("Y-m-d H:i:s")
				);
				$insertEContactPerson = $this->All->insert_template($data_fieldsEContactPerson, "contact_person_information");

				/*--END OF INSERT INTO CONTACT PERSON INFORMATION--*/

				//for live
				$ref = uniqid();
				$signature = hash('sha512',$totalGranPrice.$bookingOrderID."SGD107201335038LrYIiO7krQ");

				//session and redirect
				/*--LIVE--*/
				redirect("https://securepayments.telemoneyworld.com/easypay2/paymentpage.do?mid=107201335038&ref=".$bookingOrderID."&amt=".$totalGranPrice."&cur=SGD&rcard=64&returnurl=".base_url()."payment/success_booked/".base64_encode(base64_encode(base64_encode($bookingOrderID)))."&statusurl=".base_url()."payment/statusURLindex123/".$bookingOrderID."&transtype=sale&validity=".date("Y-m-d-H:i:s", mktime(date("H")+8,date("i")+15,date("s"),date("m"),date("d"),date("Y")))."&version=2&signature=".$signature."");
				/*--END OF LIVE--*/

				/*--TESTING--*/
				//redirect("https://test.wirecard.com.sg/easypay2/paymentpage.do?mid=20131113001&ref=".$bookingOrderID."&amt=".$totalGranPrice."&cur=SGD&rcard=64&returnurl=".base_url()."payment/success_booked/".base64_encode(base64_encode(base64_encode($bookingOrderID)))."&statusurl=".base_url()."payment/statusURLindex123/".$bookingOrderID."&paytype=3&transtype=auth&ccnum=4111111111111111&ccdate=1711&cccvv=898&validity=2018-11-01-11:22:33");
				/*--END OF TESTING--*/
				//end of session and redirect
			} else {
				$this->session->set_flashdata('error_checkout', 'Your session expired. Please try adding your order again');
				redirect('cart/index');
			}
		}
		else {
			/*--INITIATE CRUISE SESSION ARRAY--*/
			if ( $this->session->userdata('shoppingCartCruiseCookie') == TRUE ) {
				$arrayCruise 	  = $this->session->userdata('shoppingCartCruiseCookie');
				$arrayCruiseCount = count($arrayCruise);
			}
			/*--END OF INITIATE CRUISE SESSION ARRAY--*/
			/*--INITIATE LANDTOUR SESSION ARRAY--*/
			if ( $this->session->userdata('shoppingCartLandtourCookie') == TRUE ) {
				$arrayLandtour 	    = $this->session->userdata('shoppingCartLandtourCookie');
				$arrayLandtourCount = count($arrayLandtour);
			}
			/*--END OF INITIATE LANDTOUR SESSION ARRAY--*/

			/*--INITIATE HOTEL SESSION ARRAY--*/
			if ( $this->session->userdata('shoppingCartCookie') == TRUE ) {
				$arrayHotel 	 = $this->session->userdata('shoppingCartCookie');
				$arrayHotelCount = count($arrayHotel);
			}

			/*--END OF INITIATE HOTEL SESSION ARRAY--*/

			/*--INITIATE FLIGHT SESSION ARRAY--*/
			if( $this->session->userdata('shoppingCartFlightCookie') == TRUE ) {
				$arrayFlight 	  = $this->session->userdata('shoppingCartFlightCookie');
				$arrayFlightCount = count($arrayFlight);
			}
			/*--END OF INITIATE FLIGHT SESSION ARRAY--*/

			/*--HIDDEN PARAM & PHP BUILT-IN FUNCTION--*/
			$totalGranPrice   = trim($this->input->post("hidden_grandTotalPrice"));
			$bookingOrderID   = uniqid();
			/*--END OF HIDDEN PARAM & PHP BUILT-IN FUNCTION--*/

			/*--CONTACT PERSON INFORMATION - POST METHOD--*/
			$titleCP 	   = $this->input->post("titleCP");

			$dobCP = $this->input->post("dob_cp");
			$nameCP = $this->input->post('nameCP');
			$nationalityCP = $this->input->post("nationalityCP");
			$emailCP 	   = $this->input->post("emailCP");
			$contactCP 	   = $this->input->post("contactCP");
			$remarksCP	   = $this->input->post("remarksCP");
			$checkUsers = $this->All->select_template("email_address", $emailCP, "user_access");

			if ( $checkUsers == TRUE ) {
				foreach ( $checkUsers AS $checkUser ) {
					$user_access_id = $checkUser->id;
				}
				$data_fields = array(
					"title"				=> $titleCP,
					"admin_full_name" 	=> $nameCP,
					"admin_contact" 	=> $contactCP,
					"email_address" 	=> $emailCP,
					"dob"				=> $dobCP,
					"nationality"		=> $nationalityCP,
					"modified" 			=> date("Y-m-d H:i:s")
				);
				$insertUserAccess = $this->All->update_template($data_fields, "id", $user_access_id, "user_access");
				$userAccessID = $user_access_id;
			}
			else {
				$data_fieldsUser = array(
					"title"				=> $titleCP,
					'admin_full_name' => $nameCP,
					"admin_contact" 	=> $contactCP,
					"email_address" 	=> strtolower($emailCP),
					"password" 			=> sha1(SHA1_VAR.strtolower($emailCP)),
					"dob"				=> $dobCP,
					"is_block" 			=> 0,
					"is_login_facebook" => 0,
					"is_login_twitter" 	=> 0,
					"is_login_gplus" 	=> 0,
					"access_role" 		=> "NORMAL",
					"is_fp_request" 	=> 0,
					"is_signup_request" => 0,
					"created" 			=> date("Y-m-d H:i:s"),
					"modified" 			=> date("Y-m-d H:i:s")
				);
				$insertUserAccess 		 = $this->All->insert_template($data_fieldsUser, "user_access");
				$lastinsert_userAccessID = $this->db->insert_id();
				$userAccessID = $lastinsert_userAccessID;
			}
			/*--END OF CONTACT PERSON INFORMATION - POST METHOD--*/

			/*--GENERAL LOGIC--*/
			$data_fields = array(
				"granTotalPrice" => $totalGranPrice,
				"BookingOrderID" => $bookingOrderID,
				"status" 		 => "CONFIRMED",
				"user_access_id" => $userAccessID,
				"created" 		 => date("Y-m-d H:i:s"),
				"modified" 		 => date("Y-m-d H:i:s")
			);
			$insertConfirm 		  = $this->All->insert_template($data_fields, "confirmedBookOrder");
			$last_insertConfirmID = $this->db->insert_id();
			/*--END OF GENERAL LOGIC--*/

			/*--INSERT CRUISE PAX NAMES--*/
			if ( $this->session->userdata('shoppingCartCruiseCookie') == TRUE ) {
				if ( count($this->input->post("C_paxFullnameAdult")) > 0 && is_array($this->input->post("C_paxFullnameAdult")) ) {
					foreach ( $this->input->post("C_paxFullnameAdult") AS $keyAdult => $valAdult ) {
						$explodeAdult = explode("00000", $keyAdult);
						$L_title   		= $this->input->post("C_paxTitleAdult");
						$L_dobYear 		= $this->input->post("C_paxDobyearAdult");
						$L_dobMonth 	= $this->input->post("C_paxDobmonthAdult");
						$L_dobDay   	= $this->input->post("C_paxDobdayAdult");
						$L_fullname 	= $this->input->post("C_paxFullnameAdult");
						$L_nric 		= $this->input->post("C_paxNricAdult");
						$L_nationality 	= $this->input->post("C_paxNationalityAdult");
						$L_passortNo 	= $this->input->post("C_paxPassportnoAdult");
						$L_issueYear 	= $this->input->post("C_paxIssueyearAdult");
						$L_issueMonth 	= $this->input->post("C_paxIssuemonthAdult");
						$L_issueDay 	= $this->input->post("C_paxIssuedayAdult");
						$L_expireYear 	= $this->input->post("C_paxExpireyearAdult");
						$L_expireMonth 	= $this->input->post("C_paxExpiremonthAdult");
						$L_expireDay 	= $this->input->post("C_paxExpiredayAdult");
						foreach( $valAdult AS $keyA => $valA ) {
							$L_dobFull    = $L_dobYear[$keyAdult][$keyA]."-".$L_dobMonth[$keyAdult][$keyA]."-".$L_dobDay[$keyAdult][$keyA];
							$L_issueFull  = $L_issueYear[$keyAdult][$keyA]."-".$L_issueMonth[$keyAdult][$keyA]."-".$L_issueDay[$keyAdult][$keyA];
							$L_expireFull = $L_expireYear[$keyAdult][$keyA]."-".$L_expireMonth[$keyAdult][$keyA]."-".$L_expireDay[$keyAdult][$keyA];
							$data_fieldsPaxAdult = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "ADULT",
								"cruise_title_id" 			=> $explodeAdult[1],
								"itemRecordRef" 			=> $explodeAdult[0],
								"pax_title"  				=> $L_title[$keyAdult][$keyA],
								"pax_dob"  					=> $L_dobFull,
								"pax_fullname"  			=> $L_fullname[$keyAdult][$keyA],
								"pax_nric"  				=> $L_nric[$keyAdult][$keyA],
								"pax_nationality"  			=> $L_nationality[$keyAdult][$keyA],
								"pax_passport_no"  			=> $L_passortNo[$keyAdult][$keyA],
								"pax_passport_issue_date"  	=> $L_issueFull,
								"pax_passport_expire_date" 	=> $L_expireFull,
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameAdult = $this->All->insert_template($data_fieldsPaxAdult, "cruise_paxName");
						}
					}
				}
				if( count($this->input->post("C_paxFullnameChild")) > 0 && is_array($this->input->post("C_paxFullnameChild")) ) {
					foreach( $this->input->post("C_paxFullnameChild") AS $keyChild => $valChild ) {
						$explodeChild = explode("00000", $keyChild);
						$L_title   		= $this->input->post("C_paxTitleChild");
						$L_dobYear 		= $this->input->post("C_paxDobyearChild");
						$L_dobMonth 	= $this->input->post("C_paxDobmonthChild");
						$L_dobDay   	= $this->input->post("C_paxDobdayChild");
						$L_fullname 	= $this->input->post("C_paxFullnameChild");
						$L_nric 		= $this->input->post("C_paxNricChild");
						$L_nationality 	= $this->input->post("C_paxNationalityChild");
						$L_passortNo 	= $this->input->post("C_paxPassportnoChild");
						$L_issueYear 	= $this->input->post("C_paxIssueyearChild");
						$L_issueMonth 	= $this->input->post("C_paxIssuemonthChild");
						$L_issueDay 	= $this->input->post("C_paxIssuedayChild");
						$L_expireYear 	= $this->input->post("C_paxExpireyearChild");
						$L_expireMonth 	= $this->input->post("C_paxExpiremonthChild");
						$L_expireDay 	= $this->input->post("C_paxExpiredayChild");
						foreach( $valChild AS $keyC => $valC ) {
							$L_dobFull    = $L_dobYear[$keyChild][$keyC]."-".$L_dobMonth[$keyChild][$keyC]."-".$L_dobDay[$keyChild][$keyC];
							$L_issueFull  = $L_issueYear[$keyChild][$keyC]."-".$L_issueMonth[$keyChild][$keyC]."-".$L_issueDay[$keyChild][$keyC];
							$L_expireFull = $L_expireYear[$keyChild][$keyC]."-".$L_expireMonth[$keyChild][$keyC]."-".$L_expireDay[$keyChild][$keyC];
							$data_fieldsPaxChild = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "CHILD",
								"cruise_title_id" 			=> $explodeChild[1],
								"itemRecordRef" 			=> $explodeChild[0],
								"pax_title"  				=> $L_title[$keyChild][$keyC],
								"pax_dob"  					=> $L_dobFull,
								"pax_fullname"  			=> $L_fullname[$keyChild][$keyC],
								"pax_nric"  				=> $L_nric[$keyChild][$keyC],
								"pax_nationality"  			=> $L_nationality[$keyChild][$keyC],
								"pax_passport_no"  			=> $L_passortNo[$keyChild][$keyC],
								"pax_passport_issue_date"  	=> $L_issueFull,
								"pax_passport_expire_date" 	=> $L_expireFull,
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameChild = $this->All->insert_template($data_fieldsPaxChild, "cruise_paxName");
						}
					}
				}
			}
			/*--END OF INSERT CRUISE PAX NAMES--*/

			/*--INSERT LANDTOUR PAX NAMES--*/
			if( $this->session->userdata('shoppingCartLandtourCookie') == TRUE ) {
				/* done */
				if( count($this->input->post("LT_givennameAdult")) > 0 && is_array($this->input->post("LT_givennameAdult")) ) {
					$pax_title = $this->input->post('LT_titleAdult');
					$pax_givenname = $this->input->post("LT_givennameAdult");
					$pax_surname = $this->input->post("LT_surnameAdult");
					$pax_passport_no = $this->input->post('LT_passport_noAdult');
					$pax_dob_year = $this->input->post('LT_dob_yearAdult');
					$pax_dob_month = $this->input->post('LT_dob_monthAdult');
					$pax_dob_day =  $this->input->post('LT_dob_dayAdult');
					$pax_nationalityAdult 			= $this->input->post("LT_nationalityAdult");
					$pax_passportIssueCountryAdult 	= $this->input->post("LT_passportIssueCountryAdult");
					$pax_passport_expiryYearAdult  	= $this->input->post("LT_passport_expiryYearAdult");
					$pax_passport_expiryMonthAdult 	= $this->input->post("LT_passport_expiryMonthAdult");
					$pax_passport_expiryDateAdult  	= $this->input->post("LT_passport_expiryDateAdult");
					$pax_passport_issueYearAdult   	= $this->input->post("LT_passport_issueYearAdult");
					$pax_passport_issueMonthAdult  	= $this->input->post("LT_passport_issueMonthAdult");
					$pax_passport_issueDayAdult    	= $this->input->post("LT_passport_issueDayAdult");
					$pax_remarksAdult = $this->input->post('LT_passengerRemarks_Adult');

					foreach( $this->input->post("LT_givennameAdult") AS $keyAdult => $valAdult ) {
						$explodeAdult = explode("00000", $keyAdult);

						foreach( $valAdult AS $keyA => $valA ) {
							$paxName = $valA ." ". $pax_surname[$keyAdult][$keyA];
							$dobAdult = $pax_dob_year[$keyAdult][$keyA].'-'.$pax_dob_month[$keyAdult][$keyA].'-'.$pax_dob_day[$keyAdult][$keyA];
							$expiredAdult = $pax_passport_expiryYearAdult[$keyAdult][$keyA].'-'.$pax_passport_expiryMonthAdult[$keyAdult][$keyA].'-'.$pax_passport_expiryDateAdult[$keyAdult][$keyA];
							$issuedAdult  = $pax_passport_issueYearAdult[$keyAdult][$keyA].'-'.$pax_passport_issueMonthAdult[$keyAdult][$keyA].'-'.$pax_passport_issueDayAdult[$keyAdult][$keyA];

							$data_fieldsPaxAdult = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "ADULT",
								"landtour_product_id" 		=> $explodeAdult[2],
								"landtour_history_order_id" => "",
								"roomIndex"					=> $explodeAdult[1],
								"itemRecordRef" 			=> $explodeAdult[0],
								"pax_name"  				=> $paxName,
								"paxTitle" 	 		=> $pax_title[$keyAdult][$keyA],
								"pax_givenname"		=> $valA,
								"pax_surname"		=> $pax_surname[$keyAdult][$keyA],
								"paxPassportNo" 		=> $pax_passport_no[$keyAdult][$keyA],
								"paxDOB" 		 		=> $dobAdult,
								"paxNationality" 		 => $pax_nationalityAdult[$keyAdult][$keyA],
								"paxPassportIssueCountry" => $pax_passportIssueCountryAdult[$keyAdult][$keyA],
								"paxPassportExpiryDate" 	=> $expiredAdult,
								"paxPassportIssueDate" 	=> $issuedAdult,
								"paxremarks" => $pax_remarksAdult[$keyAdult][$keyA],

								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);

							$insertPaxNameAdult = $this->All->insert_template($data_fieldsPaxAdult, "landtour_paxname");
						}
					}


				}

				/* done */
				if( count($this->input->post("LT_givennameChildWB")) > 0 && is_array($this->input->post("LT_givennameChildWB")) ) {
					$pax_title = $this->input->post('LT_titleChildWB');
					$pax_givenname = $this->input->post("LT_givennameChildWB");
					$pax_surname = $this->input->post("LT_surnameChildWB");
					$pax_passport_no = $this->input->post('LT_passport_noChildWB');
					$pax_dob_year = $this->input->post('LT_dob_yearChildWB');
					$pax_dob_month = $this->input->post('LT_dob_monthChildWB');
					$pax_dob_day =  $this->input->post('LT_dob_dayChildWB');
					$pax_nationality 			= $this->input->post("LT_nationalityChildWB");
					$pax_passportIssueCountry 	= $this->input->post("LT_passportIssueCountryChildWB");
					$pax_passport_expiryYear  	= $this->input->post("LT_passport_expiryYearChildWB");
					$pax_passport_expiryMonth 	= $this->input->post("LT_passport_expiryMonthChildWB");
					$pax_passport_expiryDate  	= $this->input->post("LT_passport_expiryDateChildWB");
					$pax_passport_issueYear   	= $this->input->post("LT_passport_issueYearChildWB");
					$pax_passport_issueMonth  	= $this->input->post("LT_passport_issueMonthChildWB");
					$pax_passport_issueDay    	= $this->input->post("LT_passport_issueDayChildWB");
					$pax_remarks = $this->input->post('LT_passengerRemarks_ChildWB');
					foreach( $this->input->post("LT_givennameChildWB") AS $keyChildWB => $valChildWB ) {
						$explodeChildWB = explode("00000", $keyChildWB);
						foreach( $valChildWB AS $keyB => $valB ) {
							$paxName = $valB ." ". $pax_surname[$keyChildWB][$keyB];
							$dobPax = $pax_dob_year[$keyChildWB][$keyB].'-'.$pax_dob_month[$keyChildWB][$keyB].'-'.$pax_dob_day[$keyChildWB][$keyB];
							$expiredPassport = $pax_passport_expiryYear[$keyChildWB][$keyB].'-'.$pax_passport_expiryMonth[$keyChildWB][$keyB].'-'.$pax_passport_expiryDate[$keyChildWB][$keyB];
							$issuedPassport  = $pax_passport_issueYear[$keyChildWB][$keyB].'-'.$pax_passport_issueMonth[$keyChildWB][$keyB].'-'.$pax_passport_issueDay[$keyChildWB][$keyB];

							$data_fieldsPaxChildWB = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "CHILD_WITH_BED",
								"landtour_product_id" 		=> $explodeChildWB[2],
								"landtour_history_order_id" => "",
								"roomIndex"					=> $explodeChildWB[1],
								"itemRecordRef" 			=> $explodeChildWB[0],
								"pax_name"  				=> $paxName,
								"paxTitle" 	 		=> $pax_title[$keyChildWB][$keyB],
								"pax_givenname"		=> $valB,
								"pax_surname"		=> $pax_surname[$keyChildWB][$keyB],
								"paxPassportNo" 		=> $pax_passport_no[$keyChildWB][$keyB],
								"paxDOB" 		 		=> $dobPax,
								"paxNationality" 		 => $pax_nationality[$keyChildWB][$keyB],
								"paxPassportIssueCountry" => $pax_passportIssueCountry[$keyChildWB][$keyB],
								"paxPassportExpiryDate" 	=> $expiredPassport,
								"paxPassportIssueDate" 	=> $issuedPassport,
								"paxremarks" => $pax_remarks[$keyChildWB][$keyB],

								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameChildWB = $this->All->insert_template($data_fieldsPaxChildWB, "landtour_paxname");
						}
					}
				}

				/* done */
				if( count($this->input->post("LT_givennameChildWOB")) > 0 && is_array($this->input->post("LT_givennameChildWOB")) ) {

					$pax_title = $this->input->post('LT_titleChildWOB');
					$pax_givenname = $this->input->post("LT_givennameChildWOB");
					$pax_surname = $this->input->post("LT_surnameChildWOB");
					$pax_passport_no = $this->input->post('LT_passport_noChildWOB');
					$pax_dob_year = $this->input->post('LT_dob_yearChildWOB');
					$pax_dob_month = $this->input->post('LT_dob_monthChildWOB');
					$pax_dob_day =  $this->input->post('LT_dob_dayChildWOB');
					$pax_nationality 			= $this->input->post("LT_nationalityChildWOB");
					$pax_passportIssueCountry 	= $this->input->post("LT_passportIssueCountryChildWOB");
					$pax_passport_expiryYear  	= $this->input->post("LT_passport_expiryYearChildWOB");
					$pax_passport_expiryMonth 	= $this->input->post("LT_passport_expiryMonthChildWOB");
					$pax_passport_expiryDate  	= $this->input->post("LT_passport_expiryDateChildWOB");
					$pax_passport_issueYear   	= $this->input->post("LT_passport_issueYearChildWOB");
					$pax_passport_issueMonth  	= $this->input->post("LT_passport_issueMonthChildWOB");
					$pax_passport_issueDay    	= $this->input->post("LT_passport_issueDayChildWOB");
					$pax_remarks = $this->input->post('LT_passengerRemarks_ChildWOB');

					foreach( $this->input->post("LT_givennameChildWOB") AS $keyChildWOB => $valChildWOB ) {
						$explodeChildWOB = explode("00000", $keyChildWOB);
						foreach( $valChildWOB AS $keyC => $valC ) {
							$paxName = $valC ." ". $pax_surname[$keyChildWOB][$keyC];
							$dobPax = $pax_dob_year[$keyChildWOB][$keyC].'-'.$pax_dob_month[$keyChildWOB][$keyC].'-'.$pax_dob_day[$keyChildWOB][$keyC];
							$expiredPassport = $pax_passport_expiryYear[$keyChildWOB][$keyC].'-'.$pax_passport_expiryMonth[$keyChildWOB][$keyC].'-'.$pax_passport_expiryDate[$keyChildWOB][$keyC];
							$issuedPassport  = $pax_passport_issueYear[$keyChildWOB][$keyC].'-'.$pax_passport_issueMonth[$keyChildWOB][$keyC].'-'.$pax_passport_issueDay[$keyChildWOB][$keyC];

							$data_fieldsPaxChildWOB = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "CHILD_WITHOUT_BED",
								"landtour_product_id" 		=> $explodeChildWOB[2],
								"landtour_history_order_id" => "",
								"roomIndex"					=> $explodeChildWOB[1],
								"itemRecordRef" 			=> $explodeChildWOB[0],
								"pax_name"  				=> $paxName,
								"paxTitle" 	 		=> $pax_title[$keyChildWOB][$keyC],
								"pax_givenname"		=> $valC,
								"pax_surname"		=> $pax_surname[$keyChildWOB][$keyC],
								"paxPassportNo" 		=> $pax_passport_no[$keyChildWOB][$keyC],
								"paxDOB" 		 		=> $dobPax,
								"paxNationality" 		 => $pax_nationality[$keyChildWOB][$keyC],
								"paxPassportIssueCountry" => $pax_passportIssueCountry[$keyChildWOB][$keyC],
								"paxPassportExpiryDate" 	=> $expiredPassport,
								"paxPassportIssueDate" 	=> $issuedPassport,
								"paxremarks" => $pax_remarks[$keyChildWOB][$keyC],
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameChildWOB = $this->All->insert_template($data_fieldsPaxChildWOB, "landtour_paxname");
						}
					}
				}
				/* done */
				if( count($this->input->post("LT_givennameChildHALF")) > 0 && is_array($this->input->post("LT_givennameChildHALF")) ) {
					$pax_title = $this->input->post('LT_titleChildHALF');
					$pax_givenname = $this->input->post("LT_givennameChildHALF");
					$pax_surname = $this->input->post("LT_surnameChildHALF");
					$pax_passport_no = $this->input->post('LT_passport_noChildHALF');
					$pax_dob_year = $this->input->post('LT_dob_yearChildHALF');
					$pax_dob_month = $this->input->post('LT_dob_monthChildHALF');
					$pax_dob_day =  $this->input->post('LT_dob_dayChildHALF');
					$pax_nationality = $this->input->post("LT_nationalityChildHALF");
					$pax_passportIssueCountry = $this->input->post("LT_passportIssueCountryChildHALF");
					$pax_passport_expiryYear = $this->input->post("LT_passport_expiryYearChildHALF");
					$pax_passport_expiryMonth = $this->input->post("LT_passport_expiryMonthChildHALF");
					$pax_passport_expiryDate = $this->input->post("LT_passport_expiryDateChildHALF");
					$pax_passport_issueYear = $this->input->post("LT_passport_issueYearChildHALF");
					$pax_passport_issueMonth = $this->input->post("LT_passport_issueMonthChildHALF");
					$pax_passport_issueDay = $this->input->post("LT_passport_issueDayChildHALF");
					$pax_remarks = $this->input->post('LT_passengerRemarks_ChildHALF');

					foreach( $this->input->post("LT_givennameChildHALF") AS $keyChildHALF => $valChildHALF ) {
						$explodeChildHALF = explode("00000", $keyChildHALF);
						foreach( $valChildHALF AS $keyH => $valH ) {

							$paxName = $valH ." ". $pax_surname[$keyChildHALF][$keyH];
							$dobPax = $pax_dob_year[$keyChildHALF][$keyH].'-'.$pax_dob_month[$keyChildHALF][$keyH].'-'.$pax_dob_day[$keyChildHALF][$keyH];
							$expiredPassport = $pax_passport_expiryYear[$keyChildHALF][$keyH].'-'.$pax_passport_expiryMonth[$keyChildHALF][$keyH].'-'.$pax_passport_expiryDate[$keyChildHALF][$keyH];
							$issuedPassport  = $pax_passport_issueYear[$keyChildHALF][$keyH].'-'.$pax_passport_issueMonth[$keyChildHALF][$keyH].'-'.$pax_passport_issueDay[$keyChildHALF][$keyH];

							$data_fieldsPaxChildHALF = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "CHILD_HALF_TWIN",
								"landtour_product_id" 		=> $explodeChildHALF[2],
								"landtour_history_order_id" => "",
								"roomIndex"					=> $explodeChildHALF[1],
								"itemRecordRef" 			=> $explodeChildHALF[0],
								"pax_name"  				=> $paxName,
								"paxTitle" 	 		=> $pax_title[$keyChildHALF][$keyH],
								"pax_givenname"		=> $valH,
								"pax_surname"		=> $pax_surname[$keyChildHALF][$keyH],
								"paxPassportNo" 		=> $pax_passport_no[$keyChildHALF][$keyH],
								"paxDOB" 		 		=> $dobPax,
								"paxNationality" 		 => $pax_nationality[$keyChildHALF][$keyH],
								"paxPassportIssueCountry" => $pax_passportIssueCountry[$keyChildHALF][$keyH],
								"paxPassportExpiryDate" 	=> $expiredPassport,
								"paxPassportIssueDate" 	=> $issuedPassport,
								"paxremarks" => $pax_remarks[$keyChildHALF][$keyH],
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameChildHALF = $this->All->insert_template($data_fieldsPaxChildHALF, "landtour_paxname");
						}
					}
				}

				/* done */
				if( count($this->input->post("LT_givennameInfant")) > 0 && is_array($this->input->post("LT_givennameInfant")) ) {
					$pax_title = $this->input->post('LT_titleInfant');
					$pax_givenname = $this->input->post("LT_givennameInfant");
					$pax_surname = $this->input->post("LT_surnameInfant");
					$pax_passport_no = $this->input->post('LT_passport_Infant');
					$pax_dob_year = $this->input->post('LT_dob_yearInfant');
					$pax_dob_month = $this->input->post('LT_dob_monthInfant');
					$pax_dob_day =  $this->input->post('LT_dob_dayInfant');
					$pax_nationality 			= $this->input->post("LT_nationalityInfant");
					$pax_passportIssueCountry 	= $this->input->post("LT_passportIssueCountryInfant");
					$pax_passport_expiryYear  	= $this->input->post("LT_passport_expiryYearInfant");
					$pax_passport_expiryMonth 	= $this->input->post("LT_passport_expiryMonthInfant");
					$pax_passport_expiryDate  	= $this->input->post("LT_passport_expiryDateInfant");
					$pax_passport_issueYear   	= $this->input->post("LT_passport_issueYearInfant");
					$pax_passport_issueMonth  	= $this->input->post("LT_passport_issueMonthInfant");
					$pax_passport_issueDay    	= $this->input->post("LT_passport_issueDayInfant");
					$pax_remarks = $this->input->post('LT_passengerRemarks_Infant');

					foreach( $this->input->post("LT_givennameInfant") AS $keyInfant => $valInfant ) {
						$explodeInfant = explode("00000", $keyInfant);
						foreach( $valInfant AS $keyIN => $valIN ) {
							$paxName = $valIN ." ". $pax_surname[$keyInfant][$keyIN];
							$dobPax = $pax_dob_year[$keyInfant][$keyIN].'-'.$pax_dob_month[$keyInfant][$keyIN].'-'.$pax_dob_day[$keyInfant][$keyIN];
							$expiredPassport = $pax_passport_expiryYear[$keyInfant][$keyIN].'-'.$pax_passport_expiryMonth[$keyInfant][$keyIN].'-'.$pax_passport_expiryDate[$keyInfant][$keyIN];
							$issuedPassport  = $pax_passport_issueYear[$keyInfant][$keyIN].'-'.$pax_passport_issueMonth[$keyInfant][$keyIN].'-'.$pax_passport_issueDay[$keyInfant][$keyIN];

							$data_fieldsPaxInfant = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "INFANT",
								"landtour_product_id" 		=> $explodeInfant[2],
								"landtour_history_order_id" => "",
								"roomIndex"					=> $explodeInfant[1],
								"itemRecordRef" 			=> $explodeInfant[0],
								"pax_name"  				=> $paxName,
								"paxTitle" 	 		=> $pax_title[$keyInfant][$keyIN],
								"pax_givenname"		=> $valIN,
								"pax_surname"		=> $pax_surname[$keyInfant][$keyIN],
								"paxPassportNo" 		=> $pax_passport_no[$keyInfant][$keyIN],
								"paxDOB" 		 		=> $dobPax,
								"paxNationality" 		 => $pax_nationality[$keyInfant][$keyIN],
								"paxPassportIssueCountry" => $pax_passportIssueCountry[$keyInfant][$keyIN],
								"paxPassportExpiryDate" 	=> $expiredPassport,
								"paxPassportIssueDate" 	=> $issuedPassport,
								"paxremarks" => $pax_remarks[$keyInfant][$keyIN],
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameInfant = $this->All->insert_template($data_fieldsPaxInfant, "landtour_paxname");
						}
					}
				}
				/* done */
				if( count($this->input->post("LT_TicketgivennameAdult")) > 0 && is_array($this->input->post("LT_TicketgivennameAdult")) ) {
					$pax_title = $this->input->post('LT_TicketTitleAdult');
					$pax_givenname = $this->input->post("LT_TicketgivennameAdult");
					$pax_surname = $this->input->post("LT_TicketsurnameAdult");
					$pax_passport_no = $this->input->post('LT_Ticketpassport_noAdult');
					$pax_dob_year = $this->input->post('LT_Ticket_dob_yearAdult');
					$pax_dob_month = $this->input->post('LT_Ticket_dob_monthAdult');
					$pax_dob_day =  $this->input->post('LT_Ticket_dob_dayAdult');
					$pax_nationalityAdult 			= $this->input->post("LT_Ticket_nationalityAdult");
					$pax_passportIssueCountryAdult 	= $this->input->post("LT_Ticket_passportIssueCountryAdult");
					$pax_passport_expiryYearAdult  	= $this->input->post("LT_Ticket_passport_expiryYearAdult");
					$pax_passport_expiryMonthAdult 	= $this->input->post("LT_Ticket_passport_expiryMonthAdult");
					$pax_passport_expiryDateAdult  	= $this->input->post("LT_Ticket_passport_expiryDateAdult");
					$pax_passport_issueYearAdult   	= $this->input->post("LT_Ticket_passport_issueYearAdult");
					$pax_passport_issueMonthAdult  	= $this->input->post("LT_Ticket_passport_issueMonthAdult");
					$pax_passport_issueDayAdult    	= $this->input->post("LT_Ticket_passport_issueDayAdult");
					$pax_remarksAdult = $this->input->post('LT_Ticket_passengerRemarks_Adult');

					foreach( $this->input->post("LT_TicketgivennameAdult") AS $keyTicketAdult => $valTicketAdult ) {
						$explodeTicketAdult = explode("00000", $keyTicketAdult);
						foreach( $valTicketAdult AS $keyTA => $valTA ) {

							$paxName = $valTA ." ". $pax_surname[$keyTicketAdult][$keyTA];
							$dobAdult = $pax_dob_year[$keyTicketAdult][$keyTA].'-'.$pax_dob_month[$keyTicketAdult][$keyTA].'-'.$pax_dob_day[$keyTicketAdult][$keyTA];
							$expiredAdult = $pax_passport_expiryYearAdult[$keyTicketAdult][$keyTA].'-'.$pax_passport_expiryMonthAdult[$keyTicketAdult][$keyTA].'-'.$pax_passport_expiryDateAdult[$keyTicketAdult][$keyTA];
							$issuedAdult  = $pax_passport_issueYearAdult[$keyTicketAdult][$keyTA].'-'.$pax_passport_issueMonthAdult[$keyTicketAdult][$keyTA].'-'.$pax_passport_issueDayAdult[$keyTicketAdult][$keyTA];

							$data_fieldsPaxTA = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "ADULT",
								"landtour_product_id" 		=> $explodeTicketAdult[1],
								"landtour_history_order_id" => NULL,
								"roomIndex"					=> NULL,
								"itemRecordRef" 			=> $explodeTicketAdult[0],
								"pax_name"  				=> $paxName,
								"paxTitle" 	 		=> $pax_title[$keyTicketAdult][$keyTA],
								"pax_givenname"		=> $valTA,
								"pax_surname"		=> $pax_surname[$keyTicketAdult][$keyTA],
								"paxPassportNo" 		=> $pax_passport_no[$keyTicketAdult][$keyTA],
								"paxDOB" 		 		=> $dobAdult,
								"paxNationality" 		 => $pax_nationalityAdult[$keyTicketAdult][$keyTA],
								"paxPassportIssueCountry" => $pax_passportIssueCountryAdult[$keyTicketAdult][$keyTA],
								"paxPassportExpiryDate" 	=> $expiredAdult,
								"paxPassportIssueDate" 	=> $issuedAdult,
								"paxremarks" => $pax_remarksAdult[$keyTicketAdult][$keyTA],
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameTicketAdult = $this->All->insert_template($data_fieldsPaxTA, "landtour_paxname_ticket");
						}
					}
				}

				/* done */
				if( count($this->input->post("LT_Ticket_givennameChild")) > 0 && is_array($this->input->post("LT_Ticket_givennameChild")) ) {
					$pax_title = $this->input->post('LT_Ticket_titleChild');
					$pax_givenname = $this->input->post("LT_Ticket_givennameChild");
					$pax_surname = $this->input->post("LT_Ticket_surnameChild");
					$pax_passport_no = $this->input->post('LT_Ticket_passport_noChild');
					$pax_dob_year = $this->input->post('LT_Ticket_dob_yearChild');
					$pax_dob_month = $this->input->post('LT_Ticket_dob_monthChild');
					$pax_dob_day =  $this->input->post('LT_Ticket_dob_dayChild');
					$pax_nationality 			= $this->input->post("LT_Ticket_nationalityChild");
					$pax_passportIssueCountry 	= $this->input->post("LT_Ticket_passportIssueCountryChild");
					$pax_passport_expiryYear  	= $this->input->post("LT_Ticket_passport_expiryYearChild");
					$pax_passport_expiryMonth 	= $this->input->post("LT_Ticket_passport_expiryMonthChild");
					$pax_passport_expiryDate  	= $this->input->post("LT_Ticket_passport_expiryDateChild");
					$pax_passport_issueYear   	= $this->input->post("LT_Ticket_passport_issueYearChild");
					$pax_passport_issueMonth  	= $this->input->post("LT_Ticket_passport_issueMonthChild");
					$pax_passport_issueDay    	= $this->input->post("LT_Ticket_passport_issueDayChild");
					$pax_remarks = $this->input->post('LT_Ticket_passengerRemarks_Child');

					foreach( $this->input->post("LT_Ticket_givennameChild") AS $keyTicketChild => $valTicketChild ) {
						$explodeTicketChild = explode("00000", $keyTicketChild);

						foreach( $valTicketChild AS $keyTC => $valTC ) {
							$paxName = $valTC ." ". $pax_surname[$keyTicketChild][$keyTC];
							$dobPax = $pax_dob_year[$keyTicketChild][$keyTC].'-'.$pax_dob_month[$keyTicketChild][$keyTC].'-'.$pax_dob_day[$keyTicketChild][$keyTC];
							$expiredPassport = $pax_passport_expiryYear[$keyTicketChild][$keyTC].'-'.$pax_passport_expiryMonth[$keyTicketChild][$keyTC].'-'.$pax_passport_expiryDate[$keyTicketChild][$keyTC];
							$issuedPassport  = $pax_passport_issueYear[$keyTicketChild][$keyTC].'-'.$pax_passport_issueMonth[$keyTicketChild][$keyTC].'-'.$pax_passport_issueDay[$keyTicketChild][$keyTC];

							$data_fieldsPaxTC = array(
								"bookingID" 				=> $bookingOrderID,
								"pax_type"  				=> "CHILD",
								"landtour_product_id" 		=> $explodeTicketChild[1],
								"landtour_history_order_id" => NULL,
								"roomIndex"					=> NULL,
								"itemRecordRef" 			=> $explodeTicketChild[0],
								"pax_name"  				=> $paxName,
								"paxTitle" 	 		=> $pax_title[$keyTicketChild][$keyTC],
								"pax_givenname"		=> $valTC,
								"pax_surname"		=> $pax_surname[$keyTicketChild][$keyTC],
								"paxPassportNo" 		=> $pax_passport_no[$keyTicketChild][$keyTC],
								"paxDOB" 		 		=> $dobPax,
								"paxNationality" 		 => $pax_nationality[$keyTicketChild][$keyTC],
								"paxPassportIssueCountry" => $pax_passportIssueCountry[$keyTicketChild][$keyTC],
								"paxPassportExpiryDate" 	=> $expiredPassport,
								"paxPassportIssueDate" 	=> $issuedPassport,
								"paxremarks" => $pax_remarks[$keyTicketChild][$keyTC],
								"created"   				=> date("Y-m-d H:i:s"),
								"modified"  				=> date("Y-m-d H:i:s")
							);
							$insertPaxNameTicketChild = $this->All->insert_template($data_fieldsPaxTC, "landtour_paxname_ticket");
						}
					}
				}
			}
			/*--END OF INSERT LANDTOUR PAX NAMES--*/

			/*--INSERT HOTEL PAX NAMES--*/
			if ( $this->session->userdata('shoppingCartCookie') == TRUE ) {
				foreach ( $this->input->post("paxNameAdult") AS $keyRoom => $roomArr ) {
					foreach ($roomArr as $keyAdult => $valAdult) {
						$arrKey 	= explode(":", $keyAdult);
						$lastIdx 	= array_pop($arrKey);
						$roomTypeID = implode(':', explode(':', $keyAdult, -1));
						foreach ( $valAdult AS $keyA => $valA ) {
							$data_fieldsPaxAdult = array(
								"bookingID" 	 	  => $bookingOrderID,
								"adult_or_child" 	  => "ADULT",
								"RoomTypeID" 	 	  => $roomTypeID,
								"paxName" 		 	  => $valA,
								"flag_historyoder_id" => $lastIdx,
								"flag_room" => ($keyRoom + 1),
								"created" 		 	  => date("Y-m-d H:i:s"),
								"modified" 		 	  => date("Y-m-d H:i:s")
							);
							$insertPaxNameAdult = $this->All->insert_template($data_fieldsPaxAdult, "hotel_paxName");
						}
					}

				}

				if ($this->input->post('paxNameChild')) {
					$paxChildAge = $this->input->post('paxNameChildAge');

					foreach ( $this->input->post("paxNameChild") AS $keyRoom => $roomArr ) {
						foreach ($roomArr as $keyChild => $valChild) {
							$arrKey = explode(":", $keyChild);
							$lastIdx = array_pop($arrKey);
							$roomTypeID = implode(':', explode(':', $keyChild, -1));

							foreach ( $valChild AS $keyC => $valC ) {
								$data_fieldsPaxChild = array(
									"bookingID" 	 	  => $bookingOrderID,
									"adult_or_child" 	  => "CHILD",
									"RoomTypeID" 	 	  => $roomTypeID,
									"paxName" 		 	  => $valC,
									"flag_historyoder_id" => $lastIdx,
									"flag_room" => ($keyRoom + 1),
									"age" => $paxChildAge[$keyRoom]["$keyChild"][$keyC],
									"created" 		 	  => date("Y-m-d H:i:s"),
									"modified" 		 	  => date("Y-m-d H:i:s")
								);
								$insertPaxNameChild = $this->All->insert_template($data_fieldsPaxChild, "hotel_paxName");
							}
						}
					}
				}
				/*--put infant code is here--*/
			}
			/*--END OF INSERT HOTEL PAX NAMES--*/

			/*--INSERT FLIGHT PAX NAMES--*/
			if ( $this->session->userdata('shoppingCartFlightCookie') == TRUE ) {
				/*--ADULT PASSENGER--*/
				$pax_titleAdult 				= $this->input->post("titleAdult");
				/*$pax_nameAdult 					= $this->input->post("nameAdult");*/
				$pax_givennameAdult 					= $this->input->post("givennameAdult");
				$pax_surnameAdult 					= $this->input->post("surnameAdult");

				$pax_passport_noAdult 			= $this->input->post("passport_noAdult");
				$pax_nationalityAdult 			= $this->input->post("nationalityAdult");
				$pax_passportIssueCountryAdult 	= $this->input->post("passportIssueCountryAdult");
				/*
				$pax_dob_yearAdult 				= $this->input->post("dob_yearAdult");
				$pax_dob_monthAdult 			= $this->input->post("dob_monthAdult");
				$pax_dob_dayAdult 				= $this->input->post("dob_dayAdult");
				*/
				$pax_dobAdult = $this->input->post('dob_adult');

				$pax_passport_expiryYearAdult  	= $this->input->post("passport_expiryYearAdult");
				$pax_passport_expiryMonthAdult 	= $this->input->post("passport_expiryMonthAdult");
				$pax_passport_expiryDateAdult  	= $this->input->post("passport_expiryDateAdult");
				$pax_passport_issueYearAdult   	= $this->input->post("passport_issueYearAdult");
				$pax_passport_issueMonthAdult  	= $this->input->post("passport_issueMonthAdult");
				$pax_passport_issueDayAdult    	= $this->input->post("passport_issueDayAdult");
				$pax_remarksAdult = $this->input->post('passengerRemarks_Adult');

				if( count($this->session->userdata('shoppingCartFlightCookie')) > 0 ) {
					for($a=1; $a<=count($this->session->userdata('shoppingCartFlightCookie')); $a++) {
						if( count($pax_givennameAdult[$a]) > 0 ) {
							foreach( $pax_givennameAdult[$a] AS $key => $value ) {
						/*if( count($pax_nameAdult[$a]) > 0 ) {
							foreach( $pax_nameAdult[$a] AS $key => $value ) {*/
								$dobAdult 	 = $pax_dobAdult[$a][$key];
								/*$names = explode(" ", $pax_nameAdult[$a][$key]);
								$result = array_filter($names);*/
								/*$paxname = strtoupper(implode(" ", $result));*/

								$paxname = $pax_givennameAdult[$a][$key]." ".$pax_surnameAdult[$a][$key];

								//pax_dob_yearAdult[$a][$key].'-'.$pax_dob_monthAdult[$a][$key].'-'.$pax_dob_dayAdult[$a][$key];
								$expiredAdult = $pax_passport_expiryYearAdult[$a][$key].'-'.$pax_passport_expiryMonthAdult[$a][$key].'-'.$pax_passport_expiryDateAdult[$a][$key];
								$issuedAdult  = $pax_passport_issueYearAdult[$a][$key].'-'.$pax_passport_issueMonthAdult[$a][$key].'-'.$pax_passport_issueDayAdult[$a][$key];
								$data_fieldsPaxAdult = array(
									"bookingOrderID" 	 			=> $bookingOrderID,
									"passengerType" 				=> "ADULT",
									"passengerTitle" 	 			=> $pax_titleAdult[$a][$key],
									"passengerName" 		 		=> $paxname,
									"passenger_givenname" => $pax_givennameAdult[$a][$key],
									"passenger_surname" => $pax_surnameAdult[$a][$key],

									"passengerPassportNo" 		 	=> $pax_passport_noAdult[$a][$key],
									"passengerDOB" 		 			=> $dobAdult,
									"passengerNationality" 		 	=> $pax_nationalityAdult[$a][$key],
									"passengerPassportIssueCountry" => $pax_passportIssueCountryAdult[$a][$key],
									"passengerPassportExpiryDate" 	=> $expiredAdult,
									"passengerPassportIssueDate" 	=> $issuedAdult,
									"passenger_remarks" => $pax_remarksAdult[$a][$key],
									"passengerCartID" 		 		=> $a,
									"created" 		 				=> date("Y-m-d H:i:s"),
									"modified" 		 				=> date("Y-m-d H:i:s")
								);
								$insertAdult = $this->All->insert_template($data_fieldsPaxAdult, "flight_passenger_pnr_details");
							}
						}
					}
				}
				/*--END OF ADULT PASSENGER--*/
				/*--CHILD PASSENGER--*/
				$pax_titleChild 				= $this->input->post("titleChild");
				/*$pax_nameChild = $this->input->post('nameChild');*/
				$pax_givennameChild 					= $this->input->post("givennameChild");
				$pax_surnameChild 					= $this->input->post("surnameChild");

				$pax_passport_noChild 			= $this->input->post("passport_noChild");
				$pax_nationalityChild 			= $this->input->post("nationalityChild");
				$pax_passport_issueCountryChild = $this->input->post("passport_issueCountryChild");
				/*$pax_dob_yearChild 				= $this->input->post("dob_yearChild");
				$pax_dob_monthChild 			= $this->input->post("dob_monthChild");
				$pax_dob_dayChild 				= $this->input->post("dob_dayChild");*/
				$pax_dobChild = $this->input->post('dob_child');
				$pax_passport_expiryYearChild  	= $this->input->post("passport_expiryYearChild");
				$pax_passport_expiryMonthChild 	= $this->input->post("passport_expiryMonthChild");
				$pax_passport_expiryDayChild  	= $this->input->post("passport_expiryDayChild");
				$pax_passport_issueYearChild   	= $this->input->post("passport_issueYearChild");
				$pax_passport_issueMonthChild  	= $this->input->post("passport_issueMonthChild");
				$pax_passport_issueDayChild    	= $this->input->post("passport_issueDayChild");
				$pax_remarksChild = $this->input->post('passengerRemarks_Child');

				if( count($this->session->userdata('shoppingCartFlightCookie')) > 0 ) {
					for($a=1; $a<=count($this->session->userdata('shoppingCartFlightCookie')); $a++) {
						/*if(isset($pax_nameChild[$a]) && count($pax_nameChild[$a]) > 0 ) {
							foreach( $pax_nameChild[$a] AS $key => $value ) {*/
						if(isset($pax_givennameChild[$a]) && count($pax_givennameChild[$a]) > 0 ) {
							foreach( $pax_givennameChild[$a] AS $key => $value ) {
								$dobChild 	 = $pax_dobChild[$a][$key];
								/*pax_dob_yearChild[$a][$key].'-'.$pax_dob_monthChild[$a][$key].'-'.$pax_dob_dayChild[$a][$key];*/
								$expiredChild = $pax_passport_expiryYearChild[$a][$key].'-'.$pax_passport_expiryMonthChild[$a][$key].'-'.$pax_passport_expiryDayChild[$a][$key];
								$issuedChild  = $pax_passport_issueYearChild[$a][$key].'-'.$pax_passport_issueMonthChild[$a][$key].'-'.$pax_passport_issueDayChild[$a][$key];

								/*$names = explode(" ", $pax_nameChild[$a][$key]);
								$result = array_filter($names);
								$paxname = strtoupper(implode(" ", $result));*/

								$paxname = $pax_givennameChild[$a][$key]." ".$pax_surnameChild[$a][$key];

								$data_fieldsPaxChild = array(
									"bookingOrderID" 	 			=> $bookingOrderID,
									"passengerType" 				=> "CHILD",
									"passengerTitle" 	 			=> $pax_titleChild[$a][$key],
									"passengerName" 		 		=> $paxname,
									"passenger_givenname" => $pax_givennameChild[$a][$key],
									"passenger_surname" => $pax_surnameChild[$a][$key],

									"passengerPassportNo" 		 	=> $pax_passport_noChild[$a][$key],
									"passengerDOB" 		 			=> $dobChild,
									"passengerNationality" 		 	=> $pax_nationalityChild[$a][$key],
									"passengerPassportIssueCountry" => $pax_passport_issueCountryChild[$a][$key],
									"passengerPassportExpiryDate" 	=> $expiredChild,
									"passengerPassportIssueDate" 	=> $issuedChild,
									"passenger_remarks" => $pax_remarksChild[$a][$key],
									"passengerCartID" 		 		=> $a,
									"created" 		 				=> date("Y-m-d H:i:s"),
									"modified" 		 				=> date("Y-m-d H:i:s")
								);
								$insertChild = $this->All->insert_template($data_fieldsPaxChild, "flight_passenger_pnr_details");
							}
						}
					}
				}
				/*--END OF CHILD PASSENGER--*/
				/*--INFANT PASSENGER--*/
				$pax_titleInfant 				 = $this->input->post("titleInfant");
				$pax_nameInfant 				 = $this->input->post("nameInfant");
				$pax_givennameInfant 				 = $this->input->post("givennameInfant");
				$pax_surnameInfant 				 = $this->input->post("surnameInfant");

				$pax_passport_noInfant 			 = $this->input->post("passport_noInfant");
				$pax_nationalityInfant 			 = $this->input->post("nationalityInfant");
				$pax_passport_issueCountryInfant = $this->input->post("passport_issueCountryInfant");
				/*$pax_dob_yearInfant 			 = $this->input->post("dob_yearInfant");
				$pax_dob_monthInfant 			 = $this->input->post("dob_monthInfant");
				$pax_dob_dayInfant 				 = $this->input->post("dob_dayInfant");*/
				$pax_dobInfant 	= $this->input->post('dob_infant');
				$pax_passport_expiryYearInfant   = $this->input->post("passport_expiryYearInfant");
				$pax_passport_expiryMonthInfant  = $this->input->post("passport_expiryMonthInfant");
				$pax_passport_expiryDayInfant  	 = $this->input->post("passport_expiryDayInfant");
				$pax_passport_issueYearInfant    = $this->input->post("passport_issueYearInfant");
				$pax_passport_issueMonthInfant   = $this->input->post("passport_issueMonthInfant");
				$pax_passport_issueDayInfant     = $this->input->post("passport_issueDayInfant");
				$pax_remarksInfant = $this->input->post('passengerRemarks_Infant');

				if( count($this->session->userdata('shoppingCartFlightCookie')) > 0 ) {
					for($a=1; $a<=count($this->session->userdata('shoppingCartFlightCookie')); $a++) {
						if(isset($pax_givennameInfant[$a]) && count($pax_givennameInfant[$a]) > 0 ) {
							foreach( $pax_givennameInfant[$a] AS $key => $value ) {
						/*if(isset($pax_nameInfant[$a]) && count($pax_nameInfant[$a]) > 0 ) {
							foreach( $pax_nameInfant[$a] AS $key => $value ) {*/
								/*$names = explode(" ", $pax_nameInfant[$a][$key]);
								$result = array_filter($names);
								$paxname = strtoupper(implode(" ", $result));*/

								$paxname = $pax_givennameInfant[$a][$key]." ".$pax_surnameInfant[$a][$key];

								/*$dobInfant 	   = $pax_dob_yearInfant[$a][$key].'-'.$pax_dob_monthInfant[$a][$key].'-'.$pax_dob_dayInfant[$a][$key];*/
								$dobInfant 	 = $pax_dobInfant[$a][$key];
								$expiredInfant = $pax_passport_expiryYearInfant[$a][$key].'-'.$pax_passport_expiryMonthInfant[$a][$key].'-'.$pax_passport_expiryDayInfant[$a][$key];
								$issuedInfant  = $pax_passport_issueYearInfant[$a][$key].'-'.$pax_passport_issueMonthInfant[$a][$key].'-'.$pax_passport_issueDayInfant[$a][$key];
								$data_fieldsPaxInfant = array(
									"bookingOrderID" 	 			=> $bookingOrderID,
									"passengerType" 				=> "INFANT",
									"passengerTitle" 	 			=> $pax_titleInfant[$a][$key],
									"passengerName" 		 		=> $paxname,
									"passenger_givenname" 		 		=> $pax_givennameInfant[$a][$key],
									"passenger_surname" 		 		=> $pax_surnameInfant[$a][$key],

									"passengerPassportNo" 		 	=> $pax_passport_noInfant[$a][$key],
									"passengerDOB" 		 			=> $dobInfant,
									"passengerNationality" 		 	=> $pax_nationalityInfant[$a][$key],
									"passengerPassportIssueCountry" => $pax_passport_issueCountryInfant[$a][$key],
									"passengerPassportExpiryDate" 	=> $expiredInfant,
									"passengerPassportIssueDate" 	=> $issuedInfant,
									"passenger_remarks" => $pax_remarksInfant[$a][$key],
									"passengerCartID" 		 		=> $a,
									"created" 		 				=> date("Y-m-d H:i:s"),
									"modified" 		 				=> date("Y-m-d H:i:s")
								);
								$insertInfant = $this->All->insert_template($data_fieldsPaxInfant, "flight_passenger_pnr_details");
							}
						}
					}
				}
				/*--END OF INFANT PASSENGER--*/
			}
			/*--END OF INSERT FLIGHT PAX NAMES--*/

			/*--INSERT INTO HOTEL_HISTORY_ORDER--*/
			if ( $this->session->userdata('shoppingCartCookie') == TRUE ) {
				$sp = $this->input->post("remarkCK");
				for ($ha=0; $ha<$arrayHotelCount; $ha++) {
					$ctr = 0;
					$implodeSP = "";
					foreach ($arrayHotel[$ha]['hotel_room'] as $hotelroom)
					{
						$arraySP   = $sp[$ha][$ctr];
						$implodeSP = implode(",", $arraySP);

						/*--SPECIAL REQUEST--*/
						//$arraySP   = $sp[$arrayHotelCount[->id];

						/*--END OF SPECIAL REQUEST--*/
						$data_fieldsHistory = array(
							"hotel_confirmedBookOrder_ID" => $last_insertConfirmID,
							"bookingRefID" 			 	  => $bookingOrderID,
							"hotel_Fullname" 			  => $arrayHotel[$ha]["hotel_Fullname"],
							"hotel_Image" 		      	  => $arrayHotel[$ha]["hotel_Image"],
							"hotel_ItemCode" 		  	  => $arrayHotel[$ha]["hotel_ItemCode"],
							"hotel_ItemCityCode" 		  => $arrayHotel[$ha]["hotel_ItemCityCode"],
							"hotel_PricePerRoom" 		  => $hotelroom["hotel_PricePerRoom"],
							"hotel_RoomType" 			  => $hotelroom["hotel_RoomType"],
							"hotel_RoomTypeID"			  => $hotelroom["hotel_RoomTypeID"],
							"hotel_RoomQuantity"		  => $arrayHotel[$ha]["hotel_RoomQuantity"],
							"hotel_AdultQuantity"		  => $hotelroom["hotel_AdultQuantity"],
							"hotel_ChildQuantity"		  => $hotelroom["hotel_ChildQuantity"],
							"hotel_InfantQuantity"		  => $hotelroom["hotel_InfantQuantity"],
							"check_in_date"				  => $arrayHotel[$ha]["check_in_date"],
							"check_out_date"			  => $arrayHotel[$ha]["check_out_date"],
							"duration" 		  		  	  => $arrayHotel[$ha]["duration"],
							"room_index" => $hotelroom['room_index'],
							"user_access_id" 			  => $userAccessID,
							"special_request" 			  => $remarksCP,
							"hotelAPISpecialRequest"	  => $implodeSP,
							"GTA_Markup_Rate" => GTA_PRICE_MARKUP,
							"room_meal" => $hotelroom['room_meal'],
							"created" 					  => date("Y-m-d H:i:s"),
							"modified" 					  => date("Y-m-d H:i:s")
						);
						$insertHistoryOrder  = $this->All->insert_template($data_fieldsHistory, "hotel_historyOder");
						$last_historyOrderID = $this->db->insert_id();

						$data_field = array("flag_historyoder_id" => $last_historyOrderID);
						$this->All->update_template_two($data_field, 'bookingID', $bookingOrderID, 'flag_historyoder_id', $ha, 'hotel_paxName');
						$ctr++;
					}
				}
				$success_hotel_checkout = true;
			}
			/*--END OF INSERT INTO HOTEL_HISTORY_ORDER--*/

			/*--INSERT INTO FLIGHT_HISTORY_ORDER--*/
			if ( $this->session->userdata('shoppingCartFlightCookie') == TRUE ) {
				$arrayFlight = $this->session->userdata('shoppingCartFlightCookie');
				if ( $arrayFlight == TRUE ) {
					if ( count($arrayFlight) > 0 ) {
						$file_datas = require_once($this->instanceurl.'webservices/abacus/SWSWebservices.class.php');
						$flight_PNR = "";
						$arrayPNR = array();
						for ($ha=0; $ha<count($arrayFlight); $ha++) {
							$passengerDetails = $this->All->select_template_w_2_conditions(
								"bookingOrderID", $bookingOrderID,
								"passengerCartID", ($ha + 1),
								"flight_passenger_pnr_details"
							);
							/* get PNR, still only support 1 single FLight */
							$depFlightCode = $arrayFlight[$ha]["departureFlightCode"];
							$depFlightCodeArr = explode("~", $depFlightCode);
							if (count($depFlightCodeArr) > 1) {
								$returnRefID = book_flight_multiflight(
									$arrayFlight[$ha]["departureFlightAirEquipType"],
									$arrayFlight[$ha]["arrivalFlightAirEquipType"],
									$arrayFlight[$ha]["departureDateFrom"],
									$arrayFlight[$ha]["departureTimeFrom"],
									$arrayFlight[$ha]["departureDateTo"],
									$arrayFlight[$ha]["departureTimeTo"],

									$arrayFlight[$ha]["departureCityCodeFrom"],
									$arrayFlight[$ha]["departureCityCodeTo"],
									$arrayFlight[$ha]["departureFlightCode"],
									$arrayFlight[$ha]["departureFlightResBookDesigCode"],
	    							$arrayFlight[$ha]["departureFlightAirEquipType"],
	    							$arrayFlight[$ha]["departureFlightMarriageGrp"],
	    							$arrayFlight[$ha]["arrivalDateFrom"],
	    							$arrayFlight[$ha]["arrivalTimeFrom"],
	    							$arrayFlight[$ha]["arrivalDateTo"],
	    							$arrayFlight[$ha]["arrivalTimeTo"],
									$arrayFlight[$ha]["arrivalCityCodeFrom"],
									$arrayFlight[$ha]["arrivalCityCodeTo"],
									$arrayFlight[$ha]["arrivalFlightCode"],
									$arrayFlight[$ha]["arrivalFlightResBookDesigCode"],
	    							$arrayFlight[$ha]["arrivalFlightAirEquipType"],
	    							$arrayFlight[$ha]["arrivalFlightMarriageGrp"],
									$arrayFlight[$ha]["noofAdult"],
									$arrayFlight[$ha]["noofChild"],
									$arrayFlight[$ha]["noofInfant"],
									$this->input->post("emailCP"),
	    							$this->input->post("contactCP"),
	    							$this->input->post("nationalityCP"),
	    							$passengerDetails,
									$this->input->post('remarksCP')
								);

								if($returnRefID != '' && $returnRefID != 'error') {
									/* save the PNR */
									$flight_PNR = $returnRefID;
									/* we got PNR! save to flight_history_order in next session */
								}
								else {
									$this->session->set_flashdata('error_checkout',
										'<article class="full-width-2">
											<div style="text-align:center; color:red; padding:15px; font-size:16px">
												Flight Booking error. Please try again.
											</div>
										</article>'
									);
									//echo 'B';
									redirect("checkout");
									exit;
								}
							}
							else {
								/* check if it one way or transfer / return flight */
								/* single flight */
								$sepFlightCode = explode(" ", $depFlightCode);
								$flightCode    = $sepFlightCode[0];
								$flightNo 	   = $sepFlightCode[1];
								if ($arrayFlight[$ha]["arrivalFlightCode"] != "") {
									/* return */
									$arrvFlightCode    = $arrayFlight[$ha]["arrivalFlightCode"];
									$arrvFlightCodeArr = explode("~", $arrvFlightCode);
									if(count($arrvFlightCodeArr)) {
										$returnRefID = book_flight_multiflight(
											$arrayFlight[$ha]["departureFlightAirEquipType"],
											$arrayFlight[$ha]["arrivalFlightAirEquipType"],
											$arrayFlight[$ha]["departureDateFrom"],
											$arrayFlight[$ha]["departureTimeFrom"],
											$arrayFlight[$ha]["departureDateTo"],
											$arrayFlight[$ha]["departureTimeTo"],

											$arrayFlight[$ha]["departureCityCodeFrom"],
											$arrayFlight[$ha]["departureCityCodeTo"],
											$arrayFlight[$ha]["departureFlightCode"],
											$arrayFlight[$ha]["departureFlightResBookDesigCode"],
			    							$arrayFlight[$ha]["departureFlightAirEquipType"],
			    							$arrayFlight[$ha]["departureFlightMarriageGrp"],
			    							$arrayFlight[$ha]["arrivalDateFrom"],
			    							$arrayFlight[$ha]["arrivalTimeFrom"],
			    							$arrayFlight[$ha]["arrivalDateTo"],
			    							$arrayFlight[$ha]["arrivalTimeTo"],
											$arrayFlight[$ha]["arrivalCityCodeFrom"],
											$arrayFlight[$ha]["arrivalCityCodeTo"],
											$arrayFlight[$ha]["arrivalFlightCode"],
											$arrayFlight[$ha]["arrivalFlightResBookDesigCode"],
			    							$arrayFlight[$ha]["arrivalFlightAirEquipType"],
			    							$arrayFlight[$ha]["arrivalFlightMarriageGrp"],
											$arrayFlight[$ha]["noofAdult"],
											$arrayFlight[$ha]["noofChild"], $arrayFlight[$ha]["noofInfant"],
											$this->input->post("emailCP"),
			    							$this->input->post("contactCP"),
			    							$this->input->post("nationalityCP"),
			    							$passengerDetails,
							                $this->input->post('remarksCP')
										);
									}

									if($returnRefID != '' && $returnRefID != 'error') {
										/* save the PNR */
										$flight_PNR = $returnRefID;
										/* we got PNR! save to flight_history_order in next session */
									}
									else {
										$this->session->set_flashdata('error_checkout',
											'<article class="full-width-2">
												<div style="text-align:center; color:red; padding:15px; font-size:16px">
													Flight Booking error. Please try again.
												</div>
											</article>'
										);
										//echo 'C';
										redirect("checkout");
										exit;
									}
								}
								else {
									/* single flight, just departure. yep */
									$sepFlightCode = explode(" ", $depFlightCode);
									$flightCode    = $sepFlightCode[0];
									$flightNo 	   = $sepFlightCode[1];
									$returnRefID = book_flight_SINGLE(
										$arrayFlight[$ha]["departureDateFrom"],
										$arrayFlight[$ha]["departureTimeFrom"],
										$arrayFlight[$ha]["departureCityCodeTo"],
										$flightCode,
										$flightNo,
										$arrayFlight[$ha]["departureCityCodeFrom"],
										$arrayFlight[$ha]["noofAdult"],
										$arrayFlight[$ha]["noofChild"],
										$arrayFlight[$ha]["noofInfant"],
										'O',
										$arrayFlight[$ha]["flightClass"],
										$passengerDetails,
										$this->input->post("emailCP"),
					    				$this->input->post("contactCP"),
										$this->input->post('remarksCP')
									);

									if($returnRefID != '' && $returnRefID != 'error') {
										/* save the PNR */
										$flight_PNR = $returnRefID;
										/* we got PNR! save to flight_history_order in next session */
									}
									else {
										$this->session->set_flashdata('error_checkout',
											'<article class="full-width-2">
												<div style="text-align:center; color:red; padding:15px; font-size:16px">
													Flight Booking error. Please try again.
												</div>
											</article>'
										);
										//echo 'D';
										redirect("checkout");
										exit;
									}
								}
							}
							$data_fieldsHistory = array(
								"flight_confirmedBookOrder_ID" => $last_insertConfirmID,
								"bookingRefID" 				   => $bookingOrderID,
								"departureFlightName" 	   	   => $arrayFlight[$ha]["departureFlightName"],
					            "departureFlightCode" 	   	   => $arrayFlight[$ha]["departureFlightCode"],
					            "departureDateFrom" 	   	   => $arrayFlight[$ha]["departureDateFrom"],
					            "departureDateTo" 		   	   => $arrayFlight[$ha]["departureDateTo"],
					            "departureTimeFrom" 	  	   => $arrayFlight[$ha]["departureTimeFrom"],
					            "departureTimeTo" 		   	   => $arrayFlight[$ha]["departureTimeTo"],
					            "departureCityNameFrom"    	   => $arrayFlight[$ha]["departureCityNameFrom"],
					            "departureCityNameTo" 	   	   => $arrayFlight[$ha]["departureCityNameTo"],
					            "departureCityCodeFrom"    	   => $arrayFlight[$ha]["departureCityCodeFrom"],
					            "departureCityCodeTo" 	   	   => $arrayFlight[$ha]["departureCityCodeTo"],
					            "departureAirportNameFrom" 	   => $arrayFlight[$ha]["departureAirportNameFrom"],
					            "departureAirportNameTo"   	   => $arrayFlight[$ha]["departureAirportNameTo"],
					            "departureTimeTaken" 	   	   => $arrayFlight[$ha]["departureTimeTaken"],
					            "departureBaggage" 		   	   => $arrayFlight[$ha]["departureBaggage"],
					            "departureMeal" 		   	   => $arrayFlight[$ha]["departureMeal"],
					            "departureTotalTransit"	   	   => $arrayFlight[$ha]["departureTotalTransit"],
					            "departureTotalFlightTime" 	   => $arrayFlight[$ha]["departureTotalFlightTime"],
					            "departureTotalPrice" 	   	   => $arrayFlight[$ha]["departureTotalPrice"],
					            "departureFlightAirEquipType" => $arrayFlight[$ha]["departureFlightAirEquipType"],

					            "departurePriceAdultTaxFare" => $arrayFlight[$ha]['departurePriceAdultTaxFare'],
								"departurePriceAdultBaseFare" => $arrayFlight[$ha]['departurePriceAdultBaseFare'],
								"departurePriceChildTaxFare" => $arrayFlight[$ha]['departurePriceChildTaxFare'],
								"departurePriceChildBaseFare" => $arrayFlight[$ha]['departurePriceChildBaseFare'],
								"departurePriceInfantTaxFare" => $arrayFlight[$ha]['departurePriceInfantTaxFare'],
								"departurePriceInfantBaseFare" => $arrayFlight[$ha]['departurePriceInfantBaseFare'],

								"departureTerminalID_from" => $arrayFlight[$ha]['departureTerminalID_from'],
								"departureTimezone_from" => $arrayFlight[$ha]['departureTimezone_from'],
								"departureTerminalID_to" => $arrayFlight[$ha]['departureTerminalID_to'],
								"departureTimezone_to" => $arrayFlight[$ha]['departureTimezone_to'],

					            "arrivalFlightName" 	   	   => $arrayFlight[$ha]["arrivalFlightName"],
					            "arrivalFlightCode" 	   	   => $arrayFlight[$ha]["arrivalFlightCode"],
					            "arrivalDateFrom" 		   	   => $arrayFlight[$ha]["arrivalDateFrom"],
					            "arrivalDateTo" 		   	   => $arrayFlight[$ha]["arrivalDateTo"],
					            "arrivalTimeFrom" 		   	   => $arrayFlight[$ha]["arrivalTimeFrom"],
					            "arrivalTimeTo" 		   	   => $arrayFlight[$ha]["arrivalTimeTo"],
					            "arrivalCityNameFrom" 	   	   => $arrayFlight[$ha]["arrivalCityNameFrom"],
					            "arrivalCityNameTo" 	   	   => $arrayFlight[$ha]["arrivalCityNameTo"],
					            "arrivalCityCodeFrom" 	   	   => $arrayFlight[$ha]["arrivalCityCodeFrom"],
					            "arrivalCityCodeTo" 	   	   => $arrayFlight[$ha]["arrivalCityCodeTo"],
					            "arrivalAirportNameFrom"   	   => $arrayFlight[$ha]["arrivalAirportNameFrom"],
					            "arrivalAirportNameTo" 	   	   => $arrayFlight[$ha]["arrivalAirportNameTo"],
					            "arrivalTimeTaken" 		   	   => $arrayFlight[$ha]["arrivalTimeTaken"],
					            "arrivalBaggage" 		   	   => $arrayFlight[$ha]["arrivalBaggage"],
					            "arrivalMeal" 			   	   => $arrayFlight[$ha]["arrivalMeal"],
					            "arrivalTotalTransit" 	   	   => $arrayFlight[$ha]["arrivalTotalTransit"],
					            "arrivalTotalFlightTime"   	   => $arrayFlight[$ha]["arrivalTotalFlightTime"],
					            "arrivalTotalPrice" 	   	   => $arrayFlight[$ha]["arrivalTotalPrice"],
					            "arrivalFlightAirEquipType" => $arrayFlight[$ha]["arrivalFlightAirEquipType"],

					            "arrivalPriceAdultTaxFare" => $arrayFlight[$ha]['arrivalPriceAdultTaxFare'],
								"arrivalPriceAdultBaseFare" => $arrayFlight[$ha]['arrivalPriceAdultBaseFare'],
								"arrivalPriceChildTaxFare" => $arrayFlight[$ha]['arrivalPriceChildTaxFare'],
								"arrivalPriceChildBaseFare" => $arrayFlight[$ha]['arrivalPriceChildBaseFare'],
								"arrivalPriceInfantTaxFare" => $arrayFlight[$ha]['arrivalPriceInfantTaxFare'],
								"arrivalPriceInfantBaseFare" => $arrayFlight[$ha]['arrivalPriceInfantBaseFare'],

								"arrivalTerminalID_from" => $arrayFlight[$ha]['arrivalTerminalID_from'],
								"arrivalTimezone_from" => $arrayFlight[$ha]['arrivalTimezone_from'],
								"arrivalTerminalID_to" => $arrayFlight[$ha]['arrivalTerminalID_to'],
								"arrivalTimezone_to" => $arrayFlight[$ha]['arrivalTimezone_to'],

								"departureFareBasisCode" => $arrayFlight[$ha]['departureFareBasisCode'],
								"arrivalFareBasisCode" => $arrayFlight[$ha]['arrivalFareBasisCode'],
								"departuremealcode" => $arrayFlight[$ha]['departuremealcode'],
								"arrivalmealcode" => $arrayFlight[$ha]['arrivalmealcode'],

								"TotalPriceAdminFare" => $arrayFlight[$ha]['TotalPriceAdminFare'],
					            "noofAdult" 			   	   => $arrayFlight[$ha]["noofAdult"],
					            "noofChild" 			   	   => $arrayFlight[$ha]["noofChild"],
					            "noofInfant" 			   	   => $arrayFlight[$ha]["noofInfant"],
					            "flightClass" 			   	   => $arrayFlight[$ha]["flightClass"],
					            "user_access_id"			   => $userAccessID,
					            "created" 				   	   => date("Y-m-d H:i:s"),
					            "modified" 				   	   => date("Y-m-d H:i:s"),
					            "flight_PNR"				   => $flight_PNR
							);
							$insertHistoryOrder  = $this->All->insert_template($data_fieldsHistory, "flight_history_order");
							$last_historyOrderID = $this->db->insert_id();
						}
					}
				}
				$success_flight_checkout = true;
			}
			/*--END OF INSERT INTO FLIGHT_HISTORY_ORDER--*/

			/*--INSERT INTO LANDTOUR_HISTORY_ORDER--*/
			if ( $this->session->userdata('shoppingCartLandtourCookie') == TRUE ) {
				for($la=0; $la<$arrayLandtourCount; $la++) {
					$data_fieldsHistory = array(
						"landtour_confirmedBookOrder_ID" => $last_insertConfirmID,
						"bookOrderID"					 => $bookingOrderID,
						"landtour_product_id" 			 => $arrayLandtour[$la]["landtour_product_id"],
						"landtour_system_price_id"		 => $arrayLandtour[$la]["landtour_system_price_id"],
						"selected_date" 				 => $arrayLandtour[$la]["selectedDate"],
						"countRoom" 		         	 => $arrayLandtour[$la]["countRoom"],
						"paxDetails" 			  	   	 => $arrayLandtour[$la]["paxDetails"],
						"sellingType"					 => $arrayLandtour[$la]["sellingType"],
						"user_access_id" 			  	 => $userAccessID,
						"special_request"			   	 => $this->input->post("member_remarksLandtour"),
						"status"				   		 => "CONFIRMED",
						"created" 					     => date("Y-m-d H:i:s"),
						"modified" 					   	 => date("Y-m-d H:i:s")
					);
					$insertHistoryOrder  = $this->All->insert_template($data_fieldsHistory, "landtour_history_order");
					$last_historyOrderID = $this->db->insert_id();
				}
				$success_landtour_checkout = true;
			}
			/*--END OF INSERT INTO LANDTOUR_HISTORY_ORDER--*/

			/*--INSERT INTO CRUISE_HISTORY_ORDER--*/
			if ( $this->session->userdata('shoppingCartCruiseCookie') == TRUE ) {
				for($ca=0; $ca<$arrayCruiseCount; $ca++) {
					$data_fieldsHistory = array(
						"cruise_confirmedBookOrder_ID" => $last_insertConfirmID,
						"brandID" 			 		   => $arrayCruise[$ca]["brandID"],
						"shipID" 				  	   => $arrayCruise[$ca]["shipID"],
						"cruiseTitleID" 		       => $arrayCruise[$ca]["cruiseTitleID"],
						"durationNight" 		  	   => $arrayCruise[$ca]["durationNight"],
						"cruiseDate" 		  		   => $arrayCruise[$ca]["cruiseDate"],
						"stateroomID" 			  	   => $arrayCruise[$ca]["stateroomID"],
						"cruisePrice" 			  	   => $arrayCruise[$ca]["cruisePrice"],
						"cruisePriceType"			   => $arrayCruise[$ca]["cruisePriceType"],
						"extraPrice"				   => $arrayCruise[$ca]["extraPrice"],
						"extraIDs"				   	   => $arrayCruise[$ca]["extraIDs"],
						"extraPeriod"				   => $arrayCruise[$ca]["extraPeriod"],
						"noofAdult" 		  		   => $arrayCruise[$ca]["noofAdult"],
						"noofChild" 		  		   => $arrayCruise[$ca]["noofChild"],
						"user_access_id" 			   => $userAccessID,
						"created" 					   => date("Y-m-d H:i:s"),
						"modified" 					   => date("Y-m-d H:i:s")
					);
					$insertHistoryOrder  = $this->All->insert_template($data_fieldsHistory, "cruise_historyOrder");
					$last_historyOrderID = $this->db->insert_id();
				}
				$success_cruise_checkout = true;
			}
			/*--END OF INSERT INTO CRUISE_HISTORY_ORDER--*/

			/*--INSERT INTO CONTACT PERSON INFORMATION--*/
			/*$dobCP = $this->input->post("dob_yearCP").'-'.$this->input->post("dob_monthCP").'-'.$this->input->post("dob_dayCP");*/
			/*$dobCP = $this->input->post("dob_cp");
			$issCP = $this->input->post("passport_issueYearCP").'-'.$this->input->post("passport_issueMonthCP").'-'.$this->input->post("passport_issueDayCP");
			$expCP = $this->input->post("passport_expiryYearCP").'-'.$this->input->post("passport_expiryMonthCP").'-'.$this->input->post("passport_expiryDayCP");
			*/
			/*$names = explode(" ", $this->input->post("nameCP"));
			$resultcp = array_filter($names);
			$cpname = strtoupper(implode(" ", $resultcp));*/

			if($success_cruise_checkout || $success_landtour_checkout || $success_hotel_checkout || $success_flight_checkout) {
				$data_fieldsContactPerson = array(
					"bookOrderID" 		   	  => $bookingOrderID,
					"cp_title" 	   			  => $this->input->post("titleCP"),
					"cp_fullname" 	   		  => $this->input->post('nameCP'),
					"cp_email"				  => $this->input->post("emailCP"),
					"cp_contact_no"  		  => $this->input->post("contactCP"),
					"cp_remarks"  			  => $this->input->post("remarksCP"),
					"created" 			   	  => date("Y-m-d H:i:s"),
					"modified" 			   	  => date("Y-m-d H:i:s")
				);
				$insertContactPerson = $this->All->insert_template($data_fieldsContactPerson, "contact_person_information");

				/* emergency contact person */
				$data_fieldsEContactPerson = array(
					"bookOrderID" 		   	  => $bookingOrderID,
					"cp_title" 	   			  => $this->input->post("e_titleCP"),
					"cp_fullname" 	   		  => $this->input->post("e_nameCP"),
					"cp_email"				  => $this->input->post("e_emailCP"),
					"cp_contact_no"  		  => $this->input->post("e_contactCP"),
					'category' => $this->input->post('emergency_relationship'),
					"created" 			   	  => date("Y-m-d H:i:s"),
					"modified" 			   	  => date("Y-m-d H:i:s")
				);
				$insertEContactPerson = $this->All->insert_template($data_fieldsEContactPerson, "contact_person_information");
				/*--END OF INSERT INTO CONTACT PERSON INFORMATION--*/

				//for live
				$ref = uniqid();
				$signature = hash('sha512',$totalGranPrice.$bookingOrderID."SGD107201335038LrYIiO7krQ");

				//session and redirect
				/*--LIVE--*/
				redirect("https://securepayments.telemoneyworld.com/easypay2/paymentpage.do?mid=107201335038&ref=".$bookingOrderID."&amt=".$totalGranPrice."&cur=SGD&rcard=64&returnurl=".base_url()."payment/success_booked/".base64_encode(base64_encode(base64_encode($bookingOrderID)))."&statusurl=".base_url()."payment/statusURLindex123/".$bookingOrderID."&transtype=sale&validity=".date("Y-m-d-H:i:s", mktime(date("H")+8,date("i")+15,date("s"),date("m"),date("d"),date("Y")))."&version=2&signature=".$signature."");
				/*--END OF LIVE--*/

				//session and redirect
				//redirect("https://test.wirecard.com.sg/easypay2/paymentpage.do?mid=20131113001&ref=".$bookingOrderID."&amt=".$totalGranPrice."&cur=SGD&rcard=64&returnurl=".base_url()."payment/success_booked/".base64_encode(base64_encode(base64_encode($bookingOrderID)))."&statusurl=".base_url()."payment/statusURLindex123/".$bookingOrderID."&paytype=3&transtype=auth&ccnum=4111111111111111&ccdate=1611&cccvv=898&validity=2018-11-01-11:22:33");
				//end of session and redirect
			} else {
				$this->session->set_flashdata('error_checkout', 'Your session expired. Please try adding your order again');
				redirect('cart/index');
			}

		}
	}

    public function testpay()
    {
        $bookOrderID = $this->uri->segment(3);

        if (!isset($_SERVER['HTTP_HOST'])) {
            echo 'Not Allowed!';
        }
        $totalGranPrice = $this->input->post('grandprice');

        $ref = uniqid();
        $signature = hash('sha512',$totalGranPrice.$bookOrderID."SGD107201335038LrYIiO7krQ");


        redirect("https://securepayments.telemoneyworld.com/easypay2/paymentpage.do?mid=107201335038&ref=".$bookOrderID."&amt=".$totalGranPrice."&cur=SGD&rcard=64&returnurl=".base_url()."payment/success_booked/".base64_encode(base64_encode(base64_encode($bookOrderID)))."&statusurl=".base_url()."payment/statusURLindex123/".$bookOrderID."&transtype=sale&validity=".date("Y-m-d-H:i:s", mktime(date("H")+8,date("i")+15,date("s"),date("m"),date("d"),date("Y")))."&version=2&signature=".$signature."");
    }

/*    public function testmailpay()
    {
        $this->load->library('email');
        $config = array(
            'charset'  => 'utf-8',
            'wordwrap' => TRUE,
            'mailtype' => 'html'
        );

        $this->email->initialize($config);
        $this->email->from('info@ctc.com.sg', 'CTC Travel');
        $this->email->to('fandyfandry@gmail.com');
        $this->email->bcc('beto.thamrin@gmail.com');
        $this->email->subject('CTC Pax Statement');
        $this->email->message('asdasd');
        $this->email->send();

    }*/
	public function statusURLindex123()
	{
		$bookOrderID = $this->uri->segment(3);

        $txt  = "[".date("Y-m-d H:i:s")."] [PaymentCheck]".$bookOrderID." \n\n";

        //log file
        $filepayment = fopen("/var/www/html/ctctravel.org/fit/assets/api-logs/log_payment.txt", "a") or die("Unable to open file!");
        fwrite($filepayment, "\n". $txt);
        fclose($filepayment);

        $insert_pay_id_update = "-";
        if($this->session->userdata('shoppingCartFlightCookie') == TRUE) {
            $data_fldsd = array(
                'bookOrderID' => ($bookOrderID == "" ? "-" : $bookOrderID),
                'status_start'=>1,
                'status_end' => 0,
                'created'=>date("Y-m-d H:i:s")
            );
    		$insert_pay_status = $this->All->insert_template($data_fldsd, "flight_payment_status");
    		$insert_pay_id_update = $this->db->insert_id();
        }

		$data_fields = array(
			"bookOrderID" 			 => $bookOrderID,
			"TM_MCode" 	  		 	 => $this->input->post("TM_MCode"),
			"TM_RefNo" 	  			 => $this->input->post("TM_RefNo"),
			"TM_Currency" 	  		 => $this->input->post("TM_Currency"),
			"TM_PaymentType" 	  	 => $this->input->post("TM_PaymentType"),
			"TM_Status" 	  		 => $this->input->post("TM_Status"),
			"TM_Error" 	  			 => $this->input->post("TM_Error"),
			"TM_ErrorMsg" 	  		 => $this->input->post("TM_ErrorMsg"),
			"TM_ApprovalCode" 	  	 => $this->input->post("TM_ApprovalCode"),
			"TM_BankRespCode" 	  	 => $this->input->post("TM_BankRespCode"),
			"TM_TrnType" 	  		 => $this->input->post("TM_TrnType"),
			"TM_SubTrnType" 	  	 => $this->input->post("TM_SubTrnType"),
			"TM_CCLast4Digit" 	  	 => $this->input->post("TM_CCLast4Digit"),
			"TM_ExpiryDate" 	  	 => $this->input->post("TM_ExpiryDate"),
			"TM_CCNum" 	  			 => $this->input->post("TM_CCNum"),
			"TM_RecurrentId" 	  	 => $this->input->post("TM_RecurrentId"),
			"TM_SubSequentMCode" 	 => $this->input->post("TM_SubSequentMCode"),
			"TM_UserField1" 	  	 => $this->input->post("TM_UserField1"),
			"TM_UserField2" 	  	 => $this->input->post("TM_UserField2"),
			"TM_UserField3" 	  	 => $this->input->post("TM_UserField3"),
			"TM_UserField4" 	  	 => $this->input->post("TM_UserField4"),
			"TM_UserField5" 	  	 => $this->input->post("TM_UserField5"),
			"TM_IPP_FirstPayment" 	 => $this->input->post("TM_IPP_FirstPayment"),
			"TM_IPP_LastPayment" 	 => $this->input->post("TM_IPP_LastPayment"),
			"TM_IPP_MonthlyPayment"  => $this->input->post("TM_IPP_MonthlyPayment"),
			"TM_IPP_TransTenure" 	 => $this->input->post("TM_IPP_TransTenure"),
			"TM_IPP_TotalInterest" 	 => $this->input->post("TM_IPP_TotalInterest"),
			"TM_IPP_DownPayment" 	 => $this->input->post("TM_IPP_DownPayment"),
			"TM_IPP_MonthlyInterest" => $this->input->post("TM_IPP_MonthlyInterest"),
			"TM_TokenId" 	  		 => $this->input->post("TM_TokenId"),
			"TM_Version" 	  		 => $this->input->post("TM_Version"),
			"TM_Signature" 	  		 => $this->input->post("TM_Signature"),
			"TM_ECI" 	  			 => $this->input->post("TM_ECI"),
			"TM_CAVV" 	  		 	 => $this->input->post("TM_CAVV"),
			"TM_XID" 	  			 => $this->input->post("TM_XID"),
			"TM_Original_RefNo" 	 => $this->input->post("TM_Original_RefNo"),
			"TM_OriginalPayType" 	 => $this->input->post("TM_OriginalPayType"),
			"created" 	  			 => date("Y-m-d H:i:s"),
			"modified" 	  			 => date("Y-m-d H:i:s")
		);
		$insert_hotel_payment_reference = $this->All->insert_template($data_fields, "payment_reference");
		$last_paymentRefID = $this->db->insert_id();

        if($this->session->userdata('shoppingCartFlightCookie') == TRUE) {
    		$data_fldup = array(
    			"status_end"   => 1,
    			"paymentrefid" => $last_paymentRefID
    		);
    		$update1 = $this->All->update_template($data_fldup, "id", $insert_pay_id_update, "flight_payment_status");
        }
		$txt  = "[".date("Y-m-d H:i:s")."] [PaymentProcess]".$bookOrderID."; ID:".$insert_pay_id_update.";PayRefID : ".$last_paymentRefID." End;\n\n";

        //log file
        $filepayment = fopen("/var/www/html/ctctravel.org/fit/assets/api-logs/log_payment.txt", "a") or die("Unable to open file!");
        // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
        fwrite($filepayment, "\n". $txt);
        fclose($filepayment);

		//
		$checks = $this->All->select_template("id", $last_paymentRefID, "payment_reference");
		if( $checks == TRUE ) {
			foreach( $checks AS $check ) {
				$tmStatus = $check->TM_Status;
			}
			if( $tmStatus == "YES" ) {
				if( $this->session->userdata('normal_session_id') == TRUE ) {

					//minus quantity landtour and send email
				 	$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
				 	$check_res  = mysqli_query(
				 		$connection,
				 		"SELECT * FROM landtour_history_order WHERE landtour_confirmedBookOrder_ID = ".$confirmedBookOrderID
					);
					if( mysqli_num_rows($check_res) > 0 ) {
						$a = 0;
						while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
							if( $check_row["sellingType"] == "ticket" ) {
								//new code here
								if( $check_row["paxDetails"] != NULL ) {
									$explodePaxs = explode("~", $check_row["paxDetails"]);
									//Get stock quantity
									$ltRes = mysqli_query(
								 		$connection,
								 		"
								 			SELECT * FROM landtour_system_prices
								 			WHERE landtour_product_id = ".$check_row["landtour_product_id"]."
								 			AND DATE(price_date) = '".$check_row["selected_date"]."'
								 		"
									);
									$ltRow = mysqli_fetch_array($ltRes, MYSQL_ASSOC);
									$ticketAdultQty = $ltRow["ticketAdultQty"];
									$ticketChildQty = $ltRow["ticketChildQty"];
									//End of get stock quantity
									//update adult qty and child qty
									$data_fields = array(
										"ticketAdultQty" => $ticketAdultQty-$explodePaxs[0],
										"ticketChildQty" => $ticketChildQty-$explodePaxs[1],
										"modified"     	 => date("Y-m-d H:i:s")
									);
									$updateQTY = $this->All->update_template_two(
										$data_fields,
										"landtour_product_id", $check_row["landtour_product_id"],
										"price_date", $check_row["selected_date"],
										"landtour_system_prices"
									);
									//end of update adult qty and child qty
								}
								//end of new code here
							}
							else if( $check_row["sellingType"] == "room" ) {
								//new code here
								if( $check_row["paxDetails"] != NULL ) {
									//Get stock quantity
									$ltRes = mysqli_query(
								 		$connection,
								 		"
								 			SELECT * FROM landtour_system_prices
								 			WHERE landtour_product_id = ".$check_row["landtour_product_id"]."
								 			AND DATE(price_date) = '".$check_row["selected_date"]."'
								 		"
									);
									$ltRow = mysqli_fetch_array($ltRes, MYSQL_ASSOC);
									$stockQty = $ltRow["roomQuantity"];
									//End of get stock quantity
									//update quantity adult price
									$data_fields = array(
										"roomQuantity" => $stockQty-$check_row["countRoom"],
										"modified"     => date("Y-m-d H:i:s")
									);
									$updateQTY = $this->All->update_template_two(
										$data_fields,
										"landtour_product_id", $check_row["landtour_product_id"],
										"price_date", $check_row["selected_date"],
										"landtour_system_prices"
									);
									//end of update quantity adult price
								}
								//end of new code here
							}
						}
					}
					//end of minus quantity landtour and send email

					//minus quantity
					$arrayContent = array();
				 	$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
				 	$check_res  = mysqli_query(
				 		$connection,
				 		"
				 			SELECT stateroomID, cruiseTitleID, brandID, shipID, COUNT(*) AS countStateroom FROM cruise_cart
				 			WHERE user_access_id = ".$this->session->userdata('normal_session_id')."
				 			GROUP BY cruiseTitleID, stateroomID
				 		"
					);
					if( mysqli_num_rows($check_res) > 0 ) {
						$a = 0;
						while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
							//available quantity
							$qtyRes = mysqli_query(
						 		$connection,
						 		"
						 			SELECT * FROM cruise_title_stateroom_qty
						 			WHERE cruise_title_id = ".$check_row["cruiseTitleID"]."
						 			AND stateroom_id = ".$check_row["stateroomID"]."
						 		"
							);
							$qtyRow = mysqli_fetch_array($qtyRes, MYSQL_ASSOC);
							$stateRoomQTY = $qtyRow["quantity"];
							//end of available quantity
							//update quantity stateroom available
							$data_fields = array(
								"quantity" => $stateRoomQTY-$check_row["countStateroom"],
								"modified" => date("Y-m-d H:i:s")
							);
							$updateQTY = $this->All->update_template_four(
								$data_fields,
								"cruise_title_id", 	$check_row["cruiseTitleID"],
								"cruise_ship_id", 	$check_row["shipID"],
								"cruise_brand_id", 	$check_row["brandID"],
								"stateroom_id", 	$check_row["stateroomID"],
								"cruise_title_stateroom_qty"
							);
							//end of update quantity stateroom available
						}

					}
					//end of minus quantity

					//send hotel request to GTA
					$requests = $this->All->select_template("bookingRefID", $bookOrderID, "hotel_historyOder");
					if( $requests == TRUE ) {
						$passengers = $this->All->select_template("bookOrderID", $bookOrderID, "contact_person_information");
						foreach( $passengers AS $passenger ) {
							$contactPersonName = $passenger->cp_title." ".$passenger->cp_fullname;
						}
						$totalPrices = $this->All->select_template("BookingOrderID", $bookOrderID, "confirmedBookOrder");
						foreach( $totalPrices AS $totalPrice ) {
							$grandTotalPrice = $totalPrice->granTotalPrice;
						}
						$this->All->insert_addNewBooking($bookOrderID);
					}
					//end of send hotel request to GTA

					//send email
					$userEmailAddress    = $this->All->getEmailContactPurchaseInfo($bookOrderID);
					$data["bookRefID"]   = $bookOrderID;
					$data["dateCreated"] = date("Y F d");

					/*** CHECKK for food type */

					$html = $this->load->view('voucher/final', $data, true);
					$messageContent = $this->load->view('voucher/email_message', '', true);
					$pdfFilePath = $this->instanceurl."assets/final_pdf/".$bookOrderID.".pdf";
					$this->load->library('m_pdf');
					$this->m_pdf->pdf->WriteHTML($html);
					$save_as = $this->m_pdf->pdf->Output($pdfFilePath, "F");
					$attachment = chunk_split(base64_encode($save_as));
			        $this->load->library('email');
			        $config = array(
						'charset'  => 'utf-8',
						'wordwrap' => TRUE,
						'mailtype' => 'html'
					);
					$this->email->initialize($config);
					$this->email->from('info@ctc.com.sg', 'CTC Travel');
                    $this->email->to($userEmailAddress);
					$this->email->bcc('fandyfandry@gmail.com, junyao.shi@ctc.com.sg, gary.tan@ctc.com.sg, sylvia.tan@ctc.com.sg, cindy.yan@ctc.com.sg');
					$this->email->subject('CTC Pax Statement');
					$this->email->message($messageContent);
					$this->email->attach($pdfFilePath);
					$this->email->send();
					//end of send email

				}
				else {
					//minus quantity landtour
				 	$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
				 	$check_res  = mysqli_query(
				 		$connection,
				 		"SELECT * FROM landtour_history_order WHERE landtour_confirmedBookOrder_ID = ".$confirmedBookOrderID
					);
					if( mysqli_num_rows($check_res) > 0 ) {
						$a = 0;
						while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
							if( $check_row["sellingType"] == "ticket" ) {
								//new code here
								if( $check_row["paxDetails"] != NULL ) {
									$explodePaxs = explode("~", $check_row["paxDetails"]);
									//Get stock quantity
									$ltRes = mysqli_query(
								 		$connection,
								 		"
								 			SELECT * FROM landtour_system_prices
								 			WHERE landtour_product_id = ".$check_row["landtour_product_id"]."
								 			AND DATE(price_date) = '".$check_row["selected_date"]."'
								 		"
									);
									$ltRow = mysqli_fetch_array($ltRes, MYSQL_ASSOC);
									$ticketAdultQty = $ltRow["ticketAdultQty"];
									$ticketChildQty = $ltRow["ticketChildQty"];
									//End of get stock quantity
									//update adult qty and child qty
									$data_fields = array(
										"ticketAdultQty" => $ticketAdultQty-$explodePaxs[0],
										"ticketChildQty" => $ticketChildQty-$explodePaxs[1],
										"modified"     	 => date("Y-m-d H:i:s")
									);
									$updateQTY = $this->All->update_template_two(
										$data_fields,
										"landtour_product_id", $check_row["landtour_product_id"],
										"price_date", $check_row["selected_date"],
										"landtour_system_prices"
									);
									//end of update adult qty and child qty
								}
								//end of new code here
							}
							else if( $check_row["sellingType"] == "room" ) {
								//new code here
								if( $check_row["paxDetails"] != NULL ) {
									//Get stock quantity
									$ltRes = mysqli_query(
								 		$connection,
								 		"
								 			SELECT * FROM landtour_system_prices
								 			WHERE landtour_product_id = ".$check_row["landtour_product_id"]."
								 			AND DATE(price_date) = '".$check_row["selected_date"]."'
								 		"
									);
									$ltRow = mysqli_fetch_array($ltRes, MYSQL_ASSOC);
									$stockQty = $ltRow["roomQuantity"];
									//End of get stock quantity
									//update quantity adult price
									$data_fields = array(
										"roomQuantity" => $stockQty-$check_row["countRoom"],
										"modified"     => date("Y-m-d H:i:s")
									);
									$updateQTY = $this->All->update_template_two(
										$data_fields,
										"landtour_product_id", $check_row["landtour_product_id"],
										"price_date", $check_row["selected_date"],
										"landtour_system_prices"
									);
									//end of update quantity adult price
								}
								//end of new code here
							}
						}
					}
					//end of minus quantity landtour

					//minus quantity cruise
					$arrayContent = array();
				 	$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
				 	$check_res  = mysqli_query(
				 		$connection,
				 		"
				 			SELECT stateroomID, cruiseTitleID, brandID, shipID, COUNT(*) AS countStateroom FROM cruise_historyOrder
				 			WHERE cruise_confirmedBookOrder_ID = ".$confirmedBookOrderID."
				 			GROUP BY cruiseTitleID, stateroomID
				 		"
					);
					if( mysqli_num_rows($check_res) > 0 ) {
						$a = 0;
						while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
							//available quantity
							$qtyRes = mysqli_query(
						 		$connection,
						 		"
						 			SELECT * FROM cruise_title_stateroom_qty
						 			WHERE cruise_title_id = ".$check_row["cruiseTitleID"]."
						 			AND stateroom_id = ".$check_row["stateroomID"]."
						 		"
							);
							$qtyRow = mysqli_fetch_array($qtyRes, MYSQL_ASSOC);
							$stateRoomQTY = $qtyRow["quantity"];
							//end of available quantity
							//update quantity stateroom available
							$data_fields = array(
								"quantity" => $stateRoomQTY-$check_row["countStateroom"],
								"modified" => date("Y-m-d H:i:s")
							);
							$updateQTY = $this->All->update_template_four(
								$data_fields,
								"cruise_title_id", 	$check_row["cruiseTitleID"],
								"cruise_ship_id", 	$check_row["shipID"],
								"cruise_brand_id", 	$check_row["brandID"],
								"stateroom_id", 	$check_row["stateroomID"],
								"cruise_title_stateroom_qty"
							);
							//end of update quantity stateroom available
						}
					}
					//end of minus quantity cruise

					//send hotel request to GTA
					$requests = $this->All->select_template("bookingRefID", $bookOrderID, "hotel_historyOder");
					if( $requests == TRUE ) {
						$passengers = $this->All->select_template("bookOrderID", $bookOrderID, "contact_person_information");
						foreach( $passengers AS $passenger ) {
							$contactPersonName = $passenger->cp_title." ".$passenger->cp_fullname;
						}
						$totalPrices = $this->All->select_template("BookingOrderID", $bookOrderID, "confirmedBookOrder");
						foreach( $totalPrices AS $totalPrice ) {
							$grandTotalPrice = $totalPrice->granTotalPrice;
						}
						$this->All->insert_addNewBooking($bookOrderID);
					}

					//end of send hotel request to GTA

					//send email
					$userEmailAddress    = $this->All->getEmailContactPurchaseInfo($bookOrderID);
					$data["bookRefID"]   = $bookOrderID;
					$data["dateCreated"] = date("Y F d");
					$html = $this->load->view('voucher/final', $data, true);
					$messageContent = $this->load->view('voucher/email_message', '', true);
					$pdfFilePath = $this->instanceurl."assets/final_pdf/".$bookOrderID.".pdf";
					$this->load->library('m_pdf');
					$this->m_pdf->pdf->WriteHTML($html);
					$save_as = $this->m_pdf->pdf->Output($pdfFilePath, "F");
					$attachment = chunk_split(base64_encode($save_as));
			        $this->load->library('email');
			        $config = array(
						'charset'  => 'utf-8',
						'wordwrap' => TRUE,
						'mailtype' => 'html'
					);
					$this->email->initialize($config);
					$this->email->from('info@ctc.com.sg', 'CTC Travel');
					$this->email->to($userEmailAddress);
					$this->email->bcc('fandyfandry@gmail.com, junyao.shi@ctc.com.sg, gary.tan@ctc.com.sg, sylvia.tan@ctc.com.sg, cindy.yan@ctc.com.sg');
					$this->email->subject('CTC Pax Statement');
					$this->email->message($messageContent);
					$this->email->attach($pdfFilePath);
					$this->email->send();
					//end of send email

				}
			}
			else {

				//details
				$confirmedBookings = $this->All->select_template("BookingOrderID", $bookOrderID, "confirmedBookOrder");
				foreach( $confirmedBookings AS $confirmedBooking ) {
					$confirmedID = $confirmedBooking->id;
				}
				//end of details

				//upate confirmedBookingStatus - cruise
				$data_fields1 = array(
					"status"   => "FAILED",
					"modified" => date("Y-m-d H:i:s")
				);
				$update1 = $this->All->update_template($data_fields1, "BookingOrderID", $bookOrderID, "confirmedBookOrder");
				//end of upate confirmedBookingStatus - cruise

				//update cruiseOrder
				$data_fields2 = array(
					"status"   => "FAILED",
					"modified" => date("Y-m-d H:i:s")
				);
				$update2 = $this->All->update_template(
					$data_fields2, "cruise_confirmedBookOrder_ID", $confirmedID, "cruise_historyOrder"
				);
				//end of update cruiseOrder

				//update landtourOrder
				$data_fields2 = array(
					"status"   => "FAILED",
					"modified" => date("Y-m-d H:i:s")
				);
				$update2 = $this->All->update_template(
					$data_fields2, "landtour_confirmedBookOrder_ID", $confirmedID, "landtour_history_order"
				);
				//end of update landtourOrder

				//update hotelOrder
				$data_fields3 = array(
					"status"   => "FAILED",
					"modified" => date("Y-m-d H:i:s")
				);
				$update3 = $this->All->update_template(
					$data_fields3, "hotel_confirmedBookOrder_ID", $confirmedID, "hotel_historyOder"
				);
				//end of update hotelOrder

				//update flightOrder
				$data_fields4 = array(
					"status"   => "FAILED",
					"modified" => date("Y-m-d H:i:s")
				);
				$update4 = $this->All->update_template(
					$data_fields4, "flight_confirmedBookOrder_ID", $confirmedID, "flight_history_order"
				);
				//end of update flightOrder

			}
		} else {}
	}

	public function success_booked()
	{
		$bookOrderID = base64_decode(base64_decode(base64_decode($this->uri->segment(3))));
		$checks = $this->All->select_template(
			"bookOrderID", $bookOrderID, "payment_reference"
		);
		if( $checks == TRUE ) {
			foreach( $checks AS $check ) {
				$tmStatus = $check->TM_Status;
			}
			if( $tmStatus == "YES" ) {
				//clear cruiseCart & array
				$this->session->unset_userdata('shoppingCartCruiseCookie');
				$delete_cruiseCart = $this->All->delete_template(
					"user_access_id", $this->session->userdata('normal_session_id'), "cruise_cart"
				);
				//end of clear cruiseCart & array
				//clear landtourCart & array
				$this->session->unset_userdata('shoppingCartLandtourCookie');
				$delete_landtourCart = $this->All->delete_template(
					"user_access_id", $this->session->userdata('normal_session_id'), "landtour_cart"
				);
				//end of clear landtourCart & array
				//clear hotelCart & array
				$this->session->unset_userdata('shoppingCartCookie');
				$delete_hotelCart = $this->All->delete_template(
					"user_access_id", $this->session->userdata('normal_session_id'), "hotel_cart"
				);
				//end of clear hotelCart & array
				//clear flightCart & array
				$this->session->unset_userdata('shoppingCartFlightCookie');
				$delete_flightCart = $this->All->delete_template(
					"user_access_id", $this->session->userdata('normal_session_id'), "flight_cart"
				);
				//end of clear flightCart & array
			}
		} else {
			$txt  = "[".date("Y-m-d H:i:s")."] [SuccessBooked]Failed ". $bookOrderID ."!\n\n";

	        //log file
	        $filepayment = fopen("/var/www/html/ctctravel.org/fit/assets/api-logs/log_payment.txt", "a") or die("Unable to open file!");
	        fwrite($filepayment, "\n". $txt);
	        fclose($filepayment);
		}
		$this->load->view('payment_success_checkout_index');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */