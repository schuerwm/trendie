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

   

    $_SESSION["favcolor"] = "green";

    $frmEmailErrorTaken = False;
    $frmPasswordError = False;

    if(isset($_POST['register']))
    {
        

        $user = new ParseUser();
        $user->set("username", $_POST["frmEmail"]);
        $user->set("password", $_POST["frmPassword"]);
        $user->set("email", $_POST["frmEmail"]);    
        
         
        try {
            $user->signUp();
            header("Location: /register_second.php");
            die();
        } catch (ParseException $ex) {
          echo "Error: " . $ex->getCode() . " " . $ex->getMessage();

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
