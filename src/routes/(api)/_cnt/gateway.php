<?php 
		
	$rsp = null;	
	
	//-------------- FOLDERS INTERNOS --------------//
		
		define('API_F_GATEWAY', dirname(__FILE__).'/gateway/');
	
	//-------------- FOLDERS INTERNOS --------------//
	
	
	try {
        
        
        if($__p3_o == 'mercadopago'){ 
					
            include(API_F_GATEWAY."mercadopago.php");

        }
        
        if($__e != 'ok'){
            //header('HTTP/1.0 403 Forbidden');
        }else{
            header("HTTP/1.1 200 OK");
        }

    } catch (Exception $e) {

        $__sve = $e->getMessage();
        
    }	
	
	
?>