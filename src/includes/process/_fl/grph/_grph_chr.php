<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdGrphChr")) { 
	
	$__enc = Enc_Rnd($_POST['grphchr_tt'].'-'.$_POST['grphchr_key'].'-'.$_POST['grphchr_tp']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).MDL_GRPH_CHR_BD." (grphchr_enc, grphchr_tt, grphchr_key, grphchr_dfl, grphchr_tp) VALUES (%s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr(ctjTx($_POST['grphchr_tt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['grphchr_key'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['grphchr_dfl'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['grphchr_tp'],'out'), "text"));	
	
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(460, $_POST['sismtr_tt'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdGrphChr")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).MDL_GRPH_CHR_BD." SET grphchr_tt=%s, grphchr_key=%s, grphchr_dfl=%s, grphchr_tp=%s WHERE grphchr_enc=%s",
						GtSQLVlStr(ctjTx($_POST['grphchr_tt'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['grphchr_key'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['grphchr_dfl'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['grphchr_tp'],'out'), "text"),
						GtSQLVlStr($_POST['grphchr_enc'], 'text'));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['i'] = $_POST['id_grphchr'];
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(461, $_POST['sisexa_tt'], $_POST['id_sisexa']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdGrphChr'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).MDL_GRPH_CHR_BD.' WHERE grphchr_enc=%s', GtSQLVlStr($_POST['uid'], 'int'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		 //$rsp['a'] = Aud_Sis(Aud_Dsc(462, $_POST['sismtr_tt'], $_POST['id_grph']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>