 <?php
	

	$link = mysql_connect('housingbubble.web.engr.illinois.edu', 'housingbubble_cs411', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('housingbubble_cs411');
	//this is where you pass in username
	//or hard code it to be abc
	$username = $_POST["username"];
	$legal_parameter = 1; 

	/*if ($strcmp(username, "")){
		$set .= "major = \"".$standing."\" "; 
	} else {
		$legal_parameter = 0;
	}*/


	if ($legal_parameter > 0){
		$view_profile_query = "select * from profile where username = \"".$username."\" ";
		$res = mysql_query($view_profile_query);
		$data=mysql_fetch_assoc($res);
		$major = $data['major'];
		$standing = $data['standing'];
		$age = $data['age'];
    //print major age standing...

    print("





<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
<link href='../css/bootstrap.css' rel='stylesheet' type='text/css' media='all' />
<!-- /start menu -->

<style>

/* -------------------- Select Box Styles: bavotasan.com Method (with special adaptations by ericrasch.com) */
/* -------------------- Source: http://bavotasan.com/2011/style-select-box-using-only-css/ */
.styled-select {
   background: url(http://i62.tinypic.com/15xvbd5.png) no-repeat 96% 0;
   height: 29px;
   overflow: hidden;
   width: 240px;
}

.styled-select select {
   background: transparent;
   border: none;
   font-size: 14px;
   height: 29px;
   padding: 5px; /* If you add too much padding here, the options won't show in IE */
   width: 268px;
}

.styled-select.slate {
   background: url(http://i62.tinypic.com/2e3ybe1.jpg) no-repeat right center;
   height: 34px;
   width: 240px;
}

.styled-select.slate select {
   border: 1px solid #ccc;
   font-size: 16px;
   height: 34px;
   width: 268px;
}

/* -------------------- Rounded Corners */
.rounded {
   -webkit-border-radius: 20px;
   -moz-border-radius: 20px;
   border-radius: 20px;
}

.semi-square {
   -webkit-border-radius: 5px;
   -moz-border-radius: 5px;
   border-radius: 5px;
}

/* -------------------- Colors: Background */
.slate   { background-color: #ddd; }
.green   { background-color: #779126; }
.blue    { background-color: #3b8ec2; }
.yellow  { background-color: #eec111; }
.black   { background-color: #000; }

/* -------------------- Colors: Text */
.slate select   { color: #000; }
.green select   { color: #fff; }
.blue select    { color: #fff; }
.yellow select  { color: #000; }
.black select   { color: #fff; }


/* -------------------- Select Box Styles: danielneumann.com Method */
/* -------------------- Source: http://danielneumann.com/blog/how-to-style-dropdown-with-css-only/ */
#mainselection select {
   border: 0;
   color: #EEE;
   background: transparent;
   font-size: 20px;
   font-weight: bold;
   padding: 2px 10px;
   width: 378px;
   *width: 350px;
   *background: #58B14C;
   -webkit-appearance: none;
}

#mainselection {
   overflow:hidden;
   width:350px;
   -moz-border-radius: 9px 9px 9px 9px;
   -webkit-border-radius: 9px 9px 9px 9px;
   border-radius: 9px 9px 9px 9px;
   box-shadow: 1px 1px 11px #330033;
   background: #58B14C url('http://i62.tinypic.com/15xvbd5.png') no-repeat scroll 319px center;
}


/* -------------------- Select Box Styles: stackoverflow.com Method */
/* -------------------- Source: http://stackoverflow.com/a/5809186 */
select#soflow, select#soflow-color {
   -webkit-appearance: button;
   -webkit-border-radius: 2px;
   -webkit-box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
   -webkit-padding-end: 20px;
   -webkit-padding-start: 2px;
   -webkit-user-select: none;
   background-image: url(http://i62.tinypic.com/15xvbd5.png), -webkit-linear-gradient(#FAFAFA, #F4F4F4 40%, #E5E5E5);
   background-position: 97% center;
   background-repeat: no-repeat;
   border: 1px solid #AAA;
   color: #555;
   font-size: inherit;
   margin: 20px;
   overflow: hidden;
   padding: 5px 10px;
   text-overflow: ellipsis;
   white-space: nowrap;
   width: 300px;
}

select#soflow-color {
   color: #fff;
   background-image: url(http://i62.tinypic.com/15xvbd5.png), -webkit-linear-gradient(#779126, #779126 40%, #779126);
   background-color: #779126;
   -webkit-border-radius: 20px;
   -moz-border-radius: 20px;
   border-radius: 20px;
   padding-left: 15px;
}
</style>
</head>
<body> 
<!--header-->
        <div class='header-info'>
            <div class='container'>
                    <div class='header-top-in'>
                        
                        <ul class='support'>
                            <li><a href='mailto:info@example.com'><i class='glyphicon glyphicon-envelope'> </i>qzhu3@illinois.edu</a></li>
                            <li><span><i class='glyphicon glyphicon-earphone' class='tele-in'> </i>1 217 480 7041</span></li>           
                        </ul>
                        <ul class=' support-right'>
                            <li><a href='../index.html'><i class='glyphicon glyphicon-user' class='men'> </i>Log out</a></li>
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
         <!---->

                    <!---->
                    
                    <!---->
                </div>
            <div class='clearfix'> </div>
        </div>
        </div>  
                <div class='clearfix'> </div>   
            </div>
<!---->
<div class='back'>
    <h2>Profile</h2>
</div>
        <!---->
        <div class='container'>
        <div class='register'>
            <h3>
                User's username: {$username}<br><br>
                User's standing: {$data['standing']}<br><br>
                User's major: {$data['major']}<br><br>
                User's age: {$data['age']}<br><br>
            </h3>





                <form action='/action/update_profile.php' method='POST'>

                    <div>
                        <span for='standing'>Standing:</span>
                        <div class='styled-select slate'>
                            <select id='standing' label='standing' name='standing'>
                                <option value='unspecified'>Unspecified</option>
                                <option value='freshman'>Freshman</option>
                                <option value='sophomore'>Sophomore</option>
                                <option value='junior'>Junior</option>
                                <option value='senior'>Senior</option>
                                <option value='master'>MS</option>
                                <option value='phd'>PhD</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <span for='major'>major:</span>
                        <div class='styled-select slate'>
                            <select id='major' label='major' name='major' type='text'>
                                <option value='agriculture'>Agriculture</option>
                                <option value='architecture'>Architecture</option>
                                <option value='art'>Art</option>
                                <option value='biology'>Biology/BioE</option>
                                <option value='business'>Business</option>
                                <option value='chemistry'>Chemistry/ChemE</option>
                                <option value='cs'>Computer Science</option>
                                <option value='economics'>Economics</option>
                                <option value='ece'>Electrical and Computer Engineering</option>
                                <option value='english'>English/Literature</option>
                                <option value='geology'>Geology</option>
                                <option value='history'>History</option>
                                <option value='ie'>Industrial Engineering</option>
                                <option value='mse'>Material Science Engineering</option>
                                <option value='math'>Mathematics</option>
                                <option value='me'>Mechanical Engineering</option>
                                <option value='music'>Music</option>
                                <option value='npre'>NPRE</option>
                                <option value='physics'>Physics</option>
                                <option value='psychology'>Psychology</option>
                                <option value='stat'>Statistics</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <span class='mation' for='age'>age:</span>
                            <input type='text' name='age'>
                    </div>

                    <div>
                        <input hidden type = 'text' id='username' name='username' value='{$username}'>
                    </div>

                    <input type='submit' action='/action/update_profile.php' value = 'Save'>
                </form>
                
                




           </div>
            </div>
            <!---->
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
                 <!---->

<a href='#to-top' id='toTop' style='display: block;'> <span id='toTopHover' style='opacity: 1;'> </span></a>
<!----> 
<!---->
</body>
</html>






");
	}

	mysql_close($link);
?>




<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src='../js/jquery.min.js'></script>
<!-- Custom Theme files -->
<!--theme-style-->
<link href='../css/style.css' rel='stylesheet' type='text/css' media='all' />  
<!--//theme-style-->
<meta name='viewport' content='width=device-width, initial-scale=1'>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name='keywords' content='I-wear Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design' />
<script type='application/x-javascript'> addEventListener('load', function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script type='text/javascript' src='../js/move-top.js'></script>
<script type='text/javascript' src='../js/easing.js'></script>
<!--fonts-->
<!--//fonts-->
<!-- start menu -->

<!--//slider-script-->

<script src='../js/easyResponsiveTabs.js' type='text/javascript'></script>
            <script type='text/javascript'>
                $(document).ready(function () {
                    $('#horizontalTab').easyResponsiveTabs({
                        type: 'default', //Types: default, vertical, accordion           
                        width: 'auto', //auto or any width like 600px
                        fit: true   // 100% fit in a container
                    });
                });
                
</script>   
                 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- js -->
         <script src='../js/bootstrap.js'></script>
    <!-- js -->

<script src='../js/simpleCart.min.js'> </script>
<!-- start menu -->
<link href='../css/memenu.css' rel='stylesheet' type='text/css' media='all' />
<script type='text/javascript' src='../js/memenu.js'></script>
<script>$(document).ready(function(){$('.memenu').memenu();});</script> 









<script type='text/javascript'>
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