<?php

$accessToken = "";

require 'vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '359142604291843',
  'app_secret' => '495e4d2ee50cdb62ef78b009c02abead',
  ]);


if(!isset($_COOKIE['fbAccessToken'])) {
    header('index.php');
} else {
    $accessToken =  $_COOKIE['fbAccessToken'];
}

try {
    // Returns a `Facebook\FacebookResponse` object
    $response = $fb->get('/me?fields=id,name,email', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    header('index.php');
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

// Returns a `Facebook\GraphNodes\GraphUser` collection
$user = $response->getGraphUser();
echo 'Name: ' . $user['name'];

?>