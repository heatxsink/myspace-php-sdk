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
		$authorized_verifier = $oauth_resp->authorized_verifier;
		
        if ($authorized_request_token){
			$ms = new MySpace(CONSUMER_KEY, CONSUMER_SECRET, $authorized_request_token->key, $authorized_request_token->secret, $authorized_verifier);
		  	$access_token = $ms->getAccessToken();


		  	$ms = new MySpace(CONSUMER_KEY, CONSUMER_SECRET, $access_token->key, $access_token->secret);


			$userid = $ms->getCurrentUserId();


			$_SESSION['userID'] = $userid;
			$_SESSION['access_token_key'] = $access_token->key;
			$_SESSION['access_token_secret'] = $access_token->secret;

			// Use the userID (fetched in the previous step) to get user's profile, friends and other info
			$profile_data = $ms->getProfile($userid);
			$friends_data = $ms->getFriends($userid);

			// Access $profile_data and $friend_data inside of index.php (via the include below)
			// to display the profile/friends data
		}
    }

?>
    <html>
  <head><title>MySpaceID Hybrid Example</title></head>

  <link rel="stylesheet" type="text/css" href="static/base.css">

  <!-- YUI Combo CSS + JS files: -->
  <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?2.6.0/build/tabview/assets/skins/sam/tabview.css">
  <script type="text/javascript" src="http://yui.yahooapis.com/combo?2.6.0/build/yahoo-dom-event/yahoo-dom-event.js&2.6.0/build/imageloader/imageloader-min.js&2.6.0/build/element/element-beta-min.js&2.6.0/build/tabview/tabview-min.js"></script>

  <body class="yui-skin-sam">

<script>
function closeWin() {
//  alert("closeWin() called");
//  alert(opener);

//window.opener.location.href = "profile.php";
//  window.opener.location.reload(true);
var rand = Math.random();

alert(rand);

  window.opener.sayhi(rand);
  self.close();
}
</script>





    <h1>Finishing Log In</h1>



    <br>

    <?php if (isset($msg)) { print "<div class=\"alert\">$msg</div>"; } ?>
    <?php if (isset($error)) { print "<div class=\"error\">$error</div>"; } ?>
    <?php if (isset($success)) { print "<div class=\"success\">$success</div>"; } ?>



<script>closeWin();</script>
  </body>
</html>
<?php

}

run();

?>