<?php

if($__t == 'sis'){ 
	$__bd = _BdStr(DBM).MDL_SIS_BD; // Base de Datos
	$__bdauto = '_sis';
}else{
	$__bd = _BdStr(DBM).MDL_CL_SIS_BD; // Base de Datos
	$__bd_go = ['d'=>'cl'];
	$__bdauto = '_cl_sis';
}	
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSis")) { 
		
	$__enc = Enc_Rnd($_POST['sis_tt'].'-'.$_POST['sis_vl']);
	
	$insertSQL = sprintf("INSERT INTO ".$__bd." ( sis_enc, sis_tt, sis_var, sis_vl) VALUES ( %s, %s, %s, %s)",
                  
                   GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sis_tt'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['sis_var'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sis_vl'],'out','',['html'=>'ok', 'schr'=>'no']), "text"));	
                   		
	$Result = $__cnx->_prc($insertSQL);
	
		if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(71, $_POST['sis_vl'], $__cnx->c_p->insert_id, $_POST['sis_tt']), $rsp['v']);
		__AutoRUN([ 't'=>'sis_cns', 'bd'=>$__bdauto ]);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['m2'] = $insertSQL.$__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSis")) { 
	
	$updateSQL = sprintf("UPDATE ".$__bd." SET sis_tt=%s, sis_var=%s, sis_vl=%s WHERE sis_enc =%s",
					   GtSQLVlStr(ctjTx($_POST['sis_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sis_var'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['sis_vl'],'out','', ['html'=>'ok', 'schr'=>'no']), "text"),
                       GtSQLVlStr(ctjTx($_POST['sis_enc'],'out'), "text"));

	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['sis_vl'], $_POST['id_sis'], $_POST['sis_tt']), $rsp['v']);
		__AutoRUN([ 't'=>'sis_cns', 'bd'=>$__bdauto ]);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSis'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '.$__bd.' WHERE sis_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['sis_vl'], $_POST['uid'], $_POST['sis_tt']), $rsp['v']);}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>