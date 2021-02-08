<?php 
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_org_enc = Php_Ls_Cln($_POST['_org_enc']); // enc de organizaciones
		
		$_orgenf_enc = Php_Ls_Cln($_POST['_orgenf_enc']); // enc de los relacionales enfasis
		$_orglng_enc = Php_Ls_Cln($_POST['_orglng_enc']); // enc de los relacionales idiomas
		$_orgbch_enc = Php_Ls_Cln($_POST['_orgbch_enc']); // enc de los relacionales bachiller
		$_orgexa_enc = Php_Ls_Cln($_POST['_orgexa_enc']); // enc de los relacionales examenes
		
		$__Cls_Org = new CRM_Org(); 
		$__Cls_Org->org_enc = $_org_enc;
		$__Cls_Org->orgenf_enc = $_orgenf_enc;
		$__Cls_Org->orglng_enc = $_orglng_enc;
		$__Cls_Org->orgbch_enc = $_orgbch_enc;
		$__Cls_Org->orgexa_enc = $_orgexa_enc;
			
	
		if($_dt == "enf"){
			
			if($_est == "in"){
				$PrcDt = $__Cls_Org->_Enf_In();
			}else if($_est == "del"){
				$PrcDt = $__Cls_Org->_Enf_Eli();
			}
			
		}elseif($_dt == "lng"){
			
			if($_est == "in"){ 
				$PrcDt = $__Cls_Org->_Lng_In();
			}else if($_est == "del"){
				$PrcDt = $__Cls_Org->_Lng_Eli();
			}
			
		}elseif($_dt == "bch"){
			
			if($_est == "in"){ 
				$PrcDt = $__Cls_Org->_Bch_In();
			}else if($_est == "del"){
				$PrcDt = $__Cls_Org->_Bch_Eli();
			}
			
		}elseif($_dt == "exa"){
			
			if($_est == "in"){ 
				$PrcDt = $__Cls_Org->_Exa_In();
			}else if($_est == "del"){
				$PrcDt = $__Cls_Org->_Exa_Eli();
			}
			
		}
			
	
		if($PrcDt->e == 'ok'){	
			$rsp['e'] = $PrcDt->e;
		}
		
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['org']['enf'] = $__Cls_Org->GtOrgEnfLs();
		$rsp['org']['lng'] = $__Cls_Org->GtOrgLngLs();
		$rsp['org']['bch'] = $__Cls_Org->GtOrgBchLs();
		$rsp['org']['exa'] = $__Cls_Org->GtOrgExaLs();
			
			
		}catch(Exception $e){
			$rsp['e'] = 'no';
			$rsp['w'] = TX_NSPPCSR .$e->getMessage();
		}
	
?>