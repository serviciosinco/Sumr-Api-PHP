<?php

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlCnt")) {

	$__CntIn = new CRM_Cnt();
	$__CntIn->cnt_nm = $_POST['cnt_nm'];
	$__CntIn->cnt_ap = $_POST['cnt_ap'];
	$__CntIn->cnt_dc = $_POST['cnt_dc'];
	$__CntIn->cnt_dc_tp = $_POST['cnt_dctp'];
	$__CntIn->cnt_fn = $_POST['cnt_fn'];
	$__CntIn->cnt_tp = $_POST['cnt_tp'];
	//$__CntIn->cnt_cld = $_POST['cnt_cld'];
	$__CntIn->cnt_sx = $_POST['cnt_sx'];
	$__CntIn->cnt_bd = $_POST['cnt_bd'];
	$__CntIn->cnt_eml = $_POST['cnt_eml'];
	$__CntIn->cnt_eml_2 = $_POST['cnt_eml_2'];
	$__CntIn->cnt_eml_3 = $_POST['cnt_eml_3'];
	$__CntIn->cnt_lcl = $_POST['cnt_lcl'];
	$__CntIn->cnt_tel = $_POST['cnt_tel'];
	$__CntIn->cnt_tel_2 = $_POST['cnt_tel_2'];
	$__CntIn->cnt_clg = $_POST['cnt_clg'];
	$__CntIn->cnt_em = $_POST['cnt_em'];
	$__CntIn->cnt_dir = $_POST['cnt_dir'];
	$__CntIn->cnt_prf = $_POST['cnt_prf'];
	$__CntIn->cnt_sndi = $_POST['cnt_sndi'];
	$__dtus_in = $__CntIn->InCnt();


	if($__dtus_in->e == 'ok'){
		$rsp['i'] = $__dtus_in->i;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(26, $_POST['cnt_nm'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__dtus_in->w;
		$rsp['i'] = $__dtus_in->i;
		$rsp['o'] = $__CntIn;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__dtus_in->w]);

	}

}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCnt")) {

	$__CntIn = new CRM_Cnt();
	$__CntIn->cnt_nm = $_POST['cnt_nm'];
	$__CntIn->cnt_ap = $_POST['cnt_ap'];
	$__CntIn->cnt_fn = $_POST['cnt_fn'];
	$__CntIn->cnt_sx = $_POST['cnt_sx'];
	$__CntIn->cnt_eml = $_POST['cnteml_eml'];
	$__CntIn->cnt_sndi = 1;
	$__CntIn->cnt_bd = $_POST['cnt_bd'];
	if(!isN(Php_Ls_Cln($_POST['_cnt_plcy']))){
		$___plcydt = GtClPlcyDt([ 'id'=>Php_Ls_Cln($_POST['_cnt_plcy']), 't'=>'enc' ]);
		$__CntIn->plcy_id = $___plcydt->id;
	}
	$__dtus_in = $__CntIn->_Cnt();

	if($__dtus_in->e == 'ok'){
		$rsp['i'] = $__dtus_in->i;
		$rsp['enc'] = $__dtus_in->enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(26, $_POST['cnt_nm'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__dtus_in->w;
		$rsp['i'] = $__dtus_in->i;
		$rsp['o'] = $__CntIn;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__dtus_in->w]);
	}

}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCnt")) {

		$__CntUp = new CRM_Cnt();
		$__CntUp->id_cnt = $_POST['id_cnt'];
		$__CntUp->cnt_enc = $_POST['cnt_enc'];
		$__CntUp->cnt_nm = $_POST['cnt_nm'];
		$__CntUp->cnt_ap = $_POST['cnt_ap'];
		$__CntUp->cnt_dc = $_POST['cnt_dc'];
		$__CntUp->cnt_dc_tp = $_POST['cnt_dctp'];
		$__CntUp->cnt_fn = $_POST['cnt_fn'];
		$__CntUp->cnt_tp = $_POST['cnt_tp'];
		//$__CntUp->cnt_cld = $_POST['cnt_cld'];
		$__CntUp->cnt_sx = $_POST['cnt_sx'];
		$__CntUp->cnt_bd = $_POST['cnt_bd'];
		$__CntUp->cnt_eml = $_POST['cnt_eml'];
		$__CntUp->cnt_eml_2 = $_POST['cnt_eml_2'];
		$__CntUp->cnt_eml_3 = $_POST['cnt_eml_3'];
		$__CntUp->cnt_lcl = $_POST['cnt_lcl'];
		$__CntUp->cnt_cel = $_POST['cnt_cel'];
		$__CntUp->cnt_cel_2 = $_POST['cnt_cel_2'];
		$__CntUp->cnt_tel = $_POST['cnt_tel'];
		$__CntUp->cnt_tel_2 = $_POST['cnt_tel_2'];
		$__CntUp->cnt_tel_3 = $_POST['cnt_tel_3'];
		$__CntUp->cnt_tel_4 = $_POST['cnt_tel_4'];
		$__CntUp->cnt_tel_5 = $_POST['cnt_tel_5'];
		$__CntUp->cnt_em = $_POST['cnt_em'];
		$__CntUp->cnt_dir = $_POST['cnt_dir'];
		$__CntUp->cnt_prf = $_POST['cnt_prf'];
		$__CntUp->cnt_sndi = $_POST['cnt_sndi'];

		$__dtus_up = $__CntUp->UpdCnt();

	if($__dtus_up->e == 'ok'){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['enc'] = $_POST['cnt_enc'];

		Aud_Sis(Aud_Dsc(27, $_POST['cnt_nm'], $__cnx->c_p->insert_id), $rsp['v']);
		if($_POST['___pop'] == 'ok'){ $rsp['c'] = 'ok'; }

	}else{
		$rsp['e'] = 'noddd';
		$rsp['m'] = 2;
		$rsp['w'] = $__dtus_up->w;

		_ErrSis(['p'=>$updateSQL, 'd'=>$__dtus_up->w]);
	}
}

// Elimino el Registro
if ((isset($_POST['id_cnt'])) && ($_POST['id_cnt'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdCnt'))) {
	$deleteSQL = sprintf('DELETE FROM '.TB_CNT.' WHERE cnt_enc=%s', GtSQLVlStr($_POST['cnt_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(28, $_POST['cnt_nm'], $__cnx->c_p->insert_id), $rsp['v']);}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>