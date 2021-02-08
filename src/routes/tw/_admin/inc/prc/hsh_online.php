<?php $pth = '../../'; include('../_inc.php');

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdHshEst_On")) { 

	$updateSQL = sprintf("UPDATE hsh SET hsh_on=%s WHERE id_hsh=%s",
						   GtSQLVlStr(1, "text"),
						   GtSQLVlStr($_POST['id_hsh'], "int"));						   
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['est'] = 'ok';
		$rsp['msg'] = 1;
	}else{
		$rsp['est'] = 'no';
		$rsp['msg'] = 1;
	} 	
	
	$__cnx->_clsr($Result);
	
}elseif ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdHshEst_Off")) { 

	$updateSQL = sprintf("UPDATE hsh SET hsh_on=%s WHERE id_hsh=%s",
						   GtSQLVlStr(2, "text"),
						   GtSQLVlStr($_POST['id_hsh'], "int"));						   
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['est'] = 'ok';
		$rsp['msg'] = 1;
	}else{
		$rsp['est'] = 'no';
		$rsp['msg'] = 1;
	} 	
	
	$__cnx->_clsr($Result);
}else{
	$rsp['est'] = 'no';
	$rsp['msg'] = 1;
}

$rtrn = json_encode($rsp); header('Content-type: application/json'); echo $rtrn;
?>