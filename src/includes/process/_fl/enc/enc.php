<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEnc")) {
	
	$__enc = Enc_Rnd($_POST['enc_tt']);
	
	$insertSQL = sprintf("INSERT INTO ".TB_ENC." (enc_enc, enc_cl, enc_tt) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s)",
				   GtSQLVlStr($__enc, "text"),
				   GtSQLVlStr(CL_ENC, "text"),
				   GtSQLVlStr(ctjTx($_POST['enc_tt'],'out'), "text"));
				   		
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
	
		$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEnc")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_ENC." SET enc_tt=%s WHERE enc_enc=%s",
		               GtSQLVlStr(ctjTx($_POST['enc_tt'],'out'), "text"),
					   GtSQLVlStr($_POST['enc_enc'], "text"));
					   
	;
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
if ((isset($_POST['id_enc'])) && ($_POST['id_enc'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEnc'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_ENC.' WHERE enc_enc=%s', GtSQLVlStr($_POST['enc_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(281, 'Visita de la empresa', $_POST['id_enc']), $rsp['v']);
	}else{
		//$rsp['qry'] = $deleteSQL; 
		$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}
?>