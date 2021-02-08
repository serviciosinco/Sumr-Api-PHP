<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSclLdFlds")) { 
	
	$__enc = Enc_Rnd($_POST['sclldflds_fld'].'-'.DB_CL_ENC);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_SCL_LD_FLDS." ( sclldflds_enc, sclldflds_cl, sclldflds_fld, sclldflds_est ) VALUES ( %s, %s, %s, %s )",    
				GtSQLVlStr(ctjTx($__enc,'out'), "text"),
				GtSQLVlStr(DB_CL_ID, "int"),
				GtSQLVlStr($_POST['sclldflds_fld'], "int"),
				GtSQLVlStr(Html_chck_vl($_POST['sclldflds_est']), "int")					  
            );	

	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['e'] = 'ok';
        $rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['m2'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSclLdFlds")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_SCL_LD_FLDS." SET sclldflds_fld=%s, sclldflds_est=%s WHERE sclldflds_enc=%s",
					GtSQLVlStr($_POST['sclldflds_fld'], "int"),
                    GtSQLVlStr(Html_chck_vl($_POST['sclldflds_est']), "int"),
					GtSQLVlStr(ctjTx($_POST['sclldflds_enc'],'out'), "text")
				);

    $Result = $__cnx->_prc($updateSQL); 
    
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['qry'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSclLdFlds'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBT).TB_SCL_LD_FLDS.' WHERE sclldflds_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>