<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisCntEstTp")) {
		
	$__enc = Enc_Rnd( $__dt_cl->id.'-'.$_POST['siscntesttp_tt'].'-'.$_POST['siscntesttp_ord'] ); 
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_CNT_EST_TP." (siscntesttp_enc, siscntesttp_clr_bck, siscntesttp_cl, siscntesttp_tt, siscntesttp_ord,siscntesttp_prch,siscntesttp_cntr) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($_POST['siscntesttp_clr_bck'],'out'), "text"),
                   GtSQLVlStr($__dt_cl->id, "int"),
				   GtSQLVlStr(ctjTx($_POST['siscntesttp_tt'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['siscntesttp_ord'],'out'), "text"),
				   GtSQLVlStr($_POST['siscntesttp_prch'], "int"),
				   GtSQLVlStr($_POST['siscntesttp_cntr'], "int"));
	
	$Result = $__cnx->_prc($insertSQL);
		if($Result){
		$rsp['i'] = $__enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	$rtrn = json_encode($rsp);
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisCntEstTp")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_CNT_EST_TP." SET siscntesttp_clr_bck=%s, siscntesttp_tt=%s, siscntesttp_ord=%s, siscntesttp_prch=%s, siscntesttp_cntr=%s WHERE siscntesttp_enc=%s",
						GtSQLVlStr(ctjTx($_POST['siscntesttp_clr_bck'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['siscntesttp_tt'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['siscntesttp_ord'],'out'), "text"),
						GtSQLVlStr($_POST['siscntesttp_prch'], "int"),
						GtSQLVlStr($_POST['siscntesttp_cntr'], "int"),
						GtSQLVlStr($_POST['siscntesttp_enc'], "text"));
						
	
	$Result = $__cnx->_prc($updateSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(437, $_POST['siscntesttp_tt'], $_POST['id_siscntesttp']), $rsp['v']);
	}else{
		$rsp['rst'] = 'no';
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisCntEstTp'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_SIS_CNT_EST_TP.' WHERE siscntesttp_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		$rsp['a'] = Aud_Sis(Aud_Dsc(438, $_POST['siscntesttp_tt'], $_POST['uid']), $rsp['v']); 
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>