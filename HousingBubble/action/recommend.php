<?php
/**
 * Created by PhpStorm.
 * User: pyz
 * Date: 3/22/17
 * Time: 12:03 AM
 */
$link = mysqli_connect('housingbubble.web.engr.illinois.edu', 'housingbubble_cs411', 'cs411');
if (!$link) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($link, 'housingbubble_cs411');
$username = $_POST["username"];

$like_query = "
select distinct pid from
(
SELECT fuck.pid2 as pid, similar.similarity
FROM (
SELECT ltt.pid AS pid1, liked_properties.pid AS pid2
FROM (
SELECT DISTINCT pid
FROM (
SELECT * 
FROM (
SELECT DISTINCT u1 AS uu
FROM (
SELECT DISTINCT username AS u1
FROM (
SELECT username AS t1un, pid AS t1p
FROM liketable
WHERE username =  '{$username}'
)t1
INNER JOIN liketable t2 ON t1.t1p = t2.pid
) AS also_like_users
) AS also_like_users
INNER JOIN liketable ON also_like_users.uu = liketable.username
) AS also_liked_properties
WHERE username <>  '{$username}'
)liked_properties
CROSS JOIN (

SELECT * 
FROM liketable
WHERE username =  '{$username}'
)ltt ON ltt.pid <> liked_properties.pid
) AS fuck
INNER JOIN similar ON similar.pid1 = fuck.pid1
AND similar.pid2 = fuck.pid2
ORDER BY similarity DESC 
LIMIT 50
) final limit 50
";

