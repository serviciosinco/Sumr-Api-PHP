<?php 

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisAud")) { 
	$insertSQL = sprintf("INSERT INTO ".MDL_SIS_AUD_BD." (audtx_dsc, obs_audtx, aud_cl, aud_tp) VALUES (%s, %s, %s, %s)",
					GtSQLVlStr(ctjTx($_POST['audtx_dsc'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['obs_audtx'],'out'), "text"),
					GtSQLVlStr($__dt_cl->id, "int"),
					GtSQLVlStr($_POST['aud_tp'], "int"));			
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(415, $_POST['audtx_dsc'], $__cnx->c_p->insert_id), $rsp['v']);

	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}




// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisAud")) { 
$updateSQL = sprintf("UPDATE ".MDL_SIS_AUD_BD." SET audtx_dsc=%s, obs_audtx=%s, aud_cl=%s, aud_tp=%s WHERE id_audtx=%s",
					   GtSQLVlStr(ctjTx($_POST['audtx_dsc'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['obs_audtx'],'out'), "text"),
					   GtSQLVlStr($__dt_cl->id, "int"),
					   GtSQLVlStr($_POST['aud_tp'], "int"),
					   GtSQLVlStr($_POST['id_audtx'], "int"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_audtx'])) && ($_POST['id_audtx'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisAud'))) { 
	$deleteSQL = sprintf('DELETE FROM '.MDL_SIS_AUD_BD.' WHERE id_audtx=%s', GtSQLVlStr($_POST['id_audtx'], 'int'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	$rsp['a'] = Aud_Sis(Aud_Dsc(417, $_POST['audtx_dsc'], $_POST['id_audtx']), $rsp['v']);
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>