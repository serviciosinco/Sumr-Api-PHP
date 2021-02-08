<?php
	
// Ingreso de Imagen del Banco
if ((isset($_POST['MMR_insert'])) && ($_POST['MMR_insert'] == 'EdUsMdl')){

	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_US_CL." (uscl_us, uscl_cl) VALUES (%s, %s)",
					GtSQLVlStr($_POST['id_sds'], "int"),	
					GtSQLVlStr($_POST['id_rlc'], "int"));
	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;	
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['p'] = $__cnx->c_p->error;
	}
	$__cnx->_clsr($Result);
}


// Elimino de Imagen
if(isset($_POST['MMR_delete'])&&($_POST['MMR_delete'] == 'EdUsMdl')){

	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_US_CL." WHERE uscl_us=%s AND uscl_cl=%s", GtSQLVlStr($_POST['id_sds'], "int"),	GtSQLVlStr($_POST['id_rlc'], "int"));
	$Result = $__cnx->_prc($deleteSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	}
	$__cnx->_clsr($Result);
}

?>