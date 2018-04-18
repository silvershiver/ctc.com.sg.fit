<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {

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
		$this->load->view('backend/setting');
	}
	
	public function edit()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$array_name = array(
				'site_name',
				'site_version', 
				'support_email', 
				'contact_email', 
				'info_email', 
				'meta_keyword',
				'meta_description',
				'full_address'
			);
			$array_value = array(
				$this->input->post('site_name'),
				$this->input->post('site_version'), 
				$this->input->post('support_email'), 
				$this->input->post('contact_email'), 
				$this->input->post('info_email'), 
				$this->input->post('meta_keyword'),
				$this->input->post('meta_description'),
				$this->input->post('full_address')
			);
			$array_combine = array_combine($array_name, $array_value);
			foreach( $array_combine AS $key => $value ) {
				$result = $this->all->update_setting(
					$key, 
					$value
				);
			}
			$this->session->set_flashdata(
				'success_update_setting', 
				'<div style="color:green; font-weight:bold; margin-top:10px">Setting has been updated.</div>'
			);
			redirect("backend/setting");
		}
		else {
			redirect("backend/setting");
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */