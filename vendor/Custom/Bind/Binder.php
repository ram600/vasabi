<?php
namespace Custom\Bind;
/**
 * @author Ramil Aysin <>
 * 
 * 
 * bind data array in object with similar setters
 */
class Binder {
    
    const METHOD_PREFIX = 'set';
    
    public static final function bind(array $data,$object){
        if(is_object($object)){
            $method_list = get_class_methods($object);
            $lower_method_list = array_map('strtolower',$method_list);
            
            foreach ($data as $key => $value) {
                if($key = array_search(strtolower(self::METHOD_PREFIX.$key),$lower_method_list)){
                    call_user_func(array($object,$method_list[$key]), $value);
                    unset($method_list[$key]);
                }
            }
            return $object;
        }
        throw new \Exception(__CLASS__.__FUNCTION__." this is not object,this is ".  gettype($object)." !");
    }
    
    
    
    
    
    
}
?>
