<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisSlc")) { 
	
	$__enc = Enc_Rnd($_POST['sisslc_tt'].'-'.$_POST['sisslc_tp']);
		
	$insertSQL = sprintf("INSERT INTO ".TB_SIS_SLC." (sisslc_enc, sisslc_tt, sisslc_tp, sisslc_cns) VALUES (%s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($_POST['sisslc_tt'],'out'), "text"),
				   GtSQLVlStr($_POST['sisslc_tp'], "int"),
				   GtSQLVlStr(ctjTx($_POST['sisslc_cns'],'out'), "text"));		
				   
	
	$Result = $__cnx->_prc($insertSQL);
	
		if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(142, $_POST['cd_tt'], $__cnx->c_p->insert_id), $rsp['v']);		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['d'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisSlc")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_SIS_SLC." SET sisslc_tt=%s, sisslc_tp=%s, sisslc_cns=%s WHERE sisslc_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['sisslc_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisslc_tp'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisslc_cns'],'out'), "text"),
					   GtSQLVlStr($_POST['sisslc_enc'], "text"));
					   
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_sisslc'])) && ($_POST['id_sisslc'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisSlc'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_SIS_SLC.' WHERE sisslc_enc=%s', GtSQLVlStr($_POST['sisslc_enc'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 //$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>