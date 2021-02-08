<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClAppIcn")) { 
	
	$__Enc = Enc_Rnd($_POST['clappicn_clapp'].'-'.$_POST['clappicn_tt']);

	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_APP_ICN." (clappicn_enc, clappicn_clapp, clappicn_tt, clappicn_lnk, clappicn_icn, clappicn_ord, clappicn_e) VALUES (%s, (SELECT id_clapp FROM "._BdStr(DBM).TB_CL_APP." WHERE clapp_enc=%s) , %s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr($_POST['clappicn_clapp'], "text"),
                   GtSQLVlStr(ctjTx($_POST['clappicn_tt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['clappicn_lnk'],'out'), "text"),
                   GtSQLVlStr($_POST['clappicn_icn'], "int"),
                   GtSQLVlStr(ctjTx($_POST['clappicn_ord'],'out'), "text"),
                   GtSQLVlStr($_POST['clappicn_e'], "int"));			

	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClAppIcn")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_APP_ICN." SET clappicn_tt=%s, clappicn_lnk=%s, clappicn_icn=%s, clappicn_ord=%s, clappicn_e=%s WHERE clappicn_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['clappicn_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clappicn_lnk'],'out'), "text"),
					   GtSQLVlStr($_POST['clappicn_icn'], "int"),
					   GtSQLVlStr(ctjTx($_POST['clappicn_ord'],'out'), "text"),
					   GtSQLVlStr($_POST['clappicn_e'], "int"),            
                       GtSQLVlStr($_POST['clappicn_enc'], "text"));
	
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

if ((isset($_POST['id_clappicn'])) && ($_POST['idclappicn'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClAppIcn'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_CL_APP_ICN.' WHERE clappicn_enc=%s', GtSQLVlStr($_POST['clappicn_enc'], 'text'));
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