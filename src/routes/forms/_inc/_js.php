<?php 

	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL);
	//define('DSERR','on');

	$__tp = 'js'; 
	include('inc.php'); 
	Hdr_JS(); 
	
	$browser = new Browser();
	
	ob_start("cmpr_js");
	
	$__f = substr($_SERVER['REQUEST_URI'], 1);
	$__pm_i = 2;
	$__tp = str_replace('_', '', PrmLnk('rtn', 1));
		
	$__f = explode('?', substr($_SERVER['REQUEST_URI'], 1));
	$__fle = $__f[0];
	
	include('js/'.$__fle);
				
	ob_end_flush();
	
?>