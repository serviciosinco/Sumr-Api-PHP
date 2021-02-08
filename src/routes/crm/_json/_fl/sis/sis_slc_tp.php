<?php 
	
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_cl = Php_Ls_Cln($_POST['_id_cl']);
		$_id_sisslc = Php_Ls_Cln($_POST['_id_sisslctp']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		$__Cl->sisslccl_sisslc = $_id_sisslc;
	
			
		if(!isN($_id_cl)){
			
			$__Cl->sisslccl_cl = $_id_cl;
			
			if($_est == 'in'){
				$PrcDt = $__Cl->SisSlcTpCl_In();
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->SisSlcTpCl_Del();	
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		$rsp['sisslc']['cl'] = $__Cl->SisSlcTpCl([ 'on'=>1 ]);
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
	}
	
?>