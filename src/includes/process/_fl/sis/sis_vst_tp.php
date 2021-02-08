<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdVstTp")) {

		global $__cnx;

		$insertSQL = sprintf("INSERT INTO ".MDL_VST_TP_BD." (vsttp_nm) VALUES (%s)",	
                       GtSQLVlStr(ctjTx($_POST['vsttp_nm'],'out'), "text"));

		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
			//$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(119, $_POST['vsttp_nm'], $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
		$__cnx->_clsr($Result);
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdVstTp")) { 
	
	global $__cnx;
	
$updateSQL = sprintf("UPDATE ".MDL_VST_TP_BD." SET  vsttp_nm=%s WHERE vsttp_enc=%s",	
                       GtSQLVlStr(ctjTx($_POST['vsttp_nm'],'out'), "text"),
					   GtSQLVlStr($_POST['vsttp_enc'], "text"));

	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(120, $_POST['vsttp_nm'], $_POST['id_vsttp']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	
	$__cnx->_clsr($Result);
}

// Elimino el Registro
if ((isset($_POST['id_vsttp'])) && ($_POST['id_vsttp'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdVstTp'))) { 
	
	global $__cnx;
	
	$deleteSQL = sprintf('DELETE FROM '.MDL_VST_TP_BD.' WHERE vsttp_enc=%s', GtSQLVlStr($_POST['vsttp_enc'], 'int'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(121, $_POST['vsttp_nm'], $_POST['id_vsttp']), $rsp['v']); }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	
	$__cnx->_clsr($Result);
}
?>