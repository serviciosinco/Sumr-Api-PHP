<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdGrphChrRlc")) {

	$__enc = Enc_Rnd($_POST['grphchrrlc_grph'].'-'.$_POST['grphchrrlc_chr'].'-'.$_POST['grphchrrlc_vl_es']);

	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).MDL_GRPH_CHR_RLC_BD." (grphchrrlc_enc, grphchrrlc_grph, grphchrrlc_chr, grphchrrlc_vl_es, grphchrrlc_vl_en) VALUES (%s, %s, %s, %s, %s)",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($_POST['grphchrrlc_grph'], 'int'),
                       	GtSQLVlStr($_POST['grphchrrlc_chr'], 'int'),
                       	GtSQLVlStr(ctjTx($_POST['grphchrrlc_vl_es'],'out'), "text"),
                       	GtSQLVlStr(ctjTx($_POST['grphchrrlc_vl_en'],'out'), "text"));

	$Result = $__cnx->_prc($insertSQL);

	if($Result){

		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(460, $_POST['sismtr_tt'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdGrphChrRlc") && !isN($_POST['grphchrrlc_enc'])) {

	if($_POST['grphchrrlc_vl_es']=='0'){ $_vl_es_tp='int'; }else{ $_vl_es_tp='text'; }
	if($_POST['grphchrrlc_vl_en']=='0'){ $_vl_en_tp='int'; }else{ $_vl_en_tp='text'; }

	$updateSQL = sprintf("UPDATE "._BdStr(DBM).MDL_GRPH_CHR_RLC_BD." SET grphchrrlc_grph=%s, grphchrrlc_chr=%s, grphchrrlc_vl_es=%s, grphchrrlc_vl_en=%s WHERE grphchrrlc_enc=%s",
						GtSQLVlStr($_POST['grphchrrlc_grph'], 'int'),
						GtSQLVlStr($_POST['grphchrrlc_chr'], 'int'),
						GtSQLVlStr($_POST['grphchrrlc_vl_es'], $_vl_es_tp),
						GtSQLVlStr($_POST['grphchrrlc_vl_en'], $_vl_en_tp),
						GtSQLVlStr($_POST['grphchrrlc_enc'], 'text'));

	$Result = $__cnx->_prc($updateSQL);

	if($Result){
		$rsp['i'] = $_POST['id_grphchrrlc'];
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['q'] = compress_code($updateSQL);
		//$rsp['a'] = Aud_Sis(Aud_Dsc(461, $_POST['sisexa_tt'], $_POST['id_sisexa']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	}

}

// Elimino el Registro
if ((isset($_POST['id_grphchrrlc'])) && ($_POST['id_grphchrrlc'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdGrphChrRlc'))) {
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).MDL_GRPH_CHR_RLC_BD.' WHERE id_grphchrrlc=%s', GtSQLVlStr($_POST['id_grphchrrlc'], 'int'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
		 //$rsp['a'] = Aud_Sis(Aud_Dsc(462, $_POST['sismtr_tt'], $_POST['id_grph']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>