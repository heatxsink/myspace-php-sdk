<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class SubscriptionTest extends UnitTestCase {
	
	public function test_pass() {
  	        $ms_key = CONSUMER_KEY;			

	        $ms_secret = CONSUMER_SECRET;
	        $token = OAUTH_TOKEN;
	        $secret = OAUTH_SECRET;
	
		$ms = new MySpace($ms_key, $ms_secret,$token,$secret);

		$subscription = $ms->addSubscription('All','http://myspace.si-sv2826.com/myposthandler.ashx','{}','',100,100);
		$this->assertTrue($subscription->statusLink != NULL, "Subscription Failed");

		$getsubscription = $ms->getAllSubscription();
		$this->assertTrue($getsubscription != NULL, "Get All Subscription Failed");

		$deleteSubscription = $ms->deleteAllSubscription();
		$this->assertTrue($getsubscription == 1, "Delete All Subscription Failed");


	}
}

?>







