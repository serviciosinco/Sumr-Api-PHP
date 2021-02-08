<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdTpcTp")) { 	
	
	global $__cnx;
	
	$__enc = Enc_Rnd($_POST['tpctp_tt'].' '.$_POST['tpctp_key']);		
		
	$insertSQL = sprintf("INSERT INTO ".TB_TPC_TP." (tpctp_enc, tpctp_tt, tpctp_key) VALUES (%s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($_POST['tpctp_tt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['tpctp_key'],'out'), "text"));
				   $Result = $__cnx->_prc($insertSQL);
		if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(499, $_POST['tpctp_tt'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['sm'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	
	$__cnx->_clsr($Result);
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdTpcTp")) { 
	
	global $__cnx;
	
	$updateSQL = sprintf("UPDATE ".TB_TPC_TP." SET tpctp_tt=%s, tpctp_key=%s WHERE tpctp_enc=%s",
						GtSQLVlStr(ctjTx($_POST['tpctp_tt'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['tpctp_key'],'out'), "text"),
						GtSQLVlStr($_POST['tpctp_enc'], "text"));
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(500, $_POST['tpctp_tt'], $_POST['id_tpctp']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	
	$__cnx->_clsr($Result);
	
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdTpcTp'))) { 
	
	global $__cnx;
	
	$deleteSQL = sprintf('DELETE FROM '.TB_TPC_TP.' WHERE tpctp_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 $rsp['a'] = Aud_Sis(Aud_Dsc(501, $_POST['tpctp_tt'], $_POST['id_tpctp']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	
	$__cnx->_clsr($Result);
}
?>