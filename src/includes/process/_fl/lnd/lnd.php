<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdLnd")) { 
			
	$__sbdmn = Gt_SbDMN();
	$__dt_cl = __Cl([ 'id'=>$__sbdmn, 't'=>'sbd' ]);	
			
	$__enc = Enc_Rnd($_POST['lnd_tt'].'-'.DB_CL_ENC);
	$__dir = date("Y").'_'.$__dt_cl->sbd.'_'.Gn_Rnd(10);;
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_LND." ( lnd_enc, lnd_cl, lnd_tt, lnd_html, lnd_js, lnd_js_rdy, lnd_js_ld, lnd_js_scrl, lnd_css, lnd_dir, lnd_opt_cmprs, lnd_fm_opq, lnd_fm_icn, lnd_us) VALUES ( %s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc=%s), %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                  
				GtSQLVlStr(ctjTx($__enc,'out'), "text"),
				GtSQLVlStr(DB_CL_ENC, "text"),
				GtSQLVlStr(ctjTx($_POST['lnd_tt'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['lnd_html'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
				GtSQLVlStr(ctjTx($_POST['lnd_js'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
				GtSQLVlStr(ctjTx($_POST['lnd_js_rdy'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
				GtSQLVlStr(ctjTx($_POST['lnd_js_ld'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
				GtSQLVlStr(ctjTx($_POST['lnd_js_scrl'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
				GtSQLVlStr(ctjTx($_POST['lnd_css'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
				GtSQLVlStr(ctjTx($__dir,'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['lnd_opt_cmprs'],'out'), "int"),
				GtSQLVlStr(ctjTx($_POST['lnd_fm_opq'],'out'), "int"),
				GtSQLVlStr(ctjTx($_POST['lnd_fm_icn'],'out'), "int"),
				GtSQLVlStr(ctjTx(SISUS_ID,'out'), "text")
				   				  
            );	
                   
                   		
	
	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['i'] = $__enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(71, $_POST['upfld_vl'], $__cnx->c_p->insert_id, $_POST['lnd_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['m2'] = $insertSQL.$__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdLnd")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_LND." SET lnd_tt=%s, lnd_html=%s, lnd_js=%s, lnd_js_rdy=%s, lnd_js_ld=%s, lnd_js_scrl=%s, lnd_css=%s, lnd_opt_cmprs=%s, lnd_fm_opq=%s, lnd_fm_icn=%s, lnd_fi=%s WHERE lnd_enc =%s",
					   
					GtSQLVlStr(ctjTx($_POST['lnd_tt'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['lnd_html'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
					GtSQLVlStr(ctjTx($_POST['lnd_js'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
					GtSQLVlStr(ctjTx($_POST['lnd_js_rdy'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
					GtSQLVlStr(ctjTx($_POST['lnd_js_ld'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
					GtSQLVlStr(ctjTx($_POST['lnd_js_scrl'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
					GtSQLVlStr(ctjTx($_POST['lnd_css'], 'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no'] ), "text"),
					GtSQLVlStr(ctjTx($_POST['lnd_opt_cmprs'],'out'), "int"),
					GtSQLVlStr(ctjTx($_POST['lnd_fm_opq'],'out'), "int"),
					GtSQLVlStr(ctjTx($_POST['lnd_fm_icn'],'out'), "int"),
					GtSQLVlStr(ctjTx($_POST['lnd_fi'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['lnd_enc'],'out'), "text"));
					
	 
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['upfld_vl'], $_POST['id_lnd'], $_POST['lnd_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdLnd'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_LND.' WHERE lnd_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; /*$rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['upfld_vl'], $_POST['uid'], $_POST['lnd_tt']), $rsp['v']);*/}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>