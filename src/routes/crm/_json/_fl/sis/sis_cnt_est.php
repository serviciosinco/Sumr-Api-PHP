<?php 

	
	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_id_mdlstp = Php_Ls_Cln($_POST['_id_mdlstp']);
		$_id_est = Php_Ls_Cln($_POST['_id_est']);
		$__e = Php_Ls_Cln($_POST['_e']);
		

		$__sis = new CRM_Cl(); 
		$__sis->post = $_POST; 
		$__sis->db = $_tp;
			
			
		if($_dt == 'est' && !isN($_id_mdlstp) && !isN($_id_est)){
			
			$__mdlstpdt = GtMdlSTpDt([ 'enc'=>$_id_mdlstp ]);			
			
			$__sis->mdlstpest_mdlstp = $__mdlstpdt->id;
			$__sis->mdlstpest_cntest = $_id_est;
			$__sis->mdlstpest_est = Blnm($__e);
			$PrcDt = $__sis->MdlSTpEst();	

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif($_dt == 'dfl' && !isN($_id_mdlstp) && !isN($_id_est)){
			
			$__mdlstpdt = GtMdlSTpDt([ 'enc'=>$_id_mdlstp ]);			
			
			$__sis->mdlstpest_mdlstp = $__mdlstpdt->id;
			$__sis->mdlstpest_cntest = $_id_est;
			$__sis->mdlstpest_dfl = Blnm($__e);
			$PrcDt = $__sis->MdlSTpEst();	
			$rsp['prc'] = $PrcDt;
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>