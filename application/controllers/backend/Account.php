<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

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

			if($this->session->userdata('user_session_access_edit_profile') == '1')
			{
				$this->load->view('backend/account_profile');
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

	public function change_password()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/account_change_password');
		}
		else {
			redirect("backend/");
		}
	}

	public function do_change_password()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$this->load->library('form_validation');
				$this->form_validation->set_rules(
					'current_password',
					'Current password',
					'trim|required|callback_password_check'
				);
				$this->form_validation->set_rules(
					'new_password',
					'New password',
					'trim|required|min_length[8]|matches[confirm_new_password]'
				);
				$this->form_validation->set_rules(
					'confirm_new_password',
					'Confirm new password',
					'trim|required|min_length[8]'
				);
				if($this->form_validation->run() == FALSE) {
					$this->form_validation->set_error_delimiters('<div style="color:red; margin-top:3px">', '</div>');
					$this->load->view('backend/account_change_password');
				}
				else {
					$current_password 	  = trim($this->input->post("current_password"));
					$new_password 	   	  = trim($this->input->post("new_password"));
					$confirm_new_password = trim($this->input->post("confirm_new_password"));
					$data_fields = array(
						"password" => sha1(SHA1_VAR.$new_password),
						"modified" => date("Y-m-d H:i:s"),
					);
					$update_password = $this->All->update_template(
						$data_fields, "id", $this->session->userdata('user_session_id'), "user_access"
					);
					$this->session->set_flashdata(
						'password_updated',
						'<div class="alert alert-success alert-bordered">
							<button type="button" class="close" data-dismiss="alert">
								<span>&times;</span><span class="sr-only">Close</span>
							</button>
							<span class="text-semibold">Well done!</span>
							You successfully updated your password.
						</div>'
					);
					redirect("backend/account/change_password");
				}
			}
		}
		else {
			redirect("backend/");
		}
	}

	public function do_update_profile()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$full_name     = trim($this->input->post("full_name"));
				$email_address = trim($this->input->post("email_address"));
				$contact_no    = trim($this->input->post("contact_no"));
				$address	   = trim($this->input->post("address"));
				//update profile function
				$data_fields = array(
					"admin_full_name" => $full_name,
					"email_address"   => $email_address,
					"admin_contact"   => $contact_no,
					"admin_address"   => $address,
					"modified" 		  => date("Y-m-d H:i:s")
				);
				$update_profile = $this->All->update_template(
					$data_fields, "id", $this->session->userdata('user_session_id'), "user_access"
				);
				$this->session->unset_userdata('user_session_admin_full_name');
				$this->session->unset_userdata('user_session_admin_contact');
				$this->session->unset_userdata('user_session_admin_address');
				$this->session->unset_userdata('user_session_email_address');
				$this->session->set_userdata('user_session_admin_full_name', $full_name);
				$this->session->set_userdata('user_session_admin_contact', 	 $contact_no);
				$this->session->set_userdata('user_session_admin_address', 	 $address);
				$this->session->set_userdata('user_session_email_address',	 $email_address);
				//end of update profile function
				$this->session->set_flashdata(
					'profile_details_updated',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span>
						You successfully updated your profile details.
					</div>'
				);
				redirect("backend/account");
			}
		}
		else {
			redirect("backend/");
		}
	}

	public function password_check($str)
	{
		$password_input = sha1(SHA1_VAR.$str);
		$check = $this->All->select_template("password", $password_input, "user_access");
		if ($check == FALSE) {
			$this->form_validation->set_message('password_check', 'Current password is not found');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */