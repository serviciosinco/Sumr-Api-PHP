<?php 
// Modificación de Registro 
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisTraEst")) { 
		
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_TRA." SET tra_est=%s, tra_chk_rsp=%s WHERE tra_enc=%s",
								GtSQLVlStr($_POST['tra_est'], "int"),
								GtSQLVlStr(2, "int"),
								GtSQLVlStr($_POST['tra_enc'], "text"));
													
	$Result = $__cnx->_prc($updateSQL);
	//echo $updateSQL;
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
?>