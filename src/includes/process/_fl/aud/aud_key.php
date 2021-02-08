<?php 
	// Ingreso de Registro
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdAudKey")) { 
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).MDL_AUD_KEY_BD." (audkey_key, audkey_post, audkey_auddsc) VALUES (%s, %s, %s)",
	                       GtSQLVlStr(ctjTx($_POST['audkey_key'],'out'), "text"),
	                       GtSQLVlStr(ctjTx($_POST['audkey_post'],'out'), "text"),
	                       GtSQLVlStr(ctjTx($_POST['audkey_auddsc'],'out'), "text"));		
				$Result = $__cnx->_prc($insertSQL);
	 		if($Result){
				//$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				//$rsp['a'] = Aud_Sis(Aud_Dsc(460, $_POST['dnctp_tt'], $__cnx->c_p->insert_id), $rsp['v']);
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
			}
	}
	
	// Modificación de Registro
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdAudKey")) { 
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).MDL_AUD_KEY_BD." SET audkey_key=%s, audkey_post=%s, audkey_auddsc=%s WHERE id_audkey=%s",
							GtSQLVlStr(ctjTx($_POST['audkey_key'],'out'), "text"),
	                        GtSQLVlStr(ctjTx($_POST['audkey_post'],'out'), "text"),
	                        GtSQLVlStr(ctjTx($_POST['audkey_auddsc'],'out'), "text"),
							GtSQLVlStr($_POST['id_audkey'], "int"));
		
		$Result = $__cnx->_prc($updateSQL); 
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(461, $_POST['sisexa_tt'], $_POST['id_sisexa']), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		} 
	}
	
	// Elimino el Registro
	if ((isset($_POST['id_audkey'])) && ($_POST['id_audkey'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdAudKey'))) { 
		$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).MDL_AUD_KEY_BD.' WHERE id_audkey=%s', GtSQLVlStr($_POST['id_audkey'], 'int'));
		 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
			 //$rsp['a'] = Aud_Sis(Aud_Dsc(462, $_POST['dnctp_tt'], $_POST['id_dnctp']), $rsp['v']);
		 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}
?>