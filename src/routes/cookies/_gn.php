<?php
$Rt = '../../includes/'; $__tp = 'js'; include('../../includes/inc.php'); Hdr_JS(); ob_start("cmpr_js");

	$__f = substr($_SERVER['REQUEST_URI'], 1);
	$__pm_i = 2;
	$__tp = str_replace('_', '', PrmLnk('rtn', 1));


	$__f = explode('?', substr($_SERVER['REQUEST_URI'], 1));
	$__fle = $__f[0];

	include($__fle);


ob_end_flush();
?>