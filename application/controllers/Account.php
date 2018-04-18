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
	public function my_profile()
	{
		if( $this->session->userdata("normal_session_id") == TRUE ) {			
			$this->load->view('myprofile_index');	
		}
		else {
			redirect("/");
		}
	}

	public function saveprofile()
	{
		if( $this->session->userdata("normal_session_id") == TRUE && $_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->db->set('first_name', trim($this->input->post('first_name')));
			$this->db->set('last_name', trim($this->input->post('last_name')));
			$this->db->set('email_address', trim($this->input->post('email')));
			$this->db->set('admin_contact', trim($this->input->post('contact_no')));
			$this->db->set('nric', trim($this->input->post('nric')));
			$this->db->set('passport_no', trim($this->input->post('passport_no')));
			$this->db->set('nationality', trim($this->input->post('country')));
			$this->db->set('admin_address', trim($this->input->post('address')));
			$this->db->where('id', $this->session->userdata("normal_session_id"));			
			if($this->db->update('user_access')) {
				$this->session->set_flashdata(
					'profile_updated',
					'<div style="color:green; margin-top:3px">
						You successfully updated your profile.
					</div>'
				);
			} else {
				$this->session->set_flashdata(
					'error_update_profile', 
					'<div style="color:red; margin-top:3px">
						Failed to update your profile. Please contact your administrator.
					</div>'
				);
			}

			redirect("account/my_profile");
		}
		else {
			redirect("/");
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
	

	public function savepassword()
	{
		if( $this->session->userdata("normal_session_id") == TRUE && $_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules(
				'current_password', 
				'Current password', 
				'trim|required|callback_password_check'
			);
			$this->form_validation->set_rules(
				'new_password',
				'New password',
				'trim|required|min_length[8]|matches[retype_password]'
			);
			$this->form_validation->set_rules(
				'retype_password', 
				'Retype new password', 
				'trim|required|min_length[8]'
			);
			if($this->form_validation->run() == FALSE) {
				$this->form_validation->set_error_delimiters('<div style="color:red; margin-top:3px">', '</div>');
				$this->session->set_flashdata('error_update_password', validation_errors());
				redirect("account/my_profile#change_password_tab");
			} else {

				$this->db->set('password', sha1(SHA1_VAR.$this->input->post('new_password')));
				$this->db->where('id', $this->session->userdata("normal_session_id"));
				if($this->db->update('user_access')) {

					$this->session->set_flashdata(
						'password_updated',
						'<div style="color:green; margin-top:3px">
							You successfully updated your password.
						</div>'
					);
				} else {
					$this->session->set_flashdata(
						'error_update_password', 
						'<div style="color:red; margin-top:3px">
							Failed to udpate your password. Please contact your administrator.
						</div>'
					);
				}

				redirect("account/my_profile#change_password_tab");
			}
		}

		else {
			redirect("/");
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */