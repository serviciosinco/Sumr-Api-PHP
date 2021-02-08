<?php 
	
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_cl = Php_Ls_Cln($_POST['_id_cl']);
		$_id_mdlstp = Php_Ls_Cln($_POST['_id_mdlstp']);
		$_id_sisslc = Php_Ls_Cln($_POST['_id_sisslc']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		$__Cl->sisslccl_mdlstp = $_id_mdlstp;
		$__Cl->sisslccl_sisslc = $_id_sisslc;
	
			
		if(!isN($_id_sisslc)){
			
			
			if(!isN($_id_cl)){
				
				$__cl = GtClDt($_id_cl, 'enc');
				$__Cl->sisslccl_cl = $__cl->id;
				
				if($_est == 'in'){
					$PrcDt = $__Cl->SisSlcCl_In();
				}elseif($_est == 'del'){
					$PrcDt = $__Cl->SisSlcCl_Del();	
				}
				
				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;
				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				}
				
			}
			if(!isN($_id_mdlstp)){
				
				if($_est == 'in'){
					$PrcDt = $__Cl->SisSlc_Mdl_In();
				}elseif($_est == 'del'){
					$PrcDt = $__Cl->SisSlc_Mdl_Del();	
				}
				
				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;
					$rsp['ed'] = $PrcDt;
				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
					}
				
			}


		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		$rsp['cl']['sisslc']['cl'] = $__Cl->Cl_Ls([ 'on'=>1 ]);
		$rsp['cl']['sisslc']['mdls'] = $__Cl->SisSlc_Mdl();
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
	}
	
?>