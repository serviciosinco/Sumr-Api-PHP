<?php

$pth = '../../';

include($pth.'../../../includes/__inc.php');

hdr_js(); //ob_start("cmpr_js");

		$__f = explode('?', substr($_SERVER['REQUEST_URI'], 1));
		$__fle = basename($__f[0]);


		include($__fle);


//ob_end_flush();
?>