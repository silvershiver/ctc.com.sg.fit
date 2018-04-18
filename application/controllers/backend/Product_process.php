<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_process extends CI_Controller {

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
			redirect("backend/product/cruise_manage_instruction");
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
		redirect("backend/product/cruise_manage_instruction");
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
				$this->load->view('backend/cruise/cruise_special_instruction');
			}
			else {
				$data = array(
				   'type' 				 => "CRUISE",
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
				redirect("backend/product/cruise_manage_instruction");
			}
		}
		else {
			redirect("backend/");
		}
	}

	public function insert_cruise_brand()
	{
		if( $this->session->userdata('user_session_id') == TRUE ) {
			$config = array(
               array( 'field' => 'brand_name', 	 'rules' => 'required' ),
			   array( 'field' => 'brand_desc', 	 'rules' => 'required' ),
			   array( 'field' => 'brand_status', 'rules' => 'required' )
            );
			$this->form_validation->set_rules($config);
			$this->form_validation->set_message('required', '* Required');
			$this->form_validation->set_message('numeric', 	'* Must contain only numbers');
			$this->form_validation->set_error_delimiters('<span class="form_error">', '</span>');
			if( $this->form_validation->run() == FALSE ) {
				$data['title'] = "Cruise Brands Management";
				$this->load->view('backend/cruise/manage_brand', $data);
			}
			else {
				$this->load->view('backend/cruise/processes/insert_cruise_brand');
			}
		}
		else {
			redirect("backend/");
		}
	}

	public function update_cruise_brand()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/processes/update_cruise_brand');
		}
		else {
			redirect("backend/");
		}
	}//update_cruise_brand
	public function delete_cruise_brand()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/processes/delete_cruise_brand');
		}
		else {
			redirect("backend/");
		}
	}//delete_cruise_brand


	//********** CRUISE SHIP

	public function insert_cruise_ship()
	{
		if($this->session->userdata('user_session_id') == TRUE) {

			$config = array(
				array( 'field'   => 'ship_brand', 'rules'   => 'required' ),
               array( 'field'   => 'ship_name', 'rules'   => 'required' ),
			   array( 'field'   => 'ship_desc', 'rules'   => 'required' )
            );

			$this->form_validation->set_rules($config);
			$this->form_validation->set_message('required', '*Required');
			$this->form_validation->set_message('numeric', '*Must contain only numbers');
			$this->form_validation->set_error_delimiters('<span class="form_error">', '</span>');

				if ($this->form_validation->run() == FALSE)
				{
					$data['title'] = "Cruise Ship Management";
					$this->load->view('backend/cruise/manage_ship', $data);
				}
					else
					{
						$this->load->view('backend/cruise/processes/insert_cruise_ship');
					}

		}
		else {
			redirect("backend/");
		}
	}//insert_cruise_ship
	public function update_cruise_ship()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/processes/update_cruise_ship');
		}
		else {
			redirect("backend/");
		}
	}//update_cruise_ship
	public function delete_cruise_ship()
	{
		if( $this->session->userdata('user_session_id') == TRUE ) {
			//parameter
			$id = $this->uri->segment(4);
			//end of parameter
			//check ship if using this ship ID
			$checks = $this->All->select_template_w_2_conditions(
				"SHIP_ID", $id, "IS_DELETED", 0, "cruise_title"
			);
			if( $checks == TRUE ) {
				//session and redirect
				$this->session->set_flashdata(
					'thisShipIDExist',
					'<div class="alert alert-danger alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Notification!</span>
						Please delete all cruises under this ship ID first.
					</div>'
				);
				redirect("backend/product/cruise_manage_ship");
				//end of session and redirect
			}
			else {
				//delete process
				$deleteCruiseShip = $this->All->delete_template("ID", $id, "cruise_ships");
				//session and redirect
				$this->session->set_flashdata(
					'successDeleteShipID',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Notification!</span>
						Selected cruise ship ID has been deleted.
					</div>'
				);
				redirect("backend/product/cruise_manage_ship");
				//end of session and redirect
			}
			//end of check ship if using this ship ID
			//$this->load->view('backend/cruise/processes/delete_cruise_ship');
		}
		else {
			redirect("backend/");
		}
	}//delete_cruise_ship

	//********** CRUISE STATEROOMS

	public function insert_cruise_stateroom()
	{
		if($this->session->userdata('user_session_id') == TRUE) {

			$config = array(
				array( 'field'   => 'stateroom_name', 'rules'   => 'required' ),
               array( 'field'   => 'brand', 'rules'   => 'required' ),
			   array( 'field'   => 'ship', 'rules'   => 'required' )
            );

			$this->form_validation->set_rules($config);
			$this->form_validation->set_message('required', '*Required');
			$this->form_validation->set_message('numeric', '*Must contain only numbers');
			$this->form_validation->set_error_delimiters('<span class="form_error">', '</span>');

				if ($this->form_validation->run() == FALSE)
				{
					$data['title'] = "Cruise Staterooms Management";
					$this->load->view('backend/cruise/manage_stateroom', $data);
				}
					else
					{
						$this->load->view('backend/cruise/processes/insert_cruise_staterooms');
					}

		}
		else {
			redirect("backend/");
		}
	}//insert_cruise_stateroom
	public function update_cruise_stateroom()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/processes/update_cruise_ship');
		}
		else {
			redirect("backend/");
		}
	}//update_cruise_stateroom
	public function delete_cruise_stateroom()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/cruise/processes/delete_cruise_stateroom');
		}
		else {
			redirect("backend/");
		}
	}//delete_cruise_stateroom


	//********** PRICES

	public function insert_cruise_prices()
	{
		if($this->session->userdata('user_session_id') == TRUE) {

			$this->load->view('backend/cruise/processes/insert_cruise_prices');

		}
		else {
			redirect("backend/");
		}
	}//insert_cruise_ship

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */