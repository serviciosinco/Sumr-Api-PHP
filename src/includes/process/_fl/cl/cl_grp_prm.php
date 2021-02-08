<?php
	
// Ingreso de Imagen del Banco
if ((isset($_POST['MMR_insert'])) && ($_POST['MMR_insert'] == 'EdUsGrpPrm')){
		$insertSQL = sprintf("INSERT INTO usgrp_grp (usgrpgrp_grp, usgrpgrp_us) VALUES (%s, %s)",
					   GtSQLVlStr($_POST['id_tp'], "int"),	
                       GtSQLVlStr($_POST['id_rlc'], "int"));
                   
		$Result = $__cnx->_prc($insertSQL); echo $__cnx->c_p->error;
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
			
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	}
}


// Elimino de Imagen
if(isset($_POST['MMR_delete'])&&($_POST['MMR_delete'] == 'EdUsGrpPrm')){
	$deleteSQL = sprintf("DELETE FROM usgrp_grp WHERE usgrpgrp_grp=%s AND usgrpgrp_us=%s", GtSQLVlStr($_POST['id_tp'], "int"),	GtSQLVlStr($_POST['id_rlc'], "int"));
	
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