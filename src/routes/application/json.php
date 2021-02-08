<?php $Rt = '../../includes/'; $__pbc='ok';

	include($Rt.'inc.php');

	$__i = PrmLnk('rtn', 1, 'ok');
	$__i2 = PrmLnk('rtn', 2, 'ok');
	$__i2_i = explode('.', $__i2);
	$__i3 = PrmLnk('rtn', 3, 'ok');

	if($__i == 'json'){
		if($__i2_i[0] == 'lista_o'){
			$__to_inc = 'lista_o.php';
		}elseif($__i2_i[0] == 'anexos'){
			$__to_inc = 'anexos.php';
		}
	}

	if($__to_inc != ''){
		include('_cnt/json/'.$__to_inc);
	}


	$rtrn = json_encode($rsp);
	if($rtrn != '' && $rtrn != NULL && !empty($rtrn)){ echo $rtrn; }

?>