<?php 

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdConCrrFle")) { 
	
	$updateSQL = sprintf("UPDATE ".MDL_EMP_OFR_FLE_BD." SET ofrfle_dsc=%s, ofrfle_fe=%s, ofrfle_fa=%s WHERE id_ofrfle=%s",
						GtSQLVlStr(ctjTx($_POST['ofrfle_dsc'],'out'), "text"),
						GtSQLVlStr($_POST['ofrfle_fe'], "date"),
						GtSQLVlStr(SIS_F, "date"),
					    GtSQLVlStr($_POST['id_ofrfle'], "int"));
					   
	;
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(47, $_POST['id_ofrfle']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_ofrfle'])) && ($_POST['id_ofrfle'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdConCrrFle'))) { 
	$deleteSQL = sprintf('DELETE FROM '.MDL_EMP_OFR_FLE_BD.' WHERE ofrfle_enc=%s', GtSQLVlStr($_POST['ofrfle_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(48, $_POST['id_ofrfle']), $rsp['v']); }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>