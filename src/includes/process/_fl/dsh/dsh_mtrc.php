<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdDshMtrc")) { 
		
		$__enc = Enc_Rnd($_POST['dshmtrc_tt'].'-'.$_POST['dshmtrc_qry_vl']);
		
		$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_DSH_MTRC." (dshmtrc_enc ,dshmtrc_tt, dshmtrc_qry, dshmtrc_qry_tt, dshmtrc_qry_vl, dshmtrc_qry_id, dshmtrc_qry_ctg) VALUES (%s, %s, %s, %s, %s, %s, %s)",
		 				GtSQLVlStr(ctjTx($__enc,'out'), "text"),
		 				GtSQLVlStr(ctjTx($_POST['dshmtrc_tt'],'out'), "text"),
		 				GtSQLVlStr(strip_tags(ctjTx($_POST['mtrc_qry'],'out')), "text"),
		 				GtSQLVlStr(ctjTx($_POST['dshmtrc_qry_tt'],'out'), "text"),
		 				GtSQLVlStr(ctjTx($_POST['dshmtrc_qry_vl'],'out'), "text"),
		 				GtSQLVlStr(ctjTx($_POST['dshmtrc_qry_id'],'out'), "text"),
		 				GtSQLVlStr(ctjTx($_POST['dshmtrc_qry_ctg'],'out'), "text"));	
		
		$Result = $__cnx->_prc($insertSQL);
		$rsp['i'] = $__enc;
		
 		if($Result){
	 		foreach($_POST['dshmtrc_dms'] as $_v){
			    $updateSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_DSH_DMS_MTRC." (dshdmsmtrc_dms, dshdmsmtrc_mtrc) VALUES (%s, (SELECT id_dshmtrc FROM "._BdStr(DBM).TB_DSH_MTRC." WHERE dshmtrc_enc = %s))",
						GtSQLVlStr($_v, 'int'),
						GtSQLVlStr($rsp['i'], 'text'));
				$Result_Upd = $__cnx->_prc($updateSQL);
		    }
		    
		    
		    foreach($_POST['dshmtrccl_cl'] as $_v_cl){
			    $updateSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_DSH_MTRC_CL." (dshmtrccl_cl, dshmtrccl_mtrc) VALUES (%s, (SELECT id_dshmtrc FROM "._BdStr(DBM).TB_DSH_MTRC." WHERE dshmtrc_enc = %s))",
					GtSQLVlStr($_v_cl, 'int'),
					GtSQLVlStr($rsp['i'], 'text'));
					$updateSQL = $__cnx->_prc($updateSQL);
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdDshMtrc")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_DSH_MTRC." SET dshmtrc_tt=%s, dshmtrc_qry=%s, dshmtrc_qry_tt=%s, dshmtrc_qry_vl=%s, dshmtrc_qry_id=%s, dshmtrc_qry_ctg=%s WHERE dshmtrc_enc=%s",
						GtSQLVlStr(ctjTx($_POST['dshmtrc_tt'],'out'), "text"),
						GtSQLVlStr(strip_tags(ctjTx($_POST['dshmtrc_qry'],'out')), "text"),
                       	GtSQLVlStr(ctjTx($_POST['dshmtrc_qry_tt'],'out'), "text"),
                       	GtSQLVlStr(ctjTx($_POST['dshmtrc_qry_vl'],'out'), "text"),
                       	GtSQLVlStr(ctjTx($_POST['dshmtrc_qry_id'],'out'), "text"),
                       	GtSQLVlStr(ctjTx($_POST['dshmtrc_qry_ctg'],'out'), "text"),
						GtSQLVlStr($_POST['dshmtrc_enc'], 'text'));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['i'] = $_POST['dshmtrc_enc'];
		
		$_dms_grph =  implode(',', $_POST['dshmtrc_dms']);
		$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_DSH_DMS_MTRC." WHERE dshdmsmtrc_mtrc = (SELECT id_dshmtrc FROM "._BdStr(DBM).TB_DSH_MTRC." WHERE dshmtrc_enc = %s) AND dshdmsmtrc_dms NOT IN (%s)",
					GtSQLVlStr($_POST['dshmtrc_enc'], 'text'),
					GtSQLVlStr($_dms_grph, 'text'));
			
		$Result_Eli = $__cnx->_prc($deleteSQL);
		
		$rsp['i'] = $_POST['dshmtrc_enc'];

		if($_POST['dshmtrc_dms'] != NULL && $_POST['dshmtrc_dms'] != ''){
			foreach($_POST['dshmtrc_dms'] as $_v){
				    $updateSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_DSH_DMS_MTRC." (dshdmsmtrc_dms, dshdmsmtrc_mtrc) VALUES (%s, (SELECT id_dshmtrc FROM "._BdStr(DBM).TB_DSH_MTRC." WHERE dshmtrc_enc = %s))",
							GtSQLVlStr($_v, 'int'),
							GtSQLVlStr($rsp['i'], 'text'));
					$Result_Upd = $__cnx->_prc($updateSQL);
			}
		}
		
		 
		$_mtrc_cl =  implode(',', $_POST['dshmtrccl_cl']);
		$deleteSQL_cl = sprintf("DELETE FROM "._BdStr(DBM).TB_DSH_MTRC_CL." WHERE dshmtrccl_mtrc = (SELECT id_dshmtrc FROM "._BdStr(DBM).TB_DSH_MTRC." WHERE dshmtrc_enc = %s) AND dshmtrccl_cl NOT IN (%s)",
					GtSQLVlStr($_POST['dshmtrc_enc'], 'text'),
					GtSQLVlStr($_mtrc_cl, 'int'));
		$Resul_Eli = $__cnx->_prc($deleteSQL_cl);
		

		if($_POST['dshmtrccl_cl'] != NULL && $_POST['dshmtrccl_cl'] != ''){
			foreach($_POST['dshmtrccl_cl'] as $_v_cl){
			    $updateSQL_Cl = sprintf("INSERT INTO "._BdStr(DBM).TB_DSH_MTRC_CL." (dshmtrccl_cl, dshmtrccl_mtrc) VALUES (%s, (SELECT id_dshmtrc FROM "._BdStr(DBM).TB_DSH_MTRC." WHERE dshmtrc_enc = %s))",
					GtSQLVlStr($_v_cl, 'int'),
					GtSQLVlStr($rsp['i'], 'text'));
					$Resul_Upd_Cl = $__cnx->_prc($updateSQL_Cl);
		    }
		    
		}
	    
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
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdDshMtrc'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_DSH_MTRC.' WHERE dshmtrc_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		 //$rsp['a'] = Aud_Sis(Aud_Dsc(462, $_POST['sismtr_tt'], $_POST['id_grph']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>