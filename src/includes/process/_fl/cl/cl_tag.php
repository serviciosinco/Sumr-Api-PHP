<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClTag")) { 
		
	$__enc = Enc_Rnd($_POST['cltag_cl'].'-'.$_POST['cltag_sistag'].'-'.$_POST['cltag_vl']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_TAG." (cltag_enc, cltag_cl, cltag_sistag, cltag_vl) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc=%s), %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr($_POST['cltag_cl'], "text"),
				   GtSQLVlStr($_POST['cltag_sistag'], "int"),
                   GtSQLVlStr(ctjTx($_POST['cltag_vl'],'out','',['html'=>'ok','schr'=>'no','nl2'=>'no']), "text"));
                   			
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(71, $_POST['sis_vl'], $__cnx->c_p->insert_id, $_POST['sis_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClTag")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_TAG." SET cltag_cl=(SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc=%s), cltag_sistag=%s, cltag_vl=%s WHERE cltag_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['cltag_cl'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['cltag_sistag'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['cltag_vl'],'out','',['html'=>'ok','schr'=>'no','nl2'=>'no']), "text"),
                       GtSQLVlStr($_POST['cltag_enc'], "text"));
	
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['sis_vl'], $_POST['id_cltag'], $_POST['sis_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_cltag'])) && ($_POST['id_cltag'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClTag'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_TAG." WHERE cltag_enc=%s", GtSQLVlStr($_POST['cltag_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['sis_vl'], $_POST['id_cltag'], $_POST['sis_tt']), $rsp['v']);
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>