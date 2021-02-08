<?php $Rt = '../../includes/'; require($Rt.'inc.php'); $__bdfrnt = 'ok';


	$__p1 = PrmLnk('rtn', 1, 'ok');
	$__p2 = PrmLnk('rtn', 2, 'ok');
	$__p3 = PrmLnk('rtn', 3, 'ok');
	$__p4 = PrmLnk('rtn', 4, 'ok');
	$__p5 = PrmLnk('rtn', 5, 'ok');


	if($__p2 == 'url'){
		include(DIR_CNT.'url.php');
	}else{
		include(DIR_CNT.'pxl.php');
	}

?>