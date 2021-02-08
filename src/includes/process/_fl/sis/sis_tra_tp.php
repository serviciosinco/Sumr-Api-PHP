<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdAbrTrsTp")) {

		$insertSQL = sprintf("INSERT INTO ".MDL_SIS_TRA_TP_BD." (id_tratp, tratp_nm) VALUES (%s, %s)",
					   GtSQLVlStr($_POST['id_tratp'], "int"),	
                       GtSQLVlStr(ctjTx($_POST['tratp_nm'],'out'), "text"));
					   		
		
		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
			//$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(83, $_POST['tratp_nm'], $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdAbrTrsTp")) { 
$updateSQL = sprintf("UPDATE ".MDL_SIS_TRA_TP_BD." SET tratp_nm=%s WHERE tratp_enc=%s",
                       GtSQLVlStr(ctjTx($_POST['tratp_nm'],'out'), "text"),
					   GtSQLVlStr($_POST['tratp_enc'], "text"));
					   
	
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(84, $_POST['tratp_nm'], $_POST['id_tratp']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_tratp'])) && ($_POST['id_tratp'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdAbrTrsTp'))) { 
	$deleteSQL = sprintf('DELETE FROM '.MDL_SIS_TRA_TP_BD.' WHERE tratp_enc=%s', GtSQLVlStr($_POST['tratp_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(85, $_POST['tratp_nm'], $_POST['id_tratp']), $rsp['v']);}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>