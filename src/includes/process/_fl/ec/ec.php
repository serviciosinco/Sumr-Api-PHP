<?php

	
	if($__prfx->lt == 'ec_tmpl' || $__prfx->lt == 'ec' || $___Ls->mdlstp->tp == 'ec'){
		
		$__rlc_tp = 'ok';
		$__rlc_id = GtMdlSTpDt(['tp'=>$___Ls->mdlstp->tp]);

	}

	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && (($_POST["MM_insert"] == "EdEc") || ($_POST["MM_insert"] == "EdSndEcTmpl") )) { 
		
	$_ec_snd = new API_CRM_ec();
							
	$_ec_snd->ec_dir = $_POST['ec_dir'];
	$_ec_snd->ec_est = $_POST['ec_est'];
	$_ec_snd->ec_dmo = $_POST['ec_dmo'];
	$_ec_snd->ec_cds = $_POST['ec_cds'];
	$_ec_snd->ec_tt = $_POST['ec_tt'];
	$_ec_snd->ec_sbt = $_POST['ec_sbt'];
	$_ec_snd->ec_dsc = $_POST['ec_dsc'];
	$_ec_snd->ec_cd = $_POST['ec_cd'];
	$_ec_snd->ec_fnd = $_POST['ec_fnd'];
	$_ec_snd->ec_spn = $_POST['ec_spn'];
	$_ec_snd->ec_w = $_POST['ec_w'];
	$_ec_snd->ec_fm = $_POST['ec_fm'];
	$_ec_snd->ec_pdf = $_POST['ec_pdf'];
	$_ec_snd->ec_ord = $_POST['ec_ord'];
	$_ec_snd->ec_pay = $_POST['ec_pay'];
	$_ec_snd->ec_nmr = $_POST['ec_nmr'];
	$_ec_snd->ec_frw = $_POST['ec_frw'];
	$_ec_snd->ec_key = $_POST['ec_key'];
	$_ec_snd->ec_em = $_POST['ec_em'];
	$_ec_snd->ec_lnk = $_POST['ec_lnk'];
	$_ec_snd->ec_lnk_nxt = $_POST['ec_lnk_nxt'];
	$_ec_snd->ec_sbj = $_POST['ec_sbj'];
	$_ec_snd->ec_prhdr = $_POST['ec_prhdr'];
	$_ec_snd->ec_frm = $_POST['ec_frm'];
	
	$_ec_snd->ec_pml = $_POST['ec_pml'];
	$_ec_snd->ec_sis = $_POST['ec_sis'];
	$_ec_snd->ec_us = $_POST['ec_us'];
	$_ec_snd->ec_act_frm = $_POST['ec_act_frm'];
	$_ec_snd->ec_fac = $_POST['_fac'];
	$_ec_snd->ec_cmz = $_POST['ec_cmz'];
	$_ec_snd->ec_flj = $_POST['ec_flj'];
	$_ec_snd->ec_pst_fb = !isN($_POST['ec_pst_fb'])?$_POST['ec_pst_fb']:2;

	$_ec_snd->ec_chk_hdr = 1;
	$_ec_snd->ec_chk_ftr = 1;

	$_ec_snd->ec_tp = $_POST['ec_tp'];
	$_ec_snd->ec_cl = DB_CL_ENC;		
	$_ec_snd->svsrce = 'ok'; // Esta guardando el codigo fuente?
	$Result = $_ec_snd->_EcSve([ 'norplc'=>'ok' ]);

	
	if($Result->e == 'ok'){
 		$rsp['enc'] = $Result->i;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['ahtml'] = $_ec_snd->ec_ahtml;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $Result->w;
	}
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && (($_POST["MM_update"] == "EdEc") || ($_POST["MM_update"] == "EdSndEcTmpl"))) { 
				
	$_ec_snd = new API_CRM_ec();

	$_ec_snd->id_ec =  $_POST['id_ec'];
	$_ec_snd->ec_enc = $_POST['ec_enc'];
	$_ec_snd->ec_tt =  $_POST['ec_tt'];
	$_ec_snd->ec_sbt = $_POST['ec_sbt'];
	$_ec_snd->ec_est = $_POST['ec_est'];
	$_ec_snd->ec_dmo = $_POST['ec_dmo'];
	$_ec_snd->ec_cds = $_POST['ec_cds'];
	$_ec_snd->ec_oth = $_POST['ec_oth'];
	$_ec_snd->ec_dsc = $_POST['ec_dsc'];
	$_ec_snd->ec_cd = $_POST['ec_cd'];
	$_ec_snd->ec_dir = $_POST['ec_dir'];
	$_ec_snd->ec_fnd = $_POST['ec_fnd'];
	$_ec_snd->ec_spn = $_POST['ec_spn'];
	$_ec_snd->ec_w = $_POST['ec_w'];
	$_ec_snd->ec_fm = $_POST['ec_fm'];
	$_ec_snd->ec_pdf = $_POST['ec_pdf'];
	$_ec_snd->ec_ord = $_POST['ec_ord'];
	$_ec_snd->ec_pay = $_POST['ec_pay'];
	$_ec_snd->ec_nmr = $_POST['ec_nmr'];
	$_ec_snd->ec_frw = $_POST['ec_frw'];
	$_ec_snd->ec_key = $_POST['ec_key'];
	$_ec_snd->ec_em = $_POST['ec_em'];
	$_ec_snd->ec_lnk = $_POST['ec_lnk'];
	$_ec_snd->ec_lnk_nxt = $_POST['ec_lnk_nxt'];
	$_ec_snd->ec_sbj = $_POST['ec_sbj'];
	$_ec_snd->ec_prhdr = $_POST['ec_prhdr'];
	$_ec_snd->ec_pml = $_POST['ec_pml'];
	$_ec_snd->ec_sis = $_POST['ec_sis'];
	$_ec_snd->ec_frm = $_POST['ec_frm'];
	$_ec_snd->ec_act_frm = $_POST['ec_act_frm'];
	$_ec_snd->ec_pml_upd = $_POST['ec_pml_UPD'];
	$_ec_snd->ec_cmz = $_POST['ec_cmz'];
	$_ec_snd->ec_flj = $_POST['ec_flj'];	
	$_ec_snd->ec_pst_fb = !isN($_POST['ec_pst_fb'])?$_POST['ec_pst_fb']:2;


	$_ec_snd->svsrce = 'ok'; // Esta guardando el codigo fuente?
	$_ec_snd->ec_chk_hdr = !isN($_POST['ec_chk_hdr'])?$_POST['ec_chk_hdr']:2;
	$_ec_snd->ec_chk_ftr = !isN($_POST['ec_chk_ftr'])?$_POST['ec_chk_ftr']:2;
				
	$Result = $_ec_snd->_EcUpd([ 'norplc'=>'ok' ]);
	
	if($Result->e == 'ok'){
		
		$rsp['w'] = $__cnx->c_p->error;
		//$rsp['i'] = $_POST['ec_enc'];
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['qry'] = $Result;
		$rsp['ahtml'] = $_ec_snd->ec_ahtml;
		
		//$rsp['a'] = Aud_Sis(Aud_Dsc(50, $_POST['ec_tt'], $_POST['id_ec']), $rsp['v']);

		$rsp['a'] = $_Crm_Aud->In_Aud([ 'aud'=>_CId('ID_AUDDSC_EC'), "db"=>'ec', "iddb"=>$_POST['ec_enc'], "post"=>$_POST]);
		

		$__ec = new API_CRM_ec();
		
		$__ec->id = $_POST['ec_enc'];

		$__ec->id_t = 'enc';
		$__ec->frm = 'Ml';
		$__ec->html = 'ok';    
		$__ec->sve_url = 'ok';
		
		$__body = 's'.$__ec->_bld();	
		//$rsp['i'] = $__ec->ec_id;	
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $Result->w;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEc' || ($_POST["MM_delete"] == "EdSndEcTmpl") ))) { 
	//$deleteSQL = sprintf('DELETE FROM '.TB_EC.' WHERE id_ec=%s', GtSQLVlStr($_POST['id_ec'], 'int'));
	
	$deleteSQL = sprintf('UPDATE '._BdStr(DBM).TB_EC.' SET ec_est = '._CId('ID_SISEST_OBSL').' WHERE ec_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	
	$Result = $__cnx->_prc($deleteSQL); 
	if($Result){
		$rsp['e'] = 'ok'; 
		$rsp['m'] = 1; 
		$rsp['a'] = Aud_Sis(Aud_Dsc(51, $_POST['ec_tt'], $_POST['id_ec']), $rsp['v']);
		$rsp['error'] = $deleteSQL; 
	}else{ 
		$rsp['e'] = 'no'; 
		$rsp['m'] = 2; 
		$rsp['error'] = $deleteSQL.' <-> '.$__cnx->c_p->error; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}
?>