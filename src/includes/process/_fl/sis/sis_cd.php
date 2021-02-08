<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisCd")) { 
	
	$__enc = Enc_Rnd($_POST['siscd_tt'].'-'.$_POST['siscd_dp']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).MDL_SIS_CD_BD." (id_siscd, siscd_enc, siscd_tt, siscd_dp, siscd_vrf, siscd_inc) VALUES (%s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($_POST['id_siscd'], "int"),
                       GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['siscd_tt'],'out'), "text"),
					   GtSQLVlStr($_POST['siscd_dp'], "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['siscd_vrf']), "int"),
					   GtSQLVlStr($_POST['siscd_inc'], "int"));		
	
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(418, $_POST['siscd_tt'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['ms'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisCd")) { 
$updateSQL = sprintf("UPDATE "._BdStr(DBM).MDL_SIS_CD_BD." SET siscd_tt=%s, siscd_dp=%s, siscd_inc=%s, siscd_vrf=%s WHERE siscd_enc=%s",
						GtSQLVlStr(ctjTx($_POST['siscd_tt'],'out'), "text"),
					   	GtSQLVlStr($_POST['siscd_dp'], "int"),
						GtSQLVlStr($_POST['siscd_inc'], "int"),
						GtSQLVlStr(Html_chck_vl($_POST['siscd_vrf']), "int"),
						GtSQLVlStr(ctjTx($_POST['siscd_enc'],'out'), "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(419, $_POST['siscd_tt'], $_POST['id_siscd']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['siscd_enc'])) && ($_POST['siscd_enc'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisCd'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).MDL_SIS_CD_BD.' WHERE siscd_enc=%s', GtSQLVlStr($_POST['siscd_enc'], 'int'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	 $rsp['a'] = Aud_Sis(Aud_Dsc(420, $_POST['siscd_tt'], $_POST['siscd_enc']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>