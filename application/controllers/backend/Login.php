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
	public function out()
	{
		$this->session->unset_userdata('user_session_id');
		redirect("backend/");
	}

	public function progress()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email_login', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('password_login', 'Password', 'trim|required');
			if($this->form_validation->run() == FALSE) {
				$this->form_validation->set_error_delimiters('<div style="color:red; margin-top:3px">', '</div>');
				$this->load->view('backend/index');
			}
			else {
				$do_login = $this->All->backend_login(
					$this->input->post('email_login'), sha1(SHA1_VAR.$this->input->post('password_login'))
				);
				if( $do_login != FALSE ) {
					//remember me
					$rememberme = $this->input->post('remember_me');
					if( $rememberme == 1 ) {
						$this->session->set_userdata('io_email_ctcfitapp',    $this->input->post('email_login'));
						$this->session->set_userdata('io_password_ctcfitapp', $this->input->post('password_login'));
					}
					else {
						$this->session->unset_userdata('io_email_ctcfitapp');
						$this->session->unset_userdata('io_password_ctcfitapp');
					}
					//end of remember me
					foreach( $do_login AS $get_login ) {
						$user_session_id 		 	  = $get_login->id;
						$user_session_first_name 	  = $get_login->first_name;
						$user_session_last_name 	  = $get_login->last_name;
						$user_session_admin_full_name = $get_login->admin_full_name;
						$user_session_admin_contact   = $get_login->admin_contact;
						$user_session_admin_address   = $get_login->admin_address;
						$user_session_email_address   = $get_login->email_address;
						$user_session_is_block 		  = $get_login->is_block;
						$user_session_access_role 	  = $get_login->access_role;
						$user_session_access_dashboard = $get_login->acc_dashboard;
						$user_session_access_admin = $get_login->acc_admin;
						$user_session_access_add_admin = $get_login->acc_add_admin;
						$user_session_access_customer = $get_login->acc_customer;
						$user_session_access_category = $get_login->acc_category;
						$user_session_access_add_category = $get_login->acc_add_category;
						$user_session_access_product = $get_login->acc_product;
						$user_session_access_cruises = $get_login->acc_cruises;
						$user_session_access_flights = $get_login->acc_flights;
						$user_session_access_hotels = $get_login->acc_hotels;
						$user_session_access_landtours = $get_login->acc_landtours;
						$user_session_access_main_banner = $get_login->acc_main_banner;
						$user_session_access_gta_settings = $get_login->acc_gta_settings;
						$user_session_access_support_centre = $get_login->acc_support_centre;
						$user_session_access_content_management = $get_login->acc_content_management;
						$user_session_access_online_help = $get_login->acc_online_help;
						$user_session_access_edit_profile = $get_login->acc_edit_profile;
					}
					$this->session->set_userdata('user_session_id', 				$user_session_id);
					$this->session->set_userdata('user_session_first_name', 		$user_session_first_name);
					$this->session->set_userdata('user_session_last_name', 	  		$user_session_last_name);
					$this->session->set_userdata('user_session_admin_full_name', 	$user_session_admin_full_name);
					$this->session->set_userdata('user_session_admin_contact', 	  	$user_session_admin_contact);
					$this->session->set_userdata('user_session_admin_address', 	  	$user_session_admin_address);
					$this->session->set_userdata('user_session_email_address', 		$user_session_email_address);
					$this->session->set_userdata('user_session_is_block', 			$user_session_is_block);
					$this->session->set_userdata('user_session_access_role', 		$user_session_access_role);
					$this->session->set_userdata('user_session_access_dashboard', 		$user_session_access_dashboard);
					$this->session->set_userdata('user_session_access_admin', 		$user_session_access_admin);
					$this->session->set_userdata('user_session_access_add_admin', 		$user_session_access_add_admin);
					$this->session->set_userdata('user_session_access_customer', 		$user_session_access_customer);
					$this->session->set_userdata('user_session_access_category', 		$user_session_access_category);
					$this->session->set_userdata('user_session_access_add_category', 		$user_session_access_add_category);
					$this->session->set_userdata('user_session_access_product', 		$user_session_access_product);
					$this->session->set_userdata('user_session_access_cruises', 		$user_session_access_cruises);
					$this->session->set_userdata('user_session_access_flights', 		$user_session_access_flights);
					$this->session->set_userdata('user_session_access_hotels', 		$user_session_access_hotels);
					$this->session->set_userdata('user_session_access_landtours', 		$user_session_access_landtours);
					$this->session->set_userdata('user_session_access_main_banner', 		$user_session_access_main_banner);
					$this->session->set_userdata('user_session_access_gta_settings', 		$user_session_access_gta_settings);
					$this->session->set_userdata('user_session_access_support_centre', 		$user_session_access_support_centre);
					$this->session->set_userdata('user_session_access_content_management', 		$user_session_access_content_management);
					$this->session->set_userdata('user_session_access_online_help', 		$user_session_access_online_help);
					$this->session->set_userdata('user_session_access_edit_profile', 		$user_session_access_edit_profile);


					redirect("backend/dashboard");
				}
				else {
					$this->session->set_flashdata(
						'wrong_login_process',
						'<div style="color:red; margin-bottom:5px">Wrong account. Please try again.</div>'
					);
					redirect("/backend");
				}
			}
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */