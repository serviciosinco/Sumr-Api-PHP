<?php 	
	
if(!isN($_POST['sismd_dflt'])){ $__dflt = $_POST['sismd_dflt']; }else{ $__dflt = '2'; }
if(!isN($_POST['sismd_sndi'])){ $__sndi = $_POST['sismd_sndi']; }else{ $__sndi = '2'; }

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisMd")) {
	
	$__enc = Enc_Rnd($_POST['sismd_tt'].'-'.$_POST['sismd_tp']);
	
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_MD." (sismd_enc, sismd_tt, sismd_tp, sismd_clr, sismd_cdg, sismd_ld_v, sismd_usnvl, sismd_dflt, sismd_sndi, sismd_key, sismd_dflt_wb) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),	
                   GtSQLVlStr(ctjTx($_POST['sismd_tt'],'out'), "text"),
                   GtSQLVlStr($_POST['sismd_tp'], "int"),	
				   GtSQLVlStr(ctjTx($_POST['sismd_clr'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['sismd_cdg'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['sismd_ld_v'],'out'), "text"),
				   GtSQLVlStr($_POST['sismd_usnvl'], "int"),
				   GtSQLVlStr($__dflt, "int"),
				   GtSQLVlStr($__sndi, "int"),
				   GtSQLVlStr(ctjTx($_POST['sismd_key'],'out'), "text"),
				   GtSQLVlStr(Html_chck_vl($_POST['sismd_dflt_wb']), "int"));
				   		
	
	$Result = $__cnx->_prc($insertSQL);
	
		if($Result){
		$rsp['i'] = $__enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['ms'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisMd")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_MD." SET sismd_tt=%s, sismd_tp=%s, sismd_clr=%s, sismd_cdg=%s, sismd_ld_v=%s,  sismd_usnvl=%s, sismd_dflt=%s, sismd_sndi=%s, sismd_key=%s, sismd_dflt_wb=%s WHERE sismd_enc=%s",
                       GtSQLVlStr(ctjTx($_POST['sismd_tt'],'out'), "text"),
                       GtSQLVlStr($_POST['sismd_tp'], "int"),	
					   GtSQLVlStr(ctjTx($_POST['sismd_clr'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sismd_cdg'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sismd_ld_v'],'out'), "text"),
					   GtSQLVlStr($_POST['sismd_usnvl'], "int"),
					   GtSQLVlStr($__dflt, "int"),
					   GtSQLVlStr($__sndi, "int"),
					   GtSQLVlStr(ctjTx($_POST['sismd_key'],'out'), "text"),
					   GtSQLVlStr(Html_chck_vl($_POST['sismd_dflt_wb']), "int"),
					   GtSQLVlStr($_POST['sismd_enc'], "text"));
					   
	;
	$Result = $__cnx->_prc($updateSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['ms'] = $updateSQL;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['err'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisMd'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_SIS_MD.' WHERE sismd_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		$rsp['a'] = Aud_Sis(Aud_Dsc(438, $_POST['sismd_nm'], $_POST['uid']), $rsp['v']); 
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}




// Ingreso de Imagen del Banco
if ((isset($_POST['MMR_insert'])) && ($_POST['MMR_insert'] == 'EdMdCl')){
		
		$__enc = Enc_Rnd($_POST['id_md'].'-'.$_POST['id_rlc']);
		
		$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_MD_CL." (sismdcl_sismd, sismdcl_enc, sismdcl_cl) VALUES (%s, %s, %s)",
					   GtSQLVlStr($_POST['id_md'], "int"),
					   GtSQLVlStr($__enc, "text"),	
                       GtSQLVlStr($_POST['id_rlc'], "int"));              
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
if(isset($_POST['MMR_delete'])&&($_POST['MMR_delete'] == 'EdMdCl')){
	
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_SIS_MD_CL." WHERE sismdcl_sismd=%s AND sismdcl_cl=%s", GtSQLVlStr($_POST['id_md'], "int"),	GtSQLVlStr($_POST['id_rlc'], "int"));
	
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