<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdDwnCol")) { 

    $__enc = Enc_Rnd($_POST['dwncol_col'].'-'.DB_CL_ENC);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBD).TB_DWN_COL." ( dwncol_enc, dwncol_cl, dwncol_col, dwncol_e) VALUES ( %s, %s, %s, %s)",
                GtSQLVlStr(ctjTx($__enc,'out'), "text"),
				GtSQLVlStr(DB_CL_ID, "text"),
				GtSQLVlStr($_POST['dwncol_col'], "int"),
				GtSQLVlStr(Html_chck_vl($_POST['dwncol_e']), "int")					  
            );	

	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['i'] = $__enc;
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdDwnCol")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBD).TB_DWN_COL." SET dwncol_col=%s, dwncol_e=%s WHERE dwncol_enc =%s",
                    GtSQLVlStr($_POST['dwncol_col'], "int"),
                    GtSQLVlStr(Html_chck_vl($_POST['dwncol_e']), "int"),
					GtSQLVlStr(ctjTx($_POST['dwncol_enc'],'out'), "text")
				);
					
	 
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['upfld_vl'], $_POST['id_lnd'], $_POST['lnd_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['qry'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdRd'))) { 
	
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBD).TB_DWN_COL." WHERE rd_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	 
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; /*$rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['upfld_vl'], $_POST['uid'], $_POST['lnd_tt']), $rsp['v']);*/}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>