<?php 
	
	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);

        $_id_org = Php_Ls_Cln($_POST['_id_org']);
		$_id_grp = Php_Ls_Cln($_POST['_id_grp']);
		
		$__org = new CRM_Org(); 
	
        $__org->org_enc = $_id_org;
        $__org->grp_enc = $_id_grp;


		if($_dt == 'grp' && !isN($__org->grp_enc)){

			$__org->org_est = Blnm($_est);
			
			$PrcDt = $__org->OrgGrp();
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

		$rsp['org']['grp'] = $__org->OrgGrp_Ls();
		
		
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>