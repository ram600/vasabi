//core
//depend jquery 1.7


    
    var vote = function(stick_id,element_id,vote){
            el = $('#'+element_id+stick_id);
            rate = parseInt(el.text());
            
            //preload hack ;)
            if(vote == 'like'){
               if(el.hasClass('vote-pl')){
                 return false; 
               }
               el.addClass('vote-pl');
               el.removeClass('vote-min');
               el.text(++rate); 
            }else{
               if(el.hasClass('vote-min')){
                 return false; 
               }
                el.addClass('vote-min');
                el.removeClass('vote-pl');
                el.text(--rate);
            }
        
           $.post("stick/"+vote,{id:stick_id},function(result){
            if(result.data >= 0 ){
                el.text(result.data);
            }
           },"json"); 
    }    
    
    var globalResult = function(data_obj){
    
        this.succes = true;
        
        this.isSuccess = function(){
            return (this.success)?true:false;
        }
    
        this.getMessage = function(message){
           mess = '';
           if(typeof message == 'object'){
                this.success = false;
                mess += 'Error<br/>'; 
           
           $.each(message, function(index,val){
              if(typeof val == 'object'){
                $.each(val,function(index,val){
                   mess +=val+'<br/>'
                });  
              }else{
                mess += val+'<br/>';
              }
              
           });
           }else{
            mess +=message;
           }
           
           return mess;
        }
    
        if(data_obj.error){
          noty({
              text: this.getMessage(data_obj.error),
  		type: 'warning',
                dismissQueue: false,
  		layout: 'topRight',
  		theme: 'defaultTheme'
  	       }); 
        }else{
          noty({
  		text: this.getMessage(data_obj.messages),
  		type: 'success',
                dismissQueue: false,
  		layout: 'topRight',
  		theme: 'defaultTheme'
  	       });
        }
        	
    }
    





