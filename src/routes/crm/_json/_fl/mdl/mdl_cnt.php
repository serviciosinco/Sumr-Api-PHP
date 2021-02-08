<?php 
	
	//--------------- POST PARAMETERS  ---------------//

		$__id = Php_Ls_Cln($_POST['id']);

	//--------------- POST PARAMETERS  ---------------//

	
	$__dt_main = GtMdlCntDt([ 't'=>'enc', 'id'=>$__id, 'shw'=>[ 'cnt'=>'ok' ] ]);	
	
	$__ls_msj = GtMdlCntMsj([ 'i'=>$__dt_main->id ]); 
	$__ls_est = GtMdlCntEst([ 'i'=>$__dt_main->id ]);
	$__ls_oth = GtMdlCntOth([ 'i'=>$__dt_main->cnt->id, 'i2'=>$__dt_main->id, 'd'=>[ 'mdlcntmdl'=>'ok' ] ]);
    $__ls_tml = GtCntTml([ 'cnt'=>$__dt_main->cnt->id, 'mdl_cnt'=>$__dt_main->id ]);	
	
	$rsp['cnt'] = $__dt_main->cnt->id;
	
	$rsp['dsh']['main'] = $__dt_main;
	$rsp['dsh']['msj'] = $__ls_msj;
	$rsp['dsh']['est'] = $__ls_est;
	$rsp['dsh']['oth'] = $__ls_oth;
	$rsp['dsh']['tml'] = $__ls_tml;
	
?>