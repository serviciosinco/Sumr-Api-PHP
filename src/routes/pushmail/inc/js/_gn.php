<?php

	$__tme_s = microtime(true); $Rt = '../../../../includes/'; require($Rt.'inc.php'); ob_start("cmpr_js");

	Hdr_JS();


	$__cl = Php_Ls_Cln($_GET['_cl']);
	$_cl_dt = GtClDt( $__cl, 'enc' );


	$__f = explode('?', substr($_SERVER['REQUEST_URI'], 1));
	$__fle = basename($__f[0]);
	include($__fle);

	ob_end_flush();

?>