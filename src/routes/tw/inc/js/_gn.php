<?php
	$_notwbs = 'ok';
	$pth = '../../../../includes/';
	include($pth.'__inc.php');
	include('../_inc.php');

	$__i = PrmLnk('rtn', 1);
	$__i2 = PrmLnk('rtn', 2);
	$__i3 = PrmLnk('rtn', 3);


	$_brws = new Browser();
	if($_brws->getBrowser() == 'Internet Explorer'){
		$_ie='ok';
		if($_brws->getVersion() < 9){ $_ieold = 'ok'; $_icn_sfx = '_ie'; }
	}



	hdr_js();
	ob_start("cmpr_js");


		$__f = substr($_SERVER['REQUEST_URI'], 1);
		$__f = explode('?', substr($_SERVER['REQUEST_URI'], 1));
		$__fle = basename($__f[0]);
		include($__fle);


	ob_end_flush();
?>