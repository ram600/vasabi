<?php

/**FUNCTIONS***/

function memoryUsage($usage, $base_memory_usage) {
printf("Bytes diff: %d\n", $usage - $base_memory_usage);
}
function someBigValue() {
return str_repeat('SOME BIG STRING',4);
}

/******END-FUNCITONS****/


echo "String memory usage test.\n\n";
$base_memory_usage = memory_get_usage();
$base_memory_usage = memory_get_usage();

echo "Start\n";
memoryUsage(memory_get_usage(), $base_memory_usage);

$a = array(someBigValue(),  someBigValue(),  someBigValue(),  someBigValue());


echo "Value setted\n";
memoryUsage(memory_get_usage(), $base_memory_usage);

//
//link & off on cycle optimizations..else if not & it will be created copy structrue of $a//and when cycle ended original $a will be removed
foreach ($a as $k => &$value) {
    
    unset($a[$k]);// =  someBigValue();
    //unset($a[$k]);
    unset($k,$value);
    echo 'In Foreach cycle.'.PHP_EOL;
    memoryUsage(memory_get_usage(), $base_memory_usage);
}

echo 'After foreach.'.PHP_EOL;
memoryUsage(memory_get_usage(), $base_memory_usage);

unset($a);
echo "Val unset\n";
memoryUsage(memory_get_usage(), $base_memory_usage);




