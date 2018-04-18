<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

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
	public function __construct()
    {
		parent::__construct();
		$this->load->model('cruise');
    }

	public function landtour_special_instruction()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/land_tour/landtour_special_instruction');
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_manage_instruction()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/cruise_special_instruction');
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_index()
	{
		$data['title'] = "Cruise Management";
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/product_cruise_index', $data);
		}
		else {
			redirect("backend/");
		}
	}

	public function landtour_index()
	{
		$data['title'] = "Land Tour Management";
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/land_tour/landtour_index', $data);
		}
		else {
			redirect("backend/");
		}
	}

	public function landtour_add_new()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/land_tour/manage_new_product');
		}
		else {
			redirect("backend/");
		}
	}

	public function landtour_category()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/land_tour/manage_category');
		}
		else {
			redirect("backend/");
		}
	}

	public function landtour_location()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/land_tour/manage_location');
		}
		else {
			redirect("backend/");
		}
	}

	public function landtour_overview()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/land_tour/landtour_overview');
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_manage_transaction()
	{
		$data['title'] = "Cruise Transaction Management";
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/product_cruise_transaction', $data);
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_overview()
	{
		$data['title'] = "Cruise Overview";
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/cruise_overview', $data);
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_manage_prices()
	{
		$data['title'] = "Cruise Price Management";
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/manage_prices', $data);
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_manage_ship()
	{
		$data['title'] = "Cruise Ship Management";
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/manage_ship', $data);
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_manage_brand()
	{
		$data['title'] = "Cruise Brand Management";
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/manage_brand', $data);
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_manage_stateroom()
	{
		$data['title'] = "Cruise Stateroom Management";
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/manage_stateroom', $data);
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_add_new_prices()
	{
		$data['title'] = "Add New Cruise Prices";
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/add_new_prices', $data);
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_add_new()
	{
		$data['title'] = "Add New Cruise";
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/add_new_cruise', $data);
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_brand()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/product_cruise_manage_brand');
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_ship()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/product_cruise_manage_ship');
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_price()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/product_cruise_edit_price');
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_date()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/product_cruise_edit_date');
		}
		else {
			redirect("backend/");
		}
	}

	public function cruise_itineraries()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/product_cruise_edit_itinerary');
		}
		else {
			redirect("backend/");
		}
	}

	public function flight_index()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/product_flight_index');
		}
		else {
			redirect("backend/");
		}
	}

	public function hotel_index()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/product_hotel_index');
		}
		else {
			redirect("backend/");
		}
	}

	public function passes_index()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/product_passes_index');
		}
		else {
			redirect("backend/");
		}
	}

	public function tour_index()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/product_tour_index');
		}
		else {
			redirect("backend/");
		}
	}

	public function transfer_index()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/product_transfer_index');
		}
		else {
			redirect("backend/");
		}
	}

	public function update_brand()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$data_fields = array(
				"NAME" 	   => $this->input->post("brandName"),
				"DESC" 	   => $this->input->post("brandDesc"),
				"STATUS"   => $this->input->post("brandStatus"),
				"MODIFIED" => date("Y-m-d H:i:s")
			);
			$updateBrand = $this->All->update_template($data_fields, "ID", $this->input->post("hidden_cruiseBrandID"), "cruise_brand");
			//session and redirect
			$this->session->set_flashdata(
				'updateCruiseBrand',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Well done!</span>
					Action updated!
				</div>'
			);
			redirect("backend/product/cruise_manage_brand");
			//end of session and redirect
		}
		else {
			redirect("backend/");
		}
	}

	public function insert_new_cruiseDetails()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$checks = $this->All->select_template_w_2_conditions(
				"CRUISE_TITLE", trim($this->input->post("ship_title")), "IS_DELETED", 0, "cruise_title"
			);
			if( $checks == TRUE ) {
				$this->session->set_userdata(
					'addNewCruise_error',
					'<div class="alert alert-danger alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Notification!</span>
						Cruise title has been used. Please use another cruise title.
					</div>'
				);
			}
			else {
				$data_fields = array(
					"CRUISE_TITLE" 	 => trim($this->input->post("ship_title")),
					"CRUISE_DESC"	 => trim($this->input->post("ship_desc")),
					"DEPARTURE_PORT" => trim($this->input->post("departure_port")),
					"DEPARTURE_DATE" => trim($this->input->post("departure_date")),
					"PORTS_OF_CALL"  => trim($this->input->post("ports_of_call")),
					"SHIP_ID" 		 => trim($this->input->post("ship_name")),
					"NIGHTS" 		 => trim($this->input->post("noof_night")),
					"CREATED" 		 => date("Y-m-d H:i:s"),
					"MODIFIED" 		 => date("Y-m-d H:i:s")
				);
				$insertCruise = $this->All->insert_template($data_fields, "cruise_title");
				$this->session->set_userdata(
					'addNewCruise',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span>
						New cruise has been added
					</div>'
				);
			}
		}
		else {
			redirect("backend/");
		}
	}

	public function upload_cruise_img_progress()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if (!empty($_FILES)) {
				$tempFile   = $_FILES['file']['tmp_name'];
				$fileName   = $_FILES['file']['name'];
				$fileSize   = $_FILES['file']['size'];
				$fileType   = $_FILES['file']['type'];
				//encrypt
				$array_name   = explode('.', $_FILES['file']['name']);
				$extension    = end($array_name);
				$new_filename = md5(uniqid(rand(), true)).'.'.$extension;
				//end of encrypt
				$targetPath = getcwd().'/assets/cruise_img/';
				$targetFile = $targetPath . $new_filename ;
				move_uploaded_file($tempFile, $targetFile);
				$data_fields = array(
					'cruise_title_id' => $this->input->post("hidden_cruise_title_id"),
					'file_name' => $new_filename,
					'file_type' => $fileSize,
					'file_size' => $fileType,
					'created' 	=> date("Y-m-d H:i:s"),
					'modified' 	=> date("Y-m-d H:i:s")
				);
				$insert_cruiseImg = $this->All->insert_template($data_fields, 'cruise_image');
			}
		}
		else {
			redirect("backend/");
		}
	}

	public function insertLOWDate()
	{
		$date_ruleLast_ID = "";
		//input parameters
		$cruise_brand_id = trim($this->input->post("brand_id"));
		$cruise_ship_id  = trim($this->input->post("shipd_id"));
		$no_of_nights 	 = trim($this->input->post("noof_night"));
		$date_from 	  	 = trim($this->input->post("datepicker_from"));
		$date_to	  	 = trim($this->input->post("datepicker_to"));
		$period_type 	 = trim($this->input->post("period_type"));
		//end of input parameters
		//process
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"
				SELECT * FROM cruise_prices_date_rule
				WHERE cruise_brand_id = ".$cruise_brand_id." AND cruise_ship_id = ".$cruise_ship_id."
				AND no_of_nights = ".$no_of_nights." AND period_type = '".$period_type."'
				AND (date_from BETWEEN '".$date_from."' AND '".$date_to."')
				AND (date_to BETWEEN '".$date_from."' AND '".$date_to."')
			"
		);
		//$num = mysqli_num_rows($check_res);
		if( mysqli_num_rows($check_res) > 0 ) {
			$error_code = 1;
			$message = 'Date already exists in this period. Please choose another date range.';
		}
		else {
			$data_fields = array(
				"cruise_brand_id" => $cruise_brand_id,
				"cruise_ship_id"  => $cruise_ship_id,
				"no_of_nights" 	  => $no_of_nights,
				"date_from" 	  => $date_from,
				"date_to" 		  => $date_to,
				"period_type" 	  => $period_type,
				"created" 		  => date("Y-m-d H:i:s"),
				"modified" 		  => date("Y-m-d H:i:s")
			);
			$insert_dateRule  = $this->All->insert_template($data_fields, "cruise_prices_date_rule");
			$date_ruleLast_ID = $this->db->insert_id();
			$error_code = 0;
			$message = 'Date inserted successfully';
		}
		//end of process
		//message and redirect
		$array = array(
			"errorCode" => $error_code,
			"message"   => $message,
			"fromDate"	=> date("Y-F-d", strtotime($date_from)),
			"toDate"	=> date("Y-F-d", strtotime($date_to)),
			"dateID"	=> $date_ruleLast_ID
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function insertSHOULDERDate()
	{
		$date_ruleLast_ID = "";
		//input parameters
		$cruise_brand_id = trim($this->input->post("brand_id"));
		$cruise_ship_id  = trim($this->input->post("shipd_id"));
		$no_of_nights 	 = trim($this->input->post("noof_night"));
		$date_from 	  	 = trim($this->input->post("datepicker_from"));
		$date_to	  	 = trim($this->input->post("datepicker_to"));
		$period_type 	 = trim($this->input->post("period_type"));
		//end of input parameters
		//process
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"
				SELECT * FROM cruise_prices_date_rule
				WHERE cruise_brand_id = ".$cruise_brand_id." AND cruise_ship_id = ".$cruise_ship_id."
				AND no_of_nights = ".$no_of_nights." AND period_type = '".$period_type."'
				AND (date_from BETWEEN '".$date_from."' AND '".$date_to."')
				AND (date_to BETWEEN '".$date_from."' AND '".$date_to."')
			"
		);
		if(mysqli_num_rows($check_res) > 0) {
			$error_code = 1;
			$message = 'Date already exists in this period. Please choose another date range.';
		}
		else {
			$data_fields = array(
				"cruise_brand_id" => $cruise_brand_id,
				"cruise_ship_id"  => $cruise_ship_id,
				"no_of_nights" 	  => $no_of_nights,
				"date_from" 	  => $date_from,
				"date_to" 		  => $date_to,
				"period_type" 	  => $period_type,
				"created" 		  => date("Y-m-d H:i:s"),
				"modified" 		  => date("Y-m-d H:i:s")
			);
			$insert_dateRule = $this->All->insert_template($data_fields, "cruise_prices_date_rule");
			$date_ruleLast_ID = $this->db->insert_id();
			$error_code = 0;
			$message = 'Date inserted successfully';
		}
		//end of process
		//message and redirect
		$array = array(
			"errorCode" => $error_code,
			"message"   => $message,
			"fromDate"	=> date("Y-F-d", strtotime($date_from)),
			"toDate"	=> date("Y-F-d", strtotime($date_to)),
			"dateID"	=> $date_ruleLast_ID
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function insertPEAKDate()
	{
		$date_ruleLast_ID = "";
		//input parameters
		$cruise_brand_id = trim($this->input->post("brand_id"));
		$cruise_ship_id  = trim($this->input->post("shipd_id"));
		$no_of_nights 	 = trim($this->input->post("noof_night"));
		$date_from 	  	 = trim($this->input->post("datepicker_from"));
		$date_to	  	 = trim($this->input->post("datepicker_to"));
		$period_type 	 = trim($this->input->post("period_type"));
		//end of input parameters
		//process
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"
				SELECT * FROM cruise_prices_date_rule
				WHERE cruise_brand_id = ".$cruise_brand_id." AND cruise_ship_id = ".$cruise_ship_id."
				AND no_of_nights = ".$no_of_nights." AND period_type = '".$period_type."'
				AND (date_from BETWEEN '".$date_from."' AND '".$date_to."')
				AND (date_to BETWEEN '".$date_from."' AND '".$date_to."')
			"
		);
		if(mysqli_num_rows($check_res) > 0) {
			$error_code = 1;
			$message = 'Date already exists in this period. Please choose another date range.';
		}
		else {
			$data_fields = array(
				"cruise_brand_id" => $cruise_brand_id,
				"cruise_ship_id"  => $cruise_ship_id,
				"no_of_nights" 	  => $no_of_nights,
				"date_from" 	  => $date_from,
				"date_to" 		  => $date_to,
				"period_type" 	  => $period_type,
				"created" 		  => date("Y-m-d H:i:s"),
				"modified" 		  => date("Y-m-d H:i:s")
			);
			$insert_dateRule = $this->All->insert_template($data_fields, "cruise_prices_date_rule");
			$date_ruleLast_ID = $this->db->insert_id();
			$error_code = 0;
			$message = 'Date inserted successfully';
		}
		//end of process
		//message and redirect
		$array = array(
			"errorCode" => $error_code,
			"message"   => $message,
			"fromDate"	=> date("Y-F-d", strtotime($date_from)),
			"toDate"	=> date("Y-F-d", strtotime($date_to)),
			"dateID"	=> $date_ruleLast_ID
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function deleteDateLoW()
	{
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_prices_date_rule");
	}

	public function deleteDateSHOULDER()
	{
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_prices_date_rule");
	}

	public function deleteDatePEAK()
	{
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_prices_date_rule");
	}

	public function deleteExtraChargeSTT()
	{
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_stateroom_extra_charge");
	}

	public function deleteDiscountSTT()
	{
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_stateroom_discount");
	}

	public function insertSTTDiscount()
	{
		//input parameters
		$sttID 		 = trim($this->input->post("sttID"));
		$sttDiscount = trim($this->input->post("sttDiscount"));
		//end of input parameters
		//process
		$data_fields = array(
			"discount_value" => trim($sttDiscount),
			"stateroom_id"	 => $sttID,
			"created" 		 => date("Y-m-d H:i:s"),
			"modified" 		 => date("Y-m-d H:i:s")
		);
		$insert_discount = $this->All->insert_template($data_fields, "cruise_stateroom_discount");
		$discountLast_ID = $this->db->insert_id();
		$error_code = 0;
		$message = 'Discount value inserted successfully';
		//end of process
		//message and redirect
		$array = array(
			"errorCode" 	=> $error_code,
			"message"   	=> $message,
			"discountID"    => $discountLast_ID,
			"discountValue" => trim(number_format($sttDiscount), 2),
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function insertSTTExtraCharge()
	{
		//input parameters
		$sttID = trim($this->input->post("sttID"));
		$sttChargeName  = trim($this->input->post("sttChargeName"));
		$sttChargePrice = trim($this->input->post("sttChargePrice"));
		//end of input parameters
		//process
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"
				SELECT * FROM cruise_stateroom_extra_charge
				WHERE stateroom_id = ".$sttID." AND extra_name = '".$sttChargeName."'
			"
		);
		$num = mysqli_num_rows($check_res);
		if( $num ) {
			$error_code = 1;
			$message = "This extra charge name has been added before";
		}
		else {
			$data_fields = array(
				"extra_name" 		=> trim($sttChargeName),
				"extra_price_value" => trim($sttChargePrice),
				"stateroom_id"		=> $sttID,
				"created" 		  	=> date("Y-m-d H:i:s"),
				"modified" 		  	=> date("Y-m-d H:i:s")
			);
			$insert_extraCharge = $this->All->insert_template($data_fields, "cruise_stateroom_extra_charge");
			$error_code = 0;
			$message = 'Extra charge inserted successfully';
		}
		//end of process
		//message and redirect
		$array = array(
			"errorCode" 	  => $error_code,
			"message"   	  => $message,
			"extraPriceName"  => trim($sttChargeName),
			"extraPriceValue" => trim(number_format($sttChargePrice), 2),
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function insertLOWExtraCharge()
	{
		$extraCharga_ruleLast_ID = "";
		//input parameters
		$cruise_brand_id  = trim($this->input->post("brand_id"));
		$cruise_ship_id   = trim($this->input->post("shipd_id"));
		$no_of_nights 	  = trim($this->input->post("noof_night"));
		$low_charge_name  = trim($this->input->post("low_charge_name"));
		$low_charge_price = number_format(trim($this->input->post("low_charge_price")), 2);
		$period_type 	  = trim($this->input->post("period_type"));
		$stateroomID 	  = trim($this->input->post("stateroomID"));
		//end of input parameters
		//process
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"
				SELECT * FROM cruise_extra_price
				WHERE cruise_brand_id = ".$cruise_brand_id." AND cruise_ship_id = ".$cruise_ship_id."
				AND no_of_nights = ".$no_of_nights." AND period_type = '".$period_type."' AND stateroomID = ".$stateroomID."
				AND extra_price_name = '".$low_charge_name."'
			"
		);
		$num = mysqli_num_rows($check_res);
		if( $num ) {
			$error_code = 1;
			$message = 'This extra charge name has been added before';
		}
		else {
			$data_fields = array(
				"cruise_brand_id" 	=> $cruise_brand_id,
				"cruise_ship_id"  	=> $cruise_ship_id,
				"no_of_nights" 	  	=> $no_of_nights,
				"stateroomID"		=> $stateroomID,
				"extra_price_name" 	=> trim($low_charge_name),
				"extra_price_value" => trim($low_charge_price),
				"period_type" 	  	=> $period_type,
				"created" 		  	=> date("Y-m-d H:i:s"),
				"modified" 		  	=> date("Y-m-d H:i:s")
			);
			$insert_extraCharge = $this->All->insert_template($data_fields, "cruise_extra_price");
			$extraCharga_ruleLast_ID = $this->db->insert_id();
			$error_code = 0;
			$message = 'Extra charge inserted successfully';
		}
		//end of process
		//message and redirect
		$array = array(
			"errorCode" 	  => $error_code,
			"message"   	  => $message,
			"stateroomID"	  => $stateroomID,
			"extraPriceID"	  => $extraCharga_ruleLast_ID,
			"extraPriceName"  => trim($low_charge_name),
			"extraPriceValue" => trim($low_charge_price),
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function insertSHOULDERExtraCharge()
	{
		$extraCharga_ruleLast_ID = "";
		//input parameters
		$cruise_brand_id  	   = trim($this->input->post("brand_id"));
		$cruise_ship_id   	   = trim($this->input->post("shipd_id"));
		$no_of_nights 	  	   = trim($this->input->post("noof_night"));
		$shoulder_charge_name  = trim($this->input->post("shoulder_charge_name"));
		$shoulder_charge_price = number_format(trim($this->input->post("shoulder_charge_price")), 2);
		$period_type 	  = trim($this->input->post("period_type"));
		$stateroomID 	  = trim($this->input->post("stateroomID"));
		//end of input parameters
		//process
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"
				SELECT * FROM cruise_extra_price
				WHERE cruise_brand_id = ".$cruise_brand_id." AND cruise_ship_id = ".$cruise_ship_id."
				AND no_of_nights = ".$no_of_nights." AND period_type = '".$period_type."' AND stateroomID = ".$stateroomID."
				AND extra_price_name = '".$shoulder_charge_name."'
			"
		);
		$num = mysqli_num_rows($check_res);
		if( $num ) {
			$error_code = 1;
			$message = 'This extra charge name has been added before';
		}
		else {
			$data_fields = array(
				"cruise_brand_id" 	=> $cruise_brand_id,
				"cruise_ship_id"  	=> $cruise_ship_id,
				"no_of_nights" 	  	=> $no_of_nights,
				"stateroomID"		=> $stateroomID,
				"extra_price_name" 	=> trim($shoulder_charge_name),
				"extra_price_value" => trim($shoulder_charge_price),
				"period_type" 	  	=> $period_type,
				"created" 		  	=> date("Y-m-d H:i:s"),
				"modified" 		  	=> date("Y-m-d H:i:s")
			);
			$insert_extraCharge = $this->All->insert_template($data_fields, "cruise_extra_price");
			$extraCharga_ruleLast_ID = $this->db->insert_id();
			$error_code = 0;
			$message = 'Extra charge inserted successfully';
		}
		//end of process
		//message and redirect
		$array = array(
			"errorCode" 	  => $error_code,
			"message"   	  => $message,
			"stateroomID"	  => $stateroomID,
			"extraPriceID"	  => $extraCharga_ruleLast_ID,
			"extraPriceName"  => trim($shoulder_charge_name),
			"extraPriceValue" => trim($shoulder_charge_price),
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function insertPEAKExtraCharge()
	{
		$extraCharga_ruleLast_ID = "";
		//input parameters
		$cruise_brand_id   = trim($this->input->post("brand_id"));
		$cruise_ship_id    = trim($this->input->post("shipd_id"));
		$no_of_nights 	   = trim($this->input->post("noof_night"));
		$peak_charge_name  = trim($this->input->post("peak_charge_name"));
		$peak_charge_price = number_format(trim($this->input->post("peak_charge_price")), 2);
		$period_type 	   = trim($this->input->post("period_type"));
		$stateroomID 	  = trim($this->input->post("stateroomID"));
		//end of input parameters
		//process
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"
				SELECT * FROM cruise_extra_price
				WHERE cruise_brand_id = ".$cruise_brand_id." AND cruise_ship_id = ".$cruise_ship_id."
				AND no_of_nights = ".$no_of_nights." AND period_type = '".$period_type."' AND stateroomID = ".$stateroomID."
				AND extra_price_name = '".$peak_charge_name."'
			"
		);
		$num = mysqli_num_rows($check_res);
		if( $num ) {
			$error_code = 1;
			$message = 'This extra charge name has been added before';
		}
		else {
			$data_fields = array(
				"cruise_brand_id" 	=> $cruise_brand_id,
				"cruise_ship_id"  	=> $cruise_ship_id,
				"no_of_nights" 	  	=> $no_of_nights,
				"stateroomID"		=> $stateroomID,
				"extra_price_name" 	=> trim($peak_charge_name),
				"extra_price_value" => trim($peak_charge_price),
				"period_type" 	  	=> $period_type,
				"created" 		  	=> date("Y-m-d H:i:s"),
				"modified" 		  	=> date("Y-m-d H:i:s")
			);
			$insert_extraCharge = $this->All->insert_template($data_fields, "cruise_extra_price");
			$extraCharga_ruleLast_ID = $this->db->insert_id();
			$error_code = 0;
			$message = 'Extra charge inserted successfully';
		}
		//end of process
		//message and redirect
		$array = array(
			"errorCode" 	  => $error_code,
			"message"   	  => $message,
			"stateroomID"	  => $stateroomID,
			"extraPriceID"	  => $extraCharga_ruleLast_ID,
			"extraPriceName"  => trim($peak_charge_name),
			"extraPriceValue" => trim($peak_charge_price),
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function deleteExtraChargeLoW()
	{
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_extra_price");
	}

	public function deleteExtraChargeSHOULDER()
	{
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_extra_price");
	}

	public function deleteExtraChargePEAK()
	{
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_extra_price");
	}

	public function update_cruiseDetails()
	{
		//input parameters
		$cruiseTourCode = trim($this->input->post("cruiseTourCode"));
		$cruiseTitleID 	= trim($this->input->post("cruiseTitleID"));
		$brandID   		= trim($this->input->post("brandID"));
		$shipID    		= trim($this->input->post("shipID"));
		$noof_night 	= trim($this->input->post("noof_night"));
		$ship_title  	= trim($this->input->post("ship_title"));
		$ship_desc	 	= trim($this->input->post("ship_desc"));
		$departure_port = trim($this->input->post("departure_port"));
		$departure_date = trim($this->input->post("departure_date"));
		$ports_of_call 	= trim($this->input->post("ports_of_call"));
		//end of input parameters
		//process
		$data_fields = array(
			"CRUISE_TOUR_CODE" => $cruiseTourCode,
			"CRUISE_TITLE" 	   => $ship_title,
			"CRUISE_DESC" 	   => $ship_desc,
			"DEPARTURE_PORT"   => $departure_port,
			"DEPARTURE_DATE"   => $departure_date,
			"PORTS_OF_CALL"    => $ports_of_call,
			"MODIFIED" 		   => date("Y-m-d H:i:s")
		);
		$insert_extraCharge = $this->All->update_template($data_fields, "ID", $cruiseTitleID, "cruise_title");
		$error_code = 0;
		$message = 'Cruise detail(s) info has been updated';
		/*
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"SELECT * FROM cruise_title WHERE CRUISE_TITLE = '".$ship_title."'"
		);
		$num = mysqli_num_rows($check_res);
		if( $num ) {
			$error_code = 1;
			$message = 'This cruise title has been added before. Please choose another title';
		}
		else {
			$data_fields = array(
				"CRUISE_TOUR_CODE" => $cruiseTourCode,
				"CRUISE_TITLE" 	   => $ship_title,
				"CRUISE_DESC" 	   => $ship_desc,
				"DEPARTURE_PORT"   => $departure_port,
				"DEPARTURE_DATE"   => $departure_date,
				"PORTS_OF_CALL"    => $ports_of_call,
				"MODIFIED" 		   => date("Y-m-d H:i:s")
			);
			$insert_extraCharge = $this->All->update_template($data_fields, "ID", $cruiseTitleID, "cruise_title");
			$error_code = 0;
			$message = 'Cruise detail(s) info has been updated';
		}
		*/
		//end of process
		//message and redirect
		$array = array(
			"errorCode" => $error_code,
			"message"   => $message,
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function insert_landtourItinerary()
	{
		//input parameters
		$landtourProductID    = trim($this->input->post("landtourProductID"));
		$itinerary_day   	  = trim($this->input->post("itinerary_day"));
		$itinerary_day 		  = str_replace("Day ", "", $itinerary_day);
		$itinerary_title      = trim($this->input->post("itinerary_title"));
		$itinerary_desc   	  = trim($this->input->post("itinerary_desc"));
		$itinerary_extra_info = trim($this->input->post("itinerary_extra_info"));
		//end of input parameters
		//process insert
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"
				SELECT * FROM landtour_itinerary
				WHERE landtour_product_id = ".$landtourProductID." AND itinerary_day_no = '".$itinerary_day."'
			"
		);
		$num = mysqli_num_rows($check_res);
		if( $num ) {
			$error_code = 1;
			$message = 'Day no. has been used. Please try another day.';
		}
		else {
			$data_fields = array(
				"landtour_product_id"  => $landtourProductID,
				"itinerary_day_no" 	   => $itinerary_day,
				"itinerary_title" 	   => $itinerary_title,
				"itinerary_desc" 	   => $itinerary_desc,
				"itinerary_extra_info" => $itinerary_extra_info,
				"created"		  	   => date("Y-m-d H:i:s"),
				"modified"		  	   => date("Y-m-d H:i:s")
			);
			$insert_landtourItinerary = $this->All->insert_template($data_fields, "landtour_itinerary");
			$lastItinerary_ID = $this->db->insert_id();
			$error_code = 0;
			$message = 'New land tour itinerary has been added';
		}
		//end of process insert
		//message and redirect
		$array = array(
			"errorCode" 		   => $error_code,
			"lastItinerary_ID"     => $lastItinerary_ID,
			"message"   		   => $message,
			"itinerary_day"  	   => $itinerary_day,
			"itinerary_title"  	   => $itinerary_title,
			"itinerary_desc"       => $itinerary_desc,
			"itinerary_extra_info" => $itinerary_extra_info
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function insert_cruiseItinerary()
	{
		//input parameters
		$cruiseTitleID   = trim($this->input->post("cruiseTitleID"));
		$dayItinerary    = trim($this->input->post("dayItinerary"));
		$portItinerary   = trim($this->input->post("portItinerary"));
		$arrivalTime     = trim($this->input->post("arrivalTime"));
		$departureTime   = trim($this->input->post("departureTime"));
		$remarkItinerary = trim($this->input->post("remarkItinerary"));
		//end of input parameters
		//process insert
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"SELECT * FROM cruise_itinerary WHERE CRUISE_TITLE_ID = ".$cruiseTitleID." AND DAY = '".$dayItinerary."'"
		);
		$num = mysqli_num_rows($check_res);
		if( $num ) {
			$error_code = 1;
			$message = 'Day no. has been used. Please try another day.';
		}
		else {
			//day no max
			$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			$maxno_res  = mysqli_query(
				$connection,
				"SELECT DAY FROM cruise_itinerary WHERE CRUISE_TITLE_ID = ".$cruiseTitleID." ORDER BY DAY DESC LIMIT 0,1"
			);
			if( mysqli_num_rows($maxno_res) > 0 ) {
				$maxno_row = mysqli_fetch_array($maxno_res, MYSQL_ASSOC);
				$maxDay = $maxno_row["DAY"]+1;
			}
			else {
				$maxDay = 1;
			}
			//end of day no max
			$data_fields = array(
				"CRUISE_TITLE_ID" => $cruiseTitleID,
				"DAY" 	 		  => $maxDay,
				"PORT" 			  => $portItinerary,
				"ARRIVAL_TIME" 	  => $arrivalTime,
				"DEPARTURE_TIME"  => $departureTime,
				"REMARK"		  => $remarkItinerary
			);
			$insert_cruiseItinerary = $this->All->insert_template($data_fields, "cruise_itinerary");
			$cruiseLast_ID = $this->db->insert_id();
			$error_code = 0;
			$message = 'New cruise itnerary has been added';
		}
		//end of process insert
		//message and redirect
		$array = array(
			"errorCode" 		 => $error_code,
			"cruiseItineraryID"  => $cruiseLast_ID,
			"message"   		 => $message,
			"dayPrint"  		 => $maxDay,
			"portPrint"  		 => $portItinerary,
			"arrivalTimePrint"   => $arrivalTime,
			"departureTimePrint" => $departureTime,
			"remarkItinerary"	 => $remarkItinerary,
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function deleteItineraryDetails()
	{
		$delete = $this->All->delete_template("ID", $this->uri->segment(4), "cruise_itinerary");
	}

	public function deleteCruiseImage()
	{
		$details = $this->All->select_template('id', $this->uri->segment(4), 'cruise_image');
		if( $details == TRUE ) {
			foreach( $details AS $detail ) {
				$file_name = $detail->file_name;
				unlink("assets/cruise_img/".$file_name);
			}
		}
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_image");
	}

	public function deleteCruisePDF()
	{
		$details = $this->All->select_template('id', $this->uri->segment(4), 'cruise_pdf');
		if( $details == TRUE ) {
			foreach( $details AS $detail ) {
				$file_name = $detail->file_name;
				unlink("assets/cruise_pdf/".$file_name);
			}
		}
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_pdf");
	}

	public function uploadImage()
	{
		if (!empty($_FILES)) {
			$tempFile   = $_FILES['file']['tmp_name'];
			$fileName   = $_FILES['file']['name'];
			$fileSize   = $_FILES['file']['size'];
			$fileType   = $_FILES['file']['type'];
			//encrypt
			$array_name   = explode('.', $_FILES['file']['name']);
			$extension    = end($array_name);
			$new_filename = md5(uniqid(rand(), true)).'.'.$extension;
			//end of encrypt
			$targetPath = getcwd().'/assets/cruise_img/';
			$targetFile = $targetPath . $new_filename ;
			move_uploaded_file($tempFile, $targetFile);
			$data_fields = array(
				'cruise_title_id' => $this->uri->segment(4),
				'file_name' 	  => $new_filename,
				'file_type' 	  => $fileSize,
				'file_size' 	  => $fileType,
				'created' 		  => date("Y-m-d H:i:s"),
				'modified' 		  => date("Y-m-d H:i:s")
			);
			$insert_image = $this->All->insert_template($data_fields, 'cruise_image');
			$image_last_id = $this->db->insert_id();
			//message and redirect
			$array = array(
				"fileID"      => $image_last_id,
				"fileName"    => $new_filename,
				"fileType"    => $fileType,
				"fileSize"    => $fileSize,
				"fileCreated" => date("Y-m-d H:i:s")
			);
			echo json_encode($array);
			//end of message and redirect
		}
	}

	public function uploadPDF()
	{
		if (!empty($_FILES)) {
			$tempFile   = $_FILES['file']['tmp_name'];
			$fileName   = $_FILES['file']['name'];
			$fileSize   = $_FILES['file']['size'];
			$fileType   = $_FILES['file']['type'];
			//encrypt
			$array_name   = explode('.', $_FILES['file']['name']);
			$extension    = end($array_name);
			$new_filename = md5(uniqid(rand(), true)).'.'.$extension;
			//end of encrypt
			$targetPath = getcwd().'/assets/cruise_pdf/';
			$targetFile = $targetPath . $new_filename ;
			move_uploaded_file($tempFile, $targetFile);
			$data_fields = array(
				'cruise_title_id' => $this->uri->segment(4),
				'file_name' 	  => $new_filename,
				'file_type' 	  => $fileSize,
				'file_size' 	  => $fileType,
				'created' 		  => date("Y-m-d H:i:s"),
				'modified' 		  => date("Y-m-d H:i:s")
			);
			$insert_pdf  = $this->All->insert_template($data_fields, 'cruise_pdf');
			$pdf_last_id = $this->db->insert_id();
			//message and redirect
			$array = array(
				"fileID"      => $pdf_last_id,
				"fileName"    => $new_filename,
				"fileType"    => $fileType,
				"fileSize"    => $fileSize,
				"fileCreated" => date("Y-m-d H:i:s")
			);
			echo json_encode($array);
			//end of message and redirect
		}
	}

	public function setPrimaryImage()
	{
		$imageID 	   = $this->uri->segment(4);
		$cruiseTitleID = $this->uri->segment(5);
		//set into primary image
		$data_fieldsPR = array(
			"imgStatus" => "PRIMARY",
			"modified"  => date("Y-m-d H:i:s")
		);
		$update_PR = $this->All->update_template($data_fieldsPR, "id", $imageID, "cruise_image");
		//end of set into primary image
		//set other images become default
		$data_fieldsNotPR = array(
			"imgStatus" => "DEFAULT",
			"modified"  => date("Y-m-d H:i:s")
		);
		$update_NotPR = $this->All->update_template_two(
			$data_fieldsNotPR, "id !=", $imageID, "cruise_title_id", $cruiseTitleID, "cruise_image"
		);
		//end of set other images become default
		//session and redirect
		$this->session->set_flashdata(
			'setPrimaryImage_session',
			'<div class="alert alert-success alert-bordered">
				<button type="button" class="close" data-dismiss="alert">
					<span>&times;</span><span class="sr-only">Close</span>
				</button>
				<span class="text-semibold">Well done!</span>
				Action updated!
			</div>'
		);
		redirect("backend/product/cruise_overview/".$cruiseTitleID);
		//end of session and redirect
	}

	public function updateIndividualStateroom()
	{
		//input parameters
		$titleID 	  = $this->input->post("titleID");
		$shipID 	  = $this->input->post("shipID");
		$brandID 	  = $this->input->post("brandID");
		$stateroomID  = $this->input->post("sttID");
		$stateroomQTY = $this->input->post("qty");
		//end of input parameters
		$staterooms = $this->All->select_template_w_4_conditions(
			"cruise_title_id", $titleID, "cruise_ship_id", $shipID, "cruise_brand_id", $brandID, "stateroom_id", $stateroomID,
			"cruise_title_stateroom_qty"
		);
		if( $staterooms == TRUE ) {
			foreach( $staterooms AS $stateroom ) {
				$stateroom_qty_ID = $stateroom->id;
			}
			//update
			$data_fields = array(
				"quantity" => $stateroomQTY,
				"modified" => date("Y-m-d H:i:s")
			);
			$updateStateroom = $this->All->update_template($data_fields, "ID", $stateroom_qty_ID, "cruise_title_stateroom_qty");
			$error_code = 0;
			$message = 'Stateroom quantity has been updated';
			//end of update
		}
		else {
			$data_fields = array(
				"cruise_title_id" => $titleID,
				"cruise_ship_id"  => $shipID,
				"cruise_brand_id" => $brandID,
				"stateroom_id" 	  => $stateroomID,
				"quantity" 		  => $stateroomQTY,
				"created" 		  => date("Y-m-d H:i:s"),
				"modified" 		  => date("Y-m-d H:i:s")
			);
			$insertStateroomQty = $this->All->insert_template($data_fields, "cruise_title_stateroom_qty");
			$stateroom_qty_ID   = $this->db->insert_id();
			$error_code = 0;
			$message = 'Stateroom quantity has been updated';
		}
		//message and redirect
		$array = array(
			"errorCode" => $error_code,
			"message"   => $message,
			"stateID"   => $stateroom_qty_ID,
			"stateQty"  => $stateroomQTY
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function updateNewStateroom()
	{
		//input parameters
		$stateroomID 	   = trim($this->input->post("sttID"));
		$stateroomName     = trim($this->input->post("sttName"));
		$stateroomOccupant = trim($this->input->post("sttOccupant"));
		//end of input parameters
		//update
		$data_fields = array(
			"STATEROOM_NAME" 	 => $stateroomName,
			"STATEROOM_OCCUPANT" => $stateroomOccupant,
			"LAST_UPDATED" 		 => date("Y-m-d H:i:s")
		);
		$updateStateroom = $this->All->update_template($data_fields, "ID", $stateroomID, "cruise_stateroom");
		$error_code = 0;
		$message = 'Stateroom details has been updated';
		//end of update
		//message and redirect
		$array = array(
			"errorCode" 	=> $error_code,
			"message"   	=> $message,
			"stateName" 	=> $stateroomName,
			"stateOccupant" => $stateroomOccupant
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function insertNewStateroom()
	{
		//input parameters
		$brandID 		   = trim($this->input->post("brandID"));
		$shipID   		   = trim($this->input->post("shipID"));
		$stateroomName     = trim($this->input->post("stateroomName"));
		$stateroomOccupant = trim($this->input->post("stateroomOccupant"));
		//end of input parameters
		/*
		$checkNames = $this->All->select_template_w_2_conditions(
			"CRUISE_BRAND_ID", $brandID, "STATEROOM_NAME", $stateroomName,
			"cruise_stateroom"
		);
		if( $checkNames == TRUE ) {
			$error_code = 1;
			$message = 'Stateroom name has been used before. Please choose another stateroom name.';
			$stateroomLast_ID = "";
		}
		else {
			$checkNamesTwo = $this->All->select_template_w_2_conditions(
				"CRUISE_SHIP_ID", $shipID, "STATEROOM_NAME", $stateroomName,
				"cruise_stateroom"
			);
			if( $checkNamesTwo == TRUE ) {
				$error_code = 1;
				$message = 'Stateroom name has been used before. Please choose another stateroom name.';
				$stateroomLast_ID = "";
			}
			else {
				$data_fields = array(
					"CRUISE_BRAND_ID" 	 => $brandID,
					"CRUISE_SHIP_ID" 	 => $shipID,
					"STATEROOM_NAME" 	 => $stateroomName,
					"STATEROOM_OCCUPANT" => $stateroomOccupant,
					"LAST_UPDATED" 		 => date("Y-m-d H:i:s")
				);
				$insertStateroom  = $this->All->insert_template($data_fields, "cruise_stateroom");
				$stateroomLast_ID = $this->db->insert_id();
				$error_code = 0;
				$message = 'New stateroom has been added';
			}
		}
		*/
		$checkNamesTwo = $this->All->select_template_w_2_conditions(
			"CRUISE_SHIP_ID", $shipID, "STATEROOM_NAME", $stateroomName,
			"cruise_stateroom"
		);
		if( $checkNamesTwo == TRUE ) {
			$error_code = 1;
			$message = 'Stateroom name has been used before. Please choose another stateroom name.';
			$stateroomLast_ID = "";
		}
		else {
			$data_fields = array(
				"CRUISE_BRAND_ID" 	 => $brandID,
				"CRUISE_SHIP_ID" 	 => $shipID,
				"STATEROOM_NAME" 	 => $stateroomName,
				"STATEROOM_OCCUPANT" => $stateroomOccupant,
				"LAST_UPDATED" 		 => date("Y-m-d H:i:s")
			);
			$insertStateroom  = $this->All->insert_template($data_fields, "cruise_stateroom");
			$stateroomLast_ID = $this->db->insert_id();
			$error_code = 0;
			$message = 'New stateroom has been added';
		}
		//message and redirect
		$array = array(
			"errorCode" 	=> $error_code,
			"message"   	=> $message,
			"stateRoomID"   => $stateroomLast_ID,
			"stateName"   	=> $stateroomName,
			"stateOccupant" => $stateroomOccupant
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function doStateroomOrder()
	{
		$sectionids = $this->input->post("sectionsid");
        $count 		= 1;
        if( is_array($sectionids) ) {
            foreach( $sectionids as $sectionid ) {
	            $data_fields = array(
		            "orderNo" 	   => $count,
		            "LAST_UPDATED" => date("Y-m-d H:i:s")
	            );
	            $updateOrder = $this->All->update_template($data_fields, "ID", $sectionid, "cruise_stateroom");
                $count++;
            }
            echo '{"status":"success"}';
        }
        else {
            echo '{"status":"failure", "message":"No Update happened. Could be an internal error, please try again."}';
        }
	}

	public function deleteChildAgeRule()
	{
		$cruiseTitleID = $this->uri->segment(4);
		$deleteRule = $this->All->delete_template("cruise_title_id", $cruiseTitleID, "cruise_child_age");
		$this->session->set_flashdata(
			'childAgeRule_delete',
			'<div class="alert alert-success alert-bordered">
				<button type="button" class="close" data-dismiss="alert">
					<span>&times;</span><span class="sr-only">Close</span>
				</button>
				<span class="text-semibold">Well done!</span>
				Rule has been deleted
			</div>'
		);
		redirect("backend/product/cruise_overview/".$cruiseTitleID);
	}

	public function childAgeNew()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$checks = $this->All->select_template("cruise_title_id", $this->input->post("hiddenCruiseTitleID"), "cruise_child_age");
			if( $checks == TRUE ) {
				$this->session->set_flashdata(
					'childAgeRule_error',
					'<div class="alert alert-danger alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Notification!</span>
						In order to add new rule for child age, please delete the old rule
					</div>'
				);
				redirect("backend/product/cruise_overview/".$this->input->post("hiddenCruiseTitleID"));
			}
			else {
				$data_fields = array(
					"cruise_title_id"  => $this->input->post("hiddenCruiseTitleID"),
					"child_age_value"  => $this->input->post("value_child_age_form"),
					"child_age_status" => $this->input->post("status_child_age_form"),
					"created" 		   => date("Y-m-d H:i:s"),
					"modified" 		   => date("Y-m-d H:i:s")
				);
				$insertAge = $this->All->insert_template($data_fields, "cruise_child_age");
				$this->session->set_flashdata(
					'childAgeRule_session',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span>
						New rule for child age has been added
					</div>'
				);
				redirect("backend/product/cruise_overview/".$this->input->post("hiddenCruiseTitleID"));
			}
		}
		else {
			redirect("backend/product/cruise_index");
		}
	}

	public function insertLOWDiscount()
	{
		$date_ruleLast_ID = "";
		//input parameters
		$cruise_brand_id = trim($this->input->post("brand_id"));
		$cruise_ship_id  = trim($this->input->post("shipd_id"));
		$no_of_nights 	 = trim($this->input->post("noof_night"));
		$discount_price  = trim($this->input->post("discount_price"));
		$stateroomID	 = trim($this->input->post("stateroomID"));
		$period_type 	 = trim($this->input->post("period_type"));
		//end of input parameters
		//insert discount
		$data_fields = array(
			"cruise_brand_id" 	=> $cruise_brand_id,
			"cruise_ship_id"  	=> $cruise_ship_id,
			"no_of_nights" 	  	=> $no_of_nights,
			"stateroomID" 		=> trim($stateroomID),
			"extra_price_value" => trim($discount_price),
			"period_type" 	  	=> $period_type,
			"created" 		  	=> date("Y-m-d H:i:s"),
			"modified" 		  	=> date("Y-m-d H:i:s")
		);
		$insert_extraCharge   = $this->All->insert_template($data_fields, "cruise_discount");
		$discount_ruleLast_ID = $this->db->insert_id();
		$error_code = 0;
		//end of insert discount
		//message and redirect
		$array = array(
			"errorCode" 	  	 => $error_code,
			"stateroomID"	  	 => $stateroomID,
			"discountPriceID" 	 => $discount_ruleLast_ID,
			"discountPriceValue" => number_format($discount_price, 2),
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function insertSHOULDERDiscount()
	{
		$date_ruleLast_ID = "";
		//input parameters
		$cruise_brand_id = trim($this->input->post("brand_id"));
		$cruise_ship_id  = trim($this->input->post("shipd_id"));
		$no_of_nights 	 = trim($this->input->post("noof_night"));
		$discount_price  = trim($this->input->post("discount_price"));
		$stateroomID	 = trim($this->input->post("stateroomID"));
		$period_type 	 = trim($this->input->post("period_type"));
		//end of input parameters
		//insert discount
		$data_fields = array(
			"cruise_brand_id" 	=> $cruise_brand_id,
			"cruise_ship_id"  	=> $cruise_ship_id,
			"no_of_nights" 	  	=> $no_of_nights,
			"stateroomID" 		=> trim($stateroomID),
			"extra_price_value" => trim($discount_price),
			"period_type" 	  	=> $period_type,
			"created" 		  	=> date("Y-m-d H:i:s"),
			"modified" 		  	=> date("Y-m-d H:i:s")
		);
		$insert_extraCharge   = $this->All->insert_template($data_fields, "cruise_discount");
		$discount_ruleLast_ID = $this->db->insert_id();
		$error_code = 0;
		//end of insert discount
		//message and redirect
		$array = array(
			"errorCode" 	  	 => $error_code,
			"stateroomID"	  	 => $stateroomID,
			"discountPriceID" 	 => $discount_ruleLast_ID,
			"discountPriceValue" => number_format($discount_price, 2),
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function insertPEAKDiscount()
	{
		$date_ruleLast_ID = "";
		//input parameters
		$cruise_brand_id = trim($this->input->post("brand_id"));
		$cruise_ship_id  = trim($this->input->post("shipd_id"));
		$no_of_nights 	 = trim($this->input->post("noof_night"));
		$discount_price  = trim($this->input->post("discount_price"));
		$stateroomID	 = trim($this->input->post("stateroomID"));
		$period_type 	 = trim($this->input->post("period_type"));
		//end of input parameters
		//insert discount
		$data_fields = array(
			"cruise_brand_id" 	=> $cruise_brand_id,
			"cruise_ship_id"  	=> $cruise_ship_id,
			"no_of_nights" 	  	=> $no_of_nights,
			"stateroomID" 		=> trim($stateroomID),
			"extra_price_value" => trim($discount_price),
			"period_type" 	  	=> $period_type,
			"created" 		  	=> date("Y-m-d H:i:s"),
			"modified" 		  	=> date("Y-m-d H:i:s")
		);
		$insert_extraCharge   = $this->All->insert_template($data_fields, "cruise_discount");
		$discount_ruleLast_ID = $this->db->insert_id();
		$error_code = 0;
		//end of insert discount
		//message and redirect
		$array = array(
			"errorCode" 	  	 => $error_code,
			"stateroomID"	  	 => $stateroomID,
			"discountPriceID" 	 => $discount_ruleLast_ID,
			"discountPriceValue" => number_format($discount_price, 2),
		);
		echo json_encode($array);
		//end of message and redirect
	}

	public function deleteDiscountLoW()
	{
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_discount");
	}

	public function deleteDiscountShoulder()
	{
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_discount");
	}

	public function deleteDiscountPeak()
	{
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "cruise_discount");
	}

	public function delete_cruise()
	{
		$cruiseTitleID = $this->uri->segment(4);
		$data_fields = array(
			"IS_SUSPEND" => 1,
			"MODIFIED"	 => date("Y-m-d H:i:s")
		);
		$updateCruise  = $this->All->update_template($data_fields, "ID", $cruiseTitleID, "cruise_title");
		$this->session->set_flashdata(
			'suspendCruise',
			'<div class="alert alert-success alert-bordered">
				<button type="button" class="close" data-dismiss="alert">
					<span>&times;</span><span class="sr-only">Close</span>
				</button>
				<span class="text-semibold">Notification</span>
				Cruise status has been changed into inactive
			</div>'
		);
		redirect("backend/product/cruise_index");
	}

	public function make_cruise_active()
	{
		$cruiseTitleID = $this->uri->segment(4);
		$data_fields = array(
			"IS_SUSPEND" => 0,
			"MODIFIED"	 => date("Y-m-d H:i:s")
		);
		$updateCruise  = $this->All->update_template($data_fields, "ID", $cruiseTitleID, "cruise_title");
		$this->session->set_flashdata(
			'activeCruise',
			'<div class="alert alert-success alert-bordered">
				<button type="button" class="close" data-dismiss="alert">
					<span>&times;</span><span class="sr-only">Close</span>
				</button>
				<span class="text-semibold">Notification</span>
				Cruise status has been changed into active
			</div>'
		);
		redirect("backend/product/cruise_index");
	}

	public function updateStartingPrice()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$data_fields = array(
					"STARTING_PRICE" => $this->input->post("manual_starting_price"),
					"MODIFIED"	 	 => date("Y-m-d H:i:s")
				);
				$update_starting_price = $this->All->update_template(
					$data_fields, "ID", $this->input->post("hidden_cruise_titleID"), "cruise_title"
				);
				$this->session->set_flashdata(
					'updateStartingPrice',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Notification</span>
						Starting price has been updated
					</div>'
				);
				redirect("backend/product/cruise_overview/".$this->input->post("hidden_cruise_titleID"));
			}
			else {
				redirect("backend/product/cruise_index");
			}
		}
		else {
			redirect("backend/");
		}
	}

	public function remove_dx_cruise()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$cruiseTitleID = $this->uri->segment(4);
			$data_fields = array(
				"IS_DELETED" => 1,
				"MODIFIED"   => date("Y-m-d H:i:s")
			);
			$updateDeleted = $this->All->update_template($data_fields, "ID", $cruiseTitleID, "cruise_title");
			//session and redirect
			$this->session->set_flashdata(
				'deleteCruiseTitleSuccess',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Well done!</span>
					Cruise has been deleted!
				</div>'
			);
			redirect("backend/product/cruise_index");
			//end of session and redirect
		}
		else {
			redirect("backend/");
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */