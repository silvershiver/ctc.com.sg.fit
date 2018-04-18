<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

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
	
	public function testPDF()
	{
		//$data = [];
        //load the view and saved it into $html variable
        $html=$this->load->view('voucher/cruise', $data, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = "/var/www/html/ctcfitapp1/assets/pdf/output_pdf_name.pdf";
 
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
		if( $this->session->userdata('normal_session_id') == TRUE ) {
					
			/*--GENERAL LOGIC--*/
			$totalGranPrice = trim($this->input->post("hidden_grandTotalPrice"));		
			$bookingOrderID = uniqid();
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
			
			/*--Cruise payment proceed--*/
			$cruiseCarts = $this->All->select_template("user_access_id", $this->session->userdata('normal_session_id'), "cruise_cart");
			if( $cruiseCarts == TRUE ) {
				foreach( $cruiseCarts AS $cruiseCart ) {
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
					//insert adult
					$noAdult = $cruiseCart->noofAdult;
					for($a=0; $a<$noAdult; $a++) {
						$s_title 	   = $this->input->post("titleAdult".$cruiseCart->id);
						$s_name  	   = $this->input->post("nameAdult".$cruiseCart->id);
						$s_nric  	   = $this->input->post("nricAdult".$cruiseCart->id);
						$s_dobY  	   = $this->input->post("dob_yearAdult".$cruiseCart->id);
						$s_dobM  	   = $this->input->post("dob_monthAdult".$cruiseCart->id);
						$s_dobD  	   = $this->input->post("dob_dayAdult".$cruiseCart->id);
						$s_nationality = $this->input->post("nationalityAdult".$cruiseCart->id);
						$s_email   	   = $this->input->post("emailAdult".$cruiseCart->id);
						$s_contact 	   = $this->input->post("contactAdult".$cruiseCart->id);
						$s_address     = $this->input->post("address1Adult".$cruiseCart->id);
						$s_passportNo  = $this->input->post("passport_numberAdult".$cruiseCart->id);
						$s_issueY      = $this->input->post("issue_yearAdult".$cruiseCart->id);
						$s_issueM      = $this->input->post("issue_monthAdult".$cruiseCart->id);
						$s_issueD      = $this->input->post("issue_dayAdult".$cruiseCart->id);
						$s_expiryY     = $this->input->post("expiry_yearAdult".$cruiseCart->id);
						$s_expiryM     = $this->input->post("expiry_monthAdult".$cruiseCart->id);
						$s_expiryD     = $this->input->post("expiry_dayAdult".$cruiseCart->id);
						$s_remark      = $this->input->post("member_remarksAdult".$cruiseCart->id);
						if( $this->input->post("contact_personalAdult") == $cruiseCart->id ) {
							$s_cpersonal = 1;
						}
						else {
							$s_cpersonal = 0;
						}
						$data_fieldsTraveler = array(
							"bookOrderID" 		   => $bookingOrderID,
							"historyOrderID"	   => $last_historyOrderID,
							"type_adul_or_child"   => "ADULT",
							"traveler_title" 	   => trim($s_title[$a]),
							"traveler_fullname"    => trim($s_name[$a]),
							"traveler_nric" 	   => trim($s_nric[$a]),
							"traveler_dob" 		   => trim($s_dobY[$a]).'-'.trim($s_dobM[$a]).'-'.trim($s_dobD[$a]),
							"traveler_nationality" => trim($s_nationality[$a]),
							"traveler_email"       => trim($s_email[$a]),
							"traveler_contact" 	   => trim($s_contact[$a]),
							"traveler_postCode"    => "",
							"traveler_address" 	   => trim($s_address[$a]),
							"traveler_unitNo" 	   => "",
							"traveler_passportNo"  => trim($s_passportNo[$a]),
							"traveler_issueDate"   => trim($s_issueY[$a]).'-'.trim($s_issueM[$a]).'-'.trim($s_issueD[$a]),
							"traveler_expiryDate"  => trim($s_expiryY[$a]).'-'.trim($s_expiryM[$a]).'-'.trim($s_expiryD[$a]),
							"remarks" 			   => trim($s_remark[$a]),
							"contactPurchase" 	   => $s_cpersonal,
							"created" 			   => date("Y-m-d H:i:s"),
							"modified" 			   => date("Y-m-d H:i:s")
						);
						$insertTraveler = $this->All->insert_template($data_fieldsTraveler, "cruise_traverlerInfo");
					}
					//end of insert adult
					//insert child
					$noChild = $cruiseCart->noofChild;
					for($b=0; $b<$noChild; $b++) {
						$ss_title 	    = $this->input->post("titleChild".$cruiseCart->id);
						$ss_name  	    = $this->input->post("nameChild".$cruiseCart->id);
						$ss_nric  	    = $this->input->post("nricChild".$cruiseCart->id);
						$ss_dob  	    = $this->input->post("dobChild".$cruiseCart->id);
						$ss_nationality = $this->input->post("nationalityChild".$cruiseCart->id);
						$ss_email   	= $this->input->post("emailChild".$cruiseCart->id);
						$ss_contact 	= $this->input->post("contactChild".$cruiseCart->id);
						$ss_address     = $this->input->post("address1Child".$cruiseCart->id);
						$ss_passportNo  = $this->input->post("passport_numberChild".$cruiseCart->id);
						$ss_issueY      = $this->input->post("issue_yearChild".$cruiseCart->id);
						$ss_issueM      = $this->input->post("issue_monthChild".$cruiseCart->id);
						$ss_issueD      = $this->input->post("issue_dayChild".$cruiseCart->id);
						$ss_expiryY     = $this->input->post("expiry_yearChild".$cruiseCart->id);
						$ss_expiryM     = $this->input->post("expiry_monthChild".$cruiseCart->id);
						$ss_expiryD     = $this->input->post("expiry_dayChild".$cruiseCart->id);
						$ss_remark      = $this->input->post("member_remarksChild".$cruiseCart->id);
						$data_fieldsTravelerC = array(
							"bookOrderID" 		   => $bookingOrderID,
							"historyOrderID"	   => $last_historyOrderID,
							"type_adul_or_child"   => "CHILD",
							"traveler_title" 	   => trim($ss_title[$b]),
							"traveler_fullname"    => trim($ss_name[$b]),
							"traveler_nric" 	   => trim($ss_nric[$b]),
							"traveler_dob" 		   => $ss_dob[$b],
							"traveler_nationality" => trim($ss_nationality[$b]),
							"traveler_email"       => trim($ss_email[$b]),
							"traveler_contact" 	   => trim($ss_contact[$b]),
							"traveler_postCode"    => "",
							"traveler_address" 	   => trim($ss_address[$b]),
							"traveler_unitNo" 	   => "",
							"traveler_passportNo"  => trim($ss_passportNo[$b]),
							"traveler_issueDate"   => trim($ss_issueY[$b]).'-'.trim($s_issueM[$b]).'-'.trim($s_issueD[$b]),
							"traveler_expiryDate"  => trim($ss_expiryY[$b]).'-'.trim($s_expiryM[$b]).'-'.trim($s_expiryD[$b]),
							"remarks" 			   => trim($ss_remark[$b]),
							"contactPurchase" 	   => 0,
							"created" 			   => date("Y-m-d H:i:s"),
							"modified" 			   => date("Y-m-d H:i:s")
						);
						$insertTraveler = $this->All->insert_template($data_fieldsTravelerC, "cruise_traverlerInfo");
					}
					//end of insert child
				}
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
				//clear user cart
				$countCart = $this->All->getCountCart($this->session->userdata('normal_session_id'));
				//end of clear user cart
				//send email
				$userEmailAddress = $this->All->getEmailUser($bookingOrderID);
				$data["bookRefID"]    = $bookingOrderID;
				$data["userAccessID"] = $this->session->userdata('normal_session_id');
				$data["dateCreated"]  = date("Y F d");
				$html = $this->load->view('voucher/cruise', $data, true);
				$pdfFilePath = "/var/www/html/ctctravel.org/cruise/assets/pdf/".$bookingOrderID.".pdf";
				$this->load->library('m_pdf');	
				$this->m_pdf->pdf->WriteHTML($html);
				$save_as = $this->m_pdf->pdf->Output($pdfFilePath, "F");
				$attachment = chunk_split(base64_encode($save_as));       
		        $this->load->library('email');
				$this->email->from('info@ctc.com.sg', 'CTC Travel');
				$this->email->to($userEmailAddress); 
				$this->email->bcc('sylvia.tan@ctc.com.sg'); 
				$this->email->subject('Cruise Pax Statement');
				$this->email->message('Thank you for purchasing CTC Travel Cruise Deal.');
				$this->email->attach($pdfFilePath);
				$this->email->send();
				//end of send email
				$delete_cruiseCart = $this->All->delete_template(
					"user_access_id", $this->session->userdata('normal_session_id'), "cruise_cart"
				);
			}
			/*--End of Cruise payment proceed--*/
			
			/*--Hotel payment proceed--*/
			$carts = $this->All->select_template("user_access_id", $this->session->userdata('normal_session_id'), "hotel_cart");
			if( $carts == TRUE ) {
				$contact_names 	  = $this->input->post("contact_names");
				$special_requests = $this->input->post("special_requests");
				$totalGranPrice   = trim($this->input->post("hidden_grandTotalPrice"));
				$bookingOrderID = uniqid();
				$data_fields = array(
					"granTotalPrice" => $totalGranPrice,
					"BookingOrderID" => $bookingOrderID,
					"status" 		 => "CONFIRMED",
					"user_access_id" => $this->session->userdata('normal_session_id'),
					"created" 		 => date("Y-m-d H:i:s"),
					"modified" 		 => date("Y-m-d H:i:s")
				);
				$insertConfirm = $this->All->insert_template($data_fields, "hotel_confirmedBookOrder");
				$last_insertConfirmID = $this->db->insert_id();
				foreach( $carts AS $cart ) {
					$bName 		 	= "BOOKHOTELCTC".$cart->id;
					$bRef  		 	= "BOOKHOTELCTCREF".$cart->id;
					$bDepartDate 	= $cart->check_in_date;
					$bCheckoutDate 	= $cart->check_out_date;
					$paxID1 	 	= 1;
					$paxName1 	 	= "Fandy Fandry";
					$paxID2 	 	= 2;
					$paxName2 	 	= "Immanuel Gian";
					$price		 	= trim($cart->hotel_PricePerRoom);
					$itemRef 		= $cart->id;
					$itemCityCode 	= $cart->hotel_ItemCityCode;
					$itemCode 		= $cart->hotel_ItemCode;
					$checkIn 		= $cart->check_in_date;
					$noofadult 		= $cart->hotel_AdultQuantity;
					$hotelRoomID 	= $cart->hotel_RoomTypeID;
					$doBooking = $this->All->insertNewBookingRequest(
						$bName, $bRef, $bDepartDate, $bCheckoutDate, $paxID1, $paxName1, $paxID2, $paxName2, 
						$price, $itemRef, $itemCityCode, $itemCode, $checkIn, $noofadult, $hotelRoomID
					);
					$booking_reference = $doBooking["RESPONSE"]["RESPONSEREFERENCE"];
					$data_fieldsHistory = array(
						"hotel_confirmedBookOrder_ID" => $last_insertConfirmID,
						"bookingRefID" 				  => $booking_reference,
						"hotel_Fullname" 			  => $cart->hotel_Fullname,
						"hotel_Image" 				  => $cart->hotel_Image,
						"hotel_ItemCode" 		      => $cart->hotel_ItemCode,
						"hotel_ItemCityCode" 		  => $cart->hotel_ItemCityCode,
						"hotel_PricePerRoom" 		  => $cart->hotel_PricePerRoom,
						"hotel_RoomType" 			  => $cart->hotel_RoomType,
						"hotel_RoomTypeID" 			  => $cart->hotel_RoomTypeID,
						"hotel_RoomQuantity" 		  => $cart->hotel_RoomQuantity,
						"hotel_AdultQuantity" 		  => $cart->hotel_AdultQuantity,
						"hotel_ChildrenQuantity" 	  => $cart->hotel_ChildrenQuantity,
						"check_in_date" 			  => $cart->check_in_date,
						"check_out_date" 			  => $cart->check_out_date,
						"duration" 					  => $cart->duration,
						"user_access_id" 			  => $this->session->userdata('normal_session_id'),
						"contactPerson_name" 		  => $contact_names[$cart->id],
						"special_request" 			  => $special_requests[$cart->id],
						"created" 					  => date("Y-m-d H:i:s"),
						"modified" 					  => date("Y-m-d H:i:s")
					);
					$insertHistoryOrder = $this->All->insert_template($data_fieldsHistory, "hotel_historyOder");
				}
			}
			/*--End of Hotel payment proceed--*/
			
			//for live
			$ref = uniqid();
			$signature = hash('sha512',$totalGranPrice.$ref."SGD107201335038LrYIiO7krQ");
			
			//session and redirect
			/*--LIVE--*/
			redirect("https://securepayments.telemoneyworld.com/easypay2/paymentpage.do?mid=107201335038&ref=".$ref."&amt=".$totalGranPrice."&cur=SGD&rcard=64&returnurl=".base_url()."payment/success_booked/".base64_encode(base64_encode(base64_encode($bookingOrderID)))."&statusurl=".base_url()."payment/statusURLindex123/".$bookingOrderID."&transtype=sale&validity=".date("Y-m-d-H:i:s", mktime(date("H")+8,date("i")+15,date("s"),date("m"),date("d"),date("Y")))."&version=2&signature=".$signature."");
			/*--END OF LIVE--*/
			/*--TESTING--*/
			//redirect("https://test.wirecard.com.sg/easypay2/paymentpage.do?mid=20131113001&ref=".uniqid()."&amt=".$totalGranPrice."&cur=SGD&rcard=64&returnurl=".base_url()."payment/success_booked/".base64_encode(base64_encode(base64_encode($bookingOrderID)))."&statusurl=".base_url()."payment/statusURLindex123/".$bookingOrderID."&paytype=3&transtype=auth&ccnum=4111111111111111&ccdate=1611&cccvv=898&validity=2016-11-01-11:22:33");
			/*--END OF TESTING--*/
			//end of session and redirect
			
		}
		else {
			
			/*--INITIATE CRUISE SESSION ARRAY--*/
			$arrayCruise 	  = $this->session->userdata('shoppingCartCruiseCookie');
			$arrayCruiseCount = count($arrayCruise);
			$totalGranPrice   = trim($this->input->post("hidden_grandTotalPrice"));		
			$bookingOrderID   = uniqid();
			/*--END OF INITIATE CRUISE SESSION ARRAY--*/
			
			/*--INSERT INTO USER_ACCESS IF ANY--*/
			$contactPurchasePerson = $this->input->post("contact_personalAdult");
			$aa 		   = explode("-", $contactPurchasePerson);
			$countConnect  = $aa[0];
			$uniqueID 	   = $aa[1];
			$title 		   = $this->input->post("titleAdult".$uniqueID);
			$first_name    = $this->input->post("nameAdult".$uniqueID);
			$admin_contact = $this->input->post("contactAdult".$uniqueID);
			$admin_address = $this->input->post("address1Adult".$uniqueID);
			$email_address = $this->input->post("emailAdult".$uniqueID);
			$dob 		   = $this->input->post("dobAdult".$uniqueID);
			$nric 		   = $this->input->post("nricAdult".$uniqueID);
			$nationality   = $this->input->post("nationalityAdult".$uniqueID);
			$passport_no   = $this->input->post("passport_numberAdult".$uniqueID);
			$issue_date    = $this->input->post("issuePassportAdult".$uniqueID);
			$expiry_date   = $this->input->post("expiryPassportAdult".$uniqueID);
			$checkUsers = $this->All->select_template(
				"email_address", $email_address[$countConnect], "user_access"
			);
			if( $checkUsers == TRUE ) {
				foreach( $checkUsers AS $checkUser ) {
					$user_access_id = $checkUser->id;
				}
				$data_fields = array(
					"title"				=> $title[$countConnect],
					"first_name" 		=> $first_name[$countConnect],
					"last_name" 		=> "",
					"admin_full_name" 	=> "",
					"admin_contact" 	=> $admin_contact[$countConnect],
					"admin_address" 	=> $admin_address[$countConnect],
					"email_address" 	=> $email_address[$countConnect],
					"dob"				=> $dob[$countConnect],
					"nric"				=> $nric[$countConnect],
					"nationality"		=> $nationality[$countConnect],
					"passport_no"		=> $passport_no[$countConnect],
					"issue_date"		=> $issue_date[$countConnect],
					"expiry_date"		=> $expiry_date[$countConnect],
					"modified" 			=> date("Y-m-d H:i:s")
				);
				$insertUserAccess = $this->All->update_template($data_fields, "id", $user_access_id, "user_access");
				$userAccessID = $user_access_id;
			}
			else {
				$data_fieldsUser = array(
					"title"				=> $title[$countConnect],
					"first_name" 		=> $first_name[$countConnect],
					"last_name" 		=> "",
					"admin_full_name" 	=> "",
					"admin_contact" 	=> $admin_contact[$countConnect],
					"admin_address" 	=> $admin_address[$countConnect],
					"email_address" 	=> $email_address[$countConnect],
					"password" 			=> sha1(SHA1_VAR.$email_address[$countConnect]),
					"dob"				=> $dob[$countConnect],
					"nric"				=> $nric[$countConnect],
					"nationality"		=> $nationality[$countConnect],
					"passport_no"		=> $passport_no[$countConnect],
					"issue_date"		=> $issue_date[$countConnect],
					"expiry_date"		=> $expiry_date[$countConnect],
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
			/*--END OF INSERT INTO USER_ACCESS IF ANY--*/
			
			/*--GENERAL LOGIC--*/
			$data_fields = array(
				"granTotalPrice" => $totalGranPrice,
				"BookingOrderID" => $bookingOrderID,
				"status" 		 => "CONFIRMED",
				"user_access_id" => $userAccessID,
				"created" 		 => date("Y-m-d H:i:s"),
				"modified" 		 => date("Y-m-d H:i:s")
			);
			$insertConfirm = $this->All->insert_template($data_fields, "confirmedBookOrder");
			$last_insertConfirmID = $this->db->insert_id();
			/*--END OF GENERAL LOGIC--*/
			
			/*--INSERT INTO CART AND TRAVELLER INFO--*/
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
				//insert adult record
				$noAdult = $arrayCruise[$ca]["noofAdult"];
				for($a=0; $a<$noAdult; $a++) {
					$s_title 	   = $this->input->post("titleAdult".$arrayCruise[$ca]["uniqueID"]);
					$s_name  	   = $this->input->post("nameAdult".$arrayCruise[$ca]["uniqueID"]);
					$s_nric  	   = $this->input->post("nricAdult".$arrayCruise[$ca]["uniqueID"]);
					$s_dob  	   = $this->input->post("dobAdult".$arrayCruise[$ca]["uniqueID"]);
					$s_nationality = $this->input->post("nationalityAdult".$arrayCruise[$ca]["uniqueID"]);
					$s_email   	   = $this->input->post("emailAdult".$arrayCruise[$ca]["uniqueID"]);
					$s_contact 	   = $this->input->post("contactAdult".$arrayCruise[$ca]["uniqueID"]);
					$s_address     = $this->input->post("address1Adult".$arrayCruise[$ca]["uniqueID"]);
					$s_passportNo  = $this->input->post("passport_numberAdult".$arrayCruise[$ca]["uniqueID"]);
					$s_issue       = $this->input->post("issuePassportAdult".$arrayCruise[$ca]["uniqueID"]);
					$s_expiry      = $this->input->post("expiryPassportAdult".$arrayCruise[$ca]["uniqueID"]);
					$s_remark      = $this->input->post("member_remarksAdult".$arrayCruise[$ca]["uniqueID"]);
					if( $this->input->post("contact_personalAdult") == $ca ) {
						$s_cpersonal = 1;
					}
					else {
						$s_cpersonal = 0;
					}
					$data_fieldsTraveler = array(
						"bookOrderID" 		   => $bookingOrderID,
						"historyOrderID"	   => $last_historyOrderID,
						"type_adul_or_child"   => "ADULT",
						"traveler_title" 	   => trim($s_title[$a]),
						"traveler_fullname"    => trim($s_name[$a]),
						"traveler_nric" 	   => trim($s_nric[$a]),
						"traveler_dob" 		   => trim($s_dob[$a]),
						"traveler_nationality" => trim($s_nationality[$a]),
						"traveler_email"       => trim($s_email[$a]),
						"traveler_contact" 	   => trim($s_contact[$a]),
						"traveler_address" 	   => trim($s_address[$a]),
						"traveler_passportNo"  => trim($s_passportNo[$a]),
						"traveler_issueDate"   => trim($s_issue[$a]),
						"traveler_expiryDate"  => trim($s_expiry[$a]),
						"remarks" 			   => trim($s_remark[$a]),
						"contactPurchase"	   => $s_cpersonal,
						"created" 			   => date("Y-m-d H:i:s"),
						"modified" 			   => date("Y-m-d H:i:s")
					);
					$insertTraveler = $this->All->insert_template($data_fieldsTraveler, "cruise_traverlerInfo");
				}
				//end of insert adult record
				//insert child record
				$noChild = $arrayCruise[$ca]["noofChild"];
				for($b=0; $b<$noChild; $b++) {
					$ss_title 	    = $this->input->post("titleChild".$arrayCruise[$ca]["uniqueID"]);
					$ss_name  	    = $this->input->post("nameChild".$arrayCruise[$ca]["uniqueID"]);
					$ss_nric  	    = $this->input->post("nricChild".$arrayCruise[$ca]["uniqueID"]);
					$ss_dob  	    = $this->input->post("dobChild".$arrayCruise[$ca]["uniqueID"]);
					$ss_nationality = $this->input->post("nationalityChild".$arrayCruise[$ca]["uniqueID"]);
					$ss_email   	= $this->input->post("emailChild".$arrayCruise[$ca]["uniqueID"]);
					$ss_contact 	= $this->input->post("contactChild".$arrayCruise[$ca]["uniqueID"]);
					$ss_address     = $this->input->post("address1Child".$arrayCruise[$ca]["uniqueID"]);
					$ss_passportNo  = $this->input->post("passport_numberChild".$arrayCruise[$ca]["uniqueID"]);
					$ss_issue       = $this->input->post("issuePassportChild".$arrayCruise[$ca]["uniqueID"]);
					$ss_expiry      = $this->input->post("expiryPassportChild".$arrayCruise[$ca]["uniqueID"]);
					$ss_remark      = $this->input->post("member_remarksChild".$arrayCruise[$ca]["uniqueID"]);
					$data_fieldsTravelerC = array(
						"bookOrderID" 		   => $bookingOrderID,
						"historyOrderID"	   => $last_historyOrderID,
						"type_adul_or_child"   => "CHILD",
						"traveler_title" 	   => trim($ss_title[$b]),
						"traveler_fullname"    => trim($ss_name[$b]),
						"traveler_nric" 	   => trim($ss_nric[$b]),
						"traveler_dob" 		   => $ss_dob[$b],
						"traveler_nationality" => trim($ss_nationality[$b]),
						"traveler_email"       => trim($ss_email[$b]),
						"traveler_contact" 	   => trim($ss_contact[$b]),
						"traveler_address" 	   => trim($ss_address[$b]),
						"traveler_passportNo"  => trim($ss_passportNo[$b]),
						"traveler_issueDate"   => trim($ss_issue[$b]),
						"traveler_expiryDate"  => trim($ss_expiry[$b]),
						"remarks" 			   => trim($ss_remark[$b]),
						"created" 			   => date("Y-m-d H:i:s"),
						"modified" 			   => date("Y-m-d H:i:s")
					);
					$insertTraveler = $this->All->insert_template($data_fieldsTravelerC, "cruise_traverlerInfo");
				}
				//end of insert child record
			}
			/*--END OF INSERT INTO CART AND TRAVELLER INFO--*/
			
			/*--MINUS QUANTITY--*/
			$array1 = $arrayCruise;
			$array = array_map(function($element) {
	        	return $element['stateroomID'].":".$element['cruiseTitleID'];
	        }, $array1);
			$array2 = (array_count_values($array));
			foreach( $array2 AS $key => $value ) {
				$explode = explode(":", $key);
				//available quantity
				$qtyRes = mysqli_query(
			 		$connection,
			 		"
			 			SELECT * FROM cruise_title_stateroom_qty WHERE cruise_title_id = ".$explode[1]." 
			 			AND stateroom_id = ".$explode[0]."
			 		"
				);
				$qtyRow = mysqli_fetch_array($qtyRes, MYSQL_ASSOC);
				$stateRoomQTY = $qtyRow["quantity"];
				//end of available quantity
				//update quantity stateroom available
				$data_fields = array(
					"quantity" => $stateRoomQTY-$value,
					"modified" => date("Y-m-d H:i:s")
				);
				$updateQTY = $this->All->update_template_two(
					$data_fields, 
					"cruise_title_id", 	$explode[1],
					"stateroom_id", 	$explode[0],
					"cruise_title_stateroom_qty"
				);
				//end of update quantity stateroom available
			}
			/*--END OF MINUS QUANTITY--*/
			
			//CLEAR USER CART
			$countCart = $this->All->getCountCart($userAccessID);
			//END OF CLEAR USER CART
			
			//send email
			$userEmailAddress = $this->All->getEmailUser($bookingOrderID);
			$data["bookRefID"]    = $bookingOrderID;
			$data["userAccessID"] = $userAccessID;
			$data["dateCreated"]  = date("Y F d");
			$html = $this->load->view('voucher/cruise', $data, true);
			$pdfFilePath = "/var/www/html/ctctravel.org/cruise/assets/pdf/".$bookingOrderID.".pdf";
			$this->load->library('m_pdf');	
			$this->m_pdf->pdf->WriteHTML($html);
			$save_as = $this->m_pdf->pdf->Output($pdfFilePath, "F");
			$attachment = chunk_split(base64_encode($save_as));       
	        $this->load->library('email');
			$this->email->from('info@ctc.com.sg', 'CTC Travel');
			$this->email->to($userEmailAddress);
			$this->email->bcc('sylvia.tan@ctc.com.sg'); 
			$this->email->subject('Cruise Pax Statement');
			$this->email->message('Thank you for purchasing CTC Travel Cruise Deal.');
			$this->email->attach($pdfFilePath);
			$this->email->send();
			//end of send email
			$delete_cruiseCart = $this->All->delete_template("user_access_id", $userAccessID, "cruise_cart");
			$this->session->unset_userdata('shoppingCartCruiseCookie');
			/*--END OF MINUS QUANTITY--*/
			
			//for live
			$ref = uniqid();
			$signature = hash('sha512',$totalGranPrice.$ref."SGD107201335038LrYIiO7krQ");
			
			//session and redirect
			/*--LIVE--*/
			redirect("https://securepayments.telemoneyworld.com/easypay2/paymentpage.do?mid=107201335038&ref=".$ref."&amt=".$totalGranPrice."&cur=SGD&rcard=64&returnurl=".base_url()."payment/success_booked/".base64_encode(base64_encode(base64_encode($bookingOrderID)))."&statusurl=".base_url()."payment/statusURLindex123/".$bookingOrderID."&transtype=sale&validity=".date("Y-m-d-H:i:s", mktime(date("H")+8,date("i")+15,date("s"),date("m"),date("d"),date("Y")))."&version=2&signature=".$signature."");
			/*--END OF LIVE--*/
			
			//session and redirect
			/*
			redirect("https://test.wirecard.com.sg/easypay2/paymentpage.do?mid=20131113001&ref=".uniqid()."&amt=".$totalGranPrice."&cur=SGD&rcard=64&returnurl=".base_url()."payment/success_booked/".base64_encode(base64_encode(base64_encode($bookingOrderID)))."&statusurl=http://54.251.177.123/ctcfitapp1/payment/statusURLindex123/".$bookingOrderID."&paytype=3&transtype=auth&ccnum=4111111111111111&ccdate=1611&cccvv=898&validity=2016-11-01-11:22:33");
			*/
			//end of session and redirect
			
		}
	}
	
	public function statusURLindex123()
	{
		$bookOrderID = $this->uri->segment(3);
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
	}
	
	public function success_booked()
	{
		$this->load->view('payment_success_checkout_index');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */