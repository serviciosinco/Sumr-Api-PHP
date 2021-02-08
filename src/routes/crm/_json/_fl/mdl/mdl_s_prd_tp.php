<?php
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_mdlprd = Php_Ls_Cln($_POST['_id_mdlprd']);
		
		
		$__mdl = new CRM_Mdl(); 
		$__mdl->post = $_POST; 
		$__mdl->db = $_tp;
		
		$__dtprd = GtMdlSPrdDt([ 'id'=>$_id_mdlprd, 't'=>'enc' ]);
		$__mdl->mdl_prd = $__dtprd->id; 
		$rsp['cl']['p'] = $__dtprd;

		if($_dt == 'mdl_s_prdtp' && !isN($__dtprd->id)){
			
			$_id_mdltp = Php_Ls_Cln($_POST['_id_prdtp']);
			$__dttp = GtMdlSTpDt([ 'enc'=>$_id_mdltp ]);
			$__mdl->mdl_tp = $__dttp->id;
			
			$PrcDt = $__mdl->MdlSPrdTp();
			
			$rsp['eddd'] = $PrcDt;	

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt;	
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

		$rsp['cl']['prdtp'] = $__mdl->MdlSPrdTp_Ls();
			
			
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['es'] = $PrcDt->qry;
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	
	} 
?>