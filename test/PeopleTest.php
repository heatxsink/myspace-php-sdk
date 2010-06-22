<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class PeopleTest extends UnitTestCase {
	
	public function test_pass() {

	        $ms_key = CONSUMER_KEY;			
	        $ms_secret = CONSUMER_SECRET;
	        $token = OAUTH_TOKEN;
	        $secret = OAUTH_SECRET;
	
		$ms = new MySpace($ms_key, $ms_secret,$token,$secret);

		$fields = $ms->getPeopleSupportedFields();
		$this->assertTrue(count($fields) > 0);

		$people = $ms->getPerson("@me");
		$this->assertTrue($people->person-id != NULL);
		
		$friends = $ms->getFriends("@me");
		$this->assertTrue(count($friends) >= 0);
	
	}
}

?>

