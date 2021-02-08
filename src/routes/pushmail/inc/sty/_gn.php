<?php

	$__tme_s = microtime(true); $Rt = '../../../../includes/'; require($Rt.'inc.php'); ob_start("cmpr_css");


	$__f = explode('?', substr($_SERVER['REQUEST_URI'], 1));
	$__fle = basename($__f[0]);
	include($__fle);


	Hdr_CSS([ 'f'=>$__fle ]);
	ob_end_flush();

?>