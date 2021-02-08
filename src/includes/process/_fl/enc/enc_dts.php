<?php

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEncDts")) { 
$updateSQL = sprintf("UPDATE ".TB_ENC_DTS." SET encdts_qly=%s  WHERE id_encdts=%s",
						GtSQLVlStr(ctjTx($_POST['encdts_qly'],'out'), "text"),
						GtSQLVlStr($_POST['id_encdts'], "int"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(35, $_POST['encdts_qly'], $_POST['id_encdts']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_encdts'])) && ($_POST['id_encdts'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEncDts'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_ENC_DTS.' WHERE id_encdts=%s', GtSQLVlStr($_POST['id_encdts'], 'int'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	// $rsp['a'] = Aud_Sis(Aud_Dsc(36, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>