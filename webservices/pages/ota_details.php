<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CTCFITApp - OTA Details</title>
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	        <!--START HEADER-->
            <?php require("../master/header-nav.php"); ?>
            <!--END OF START HEADER-->
            <!--START HEADER-->
            <?php require("../master/side-nav.php"); ?>
            <!--END OF START HEADER-->
        </nav>
		<!-- End of Navigation -->

        <div id="page-wrapper">
    
            <?php
	        if( $_GET["page"] == "tourmasters_show" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">GET tourmasters/show</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Returns a single Tour Master, specified by the TourCode parameter below. A list of standard itineraries will be returned inline.
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="get" action="ota_details.php">
                                        <div class="form-group">
                                            <label>Enter tour code</label>
                                            <input type="hidden" name="page" value="tourmasters_show" />
                                            <input type="text" name="tour_code" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$base_url  = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourmasters/show/";
$tour_code = "12AU07F 15/15SQ-P";
$oringal_xml = simplexml_load_file($base_url.$tour_code);
$xml = json_decode(json_encode($oringal_xml), 1);
print_r($xml);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_GET["tour_code"] == TRUE ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from from above</b></p>
<?php
//tour master show
$base_url  = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourmasters/show/";
$tour_code = $_GET["tour_code"];
$oringal_xml = simplexml_load_file($base_url.$tour_code);
$xml = json_decode(json_encode($oringal_xml), 1);
echo "<pre>";
print_r($xml);
echo "</pre>";
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "tourmasters_searchtourtype" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">GET tourmasters/searchtourtype</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Returns a list of Tour Masters for a specific the tour type. The list is group by tour type, and does not include standard itineraries.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://203.120.188.141/API-CT/OTSAPIService.svc/tourmasters/searchtourtype?q={query}&ski p={skip}&top={top}&since={startdate}&until={enddate}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="get" action="ota_details.php">
                                        <div class="form-group">
                                            <label>Enter tour type</label>
                                            <input type="hidden" name="page" value="tourmasters_searchtourtype" />
                                            <input type="text" name="tour_type" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$base_url  = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourmasters/searchtourtype?q=";
$tour_type = $_GET["tour_type"];
$oringal_xml = simplexml_load_file($base_url.$tour_type);
$xml = json_decode(json_encode($oringal_xml), 1);
print_r($xml);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_GET["tour_type"] == TRUE ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from from above</b></p>
<?php
//tour master show
$base_url  = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourmasters/searchtourtype?q=";
$tour_type = $_GET["tour_type"];
$oringal_xml = simplexml_load_file($base_url.$tour_type);
$xml = json_decode(json_encode($oringal_xml), 1);
echo "<pre>";
print_r($xml);
echo "</pre>";
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "tourmasters_searcharea" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">GET tourmasters/searcharea</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Returns a list of Tour Masters for a specific the tour area. The list is group by tour type, and does not include standard itineraries.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourmasters/searcharea?q={query}&skip={s kip}&top={top}&since={startdate}&until={enddate}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="get" action="ota_details.php">
                                        <div class="form-group">
                                            <label>Enter tour area</label>
                                            <input type="hidden" name="page" value="tourmasters_searcharea" />
                                            <input type="text" name="tour_area" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$base_url  = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourmasters/searcharea?q=";
$tour_area = $_GET["tour_area"];
$oringal_xml = simplexml_load_file($base_url.$tour_area);
$xml = json_decode(json_encode($oringal_xml), 1);
print_r($xml);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_GET["tour_area"] == TRUE ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from from above</b></p>
<?php
$base_url  = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourmasters/searcharea?q=";
$tour_area = $_GET["tour_area"];
$oringal_xml = simplexml_load_file($base_url.$tour_area);
$xml = json_decode(json_encode($oringal_xml), 1);
echo "<pre>";
print_r($xml);
echo "</pre>";
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "post_tourreservation" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">POST tourreservation/reserve</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Reserve certain number of passengers for a specific tour code. Reservation will be valid for a certain period of time only (currently, set to 5 minutes). Reservation will be released upon expiration.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourreservation/reserve?tourcode={tourco de}&seat={seat}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="ota_details.php?page=post_tourreservation">
                                        <div class="form-group">
                                            <label>Enter tour code</label>
                                            <input type="text" name="tour_code" required class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label>Enter number of seat</label>
                                            <input type="text" name="seat_number" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$tour_code   = $_POST["tour_code"];
$seat_number = $_POST["seat_number"];
$data_posts  = "tourcode=$tour_code&seat=$seat_number";
$url 		 = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourreservation/reserve?$data_posts";
$ch 		 = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_posts));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
$data = curl_exec($ch);
curl_close($ch);
print_r($data);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_POST["tour_code"] != NULL && $_POST["seat_number"] != NULL ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from from above</b></p>
<?php
$tour_code   = $_POST["tour_code"];
$seat_number = $_POST["seat_number"];
$data_posts  = "tourcode=$tour_code&seat=$seat_number";
$url 		 = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourreservation/reserve?$data_posts";
$ch 		 = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_posts));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
$data = curl_exec($ch);
curl_close($ch);
print_r('<pre>');
print_r($data);
print_r('</pre>');
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "put_tourreservation" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">PUT tourreservation</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Extend the reservation by another 5 minutes. Reservation will be released upon expiration.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourreservation/{resvn}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="ota_details.php?page=put_tourreservation">
                                        <div class="form-group">
                                            <label>Enter resvn</label>
                                            <input type="text" name="resvn" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$resvnID 	 = $_POST["resvn"];
