<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Support extends CI_Controller {

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


			if($this->session->userdata('user_session_access_support_centre') == '1')
			{
				$this->load->view('backend/support_index');
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

	public function do_delete_process()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			//input parameters
			$delete_process = $this->All->delete_template("id", $this->uri->segment(4), "contact_support");
			//session and redirect
			$this->session->set_flashdata(
				'success_delete_support',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Well done!</span>
					Support message has been deleted.
				</div>'
			);
			redirect("backend/support");
			//end of session and redirect
		}
		else {
			redirect("backend/");
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */