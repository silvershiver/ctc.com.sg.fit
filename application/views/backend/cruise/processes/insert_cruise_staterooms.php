<?php 
	
	$data = array(
	   'CRUISE_BRAND_ID' => strtoupper($_POST['brand']) ,
	   'CRUISE_SHIP_ID' => strtoupper($_POST['ship']) ,
	   'STATEROOM_NAME' => strtoupper($_POST['stateroom_name']) 
	);
	
	if($this->db->insert('cruise_stateroom', $data)){
		$alert_string = "New Stateroom Inserted";
	}
		else{
			$alert_string = "Unable to insert stateroom, please try again";	
		}
		$this->session->set_flashdata('alert', $alert_string);
		redirect('backend/product/cruise_manage_stateroom');	

?>
