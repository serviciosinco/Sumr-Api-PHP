<?php

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdAtmt")) {

	$__enc = Enc_Rnd($_POST['atmt_nm'].'-'.$_POST['atmt_cl'].'-'.SISUS_ID);

	$insertSQL = sprintf("INSERT INTO "._BdStr(DBA).TB_ATMT." (atmt_enc, atmt_cl, atmt_nm, atmt_sndr, atmt_on, atmt_allmdl) VALUES (%s,(SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc=%s), %s, %s, %s, %s)",
				   GtSQLVlStr($__enc, "text"),
				   GtSQLVlStr(DB_CL_ENC, "text"),
				   GtSQLVlStr(ctjTx($_POST['atmt_nm'],'out'), "text"),
				   GtSQLVlStr($_POST['atmt_sndr'], "int"),
				   GtSQLVlStr(!isN($_POST['atmt_on'])?$_POST['atmt_on']:2, "int"),
				   GtSQLVlStr(!isN($_POST['atmt_allmdl'])?$_POST['atmt_allmdl']:2, "int"));

	$Result = $__cnx->_prc($insertSQL); $rsp['q'] = $insertSQL;

	if($Result){
 		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		//_ErrSis(array('p'=>$insertSQL, 'd'=>$__cnx->c_p->error));
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdAtmt")) {

	if(!isN($_POST['atmt_on'])){ $__est = $_POST['atmt_on']; }else{ $__est = 2; }
	if(!isN($_POST['atmt_allmdl'])){ $__allmdl = $_POST['atmt_allmdl']; }else{ $__allmdl = 2; }

	$updateSQL = sprintf("UPDATE "._BdStr(DBA).TB_ATMT." SET atmt_nm=%s, atmt_on=%s, atmt_allmdl=%s, atmt_sndr=%s WHERE atmt_enc=%s",
	                    GtSQLVlStr(ctjTx($_POST['atmt_nm'],'out'), "text"),
						GtSQLVlStr($__est, "int"),
						GtSQLVlStr($__allmdl, "int"),
						GtSQLVlStr($_POST['atmt_sndr'], "int"),
						GtSQLVlStr($_POST['atmt_enc'], "text"));

	$Result = $__cnx->_prc($updateSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	}
}

// Elimino el Registro
if ((isset($_POST['id_atmt'])) && ($_POST['id_atmt'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdAtmt'))) {
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBA).TB_ATMT.' WHERE id_atmt=%s', GtSQLVlStr($_POST['id_atmt'], 'int'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	//$rsp['a'] = Aud_Sis(Aud_Dsc(258, $_POST['atmt_nm'], $_POST['id_atmt']), $rsp['v']);
	 }else{ $rsp['e'] = 'no'; $rsp['m'] = 2; _ErrSis(array('p'=>$deleteSQL, 'd'=>$__cnx->c_p->error)); $rsp['w'] = $__cnx->c_p->error;}
}
?>