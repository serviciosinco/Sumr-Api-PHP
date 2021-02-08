<?php 

//@ini_set('display_errors', true); 
//error_reporting(E_ALL);

// Ingreso de Registro

$___days_week = _WkDays();

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClWdgt")) { 
	
	$__Enc = Enc_Rnd($_POST['clwdgt_cl'].'-'.$_POST['clwdgt_nm']);

	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_WDGT." (clwdgt_enc, clwdgt_cl, clwdgt_nm, clwdgt_clr_strt, clwdgt_clr_hdr, clwdgt_tx_btn_tt, clwdgt_tx_pop_tt, clwdgt_tx_pop_intro, clwdgt_test_url, clwdgt_test_inline, clwdgt_pwd, clwdgt_thm, clwdgt_shwtt) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr($_POST['clwdgt_cl'], "text"),
                   GtSQLVlStr(ctjTx($_POST['clwdgt_nm'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['clwdgt_clr_strt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['clwdgt_clr_hdr'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['clwdgt_tx_btn_tt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['clwdgt_tx_pop_tt'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['clwdgt_tx_pop_intro'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['clwdgt_test_url'],'out'), "text"),
				   GtSQLVlStr(!isN($_POST['clwdgt_test_inline'])?$_POST['clwdgt_pwd']:1, "int"),			   
				   GtSQLVlStr(!isN($_POST['clwdgt_pwd'])?$_POST['clwdgt_pwd']:1, "int"),
				   GtSQLVlStr(!isN($_POST['clwdgt_thm'])?$_POST['clwdgt_thm']:1, "int"),
                   GtSQLVlStr(!isN($_POST['clwdgt_shwtt'])?$_POST['clwdgt_shwtt']:1, "int"));			
				   
	
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClWdgt")) { 
	
	if(!isN($_POST['clwdgt_pwd'])){ $_pwd=$_POST['clwdgt_pwd']; }else{ $_pwd=2; }
	if(!isN($_POST['clwdgt_thm'])){ $_thm=$_POST['clwdgt_thm']; }else{ $_thm=2; }
	if(!isN($_POST['clwdgt_puff'])){ $_puff=$_POST['clwdgt_puff']; }else{ $_puff=2; }
	if(!isN($_POST['clwdgt_shwtt'])){ $_shwtt=$_POST['clwdgt_shwtt']; }else{ $_shwtt=2; }
	
	if(!isN($_POST['clwdgt_mbl_pwd'])){ $_mbl_pwd=$_POST['clwdgt_mbl_pwd']; }else{ $_mbl_pwd=2; }
	if(!isN($_POST['clwdgt_mbl_puff'])){ $_mbl_puff=$_POST['clwdgt_mbl_puff']; }else{ $_mbl_puff=2; }
	if(!isN($_POST['clwdgt_mbl_shwtt'])){ $_mbl_shwtt=$_POST['clwdgt_mbl_shwtt']; }else{ $_mbl_shwtt=2; }
	
	
	if(!isN($_POST['clwdgt_pst_top'])){ $_p_top=$_POST['clwdgt_pst_top']; }else{ $_p_top=2; }
	if(!isN($_POST['clwdgt_pst_right'])){ $_p_right=$_POST['clwdgt_pst_right']; }else{ $_p_right=2; }
	if(!isN($_POST['clwdgt_pst_bottom'])){ $_p_bottom=$_POST['clwdgt_pst_bottom']; }else{ $_p_bottom=2; }
	if(!isN($_POST['clwdgt_pst_left'])){ $_p_left=$_POST['clwdgt_pst_left']; }else{ $_p_left=2; }
	if(!isN($_POST['clwdgt_pst_top_v'])){ $_p_top_v=$_POST['clwdgt_pst_top_v']; }else{ $_p_top_v=NULL; }
	if(!isN($_POST['clwdgt_pst_right_v'])){ $_p_right_v=$_POST['clwdgt_pst_right_v']; }else{ $_p_right_v=NULL; }
	if(!isN($_POST['clwdgt_pst_bottom_v'])){ $_p_bottom_v=$_POST['clwdgt_pst_bottom_v']; }else{ $_p_bottom_v=NULL; }
	if(!isN($_POST['clwdgt_pst_left_v'])){ $_p_left_v=$_POST['clwdgt_pst_left_v']; }else{ $_p_left_v=NULL; }
	
	if(!isN($_POST['clwdgt_pst_mbl_top'])){ $_mbl_p_top=$_POST['clwdgt_pst_mbl_top']; }else{ $_mbl_p_top=2; }
	if(!isN($_POST['clwdgt_pst_mbl_right'])){ $_mbl_p_right=$_POST['clwdgt_pst_mbl_right']; }else{ $_mbl_p_right=2; }
	if(!isN($_POST['clwdgt_pst_mbl_bottom'])){ $_mbl_p_bottom=$_POST['clwdgt_pst_mbl_bottom']; }else{ $_mbl_p_bottom=2; }
	if(!isN($_POST['clwdgt_pst_mbl_left'])){ $_mbl_p_left=$_POST['clwdgt_pst_mbl_left']; }else{ $_mbl_p_left=2; }
	if(!isN($_POST['clwdgt_pst_mbl_top_v'])){ $_mbl_p_top_v=$_POST['clwdgt_pst_mbl_top_v']; }else{ $_mbl_p_top_v=NULL; }
	if(!isN($_POST['clwdgt_pst_mbl_right_v'])){ $_mbl_p_right_v=$_POST['clwdgt_pst_mbl_right_v']; }else{ $_mbl_p_right_v=NULL; }
	if(!isN($_POST['clwdgt_pst_mbl_bottom_v'])){ $_mbl_p_bottom_v=$_POST['clwdgt_pst_mbl_bottom_v']; }else{ $_mbl_p_bottom_v=NULL; }
	if(!isN($_POST['clwdgt_pst_mbl_left_v'])){ $_mbl_p_left_v=$_POST['clwdgt_pst_mbl_left_v']; }else{ $_mbl_p_left_v=NULL; }
	
	if(!isN($_POST['clwdgt_test_inline'])){ $_test_inl=$_POST['clwdgt_test_inline']; }else{ $_test_inl=2; }

	foreach($___days_week as $_k => $_v){
		if(!isN($_POST['clwdgt_sch_d_'.$_v->id])){ ${'_mbl_sch_d_'.$_v->id} =$_POST['clwdgt_sch_d_'.$_v->id]; }else{ ${'_mbl_sch_d_'.$_v->id}=2; }
		if(!isN($_POST['clwdgt_sch_d_'.$_v->id.'_s'])){ ${'_mbl_sch_d_'.$_v->id.'_s'} =$_POST['clwdgt_sch_d_'.$_v->id.'_s']; }else{ ${'_mbl_sch_d_'.$_v->id.'_s'}=NULL; }
		if(!isN($_POST['clwdgt_sch_d_'.$_v->id.'_e'])){ ${'_mbl_sch_d_'.$_v->id.'_e'} =$_POST['clwdgt_sch_d_'.$_v->id.'_e']; }else{ ${'_mbl_sch_d_'.$_v->id.'_e'}=NULL; }
		$_upd_sql[] = sprintf('clwdgt_sch_d_'.$_v->id.'=%s', ${'_mbl_sch_d_'.$_v->id});
		$_upd_sql[] = sprintf('clwdgt_sch_d_'.$_v->id.'_s=%s', GtSQLVlStr(${'_mbl_sch_d_'.$_v->id.'_s'}, "date"));
		$_upd_sql[] = sprintf('clwdgt_sch_d_'.$_v->id.'_e=%s', GtSQLVlStr(${'_mbl_sch_d_'.$_v->id.'_e'}, "date"));

		if(!isN($_POST['clwdgt_sch_mbl_d_'.$_v->id])){ ${'_mbl_sch_mbl_d_'.$_v->id} =$_POST['clwdgt_sch_mbl_d_'.$_v->id]; }else{ ${'_mbl_sch_mbl_d_'.$_v->id}=2; }
		if(!isN($_POST['clwdgt_sch_mbl_d_'.$_v->id.'_s'])){ ${'_mbl_sch_mbl_d_'.$_v->id.'_s'} =$_POST['clwdgt_sch_mbl_d_'.$_v->id.'_s']; }else{ ${'_mbl_sch_mbl_d_'.$_v->id.'_s'}=NULL; }
		if(!isN($_POST['clwdgt_sch_mbl_d_'.$_v->id.'_e'])){ ${'_mbl_sch_mbl_d_'.$_v->id.'_e'} =$_POST['clwdgt_sch_mbl_d_'.$_v->id.'_e']; }else{ ${'_mbl_sch_mbl_d_'.$_v->id.'_e'}=NULL; }
		$_upd_sql[] = sprintf('clwdgt_sch_mbl_d_'.$_v->id.'=%s', ${'_mbl_sch_mbl_d_'.$_v->id});
		$_upd_sql[] = sprintf('clwdgt_sch_mbl_d_'.$_v->id.'_s=%s', GtSQLVlStr(${'_mbl_sch_mbl_d_'.$_v->id.'_s'}, "date"));
		$_upd_sql[] = sprintf('clwdgt_sch_mbl_d_'.$_v->id.'_e=%s', GtSQLVlStr(${'_mbl_sch_mbl_d_'.$_v->id.'_e'}, "date"));
	}
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_WDGT." SET
	
					clwdgt_nm=%s, clwdgt_clr_strt=%s, clwdgt_clr_hdr=%s, clwdgt_tx_btn_tt=%s, clwdgt_tx_pop_tt=%s, clwdgt_tx_pop_intro=%s, clwdgt_test_url=%s, clwdgt_test_inline=%s,
					clwdgt_pwd=%s, clwdgt_thm=%s, clwdgt_puff=%s, clwdgt_shwtt=%s, 
					clwdgt_mbl_pwd=%s, clwdgt_mbl_puff=%s, clwdgt_mbl_shwtt=%s, 
					clwdgt_pst_top=%s, clwdgt_pst_right=%s, clwdgt_pst_bottom=%s, clwdgt_pst_left=%s , 
					clwdgt_pst_top_v=%s, clwdgt_pst_right_v=%s, clwdgt_pst_bottom_v=%s, clwdgt_pst_left_v=%s , 
					clwdgt_pst_mbl_top=%s, clwdgt_pst_mbl_right=%s, clwdgt_pst_mbl_bottom=%s, clwdgt_pst_mbl_left=%s,
					clwdgt_pst_mbl_top_v=%s, clwdgt_pst_mbl_right_v=%s, clwdgt_pst_mbl_bottom_v=%s, clwdgt_pst_mbl_left_v=%s,
					".implode(',', $_upd_sql)."
					WHERE clwdgt_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['clwdgt_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgt_clr_strt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgt_clr_hdr'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgt_tx_btn_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgt_tx_pop_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgt_tx_pop_intro'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clwdgt_test_url'],'out'), "text"),
					   GtSQLVlStr($_test_inl, "int"),
					   GtSQLVlStr($_pwd, "int"),
					   GtSQLVlStr($_thm, "int"),
					   GtSQLVlStr($_puff, "int"),
					   GtSQLVlStr($_shwtt, "int"),
					   GtSQLVlStr($_mbl_pwd, "int"),
					   GtSQLVlStr($_mbl_puff, "int"),
					   GtSQLVlStr($_mbl_shwtt, "int"),
					   GtSQLVlStr($_p_top, "int"),
					   GtSQLVlStr($_p_right, "int"),
					   GtSQLVlStr($_p_bottom, "int"),
					   GtSQLVlStr($_p_left, "int"),				   
					   GtSQLVlStr($_p_top_v, "text"),
					   GtSQLVlStr($_p_right_v, "text"),
					   GtSQLVlStr($_p_bottom_v, "text"),
					   GtSQLVlStr($_p_left_v, "text"),
					   GtSQLVlStr($_mbl_p_top, "int"),
					   GtSQLVlStr($_mbl_p_right, "int"),
					   GtSQLVlStr($_mbl_p_bottom, "int"),
					   GtSQLVlStr($_mbl_p_left, "int"), 				   
					   GtSQLVlStr($_mbl_p_top_v, "text"),
					   GtSQLVlStr($_mbl_p_right_v, "text"),
					   GtSQLVlStr($_mbl_p_bottom_v, "text"),
					   GtSQLVlStr($_mbl_p_left_v, "text"), 
                       GtSQLVlStr($_POST['clwdgt_enc'], "text"));
	

	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}


if ((isset($_POST['id_clwdgt'])) && ($_POST['idclwdgt'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClWdgt'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '.TB_CL_WDGT.' WHERE clwdgt_enc=%s', GtSQLVlStr($_POST['clwdgt_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	 
	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(417, $_POST['clare_dsc'], $_POST['id_clare']), $rsp['v']);
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'_cl_mnu' ]);
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
	
}


if ( !isN($_POST['clwdgt_enc']) && !isN($_POST['MM_rebuild']) && $_POST['MM_rebuild'] == 'EdClWdgt' ) { 

	$__wdgt = new CRM_Wdgt();
	$__wdgt->id_clwdgt = $_POST['clwdgt_enc'];
	
	$rsp['wsve']['json'] = $_w_sve_json = $__wdgt->sve_json();
	$rsp['wsve']['main'] = $_w_sve_main = $__wdgt->sve_main();
	
	if($_w_sve_json->e == 'ok' && $_w_sve_main->e == 'ok'){
		$rsp['e'] = 'ok';
	}

}


?>