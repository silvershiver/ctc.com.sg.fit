<?php 
class Flight extends CI_Model {

    function _construct()
	{
      	parent::_construct();
	}
	
	function remove_duplicated_values($array)
	{
		$newArray = array();
		foreach( $array as $key => $val ) {
			$newArray[$val] = 1;
 		}
 		return array_keys($newArray);
	}
	
    function getAirlinesNameBasedOnCode($airline_code = "")
    {
	    $arrayOutput = "";
		$names = $this->All->select_template("code", $airline_code, "flight_airlines");
		if( $names == TRUE ) {
			foreach( $names AS $name ) {
				$arrayOutput = $name->name;
			}
		}
		return $arrayOutput;
    }
    
    function getCityNameBasedOnCode($airport_code = "")
    {
	    $arrayOutput = "";
		$names = $this->All->select_template("code", $airport_code, "flight_airportV2");
		if( $names == TRUE ) {
			foreach( $names AS $name ) {
				$arrayOutput = $name->city_name;
			}
		}
		return $arrayOutput;
    }
    
    function getAirportNameBasedOnCode($airport_code = "")
    {
	    $arrayOutput = "";
		$names = $this->All->select_template("code", $airport_code, "flight_airportV2");
		if( $names == TRUE ) {
			foreach( $names AS $name ) {
				$arrayOutput = $name->name;
			}
		}
		return $arrayOutput;
    }
    
    function convertToHoursMins($time, $format = '%02d:%02d') 
    {
	    if( $time < 1 ) {
	    	return;
	    }
	    $hours 	 = floor($time / 60);
	    $minutes = ($time % 60);
	    return sprintf($format, $hours, $minutes);
	}
	
	function getRateConvertion($currency_code)
    {
	    $arrayOutput = "";
		$names = $this->All->select_template("currency_code", $currency_code, "flight_currency");
		if( $names == TRUE ) {
			foreach( $names AS $name ) {
				$arrayOutput = $name->rate;
			}
		}
		return $arrayOutput;
    }
	
}

?>