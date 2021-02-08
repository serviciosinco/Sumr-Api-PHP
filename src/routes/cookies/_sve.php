<?php if($_to_inc == ''){ $Rt = '../../includes/'; include('../../includes/inc.php'); } ob_start("compress_code"); Hdr_JSON();


	$rsp['e'] = 'no';

	$__i = Php_Ls_Cln($_GET['id']);
	$__c = Php_Ls_Cln($_GET['c']);
	$__u = Php_Ls_Cln($_GET['u']);
	$__m = Php_Ls_Cln($_GET['m']);
	$__t = Php_Ls_Cln($_GET['t']);

	$__sve_dt = _SvCkTrck([ 'id'=>$__i, 'c'=>$__c, 'u'=>$__u, 'm'=>$__m, 't'=>$__t ]);
	$rsp['adm'] = $__sve_dt;

	if($__sve_dt->e == 'ok'){ $rsp['e'] = 'ok'; }

	$rtrn = json_encode($rsp);
	if(!isN($rtrn)){ echo $rtrn; }


ob_end_flush();
?>