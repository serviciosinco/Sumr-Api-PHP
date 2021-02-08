<?php 
	try{
        
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
	
        $_id_auto = Php_Ls_Cln($_POST['_id_auto']);
        $_id_cl = Php_Ls_Cln($_POST['_id_cl']);
        $_est = Php_Ls_Cln($_POST['est']);

		$__cl = new CRM_Cl(); 

        $__cl->id_cl = $_id_cl;
        $__cl->id_auto = $_id_auto;
        $__cl->est = $_est;

        
		
		if($_dt == 'auto' && !isN($__cl->id_cl)){

            $PrcDt = $__cl->AutoCl();
  
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
        }
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

        $rsp['auto']['cl'] = $__cl->AutoCl_Ls();

	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}	
?>