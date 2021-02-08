<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisCntTp")) {
	
	$__Cl = new CRM_Cl(); 
	$__Cl->cnttp_nm = Php_Ls_Cln($_POST['siscnttp_nm']);
	$__Cl->cnttp_key = Php_Ls_Cln($_POST['siscnttp_key']);
	$__Cl->cnttp_grp = Php_Ls_Cln($_POST['siscnttp_grp']);
	$__Cl->cnttp_clr = Php_Ls_Cln($_POST['siscnttp_clr']);
	$PrcDt = $__Cl->ClCntTp_In(); 
	$rsp = $PrcDt;
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisCntTp")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_SIS_CNT_TP." SET siscnttp_nm=%s, siscnttp_grp = %s, siscnttp_key=%s, siscnttp_clr=%s WHERE siscnttp_enc=%s",
                       GtSQLVlStr(ctjTx($_POST['siscnttp_nm'],'out'), "text"),
                       GtSQLVlStr($_POST['siscnttp_grp'], "int"),
                       GtSQLVlStr(ctjTx($_POST['siscnttp_key'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['siscnttp_clr'],'out'), "text"),
					   GtSQLVlStr($_POST['siscnttp_enc'], "text"));
					   
	;
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(437, $_POST['siscnttp_nm'], $_POST['id_siscnttp']), $rsp['v']);
	}else{
		$rsp['rst'] = 'no';
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisCntTp'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_SIS_CNT_TP.' WHERE siscnttp_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	$rsp['a'] = Aud_Sis(Aud_Dsc(438, $_POST['siscnttp_nm'], $_POST['id_siscnttp']), $rsp['v']); 
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>