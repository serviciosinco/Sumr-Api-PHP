<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClScrpt")) { 
		
	$__enc = Enc_Rnd($_POST['clscrpt_act'].'-'.$_POST['clscrpt_tp'].'-'.$_POST['cltag_vl']);
	
	if(!isN($_POST['clscrpt_sino'])){ $_sino=$_POST['clscrpt_sino']; }else{ $_sino=2; }
	if(!isN($_POST['clscrpt_end'])){ $_end=$_POST['clscrpt_end']; }else{ $_end=2; }
	
	$insertSQL = sprintf("INSERT INTO ".TB_CL_SCRPT." (clscrpt_enc, clscrpt_cl, clscrpt_act, clscrpt_tp, clscrpt_vl, clscrpt_sino, clscrpt_end, clscrpt_ord) VALUES (%s, (SELECT id_cl FROM ".TB_CL." WHERE cl_enc=%s), %s, %s, %s, %s, %s, %s)",
		                   GtSQLVlStr($__enc, "text"),
						   GtSQLVlStr(ctjTx($_POST['clscrpt_cl'],'out'), "text"),
						   GtSQLVlStr(ctjTx($_POST['clscrpt_act'],'out'), "text"),
						   GtSQLVlStr(ctjTx($_POST['clscrpt_tp'],'out'), "text"),
						   GtSQLVlStr(ctjTx($_POST['clscrpt_vl'],'out','',['html'=>'ok','schr'=>'no','nl2'=>'no']), "text"),
						   GtSQLVlStr($_sino, "int"),
						   GtSQLVlStr($_end, "int"),
						   GtSQLVlStr($_POST['clscrpt_ord'], "int"));
                   			
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(71, $_POST['sis_vl'], $__cnx->c_p->insert_id, $_POST['sis_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClScrpt")) { 
	
	if(!isN($_POST['clscrpt_sino'])){ $_sino=$_POST['clscrpt_sino']; }else{ $_sino=2; }
	if(!isN($_POST['clscrpt_end'])){ $_end=$_POST['clscrpt_end']; }else{ $_end=2; }

	$updateSQL = sprintf("UPDATE ".TB_CL_SCRPT." SET clscrpt_act=%s, clscrpt_tp=%s, clscrpt_vl=%s, clscrpt_sino=%s, clscrpt_end=%s, clscrpt_ord=%s WHERE clscrpt_enc=%s",
						GtSQLVlStr(ctjTx($_POST['clscrpt_act'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['clscrpt_tp'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['clscrpt_vl'],'out','',['html'=>'ok','schr'=>'no','nl2'=>'no']), "text"),
						GtSQLVlStr($_sino, "int"),
						GtSQLVlStr($_end, "int"),
						GtSQLVlStr($_POST['clscrpt_ord'], "int"),
						GtSQLVlStr($_POST['clscrpt_enc'], "text"));
	
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['sis_vl'], $_POST['id_cltag'], $_POST['sis_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClScrpt'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_CL_SCRPT.' WHERE clscrpt_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['sis_vl'], $_POST['id_cltag'], $_POST['sis_tt']), $rsp['v']);
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>