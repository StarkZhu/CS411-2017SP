<?php
/**
 * Created by PhpStorm.
 * User: pyz
 * Date: 3/20/17
 * Time: 9:18 AM
 */

$link = mysqli_connect('housingbubble.web.engr.illinois.edu', 'housingbubble_cs411', 'cs411');
if (!$link) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($link, 'housingbubble_cs411');
$username = $_POST["username"];
$like_query = "select * from liketable where username = '{$username}'";
$like_res = mysqli_query($link, $like_query);

$row = mysqli_num_rows($like_res);

if ($row == 0){
    print("you didn't like any property");
}
else {
    while($like_data = mysqli_fetch_assoc($like_res)){
        $pid = $like_data["pid"];
        $pid_query = "select * from property where pid = {$pid}";
        $pid_res = mysqli_query($link, $pid_query);
        $pid_data = mysqli_fetch_assoc($pid_res);
        print("{$pid_data['pid']}");
        //address, price, parking.......
    }
}

mysqli_close($link);

?>