<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

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
		$this->load->library('Spreadsheet_Excel_Reader');
		$this->load->model('bank');
    }

	public function index()
	{
		$this->load->view('backend/user');
	}

	public function initial()
	{
		$this->load->view('backend/user_initial');
	}

	public function update_initial()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$initial_id = $this->input->post('hidden_initial_id');
			$data_fields = array(
				'bank_type'    	   => $this->input->post('bank_type'),
				'account_name' 	   => $this->input->post('account_name'),
				'account_id'   	   => $this->input->post('account_id'),
				'initial_name'	   => $this->input->post('initial_name'),
				'mandate_group_id' => $this->input->post('mandate_group'),
				'modified'     	   => date("Y-m-d H:i:s")
			);
			$update_initial = $this->all->update_template($data_fields, 'id', $initial_id, 'user_initial');
			$this->session->set_flashdata(
				'success_update_user_initial',
				'<div style="color:green; font-weight:bold; margin-top:10px">An initial has been updated</div>'
			);
			redirect("backend/user/initial");
		}
		else {
			$this->load->view('backend/user_initial');
		}
	}

	public function delete_initial()
	{
		$initial_id = $this->uri->segment(4);
		$delete = $this->all->delete_template('id', $initial_id, 'user_initial');
		$this->session->set_flashdata(
			'success_delete_user_initial',
			'<div style="color:green; font-weight:bold; margin-top:10px">An initial has been deleted</div>'
		);
		redirect("backend/user/initial");
	}

	public function initial_upload_excel()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$archivo 	  = $_FILES['initial_excel_file']['tmp_name'];
			$data    	  = new Spreadsheet_Excel_Reader($archivo);
			$filename 	  = pathinfo($_FILES['initial_excel_file']['name'], PATHINFO_FILENAME);
			$details 	  = array();
			$total_rows   = $data->rowcount($sheet_index=0);
			for($i = 2; $i<=$total_rows; $i++) {
				if( $data->val($i, 'A') != NULL ) {
					$break_name_arr = explode("_", $data->val($i, 'E'));
					$details['bank_type']    = $data->val($i, 'B');
					$details['account_name'] = $data->val($i, 'C');
					$details['account_id']   = $data->val($i, 'D');
					$details['initial_name'] = $break_name_arr[1];
					$details['created'] 	 = date("Y-m-d H:i:s");
					$details['modified'] 	 = date("Y-m-d H:i:s");
					$checks = $this->all->select_template_w_2_conditions(
						'bank_type', $details['bank_type'], 'initial_name', $details['initial_name'], 'user_initial'
					);
					if( $checks == TRUE ) {
						//update record if exist
						$data_fields = array(
							'bank_type'    => $details['bank_type'],
							'account_name' => $details['account_name'],
							'account_id'   => $details['account_id'],
							'initial_name' => $details['initial_name'],
							'modified' 	   => date("Y-m-d H:i:s")
						);
						$update = $this->all->update_template_two(
							$data_fields, 'bank_type', $details['bank_type'], 'initial_name', $details['initial_name'], 'user_initial'
						);
					}
					else {
						//insert record if not exist
						$this->bank->insert_initial($details);
					}
				}
			}
			$this->session->set_flashdata(
				'success_upload_initial_excel',
				'<div style="color:green; font-weight:bold; margin-top:10px">File has been uploaded successfully.</div>'
			);
			redirect('backend/user/initial');
		}
		else {
			$this->load->view('backend/user_initial');
		}
	}

	public function initial_process()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules(
				'account_name',
				'Account name',
				'trim|required|xss_clean'
			);
			$this->form_validation->set_rules(
				'account_id',
				'Account ID',
				'trim|required|xss_clean'
			);
			$this->form_validation->set_rules(
				'initial_name',
				'Initial Name',
				'trim|required|xss_clean'
			);
			if($this->form_validation->run() == FALSE) {
				$this->form_validation->set_error_delimiters(
					'<div style="color:red; margin-bottom:10px">',
					'</div>'
				);
				$this->load->view('backend/user_initial');
			}
			else {
				$data_fields = array(
					'bank_type'	   	   => $this->input->post('bank_type'),
					'account_name' 	   => $this->input->post('account_name'),
					'account_id'   	   => $this->input->post('account_id'),
					'initial_name' 	   => $this->input->post('initial_name'),
					'mandate_group_id' => $this->input->post('mandate_group'),
					'created' 	   	   => date("Y-m-d H:i:s"),
					'modified' 	   	   => date("Y-m-d H:i:s")
				);
				$insert = $this->all->insert_template($data_fields, 'user_initial');
				$this->session->set_flashdata(
					'success_add_new_initial',
					'<div style="color:green; font-weight:bold; margin-top:10px">A new initial has been updated.</div>'
				);
				redirect("backend/user/initial");
			}
		}
		else {
			$this->load->view('backend/user_initial');
		}
	}

	public function update_process()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules(
				'fullname',
				'Full name',
				'trim|required|xss_clean'
			);
			$this->form_validation->set_rules(
				'user_id',
				'User ID',
				'trim|required|xss_clean'
			);
			if($this->form_validation->run() == FALSE) {
				$this->form_validation->set_error_delimiters(
					'<div style="color:red; margin-bottom:10px">',
					'</div>'
				);
				$data['hidden_user_id'] = $this->input->post('hidden_user_id');
				$this->load->view('backend/user_update', $data);
			}
			else {
				//update user ID
				$data_fields = array(
					'user_id' 		   => $this->input->post('user_id'),
					'user_group_id'    => $this->input->post('user_group'),
					'assigned_account' => $this->input->post('assigned_account'),
					'full_name' 	   => $this->input->post('fullname'),
					'modified' 		   => date("Y-m-d H:i:s")
				);
				$update_user_id = $this->all->update_template($data_fields, 'id', $this->input->post('hidden_user_id'), 'user');
				//end of update ID
				$this->session->set_flashdata(
					'success_update_user',
					'<div style="color:green; font-weight:bold; margin-top:10px">User has been updated.</div>'
				);
				redirect("backend/user/update/".$this->input->post('hidden_user_id'));
			}
		}
		else {
			redirect('backend/user');
		}
	}

	public function insert()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->library('form_validation');
			$data_fields = array(
				'user_id' 		   => trim($this->input->post('user_id')),
				'password' 		   => sha1(SHA1_VAR.$this->input->post('password')),
				'user_group_id'    => trim($this->input->post('user_group')),
				'assigned_account' => trim($this->input->post('assigned_account')),
				'full_name'	 	   => trim($this->input->post('fullname')),
				'created'    	   => date("Y-m-d H:i:s"),
				'modified'   	   => date("Y-m-d H:i:s")
			);
			$insert = $this->all->insert_template($data_fields, 'user');
			$this->session->set_flashdata(
				'success_insert_user',
				'<div style="color:green; font-weight:bold; margin-top:10px">A new user has been added.</div>'
			);
			redirect("backend/user");
		}
		else {
			redirect('backend/user');
		}
	}

	public function delete($id)
	{
		if( !isset($id) ) {
			redirect('backend/user');
		}
		else {
			$this->all->delete_template('id', $id, 'user');
			$this->session->set_flashdata(
					'success_delete_user',
					'<div style="color:green; font-weight:bold; margin-top:10px">The user has been deleted</div>'
				);

			redirect("backend/user");
		}
	}

	public function update()
	{
		$this->load->view('backend/user_update');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */