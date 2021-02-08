 <?php 	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_cnt_enc = Php_Ls_Cln($_POST['_cnt_enc']);
		$_cntc_enc = Php_Ls_Cln($_POST['_cntc_enc']);
		
		$__Cls_Cnt = new CRM_Cnt(); 
		$__Cls_Cnt->cnt_enc = $_cnt_enc;
		$__Cls_Cnt->cntc_enc = $_cntc_enc;
		
		if($_dt == "cntc"){
			if($_est == "in"){
				$PrcDt = $__Cls_Cnt->CntHCntc_In();
			}else if($_est == "del"){
				$PrcDt = $__Cls_Cnt->CntHCntc_Eli();
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		$rsp['cnt']['cntc'] = $__Cls_Cnt->GtCntHCntc();
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>