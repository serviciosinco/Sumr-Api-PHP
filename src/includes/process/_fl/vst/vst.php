<?php 
	// Ingreso de Registro

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlCntVst")) { 
		
		global $__cnx;
		
		$__enc = Enc_Rnd($_POST['vst_obs']);
		$enc = $_POST['mdlcntvst_mdlcnt'];
	
	$insertSQL = sprintf("INSERT INTO ".TB_VST." (vst_enc, vst_us, vst_cnt , vst_tp, vst_f, vst_h, vst_rxc, vst_obs,vst_est ,vst_dir) VALUES (%s, %s, (SELECT mdlcnt_cnt FROM ".TB_MDL_CNT." 
						WHERE mdlcnt_enc = %s),  %s, %s, %s, %s , %s, %s, %s)",
                    	GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
                    	GtSQLVlStr($_POST['vst_us'],"int"),
						GtSQLVlStr(ctjTx($enc, 'out'), "text"),
                    	GtSQLVlStr($_POST['vst_tp'],"int"),
                    	GtSQLVlStr(ctjTx($_POST['vst_f'], 'out'), "text"),
                    	GtSQLVlStr(ctjTx($_POST['vst_h'], 'out'), "text"),
                    	GtSQLVlStr($_POST['vst_rxc'], "int"),
                      	GtSQLVlStr(ctjTx($_POST['vst_obs'], 'out'), "text"),
                      	GtSQLVlStr($_POST['vst_est'], "int"),
                    	GtSQLVlStr(ctjTx($_POST['vst_dir'], 'out'), "text"));

		$Result = $__cnx->_prc($insertSQL);

		if($Result){
	 		
		 	$_id = $__cnx->c_p->insert_id;
		 	
		 	$enc = $_POST['mdlcntvst_mdlcnt'];
		 	$__enc = Enc_Rnd($_POST['vst_obs']);
		 		
			$insertSQL1 = sprintf("INSERT INTO ".TB_MDL_CNT_VST." (mdlcntvst_enc, mdlcntvst_mdlcnt, mdlcntvst_vst) VALUES (%s, (SELECT id_mdlcnt FROM ".TB_MDL_CNT." 
							WHERE mdlcnt_enc = %s),%s)",
	                    	GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
	                    	GtSQLVlStr(ctjTx($enc, 'out'), "text"),
	                    	GtSQLVlStr($_id,"int"));

			$Result = $__cnx->_prc($insertSQL1);
			
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			
		}else{
			$rsp['e'] = 'no';
			
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
		$__cnx->_clsr($Result);
		
	}
	
	// Modificación de Registro primero este
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlCntVst")) {
		
		global $__cnx;
		
		$updateSQL = sprintf("UPDATE ".TB_VST."  SET vst_us = %s, vst_tp = %s, vst_f = %s, vst_h = %s, vst_rxc = %s, vst_obs = %s , vst_est = %s ,vst_dir = %s WHERE vst_enc=%s",
		
						GtSQLVlStr($_POST['vst_us'],"int"),
                    	GtSQLVlStr($_POST['vst_tp'],"int"),
                    	GtSQLVlStr(ctjTx($_POST['vst_f'], 'out'), "text"),
                    	GtSQLVlStr(ctjTx($_POST['vst_h'], 'out'), "text"),
                    	GtSQLVlStr($_POST['vst_rxc'], "int"),
                      	GtSQLVlStr(ctjTx($_POST['vst_obs'], 'out'), "text"),
                      	GtSQLVlStr($_POST['vst_est'], "int"),
                    	GtSQLVlStr(ctjTx($_POST['vst_dir'], 'out'), "text"),
                    	GtSQLVlStr(ctjTx($_POST['vst_enc'], 'out'), "text"));

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
		
		$__cnx->_clsr($Result);
		
	}
	
		
	// Elimino el Registro
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlCntVst'))) { 
		
		global $__cnx;
		
		$deleteSQL = sprintf("DELETE FROM ".TB_VST." WHERE vst_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
			
		//$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
		
		$__cnx->_clsr($Result);
	}
?>