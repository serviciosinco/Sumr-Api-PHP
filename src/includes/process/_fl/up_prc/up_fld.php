<?php

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdUpFld")) {
	global $__cnx;

	$__enc = Enc_Rnd($_POST['upfld_tt'].'-'.$_POST['upfld_vl']);

	$insertSQL = sprintf("INSERT INTO ".DBP.".".TB_UP_FLD." ( upfld_enc, upfld_tt, upfld_vl, upfld_fk, upfld_dte, upfld_cnt, upfld_mdl_cnt, upfld_mdl_cnt_tra, upfld_snd_ec_lsts_up, upfld_snd_sms_cmpg_up, upfld_ext_cnt, upfld_ext_mdlcnt, upfld_scl) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",

                   GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['upfld_tt'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['upfld_vl'],'out'), "text"),
				   GtSQLVlStr(Html_chck_vl($_POST['upfld_fk']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['upfld_dte']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['upfld_cnt']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['upfld_mdl_cnt']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['upfld_mdl_cnt_tra']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['upfld_snd_ec_lsts_up']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['upfld_snd_sms_cmpg_up']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['upfld_ext_cnt']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['upfld_ext_mdlcnt']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['upfld_scl']), "int")
                  );

	$Result = $__cnx->_prc($insertSQL);

		if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(71, $_POST['upfld_vl'], $__cnx->c_p->insert_id, $_POST['upfld_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	$__cnx->_clsr($Result);
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdUpFld")) {
	global $__cnx;

	$updateSQL = sprintf("UPDATE ".DBP.".".TB_UP_FLD." SET upfld_tt=%s, upfld_vl=%s, upfld_fk=%s, upfld_dte=%s, upfld_cnt=%s, upfld_mdl_cnt=%s, upfld_mdl_cnt_tra=%s, upfld_snd_ec_lsts_up=%s, upfld_snd_sms_cmpg_up=%s, upfld_ext_cnt=%s, upfld_ext_mdlcnt=%s, upfld_scl=%s WHERE upfld_enc =%s",

					GtSQLVlStr(ctjTx($_POST['upfld_tt'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['upfld_vl'],'out'), "text"),
					GtSQLVlStr(Html_chck_vl($_POST['upfld_fk']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['upfld_dte']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['upfld_cnt']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['upfld_mdl_cnt']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['upfld_mdl_cnt_tra']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['upfld_snd_ec_lsts_up']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['upfld_snd_sms_cmpg_up']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['upfld_ext_cnt']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['upfld_ext_mdlcnt']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['upfld_scl']), "int"),
					GtSQLVlStr(ctjTx($_POST['upfld_enc'],'out'), "text"));

	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['upfld_vl'], $_POST['id_upfld'], $_POST['upfld_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	}
	$__cnx->_clsr($Result);
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdUpFld'))) {
	global $__cnx;

	$deleteSQL = sprintf('DELETE FROM '.DBP.'.'.TB_UP_FLD.' WHERE upfld_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL);

	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['upfld_vl'], $_POST['uid'], $_POST['upfld_tt']), $rsp['v']);}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	$__cnx->_clsr($Result);
}
?>