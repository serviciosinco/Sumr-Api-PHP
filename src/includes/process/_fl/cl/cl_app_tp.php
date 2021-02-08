<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClAppTp")) { 
	
	$__Enc = Enc_Rnd($_POST['clapptp_clapp'].'-'.$_POST['clapptp_tt']);

	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_APP_TP." (clapptp_enc, clapptp_clapp, clapptp_tt, clapptp_lnk, clapptp_tp, clapptp_ord, clapptp_e, clapptp_fm) VALUES (%s, (SELECT id_clapp FROM "._BdStr(DBM).TB_CL_APP." WHERE clapp_enc=%s) , %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr($_POST['clapptp_clapp'], "text"),
                   GtSQLVlStr(ctjTx($_POST['clapptp_tt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['clapptp_lnk'],'out'), "text"),
                   GtSQLVlStr($_POST['clapptp_tp'], "int"),
                   GtSQLVlStr(ctjTx($_POST['clapptp_ord'],'out'), "text"),
                   GtSQLVlStr($_POST['clapptp_e'], "int"),
                   GtSQLVlStr($_POST['clapptp_fm'], "int"));			

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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClAppTp")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_APP_TP." SET clapptp_tt=%s, clapptp_lnk=%s, clapptp_tp=%s, clapptp_ord=%s, clapptp_e=%s, clapptp_fm=%s WHERE clapptp_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['clapptp_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clapptp_lnk'],'out'), "text"),
					   GtSQLVlStr($_POST['clapptp_tp'], "int"),
					   GtSQLVlStr(ctjTx($_POST['clapptp_ord'],'out'), "text"),
					   GtSQLVlStr($_POST['clapptp_e'], "int"),
					   GtSQLVlStr($_POST['clapptp_fm'], "int"),            
                       GtSQLVlStr($_POST['clapptp_enc'], "text"));
	
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

if ((isset($_POST['id_clapptp'])) && ($_POST['idclapptp'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClAppTp'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_CL_APP_TP.' WHERE clapptp_enc=%s', GtSQLVlStr($_POST['clapptp_enc'], 'text'));
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