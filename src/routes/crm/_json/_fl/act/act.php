<?php 
	
	try{
		
        $_tp = Php_Ls_Cln($_POST['t']);
        $_dt = Php_Ls_Cln($_POST['d']);
        $_t2 = Php_Ls_Cln($_POST['t2']);

        $__mdl = new CRM_Mdl(); 
        
        if($_dt == 'act_clnd'){
            
            $__mdl->tp = $_t2;
            $PrcDt = $__mdl->ActClnd_Ls();
            
			if($PrcDt->e == 'ok'){	
                $rsp['e'] = $PrcDt->e;
                $rsp['data'] = $PrcDt->ls;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
        
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>