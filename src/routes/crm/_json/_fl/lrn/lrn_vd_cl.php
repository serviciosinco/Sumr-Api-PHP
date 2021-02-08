 <?php 
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_lrn_enc = Php_Ls_Cln($_POST['_id_vd']);
		$_cl_enc = Php_Ls_Cln($_POST['_cl_enc']);
		
		
		// t_2
		$_t2 = Php_Ls_Cln($_POST['t2']);
		
		$__Cls_Lrn = new CRM_Cl(); 
		$__Cls_Lrn->lrn_enc = $_lrn_enc;
		$__Cls_Lrn->cl_enc = $_cl_enc;
		
		
		
		if($_dt == "lrn"){
			
			
			if($_est == "in"){
				$PrcDt = $__Cls_Lrn->_LrnVd_Cl_In();
			}elseif($_est == "del"){
				$PrcDt = $__Cls_Lrn->_LrnVd_Cl_Eli();
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		} 

		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n;}

		$rsp['lrnvd'] = $__Cls_Lrn->GtLrnVdClLs();
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>