<?php 

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEcLstsEml")) { 
	
						$__CntIn = new CRM_Cnt();
						$__CntIn->ec_lsts_id = $_POST['eclstseml_lsts'];
						$__CntIn->cnt_dc = $_POST['eclstseml_dc'];
						$__CntIn->cnt_nm = $_POST['eclstseml_nm'];
						$__CntIn->cnt_ap = $_POST['eclstseml_ap'];
						$__CntIn->cnt_eml = ctjTx($_POST['eclstseml_eml'],'out');
						$PrcDt = $__CntIn->InEcLstsCnt();
						$PrcDtLsts = $PrcDt->eml_all->lsts;
						$rsp['d'] = print_r($PrcDtLsts, true);
						
 		if(($PrcDtLsts->e1->e == 'ok')||($PrcDtLsts->e2->e == 'ok')||($PrcDtLsts->e3->e == 'ok')){
			/*$rsp['i'] = $PrcDt->i;*/
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(259, $_POST['eclstseml_nm'], $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['es'] = 'no';
			$rsp['m'] = 2;
			if(!isN($PrcDt->w) && !isN($PrcDt->w_all)){ $rsp['w'] = $PrcDt->w.' '.$PrcDt->w_all; }
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEcLstsEml")) { 
	
			$__CntUp = new CRM_Cnt();
			$__CntUp->id_cnt = $_POST['eclstseml_idcnt'];
			$__CntUp->cnt_nm = ctjTx($_POST['eclstseml_nm'],'out');
			$__CntUp->cnt_ap = ctjTx($_POST['eclstseml_ap'],'out');
			$__dtus_up = $__CntUp->UpdCnt();	
					   
	if($__dtus_up->e == 'ok'){
		
		$rsp['i'] = $__dtus_up->i;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['k'] = $updateSQL;
		$rsp['a'] = Aud_Sis(Aud_Dsc(260, $_POST['eclstseml_nm'], $_POST['id_eclstseml']), $rsp['v']);		
		$UpdateEm = sprintf("UPDATE cnt_eml SET cnteml_eml=%s
													WHERE 
													cnteml_cnt=%s",
							                       GtSQLVlStr(ctjTx($_POST['eclstseml_eml'],'out'), "text"),													                       GtSQLVlStr($_POST['eclstseml_idcnt'], "int"));
												$Result_RLC = $__cnx->_prc($UpdateEm);
							if($Result_RLC){ $rsp['e'] = 'ok'; }else{ $rsp['e'] = 'no'; }
	
	}else{
		$rsp['e'] = 'no';
		
		$rsp['m'] = 2;
		$rsp['w'] = $__dtus_up->w;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__dtus_up->w));
		
	} 
}



// Elimino el Registro
if ((isset($_POST['id_eclstseml'])) && ($_POST['id_eclstseml'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEcLstsEml'))) { 
	$deleteSQL = sprintf("DELETE FROM ec_lsts_eml WHERE id_eclstseml=%s", GtSQLVlStr($_POST['id_eclstseml'], 'int'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	$rsp['a'] = Aud_Sis(Aud_Dsc(261, $_POST['eclstseml_nm'], $_POST['id_eclstseml']), $rsp['v']);
	}else{$rsp['e'] = 'no'; $rsp['m'] = 2; $rsp['q'] = $__cnx->c_p->error.$deleteSQL;}
}

?>