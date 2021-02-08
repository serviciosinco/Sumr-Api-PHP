<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClDmnSub")) { 
	
	$__Enc = Enc_Rnd($_POST['cldmnsub_sub'].'- '.$_POST['cldmnsub_tp']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_DMN_SUB." (cldmnsub_enc, cldmnsub_cldmn, cldmnsub_sub, cldmnsub_tp) VALUES 
										(%s, (SELECT id_cldmn FROM "._BdStr(DBM).TB_CL_DMN." WHERE cldmn_enc = %s), %s, %s)",						
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['cldmnsub_cldmn'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['cldmnsub_sub'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['cldmnsub_tp'],'out'), "text"));			
				   
	
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClDmnSub")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_DMN_SUB." SET cldmnsub_sub=%s, cldmnsub_tp=%s WHERE cldmnsub_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['cldmnsub_sub'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['cldmnsub_tp'],'out'), "text"),
                       GtSQLVlStr($_POST['cldmnsub_enc'], "text"));
	
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

if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClDmnSub'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_CL_DMN_SUB.' WHERE cldmnsub_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
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