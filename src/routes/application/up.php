<?php $Rt = '../../includes/'; $__pbc='ok';

	include($Rt.'inc.php');

	$__i = PrmLnk('rtn', 1, 'ok');
	$__i2 = PrmLnk('rtn', 2, 'ok');
	$__i2_i = explode('.', $__i2);
	$__i3 = PrmLnk('rtn', 3, 'ok');

	$_aws = new API_CRM_Aws();

	if($__i == 'up'){
		if($__i2_i[0] == 'upl_anx'){

			$__to_inc = 'upl_anx.php';
		}
	}

	if($__to_inc != ''){
		include('_cnt/up/'.$__to_inc);
	}


	$rtrn = json_encode($rsp);
	if($rtrn != '' && $rtrn != NULL && !empty($rtrn)){ echo $rtrn; }

?>