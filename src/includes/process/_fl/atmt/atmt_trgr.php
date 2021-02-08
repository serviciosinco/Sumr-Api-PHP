<?php 	
	
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdAtmtTrgr")) { 
		
		
	$__enc = Enc_Rnd($_POST['atmttrgr_nm'].'-'.$_POST['atmttrgr_atmt'].'-'.SISUS_ID);
	
	$rsp['c'] = 'ok';
	
	if($_POST['atmttrgr_dly'] != _CId('ID_SISATMTDLY_NOW')){ 
		$__dly_v = $_POST['atmttrgr_dly_v']; 
	}else{ 
		$__dly_v = NULL; 
	}
	
	if($_POST['atmttrgr_sch'] == _CId('ID_SISATMTSCH_RNG')){ 
		$__sch_h1_v = $_POST['atmttrgr_sch_h1']; $__sch_h2_v = $_POST['atmttrgr_sch_h2']; 
	}elseif($_POST['atmttrgr_sch'] == _CId('ID_SISATMTSCH_PRNT')){ 
		$__sch_h1_v = NULL; $__sch_h2_v = NULL; 
	}elseif($_POST['atmttrgr_sch'] == _CId('ID_SISATMTSCH_HRA')){ 
		$__sch_h1_v = $_POST['atmttrgr_sch_h1']; $__sch_h2_v = NULL; 
	}
	
	if($_POST['atmttrgr_dly'] != _CId('ID_SISATMTDLY_NOW')){ 
		$__dly_v = $_POST['atmttrgr_dly_v']; 
	}else{ 
		$__dly_v = NULL; 
	}
	
	
	if(!isN($_POST['atmttrgr_dly'])){ 
		$__dly = $_POST['atmttrgr_dly']; 
	}else{ 
		$__dly = _CId('ID_SISATMTDLY_NOW'); 
	}
	
	if(!isN($_POST['atmttrgr_sch'])){ 
		$__sch = $_POST['atmttrgr_sch']; 
	}else{ 
		$__sch = _CId('ID_SISATMTSCH_PRNT'); 
	}
	
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBA).TB_ATMT_TRGR." (atmttrgr_enc, atmttrgr_nm, atmttrgr_atmt, atmttrgr_trgr, atmttrgr_v_ls, atmttrgr_v_vl, atmttrgr_etp, atmttrgr_dly, atmttrgr_dly_v, atmttrgr_sch, atmttrgr_sch_d_1, atmttrgr_sch_d_2, atmttrgr_sch_d_3, atmttrgr_sch_d_4, atmttrgr_sch_d_5, atmttrgr_sch_d_6, atmttrgr_sch_d_7, atmttrgr_sch_h1, atmttrgr_sch_h2, atmttrgr_ord, atmttrgr_lnl, atmttrgr_rpt, atmttrgr_hbl, atmttrgr_invk_api, atmttrgr_invk_up, atmttrgr_invk_crm, atmttrgr_invk_auto, atmttrgr_invk_form) VALUES (%s,%s, (SELECT id_atmt FROM "._BdStr(DBA).TB_ATMT." WHERE atmt_enc=%s),%s, %s,%s, (SELECT id_cletp FROM "._BdStr(DBM).TB_CL_ETP." WHERE cletp_enc=%s),%s, %s, %s, %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
				   GtSQLVlStr($__enc, "text"),
				   GtSQLVlStr(ctjTx($_POST['atmttrgr_nm'],'out'), "text"),
				   GtSQLVlStr($_POST['atmttrgr_atmt'], "text"),
				   GtSQLVlStr($_POST['atmttrgr_trgr'], "int"),
				   GtSQLVlStr(ctjTx($_POST['atmttrgr_v_ls'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['atmttrgr_v_vl'],'out'), "text"),
				   GtSQLVlStr($_POST['atmttrgr_etp'], "text"),
				   GtSQLVlStr($__dly, "int"),
				   GtSQLVlStr($__dly_v, "text"),
				   GtSQLVlStr($__sch, "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_1']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_2']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_3']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_4']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_5']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_6']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_7']), "int"),
				   GtSQLVlStr($_POST['atmttrgr_sch_h1'], "date"),
				   GtSQLVlStr($_POST['atmttrgr_sch_h2'], "date"),
				   GtSQLVlStr($_POST['atmttrgr_ord'], "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_lnl']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_rpt']), "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_hbl']), "int"),
				   GtSQLVlStr(Html_chck_vl(1), "int"),
				   GtSQLVlStr(Html_chck_vl(1), "int"),
				   GtSQLVlStr(Html_chck_vl(1), "int"),
				   GtSQLVlStr(Html_chck_vl(1), "int"),
				   GtSQLVlStr(Html_chck_vl(1), "int"));
				   	
	
	$Result = $__cnx->_prc($insertSQL); //$rsp['q'] = $insertSQL;
		
	if($Result){	
 		//$rsp['i'] = $__cnx->c_p->insert_id;
 		//$rsp['enc'] = $__enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(array('p'=>$insertSQL, 'd'=>$__cnx->c_p->error));
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdAtmtTrgr")) { 
	
	if($_POST['atmttrgr_dly'] != _CId('ID_SISATMTDLY_NOW')){ 
		$__dly_v = $_POST['atmttrgr_dly_v']; 
	}else{ 
		$__dly_v = NULL; 
	}
	
	if($_POST['atmttrgr_sch'] == _CId('ID_SISATMTSCH_RNG')){ 
		$__sch_h1_v = $_POST['atmttrgr_sch_h1']; $__sch_h2_v = $_POST['atmttrgr_sch_h2']; 
	}elseif($_POST['atmttrgr_sch'] == _CId('ID_SISATMTSCH_PRNT')){ 
		$__sch_h1_v = NULL; $__sch_h2_v = NULL; 
	}elseif($_POST['atmttrgr_sch'] == _CId('ID_SISATMTSCH_HRA')){ 
		$__sch_h1_v = $_POST['atmttrgr_sch_h1']; $__sch_h2_v = NULL; 
	}
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBA).TB_ATMT_TRGR." SET atmttrgr_nm=%s, atmttrgr_atmt=%s, atmttrgr_trgr=%s, atmttrgr_v_ls=%s, atmttrgr_v_vl=%s, atmttrgr_etp=%s, atmttrgr_dly=%s, atmttrgr_dly_v=%s, atmttrgr_sch=%s, atmttrgr_sch_d_1=%s, atmttrgr_sch_d_2=%s, atmttrgr_sch_d_3=%s, atmttrgr_sch_d_4=%s, atmttrgr_sch_d_5=%s, atmttrgr_sch_d_6=%s, atmttrgr_sch_d_7=%s, atmttrgr_sch_h1=%s, atmttrgr_sch_h2=%s, atmttrgr_ord=%s, atmttrgr_lnl=%s, atmttrgr_rpt=%s, atmttrgr_hbl=%s, atmttrgr_invk_api=%s, atmttrgr_invk_up=%s, atmttrgr_invk_crm=%s, atmttrgr_invk_auto=%s, atmttrgr_invk_form=%s WHERE atmttrgr_enc=%s",			
	                    GtSQLVlStr(ctjTx($_POST['atmttrgr_nm'],'out'), "text"),
	                    GtSQLVlStr($_POST['atmttrgr_atmt'], "int"),
						GtSQLVlStr($_POST['atmttrgr_trgr'], "int"),
						GtSQLVlStr(ctjTx($_POST['atmttrgr_v_ls'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['atmttrgr_v_vl'],'out'), "text"),
						GtSQLVlStr($_POST['atmttrgr_etp'], "int"),
						GtSQLVlStr($_POST['atmttrgr_dly'], "int"),
						GtSQLVlStr($__dly_v, "text"),
						GtSQLVlStr($_POST['atmttrgr_sch'], "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_1']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_2']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_3']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_4']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_5']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_6']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_sch_d_7']), "int"),
						GtSQLVlStr($__sch_h1_v, "date"),
						GtSQLVlStr($__sch_h2_v, "date"),
						GtSQLVlStr($_POST['atmttrgr_ord'], "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_lnl']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_rpt']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_hbl']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_invk_api']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_invk_up']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_invk_crm']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_invk_auto']), "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgr_invk_form']), "int"),
						GtSQLVlStr($_POST['atmttrgr_enc'], "text")); 
	 
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['enc'] = $_POST['atmttrgr_enc'];
		
		
		$__trgrdt = GtAtmtTrgrDt([ 'id'=>$_POST['atmttrgr_trgr'] ]);
		
		if(!isN($__trgrdt->id)){	
			$__Atmt->atmt_enc = $__trgrdt->enc;
			$PrcDt = $__Atmt->_Trgr_Upd([ 'fa'=>SIS_F_D2 ]);
			$rsp['p'] = $PrcDt;
		}
		
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdAtmtTrgr'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBA).TB_ATMT_TRGR.' WHERE atmttrgr_enc=%s', GtSQLVlStr($_POST['uid'], 'int'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	//$rsp['a'] = Aud_Sis(Aud_Dsc(258, $_POST['atmttrgr_nm'], $_POST['id_atmttrgr']), $rsp['v']);
	 }else{ $rsp['e'] = 'no'; $rsp['m'] = 2; _ErrSis(array('p'=>$deleteSQL, 'd'=>$__cnx->c_p->error)); $rsp['w'] = $__cnx->c_p->error;}
}
?>