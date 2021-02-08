<?php 
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdlcnt']);
		$_id_sch = Php_Ls_Cln($_POST['_id_sch']);
		$_mdl = Php_Ls_Cln($_POST['_mdlcnt_mdl']);
		
		
		$__mdl = new CRM_Mdl(); 
		$__mdl->post = $_POST; 
		$__mdl->db = $_tp;
		
		$__mdl->mdlsch_mdl = $_id_mdl;	
		$__mdl->mdlsch_mdlsch = $_mdl;
		
		$__dtprd = GtMdlSSchDt([ 'id'=>$_id_sch, 't'=>'enc' ]);
		$__dtmdl = GtMdlCntDt([ 't'=>'enc', 'id'=>$_id_mdl ]);
			
		if($_dt == 'sch' && !isN($__dtprd->id)){
			
			$__mdl->mdlsch_mdl = $__dtmdl->id;
			$__mdl->mdlsch_sch = $__dtprd->id;
			$__mdl->mdlsch_est = Blnm($_est);
			
			$PrcDt = $__mdl->MdlCntSch();
			
			$rsp['prc'] = $PrcDt;
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'new_sch'){
			
			$__mdl->mdlssch_nm = Php_Ls_Cln($_POST['mdlssch_nm']);
			
			$PrcDt = $__mdl->MdlSSch(); 
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['cl']['mdlcnt']['sch'] = $__mdl->MdlCntSch_Ls([ 'mdl'=>$__dtmdl->id ]);
		
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>