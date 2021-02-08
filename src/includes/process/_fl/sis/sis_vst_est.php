<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdVstEst")) {

		global $__cnx;

		$insertSQL = sprintf("INSERT INTO ".MDL_VST_EST_BD." (vstest_nm) VALUES (%s)",	
                       GtSQLVlStr(ctjTx($_POST['vstest_nm'],'out'), "text"));

		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
			//$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(116, $_POST['vstest_nm'], $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_pmysqli->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		$__cnx->_clsr($Result);
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdVstEst")) { 
	
	global $__cnx;
	
	$updateSQL = sprintf("UPDATE ".MDL_VST_EST_BD." SET  vstest_nm=%s WHERE vstest_enc=%s",	
                       GtSQLVlStr(ctjTx($_POST['vstest_nm'],'out'), "text"),
					   GtSQLVlStr($_POST['vstest_enc'], "text"));

	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(117, $_POST['vstest_nm'], $_POST['id_vstest']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	$__cnx->_clsr($Result);
}

// Elimino el Registro
if ((isset($_POST['id_vstest'])) && ($_POST['id_vstest'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdVstEst'))) { 
	
	global $__cnx;
	
	$deleteSQL = sprintf('DELETE FROM '.MDL_VST_EST_BD.' WHERE vstest_enc=%s', GtSQLVlStr($_POST['vstest_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(118, $_POST['vstest_nm'], $_POST['id_vstest']), $rsp['v']); }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	$__cnx->_clsr($Result);
}
?>