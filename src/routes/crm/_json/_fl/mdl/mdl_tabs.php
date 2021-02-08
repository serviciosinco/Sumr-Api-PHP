<?php 	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_mdl = Php_Ls_Cln($_POST['_mdl_enc']);
		$_id = Php_Ls_Cln($_POST['_id']);
		
		$__mdl = new CRM_Mdl(); 
		$__mdl->post = $_POST; 
		$__mdl->db = $_tp;
		
		$__mdl->mdlmdl_mdl = $_id;	
		$__mdl->mdlmdl_main = $_id_mdl;	
 
		$__dtmdl = GtMdlDt([ 't'=>'enc', 'id'=>$_id_mdl ]);
		$__dtmdl_id = GtMdlDt([ 't'=>'enc', 'id'=>$_id ]);
			
		if($_dt == 'mdl_mdl'){
			
			$__mdl->mdlmdl_mdl = $__dtmdl_id->id;
			$__mdl->mdlmdl_main = $__dtmdl->id;
			$__mdl->mdlmdl_est = Blnm($_est);
			
			$PrcDt = $__mdl->MdlMdl();
	
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		$rsp['mdl_tabs']['mdl'] = $__mdl->MdlMdl_Ls([ 'mdl'=>$__dtmdl->id ]);
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

			
	
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>