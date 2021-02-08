<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisVstAplz")) {

		global $__cnx;

		$insertSQL = sprintf("INSERT INTO ".MDL_VST_APLZ_BD." (emaplz_nm) VALUES (%s)",
                       GtSQLVlStr(ctjTx($_POST['emaplz_nm'],'out'), "text"));

		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
			//$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(113, $_POST['emaplz_nm'], $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
		$__cnx->_clsr($Result);
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisVstAplz")) { 
	
	global $__cnx;
	
$updateSQL = sprintf("UPDATE ".MDL_VST_APLZ_BD." SET emaplz_nm=%s WHERE emaplz_enc=%s",	
                       GtSQLVlStr(ctjTx($_POST['emaplz_nm'],'out'), "text"),
					   GtSQLVlStr($_POST['emaplz_enc'], "text"));

	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(114, $_POST['emaplz_nm'], $_POST['id_emaplz']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	
	$__cnx->_clsr($Result);
}

// Elimino el Registro
if ((isset($_POST['id_emaplz'])) && ($_POST['id_emaplz'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisVstAplz'))) { 
	
	global $__cnx;
	
	$deleteSQL = sprintf('DELETE FROM '.MDL_VST_APLZ_BD.' WHERE emaplz_enc=%s', GtSQLVlStr($_POST['emaplz_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(115, $_POST['emaplz_nm'], $_POST['id_emaplz']), $rsp['v']); }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	
	$__cnx->_clsr($Result;
}
?>