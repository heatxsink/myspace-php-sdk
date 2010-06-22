<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class MediaItemCommentsTest extends UnitTestCase {
	
	public function test_pass() {

	    $ms_key = CONSUMER_KEY;			
	    $ms_secret = CONSUMER_SECRET;
	    $token = OAUTH_TOKEN;
	    $secret = OAUTH_SECRET;
	
	    $ms = new MySpace($ms_key, $ms_secret,$token,$secret);
		
	    $albums = $ms->getAlbums("@me");
	
		if(count($albums) >= 0)
		{
			$getMediaItem = $ms->getMediaItems("@me", $albums->entry[0]->album->id);
			if(count($getMediaItem) >= 0)
			{
				$comments = $ms->getMediaItemComments("@me", $albums->entry[0]->album->id, $getMediaItem->entry[0]->mediaItem->id);
				$this->assertTrue(count($comments) >= 0, "Get Media Item Comments Failed");
			}
		}
	}
}

?>
