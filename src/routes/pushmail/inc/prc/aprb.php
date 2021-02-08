<?php 
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "AprbCom")) { 
		
		$__usd = GtUsDt( Php_Ls_Cln($_POST['_us']), 'enc');
		$__ecd = GtEcDt( Php_Ls_Cln($_POST['_ec']), 'enc');
		
		$insertSQL = sprintf("INSERT INTO ".TB_EC_CMNT." (eccmnt_ec, eccmnt_cmnt, eccmnt_us) VALUES (%s, %s, %s)",
		               GtSQLVlStr($__ecd->id, "date"),
		               GtSQLVlStr(ctjTx($_POST['_tx'],'out'), "text"),
					   GtSQLVlStr($__usd->id, "text"));

		$Result = $__cnx->_prc($insertSQL);
		
 		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			//$rsp['w'] = $__cnx->c_p->error;
		}	
		
		$__cnx->_clsr($Result);	
		
	}
	
	
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "Aprb")) { 
		
		$__usd = GtUsDt( Php_Ls_Cln($_POST['_us']), 'enc');
		$__ecd = GtEcDt( Php_Ls_Cln($_POST['_ec']), 'enc');
		
		if(!isN($__usd->id) && !isN($__ecd->id)){
			$updateSQL = sprintf("UPDATE ".TB_EC." SET ec_est=%s WHERE id_ec=%s",
							   GtSQLVlStr(_CId('ID_SISEST_APRB'), "int"),
							   GtSQLVlStr($__ecd->id, "int"));
			$Result = $__cnx->_prc($updateSQL);
		}
		
 		if($Result){
			$rsp['e'] = 'ok';
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] =  $__cnx->c_r->error;
		}
		
		$__cnx->_clsr($Result);			
		
	}

?>