<?php 
	
	
	try{
		

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);

		$_id_are = Php_Ls_Cln($_POST['_id_are']);
		$_id_grp = Php_Ls_Cln($_POST['_id_grp']);
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdl']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		
		$__Cl->grp_id = $_id_grp;
		$__Cl->are_id = $_id_are;
		$__Cl->mdl_id = $_id_mdl;
		
			
		if($_dt == 'are' && ($_est == 'in' || $_est == 'del')){

			if($_est == 'in'){
				$PrcDt = $__Cl->ClGrpAre_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->ClGrpAre_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif($_dt == 'mdl' && ($_est == 'in' || $_est == 'del')){

			if($_est == 'in'){
				$PrcDt = $__Cl->ClGrpMdl_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->ClGrpMdl_Del();	
			}
			
			$rsp['eS'] = $PrcDt->e;
			$rsp['eD'] = $PrcDt->e;
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
				$rsp['qry'] = $PrcDt->qry;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif($_dt == 'plcy' && ($_est == 'in' || $_est == 'del')){

			$__Cl->cl_grp = Php_Ls_Cln($_POST['_id_grp']);
			$__Cl->cl_plcy = Php_Ls_Cln($_POST['_id_plcy']);

			if($_est == 'in'){
				$PrcDt = $__Cl->ClGrpPlcy_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->ClGrpPlcy_Del();	
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['er'] = $PrcDt;
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
		
		$rsp['cl']['grp']['are'] = $__Cl->ClGrpAre_Ls();
		//($rsp['cl']['grp']['mdl'] = $__Cl->ClGrpMdl_Ls();
		$rsp['cl']['grp']['plcy'] = $__Cl->ClGrpPlcy_Ls();
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>