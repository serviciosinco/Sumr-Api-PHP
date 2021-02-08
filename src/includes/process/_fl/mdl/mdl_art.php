<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlArt")) { 
$insertSQL = sprintf("INSERT INTO ".MDL_ART_TB." (id_art, art_tt, art_dsc, art_fn) VALUES (%s, %s, %s, %s)",
                       GtSQLVlStr($_POST['id_sid_artistp'], "int"),
					   GtSQLVlStr(ctjTx($_POST['art_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['art_dsc'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['art_fn'],'out'), "text"));		
		
		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
			//$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(142, $_POST['cd_tt'], $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlArt")) { 
	
	$updateSQL = sprintf("UPDATE ".MDL_ART_TB." SET art_tt=%s, art_dsc=%s, art_fn=%s WHERE art_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['art_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['art_dsc'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['art_fn'],'out'), "text"),
					   GtSQLVlStr($_POST['art_enc'], "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_art'])) && ($_POST['id_art'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlArt'))) { 
	$deleteSQL = sprintf('DELETE FROM '.MDL_ART_TB.' WHERE id_art=%s', GtSQLVlStr($_POST['id_art'], 'int'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 //$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>