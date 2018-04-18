<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

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
			//$this->load->view('backend/category_index');
			if($this->session->userdata('user_session_access_category') == '1')
			{
				$this->load->view('backend/category_index');
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

	public function update_category_progress()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			//update category
			$data_fields = array(
				"category_name"   => trim($this->input->post("category_name")),
				"category_desc"   => trim($this->input->post("category_desc")),
				"category_status" => trim($this->input->post("category_status")),
				"modified" 		  => date("Y-m-d H:i:s")
			);
			$update_category = $this->All->update_template($data_fields, "id", $this->input->post("hidden_category_id"), "category");
			//session and redirect
			$this->session->set_flashdata(
				'session_update_category',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Well done!</span>
					You successfully updated category details.
				</div>'
			);
			redirect("backend/category");
		}
		else {
			redirect("backend/");
		}
	}

	public function add_new_progress()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				//insert new category
				$data_fields = array(
					"category_name"   => trim($this->input->post("category_name")),
					"category_desc"   => trim($this->input->post("category_desc")),
					"category_status" => trim($this->input->post("category_status")),
					"created" 		  => date("Y-m-d H:i:s"),
					"modified" 		  => date("Y-m-d H:i:s")
				);
				$insert_category = $this->All->insert_template($data_fields, "category");
				//session and redirect
				$this->session->set_flashdata(
					'session_add_new_category',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span>
						You successfully added new category.
					</div>'
				);
				redirect("backend/category");
			}
			else {
				redirect("backend/category");
			}
		}
		else {
			redirect("backend/");
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */