<?php 
$__tp_dt = GtMdlSTpDt(['tp'=>$___Prc->mdlstp->tp]);	

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdConCrrVst")) {

	if($_POST['empvst_f'] == null || $_POST['empvst_f'] == ''){
		$empvst_f='0000-00-00';	
	}else{ 
		$empvst_f = $_POST['empvst_f'];	
	}
	
	if($_POST['empvst_aplz'] != NULL){ $__qry_aplz = $_POST['empvst_aplz']; }else{ $__qry_aplz = 1; }
	
	

	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_VST_BD." ( id_empvst_tra, empvsttra_tra, empvsttra_vst, empvsttra_fi, empvsttra_fa) VALUES (%s, %s, %s, %s, %s)",
					GtSQLVlStr($_POST['id_empvst_tra'], "int"),
					GtSQLVlStr($_POST['empvsttra_tra'], "int"),
					GtSQLVlStr($_POST['empvsttra_vst'], "int"),
					GtSQLVlStr($_POST['empvsttra_fi'], "date"),
					GtSQLVlStr($_POST['empvsttra_fa'], "date"));
	
	
	$Result = $__cnx->_prc($insertSQL);
	if($Result){
		$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(279, 'Visita de la empresa', $__cnx->c_p->insert_id), $rsp['v']);
					$Result_UPD = $__cnx->_prc($updateSQL);
			$Result_tra = $__cnx->_prc($insertSQLtra);
		$_dt_cnt = GtCntCrrDt($_POST['empvst_cnt']);
		//$rsp['cl'] = " __NxtEmpSub('nxt_ofr', '".$_dt_cnt->emp->tot_vst."'); ";
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdConCrrVst")) { 
	
	$updateSQL = sprintf("UPDATE ".MDL_EMP_VST_BD." SET empvst_sistp=%s, empvst_us=%s, empvst_cnt=%s, empvst_va=%s, empvst_tp=%s, empvst_f=%s, empvst_h=%s, empvst_fr=%s, empvst_hr=%s, empvst_pln=%s, empvst_rxc=%s, empvst_rxc_est=%s, empvst_grn=%s, empvst_dir=%s, empvst_obs=%s, empvst_rsl=%s, empvst_aplz=%s, empvst_est=%s, empvst_ofr=%s, empvst_fi=%s, empvst_fa=%s WHERE empvst_enc=%s",
		               
		               GtSQLVlStr(ctjTx($_POST['empvst_sistp'],'out'), "text"),
		               GtSQLVlStr($_POST['empvst_us'], "int"),
		               GtSQLVlStr($_POST['empvst_cnt'], "int"),
		               GtSQLVlStr($_POST['empvst_va'], "int"),
		               GtSQLVlStr($_POST['empvst_tp'], "int"),
		               GtSQLVlStr($_POST['empvst_f'], "date"),
					   GtSQLVlStr($_POST['empvst_h'], "date"),
					   GtSQLVlStr($_POST['empvst_fr'], "date"),
					   GtSQLVlStr($_POST['empvst_hr'], "date"),
		               GtSQLVlStr( Html_chck_vl($_POST['empvst_pln']) , "int"),	
		               GtSQLVlStr( Html_chck_vl($_POST['empvst_rxc']), "int"),
		               GtSQLVlStr( Html_chck_vl($_POST['empvst_rxc_est']), "int"),
		               GtSQLVlStr( Html_chck_vl($_POST['empvst_grn']), "int"),
		               GtSQLVlStr( Html_chck_vl($_POST['empvst_dir']), "int"),
		               GtSQLVlStr(ctjTx($_POST['empvst_obs'],'out'), "text"),
		               GtSQLVlStr(ctjTx($_POST['empvst_rsl'],'out'), "text"),
		               GtSQLVlStr($_POST['empvst_aplz'], "int"),
		               GtSQLVlStr($_POST['empvst_est'], "int"),
		               GtSQLVlStr( Html_chck_vl($_POST['empvst_ofr']) , "int"),
		               GtSQLVlStr($_POST['empvst_fi'], "date"),
					   GtSQLVlStr($_POST['empvst_fa'], "date"),
					   GtSQLVlStr($_POST['empvst_enc'], "text"));	
					      
	
	//echo "--".$updateSQL;
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(280, 'Visita de la empresa', $_POST['id_empvst']), $rsp['v']);
		$_dt_cnt = GtCntCrrDt($_POST['empvst_cnt']);
		//$rsp['cl'] = " __NxtEmpSub('nxt_ofr', '".$_dt_cnt->emp->tot_vst."'); ";
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $updateSQL;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_empvst'])) && ($_POST['id_empvst'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdConCrrVst'))) { 
	$deleteSQL = sprintf('DELETE FROM '.MDL_EMP_VST_BD.' WHERE empvst_enc=%s', GtSQLVlStr($_POST['empvst_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	$rsp['a'] = Aud_Sis(Aud_Dsc(281, 'Visita de la empresa', $_POST['id_empvst']), $rsp['v']);
	
		//$rsp['cl'] = " __NxtEmpSub('_del'); ";
	
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>