<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlSTp")) { 
	
	
	$__enc = Enc_Rnd( $_POST['mdlstp_nm'].'-'.$_POST['mdlstp_tp'] ); 
	
		
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP." (mdlstp_enc, mdlstp_nm, mdlstp_tp, mdlstp_inf, mdlstp_sch, mdlstp_unq, mdlstp_clr, mdlstp_clg, mdlstp_uni, mdlstp_emp, mdlstp_tra, mdlstp_mdls) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GtSQLVlStr($__enc, "text"),
                    GtSQLVlStr(ctjTx($_POST['mdlstp_nm'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['mdlstp_tp'],'out'), "text"),
					GtSQLVlStr(Html_chck_vl($_POST['mdlstp_inf']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['mdlstp_sch']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['mdlstp_unq']), "int"),
					GtSQLVlStr(ctjTx($_POST['mdlstp_clr'],'out'), "text"),
					GtSQLVlStr(Html_chck_vl($_POST['mdlstp_clg']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['mdlstp_uni']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['mdlstp_emp']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['mdlstp_tra']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['mdlstp_mdls']), "int"));
				   		
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(142, $_POST['cd_tt'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlSTp")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S_TP." SET mdlstp_nm=%s, mdlstp_tp=%s, mdlstp_clr=%s, mdlstp_inf=%s, mdlstp_sch=%s, mdlstp_unq=%s, mdlstp_clg=%s, mdlstp_uni=%s, mdlstp_emp=%s, mdlstp_tra=%s, mdlstp_mdls=%s WHERE mdlstp_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['mdlstp_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['mdlstp_tp'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['mdlstp_clr'],'out'), "text"),
					   GtSQLVlStr($_POST['mdlstp_inf'], "int"),
					   GtSQLVlStr($_POST['mdlstp_sch'], "int"),
					   GtSQLVlStr($_POST['mdlstp_unq'], "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['mdlstp_clg']), "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['mdlstp_uni']), "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['mdlstp_emp']), "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['mdlstp_tra']), "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['mdlstp_mdls']), "int"),
					   GtSQLVlStr($_POST['mdlstp_enc'], "text"));
					   
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $updateSQL;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_mdlstp'])) && ($_POST['id_mdlstp'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlSTp'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_MDL_S_TP.' WHERE mdlstp_enc=%s', GtSQLVlStr($_POST['mdlstp_enc'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 //$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}





// Ingreso de Imagen del Banco
if ((isset($_POST['MMR_insert'])) && ($_POST['MMR_insert'] == 'EdTpCl')){
		
		$__enc = Enc_Rnd($_POST['id_tp'].'-'.$_POST['id_rlc']);
		
		$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_CL." (sistpcl_sistp, sistpcl_enc, sistpcl_cl) VALUES (%s, %s, %s)",
					   GtSQLVlStr($_POST['id_tp'], "int"),
					   GtSQLVlStr($__enc, "text"),	
                       GtSQLVlStr($_POST['id_rlc'], "int"));              
		$Result = $__cnx->_prc($insertSQL);
		
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;	
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	}
}


// Elimino de Imagen
if(isset($_POST['MMR_delete'])&&($_POST['MMR_delete'] == 'EdTpCl')){
	
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_MDL_S_TP_CL." WHERE sistpcl_sistp=%s AND sistpcl_cl=%s", GtSQLVlStr($_POST['id_tp'], "int"),	GtSQLVlStr($_POST['id_rlc'], "int"));
	
	$Result = $__cnx->_prc($deleteSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;	
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	}
}
?>