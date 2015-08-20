<?php
//include the Facebook PHP SDK
include_once 'facebook.php';
 
//start the session if necessary
if( session_id() ) {
 
} else {
    session_start();
}
 
//instantiate the Facebook library with the APP ID and APP SECRET
$facebook = new Facebook(array(
    'appId' => 'APP ID',
    'secret' => 'APP SECRET',
    'cookie' => true
));
//get the info from the form
$parameters = array(
    'message' => $_POST['message'],
    'picture' => $_POST['picture'],
    'link' => $_POST['link'],
    'name' => $_POST['name'],
    'caption' => $_POST['caption'],
    'description' => $_POST['description']
);
//add the access token to it
$parameters['access_token'] = $_SESSION['active']['access_token'];
//build and call our Graph API request
$newpost = $facebook->api(
    '/me/feed',
    'POST',
    $parameters
);
?>