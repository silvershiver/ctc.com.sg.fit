<?php 
	
	$data = array(
	   'PARENT_BRAND' => strtoupper($_POST['ship_brand']) ,
	   'SHIP_NAME' => strtoupper($_POST['ship_name']) ,
	   'SHIP_DESC' => $_POST['ship_desc'] 
	);
	
	if($this->db->insert('cruise_ships', $data)){
		$alert_string = "New Ship Inserted";
	}
		else{
			$alert_string = "Unable to insert ship, please try again";	
		}
		$this->session->set_flashdata('alert', $alert_string);
		redirect('backend/product/cruise_manage_ship');	

?>
