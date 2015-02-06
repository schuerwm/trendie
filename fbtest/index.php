 <?php


require 'vendor/autoload.php';
use Facebook\Helpers\FacebookJavaScriptHelper;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

$fb = new Facebook\Facebook([
  'app_id' => '359142604291843',
  'app_secret' => '495e4d2ee50cdb62ef78b009c02abead',
  ]);


$facebookApp = $fb->getApp();
$facebookClient = $fb->getClient();


$jsHelper = new FacebookJavaScriptHelper($facebookApp);
$signedRequest = $jsHelper->getSignedRequest();

if ($signedRequest) {
  $payload = $signedRequest->getPayload();
  var_dump($payload);
}

?>

<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <script>
   // This is called with the results from from FB.getLoginStatus().
	  function statusChangeCallback(response) {
	    console.log('statusChangeCallback');
	    console.log(response);
	    // The response object is returned with a status field that lets the
	    // app know the current login status of the person.
	    // Full docs on the response object can be found in the documentation
	    // for FB.getLoginStatus().
	    if (response.status === 'connected') {
	      // Logged into your app and Facebook.
	      //testAPI();
	      window.location.replace("fb-login-callback.php");	
	    } else if (response.status === 'not_authorized') {
	      // The person is logged into Facebook, but not your app.
	      document.getElementById('status').innerHTML = 'Please log ' +
	        'into this app.';
	    } else {
	      // The person is not logged into Facebook, so we're not sure if
	      // they are logged into this app or not.
	      document.getElementById('status').innerHTML = 'Please log ' +
	        'into Facebook.';
	    }
	  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
	  function checkLoginState() {
	    FB.getLoginStatus(function(response) {
	      statusChangeCallback(response);
	    });
	  }


	window.fbAsyncInit = function() {
		  FB.init({
		    appId      : '359142604291843',
		    cookie     : true,  // enable cookies to allow the server to access 
		                        // the session
		    xfbml      : true,  // parse social plugins on this page
		    version    : 'v2.1' // use version 2.1
		  });

	  // Now that we've initialized the JavaScript SDK, we call 
	  // FB.getLoginStatus().  This function gets the state of the
	  // person visiting this page and can return one of three states to
	  // the callback you provide.  They can be:
	  //
	  // 1. Logged into your app ('connected')
	  // 2. Logged into Facebook, but not your app ('not_authorized')
	  // 3. Not logged into Facebook and can't tell if they are logged into
	  //    your app or not.
	  //
	  // These three cases are handled in the callback function.

		  FB.getLoginStatus(function(response) {
		    statusChangeCallback(response);
		  });
	  };


      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));


	  function testAPI() {
	    console.log('Welcome!  Fetching your information.... ');
	    FB.api('/me', function(response) {
	      console.log('Successful login for: ' + response.name);
	      document.getElementById('status').innerHTML =
	        'Thanks for logging in, ' + response.name + '!';
	    });
	  }
 
    </script>
 <?php echo '<p>Hello World</p>'; ?> 
 <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>

<div id="status">
</div>

 </body>
</html>