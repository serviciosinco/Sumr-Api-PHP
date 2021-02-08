<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdPlnCmp")) { 
	$__enc = Enc_Rnd($_POST['plncmp_cod'].'- Campaña');
	$insertSQL = sprintf("INSERT INTO ".TB_PLN_CMP." ( plncmp_enc, plncmp_md, plncmp_slc, plncmp_est, plncmp_cod, plncmp_url, plncmp_obj, plncmp_dsc ) 
						VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)",
						GtSQLVlStr(ctjTx($__enc,'out'), "text"),
						GtSQLVlStr($_POST['plncmp_md'], "int"),
						GtSQLVlStr($_POST['plncmp_slc'], "int"),
						GtSQLVlStr($_POST['plncmp_est'], "int"),
						GtSQLVlStr(ctjTx($_POST['plncmp_cod'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_url'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_obj'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_dsc'],'out'), "text"));		
	
	$Result = $__cnx->_prc($insertSQL);
	if($Result){
		$rsp['i'] = $__enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(418, $_POST['siscd_tt'], $__cnx->c_p->insert_id), $rsp['v']);
		
		$tp = GtMdlSTpDt([ 'tp'=>$_POST['t2'] ]);

		$insertSQLTP = sprintf("INSERT INTO ".TB_PLN_CMP_TP." ( plncmptp_plncmp, plncmptp_tp ) 
						VALUES ( %s, %s )",
						GtSQLVlStr($__cnx->c_p->insert_id, "int"),
						GtSQLVlStr($tp->id, "int"));	
		$Result = $__cnx->_prc($insertSQLTP);
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['ms'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdPlnCmp")) { 
$updateSQL = sprintf("UPDATE ".TB_PLN_CMP." SET plncmp_md=%s, plncmp_slc=%s, plncmp_est=%s, plncmp_aprb=%s, plncmp_aprb_us=%s, plncmp_cod=%s, plncmp_url=%s, plncmp_obj=%s, plncmp_dsc=%s, plncmp_f_str=%s, plncmp_f_end=%s, plncmp_prs=%s, plncmp_utl=%s, plncmp_pay=%s, plncmp_dsc_dmg=%s, plncmp_dsc_psc=%s, plncmp_rsl_exp=%s, plncmp_rsl_clck=%s, plncmp_rsl_alcn=%s, plncmp_gst=%s, plncmp_gst_fnl=%s, plncmp_obs=%s WHERE plncmp_enc=%s",
						GtSQLVlStr($_POST['plncmp_md'], "int"),
                        GtSQLVlStr($_POST['plncmp_slc'], "int"),
                        GtSQLVlStr($_POST['plncmp_est'], "int"),
                        GtSQLVlStr($_POST['plncmp_aprb'], "int"),
                        GtSQLVlStr(ctjTx($_POST['plncmp_aprb_us'],'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['plncmp_cod'],'out'), "text"),
					    GtSQLVlStr(ctjTx($_POST['plncmp_url'],'out'), "text"),
					    GtSQLVlStr(ctjTx($_POST['plncmp_obj'],'out'), "text"),
					    GtSQLVlStr(ctjTx($_POST['plncmp_dsc'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_f_str'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_f_end'],'out'), "text"),	
						GtSQLVlStr(ctjTx($_POST['plncmp_prs'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_utl'],'out'), "text"),
						GtSQLVlStr($_POST['plncmp_pay'], "int"),	
						GtSQLVlStr(ctjTx($_POST['plncmp_dsc_dmg'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_dsc_psc'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_rsl_exp'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_rsl_clck'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_rsl_alcn'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_gst'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_gst_fnl'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_obs'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['plncmp_enc'],'out'), "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['sm'] = $updateSQL;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(419, $_POST['siscd_tt'], $_POST['id_siscd']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		$rsp['sm'] = $updateSQL;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}
?>