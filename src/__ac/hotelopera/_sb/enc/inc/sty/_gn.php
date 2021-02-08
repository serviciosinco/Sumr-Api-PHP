<?php 

	$__t = Php_Ls_Cln($_GET['__t']);
	$__i_vg = '?__v=001&';


		
	$css_prnt = [
				'estr.css',
				'jquery.mCustomScrollbar.css',
			];
	
	
	Hdr_CSS(); 
	ob_start("cmpr_css"); 
			
		foreach ($css_prnt as $css_file_prnt) {
				include($css_file_prnt);
		}		
	
	
	ob_end_flush();
?>