<?php 
	
	//-------------- VARIABLES GENERALES - START --------------//
		
		
		$__e = Php_Ls_Cln($_GET['_e']);
		$_____md_rfr = Php_Ls_Cln($_GET['rfr']);
		$_____md_key = Php_Ls_Cln($_GET['__k']);
		$_____act = Php_Ls_Cln($_GET['__act']);
		$_____snt = Php_Ls_Cln($_GET['__sent']);
		$__id_rnd = Php_Ls_Cln($_GET['rnd']);
		 

		$_____md_url = URL_Data( $_____md_rfr );
		$_____md_schw = unserialize(SIS_SCHWBS);
		
		if (in_array($_____md_url['host'], $_____md_schw)){ 
			$_____md_uid = SIS_MD_SCHORG; 
		}
	
	//-------------- TARGET FORM --------------//
		
		if(!_isFm()){ $__trg_a = "_self"; }else{ $__trg_a = "_parent"; }
		
	
?> 