<?php 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCntRlc")) {

		$__dt_cnt = GtUsDt($_POST['cntrlc_rlc_cnt']);
		
		
		$insertSQL = sprintf("INSERT INTO ".TB_CNT_RLC_BD." (id_cntrlc, cntrlc_cnt, cntrlc_rlc, cntrlc_rlc_cnt, cntrlc_rcg, cntrlc_fi, cntrlc_fa) VALUES (%s, %s, %s, %s, %s, %s, %s)",
					   GtSQLVlStr($_POST['id_cntrlc'], "int"),
		               GtSQLVlStr($_POST['cntrlc_cnt'], "int"),
		               GtSQLVlStr($_POST['cntrlc_rlc'], "text"),
		               GtSQLVlStr($_POST['cntrlc_rlc_cnt'], "int"),
		               GtSQLVlStr($_POST['cntrlc_rcg'], "int"),
					   GtSQLVlStr(SIS_F, "date"),
					   GtSQLVlStr(SIS_F, "date"));
					   		
		
		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCntRlc")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_CNT_RLC_BD." SET cntrlc_cnt=%s, cntrlc_rlc=%s, cntrlc_rlc_cnt=%s, cntrlc_rcg=%s, cntrlc_fi=%s, cntrlc_fa=%s WHERE cntrlc_enc=%s",
		               GtSQLVlStr($_POST['cntrlc_cnt'], "int"),
		               GtSQLVlStr($_POST['cntrlc_rlc'], "text"),
		               GtSQLVlStr($_POST['cntrlc_rlc_cnt'], "int"),
		               GtSQLVlStr($_POST['cntrlc_rcg'], "int"),
                       GtSQLVlStr(SIS_F, "date"),
					   GtSQLVlStr(SIS_F, "date"),
					   GtSQLVlStr($_POST['cntrlc_enc'], "text"));
					   
	;
	$Result = $__cnx->_prc($updateSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(146, $_POST['cntrlc_mdlcnt'], $_POST['id_cntrlc']), $rsp['v']);	
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_cntrlc'])) && ($_POST['id_cntrlc'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdCntRlc'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_CNT_RLC_BD.' WHERE id_cntrlc=%s', GtSQLVlStr($_POST['id_cntrlc'], 'int'));
	$Result = $__cnx->_prc($deleteSQL); 
	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(147, $_POST['cnt_nm'], $_POST['id_cnt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}
?>