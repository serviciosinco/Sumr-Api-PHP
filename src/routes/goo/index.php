<?php

	$pth = '../../includes/'; $__https_off = 'off'; $__no_sbdmn = 'ok'; $__bdfrnt = 'ok'; include($pth .'inc.php');


	$__p1 = PrmLnk('rtn', 1, 'ok');
	$__p2 = PrmLnk('rtn', 2, 'ok');
	$__p3 = PrmLnk('rtn', 3, 'ok');

	if($__p1 == 'save'){

		include('cnt/save.php');

	}

?>