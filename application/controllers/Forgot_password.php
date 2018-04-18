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
	
	public function do_reset()
	{
		$this->load->view('forgot_password_doreset');
	}
	
	public function do_execute_reset()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$real_email = base64_decode(base64_decode(base64_decode(trim($this->input->post("hidden_encrypt_email")))));
			if( trim($this->input->post("password")) != trim($this->input->post("confirm_password")) ) {
				//session and redirect
				$this->session->set_flashdata(
					'password_not_match',
					'<div class="f-item">
						<label for="f_name" style="color:red">
							Password is not match. Please try again.
						</label>
					</div>'
				);
				redirect("forgot_password/do_reset/".trim($this->input->post("hidden_encrypt_email")));
				//end of session and redirect
			}
			else {
				$data_fields = array(
					"password" 		=> sha1(SHA1_VAR.$this->input->post('password')),
					"is_fp_request" => 0,
					"modified" 		=> date("Y-m-d H:i:s")
				);
				$update = $this->All->update_template($data_fields, "email_address", $real_email, "user_access");
				//session and redirect
				$this->session->set_flashdata(
					'success_reset_password',
					'<div class="f-item">
						<label for="f_name" style="color:green">
							Your password has been reset
						</label>
					</div>'
				);
				redirect("forgot_password/do_reset/".trim($this->input->post("hidden_encrypt_email")));
				//end of session and redirect
			}
		}
		else {
			redirect("/");
		}
	}
	
	public function do_submission()
	{
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res = mysqli_query(
			$connection, 
			"
				SELECT * FROM user_access WHERE is_block = 0 AND is_signup_request = 0  
				AND email_address = '".$this->input->post('email')."'
			"
		);
		if( mysqli_num_rows($check_res) > 0 ) {
			$this->load->library('email');
			$email_encrypt = base64_encode(base64_encode(base64_encode($this->input->post('email'))));
			//update is_fp_request
			$data_fields = array(
				"is_fp_request" => 1,
				"modified" 		=> date("Y-m-d H:i:s")
			);
			$update_status = $this->All->update_template(
				$data_fields, "email_address", $this->input->post('email'), "user_access"
			);
			//data input to email
			$data_email["contact_no_ontop"] = "<span style='color:white'>For Local: 6532 0532 | For Overseas: +65 6530 0338</span>";
			$data_email["email_address"] 	= trim($this->input->post("email"));
			$data_email["reset_link"]    	= base_url()."forgot_password/do_reset/$email_encrypt";
			$msg = $this->load->view('email/forgot_password', $data_email, true);
			$this->email->set_mailtype("html");
			$this->email->from('enquiry@ctc.com.sg', 'CTC Enquiry Support');
			$this->email->to(trim($this->input->post("email")));
			$this->email->subject('Forgot Password');
			$this->email->message($msg);
			$this->email->send();
			echo 1;
		}
		else {
			echo 0;
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */