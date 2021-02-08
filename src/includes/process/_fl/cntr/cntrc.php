<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCntrc")) { 
	
	$__enc = Enc_Rnd( $_POST['cntrc_nm'].'-'.$_POST['cntrc_vrs'] ); 
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CNTRC." (cntrc_enc, cntrc_cl, cntrc_lgo, cntrc_nm, cntrc_vrs) VALUES (%s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($__dt_cl->id, "int"),
                       GtSQLVlStr(ctjTx($_POST['cntrc_lgo'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['cntrc_nm'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['cntrc_vrs'],'out'), "text"));	 
                       	
	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['er'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCntrc")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CNTRC." SET  cntrc_nm=%s, cntrc_vrs=%s WHERE cntrc_enc=%s",
                       GtSQLVlStr(ctjTx($_POST['cntrc_nm'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['cntrc_vrs'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['cntrc_enc'],'out'), "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['ms'] = $updateSQL;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdCntrc'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_CNTRC." WHERE cntrc_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 //$rsp['a'] = Aud_Sis(Aud_Dsc(483, $_POST['mdls_nm'], $_POST['id_mdls']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>