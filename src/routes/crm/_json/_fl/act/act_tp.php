<?php 
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_clg = Php_Ls_Cln($_POST['_id_clg']);
        $_id_act = Php_Ls_Cln($_POST['_id_act']);
		$_id_acttp = Php_Ls_Cln($_POST['_id_acttp']);
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
		$_t3 = Php_Ls_Cln($_POST['_t3']);
		$_t2 = Php_Ls_Cln($_POST['_t2']);

		if(!isN($_t3)){
			$__mdl->mdls_tp = $_t3;
		}else{
			$__mdl->mdls_tp = $_t2;
		}

		
		
		$__mdl = new CRM_Mdl(); 
		
        $__mdl->mdls_clg = $_id_clg;	
        $__mdl->mdls_act = $_id_act;
		$__mdl->mdls_acttp = $_id_acttp;
		$__mdl->mdls_mdl = $_id_mdl;
		

		if($_dt == 'act' && !isN($__mdl->mdls_acttp)){

			$__mdl->mdls_acttp_est = Blnm($_est);
			
			$PrcDt = $__mdl->ActTp();
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif($_dt == 'mdl' && !isN($__mdl->mdls_mdl)){

			$__mdl->mdls_mdl_est = Blnm($_est);
			
			$PrcDt = $__mdl->MdlAct();
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		if($_dt == 'act'){
			$rsp['mdl']['tp']['act'] = $__mdl->ActTp_Ls();
			$rsp['mdl']['tp']['sds'] = $__mdl->ActClgSds_Ls();
		}elseif($_dt == 'mdl'){
			$rsp['mdl']['act'] = $__mdl->MdlAct_Ls();
		}
		
		
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>