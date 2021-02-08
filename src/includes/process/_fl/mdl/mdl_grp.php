<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlGrp")) { 

	$__enc = Enc_Rnd($_POST['mdlgrp_mdl'].'-'.$_POST['mdlgrp_clgrp']);

	$insertSQL = sprintf("INSERT INTO ".TB_MDL_GRP." ( mdlgrp_enc, mdlgrp_mdl, mdlgrp_clgrp, mdlgrp_tp) VALUES (%s, %s, %s, %s)",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($_POST['mdlgrp_mdl'], "int"),
                       	GtSQLVlStr($_POST['mdlgrp_clgrp'], "int"),
                       	GtSQLVlStr($_POST['mdlgrp_tp'], "int"));
	
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlGrp")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_MDL_GRP." SET mdlgrp_mdl=%s, mdlgrp_clgrp=%s, mdlgrp_tp=%s WHERE mdlgrp_enc=%s",
						GtSQLVlStr($_POST['mdlgrp_mdl'], "int"),
						GtSQLVlStr($_POST['mdlgrp_clgrp'], "int"),
						GtSQLVlStr($_POST['mdlgrp_tp'], "int"),
						GtSQLVlStr($_POST['mdlgrp_enc'], "text"));
	
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
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlGrp'))) { 
	$deleteSQL = sprintf("DELETE FROM ".TB_MDL_GRP." WHERE mdlgrp_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 $rsp['a'] = Aud_Sis(Aud_Dsc(483, $_POST['mdlgrp_mdl'], $_POST['id_mdls']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}

?>