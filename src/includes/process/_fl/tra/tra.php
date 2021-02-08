<?php 
	
	
$__rlc = Php_Ls_Cln($_POST['___t_rlc']);
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdTra")) {
		
	$__TraIn = new CRM_Tra();
	$__TraIn->__t = $__t;
	$__TraIn->___t_rlc = $__rlc;
	$__TraIn->tra_tt = $_POST['tra_tt'];
	$__TraIn->tra_dsc = $_POST['tra_dsc'];
	$__TraIn->tra_f = $_POST['tra_f'];
	$__TraIn->tra_h = $_POST['tra_h'];
	$__TraIn->invk->by = _CId('ID_SISINVK_CRM');
	
	$PrcDt = $__TraIn->In_Tra();
	$rsp['e'] = $PrcDt->e;
	$rsp['m'] = $PrcDt->m;
	$rsp['w'] = $PrcDt->w;
	$rsp['i'] = $PrcDt->i;
	
	if($__t == 'emp_vst_tra'){
		

					
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_VST_BD." ( empvsttra_tra	, empvsttra_vst) VALUES (%s, %s)",
	                GtSQLVlStr($rsp['i'], "int"),
	                GtSQLVlStr($_POST['___t_rlc'], "int"));
		
	$Result = $__cnx->_prc($insertSQL);

	//echo $insertSQL;
		if($Result){
		$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(279, 'Visita de la empresa', $__cnx->c_p->insert_id), $rsp['v']);
		
			$Result_UPD =$__cnx->_prc($updateSQL);
			$Result_tra = $__cnx->_prc($insertSQLtra);
			$_dt_cnt = GtCntCrrDt($_POST['empvst_cnt']);
		
		//$rsp['cl'] = " __NxtEmpSub('nxt_ofr', '".$_dt_cnt->emp->tot_vst."'); ";
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}	
		$PrcDt->i;	
	}
	
		
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdTra")) { 

		$__TraIn = new CRM_Tra();
		$__TraIn->tra_cls = $_POST['tra_cls'];
		$__TraIn->tra_tt = $_POST['tra_tt'];
		$__TraIn->tra_dsc = $_POST['tra_dsc'];
		$__TraIn->tra_tp = $_POST['tra_tp'];
		$__TraIn->tra_est = $_POST['tra_est'];
		$__TraIn->tra_f = $_POST['tra_f'];
		$__TraIn->tra_h = $_POST['tra_h'];
		$__TraIn->id_tra  = $_POST['id_tra'];
		
		
		$PrcDt = $__TraIn->Upd_Tra();
		
		$rsp['e'] = $PrcDt->e;
		$rsp['m'] = $PrcDt->m;
		$rsp['w'] = $PrcDt->w;
		
}

// updade desde check
if ((isset($_POST["MMM_update_cls"])) && ($_POST["MMM_update_cls"] == "EdTra")) { 
	
	global $__cnx;
	
	if($_POST['tra_cls'] != ''){ $_upd_cls = $_POST['tra_cls']; }else{ $_upd_cls = 2; }

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_TRA." SET tra_cls=%s, tra_chk_rsp='2' WHERE id_tra=%s",
						   GtSQLVlStr($_upd_cls, "int"),
						   GtSQLVlStr($_POST['id_tra'], "int"));

		$Result = $__cnx->_prc($updateSQL);
		if($Result){
			$rsp['i'] = $_POST['id_tra'];
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(26, $__cnx->c_p->insert_id, $__dt_abrcmp->tt), $rsp['v']);
			
				if($__t == 'emp_vst_tra'){
					$insertSQL = sprintf("UPDATE "._BdStr(DBM).TB_TRA_VST_BD." SET empvsttra_tra=%s, empvsttra_vst=%s id_tra=%s",
					                GtSQLVlStr($rsp['i'], "int"),
					                GtSQLVlStr($_POST['___t_rlc'], "int"));

					$Result = $__cnx->_prc($insertSQL);
					//echo $insertSQL;
			 		if($Result){
						$rsp['i'] = $__cnx->c_p->insert_id;
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
						//$rsp['a'] = Aud_Sis(Aud_Dsc(279, 'Visita de la empresa', $__cnx->c_p->insert_id), $rsp['v']);
							$Result_UPD = $__cnx->c_p($updateSQL);
							$Result_tra = $__cnx->c_p($insertSQLtra);
						$_dt_cnt = GtCntCrrDt($_POST['empvst_cnt']);
						//$rsp['cl'] = " __NxtEmpSub('nxt_ofr', '".$_dt_cnt->emp->tot_vst."'); ";
					}else{
						$rsp['e'] = 'no';
						$rsp['m'] = 2;
						$rsp['w'] = $__cnx->c_p->error;
						_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
					}	
						$PrcDt->i;	
					}
					
					$__cnx->_clsr($Result);
						
			
			
			if($_POST['__ntf'] != ''){ $rsp['cl'] = " SUMR_Main.ntf.rmv(".$_POST['__ntf'].", 'tra'); "; }
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		} 
}
// fin updade desde check

// Elimino el Registro
if ((isset($_POST['id_tra'])) && ($_POST['id_tra'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdTra'))) { 
	
	global $__cnx;

	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_TRA.' WHERE tra_enc=%s', GtSQLVlStr($_POST['tra_enc'], 'text')  ); $rsp['s'] = $deleteSQL;
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){
			$rsp['i'] = $_POST['id_tra'];
			$rsp['e'] = 'ok'; 
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(34,  $_POST['tra_dsc'], $rsp['i']), $rsp['v']);
			if($_POST['__ntf'] != ''){ $rsp['cl'] = " SUMR_Main.ntf.rmv(".$_POST['__ntf'].", 'tra'); "; }
	}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2; 
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
	
	$__cnx->_clsr($Result);
	
}
?>