<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once dirname(__FILE__). "/../config/config.MySpace.php";
require_once dirname(__FILE__) . "/../source/MySpaceID/myspace.php";

class AlbumTest extends UnitTestCase {
	
	public function test_pass() {
	    
	        $ms_key = CONSUMER_KEY;			

	  	$ms_secret = CONSUMER_SECRET;
	  	$token = OAUTH_TOKEN;
	    	$secret = OAUTH_SECRET;
	
		$ms = new MySpace($ms_key, $ms_secret,$token,$secret);
		
		$albumFields = $ms->getAlbumsSupportedFields();
		$this->assertTrue(count($albumFields) != 0);

		$albums = $ms->getAlbums("@me");
		$this->assertTrue(count($albums) >= 0);

		$addAlbum = $ms->addAlbum("@me", "myalbum");
		$this->assertTrue($addAlbum->statusLink != NULL);
		
		if(count($albums) >= 0)
		{
			$updateAlbum = $ms->updateAlbum("@me", $albums->entry[0]->album->id, "myalbum2");
			$this->assertTrue($updateAlbum->statusLink != NULL);

			$album = $ms->getAlbum("@me",$albums->entry[0]->album->id);
			$this->assertEqual($album->album->id, $albums->entry[0]->album->id);
		}



	}
}

?>