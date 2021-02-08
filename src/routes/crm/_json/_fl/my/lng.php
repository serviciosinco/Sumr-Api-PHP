<?php 
	
	
	try{
		

		$_tp = Php_Ls_Cln($_POST['t']);

		$__Cl = new CRM_Cl(); 
			
			
		if(!isN($_id_us)){

			if($_est == 'in'){
				$PrcDt = $__Cl->UsGrp_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->UsGrp_Del();	
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
	}
	
?>