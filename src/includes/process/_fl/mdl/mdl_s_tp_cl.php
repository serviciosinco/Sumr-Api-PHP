<?php
	
// Ingreso de Imagen del Banco
if ((isset($_POST['MMR_insert'])) && ($_POST['MMR_insert'] == 'EdMdlTpCl')){
	
	$__Cl = new CRM_Cl(); 
	$__Cl->mdlstpcl_mdlstp = Php_Ls_Cln($_POST['id_tp']);
	$__Cl->mdlstpcl_cl = Php_Ls_Cln($_POST['id_rlc']);
	
	$PrcDt = $__Cl->MdlSTpCl_In(); 
	$rsp = $PrcDt;		
}


// Elimino de Imagen
if(isset($_POST['MMR_delete'])&&($_POST['MMR_delete'] == 'EdMdlTpCl')){
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_MDL_S_TP_CL." WHERE mdlstpcl_mdlstp=%s AND mdlstpcl_cl=%s", GtSQLVlStr($_POST['id_tp'], "int"),	GtSQLVlStr($_POST['id_rlc'], "int"));
	
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