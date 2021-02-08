<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisCntTpGrp")) { 	
	
	$__enc = Enc_Rnd($_POST['siscnttpgrp_nm']);		
		
	$insertSQL = sprintf("INSERT INTO ".TB_SIS_CNT_TP_GRP." (siscnttpgrp_enc, siscnttpgrp_nm, siscnttpgrp_key, siscnttpgrp_clr) VALUES (%s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx($_POST['siscnttpgrp_nm'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['siscnttpgrp_key'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['siscnttpgrp_clr'],'out'), "text"));

                   
	
	
	$Result = $__cnx->_prc($insertSQL);
		if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(499, $_POST['siscnttpgrp_nm'], $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisCntTpGrp")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_SIS_CNT_TP_GRP." SET siscnttpgrp_nm=%s, siscnttpgrp_key=%s, siscnttpgrp_clr=%s WHERE siscnttpgrp_enc=%s",
						GtSQLVlStr(ctjTx($_POST['siscnttpgrp_nm'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['siscnttpgrp_key'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['siscnttpgrp_clr'],'out'), "text"),
						GtSQLVlStr($_POST['siscnttpgrp_enc'], "text"));
						
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(500, $_POST['siscnttpgrp_nm'], $_POST['id_siscnttpgrp']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisCntTpGrp'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_SIS_CNT_TP_GRP.' WHERE siscnttpgrp_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 $rsp['a'] = Aud_Sis(Aud_Dsc(501, $_POST['siscnttpgrp_nm'], $_POST['uid']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>