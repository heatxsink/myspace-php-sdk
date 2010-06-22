<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class AppDataTest extends UnitTestCase {
	
	public function test_pass() {
	    $ms_key = CONSUMER_KEY;			
	    $ms_secret = CONSUMER_SECRET;
	    $token = OAUTH_TOKEN;
	    $secret = OAUTH_SECRET;
	    $appId = APP_ID;
	
	    $ms = new MySpace($ms_key, $ms_secret,$token,$secret);
	    $userid = $ms->getCurrentUserId();

	    $getApp = $ms->getAppData("@me", $appId);
	    $this->assertTrue(count($getApp) >= 0, "Get App Data Failed");

	    $addApp = $ms->addAppData("@me", $appId, 'test','values23');
	    $this->assertEqual($addApp->statusLink != NULL, "Add App Data Failed");

	    $delApp = $ms->clearAppData("@me", $appId, 'test');
	    $this->assertEqual($delApp == 1, "Delete App Data Failed");
	
	}
}

?>

