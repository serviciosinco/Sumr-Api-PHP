<?php 
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		
		$_est = Php_Ls_Cln($_POST['est']);	
		$_id_mdl = Php_Ls_Cln($_POST['_id_mdl']);
		$_id_chck = Php_Ls_Cln($_POST['_id_chck']);
				
		$__mdl = new CRM_Mdl(); 
		$__mdl->post = $_POST; 
		$__mdl->db = $_tp;
		
		$__dtmdl = GtMdlCntDt([ 't'=>'enc', 'id'=>$_id_mdl ]);
			
		if($_dt == 'chck' && !isN($__dtmdl->id)){
			
			$__mdl->mdlchck_mdlcnt = $__dtmdl->id;
			$__mdl->mdlchck_chck = $_id_chck;
			$__mdl->mdlchck_est = Blnm($_est);
			
			$PrcDt = $__mdl->MdlCntChck();
			
			/*if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}*/
			
		}else if($_dt == 'chck_asis'){	
			$__mdl->mdlchck_chck = $_id_chck;
			$__est = SisCntEst(['asis'=>'ok']);

			if(!isN($__est->id)){
				$__mdl->mdlchck_est = $__est->id;
				$PrcDt = $__mdl->MdlCntEst_Upd();
			}			
		}
		
		
		if($_dt == 'chck_asis'){
			$rsp['est'] = $PrcDt;					
		}else{
			if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
			$rsp['cl']['mdl'] = $PrcDt;	
		}
		
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>