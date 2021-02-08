<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCntApplRomt")) { 
	
	if ( $_POST['cntapplromt_cntappl'] != '') {
		
			$__enc = Enc_Rnd($_POST['cntapplromt_nm'].'-'.$_POST['cntapplromt_wtlve']);
			
			$insertSQL = sprintf("INSERT INTO ".TB_CNT_APPL_ROMT." (cntapplromt_enc, cntapplromt_cntappl, cntapplromt_nm, cntapplromt_wtlve) VALUES (%s, (SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = %s), %s, %s)",
	                       GtSQLVlStr($__enc, "text"),
	                       GtSQLVlStr($_POST['cntapplromt_cntappl'], "int"),
						   GtSQLVlStr(ctjTx($_POST['cntapplromt_nm'],'out'), "text"),
						   GtSQLVlStr($_POST['cntapplromt_wtlve'], "int"));
			
			
			$Result = $__cnx->_prc($insertSQL); 
			
	 		if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['err'] = $__cnx->c_p->error;
			}				
			
	}else{
		
		$rsp['m'] = 8;
			
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCntApplRomt")) { 

		$updateSQL = sprintf("UPDATE ".TB_CNT_APPL_ROMT." SET cntapplromt_nm=%s, cntapplromt_wtlve=%s WHERE cntapplromt_enc=%s",
						   GtSQLVlStr(ctjTx($_POST['cntapplromt_nm'],'out'), "text"),
						   GtSQLVlStr($_POST['cntapplromt_wtlve'], "int"),
	                       GtSQLVlStr($_POST['cntapplromt_enc'], "text"));
		
		$Result = $__cnx->_prc($updateSQL); 
		
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
	 	}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
		} 
		
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdCntApplRomt'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_CNT_APPL_ROMT.' WHERE cntapplromt_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	
	$Result = $__cnx->_prc($deleteSQL); 
	if($Result){
		$rsp['e'] = 'ok'; 
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}
?>