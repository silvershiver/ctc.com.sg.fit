<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class administrator extends CI_Controller {

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
	public function index()
	{
		if($this->session->userdata('user_session_id') == TRUE) {


			if($this->session->userdata('user_session_access_admin') == '1')
			{
				$this->load->view('backend/administrator_index');
			}
			else
			{
				$this->load->view('backend/permission_denied');
			}
		}
		else {
			redirect("backend/");
		}
	}

	public function do_delete_action()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$delete_admin = $this->All->delete_template("id", $this->uri->segment(4), "user_access");
			//session and redirect
			$this->session->set_flashdata(
				'session_delete_administrator',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Well done!</span>
					You have successfully deleted an administrator.
				</div>'
			);
			redirect("backend/administrator");
			//end of session and redirect
		}
		else {
			redirect("backend/");
		}
	}

	public function edit_administrator()
	{
		//var_dump($_POST);exit;
		if($this->session->userdata('user_session_id') == TRUE) {

			$acc_dashboard = $this->input->post('acc_dashboard_edit');
			$acc_dashboard_value=0;
			if($acc_dashboard == 'on')
			{
				$acc_dashboard_value ='1';
			}

			$acc_admin = $this->input->post('acc_admin_edit');
			$acc_admin_value=0;
			if($acc_admin == 'on')
			{
				$acc_admin_value ='1';
			}

			$acc_add_admin = $this->input->post('acc_add_admin_edit');
			$acc_add_admin_value=0;
			if($acc_add_admin == 'on')
			{
				$acc_add_admin_value ='1';
			}

			$acc_customer = $this->input->post('acc_customer_edit');
			$acc_customer_value=0;
			if($acc_customer == 'on')
			{
				$acc_customer_value ='1';
			}

			$acc_category = $this->input->post('acc_category_edit');
			$acc_category_value=0;
			if($acc_category == 'on')
			{
				$acc_category_value ='1';
			}

			$acc_add_category = $this->input->post('acc_add_category_edit');
			$acc_add_category_value=0;
			if($acc_add_category == 'on')
			{
				$acc_add_category_value ='1';
			}

			$acc_product = $this->input->post('acc_product_edit');
			$acc_product_value=0;
			if($acc_product == 'on')
			{
				$acc_product_value ='1';
			}

			$acc_cruises = $this->input->post('acc_cruises_edit');
			$acc_cruises_value=0;
			if($acc_cruises == 'on')
			{
				$acc_cruises_value ='1';
			}

			$acc_flights = $this->input->post('acc_flights_edit');
			$acc_flights_value=0;
			if($acc_flights == 'on')
			{
				$acc_flights_value ='1';
			}

			$acc_hotels = $this->input->post('acc_hotels_edit');
			$acc_hotels_value=0;
			if($acc_hotels == 'on')
			{
				$acc_hotels_value ='1';
			}

			$acc_landtours = $this->input->post('acc_landtours_edit');
			$acc_landtours_value=0;
			if($acc_landtours == 'on')
			{
				$acc_landtours_value ='1';
			}

			$acc_main_banner = $this->input->post('acc_main_banner_edit');
			$acc_main_banner_value=0;
			if($acc_main_banner == 'on')
			{
				$acc_main_banner_value ='1';
			}

			$acc_gta_settings = $this->input->post('acc_gta_settings_edit');
			$acc_gta_settings_value=0;
			if($acc_gta_settings == 'on')
			{
				$acc_gta_settings_value ='1';
			}

			$acc_support_centre = $this->input->post('acc_support_centre_edit');
			$acc_support_centre_value=0;
			if($acc_support_centre == 'on')
			{
				$acc_support_centre_value ='1';
			}

			$acc_content_management = $this->input->post('acc_content_management_edit');
			$acc_content_management_value=0;
			if($acc_content_management == 'on')
			{
				$acc_content_management_value ='1';
			}

			$acc_online_help = $this->input->post('acc_online_help_edit');
			$acc_online_help_value=0;
			if($acc_online_help == 'on')
			{
				$acc_online_help_value ='1';
			}

			$acc_edit_profile = $this->input->post('acc_edit_profile_edit');
			$acc_edit_profile_value=0;
			if($acc_edit_profile == 'on')
			{
				$acc_edit_profile_value ='1';
			}


			if( $this->input->post('admin_password') != NULL ) {
				$data_fields = array(
					"admin_full_name" => trim($this->input->post("admin_name")),
					"admin_contact"   => trim($this->input->post("admin_contact_no")),
					"admin_address"   => trim($this->input->post("admin_address")),
					"email_address"   => trim($this->input->post("admin_email_address")),
					"password" 		  => sha1(SHA1_VAR.$this->input->post('admin_password')),
					"modified" 		  => date("Y-m-d H:i:s"),
					"acc_dashboard" => $acc_dashboard_value,
					"acc_admin"		=> $acc_admin_value,
					"acc_add_admin" => $acc_add_admin_value,
					"acc_customer"	=> $acc_customer_value,
					"acc_category"	=> $acc_category_value,
					"acc_add_category" => $acc_add_category_value,
					"acc_product" 	=> $acc_product_value,
					"acc_cruises"	=> $acc_cruises_value,
					"acc_flights"	=> $acc_flights_value,
					"acc_hotels"	=> $acc_hotels_value,
					"acc_landtours" => $acc_landtours_value,
					"acc_main_banner" => $acc_main_banner_value,
					"acc_gta_settings" => $acc_gta_settings_value,
					"acc_support_centre" => $acc_support_centre_value,
					"acc_content_management" => $acc_content_management_value,
					"acc_online_help" => $acc_online_help_value,
					"acc_edit_profile" => $acc_edit_profile_value
				);
			}
			else {
				$data_fields = array(
					"admin_full_name" => trim($this->input->post("admin_name")),
					"admin_contact"   => trim($this->input->post("admin_contact_no")),
					"admin_address"   => trim($this->input->post("admin_address")),
					"email_address"   => trim($this->input->post("admin_email_address")),
					"modified" 		  => date("Y-m-d H:i:s"),
					"acc_dashboard" => $acc_dashboard_value,
					"acc_admin"		=> $acc_admin_value,
					"acc_add_admin" => $acc_add_admin_value,
					"acc_customer"	=> $acc_customer_value,
					"acc_category"	=> $acc_category_value,
					"acc_add_category" => $acc_add_category_value,
					"acc_product" 	=> $acc_product_value,
					"acc_cruises"	=> $acc_cruises_value,
					"acc_flights"	=> $acc_flights_value,
					"acc_hotels"	=> $acc_hotels_value,
					"acc_landtours" => $acc_landtours_value,
					"acc_main_banner" => $acc_main_banner_value,
					"acc_gta_settings" => $acc_gta_settings_value,
					"acc_support_centre" => $acc_support_centre_value,
					"acc_content_management" => $acc_content_management_value,
					"acc_online_help" => $acc_online_help_value,
					"acc_edit_profile" => $acc_edit_profile_value
				);
			}
			$update_administrator = $this->All->update_template(
				$data_fields, "id", $this->input->post("hidden_admin_id"), "user_access"
			);
			//session and redirect
			$this->session->set_flashdata(
				'session_update_administrator',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Well done!</span>
					You successfully updated administrator details.
				</div>'
			);
			redirect("backend/administrator");
			//end of session and redirect
		}
		else {
			redirect("backend/");
		}
	}

	public function add_new_administrator()
	{
		//var_dump($_POST);exit;



		if($this->session->userdata('user_session_id') == TRUE) {
			$role_admin = $this->input->post('role_admin'); //hasil 1 atau 2
			$role_admin_value='';
			if($role_admin == '1')
			{
				$role_admin_value='ADMINISTRATOR';
			}
			else if($role_admin == '2')
			{
				$role_admin_value='STAFF';
			}


			$acc_dashboard = $this->input->post('acc_dashboard');
			$acc_dashboard_value=0;
			if($acc_dashboard == 'on')
			{
				$acc_dashboard_value ='1';
			}

			$acc_admin = $this->input->post('acc_admin');
			$acc_admin_value=0;
			if($acc_admin == 'on')
			{
				$acc_admin_value ='1';
			}

			$acc_add_admin = $this->input->post('acc_add_admin');
			$acc_add_admin_value=0;
			if($acc_add_admin == 'on')
			{
				$acc_add_admin_value ='1';
			}

			$acc_customer = $this->input->post('acc_customer');
			$acc_customer_value=0;
			if($acc_customer == 'on')
			{
				$acc_customer_value ='1';
			}

			$acc_category = $this->input->post('acc_category');
			$acc_category_value=0;
			if($acc_category == 'on')
			{
				$acc_category_value ='1';
			}

			$acc_add_category = $this->input->post('acc_add_category');
			$acc_add_category_value=0;
			if($acc_add_category == 'on')
			{
				$acc_add_category_value ='1';
			}

			$acc_product = $this->input->post('acc_product');
			$acc_product_value=0;
			if($acc_product == 'on')
			{
				$acc_product_value ='1';
			}

			$acc_cruises = $this->input->post('acc_cruises');
			$acc_cruises_value=0;
			if($acc_cruises == 'on')
			{
				$acc_cruises_value ='1';
			}

			$acc_flights = $this->input->post('acc_flights');
			$acc_flights_value=0;
			if($acc_flights == 'on')
			{
				$acc_flights_value ='1';
			}

			$acc_hotels = $this->input->post('acc_hotels');
			$acc_hotels_value=0;
			if($acc_hotels == 'on')
			{
				$acc_hotels_value ='1';
			}

			$acc_landtours = $this->input->post('acc_landtours');
			$acc_landtours_value=0;
			if($acc_landtours == 'on')
			{
				$acc_landtours_value ='1';
			}

			$acc_main_banner = $this->input->post('acc_main_banner');
			$acc_main_banner_value=0;
			if($acc_main_banner == 'on')
			{
				$acc_main_banner_value ='1';
			}

			$acc_gta_settings = $this->input->post('acc_gta_settings');
			$acc_gta_settings_value=0;
			if($acc_gta_settings == 'on')
			{
				$acc_gta_settings_value ='1';
			}

			$acc_support_centre = $this->input->post('acc_support_centre');
			$acc_support_centre_value=0;
			if($acc_support_centre == 'on')
			{
				$acc_support_centre_value ='1';
			}

			$acc_content_management = $this->input->post('acc_content_management');
			$acc_content_management_value=0;
			if($acc_content_management == 'on')
			{
				$acc_content_management_value ='1';
			}

			$acc_online_help = $this->input->post('acc_online_help');
			$acc_online_help_value=0;
			if($acc_online_help == 'on')
			{
				$acc_online_help_value ='1';
			}

			$acc_edit_profile = $this->input->post('acc_edit_profile');
			$acc_edit_profile_value=0;
			if($acc_edit_profile == 'on')
			{
				$acc_edit_profile_value ='1';
			}


			$data_fields = array(
				"admin_full_name" => trim($this->input->post("admin_name")),
				"admin_contact"   => trim($this->input->post("admin_contact_no")),
				"admin_address"   => trim($this->input->post("admin_address")),
				"email_address"   => trim($this->input->post("admin_email_address")),
				"password" 		  => sha1(SHA1_VAR.$this->input->post('admin_password')),
				"access_role" 	  => "SUPERADMIN",
				"created" 		  => date("Y-m-d H:i:s"),
				"modified" 		  => date("Y-m-d H:i:s"),
				"role_admin"	  => $role_admin_value,
				"acc_dashboard" => $acc_dashboard_value,
				"acc_admin"		=> $acc_admin_value,
				"acc_add_admin" => $acc_add_admin_value,
				"acc_customer"	=> $acc_customer_value,
				"acc_category"	=> $acc_category_value,
				"acc_add_category" => $acc_add_category_value,
				"acc_product" 	=> $acc_product_value,
				"acc_cruises"	=> $acc_cruises_value,
				"acc_flights"	=> $acc_flights_value,
				"acc_hotels"	=> $acc_hotels_value,
				"acc_landtours" => $acc_landtours_value,
				"acc_main_banner" => $acc_main_banner_value,
				"acc_gta_settings" => $acc_gta_settings_value,
				"acc_support_centre" => $acc_support_centre_value,
				"acc_content_management" => $acc_content_management_value,
				"acc_online_help" => $acc_online_help_value,
				"acc_edit_profile" => $acc_edit_profile_value
			);
			$insert_administrator = $this->All->insert_template($data_fields, "user_access");
			//session and redirect
			$this->session->set_flashdata(
				'session_insert_administrator',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Well done!</span>
					You successfully added new administrator.
				</div>'
			);
			redirect("backend/administrator");
			//end of session and redirect
		}
		else {
			redirect("backend/");
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */