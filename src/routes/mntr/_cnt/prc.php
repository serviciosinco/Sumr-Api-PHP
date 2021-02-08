<?php

	$_r['e'] = 'no';
	
	
	

	//---------------------- VARIABLES GET ----------------------//
		
		
		$__nn = Php_Ls_Cln($_POST['nn']);
		$__nv = Php_Ls_Cln($_POST['nv']);
	
	
	//---------------------- INSTALL ----------------------//
	
	
		$__mntr = new CRM_Mntr(); 
		$_r = $__mntr->__node_install([ 'nn'=>$__nn ]);	
		
	
	//-------------- PRINT RESULTS --------------//
	
	
	if(!isN($_r)){ echo json_encode($_r); }

		
		
?>