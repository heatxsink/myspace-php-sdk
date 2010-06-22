<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class ProfileCommentsTest extends UnitTestCase {
	
	public function test_pass() {
	    $ms_key = CONSUMER_KEY;			
	    $ms_secret = CONSUMER_SECRET;
	    $token = OAUTH_TOKEN;
	    $secret = OAUTH_SECRET;
	
	    $ms = new MySpace($ms_key, $ms_secret,$token,$secret);
	    $comments = $ms->getProfileComments("@me");
	    $this->assertTrue($comments != NULL, "Profile Comments Failed");
	}
}

?>




