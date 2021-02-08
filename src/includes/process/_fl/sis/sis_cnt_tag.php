<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisCntTag")) {
	
	$__Cl = new CRM_Cl(); 
	$__Cl->cnttag_nm = Php_Ls_Cln($_POST['siscnttag_nm']);
	$__Cl->cnttag_clr = Php_Ls_Cln($_POST['siscnttag_clr']);
	$PrcDt = $__Cl->ClCntTag_In(); 
	$rsp = $PrcDt;
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisCntTag")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_SIS_CNT_TAG." SET siscnttag_nm=%s, siscnttag_clr=%s WHERE siscnttag_enc=%s",
                       GtSQLVlStr(ctjTx($_POST['siscnttag_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['siscnttag_clr'],'out'), "text"),
					   GtSQLVlStr($_POST['siscnttag_enc'], "text"));
					   
	;
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(437, $_POST['siscnttag_nm'], $_POST['id_siscnttag']), $rsp['v']);
	}else{
		$rsp['rst'] = 'no';
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisCntTag'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_SIS_CNT_TAG.' WHERE siscnttag_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	$rsp['a'] = Aud_Sis(Aud_Dsc(438, $_POST['siscnttag_nm'], $_POST['id_siscnttag']), $rsp['v']); 
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>