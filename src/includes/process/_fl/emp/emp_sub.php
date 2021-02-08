<?php 


// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEmpSub")) {
		$insertSQL = sprintf("INSERT INTO ".MDL_EMP_SUB_BD." (id_empsub, empsub_nit, empsub_rs, empsub_cd, empsub_dir, empsub_fnt, empsub_cls, empsub_est, empsub_sec, empsub_fac, empsub_faccnc, empsub_scec, empsub_ofr, empsub_fi, empsub_emp) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					   GtSQLVlStr($_POST['id_empsub'], "int"),
					   GtSQLVlStr($_POST['empsub_nit'], "text"),
					   GtSQLVlStr(ctjTx($_POST['empsub_rs'],'out'), "text"),
                       GtSQLVlStr($_POST['empsub_cd'], "int"),
					   GtSQLVlStr(ctjTx($_POST['empsub_dir'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['empsub_fnt'],'out'), "text"),
					   GtSQLVlStr($_POST['empsub_cls'], "int"),
					   GtSQLVlStr($_POST['empsub_est'], "int"),
					   GtSQLVlStr(ctjTx($_POST['empsub_sec'],'out'), "text"),
					   GtSQLVlStr(ctjMlt($_POST['empsub_fac']), "text"),
					   GtSQLVlStr(ctjMlt($_POST['empsub_faccnc']), "text"),
					   GtSQLVlStr(ctjMlt($_POST['empsub_scec']), "text"),
					   GtSQLVlStr(ctjMlt($_POST['empsub_ofr']), "text"),
					   GtSQLVlStr(SIS_F, "date"),
					   GtSQLVlStr($_POST['empsub_emp'], "int"));
		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$_dt_emp = GtEmpDt($_POST['empsub_emp']);
			$rsp['cl'] = " __NxtEmpSub('nxt_cnt', '".$_dt_emp->tot_sub."'); ";
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $insertSQL.' - '.$__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEmpSub")) { 
	
	$updateSQL = sprintf("UPDATE ".MDL_EMP_SUB_BD." SET empsub_nit=%s, empsub_rs=%s, empsub_cd=%s, empsub_dir=%s, empsub_fnt=%s, empsub_cls=%s, 
empsub_est=%s, empsub_sec=%s, empsub_fac=%s, empsub_faccnc=%s, empsub_scec=%s, empsub_ofr=%s, empsub_fa=%s, empsub_emp=%s WHERE empsub_enc=%s",
					   GtSQLVlStr($_POST['empsub_nit'], "text"),
                       GtSQLVlStr(ctjTx($_POST['empsub_rs'],'out'), "text"),
                       GtSQLVlStr($_POST['empsub_cd'], "int"),
                       GtSQLVlStr(ctjTx($_POST['empsub_dir'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empsub_fnt'],'out'), "text"),
					   GtSQLVlStr($_POST['empsub_cls'], "int"),
					   GtSQLVlStr($_POST['empsub_est'], "int"),
					   GtSQLVlStr(ctjTx($_POST['empsub_sec'],'out'), "text"),
					   GtSQLVlStr(ctjMlt($_POST['empsub_fac']), "text"),
					   GtSQLVlStr(ctjMlt($_POST['empsub_faccnc']), "text"),
					   GtSQLVlStr(ctjMlt($_POST['empsub_scec']), "text"),
					   GtSQLVlStr(ctjMlt($_POST['empsub_ofr']), "text"),
					   GtSQLVlStr(SIS_F, "date"),
					   GtSQLVlStr($_POST['empsub_emp'], "int"),
					   GtSQLVlStr($_POST['empsub_enc'], "text"));
					   
	;
	$Result = $__cnx->_prc($updateSQL); $rsp['w'] = $__cnx->c_p->error;
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$_dt_emp = GtEmpDt($_POST['empsub_emp']);
		$rsp['cl'] = " __NxtEmpSub('nxt_cnt', '".$_dt_emp->tot_sub."'); ";
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_empsub'])) && ($_POST['id_empsub'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEmpSub'))) { 
	$deleteSQL = sprintf('DELETE FROM '.MDL_EMP_SUB_BD.' WHERE empsub_enc=%s', GtSQLVlStr($_POST['empsub_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['cl'] = " __NxtEmpSub('nxt_cnt', '".$_dt_emp->tot_sub."');"; }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>