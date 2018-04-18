<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

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
			$this->load->view('backend/profile');
		}
		else {
			redirect("backend/");
		}
	}
	
	public function edit_password()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$this->load->library('form_validation');
				$this->form_validation->set_rules(
					'new_password', 
					'New Password', 
					'trim|required|matches[confirm_new_password]|min_length[5]|xss_clean'
				);
				$this->form_validation->set_rules(
					'confirm_new_password', 
					'Confirm New Password', 
					'trim|required|min_length[5]|xss_clean'
				);
				$this->form_validation->set_message('required', 'Required');
				$this->form_validation->set_message('matches', 'Password is not match');
				if($this->form_validation->run() == FALSE) {
					$this->form_validation->set_error_delimiters(
						'<div style="color:red; margin-bottom:10px">', 
						'</div>'
					);
					$this->load->view('backend/profile');
				}
				else {
					$data_fields = array(
						'password' => sha1(SHA1_VAR.$this->input->post('new_password')),
						'modified' => date("Y-m-d H:i:s")
					);
					$update = $this->all->update_template(
						$data_fields, 'id', $this->input->post('hidden_admin_id'), 'administrator'
					);
					$this->session->set_flashdata(
						'success_update_password', 
						'<div style="color:green; font-weight:bold; margin-top:10px">Your password has been changed.</div>'
					);
					redirect("backend/profile");
				}
			}
			else {
				redirect("backend/profile");
			}
		}
		else {
			redirect("backend/");
		}
	}
	
	public function edit()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$this->load->library('form_validation');
				$this->form_validation->set_rules(
					'fullname_edit', 
					'Full Name', 
					'trim|required|xss_clean'
				);
				$this->form_validation->set_rules(
					'email_edit', 
					'Email Address', 
					'trim|required|valid_email|xss_clean'
				);
				if($this->form_validation->run() == FALSE) {
					$this->form_validation->set_error_delimiters(
						'<div style="color:red; margin-bottom:10px">', 
						'</div>'
					);
					$this->load->view('backend/profile');
				}
				else {
					$data_fields = array(
						'full_name'	=> $this->input->post('fullname_edit'),
						'email'		=> $this->input->post('email_edit'),
						'modified'	=> date("Y-m-d H:i:s")
					);
					$update = $this->all->update_template(
						$data_fields, 'id', $this->input->post('hidden_admin_id'), 'administrator'
					);
					$this->session->unset_userdata('admin_id');
					$this->session->unset_userdata('admin_fullname');
					$this->session->unset_userdata('admin_email');
					$this->session->set_userdata('admin_id',   	   $this->input->post('hidden_admin_id'));
					$this->session->set_userdata('admin_fullname', $this->input->post('fullname_edit'));
					$this->session->set_userdata('admin_email',    $this->input->post('email_edit'));
					if($this->db->affected_rows() == 1) {
						$this->session->set_flashdata(
							'success_update_profile', 
							'<div style="color:green; font-weight:bold; margin-top:10px">Your profile has been changed.</div>'
						);
						redirect("backend/profile");
					}
					else {
						redirect("backend/profile");
					}
				}
			}
			else {
				redirect("backend/profile");
			}
		}
		else {
			redirect("backend/");
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */