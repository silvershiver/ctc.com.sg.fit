<?php
session_start();
require('linkedin_sdk/http.php');
require('linkedin_sdk/oauth_client.php');
define("API_KEY", 	 	"7554ft0iaq8syk");
define("SECRET_KEY", 	"4JiIXTvRmvy7tU98");
define("SITE_URL", 		"http://54.251.177.123/ctcfitapp1/webservices/pages/");
define("REDIRECT_URL", 	SITE_URL."linkedin_login.php");
define("SCOPE", 		'r_basicprofile r_emailaddress');
define("LOGOUT_URL", 	SITE_URL."linkedin_logout.php");
 
$client = new oauth_client_class;
$client->debug = false;
$client->debug_http = true;
$client->redirect_uri = REDIRECT_URL;
 
$client->client_id = API_KEY;
$application_line = __LINE__;
$client->client_secret = SECRET_KEY;
 
if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
  die('Please go to LinkedIn Apps page');
 
$client->scope = SCOPE;
if (($success = $client->Initialize())) {
  if (($success = $client->Process())) {
    if (strlen($client->authorization_error)) {
      $client->error = $client->authorization_error;
      $success = false;
    } elseif (strlen($client->access_token)) {
      $success = $client->CallAPI(
	  'http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,picture-url,public-profile-url,formatted-name,maiden-name,phonetic-first-name,phonetic-last-name,headline,location,industry,current-share,num-connections,num-connections-capped,summary,specialties,positions,picture-urls::(original),site-standard-profile-request,api-standard-profile-request)', 
					'GET', array(
						'format'=>'json'
					), array('FailOnAccessError'=>true), $user);
    }
  }
  $success = $client->Finalize($success);
}
if ($client->exit) exit;
$_SESSION["user_details"] = $user;
header("Location: linkedin.php");
?>