<?php 
	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);

		$_id_cl = Php_Ls_Cln($_POST['_id_cl']);
		$_id_fnt = Php_Ls_Cln($_POST['_id_fnt']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		
		$__Cl->fnt_id = $_id_fnt;
		$__Cl->cl_id = $_id_cl;
		
			
		if($_dt == 'fnt' && ($_est == 'in' || $_est == 'del')){

			if($_est == 'in'){
				$PrcDt = $__Cl->SisFntCl_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->SisFntCl_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['cl']['fnt'] = $__Cl->SisFntCl_Ls();
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>