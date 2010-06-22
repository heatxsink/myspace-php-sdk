<?php

	//please register at http://developer.myspace.com for a CONSUMERK_KEY
	define('CONSUMER_KEY', 'NOT SET');

	//please register at http://developer.myspace.com for a CONSUMER_SECRET
	define('CONSUMER_SECRET', 'NOT SET');

	/**
     * This is where the example will store its OpenID information.
     * You should change this path if you want the example store to be
     * created elsewhere.  After you're done playing with the example
     * script, you'll have to remove this directory manually.
     */
	define('TEMP_STORE_PATH', "tmp/_php_consumer_test");

	/**
	 * map the following CONST to a proper file for your opperatin system/ enviroment
	 *
	 * "source/Auth/OpenID/CryptUtil.php"
	 *
	 * define('Auth_OpenID_RAND_SOURCE', 'C:\_net_capture\001.pcap');
	 */
?>