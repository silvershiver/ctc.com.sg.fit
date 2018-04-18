<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

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
		$this->load->view('backend/page');
	}
	
	public function details()
	{
		$this->load->view('backend/page_details');
	}
	
	public function edit()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data_fields = array(
				'page_content' => $this->input->post('editor1'),
				'modified'	  => date("Y-m-d H:i:s")
			);
			$update = $this->all->update_template(
				$data_fields, 'id', $this->input->post('hidden_page_id'), 'page'
			);
			$this->session->set_flashdata(
				'success_update_page_details', 
				'<div style="color:green; font-weight:bold; margin-top:10px">Page has been updated.</div><br />'
			);
			redirect("backend/page/details/".$this->input->post('hidden_page_id'));
		}
		else {
			redirect("backend/page");
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */