<?php

$_notwbs = 'ok';
$pth = '../';

include($pth.'../../../includes/__inc.php');
include('../../inc/_inc.php');

hdr_css(); //ob_start("cmpr_js");

		$__f = explode('?', substr($_SERVER['REQUEST_URI'], 1));
		$__fle = basename($__f[0]);


		include($__fle);


//ob_end_flush();
?>