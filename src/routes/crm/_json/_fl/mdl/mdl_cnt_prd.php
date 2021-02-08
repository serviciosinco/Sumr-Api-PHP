<?php 
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdlcnt']);
		$_id_prd = Php_Ls_Cln($_POST['_id_prd']);
		$_id_tp = Php_Ls_Cln($_POST['_tp']);
		
		$__mdl = new CRM_Mdl(); 
		$__mdl->post = $_POST; 
		$__mdl->db = $_tp;
		
		$__mdl->mdlprd_mdl = $_id_mdl;

		$__dtprd = GtMdlSPrdDt([ 'id'=>$_id_prd, 't'=>'enc' ]);
		$__dtmdl = GtMdlCntDt([ 't'=>'enc', 'id'=>$_id_mdl ]);

		if($_dt == 'prd' && !isN($__dtprd->id)){
			
			$__mdl->mdlprd_mdl = $__dtmdl->id;
			$__mdl->mdlprd_prd = $__dtprd->id;
			$__mdl->mdlprd_est = Blnm($_est);
			$PrcDt = $__mdl->MdlCntPrd();
			
			$rsp['prc'] = $PrcDt;
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'new_prd'){
			
			$__mdl->mdlsprd_nm = Php_Ls_Cln($_POST['mdlsprd_nm']);
			$__mdl->mdlsprd_y = Php_Ls_Cln($_POST['mdlsprd_y']);
			$__mdl->mdlsprd_s = Php_Ls_Cln($_POST['mdlsprd_s']);
			
			$PrcDt = $__mdl->MdlSPrd(); 
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['cl']['mdlcnt']['prd'] = $__mdl->MdlCntPrd_Ls([ 'mdl'=>$__dtmdl->id, 'tp' => $_id_tp ]);
		
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>