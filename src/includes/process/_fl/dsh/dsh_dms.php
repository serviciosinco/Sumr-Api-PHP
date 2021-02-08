<?php  
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdDshDms")) { 
		
		$__enc = Enc_Rnd($_POST['dshdms_tt'].'-'.'Dimensiones');
		
		$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_DSH_DMS." (dshdms_enc, dshdms_tt) VALUES (%s, %s)",
						GtSQLVlStr(ctjTx($__enc,'out'), "text"),			
						GtSQLVlStr(ctjTx($_POST['dshdms_tt'],'out'), "text"));	
		$Result = $__cnx->_prc($insertSQL);

		

		
 		if($Result){
	 		foreach($_POST['dshdms_grph'] as $_v){
			    $updateSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_DSH_GRPH_DMS." (dshgrphdms_grph, dshgrphdms_dms) VALUES (%s, %s)",
						GtSQLVlStr($_v, 'int'),
						GtSQLVlStr($rsp['i'], 'int'));
				$Result_Upd = $__cnx->_prc($updateSQL);
		    }
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(460, $_POST['sismtr_tt'], $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdDshDms")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_DSH_DMS." SET dshdms_tt=%s WHERE dshdms_enc=%s",
						GtSQLVlStr(ctjTx($_POST['dshdms_tt'],'out'), "text"),
						GtSQLVlStr($_POST['dshdms_enc'], 'text'));
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['i'] = $_POST['dshdms_enc'];

		$_dms_grph =  implode(',', $_POST['dshdms_grph']);
		$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_DSH_GRPH_DMS." WHERE dshgrphdms_dms = (SELECT id_dshdms FROM "._BdStr(DBM).TB_DSH_DMS." WHERE dshdms_enc = %s) AND dshgrphdms_grph NOT IN (%s)",
					GtSQLVlStr($_POST['dshdms_enc'], 'text'),
					GtSQLVlStr($_dms_grph, 'int'));
		$Result_Eli = $__cnx->_prc($deleteSQL);
		
		if($_POST['dshdms_grph'] != NULL && $_POST['dshdms_grph'] != ''){
			foreach($_POST['dshdms_grph'] as $_v){
				    $updateSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_DSH_GRPH_DMS." (dshgrphdms_grph, dshgrphdms_dms) VALUES (%s, (SELECT id_dshdms FROM "._BdStr(DBM).TB_DSH_DMS." WHERE dshdms_enc = %s))",
							GtSQLVlStr($_v, 'int'),
							GtSQLVlStr($rsp['i'], 'text'));
					$Result_Upd = $__cnx->_prc($updateSQL);
			}
		}
	    
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
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdDshDms'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_DSH_DMS.' WHERE dshdms_enc=%s', GtSQLVlStr($_POST['uid'], 'int'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		 //$rsp['a'] = Aud_Sis(Aud_Dsc(462, $_POST['sismtr_tt'], $_POST['id_grph']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>