<?php 
if ((isset($_POST['MMR_insert'])) && ($_POST['MMR_insert'] == 'EdEmpGrp')){

	$insertSQL = sprintf("INSERT INTO ".MDL_EMP_GRP_BD." (empgrprlc_grp, empgrprlc_emp) VALUES (%s, %s)", GtSQLVlStr($_POST['id_rlc'], 'int'),GtSQLVlStr($_POST['id_sds'], 'int'));
	
	$Result = $__cnx->_prc($insertSQL); echo $__cnx->c_p->error;
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;	

	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['p'] = $__cnx->c_p->error;
	}
}

// Elimino de Imagen
if(isset($_POST['MMR_delete'])&&($_POST['MMR_delete'] == 'EdEmpGrp')){

	/*$__prc = Php_Ls_Cln($_POST['tp_prc']);
	if($__prc == 'clf'){ $_bd = 'sim__evn_clf_rlc'; $_prfx = 'evnclfrlc'; }*/

	$deleteSQL = sprintf("DELETE FROM ".MDL_EMP_GRP_BD." WHERE empgrprlc_grp=%s AND empgrprlc_emp=%s", GtSQLVlStr($_POST['id_rlc'], 'int'),GtSQLVlStr($_POST['id_sds'], 'int'));
	
	$Result = $__cnx->_prc($deleteSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	}
}
	
?>
