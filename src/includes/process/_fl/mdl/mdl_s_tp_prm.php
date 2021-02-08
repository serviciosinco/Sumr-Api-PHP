<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlsTpPrm")) { 	
	
	$__Cl = new CRM_Cl(); 
	
	$__Cl->mdlstpprm_nm = Php_Ls_Cln($_POST['mdlstpprm_nm']);
	$__Cl->mdlstpprm_tp = Php_Ls_Cln($_POST['mdlstpprm_tp']);
	$__Cl->mdlstpprm_mdlstp = Php_Ls_Cln($_POST['mdlstpprm_mdlstp']);
	$__Cl->mdlstpprm_vl = Php_Ls_Cln($_POST['mdlstpprm_vl']);
	
	$PrcDt = $__Cl->MdlSTpPrm_In(); 
	$rsp = $PrcDt;			
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlsTpPrm")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_MDL_S_TP_PRM." SET mdlstpprm_nm=%s, mdlstpprm_vl=%s, mdlstpprm_tp=%s, mdlstpprm_mdlstp=%s  WHERE mdlstpprm_enc=%s",
						GtSQLVlStr(ctjTx($_POST['mdlstpprm_nm'],'out'), "text"),
					    GtSQLVlStr(ctjTx($_POST['mdlstpprm_vl'],'out'), "text"),
						GtSQLVlStr($_POST['mdlstpprm_tp'], "int"),
						GtSQLVlStr($_POST['mdlstpprm_mdlstp'], "int"),
						GtSQLVlStr($_POST['mdlstpprm_enc'], "text"));
						
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(482, $_POST['mdlstpprm_nm'], $_POST['id_mdlstpprm']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_mdlstpprm'])) && ($_POST['id_mdlstpprm'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlsTpPrm'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_MDL_S_TP_PRM.' WHERE mdlstpprm_enc=%s', GtSQLVlStr($_POST['mdlstpprm_enc'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 $rsp['a'] = Aud_Sis(Aud_Dsc(483, $_POST['mdlstpprm_nm'], $_POST['id_mdlstpprm']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>