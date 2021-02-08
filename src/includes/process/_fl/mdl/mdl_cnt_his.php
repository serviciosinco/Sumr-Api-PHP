<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlCntHis")) { 
	
	
	$__HisIn = new CRM_Cnt();
	$__HisIn->mdlcnthis_mdlcnt = $_POST['mdlcnthis_mdlcnt'];
	$__HisIn->mdlcnthis_tp = $_POST['mdlcnthis_tp'];
	$__HisIn->mdlcnthis_dsc = $_POST['mdlcnthis_dsc'];
	$__HisIn->mdlcnthis_us = SISUS_ID;
	
	$PrcDt = $__HisIn->HisIn([ 't'=>'mdl' ]);
		
	if($PrcDt->e == 'ok'){		
		
		$__est_now = GtCntEstDt([ 'id'=>$_POST['mdlcnthis_est'] ]);
		$__est_lst = GtMdlCntEst_Lst([ 'id'=>$_POST['mdlcnthis_mdlcnt'], 'nw'=>$_POST['mdlcnthis_est'] ]);
		
		if($__est_lst->df == 'ok' && ($__est_lst->e != 29 || ($__est_now->ord >= 3) )){ 
			
			if(Html_chck_vl($_POST['mdlcnt_chk_vll']) == 1 && $__est_lst->e != 32 ){ 
				$__e_go = 32; 
			}else{ 
				$__e_go = $_POST['mdlcnthis_est']; 	
			} 
			$_cnt_est = __MdlCntEst([ 'c'=>$_POST['mdlcnthis_mdlcnt'], 'e'=>$__e_go ]); 
		
		}
		
		
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['cl'] = "  __NxtTra(); ";	
		
	}else{
		
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $PrcDt;
		
	}
	
}


// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlCntHis")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_MDL_CNT_HIS." SET mdlcnthis_dsc=%s WHERE mdlcnthis_enc=%s",
						   GtSQLVlStr(ctjTx($_POST['mdlcnthis_dsc'],'out'), "text"),
						   GtSQLVlStr($_POST['mdlcnthis_enc'], "text"));				   
	
	$Result = $__cnx->_prc($updateSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Elimino el Registro
if ((isset($_POST["id_mdlcnthis"])) && ($_POST["id_mdlcnthis"] != "") && ((isset($_POST["MM_delete"]))&&($_POST["MM_delete"] == "EdMdlCntHis"))) { 
	$deleteSQL = sprintf("DELETE FROM ".TB_MDL_CNT_HIS." WHERE mdlcnthis_enc=%s", GtSQLVlStr($_POST['mdlcnthis_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	if($Result){
		$rsp['e'] = 'ok'; 
		$rsp['m'] = 1; 
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}

?>