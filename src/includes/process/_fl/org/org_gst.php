<?php 
	$___Ls->cnx->cl = 'ok';
		
		// Ingreso de Registro

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgGst")) { 
		
		$__enc = Enc_Rnd($_POST['orggst_dsc'].'-'.$_POST['orggst_tp']);
		
		$_fl = "( SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = '".$_POST['orggst_org']."' )";
		$insertSQL = sprintf("INSERT INTO  ".TB_ORG_GST." (orggst_enc, orggst_dsc, orggst_tp, orggst_us, orggst_org) VALUES (%s, %s, %s, %s, $_fl)",
                    	GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
                    	GtSQLVlStr(ctjTx($_POST['orggst_dsc'], 'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['orggst_tp'], 'out'), "int"),
						GtSQLVlStr(ctjTx(SISUS_ID, 'out'), "int"));
		
		$Result = $__cnx->_prc($insertSQL);	

 		if($Result){
	 		
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$_id = $__cnx->c_p->insert_id;
			
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
	}
	
	// Modificación de Registro primero este
	/*if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgDc")) {
		$updateSQL = sprintf("UPDATE ".TB_ORG_DC." SET orgdc_dc=%s, orgdc_tp=%s WHERE orgdc_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['orgdc_dc'], 'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['orgdc_tp'], 'out'), "int"),
					   GtSQLVlStr(ctjTx($_POST['orgdc_enc'], 'out'), "text"));

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
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgDc'))) { 
		$deleteSQL = sprintf("DELETE FROM ".TB_ORG_DC." WHERE orgdc_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}
	*/
?>