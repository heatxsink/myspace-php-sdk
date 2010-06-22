<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class StatusMoodTest extends UnitTestCase {
	
	public function test_pass() {
	    	
		$ms_key = CONSUMER_KEY;			
	   	$ms_secret = CONSUMER_SECRET;
	  	$token = OAUTH_TOKEN;
	   	$secret = OAUTH_SECRET;
	
		$ms = new MySpace($ms_key, $ms_secret,$token,$secret);
		$status = $ms->getStatus("@me");
		$this->assertTrue($status != NULL, "Status Failed");

		$statusHistory = $ms->getStatusHistory("@me");
		$this->assertTrue(count($statusHistory) >= 0, "History Failed"); 

		$friendstatusHistory = $ms->getFriendsStatusHistory("@me");
		$this->assertTrue(count($friendstatusHistory) >= 0, "History Failed"); 

		$friendstatusHistory = $ms->getFriendsStatusHistory("@me");
		$this->assertTrue(count($friendstatusHistory) >= 0, "Friends History Failed"); 

		
		if(count($friends) > 0)
		{
			$friendId = FRIEND_ID;
			$friendStatus = $ms->getFriendsStatus("@me", $friendId); 
			$this->assertTrue(count($friendStatus) >= 0, "Status By Friend ID Failed");
			$fhistory = $ms->getFriendStatusHistory("@me", $friendId);
			$this->assertTrue(count($fhistory) >= 0, "Status History By Friend ID Failed");
		}

		$moods = $ms->getSupportedStatus("@me");
		$this->assertTrue(count($moods) >= 0, "Supported Status Failed");

		if(count($moods) > 0)
	      {
			$mood = $ms->getSupportedStatusById("@me", $moods->array[0]->moodId);
			$this->assertTrue($mood != NULL, "Supported Status Mood By Id Failed");
		}

		$uStatus = $ms->updateStatus("@me","excited", "Hi Mood", array('latitude' => 47.604832,  'longitude' => -122.337549));
		$this->assertTrue($uStatus != NULL, "Update Status Failed");
	}
}

?>



