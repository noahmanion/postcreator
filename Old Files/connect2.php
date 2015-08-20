<? php
// from: http://www.finalwebsites.com/facebook-api-php-tutorial/
// and: http://code.tutsplus.com/tutorials/wrangling-with-the-facebook-graph-api--net-23059
session_start();

require_once 'facebook-php-sdk-v4-4.0-dev/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;

$api_key = '';
$api_secret = '';
$redirect_login_url = '/manage.php';
$permissions = array (
	'publish_stream',
	'read_stream',
	'offline_access',
	'manage_pages'
	)

// initialize your app using your key and secret
FacebookSession::setDefaultApplicaion($api_key, $api_secret);

//create a helper object which is needed to create a login URL
//the $redirect_login_url is the page the visitor will come to after login
$helper  = new FacebookRedirectLoginHelper($redirect_login_url);

//first check if there is an exisitng sessions
if ( isset($_SESSION) && isset($_SESSION['fb_token'])) {
	//create a new session from from the exisitng php session
	$session = new FacebookSession ($_SESSION['fb_token']);
	try {
		//validate the access_token to make sure it's still valid
		if(!$session->validate()) $session = null;
	} catch (Exception $e) {
		//catch any exceptions and set the session null
		$session = null;
		echo 'No session:'.$e->getMessage();
	}

} elseif(empty($session)) {
	// the session is empty, we create a new one
	try {
		//the visitor is redirected from the login, let's pickup the session
		$session = $helper->getSessionFromRedirect();
	} catch (FacebookRequestException $e) {
		//facebook returned an error
		echo 'Facebook (session) requrest error'.$e->getMessage();
	} catch (Exception $e ) {
		//any other error
		echo 'other (session) request error'.$e->getMessage();
	}
}
if (isset( $session ) ) {
	//store the session token into a php session
	$_SESSION['fb_token'] = $session->getToken();
	//and create a new facebook session using the current token
	//or from the new token we get after login
	$session = new FacebookSession ($session->getToken() );
	try {
		//with this session i will login
		$request new FacebookRequest(
		'/me/permissions',
    	'GET',
    	array(
        	'access_token' => $access_token
    		)
    	)
    	$response = $request->execute();
    	$graphObject = $response->getGraphObject();
    	
    } catch ( FacebookRequestException $e ) {
			// show any error for this facebook request
			echo 'Facebook (get) request error: '.$e->getMessage();
		}
	}
} else {
	// we need to create a new session, provide a login link
	echo 'No session, please <a href="'. $helper->getLoginUrl( array( 'publish_actions' ) ).'">login</a>.';
}

?>