/*
 *
select fuck.pid2, similar.similarity from
(select ltt.pid as pid1, liked_properties.pid as pid2 from
(select distinct pid from
(select * from
(select distinct u1 as uu
from
(
    select distinct username as u1
    from
    (
        select username as t1un, pid as t1p from liketable where username = {$username}
    ) t1
    inner join liketable t2 on t1.t1p = t2.pid
) as also_like_users ) as also_like_users

inner join liketable on also_like_users.uu = liketable.username ) as also_liked_properties
where username <> {$username}) liked_properties
cross join
(select * from liketable where username = {$username}) ltt on ltt.pid <> liked_properties.pid)
as fuck
inner join similar on similar.pid1 = fuck.pid1 and similar.pid2 = fuck.pid2
order by similarity desc limit 30
*/

    print(" 
        <!DOCTYPE html>
        <html>
        <head>
        <title>Product</title>
        <link href='../css/bootstrap.css' rel='stylesheet' type='text/css' media='all' />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src='../jquery-3.2.0.min.js'></script>
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
                                <li><a href='mailto:info@example.com'><i class='glyphicon glyphicon-envelope'> </i>ypan19@illinois.edu</a></li>
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
                    <h2>Recommendation</h2>
                </div>
    ");

$already_like_query = "select * from liketable where username = '{$username}'";

$already_like_res = mysqli_query($link, $already_like_query);

$already_like_array = array();

while($already_like_data = mysqli_fetch_assoc($already_like_res)){
    $already_like_pid = $already_like_data["pid"];
    $already_like_array[$already_like_pid] = 1;
}



$like_res = mysqli_query($link, $like_query);
$currnum = 0;
        print("
            <div class='product'>
                <div class='container'>
                    <div class='col-md-9 product-price1'>





                        <div class='product-right-top'>

            ");
$rec_count = 0;
while($recommend_data = mysqli_fetch_assoc($like_res)){
    if ($rec_count >= 10) {
        break;
    }

    $pid = $recommend_data["pid"];
    if (array_key_exists($pid, $already_like_array)){
        continue;
    } else {
        $rec_count += 1;
    }
    $pid_query = "select * from property where pid = {$pid}";
    //print("<br> $pid_query </br>");
    $pid_res = mysqli_query($link, $pid_query);
    $pid_data = mysqli_fetch_assoc($pid_res);

            if($currnum%3 == 0)
                print("<div class='top-product'>");//row of items

            print("<div class='col-md-4 chain-grid  simpleCart_shelfItem'>");//whole item
            print("<div class='grid-span-1'>");//start of image
            if(strlen($pid_data['image']) < 5)
                print("<a><img src='./images.png' alt='A' class='img-responsive' height=196 width=196></a>");
            else
                print("<a><img src='{$pid_data['image']}' alt='No Image Source' class='img-responsive' height=196 width=196></a>");
            print("</div>");//end of image

            print("<div class='grid-chain-bottom '>");//start of title-price-info
            print("<a>House Address: {$pid_data['address']}</a>");
            print("<div class='star-price'>");//start of price-info
            print("<div class='price-at'>");//start of info
            print("<ul class='star-footer'>");//<ul> is set of noded lines
            print("<li><a><i>Property ID: {$pid_data['pid']}</i></a></li>");
            print("<li><a><i>House Area: {$pid_data['area']} sq ft</i></a></li>");

            if ($pid_data['parking'] == 1){
                print("<li><a><i>Parking availability: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>Parking availability: No</i></a></li>");
            }

            if ($pid_data['washer_dryer'] == 1){
                print("<li><a><i>Washer and Dryer availability: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>Washer and Dryer availability: No</i></a></li>");
            }

            if ($pid_data['pet'] == 1){
                print("<li><a><i>Allow pet: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>Allow pet: No</i></a></li>");
            }

            if ($pid_data['ac'] == 1){
                print("<li><a><i>A/C availability: Yes</i></a></li>");
            }
            else
            {
                print("<li><a><i>A/C availability: No</i></a></li>");
            }

            print("<li><a><i>Number of bedrooms: {$pid_data['bedrooms']}</i></a></li>");
            print("<li><a><i>Number of bathrooms: {$pid_data['bathrooms']}</i></a></li>");
            print("</ul></div>");//end of info

            print("<div class='price-at-bottom'>");//start of price
            print("<span class='item_price'>\$ {$pid_data['price']}/month</span>");
            print("</div>");//end of price
            print("<div class='clearfix'> </div>");//unknown function but exists
            print("</div>");//end of price-info



            $like_query_2 = "select * from liketable where username = '{$username}' and pid = {$pid_data["pid"]}";
            $like_res_2 = mysqli_query($link, $like_query_2);



            print("<div class='cart-add'>");//start of operations
            if (mysqli_num_rows($like_res_2) > 0){
                print("\n<button id = {$pid_data['pid']}and{$username} onclick=send_like(id)>dislike</button>");
                //like button is clickable button that calls a function in javascript which calls php script
            } 
            else {
                print("\n<button id = {$pid_data['pid']}and{$username} onclick=send_like(id)>like</button>");
                //like button is clickable button that calls a function in javascript which calls php script
            }
            //for like button, it is a hyperlink that passes in user and pid, i.e. 12
            print("<form action = './similar.php' method='POST'>
                    <input hidden type='text' value='{$username}' id='username' name='username'>
                    <input hidden type='text' value='{$pid_data['pid']}' id='pid' name='pid'>
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

            if (mysqli_num_rows($like_res_2) > 0){
                print("\n<button id = {$pid_data['pid']}and{$username} onclick=send_like(id)>dislike</button>");

                //like button is clickable button that calls a function in javascript which calls php script
            } else {
                print("\n<button id = {$pid_data['pid']}and{$username} onclick=send_like(id)>like</button>");
                //like button is clickable button that calls a function in javascript which calls php script
            }




            print("<form action = './similar.php' method='POST'>
                    <input hidden type='text' value='{$username}' id='username' name='username'>
                    <input hidden type='text' value='{$pid_data['pid']}' id='pid' name='pid'>
                    <input type='submit' value='Show similar properties'>
                    </form>");
            */
}

    if($currnum%3 != 0) {
        print("<div class='clearfix'> </div>");
        print("</div>");//end of row of items
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

mysqli_close($link);

?>






<script type="text/javascript">
        $(document).ready(function() {
        $().UItoTop({ easingType: 'easeOutQuart' });
});
</script>
<script>
    function send_like(id){
            var id_num=parseInt(id);
            var splits = id.split("and")
            var name = splits[1];
            console.log(id);
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