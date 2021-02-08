<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClDmn")) { 
	
	$__Enc = Enc_Rnd($_POST['cldmn_cl'].'-'.$_POST['cldmn_dmn']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_DMN." (cldmn_enc, cldmn_cl, cldmn_dmn) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr($_POST['cldmn_cl'], "text"),
                   GtSQLVlStr(ctjTx($_POST['cldmn_dmn'],'out'), "text"));			
				   
	
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClDmn")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_CL_DMN." SET cldmn_dmn=%s WHERE cldmn_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['cldmn_dmn'],'out'), "text"),
                       GtSQLVlStr($_POST['cldmn_enc'], "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

if ((isset($_POST['id_cldmn'])) && ($_POST['idcldmn'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClDmn'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_CL_DMN.' WHERE cldmn_enc=%s', GtSQLVlStr($_POST['cldmn_enc'], 'text'));
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


?>