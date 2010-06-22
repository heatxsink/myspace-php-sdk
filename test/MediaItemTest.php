<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');

require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class MediaItemTest extends UnitTestCase {
	
	public function test_pass() {

	  	$ms_key = CONSUMER_KEY;		
	  	$ms_secret = CONSUMER_SECRET;
	        $token = OAUTH_TOKEN;
	  	$secret = OAUTH_SECRET;
	
	    	$ms = new MySpace($ms_key, $ms_secret,$token,$secret);
		
		$mediaFields = $ms->getMediaItemSupportedFields();
		$this->assertTrue(count($mediaFields) != 0);

		$albums = $ms->getAlbums("@me");
		$this->assertTrue(count($albums) >= 0);
	
		if(count($albums) >= 0)
		{
			$getMediaItem = $ms->getMediaItems("@me", $albums->entry[0]->album->id);
			$this->assertTrue(count($getMediaItems) >= 0);

			if(count($getMediaItem) >= 0)
			{
				$itemById = $ms->getMediaItemById("@me", $albums->entry[0]->album->id, $getMediaItem->entry[0]->mediaItem->id);
				$this->assertEqual($getMediaItem->entry[0]->mediaItem->id, $itemById->mediaItem->id, "Get Media Item By Id Failed");
			}
		}

		$videoCategories = $ms->getVideosCategories("@me");
		$this->assertTrue(count($videoCategories) > 0, "Get Videos Categories Failed");
		
		if(count($videoCategories) >= 0)
		{	
			$videoCategoriesById = $ms->getVideosCategoriesById("@me", $videoCategories->array[0]->id);
			$this->assertTrue(count($videoCategoriesById) >= 0, "Get Video Catgegories By Id");
		}



	}
}

?>
