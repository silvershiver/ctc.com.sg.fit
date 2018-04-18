<?php 
	
	$data = array(
	   'NAME'	  => strtoupper($_POST['brand_name']),
	   'DESC' 	  => $_POST['brand_desc'],
	   'STATUS'   => $_POST['brand_status'],
	   'created'  => date("Y-m-d H:i:s"),
	   'modified' => date("Y-m-d H:i:s"),
	);
	
	if( $this->db->insert('cruise_brand', $data) ) {
		$alert_string = "Brand saved";
	}
	else {
		$alert_string = "Unable to save brand, please try again";	
	}
	$this->session->set_flashdata('alert', $alert_string);
	redirect('backend/product/cruise_manage_brand');	

?>
