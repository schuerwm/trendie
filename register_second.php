<?php 

    require 'vendor/autoload.php';
 
    use Parse\ParseClient;
    use Parse\ParseUser;
    use Parse\ParseObject;
    use Parse\ParseException;
    use Parse\ParseSessionStorage;


    session_start();
    
    ParseClient::initialize('pyRq9kQT7w6aAC0G5xvzET7ftHMoLAgF32k3egiQ', '5K1KmKFbYbkg0FOJC4SQWbbtQWh3CzNG80NBjeVI', 'sEDHyxYcfUp4E8peGTb1doj49r3blIz7VWccNsT8');
    ParseClient::setStorage( new ParseSessionStorage() );


    if(isset($_POST['save']))
    {
        $currentUser = ParseUser::getCurrentUser();
		if ($currentUser) {
		    $currentUser->set("zip", (int)$_POST["frmZip"]);
   			$currentUser->setArray("interests", $_POST["frmInterests"]);

			 try {
			    $currentUser->save();
			     header("Location: /home.php");
			     die();
			 } catch (ParseException $ex) {
			          echo "Error: " . $ex->getCode() . " " . $ex->getMessage();

			 }

		} else {
		   header("Location: /register_first.php");
		   die();
		}
    } 
    else if(isset($_POST['skip'])){
 		 header("Location: /homepage.php?skip=true");
 		 die();

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
                        <h2>Complete Your Profile</h2>
                     </div>
                </div>
                <div class="row" style="text-align:center;padding-top:50px;">
                		<div style="width:45%;padding:40px;margin: 0 auto;background-color:#ececec">
                		                     
						 	<form class="form-horizontal" method="post" action="register_second.php" data-toggle="validator" role="form">
                              <div class="form-group">
                                <label class="sr-only" for="frmZip">Zip Code</label>
                                <input type="number" class="form-control" id="frmZip" name="frmZip" placeholder="Enter zip code">
                              </div>
                              <br>
                              <div>Select Interests</div>
                              <br>
							 <div class="form-group">
							 	<div style="float:left;padding-right:25px;"><input type=checkbox name="frmInterests[]" value=shoes><br>
							 	<img style="width:140px;border:1px solid #cccaca;margin-top:20px" src=/shared/img/shoes.jpg></div>
							 	
							 	<div style="float:left;padding-right:25px;"><input type=checkbox name="frmInterests[]" value=dress><br>
							 	<img style="width:140px;border:1px solid #cccaca;margin-top:20px"src=/shared/img/dress.jpg></div>
							 	
							 	<div style="float:left"><input type=checkbox name="frmInterests[]" value=handbag><br>
							 	<img style="width:140px;border:1px solid #cccaca;margin-top:20px"src=/shared/img/handbag.jpg></div>
							 </div>
							  <div class="form-group" align=right>
							    <div >
							      <button type="submit" class="btn btn-default" name="skip">Skip</button>
							      <button type="submit" class="btn btn-custom" name="save">Save</button>
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
