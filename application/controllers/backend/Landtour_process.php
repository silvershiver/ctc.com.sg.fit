<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landtour_process extends CI_Controller {

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
		$this->load->model('landtour');
    }
	
	public function delete_category()
	{
		$categoryID = $this->uri->segment(4);
		$data_fields = array(
			"is_deleted" => 1,
		    "modified" 	 => date("Y-m-d H:i:s")
		);
		$deleteCategory = $this->All->update_template($data_fields, "id", $categoryID, "landtour_category");
		$this->session->set_flashdata(
			'isDeletedLandtourCategory',
			'<div class="alert alert-success alert-bordered">
				<button type="button" class="close" data-dismiss="alert">
					<span>&times;</span><span class="sr-only">Close</span>
				</button>
				<span class="text-semibold">Notification</span> 
				Selected land tour category has been deleted
			</div>'
		);
		redirect("backend/product/landtour_category");
	}
	
	public function delete_cruise_from_list()
	{
		$landtourID = $this->uri->segment(4);
		$data_fields = array(
			"is_deleted" => 1,
		    "modified" 	 => date("Y-m-d H:i:s")
		);
		$updates = $this->All->update_template($data_fields, "id", $landtourID, "landtour_product");
		$this->session->set_flashdata(
			'isDeletedLandtour',
			'<div class="alert alert-success alert-bordered">
				<button type="button" class="close" data-dismiss="alert">
					<span>&times;</span><span class="sr-only">Close</span>
				</button>
				<span class="text-semibold">Notification</span> 
				Selected land tour has been deleted
			</div>'
		);
		redirect("backend/product/landtour_index");
	}
	
	public function doCategoryOrder()
	{
		$sectionids = $this->input->post("sectionsid");
        $count 		= 1;
        if( is_array($sectionids) ) {
            foreach( $sectionids as $sectionid ) {
	            $data_fields = array(
		            "sortNo"   => $count,
		            "modified" => date("Y-m-d H:i:s")
	            );
	            $updateOrder = $this->All->update_template($data_fields, "id", $sectionid, "landtour_category");
                $count++;
            }
            echo '{"status":"success"}';
        } 
        else {
            echo '{"status":"failure", "message":"No Update happened. Could be an internal error, please try again."}';
        }
	}
	
	public function deleteLandtourPDF()
	{
		$details = $this->All->select_template('id', $this->uri->segment(4), 'landtour_pdf');
		if( $details == TRUE ) {
			foreach( $details AS $detail ) {
				$file_name = $detail->file_name;
				unlink("assets/landtour_pdf/".$file_name);
			}
		}
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "landtour_pdf");
		$this->session->set_flashdata(
			'deleteItineraryPDF',
			'<div class="alert alert-success alert-bordered">
				<button type="button" class="close" data-dismiss="alert">
					<span>&times;</span><span class="sr-only">Close</span>
				</button>
				<span class="text-semibold">Notification</span> 
				PDF itinerary has been deleted
			</div>'
		);
		redirect("backend/product/landtour_overview/".$this->uri->segment(5));
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
			$targetPath = getcwd().'/assets/landtour_pdf/';
			$targetFile = $targetPath . $new_filename ;
			move_uploaded_file($tempFile, $targetFile);
			$data_fields = array(
				'landtour_id' => $this->uri->segment(4),
				'file_name'   => $new_filename,
				'file_type'   => $fileSize,
				'file_size'   => $fileType,
				'created' 	  => date("Y-m-d H:i:s"),
				'modified' 	  => date("Y-m-d H:i:s")
			);
			$insert_pdf  = $this->All->insert_template($data_fields, 'landtour_pdf');
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
	
	public function delete_itinerary()
	{
		if( $this->session->userdata('user_session_id') == TRUE ) {	
			$deleteItinerary = $this->All->delete_template("id", $this->uri->segment(4), "landtour_itinerary");
			$this->session->set_flashdata(
				'deleteItinerary',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Notification</span> 
					Selected itinerary has been deleted
				</div>'
			);
			redirect("backend/product/landtour_overview/".$this->uri->segment(5));
		}
		else {
			redirect("backend/");
		}
	}
	
	public function edit_itinerary()
	{
		if( $this->session->userdata('user_session_id') == TRUE ) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$data_fields = array(
					"itinerary_title" 	   => $this->input->post("edit_itinerary_title"),
					"itinerary_desc" 	   => $this->input->post("edit_itinerary_desc"),
					"itinerary_extra_info" => $this->input->post("edit_itinerary_extra_info"),
					"modified"	 	 	   => date("Y-m-d H:i:s")
				);
				$updateItinerary = $this->All->update_template(
					$data_fields, "id", $this->input->post("hidden_itinerary_id"), "landtour_itinerary"
				);
				$this->session->set_flashdata(
					'updateItineraryDetails',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Notification</span> 
						Itinerary details has been updated
					</div>'
				);
				redirect("backend/product/landtour_overview/".$this->input->post("hidden_landtour_productID"));
			}
			else {
				redirect("backend/product/landtour_index");
			}
		}
		else {
			redirect("backend/");
		}
	}
	
	public function insert_category()
	{
		if( $this->session->userdata('user_session_id') == TRUE ) {
			$config = array(
               array( 'field' => 'category_name', 	'rules' => 'required' ), 
			   array( 'field' => 'category_desc', 	'rules' => 'required' ),
			   array( 'field' => 'category_status', 'rules' => 'required' )
            );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_message('required', '* Required');
			$this->form_validation->set_error_delimiters('<span class="form_error">', '</span>');
			if( $this->form_validation->run() == FALSE ) {
				$this->load->view('backend/land_tour/manage_category');
			}
			else {
				$data = array(
				   'category_name'	 => $this->db->escape_str($this->input->post("category_name")),
				   'category_desc' 	 => $this->db->escape_str($this->input->post("category_desc")),
				   'category_status' => $this->db->escape_str($this->input->post("category_status")),
				   'created'  		 => date("Y-m-d H:i:s"),
				   'modified' 		 => date("Y-m-d H:i:s"),
				);
				if( $this->db->insert('landtour_category', $data) ) {
					$alert_string = "<span style='color:green'><b>Category saved</b></span>";
				}
				else {
					$alert_string = "<span style='color:red'><b>Unable to save category, please try again</b></span>";	
				}
				$this->session->set_flashdata('alert', $alert_string);
				redirect('backend/product/landtour_category');
			}	
		}
		else {
			redirect("backend/");
		}
	}
	
	public function update_category()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$data_fields = array(
				"category_name"   => $this->db->escape_str($this->input->post("category_name")),
				"category_desc"   => $this->db->escape_str($this->input->post("category_desc")),
				"category_status" => $this->db->escape_str($this->input->post("category_status")),
				"modified" 		  => date("Y-m-d H:i:s")
			);
			$update = $this->All->update_template(
				$data_fields, "id", $this->input->post("hidden_landtourCategoryID"), "landtour_category"
			);
			$this->session->set_flashdata(
				'updateOK',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Notification</span> 
					Category details has been updated
				</div>'
			);
			redirect("backend/product/landtour_category");
		}
		else {
			redirect("backend/");
		}
	}
	
	public function insert_special_instruction()
	{
		if( $this->session->userdata('user_session_id') == TRUE ) {
			$config = array(
               array( 'field' => 'order_no', 'rules' => 'required' ), 
			   array( 'field' => 'content',  'rules' => 'required' )
            );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_message('required', '* Required');
			$this->form_validation->set_error_delimiters('<span class="form_error">', '</span>');
			if( $this->form_validation->run() == FALSE ) {
				$this->load->view('backend/land_tour/landtour_special_instruction');
			}
			else {
				$data = array(
				   'type' 				 => "LANDTOUR",
				   'order_no' 	  		 => $this->db->escape_str($this->input->post("order_no")),
				   'instruction_content' => $this->db->escape_str($this->input->post("content")),
				   'created'  	  		 => date("Y-m-d H:i:s"),
				   'modified' 	  		 => date("Y-m-d H:i:s"),
				);
				if( $this->db->insert('special_instruction', $data) ) {
					$alert_string = "<span style='color:green'><b>Special instruction saved</b></span>";
				}
				else {
					$alert_string = "<span style='color:red'><b>Unable to save special instruction, please try again</b></span>";	
				}
				$this->session->set_flashdata(
					'insertSpecialInstruction',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						'.$alert_string.'
					</div>'
				);
				redirect("backend/product/landtour_special_instruction");
			}	
		}
		else {
			redirect("backend/");
		}
	}
	
	public function insert_location()
	{
		if( $this->session->userdata('user_session_id') == TRUE ) {
			$config = array(
               array( 'field' => 'country_name', 'rules' => 'required' )
            );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_message('required', '* Required');
			$this->form_validation->set_error_delimiters('<span class="form_error">', '</span>');
			if( $this->form_validation->run() == FALSE ) {
				$this->load->view('backend/land_tour/manage_location');
			}
			else {
				$checks = $this->All->select_template("country_name", $this->input->post("country_name"), "landtour_location");
				if( $checks == TRUE ) {
					$this->session->set_flashdata(
						'wrongInsert',
						'<div class="alert alert-danger alert-bordered">
							<button type="button" class="close" data-dismiss="alert">
								<span>&times;</span><span class="sr-only">Close</span>
							</button>
							Country and city name have been added before. Please choose another inputs.
						</div>'
					);
					redirect("backend/product/landtour_location");
				}
				else {
					$data = array(
					   'country_name' => $this->db->escape_str($this->input->post("country_name")),
					   'city_name' 	  => NULL,
					   'created'  	  => date("Y-m-d H:i:s"),
					   'modified' 	  => date("Y-m-d H:i:s"),
					);
					if( $this->db->insert('landtour_location', $data) ) {
						$alert_string = "<span style='color:green'><b>Location saved</b></span>";
					}
					else {
						$alert_string = "<span style='color:red'><b>Unable to save location, please try again</b></span>";	
					}
					$this->session->set_flashdata(
						'insertLocationOK',
						'<div class="alert alert-success alert-bordered">
							<button type="button" class="close" data-dismiss="alert">
								<span>&times;</span><span class="sr-only">Close</span>
							</button>
							'.$alert_string.'
						</div>'
					);
					redirect("backend/product/landtour_location");
				}
			}	
		}
		else {
			redirect("backend/");
		}
	}
	
	public function update_special_instruction()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$data_fields = array(
				"order_no" => $this->db->escape_str($this->input->post("order_no")),
				"instruction_content" => $this->db->escape_str($this->input->post("content")),
				"modified" => date("Y-m-d H:i:s")
			);
			$update = $this->All->update_template(
				$data_fields, "id", $this->input->post("hidden_specialInstructionID"), "special_instruction"
			);
			$this->session->set_flashdata(
				'updateOK',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Notification</span> 
					Special instruction details has been updated
				</div>'
			);
			redirect("backend/product/landtour_special_instruction");
		}
		else {
			redirect("backend/");
		}
	}
	
	public function update_location()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$data_fields = array(
				"country_name" => $this->db->escape_str($this->input->post("country_name")),
				"city_name"    => $this->db->escape_str($this->input->post("city_name")),
				"modified" 	   => date("Y-m-d H:i:s")
			);
			$update = $this->All->update_template(
				$data_fields, "id", $this->input->post("hidden_landtourLocationID"), "landtour_location"
			);
			$this->session->set_flashdata(
				'updateOK',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Notification</span> 
					Location details has been updated
				</div>'
			);
			redirect("backend/product/landtour_location");
		}
		else {
			redirect("backend/");
		}
	}
	
	public function delete_special_instruction()
	{
		$deleteSpecialInstructionID = $this->uri->segment(4);
		$deleteLocation = $this->All->delete_template("id", $deleteSpecialInstructionID, "special_instruction");
		$this->session->set_flashdata(
			'deleteOK',
			'<div class="alert alert-success alert-bordered">
				<button type="button" class="close" data-dismiss="alert">
					<span>&times;</span><span class="sr-only">Close</span>
				</button>
				<span class="text-semibold">Notification</span> 
				Record has been deleted
			</div>'
		);
		redirect("backend/product/landtour_special_instruction");
	}
	
	public function delete_location()
	{
		$locationID 	= $this->uri->segment(4);
		$deleteLocation = $this->All->delete_template("id", $locationID, "landtour_location");
		$this->session->set_flashdata(
			'deleteOK',
			'<div class="alert alert-success alert-bordered">
				<button type="button" class="close" data-dismiss="alert">
					<span>&times;</span><span class="sr-only">Close</span>
				</button>
				<span class="text-semibold">Notification</span> 
				Record has been deleted
			</div>'
		);
		redirect("backend/product/landtour_location");
	}
	
	public function insert_landtour_product()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$data = array(
			   'lt_category_id'	=> $this->db->escape_str($this->input->post("lt_category")),
			   'lt_tourID' 	    => $this->db->escape_str($this->input->post("lt_tourID")),
			   'lt_title' 	    => $this->db->escape_str($this->input->post("lt_title")),
			   'lt_hightlight'  => $this->db->escape_str($this->input->post("lt_highlight")),
			   'lt_itinerary'   => $this->input->post("lt_itinerary"),
			   'start_date'     => $this->db->escape_str($this->input->post("start_date")),
			   'start_country'  => $this->db->escape_str($this->input->post("st_country")),
			   'start_city' 	=> $this->db->escape_str($this->input->post("st_city")),
			   'end_date' 		=> $this->db->escape_str($this->input->post("end_date")),
			   'end_country' 	=> $this->db->escape_str($this->input->post("en_country")),
			   'end_city' 		=> $this->db->escape_str($this->input->post("en_city")),
			   'location'		=> $this->db->escape_str($this->input->post("location")),
			   'is_suspend' 	=> 0,
			   'tags' 			=> $this->db->escape_str($this->input->post("tags")),
			   'slug_url'		=> url_title($this->input->post("lt_title"), 'dash', true),
			   'is_feature'		=> $this->input->post("isFeature"),
			   'created'  		=> date("Y-m-d H:i:s"),
			   'modified' 		=> date("Y-m-d H:i:s")
			);
			if( $this->db->insert('landtour_product', $data) ) {
				$alert_string = "Land tour product saved";
			}
			else {
				$alert_string = "Unable to save land tour product, please try again";	
			}
			$this->session->set_flashdata('insertLandTourProduct', $alert_string);
			$this->session->set_flashdata(
				'insertLandTourProduct',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Notification</span> 
					'.$alert_string.'
				</div>'
			);
			redirect('backend/product/landtour_index/'.base64_decode(base64_decode(base64_decode($this->input->post("lt_tourID")))));
		}
		else {
			redirect("backend/");
		}
	}
	
	public function make_cruise_inactive()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$landtourTitleID = $this->uri->segment(4);
			$data_fields = array(
				"is_suspend" => 1,
				"modified"	 => date("Y-m-d H:i:s")
			);
			$updateLandTour  = $this->All->update_template($data_fields, "id", $landtourTitleID, "landtour_product"); 
			$this->session->set_flashdata(
				'suspendLandTour',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Notification</span> 
					Land tour status has been changed into inactive
				</div>'
			);
			redirect("backend/product/landtour_index");
		}
		else {
			redirect("backend/");
		}
	}
	
	public function make_cruise_active()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$landtourTitleID = $this->uri->segment(4);
			$data_fields = array(
				"is_suspend" => 0,
				"modified"	 => date("Y-m-d H:i:s")
			);
			$updateLandTour  = $this->All->update_template($data_fields, "id", $landtourTitleID, "landtour_product"); 
			$this->session->set_flashdata(
				'activeLandtour',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Notification</span> 
					Land tour status has been changed into active
				</div>'
			);
			redirect("backend/product/landtour_index");
		}
		else {
			redirect("backend/");
		}
	}
	
	public function upload_landtour_img_progress()
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
				$targetPath = getcwd().'/assets/landtour_img/';
				$targetFile = $targetPath . $new_filename ;
				move_uploaded_file($tempFile, $targetFile);
				$data_fields = array(
					'landtour_product_id' => $this->input->post("hidden_land_tour_id"),
					'file_name' => $new_filename,
					'file_type' => $fileSize,
					'file_size' => $fileType,
					'created' 	=> date("Y-m-d H:i:s"),
					'modified' 	=> date("Y-m-d H:i:s")
				);
				$insert_landtourImg = $this->All->insert_template($data_fields, 'landtour_image');
			}
		}
		else {
			redirect("backend/");
		}
	}
	
	public function update_landtour_product()
	{
		//input parameters
		$lt_ID	 	  = trim($this->input->post("lt_ID"));
		$lt_tourID 	  = trim($this->input->post("lt_tourID"));
		$lt_title 	  = trim($this->input->post("lt_title"));
		$lt_highlight = trim($this->input->post("lt_highlight"));
		$lt_itinerary = $this->input->post("lt_itinerary");
		$start_date   = trim($this->input->post("start_date"));
		$st_country   = trim($this->input->post("st_country"));
		$st_city	  = trim($this->input->post("st_city"));
		$end_date 	  = trim($this->input->post("end_date"));
		$en_country   = trim($this->input->post("en_country"));
		$en_city 	  = trim($this->input->post("en_city"));
		$tags 		  = trim($this->input->post("tags"));
		$location	  = trim($this->input->post("location"));
		$is_feature	  = trim($this->input->post("isFeature"));
		//end of input parameters
		//process
		$data_fields = array(
			"lt_tourID" 	=> $lt_tourID,
			"lt_title" 	    => $lt_title,
			"lt_hightlight" => $lt_highlight,
			"lt_itinerary"  => $lt_itinerary,
			"start_date"   	=> $start_date,
			"start_country" => $st_country,
			"start_city"    => $st_city,
			"end_date"    	=> $end_date,
			"end_country" 	=> $en_country,
			"end_city"    	=> $en_city,
			"location"		=> $location,
			"tags"    	  	=> $tags,
			"slug_url"		=> url_title($lt_title, 'dash', true),
			"is_feature"	=> $is_feature,
			"modified" 	  	=> date("Y-m-d H:i:s")
		);
		$updateLandtourDetails = $this->All->update_template($data_fields, "id", $lt_ID, "landtour_product");
		$error_code = 0;
		$message = 'Land tour detail(s) info has been updated';
		//end of process
		//message and redirect
		$array = array(
			"errorCode" => $error_code,
			"message"   => $message,
		);
		echo json_encode($array);
		//end of message and redirect
	}
	
	public function updateStartingPrice()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$data_fields = array(
					"starting_price" => $this->input->post("manual_starting_price"),
					"modified"	 	 => date("Y-m-d H:i:s")
				);
				$update_starting_price = $this->All->update_template(
					$data_fields, "id", $this->input->post("hidden_landtour_productID"), "landtour_product"
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
				redirect("backend/product/landtour_overview/".$this->input->post("hidden_landtour_productID"));
			}
			else {
				redirect("backend/product/landtour_index");
			}
		}
		else {
			redirect("backend/");
		}
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
			$targetPath = getcwd().'/assets/landtour_img/';
			$targetFile = $targetPath . $new_filename ;
			move_uploaded_file($tempFile, $targetFile);
			$data_fields = array(
				'landtour_product_id' => $this->uri->segment(4),
				'file_name' 	  	  => $new_filename,
				'file_type' 	  	  => $fileSize,
				'file_size' 	  	  => $fileType,
				'created' 		  	  => date("Y-m-d H:i:s"),
				'modified' 		  	  => date("Y-m-d H:i:s")
			);
			$insert_image = $this->All->insert_template($data_fields, 'landtour_image');
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
	
	public function deleteLandtourImage()
	{
		$details = $this->All->select_template('id', $this->uri->segment(4), 'landtour_image');
		if( $details == TRUE ) {
			foreach( $details AS $detail ) {
				$file_name = $detail->file_name;
				unlink("assets/landtour_img/".$file_name);
			}
		}
		$delete = $this->All->delete_template("id", $this->uri->segment(4), "landtour_image");
	}
	
	public function setPrimaryImage()
	{
		$imageID 	= $this->uri->segment(4);
		$landtourID = $this->uri->segment(5);
		//set into primary image
		$data_fieldsPR = array(
			"imgStatus" => "PRIMARY",
			"modified"  => date("Y-m-d H:i:s")
		);
		$update_PR = $this->All->update_template($data_fieldsPR, "id", $imageID, "landtour_image");
		//end of set into primary image
		//set other images become default
		$data_fieldsNotPR = array(
			"imgStatus" => "DEFAULT",
			"modified"  => date("Y-m-d H:i:s")
		);
		$update_NotPR = $this->All->update_template_two(
			$data_fieldsNotPR, "id !=", $imageID, "landtour_product_id", $landtourID, "landtour_image"
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
		redirect("backend/product/landtour_overview/".$landtourID);
		//end of session and redirect
	}
	
	public function insertPriceDate()
	{
		$date_ruleLast_ID = "";
		//input parameters
		$landtour_product_id = trim($this->input->post("landtour_product_id"));
		$priceDate  		 = trim($this->input->post("price_date"));
		$sellingType  		 = trim($this->input->post("selling_type"));
		//end of input parameters
		//process
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"
				SELECT * FROM landtour_priceDate 
				WHERE landtour_product_id = ".$landtour_product_id." AND priceDate = '".$priceDate."' 
				AND selling_type = '".$sellingType."'
			"
		);
		if(mysqli_num_rows($check_res) > 0) {
			$error_code = 1;
			$message = 'Date already exists in this product. Please choose another date.';
		}
		else {
			$data_fields = array(
				"landtour_product_id" => $landtour_product_id,
				"priceDate"  		  => $priceDate,
				"selling_type"		  => $sellingType,
				"created" 		  	  => date("Y-m-d H:i:s"),
				"modified" 		  	  => date("Y-m-d H:i:s")
			);
			$insert_priceDate = $this->All->insert_template($data_fields, "landtour_priceDate");
			$date_ruleLast_ID = $this->db->insert_id();
			$error_code = 0;
			$message = 'Date inserted successfully';
		}
		//end of process
		//message and redirect
		$array = array(
			"errorCode"   => $error_code,
			"message"     => $message,
			"priceDate"	  => date("Y-F-d", strtotime($priceDate)),
			"sellingType" => $sellingType,
			"dateID"	  => $date_ruleLast_ID
		);
		echo json_encode($array);
		//end of message and redirect
	}
	
	public function deleteDate()
	{
		$gets = $this->All->select_template("id", $this->uri->segment(4), "landtour_priceDate");
		foreach( $gets AS $get ) {
			$getDate = $get->priceDate;
		}
		$delete1 = $this->All->delete_template_w_2_conditions(
			"landtour_product_id", $this->uri->segment(5), 
			"price_date", $getDate, 
			"landtour_system_prices"
		);
		$delete2 = $this->All->delete_template("id", $this->uri->segment(4), "landtour_priceDate");
	}
	
	public function insert_landtour_prices()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				//debug code
				//echo "<pre>";
				//print_r($this->input->post("hidden_sellingType"));
				//echo "</pre>";
				//echo die("stop");
				//end of debug code
				$arr_dates 		   		= $this->input->post("priceDate");
				$arr_adultSinglePrice 	= $this->input->post("adultSinglePrice");
				$arr_adultSingleQty    	= $this->input->post("adultSingleQty");
				$arr_adultTwinPrice 	= $this->input->post("adultTwinPrice");
				$arr_adultTwinQty    	= $this->input->post("adultTwinQty");
				$arr_adultTriplePrice 	= $this->input->post("adultTriplePrice");
				$arr_adultTripleQty    	= $this->input->post("adultTripleQty");
				$arr_childWBPrice  		= $this->input->post("childWBPrice");
				$arr_childWBQty    		= $this->input->post("childWBQty");
				$arr_childWOBPrice 		= $this->input->post("childWOBPrice");
				$arr_childWOBQty   		= $this->input->post("childWOBQty");
				$arr_childHalfTwinPrice = $this->input->post("childHalfTwinPrice");
				$arr_childHalfTwinQty   = $this->input->post("childHalfTwinQty");
				$arr_infantPrice   		= $this->input->post("infantPrice");
				$arr_infantQty 	   		= $this->input->post("infantQty");
				$arr_roomQuantity   	= $this->input->post("roomQuantity");
				$arr_roomCombination 	= $this->input->post("roomCombination");
				$arr_ticketAdultPrice   = $this->input->post("ticketAdultPrice");
				$arr_ticketAdultQty   	= $this->input->post("ticketAdultQty");
				$arr_ticketChildPrice   = $this->input->post("ticketChildPrice");
				$arr_ticketChildQty   	= $this->input->post("ticketChildQty");
				$arr_hidden_sellingType = $this->input->post("hidden_sellingType");
				$countDate 		   		= count($arr_dates);
				if( $countDate > 0 ) {
					for( $a=0; $a<$countDate; $a++ ) {
						$checks = $this->All->select_template_w_2_conditions(
							"landtour_product_id", $this->input->post("hidden_landtour_productID"), 
							"price_date", $arr_dates[$a], 
							"landtour_system_prices"
						);
						if( $checks == TRUE ) {
							if( $arr_hidden_sellingType[$a] == "TICKET" ) {
								$data_fields = array(
									"ticketAdultPrice" => $arr_ticketAdultPrice[$a],
									"ticketAdultQty"   => $arr_ticketAdultQty[$a],
									"ticketChildPrice" => $arr_ticketChildPrice[$a],
									"ticketChildQty"   => $arr_ticketChildQty[$a],
									"modified"	 	   => date("Y-m-d H:i:s")
								);
							}
							else {
								$data_fields = array(
									"adultSingle_price" 	=> $arr_adultSinglePrice[$a],
									"adultSingle_qty" 	  	=> $arr_adultSingleQty[$a],
									"adultTwin_price" 	  	=> $arr_adultTwinPrice[$a],
									"adultTwin_qty" 	  	=> $arr_adultTwinQty[$a],
									"adultTriple_price" 	=> $arr_adultTriplePrice[$a],
									"adultTriple_qty" 	  	=> $arr_adultTripleQty[$a],
									"child_wb_price"  		=> $arr_childWBPrice[$a],
									"child_wb_qty" 	  		=> $arr_childWBQty[$a],
									"child_wob_price" 		=> $arr_childWOBPrice[$a],
									"child_wob_qty"   		=> $arr_childWOBQty[$a],
									"child_half_twin_price" => $arr_childHalfTwinPrice[$a],
									"child_half_twin_qty" 	=> $arr_childHalfTwinQty[$a],
									"infant_price" 	  		=> $arr_infantPrice[$a],
									"infant_qty" 	  		=> $arr_infantQty[$a],
									"roomQuantity"			=> $arr_roomQuantity[$a],
									"roomCombinationQty"	=> $arr_roomCombination[$a],
									"modified"	 	  		=> date("Y-m-d H:i:s")
								);
							}
							$updatePrices = $this->All->update_template_two(
								$data_fields, 
								"price_date", $arr_dates[$a],
								"landtour_product_id", $this->input->post("hidden_landtour_productID"), 
								"landtour_system_prices"
							);
						}
						else {
							if( $arr_hidden_sellingType[$a] == "TICKET" ) {
								$data_fields = array(
									"landtour_product_id" 	=> $this->input->post("hidden_landtour_productID"),
									"price_date" 		  	=> $arr_dates[$a],
									"adultSingle_price" 	=> NULL,
									"adultSingle_qty" 	  	=> NULL,
									"adultTwin_price" 	  	=> NULL,
									"adultTwin_qty" 	  	=> NULL,
									"adultTriple_price" 	=> NULL,
									"adultTriple_qty" 	  	=> NULL,
									"child_wb_price"  		=> NULL,
									"child_wb_qty" 	  		=> NULL,
									"child_wob_price" 		=> NULL,
									"child_wob_qty"   		=> NULL,
									"child_half_twin_price" => NULL,
									"child_half_twin_qty" 	=> NULL,
									"infant_price" 	  		=> NULL,
									"infant_qty" 	  		=> NULL,
									"roomQuantity"			=> NULL,
									"roomCombinationQty"	=> NULL,
									"ticketAdultPrice" 		=> $arr_ticketAdultPrice[$a],
									"ticketAdultQty"   		=> $arr_ticketAdultQty[$a],
									"ticketChildPrice" 		=> $arr_ticketChildPrice[$a],
									"ticketChildQty"   		=> $arr_ticketChildQty[$a],
									"created"	 	 	  	=> date("Y-m-d H:i:s"),
									"modified"	 	 	  	=> date("Y-m-d H:i:s")
								);
							}
							else {
								$data_fields = array(
									"landtour_product_id" 	=> $this->input->post("hidden_landtour_productID"),
									"price_date" 		  	=> $arr_dates[$a],
									"adultSingle_price" 	=> $arr_adultSinglePrice[$a],
									"adultSingle_qty" 	  	=> $arr_adultSingleQty[$a],
									"adultTwin_price" 	  	=> $arr_adultTwinPrice[$a],
									"adultTwin_qty" 	  	=> $arr_adultTwinQty[$a],
									"adultTriple_price" 	=> $arr_adultTriplePrice[$a],
									"adultTriple_qty" 	  	=> $arr_adultTripleQty[$a],
									"child_wb_price"  		=> $arr_childWBPrice[$a],
									"child_wb_qty" 	  		=> $arr_childWBQty[$a],
									"child_wob_price" 		=> $arr_childWOBPrice[$a],
									"child_wob_qty"   		=> $arr_childWOBQty[$a],
									"child_half_twin_price" => $arr_childHalfTwinPrice[$a],
									"child_half_twin_qty" 	=> $arr_childHalfTwinQty[$a],
									"infant_price" 	  		=> $arr_infantPrice[$a],
									"infant_qty" 	  		=> $arr_infantQty[$a],
									"roomQuantity"			=> $arr_roomQuantity[$a],
									"roomCombinationQty"	=> $arr_roomCombination[$a],
									"created"	 	 	  	=> date("Y-m-d H:i:s"),
									"modified"	 	 	  	=> date("Y-m-d H:i:s")
								);
							}
							$insertPrices = $this->All->insert_template($data_fields, "landtour_system_prices");
						}
					}
					$this->session->set_flashdata(
						'updateLandtourPrices',
						'<div class="alert alert-success alert-bordered">
							<button type="button" class="close" data-dismiss="alert">
								<span>&times;</span><span class="sr-only">Close</span>
							</button>
							<span class="text-semibold">Notification</span> 
							Land tour prices have been updated
						</div>'
					);
					redirect("backend/product/landtour_overview/".$this->input->post("hidden_landtour_productID"));
				}
				else {
					redirect("backend/product/landtour_overview/".$this->input->post("hidden_landtour_productID"));
				}
			}
			else {
				redirect("backend/product/landtour_index");
			}
		}
		else {
			redirect("backend/");
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */