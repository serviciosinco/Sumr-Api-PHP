<?php 

	$__qry_id = 'id_encfld';
	$__qry_bd = TB_ENC_FLD;
	$__qry_prfx = 'encfld';
	$__qry_rlc = 'encfld_enc';


// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEncFld")) {

	$insertSQL = sprintf("INSERT INTO {$__qry_bd} ({$__qry_rlc}, {$__qry_prfx}_fld, {$__qry_prfx}_rqr, {$__qry_prfx}_ord,  {$__qry_prfx}_row, {$__qry_prfx}_max, {$__qry_prfx}_tt_es, {$__qry_prfx}_tt_en, {$__qry_prfx}_tt_it, {$__qry_prfx}_tt_fr, {$__qry_prfx}_tt_gr, {$__qry_prfx}_tt_krn, {$__qry_prfx}_tt_jpn, {$__qry_prfx}_tt_ptg, {$__qry_prfx}_tt_mdn) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr($_POST[$__qry_rlc], "int"),
				   GtSQLVlStr($_POST[$__qry_prfx.'_fld'], "int"),
				   GtSQLVlStr( _NoNll(Html_chck_vl( $_POST[$__qry_prfx.'_rqr'] )) , "int"),
				   GtSQLVlStr( _NoNll( $_POST[$__qry_prfx.'_ord'] ) , "int"),
				   GtSQLVlStr( _NoNll( $_POST[$__qry_prfx.'_row'] ) , "int"),
				   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_max'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_es'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_en'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_it'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_fr'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_gr'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_krn'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_jpn'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_ptg'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_mdn'],'out'), "text"));
				   		
	
	$Result = $__cnx->_prc($insertSQL);
	
		if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(335, 'Field del modulo', $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEncFld")) { 
$updateSQL = sprintf("UPDATE {$__qry_bd} SET {$__qry_rlc}=%s, {$__qry_prfx}_fld=%s, {$__qry_prfx}_rqr=%s, {$__qry_prfx}_ord=%s, {$__qry_prfx}_row=%s,  {$__qry_prfx}_max=%s, {$__qry_prfx}_tt_es=%s, {$__qry_prfx}_tt_en=%s, {$__qry_prfx}_tt_it=%s, {$__qry_prfx}_tt_fr=%s, {$__qry_prfx}_tt_gr=%s, {$__qry_prfx}_tt_krn=%s, {$__qry_prfx}_tt_jpn=%s, {$__qry_prfx}_tt_ptg=%s, {$__qry_prfx}_tt_mdn=%s, {$__qry_prfx}_fa=%s, {$__qry_prfx}_ha=%s WHERE id_{$__qry_prfx}=%s",
					   GtSQLVlStr($_POST[$__qry_rlc], "int"),
					   GtSQLVlStr($_POST[$__qry_prfx.'_fld'], "int"),
					   GtSQLVlStr( _NoNll(Html_chck_vl( $_POST[$__qry_prfx.'_rqr'] )) , "int"),
					   GtSQLVlStr( _NoNll( $_POST[$__qry_prfx.'_ord'] ) , "int"),
					   GtSQLVlStr( _NoNll( $_POST[$__qry_prfx.'_row'] ) , "int"),
					   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_max'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_es'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_en'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_it'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_fr'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_gr'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_krn'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_jpn'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_ptg'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST[$__qry_prfx.'_tt_mdn'],'out'), "text"),
					   GtSQLVlStr(SIS_F, "date"),
					   GtSQLVlStr(SIS_H2, "date"),
					   GtSQLVlStr($_POST[$__qry_id], "int"));
					   
	;
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(336, 'Field del modulo', $_POST[$__qry_id]), $rsp['v']);   
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST[$__qry_id])) && ($_POST[$__qry_id] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEncFld'))) { 
	$deleteSQL = sprintf("DELETE FROM {$__qry_bd} WHERE {$__qry_id}=%s", GtSQLVlStr($_POST[$__qry_id], 'int'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	//$rsp['a'] = Aud_Sis(Aud_Dsc(337, 'Field del modulo', $_POST[$__qry_id]), $rsp['v']);
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>