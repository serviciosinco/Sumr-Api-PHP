<?php 
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$__id_org = Php_Ls_Cln($_POST['_id_org']); // enc de organizaciones
		$_org_tp = Php_Ls_Cln($_POST['_org_tp']);
		
		$_Org_Tp = new CRM_Org(); 
		$_Org_Tp->id_org = $__id_org;
		$_Org_Tp->org_tp = $_org_tp;
			
	
		if($_dt == "tp"){
			
			if($_est == "in"){
				$PrcDt = $_Org_Tp->GtOrgTpLs_In();
			}else if($_est == "del"){
				$PrcDt = $_Org_Tp->GtOrgTpLs_Del();
			}
			
		}
	
		if($PrcDt->e == 'ok'){	
			$rsp['e'] = $PrcDt->e;
		}

		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['org']['tp'] = $_Org_Tp->GtOrgTpLs();

		}catch(Exception $e){
			$rsp['e'] = 'no';
			$rsp['w'] = TX_NSPPCSR .$e->getMessage();
		}
	
?>