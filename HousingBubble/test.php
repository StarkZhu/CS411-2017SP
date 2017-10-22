  
      <?php
/**
 * Created by PhpStorm.
 * User: pyz
 * Date: 3/22/17
 * Time: 5:01 PM
 */


function bchexdec($hex) {
        if(strlen($hex) == 1) {
            return hexdec($hex);
        } else {
            $remain = substr($hex, 0, -1);
            $last = substr($hex, -1);
            return bcadd(bcmul(16, bchexdec($remain)), hexdec($last));
        }
    }


$link = mysqli_connect('housingbubble.web.engr.illinois.edu', 'housingbubble_cs411', 'cs411');
	if (mysqli_connect_errno()) {
		die('Could not connect: ' . mysqli_connect_error());
	}
mysqli_select_db($link, 'housingbubble_cs411');

$username = "hhhhh";

$error_query = "select value from bf_test where idx = -2";

$error_res = mysqli_query($link, $error_query);

$error_rate = mysqli_fetch_assoc($error_res);

$error_rate = $error_rate["value"];

$k = log($error_rate, 2);

$bool_value = true;

$length_query = "select * from bf_test where idx = -1";
$length_res = mysqli_query($link, $length_query);

$length = mysqli_fetch_assoc($length_res)["value"];



for ($i = 0; $i < intval(ceil($k)); $i+=1) {

    $hex_str = dechex($i);
    $hash_hex = hash('sha256', "{$username}0x{$hex_str}");

		$hexdec = bchexdec($hash_hex);

  	$index_str = bcmod($hexdec, "{$length}");
  
    $index_query = "select * from bf_test where idx = {$index_str}";
  
    $index_res = mysqli_query($link, $index_query);

    $value = mysqli_fetch_assoc($index_res)["value"];
    if ($value == 0){
        $bool_value = false;
        break;
    }
}


if (!$bool_value){
    for ($i = 0; $i < intval(ceil($k)); $i+=1) {
        $hex_str = dechex($i);
        $hash_hex = hash('sha256', "{$username}0x{$hex_str}");

				$hexdec = bchexdec($hash_hex);
        $index_str = bcmod($hexdec, "{$length}");

        $index_query = "select * from bf_test where idx = {$index_str}";
        $index_res = mysqli_query($link, $index_query);
        // TODO: query table to get index
        $value = mysqli_fetch_assoc($index_res)["value"];
        $value += 1;
        $update_query = "update bf_test set value = {$value} where idx = {$index_str}";
        mysqli_query($link, $update_query);
    }


//////
    print("welcome!");
//////
//this should go to index.html
// notice that you should incorporate the information of username in the html so that the login session goes on.


}else {
    print("already exists");
}
mysqli_close($link);

?>
  