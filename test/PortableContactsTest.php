<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class PortableContactTest extends UnitTestCase {
	
	public function test_pass() {
	        $ms_key = CONSUMER_KEY;			
	        $ms_secret = CONSUMER_SECRET;
	        $token = OAUTH_TOKEN;
	        $secret = OAUTH_SECRET;
	
		$ms = new MySpace($ms_key, $ms_secret,$token,$secret);

		$person = $ms->getPersonPoco("@me");
		$this->assertTrue($person != NULL, "Person POCO Failed");

		$friendPoco = $ms->getFriendsPoco("@me");
		$this->assertTrue($friendPoco != NULL, "Friend POCO Failed");

	}
}

?>






