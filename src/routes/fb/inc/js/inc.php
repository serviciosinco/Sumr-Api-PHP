<?php 
	ini_set('display_errors', false);
	
	function hdr_js(){ 
			$expires = 60 * 60 * 24 * 7;
			$__fle_dir = dirname(__FILE__).$_SERVER['PHP_SELF'];
			$__fle_mtm = filemtime($__fle_dir);
			$__fle_etag = md5_file( basename($_SERVER['PHP_SELF']) . $__fle_mtm ); 
			
			header("Content-type: text/javascript; charset: UTF-8"); 
			header("Expires: " . gmdate("D, d M Y H:i:s", time() + 3600) . " GMT");
			header('Last-Modified: '.gmdate('D, d M Y H:i:s',  $__fle_mtm).' GMT', true, 200); 
			header('Cache-Control: no-cache, must-revalidate');
			header('Pragma: cache');
			header("Etag: ".$__fle_etag); 
	}
	function cmpr_js($buffer) {
			$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', ' ', $buffer);
			$buffer = str_replace(array("\r\n", "\r", "\n", "\t", ' ', '  ', '   ', '    '), ' ', $buffer);
			$buffer = str_replace(array('  ', '   '), ' ', $buffer);
			$buffer = str_replace(array('  '), ' ', $buffer); return $buffer;
	}
?>