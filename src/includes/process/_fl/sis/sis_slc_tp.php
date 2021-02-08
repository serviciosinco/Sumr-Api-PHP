<?php
	
if($___Prc->pst->tsb == 'cl'){ 
	$__bd_go = ['d'=>'cl']; 
	$__bd = _BdStr(DBM).TB_CL_SLC_TP;
}else{
	$__bd = _BdStr(DBM).TB_SIS_SLC_TP;
}

	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisSlcTp")) { 
		
	global $__cnx;	
		
	$__enc = Enc_Rnd($_POST['sisslctp_tt'].'-'.$_POST['sisslctp_key']);
	
	$insertSQL = sprintf("INSERT INTO ".$__bd." (sisslctp_enc, sisslctp_tt, sisslctp_key, sisslctp_sis, sisslctp_cl, sisslctp_ord, sisslctp_ord_desc) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($_POST['sisslctp_tt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sisslctp_key'],'out'), "text"),
                   GtSQLVlStr(Html_chck_vl($_POST['sisslctp_sis']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['sisslctp_cl']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['sisslctp_ord']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['sisslctp_ord_desc']), "int"));	

	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['enc'] = $__enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(142, $_POST['cd_tt'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['d'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	
	$__cnx->_clsr($Result);
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisSlcTp")) { 
	
	global $__cnx;
	
	$updateSQL = sprintf("UPDATE ".$__bd." SET sisslctp_tt=%s, sisslctp_key=%s, sisslctp_sis=%s, sisslctp_cl=%s, sisslctp_ord=%s, sisslctp_ord_desc=%s WHERE sisslctp_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['sisslctp_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisslctp_key'],'out'), "text"),
					   GtSQLVlStr(Html_chck_vl($_POST['sisslctp_sis']), "int"), 
					   GtSQLVlStr(Html_chck_vl($_POST['sisslctp_cl']), "int"),  
					   GtSQLVlStr(Html_chck_vl($_POST['sisslctp_ord']), "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['sisslctp_ord_desc']), "int"),
					   GtSQLVlStr($_POST['sisslctp_enc'], "text"));

	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['enc'] = $_POST['sisslctp_enc'];
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $updateSQL.$__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	
	$__cnx->_clsr($Result);
}

// Elimino el Registro
if ((isset($_POST['id_sisslctp'])) && ($_POST['id_sisslctp'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisSlcTp'))) { 
	
	global $__cnx;
	
	$deleteSQL = sprintf('DELETE FROM '.$__bd.' WHERE sisslctp_enc=%s', GtSQLVlStr($_POST['sisslctp_enc'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 //$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	 
	 $__cnx->_clsr($Result);
}
?>