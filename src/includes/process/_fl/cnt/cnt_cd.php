<?php 
	// Ingreso de Registro
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCntCd")) { 
		
		$__CntIn = new CRM_Cnt();
		$__CntIn->cnt_id = $_POST['cntcd_cnt'];
		$__CntIn->cnt_cd[] = [
				'id'=>$_POST['cntcd_cd'],
				'rel'=>$_POST['cntcd_rel']
			];
		
		$__in = $__CntIn->_Cnt();	
		
		if($__in->e == 'ok'){
			$rsp['enc'] = $__in->enc;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__in->w]);
		}
		
	}
	
	// Modificación de Registro primero este
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCntCd")) {
		
		$updateSQL = sprintf("UPDATE ".TB_CNT_CD."  SET cntcd_rel =%s WHERE cntcd_enc =%s",
		
						GtSQLVlStr($_POST['cntcd_rel'],"int"),
						GtSQLVlStr(ctjTx($_POST['cntcd_enc'], 'out'), "text"));		
	
        
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
?>