<?php 
class Cruise extends CI_Model {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function test(){ echo "Connected to Cruise model"; }
	
    function get_cruise_titles($cruise_id = null)
    {
		if(!empty($cruise_id)){
			$this->db->where('ID', $cruise_id);	
		}
		$this->db->where('IS_DELETED', 0);
		$query = $this->db->get('cruise_title');
		return $query;
    }//get_cruise_titles
	
	function get_cruise_brands($cruise_id = null)
    {
		if(!empty($cruise_id)){
			$this->db->where('ID', $cruise_id);	
		}
			$query = $this->db->get('cruise_brand');
			return $query;
    }//get_cruise_brands
	
	function get_cruise_ships($cruise_id = null, $column = 'ID')
    {
		if(!empty($cruise_id)){
			$this->db->where($column, $cruise_id);	
		}
			$query = $this->db->get('cruise_ships');
			return $query;
    }//get_cruise_ships
	
	function get_staterooms($brand_id = null, $ship_id = null)
    {
		$this->db->where('cruise_brand_id', $brand_id);	
		$this->db->where('cruise_ship_id', $ship_id);
		$this->db->order_by("orderNo", "ASC");
		$query = $this->db->get('cruise_stateroom');
		return $query;
    }
    
    function getCruiseBrandID($shipID)
    {
	    $default = "";
	    $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"SELECT * FROM cruise_ships WHERE ID = ".$shipID.""
		);
		if( mysqli_num_rows($check_res) > 0 ) {
			$check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
			$check_res1  = mysqli_query(
				$connection,
				"SELECT * FROM cruise_brand WHERE ID = ".$check_row["PARENT_BRAND"].""
			);
			if( mysqli_num_rows($check_res1) > 0 ) {
				$check_row1 = mysqli_fetch_array($check_res1, MYSQL_ASSOC);
				$printShow = $check_row1["ID"];
			}
		}
		else {
			$printShow = $default;
		}
		return $printShow;
    }
    
    function getCruiseBrandName($shipID)
    {
	    $default = "";
	    $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"SELECT * FROM cruise_ships WHERE ID = ".$shipID.""
		);
		if( mysqli_num_rows($check_res) > 0 ) {
			$check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
			$check_res1  = mysqli_query(
				$connection,
				"SELECT * FROM cruise_brand WHERE ID = ".$check_row["PARENT_BRAND"].""
			);
			if( mysqli_num_rows($check_res1) > 0 ) {
				$check_row1 = mysqli_fetch_array($check_res1, MYSQL_ASSOC);
				$printShow = $check_row1["NAME"];
			}
		}
		else {
			$printShow = $default;
		}
		return $printShow;
    }
	

    
}//end Model

?>