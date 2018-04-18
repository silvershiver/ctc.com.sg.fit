<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CTCFITApp - OTA Web Services</title>
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
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
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">OTA Web Service Platform</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Outbound Travel System Web API
                            <br />
                            <b>Base URL API: http://203.120.188.141</b>
                            <br />
                            <b>Service API: http://203.120.188.141/API-CT/OTSAPIService.svc/</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th style="width:200px">Name</th>
                                            <th>Description</th>
                                            <th style="width:100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd gradeX">
                                            <td>GET tourmasters/show</td>
                                            <td>Returns a single Tour Master, specified by the TourCode parameter below. A list of standard itineraries will be returned inline.</td>
                                            <td>
	                                            <a href="ota_details.php?page=tourmasters_show">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>GET tourmasters/searchtourtype</td>
                                            <td>Returns a list of Tour Masters for a specific the tour type. The list is group by tour type, and does not include standard itineraries.</td>
                                            <td>
	                                            <a href="ota_details.php?page=tourmasters_searchtourtype">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>GET tourmasters/searcharea</td>
                                            <td>Returns a list of Tour Masters for a specific the tour area. The list is group by tour type, and does not include standard itineraries.</td>
                                            <td>
	                                            <a href="ota_details.php?page=tourmasters_searcharea">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>POST tourreservation/reserve</td>
                                            <td>Reserve certain number of passengers for a specific tour code. Reservation will be valid for a certain period of time only (currently, set to 5 minutes). Reservation will be released upon expiration.</td>
                                            <td>
	                                            <a href="ota_details.php?page=post_tourreservation">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>PUT tourreservation</td>
                                            <td>Extend the reservation by another 5 minutes. Reservation will be released upon expiration.</td>
                                            <td>
	                                            <a href="ota_details.php?page=put_tourreservation">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>DELETE tourreservation</td>
                                            <td>Delete the reservation.</td>
                                            <td>
	                                            <a href="ota_details.php?page=delete_tourreservation">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>POST tourbookings/book</td>
                                            <td>Commit reservation to booking, create a new tour booking.</td>
                                            <td>
	                                            <a href="ota_details.php?page=post_tourbookings_book">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>POST tourbookings/bookfull</td>
                                            <td>Commit reservation to booking, create a new tour booking with detailed fares.</td>
                                            <td>
	                                            <a href="ota_details.php?page=post_tourbookings_bookfull">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>GET tourbookings</td>
                                            <td>Return the web booking details.</td>
                                            <td>
	                                            <a href="ota_details.php?page=get_tourbookings">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>GET tourbookings/pax</td>
                                            <td>Return the web booking pax details.</td>
                                            <td>
	                                            <a href="ota_details.php?page=get_tourbookings_pax">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>GET tourbookings/itinerary</td>
                                            <td>Return the web booking details.</td>
                                            <td>
	                                            <a href="ota_details.php?page=get_tourbookings_itinerary">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>GET tourbookings/charges</td>
                                            <td>Return the web booking charges details.</td>
                                            <td>
	                                            <a href="ota_details.php?page=get_tourbookings_charges">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>GET tourbookings/payment</td>
                                            <td>Return the web booking payment details.</td>
                                            <td>
	                                            <a href="ota_details.php?page=get_tourbookings_payment">Details & Example</a>
	                                        </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>DELETE tourbookings</td>
                                            <td>Delete the web booking. Not applicable if tour is departed or refund processing is required.</td>
                                            <td>
	                                            <a href="ota_details.php?page=delete_tourbookings">Details & Example</a>
	                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
</body>
</html>
