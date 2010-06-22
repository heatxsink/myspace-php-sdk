<?php

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

class AllTests extends TestSuite {
    function AllTests() {
	  set_time_limit(500);

      $this->TestSuite('All PHP MySpace Test ' . SimpleTest::getVersion());
      $this->addFile(dirname(__FILE__) . '\CurrentUserIdTest.php');
	  $this->addFile(dirname(__FILE__) . '\AlbumTest.php');
      $this->addFile(dirname(__FILE__) . '\MediaItemTest.php');
	  $this->addFile(dirname(__FILE__) . '\MediaItemCommentsTest.php');
	  $this->addFile(dirname(__FILE__) . '\ActivitiesTest.php');
	  $this->addFile(dirname(__FILE__) . '\AppDataTest.php');
      $this->addFile(dirname(__FILE__) . '\GroupTest.php');
	  $this->addFile(dirname(__FILE__) . '\PeopleTest.php');
	  $this->addFile(dirname(__FILE__) . '\NotificationTest.php');
	  $this->addFile(dirname(__FILE__) . '\StatusMoodTest.php');
	  $this->addFile(dirname(__FILE__) . '\ProfileCommentsTest.php');
	  $this->addFile(dirname(__FILE__) . '\OpenSearchTest.php');
	  $this->addFile(dirname(__FILE__) . '\PortableContactsTest.php');
	  $this->addFile(dirname(__FILE__) . '\SubscriptionTest.php');
  }
}
?>

