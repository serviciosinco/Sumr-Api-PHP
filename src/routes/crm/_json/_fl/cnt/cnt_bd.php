 <?php 
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_cnt_enc = Php_Ls_Cln($_POST['_cnt_enc']);
		$_bd_enc = Php_Ls_Cln($_POST['_bd_enc']);
		$_sisbd_nm = Php_Ls_Cln($_POST['sisbd_nm']);
		
		// t_2
		$_t2 = Php_Ls_Cln($_POST['t2']);
		
		$__Cls_Cnt = new CRM_Cnt(); 
		$__Cls_Cnt->cnt_enc = $_cnt_enc;
		$__Cls_Cnt->sisbd_enc = $_bd_enc;
		$__Cls_Cnt->sisbd_nm = $_sisbd_nm;
		
		if($_dt == "mdl"){
			
			if($_est == "in"){
				$PrcDt = $__Cls_Cnt->_Cnt_Bd_In();
			}else if($_est == "del"){
				$PrcDt = $__Cls_Cnt->_Cnt_Bd_Eli();
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		} elseif($_dt == "new_bd"){
		
	
			$PrcDt = $__Cls_Cnt->_Sis_Bd_In();	
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}

		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n;
			 }
		
		
		$rsp['cnt']['bd'] = $__Cls_Cnt->GtCntBdLs();
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>