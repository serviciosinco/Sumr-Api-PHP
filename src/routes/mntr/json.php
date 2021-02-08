<?php $Rt = '../../includes/'; $__pbc='ok';

	include($Rt.'inc.php');


	$__i = PrmLnk('rtn', 1, 'ok');
	$__i2 = PrmLnk('rtn', 2, 'ok');
	$__i3 = PrmLnk('rtn', 3, 'ok');


	if($__i == 'json'){
		if($__i2 == 'listado'){
			$__to_inc = 'listado.php';
		}
	}

	if($__to_inc != ''){
		include('_cnt/json/'.$__to_inc);
	}


	$rtrn = json_encode($rsp);
	if($rtrn != '' && $rtrn != NULL && !empty($rtrn)){ echo $rtrn; }

?>