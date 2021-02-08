<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdGrph")) { 
	
	$__enc = Enc_Rnd($_POST['grph_tt'].'-'.$_POST['grph_c'].'-'.$_POST['grph_d']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).MDL_GRPH_BD." (grph_enc, grph_tt, grph_fnc, grph_c, grph_d) VALUES (%s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr(ctjTx($_POST['grph_tt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['grph_fnc'],'out','', ['html'=>'no', 'schr'=>'no'] ), "text"),
                       GtSQLVlStr(ctjTx($_POST['grph_c'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['grph_d'],'out'), "text"));	
	
	
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdGrph")) { 
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).MDL_GRPH_BD." SET grph_tt=%s, grph_fnc=%s, grph_c=%s, grph_d=%s WHERE grph_enc=%s",
						GtSQLVlStr(ctjTx($_POST['grph_tt'],'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['grph_fnc'],'out','', ['html'=>'no', 'schr'=>'no']), "text"),
                        GtSQLVlStr(ctjTx($_POST['grph_c'],'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['grph_d'],'out'), "text"),
						GtSQLVlStr($_POST['grph_enc'], "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['i'] = $_POST['id_grph'];
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['post'] = $_POST['grph_fnc'];
		//$rsp['a'] = Aud_Sis(Aud_Dsc(461, $_POST['sisexa_tt'], $_POST['id_sisexa']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_grph'])) && ($_POST['id_grph'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdGrph'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).MDL_GRPH_BD.' WHERE id_grph=%s', GtSQLVlStr($_POST['id_grph'], 'int'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		 //$rsp['a'] = Aud_Sis(Aud_Dsc(462, $_POST['sismtr_tt'], $_POST['id_grph']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>