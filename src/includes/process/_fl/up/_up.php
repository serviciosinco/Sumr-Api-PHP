<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdUp")) {

	$insertSQL = sprintf("INSERT INTO "._BdStr(DB_PRC).TB_UP_BD." (id_up, up_nm, up_ext, up_col, up_row, up_est) VALUES (%s, %s, %s, %s, %s, %s)",
				   GtSQLVlStr($_POST['id_up'], "int"),	
                   GtSQLVlStr(ctjTx($_POST['up_nm'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['up_ext'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['up_col'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['up_row'],'out'), "text"),
				   GtSQLVlStr($_POST['up_est'], "int"));

	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(122, $_POST['emaplz_nm'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis([ 'p'=>$insertSQL, 'd'=>$__cnx->c_p->error ]);
	}
	
	$__cnx->_clsr($Result);
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdUp")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DB_PRC).TB_UP_BD." SET up_nm=%s, up_ext=%s, up_col=%s, up_row=%s, up_est=%s WHERE id_up=%s",
                       GtSQLVlStr(ctjTx($_POST['up_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['up_ext'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['up_col'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['up_row'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['up_est'],'out'), "text"),
					   GtSQLVlStr($_POST['id_up'], "int"));

	$Result = $__cnx->_prc($updateSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(123, $_POST['emaplz_nm'], $_POST['id_up']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	
	$__cnx->_clsr($Result);
}

// Elimino el Registro
if ((isset($_POST['id_up'])) && ($_POST['id_up'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdUp'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DB_PRC).TB_UP_BD.' WHERE id_up=%s', GtSQLVlStr($_POST['id_up'], 'int'));
	$Result =$__cnx->_prc($deleteSQL); 
	
	if($Result){
		$rsp['e'] = 'ok'; 
		$rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(124, $_POST['emaplz_nm'], $_POST['id_up']), $rsp['v']); 
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2;
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
	
	$__cnx->_clsr($Result);
}
?>