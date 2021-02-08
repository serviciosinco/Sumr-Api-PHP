<?php 	

$__Atmt = new CRM_Atmt(); 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdAtmtTrgrAct")) { 
		
		$__enc = Enc_Rnd($_POST['atmttrgract_v_ls'].'-'.$_POST['atmttrgract_act'].'-'.$_POST['atmttrgract_trgr'].'-'.SISUS_ID);
		
		$insertSQL = sprintf("INSERT INTO "._BdStr(DBA).TB_ATMT_TRGR_ACT." (atmttrgract_enc, atmttrgract_v_ls, atmttrgract_act, atmttrgract_trgr) VALUES (%s, %s, (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc=%s), (SELECT id_atmttrgr FROM "._BdStr(DBA).TB_ATMT_TRGR." WHERE atmttrgr_enc=%s))",
					   GtSQLVlStr($__enc, "text"),
					   GtSQLVlStr(ctjTx($_POST['atmttrgract_v_ls'],'out'), "text"),
					   GtSQLVlStr($_POST['atmttrgract_act'], "text"),
					   GtSQLVlStr($_POST['atmttrgract_trgr'], "text")); 
		
		//$rsp['q'] = $insertSQL;
					   	
		
		$Result = $__cnx->_prc($insertSQL); 
 		
 		if($Result){	
	 		//$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;		
			
			if(!isN($_POST['atmttrgract_trgr'])){	
				$PrcDt = $__Atmt->_Trgr_Upd([ 'enc'=>$_POST['atmttrgract_trgr'], 'fa'=>SIS_F_D2 ]);
				$rsp['p'] = $PrcDt;
			}
		
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(array('p'=>$insertSQL, 'd'=>$__cnx->c_p->error));
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdAtmtTrgrAct")) { 
	
	if(!isN($_POST['atmttrgract_hbl'])){ $_hbl=$_POST['atmttrgract_hbl']; }else{ $_hbl=2; }
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBA).TB_ATMT_TRGR_ACT." SET atmttrgract_v_ls=%s, atmttrgract_hbl=%s, atmttrgract_act=(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc=%s), atmttrgract_trgr=(SELECT id_atmttrgr FROM "._BdStr(DBA).TB_ATMT_TRGR." WHERE atmttrgr_enc=%s) WHERE atmttrgract_enc=%s",			
	                    GtSQLVlStr(ctjTx($_POST['atmttrgract_v_ls'],'out'), "text"),
	                    GtSQLVlStr($_hbl, "int"),
	                    GtSQLVlStr($_POST['atmttrgract_act'], "text"),
						GtSQLVlStr($_POST['atmttrgract_trgr'], "text"),
						GtSQLVlStr($_POST['atmttrgract_enc'], "text"));
	 
	$Result = $__cnx->_prc($updateSQL);

	if($Result){
		
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(257, $_POST['atmttrgract_v_ls'], $_POST['id_atmttrgract']), $rsp['v']);
		
		if(!isN($_POST['atmttrgract_trgr'])){	
			$PrcDt = $__Atmt->_Trgr_Upd([ 'enc'=>$_POST['atmttrgract_trgr'], 'fa'=>SIS_F_D2 ]);
			$rsp['p'] = $PrcDt;
		}
		
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	} 
}

// Elimino el Registro
if ((isset($_POST['id_atmttrgract'])) && ($_POST['id_atmttrgract'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdAtmtTrgrAct'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBA).TB_ATMT_TRGR_ACT.' WHERE id_atmttrgract=%s', GtSQLVlStr($_POST['id_atmttrgract'], 'int'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	//$rsp['a'] = Aud_Sis(Aud_Dsc(258, $_POST['atmttrgract_v_ls'], $_POST['id_atmttrgract']), $rsp['v']);
	 }else{ $rsp['e'] = 'no'; $rsp['m'] = 2; _ErrSis(array('p'=>$deleteSQL, 'd'=>$__cnx->c_p->error));}
}
?>