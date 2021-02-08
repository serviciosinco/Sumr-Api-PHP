<?php 
	
	
	try{
		
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_org_enc = Php_Ls_Cln($_POST['_org_enc']);
		$_orgzna_enc = Php_Ls_Cln($_POST['_orgzna_enc']);
		$_orggrp_enc = Php_Ls_Cln($_POST['_orggrp_enc']);
		$id_orggrp = Php_Ls_Cln($_POST['id_orggrp']);
		$id_orgzna = Php_Ls_Cln($_POST['id_orgzna']);
		$orgzna_clr = Php_Ls_Cln($_POST['orgzna_clr']);
		

		$__Cls_Org = new CRM_Org(); 
		$__Cls_Org->org_enc = $_org_enc;
		$__Cls_Org->orgzna_enc = $_orgzna_enc;
		$__Cls_Org->orggrp_enc = $_orggrp_enc;
		$__Cls_Org->id_orggrp = $id_orggrp;
		$__Cls_Org->id_orgzna = $id_orgzna;
		$__Cls_Org->orgzna_clr =$orgzna_clr;
	
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
			
		}elseif($_dt == "grp"){
			
			if($_est == "in"){
				$PrcDt = $__Cls_Org->_Grp_In();
			}else if($_est == "del"){
				$PrcDt = $__Cls_Org->_Grp_Eli();
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		
		} 
		
		if($_dt == "new_grp"){
			
			$PrcDt = $__Cls_Org->InsGrp();
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}

		}elseif($_dt == "new_zna" ){
		
			$PrcDt = $__Cls_Org->InsZna();		
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		
		}	
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		//$rsp['org']['zna'] = $__Cls_Org->GtOrgSdsZnaLs();
		$rsp['org']['grp'] = $__Cls_Org->GtOrgGrpLs();
		
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>