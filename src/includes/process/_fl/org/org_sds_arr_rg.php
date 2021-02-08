<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgSdsArrRg")) {
	
	$__enc = Enc_Rnd( $_POST['orgsdsarrrg_arr']." - ".$_POST['orgsdsarrrg_vl'] ); 
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_ARR_RG." (
																		orgsdsarrrg_enc, 
																		orgsdsarrrg_arr, 
																		orgsdsarrrg_vl,
																		orgsdsarrrg_f,
																		orgsdsarrrg_vl_adm
																	  ) VALUES 
																	  (	
																	  	%s, 
																	  	( SELECT id_orgsdsarr FROM "._BdStr(DBM).TB_ORG_SDS_ARR." WHERE orgsdsarr_enc = %s ), 
																		%s,
																		%s,
																		%s  
																	  )",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr($_POST['orgsdsarrrg_arr'], "text"),
				   GtSQLVlStr(ctjTx($_POST['orgsdsarrrg_vl'],'out'), "text"),
				   GtSQLVlStr($_POST['orgsdsarrrg_f']."-01", "date"),
				   GtSQLVlStr($_POST['orgsdsarrrg_vl_adm'], "int")
				);
	
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgSdsArrRg")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ORG_SDS_ARR_RG." SET 
																	orgsdsarrrg_arr = ( SELECT id_orgsdsarr FROM "._BdStr(DBM).TB_ORG_SDS_ARR." WHERE orgsdsarr_enc = %s ), 
																	orgsdsarrrg_vl=%s,
																	orgsdsarrrg_f=%s,
																	orgsdsarrrg_vl_adm=%s
																	WHERE 
																	orgsdsarrrg_enc=%s
																",
									GtSQLVlStr($_POST['orgsdsarrrg_arr'], "text"),
									GtSQLVlStr(ctjTx($_POST['orgsdsarrrg_vl'],'out'), "text"),
									GtSQLVlStr($_POST['orgsdsarrrg_f']."-01", "date"),
									GtSQLVlStr($_POST['orgsdsarrrg_vl_adm'], "int"),
									GtSQLVlStr($_POST['orgsdsarrrg_enc'], "text"));
	
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
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgSdsArrRg'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SDS_ARR_RG." WHERE orgsdsarrrg_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(438, $_POST['clgrp_nm'], $_POST['uid']), $rsp['v']); 
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>