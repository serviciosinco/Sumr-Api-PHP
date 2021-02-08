<?php


// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdWbhk")) { 
		
	$__enc = Enc_Rnd($_POST['wbhk_nm'].'-'.$_POST['wbhk_url']);
	
	$insertSQL = sprintf("INSERT INTO ".DBP.".".TB_WHK." ( wbhk_enc, wbhk_cl, wbhk_nm, wbhk_cstm, wbhk_url, wbhk_soap, wbhk_rest, wbhk_port) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)",
                  
                   GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                   GtSQLVlStr($__dt_cl->id, "int"),
                   GtSQLVlStr(ctjTx($_POST['wbhk_nm'],'out'), "text"),
				   GtSQLVlStr(Html_chck_vl($_POST['wbhk_cstm']), "int"),
				   GtSQLVlStr(ctjTx($_POST['wbhk_url'],'out'), "text"),
				   GtSQLVlStr(Html_chck_vl($_POST['wbhk_soap']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['wbhk_rest']), "int"),
				   GtSQLVlStr(ctjTx($_POST['wbhk_port'],'out'), "int"));	
   
	$Result = $__cnx->_prc($insertSQL);
	    
	if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(71, $_POST['wbhk_url'], $__cnx->c_p->insert_id, $_POST['wbhk_nm']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['m2'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	$__cnx->_clsr($Result);
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdWbhk")) { 

	$updateSQL = sprintf("UPDATE ".DBP.".".TB_WHK." SET wbhk_nm=%s, wbhk_cstm=%s, wbhk_url=%s, wbhk_soap=%s, wbhk_rest=%s, wbhk_port=%s WHERE wbhk_enc =%s",
					   
					GtSQLVlStr(ctjTx($_POST['wbhk_nm'],'out'), "text"),
					GtSQLVlStr(Html_chck_vl($_POST['wbhk_cstm']), "int"),
					GtSQLVlStr(ctjTx($_POST['wbhk_url'],'out'), "text"),
					GtSQLVlStr(Html_chck_vl($_POST['wbhk_soap']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['wbhk_rest']), "int"),
					GtSQLVlStr(ctjTx($_POST['wbhk_port'],'out'), "int"),
					GtSQLVlStr(ctjTx($_POST['wbhk_enc'],'out'), "text"));

	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
//		$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['wbhk_url'], $_POST['id_upfld'], $_POST['wbhk_nm']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	$__cnx->_clsr($Result);
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdWbhk'))) { 

	$deleteSQL = sprintf('DELETE FROM '.DBP.'.'.TB_WHK.' WHERE wbhk_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['wbhk_url'], $_POST['uid'], $_POST['wbhk_nm']), $rsp['v']);}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	$__cnx->_clsr($Result);
} 
?>
