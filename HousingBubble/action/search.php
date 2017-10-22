<?php
/**
 * Created by PhpStorm.
 * User: pyz
 * Date: 3/20/17
 * Time: 8:37 AM
 */

$link = mysqli_connect('housingbubble.web.engr.illinois.edu', 'housingbubble_cs411', 'cs411');
if (!$link) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($link, 'housingbubble_cs411');

// hard code username for initial demo
$username = $_POST["username"];

$area_low = $_POST["Area_Low"];
$area_high = $_POST["Area_High"];
$parking = $_POST["Parking"];
$washer_dryer = $_POST["WasherDryer"];
$price_low = $_POST["Price_Low"];
$price_high = $_POST["Price_High"];
$bathrooms = $_POST["Bathroom"];
$bedrooms = $_POST["Bedroom"];
$allow_pet = $_POST["AllowPet"];
$air_conditioner = $_POST["AirC"];

$legal_parameter = 1;

$condition = "pid >= 0";


$column_list  = "(username, area_low, area_high, parking, floor, dryer, price_low, price_high, bathrooms, bedrooms, pet, ac) ";

$value_list = "('".$username."',";

if ($area_low != ""){
    $condition .=  " and area >= ".$area_low;
    $value_list .=  $area_low .", ";
    if (!is_numeric($area_low)){
        print( "Area should be numbers" );
        $legal_parameter = 0;
    }
} else {
    $value_list .= "0, ";
}

if ($area_high != ""){
    $condition .=  " and area <= ".$area_high;
    $value_list .= $area_high.", ";
    if (!is_numeric($area_high)){
        print( "Area should be numbers" );
        $legal_parameter = 0;
    }
} else {
    $value_list .= "999999". ", ";
}

if ($parking != "None"){
    $condition .=  " and  parking = ".$parking;
    $value_list .= "1, ";
} else {
    $value_list .= "-1, ";
}


if ($washer_dryer != "None" && $washer_dryer != NULL){
    $condition .=  " and washer_dryer = {$wash_dryer}";
    $value_list .= "1, ";
} else {
    $value_list .= "-1, ";
}


if ($price_low != ""){
    $condition .=  " and price >= ".$price_low;
    $value_list .= $price_low. ", ";
    if (!is_numeric($price_low)){
        print( "Price should be numbers" );
        $legal_parameter = 0;
    }
} else {
    $value_list .=  "0, ";
}

if ($price_high != ""){
    $condition .=  " and price <= ".$price_high;
    $value_list .= $price_high. ", ";
    if (!is_numeric($price_high)){
        print( "Price should be numbers" );
        $legal_parameter = 0;
    }
} else {
    $value_list .=  "99999999, ";
}

if ($bathrooms != "None"){
    $condition .=  " and bathrooms >= ".$bathrooms;
    $value_list .= $bathrooms.", ";
    if (!is_numeric($bathrooms)){
        print( "Number of bathrooms should be numbers" );
        $legal_parameter = 0;
    }
} else {
    $value_list .= "-1, ";
}

if ($bedrooms != "None"){
    $condition .=  " and bedrooms >= ".$bedrooms;
    $value_list .= $bedrooms.", ";
    if (!is_numeric($bedrooms)){
        print( "Number of bedrooms should be numbers" );
        $legal_parameter = 0;
    }
} else {
    $value_list .= "-1, ";
}

if ($allow_pet != "None" && $allow_pet != NULL){
    $condition .= " and pet = {$allow_pet}";
    $value_list .= "{$allow_pet}, ";
} else {
    $value_list .= "-1, ";
}

if ($air_conditioner != "None" && $air_conditioner != NULL){
    $condition .= " and ac = ".$air_conditioner;
    $value_list .= $air_conditioner." )";
} else {
    $value_list .= "-1 )";
}

