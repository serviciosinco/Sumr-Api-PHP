<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlCtrl")) { 
    
    $__mdl_d = GtMdlDt([ 'id'=>$_POST['mdlctrl_mdl'], 't'=>'enc' ]);

	$__enc = Enc_Rnd( $__mdl_d->id.'-'.$_POST['mdlctrl_tx'] ); 
	
	$insertSQL = sprintf("INSERT INTO ".TB_MDL_CTRL." (mdlctrl_enc, mdlctrl_mdl, mdlctrl_tx, mdlctrl_ord) VALUES (%s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($__mdl_d->id, "int"),
					   GtSQLVlStr($_POST['mdlctrl_tx'], "text"),
					   GtSQLVlStr($_POST['mdlctrl_ord'], "int"));
	
	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['er'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
    }
    
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlCtrl")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_MDL_CTRL." SET mdlctrl_tx=%s, mdlctrl_ord=%s WHERE mdlctrl_enc=%s",
						GtSQLVlStr($_POST['mdlctrl_tx'], "text"),
						GtSQLVlStr($_POST['mdlctrl_ord'], "int"),
						GtSQLVlStr($_POST['mdlctrl_enc'], "text"));
	
    $Result = $__cnx->_prc($updateSQL); 
    
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
    } 
    
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlCtrl'))) { 
	$deleteSQL = sprintf("DELETE FROM ".TB_MDL_CTRL." WHERE mdlctrl_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>