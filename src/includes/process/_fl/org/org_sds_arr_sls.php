<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgSdsArrSls")) {
	

	$__enc = Enc_Rnd( $_POST['orgsdsarr_sls_enc']." - ".$_POST['orgsdsarrsls_vl']." - ".SISUS_ID ); 
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." (
																		orgsdsarrsls_enc,
																		orgsdsarrsls_vl,
																		orgsdsarrsls_trs,
                                                                        orgsdsarrsls_vst,
                                                                        orgsdsarrsls_f,
                                                                        orgsdsarrsls_arr
																	  ) VALUES 
																	  (	
																	  	%s,
																	  	%s,
																		%s,
                                                                        %s,
                                                                        %s,
                                                                        ( 
                                                                            SELECT id_orgsdsarr FROM "._BdStr(DBM).TB_ORG_SDS_ARR." 
                                                                            WHERE orgsdsarr_est = 1 AND orgsdsarr_orgsds IN (
                                                                                SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s
                                                                            )
                                                                        )
																	  )",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($_POST['orgsdsarrsls_vl'],'out'), "text"),
                   GtSQLVlStr($_POST['orgsdsarrsls_trs'], "int"),
                   GtSQLVlStr($_POST['orgsdsarrsls_vst'], "int"),
                   GtSQLVlStr($_POST['orgsdsarrsls_f'], "date"),
                   GtSQLVlStr(ctjTx($_POST['orgsdsarr_sls_enc'],'out'), "text")
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgSdsArrSls")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." SET 
                                                                    orgsdsarrsls_vl=%s,
                                                                    orgsdsarrsls_trs=%s,
                                                                    orgsdsarrsls_vst=%s,
																	orgsdsarrsls_f=%s,
																	orgsdsarrsls_arr= ( 
																		SELECT id_orgsdsarr FROM "._BdStr(DBM).TB_ORG_SDS_ARR." 
																		WHERE orgsdsarr_est = 1 AND orgsdsarr_orgsds IN (
																			SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s
																		)
																	)
																	WHERE 
																	orgsdsarrsls_enc=%s
																",
                            GtSQLVlStr(ctjTx($_POST['orgsdsarrsls_vl'],'out'), "text"),
                            GtSQLVlStr($_POST['orgsdsarrsls_trs'], "int"),
                            GtSQLVlStr($_POST['orgsdsarrsls_vst'], "int"),
							GtSQLVlStr($_POST['orgsdsarrsls_f'], "date"),
							GtSQLVlStr(ctjTx($_POST['orgsdsarr_sls_enc'],'out'), "text"),
                            GtSQLVlStr(ctjTx($_POST['orgsdsarrsls_enc'],'out'), "text")
                        );
	
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
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgSdsArrSls'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." WHERE orgsdsarrsls_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(438, $_POST['clgrp_nm'], $_POST['uid']), $rsp['v']); 
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>