if ($legal_parameter == 1){

    $condition = "select * from property where ".$condition. " order by pid limit 31";
    
    $insert_history = "insert into history {$column_list} values {$value_list}" ;

    $res = mysqli_query($link, $insert_history);

    $res = mysqli_query($link, $condition);
    
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
                                <li><a href='mailto:info@example.com'><i class='glyphicon glyphicon-envelope'> </i>yxu72@illinois.edu</a></li>
                                <li><span><i class='glyphicon glyphicon-earphone' class='tele-in'> </i>1 217 778 6031</span></li>           
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
                            </div>  
                        </div>
                    </div>
                </div>
        
                <div class='back'>
                    <h2>Properties</h2>
                </div>
    ");
    
    
    
    
    print(" 
      <script src='../jquery-3.2.0.min.js'></script>
      <script>
        function sendLike(name, id)
        {
            $.ajaxSetup({async: false});
            $.post('liketoggle.php', {pid: id, username: name});
            if(document.getElementById(id).innerHTML == 'like')
            {
                document.getElementById(id).innerHTML = 'dislike';
            }
            else
            {
                document.getElementById(id).innerHTML = 'like';
            }
        }
      </script>");






    $num = mysqli_num_rows($res);
    if (mysqli_num_rows($res)>0)
    {
        print("
            <div class='product'>
                <div class='container'>
                    <div class='col-md-9 product-price1'>


                        <div class='mens-toolbar'>
                            <p class='showing'>There are {$num} result(s) available</p>
                            <div class='clearfix'></div>        
                        </div>


                        <div class='product-right-top'>

            ");
        $currnum = 0;
        while($data=mysqli_fetch_assoc($res)) {
            if($currnum%4 == 0)
                print("<div class='top-product'>");//row of items

            print("<div class='col-md-4 chain-grid  simpleCart_shelfItem'>");//whole item
            print("<div class='grid-span-1'>");//start of image
            if(strlen($data['image']) < 5)
                print("<a><img src='./images.png' alt='A' class='img-responsive' height=196 width=196></a>");
            else
                print("<a><img src='{$data['image']}' alt='No Image Source' class='img-responsive' height=196 width=196></a>");
            print("</div>");//end of image

            print("<div class='grid-chain-bottom '>");//start of title-price-info
            print("<a>House Address: {$data['address']}</a>");
            print("<div class='star-price'>");//start of price-info
            print("<div class='price-at'>");//start of info
            print("<ul class='star-footer'>");//<ul> is set of noded lines
            print("<li><a><i>House Area: {$data['area']} sq ft</i></a></li>");

            if ($data['parking'] == 1){
                print("<li><a><i>Parking availability: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>Parking availability: No</i></a></li>");
            }

            if ($data['washer_dryer'] == 1){
                print("<li><a><i>Washer and Dryer availability: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>Washer and Dryer availability: No</i></a></li>");
            }

            if ($data['pet'] == 1){
                print("<li><a><i>Allow pet: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>Allow pet: No</i></a></li>");
            }

            if ($data['ac'] == 1){
                print("<li><a><i>A/C availability: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>A/C availability: No</i></a></li>");
            }

            print("<li><a><i>Number of bedrooms: {$data['bedrooms']}</i></a></li>");
            print("<li><a><i>Number of bathrooms: {$data['bathrooms']}</i></a></li>");
            print("</ul></div>");//end of info

            print("<div class='price-at-bottom'>");//start of price
            print("<span class='item_price'>\$ {$data['price']}/month</span>");
            print("</div>");//end of price
            print("<div class='clearfix'> </div>");//unknown function but exists
            print("</div>");//end of price-info


            $like_query = "select * from liketable where username = '{$username}' and pid = {$data["pid"]}";
            $like_res = mysqli_query($link, $like_query);
            print("<div class='cart-add'>");//start of operations

            if (mysqli_num_rows($like_res) > 0){
                print("\n<button id = {$data['pid']}and{$username} onclick=send_like(id)>dislike</button>");
                //like button is clickable button that calls a function in javascript which calls php script
            } 
            else {
                print("\n<button id = {$data['pid']}and{$username} onclick=send_like(id)>like</button>");
                //like button is clickable button that calls a function in javascript which calls php script
            }
            //for like button, it is a hyperlink that passes in user and pid, i.e. 12
            print("<form action = './similar.php' method='POST'>
                    <input hidden type='text' value='{$username}' id='username' name='username'>
                    <input hidden type='text' value='{$data['pid']}' id='pid' name='pid'>
                    <input type='submit' value='Show similar properties'>
                    </form>");
            print("<div class='clearfix'></div>");
            print("</div></div></div>");//end of operation, end of title-price-info, end of whole item
            if($currnum%3 == 2)
            {
                print("<div class='clearfix'> </div>");
                print("</div>");//end of row of items
            }
            $currnum = $currnum + 1;

            /*       
            print("<textarea disabled style='resize:none' rows='12' cols='40'>\n");
            print("House Address: {$data['address']}\n");
            print("House Area: {$data['area']} sq ft\n");
            print("Rent: \${$data['price']} per mouth\n");
            if ($data['parking'] == 1){
                print("Parking availability: yes\n");
            } else {
                print("Parking availability: no\n");
            }
            if ($data['washer_dryer'] == 1){
                print("Washer and Dryer availability: yes\n");
            } else {
                print("Washer and Dryer availability: no\n");
            }

            if ($data['pet'] == 1){
                print("Allow pet: yes\n");
            } else {
                print("Allow pet: no\n");
            }

            if ($data['ac'] == 1){
                print("A/C availability: yes\n");
            } else {
                print("A/C availability: no\n");
            }

            print("Number of bedrooms: {$data['bedrooms']}\n");
            print("Number of bathrooms: {$data['bathrooms']}");
            print("\n");
            print("</textarea>");
            */           
            //$sub_query_sim = "select * from similar where pid1 = {$similar_pid} order by similarity desc limit 5";
        }
        if($currnum%4 != 0) {
            print("<div class='clearfix'> </div>");
            print("</div>");//end of row of items
        }
        print("</div></div></div></div>");
    } 

    else {
        print("no such result");
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


        <a href='#to-top' id='toTop' style='display: block;'> <span id='toTopHover' style='opacity: 1;'> </span></a>
        <!----> 
        <!---->
        </body>
        </html>  
    ");
  

}



mysqli_close($link);


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
<script>
    function send_like(id){
            var id_num=parseInt(id);
            var splits = id.split("and")
            var name = splits[1];
            $.ajaxSetup({async: false});
            $.post("liketoggle.php", {pid: id_num, username: name});
            document.getElementById(id).innerHTML = (document.getElementById(id).innerHTML == "dislike") ? "like" : "dislike";
    }
</script>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>


<script type="text/javascript" src="../js/move-top.js"></script>
<script type="text/javascript" src="../js/easing.js"></script>
<script src="../js/simpleCart.min.js"> </script>
<script type="text/javascript" src="../js/memenu.js"></script>
<script>$(document).ready(function(){$(".memenu").memenu();});</script> 
 <script src="../js/bootstrap.js"></script>
 <script src="../js/simpleCart.min.js"> </script>
 