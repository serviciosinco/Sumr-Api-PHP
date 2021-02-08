<?php 
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL & ~E_NOTICE /*&& ~E_WARNING*/);
			
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_id = Php_Ls_Cln($_POST['_id']);
		
		$_id_cl = Php_Ls_Cln($_POST['_id_cl']);
		$_id_mdlstp = Php_Ls_Cln($_POST['_id_mdlstp']);
		$_mdlstp_dt = GtMdlSTpDt(['enc'=>$_id_mdlstp]);
		
		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		$__Cl->mdlstp_id = $_mdlstp_dt->id;
	
			
		if(!isN($_mdlstp_dt->id)){
			
			
			if( !isN($_POST['mdlstpattr_attr']) ){
				
				$__Cl->mdlstpattr_attr = Php_Ls_Cln($_POST['mdlstpattr_attr']);
				
				if($_est == 'in'){
					$PrcDt = $__Cl->MdlSTpAttr_In();		
				}elseif($_est == 'del'){
					$PrcDt = $__Cl->MdlSTpAttr_Del();	
				}
				
				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;
				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				}
				
			}elseif(!isN($_POST['mdlstpprm_tp'])){
				
				$__Cl->mdlstpprm_tp = Php_Ls_Cln($_POST['mdlstpprm_tp']);	
				$__Cl->mdlstpprm_nm = Php_Ls_Cln($_POST['mdlstpprm_nm']);
				$__Cl->mdlstpprm_mdlstp = $_mdlstp_dt->id;
				$__Cl->mdlstpprm_vl = Php_Ls_Cln($_POST['mdlstpprm_vl']);
				
				if($_est == 'in'){
					$PrcDt = $__Cl->MdlSTpPrm_In(); 	
				}elseif($_est == 'del'){
					//$PrcDt = $__Cl->MdlSTpPrm_Del();	
				}
	
				
				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;
				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				}
				
			}elseif(!isN($_id_cl)){
				
				$__cl = GtClDt($_id_cl, 'enc');
				
				$__Cl->mdlstpcl_mdlstp = $_mdlstp_dt->id;	
				$__Cl->mdlstpcl_cl = $__cl->id;
				
				if($_est == 'in'){
					$PrcDt = $__Cl->MdlSTpCl_In();
				}elseif($_est == 'del'){
					$PrcDt = $__Cl->MdlSTpCl_Del();	
				}
	
				
				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;

				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				}
				
			}elseif( $_dt == 'ctg' && !isN($_id)){
				
				$__Cl->id_ctg = $_id;
				
				if($_est == 'in'){
					$PrcDt = $__Cl->MdlSTpCtg_In();	
				}else{
					$PrcDt = $__Cl->MdlSTpCtg_Eli();		
				}
				
				$rsp['rsp'] = $PrcDt;
				
				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;	
				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				}
				
			}


		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['cl']['mdlstp']['prm'] = $__Cl->ClGrpPrm_Ls();
		$rsp['cl']['mdlstp']['attr'] = $__Cl->MdlSTpAttr_Ls();	
		$rsp['cl']['mdlstp']['cl'] = $__Cl->Cl_Ls([ 'on'=>1 ]);
		$rsp['cl']['mdlstp']['ctg'] = $__Cl->MdlSTpCtg();
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
	}
	
?>