$data    	 = array("resvn" => $resvnID);                                                                   
$data_string = json_encode($data);                                                                                   
$ch = curl_init("http://203.120.188.141/API-CT/OTSAPIService.svc/tourreservation/".$resvnID);                                                                     
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
$result = curl_exec($ch);
print_r($result);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_POST["resvn"] != NULL ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from from above</b></p>
<?php
$resvnID 	 = $_POST["resvn"];
$data    	 = array("resvn" => $resvnID);                                                                   
$data_string = json_encode($data);                                                                                   
$ch = curl_init("http://203.120.188.141/API-CT/OTSAPIService.svc/tourreservation/".$resvnID);                                                                     
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
$result = curl_exec($ch);
print_r('<pre>');
print_r($result);
print_r('</pre>');
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "delete_tourreservation" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">DELETE tourreservation</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Delete the reservation.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourreservation/{resvn}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="ota_details.php?page=delete_tourreservation">
                                        <div class="form-group">
                                            <label>Enter resvn</label>
                                            <input type="text" name="resvn" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$resvnID 	 = $_POST["resvn"];
$data    	 = array("resvn" => $resvnID);                                                                   
$data_string = json_encode($data);                                                                                   
$ch = curl_init("http://203.120.188.141/API-CT/OTSAPIService.svc/tourreservation/".$resvnID);                                                                     
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
$result = curl_exec($ch);
print_r($result);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_POST["resvn"] != NULL ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from from above</b></p>
<?php
$resvnID 	 = $_POST["resvn"];
$data    	 = array("resvn" => $resvnID);                                                                   
$data_string = json_encode($data);                                                                                   
$ch = curl_init("http://203.120.188.141/API-CT/OTSAPIService.svc/tourreservation/".$resvnID);                                                                     
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
$result = curl_exec($ch);
print_r('<pre>');
print_r($result);
print_r('</pre>');
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "post_tourbookings_book" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">POST tourbookings/book</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Commit reservation to booking, create a new tour booking.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourbookings/bookfull/{resvn}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="ota_details.php?page=post_tourbookings_book">
                                        <div class="form-group">
                                            <label>Enter resvn</label>
                                            <input type="text" name="resvn" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<textarea name="" readonly class="form-control" style="resize:none; height:500px">
