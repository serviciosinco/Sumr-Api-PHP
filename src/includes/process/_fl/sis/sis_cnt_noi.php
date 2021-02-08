<?php  $rsp['some'] = 'ok';
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisCntNoi")) {
		
	$__enc = Enc_Rnd( $__dt_cl->id.'-'.$_POST['siscntnoi_nm'].'-'.$_POST['siscntnoi_prnt'] ); 
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_CNT_NOI." (siscntnoi_enc, siscntnoi_prnt, siscntnoi_cl, siscntnoi_nm) VALUES (%s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr($_POST['siscntnoi_prnt'], "int"),
                   GtSQLVlStr($__dt_cl->id, "int"),
				   GtSQLVlStr(ctjTx($_POST['siscntnoi_nm'],'out'), "text"));	 $rsp['q'] = $insertSQL;	
	
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		$rsp['enc'] = $__enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['w'] = $__cnx->c_p->error;
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisCntNoi")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_CNT_NOI." SET siscntnoi_prnt=%s, siscntnoi_nm=%s WHERE siscntnoi_enc=%s",
						GtSQLVlStr($_POST['siscntnoi_prnt'], "int"),
						GtSQLVlStr(ctjTx($_POST['siscntnoi_nm'],'out'), "text"),
						GtSQLVlStr($_POST['siscntnoi_enc'], "text"));
					   
	;
	$Result = $__cnx->_prc($updateSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(437, $_POST['siscntnoi_nm'], $_POST['id_siscntnoi']), $rsp['v']);
	}else{
		$rsp['rst'] = 'no';
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisCntNoi'))) { 
	$deleteSQL = sprintf('DELETE FROM '.DBM.'.'.TB_SIS_CNT_NOI.' WHERE siscntnoi_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		$rsp['a'] = Aud_Sis(Aud_Dsc(438, $_POST['siscntnoi_nm'], $_POST['uid']), $rsp['v']); 
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}
?>