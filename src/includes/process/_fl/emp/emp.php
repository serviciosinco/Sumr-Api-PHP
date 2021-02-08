<?php 
	
	$emps_url = filter_var($_POST['emp_web'], FILTER_VALIDATE_URL);
	
	if($emps_url){ 
		$__url_vld = filter_var($emps_url, FILTER_SANITIZE_URL);
	}
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEmp")) {
	if($_POST['emp_ps'] == 57){  $_vld_nt_my = 9; $_vld_nt_mn = 11; }else{ $_vld_nt_my = 1; $_vld_nt_mn = 20; }
	
	if( strlen( $_POST['emp_nit'] ) == 10 ){
		
		
		$__Fll = new CRM_Fll();
		$__Fll->c_dmn = $_POST['emp_web'];
		$__Sve = $__Fll->sve();
			
		$insertSQL = sprintf("INSERT INTO ".MDL_EMP_BD." (emp_ps, emp_nit, emp_rs, emp_cd, emp_dir, emp_fnt, emp_web, emp_est, emp_sct, emp_scec, emp_ofr, emp_clr, emp_fi) VALUES (%s, %s, %s, %s, %s, %s,  %s, %s, %s, %s, %s, %s, %s)",
					   GtSQLVlStr($_POST['emp_ps'], "int"),
					   GtSQLVlStr($_POST['emp_nit'], "text"),
					   GtSQLVlStr(ctjTx(MyMn($_POST['emp_rs']),'out'), "text"),
                       GtSQLVlStr($_POST['emp_cd'], "int"),
					   GtSQLVlStr(ctjTx($_POST['emp_dir'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['emp_fnt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($emps_url,'out'), "text"),
					   GtSQLVlStr($_POST['emp_est'], "int"),
					   GtSQLVlStr(ctjTx($_POST['emp_sct'],'out'), "text"),
					   GtSQLVlStr(ctjMlt($_POST['emp_scec']), "text"),
					   GtSQLVlStr(ctjMlt($_POST['emp_ofr']), "text"),
					   GtSQLVlStr(ctjMlt($_POST['emp_clr']), "text"),
					   GtSQLVlStr(SIS_F, "date"));

		
		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = $__Fll->c_dmn = $_POST['emp_web'];
			/*$_dt_emp = GtEmpDt($_POST['emp_emp']);
			$rsp['cl'] = " __NxtEmp('nxt_cnt', '".$_dt_emp->tot_sub."'); ";*/
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $insertSQL.' - '.$__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
	
	}else{
		
		$rsp['e'] = 'no';
		$rsp['m'] = 10;
				
	}	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEmp")) { 
	
	if($_POST['emp_ps'] == 57){  $_vld_nt_my = 9; $_vld_nt_mn = 11; }else{ $_vld_nt_my = 1; $_vld_nt_mn = 20; }
		
	if( strlen( $_POST['emp_nit'] ) == 10 ){
		
		$__Fll = new CRM_Fll();
		$__Fll->c_dmn = $_POST['emp_web'];
		$__Sve = $__Fll->sve();
		
		$updateSQL = sprintf("UPDATE ".MDL_EMP_BD." SET emp_ps=%s, emp_nit=%s, emp_rs=%s, emp_cd=%s, emp_dir=%s, emp_fnt=%s, emp_web=%s,  
		emp_est=%s, emp_sct=%s, emp_scec=%s, emp_ofr=%s, emp_fa=%s, emp_clr=%s WHERE emp_enc=%s",
							   GtSQLVlStr($_POST['emp_ps'], "int"),
							   GtSQLVlStr($_POST['emp_nit'], "text"),
		                       GtSQLVlStr(ctjTx( MyMn($_POST['emp_rs']) ,'out'), "text"),
		                       GtSQLVlStr($_POST['emp_cd'], "int"),
		                       GtSQLVlStr(ctjTx($_POST['emp_dir'],'out'), "text"),
							   GtSQLVlStr(ctjTx($_POST['emp_fnt'],'out'), "text"),
							   GtSQLVlStr(ctjTx($emps_url,'out'), "text"),
							   GtSQLVlStr($_POST['emp_est'], "int"),
							   GtSQLVlStr(ctjTx($_POST['emp_sct'],'out'), "text"),
							   GtSQLVlStr(ctjMlt($_POST['emp_scec']), "text"),
							   GtSQLVlStr(ctjMlt($_POST['emp_ofr']), "text"),
							   GtSQLVlStr(SIS_F, "date"),
							   GtSQLVlStr($_POST['emp_clr'], "text"),
							   GtSQLVlStr($_POST['emp_enc'], "text"));
		
		$Result = $__cnx->_prc($updateSQL); //$rsp['w'] = $__cnx->c_p->error;
		
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_ORG_MOD'), "db"=>$__t, "post"=>$_POST]);
			
			//$rsp['a'] = Aud_Sis(Aud_Dsc(30, $_POST['emp_nit'],  $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		} 
	
	}else{
		
		$rsp['e'] = 'no';
		$rsp['m'] = 10;
				
	}	
}

// Elimino el Registro
if ((isset($_POST['id_emp'])) && ($_POST['id_emp'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEmp'))) { 
	$deleteSQL = sprintf('DELETE FROM '.MDL_EMP_BD.' WHERE emp_enc=%s', GtSQLVlStr($_POST['emp_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['cl'] = " __NxtEmp('nxt_cnt', '".$_dt_emp->tot_sub."');"; $rsp['a'] = Aud_Sis(Aud_Dsc(31, $_POST['emp_nit'], $__cnx->c_p->insert_id), $rsp['v']); }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>