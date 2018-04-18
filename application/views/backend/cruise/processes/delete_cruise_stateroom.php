<?php 
	
	$id 	 = $this->uri->segment(4);
	$shipID  = $this->uri->segment(5);
	$brandID = $this->uri->segment(6);
	
	$checks = $this->All->delete_template_w_3_conditions(
		"SHIP_ID", $shipID, "BRAND_ID", $brandID, "STATEROOM_ID", $id, "cruise_prices"
	);

	if( $this->db->delete('cruise_stateroom', array('ID' => $id)) ){
		$alert_string = "Stateroom deleted";
	}
	else{
		$alert_string = "Unable to delete stateroom, please try again";	
	}
	//$this->session->set_flashdata('alert', $alert_string);
	redirect('backend/product/cruise_manage_stateroom');	

?>
