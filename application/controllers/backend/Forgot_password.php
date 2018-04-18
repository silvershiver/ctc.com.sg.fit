<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

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
		$this->load->view('backend/forgot_password');
	}
	
	public function doreset()
	{
		$this->load->view('backend/forgot_password_doreset');
	}
	
	public function do_reset_password()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->library('form_validation');
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
				$data["hidden_email_encrypt"] = $this->input->post("hidden_email_encrypt");
				$this->load->view('backend/forgot_password_doreset', $data);
			}
			else {
				$new_password 	   	  = trim($this->input->post("new_password"));
				$confirm_new_password = trim($this->input->post("confirm_new_password"));
				$data_fields = array(
					"password" 		=> sha1(SHA1_VAR.$new_password),
					"is_fp_request" => 0,
					"modified" 		=> date("Y-m-d H:i:s"),
				);
				$update_password = $this->All->update_template(
					$data_fields, "email_address", $this->input->post('hidden_email_address'), "user_access"
				);
				$this->session->set_flashdata(
					'reset_password_success',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span> 
						You successfully updated your password.
					</div>'
				);
				redirect("backend");
			}
		}
	}
	
	public function progress_send_email()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules(
				'email_address', 'Email Address', 'trim|required|valid_email|callback_email_check'
			);
			if($this->form_validation->run() == FALSE) {
				$this->form_validation->set_error_delimiters('<div style="color:red; margin-top:3px">', '</div>');
				$this->load->view('backend/forgot_password');
			}
			else {
				//library
				$this->load->library('email');
				//email encrypt
				$email_encrypt = base64_encode(base64_encode(base64_encode($this->input->post('email_address'))));
				//update is_fp_request
				$data_fields = array(
					"is_fp_request" => 1,
					"modified" 		=> date("Y-m-d H:i:s")
				);
				$update_status = $this->All->update_template(
					$data_fields, "email_address", $this->input->post('email_address'), "user_access"
				);
				//data input to email
				$data_email["contact_no_ontop"] = "+1 (555) 555-5555";
				$data_email["email_address"] 	= $this->input->post('email_address');
				$data_email["reset_link"]    	= base_url()."backend/forgot_password/doreset/$email_encrypt";
				$msg = $this->load->view('email/forgot_password', $data_email, true);
				$this->email->set_mailtype("html");
				$this->email->from('info@ctcfitapp.com', 'CTCFITApp Support');
				$this->email->to($this->input->post("email_address"));
				$this->email->subject('Reset your password');
				$this->email->message($msg);
				$this->email->send();
				//session and redirect
				$this->session->set_flashdata(
					'email_sent',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span> 
						An email has been sent to your email.
					</div>'
				);
				redirect("backend/forgot_password");
			}
		}
	}
	
	public function email_check($str)
	{
		$email_input = $str;
		$check = $this->All->select_template("email_address", $email_input, "user_access");
		if ($check == FALSE) {
			$this->form_validation->set_message('email_check', 'Your email address is not found');
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