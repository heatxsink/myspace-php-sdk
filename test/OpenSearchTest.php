<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class OpenSearchTest extends UnitTestCase {
	
	public function test_pass() {

	   	$ms_key = CONSUMER_KEY;			//we get this from config.MySpace.php
	   	$ms_secret = CONSUMER_SECRET;
	    	$token = OAUTH_TOKEN;
	   	$secret = OAUTH_SECRET;
	
		$ms = new MySpace($ms_key, $ms_secret,$token,$secret);

		$peopleSearch = $ms->searchPeople("car");
		$this->assertTrue($peopleSearch != NULL, "People Search Failed");

		$imageSearch = $ms->searchImages("car");
		$this->assertTrue($imageSearch != NULL, "Image Search Failed");

		$videoSearch = $ms->searchVideos("car");
		$this->assertTrue($videoSearch != NULL, "Video Search Failed");

	}
}

?>