<groupTourBooking xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
	<roomList>
		<bookingRoom>
			<roomNo>1</roomNo>
			<paxList>
				<bookingPax>
					<title>MR</title>
					<lastName>TAN</lastName>
					<firstName>AH BENG</firstName>
					<paxType>A</paxType>
					<birthDate>1966-12-04T00:00:00</birthDate>
					<gender>M</gender>
					<occupation></occupation>
					<homeTel>67654321</homeTel>
					<officeTel></officeTel>
					<handPhone>87654321</handPhone>
					<eMail>ABTAN@YAHOO.COM</eMail>
					<nationality>SINGAPORE</nationality>
					<passportNo>E1425077F</passportNo>
					<passportType></passportType>
					<passportExpiryDate>2018-12-30T00:00:00</passportExpiryDate>
					<passportDateIssued>2013-07-30T00:00:00</passportDateIssued>
					<passportPlaceIssued></passportPlaceIssued>
					<address1>129C FIDELIO STREET SPOR</address1>
					<address2>454950</address2>
					<address3></address3>
					<postalCode></postalCode>
					<roomType></roomType>
					<mealCode></mealCode>
					<noBed></noBed>
				</bookingPax>
			</paxList>
		</bookingRoom>
	</roomList>
	<tourCode>12AU06B 09/14SQ</tourCode>
	<paxTravelType>G</paxTravelType>
	<bookingDate>2014-09-08T16:19:23.4200298+08:00</bookingDate>
	<landOnly></landOnly>
	<pnrNo></pnrNo>
	<custRef></custRef>
	<contactName>TAN AH BENG</contactName>
	<faxNo></faxNo>
	<remark1>ABTAN@YAHOO.COM</remark1>
	<remark2></remark2>
	<remark3></remark3>
	<instruction1></instruction1>
	<instruction2></instruction2>
	<instruction3></instruction3>
	<instruction4></instruction4>
	<instruction5></instruction5>
	<instruction6></instruction6>
	<instruction7></instruction7>
	<instruction8></instruction8>
	<bookingStaff></bookingStaff>
</groupTourBooking>
</textarea>
<br />
<pre>
$raw_xml = 'See format web booking above';
$tour_resv_id = $_POST["resvn"];
$xml = $raw_xml;
$ch = curl_init("http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/book/$tour_resv_id");               
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	'Content-Type: application/xml',                                                                                
	'Content-Length: '.strlen($xml))                                                                       
);                                                                                                                 
$result = curl_exec($ch);
print_r($result);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_POST["resvn"] != NULL ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from form above</b></p>
<?php
$raw_xml = '
<groupTourBooking xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
	<roomList>
		<bookingRoom>
			<roomNo>1</roomNo>
			<paxList>
				<bookingPax>
					<title>MR</title>
					<lastName>TAN</lastName>
					<firstName>AH BENG</firstName>
					<paxType>A</paxType>
					<birthDate>1966-12-04T00:00:00</birthDate>
					<gender>M</gender>
					<occupation></occupation>
					<homeTel>67654321</homeTel>
					<officeTel></officeTel>
					<handPhone>87654321</handPhone>
					<eMail>ABTAN@YAHOO.COM</eMail>
					<nationality>SINGAPORE</nationality>
					<passportNo>E1425077F</passportNo>
					<passportType></passportType>
					<passportExpiryDate>2018-12-30T00:00:00</passportExpiryDate>
					<passportDateIssued>2013-07-30T00:00:00</passportDateIssued>
					<passportPlaceIssued></passportPlaceIssued>
					<address1>129C FIDELIO STREET SPOR</address1>
					<address2>454950</address2>
					<address3></address3>
					<postalCode></postalCode>
					<roomType></roomType>
					<mealCode></mealCode>
					<noBed></noBed>
				</bookingPax>
			</paxList>
		</bookingRoom>
	</roomList>
	<tourCode>12AU06B 09/14SQ</tourCode>
	<paxTravelType>G</paxTravelType>
	<bookingDate>2014-09-08T16:19:23.4200298+08:00</bookingDate>
	<landOnly></landOnly>
	<pnrNo></pnrNo>
	<custRef></custRef>
	<contactName>TAN AH BENG</contactName>
	<faxNo></faxNo>
	<remark1>ABTAN@YAHOO.COM</remark1>
	<remark2></remark2>
	<remark3></remark3>
	<instruction1></instruction1>
	<instruction2></instruction2>
	<instruction3></instruction3>
	<instruction4></instruction4>
	<instruction5></instruction5>
	<instruction6></instruction6>
	<instruction7></instruction7>
	<instruction8></instruction8>
	<bookingStaff></bookingStaff>
