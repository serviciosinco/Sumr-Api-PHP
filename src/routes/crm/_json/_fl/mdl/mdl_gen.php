<?php 
	
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_tp2 = Php_Ls_Cln($_POST['t2']);
		$_tp3 = Php_Ls_Cln($_POST['tp']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_mdlgen = Php_Ls_Cln($_POST['_id_mdlgen']);
		$_mdlgen_dt = GtMdlGenDt([ 'id'=>$_id_mdlgen, 't'=>'enc' ]);
		
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
		$_id_tp = Php_Ls_Cln($_POST['_id_tp']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		$__Cl->mdlgen_id = $_mdlgen_dt->id;
		
		
		$__mdl = GtMdlDt([ 'id'=>$_id_mdl, 't'=>'enc' ]);
		if(!isN($__mdl->id)){ $__Cl->mdl_id = $__mdl->id; }
		
			
		if(!isN($_id_mdl)&&!isN($_id_mdlgen)&&($_dt == 'mdl_r')){
			
			
			if($_est == 'in'){
				$PrcDt = $__Cl->MdlGenMdl_In();	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->MdlGenMdl_Del();	
			}
			
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_id_mdlgen)&&($_dt == 'mdl_gen_mdlfm')){
			
			$__Cl->mdlfm_id = Php_Ls_Cln($_POST['_id_mdlfm']);
			
			if($_est == 'in'){
				$PrcDt = $__Cl->MdlGenFm_In();	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->MdlGenFm_Del();	
			}
			
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}	
					
		}elseif(!isN($_id_mdl)&&($_dt == 'mdlgen_mdl')){
			
			$__Cl->mdl_id = $_id_mdl;
			
			if($_est == 'in'){
				$PrcDt = $__Cl->MdlGenRel_In();	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->MdlGenRel_Del();	
			}
			
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}	
					
		}elseif(!isN($_id_tp)&&($_dt == 'mdlgen_tp')){

			$__Cl->tp_id = Php_Ls_Cln($_POST['_id_tp']);
			
			if($_est == 'in'){
				$PrcDt = $__Cl->MdlGenTp_In();	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->MdlGenTp_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}	
					
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		if($_dt == 'mdlgen_mdl'){
			$rsp['cl']['mdlgen']['mdl_tp'] = $__Cl->MdlGenRel_Ls([ 't'=>$_tp3, 'dt' => $_mdlgen_dt ]);
		}elseif($_dt == 'mdlgen_tp'){
			$rsp['cl']['mdlgen']['mdl_tp'] = $__Cl->MdlGenTp_Ls([ 't'=>$_tp3 ]);
		}else{
			$rsp['cl']['mdlgen']['mdl'] = $__Cl->ClMdl_Ls([ 't'=>$_tp2 ]);
			$rsp['cl']['mdlgen']['mdlfm'] = $__Cl->ClMdlFmGen_Ls([ 't'=>$_tp2 ]);
		}
				
		//$rsp['cl']['mdlgen']['fm'] = $__Cl->GtClFmLs([ 't'=>$_tp2 ]);
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>