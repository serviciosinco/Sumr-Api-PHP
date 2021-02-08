<?php 

	try{
				
		
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_sclacc = Php_Ls_Cln($_POST['_id_sclacc']);
		
		
		if($_tp == '_acc_cnv_post'){

		}else if($_dt == 'us_scl_acc'){
			
			$_id = Php_Ls_Cln($_POST['_id']);
			
			if($_est == 'in'){
				$PrcDt = GtSclAccUs_In(['id'=>$_id,'id_sclacc'=>$_id_sclacc]);		
			}else{
				$PrcDt = GtSclAccUs_Eli(['id'=>$_id,'id_sclacc'=>$_id_sclacc]);	
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}		
			
		}else if($_dt == 'grp_scl_acc'){

			$_id = Php_Ls_Cln($_POST['_id']);
			if($_est == 'in'){
				$PrcDt = GtSclAccGrp_In(['id'=>$_id,'id_sclacc'=>$_id_sclacc]);		
			}else{
				$PrcDt = GtSclAccGrp_Eli(['id'=>$_id,'id_sclacc'=>$_id_sclacc]);	
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}		
		}else if($_dt == 'sch_form'){

			$_tt = Php_Ls_Cln($_POST['_tt']); 
			
			$rsp['sclacc']['form'] = GtSclAccFormLs([ 'sclacc'=>$_id_sclacc, 'tp' => 'enc', 'tt' => $_tt ]);
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}		
		}
		
 
		
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; } 

		if(isN($_dt) || $_dt != 'sch_form')  {
			$rsp['sclacc'] = GtSclAccDt([ 'enc'=>$_id_sclacc, 'form'=>'ok' ]);
		}
		
		
		

		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
?>