</groupTourBooking>
';
$tour_resv_id = $_POST["resvn"];
$xml = $raw_xml;
$ch = curl_init("http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/book/$tour_resv_id");               
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	'Content-Type: application/xml',                                                                                
	'Content-Length: '.strlen($xml))                                                                       
);                                                                                                                 
$result = curl_exec($ch);
print_r('<pre>');
print_r($result);
print_r('</pre>');
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "post_tourbookings_bookfull" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">POST tourbookings/bookfull</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Commit reservation to booking, create a new tour booking with detailed fares.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourbookings/bookfull/{resvn}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="ota_details.php?page=post_tourbookings_bookfull">
                                        <div class="form-group">
                                            <label>Enter resvn</label>
                                            <input type="text" name="resvn" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<textarea name="" readonly class="form-control" style="resize:none; height:500px">
<groupTourBooking xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
	<roomList>
		<bookingRoom>
			<roomNo>1</roomNo>
			<paxList>
				<bookingPax>
					<title>MR</title>
					<lastName>TAN</lastName>
					<firstName>AH BENG</firstName>
					<paxType>A</paxType>
					<birthDate>1966-12-04T00:00:00</birthDate>
					<gender>M</gender>
					<occupation></occupation>
					<homeTel>67654321</homeTel>
					<officeTel></officeTel>
					<handPhone>87654321</handPhone>
					<eMail>ABTAN@YAHOO.COM</eMail>
					<nationality>SINGAPORE</nationality>
					<passportNo>E1425077F</passportNo>
					<passportType></passportType>
					<passportExpiryDate>2018-12-30T00:00:00</passportExpiryDate>
					<passportDateIssued>2013-07-30T00:00:00</passportDateIssued>
					<passportPlaceIssued></passportPlaceIssued>
					<address1>129C FIDELIO STREET SPOR</address1>
					<address2>454950</address2>
					<address3></address3>
					<postalCode></postalCode>
					<roomType></roomType>
					<mealCode></mealCode>
					<noBed></noBed>
				</bookingPax>
			</paxList>
		</bookingRoom>
	</roomList>
	<tourCode>12AU06B 09/14SQ</tourCode>
	<paxTravelType>G</paxTravelType>
	<bookingDate>2014-09-08T16:19:23.4200298+08:00</bookingDate>
	<landOnly></landOnly>
	<pnrNo></pnrNo>
	<custRef></custRef>
	<contactName>TAN AH BENG</contactName>
	<faxNo></faxNo>
	<remark1>ABTAN@YAHOO.COM</remark1>
	<remark2></remark2>
	<remark3></remark3>
	<instruction1></instruction1>
	<instruction2></instruction2>
	<instruction3></instruction3>
	<instruction4></instruction4>
	<instruction5></instruction5>
	<instruction6></instruction6>
	<instruction7></instruction7>
	<instruction8></instruction8>
	<bookingStaff></bookingStaff>
