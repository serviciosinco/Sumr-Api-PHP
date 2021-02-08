<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgGrp")) { 	
	
	$__enc = Enc_Rnd($_POST['orggrp_nm']);		
		
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_GRP." (orggrp_enc, orggrp_nm) VALUES (%s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($_POST['orggrp_nm'],'out'), "text"));
                   
	
	
	$Result = $__cnx->_prc($insertSQL);
		if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['sm'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgGrp")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ORG_GRP." SET orggrp_nm=%s  WHERE orggrp_enc=%s",
						GtSQLVlStr(ctjTx($_POST['orggrp_nm'],'out'), "text"),
						GtSQLVlStr($_POST['orggrp_enc'], "text"));
						
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgGrp'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_GRP." WHERE orggrp_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>