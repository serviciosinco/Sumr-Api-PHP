<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClPlcy")) { 
	
	$__Enc = Enc_Rnd($_POST['clplcy_lnk_tt'].'-'.$_POST['clplcy_tx']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_PLCY." (clplcy_enc, clplcy_cl, clplcy_nm, clplcy_tx, clplcy_lnk, clplcy_lnk_tt, clplcy_v, clplcy_e, clplcy_main, clplcy_ec) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, %s, %s, %s, %s, %s, %s)",
                  GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                  GtSQLVlStr(ctjTx(CL_ENC,'out'), "text"),
                  GtSQLVlStr(ctjTx($_POST['clplcy_nm'],'out'), "text"),
                  GtSQLVlStr(ctjTx($_POST['clplcy_tx'],'out'), "text"),
                  GtSQLVlStr(ctjTx($_POST['clplcy_lnk'],'out'), "text"),
                  GtSQLVlStr(ctjTx($_POST['clplcy_lnk_tt'],'out'), "text"),
				  GtSQLVlStr($_POST['clplcy_v'], "int"),
				  GtSQLVlStr(Html_chck_vl($_POST['clplcy_e']), "int"),
				  GtSQLVlStr(Html_chck_vl($_POST['clplcy_main']), "int"),
				  GtSQLVlStr($_POST['clplcy_ec'], "int"));			
				   
	
	$Result = $__cnx->_prc($insertSQL); $rsp['w'] = $__cnx->c_p->error;
	
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClPlcy")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_PLCY." SET clplcy_nm=%s, clplcy_tx=%s, clplcy_lnk=%s, clplcy_lnk_tt=%s, clplcy_v=%s, clplcy_e=%s, clplcy_main=%s, clplcy_ec=%s WHERE clplcy_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['clplcy_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clplcy_tx'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clplcy_lnk'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clplcy_lnk_tt'],'out'), "text"),
					   GtSQLVlStr($_POST['clplcy_v'], "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['clplcy_e']), "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['clplcy_main']), "int"),
					   GtSQLVlStr($_POST['clplcy_ec'], "int"),
                    	GtSQLVlStr($_POST['clplcy_enc'], "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['enc'] = $_POST['clplcy_enc'];
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClPlcy'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_CL_PLCY.' WHERE clplcy_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	 
	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}


?>