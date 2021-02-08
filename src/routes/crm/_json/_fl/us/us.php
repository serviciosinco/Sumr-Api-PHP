<?php
	try{ 

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_id_us = Php_Ls_Cln($_POST['_id_cl']);
		$_id_grp = Php_Ls_Cln($_POST['_id_us']);
		
		$_id_prm = Php_Ls_Cln($_POST['_id_prm']);
		$_id_est = Php_Ls_Cln($_POST['_id_est']);
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdl']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		$__Cl->us_id = $_id_us;
		$__Cl->grp_id = $_id_grp;
		$__Cl->prm_id = $_id_prm;
		$__Cl->est_id = $_id_est;
		$__Cl->mdl_id = $_id_mdl;
	
		if(!isN($_id_us)){			
			
			if($_est == 'in'){
				$PrcDt = $__Cl->UsCl_In();	
	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->UsCl_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
				$rsp['us']['cl'] = $__Cl->UsCl_Ls();
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_id_prm)){

			if($_est == 'in'){
				$PrcDt = $__Cl->UsPrm_In(); 	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->UsPrm_Del();	
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
				$rsp['us']['prm'] = $__Cl->UsMdl_Ls();
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
				$rsp['us']['prm'] = $__Cl->UsMdl_Ls();
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'new_est'){
			
			/*$__Cl->cntest_tt = Php_Ls_Cln($_POST['siscntest_tt']);
			$__Cl->cntest_tp = Php_Ls_Cln($_POST['siscntest_tp']);
			$__Cl->cntest_clr_bck = Php_Ls_Cln($_POST['siscntest_clr_bck']);
			$PrcDt = $__Cl->ClCntEst_In(); 	
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}*/
			
		}elseif(!isN($_dt) && $_dt == 'are'){

			$__Cl->__are = Php_Ls_Cln($_POST['id_clare']);
			$__Cl->__us = Php_Ls_Cln($_POST['id_us']);
			$__Cl->grp_id = Php_Ls_Cln($_POST['id_us']);
			
			if($_est == 'in'){
				$PrcDt = $__Cl->UsAre_In(); 	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->UsAre_Del();	
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
				$rsp['us']['are'] = $__Cl->UsAre_Ls();
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'mdl'){

			$__Cl->__us = Php_Ls_Cln($_POST['_id_us']);
			$__Cl->__mdl  = Php_Ls_Cln($_POST['id_mdl']);

			if($_est == 'in'){
				$PrcDt = $__Cl->UsMdls_In(); 	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->UsMdls_Del();
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
				$rsp['us']['mdl'] = $__Cl->UsMdls_Ls();
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'plcy'){

			$__Cl->__us = Php_Ls_Cln($_POST['_id_us']);
			$__Cl->__plcy  = Php_Ls_Cln($_POST['_id_plcy']);

			if($_est == 'in'){
				$PrcDt = $__Cl->UsPlcy_In(); 	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->UsPlcy_Del();	
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
				$rsp['us']['plcy'] = $__Cl->UsPlcy_Ls();
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'ntf'){
 
			$__Cl->us_ntf = $_est;
			$PrcDt = $__Cl->UsNtf(); 	
			
			//$rsp['tmp_prc'] = $PrcDt;

			if($PrcDt->e == 'ok'){	 
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				$rsp['w2'] = $PrcDt;
			}
		}
			
		if(isN($_dt)){
			
			$rsp['us']['prm'] = $__Cl->UsMdl_Ls();
			$rsp['us']['cl'] = $__Cl->UsCl_Ls();
			$rsp['us']['are'] = $__Cl->UsAre_Ls();
			$rsp['us']['mdl'] = $__Cl->UsMdls_Ls();
			$rsp['us']['plcy'] = $__Cl->UsPlcy_Ls();
		} 

	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>