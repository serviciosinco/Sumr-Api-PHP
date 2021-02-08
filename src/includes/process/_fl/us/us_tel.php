<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdUsTel")) {
	
	$__dt_us = GtUsDt($_POST['ustel_us'], 'enc');

	$__enc = Enc_Rnd($_POST['ustel_tel'].'-'.$_POST['ustel_ext'].'-'.$__dt_us->id);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_US_TEL." (ustel_enc, ustel_tel, ustel_ext, ustel_us, ustel_ps, ustel_tp, ustel_dfl, ustel_ntf_sms, ustel_ntf_wthsp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr(ctjTx($_POST['ustel_tel'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['ustel_ext'],'out'), "text"),
                       GtSQLVlStr($__dt_us->id, "int"),
                       GtSQLVlStr($_POST['ustel_ps'], "int"),
                       GtSQLVlStr($_POST['ustel_tp'], "int"),
					   GtSQLVlStr(_NoNll(Html_chck_vl($_POST['ustel_dfl'])), "int"),
					   GtSQLVlStr(!isN($_POST['ustel_ntf_sms'])?$_POST['ustel_ntf_sms']:2, "int"),
					   GtSQLVlStr(!isN($_POST['ustel_ntf_wthsp'])?$_POST['ustel_ntf_wthsp']:2, "int"));	
					   
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(460, $_POST['dnctp_tt'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	
	$__cnx->_clsr($Result);
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdUsTel")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US_TEL." SET ustel_tel=%s, ustel_ext=%s, ustel_ps=%s, ustel_tp=%s, ustel_dfl=%s, ustel_ntf_sms=%s, ustel_ntf_wthsp=%s WHERE ustel_enc=%s",
						GtSQLVlStr(ctjTx($_POST['ustel_tel'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ustel_ext'],'out'), "text"),
						GtSQLVlStr($_POST['ustel_ps'], "int"),
						GtSQLVlStr($_POST['ustel_tp'], "int"),
						GtSQLVlStr(_NoNll(Html_chck_vl($_POST['ustel_dfl'])), "int"),
						GtSQLVlStr($_POST['ustel_ntf_sms'], "int"),
						GtSQLVlStr($_POST['ustel_ntf_wthsp'], "int"),
						GtSQLVlStr($_POST['ustel_enc'], "text"));

	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(461, $_POST['sisexa_tt'], $_POST['id_sisexa']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	
	$__cnx->_clsr($Result);
	
}

// Elimino el Registro
if ((isset($_POST['id_ustel'])) && ($_POST['id_ustel'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdUsTel'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_US_TEL.' WHERE ustel_enc=%s', GtSQLVlStr($_POST['ustel_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		 //$rsp['a'] = Aud_Sis(Aud_Dsc(462, $_POST['dnctp_tt'], $_POST['id_dnctp']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	
	$__cnx->_clsr($Result);
	
}
?>