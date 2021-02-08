<?php 

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisCntEst")) {
	
	if( isN($_POST['siscntest_noi']) ){ $__est_noi = 2; }else{ $__est_noi = $_POST['siscntest_noi']; }
	if( isN($_POST['siscntest_buy']) ){ $__est_buy = 2; }else{ $__est_buy = $_POST['siscntest_buy']; }
	
	$__Cl = new CRM_Cl(); 
	$__Cl->cntest_tt = Php_Ls_Cln($_POST['siscntest_tt']);
	$__Cl->cntest_tp = Php_Ls_Cln($_POST['siscntest_tp']);
	$__Cl->cntest_dsc = Php_Ls_Cln($_POST['siscntest_dsc']);
	$__Cl->cntest_clr_bck = Php_Ls_Cln($_POST['siscntest_clr_bck']);
	$__Cl->cntest_clr_fnt = Php_Ls_Cln($_POST['siscntest_clr_fnt']);
	$__Cl->cntest_noi = $__est_noi;
	$__Cl->cntest_buy = $__est_buy;
	$__Cl->cntest_usnvl = Php_Ls_Cln($_POST['siscntest_usnvl']);
	$__Cl->cntest_asis = Php_Ls_Cln($_POST['siscntest_asis']);

	$__Cl->cntest_tra_archv = Php_Ls_Cln($_POST['siscntest_tra_archv']);
	$__Cl->cntest_tra_cncl = Php_Ls_Cln($_POST['siscntest_tra_cncl']);
	$__Cl->cntest_tra_cmpl = Php_Ls_Cln($_POST['siscntest_tra_cmpl']);
	$__Cl->cntest_tra_eli = Php_Ls_Cln($_POST['siscntest_tra_eli']);
	$__Cl->cntest_tra_prc = Php_Ls_Cln($_POST['siscntest_tra_prc']);

	$PrcDt = $__Cl->ClCntEst_In(); 
	$rsp = $PrcDt;
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisCntEst")) { 
	
	if( isN($_POST['siscntest_noi']) ){ $__est_noi = 2; }else{ $__est_noi = $_POST['siscntest_noi']; }
	if( isN($_POST['siscntest_buy']) ){ $__est_buy = 2; }else{ $__est_buy = $_POST['siscntest_buy']; }

	if( isN($_POST['siscntest_tra_archv']) ){ $__est_tra_archv = 2; }else{ $__est_tra_archv = $_POST['siscntest_tra_archv']; }
	if( isN($_POST['siscntest_tra_cncl']) ){ $__est_tra_cncl = 2; }else{ $__est_tra_cncl = $_POST['siscntest_tra_cncl']; }
	if( isN($_POST['siscntest_tra_cmpl']) ){ $__est_tra_cmpl = 2; }else{ $__est_tra_cmpl = $_POST['siscntest_tra_cmpl']; }
	if( isN($_POST['siscntest_tra_eli']) ){ $__est_tra_eli = 2; }else{ $__est_tra_eli = $_POST['siscntest_tra_eli']; }
	if( isN($_POST['siscntest_tra_prc']) ){ $__est_tra_prc = 2; }else{ $__est_tra_prc = $_POST['siscntest_tra_prc']; }
	

	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_CNT_EST." SET siscntest_tt=%s, siscntest_clr_bck=%s, siscntest_clr_fnt=%s, siscntest_noi=%s, siscntest_buy=%s, siscntest_dsc=%s, siscntest_tp=%s, siscntest_usnvl=%s, siscntest_asis=%s, siscntest_tra_archv=%s, siscntest_tra_cncl=%s, siscntest_tra_cmpl=%s, siscntest_tra_eli=%s, siscntest_tra_prc=%s WHERE siscntest_enc=%s",
                       	GtSQLVlStr(ctjTx($_POST['siscntest_tt'],'out'), "text"),
					   	GtSQLVlStr(ctjTx($_POST['siscntest_clr_bck'],'out'), "text"),
					   	GtSQLVlStr(ctjTx($_POST['siscntest_clr_fnt'],'out'), "text"),
					   	GtSQLVlStr($__est_noi, "int"),
					  	GtSQLVlStr($__est_buy, "int"),
					   	GtSQLVlStr(ctjTx($_POST['siscntest_dsc'],'out'), "text"),
					  	GtSQLVlStr($_POST['siscntest_tp'], "int"),
					   	GtSQLVlStr($_POST['siscntest_usnvl'], "int"),
						GtSQLVlStr(Html_chck_vl($_POST['siscntest_asis']), "int"),
						GtSQLVlStr($__est_tra_archv, "int"),
						GtSQLVlStr($__est_tra_cncl, "int"),
						GtSQLVlStr($__est_tra_cmpl, "int"),
						GtSQLVlStr($__est_tra_eli, "int"),
						GtSQLVlStr($__est_tra_prc, "int"),
					   	GtSQLVlStr($_POST['siscntest_enc'], "text"));
					   
	$Result = $__cnx->_prc($updateSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(437, $_POST['siscntest_tt'], $_POST['id_siscntest']), $rsp['v']);
	}else{
		$rsp['rst'] = 'no';
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisCntEst'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_SIS_CNT_EST.' WHERE siscntest_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	$rsp['a'] = Aud_Sis(Aud_Dsc(438, $_POST['siscntest_tt'], $_POST['id_siscntest']), $rsp['v']); 
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>