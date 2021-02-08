<?php 
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
	
        $_id_act = Php_Ls_Cln($_POST['_id_act']);
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdl']);

		$__mdl = new CRM_Mdl(); 

        $__mdl->mdls_act = $_id_act;
		$__mdl->mdls_mdl = $_id_mdl;
		
		if($_dt == 'mdl' && !isN($__mdl->mdls_mdl)){

			$__mdl->mdls_mdl_est = Blnm($_est);
			
			$PrcDt = $__mdl->ActGrd();
			$rsp['ed'] = $PrcDt;
			if($PrcDt->e == 'ok'){
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

		$rsp['mdl']['act'] = $__mdl->ActGrd_Ls();

	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}	
?>