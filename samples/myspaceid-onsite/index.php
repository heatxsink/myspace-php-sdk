<?php
define('LIB_PATH', 		"../../source/");
define('CONFIG_PATH', 	"../../config/");
define('LOCAL', false);

//gets a base path to the project  the "3rd parent" directory
$path_extra = dirname(dirname(dirname(__FILE__)));

//gets the default include path(s)
$path = ini_get('include_path');

//lets add a few more default paths.
$path = CONFIG_PATH . PATH_SEPARATOR
		.	LIB_PATH . PATH_SEPARATOR
		.	$path_extra . PATH_SEPARATOR
		.	$path;

//sets the new path(s) for php
ini_set('include_path', $path);

//turns on all error reporting
error_reporting(E_ALL);

//loads the configuration file with you're consumer key and secret
// uses the ternary operation for readability
// http://en.wikipedia.org/wiki/Ternary_operation
// BOOL ? (eval if BOOL == true) : (eval if BOOL == false);
require_once LOCAL ? "config.MySpace.local.php" : "config.MySpace.php";

//loads the myspaceid api sdk
require_once "MySpaceID/myspace.php";

$ms_key = "[your onsite app key]";
$ms_secret = "[your onsite app secret]";

print "Hello, this is an onsite app using the MySpaceID PHP SDK.<br>";
//print $_SERVER['REQUEST_URI'] . "<br>";
//print $_GET . "<br>";
//print_r($_GET) . "<br>";

//
// Compute signature of request to verify
//
$method = $_SERVER["REQUEST_METHOD"];
$req = OAuthRequest::from_request($method, $http_url);

$req->del_parameter('oauth_signature'); 
//print "<br>Req = " . $req;
$sigMethod = new OAuthSignatureMethod_HMAC_SHA1();
$consumer = new OAuthConsumer($ms_key, $ms_secret);
$signature = $sigMethod->build_signature($req, $consumer);
print "<br>Base string = " . $req.base_string;
print "<br>Built Signature = " . $signature . "";
print "<br>Passed in Signature = " . $_GET['oauth_signature'] . "<br>";

if (strcmp($_GET['oauth_signature'], $signature) != 0) {
	print "Signatures don't match!  Exiting.<br>";
}
else {
  print "Signatures match!";  
  		
  // Send notification
  $userId = @$_GET['opensocial_viewer_id'];
  $ms = new MySpace($ms_key, $ms_secret, null, null, false);

  $templateParameters = array('content'=>'Test notification content from php sdk', 'button0_surface'=>'canvas', 'button0_label'=>'Go To App Canvas', 'button1_surface'=>'appProfile', 'button1_label'=>'Go To App Profile');
  $rc = $ms->sendNotification('129910', '454304609,28568917', $templateParameters, 'http://api.myspace.com/v1/users/296768296');
  echo '<br><br>sendNotification returned ' . $rc;

  $profileInfo = $ms->getProfile($userId);
  displayProfileInfo($profileInfo);
  
  $albumInfo = $ms->getAlbumInfo($userId, "817520");
  displayAlbumInfo($albumInfo);
  
  $appData = $ms->getGlobalAppData();
  displayObject($appData, "appData");
  $ms->putGlobalAppData(array('animal'=>'giraffe', 'plant'=>'rose', 'mineral'=>'sandstone'));
  sleep(3);
  $appData = $ms->getGlobalAppData();
  displayObject($appData, "appData");
  $appData = $ms->getGlobalAppData('animal;plant');
  displayObject($appData, "appData for only animal and plant");
  $ms->clearGlobalAppData('animal;mineral');
  sleep(3);
  $appData = $ms->getGlobalAppData();
  displayObject($appData, "appData");
}

function displayObject($obj, $name) {
	print '<b>'.$name.' = </b>';
	print_r($obj);
	print '<br/>';
}

function displayAlbumInfo($albumInfo) {
	$s = "album info:";
	$s .= "ID: " . $albumInfo->id;
	$s .= "Title: " . $albumInfo->title . "<br>";
	echo $s;
}

function displayProfileInfo($profile_data)
{
	$profileInfo =  "<h3>Your MySpace Profile Information</h3>";

	$profileInfo.= "<img src='" . $profile_data->basicprofile->image . "'> <br>";
	$profileInfo.= "Profile URL: " . "<a href='" . $profile_data->basicprofile->webUri . "'>" . $profile_data->basicprofile->webUri . "</a><br>";
	$profileInfo.= "Name: " . $profile_data->basicprofile->name . "<br>";
	$profileInfo.= "Gender: " . $profile_data->gender . "<br>";
	$profileInfo.= "Age: " . $profile_data->age . "<br>";
	$profileInfo.= "Marital Status: " . $profile_data->maritalstatus . "<br>";
	$profileInfo.= "City: " . $profile_data->city . "<br>";
	$profileInfo.= "Postal Code: " . $profile_data->postalcode . "<br>";
	$profileInfo.= "Region: " . $profile_data->region . "<br>";
	$profileInfo.= "Country: " . $profile_data->country . "<br>";

	echo $profileInfo;
}



?>