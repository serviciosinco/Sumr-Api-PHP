
<?php 	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEmpCnt")) {

		$insertSQL = sprintf("INSERT INTO ".TB_EMP_CNT." ( empcnt_emp, empcnt_nm, empcnt_ap, empcnt_cel, empcnt_tel, empcnt_ext, empcnt_depto, empcnt_obs, empcnt_crg, empcnt_mail) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
		               GtSQLVlStr($_POST['empcnt_emp'], "int"),	
                       GtSQLVlStr(ctjTx( MyMn($_POST['empcnt_nm']) ,'out'), "text"),
                       GtSQLVlStr(ctjTx( MyMn($_POST['empcnt_ap']) ,'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['empcnt_cel'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_tel'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_ext'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_depto'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_obs'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_crg'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_mail'],'out'), "text"));
					   		
		
		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(271, $_POST['empcnt_nm'], $__cnx->c_p->insert_id), $rsp['v']);
			//$_dt_cnt = GtEmpDt($_POST['empcnt_emp']);
			//$rsp['cl'] = " __NxtEmpSub('nxt_vst', '".$_dt_cnt->tot_cnt."'); ";
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['o'] = $insertSQL;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEmpCnt")) { 


	$updateSQL = sprintf("UPDATE ".TB_EMP_CNT." SET empcnt_emp=%s, empcnt_nm=%s, empcnt_ap=%s, empcnt_cel=%s, empcnt_tel=%s, empcnt_ext=%s, 
empcnt_depto=%s, empcnt_obs=%s, empcnt_crg=%s, empcnt_mail=%s WHERE empcnt_enc=%s",
					   GtSQLVlStr($_POST['empcnt_emp'], "int"),	
                       GtSQLVlStr(ctjTx( MyMn($_POST['empcnt_nm']) ,'out'), "text"),
                       GtSQLVlStr(ctjTx( MyMn($_POST['empcnt_ap']) ,'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['empcnt_cel'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_tel'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_ext'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_depto'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_obs'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_crg'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['empcnt_mail'],'out'), "text"),
					   GtSQLVlStr($_POST['empcnt_enc'], "text"));
					   
	
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(272, $_POST['empcnt_nm'], $_POST['id_empcnt']), $rsp['v']);
		//$_dt_cnt = GtEmpDt($_POST['empcnt_emp']);
		//$rsp['cl'] = " __NxtEmpSub('nxt_vst', '".$_dt_cnt->tot_cnt."'); ";
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_empcnt'])) && ($_POST['id_empcnt'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEmpCnt'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_EMP_CNT.' WHERE empcnt_enc=%s', GtSQLVlStr($_POST['empcnt_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	$rsp['a'] = Aud_Sis(Aud_Dsc(273, $_POST['empcnt_nm'], $_POST['id_empcnt']), $rsp['v']);
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>