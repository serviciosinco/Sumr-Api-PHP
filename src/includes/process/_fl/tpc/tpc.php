<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdTpc")) { 	
	
	global $__cnx;
	
	$__enc = Enc_Rnd($_POST['tpc_tt'].' '.$_POST['tpc_tp']);		
		
	$insertSQL = sprintf("INSERT INTO ".TB_TPC." (tpc_enc, tpc_tt, tpc_tp, tpc_key) VALUES (%s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($_POST['tpc_tt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['tpc_tp'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['tpc_key'],'out'), "text"));

	$Result = $__cnx->_prc($insertSQL);
		if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(499, $_POST['tpc_tt'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['sm'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	$__cnx->_clsr($Result);
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdTpc")) { 
	
	global $__cnx;
	
	$updateSQL = sprintf("UPDATE ".TB_TPC." SET tpc_tt=%s, tpc_tp=%s, tpc_key=%s WHERE tpc_enc=%s",
						GtSQLVlStr(ctjTx($_POST['tpc_tt'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['tpc_tp'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['tpc_key'],'out'), "text"),
						GtSQLVlStr($_POST['tpc_enc'], "text"));
 
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(500, $_POST['tpc_tt'], $_POST['id_tpc']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	$__cnx->_clsr($Result);
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdTpc'))) { 
	
	global $__cnx;
	
	$deleteSQL = sprintf('DELETE FROM '.TB_TPC.' WHERE tpc_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 $rsp['a'] = Aud_Sis(Aud_Dsc(501, $_POST['tpc_tt'], $_POST['id_tpc']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	 $__cnx->_clsr($Result);
}
?>