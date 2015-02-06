<?php

	require 'vendor/autoload.php';
 
    if(isset($_POST['scrape'])) {


    use Parse\ParseClient;
    use Parse\ParseUser;
    use Parse\ParseObject;
    use Parse\ParseException;
    use Parse\ParseSessionStorage;

    $itemImage = "";
    $itemTitle = "";
    $itemDescription =""; 

    session_start();

    ParseClient::initialize('pyRq9kQT7w6aAC0G5xvzET7ftHMoLAgF32k3egiQ', '5K1KmKFbYbkg0FOJC4SQWbbtQWh3CzNG80NBjeVI', 'sEDHyxYcfUp4E8peGTb1doj49r3blIz7VWccNsT8');
    ParseClient::setStorage( new ParseSessionStorage() );
  	
  	function curl($url) {
        $ch = curl_init();  // Initialising cURL
        curl_setopt($ch, CURLOPT_URL, $url);    // Setting cURL's URL option with the $url variable passed into the function
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        curl_close($ch);    // Closing cURL
        return $data;   // Returning the data from the function
    }

 	$html = curl("http://shop.nordstrom.com/s/eliza-j-crepe-popover-dress-regular-petite/3890299?origin=category-personalizedsort&contextualcategoryid=0&fashionColor=ORANGE&resultback=455"); 

	//parsing begins here:
	$doc = new DOMDocument();
	@$doc->loadHTML($html);

	foreach($doc->getElementsByTagName('meta') as $meta) {
   
	    if($meta->getAttribute('property')=='og:image'){ 
	        //Assign the value from content attribute to $meta_og_img
	        $itemImage = $meta->getAttribute('content');
	    }

	   if($meta->getAttribute('property')=='og:description'){ 
	        //Assign the value from content attribute to $meta_og_img
	        $itemDescription = $meta->getAttribute('content');
	    }

	    if($meta->getAttribute('property')=='og:title'){ 
	        //Assign the value from content attribute to $meta_og_img
	        $itemTitle = $meta->getAttribute('content');
	    }   
	}

	$item = new ParseObject("Item");
 
	$item->set("title", $itemTitle );
	$item->set("imageURL", $itemImage);
	$item->set("description", $itemDescription);
	$item->set("url", $url);
	$item->set("category", 'dresses');
	 
	try {
	  $item->save();
	  echo 'New object created with objectId: ' . $item->getObjectId();
	} catch (ParseException $ex) {  
	  // Execute any logic that should take place if the save fails.
	  // error is a ParseException object with an error code and message.
	  echo 'Failed to create new object, with error message: ' + $ex->getMessage();
	}

	    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Trendie - Set the Trends.  Discover the World.</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	<link href='http://fonts.googleapis.com/css?family=Antic+Didone' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Arapey' rel='stylesheet' type='text/css'>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Custom styles for this template -->
    <link href="/shared/css/trendie.css" rel="stylesheet">
  </head>

  <body>

    <!-- Navigation -->

    <!-- Intro Header -->
    	
  
        <div class="register-body">
        	 <div class="row" style="text-align:right;">
        	 		<a href="/login" style="color:#000">Sign in</a>
        	 </div>
            <div class="container">
                <div class="row" style="padding-top:80px;">
                    <div class="col-md-12">
                        <h2>Register For Access</h2>
                     </div>
                </div>
                <div class="row" style="text-align:center;padding-top:50px;">
                		<div style="width:30%;padding:50px;margin: 0 auto;background-color:#ececec">
                		                     
							 <form class="form-horizontal" method="post" action="register_first.php" data-toggle="validator" role="form">
                              <div class="form-group has-error">
                                <label class="sr-only control-label" for="frmEmail" style="text-align:left;width:100%;display:block">Email address</label>
                                <input type="email" class="form-control" id="frmEmail" name="frmEmail" placeholder="Enter email address">
                              </div>
							    <div class="form-group">
                                <label class="sr-only control-label" for="frmPassword">Password</label>
                                <input type="password" data-minlength="6" class="form-control" id="frmPassword" name="frmPassword" placeholder="Enter password">
                                <span class="help-block">Minimum of 6 characters</span>
                              </div>
							  <div class="form-group" align=right>
							    <div >
							      <button type="submit" class="btn btn-custom" name="register">Register</button>
							    </div>
							  </div>
							</form>
					    </div>
                </div>              
            </div>
        </div>

    <!-- Footer -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

  </body>
</html>