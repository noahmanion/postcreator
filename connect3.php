<?php
// from: http://www.finalwebsites.com/facebook-api-php-tutorial/
// and: http://code.tutsplus.com/tutorials/wrangling-with-the-facebook-graph-api--net-23059
// http://www.benmarshall.me/facebook-sdk-php-v4/
session_start();


//define root directory
//define( 'ROOT', dirname(__FILE__) . '/');
//autoload required files
require_once('Facebook/FacebookSession.php');
require_once('Facebook/FacebookRedirectLoginHelper.php');

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
//initialize the sdk
$api_key = '767268540057032';
$api_secret = '1cbe63c2896966954ede8a6435aee015';
$redirect_uri = 'localhost:8000/success.php';
$permissions = array (
	'publish_stream',
	'read_stream',
	'manage_pages'
	)
FacebookSession::setDefaultApplication($api_key, $app_secret );
//create the logain helper and replace REDIRECT_URI Wtih your url
// Use the same domain you set for the app's 'App Domains'
//eg $helper = new FacebookRedirectLoginHelper( 'http://mydomain.com/redirect' )
$helper = new FacebookRedirectLoginHelper ( $redirect_uri );
//check if existing session exists
if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
	//create a new session from saved access_token
	$session = new FacebookSession( $_SESSION['fb_token'] );
		//validate the access)toke to make sure it's still valid
	try {
		if( ! $sessions->validate() ) {
			$session = null;
		}
	} catch (Exception $e ) {
		// Catch any exception
		$session = null;
	}
} else {
	// No session exists
	try{
		$session = $helper->getSessionFromRedirect();
	} catch( FacebookRequestException $ex ) {
		//when facebook returns an error
	} catch( Exception $ex ) {
		// When validation fails or other local issues
		echo $ex->message;
	}
}
//check if a session exsits
if ( isset( $session ) ) {
	//save the session
	$_SESSION['fb_token'] = $session->getToken();
	//create a session using saved token or the new one we generated at login
	$session = new FacebookSession( $session->getToken() );
	//create the logout URL (logout page should destroy the session)
	$logoutURL = $helper ->getLogoutUrl( $session, 'localhost:8000/logout' );
	echo '<a href="' . $logoutURL . '">Log out</a>';
} else {
	//No Session
	//get login URL
	$loginUrl = $helper->getLoginUrl( $permission );
	echo '<a href="' . $loginUrl . '">Log in</a>';
}
?>