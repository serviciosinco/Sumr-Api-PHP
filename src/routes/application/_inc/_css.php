<?php	

	$__g_thm = Php_Ls_Cln($_GET['_thm']);
	
	Hdr_CSS(); 
	
	ob_start("cmpr_css"); 
	

		include( 'css/base.css' );	
		if(!isN($__g_thm)){ include ('css/themes/'.$__g_thm.'.css'); }


	ob_end_flush(); 


?>