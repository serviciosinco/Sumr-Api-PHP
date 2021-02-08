<?php 
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdlcnt']);
		$_id_cntc = Php_Ls_Cln($_POST['_id_h_cntc']);

		$__mdl = new CRM_Mdl(); 
		$__mdl->post = $_POST; 
		$__mdl->db = $_tp;

		$__dtmdl = GtMdlCntDt([ 't'=>'enc', 'id'=>$_id_mdl, 'shw'=>[ 'cnt'=>'ok' ] ]);

		if($_dt == 'h_cntc' && !isN($_id_cntc)){
			
			$__mdl->mdlcntc_cnt = $__dtmdl->cnt->id;
			$__mdl->mdlcntc_cntc = $_id_cntc;
			$__mdl->mdlcntc_est = Blnm($_est);
			$PrcDt = $__mdl->MdlCntHCntc();
			
			$rsp['prc'] = $PrcDt;
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

		$rsp['cl']['mdlcnt']['h_cntc'] = $__mdl->MdlCntHCntc_Ls([ 'mdl'=>$__dtmdl->cnt->id ]);
		
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>