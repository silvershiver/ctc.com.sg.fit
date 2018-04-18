<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mainbanner extends CI_Controller {

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


			if($this->session->userdata('user_session_access_main_banner') == '1')
			{
				$this->load->view('backend/mainbanner_index');
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

	public function doStateroomOrder()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$sectionids = $this->input->post("sectionsid");
	        $count 		= 1;
	        if( is_array($sectionids) ) {
	            foreach( $sectionids as $sectionid ) {
		            $data_fields = array(
			            "orderNo"  => $count,
			            "modified" => date("Y-m-d H:i:s")
		            );
		            $updateOrder = $this->All->update_template($data_fields, "id", $sectionid, "main_banner");
	                $count++;
	            }
	            echo '{"status":"success"}';
	        }
	        else {
	            echo '{"status":"failure", "message":" No Update happened. Could be an internal error, please try again."}';
	        }
		}
		else {
			redirect("backend/");
		}
	}

	public function doDeleteBanner()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			$details = $this->All->select_template('id', $this->uri->segment(4), 'main_banner');
			if( $details == TRUE ) {
				foreach( $details AS $detail ) {
					$file_name = $detail->banner_filename;
					unlink("assets/main-banner/".$file_name);
				}
			}
			$delete = $this->All->delete_template("id", $this->uri->segment(4), "main_banner");
			$this->session->set_flashdata(
				'deleteBannerSuccess',
				'<div class="alert alert-success alert-bordered">
					<button type="button" class="close" data-dismiss="alert">
						<span>&times;</span><span class="sr-only">Close</span>
					</button>
					<span class="text-semibold">Notification</span>
					Selected banner has been deleted
				</div>'
			);
			redirect("backend/mainbanner");
		}
		else {
			redirect("backend/");
		}
	}

	public function addBanner()
	{
		if($this->session->userdata('user_session_id') == TRUE) {
			if (!empty($_FILES)) {
				$tempFile   = $_FILES['choose_banner_file']['tmp_name'];
				$fileName   = $_FILES['choose_banner_file']['name'];
				$fileSize   = $_FILES['choose_banner_file']['size'];
				$fileType   = $_FILES['choose_banner_file']['type'];
				//encrypt
				$array_name   = explode('.', $_FILES['choose_banner_file']['name']);
				$extension    = end($array_name);
				$new_filename = md5(uniqid(rand(), true)).'.'.$extension;
				//end of encrypt
				$targetPath = getcwd().'/assets/main-banner/';
				$targetFile = $targetPath . $new_filename ;
				move_uploaded_file($tempFile, $targetFile);
				$dataWidthHeight = getimagesize($targetFile);
				$width  = $dataWidthHeight[0];
				$height = $dataWidthHeight[1];
				$data_fields = array(
					'banner_filename' 	 => $new_filename,
					'banner_size_width'  => $width,
					'banner_size_height' => $height,
					'banner_type' 	  	 => $extension,
					'created' 		  	 => date("Y-m-d H:i:s"),
					'modified' 		  	 => date("Y-m-d H:i:s")
				);
				$insert_image = $this->All->insert_template($data_fields, 'main_banner');
				$image_last_id = $this->db->insert_id();
				$this->session->set_flashdata(
					'addBannerSuccess',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Notification</span>
						New banner has been added
					</div>'
				);
				redirect("backend/mainbanner");
			}
			else {
				redirect("backend/mainbanner");
			}
		}
		else {
			redirect("backend/");
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */