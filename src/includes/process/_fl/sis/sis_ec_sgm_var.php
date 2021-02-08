<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisEcSgmVar")) { 	
	
	$__enc = Enc_Rnd($_POST['sisecsgmvar_nm']);		
		
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_EC_SGM_VAR." (sisecsgmvar_enc, sisecsgmvar_nm, sisecsgmvar_sgm, sisecsgmvar_tp, sisecsgmvar_ls, sisecsgmvar_dt, sisecsgmvar_qry) VALUES (%s, %s,%s,%s,%s,%s,%s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($_POST['sisecsgmvar_nm'],'out'), "text"),
                   GtSQLVlStr($_POST['sisecsgmvar_sgm'], "int"),
                   GtSQLVlStr($_POST['sisecsgmvar_tp'], "int"),
                   GtSQLVlStr(ctjTx($_POST['sisecsgmvar_ls'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sisecsgmvar_dt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sisecsgmvar_qry'],'out'), "text"));
                   
	
	
	$Result = $__cnx->_prc($insertSQL);
		if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(499, $_POST['sisecsgmvar_nm'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['sm'] = $insertSQL." ".$__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisEcSgmVar")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_EC_SGM_VAR." SET sisecsgmvar_nm=%s, sisecsgmvar_sgm=%s, sisecsgmvar_tp=%s, sisecsgmvar_ls=%s, sisecsgmvar_dt=%s, sisecsgmvar_qry=%s WHERE sisecsgmvar_enc=%s",
							GtSQLVlStr(ctjTx($_POST['sisecsgmvar_nm'],'out'), "text"),
							GtSQLVlStr($_POST['sisecsgmvar_sgm'], "int"),
							GtSQLVlStr($_POST['sisecsgmvar_tp'], "int"),
							GtSQLVlStr(ctjTx($_POST['sisecsgmvar_ls'],'out'), "text"),
							GtSQLVlStr(ctjTx($_POST['sisecsgmvar_dt'],'out'), "text"),
							GtSQLVlStr(ctjTx($_POST['sisecsgmvar_qry'],'out'), "text"),
							GtSQLVlStr($_POST['sisecsgmvar_enc'], "text"));
						
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(500, $_POST['sisps_tt'], $_POST['id_sisps']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisEcSgmVar'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_SIS_EC_SGM_VAR.' WHERE sisecsgmvar_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;  
	 $rsp['a'] = Aud_Sis(Aud_Dsc(501, $_POST['sisecsgmvar_nm'], $_POST['uid']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>