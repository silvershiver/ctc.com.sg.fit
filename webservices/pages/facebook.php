<?php
require_once(__DIR__.'/fb_sdk/autoload.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CTCFITApp - Facebook Login API</title>
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
<script>
	//Load the Facebook JS SDK
	(function(d){
		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/en_US/all.js";
		ref.parentNode.insertBefore(js, ref);
 	}(document));

 	// Init the SDK upon load
 	window.fbAsyncInit = function() {
 		FB.init({
 			appId  : '174419019408634', // App ID
 			status : true, // check login status
 			cookie : true, // enable cookies to allow the server to access the session
 			xfbml  : true  // parse XFBML
  		});
  		// Specify the extended permissions needed to view user data
  		// The user will be asked to grant these permissions to the app (so only pick those that are needed)
        var permissions = [
          	'email',
		  	'user_likes',
		  	'user_about_me',
		  	'user_birthday',
		  	'user_education_history',
		  	'user_hometown',
		  	'user_relationships',
		  	'user_relationship_details',
		  	'user_location',
		  	'user_religion_politics',
		  	'user_website',
		  	'user_work_history',
		  	'public_profile',
		  	'user_friends',
		  	'user_actions.books',
		  	'user_actions.fitness',
		  	'user_actions.music',
          'user_actions.news',
          'user_actions.video',
          'user_events',
          'user_games_activity',
          'user_managed_groups',
          'user_photos',
          'user_posts',
          'user_tagged_places',
          'user_videos',
          'read_custom_friendlists',
          'read_insights',
          'read_page_mailboxes',
          'manage_pages',
          'publish_pages',
          'publish_actions',
          'rsvp_event',
          'ads_read',
          'ads_management',
          ].join(',');

// Specify the user fields to query the OpenGraph for.
// Some values are dependent on the user granting certain permissions
        var fields = [
          'id',
          'name',
          'first_name',
          'middle_name',
          'last_name',
          'gender',
          'locale',
          'languages',
          'link',
          'third_party_id',
          'installed',
          'timezone',
          'updated_time',
          'verified',
          'age_range',
          'bio',
          'birthday',
          'cover',
          'currency',
          'devices',
          'education',
          'email',
          'hometown',
          'interested_in',
          'location',
          'political',
          'payment_pricepoints',
          'favorite_athletes',
          'favorite_teams',
          'picture',
          'quotes',
          'relationship_status',
          'religion',
          'significant_other',
          'video_upload_limits',
          'website',
          'work'
          ].join(',');

  function showDetails() {
    FB.api('/me', {fields: fields}, function(details) {
      // output the response
      $('#userdata').html(JSON.stringify(details, null, '\t'));
      $('#fb-login').attr('style', 'display:none;');
    });
  }


  $('#fb-login').click(function(){
    //initiate OAuth Login
    FB.login(function(response) { 
      // if login was successful, execute the following code
      if(response.authResponse) {
          showDetails();
      }
    }, {scope: permissions});
  });

};
</script>

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
                    <h1 class="page-header">Facebook Login API - Get Facebook User Data</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Testing Facebook API Credentials.
                            <br />
                            <b>App ID: 174419019408634</b>
                            <br />
                            <b>App Secret: 07c3da497c8b957ffe4885a8dedaec5a</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
<button id="fb-login">Login to Facebook</button>
<br /><br />
<pre id="userdata">Result data will be here</pre>
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
