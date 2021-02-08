<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClWdgtAct")) { 
	
	$__Enc = Enc_Rnd($_POST['clwdgtact_clwdgt'].'-'.$_POST['clwdgtact_nm']);

	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_WDGT_ACT." (clwdgtact_enc, clwdgtact_clwdgt, clwdgtact_nm, clwdgtact_dsc, clwdgtact_clr_bck, clwdgtact_clr_fnt, clwdgtact_tx_ph, clwdgtact_chnl, clwdgtact_chnl_acc, clwdgtact_chnl_key, clwdgtact_chnl_lne, clwdgtact_chnl_que, clwdgtact_wa_wlcm, clwdgtact_lnk_sms, clwdgtact_e, clwdgtact_awsacc, clwdgtact_mdlgen) VALUES (%s, (SELECT id_clwdgt FROM "._BdStr(DBM).TB_CL_WDGT." WHERE clwdgt_enc=%s) , %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr($_POST['clwdgtact_clwdgt'], "text"),
                   GtSQLVlStr(ctjTx($_POST['clwdgtact_nm'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['clwdgtact_dsc'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['clwdgtact_clr_bck'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['clwdgtact_clr_fnt'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['clwdgtact_tx_ph'],'out'), "text"),
                   GtSQLVlStr($_POST['clwdgtact_chnl'], "int"),
                   GtSQLVlStr(ctjTx($_POST['clwdgtact_chnl_acc'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['clwdgtact_chnl_key'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['clwdgtact_chnl_lne'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['clwdgtact_chnl_que'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['clwdgtact_wa_wlcm'],'out'), "text"),
				   GtSQLVlStr(!isN($_POST['clwdgtact_lnk_sms'])?$_POST['clwdgtact_lnk_sms']:2, "int"),  
				   GtSQLVlStr($_POST['clwdgtact_e'], "int"),
				   GtSQLVlStr($_POST['clwdgtact_awsacc'], "int"),
				   GtSQLVlStr($_POST['clwdgtact_mdlgen'], "int"));			

	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClWdgtAct")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_WDGT_ACT." SET clwdgtact_nm=%s, clwdgtact_dsc=%s, clwdgtact_clr_bck=%s, clwdgtact_clr_fnt=%s, clwdgtact_tx_ph=%s, clwdgtact_chnl=%s, clwdgtact_chnl_acc=%s, clwdgtact_chnl_key=%s, clwdgtact_chnl_lne=%s, clwdgtact_chnl_que=%s, clwdgtact_wa_wlcm=%s, clwdgtact_lnk_sms=%s, clwdgtact_e=%s, clwdgtact_awsacc=%s, clwdgtact_mdlgen=%s WHERE clwdgtact_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['clwdgtact_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgtact_dsc'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgtact_clr_bck'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgtact_clr_fnt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgtact_tx_ph'],'out'), "text"),
					   GtSQLVlStr($_POST['clwdgtact_chnl'], "int"),
					   GtSQLVlStr(ctjTx($_POST['clwdgtact_chnl_acc'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgtact_chnl_key'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgtact_chnl_lne'],'out'), "text"), 
					   GtSQLVlStr(ctjTx($_POST['clwdgtact_chnl_que'],'out'), "text"),   
					   GtSQLVlStr(ctjTx($_POST['clwdgtact_wa_wlcm'],'out'), "text"), 
					   GtSQLVlStr($_POST['clwdgtact_lnk_sms'], "int"),       
					   GtSQLVlStr($_POST['clwdgtact_e'], "int"),       
					   GtSQLVlStr($_POST['clwdgtact_awsacc'], "int"),    
					   GtSQLVlStr($_POST['clwdgtact_mdlgen'], "int"),     
                       GtSQLVlStr($_POST['clwdgtact_enc'], "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){

		$rsp['e'] = 'ok';
		$rsp['m'] = 1;

		$_aws = new API_CRM_Aws();
		$rsp['cfr'] = $_aws->_cfr_clr([ 'b'=>'frnt', 'fle'=>'action/'.$_POST['clwdgtact_enc'], 'all'=>'ok' ]);

	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

if ((isset($_POST['id_clwdgtact'])) && ($_POST['idclwdgtact'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClWdgtAct'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_CL_WDGT_ACT.' WHERE clwdgtact_enc=%s', GtSQLVlStr($_POST['clwdgtact_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	 
	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(417, $_POST['clare_dsc'], $_POST['id_clare']), $rsp['v']);
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'_cl_mnu' ]);
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}


?>