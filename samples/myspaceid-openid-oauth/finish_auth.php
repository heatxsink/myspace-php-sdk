<?php

require_once "common.php";
require_once "MySpaceID/myspace.php";

session_start();

function escape($thing) {
    return htmlentities($thing);
}

function run() {
    $consumer = getConsumer();

    // Complete the authentication process using the server's
    // response.
    $return_to = getReturnTo();
    $response = $consumer->complete($return_to);

    // Check the response status.
    if ($response->status == Auth_OpenID_CANCEL) {
        // This means the authentication was cancelled.
        $msg = 'Verification cancelled.';
    } else if ($response->status == Auth_OpenID_FAILURE) {
        // Authentication failed; display the error message.d
        $msg = "OpenID authentication failed: " . $response->message;
    } else if ($response->status == Auth_OpenID_SUCCESS) {
        // This means the authentication succeeded; extract the
        // identity URL and Simple Registration data (if it was
        // returned).
        $openid = $response->getDisplayIdentifier();
        $esc_identity = escape($openid);

        $success = sprintf('You have successfully verified ' .
                           '<a href="%s">%s</a> as your identity.<br><br>Here\'s your MySpace profile data fetched using the MySpace REST APIs',
                           $esc_identity, $esc_identity);

        if ($response->endpoint->canonicalID) {
            $escaped_canonicalID = escape($response->endpoint->canonicalID);
            $success .= '  (XRI CanonicalID: '.$escaped_canonicalID.') ';
        }

        $oauth_resp = Auth_OpenID_OAuthResponse::fromSuccessResponse($response);
		$authorized_request_token = $oauth_resp->authorized_request_token;
		
		//1.0A OAuth Spec, we will need this to get an access token
        $authorized_verifier = $oauth_resp->authorized_verifier;
        
		if ($authorized_request_token){
			$ms = new MySpace(CONSUMER_KEY, CONSUMER_SECRET, $authorized_request_token->key, $authorized_request_token->secret, $authorized_verifier);
		  	$access_token = $ms->getAccessToken();

		  	$ms = new MySpace(CONSUMER_KEY, CONSUMER_SECRET, $access_token->key, $access_token->secret);


			$userid = $ms->getCurrentUserId();

			// Use the userID (fetched in the previous step) to get user's profile, friends and other info
			$profile_data = $ms->getProfile($userid);
			$friends_data = $ms->getFriends($userid);
			
			$ms->updateStatus($userid,'testing sdk');

			// Access $profile_data and $friend_data inside of index.php (via the include below)
			// to display the profile/friends data
		}
    }

    include 'index.php';
}

run();

?>