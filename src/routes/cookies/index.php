<?php

	$__tme_s = microtime(true);
	$__tp='js';
	$Rt = '../../includes/';
	$__https_off = 'off';
	$__no_sbdmn = 'ok';
	$__bdfrnt = 'ok';
	require($Rt.'inc.php');

	header('Access-Control-Allow-Origin: *');

	$__p1 = PrmLnk('rtn', 1, 'ok');
	$__p2 = PrmLnk('rtn', 2, 'ok');
	$__p3 = PrmLnk('rtn', 3, 'ok');
	$__p4 = PrmLnk('rtn', 4, 'ok');


	if($__p1 == 's'){

		$_to_inc = '_sve.php';

	}elseif($__p1 == 'sess_img'){

		$_to_inc = '_img.php';

	}




	if($_to_inc != ''){
		ob_start("compress_code");
		No_Cache();
		include($_to_inc);
		ob_end_flush();
	}


?>