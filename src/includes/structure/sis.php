<?php $Rstr = 'adm'; $Rt = '../'; include($Rt.'inc.php'); ob_start("compress_code"); Hdr_JSON(); header('Access-Control-Allow-Origin: *');

	$___Gt = json_decode(	GtSisPrcDt(Php_Ls_Cln($_GET['__e']))	);
	if($___Gt->tp == 1){ $___cls = 'ok';}else{ $___cls = 'no'; } $__r['tx'] = $___Gt->tt;

	$__json = json_encode($__r);
	if($__json != '' && $__json != NULL && !empty($__json)){ echo $__json; }
?>