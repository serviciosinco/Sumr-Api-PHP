<?php

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCntApplAnx")) { 

		$updateSQL = sprintf("UPDATE ".TB_CNT_APPL_ANX." SET cntapplanx_est=%s WHERE cntapplanx_enc=%s",
						   GtSQLVlStr(ctjTx($_POST['cntapplanx_est'],'out'), "text"),	
	                       GtSQLVlStr($_POST['cntapplanx_enc'], "text"));
		
		$Result = $__cnx->_prc($updateSQL); 
		
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
	 	}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
		} 
		
}

?>