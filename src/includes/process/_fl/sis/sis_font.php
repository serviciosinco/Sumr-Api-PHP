<?php
		

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisFont")) { 
		
	$__enc = Enc_Rnd($_POST['sisfont_tt'].'-'.$_POST['sisfont_cod']);
	$__cenc = enCad($_POST['sisfont_cod']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_FONT." ( sisfont_enc, sisfont_tt, sisfont_cod, sisfont_sze, sisfont_sbst) VALUES (%s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sisfont_tt'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['sisfont_cod'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['sisfont_sze'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['sisfont_sbst'],'out'), "text"));	
           		
	$Result = $__cnx->_prc($insertSQL);
	
		if($Result){
		$rsp['i'] = $__enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(71, $_POST['sisfont_cod'], $__cnx->c_p->insert_id, $_POST['sisfont_tt']), $rsp['v']);
		__AutoRUN([ 't'=>'sis_cns', 'bd'=>$__bdauto ]);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if (($_POST["MM_update"] == "EdSisFont")) { 
	
	$__cenc = enCad($_POST['sisfont_cod']);
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_FONT." SET sisfont_tt=%s, sisfont_cod=%s, sisfont_sze=%s, sisfont_sbst=%s WHERE sisfont_enc =%s",
					   GtSQLVlStr(ctjTx($_POST['sisfont_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisfont_cod'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisfont_sze'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisfont_sbst'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['sisfont_enc'],'out'), "text"));

	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['sisfont_cod'], $_POST['sis_enc'], $_POST['sisfont_tt']), $rsp['v']);
		__AutoRUN([ 't'=>'sis_cns', 'bd'=>$__bdauto ]);
	}else{
		$rsp['e'] = 'nop';
		$rsp['m'] = 2;
		$rsp['ms'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisFont'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_SIS_FONT.' WHERE sisfont_enc=%s', GtSQLVlStr($_POST['uid'], 'text')); 
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['sisfont_cod'], $_POST['uid'], $_POST['sisfont_tt']), $rsp['v']);}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>