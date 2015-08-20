<?php
// from: https://www.apptic.me/blog/simple-facebook-php-sdk-4-tutorial.php
session_start();
 
require_once('Facebook/FacebookSession.php');
require_once('Facebook/FacebookRedirectLoginHelper.php');
require_once('Facebook/FacebookRequest.php');
require_once('Facebook/FacebookResponse.php');
require_once('Facebook/FacebookSDKException.php');
require_once('Facebook/FacebookRequestException.php');
require_once('Facebook/FacebookAuthorizationException.php');
require_once('Facebook/GraphObject.php');
require_once('Facebook/HttpClients/FacebookCurl.php');
require_once('Facebook/HttpClients/FacebookHttpable.php');
require_once('Facebook/HttpClients/FacebookCurlHttpClient.php');
require_once('Facebook/Entities/AccessToken.php');
require_once('Facebook/GraphUser.php');
require_once('Facebook/GraphSessionInfo.php');

 
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\Entities\AccessToken;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;
 
$app_id = '767268540057032';
$app_secret = '1cbe63c2896966954ede8a6435aee015';
 
FacebookSession::setDefaultApplication($app_id, $app_secret);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Facebook SDK example</title>
</head>
<body>
<?
 
$helper = new FacebookRedirectLoginHelper("https://www.apptic.me/blog/facebook-sdk-test.php", $app_id, $app_secret);
if (isset($_SESSION['fb_token'])) {
  // use a saved access token - will get to this later
  $session = new FacebookSession($_SESSION['fb_token']);
    try {
      if (!$session->validate()) {
        $session = null;
      }
    } 
    catch (Exception $e) { $session = null; }
} else {
    try {
        $session = $helper->getSessionFromRedirect();
    }
    catch(FacebookRequestException $ex) { } 
    catch(\Exception $ex) { }
}
 
$loggedIn = false;
 
if (isset($session)){
    if ($session) {
        $loggedIn = true;
        try {
          // Logged in
          $_SESSION['fb_token'] = $session->getToken();
          
          $user_photos = (new FacebookRequest(
            $session, 'GET', '/me/photos/uploaded'
          ))->execute()->getGraphObject(GraphUser::className());
          $user_photos = $user_photos->asArray();
          $pic = $user_photos["data"][0]->{"source"};
          //print_r($user_photos);
          echo "<img src='$pic' />";
        } catch(FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
        }   
    }
}
if (!$loggedIn){
  $loginUrl = $helper->getLoginUrl(array('user_photos'));
  echo "<a href='$loginUrl'>Login";
}
?>
</body>
</html>
