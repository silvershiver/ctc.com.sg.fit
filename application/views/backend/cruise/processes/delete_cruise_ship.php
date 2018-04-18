<?php 
	
	$id = $this->uri->segment(4);
	if($this->db->delete('cruise_ships', array('ID' => $id))){
		$alert_string = "Ship deleted";
	}
	else {
		$alert_string = "Unable to delete ship, please try again";	
	}
	redirect('backend/product/cruise_manage_ship');	

?>
