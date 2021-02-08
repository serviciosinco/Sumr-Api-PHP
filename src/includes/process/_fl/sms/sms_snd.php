<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSmsSnd")) { 
	
	$smsCmpgDt = smsCmpgDt($_POST['id_cmpg']);

	$_chk = new CRM_Cnt_Up();
	$_chk->sms_cmpg_id = $_POST["id_cmpg"];
	$_chk->sms_cmpg_us = SISUS_ID;
	$_chk->sms_cmpg_msj = $_POST['smssnd_msj'];
	$_chk->smssnd_cel = $_POST['smssnd_cel'];
	$_chk->sms_cmpg_f = $smsCmpgDt->cmpg_f;
	$_chk->sms_cmpg_h = $smsCmpgDt->cmpg_h;
	$_chk->Run();
	
	
	if($_chk->hb != 'no'){
		
		$__CntIn = new CRM_Cnt();
		$__CntIn->sms_cmpg_id = $_chk->sms_cmpg_id;
		$__CntIn->sms_cmpg_us = SISUS_ID;
		$__CntIn->sms_cmpg_msj = $_chk->sms_cmpg_msj;
		$__CntIn->smssnd_cel = $_chk->smssnd_cel;
		$__CntIn->sms_cmpg_f = $smsCmpgDt->cmpg_f;
		$__CntIn->sms_cmpg_h = $smsCmpgDt->cmpg_h;
		
		if($_chk->sms_cmpg_id != NULL){
			$PrcDt = $__CntIn->InSmsCmpg();
		}	
	}

	if($PrcDt->e == 'ok'){
			$rsp['i'] = $PrcDt->i;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $PrcDt->w;
			$rsp['i'] = $PrcDt->i;
			_ErrSis(['p'=>$insertSQL, 'd'=>$PrcDt->w]);
		}
	
		
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSmsSnd")) { 
	
	global $__cnx;
	
	$updateSQL = sprintf("UPDATE ".TB_SMS_SND." SET smssnd_cel=%s, smssnd_msj=%s WHERE id_smssnd=%s",
						GtSQLVlStr(ctjTx($_POST['smssnd_cel'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['smssnd_msj'],'out'), "text"),
						GtSQLVlStr($_POST['id_smssnd'], "int"));
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(503, $_POST['sisrlg_tt'], $_POST['id_sisrlg']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_smssnd'])) && ($_POST['id_smssnd'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSmsSnd'))) { 
	
	global $__cnx;
	
	$deleteSQL = sprintf('DELETE FROM '.TB_SMS_SND.' WHERE id_smssnd=%s', GtSQLVlStr($_POST['id_smssnd'], 'int'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 //$rsp['a'] = Aud_Sis(Aud_Dsc(504, $_POST['sisrlg_tt'], $_POST['id_sisrlg']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>