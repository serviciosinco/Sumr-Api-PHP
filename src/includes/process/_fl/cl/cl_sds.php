<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClSds")) { 
		
	$__enc = Enc_Rnd($_POST['clsds_nm'].' - '.DB_CL_ID);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_SDS." (clsds_enc, clsds_cl, clsds_nm, clsds_dir) VALUES (%s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(DB_CL_ID, "text"),
				   GtSQLVlStr($_POST['clsds_nm'], "text"),
                   GtSQLVlStr($_POST['clsds_dir'], "text"));
                   			
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClSds")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_SDS." SET clsds_nm=%s, clsds_dir=%s WHERE clsds_enc=%s",
                        GtSQLVlStr($_POST['clsds_nm'], "text"),
                        GtSQLVlStr($_POST['clsds_dir'], "text"),
                        GtSQLVlStr($_POST['clsds_enc'], "text"));
	
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['sis_vl'], $_POST['id_cltag'], $_POST['sis_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClSds'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_SDS." WHERE clsds_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}

?>