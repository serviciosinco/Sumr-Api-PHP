<?php 		
	
	try{
		
		$__eml = Php_Ls_Cln($_POST['_eml']);			 		
		$__aws = new API_CRM_Aws();
		$__prc = $__aws->_eml_vrfc([ 'id'=>$__eml ]);
		
		$rsp = $__prc;
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>