<?php 
	
	$__TraIn = new CRM_Tra();
	$TraDt = GtTraLs([ "t"=>"ord", "id"=>$_POST['tra_col'] ]);
	
	$__TraIn->db = 'tra';
	$__TraIn->post = $_POST;
	
	
	$__TraIn->id_tra = $_POST['id_tra'];
	$__TraIn->tra_tt = $_POST['_tt']; 
	$__TraIn->tra_dsc = $_POST['tra_dsc'];
	$__TraIn->tra_col = $_POST['tra_col'];
	$__TraIn->tra_f = $_POST['tra_f'];
	$__TraIn->tra_h = $_POST['tra_h'];
	$__TraIn->tra_cls = $_POST['tra_cls'];
	$__TraIn->tra_tp = $_POST['tra_tp'];
	$__TraIn->tra_cnt = $_POST['tra_cnt'];
	$__TraIn->tra_est = $_POST['tra_est'];
	$__TraIn->invk->by = _CId('ID_SISINVK_CRM');

	$__TraIn->trarsp_us = $_POST['tra_us1'];
	$__TraIn->trarsp_tp = _CId('ID_USROL_RSP');
	
	$__TraIn->mdlcnttra_mdlcnt = $_POST['mdlcnttra_mdlcnt'];
	
	if(!isN($TraDt->ult)){
		$__TraIn->tra_ord = ($TraDt->ult+1);
	}else{
		$__TraIn->tra_ord = 1;
	}
	
	// Ingreso de Registro
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlCntTra")) {
		
		if(isN($__TraIn->tra_col)){
			$rsp['e'] = 'no';
			$rsp['w'] = 'Seleccione columna';
		}else if(isN($__TraIn->trarsp_us)){
			$rsp['e'] = 'no';
			$rsp['w'] = 'Seleccione responsable';
		}else{
			
			$PrcDt = $__TraIn->In_Tra();
			$rsp['in_tra'] = $PrcDt;
			
			if($PrcDt->e == 'ok'){ 
				
				$rsp['e'] = $PrcDt->e;
				$rsp['m'] = 1;
				$PrcDt1 = $__TraIn->In_MdlTraCnt(['cnt'=>$__TraIn->tra_cnt,'tra'=>$PrcDt->i]);
				$rsp['in_mdltracnt'] = $PrcDt1;
				
			}else{
				$rsp['w1'] = $__cnx->c_p->error;
				$rsp['e'] = 'no';
				$rsp['m'] = 2;		
			}
			
		}
		
	}

	// Modificación de Registro
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlCntTra")) { 
	
		if(isN($__TraIn->tra_col)){
			$rsp['e'] = 'no';
			$rsp['w'] = 'Seleccione columna';
		}else if(isN($__TraIn->trarsp_us)){
			$rsp['e'] = 'no';
			$rsp['w'] = 'Seleccione responsable';
		}else{
			
			$PrcDt = $__TraIn->Upd_Tra();
			
			if($PrcDt->e == 'ok'){
				$rsp['e'] = $PrcDt->e;
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;	
			}
			
		}
		
	}

	// Elimino el Registro
	if ((isset($_POST['id_trarsp'])) && ($_POST['id_trarsp'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdTra'))) { 
		
		global $__cnx;
	
		$deleteSQL = sprintf("DELETE FROM $__bd WHERE trarsp_enc=%s", GtSQLVlStr($_POST['trarsp_enc'], "text")); $rsp['s'] = $deleteSQL;
		$Result = $__cnx->_prc($deleteSQL); 
		
		if($Result){
				$rsp['e'] = 'ok'; $rsp['m'] = 1;
				//$rsp['a'] = Aud_Sis(Aud_Dsc(27, $__cnx->c_p->insert_id, $__dt_abrcmp->tt), $rsp['v']);
				$rsp['a'] = Aud_Sis(Aud_Dsc(537, 'Responsable de la tarea', $_POST['id_trarsp']), $rsp['v']);
		}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2; 
				$rsp['w'] = $__cnx->c_p->error;
				_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
		}
		
		$__cnx->_clsr($Result);
		
	}
	
?>