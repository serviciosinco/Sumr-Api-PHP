<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClHCntc")) {
		
	$__enc = Enc_Rnd( $__dt_cl->id.'-'.$_POST['clhcntc_nm'] ); 
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_H_CNTC." (clhcntc_enc, clhcntc_cl, clhcntc_nm) VALUES (%s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr($__dt_cl->id, "int"),
				   GtSQLVlStr(ctjTx($_POST['clhcntc_nm'],'out'), "text"));			
	
	
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClHCntc")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_H_CNTC." SET clhcntc_nm=%s WHERE clhcntc_enc=%s",
                       GtSQLVlStr(ctjTx($_POST['clhcntc_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clhcntc_enc'],'out'), "text"));
					   
	;
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['rst'] = 'no';
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClHCntc'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_H_CNTC." WHERE clhcntc_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>