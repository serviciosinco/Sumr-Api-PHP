<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisPs")) { 	
	
	$__enc = Enc_Rnd($_POST['sisps_tt']);		
		
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_PS." (sisps_enc, sisps_tt, sisps_lng, sisps_iso2, sisps_iso3, sisps_cia, sisps_tel, sisps_int) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($_POST['sisps_tt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sisps_lng'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sisps_iso2'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sisps_iso3'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sisps_cia'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sisps_tel'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sisps_int'],'out'), "text"));
                   
	
	
	$Result = $__cnx->_prc($insertSQL);
		if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(499, $_POST['sisps_tt'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['sm'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisPs")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_PS." SET sisps_tt=%s, sisps_lng=%s, sisps_iso2=%s, sisps_iso3=%s, sisps_cia=%s, sisps_tel=%s, sisps_int=%s WHERE sisps_enc=%s",
						GtSQLVlStr(ctjTx($_POST['sisps_tt'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['sisps_lng'],'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['sisps_iso2'],'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['sisps_iso3'],'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['sisps_cia'],'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['sisps_tel'],'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['sisps_int'],'out'), "text"),
						GtSQLVlStr($_POST['sisps_enc'], "text"));
						
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(500, $_POST['sisps_tt'], $_POST['id_sisps']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_sisps'])) && ($_POST['id_sisps'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisPs'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_SIS_PS.' WHERE sisps_enc=%s', GtSQLVlStr($_POST['sisps_enc'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 $rsp['a'] = Aud_Sis(Aud_Dsc(501, $_POST['sisps_tt'], $_POST['id_sisps']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>