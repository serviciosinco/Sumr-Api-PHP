<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClApp")) { 
	
	$__Enc = Enc_Rnd($_POST['clapp_cl'].'-'.$_POST['clapp_tt']);
	
	if(!isN($_POST['clapp_dir'])){ $_dir = $_POST['clapp_dir']; }else{ $_dir = SIS_Y.'_'.$__Enc; }

	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_APP." (clapp_enc, clapp_cl, clapp_dir, clapp_tt, clapp_pml, clapp_e, clapp_stup_act, clapp_stup_csfle) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr($_POST['clapp_cl'], "text"),
				   GtSQLVlStr(ctjTx($_dir,'out'), "text"),  
				   GtSQLVlStr(ctjTx($_POST['clapp_tt'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['clapp_pml'],'out'), "text"),
                   GtSQLVlStr($_POST['clapp_e'], "int"),
				   GtSQLVlStr( (!isN($_POST['clapp_stup_act'])?$_POST['clapp_stup_act']:2 ), "int"),
				   GtSQLVlStr($_POST['clapp_stup_csfle'], "int"));
				   
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClApp")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_APP." SET clapp_tt=%s, clapp_pml=%s, clapp_cl=%s, clapp_e=%s, clapp_stup_act=%s, clapp_stup_csfle=%s WHERE clapp_enc=%s",	
					   GtSQLVlStr(ctjTx($_POST['clapp_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clapp_pml'],'out'), "text"),
					   GtSQLVlStr($_POST['clapp_cl'], "int"),
					   GtSQLVlStr($_POST['clapp_e'], "int"),
					   GtSQLVlStr($_POST['clapp_stup_act'], "int"), 
					   GtSQLVlStr($_POST['clapp_stup_csfle'], "int"),       
                       GtSQLVlStr($_POST['clapp_enc'], "text"));
	

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


if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClApp'))) { 
	$deleteSQL = sprintf('DELETE FROM ' ._BdStr(DBM).TB_CL_APP. ' WHERE clapp_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	 
	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(417, $_POST['clare_dsc'], $_POST['id_clare']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}

?>