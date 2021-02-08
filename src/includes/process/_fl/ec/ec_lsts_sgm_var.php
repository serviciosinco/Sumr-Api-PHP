<?php 	
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEcLstsSgmVar")) { 


		$insertSQL = sprintf("INSERT INTO ".MDL_EC_LSTS_SGM_VAR_BD." (eclstssgmvar_sgm, eclstssgmvar_var, eclstssgmvar_rq, eclstssgmvar_vl) VALUES (%s, %s, %s, %s)",
					   GtSQLVlStr($_POST['eclstssgmvar_sgm'], "int"),
					   GtSQLVlStr($_POST['eclstssgmvar_var'], "int"),
					   GtSQLVlStr(_NoNll(Html_chck_vl($_POST['eclstssgmvar_rq'])), "int"),
					   GtSQLVlStr(ctjTx($_POST['eclstssgmvar_vl'], 'out'), "text"));
					   	
		$Result = $__cnx->_prc($insertSQL);
 		
 		if($Result){
	 		
	 		//$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(548, 'Variable de listas de segmento de E Commerce', $__cnx->c_p->insert_id), $rsp['v']);
			
		}else{
			$rsp['qry'] = $__cnx->c_p->error.$insertSQL;
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(array('p'=>$insertSQL, 'd'=>$__cnx->c_p->error));
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEcLstsSgmVar")) { 
	$updateSQL = sprintf("UPDATE ".MDL_EC_LSTS_SGM_VAR_BD." SET eclstssgmvar_sgm=%s, eclstssgmvar_var=%s, eclstssgmvar_rq=%s, eclstssgmvar_vl=%s WHERE id_eclstssgmvar=%s",						
	                    GtSQLVlStr($_POST['eclstssgmvar_sgm'], "int"),
	                    GtSQLVlStr($_POST['eclstssgmvar_var'], "int"),
	                    GtSQLVlStr(_NoNll(Html_chck_vl($_POST['eclstssgmvar_rq'])), "int"),
	                    GtSQLVlStr(ctjTx($_POST['eclstssgmvar_vl'], 'out'), "text"),	                    
						GtSQLVlStr($_POST['id_eclstssgmvar'], "int"));
	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(549, 'Variable de listas de segmento de E Commerce', $_POST['id_eclstssgmvar']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['w'] = $__cnx->c_p->error;
		$rsp['m'] = 2;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	} 
}

// Elimino el Registro
if ((isset($_POST['id_eclstssgmvar'])) && ($_POST['id_eclstssgmvar'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEcLstsSgmVar'))) { 
	$deleteSQL = sprintf('DELETE FROM '.MDL_EC_LSTS_SGM_VAR_BD.' WHERE id_eclstssgmvar=%s', GtSQLVlStr($_POST['id_eclstssgmvar'], 'int'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	$rsp['a'] = Aud_Sis(Aud_Dsc(550, 'Variable de listas de segmento de E Commerce', $_POST['id_eclstssgmvar']), $rsp['v']);
	 }else{ $rsp['e'] = 'no'; $rsp['m'] = 2; _ErrSis(array('p'=>$deleteSQL, 'd'=>$__cnx->c_p->error));}
}
?>