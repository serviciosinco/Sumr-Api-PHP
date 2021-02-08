<?php 
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdLrn")) { 
		
		$__enc = Enc_Rnd($_POST['lrn_tt']);
		
		$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_LRN." (lrn_enc, lrn_tt, lrn_dsc,lrn_e) VALUES (%s, %s, %s, %s)",
                    	GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
                    	GtSQLVlStr(ctjTx($_POST['lrn_tt'], 'out'), "text"),
                    	GtSQLVlStr(ctjTx($_POST['lrn_dsc'], 'out'), "text"),
                    	GtSQLVlStr($_POST['lrn_e'], "int"));
                    	
                    
                    	
			
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
		
	
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdLrn")) {
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_LRN." SET lrn_tt=%s, lrn_dsc=%s, lrn_e=%s WHERE lrn_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['lrn_tt'], 'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['lrn_dsc'], 'out'), "text"),
					   GtSQLVlStr($_POST['lrn_e'], "int"),
					   GtSQLVlStr(ctjTx($_POST['lrn_enc'], 'out'), "text"));
		               
		
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
	
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdLrn'))) { 
		$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_LRN." WHERE lrn_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}
	
?>