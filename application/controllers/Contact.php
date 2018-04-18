<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

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
		$this->load->view('contact_index');
	}
	
	public function do_submission()
	{
		//insert message
		if( trim($this->input->post("contact_fullname")) != "" && trim($this->input->post("contact_email_address")) != "" && 
			trim($this->input->post("contact_message")) != "" ) {
			$data_fields = array(
				"full_name" 	  => trim($this->input->post("contact_fullname")),
				"email_address"   => trim($this->input->post("contact_email_address")),
				"content_message" => trim($this->input->post("contact_message")),
				"created" 		  => date("Y-m-d H:i:s"),
				"modified" 		  => date("Y-m-d H:i:s")
			);
			$insert_contact = $this->All->insert_template($data_fields, "contact_support");
			//session redirect
			$this->session->set_flashdata(
				'success_send_contact_support',
				'<div style="color:white; font-size:14px">
					<span class="text-semibold">Well done!</span> 
					Your message has been sent.
				</div>'
			);
			redirect("contact");
			//end of session redirect
		}
		else {
			redirect("contact");
		}
		//end of insert message
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */