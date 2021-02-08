<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisCdDp")) { 
	
	$__enc = Enc_Rnd($_POST['siscddp_tt'].'-'.$_POST['siscddp_ps']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_CD_DP." ( siscddp_enc, siscddp_tt, siscddp_pml, siscddp_indc, siscddp_ps) VALUES (%s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['siscddp_tt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['siscddp_pml'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['siscddp_indc'],'out'), "text"),
				   GtSQLVlStr($_POST['siscddp_ps'], "int"));		
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(418, $_POST['siscddp_tt'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['ms'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisCdDp")) { 
$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_CD_DP." SET siscddp_tt=%s, siscddp_pml=%s, siscddp_indc=%s, siscddp_ps=%s WHERE siscddp_enc=%s",
						GtSQLVlStr(ctjTx($_POST['siscddp_tt'],'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['siscddp_pml'],'out'), "text"),
					    GtSQLVlStr(ctjTx($_POST['siscddp_indc'],'out'), "text"),
					    GtSQLVlStr($_POST['siscddp_ps'], "int"),
						GtSQLVlStr(ctjTx($_POST['siscddp_enc'],'out'), "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(419, $_POST['siscddp_tt'], $_POST['id_siscddp']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisCdDp'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_SIS_CD_DP.' WHERE siscddp_enc=%s', GtSQLVlStr(ctjTx($_POST['uid'],'out'), "text"));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	 $rsp['a'] = Aud_Sis(Aud_Dsc(420, $_POST['siscddp_tt'], $_POST['uid']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; $rsp['ms'] = $deleteSQL; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>