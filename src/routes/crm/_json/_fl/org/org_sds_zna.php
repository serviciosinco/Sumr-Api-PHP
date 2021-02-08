<?php 
	
	
	try{
		
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_org_enc = Php_Ls_Cln($_POST['_org_enc']);
		$_orgzna_enc = Php_Ls_Cln($_POST['_orgzna_enc']);
		$id_orgzna = Php_Ls_Cln($_POST['id_orgzna']);
		$orgzna_clr = Php_Ls_Cln($_POST['orgzna_clr']);
		

		$__Cls_Org = new CRM_Org(); 
		$__Cls_Org->orgsds_enc = $_org_enc;
		$__Cls_Org->orgsdszna_enc = $_orgzna_enc;
		$__Cls_Org->id_orgsdszna = $id_orgzna;
		$__Cls_Org->orgsdszna_clr =$orgzna_clr;
	
		if($_dt == "zna"){
			
			if($_est == "in"){
				$PrcDt = $__Cls_Org->_Zna_In();
			}else if($_est == "del"){
				$PrcDt = $__Cls_Org->_Zna_Eli();
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if($_dt == "new_zna" ){
		
			$PrcDt = $__Cls_Org->InsZna();		
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		
		}	
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['org']['zna'] = $__Cls_Org->GtOrgSdsZnaLs();
		
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>