<?php
/**
 * Created by PhpStorm.
 * User: pyz
 * Date: 4/11/17
 * Time: 9:07 PM
 */



$link = mysqli_connect('housingbubble.web.engr.illinois.edu', 'housingbubble_cs411', 'cs411');
if (!$link) {
    die('Could not connect: ' . mysqli_error());
}

mysqli_select_db($link, 'housingbubble_cs411');

$query = "select * from property";
$res = mysqli_query($link, $query);

while($data = mysqli_fetch_assoc($res)){
    $pid = $data["pid"];
    $url = $data["image"];
    if (strcmp($url, "None") != 0){
        $pos = strpos($url, "/i");
        $new = str_replace("/Is", "/IS", $url);
        $update_query = "update property set image = '{$new}' where pid = {$pid}";
        mysqli_query($link, $update_query);
        print("<br> {$update_query} </br>");
    }


}


mysqli_close($link);
