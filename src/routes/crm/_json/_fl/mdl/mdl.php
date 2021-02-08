<?php 
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
		$_id_prd = Php_Ls_Cln($_POST['_id_prd']);
		
		$__mdl = new CRM_Mdl(); 
		$__mdl->post = $_POST; 
		$__mdl->db = $_tp;
		
		$__mdl->mdlprd_mdl = $_id_mdl;	
		
		$__dtprd = GtMdlSPrdDt([ 'id'=>$_id_prd, 't'=>'enc' ]);
		$__dtmdl = GtMdlDt([ 't'=>'enc', 'id'=>$_id_mdl ]);
			
		if($_dt == 'prd' && !isN($__dtprd->id)){
			
			$__mdl->mdlprd_mdl = $__dtmdl->id;
			$__mdl->mdlprd_prd = $__dtprd->id;
			$__mdl->mdlprd_est = Blnm($_est);
			$PrcDt = $__mdl->MdlPrd();
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'new_prd'){
			
			
			
			$__mdl->mdlsprd_nm = Php_Ls_Cln($_POST['mdlsprd_nm']);
			$__mdl->mdlsprd_y = Php_Ls_Cln($_POST['mdlsprd_y']);
			$__mdl->mdlsprd_s = Php_Ls_Cln($_POST['mdlsprd_s']);
			$__mdl->mdlsprd_tp = Php_Ls_Cln($_POST['mdlsprd_tp']);
	
				
			$PrcDt = $__mdl->MdlSPrd(); 
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'are'){
			
			$__mdl->est = Php_Ls_Cln($_POST['est']);
			$__mdl->id_are = Php_Ls_Cln($_POST['_id_are']);
			$__mdl->id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
			
			$PrcDt = $__mdl->MdlSAre(); 

			
			if($PrcDt->e == 'ok'){	
				
				$rsp['e'] = $PrcDt->e;

			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'us'){
			
			$__mdl->est = Php_Ls_Cln($_POST['est']);
			$__mdl->id_us = Php_Ls_Cln($_POST['_id_us']);
			$__mdl->id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
			
			$PrcDt = $__mdl->MdlSUs();
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}elseif(!isN($_dt) && $_dt == 'fm'){
			
			$__mdl->est = Php_Ls_Cln($_POST['est']);
			$__mdl->id_mdlfm = Php_Ls_Cln($_POST['_id_mdlfm']);
			$__mdl->id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
			
			$PrcDt = $__mdl->MdlSFm();
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
				$rsp['qry'] = $PrcDt;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				$rsp['qry'] = $PrcDt;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		if(isN(Php_Ls_Cln($_POST['t2']))){
			$rsp['cl']['mdls']['prd'] = $__mdl->MdlSPrd_Ls([ 'mdl'=>$__dtmdl->id ]);
			$rsp['cl']['mdls']['are'] = $__mdl->MdlSAre_Ls([ 'mdl'=>$__dtmdl->id ]);
			$rsp['cl']['mdls']['us'] = $__mdl->MdlUs_Ls([ 'mdl'=>$__dtmdl->id ]);		
		}else{
			$rsp['cl']['mdls']['fm'] = $__mdl->MdlFm_Ls([ 'mdl'=>$__dtmdl->id ]);	
		}
		
								 
		
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>