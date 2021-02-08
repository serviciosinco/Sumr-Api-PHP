<?php $pth = '../../'; include('../_inc.php');
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdTwQus")) {
	 
	$updateSQL = sprintf("UPDATE hsh_msg SET hshmsg_qus=%s WHERE hshmsg_id=%s",
						   GtSQLVlStr(1, "int"),
						   GtSQLVlStr($_POST['hshmsg_id'], "int"));							   
 	$Result = $__cnx->_prc($updateSQL); 
 	
	if($Result){ 		 
		$rsp['est'] = 'ok';
	}else{ 		 
		$rsp['est'] = 'no';
	}

	$__cnx->_clsr($Result);
	
// Elimino el Registro
}else if ((isset($_POST['id_hshmsg'])) && ($_POST['id_hshmsg'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdTwQus'))) { 
	
	$updateSQL = sprintf("UPDATE hsh_msg SET hshmsg_qus=%s WHERE id_hshmsg=%s",
						   GtSQLVlStr(2, "int"),
						   GtSQLVlStr($_POST['id_hshmsg'], "int"));							    
 	$Result = $__cnx->_prc($updateSQL); 
 	
	if($Result){ 		 
		$rsp['est'] = 'ok';
	}else{ 		 
		$rsp['est'] = 'no';
	}
	
	$__cnx->_clsr($Result);
	
}else{ 		 
		$rsp['est'] = 'no';
		$rsp['msg'] = 2; 
}

$rtrn = json_encode($rsp); header('Content-type: application/json'); echo $rtrn;
?>