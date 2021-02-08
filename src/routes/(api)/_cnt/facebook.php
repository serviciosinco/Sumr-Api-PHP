<?php 
	
	global $__cnx;
		
	$rsp = null;
	
	$__hub_c = Php_Ls_Cln($_GET['hub_challenge']);
	$__hub_t = Php_Ls_Cln($_GET['hub_verify_token']);
	$___entry  = _jEnc(_GetPost('entry')); 
	
	
	//-------------- FOLDERS INTERNOS --------------//
		
		define('API_F_FACEBOOK', dirname(__FILE__).'/facebook/');
	
	//-------------- FOLDERS INTERNOS --------------//
	
	
	if($__hub_t == enCad('FacebookAPI')){
		
		echo $__hub_c;
		
	}else{
		
		try {
			
			if(!isN($___entry)){ 
				
				foreach($___entry as $ok=>$ov){ 
					
					$___acc_chng_id = $ov->id;
					
					foreach($ov->changes as $ck=>$cv){
						
						$_data_cv = $cv;
						
						if($cv->field == 'conversations'){ // Procesa lotes de Conversaciones
							
							try {
								include(API_F_FACEBOOK.'conversations.php'); 
							} catch (Exception $e) {
							    $__incerror = $e->getMessage();  
							}
													
						}elseif($cv->field == 'feed'){ // Procesa lotes de Conversaciones
							
							try {
								include(API_F_FACEBOOK.'feed.php'); 
							} catch (Exception $e) {
							    $__incerror = $e->getMessage();  
							}	
							
						}elseif($cv->field == 'leadgen'){ // Procesa lotes de Leads
							
							try {
								include(API_F_FACEBOOK.'lead.php'); 
							} catch (Exception $e) {
							    $__incerror = $e->getMessage();  
							}	
							
						}
						
					}
				}
			
			}
			
			
		} catch (Exception $e) {
    
		    $__sve = $e->getMessage();
		    
		}
		
		if($__e != 'ok'){
			//header('HTTP/1.0 403 Forbidden');
		}else{
			header("HTTP/1.1 200 OK");
		}
		
	}
	
	
	
?>