<?php

$___plcy_id = $_POST['mdlstpfm_plcy'];

if(!isN($___plcy_id)){
	$___plcydt = GtClPlcyDt([ 'id'=>$___plcy_id, 't'=>'enc' ]);
}	
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlSTpFm")) { 
	
	$__enc = Enc_Rnd( $_POST['mdlstpfm_nm'].'-'.$_POST['mdlstpfm_plcy'] );
	
    $insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_FM." (mdlstpfm_enc, mdlstpfm_cl, mdlstpfm_nm, mdlstpfm_thm, mdlstpfm_plcy, mdlstpfm_thx_top, 
                                                                        mdlstpfm_thx_url, mdlstpfm_thx_tt, mdlstpfm_thx_sbt, mdlstpfm_thx_dsc, mdlstpfm_s_sch, 
                                                                        mdlstpfm_plcytt, mdlstpfm_plcytx, mdlstpfm_plcylnk, mdlstpfm_s_org_emp, mdlstpfm_s_org_uni, 
                                                                        mdlstpfm_s_org_clg, mdlstpfm_s_cl_sds, mdlstpfm_s_mdltp, mdlstpfm_s_are, mdlstpfm_s_allmdl, mdlstpfm_s_fltmdlstp, 
                                                                        mdlstpfm_s_mlt, mdlstpfm_s_prd, mdlstpfm_s_cmnt, mdlstpfm_dft_ps, mdlstpfm_clr_btn, mdlstpfm_fnt, mdlstpfm_css) 

                                                                        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($__dt_cl->id, "int"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_nm'],'out'), "text"),
                       GtSQLVlStr($_POST['mdlstpfm_thm'], "int"),
                       GtSQLVlStr($___plcydt->id, "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_thx_top']), "int"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_thx_url'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_thx_tt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_thx_sbt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_thx_dsc'],'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']), "text"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_sch']), "int"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_plcytt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_plcytx'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_plcylnk'],'out'), "text"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_org_emp']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_org_uni']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_org_clg']), "int"), 
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_cl_sds']), "int"), 
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_mdltp']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_are']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_allmdl']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_fltmdlstp']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_mlt']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_prd']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_cmnt']), "int"),
                       GtSQLVlStr($_POST['mdlstpfm_dft_ps'], "int"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_clr_btn'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_fnt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_css'],'out'), "text"));	 
                       	
	
	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['er'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlSTpFm")) { 
	
    $updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S_TP_FM." SET 
                        mdlstpfm_nm=%s, mdlstpfm_thm=%s, mdlstpfm_plcy=%s, mdlstpfm_thx_top=%s, mdlstpfm_thx_url=%s, mdlstpfm_thx_tt=%s, mdlstpfm_thx_sbt=%s, mdlstpfm_thx_dsc=%s, mdlstpfm_s_sch=%s, 
                        mdlstpfm_plcytt=%s, mdlstpfm_plcytx=%s, mdlstpfm_plcylnk=%s, mdlstpfm_s_org_emp=%s, 
                        mdlstpfm_s_org_uni=%s, mdlstpfm_s_org_clg=%s, mdlstpfm_s_cl_sds=%s, mdlstpfm_s_mdltp=%s, mdlstpfm_s_are=%s, 
                        mdlstpfm_s_allmdl=%s, mdlstpfm_s_fltmdlstp=%s, mdlstpfm_s_mlt=%s, mdlstpfm_s_prd=%s, mdlstpfm_s_cmnt=%s, mdlstpfm_dft_ps=%s, mdlstpfm_clr_btn=%s, mdlstpfm_fnt=%s,
                        mdlstpfm_css=%s WHERE mdlstpfm_enc=%s",					
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_nm'],'out'), "text"),
                       GtSQLVlStr($_POST['mdlstpfm_thm'], "int"),
                       GtSQLVlStr($___plcydt->id, "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_thx_top']), "int"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_thx_url'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_thx_tt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_thx_sbt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_thx_dsc'],'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']), "text"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_sch']), "int"),

                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_plcytt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_plcytx'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_plcylnk'],'out'), "text"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_org_emp']), "int"),

                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_org_uni']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_org_clg']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_cl_sds']), "int"), 
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_mdltp']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_are']), "int"),

                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_allmdl']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_fltmdlstp']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_mlt']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_prd']), "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['mdlstpfm_s_cmnt']), "int"),
                       GtSQLVlStr($_POST['mdlstpfm_dft_ps'], "int"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_clr_btn'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_fnt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_css'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['mdlstpfm_enc'],'out'), "text"));
	
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['ms'] = $updateSQL;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlSTpFm'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_MDL_S_TP_FM.' WHERE mdlstpfm_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 //$rsp['a'] = Aud_Sis(Aud_Dsc(483, $_POST['mdls_nm'], $_POST['id_mdls']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}


?>