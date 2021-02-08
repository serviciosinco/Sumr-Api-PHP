<?php 

// Ingreso de Registro

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClMnu")) { 
	
	if(isN($_POST['clmnu_ord'])){
		$__prnt = GtMnuDt([ 'id'=>$_POST['clmnu_prnt'] ]);
		$rsp['prnt'] = $__prnt;	
		
		$__ord = 1;
		if(!isN($__prnt->lst->ord)){ 
			$__ord = ($__prnt->lst->ord+1); 
		}
	}else{
		$__ord = ctjTx($_POST['clmnu_ord'],'out');
	}
	
	$__enc = Enc_Rnd($_POST['sis_tt'].'-'.$_POST['sis_vl']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_MNU." (clmnu_enc,clmnu_tt, clmnu_tp, clmnu_prnt, clmnu_cns, clmnu_chckmd, clmnu_chckmd_v, clmnu_shct, clmnu_sis, clmnu_spradmn, clmnu_main, clmnu_pop, clmnu_pop_w, clmnu_pop_h, clmnu_cls, clmnu_rel, clmnu_rel_sub, clmnu_rel_tp, clmnu_rel_data, clmnu_ord, clmnu_lnk, clmnu_cche) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GtSQLVlStr(ctjTx($__enc,'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['clmnu_tt'],'out'), "text"),
					GtSQLVlStr($_POST['clmnu_tp'], "int"),
					GtSQLVlStr($_POST['clmnu_prnt'], "int"),
					GtSQLVlStr(ctjTx($_POST['clmnu_cns'],'out'), "text"),
					GtSQLVlStr(Html_chck_vl($_POST['clmnu_chckmd']), "int"),
					GtSQLVlStr(ctjTx($_POST['clmnu_chckmd_v'],'out'), "text"),
					GtSQLVlStr(Html_chck_vl($_POST['clmnu_shct']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['clmnu_sis']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['clmnu_spradmn']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['clmnu_main']), "int"),
					GtSQLVlStr(Html_chck_vl($_POST['clmnu_pop']), "int"),
					GtSQLVlStr(ctjTx($_POST['clmnu_pop_w'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['clmnu_pop_h'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['clmnu_cls'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['clmnu_rel'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['clmnu_rel_sub'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['clmnu_rel_tp'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['clmnu_rel_data'],'out'), "text"),
					GtSQLVlStr($__ord, "text"),
					GtSQLVlStr(ctjTx($_POST['clmnu_lnk'],'out'), "text"),
					GtSQLVlStr(Html_chck_vl($_POST['clmnu_cche']), "int"));			
					
	$Result = $__cnx->_prc($insertSQL); $rsp['w'] = $__cnx->c_p->error;
	
	if($Result){
		$rsp['i'] = $__enc;
		
		
		
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(415, $_POST['clmnu_dsc'], $__cnx->c_p->insert_id), $rsp['v']);
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'cl_mnu' ]);
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}


// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClMnu")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_MNU." SET clmnu_tt=%s, clmnu_tp=%s, clmnu_prnt=%s, clmnu_cns=%s, clmnu_chckmd=%s, clmnu_chckmd_v=%s, clmnu_sis=%s, clmnu_spradmn=%s, clmnu_main=%s, clmnu_pop=%s, clmnu_pop_w=%s, clmnu_pop_h=%s, clmnu_cls=%s, clmnu_rel=%s, clmnu_rel_sub=%s, clmnu_rel_tp=%s, clmnu_rel_data=%s, clmnu_ord=%s, clmnu_lnk=%s, clmnu_shct=%s, clmnu_cche=%s WHERE clmnu_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['clmnu_tt'],'out'), "text"),
					   GtSQLVlStr($_POST['clmnu_tp'], "int"),
					   GtSQLVlStr($_POST['clmnu_prnt'], "int"),
					   GtSQLVlStr(ctjTx($_POST['clmnu_cns'],'out'), "text"),
					   GtSQLVlStr(Html_chck_vl($_POST['clmnu_chckmd']), "int"),
					   GtSQLVlStr(ctjTx($_POST['clmnu_chckmd_v'],'out'), "text"),
					   GtSQLVlStr(Html_chck_vl($_POST['clmnu_sis']), "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['clmnu_spradmn']), "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['clmnu_main']), "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['clmnu_pop']), "int"),
					   GtSQLVlStr(ctjTx($_POST['clmnu_pop_w'],'out'), "int"),
					   GtSQLVlStr(ctjTx($_POST['clmnu_pop_h'],'out'), "int"),
					   GtSQLVlStr(ctjTx($_POST['clmnu_cls'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clmnu_rel'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clmnu_rel_sub'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clmnu_rel_tp'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clmnu_rel_data'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clmnu_ord'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clmnu_lnk'],'out'), "text"),
					   GtSQLVlStr(Html_chck_vl($_POST['clmnu_shct']), "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['clmnu_cche']), "int"),
                       GtSQLVlStr($_POST['clmnu_enc'], "text"));
                 
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'cl_mnu' ]);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_clmnu'])) && ($_POST['id_clmnu'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClmnu'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_MNU." WHERE clmnu_enc=%s", GtSQLVlStr($_POST['clmnu_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	 
	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(417, $_POST['clmnu_dsc'], $_POST['id_clmnu']), $rsp['v']);
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'cl_mnu' ]);
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}



	
// Ingreso de Imagen del Banco
if ((isset($_POST['MMR_insert'])) && ($_POST['MMR_insert'] == 'EdMnuCl')){
		
	$__enc = enCad($_POST['id_mnu'].'-'.$_POST['id_rlc'].Gn_Rnd(20));
		
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_MNU_R." (clmnur_clmnu, clmnur_enc, clmnur_cl) VALUES ((SELECT id_clmnu FROM "._BdStr(DBM).TB_CL_MNU." WHERE clmnu_enc=%s LIMIT 1), %s, %s)",
					   GtSQLVlStr($_POST['id_mnu'], "text"),
					   GtSQLVlStr($__enc, "text"),	
                       GtSQLVlStr($_POST['id_rlc'], "int"));
             	$Result = $__cnx->_prc($insertSQL);
		
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;	
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'cl_mnu' ]);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['p'] = $__cnx->c_p->error;
	}
}


// Elimino de Imagen
if(isset($_POST['MMR_delete'])&&($_POST['MMR_delete'] == 'EdMnuCl')){
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_MNU_R." WHERE clmnur_clmnu = (SELECT id_clmnu FROM "._BdStr(DBM).TB_CL_MNU." WHERE clmnu_enc=%s) AND clmnur_cl=%s", GtSQLVlStr($_POST['id_mnu'], "text"),	GtSQLVlStr($_POST['id_rlc'], "int"));
	
	$Result = $__cnx->_prc($deleteSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'cl_mnu' ]);	
		$rsp['ed'] = $deleteSQL;	
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	}
}



// Modificación de Registro
if ((isset($_POST["MMR_attr"])) && ($_POST["MMR_attr"] == "EdMnuCl")) { 
	
	if(!isN($_POST['__enc'])){
		
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_MNU_R." SET clmnur_clr_fnt=%s, clmnur_clr_bck=%s WHERE clmnur_enc=%s",
						   GtSQLVlStr(ctjTx($_POST['__fnt'],'out'), "text"),
						   GtSQLVlStr(ctjTx($_POST['__bck'],'out'), "text"),
	                       GtSQLVlStr(ctjTx($_POST['__enc'],'out'), "text"));
		
		$Result = $__cnx->_prc($updateSQL); 
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'cl_mnu' ]);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		} 
	
	}
}


?>