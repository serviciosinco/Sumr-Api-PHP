<?php

$_notwbs = 'ok';
$pth = '../';

include($pth.'../../../includes/inc.php');
include('../../inc/_inc.php');



		$__f = explode('?', substr($_SERVER['REQUEST_URI'], 1));
		$__fle = basename($__f[0]);


		include($__fle);


//ob_end_flush();
?>