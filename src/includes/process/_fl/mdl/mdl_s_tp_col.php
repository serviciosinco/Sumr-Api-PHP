<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlSTpCol")) { 

    $__enc = Enc_Rnd($_POST['mdlstpcol_col'].'-'.DB_CL_ENC);

    $__tp = GtMdlSTpDt([ 'enc'=>$_POST['mdlstpcol_mdlstp'] ]);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_COL." ( mdlstpcol_enc, mdlstpcol_cl, mdlstpcol_mdlstp, mdlstpcol_col, mdlstpcol_e) VALUES ( %s, %s, %s, %s, %s)",
                GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                GtSQLVlStr(DB_CL_ID, "text"),
                GtSQLVlStr($__tp->id, "int"),
				GtSQLVlStr($_POST['mdlstpcol_col'], "int"),
				GtSQLVlStr(Html_chck_vl($_POST['mdlstpcol_e']), "int")					  
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlSTpCol")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S_TP_COL." SET mdlstpcol_col=%s, mdlstpcol_e=%s WHERE mdlstpcol_enc =%s",
                    GtSQLVlStr($_POST['mdlstpcol_col'], "int"),
                    GtSQLVlStr(Html_chck_vl($_POST['mdlstpcol_e']), "int"),
					GtSQLVlStr(ctjTx($_POST['mdlstpcol_enc'],'out'), "text")
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
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdREdMdlSTpCol'))) { 
	
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBD).TB_MDL_S_TP_COL." WHERE mdlstpcol_enc=%s", GtSQLVlStr($_POST['uid'], 'text'));
	 
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; /*$rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['upfld_vl'], $_POST['uid'], $_POST['lnd_tt']), $rsp['v']);*/}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>