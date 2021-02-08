<?php
	
	$__rlc_tp = 'ok';
	$__rlc_id = GtMdlSTpDt(['tp'=>$___Prc->mdlstp->tp]);

// Ingreso de Registro

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSmsTmpl")) { 
	
	global $__cnx;	
		
	$__enc = Enc_Rnd(DB_CL_ID.'-'.$_POST['sms_tt']);
	
	$insertSQL = sprintf("INSERT INTO ".TB_SMS." (sms_enc, sms_cl, sms_frm, sms_est, sms_tt, sms_key, sms_msj) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(DB_CL_ID, "text"),
                   GtSQLVlStr($_POST['sms_frm'], "int"),
                   GtSQLVlStr($_POST['sms_est'], "int"),
                   GtSQLVlStr(ctjTx($_POST['sms_tt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sms_key'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sms_msj'],'out'), "text"));	               

	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
			
		$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(514, $_POST['sms_tt'], $__cnx->c_p->insert_id), $rsp['v']);
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	
	$__cnx->_clsr($Result);
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSmsTmpl")) { 
	
	global $__cnx;
	
	$updateSQL = sprintf("UPDATE ".TB_SMS." SET sms_tt=%s, sms_frm=%s, sms_est=%s, sms_msj=%s, sms_key=%s WHERE sms_enc=%s",
						GtSQLVlStr(ctjTx($_POST['sms_tt'],'out'), "text"),
						GtSQLVlStr($_POST['sms_frm'], "int"),
						GtSQLVlStr($_POST['sms_est'], "int"),
						GtSQLVlStr(ctjTx($_POST['sms_msj'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['sms_key'],'out'), "text"),
						GtSQLVlStr($_POST['sms_enc'], "text"));
						
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(515, $_POST['sms_tt'], $_POST['id_sms']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	
	$__cnx->_clsr($Result);
	
}

// Elimino el Registro
if ((isset($_POST['id_sms'])) && ($_POST['id_sms'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSmsTmpl'))) { 
	
	global $__cnx;
	
	$deleteSQL = sprintf('DELETE FROM '.TB_SMS.' WHERE sms_enc=%s', GtSQLVlStr($_POST['sms_enc'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	 $rsp['a'] = Aud_Sis(Aud_Dsc(516, $_POST['sms_tt'], $_POST['id_sms']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2;  _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	 
	$__cnx->_clsr($Result);
}
?>