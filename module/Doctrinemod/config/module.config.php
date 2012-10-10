<?php
chdir(dirname(__DIR__));

return array(

   
        'db'=> array(
         'dbname' => 'vasabi',
         'user' => 'r2',
         'password' => 'domodomo1',
         'host' => '192.168.1.145',
         'driver' => 'pdo_mysql'
         ),
         'options'=>array(
             'path_to_entities'=>array(
                 '../Sticks/src/Sticks/Model'
                 ),
             'cache'=> '\Doctrine\Common\Cache\ArrayCache',
             'path_to_proxy'=>__DIR__.'/../proxy',
             'proxy_namespace'=>'Sticks\Proxies',
             'autogenerate_proxy' => true
         )
    

);