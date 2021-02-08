<?php 
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdLrnVd")) { 
		
		$__enc = Enc_Rnd($_POST['lrnvd_tt']." - ".$_POST['lrnvd_url']." - ".$_POST['lrnvd_dsc']);
		
		$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_LRN_VD." (lrnvd_enc, lrnvd_tt, lrnvd_dsc, lrnvd_url, lrnvd_e, lrnvd_lrn) VALUES (%s, %s, %s, %s,%s,(SELECT id_lrn FROM ".TB_LRN." WHERE lrn_enc = %s))",
                     	GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
                    	GtSQLVlStr(ctjTx($_POST['lrnvd_tt'], 'out'), "text"),
                    	GtSQLVlStr(ctjTx($_POST['lrnvd_dsc'], 'out'), "text"),
                    	GtSQLVlStr(ctjTx($_POST['lrnvd_url'], 'out'), "text"),
                    	GtSQLVlStr( _NoNll(Html_chck_vl($_POST['lrnvd_e'])) , "int"),
                    	GtSQLVlStr(ctjTx($_POST['lrnvd_lrn'], 'out'), "text"));
			
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
	
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdLrnVd")) {
		
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_LRN_VD." SET lrnvd_tt=%s, lrnvd_dsc=%s, lrnvd_url=%s, lrnvd_e=%s WHERE lrnvd_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['lrnvd_tt'], 'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['lrnvd_dsc'], 'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['lrnvd_url'], 'out'), "text"),
					   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['lrnvd_e'])) , "int"),
					   GtSQLVlStr(ctjTx($_POST['lrnvd_enc'], 'out'), "text"));

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
	
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdLrnVd'))) { 
		$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_LRN_VD." WHERE lrnvd_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}
	
?>