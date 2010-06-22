<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class NotificationTest extends UnitTestCase {
	
	public function test_pass() {

	        $ms_key = CONSUMER_KEY;			
	        $ms_secret = CONSUMER_SECRET;
	        $token = OAUTH_TOKEN;
	        $secret = OAUTH_SECRET;
	
		$ms = new MySpace($ms_key, $ms_secret,$token,$secret);
		$userId = $ms->getCurrentUserId();
		$notification = $ms->sendNotification($userId, $userId, array('content' => 'this is  content'),'http://opensocial.myspace.com/roa/09/mediaitemcomments/');
		$this->assertTrue($notification->statusLink != NULL, "Send Notification Failed");
	}
}

?>


