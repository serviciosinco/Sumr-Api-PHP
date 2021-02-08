<?php 
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
		$_id_ec = Php_Ls_Cln($_POST['_id_ec']);
		$_id_fle = Php_Ls_Cln($_POST['_id_fle']);
		
		
		$__mdl = new CRM_Mdl(); 
		$__mdl->post = $_POST; 
		$__mdl->db = $_tp;
		
		$__mdl->mdlfle_mdl = $_id_mdl;	
		$__mdl->mdlfle_ec = $_id_ec;

		if($_dt == 'fle'){

				
			$__mdl->mdlfle_fle = $_id_fle;	
			
			if($_est == 'ok'){
				$PrcDt = $__mdl->MdlFle_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__mdl	->MdlFle_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}	
		}

		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
	
		$rsp['cl']['mdl']['fle'] = $__mdl->MdlFle_Ls();
		
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>