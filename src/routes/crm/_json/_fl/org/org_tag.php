<?php 
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$__id_org = Php_Ls_Cln($_POST['_org_enc']);
		
		$_Org_Tp = new CRM_Org(); 
        $_Org_Tp->id_org = $__id_org;
        
		if($_dt == 'tag'){

            $__id_tag = Php_Ls_Cln($_POST['_id_tag']);

            $_Org_Tp->id_tag = $__id_tag;
			
			if($_est == 'ok'){
				$PrcDt = $_Org_Tp->GtOrgTagLs_In();
			}else if($_est == 'del'){
				$PrcDt = $_Org_Tp->GtOrgTagLs_Del();
			}
		}
	
		if($PrcDt->e == 'ok'){	
			$rsp['e'] = $PrcDt->e;
		}else{
            $rsp['er'] = $PrcDt;    
        }

		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['org']['tag'] = $_Org_Tp->GtOrgTagLs();

    }catch(Exception $e){
        $rsp['e'] = 'no';
        $rsp['w'] = TX_NSPPCSR .$e->getMessage();
    }
	
?>