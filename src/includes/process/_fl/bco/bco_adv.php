<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdBcoAdv")) { 
	
	$__Enc = Enc_Rnd($_POST['bcoadv_cl'].'-'.$_POST['bcoadv_tx']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_BCO_ADV." (bcoadv_enc, bcoadv_cl, bcoadv_tx, bcoadv_chk, bcoadv_ord) VALUES (%s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr(ctjTx(DB_CL_ID,'out'), "int"),
                   GtSQLVlStr(ctjTx($_POST['bcoadv_tx'],'out'), "text"),
				   GtSQLVlStr(Html_chck_vl($_POST['bcoadv_chk']), "int"),
                   GtSQLVlStr(ctjTx($_POST['bcoadv_ord'],'out'), "int"));			
				   
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdBcoAdv")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_BCO_ADV." SET bcoadv_tx=%s, bcoadv_chk=%s, bcoadv_ord=%s WHERE bcoadv_enc=%s",
                                GtSQLVlStr(ctjTx($_POST['bcoadv_tx'],'out'), "text"),
                                GtSQLVlStr(Html_chck_vl($_POST['bcoadv_chk']), "int"),
                                GtSQLVlStr(ctjTx($_POST['bcoadv_ord'],'out'), "int"),
                                GtSQLVlStr($_POST['bcoadv_enc'], "text"));
	
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

if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdBcoAdv'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_BCO_ADV." WHERE bcoadv_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	 
	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}


?>