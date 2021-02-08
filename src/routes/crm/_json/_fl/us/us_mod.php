<?php
	try{ 

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_id_us = Php_Ls_Cln($_POST['_id_us']);

		$__Cl = new CRM_Cl();
		
	
		if(!isN($_dt) && $_dt == 'us_est'){	
            
			$__dt_us = GtUsDt($_id_us, 'enc');

			$__Cl->id_us = $__dt_us->id;

			if($__dt_us->est == 'ok'){
				$__Cl->us_est = 3;
			}elseif($__dt_us->est == 'no'){ 
				$__Cl->us_est = 1;
			}	

			$PrcDt = $__Cl->UsEst_Upd();

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
				$rsp['us'] = GtUsDt($_id_us, 'enc');
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
        }
        

	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>