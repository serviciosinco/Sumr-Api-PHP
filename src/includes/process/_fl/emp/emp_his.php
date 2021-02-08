<?php  
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEmpHis")) { 
		
		$insertSQL = sprintf("INSERT INTO ".MDL_EMP_HIS_BD." (emphis_emp, emphis_tp, emphis_dsc, emphis_us, emphis_fi, emphis_hi) VALUES (%s, %s, %s, %s, %s, %s)",
						GtSQLVlStr($_POST['emphis_emp'], "int"),
						GtSQLVlStr($_POST['emphis_tp'], "int"),
						GtSQLVlStr(ctjTx($_POST['emphis_dsc'],'out'), "text"),
						GtSQLVlStr(SISUS_ID, "int"),
						GtSQLVlStr(SIS_F, "date"),	
						GtSQLVlStr(SIS_H2, "date"));
					   		
		
		$Result = $__cnx->_prc($insertSQL);
		if($Result == 'ok'){		
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(362, 'Historial del evento contacto', $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $Result->w;
		}
}
// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEmpHis")) { 
	
	$updateSQL = sprintf("UPDATE ".MDL_EMP_HIS_BD." SET emphis_tp=%s, emphis_dsc=%s WHERE emphis_enc=%s",
						   GtSQLVlStr($_POST['emphis_tp'], "int"),
						   GtSQLVlStr(ctjTx($_POST['emphis_dsc'],'out'), "text"),
						   GtSQLVlStr($_POST['emphis_enc'], "text"));				   
	
	$Result = $__cnx->_prc($updateSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(363, 'Historial del evento contacto', $_POST['id_emphis']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Elimino el Registro
if ((isset($_POST["id_emphis"])) && ($_POST["id_emphis"] != "") && ((isset($_POST["MM_delete"]))&&($_POST["MM_delete"] == "EdEmpHis"))) { 
	$deleteSQL = sprintf("DELETE FROM ".MDL_EMP_HIS_BD." WHERE emphis_cnt=%s", GtSQLVlStr($_POST['emphis_cnt'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	if($Result){
		$rsp['e'] = 'ok'; 
		$rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(364, 'Historial del evento contacto', $_POST['id_emphis']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}

?>