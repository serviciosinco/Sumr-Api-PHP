<?php 	

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisFnt")) {
		
	$__enc = Enc_Rnd($_POST['sisfnt_nm']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_FNT." (sisfnt_enc, sisfnt_nm, sisfnt_clr, sisfnt_dsc, sisfnt_usnvl, sisfnt_dflt_appwb) VALUES (%s, %s,  %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($_POST['sisfnt_nm'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['sisfnt_clr'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['sisfnt_dsc'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['sisfnt_usnvl'],'out'), "text"),
				   GtSQLVlStr(Html_chck_vl($_POST['sisfnt_dflt_appwb']), "int"));
				   		
	
	$Result = $__cnx->_prc($insertSQL);
		if($Result){
		$rsp['i'] = $__enc;
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisFnt")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_FNT." SET sisfnt_nm=%s, sisfnt_clr=%s, sisfnt_dsc=%s, sisfnt_usnvl=%s, sisfnt_dflt_appwb=%s WHERE sisfnt_enc=%s",
                       GtSQLVlStr(ctjTx($_POST['sisfnt_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisfnt_clr'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisfnt_dsc'],'out'), "text"),
					   GtSQLVlStr($_POST['sisfnt_usnvl'], "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['sisfnt_dflt_appwb']), "int"),
					   GtSQLVlStr($_POST['sisfnt_enc'], "text"));
					   
	;
	$Result = $__cnx->_prc($updateSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['err'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisFnt'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_SIS_FNT.' WHERE sisfnt_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		$rsp['a'] = Aud_Sis(Aud_Dsc(438, $_POST['sisfnt_nm'], $_POST['uid']), $rsp['v']); 
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}




// Ingreso de Imagen del Banco
if ((isset($_POST['MMR_insert'])) && ($_POST['MMR_insert'] == 'EdFntCl')){
		
	$__enc = Enc_Rnd($_POST['id_fnt'].'-'.$_POST['id_rlc']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_FNT_CL." (sisfntcl_sisfnt, sisfntcl_enc, sisfntcl_cl) VALUES ( (SELECT  id_sisfnt FROM "._BdStr(DBM).TB_SIS_FNT." WHERE sisfnt_enc=%s), %s, %s)",
				   GtSQLVlStr($_POST['id_fnt'], "text"),
				   GtSQLVlStr($__enc, "text"),	
                   GtSQLVlStr($_POST['id_rlc'], "int"));  $rsp['q'] = $insertSQL;
    
    $Result = $__cnx->_prc($insertSQL);
		
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;	
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['p'] = $__cnx->c_p->error;
	}
}


// Elimino de Imagen
if(isset($_POST['MMR_delete'])&&($_POST['MMR_delete'] == 'EdFntCl')){
	
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_SIS_FNT_CL." WHERE sisfntcl_sisfnt=%s AND sisfntcl_cl=%s", GtSQLVlStr($_POST['id_fnt'], "int"),	GtSQLVlStr($_POST['id_rlc'], "int"));
	
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