<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClLcl")) {
		
	$__enc = Enc_Rnd( $__dt_cl->id.'-'.$_POST['cllcl_tt'] ); 
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_LCL." (cllcl_enc, cllcl_cl, cllcl_tt, cllcl_m2, cllcl_lvl) VALUES (%s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr($__dt_cl->id, "int"),
				   GtSQLVlStr(ctjTx($_POST['cllcl_tt'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['cllcl_m2'],'out'), "text"),
				   GtSQLVlStr($_POST['cllcl_lvl'], "int"));			
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		//$rsp['i'] = $__enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClLcl")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_LCL." SET cllcl_tt=%s, cllcl_m2=%s, cllcl_lvl=%s WHERE cllcl_enc=%s",
                       GtSQLVlStr(ctjTx($_POST['cllcl_tt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['cllcl_m2'],'out'), "text"),
                       GtSQLVlStr($_POST['cllcl_lvl'], "int"),
					   GtSQLVlStr(ctjTx($_POST['cllcl_enc'],'out'), "text"));
					   
	;
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(437, $_POST['clgrp_nm'], $_POST['id_clgrp']), $rsp['v']);
	}else{
		$rsp['rst'] = 'no';
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClLcl'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_LCL." WHERE cllcl_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(438, $_POST['clgrp_nm'], $_POST['uid']), $rsp['v']); 
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>