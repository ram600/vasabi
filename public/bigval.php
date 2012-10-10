<?php
function memoryUsage($usage, $base_memory_usage) {
printf("Bytes diff: %d\n", $usage - $base_memory_usage);
}
function someBigValue() {
return str_repeat('SOME BIG STRING',4);
}



echo "String memory usage test.\n\n";
$base_memory_usage = memory_get_usage();
$base_memory_usage = memory_get_usage();


$a = someBigValue();
$b = $a;
//$b = strval($b);

echo "String value setted";
memoryUsage(memory_get_usage(), $base_memory_usage);

unset($a,$b);

echo "Unset";
memoryUsage(memory_get_usage(), $base_memory_usage);