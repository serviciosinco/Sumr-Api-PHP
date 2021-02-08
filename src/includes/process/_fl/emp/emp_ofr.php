<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEmpOfr")) {
		
		
		if($_POST['ofr_tp'] != NULL){ $__qry_tp = $_POST['ofr_tp']; }else{ $__qry_tp = 8; }
		if($_POST['ofr_cmp'] != NULL){ $__qry_cmp = $_POST['ofr_cmp']; }else{ $__qry_cmp = 3; }
		if($_POST['ofr_md'] != NULL){ $__qry_md = $_POST['ofr_md']; }else{ $__qry_md = 12; }
		if($_POST['ofr_est'] != NULL){ $__qry_est = $_POST['ofr_est']; }else{ $__qry_est = 5; }
		if($_POST['ofr_rch'] != NULL){ $__qry_rch = $_POST['ofr_rch']; }else{ $__qry_rch = 1; }
		
		$insertSQL = sprintf("INSERT INTO ".MDL_EMP_OFR_BD." (ofr_emp, ofr_fs, ofr_tt, ofr_tp, ofr_cmp, ofr_ord, ofr_ctlc, ofr_md, ofr_trm, ofr_csap, ofr_dsc, ofr_rch, ofr_obs, ofr_rtn, ofr_equ, ofr_est, ofr_fe, ofr_vlp, ofr_vla, ofr_avc, ofr_mdl, ofr_fi, ofr_fa) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						GtSQLVlStr($_POST['ofr_emp'], "int"),
						GtSQLVlStr($_POST['ofr_fs'], "date"),
						GtSQLVlStr(ctjTx($_POST['ofr_tt'],'out'), "text"),
						GtSQLVlStr($__qry_tp, "int"),
						GtSQLVlStr($__qry_cmp, "int"),
						GtSQLVlStr(ctjTx($_POST['ofr_ord'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_ctlc'],'out'), "text"),
						GtSQLVlStr($__qry_md, "int"),
						GtSQLVlStr(ctjTx($_POST['ofr_trm'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_csap'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_dsc'],'out'), "text"),
						GtSQLVlStr($__qry_rch, "int"),
						GtSQLVlStr(ctjTx($_POST['ofr_obs'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_rtn'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_equ'],'out'), "text"),
						GtSQLVlStr($__qry_est, "int"),
						GtSQLVlStr($_POST['ofr_fe'], "date"),
						GtSQLVlStr(ctjTx($_POST['ofr_vlp'],'out'), "double"),
						GtSQLVlStr(ctjTx($_POST['ofr_vla'],'out'), "double"),
						GtSQLVlStr(ctjTx($_POST['ofr_avc'],'out'), "double"),
						GtSQLVlStr(ctjMlt($_POST['ofr_mdl']), "text"),
						GtSQLVlStr(SIS_F, "date"),	
						GtSQLVlStr(SIS_F, "date"));
					   		
		
		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(274, $_POST['ofr_tt'], $__cnx->c_p->insert_id), $rsp['v']);
			$_dt_cnt = GtEmpDt($_POST['ofr_emp']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEmpOfr")) { 
$updateSQL = sprintf("UPDATE ".MDL_EMP_OFR_BD." SET ofr_emp=%s, ofr_fs=%s, ofr_tt=%s, ofr_tp=%s, ofr_cmp=%s, ofr_ord=%s, ofr_ctlc=%s, ofr_md=%s, ofr_trm=%s, ofr_csap=%s, ofr_dsc=%s, ofr_rch=%s, ofr_obs=%s, ofr_rtn=%s, ofr_equ=%s, ofr_est=%s, ofr_fe=%s, ofr_vlp=%s, ofr_vla=%s, ofr_avc=%s, ofr_mdl=%s, ofr_fa=%s WHERE ofr_enc=%s",
					   GtSQLVlStr($_POST['ofr_emp'], "int"),
						GtSQLVlStr($_POST['ofr_fs'], "date"),
						GtSQLVlStr(ctjTx($_POST['ofr_tt'],'out'), "text"),
						GtSQLVlStr($_POST['ofr_tp'], "int"),
						GtSQLVlStr(ctjTx($_POST['ofr_cmp'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_ord'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_ctlc'],'out'), "text"),
						GtSQLVlStr($_POST['ofr_md'], "int"),
						GtSQLVlStr(ctjTx($_POST['ofr_trm'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_csap'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_dsc'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_rch'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_obs'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_rtn'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['ofr_equ'],'out'), "text"),
						GtSQLVlStr($_POST['ofr_est'], "int"),
						GtSQLVlStr($_POST['ofr_fe'], "date"),
						GtSQLVlStr(ctjTx($_POST['ofr_vlp'],'out'), "double"),
						GtSQLVlStr(ctjTx($_POST['ofr_vla'],'out'), "double"),
						GtSQLVlStr(ctjTx($_POST['ofr_avc'],'out'), "double"),
						GtSQLVlStr(ctjMlt($_POST['ofr_mdl']), "text"),
						GtSQLVlStr(SIS_F, "date"),
					    GtSQLVlStr($_POST['ofr_enc'], "text"));
					   
	
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(275, $_POST['ofr_tt'], $_POST['id_ofr']), $rsp['v']);
		$_dt_cnt = GtEmpDt($_POST['ofr_emp']);
		//$rsp['cl'] = " __NxtEmpSub('last', '".$_dt_cnt->tot_ofr."'); ";
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_ofr'])) && ($_POST['id_ofr'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEmpOfr'))) { 
	$deleteSQL = sprintf('DELETE FROM '.MDL_EMP_OFR_BD.' WHERE ofr_enc=%s', GtSQLVlStr($_POST['ofr_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	$rsp['a'] = Aud_Sis(Aud_Dsc(276, $_POST['ofr_tt'], $_POST['id_ofr']), $rsp['v']);
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>