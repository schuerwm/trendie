<?php 

require 'vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '359142604291843',
  'app_secret' => '495e4d2ee50cdb62ef78b009c02abead',
  ]);


$jsHelper = $fb->getJavaScriptHelper();
$facebookClient = $fb->getClient();

try {
    $accessToken = $jsHelper->getAccessToken($facebookClient);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
}

if (isset($accessToken)) {
  setcookie('fbAccessToken', $accessToken, time() + (86400 * 30), "/");
  header('Location: homepage.php');

}

?>