</groupTourBooking>
</textarea>
<br />
<pre>
$raw_xml = 'See format web booking above';
$tour_resv_id = $_POST["resvn"];
$xml = $raw_xml;
$ch = curl_init("http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/bookfull/$tour_resv_id");               
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	'Content-Type: application/xml',                                                                                
	'Content-Length: '.strlen($xml))                                                                       
);                                                                                                                 
$result = curl_exec($ch);
print_r($result);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_POST["resvn"] != NULL ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from form above</b></p>
<?php
$raw_xml = '
<groupTourBooking xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
	<roomList>
		<bookingRoom>
			<roomNo>1</roomNo>
			<paxList>
				<bookingPax>
					<title>MR</title>
					<lastName>TAN</lastName>
					<firstName>AH BENG</firstName>
					<paxType>A</paxType>
					<birthDate>1966-12-04T00:00:00</birthDate>
					<gender>M</gender>
					<occupation></occupation>
					<homeTel>67654321</homeTel>
					<officeTel></officeTel>
					<handPhone>87654321</handPhone>
					<eMail>ABTAN@YAHOO.COM</eMail>
					<nationality>SINGAPORE</nationality>
					<passportNo>E1425077F</passportNo>
					<passportType></passportType>
					<passportExpiryDate>2018-12-30T00:00:00</passportExpiryDate>
					<passportDateIssued>2013-07-30T00:00:00</passportDateIssued>
					<passportPlaceIssued></passportPlaceIssued>
					<address1>129C FIDELIO STREET SPOR</address1>
					<address2>454950</address2>
					<address3></address3>
					<postalCode></postalCode>
					<roomType></roomType>
					<mealCode></mealCode>
					<noBed></noBed>
				</bookingPax>
			</paxList>
		</bookingRoom>
	</roomList>
	<tourCode>12AU06B 09/14SQ</tourCode>
	<paxTravelType>G</paxTravelType>
	<bookingDate>2014-09-08T16:19:23.4200298+08:00</bookingDate>
	<landOnly></landOnly>
	<pnrNo></pnrNo>
	<custRef></custRef>
	<contactName>TAN AH BENG</contactName>
	<faxNo></faxNo>
	<remark1>ABTAN@YAHOO.COM</remark1>
	<remark2></remark2>
	<remark3></remark3>
	<instruction1></instruction1>
	<instruction2></instruction2>
	<instruction3></instruction3>
	<instruction4></instruction4>
	<instruction5></instruction5>
	<instruction6></instruction6>
	<instruction7></instruction7>
	<instruction8></instruction8>
	<bookingStaff></bookingStaff>
</groupTourBooking>
';
$tour_resv_id = $_POST["resvn"];
$xml = $raw_xml;
$ch = curl_init("http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/bookfull/$tour_resv_id");               
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	'Content-Type: application/xml',                                                                                
	'Content-Length: '.strlen($xml))                                                                       
);                                                                                                                 
$result = curl_exec($ch);
print_r('<pre>');
print_r($result);
print_r('</pre>');
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "get_tourbookings" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">GET tourbookings</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Return the web booking details.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourbookings/{bookingno}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="get" action="ota_details.php">
                                        <div class="form-group">
                                            <label>Enter booking no.</label>
                                            <input type="hidden" name="page" value="get_tourbookings" />
                                            <input type="text" name="bookingno" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$base_url  = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/";
$bookingno = $_GET["bookingno"];
$oringal_xml = simplexml_load_file($base_url.$bookingno);
$xml = json_decode(json_encode($oringal_xml), 1);
print_r($xml);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_GET["bookingno"] != NULL ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from form above</b></p>
<?php
$bookingno = $_GET["bookingno"];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/$bookingno");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
$output = curl_exec($ch);
echo "<pre>";
print_r($output);
echo "</pre>";
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "get_tourbookings_pax" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">GET tourbookings/pax</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           	Return the web booking pax details.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourbookings/pax/{bookingno}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="get" action="ota_details.php">
                                        <div class="form-group">
                                            <label>Enter booking no.</label>
                                            <input type="hidden" name="page" value="get_tourbookings_pax" />
                                            <input type="text" name="bookingno" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$base_url  = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/pax/";
$bookingno = $_GET["bookingno"];
$oringal_xml = simplexml_load_file($base_url.$bookingno);
$xml = json_decode(json_encode($oringal_xml), 1);
print_r($xml);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_GET["bookingno"] != NULL ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from form above</b></p>
<?php
$bookingno = $_GET["bookingno"];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/pax/$bookingno");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
$output = curl_exec($ch);
echo "<pre>";
print_r($output);
echo "</pre>";
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "get_tourbookings_itinerary" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">GET tourbookings/itinerary</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           	Return the web booking details.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourbookings/itinerary/{bookingno}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="get" action="ota_details.php">
                                        <div class="form-group">
                                            <label>Enter booking no.</label>
                                            <input type="hidden" name="page" value="get_tourbookings_itinerary" />
                                            <input type="text" name="bookingno" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$base_url  = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/itinerary";
