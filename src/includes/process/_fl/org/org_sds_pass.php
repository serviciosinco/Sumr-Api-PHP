<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgSdsPass")) {
	
	$__enc = Enc_Rnd( $_POST['orgsdspass_pass']." - ".$_POST['orgsdspass_cl'] ); 
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_PASS." ( orgsdspass_enc, orgsdspass_cl, orgsdspass_orgsds, orgsdspass_est, orgsdspass_pass ) VALUES 
                                                                    ( %s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s ), %s, %s, %s )",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(CL_ENC, "text"),
                   GtSQLVlStr($_POST['orgsdspass_orgsds'], "int"),
                   GtSQLVlStr(Html_chck_vl($_POST['orgsdspass_est']), "int"),
				   GtSQLVlStr(ctjTx($_POST['orgsdspass_pass'],'out'), "text"));
	
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgSdsPass")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ORG_SDS_PASS." SET orgsdspass_orgsds=%s, orgsdspass_est=%s, orgsdspass_pass=%s
									                    WHERE orgsdspass_enc=%s ",
                                                    GtSQLVlStr($_POST['orgsdspass_orgsds'], "int"),
                                                    GtSQLVlStr(Html_chck_vl($_POST['orgsdspass_est']), "int"),
                                                    GtSQLVlStr(ctjTx($_POST['orgsdspass_pass'],'out'), "text"),
                                                    GtSQLVlStr($_POST['orgsdspass_enc'], "text"));
	;
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['rst'] = 'no';
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgSdsPass'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SDS_PASS." WHERE orgsdspass_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
    $Result = $__cnx->_prc($deleteSQL); 
    if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>