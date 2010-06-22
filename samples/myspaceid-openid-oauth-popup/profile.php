<?php
header ('Content-type: text/html; charset=utf-8');

require_once "common.php";
require_once "MySpaceID/myspace.php";

session_start();

$profile_data = '';
$friends_data = '';


function isLoggedin(){
	return 	(
				isset($_SESSION['userID']) &&
				isset($_SESSION['access_token_key']) &&
				isset($_SESSION['access_token_secret'])
			);
}

function loginRequired(){

	if(isLoggedin()){
		//print $_SESSION['userID'] . " is logged in";
	}else{
		print "not logged in, please log in";
	}

}

function run(){
	loginRequired();
	$userid = $_SESSION['userID'];

	$ms = new MySpace(	CONSUMER_KEY,
						CONSUMER_SECRET,
						$_SESSION['access_token_key'],
						$_SESSION['access_token_secret']
					);

	// Use the userID (fetched in the previous step) to get user's profile, friends and other info
	$profile_data = $ms->getProfile($userid);
	$friends_data = $ms->getFriends($userid);


	$activities_data = $ms->getActivities_ATOM($userid);
	$friendsActivities_data = $ms->getFriendsActivities_ATOM($userid);//43508565

	$test2 = '';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MySpaceID Hybrid Example <?php echo isset($profile_data) ? $profile_data->basicprofile->name : 'not logged in'; ?> profile</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="static/base.css">

  <!-- YUI Combo CSS + JS files: -->
  	<link rel="stylesheet" type="text/css"
		href="http://yui.yahooapis.com/combo?2.6.0/build/tabview/assets/skins/sam/tabview.css">

  	<script type="text/javascript"
			src="http://yui.yahooapis.com/combo?2.6.0/build/yahoo-dom-event/yahoo-dom-event.js&2.6.0/build/imageloader/imageloader-min.js&2.6.0/build/element/element-beta-min.js&2.6.0/build/tabview/tabview-min.js"></script>

  	<style>
		.activity{
			background:#abc;
			border:1px #fff solid;
		}
	</style>
</head>
<body class="yui-skin-sam">

<h2>profile page</h2>
<?php

	if (isset($profile_data)) {
echo <<<EOL
		<div id="MySpaceTabs" class="yui-navset">
		    <ul class="yui-nav">
		        <li id='profileTab' class="selected"><a href="#tab1"><em>Profile</em></a></li>
		        <li id='friendsTab'><a href="#tab2"><em>Friends</em></a></li>
		        <li id='activitiesTab'><a href="#tab3"><em>Activities</em></a></li>
		    </ul>
		    <div class="yui-content">
		        <div id='profileTabContent'>
		        	<p><img src="{$profile_data->basicprofile->image}" /></p>
		            <p>Profile URL : <a href="{$profile_data->basicprofile->webUri}"> {$profile_data->basicprofile->webUri}</a><p>
		            <p>Name: <strong> {$profile_data->basicprofile->name} </strong> </p>
		            <p>Gender: <strong> {$profile_data->gender} </strong> </p>
		            <p>Age: <strong> {$profile_data->age} </strong> </p>
		            <p>Marital Status: <strong> {$profile_data->maritalstatus} </strong> </p>
		            <p>City: <strong> {$profile_data->city} </strong> </p>
		            <p>Postal Code: <strong> {$profile_data->postalcode} </strong> </p>
		            <p>Region: <strong> {$profile_data->region} </strong> </p>
		            <p>Country: <strong> {$profile_data->country} </strong> </p>
		        </div>
EOL;
	}


?>

<?php
	if (isset($friends_data)) {
	// Build up the HTML that represent the content that goes into the
	// Friends Tab
	// Then insert the content block via $friendsContent below
	//

	$onlineFriends_data = $ms->getFriends($userid,null, null, 'online', 'online');


	$friendsContent = "";
	foreach ($friends_data->Friends as $friend) {
		$friendsContent.= "<a href='{$friend->webUri}'>";
		$friendsContent.= "<img id='$friend->name' title='$friend->name' border='0'></a>";
	}
echo <<<EOL
				<div id='friendsTabContent'>
				    $friendsContent
		        </div>

EOL;
	}
?>



<?php
	if (isset($friendsActivities_data)) {
	// Build up the HTML that represent the content that goes into the
	// Friends Tab
	// Then insert the content block via $friendsContent below
	//


	echo "<div id='activitiesTabContent'>";

	$activitiesContent = $friendsActivities_data;
	//$title = mb_convert_encoding ($xml->entry[32]->title[0],'UTF-8',"UTF-8, ASCII, ISO-8859-1, EUC-JP,  SJIS, JIS") ;
	print '<span class="entry_title">';
	print $title;//$xml->entry[32]->title[0];
	print '</span>';
	print '<br/><span><strong>RAW:: </strong>'. mb_convert_encoding ('???? ???  ��� ???????  is now friends with Sue Cho', 'utf-8', "UTF-8, ASCII, ISO-8859-1, EUC-JP,  SJIS, JIS").'</span>';

print '<br /><span class="entry_title"><strong>'.mb_detect_encoding($title.'a'," UTF-8, ASCII, ISO-8859-1, UTF-16, UTF-32", true).'</strong></span>';
print '<br /><span class="entry_title"><strong>'.mb_http_output().'</strong></span>';

$xml = $friendsActivities_data;

$xml->registerXPathNamespace('atom','http://www.w3.org/2005/Atom');
$xml->registerXPathNamespace('activity','http://activitystrea.ms/schema/1.0/');
$xml->registerXPathNamespace('xCal','urn:ietf:params:xml:ns:xcal');

$xml->registerXPathNamespace('atom','http://www.w3.org/2005/Atom');

$songlist_xml = $xml->xpath('atom:entry/atom:category[@label="SongUpload" or @label="ProfileSongAdd"]/ancestor::atom:entry');

//$songlist_xml = $xml->xpath('atom:entry/atom:category[@label="SongUpload" or @label="ProfileSongAdd"]/..');

$band_data = $ms->getFriendsActivities_ATOM($userid, null, null, 'PersonalBandShowUpdate');//43508565

$band_data->registerXPathNamespace('atom','http://www.w3.org/2005/Atom');
$band_data->registerXPathNamespace('activity','http://activitystrea.ms/schema/1.0/');
$band_data->registerXPathNamespace('xCal','urn:ietf:params:xml:ns:xcal');

//$bandShows_xml = $band_data->xpath('atom:entry/atom:category[@label="PersonalBandShowUpdate"]/..');

$bandShows_xml = $band_data->xpath('//xCal:location/ancestor::atom:entry');

foreach($bandShows_xml as $bandShow){

	$bandShow_activity = 	$bandShow->xpath('activity:object');
	$bandShow_activity =	$bandShow_activity[0];
	$bandShow_title = 		(string)$bandShow_activity->title;
	$bandShow_link = 		(string)$bandShow_activity->link['href'];
	$bandShow_summary = 	(string)$bandShow_activity->vevent->summary;
	$bandShow_location =	(string)$bandShow_activity->vevent->location;
	//$bandShow_dateStart =	new DateTime( (string)$bandShow_activity->vevent-dsStart); //, 'Y-m-d\TH:i:s\Z', '%Y-%m-%dTH:%M:%SZ'); //2009-03-21T03:00:00Z
	$break = '';
}

echo "<h1><span class='display-name'>{$profile_data->basicprofile->name}'s Activites</span></h1>";

echo '<ul id="activities">';

foreach($songlist_xml as $song_entry){
	echo '<li>'.$song_entry->content->asXML().'</li>';
}
echo '</ul>';

foreach ($xml->xpath('atom:entry[category/@label="BlogAdd"]') as $entry){
	$children = '';
	$content = '';
	echo "\n<ul class='activities'>\n";
	switch ((string)$entry->category['label'][0]){

		case 'EventAttending':
		echo '<li class="activity">';

			$entry->registerXPathNamespace('atom','http://www.w3.org/2005/Atom');
			$iconlink = $entry->xpath('atom:id');
			$iconlink = $entry->xpath('atom:link[@rel="icon" and @href]');
			print "<img src='".$iconlink[0]['href']."' />";
			$children = $entry->content->div->children();
			foreach ($children as $child){
				$content = $child->asXML();
				echo "\n".$content."";
			}
			echo '</li><!-- class="activity" -->';
			break;
		case 'EventPosting':
		echo '<li class="activity">';
			$children = $entry->content->div->children();
			foreach ($children as $child){
				$content = $child->asXML();
				echo "\n".$content."";
			}
			echo '</li><!-- class="activity" -->';
			break;
		case 'ProfileSongAdd':
		echo '<li class="activity">';
			$children = $entry->content->div->children();
			foreach ($children as $child){
				$content = $child->asXML();
				echo "\n".$content."";
			}
			echo '</li><!-- class="activity" -->';
			break;
		case 'FriendAdd':
			break;
		case 'FriendCategoryAdd':
			break;
		case 'ForumPosted':
			break;
		case 'JoinedGroup':
			break;
		case 'ForumTopicReply':
			break;
		case 'ProfileVideoUpdate';
			break;
		case 'FavoriteVideoAdd';
			break;
		case 'PhotoAdd':
			break;
		case 'MobilePhotoUpload';
			break;
		case 'PhotoTagged':
			break;
		case 'BlogAdd':
			break;
		default:
			echo '<li class="activity">';
			$children = $entry->content->div->children();
			foreach ($children as $child){
				$content = $child->asXML();
				echo "\n".$content."";
			}
			echo '</li><!-- class="activity" -->';

	}
	echo "\n</ul>";

}

echo "</div>";
	}
?>

<?php
	if (isset($friends_data)) {

		// We build up a string that represents the image loader code
		// for each of the friend images.
		// We then insert that string below by referencing $imageLoaderCode
		//
		$imageLoaderCode = "";
		foreach ($friends_data->Friends as $friend) {
			   $imageLoaderCode.= "tabTwoImageGroup.registerSrcImage('$friend->name', '$friend->image');";
		}

echo <<<EOL
 </div>
		</div>
		<script type="text/javascript">
			var myTabs = new YAHOO.widget.TabView("MySpaceTabs");

			// Friends Tab Image Loader
			var tabTwoImageGroup = new YAHOO.util.ImageLoader.group('friendsTab', 'mouseover');

			$imageLoaderCode

			tabTwoImageGroup.addTrigger('friendsTab', 'focus');
			tabTwoImageGroup.name = 'tab_two_group';
		</script>
EOL;
	}
?>

</body>
</html>


<?php

}//end function run()

run();

?>
