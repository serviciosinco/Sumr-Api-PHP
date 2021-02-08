<?php $pth = '../../'; include('../_inc.php');
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdTwMsg")) {
 
$insertSQL = sprintf("INSERT INTO hsh_msg (hshmsg_hsh, hshmsg_tp, hshmsg_createdat, hshmsg_idstr, hshmsg_id, hshmsg_us, hshmsg_profileimageurl, hshmsg_source, hshmsg_fromusername, hshmsg_fromuser, hshmsg_text, hshmsg_media, hshmsg_fi, hshmsg_hi) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					   GtSQLVlStr($_POST['hshmsg_hsh'],"int"),
					   GtSQLVlStr($_POST['hshmsg_tp'],"int"),
					   GtSQLVlStr(ctjTx($_POST['hshmsg_createdat'],'out'),"text"),
                       GtSQLVlStr(ctjTx($_POST['hshmsg_idstr'],'out'),"text"),
					   GtSQLVlStr(ctjTx($_POST['hshmsg_id'],'out'),"text"),
                       GtSQLVlStr(ctjTx($_POST['hshmsg_us'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['hshmsg_profileimageurl'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['hshmsg_source'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['hshmsg_fromusername'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['hshmsg_fromuser'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['hshmsg_text'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['hshmsg_media'],'out'), "text"),
					   GtSQLVlStr(SIS_F, "date"),
					   GtSQLVlStr(SIS_H2, "date"));							   
 $Result = $__cnx->_prc($insertSQL);
 	
	if($Result){ 		 
		$rsp['est'] = 'ok';
		$rsp['msg'] = 'si se procesa';
	}else{ 		 
		$rsp['est'] = 'no';
		$rsp['msg'] = 'no se procesa'; 
		$rsp['wrg'] = $__cnx->-c_r->error; 
	}
	$__cnx->_clsr($Result);
// Elimino el Registro
}else if ((isset($_POST['id_hshmsg'])) && ($_POST['id_hshmsg'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdTwMsg'))) { 

	$deleteSQL = sprintf('DELETE FROM hsh_msg WHERE id_hshmsg=%s',                      
	GtSQLVlStr($_POST['id_hshmsg'], 'int'));
	$Result = $__cnx->_prc($deleteSQL);
		if($Result){ 		 
			$rsp['est'] = 'ok';
			$rsp['msg'] = 1;
		}else{ 		 
			$rsp['est'] = 'no';
			$rsp['msg'] = 2; 
		}
	$__cnx->_clsr($Result);
}else{ 		 
		$rsp['est'] = 'no';
		$rsp['msg'] = 2; 
}

$rtrn = json_encode($rsp); header('Content-type: application/json'); echo $rtrn;
?>