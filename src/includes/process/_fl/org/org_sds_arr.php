<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgSdsArr")) {
	
	$__enc = Enc_Rnd( $_POST['orgsdsarr_tt']." - ".$_POST['orgsdsarr_lcl']." - ".$_POST['orgsdsarr_orgsds'] ); 
	
	if( !isN($_POST['orgsdsarr_tt']) ){
		$_orgsdsarr_tt = $_POST['orgsdsarr_tt'];
	}else{
		$_orgsdsarr_tt = "Arriendo - ".$_POST['orgsdsarr_vig_fi']." - ".$_POST['orgsdsarr_vig_fn'];
	}
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_ARR." (
																		orgsdsarr_enc, 
																		orgsdsarr_orgsds, 
																		orgsdsarr_tt,
																		orgsdsarr_lcl, 
																		orgsdsarr_est,
																		orgsdsarr_vl,
																		orgsdsarr_vig_fi,
																		orgsdsarr_vig_fn,
																		orgsdsarr_vl_mnt,
																		orgsdsarr_vl_rpt
																		
																	  ) VALUES 
																	  (	
																	  	%s, 
																	  	( SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s ), 
																	  	%s, 
																	  	%s, 
																	  	%s,
																	  	%s,
																	  	%s,
																		%s,
																		%s,
																		%s
																		
																	  )",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr($_POST['orgsdsarr_orgsds'], "text"),
				   GtSQLVlStr(ctjTx($_orgsdsarr_tt, 'out'), "text"),
				   GtSQLVlStr($_POST['orgsdsarr_lcl'], "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['orgsdsarr_est']), "int"),
				   GtSQLVlStr(ctjTx($_POST['orgsdsarr_vl'],'out'), "text"),
				   GtSQLVlStr($_POST['orgsdsarr_vig_fi'], "date"),
				   GtSQLVlStr($_POST['orgsdsarr_vig_fn'], "date"),
				   GtSQLVlStr(Html_chck_vl($_POST['orgsdsarr_vl_mnt']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['orgsdsarr_vl_rpt']), "int"));
	
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		//$rsp['i'] = $__enc;
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgSdsArr")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ORG_SDS_ARR." SET 
																	orgsdsarr_orgsds = ( SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s ), 
																	orgsdsarr_tt=%s,
																	orgsdsarr_lcl=%s,
																	orgsdsarr_est=%s,
																	orgsdsarr_vl=%s,
																	orgsdsarr_vig_fi=%s,
																	orgsdsarr_vig_fn=%s,
																	orgsdsarr_vl_mnt=%s,
																	orgsdsarr_vl_rpt=%s
																	WHERE 
																	orgsdsarr_enc=%s
																",
									GtSQLVlStr($_POST['orgsdsarr_orgsds'], "text"),
									GtSQLVlStr(ctjTx($_POST['orgsdsarr_tt'],'out'), "text"),
									GtSQLVlStr($_POST['orgsdsarr_lcl'], "int"),
									GtSQLVlStr(Html_chck_vl($_POST['orgsdsarr_est']), "int"),
									GtSQLVlStr(ctjTx($_POST['orgsdsarr_vl'],'out'), "text"),
									GtSQLVlStr($_POST['orgsdsarr_vig_fi'], "date"),
									GtSQLVlStr($_POST['orgsdsarr_vig_fn'], "date"),
									GtSQLVlStr(Html_chck_vl($_POST['orgsdsarr_vl_mnt']), "int"),
									GtSQLVlStr(Html_chck_vl($_POST['orgsdsarr_vl_rpt']), "int"),
									GtSQLVlStr($_POST['orgsdsarr_enc'], "text"));
	;
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(437, $_POST['clgrp_nm'], $_POST['id_clgrp']), $rsp['v']);
	}else{
		$rsp['rst'] = 'no';
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgSdsArr'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SDS_ARR." WHERE orgsdsarr_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(438, $_POST['clgrp_nm'], $_POST['uid']), $rsp['v']); 
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>