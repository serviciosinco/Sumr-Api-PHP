<?php 
	
	
	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_id_us = Php_Ls_Cln($_POST['_id_us']);
		$_id_grp = Php_Ls_Cln($_POST['_id_grp']);
        

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
        $__Cl->us_id = $_id_us;
        
		if(!isN($_id_us) && !isN($_id_grp)){

            $__Cl->grp_id = $_id_grp;

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
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['us']['grp'] = $__Cl->UsClGrp_Ls();
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>