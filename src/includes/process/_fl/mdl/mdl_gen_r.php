<?php
	
// Ingreso de Imagen del Banco
if ((isset($_POST['MMR_insert'])) && ($_POST['MMR_insert'] == 'EdProGenProRlc')){
	$__prc = Php_Ls_Cln($_POST['tp_prc']);
	if($__prc == 'clggrp'){ $_bd = '_pro_gen_pro_rlc'; }
	
	$insertSQL = sprintf("INSERT INTO {$_bd} (progenprorlc_prorlc, progenprorlc_progen, progenprorlc_fi) VALUES (%s, %s, %s)", GtSQLVlStr($_POST['id_rlc'], 'int'),GtSQLVlStr($_POST['id_clg'], 'int'), GtSQLVlStr(SIS_F, 'date'));
	$Result = $__cnx->_prc($insertSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;	
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	}
}

// Elimino de Imagen
if(isset($_POST['MMR_delete'])&&($_POST['MMR_delete'] == 'EdProGenProRlc')){
	
	$_bd = '_pro_gen_pro_rlc';

	$deleteSQL = sprintf("DELETE FROM {$_bd} WHERE progenprorlc_prorlc=%s AND progenprorlc_progen=%s", GtSQLVlStr($_POST['id_rlc'], 'int'),GtSQLVlStr($_POST['id_clg'], 'int'));
	
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