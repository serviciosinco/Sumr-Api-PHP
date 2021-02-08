<?php 

// Ingreso de Registro
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClBd")) { 
		
	$__Enc = Enc_Rnd($_POST['nm'].'- nm');
	
	
	$insertSQL = sprintf("INSERT INTO ".TB_SIS_BD." (sisbd_enc,sisbd_cl,sisbd_nm) VALUES (%s,(SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s),%s)",
	
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr(CL_ENC, "text"),
                   GtSQLVlStr($_POST['nm'], "text"));		 
	
	$Result = $__cnx->_prc($insertSQL); $rsp['w'] = $__cnx->c_p->error;
		
	if($Result){
			
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		$rsp['e'] = 'no';	 
		$rsp['m'] = 2;
		
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}
// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClBd")) { 
	
	
	$updateSQL = sprintf("UPDATE ".TB_SIS_BD."  SET sisbd_nm=%s  WHERE sisbd_enc = '%s' ",
	GtSQLVlStr($_POST['nm'], "text"),
	GtSQLVlStr($_POST['nm'], "text"));
  	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		
		$rsp['e'] = 'ok';		
		$rsp['m'] = 1;
	}else{
		$rsp['m'] = 2;
		$rsp['e'] = 'no';
		_ErrSis(['p'=>$updateSQL,'d'=>$__cnx->c_p->error]);
	} 
}

/*if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClFlj'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '.TB_CL_FLJ.' WHERE clflj_enc=%s',
	GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 

	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(417, $_POST['clare_dsc'], $_POST['id_clare']), $rsp['v']);
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'_cl_mnu' ]);
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}
*/

?>