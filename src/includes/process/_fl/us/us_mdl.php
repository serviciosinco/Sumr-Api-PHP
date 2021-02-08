<?php
	
// Ingreso de Imagen del Banco
if ((isset($_POST['MMR_insert'])) && ($_POST['MMR_insert'] == 'EdUsMdl')){
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_US_MDL." (usmdl_mdl, usmdl_us) VALUES (%s, %s)", GtSQLVlStr($_POST['id_rlc'], 'int'), GtSQLVlStr($_POST['id_sds'], 'int'));
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;	
		$rsp['p'] = $insertSQL;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['dp'] = $__cnx->c_p->error;
	}

}

// Elimino de Imagen
if(isset($_POST['MMR_delete'])&&($_POST['MMR_delete'] == 'EdUsMdl')){
	
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_US_MDL." WHERE usmdl_mdl=%s AND usmdl_us=%s", GtSQLVlStr($_POST['id_rlc'], 'int'), GtSQLVlStr($_POST['id_sds'], 'int'));
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