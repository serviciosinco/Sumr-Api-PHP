<?php 	
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSndEcLstsSgm")) { 

	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_LSTS_SGM." (eclstssgm_enc, eclstssgm_nm, eclstssgm_lsts) VALUES (%s, %s, (SELECT id_eclsts FROM "._BdStr(DBM).TB_EC_LSTS." WHERE eclsts_enc=%s) )",
				   GtSQLVlStr(ctjTx(Enc_Rnd($_POST['eclstssgm_nm'].'-'.$_POST['eclstssgm_lsts']),'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['eclstssgm_nm'],'out'), "text"),
				   GtSQLVlStr($_POST['eclstssgm_lsts'], "text"));
				   	
	
	$Result = $__cnx->_prc($insertSQL); 
	

	if($Result){
 		
 		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		
		$rsp['w'] = $__cnx->c_p->error;
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSndEcLstsSgm")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_LSTS_SGM." SET eclstssgm_nm=%s WHERE eclstssgm_enc=%s",						
	                    GtSQLVlStr(ctjTx($_POST['eclstssgm_nm'],'out'), "text"),
						GtSQLVlStr($_POST['eclstssgm_enc'], "text"));
	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(263, $_POST['eclstssgm_nm'], $_POST['id_eclstssgm']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_eclstssgm'])) && ($_POST['id_eclstssgm'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSndEcLstsSgm'))) { 
	$deleteSQL = sprintf('DELETE FROM '.MDL_EC_LSTS_SGM_BD.' WHERE id_eclstssgm=%s', GtSQLVlStr($_POST['id_eclstssgm'], 'int'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	$rsp['a'] = Aud_Sis(Aud_Dsc(264, $_POST['eclstssgm_nm'], $_POST['id_eclstssgm']), $rsp['v']);
	}else{ $rsp['e'] = 'no'; $rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSndEcLstsSgm'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '.MDL_EC_LSTS_SGM_BD.' WHERE eclstssgm_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['eclstssgm_nm'], $_POST['uid'], $_POST['id_eclstssgm']), $rsp['v']);}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}

?>