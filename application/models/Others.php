<?php

class Others extends CI_Model {

    function _construct()
	{
      	parent::_construct();
	}

	function check_hotelCart($userAccessID)
	{
		$return = "";
		if( $userAccessID == "NONE" ) {
			$return = "NO";
		}
		else {
			$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			$check_res  = mysqli_query($connection, "SELECT * FROM hotel_cart WHERE user_access_id = ".$userAccessID."");
			if( mysqli_num_rows($check_res) > 0 ) {
				$return = "YES";
			}
			else {
				$return = "NO";
			}
		}
		return $return;
	}

	function check_flightCart($userAccessID)
	{
		$return = "";
		if( $userAccessID == "NONE" ) {
			$return = "NO";
		}
		else {
			$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			$check_res  = mysqli_query($connection, "SELECT * FROM flight_cart WHERE user_access_id = ".$userAccessID."");

			if( mysqli_num_rows($check_res) > 0 ) {
				$return = "YES";
			}
			else {
				$return = "NO";
			}
		}

		return $return;
	}

	function check_landtourCart($userAccessID)
	{
		$return = "";
		if( $userAccessID == "NONE" ) {
			$return = "NO";
		}
		else {
			$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			$check_res  = mysqli_query($connection, "SELECT * FROM landtour_cart WHERE user_access_id = ".$userAccessID."");
			if( mysqli_num_rows($check_res) > 0 ) {
				$return = "YES";
			}
			else {
				$return = "NO";
			}
		}
		return $return;
	}

	function check_cruiseCart($userAccessID)
	{
		$return = "";
		if( $userAccessID == "NONE" ) {
			$return = "NO";
		}
		else {
			$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			$check_res  = mysqli_query($connection, "SELECT * FROM cruise_cart WHERE user_access_id = ".$userAccessID."");
			if( mysqli_num_rows($check_res) > 0 ) {
				$return = "YES";
			}
			else {
				$return = "NO";
			}
		}
		return $return;
	}

	function countCruiseHistoryOrder($confirmBookingID)
	{
		$return = "";
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"SELECT COUNT(*) AS totalItem FROM cruise_historyOrder WHERE cruise_confirmedBookOrder_ID = ".$confirmBookingID.""
		);
		if( mysqli_num_rows($check_res) > 0 ) {
			$check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
			$return = $check_row["totalItem"];
		}
		else {
			$return = 0;
		}
		return $return;
	}

	function countHotelHistoryOrder($confirmBookingID)
	{
		$return = "";
		$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$check_res  = mysqli_query(
			$connection,
			"SELECT COUNT(*) AS totalItem FROM hotel_historyOder WHERE hotel_confirmedBookOrder_ID = ".$confirmBookingID.""
		);
		if( mysqli_num_rows($check_res) > 0 ) {
			$check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
			$return = $check_row["totalItem"];
		}
		else {
			$return = 0;
		}
		return $return;
	}

}
?>