<?php 
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
	
        $_id_mdl = Php_Ls_Cln($_POST['_id_mdl_gen']);
		$_id_grd = Php_Ls_Cln($_POST['_id_grd']);

		$__mdl = new CRM_Mdl(); 

        $__mdl->mdls_mdl = $_id_mdl;
		$__mdl->mdls_grd = $_id_grd;
		
		if($_dt == 'mdl_gen' && !isN($__mdl->mdls_grd)){

            $PrcDt = $__mdl->ActGenGrd(); 
            
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

		$rsp['mdl_gen']['grd'] = $__mdl->ActGenGrd_Ls();

	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}	
?>