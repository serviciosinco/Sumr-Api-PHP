
<?php 
		
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSort")) { 
	
	$__Enc = Enc_Rnd($_POST['sort_cl'].'-'.$_POST['sort_nm']);

	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SORT." (sort_enc, sort_cl, sort_nm, sort_pml, sort_msv_cid, sort_snce, sort_html, sort_data) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr($_POST['sort_cl'], "int"),
                   GtSQLVlStr(ctjTx($_POST['sort_nm'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sort_pml'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sort_msv_cid'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sort_snce'],'out'), "date"),
                   GtSQLVlStr(ctjTx($_POST['sort_html'],'out', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']), "text"),
                   GtSQLVlStr(ctjTx($_POST['sort_data'],'out', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']), "text")
                ); $rsp['q'] = $insertSQL;
				   	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){

		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSort")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SORT." SET sort_nm=%s, sort_cl=%s, sort_pml=%s, sort_msv_cid=%s, sort_snce=%s, sort_html=%s, sort_data=%s WHERE sort_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['sort_nm'],'out'), "text"),
					   GtSQLVlStr($_POST['sort_cl'], "int"),
					   GtSQLVlStr(ctjTx($_POST['sort_pml'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sort_msv_cid'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sort_snce'],'out'), "date"),
					   GtSQLVlStr(ctjTx($_POST['sort_html'],'out', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']), "text"),
					   GtSQLVlStr(ctjTx($_POST['sort_data'],'out', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']), "text"),       
                       GtSQLVlStr($_POST['sort_enc'], "text"));
	

	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}


if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSort'))) { 
	$deleteSQL = sprintf('DELETE FROM ' ._BdStr(DBM).TB_SORT. ' WHERE sort_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	 
	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(417, $_POST['clare_dsc'], $_POST['id_clare']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}

?>