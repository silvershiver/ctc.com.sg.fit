<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

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
		$this->load->view('signup_index');
	}
	
	public function do_activation()
	{
		$this->load->view('signup_success');
	}
	
	public function do_signup_process()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$regs = $this->All->select_template("email_address", trim($this->input->post("email_address")), "user_access");
			if( $regs == TRUE ) {
				$this->session->set_userdata('reg_first_name', 	  trim($this->input->post("first_name")));
				$this->session->set_userdata('reg_last_name', 	  trim($this->input->post("last_name")));
				$this->session->set_userdata('reg_email_address', trim($this->input->post("email_address")));
				//session and redirect
				$this->session->set_flashdata(
					'error_same_register',
					'<div class="f-item">
						<label for="f_name" style="color:white">
							This email address has been used before. Please try another email address.
						</label>
					</div>'
				);
				redirect("/");
				//end of session and redirect
			}
			else {
				//insert into user access
				$data_fields = array(
					"first_name" 		=> trim($this->input->post("first_name")),
					"last_name" 		=> trim($this->input->post("last_name")),
					"email_address" 	=> trim($this->input->post("email_address")),
					"password" 			=> sha1(SHA1_VAR.$this->input->post('password')),
					"is_block" 			=> 1,
					"is_login_facebook" => 0,
					"is_login_twitter" 	=> 0,
					"is_login_gplus" 	=> 0,
					"access_role" 		=> "NORMAL",
					"is_fp_request" 	=> 0,
					"created" 			=> date("Y-m-d H:i:s"),
					"modified" 			=> date("Y-m-d H:i:s")
				);
				$insert = $this->All->insert_template($data_fields, "user_access");
				//end of insert into user access	
				//insert into subscription
				if( $this->input->post("newsletter") == "on" ) {
					$checks = $this->All->select_template(
						"email_address", trim($this->input->post("email_address")), "subscription"
					);
					if( $checks != TRUE ) {
						$data_fields_subscribe = array(
							"first_name" 	=> trim($this->input->post("first_name")),
							"last_name" 	=> trim($this->input->post("last_name")),
							"email_address" => trim($this->input->post("email_address")),
							"status" 		=> 1,
							"created" 		=> date("Y-m-d H:i:s"),
							"modified" 		=> date("Y-m-d H:i:s")
						);
						$subscribe = $this->All->insert_template($data_fields_subscribe, "subscription");
					}
				}
				//end of insert into subscription
				//send email confirmation
				$this->load->library('email');
				$link_encrypt = base64_encode(base64_encode(base64_encode($this->input->post('email_address'))));
				$data_fields = array(
					"is_signup_request" => 1,
					"modified" 			=> date("Y-m-d H:i:s")
				);
				$update_status = $this->All->update_template(
					$data_fields, "email_address", trim($this->input->post("email_address")), "user_access"
				);
				$data_email["contact_no_ontop"] = "<span style='color:white'>For Local: 6532 0532 | For Overseas: +65 6530 0338</span>";
				$data_email["email_address"] 	= trim($this->input->post("email_address"));
				$data_email["reset_link"]    	= base_url()."signup/do_activation/$link_encrypt";
				$msg = $this->load->view('email/signup_activation', $data_email, true);
				$this->email->set_mailtype("html");
				$this->email->from('enquiry@ctc.com.sg', 'CTC Enquiry Support');
				$this->email->to(trim($this->input->post("email_address")));
				$this->email->subject('Email Confirmation');
				$this->email->message($msg);
				$this->email->send();
				//end of send email confirmation
				//session and redirect
				$this->session->set_flashdata(
					'success_signup',
					'<div class="f-item" style="text-align:center">
						<label for="f_name" style="color:white">Thank you for signing up with CTC Travel. <br />We have sent an email to '.trim($this->input->post("email_address")).'.<br /><br /> Please check your email to activate your account.</label>
					</div>'
				);
				redirect("/");
				//end of session and redirect
			}
		}
		else {
			redirect("/");
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */