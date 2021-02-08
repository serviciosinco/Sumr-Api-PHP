<?php
		
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisCdn")) { 
		
	$__enc = Enc_Rnd($_POST['siscdn_tt'].'-'.$_POST['siscdn_url']);
	$__uenc = enCad($_POST['siscdn_url']);
	
	if(!isN($_POST['siscdn_up'])){ $__up = $_POST['siscdn_up']; }else{ $__up = 2; }
	if(!isN($_POST['siscdn_js'])){ $__js = $_POST['siscdn_js']; }else{ $__js = 2; }
	if(!isN($_POST['siscdn_css'])){ $__css = $_POST['siscdn_css']; }else{ $__css = 2; }
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_CDN." ( siscdn_enc, siscdn_tt, siscdn_url, siscdn_url_key, siscdn_v, siscdn_up, siscdn_js, siscdn_css) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['siscdn_tt'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['siscdn_url'],'out'), "text"),
				   GtSQLVlStr(ctjTx($__uenc,'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['siscdn_v'],'out'), "text"),
				   GtSQLVlStr($__up, "int"),
				   GtSQLVlStr($__js, "int"),
				   GtSQLVlStr($__css, "int"));	
           		
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		$rsp['i'] = $__enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(71, $_POST['siscdn_url'], $__cnx->c_p->insert_id, $_POST['siscdn_tt']), $rsp['v']);
		__AutoRUN([ 't'=>'sis_cns', 'bd'=>$__bdauto ]);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if (($_POST["MM_update"] == "EdSisCdn")) { 
	
	$__uenc = enCad($_POST['siscdn_url']);
	
	if(!isN($_POST['siscdn_up'])){ $__up = $_POST['siscdn_up']; }else{ $__up = 2; }
	if(!isN($_POST['siscdn_js'])){ $__js = $_POST['siscdn_js']; }else{ $__js = 2; }
	if(!isN($_POST['siscdn_css'])){ $__css = $_POST['siscdn_css']; }else{ $__css = 2; }
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_CDN." SET siscdn_tt=%s, siscdn_url=%s, siscdn_url_key=%s, siscdn_v=%s, siscdn_up=%s, siscdn_js=%s, siscdn_css=%s WHERE siscdn_enc =%s",
					   GtSQLVlStr(ctjTx($_POST['siscdn_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['siscdn_url'],'out'), "text"),
					   GtSQLVlStr(ctjTx($__uenc,'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['siscdn_v'],'out'), "text"),
					   GtSQLVlStr($__up, "int"),
					   GtSQLVlStr($__js, "int"),
					   GtSQLVlStr($__css, "int"),
                       GtSQLVlStr(ctjTx($_POST['siscdn_enc'],'out'), "text"));

	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['siscdn_url'], $_POST['sis_enc'], $_POST['siscdn_tt']), $rsp['v']);
		__AutoRUN([ 't'=>'sis_cns', 'bd'=>$__bdauto ]);
	}else{
		$rsp['e'] = 'nop';
		$rsp['m'] = 2;
		$rsp['ms'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisCdn'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_SIS_CDN.' WHERE siscdn_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['siscdn_url'], $_POST['uid'], $_POST['siscdn_tt']), $rsp['v']);}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>