<?php 
	// Ingreso de Registro

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgVst")) { 
		
		$__enc = Enc_Rnd($_POST['orgvst_us'].' - '.$_POST['orgvst_obs']);

		$insertSQL = sprintf("INSERT INTO ".TB_ORG_VST." (orgvst_enc, orgvst_us, orgvst_cnt, orgvst_f, orgvst_h, orgvst_tp, orgvst_est, orgvst_obs, orgvst_pln, orgvst_rxc, orgvst_grn, orgvst_org ) 
														VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, (SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc = %s) )",

						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['orgvst_us'], 'out'), "int"),
						GtSQLVlStr(ctjTx($_POST['orgvst_cnt'], 'out'), "int"),
						GtSQLVlStr(ctjTx($_POST['orgvst_f'], 'out'), "date"),
						GtSQLVlStr(ctjTx($_POST['orgvst_h'], 'out'), "date"),
						GtSQLVlStr(ctjTx($_POST['orgvst_tp'], 'out'), "int"),
						GtSQLVlStr(ctjTx($_POST['orgvst_est'], 'out'), "int"),
						GtSQLVlStr(ctjTx($_POST['orgvst_obs'], 'out'), "text"),
						GtSQLVlStr( Html_chck_vl($_POST['orgvst_pln']) , "int"),	
						GtSQLVlStr( Html_chck_vl($_POST['orgvst_rxc']) , "int"),
						GtSQLVlStr( Html_chck_vl($_POST['orgvst_grn']) , "int"),
						GtSQLVlStr(ctjTx($_POST['orgvst_org'], 'out'), "text"));
			
		
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
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgVst")) {
		$updateSQL = sprintf("UPDATE ".TB_ORG_VST." SET  orgvst_us=%s, orgvst_cnt=%s, orgvst_f=%s, orgvst_h=%s, orgvst_tp=%s, orgvst_est=%s, orgvst_obs=%s, orgvst_pln=%s, orgvst_rxc=%s, orgvst_grn=%s,
		orgvst_fr=%s, orgvst_hr=%s, orgvst_aplz=%s, orgvst_rsl=%s, orgvst_tra=%s, orgvst_ofr=%s WHERE orgvst_enc=%s",
						GtSQLVlStr(ctjTx($_POST['orgvst_us'], 'out'), "int"),
						GtSQLVlStr(ctjTx($_POST['orgvst_cnt'], 'out'), "int"),
						GtSQLVlStr(ctjTx($_POST['orgvst_f'], 'out'), "date"),
						GtSQLVlStr(ctjTx($_POST['orgvst_h'], 'out'), "date"),
						GtSQLVlStr(ctjTx($_POST['orgvst_tp'], 'out'), "int"),
						GtSQLVlStr(ctjTx($_POST['orgvst_est'], 'out'), "int"),
						GtSQLVlStr(ctjTx($_POST['orgvst_obs'], 'out'), "text"),
						GtSQLVlStr( Html_chck_vl($_POST['orgvst_pln']) , "int"),	
						GtSQLVlStr( Html_chck_vl($_POST['orgvst_rxc']) , "int"),
						GtSQLVlStr( Html_chck_vl($_POST['orgvst_grn']) , "int"),

						GtSQLVlStr(ctjTx($_POST['orgvst_fr'], 'out'), "date"),
						GtSQLVlStr(ctjTx($_POST['orgvst_hr'], 'out'), "date"),
						GtSQLVlStr(ctjTx($_POST['orgvst_aplz'], 'out'), "int"),
						GtSQLVlStr(ctjTx($_POST['orgvst_rsl'], 'out'), "text"),

						GtSQLVlStr( Html_chck_vl($_POST['orgvst_tra']) , "int"),
						GtSQLVlStr( Html_chck_vl($_POST['orgvst_ofr']) , "int"),

					   	GtSQLVlStr(ctjTx($_POST['orgvst_enc'], 'out'), "text"));
		

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
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgVst'))) { 
		$deleteSQL = sprintf("DELETE FROM ".TB_ORG_VST." WHERE orgvst_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}
?>