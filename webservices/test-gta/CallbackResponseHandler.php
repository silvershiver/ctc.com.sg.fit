<?php

	// Extract Response XML From Request Data
	$data = file_get_contents( 'php://input' );
	//echo $data;

	$inputDoc = new DOMDocument();
	$inputDoc->loadXML($data);
	
	$xpath = new DOMXPath( $inputDoc );
	$responseElement = $inputDoc->documentElement;

	// Process Response XML Data 
	$errorsElements = $xpath->query( 'ResponseDetails/SearchHotelPriceResponse/Errors', $responseElement );
	if( $errorsElements->length > 0 ) {
	    // Process Errors
	    //echo '<p>Invalid Search Request</p>';
	} else {
	    // Process Response Data Here
	    //echo '<p>Search Request data OK</p>';
	}

?>
