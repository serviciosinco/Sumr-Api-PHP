<?php

	$__https_off = 'off'; $Rt = '../../../includes/'; include($Rt.'inc.php');


	Hdr_CSS(); //ob_start("cmpr_css");

		$__f = substr($_SERVER['REQUEST_URI'], 1);
		$__f = explode('?', substr($_SERVER['REQUEST_URI'], 1));
		$__fle = basename($__f[0]);

	include_once($__fle);

	//ob_end_flush();

?>