<?php

	$_nosis = 'ok'; $pth = '../../../includes/'; include($pth .'__inc.php');


	Hdr_JS();

	$__f = explode('?', substr($_SERVER['REQUEST_URI'], 1));
	$__fle = basename($__f[0]);
	include($__fle);

	ob_end_flush();

?>