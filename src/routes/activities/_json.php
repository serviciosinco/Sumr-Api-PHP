<?php $pth = '../../includes/'; include($pth .'__inc.php'); ob_start("compress_code"); Hdr_JSON();


	$__i = PrmLnk('rtn', 1);
	$__i2 = PrmLnk('rtn', 2);
	$__i2_i = explode('.', $__i2);
	$__i3 = PrmLnk('rtn', 3);


	if($__i == 'json'){
		if($__i2_i[0] == 'colegio'){
			$__to_inc = 'clg.php';
		}elseif($__i2_i[0] == 'carrera_o'){
			$__to_inc = 'pro_o.php';
		}
	}

	if($__to_inc != ''){
		include('_cnt/_json/'.$__to_inc);
	}

	$rtrn = json_encode($rsp);
	if($rtrn != '' && $rtrn != NULL && !empty($rtrn)){ echo $rtrn; }

	ob_end_flush();
	CnCls($mysqli);
?>