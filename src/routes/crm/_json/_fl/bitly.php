<?php 
	
	$__url = Php_Ls_Cln($_POST['_url']);

	if (filter_var($__url, FILTER_VALIDATE_URL)) {

		$ClsShorter = new CRM_Shrt();
		$ClsShorter->shrt_url = $_POST['_url'];
		
		$__shrt = $ClsShorter->get([ 'url'=>$ClsShorter->shrt_url ]);
		
		$rsp['tmp_all'] = $__shrt;
		$rsp['url_s'] = $__shrt->url; 
		$rsp['e'] = 'ok';   
		
		 
	}else{
		$rsp['e'] = 'no';	    
		$rsp['m'] = 'Formato URL no valido.';	
	}
	
	
?>