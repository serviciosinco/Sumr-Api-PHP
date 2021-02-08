<?php	

	$__g_thm = Php_Ls_Cln($_GET['_thm']);
	$__g_cl = Php_Ls_Cln($_GET['__c']);

	
	$__cl_dt = GtClDt($__g_cl,'enc');
	$__cl_tag = $__cl_dt->tag;
	$__cl_clr = $__cl_tag->clr;
	$__cl_lgin = $__cl_tag->login;
	
	
	
	Hdr_CSS(); 
	
	ob_start("cmpr_css"); 
	

		include( 'css/base.css' );
		include( 'css/flatpicker.css' );
			
		if(!isN($__g_thm)){ include ('css/themes/'.$__g_thm.'.css'); }


	ob_end_flush(); 


?>