<?php 	
	
if($__t == 'psg_sms_cmpg' || $__t == 'prg_sms_cmpg' || $__t == 'con_sms_cmpg' || $__t == 'evn_sms_cmpg'){
	$__rlc_tp = 'ok';
	$__rlc_id = GtMdlSTpDt(['tp'=>$___Prc->mdlstp->tp]);
}
	
		
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSmsCmpg")) { 
	
		global $__cnx;
	
		if($_POST['smscmpg_lsts'] != ''){ $__lsts = $_POST['smscmpg_lsts']; }else{ $__lsts = 1; }
		if($_POST['smscmpg_sndr'] != ''){ $__sndr = $_POST['smscmpg_sndr']; }else{ $__sndr = 1; }

		$insertSQL = sprintf("INSERT INTO ".MDL_TB_SMS_CMPG_BD." (smscmpg_nm, smscmpg_msj, smscmpg_lsts, smscmpg_sndr, smscmpg_us, smscmpg_p_f, smscmpg_p_h) VALUES (%s, %s, %s, %s, %s, %s, %s)",
					   GtSQLVlStr(ctjTx($_POST['smscmpg_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['smscmpg_msj'],'out'), "text"),
					   GtSQLVlStr($__lsts, "int"),
					   GtSQLVlStr($__sndr, "int"),
					   GtSQLVlStr(SISUS_ID, "int"),
					   GtSQLVlStr($_POST['smscmpg_p_f'], "date"),
					   GtSQLVlStr($_POST['smscmpg_p_h'], "date"));

		$Result = $__cnx->_prc($insertSQL); //$rsp['w'] = $insertSQL.$__cnx->c_p->error;
 		
 		if($Result){
	 		
	 		$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(253, $_POST['eccmpg_nm'], $__cnx->c_p->insert_id), $rsp['v']);
				
				
				if($_POST['smscmpgctg_ctg'] != ''){
					$insertSQL = sprintf("INSERT INTO sms_cmpg_ctg (smscmpgctg_ctg, smscmpgctg_sms) VALUES (%s, %s)",
								   GtSQLVlStr($_POST['smscmpgctg_ctg'], "int"),
								   GtSQLVlStr($rsp['i'], "int"));				   	
					$Result = $__cnx->_prc($insertSQL);
				}
				
				if($_POST['smscmpg_lsts_sgm'] != ''){
					$insertSQL = sprintf("INSERT INTO ".MDL_TB_SMS_CMPG_SGM_BD." (smscmpgsgm_sgm, smscmpgsgm_cmpg) VALUES (%s, %s)",
								   GtSQLVlStr($_POST['smscmpg_lsts_sgm'], "int"),
								   GtSQLVlStr($rsp['i'], "int"));				   	
					$Result = $__cnx->_prc($insertSQL);
					//$rsp['w'] .= $insertSQL.$__cnx->c_p->error;
				}
				
				$updateSQL = sprintf("UPDATE ".MDL_TB_SMS_CMPG_BD." SET smscmpg_enc=%s WHERE id_smscmpg=%s",
						   GtSQLVlStr(enCad($rsp['i'].'-'.$_POST['smscmpg_nm']), "text"),
						   GtSQLVlStr($rsp['i'], "int"));				   	   
				$Result_UP = $__cnx->_prc($updateSQL);
				//$rsp['w'] .= $updateSQL.$__cnx->c_p->error;
				
				$insertSQL = sprintf("INSERT INTO ".MDL_TB_SMS_CMPG_TP_BD." (smscmpgtp_cmpg, smscmpgtp_tp) VALUES (%s, %s)",
							   GtSQLVlStr($rsp['i'], "int"),
							   GtSQLVlStr($__rlc_id->id, "int"));				   	
				$Result = $__cnx->_prc($insertSQL);
				
				$__cnx->_clsr($Result);
				
				
		}else{
			$rsp['rst'] = $__cnx->c_p->error;
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSmsCmpg")) { 
	
	global $__cnx;
	
	$updateSQL = sprintf("UPDATE ".MDL_TB_SMS_CMPG_BD." SET smscmpg_nm=%s, smscmpg_msj=%s, smscmpg_p_f=%s, smscmpg_p_h=%s WHERE smscmpg_enc=%s",						
	                    GtSQLVlStr(ctjTx($_POST['smscmpg_nm'],'out'), "text"),
	                    GtSQLVlStr(ctjTx($_POST['smscmpg_msj'],'out'), "text"),
						GtSQLVlStr($_POST['smscmpg_p_f'], "date"),
					    GtSQLVlStr($_POST['smscmpg_p_h'], "date"),
						GtSQLVlStr($_POST['smscmpg_enc'], "text"));

	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['i'] = $_POST['id_smscmpg'];
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(254, $_POST['eccmpg_nm'], $_POST['id_eccmpg']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	$__cnx->_clsr($Result);
}

// Elimino el Registro
if ((isset($_POST['id_smscmpg'])) && ($_POST['id_smscmpg'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSmsCmpg'))) { 
	
	global $__cnx;
	
	$deleteSQL = sprintf('DELETE FROM '.MDL_TB_SMS_CMPG_BD.' WHERE smscmpg_enc=%s', GtSQLVlStr($_POST['smscmpg_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	}else{ $rsp['e'] = 'no'; $rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	$__cnx->_clsr($Result);
}


// Pausa de estado
if ((isset($_POST["MMM_update_est"])) && ($_POST["MMM_update_est"] == "EdSmsCmpg")) { 
	
	global $__cnx;
	
	$updateSQL = sprintf("UPDATE ".MDL_TB_SMS_CMPG_BD." SET smscmpg_est=%s WHERE id_smscmpg=%s",						
						GtSQLVlStr($_POST['smscmpg_est'], "int"),
						GtSQLVlStr($_POST['id_smscmpg'], "int"));
    
    $__est_dt = GtSmsCmpgEstDt($_POST['smscmpg_est']);
    
	$Result = $__cnx->_prc($updateSQL); 

	$rsp['o'] = __AutoRUN([ 't'=>'snd', 's2'=>'sms' ]);
	
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['est'] = $__est_dt;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(255, $_POST['eccmpg_nm'], $_POST['id_eccmpg']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['qr'] = $updateSQL;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	$__cnx->_clsr($Result);
}



?>