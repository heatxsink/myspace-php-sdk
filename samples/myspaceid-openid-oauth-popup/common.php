<?php

define('LIB_PATH', 		"../../source/");
define('CONFIG_PATH', 	"config/");
define('LOCAL', true);


$path_extra = dirname(dirname(dirname(__FILE__)));
$path = ini_get('include_path');
$path = CONFIG_PATH . PATH_SEPARATOR
		.	LIB_PATH . PATH_SEPARATOR
		.	$path_extra . PATH_SEPARATOR
		.	$path;
ini_set('include_path', $path);

function displayError($message) {
    $error = $message;
    include 'index.php';
    exit(0);
}



function doIncludes() {
    /**
     * Require the OpenID consumer code.
     */
    require_once "Auth/OpenID/Consumer.php";

    /**
     * Require the "file store" module, which we'll need to store
     * OpenID information.
     */
    require_once "Auth/OpenID/FileStore.php";

    /**
     * Require the Simple Registration extension API.
     */
    require_once "Auth/OpenID/SReg.php";

    /**
     * Require the PAPE extension module.
     */
    require_once "Auth/OpenID/PAPE.php";

    /**
     * Require the OAuth extension module.
     */
    require_once "Auth/OpenID/OAuth.php";

    //loads the configuration file with you're consumer key and secret
	// uses the ternary operation for readability
	// http://en.wikipedia.org/wiki/Ternary_operation
	// BOOL ? (eval if BOOL == true) : (eval if BOOL == false);
	require_once LOCAL ? "config.MySpace.local.php" : "config.MySpace.php";
}

doIncludes();

/**
 * &getStore() '&' returns by reference
 *
 * @return a new reference to Auth_OpenID_FileStore($store_path)
 */
function &getStore() {
    /**
     * This is where the example will store its OpenID information.
     * You should change this path if you want the example store to be
     * created elsewhere.  After you're done playing with the example
     * script, you'll have to remove this directory manually.
     */
    $store_path = TEMP_STORE_PATH;

    if (!file_exists($store_path) &&
        !mkdir($store_path)) {
        print "Could not create the FileStore directory '$store_path'. ".
            " Please check the effective permissions.";
        exit(0);
    }

    return new Auth_OpenID_FileStore($store_path);
}

/**
 * &getConsumer() '&' returns by reference
 *
 * @return reference to the $consumer object
 */
function &getConsumer() {
    /**
     * Create a consumer object using the store object created
     * earlier.
     */
    $store = getStore();
    $consumer =& new Auth_OpenID_Consumer($store);
    return $consumer;
}

/**
 * Enter description here...
 *
 * @return HTTP or HTTPS
 */
function getScheme() {
    $scheme = 'http';
    if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
        $scheme .= 's';
    }
    return $scheme;
}

/**
 * Enter description here...
 *
 * @return URL to complete authentication
 */
function getReturnTo() {
    return sprintf("%s://%s:%s%s/finish_auth.php",
                   getScheme(), $_SERVER['SERVER_NAME'],
                   $_SERVER['SERVER_PORT'],
                   dirname($_SERVER['PHP_SELF']));
}

/**
 * Enter description here...
 *
 * @return URL that serves as the entry point for authenthication
 */

function getTrustRoot() {
	//with full path including domain name, port and dir
    return sprintf("%s://%s:%s%s/",
                   getScheme(), $_SERVER['SERVER_NAME'],
                   $_SERVER['SERVER_PORT'],
                   dirname($_SERVER['PHP_SELF']));
}
/*
function getTrustRoot() {
	//with just the domain name and port
    return sprintf("%s://%s:%s/",
                   getScheme(), $_SERVER['SERVER_NAME'],
                   $_SERVER['SERVER_PORT']
                   );
}
*/
?>