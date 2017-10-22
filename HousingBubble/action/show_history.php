 <?php
	$link = mysql_connect('housingbubble.web.engr.illinois.edu', 'housingbubble_cs411', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('housingbubble_cs411');

	$username = "abc";

	$search_id_array = array();
	for($k = 0; $k < 20; $k+=1){
		$search_id_array[$k] = -1;
	}
	$legal_parameter = 1; 


    print(" 
        <!DOCTYPE html>
        <html>
        <head>
        <title>Product</title>
        <link href='../css/bootstrap.css' rel='stylesheet' type='text/css' media='all' />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <!-- Custom Theme files -->
        <!--theme-style-->
        <link href='../css/style.css' rel='stylesheet' type='text/css' media='all' />	
        <!--//theme-style-->
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <meta name='keywords' content='I-wear Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
        Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design' />

        <!--fonts-->
        <!--//fonts-->	

        <!-- start menu -->
        <link href='../css/memenu.css' rel='stylesheet' type='text/css' media='all' />

        <!-- /start menu -->
        		  		 <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
        	<!-- js -->

        	<!-- js -->

        </head>
        <body> 

            <div class='header-info'>
                <div class='container'>
                        <div class='header-top-in'>
                            
                            <ul class='support'>
                                <li><a href='mailto:info@example.com'><i class='glyphicon glyphicon-envelope'> </i>info@example.com</a></li>
                                <li><span><i class='glyphicon glyphicon-earphone' class='tele-in'> </i>1 217 480 7041</span></li>           
                            </ul>
                            <ul class=' support-right'>
                                <li><a href='../index.html'><i class='glyphicon glyphicon-user' class='men'> </i>Login</a></li>
                                <li><a href='../register.html'><i class='glyphicon glyphicon-lock' class='tele'> </i>Create an Account</a></li>            
                            </ul>
                            <div class='clearfix'> </div>
                        </div>
                    </div>
                </div>  


                <div class='header header5'>
                    <div class='header-top'>
                        <div class='header-bottom'>
                            <div class='container'>         
                                <div class='logo'>
                                    <h1><a href='../index.html'>Housing<span>Bubble</span></a></h1>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
        
                <div class='back'>
                    <h2>History</h2>
                </div>
    ");






	if ($legal_parameter > 0){
		$query_history = "select * from history where username = \"".$username."\" order by search_id desc limit 20 ";
		$res = mysql_query($query_history);
    //read 20 the most recent search_ids 
    //and use a for loop to print them
    //you can change 20 into 10 if you like
    
		for($i = 0; $i < mysql_num_rows($res); $i+=1){
			//for every row, print the following info 
			$data=mysql_fetch_assoc($res);
			
      		$search_id_array[$i] = $data["search_id"];

     print("<textarea disabled style=\"resize:none\" rows=\"12\" cols=\"50\">\n");
     print("Search id: {$data["search_id"]}\n");

			if ($data["dryer"] > -1){
				print("In-unit dryer(s):{$data["dryer"]}\n");
			}
			if ($data["parking"] > -1){
				print("Parking Availability:{$data["parking"]}\n");
			}
			if ($data["year"] > 0){
				print("Build year:{$data["year"]}\n");
			}
			if ($data["area_low"] > 0){
				print("Area Lower Bound: {$data["area_low"]}\n");
			}
			if ($data["area_high"] < 999999){
				print("Area Higher Bound: {$data["area_high"]}\n");
			}
			if ($data["floor"] > -1){
				print("Floor: {$data["floor"]}\n");
			}
			if ($data["price_low"] > 0){
				print("Price Lower Bound: {$data["price_low"]}\n");
			}
			if ($data["price_high"] < 99999999){
				print("Price Higher Bound: {$data["price_high"]}\n");
			}
			if ($data["bathrooms"] > -1){
				print("Num of Bathrooms: {$data["bathrooms"]}\n");
			}
			if ($data["bedrooms"] > -1){
				print("Num of Bedrooms: {$data["bedrooms"]}\n");
			}
      print("</textarea>");
      // one extra line
      //you should store that in html. 
      //you can show it for convenience if you want
		}

        print("
			<form action=\"./clear_history.php\" method=\"post\">
				<select name=\"deletion[]\" id=\"deletion\" multiple>
					<option value=\"{$search_id_array[0]}\">Delete No. 1</option>
					<option value=\"{$search_id_array[1]}\">Delete No. 2</option>
					<option value=\"{$search_id_array[2]}\">Delete No. 3</option>
					<option value=\"{$search_id_array[3]}\">Delete No. 4</option>
					<option value=\"{$search_id_array[4]}\">Delete No. 5</option>
					<option value=\"{$search_id_array[5]}\">Delete No. 6</option>
					<option value=\"{$search_id_array[6]}\">Delete No. 7</option>
					<option value=\"{$search_id_array[7]}\">Delete No. 8</option>
					<option value=\"{$search_id_array[8]}\">Delete No. 9</option>
					<option value=\"{$search_id_array[9]}\">Delete No. 10</option>
					<option value=\"{$search_id_array[10]}\">Delete No. 11</option>
					<option value=\"{$search_id_array[11]}\">Delete No. 12</option>
					<option value=\"{$search_id_array[12]}\">Delete No. 13</option>
					<option value=\"{$search_id_array[13]}\">Delete No. 14</option>
					<option value=\"{$search_id_array[14]}\">Delete No. 15</option>
					<option value=\"{$search_id_array[15]}\">Delete No. 16</option>
					<option value=\"{$search_id_array[16]}\">Delete No. 17</option>
					<option value=\"{$search_id_array[17]}\">Delete No. 18</option>
					<option value=\"{$search_id_array[18]}\">Delete No. 19</option>
					<option value=\"{$search_id_array[19]}\">Delete No. 20</option>
				</select>
				<input type=\"submit\">
			</form>

			<p>Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</p>");
	}

        print("</div></div></div></div>");


    print("
    
        <div class='bottom-grid1'>
            <div class='fit1'>
                <h3>HAPPY RENTING</h3>
                <p>Hunt for your dream home</p>
            </div>
        </div>


        <!---->
        <!---->

        <div class='footer'>
            <div class='container'>
                    <div class='clearfix'> </div>
                    <table>
                        <div align='center' class='mation'>
                            <span>Copyright &copy; 2017 HousingBubble</span>
                        </div>
                        <div align='center' class='mation'>
                            <span>Qingtao Hu, Yunzhe Pan, Yinchen Xu, Qixin Zhu</span>
                        </div>
                    </table>
            </div>
        </div>


        <a href='#to-top' id='toTop' style='display: block;'> <span id='toTopHover' style='opacity: 1;'> </span></a>
        <!----> 
        <!---->
        </body>
        </html>  
    ");
	mysql_close($link);
?>



<script type="text/javascript">
		$(document).ready(function() {
				/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
				*/
		$().UItoTop({ easingType: 'easeOutQuart' });
});
</script>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>


<script type="text/javascript" src="../js/move-top.js"></script>
<script type="text/javascript" src="../js/easing.js"></script>
<script src="../js/simpleCart.min.js"> </script>
<script type="text/javascript" src="../js/memenu.js"></script>
<script>$(document).ready(function(){$(".memenu").memenu();});</script>	
 <script src="../js/bootstrap.js"></script>
 <script src="../js/simpleCart.min.js"> </script>
