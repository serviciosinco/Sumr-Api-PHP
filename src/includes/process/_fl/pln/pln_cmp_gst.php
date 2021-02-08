<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdPlnCmpGst")) { 
	
	$__Enc = Enc_Rnd($_POST['plncmpgst_dsc'].'-'.SISUS_ID);	
	
	$insertSQL = sprintf("INSERT INTO ".TB_PLN_CMP_GST." (plncmpgst_enc, plncmpgst_us, plncmpgst_plncmp, plncmpgst_dsc, plncmpgst_shw) VALUES 
						(%s, %s, (SELECT id_plncmp FROM ".TB_PLN_CMP." WHERE plncmp_enc = %s), %s, %s)",
                       GtSQLVlStr($__Enc, "text"),
					   GtSQLVlStr(SISUS_ID, "int"),
					   GtSQLVlStr(ctjTx($_POST['plncmpgst_plncmp'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['plncmpgst_dsc'],'out'), "text"),
					   GtSQLVlStr(Html_chck_vl($_POST['plncmpgst_shw']), "int"));		
	
	$Result = $__cnx->_prc($insertSQL);
	if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(142, $_POST['cd_tt'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdPlnCmpGst")) { 
$updateSQL = sprintf("UPDATE ".TB_PLN_CMP_GST." SET plncmpgst_dsc=%s, plncmpgst_shw=%s WHERE plncmpgst_enc=%s",
						GtSQLVlStr(ctjTx($_POST['plncmpgst_dsc'],'out'), "text"),
					    GtSQLVlStr(Html_chck_vl($_POST['plncmpgst_shw']), "int"),
						GtSQLVlStr(ctjTx($_POST['plncmpgst_enc'],'out'), "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['sm'] = $updateSQL;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(419, $_POST['siscd_tt'], $_POST['id_siscd']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		$rsp['sm'] = $updateSQL;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}
?>