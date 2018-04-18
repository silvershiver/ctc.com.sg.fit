<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends My_Controller {

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
	public function index()
	{
		$this->load->view('cart_index');
	}

	public function update_item_cart_session()
	{
		$x_id 		  = $this->input->post("hidden_x_id");
		$duration_day = $this->input->post("hidden_duration_day");
		$noofRoom 	  = $this->input->post("hidden_noofRoom");
		$arrayCart    = $this->session->userdata('shoppingCartCookie');
		$arrayCart[$x_id]['checkoutDate'] = date("Y-m-d", strtotime($arrayCart[$x_id]['checkinDate']."+$duration_day day"));
		$arrayCart[$x_id]['noofRoom'] 	  = $noofRoom;
		$arrayCart[$x_id]['duration_day'] = $duration_day;
		$this->session->set_userdata('shoppingCartCookie', $arrayCart);
		redirect("cart/index");
	}

	public function cruise_update_item_cart()
	{
		$hidden_cruiseCartID = $this->input->post("hidden_cruiseCartID");
		$cruiseNoPax 	     = $this->input->post("cruiseNoPax");
		$data_fields = array(
			"noofPax"  => $cruiseNoPax,
			"modified" => date("Y-m-d H:i:s")
		);
		$updateCruiseCart = $this->All->update_template($data_fields, "id", $hidden_cruiseCartID, "cruise_cart");
		//session and redirect
		$this->session->set_flashdata(
			'updateCruiseCart',
			'<article class="full-width">
				<div style="text-align:center; color:green; padding:15px; font-size:16px">
					Your cart has been updated
				</div>
			</article>'
		);
		redirect("cart/index#cruises_cart");
		//end of session and redirect
	}

	public function hotel_update_item_cart()
	{
		$cart_id 	   = $this->input->post("hidden_hotel_cart_id");
		$duration_day  = $this->input->post("hidden_duration_day");
		$noofRoom 	   = $this->input->post("hidden_noofRoom");
		$checkin_date  = $this->input->post("hidden_hotel_cart_checkin_date");
		$checkout_date = date("Y-m-d", strtotime($checkin_date."+$duration_day day"));
		$data_fields = array(
			"check_out_date" 	 => $checkout_date,
			"hotel_RoomQuantity" => $noofRoom,
			"duration" 			 => $duration_day,
			"modified" 			 => date("Y-m-d H:i:s")
		);
		$update_cart = $this->All->update_template($data_fields, "id", $cart_id, "hotel_cart");
		//session and redirect
		$this->session->set_flashdata(
			'updateHotelCart',
			'<article class="full-width">
				<div style="text-align:center; color:green; padding:15px; font-size:16px">
					Your cart has been updated
				</div>
			</article>'
		);
		redirect("cart/index");
		//end of session and redirect
	}

	public function remove_item_cart_session()
	{
		//input parameter
		$x_id = $this->uri->segment(3);
		//end of input parameter
		$arrayCart = $this->session->userdata('shoppingCartCookie');
		unset($arrayCart[$x_id]);
		$arrayCart = array_merge($arrayCart);
		$this->session->set_userdata('shoppingCartCookie', $arrayCart);
		//session and redirect
		redirect("cart/index#hotel_cart");
		//end of session and redirect
	}

	public function cruise_remove_item_cart_session()
	{
		//input parameter
		$cart_id = base64_decode(base64_decode(base64_decode($this->uri->segment(3))));
		//end of input parameter
		$arrayCart = $this->session->userdata('shoppingCartCruiseCookie');
		unset($arrayCart[$cart_id]);
		$arrayCart = array_merge($arrayCart);
		$this->session->set_userdata('shoppingCartCruiseCookie', $arrayCart);
		//session and redirect
		redirect("cart/index#cruises_cart");
		//end of session and redirect
	}

	public function cruise_remove_item_cart()
	{
		//input parameter
		$cart_id = base64_decode(base64_decode(base64_decode($this->uri->segment(3))));
		//end of input parameter
		//delete hotel cart
		$delete_hotel_cart = $this->All->delete_template("id", $cart_id, "cruise_cart");
		//end of delete hotel cart
		//session and redirect
		$this->session->set_flashdata(
			'removeCruiseCart',
			'<article class="full-width">
				<div style="text-align:center; color:green; padding:15px; font-size:16px">
					An item from cart has been removed.
				</div>
			</article>'
		);
		redirect("cart/index#cruises_cart");
		//end of session and redirect
	}

	public function landtour_remove_item_cart()
	{
		//input parameter
		$cart_id = $this->uri->segment(3);
		//end of input parameter
		$deleteCart = $this->All->delete_template("id", $cart_id, "landtour_cart");
		//session and redirect
		redirect("cart/index#landtour_cart");
		//end of session and redirect
	}

	public function landtour_remove_item_cart_session()
	{
		//input parameter
		$cart_id = $this->uri->segment(3);
		//end of input parameter
		$arrayCart = $this->session->userdata('shoppingCartLandtourCookie');
		unset($arrayCart[$cart_id]);
		$arrayCart = array_merge($arrayCart);
		$this->session->set_userdata('shoppingCartLandtourCookie', $arrayCart);
		//session and redirect
		redirect("cart/index#landtour_cart");
		//end of session and redirect
	}

	public function hotel_remove_item_cart()
	{
		//input parameter
		//$cart_id = $this->uri->segment(3);
		//end of input parameter
		//delete hotel cart
		$itemCityCode = $this->uri->segment(3);
		$itemCode = $this->uri->segment(4);
		$this->db->where('hotel_ItemCode', $itemCode);
		$this->db->where('hotel_ItemCityCode', $itemCityCode);
		$this->db->where('user_access_id', $this->session->userdata('normal_session_id'));
		$this->db->delete('hotel_cart');
		//$delete_hotel_cart = $this->All->delete_template("id", $cart_id, "hotel_cart");
		//end of delete hotel cart
		//session and redirect
		$this->session->set_flashdata(
			'removeHotelCart',
			'<article class="full-width">
				<div style="text-align:center; color:green; padding:15px; font-size:16px">
					An item from cart has been removed.
				</div>
			</article>'
		);
		redirect("cart/index#hotel_cart");
		//end of session and redirect
	}

	public function do_add_cartLandtour()
	{
		if( $this->session->userdata('normal_session_id') == TRUE ) {
			$landtourID   	   = $this->uri->segment(3);
			$lt_system_priceID = $this->uri->segment(4);
			$selectedDate 	   = $this->uri->segment(5);
			$sellingType 	   = base64_decode(base64_decode(base64_decode($this->uri->segment(6))));
			$countRoom 	  	   = $this->uri->segment(7);
			$paxDetails        = $this->uri->segment(8);
			//insert into cart
			$data_fields = array(
				"landtour_product_id" 	   => $landtourID,
				"landtour_system_price_id" => $lt_system_priceID,
				"selectedDate"   		   => $selectedDate,
				"sellingType"   		   => $sellingType,
				"countRoom"  			   => $countRoom,
				"paxDetails"		  	   => $paxDetails,
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
			$landtourID   	   = $this->uri->segment(3);
			$lt_system_priceID = $this->uri->segment(4);
			$selectedDate 	   = $this->uri->segment(5);
			$sellingType 	   = base64_decode(base64_decode(base64_decode($this->uri->segment(6))));
			$countRoom 	  	   = $this->uri->segment(7);
			$paxDetails        = $this->uri->segment(8);
			$arrayLandtourCart = $this->session->userdata('shoppingCartLandtourCookie');
			if( count($arrayLandtourCart) > 0 ) {
				$first_item = array(
					"landtour_product_id" 	   => $landtourID,
					"landtour_system_price_id" => $lt_system_priceID,
					"selectedDate"	 		   => $selectedDate,
					"sellingType"	 		   => $sellingType,
					"countRoom"  			   => $countRoom,
					"paxDetails" 			   => $paxDetails,
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
					"countRoom"  			   => $countRoom,
					"paxDetails" 			   => $paxDetails,
					"created" 		 		   => date("Y-m-d H:i:s"),
					"modified" 		 		   => date("Y-m-d H:i:s")
				);
				$cart_items[] = $first_item;
				$this->session->set_userdata('shoppingCartLandtourCookie', $cart_items);
				//session and redirect
				redirect("cart/index#landtour_cart");
				//end of session and redirect
			}
		}
	}

	public function do_add_cartCruise()
	{
		if( $this->session->userdata('normal_session_id') == TRUE ) {
			$brandID 	   = $this->uri->segment(3);
			$shipID  	   = $this->uri->segment(4);
			$cruiseTitleID = $this->uri->segment(5);
			$durationNight = $this->uri->segment(6);
			$cruiseDate    = $this->uri->segment(7);
			$stateroomID   = $this->uri->segment(8);
			$cruisePrice   = $this->uri->segment(9);
			$adult  	   = $this->uri->segment(10);
			$child   	   = $this->uri->segment(11);
			$extraPrice    = base64_decode(base64_decode(base64_decode($this->uri->segment(12))));
			$extraIDs  	   = base64_decode(base64_decode(base64_decode($this->uri->segment(13))));
			$extraPeriod   = base64_decode(base64_decode(base64_decode($this->uri->segment(14))));
			$periodType    = base64_decode(base64_decode(base64_decode($this->uri->segment(15))));
			//insert into cart
			$data_fields = array(
				"brandID"	  	  => trim($brandID),
				"shipID"	 	  => trim($shipID),
				"cruiseTitleID"   => trim($cruiseTitleID),
				"durationNight"   => trim($durationNight),
				"cruiseDate"  	  => $cruiseDate,
				"stateroomID" 	  => trim($stateroomID),
				"cruisePrice"     => trim($cruisePrice),
				"cruisePriceType" => trim($periodType),
				"extraPrice" 	  => trim($extraPrice),
				"extraIDs" 		  => trim($extraIDs),
				"extraPeriod" 	  => trim($extraPeriod),
				"noofAdult"  	  => trim($adult),
				"noofChild"  	  => trim($child),
				"user_access_id"  => $this->session->userdata('normal_session_id'),
				"created" 		  => date("Y-m-d H:i:s"),
				"modified" 		  => date("Y-m-d H:i:s")
			);
			$insertCart = $this->All->insert_template($data_fields, "cruise_cart");
			//session and redirect
			redirect("cart/index#cruises_cart");
			//end of session and redirect
		}
		else {
			$brandID 	   = $this->uri->segment(3);
			$shipID  	   = $this->uri->segment(4);
			$cruiseTitleID = $this->uri->segment(5);
			$durationNight = $this->uri->segment(6);
			$cruiseDate    = $this->uri->segment(7);
			$stateroomID   = $this->uri->segment(8);
			$cruisePrice   = $this->uri->segment(9);
			$adult  	   = $this->uri->segment(10);
			$child   	   = $this->uri->segment(11);
			$extraPrice    = base64_decode(base64_decode(base64_decode($this->uri->segment(12))));
			$extraIDs  	   = base64_decode(base64_decode(base64_decode($this->uri->segment(13))));
			$extraPeriod   = base64_decode(base64_decode(base64_decode($this->uri->segment(14))));
			$periodType    = base64_decode(base64_decode(base64_decode($this->uri->segment(15))));
			$arrayCruiseCart = $this->session->userdata('shoppingCartCruiseCookie');
			if( count($arrayCruiseCart) > 0 ) {
				$first_item = array(
					"uniqueID"		  => uniqid(),
					"brandID"	  	  => trim($brandID),
					"shipID"	 	  => trim($shipID),
					"cruiseTitleID"   => trim($cruiseTitleID),
					"durationNight"   => trim($durationNight),
					"cruiseDate"  	  => $cruiseDate,
					"stateroomID" 	  => trim($stateroomID),
					"cruisePrice"     => trim($cruisePrice),
					"cruisePriceType" => trim($periodType),
					"extraPrice" 	  => trim($extraPrice),
					"extraIDs" 		  => trim($extraIDs),
					"extraPeriod" 	  => trim($extraPeriod),
					"noofAdult"  	  => trim($adult),
					"noofChild"  	  => trim($child),
					"created" 		  => date("Y-m-d H:i:s"),
					"modified" 		  => date("Y-m-d H:i:s")
				);
				$currentItems = $this->session->userdata('shoppingCartCruiseCookie');
				$currentItems[] = $first_item;
				$this->session->set_userdata('shoppingCartCruiseCookie', $currentItems);
				//session and redirect
				redirect("cart/index#cruises_cart");
				//end of session and redirect
			}
			else {
				$first_item = array(
					"uniqueID"		  => uniqid(),
					"brandID"	  	  => trim($brandID),
					"shipID"	 	  => trim($shipID),
					"cruiseTitleID"   => trim($cruiseTitleID),
					"durationNight"   => trim($durationNight),
					"cruiseDate"  	  => $cruiseDate,
					"stateroomID" 	  => trim($stateroomID),
					"cruisePrice"     => trim($cruisePrice),
					"cruisePriceType" => trim($periodType),
					"extraPrice" 	  => trim($extraPrice),
					"extraIDs" 		  => trim($extraIDs),
					"extraPeriod" 	  => trim($extraPeriod),
					"noofAdult"  	  => trim($adult),
					"noofChild"  	  => trim($child),
					"created" 		  => date("Y-m-d H:i:s"),
					"modified" 		  => date("Y-m-d H:i:s")
				);
				$cart_items[] = $first_item;
				$this->session->set_userdata('shoppingCartCruiseCookie', $cart_items);
				//session and redirect
				redirect("cart/index#cruises_cart");
				//end of session and redirect
			}
		}
	}

	public function do_add_cartHotel()
	{
		//$this->session->unset_userdata('shoppingCartCookie');
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$itemCode 	     = base64_decode(base64_decode(base64_decode($this->input->post('itemcode'))));
			$noofRoom 	     = base64_decode(base64_decode(base64_decode($this->input->post('noofRoom'))));
			$checkinDate     = base64_decode(base64_decode(base64_decode($this->input->post('checkinDate'))));
			$hotelName       = base64_decode(base64_decode(base64_decode($this->input->post('nameHotel'))));
			$hotelImage      = base64_decode(base64_decode(base64_decode($this->input->post('hotelImage'))));
			$checkoutDate    = base64_decode(base64_decode(base64_decode($this->input->post('checkoutDate'))));
			$duration_day    = base64_decode(base64_decode(base64_decode($this->input->post('duration_day'))));
			$destinationCode = base64_decode(base64_decode(base64_decode($this->input->post('destinationCode'))));

    		$json_data = json_decode($this->input->post('json_data'));
    		$returnURL = $this->input->post('curr_url');
			if( $this->session->userdata('normal_session_id') == TRUE ) {
				//parameters
				foreach($json_data as $arrData)
				{
					$roomidx = $arrData->roomidx;
					$mealbasis = base64_decode(base64_decode(base64_decode($arrData->roommeal)));
					$pricePerRoom    = base64_decode(base64_decode(base64_decode($arrData->roomprice)));
					$roomType 	     = base64_decode(base64_decode(base64_decode($arrData->roomtype)));
					$roomTypeID   	 = base64_decode(base64_decode(base64_decode($arrData->roomtype_id)));
					$noofadult 		 = base64_decode(base64_decode(base64_decode($arrData->noadult)));
					$noofchild 		 = base64_decode(base64_decode(base64_decode($arrData->nochild)));
					$noofinfant 	 = base64_decode(base64_decode(base64_decode($arrData->noinfant)));
					$hotel_RoomImage = base64_decode(base64_decode(base64_decode($arrData->roomimage)));
					$childAgesArr = base64_decode(base64_decode(base64_decode($arrData->childages)));
					//end of parameters

					/* check idx */
					$this->db->select_max('room_index');
					$this->db->from('hotel_cart');
					$this->db->where('hotel_ItemCode', trim($itemCode));
					$this->db->where('hotel_ItemCityCode', trim($destinationCode));
					$qry = $this->db->get();

					if($qry->num_rows()) {$res = $qry->row();
						$roomidx = $res->room_index + 1;
					}

					//insert into cart
					$data_fields = array(
						"hotel_Fullname"	   => trim($hotelName),
						"hotel_Image"	 	   => trim($hotelImage),
						"hotel_ItemCode" 	   => trim($itemCode),
						"hotel_ItemCityCode"   => trim($destinationCode),
						"hotel_PricePerRoom"   => trim($pricePerRoom),
						"hotel_RoomType" 	   => trim($roomType),
						"hotel_RoomTypeID"     => trim($roomTypeID),
						"hotel_RoomQuantity"   => trim($noofRoom),
						"hotel_AdultQuantity"  => trim($noofadult),
						"hotel_ChildQuantity"  => trim($noofchild),
						"hotel_InfantQuantity" => trim($noofinfant),
						"hotel_childAges" => trim($childAgesArr),
						"check_in_date" 	   => trim($checkinDate),
						"check_out_date" 	   => trim($checkoutDate),
						"duration" 	 		   => trim($duration_day),
						"user_access_id" 	   => $this->session->userdata('normal_session_id'),
						"hotel_RoomImage" => trim($hotel_RoomImage),
						"room_index" => $roomidx,
						"room_meal" => $mealbasis,
						"created" 			   => date("Y-m-d H:i:s"),
						"modified" 			   => date("Y-m-d H:i:s")
					);
					$insertCart = $this->All->insert_template($data_fields, "hotel_cart");
					//end of insert into cart
					//session and redirect
					//end of session and redirect
				}

				redirect("cart/index#hotel_cart");
			}
			else {
				$arrayCart = $this->session->userdata('shoppingCartCookie');
				if( count($arrayCart) > 0 ) {
					/*for($x=0; $x<count($arrayCart); $x++) {
						if( $arrayCart[$x]["hotel_ItemCode"] == $itemCode && $arrayCart[$x]["hotel_RoomType"] == $roomType &&
							$arrayCart[$x]["check_in_date"] == $checkinDate && $arrayCart[$x]["check_out_date"] == $checkoutDate
						) {
							$this->session->set_flashdata(
								'errorDuplicateCart',
								'<article class="full-width">
									<div style="text-align:center; color:green; padding:15px; font-size:16px">
										This item has been added into cart before.
									</div>
								</article>'
							);
							//redirect("cart/index");
						}
					}*/
					$this->session->unset_userdata('shoppingCartCookie');
					for($x=0; $x<count($arrayCart); $x++) {
						$cart_items[] = $arrayCart[$x];
					}
					$ctr = 1;
						foreach($json_data as $arrData) {
							$roomidx = $ctr;//$arrData->roomidx;
							$mealbasis = base64_decode(base64_decode(base64_decode($arrData->roommeal)));
							$pricePerRoom    = base64_decode(base64_decode(base64_decode($arrData->roomprice)));
							$roomType 	     = base64_decode(base64_decode(base64_decode($arrData->roomtype)));
							$roomTypeID   	 = base64_decode(base64_decode(base64_decode($arrData->roomtype_id)));
							$noofadult 		 = base64_decode(base64_decode(base64_decode($arrData->noadult)));
							$noofchild 		 = base64_decode(base64_decode(base64_decode($arrData->nochild)));
							$noofinfant 	 = base64_decode(base64_decode(base64_decode($arrData->noinfant)));
							$hotel_RoomImage = base64_decode(base64_decode(base64_decode($arrData->roomimage)));
							$childAgesArr = base64_decode(base64_decode(base64_decode($arrData->childages)));

							$new_array = array(
								"hotel_PricePerRoom"   => $pricePerRoom,
								"hotel_RoomType" 	   => $roomType,
								"hotel_RoomTypeID"	   => $roomTypeID,
								"hotel_AdultQuantity"  => trim($noofadult),
								"hotel_ChildQuantity"  => trim($noofchild),
								"hotel_InfantQuantity" => trim($noofinfant),
								"room_index" => $roomidx,
								"room_meal" => $mealbasis,
								"hotel_RoomImage" => $hotel_RoomImage,
								"childages" => $childAgesArr
							);
							$arrayCartd[] = $new_array;
							$ctr++;
						}
						$cart_items[] = array(
							"hotel_Fullname" 	   => $hotelName,
							"hotel_Image"    	   => $hotelImage,
							"hotel_ItemCode" 	   => $itemCode,
							"hotel_ItemCityCode"   => $destinationCode,
							"check_in_date"  	   => $checkinDate,
							"check_out_date" 	   => $checkoutDate,
							"duration" 			   => $duration_day,
							"created"			   => date("Y-m-d H:i:s"),
							"modified"			   => date("Y-m-d H:i:s"),

							"hotel_RoomQuantity"   => $noofRoom,
							"hotel_room" => $arrayCartd
						);
				}
				else {
					foreach($json_data as $arrData) {
						$roomidx = $arrData->roomidx;
						$mealbasis = base64_decode(base64_decode(base64_decode($arrData->roommeal)));
						$pricePerRoom    = base64_decode(base64_decode(base64_decode($arrData->roomprice)));
						$roomType 	     = base64_decode(base64_decode(base64_decode($arrData->roomtype)));
						$roomTypeID   	 = base64_decode(base64_decode(base64_decode($arrData->roomtype_id)));
						$noofadult 		 = base64_decode(base64_decode(base64_decode($arrData->noadult)));
						$noofchild 		 = base64_decode(base64_decode(base64_decode($arrData->nochild)));
						$noofinfant 	 = base64_decode(base64_decode(base64_decode($arrData->noinfant)));
						$hotel_RoomImage = base64_decode(base64_decode(base64_decode($arrData->roomimage)));
						$childAgesArr = base64_decode(base64_decode(base64_decode($arrData->childages)));

						$arrayCart[] = array(
								"hotel_PricePerRoom"   => $pricePerRoom,
								"hotel_RoomType" 	   => $roomType,
								"hotel_RoomTypeID"	   => $roomTypeID,
								"hotel_AdultQuantity"  => trim($noofadult),
								"hotel_ChildQuantity"  => trim($noofchild),
								"hotel_InfantQuantity" => trim($noofinfant),
								"room_index" => $roomidx,
								"room_meal" => $mealbasis,
								"hotel_RoomImage" => $hotel_RoomImage,
								"childages" => $childAgesArr
							);
						//$cart_items['hotel_room'][] = $first_item;
						//$cart_items[] = $first_item;

					}
					$cart_items[] = array(
						"hotel_Fullname" 	   => $hotelName,
						"hotel_Image"    	   => $hotelImage,
						"hotel_ItemCode" 	   => $itemCode,
						"hotel_ItemCityCode"   => $destinationCode,
						"check_in_date"  	   => $checkinDate,
						"check_out_date" 	   => $checkoutDate,
						"duration" 			   => $duration_day,
						"created"			   => date("Y-m-d H:i:s"),
						"modified"			   => date("Y-m-d H:i:s"),
						"hotel_RoomQuantity"   => $noofRoom,
						"hotel_room" => $arrayCart
					);
				}

				$this->session->set_userdata('shoppingCartCookie', $cart_items);
				//session and redirect
				redirect("cart/index#hotel_cart");
				//end of session and redirect
			}
		} else {
			redirect('cart/index#hotel_cart');
		}
	}

	public function do_add_cartFlight()
	{
		$data = (array)json_decode(stripslashes($this->input->post('data')));
		if( $this->session->userdata('normal_session_id') == TRUE ) {
			$first_item = array(
				"departureFlightName" 	 	=> $data["departureFlightName"],
			    "departureFlightCode" 	 	=> $data["departureFlightCode"],
			    "departureDateFrom" 		=> $data["departureDateFrom"],
			    "departureDateTo" 		 	=> $data["departureDateTo"],
			    "departureTimeFrom"		 	=> $data["departureTimeFrom"],
			    "departureTimeTo"			=> $data["departureTimeTo"],
			    "departureCityNameFrom" 	=> $data["departureCityNameFrom"],
			    "departureCityNameTo" 	 	=> $data["departureCityNameTo"],
			    "departureCityCodeFrom" 	=> $data["departureCityCodeFrom"],
			    "departureCityCodeTo" 	  	=> $data["departureCityCodeTo"],
			    "departureAirportNameFrom" 	=> $data["departureAirportNameFrom"],
			    "departureAirportNameTo" 	=> $data["departureAirportNameTo"],
			    "departureTimeTaken" 		=> $data["departureTimeTaken"],
			    "departureBaggage" 		 	=> $data["departureBaggage"],
			    "departureMeal" 		 	=> $data["departureMeal"],
			    "departureTotalTransit" 	=> $data["departureTotalTransit"],
			    "departureTotalFlightTime" 	=> $data["departureTotalFlightTime"],
			    "departureTotalPrice" 	 	=> $data["departureTotalPrice"],
			    "departureFlightResBookDesigCode" => $data['departureFlightResBookDesigCode'],
			    "departureFlightAirEquipType" => $data['departureFlightAirEquipType'],
			    "departureFlightMarriageGrp" => $data['departureFlightMarriageGrp'],
			    "departureFlightEticket" => $data['departureFlightEticket'],

				"departurePriceAdultTaxFare" => $data['departurePriceAdultTaxFare'],
				"departurePriceAdultBaseFare" => $data['departurePriceAdultBaseFare'],
				"departurePriceChildTaxFare" => $data['departurePriceChildTaxFare'],
				"departurePriceChildBaseFare" => $data['departurePriceChildBaseFare'],
				"departurePriceInfantTaxFare" => $data['departurePriceInfantTaxFare'],
				"departurePriceInfantBaseFare" => $data['departurePriceInfantBaseFare'],

				"departureTerminalID_from" => $data['departureTerminalID_from'],
				"departureTimezone_from" => $data['departureTimezone_from'],
				"departureTerminalID_to" => $data['departureTerminalID_to'],
				"departureTimezone_to" => $data['departureTimezone_to'],

			    "arrivalFlightName" 	 	=> $data["arrivalFlightName"],
			    "arrivalFlightCode" 	 	=> $data["arrivalFlightCode"],
			    "arrivalDateFrom" 		 	=> $data["arrivalDateFrom"],
			    "arrivalDateTo" 		 	=> $data["arrivalDateTo"],
			    "arrivalTimeFrom"		 	=> $data["arrivalTimeFrom"],
			    "arrivalTimeTo"			 	=> $data["arrivalTimeTo"],
			    "arrivalCityNameFrom" 	 	=> $data["arrivalCityNameFrom"],
			    "arrivalCityNameTo" 	 	=> $data["arrivalCityNameTo"],
			    "arrivalCityCodeFrom" 	 	=> $data["arrivalCityCodeFrom"],
			    "arrivalCityCodeTo" 	 	=> $data["arrivalCityCodeTo"],
			    "arrivalAirportNameFrom" 	=> $data["arrivalAirportNameFrom"],
			    "arrivalAirportNameTo" 	 	=> $data["arrivalAirportNameTo"],
			    "arrivalTimeTaken" 		 	=> $data["arrivalTimeTaken"],
			    "arrivalBaggage" 		 	=> $data["arrivalBaggage"],
			    "arrivalMeal" 		 	 	=> $data["arrivalMeal"],
			    "arrivalTotalTransit" 	 	=> $data["arrivalTotalTransit"],
			    "arrivalTotalFlightTime" 	=> $data["arrivalTotalFlightTime"],
			    "arrivalTotalPrice" 	 	=> $data["arrivalTotalPrice"],
			    "arrivalFlightResBookDesigCode" => $data['arrivalFlightResBookDesigCode'],
			    "arrivalFlightAirEquipType" => $data['arrivalFlightAirEquipType'],
			    "arrivalFlightMarriageGrp" => $data['arrivalFlightMarriageGrp'],
			    "arrivalFlightEticket" => $data['arrivalFlightEticket'],

			    "arrivalPriceAdultTaxFare" => $data['arrivalPriceAdultTaxFare'],
				"arrivalPriceAdultBaseFare" => $data['arrivalPriceAdultBaseFare'],
				"arrivalPriceChildTaxFare" => $data['arrivalPriceChildTaxFare'],
				"arrivalPriceChildBaseFare" => $data['arrivalPriceChildBaseFare'],
				"arrivalPriceInfantTaxFare" => $data['arrivalPriceInfantTaxFare'],
				"arrivalPriceInfantBaseFare" => $data['arrivalPriceInfantBaseFare'],

				"arrivalTerminalID_from" => $data['arrivalTerminalID_from'],
				"arrivalTimezone_from" => $data['arrivalTimezone_from'],
				"arrivalTerminalID_to" => $data['arrivalTerminalID_to'],
				"arrivalTimezone_to" => $data['arrivalTimezone_to'],
				"departureFareBasisCode" => $data['departureFareBasisCode'],
				"departureFareBasisCodeChild" => $data['departureFareBasisCodeChild'],
				"departureFareBasisCodeInfant" => $data['departureFareBasisCodeInfant'],
				"arrivalFareBasisCode" => $data['arrivalFareBasisCode'],
				"arrivalFareBasisCodeChild" => $data['arrivalFareBasisCodeChild'],
				"arrivalFareBasisCodeInfant" => $data['arrivalFareBasisCodeInfant'],
                "departuremealcode" => $data['departuremealcode'],
                "arrivalmealcode" => $data['arrivalmealcode'],

				"TotalPriceAdminFare" => $data['TotalPriceAdminFare'],

			    "noofAdult" 	 	 		=> $data["noofAdult"],
				"noofChild" 	 	 		=> $data["noofChild"],
				"noofInfant" 	 	 		=> $data["noofInfant"],
				"flightClass"				=> $data["flightClass"],
				"created" 		  		 	=> date("Y-m-d H:i:s"),
				"modified" 		  		 	=> date("Y-m-d H:i:s"),
				"user_access_id" =>			$this->session->userdata('normal_session_id'),
				"isReturnFlight"			=> isset($data['isReturnFlight']) ? "1" : "0"
			);
			//insert into cart
			$insertCart = $this->All->insert_template($first_item, "flight_cart");
			//session and redirect
			redirect("cart/index#flight_cart");
			//end of session and redirect
		}
		else {
			$first_item = array(
				"departureFlightName" 	 	=> $data["departureFlightName"],
			    "departureFlightCode" 	 	=> $data["departureFlightCode"],
			    "departureDateFrom" 		=> $data["departureDateFrom"],
			    "departureDateTo" 		 	=> $data["departureDateTo"],
			    "departureTimeFrom"		 	=> $data["departureTimeFrom"],
			    "departureTimeTo"			=> $data["departureTimeTo"],
			    "departureCityNameFrom" 	=> $data["departureCityNameFrom"],
			    "departureCityNameTo" 	 	=> $data["departureCityNameTo"],
			    "departureCityCodeFrom" 	=> $data["departureCityCodeFrom"],
			    "departureCityCodeTo" 	  	=> $data["departureCityCodeTo"],
			    "departureAirportNameFrom" 	=> $data["departureAirportNameFrom"],
			    "departureAirportNameTo" 	=> $data["departureAirportNameTo"],
			    "departureTimeTaken" 		=> $data["departureTimeTaken"],
			    "departureBaggage" 		 	=> $data["departureBaggage"],
			    "departureMeal" 		 	=> $data["departureMeal"],
			    "departureTotalTransit" 	=> $data["departureTotalTransit"],
			    "departureTotalFlightTime" 	=> $data["departureTotalFlightTime"],
			    "departureTotalPrice" 	 	=> $data["departureTotalPrice"],
			    "departureFlightResBookDesigCode" => $data['departureFlightResBookDesigCode'],
			    "departureFlightAirEquipType" => $data['departureFlightAirEquipType'],
			    "departureFlightMarriageGrp" => $data['departureFlightMarriageGrp'],
			    "departureFlightEticket" => $data['departureFlightEticket'],

			    "departurePriceAdultTaxFare" => $data['departurePriceAdultTaxFare'],
				"departurePriceAdultBaseFare" => $data['departurePriceAdultBaseFare'],
				"departurePriceChildTaxFare" => $data['departurePriceChildTaxFare'],
				"departurePriceChildBaseFare" => $data['departurePriceChildBaseFare'],
				"departurePriceInfantTaxFare" => $data['departurePriceInfantTaxFare'],
				"departurePriceInfantBaseFare" => $data['departurePriceInfantBaseFare'],

				"departureTerminalID_from" => $data['departureTerminalID_from'],
				"departureTimezone_from" => $data['departureTimezone_from'],
				"departureTerminalID_to" => $data['departureTerminalID_to'],
				"departureTimezone_to" => $data['departureTimezone_to'],

			    "arrivalFlightName" 	 	=> $data["arrivalFlightName"],
			    "arrivalFlightCode" 	 	=> $data["arrivalFlightCode"],
			    "arrivalDateFrom" 		 	=> $data["arrivalDateFrom"],
			    "arrivalDateTo" 		 	=> $data["arrivalDateTo"],
			    "arrivalTimeFrom"		 	=> $data["arrivalTimeFrom"],
			    "arrivalTimeTo"			 	=> $data["arrivalTimeTo"],
			    "arrivalCityNameFrom" 	 	=> $data["arrivalCityNameFrom"],
			    "arrivalCityNameTo" 	 	=> $data["arrivalCityNameTo"],
			    "arrivalCityCodeFrom" 	 	=> $data["arrivalCityCodeFrom"],
			    "arrivalCityCodeTo" 	 	=> $data["arrivalCityCodeTo"],
			    "arrivalAirportNameFrom" 	=> $data["arrivalAirportNameFrom"],
			    "arrivalAirportNameTo" 	 	=> $data["arrivalAirportNameTo"],
			    "arrivalTimeTaken" 		 	=> $data["arrivalTimeTaken"],
			    "arrivalBaggage" 		 	=> $data["arrivalBaggage"],
			    "arrivalMeal" 		 	 	=> $data["arrivalMeal"],
			    "arrivalTotalTransit" 	 	=> $data["arrivalTotalTransit"],
			    "arrivalTotalFlightTime" 	=> $data["arrivalTotalFlightTime"],
			    "arrivalTotalPrice" 	 	=> $data["arrivalTotalPrice"],
			    "arrivalFlightResBookDesigCode" => $data['arrivalFlightResBookDesigCode'],
			    "arrivalFlightAirEquipType" => $data['arrivalFlightAirEquipType'],
			    "arrivalFlightMarriageGrp" => $data['arrivalFlightMarriageGrp'],
			    "arrivalFlightEticket" => $data['arrivalFlightEticket'],

			    "arrivalPriceAdultTaxFare" => $data['arrivalPriceAdultTaxFare'],
				"arrivalPriceAdultBaseFare" => $data['arrivalPriceAdultBaseFare'],
				"arrivalPriceChildTaxFare" => $data['arrivalPriceChildTaxFare'],
				"arrivalPriceChildBaseFare" => $data['arrivalPriceChildBaseFare'],
				"arrivalPriceInfantTaxFare" => $data['arrivalPriceInfantTaxFare'],
				"arrivalPriceInfantBaseFare" => $data['arrivalPriceInfantBaseFare'],

				"arrivalTerminalID_from" => $data['arrivalTerminalID_from'],
				"arrivalTimezone_from" => $data['arrivalTimezone_from'],
				"arrivalTerminalID_to" => $data['arrivalTerminalID_to'],
				"arrivalTimezone_to" => $data['arrivalTimezone_to'],

				"departureFareBasisCode" => $data['departureFareBasisCode'],
				"departureFareBasisCodeChild" => $data['departureFareBasisCodeChild'],
				"departureFareBasisCodeInfant" => $data['departureFareBasisCodeInfant'],
				"arrivalFareBasisCode" => $data['arrivalFareBasisCode'],
				"arrivalFareBasisCodeChild" => $data['arrivalFareBasisCodeChild'],
				"arrivalFareBasisCodeInfant" => $data['arrivalFareBasisCodeInfant'],
                "departuremealcode" => $data['departuremealcode'],
                "arrivalmealcode" => $data['arrivalmealcode'],

				"TotalPriceAdminFare" => $data['TotalPriceAdminFare'],

			    "noofAdult" 	 	 		=> $data["noofAdult"],
				"noofChild" 	 	 		=> $data["noofChild"],
				"noofInfant" 	 	 		=> $data["noofInfant"],
				"flightClass"				=> $data["flightClass"],
				"created" 		  		 	=> date("Y-m-d H:i:s"),
				"modified" 		  		 	=> date("Y-m-d H:i:s"),
				"isReturnFlight"			=> isset($data['isReturnFlight']) ? "1" : "0"
			);
			$arrayFlightCart = $this->session->userdata('shoppingCartFlightCookie');
			if( count($arrayFlightCart) > 0 ) {
				$currentItems = $this->session->userdata('shoppingCartFlightCookie');
				$currentItems[] = $first_item;
				$this->session->set_userdata('shoppingCartFlightCookie', $currentItems);
			}
			else {
				$cart_items[] = $first_item;
				$this->session->set_userdata('shoppingCartFlightCookie', $cart_items);
			}
		}
	}

	public function flightrules($isPrint = 0)
    {
        if ($isPrint == 0 && !$this->input->is_ajax_request()) {
            echo "Sorry, You're not authorized [100]";
        } else {
        	$data['print'] = 0;
        	if($isPrint == 1) {
        		$data['print'] = 1;
        	}
			$file_datas = require_once($this->instanceurl.'webservices/abacus/SWSWebservices.class.php');

			$data['finalxml'] = array();
			if( $this->session->userdata('shoppingCartFlightCookie') == TRUE ) {

			    if( count($this->session->userdata('shoppingCartFlightCookie')) > 0 ) {
			        $count_session_data = count($this->session->userdata('shoppingCartFlightCookie'));
			        $arrayCart = $this->session->userdata('shoppingCartFlightCookie');
			        for( $x=0; $x<$count_session_data; $x++ ) {
			            if( strpos($arrayCart[$x]["departureFlightName"], '~') !== FALSE ) {
			                $explodeCount = explode("~", $arrayCart[$x]["departureFlightName"]);
			                for($xe=0; $xe<count($explodeCount); $xe++) {
			                    $arrDepartureFlightCode       = explode("~", $arrayCart[$x]["departureFlightCode"]);
			                    $arrDepartureFareBasisCode      = explode("~", $arrayCart[$x]["departureFareBasisCode"]);
			                    $arrDepartureFareBasisCodeChild      = explode("~", $arrayCart[$x]["departureFareBasisCodeChild"]);
			                    $arrDepartureFareBasisCodeInfant      = explode("~", $arrayCart[$x]["departureFareBasisCodeInfant"]);
			                    $arrDepartureCityCodeTo       = explode("~", $arrayCart[$x]["departureCityCodeTo"]);
			                    $arrDepartureCityCodeFrom     = explode("~", $arrayCart[$x]["departureCityCodeFrom"]);
			                    $arrDepartureDateFrom         = explode("~", $arrayCart[$x]["departureDateFrom"]);
			                    $arrDepartureFlightName         = explode("~", $arrayCart[$x]["departureFlightName"]);
			                    $imgReal = explode(" ", $arrDepartureFlightCode[$xe]);

			                    $farebasecode = $arrDepartureFareBasisCode[$xe];
			                    $farebasecodeChild = $arrDepartureFareBasisCodeChild[$xe];
			                    $farebasecodeInfant = $arrDepartureFareBasisCodeInfant[$xe];

			                    $datefrom = $arrDepartureDateFrom[$xe];
			                    $destination_code = $arrDepartureCityCodeTo[$xe];
			                    $origin_code = $arrDepartureCityCodeFrom[$xe];
			                    $marketing_carrier = $imgReal[0];

				               	/*$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $farebasecode, $farebasecodeChild, $farebasecodeInfant); */
				                $rules = array();
				                $fbca = explode(",", $farebasecode);
						   		if(count($fbca)) {
							   		foreach ($fbca as $key => $value) {
							   			# code...
							   			if($value != ""){
							   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
							   				$parseResult = simplexml_load_string($xml);
							   				$rules['adult'][] = json_decode(json_encode($parseResult), true);
							   			}
							   		}
							   	}

							   	$fbcc = explode(",", $farebasecodeChild);
						   		if(count($fbcc)) {
							   		foreach ($fbcc as $key => $value) {
							   			# code...
							   			if($value != ""){
							   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
							   				$parseResult = simplexml_load_string($xml);
							   				$rules['child'][] = json_decode(json_encode($parseResult), true);
							   			}
							   		}
							   	}

							   	$fbci = explode(",", $farebasecodeInfant);
						   		if(count($fbci)) {
							   		foreach ($fbci as $key => $value) {
							   			# code...
							   			if($value != ""){
							   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
							   				$parseResult = simplexml_load_string($xml);
							   				$rules['infant'][] = json_decode(json_encode($parseResult), true);
							   			}
							   		}
							   	}

			                    $data['finalxml'][] = array(
			                            'FlightName' => $arrDepartureFlightName[$xe],
			                            'FlightCode' => $arrDepartureFlightCode[$xe],
			                            'rules' => $rules
			                        );
			                }
			            } else if( strpos($arrayCart[$x]["departureFlightName"], '~') !== TRUE ) {
			                $imgReal = explode(" ", $arrayCart[$x]['departureFlightCode']);
			                $farebasecode = $arrayCart[$x]['departureFareBasisCode'];
			                $farebasecodeChild = $arrayCart[$x]['departureFareBasisCodeChild'];
			                $farebasecodeInfant = $arrayCart[$x]['departureFareBasisCodeInfant'];

			                $datefrom = $arrayCart[$x]['departureDateFrom'];
			                $destination_code = $arrayCart[$x]['departureCityCodeTo'];
			                $origin_code = $arrayCart[$x]['departureCityCodeFrom'];
			                $marketing_carrier = $imgReal[0];

			                $rules = array();
			                $fbca = explode(",", $farebasecode);
					   		if(count($fbca)) {
						   		foreach ($fbca as $key => $value) {
						   			# code...
						   			if($value != ""){
						   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
						   				$parseResult = simplexml_load_string($xml);
						   				$rules['adult'][] = json_decode(json_encode($parseResult), true);
						   			}
						   		}
						   	}

						   	$fbcc = explode(",", $farebasecodeChild);
					   		if(count($fbcc)) {
						   		foreach ($fbcc as $key => $value) {
						   			# code...
						   			if($value != ""){
						   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
						   				$parseResult = simplexml_load_string($xml);
						   				$rules['child'][] = json_decode(json_encode($parseResult), true);
						   			}
						   		}
						   	}

						   	$fbci = explode(",", $farebasecodeInfant);
					   		if(count($fbci)) {
						   		foreach ($fbci as $key => $value) {
						   			# code...
						   			if($value != ""){
						   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
						   				$parseResult = simplexml_load_string($xml);
						   				$rules['infant'][] = json_decode(json_encode($parseResult), true);
						   			}
						   		}
						   	}

			                /*$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $farebasecode, $farebasecodeChild, $farebasecodeInfant);
*/

			                $data['finalxml'][] = array(
			                            'FlightName' => $arrayCart[$x]['departureFlightName'],
			                            'FlightCode' => $arrayCart[$x]['departureFlightCode'],
			                            'rules' => $rules
			                        );
			            }
			        }
			    }
			} else {
			     $flights_cart = $this->All->select_template(
			        "user_access_id", $this->session->userdata('normal_session_id'), "flight_cart"
			    );
			    if( $flights_cart == TRUE ) {
			        $x = 0;
			        foreach( $flights_cart AS $flight_cart ) {
			            if( strpos($flight_cart->departureFlightName, '~') !== FALSE ) {
			                //indirect
			                $ctr = 0;
			                $explodeCount = explode("~", $flight_cart->departureFlightName);
			                for($xe=0; $xe<count($explodeCount); $xe++) {
			                    $arrDepartureFlightCode       = explode("~", $flight_cart->departureFlightCode);
			                    $arrDepartureFareBasisCode      = explode("~", $flight_cart->departureFareBasisCode);
			                    $arrDepartureFareBasisCodeChild      = explode("~", $flight_cart->departureFareBasisCodeChild);
			                    $arrDepartureFareBasisCodeInfant      = explode("~", $flight_cart->departureFareBasisCodeInfant);
			                    $arrDepartureCityCodeTo       = explode("~", $flight_cart->departureCityCodeTo);
			                    $arrDepartureCityCodeFrom     = explode("~", $flight_cart->departureCityCodeFrom);
			                    $arrDepartureDateFrom         = explode("~", $flight_cart->departureDateFrom);
			                    $arrDepartureFlightName         = explode("~", $flight_cart->departureFlightName);
			                    $imgReal = explode(" ", $arrDepartureFlightCode[$xe]);

			                    $farebasecode = $arrDepartureFareBasisCode[$xe];
			                    $farebasecodeChild = $arrDepartureFareBasisCodeChild[$xe];
			                    $farebasecodeInfant = $arrDepartureFareBasisCodeInfant[$xe];

			                    $datefrom = $arrDepartureDateFrom[$xe];
			                    $destination_code = $arrDepartureCityCodeTo[$xe];
			                    $origin_code = $arrDepartureCityCodeFrom[$xe];
			                    $marketing_carrier = $imgReal[0];

			                    /*$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $farebasecode, $farebasecodeChild, $farebasecodeInfant);*/

			                    $rules = array();
			                $fbca = explode(",", $farebasecode);
					   		if(count($fbca)) {
						   		foreach ($fbca as $key => $value) {
						   			# code...
						   			if($value != ""){
						   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
						   				$parseResult = simplexml_load_string($xml);
						   				$rules['adult'][] = json_decode(json_encode($parseResult), true);
						   			}
						   		}
						   	}

						   	$fbcc = explode(",", $farebasecodeChild);
					   		if(count($fbcc)) {
						   		foreach ($fbcc as $key => $value) {
						   			# code...
						   			if($value != ""){
						   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
						   				$parseResult = simplexml_load_string($xml);
						   				$rules['child'][] = json_decode(json_encode($parseResult), true);
						   			}
						   		}
						   	}

						   	$fbci = explode(",", $farebasecodeInfant);
					   		if(count($fbci)) {
						   		foreach ($fbci as $key => $value) {
						   			# code...
						   			if($value != ""){
						   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
						   				$parseResult = simplexml_load_string($xml);
						   				$rules['infant'][] = json_decode(json_encode($parseResult), true);
						   			}
						   		}
						   	}

			                    /*$parseResult = simplexml_load_string($xml);*/
			                    $data['finalxml'][] = array(
			                            'FlightName' => $arrDepartureFlightName[$xe],
			                            'FlightCode' => $arrDepartureFlightCode[$xe],
			                            'rules' => $rules
			                        );

			                }
			            } else if( strpos($flight_cart->departureFlightName, '~') !== TRUE ) {
			                $imgReal = explode(" ", $flight_cart->departureFlightCode);
			                $farebasecode = $flight_cart->departureFareBasisCode;
			                $farebasecodeChild = $flight_cart->departureFareBasisCodeChild;
			                $farebasecodeInfant = $flight_cart->departureFareBasisCodeInfant;

			                $datefrom = $flight_cart->departureDateFrom;
			                $destination_code = $flight_cart->departureCityCodeTo;
			                $origin_code = $flight_cart->departureCityCodeFrom;
			                $marketing_carrier = $imgReal[0];

			                /*$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $farebasecode, $farebasecodeChild, $farebasecodeInfant);

			                $parseResult = simplexml_load_string($xml);*/

			                $rules = array();
			                $fbca = explode(",", $farebasecode);
					   		if(count($fbca)) {
						   		foreach ($fbca as $key => $value) {
						   			# code...
						   			if($value != ""){
						   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
						   				$parseResult = simplexml_load_string($xml);
						   				$rules['adult'][] = json_decode(json_encode($parseResult), true);
						   			}
						   		}
						   	}

						   	$fbcc = explode(",", $farebasecodeChild);
					   		if(count($fbcc)) {
						   		foreach ($fbcc as $key => $value) {
						   			# code...
						   			if($value != ""){
						   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
						   				$parseResult = simplexml_load_string($xml);						   				$rules['child'][] = json_decode(json_encode($parseResult), true);
						   			}
						   		}
						   	}

						   	$fbci = explode(",", $farebasecodeInfant);
					   		if(count($fbci)) {
						   		foreach ($fbci as $key => $value) {
						   			# code...
						   			if($value != ""){
						   				$xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $value);
						   				$parseResult = simplexml_load_string($xml);
						   				$rules['infant'][] = json_decode(json_encode($parseResult), true);
						   			}
						   		}
						   	}

			                $data['finalxml'][] = array(
			                            'FlightName' => $flight_cart->departureFlightName,
			                            'FlightCode' => $flight_cart->departureFlightCode,
			                            'rules' => $rules
			                        );
			            }
			        }
			    }
			}
			//$data['finalxml'] = $finalxml;
			if(count($data['finalxml'])) {
				if($isPrint == 1) {
					$this->load->view('cart/flightrules', $data);
				} else {
					echo $this->load->view('cart/flightrules', $data, true);
				}
			} else {
				echo json_encode(array('nodata' => true));
			}


            /*} else {
                echo "Sorry, You're not authorized [101]";
            }*/
            //checkrules($departureDate, $destinationCode, $MarketingCarrier, $originCode, $fareBasisCode);
        }
    }

	public function emptyCart()
	{
		//$arrayCart = $this->session->userdata('shoppingCartFlightCookie');
		$this->session->unset_userdata('shoppingCartFlightCookie');
		$this->session->unset_userdata('shoppingCartCookie');
		$this->session->unset_userdata('shoppingCartLandtourCookie');
		$this->session->unset_userdata('shoppingCartCruiseCookie');
		//unset($arrayCart);
		if( $this->session->userdata('normal_session_id') == TRUE )
		{
			/* clear the database */
			$this->All->delete_template('user_access_id', $this->session->userdata('normal_session_id'), 'flight_cart');
			$this->All->delete_template('user_access_id', $this->session->userdata('normal_session_id'), 'hotel_cart');
			$this->All->delete_template('user_access_id', $this->session->userdata('normal_session_id'), 'landtour_cart');
			$this->All->delete_template('user_access_id', $this->session->userdata('normal_session_id'), 'cruise_cart');
		}
		/* keep the flashdata for this request */
		$flashdat = $this->session->flashdata('empty_cart');
		$this->session->set_flashdata(
			'empty_cart',
			$flashdat
		);
		redirect('cart');
	}

	public function remove_flight_cart_session()
	{
		//input parameter
		if($this->uri->segment(3) == 'fid') {
			$cart_id = base64_decode(base64_decode(base64_decode($this->uri->segment(4))));
		} else {
			$cart_id = $this->uri->segment(3);
		}
		//end of input parameter
		//delete hotel cart
		$delete_flight_cart = $this->All->delete_template("id", $cart_id, "flight_cart");

		//end of input parameter
		$arrayCart = $this->session->userdata('shoppingCartFlightCookie');
		unset($arrayCart[$cart_id]);
		$arrayCart = array_merge($arrayCart);
		$this->session->set_userdata('shoppingCartFlightCookie', $arrayCart);
		//session and redirect
		redirect("cart/index#flight_cart");
		//end of session and redirect
	}

	public function do_add_cart()
	{
		if( $this->session->userdata('normal_session_id') == TRUE ) {
			//parameters
			$itemCode 	     = base64_decode(base64_decode(base64_decode($this->uri->segment(3))));
			$pricePerRoom    = base64_decode(base64_decode(base64_decode($this->uri->segment(4))));
			$roomType 	     = base64_decode(base64_decode(base64_decode($this->uri->segment(5))));
			$noofRoom 	     = base64_decode(base64_decode(base64_decode($this->uri->segment(6))));
			$checkinDate     = base64_decode(base64_decode(base64_decode($this->uri->segment(7))));
			$hotelName       = base64_decode(base64_decode(base64_decode($this->uri->segment(8))));
			$hotelImage      = base64_decode(base64_decode(base64_decode($this->uri->segment(9))));
			$checkoutDate    = base64_decode(base64_decode(base64_decode($this->uri->segment(10))));
			$duration_day    = base64_decode(base64_decode(base64_decode($this->uri->segment(11))));
			$roomTypeID   	 = base64_decode(base64_decode(base64_decode($this->uri->segment(12))));
			$destinationCode = base64_decode(base64_decode(base64_decode($this->uri->segment(13))));
			$noofadult 		 = base64_decode(base64_decode(base64_decode($this->uri->segment(14))));
			//end of parameters
			$checks = $this->All->select_template_w_5_conditions(
				"hotel_ItemCode", $itemCode,
				"check_in_date",  $checkinDate,
				"check_out_date", $checkoutDate,
				"hotel_RoomType", $roomType,
				"user_access_id", $this->session->userdata('normal_session_id'),
				"hotel_cart"
			);
			if( $checks == TRUE ) {
				//update cart
				$this->db->where('hotel_ItemCode', trim($itemCode));
				$this->db->where('check_in_date',  trim($checkinDate));
				$this->db->where('check_out_date', trim($checkoutDate));
				$this->db->where('hotel_RoomType', trim($roomType));
				$this->db->where('user_access_id', $this->session->userdata('normal_session_id'));
				$this->db->set('hotel_RoomQuantity', 'hotel_RoomQuantity+'.$noofRoom, FALSE);
				$this->db->set('modified', date("Y-m-d H:i:s"));
				$this->db->update('hotel_cart');
				//end of update cart
			}
			else {
				//insert into cart
				$data_fields = array(
					"hotel_Fullname"	  => trim($hotelName),
					"hotel_Image"	 	  => trim($hotelImage),
					"hotel_ItemCode" 	  => trim($itemCode),
					"hotel_ItemCityCode"  => trim($destinationCode),
					"hotel_PricePerRoom"  => trim($pricePerRoom),
					"hotel_RoomType" 	  => trim($roomType),
					"hotel_RoomTypeID"    => trim($roomTypeID),
					"hotel_RoomQuantity"  => trim($noofRoom),
					"hotel_AdultQuantity" => trim($noofadult),
					"check_in_date" 	  => trim($checkinDate),
					"check_out_date" 	  => trim($checkoutDate),
					"duration" 	 		  => trim($duration_day),
					"user_access_id" 	  => $this->session->userdata('normal_session_id'),
					"created" 			  => date("Y-m-d H:i:s"),
					"modified" 			  => date("Y-m-d H:i:s")
				);
				$insertCart = $this->All->insert_template($data_fields, "hotel_cart");
				//end of insert into cart
			}
			//session and redirect
			redirect("cart/index");
			//end of session and redirect
		}
		else {
			//parameters
			$itemCode 	     = base64_decode(base64_decode(base64_decode($this->uri->segment(3))));
			$pricePerRoom    = base64_decode(base64_decode(base64_decode($this->uri->segment(4))));
			$roomType 	     = base64_decode(base64_decode(base64_decode($this->uri->segment(5))));
			$noofRoom 	     = base64_decode(base64_decode(base64_decode($this->uri->segment(6))));
			$checkinDate     = base64_decode(base64_decode(base64_decode($this->uri->segment(7))));
			$hotelName       = base64_decode(base64_decode(base64_decode($this->uri->segment(8))));
			$hotelImage      = base64_decode(base64_decode(base64_decode($this->uri->segment(9))));
			$checkoutDate    = base64_decode(base64_decode(base64_decode($this->uri->segment(10))));
			$duration_day    = base64_decode(base64_decode(base64_decode($this->uri->segment(11))));
			$roomTypeID   	 = base64_decode(base64_decode(base64_decode($this->uri->segment(12))));
			$destinationCode = base64_decode(base64_decode(base64_decode($this->uri->segment(13))));
			$noofadult 		 = base64_decode(base64_decode(base64_decode($this->uri->segment(14))));
			//end of parameters

			$arrayCart = $this->session->userdata('shoppingCartCookie');
			if( count($arrayCart) > 0 ) {
				for($x=0; $x<count($arrayCart); $x++) {
					if( $arrayCart[$x]["itemCode"] == $itemCode && $arrayCart[$x]["roomType"] == $roomType &&
						$arrayCart[$x]["checkinDate"] == $checkinDate && $arrayCart[$x]["checkoutDate"] == $checkoutDate
					) {
						$this->session->set_flashdata(
							'errorDuplicateCart',
							'<article class="full-width">
								<div style="text-align:center; color:green; padding:15px; font-size:16px">
									This item has been added into cart before.
								</div>
							</article>'
						);
						redirect("cart/index");
					}
				}
				$new_array = array(
					"hotel_Fullname" 	  => $hotelName,
					"hotel_Image"    	  => $hotelImage,
					"hotel_ItemCode" 	  => $itemCode,
					"hotel_ItemCityCode"  => $destinationCode,
					"hotel_PricePerRoom"  => $pricePerRoom,
					"hotel_RoomType" 	  => $roomType,
					"hotel_RoomTypeID"	  => $roomTypeID,
					"hotel_RoomQuantity"  => $noofRoom,
					"hotel_AdultQuantity" => $noofadult,
					"check_in_date"  	  => $checkinDate,
					"check_out_date" 	  => $checkoutDate,
					"duration" 			  => $duration_day,
					"created"			  => date("Y-m-d H:i:s"),
					"modified"			  => date("Y-m-d H:i:s")
				);
				//$cart_items[] = $old_array;
				$arrayCart[] = $new_array;
				$cart_items = $arrayCart;
				$this->session->set_userdata('shoppingCartCookie', $cart_items);
				//session and redirect
				redirect("cart/index");
				//end of session and redirect
			}
			else {
				$first_item = array(
					"hotel_Fullname" 	  => $hotelName,
					"hotel_Image"    	  => $hotelImage,
					"hotel_ItemCode" 	  => $itemCode,
					"hotel_ItemCityCode"  => $destinationCode,
					"hotel_PricePerRoom"  => $pricePerRoom,
					"hotel_RoomType" 	  => $roomType,
					"hotel_RoomTypeID"	  => $roomTypeID,
					"hotel_RoomQuantity"  => $noofRoom,
					"hotel_AdultQuantity" => $noofadult,
					"check_in_date"  	  => $checkinDate,
					"check_out_date" 	  => $checkoutDate,
					"duration" 			  => $duration_day,
					"created"			  => date("Y-m-d H:i:s"),
					"modified"			  => date("Y-m-d H:i:s")
				);
				$cart_items[] = $first_item;
				$this->session->set_userdata('shoppingCartCookie', $cart_items);
				//session and redirect
				redirect("cart/index");
				//end of session and redirect
			}
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */