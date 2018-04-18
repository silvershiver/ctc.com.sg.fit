<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gta extends CI_Controller {

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
	public function __construct()
    {
		parent::__construct();
    }

	public function settings()
	{

		if($this->session->userdata('user_session_id') == TRUE) {

			if($this->session->userdata('user_session_access_gta_settings') == '1')
			{
				$records = $this->All->select_template("name", "GTA_PRICE_MARKUP", "gta_settings");
				if( $records == TRUE ) {
					foreach( $records AS $record ) {
						$value = $record->value;
					}
				}
				$data['gta_price_markup'] = $value;
				$this->load->view('backend/gta_settings', $data);
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

	public function doUpdateSettings()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$data_fields = array(
				"value" => trim($this->input->post("gta_price_markup"))
			);
			$update_setting = $this->All->update_template($data_fields, "name", "GTA_PRICE_MARKUP", "gta_settings");
			//session and redirect
			$this->session->set_flashdata(
				'session_update_gtaSettings',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Well done!</span>
					You successfully updated GTA markup price
				</div>'
			);
			redirect("backend/gta/settings");
			//end of session and redirect
		}
		else {
			redirect("backend/");
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */