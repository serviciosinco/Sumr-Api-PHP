<?php
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
		$_id_sch = Php_Ls_Cln($_POST['_id_sch']);
		$_mdl_enc = Php_Ls_Cln($_POST['_mdl_enc']);
		
		$__mdl = new CRM_Mdl(); 
		$__mdl->post = $_POST; 
		$__mdl->db = $_tp;
		
		$__mdl->mdlsch_mdl = $_id_mdl;	
		
		$__dtsch = GtMdlSSchDt([ 'id'=>$_id_sch, 't'=>'enc' ]);
		$__dtmdl = GtMdlDt([ 't'=>'enc', 'id'=>$_mdl_enc ]);
	
		if($_dt == 'sch' && !isN($__dtsch->id)){
			
			$__mdl->mdlsch_mdl = $__dtmdl->id;
			$__mdl->mdlsch_sch = $__dtsch->id;
			$__mdl->mdlsch_est = Blnm($_est);
			$PrcDt = $__mdl->MdlSch();

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;	
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

		$rsp['cl']['mdls']['sch'] = $__mdl->MdlSSch_Ls(['mdl'=>$__dtmdl->id]);
			
			
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['es'] = $PrcDt->qry;
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	
	} 
?>