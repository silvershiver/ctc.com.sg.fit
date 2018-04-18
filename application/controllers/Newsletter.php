<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter extends CI_Controller {

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
	public function add_new()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$checks = $this->All->select_template('email_address', $this->input->post("newsletter_signup"), 'subscription');
			if( $checks == TRUE ) {
				$this->session->set_flashdata(
					'success_add_subscribe',
					'<div style="color:white; text-align:center; font-size:16px">
						Your email address has been subscribed before. Please use another email address.
					</div>'
				);
				redirect($this->input->post("hidden_url"));
			}
			else {
				$data_fields = array(
					"first_name"    => "",
					"last_name"     => "",
					"email_address" => $this->input->post("newsletter_signup"),
					"status"   	 	=> 1,
					"created"  		=> date("Y-m-d H:i:s"),
					"modified" 		=> date("Y-m-d H:i:s")
				);
				$insert_subscribe = $this->All->insert_template($data_fields, 'subscription');
				$this->session->set_flashdata(
					'success_add_subscribe',
					'<div style="color:white; text-align:center; font-size:16px">
						Thank you for subscribing to CTC Travel.
					</div>'
				);
				redirect($this->input->post("hidden_url"));
			}
		}
		else {
			redirect("/");
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */