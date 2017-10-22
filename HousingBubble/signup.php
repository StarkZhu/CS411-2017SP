
  
  
<?php
/**
 * Created by PhpStorm.
 * User: pyz
 * Date: 3/20/17
 * Time: 7:32 AM
 */

// all the sanity check should be done in html with js, not at the backend


function bchexdec($hex) {
    if(strlen($hex) == 1) {
        return hexdec($hex);
    } else {
        $remain = substr($hex, 0, -1);
        $last = substr($hex, -1);
        return bcadd(bcmul(16, bchexdec($remain)), hexdec($last));
    }
}

function bloom_filter_bool($username, $link)
{


  $error_query = "select value from bloom_filter where idx = -2";

  $error_res = mysqli_query($link, $error_query);

  $error_rate = mysqli_fetch_assoc($error_res);

  $error_rate = $error_rate["value"];

  $k = log($error_rate, 2);

  $length_query = "select * from bloom_filter where idx = -1";
  $length_res = mysqli_query($link, $length_query);

  $length = mysqli_fetch_assoc($length_res)["value"];
  for ($i = 0; $i < intval(ceil($k)); $i+=1) {

    $hex_str = dechex($i);
    $hash_hex = hash('sha256', "{$username}0x{$hex_str}");

		$hexdec = bchexdec($hash_hex);

  	$index_str = bcmod($hexdec, "{$length}");
  
    $index_query = "select * from bloom_filter where idx = {$index_str}";
  
    $index_res = mysqli_query($link, $index_query);

    $value = mysqli_fetch_assoc($index_res)["value"];
    if ($value == 0){
        $bool_value = false;
      return false;
        break;
    }
	}
  return true; 
}


function update_bloom_filter($username, $link){


  $error_query = "select value from bloom_filter where idx = -2";

  $error_res = mysqli_query($link, $error_query);

  $error_rate = mysqli_fetch_assoc($error_res);

  $error_rate = $error_rate["value"];

  $k = log($error_rate, 2);

  $length_query = "select * from bloom_filter where idx = -1";
  $length_res = mysqli_query($link, $length_query);

  $length = mysqli_fetch_assoc($length_res)["value"];


  for ($i = 0; $i < intval(ceil($k)); $i+=1) {
        $hex_str = dechex($i);
        $hash_hex = hash('sha256', "{$username}0x{$hex_str}");

        $hexdec = bchexdec($hash_hex);
        $index_str = bcmod($hexdec, "{$length}");

        $index_query = "select * from bloom_filter where idx = {$index_str}";
        $index_res = mysqli_query($link, $index_query);
        // TODO: query table to get index
        $value = mysqli_fetch_assoc($index_res)["value"];
        $value += 1;
        $update_query = "update bloom_filter set value = {$value} where idx = {$index_str}";
        mysqli_query($link, $update_query);
    }
}




  
$link = mysqli_connect('housingbubble.web.engr.illinois.edu', 'housingbubble_cs411', 'cs411');
if (!$link) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($link, 'housingbubble_cs411');
$username = $_POST["username"];


print("
<!DOCTYPE html>
<html>
<head>
<title>Search</title>
<link href='css/bootstrap.css' rel='stylesheet' type='text/css' media='all' />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- Custom Theme files -->
<!--theme-style-->
<link href='css/style.css' rel='stylesheet' type='text/css' media='all' />	
<!--//theme-style-->
<meta name='viewport' content='width=device-width, initial-scale=1'>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name='keywords' content='I-wear Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design' />
<!--fonts-->
<!--//fonts-->
<!-- start menu -->
<script src=./js/jquery.min.js></script>
<!--//slider-script-->


		  		 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<!-- js -->
		 <script src='js/bootstrap.js'></script>
	<!-- js -->

<!-- start menu -->
<link href='css/memenu.css' rel='stylesheet' type='text/css' media='all' />
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
							<li><a href='mailto:info@example.com'><i class='glyphicon glyphicon-envelope'> </i>yxu72@illinois.edu</a></li>
							<li><span><i class='glyphicon glyphicon-earphone' class='tele-in'> </i>1 217 778 6031</span></li>			
						</ul>
						<ul class=' support-right'>
							<li><a href='index.html'><i class='glyphicon glyphicon-user' class='men'> </i>Log out</a></li>
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
					<h1><a href='index.html'>Housing<span>Bubble</span></a></h1>
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
	<h2>Register</h2>
</div>



");


if (bloom_filter_bool($username, $link)){
    //////
  	print("
    
        <div class=container>
		<h3>This username has already been used.</h3>
		<form action='register.html' method='POST' enctype='multipart/form-data'>
    	<input type='submit' value='Try again'><br>
    </form>
    </div>
    
    ");
    //////
}

else
{
$password = $_POST["password"];
$hashed = md5($password);

$age = $_POST['age'];
$major = $_POST['major'];
$standing = $_POST['standing'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$gender = $_POST['gender'];

$column_list = "(username, password, age, major, standing, gender, phone, email)";
$value_list = " ( '{$username}', '{$hashed}', {$age}, '{$major}', '{$standing}', '{$gender}', '{$phone}', '{$email}' )";

$query = "insert into profile ".$column_list." values ".$value_list;


$res = mysqli_query($link, $query);
update_bloom_filter($username, $link);

//////
  	print("
    
<div class=container>
		<p>Sign up success! Welcome {$username}.</p>
		<form action='index.html' method='POST' enctype='multipart/form-data'>
    	<input type='submit' value='Log in'><br>
    </form>
    </div>
    
    ");
//////
//this should go to index.html
// notice that you should incorporate the information of username in the html so that the login session goes on.



mysqli_close($link);
}
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
				 <!---->
<a href='#to-top' id='toTop' style='display: block;'> <span id='toTopHover' style='opacity: 1;'> </span></a>
<!----> 
<!---->

</body>
</html>


");
?>

