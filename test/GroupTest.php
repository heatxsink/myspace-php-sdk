<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class GroupTests extends UnitTestCase {
	
	public function test_pass() {
	    	
		$ms_key = CONSUMER_KEY;			
	   	$ms_secret = CONSUMER_SECRET;
	   	$token = OAUTH_TOKEN;
	    	$secret = OAUTH_SECRET;
	
		$ms = new MySpace($ms_key, $ms_secret,$token,$secret);
		
		$groups = $ms->getGroups("@me");
		$this->assertTrue(count($groups) >= 0);

		$fields = $ms->getGroupsSupportedFields();
		$this->assertTrue(count($fields) > 0);
	}
}

?>
