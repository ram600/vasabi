<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);




function read_config($filename){

    if(!is_readable($filename)){
        echo "File unreadable!\n";
    }
    if(pathinfo($filename, PATHINFO_EXTENSION) != 'ini'){
        echo "File extension must be .ini\n";
    }
    
    $file = fopen($filename,"r");
    $roots = array();
    $current_roots = null;
    
    while(!feof($file)){
       
        $row = fgets($file, 1024); 
        
        if(preg_match("/\[\s*([A-Za-z0-9]+)\s*\]/", $row,$entities)){
           $current_roots = $entities[1];
           continue;
        }
       
       if($current_roots){ 
            if(preg_match("/\s*([a-zA-Z0-9.]*)\s*=\s*(.*)\s*/",$row,$params)){
               $name = $params[1];
               $value = $params[2];

               $tmp_names = explode('.', $name);

               //have childs
               if(1 < count($tmp_names)){
                   //array_push($roots, $tmp_names);
                   continue;
               }
               //haven't childs
               $roots[$current_roots][$name] = $value;
               continue;
            }
       
       }
       
    }
    
    return $roots;
    

}


function _paramsParser($params_string,$array){
    $data = explode('.', $params_string);
    
    if(!isset($array[$data[0]])){
        
    }
    
    
    
}

$filename = 'config.ini';
print_r(read_config($filename));






?>
