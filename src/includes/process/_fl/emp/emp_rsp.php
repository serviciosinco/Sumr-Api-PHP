<?php
	
// Ingreso de Imagen del Banco
if ((isset($_POST['MMR_insert'])) && ($_POST['MMR_insert'] == 'EdEmpRsp')){
	
	$insertSQL = sprintf("INSERT INTO ".TB_EMP_RSP." (emprsp_rsp, emprsp_emp) VALUES (%s, %s)", GtSQLVlStr($_POST['id_rlc'], 'int'),GtSQLVlStr($_POST['id_sds'], 'int'));
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
if(isset($_POST['MMR_delete'])&&($_POST['MMR_delete'] == 'EdEmpRsp')){
	
	$deleteSQL = sprintf("DELETE FROM ".TB_EMP_RSP." WHERE emprsp_rsp=%s AND emprsp_emp=%s", GtSQLVlStr($_POST['id_rlc'], 'int'),GtSQLVlStr($_POST['id_sds'], 'int'));
	
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