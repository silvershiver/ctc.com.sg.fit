<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Controller {

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

			if($this->session->userdata('user_session_access_content_management') == '1')
			{
				$this->load->view('backend/content_index');
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

	public function edit_mode()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/content_edit_mode');
		}
		else {
			redirect("backend/");
		}
	}

	public function media()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/content_media');
		}
		else {
			redirect("backend/");
		}
	}

	public function delete_mode()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$content_id = $this->uri->segment(4);
			//delete media image
			$details = $this->All->select_template('content_management_id', $content_id, 'content_media');
			if( $details == TRUE ) {
				foreach( $details AS $detail ) {
					$file_name = $detail->file_name;
					unlink("assets/media_library/".$file_name);
				}
			}
			//end of delete media image
			//delete record
			$delete_media = $this->All->delete_template('content_management_id', $content_id, 'content_media');
			//end of delete record
			//delete content
			$delete_content = $this->All->delete_template('id', $content_id, 'content_management');
			//end of delete content
			//session and redirect
			$this->session->set_flashdata(
				'success_delete_content',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Well done!</span>
					Content has been deleted.
				</div>'
			);
			redirect("backend/content");
			//end of session and redirect
		}
		else {
			redirect("backend/");
		}
	}

	public function do_delete_media()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$media_id   = $this->uri->segment(4);
			$content_id = $this->uri->segment(5);
			//delete media image
			$details = $this->All->select_template('id', $media_id, 'content_media');
			if( $details == TRUE ) {
				foreach( $details AS $detail ) {
					$file_name = $detail->file_name;
				}
				if( $file_name != "" ) {
					unlink("assets/media_library/".$file_name);
				}
			}
			//end of delete media image
			//delete record
			$delete_record = $this->All->delete_template('id', $media_id, 'content_media');
			//end of delete record
			//session and redirect
			$this->session->set_flashdata(
				'success_delete_media',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Well done!</span>
					Media asset has been deleted.
				</div>'
			);
			redirect("backend/content/media/".$content_id);
			//end of session and redirect
		}
		else {
			redirect("backend/");
		}
	}

	public function upload_media_progress()
	{
		if (!empty($_FILES)) {
			$tempFile   = $_FILES['file']['tmp_name'];
			$fileName   = $_FILES['file']['name'];
			$fileSize   = $_FILES['file']['size'];
			$fileType   = $_FILES['file']['type'];
			//encrypt
			$array_name   = explode('.', $_FILES['file']['name']);
			$extension    = end($array_name);
			$new_filename = md5(uniqid(rand(), true)).'.'.$extension;
			//end of encrypt
			$targetPath = getcwd().'/assets/media_library/';
			$targetFile = $targetPath . $new_filename ;
			move_uploaded_file($tempFile, $targetFile);
			$data_fields = array(
				'content_management_id' => $this->input->post('hidden_content_id'),
				'file_name' => $new_filename,
				'file_type' => $fileSize,
				'file_size' => $fileType,
				'created' 	=> date("Y-m-d H:i:s"),
				'modified' 	=> date("Y-m-d H:i:s")
			);
			$insert_attachment = $this->All->insert_template($data_fields, 'content_media');
		}
	}

	public function save_changes_progress()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				//slug url
				$slug_url = url_title($this->input->post("page_title"), 'dash', true);
				//update logic
				$data_fields = array(
					"content_title"    => trim($this->input->post("page_title")),
					"content_slug_url" => trim($slug_url),
					"content_details"  => trim($this->input->post("page_content")),
					"content_status"   => trim($this->input->post("choose_status")),
					"modified" 		   => date("Y-m-d H:i:s")
				);
				$update_content = $this->All->update_template(
					$data_fields, "id", $this->input->post("hidden_content_id"), "content_management"
				);
				//session and redirect
				$this->session->set_flashdata(
					'success_edit_content',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span>
						Changes has been saved.
					</div>'
				);
				redirect("backend/content/edit_mode/".$this->input->post("hidden_content_id"));
			}
			else {
				redirect("backend/content");
			}
		}
		else {
			redirect("backend/");
		}
	}

	public function add_new_content_webpages()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				//slug url
				$slug_url = url_title($this->input->post("page_title"), 'dash', true);
				//insert content
				$data_fields = array(
					"content_title"    => trim($this->input->post("page_title")),
					"content_slug_url" => trim($slug_url),
					"content_details"  => trim($this->input->post("page_content")),
					"content_status"   => trim($this->input->post("choose_status")),
					"created" 		   => date("Y-m-d H:i:s"),
					"modified"		   => date("Y-m-d H:i:s")
				);
				$insert_content = $this->All->insert_template($data_fields, "content_management");
				//session and redirect
				$this->session->set_flashdata(
					'success_added_new_content',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span>
						You successfully added new content.
					</div>'
				);
				redirect("backend/content");
			}
			else {
				redirect("backend/content");
			}
		}
		else {
			redirect("backend/");
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */