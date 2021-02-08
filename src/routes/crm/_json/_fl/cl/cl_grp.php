<?php 
	
	
	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_id_us = Php_Ls_Cln($_POST['_id_us']);
		$_id_grp = Php_Ls_Cln($_POST['_id_grp']);
		$_id_prm = Php_Ls_Cln($_POST['_id_prm']);
		$_id_est = Php_Ls_Cln($_POST['_id_est']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		$__Cl->us_id = $_id_us;
		$__Cl->grp_id = $_id_grp;
		$__Cl->prm_id = $_id_prm;
		$__Cl->est_id = $_id_est;
		
		
			
		if(!isN($_id_us)){

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
			
		}elseif(!isN($_id_prm)){

			if($_est == 'in'){
				$PrcDt = $__Cl->GrpPrm_In(); 	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->GrpPrm_Del();	
			}
			
			$rsp['e'] = $PrcDt;

			/*if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}*/
			
		}elseif(!isN($_id_est)){
			
			if($_est == 'in'){
				$PrcDt = $__Cl->GrpEst_In(); 	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->GrpEst_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'new_prm'){
			
			$__Cl->mdlstpprm_nm = Php_Ls_Cln($_POST['mdlstpprm_nm']);
			$__Cl->mdlstpprm_tp = Php_Ls_Cln($_POST['mdlstpprm_tp']);
			$__Cl->mdlstpprm_mdlstp = Php_Ls_Cln($_POST['mdlstpprm_mdlstp']);
			$__Cl->mdlstpprm_vl = Php_Ls_Cln($_POST['mdlstpprm_vl']);
			$PrcDt = $__Cl->MdlSTpPrm_In(); 	
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'new_est'){
			
			$__Cl->cntest_tt = Php_Ls_Cln($_POST['siscntest_tt']);
			$__Cl->cntest_tp = Php_Ls_Cln($_POST['siscntest_tp']);
			$__Cl->cntest_clr_bck = Php_Ls_Cln($_POST['siscntest_clr_bck']);
			$PrcDt = $__Cl->ClCntEst_In(); 	
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['cl']['grp']['us'] = $__Cl->ClGrpUs_Ls();
		$rsp['cl']['grp']['prm'] = $__Cl->ClGrpPrm_Ls();
		$rsp['cl']['grp']['est'] = $__Cl->ClGrpEst_Ls();
		$rsp['cl']['grp']['tra'] = $__Cl->ClGrpTra_Ls();
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>