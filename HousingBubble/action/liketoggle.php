<?php
/**
 * Created by PhpStorm.
 * User: pyz
 * Date: 3/20/17
 * Time: 9:10 AM
 */


$link = mysqli_connect('housingbubble.web.engr.illinois.edu', 'housingbubble_cs411', 'cs411');
if (!$link) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($link, 'housingbubble_cs411');
$username = $_POST["username"];
$pid = $_POST["pid"];


$query = "select * from liketable where username = '{$username}' and pid = {$pid}";
$res = mysqli_query($link, $query);
if (mysqli_num_rows($res) == 0){
    $insert_query = "insert into liketable (username, pid) values ( '{$username}', {$pid} )";
    mysqli_query($link, $insert_query);
} else {
    $delete_query = "delete from liketable where username = '{$username}' and pid = {$pid}";
    mysqli_query($link, $delete_query);
}

print("done");
mysqli_close($link);
?>