<?php

$list = array();

for($i =0;$i < 100;$i++){
    $o = new \stdClass();
    $o->name = 1;
    $o->id = 100;
    $o->rand = rand(1,10);
    $list[] = $o;
}

$result = array_filter($list,function($o){return ($o->rand >5); });

print_r($result);


?>
