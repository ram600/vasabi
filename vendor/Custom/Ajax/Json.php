<?php

namespace Custom\Ajax;
class Json implements Response  {
   
    
    
    public static function response($data,$succssess_mess = null,$error_message = null) {
        $result = array('data'=>$data,'messages'=>$succssess_mess);
        if(count($error_message)){
            $result['error'] = $error_message;
        }
        echo json_encode($result);
        exit;
    }
}

?>
