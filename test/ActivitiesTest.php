<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class ActivitiesTest extends UnitTestCase {
	
	public function test_pass() {

	    $ms_key = CONSUMER_KEY;
	    $ms_secret = CONSUMER_SECRET;
	    $token = OAUTH_TOKEN;
	    $secret = OAUTH_SECRET;
	   
	    $ms = new MySpace($ms_key, $ms_secret,$token,$secret);
	    $userid  = $ms->getCurrentUserId();

	    $fields = $ms->getActivitiesSupportedFields();
	    $this->assertTrue(count($fields) > 0);
		
	    $verbs = $ms->getActivitiesSupportedVerbs();
	    $this->assertTrue(count($verbs) > 0);

	    $types = $ms->getActivitiesSupportedTypes();
	    $this->assertTrue(count($types) > 0);

	    $activites = $ms->getActivities($userid);
	    $this->assertTrue(count($activities) >= 0);

	    $friendActivities = $ms->getFriendsActivities($userid);
	    $this->assertTrue(count($friendActivities) >= 0);
	}
}

?>

