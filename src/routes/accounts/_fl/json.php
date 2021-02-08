<?php 

	
	//---------------------- GROUP LIST ----------------------//
		
		$rsp['e'] = 'no';
		
	//---------------------- VARIABLES GET / POST ----------------------//
	
		$__t = Php_Ls_Cln($_POST['t']);
	
	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//
	
		
		if($__t == 'login'){	
			$___to_inc = GL_JSON.'login.php';	
		}
	
	//---------------------- COMPRIME E INCLUYE CONTENIDO --------------//	
		
		ob_start("cmpr_fm"); 
		Hdr_JSON();
			
			if($___to_inc != ''){ include($___to_inc); }
			
		$rtrn = json_encode($rsp); 
		if(!isN($rtrn)){ echo $rtrn; }	
	
		ob_end_flush(); 
	
?>