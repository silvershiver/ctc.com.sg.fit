<?php 
class Landtour extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
	function test(){ echo "Connected to Cruise model"; }
	
    function get_cruise_titles($cruise_id = null)
    {
		if(!empty($cruise_id)){
			$this->db->where('ID', $cruise_id);	
		}
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
	
	function getLandtourCategory_mainSearch()
	{
		$arrayContent = array();
		$ltcategorys = $this->All->select_template_with_where_and_order(
			"category_status", 1, "category_name", "ASC", "landtour_category"
		);
		if( $ltcategorys == TRUE ) {
			foreach( $ltcategorys AS $ltcategory ) {
				$checks = $this->All->select_template("lt_category_id", $ltcategory->id, "landtour_product");
				if( $checks == TRUE ) {
					$arrayContent[$ltcategory->id] = $ltcategory->category_name;
				}
			}
		}
		return $arrayContent;
	}
	
	function getLandtourDestinationCountry_mainSearch()
	{
		$arrayContent = array();
		$ltcountrys = $this->All->select_template_with_order("country_name", "ASC", "landtour_location");
		if( $ltcountrys == TRUE ) {
			foreach( $ltcountrys AS $ltcountry ) {
				$checks = $this->All->select_template("location", $ltcountry->country_name, "landtour_product");
				if( $checks == TRUE ) {
					$arrayContent[$ltcountry->country_name] = $ltcountry->country_name;
				}
			}
		}
		return $arrayContent;
	}
    
}//end Model

?>