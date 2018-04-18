<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CTCFITApp - Linkedin Login API</title>
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
	<?php
	define("API_KEY", 	 	"7554ft0iaq8syk");
	define("SECRET_KEY", 	"4JiIXTvRmvy7tU98");
	define("SITE_URL", 		"http://54.251.177.123/ctcfitapp1/webservices/pages/");
	define("REDIRECT_URL", 	SITE_URL."linkedin_login.php");
	define("SCOPE", 		'r_basicprofile r_emailaddress');
	define("LOGOUT_URL", 	SITE_URL."linkedin_logout.php");
	?>
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
                    <h1 class="page-header">Linkedin Login API - Get Full User Data</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Testing Linkedin API Credentials.
                            <br />
                            <b>Client ID: 7554ft0iaq8syk</b>
                            <br />
                            <b>Client Secret: 4JiIXTvRmvy7tU98</b>
                            <br />
                            <b>
                            	Detail fields retrieve: 
                            	<a target="_blank" href="https://developer.linkedin.com/docs/fields/basic-profile">
	                            	https://developer.linkedin.com/docs/fields/basic-profile
                            	</a>
                            </b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
<a href="linkedin_login.php">Login with LinkedIn</a>
<br /><br />
<a href="<?php echo LOGOUT_URL; ?>">Logout from linkedin</a>
<br /><br />
<?php
if( $_SESSION["user_details"] != "" ) {
?>
	<pre>
		<?php echo print_r($_SESSION["user_details"]); ?>
	</pre>
<?php
}
else {
?>
	<pre>
		Result data will be here
	</pre>
<?php
}
?>

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
</body>
</html>
