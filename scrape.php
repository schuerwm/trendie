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

	function dbg_curl_data($curl, $data=null) {
	  static $buffer = '';

	  if ( is_null($curl) ) {
	    $r = $buffer;
	    $buffer = '';
	    return $r;
	  }
	  else {
	    $buffer .= $data;
	    return strlen($data);
	  }
	}


	function curl($url) {
        
        $ch = curl_init();  // Initialising cURL
        curl_setopt($ch, CURLOPT_URL, $url);    // Setting cURL's URL option with the $url variable passed into the function
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');


        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        
      
        if ($data === "" ||  is_null($data)) {
        	header("Location: /home.php?status=error");
        }

        curl_close($ch);   
        return $data;   // Returning the data from the function
    }


	if(isset($_POST['save'])) {

		$item = new ParseObject("Item");
	 
		$item->set("title", $_POST["frmTitle"] );
		$item->set("imageURL", $_POST["frmImage"]);
		$item->set("description", $_POST["frmDescription"]);
		$item->set("url", $_POST["frmURL"]);
		$item->set("category", $_POST["frmCategory"]);
		 
		try {
		  $item->save();
		

		  header("Location: /home.php?status=success");
		  //echo 'New object created with objectId: ' . $item->getObjectId();
		} catch (ParseException $ex) {  
		  // Execute any logic that should take place if the save fails.
		  // error is a ParseException object with an error code and message.
		  echo 'Failed to create new object, with error message: ' + $ex->getMessage();
		}
	}

    if(isset($_POST['scrape'])) {
 

    $itemImage = "";
    $itemTitle = "";
    $itemDescription =""; 


 	//$html = curl("http://shop.nordstrom.com/s/eliza-j-crepe-popover-dress-regular-petite/3890299?origin=category-personalizedsort&contextualcategoryid=0&fashionColor=ORANGE&resultback=455"); 
	//$url = "https://www.lulus.com/products/amuse-society-next-level-coral-red-tie-dye-maxi-dress/192850.html";

	$url = $_POST["frmURL"]; 
	$html = curl($url); 

	//parsing begins here:
	$doc = new DOMDocument();
	@$doc->loadHTML($html);

    $i = 0;
	$imgArray = array();

	foreach($doc->getElementsByTagName('meta') as $meta) {
   		

	    if($meta->getAttribute('property')=='og:image'){ 
	        //Assign the value from content attribute to $meta_og_img
	        $itemImage = $meta->getAttribute('content');
	        $imgArray[$i] = $itemImage;
	 		$i = $i + 1; 
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



	foreach($doc->getElementsByTagName('img') as $img) {
		
		$imgURL = $img->getAttribute('src');

		if (0 !== strpos($url, 'http://') && 0 !== strpos($url, 'https://')) {
		   $url = "http://" . $url;
		}

		if (substr($imgURL, 0, 4) != 'http' ) {
			$imgURL = "http://" . parse_url($url, PHP_URL_HOST) . "" . $imgURL ;
			
		}

		//list($width, $height) = getimagesize($imgURL); 
	

		//if ($width > 200 && $height > 200) {
			$imgArray[$i] = $imgURL;
	 		$i = $i + 1; 
		//}
	
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
    <link href="/shared/css/image-picker.css" rel="stylesheet">
    <script src="/shared/js/imagesloaded.pkgd.min.js"></script>
    <script src="/shared/js/masonry.pkgd.min.js"></script>
    <script src="/shared/js/packery.pkgd.min.js"></script>
    <script src="/shared/js/image-picker.min.js"></script>

   
  </head>

  <body>
  <div id="container" > 

              <form id=saveItem class="form-horizontal " method="post" action="scrape.php" data-toggle="validator" role="form" style="text-align:left" >
                              
                              <p>Select Category:</p>
                              <div class="btn-group" role="group" aria-label="...">
								  <button type="button" class="btn btn-default" onclick='setValue("dresses", "category");'>Dress</button>
								  <button type="button" class="btn btn-default" onclick='setValue("shoes", "category");'>Shoes</button>
								  <button type="button" class="btn btn-default" onclick='setValue("purse", "category");'>Purse</button>
								  <button type="button" class="btn btn-default" onclick='setValue("top", "category");'>Top</button>
							</div>
							<br><br>
							<p>Select Photo:</p>

							   <div class="picker">
								<select class="image-picker masonry" data-limit="2" >
								<?php 
									$i = 0;
									foreach ($imgArray as $value) {
								    	$i = $i + 1; 
								    	echo '<option data-img-src="' . $value . '" value="' .  $value . '"></option>';
								    	
									}

								?>
								</select>
							  </div>                          
							    <div class="form-group" align=right>
                                  <button type="submit" class="btn btn-custom" name="save" id="save">Trend It</button>
                                  <input type="hidden" id="category" name="frmCategory">
                                  <input type="hidden" id="image" name="frmImage"  >
                                  <input type="hidden" id="url" name="frmURL" value="<?php echo $url ?>" >
                                  <input type="hidden" id="description" name="frmDescription" value="<?php echo $itemDescription ?>">
                                  <input type="hidden" id="title" name="frmTitle" value="<?php echo $itemTitle ?>" >
                                </div>
                            </form>
                       


     </div>

    <!-- Footer -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
 	<script type="text/javascript">


	$(window).load(function() {

    	jQuery("select.image-picker").imagepicker({});

    	var i = 0;
    	var imgList = ['temp'];

  		$('.image_picker_image').each(function(i) { 
            	

			$(this).load(function(){
			  	
				var found = $.inArray($(this)[0].currentSrc, imgList);
			  	
				//if (isValidImage($(this)[0].currentSrc) == false) {
				//	$(this).parent().parent().remove();
				//}
				//else {
				  	if (found == -1) {
						imgList.push($(this)[0].currentSrc);
					}
					else {
						$(this).parent().parent().remove();
					}
				  
				  	
					if (($(this)[0].naturalWidth < 150) || ($(this)[0].naturalHeight < 150)) {
	                		$(this).parent().parent().remove();
	                }
                //}
            });

			i = i+1;

			/*if (i == $('.image_picker_image').size()) {

				var container = jQuery("select.image-picker.masonry").next("ul.thumbnails");
    
    			container.imagesLoaded(function(){
		      		container.masonry({
		        		itemSelector:   "li",
		      		});
    			});
			}*/

            
        }); 
    	
   });

    function setValue(value, field) {
    	$("#" + field).val(value);
    }

    $("#saveItem").submit(function(e) {
		
    	var img = $(".thumbnail.selected").find('.image_picker_image').attr("src");
    	$("#image").val(img);

    });

	$(".btn-group > .btn").click(function(){
	    $(this).addClass("active").siblings().removeClass("active");
	});

	
/*


  var container = jQuery("select.image-picker.masonry").next("ul.thumbnails");
    container.imagesLoaded(function(){
      container.masonry({
        itemSelector:   "li",
        gutter: 10
      });
    });*/


</script>

  </body>
</html>