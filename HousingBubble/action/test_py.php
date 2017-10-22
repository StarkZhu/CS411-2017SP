<?php 
//echo dechex(10) . "\n";
$s = 'abcd1234';

print($s."\n");
$s2 = dechex(11);
print($s2."\n");
print($s.$s2."\n");
print hash('sha256', $s."0x".$s2);


?>