<?php 
	// Ingreso de Registro

	$__TraColIn = new CRM_Tra();
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdTraColGrp")) { 
		
		$__TraColIn->tracol_tt = $_POST['tracol_tt'];
		$__TraColIn->tracol_clr = $_POST['tracol_clr'];
		$__TraColIn->tracol_tp = $_POST['tracol_tp'];
		$__TraColIn->tracol_icn = _CId('ID_TRACOLICN_DOC');
		$__TraColIn->tracol_chk_pqr = ($_POST['tracol_chk_pqr'] == 1) ? "1" : "2";
		$__TraColIn->tracol_chk_tck = ($_POST['tracol_chk_tck'] == 1) ? "1" : "2";
		$__TraColIn->tracol_chk_pblc = ($_POST['tracol_chk_pblc'] == 1) ? "1" : "2";

		$PrcDt = $__TraColIn->In_Tra_Col();
 	
 		if($PrcDt->e = "ok" && !isN($PrcDt->id)){
	 		
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$_id = $PrcDt->id;
			
			$TraColDt = GtTraColDt();
			
			$rsp['m'] = $TraColDt;
			if($TraColDt->ult > 0 && $TraColDt->ult!= '' && $TraColDt->ult != NULL){ $__TraColIn->tracolord_ord = ($TraColDt->ult+1);}else{$__TraColIn->tracolord_ord = 1; }
			
			$__TraColIn->In_Tra_Col_Ord([ 'col'=>$_id ]);
			$__TraColIn->In_Tra_Col_Grp([ 'col'=>$_id, 'grp'=>$_POST["tracolgrp_grp"] ]);
			
		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = $PrcDt->w;
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
	}
		

	// Modificación de Registro primero este
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdTraColGrp" || $_POST["MM_update"] == "EdTraCol")) { 
		
		$__TraColIn->tracol_tt = $_POST['tracol_tt'];
		$__TraColIn->tracol_clr = $_POST['tracol_clr'];
		$__TraColIn->tracol_tp = $_POST['tracol_tp'];
		$__TraColIn->tracol_enc = $_POST['tracol_enc'];
		$__TraColIn->tracol_chk_pqr = (!isN($_POST['tracol_chk_pqr'])) ? "1" : "2";
		$__TraColIn->tracol_chk_tck = (!isN($_POST['tracol_chk_tck'])) ? "1" : "2";
		$__TraColIn->tracol_chk_pblc = (!isN($_POST['tracol_chk_pblc'])) ? "1" : "2";
			
		$PrcDt = $__TraColIn->Upd_Tra_Col();
 		
 		if($PrcDt->e = "ok"){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$_id = $PrcDt->id;	
		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = 'no';
			$rsp['m'] = $PrcDt->w;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		 
	}
	
		
	// Elimino el Registro
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdTraColGrp'))) { 
		global $__cnx;
		$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_TRA_COL." WHERE tracol_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result =$__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
		$__cnx->_clsr($Result);
	}
?>