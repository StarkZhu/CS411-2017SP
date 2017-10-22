<?php
/**
 * Created by PhpStorm.
 * User: pyz
 * Date: 3/20/17
 * Time: 8:06 AM
 *
 *
 * This is the page when the user click on the similar housings to one property with pid
 *
 * the layout is basically the same as search results by condition.
 *
 * Two parameters are passed in, one username, one pid.
 *
 * say pid is 42, we query the DB for all houses that are similar to 42 and then print all of them.
 *
 * For every house similar to 42, say [12, 23, 34], we print 23's address, parking, price and information.
 *
 * And then print all the houses that are similar to 23 as hyperlink.
 *
 * The hyperlink is shown on html as address of the house
 *
 * Don't forget that we also print a like button that allows user to like this property
 *
 * Then do that again on 23, 34
 *
 */

$link = mysqli_connect('housingbubble.web.engr.illinois.edu', 'housingbubble_cs411', 'cs411');
if (!$link) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($link, 'housingbubble_cs411');
$username = $_POST["username"];
$pid = $_POST['pid']; // 42



$query = "select * from similar where pid1 = {$pid} order by similarity desc limit 10";
$res = mysqli_query($link, $query);

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
                    <h2>Similar</h2>
                </div>
    ");

$num = mysqli_num_rows($res);
if (mysqli_num_rows($res) > 0){
    print("<script src='../jquery-3.2.0.min.js'></script>");

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
    //$res is all houses similar to 42, i.e.[12, 23, 34]
    while($data = mysqli_fetch_assoc($res)){ // for every one in [12, 23, 34]
        $similar_pid = $data['pid2'];
        $sub_query = "select * from property where pid = {$similar_pid}"; //look for 12's information
        $similar_res = mysqli_query($link, $sub_query);
        $similar_data = mysqli_fetch_assoc($similar_res);

            if($currnum%3 == 0)
                print("<div class='top-product'>");//row of items

            print("<div class='col-md-4 chain-grid  simpleCart_shelfItem'>");//whole item
            print("<div class='grid-span-1'>");//start of image
            if(strlen($similar_data['image']) < 5)
                print("<a><img src='./images.png' alt='A' class='img-responsive' height=196 width=196></a>");
            else
                print("<a><img src='{$similar_data['image']}' alt='No Image Source' class='img-responsive' height=196 width=196></a>");
            print("</div>");//end of image

            print("<div class='grid-chain-bottom '>");//start of title-price-info
            print("<a>House Address: {$similar_data['address']}</a>");
            print("<div class='star-price'>");//start of price-info
            print("<div class='price-at'>");//start of info
            print("<ul class='star-footer'>");//<ul> is set of noded lines
            print("<li><a><i>House Area: {$similar_data['area']} sq ft</i></a></li>");

            if ($similar_data['parking'] == 1){
                print("<li><a><i>Parking availability: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>Parking availability: No</i></a></li>");
            }

            if ($similar_data['washer_dryer'] == 1){
                print("<li><a><i>Washer and Dryer availability: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>Washer and Dryer availability: No</i></a></li>");
            }

            if ($similar_data['pet'] == 1){
                print("<li><a><i>Allow pet: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>Allow pet: No</i></a></li>");
            }

            if ($similar_data['ac'] == 1){
                print("<li><a><i>A/C availability: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>A/C availability: No</i></a></li>");
            }

            print("<li><a><i>Number of bedrooms: {$similar_data['bedrooms']}</i></a></li>");
            print("<li><a><i>Number of bathrooms: {$similar_data['bathrooms']}</i></a></li>");
            print("</ul></div>");//end of info

            print("<div class='price-at-bottom'>");//start of price
            print("<span class='item_price'>\$ {$similar_data['price']}/month</span>");
            print("</div>");//end of price
            print("<div class='clearfix'> </div>");//unknown function but exists
            print("</div>");//end of price-info





        /**
         * and all other information that I bother to enumerate
         */
        $like_query = "select * from liketable where username = '{$username}' and pid = {$similar_pid}";
        $like_res = mysqli_query($link, $like_query);

            print("<div class='cart-add'>");//start of operations

            if (mysqli_num_rows($like_res) > 0){
                print("\n<button id = {$similar_data['pid']}and{$username} onclick=send_like(id)>dislike</button>");
                //like button is clickable button that calls a function in javascript which calls php script
            } 
            else {
                print("\n<button id = {$similar_data['pid']}and{$username} onclick=send_like(id)>like</button>");
                //like button is clickable button that calls a function in javascript which calls php script
            }







        $sub_query_sim = "select * from similar where pid1 = {$similar_pid} order by similarity desc limit 5";
        $sim_sim_res = mysqli_query($link, $sub_query_sim);
        if (mysqli_num_rows($sim_sim_res) < 0) {
            print("there is no similar");

        } else {
            while($sim_sim_data = mysqli_fetch_assoc($sim_sim_res)){
                $sim_sim_pid = $sim_sim_data['pid2'];
                $ssq = "select address, pid from property where pid = {$sim_sim_pid}";
                $ssr = mysqli_query($link, $ssq);
                $ssd = mysqli_fetch_assoc($ssr);
                $ss_address = $ssd['address'];
                $ss_p = $ssd['pid'];


                print("<form action=\"./similar.php\" method=\"post\">
                      <input hidden type='text' value='{$username}' id='username' name='username'>      
                      <input hidden type='text' value='{$sim_sim_pid}' id='pid' name='pid'>         
                      <input type='submit' value='Show similar properties'>
                      </form> 
                    ");

                print("{$ss_address}, {$ss_p}");
                //print this as hyperlink to similar.php, parameter: user, pid
            }
        }
        print("<div class='clearfix'></div>");
        print("</div></div></div>");//end of operation, end of title-price-info, end of whole item
            if($currnum%3 == 2)
            {
                print("<div class='clearfix'> </div>");
                print("</div>");//end of row of items
            }
            $currnum = $currnum + 1;
    }
        if($currnum%3 != 0) {
            print("<div class='clearfix'> </div>");
            print("</div>");//end of row of items
        }
        print("</div></div></div></div>");
}
else{
    //print nothing is similar
    print("<p>There is no similar property for the property you choose</p>");
            print($pid);
            print("\n");
            print($query);
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







mysqli_close($link);

?>






<script>
    function send_like(id){
            var id_num=parseInt(id);
            var splits = id.split("and")
            var name = splits[1];
            $.ajaxSetup({async: false});
            $.post("liketoggle.php", {pid: id_num, username: name});
            document.getElementById(id).innerHTML = (document.getElementById(id).innerHTML === "dislike")? "Like it" : "dislike";
    }
</script>

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
