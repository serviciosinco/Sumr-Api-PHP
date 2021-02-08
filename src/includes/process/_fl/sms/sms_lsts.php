<?php 	
if($__t == 'sms_lsts' || $__t == 'con_sms_lsts' || $__t == 'psg_sms_lsts' || $__t == 'prg_sms_lsts' || $__t == 'rose_sms_lsts' || $__t == 'sumr_sms_lsts' || $__t == 'evn_sms_lsts'){
	$__rlc_tp = 'ok';
	$__rlc_id = GtMdlSTpDt(['tp'=>$___Prc->mdlstp->tp]);
}
	
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSmsLsts")) { 

		global $__cnx;

		$insertSQL = sprintf("INSERT INTO ".MDL_SMS_LSTS_BD." (smslsts_nm, smslsts_frm, smslsts_rsgnup, smslsts_org, smslsts_sndr) VALUES (%s, %s, %s, %s, %s)",
					   GtSQLVlStr(ctjTx($_POST['smslsts_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['smslsts_frm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['smslsts_rsgnup'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['smslsts_org'],'out'), "text"),
					   GtSQLVlStr($_POST['smslsts_sndr'], "int"));

		$Result = $__cnx->_prc($insertSQL); $rsp['w'] = $__cnx->c_p->error;
 		
 		if($Result){
	 		
	 		$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(256, $_POST['lsts_nm'], $__cnx->c_p->insert_id), $rsp['v']);
				
				$insertSQL = sprintf("INSERT INTO ".MDL_SMS_LSTS_TP_BD." (smslststp_lsts, smslststp_tp) VALUES (%s, %s)",
							   GtSQLVlStr($rsp['i'], "int"),
							   GtSQLVlStr($__rlc_id->id, "int"));				   	
				$Result = $__cnx->_prc($insertSQL);
		
				$updateSQL = sprintf("UPDATE ".MDL_SMS_LSTS_BD." SET smslsts_enc=%s WHERE id_smslsts=%s",
						   GtSQLVlStr(enCad($rsp['i'].'-'.$_POST['smslsts_nm']), "text"),
						   GtSQLVlStr($rsp['i'], "int"));				   	   
				$Result_UP = $__cnx->_prc($updateSQL);
				
				
				$rsp['w'] = $__cnx->c_p->error;
				
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
		$__cnx->_clsr($Result); $__cnx->_clsr($Result_UP); 
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSmsLsts")) { 
	
	global $__cnx;
	
	$updateSQL = sprintf("UPDATE ".MDL_SMS_LSTS_BD." SET smslsts_enc=%s, smslsts_nm=%s, smslsts_frm=%s, smslsts_rsgnup=%s, smslsts_org=%s, smslsts_sndr=%s WHERE smslsts_enc=%s",						
	                    GtSQLVlStr(enCad($_POST['id_smslsts'].'-'.$_POST['smslsts_nm']), "text"),
	                    GtSQLVlStr(ctjTx($_POST['smslsts_nm'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['smslsts_frm'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['smslsts_rsgnup'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['smslsts_org'],'out'), "text"),
						GtSQLVlStr($_POST['smslsts_sndr'], "int"),
						GtSQLVlStr($_POST['smslsts_enc'], "text"));

	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(257, $_POST['eclsts_nm'], $_POST['id_eclsts']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	
	$__cnx->_clsr($Result);
}

// Elimino el Registro
if ((isset($_POST['id_smslsts'])) && ($_POST['id_smslsts'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSmsLsts'))) { 
	
	global $__cnx;
	
	$deleteSQL = sprintf('DELETE FROM '.MDL_SMS_LSTS_BD.' WHERE smslsts_enc=%s', GtSQLVlStr($_POST['smslsts_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	//$rsp['a'] = Aud_Sis(Aud_Dsc(258, $_POST['eclsts_nm'], $_POST['id_eclsts']), $rsp['v']);
	 }else{ $rsp['e'] = 'no'; $rsp['m'] = $__cnx->c_p->error; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	 
	$__cnx->_clsr($Result);
}
?>