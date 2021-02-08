<?php 
	
	$__rlc = Php_Ls_Cln($_POST['___t_rlc']);

		$__bd__prn = TB_CNT_SND;
		$__id__rlc = 'mdlcntec_ecsnd';
		$__id__rlc_2 = 'mdlcntec_mdlcnt';
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlCntEc")) {

	$__dt_cnt = GtUsDt($_POST['ecsnd_ec']);
	$__dt_mdlcnt = GtMdlCntDt([ 'id'=>$_POST['mdlcntec_mdlcnt'], 't'=>'enc' ]);
	
	$__ec = new API_CRM_ec();
	$__ec->snd_f = SIS_F;
	$__ec->snd_h = SIS_H2;
	$__ec->snd_ec = $_POST['ecsnd_ec'];
	$__ec->snd_mdlcnt = $__dt_mdlcnt->id;
	$__ec->snd_eml = $_POST['ecsnd_eml'];
	$__ec->snd_cnt = $_POST['___t_cnt'];
	$__ec->snd_us = SISUS_ID;
	
	$__snd = $__ec->_SndEc([ 't'=>'mdl', 'auto'=>'ok' ]);
	
	$rsp['tmp'] = $__snd; 
	
	if($__snd->e == 'ok'){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['auto'] = $__snd->u_o;
	}else{
		$rsp['e'] = 'no';
	}
}

?>