$bookingno = $_GET["bookingno"];
$oringal_xml = simplexml_load_file($base_url.$bookingno);
$xml = json_decode(json_encode($oringal_xml), 1);
print_r($xml);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_GET["bookingno"] != NULL ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from form above</b></p>
<?php
$bookingno = $_GET["bookingno"];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/itinerary/$bookingno");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
$output = curl_exec($ch);
echo "<pre>";
print_r($output);
echo "</pre>";
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "get_tourbookings_charges" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">GET tourbookings/charges</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           	Return the web booking charges details.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourbookings/charges/{bookingno}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="get" action="ota_details.php">
                                        <div class="form-group">
                                            <label>Enter booking no.</label>
                                            <input type="hidden" name="page" value="get_tourbookings_charges" />
                                            <input type="text" name="bookingno" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$base_url  = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/charges";
$bookingno = $_GET["bookingno"];
$oringal_xml = simplexml_load_file($base_url.$bookingno);
$xml = json_decode(json_encode($oringal_xml), 1);
print_r($xml);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_GET["bookingno"] != NULL ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from form above</b></p>
<?php
$bookingno = $_GET["bookingno"];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/charges/$bookingno");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
$output = curl_exec($ch);
echo "<pre>";
print_r($output);
echo "</pre>";
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "get_tourbookings_payment" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">GET tourbookings/payment</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           	Return the web booking payment details.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourbookings/payment/{bookingno}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="get" action="ota_details.php">
                                        <div class="form-group">
                                            <label>Enter booking no.</label>
                                            <input type="hidden" name="page" value="get_tourbookings_payment" />
                                            <input type="text" name="bookingno" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$base_url  = "http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/payment";
$bookingno = $_GET["bookingno"];
$oringal_xml = simplexml_load_file($base_url.$bookingno);
$xml = json_decode(json_encode($oringal_xml), 1);
print_r($xml);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_GET["bookingno"] != NULL ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from form above</b></p>
<?php
$bookingno = $_GET["bookingno"];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/payment/$bookingno");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
$output = curl_exec($ch);
echo "<pre>";
print_r($output);
echo "</pre>";
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
	        <?php
	        if( $_GET["page"] == "delete_tourbookings" ) {
	        ?>
	        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">DELETE tourbookings</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           	Delete the web booking. Not applicable if tour is departed or refund processing is required.
                        </div>
                        <div class="panel-heading">
                            <b>Format:</b><br />
                            http://server/otsapiservice.svc/tourbookings/{bookingno}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="get" action="ota_details.php">
                                        <div class="form-group">
                                            <label>Enter booking no.</label>
                                            <input type="hidden" name="page" value="delete_tourbookings" />
                                            <input type="text" name="bookingno" required class="form-control" />
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Example PHP Manual Code</b></p>
<pre>
$bookingno   = $_GET["bookingno"];
$data    	 = array("resvn" => $bookingno);                                                                   
$data_string = json_encode($data);                                                                                   
$ch = curl_init("http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/".$bookingno);                                                                     
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
$result = curl_exec($ch);
print_r($result);
</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
	            if( $_GET["bookingno"] != NULL ) {
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
<p><b>Result from form above</b></p>
<?php
$bookingno   = $_GET["bookingno"];
$data    	 = array("resvn" => $bookingno);                                                                   
$data_string = json_encode($data);                                                                                   
$ch = curl_init("http://203.120.188.141/API-CT/OTSAPIService.svc/tourbookings/".$bookingno);                                                                     
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
$result = curl_exec($ch);
print_r('<pre>');
print_r($result);
print_r('</pre>');
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
	            }
	            ?>
            </div>
            <?php
	        }
	        ?>
	        
        </div>
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>
</html>