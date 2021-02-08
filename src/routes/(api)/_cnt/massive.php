<?php 
		
	$rsp = null;
	
	$_massive = new API_CRM_Massive();
	$_wthsp = new CRM_Wthsp();

	$gdata = _PostRw();
	
	if( !isN( $gdata['type'] ) ){
		$__data_type = $gdata['type'];
	}else{
		$__data_type = Php_Ls_Cln($_POST['type']);
	}
	

	if( !isN( $gdata['message'] ) ){
		$__cnv_msg_id = $gdata['message'];
	}else{
		$__cnv_msg_id = Php_Ls_Cln($_POST['message']);
	}

	if( !isN( $gdata['channel'] ) ){
		$__cnv_id = $gdata['channel'];
	}else{
		$__cnv_id = Php_Ls_Cln($_POST['channel']);
	}


	//-------------- FOLDERS INTERNOS --------------//
		
		define('API_F_MASSIVE', dirname(__FILE__).'/msv/');
	
	//-------------- FOLDERS INTERNOS --------------//
	
	
	if(	$__data_type == 'channel'){ 
							
		try {
			require(API_F_MASSIVE.'cnv.php'); 
		} catch (Exception $e) {
			$__incerror = $e->getMessage();  
		}
								
	}elseif($__data_type == 'message_delivered'){ 
							
		try {
			require(API_F_MASSIVE.'cnv_msg_snd.php'); 
		} catch (Exception $e) {
			$__incerror = $e->getMessage();  
		}
							
	}elseif($__data_type == 'new_message'){
							
		try {
			require(API_F_MASSIVE.'cnv_msg.php'); 
		} catch (Exception $e) {
			$__incerror = $e->getMessage();  
		}
							
	}elseif($__data_type == 'remover_channel'){
		
		try {
			require(API_F_MASSIVE.'cnv_rmv.php'); 
		} catch (Exception $e) {
			$__incerror = $e->getMessage();  
		}
							
	}
	
	
	
	
?>