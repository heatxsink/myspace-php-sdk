<?php
require_once "common.php";
?>

<html>
  <head><title>MySpaceID Hybrid Example</title></head>
  
  <link rel="stylesheet" type="text/css" href="static/base.css">
  
  <!-- YUI Combo CSS + JS files: -->
  <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?2.6.0/build/tabview/assets/skins/sam/tabview.css">
  <script type="text/javascript" src="http://yui.yahooapis.com/combo?2.6.0/build/yahoo-dom-event/yahoo-dom-event.js&2.6.0/build/imageloader/imageloader-min.js&2.6.0/build/element/element-beta-min.js&2.6.0/build/tabview/tabview-min.js"></script>

  <body class="yui-skin-sam">
    <h1>MySpaceID Example - Uses OpenID/OAuth "Hybrid Protocol" To Fetch MySpace Data</h1>
    <p>
      Enter Your MySpaceID below:
    </p>

    <div id="verify-form">
      <form method="get" action="try_auth.php">
        Identity&nbsp;URL:
        <input type="hidden" name="action" value="verify" />
        <input type="text" size="64" name="openid_identifier" value="http://www.myspace.com/<VANITY_NAME>" />
		<p></p>
        <input type="submit" value="Get MySpace Data" />
      </form>
    </div>

    <br>
    
    <?php if (isset($msg)) { print "<div class=\"alert\">$msg</div>"; } ?>
    <?php if (isset($error)) { print "<div class=\"error\">$error</div>"; } ?>
    <?php if (isset($success)) { print "<div class=\"success\">$success</div>"; } ?>

<?php 
	if (isset($profile_data)) {
echo <<<EOL
		<div id="MySpaceTabs" class="yui-navset">
		    <ul class="yui-nav">
		        <li id='profileTab' class="selected"><a href="#tab1"><em>Profile</em></a></li>
		        <li id='friendsTab'><a href="#tab2"><em>Friends</em></a></li>
		        <li id='albumsTab'><a href="#tab3"><em>Albums</em></a></li>
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
	$friendsContent = "";
	foreach ($friends_data->Friends as $friend) {
		$friendsContent.= "<a href='{$friend->webUri}'>";
		$friendsContent.= "<img id='$friend->name' title='$friend->name' border='0'></a>";
	}
echo <<<EOL
				<div id='friendsTabContent'>
				    $friendsContent
		        </div>
		    </div>
		</div>
EOL;
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
