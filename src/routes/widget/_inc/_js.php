<?php
			
	include('inc.php'); 
	 
	ob_start("cmpr_js");		
		
		$_id = $_GET['id'];
		$__f = substr($_SERVER['REQUEST_URI'], 1);
		$__f = explode('?', substr($_SERVER['REQUEST_URI'], 1));
		$__fle = $__f[0];
		Hdr_JS([ 'cche'=>'ok' ]);
		
		include('js/'.$__fle);
		
	ob_end_flush(); 
	
?>