<?php 
	
	$id = $this->uri->segment(4);
	
	if($this->db->delete('cruise_brand', array('ID' => $id))){
		$alert_string = "Brand deleted";
	}
		else{
			$alert_string = "Unable to delete brand, please try again";	
		}
		//$this->session->set_flashdata('alert', $alert_string);
		redirect('backend/product/cruise_manage_brand');	

?>
