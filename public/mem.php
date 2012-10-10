<?php

function memoryUsage($usage, $base_memory_usage) {
printf("Bytes diff: %d\n", $usage - $base_memory_usage);
}

$mem = memory_get_usage();
$mem = memory_get_usage();

memoryUsage(memory_get_usage(), $mem);


$a = array(0,&$a);
$b = &$a;
unset($a);
//unset($b);
xdebug_debug_zval('a');
xdebug_debug_zval('b');
//gc_collect_cycles();



memoryUsage(memory_get_usage(), $mem);