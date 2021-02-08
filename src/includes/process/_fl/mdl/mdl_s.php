<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlS")) { 
	
	$__enc = Enc_Rnd( $_POST['mdls_nm'].'-'.$_POST['mdlstp_nm'] ); 
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S." (mdls_enc, mdls_nm, mdls_cls, mdls_tp) VALUES (%s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr(ctjTx($_POST['mdls_nm'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdls_cls'],'out'), "text"),
                       GtSQLVlStr($_POST['mdls_tp'], "int"));	
                       	
	
	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;			
		$rsp['i'] = $__enc;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['er'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlS")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S." SET mdls_nm=%s, mdls_cls=%s, mdls_tp=%s  WHERE mdls_enc=%s",
						GtSQLVlStr(ctjTx($_POST['mdls_nm'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['mdls_cls'],'out'), "text"),
						GtSQLVlStr($_POST['mdls_tp'], "int"),
						GtSQLVlStr($_POST['mdls_enc'], "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(482, $_POST['mdls_nm'], $_POST['id_mdls']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlS'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_MDL_S." WHERE mdls_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 $rsp['a'] = Aud_Sis(Aud_Dsc(483, $_POST['mdls_nm'], $_POST['id_mdls']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>