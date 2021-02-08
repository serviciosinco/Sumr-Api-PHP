<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlUs")) { 

	$__enc = Enc_Rnd( $_POST['mdlus_mdl'].'-'.$_POST['mdlstp_nm'] ); 
	
	$insertSQL = sprintf("INSERT INTO ".TB_MDL_US." (mdlus_enc, mdlus_mdl, mdlus_us, mdlus_tp) VALUES (%s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($_POST['mdlus_mdl'], "int"),
                       GtSQLVlStr($_POST['mdlus_us'], "int"),
                       GtSQLVlStr($_POST['mdlus_tp'], "int"));
	
	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;			
		//$rsp['i'] = $__enc;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['er'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
    }
    
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlUs")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_MDL_US." SET mdlus_mdl=%s, mdlus_us=%s, mdlus_tp=%s WHERE mdlus_enc=%s",
						GtSQLVlStr($_POST['mdlus_mdl'], "int"),
						GtSQLVlStr($_POST['mdlus_us'], "int"),
						GtSQLVlStr($_POST['mdlus_tp'], "int"),
						GtSQLVlStr($_POST['mdlus_enc'], "text"));
	
    $Result = $__cnx->_prc($updateSQL); 
    
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(482, $_POST['mdlus_mdl'], $_POST['id_mdls']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
    } 
    
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlUs'))) { 
	$deleteSQL = sprintf("DELETE FROM ".TB_MDL_US." WHERE mdlus_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 $rsp['a'] = Aud_Sis(Aud_Dsc(483, $_POST['mdlus_mdl'], $_POST['id_mdls']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>