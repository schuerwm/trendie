<?php 

    require 'vendor/autoload.php';
 
    use Parse\ParseClient;
    use Parse\ParseUser;
    use Parse\ParseQuery;
    use Parse\ParseObject;
    use Parse\ParseException;
    use Parse\ParseSessionStorage;


    session_start();

    ParseClient::initialize('pyRq9kQT7w6aAC0G5xvzET7ftHMoLAgF32k3egiQ', '5K1KmKFbYbkg0FOJC4SQWbbtQWh3CzNG80NBjeVI', 'sEDHyxYcfUp4E8peGTb1doj49r3blIz7VWccNsT8');
    ParseClient::setStorage( new ParseSessionStorage() );



   

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
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Custom styles for this template -->
    <link href="/shared/css/trendie.css" rel="stylesheet">
  </head>
  
  <body>



    <!-- Navigation -->

    <!-- Intro Header -->
    	



<div id="success">
        You successfully added an item.  Thanks!
    </div>
    <div id="error">
        Ooops.   An error occurred.  Please try again. 
    </div>
    <div id="openModal" class="modalDialog">
        <div>
           <div style="
            background-color: #e4e5e6;
            border-bottom: 1px solid #d7d7d8;
            padding: 10px;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            padding-bottom: 0px;"><a href="#close" title="Close" class="close">X</a><h2>Set a Trend</h2></div>
            <div>
            <form class="form-horizontal enterURL" method="post" action="scrape.php" data-toggle="validator" role="form" >
                              <div class="form-group">
                                <label class="sr-only" for="frmURL">URL</label>
                                <input  class="form-control" id="frmURL" name="frmURL" placeholder="Enter URL">
                              </div>
                                  <div class="form-group" align=right>
                                  <button type="submit" class="btn btn-custom" name="scrape"><i id="next_load" class="fa fa-circle-o-notch fa-spin"></i><span id="next">Next</span></button>
                                </div>
                            </form>
                        </div>
        </div>
    </div>
                <div id="wrapper">
                    <div id="columns">
                    <?php
                        $query = new ParseQuery("Item");
                        $query->equalTo("category", "dresses");
                        $results = $query->find();

                        for ($i = 0; $i < count($results); $i++) { 
                            $object = $results[$i];
                            echo '<div class="pin">';
                            echo '<div class="rank">' . ($i + 1) . '</div>';
                            echo '<div class="item"><img src=' . $object->get('imageURL') . '>';
                            echo '<div class="description"><p>' . $object->get('title') . '</p></div>';
                            echo '<div class="person"><div class=thumb><img src="https://s-media-cache-ak0.pinimg.com/avatars/ajofish_1330109231_30.jpg" style="" alt="Food &amp; Drink ideas"></div>';
                            echo '<div style="float: left;text-align: left;"><p style="color: #5e5e5e;font-weight: 500;line-height: 1.4;padding-top: 3px;">Sally Struthers<br><span style="color: #bbbbbb;">Trend Setter</span></p></div>';
                            echo '<div class="vote"><i class="fa fa-arrow-up fa-2x"></i> </div></div></div>';
                            echo '</div>';
                        }
                    ?>
                    </div>
                </div>
                <div onclick="location.href='#openModal';" class="add fa fa-plus fa-3x" id="add_item"></div>

    <!-- Footer -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script>


        $("#add_item").click(function(){
            $("#next").show();
            $("#next_load").hide();
        });

        $("#next").click(function(){
            $("#next").hide();
            $("#next_load").show();
        });


        function getUrlVars()
        {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        }
        $( document ).ready(function() {
           
           if (getUrlVars()["status"].indexOf("error") >= 0) {
               $("#error").slideDown('slow').delay(5000).slideUp('slow');
                
           }

           if (getUrlVars()["status"].indexOf("success") >= 0) {
               $("#success").slideDown('slow').delay(5000).slideUp('slow');
                
           }
        });

    </script>
  </body>
</html>
