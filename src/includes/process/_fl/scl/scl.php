<?php 
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['_tp']);
		$_scl = Php_Ls_Cln($_POST['_scl']);
		$_authRsp = _jEnc( Php_Ls_Cln($_POST['authResponse']) );
		$_accid = Php_Ls_Cln($_POST['_accid']);
		$_accopt = Php_Ls_Cln($_POST['_accopt']);
		$_cnvid = Php_Ls_Cln($_POST['_cnvid']);
		$_cnvest = _jEnc(Php_Ls_Cln($_POST['_cnvest']));
		$_rply_msg = Php_Ls_Cln($_POST['_rply_msg']);
		
		if($_tp != ''){ 
			$__SclBd = new CRM_Thrd(); 
		}
		
		if($_tp == '_new_lgin'){
							
			if($_authRsp != NULL){
				$__SclBd->__t = 'scl';
				$__SclBd->cl = DB_CL_ENC;
				$__SclBd->us = SISUS_ID;
				$__SclBd->scl_attr = [
					'auth'=>$_authRsp,
				];
				$__SclBd->scl = $_scl;			
				$__Prc = $__SclBd->In();
			}
			if(ChckSESS_superadm()){ $rsp['prc'] = $__Prc; }
			if($__Prc->e == 'ok'){
				$rsp['e'] = 'ok';
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$__Prc->w : "");
			}			
			
		}elseif($_tp == '_acc_upd'){
			
			$_accdt = GtSclAccDt(['enc'=>$_accid]);

			if(!isN($_accdt->enc)){
				
				if($_accopt == 'ok'){ $est = 1; }else{ $est = 2; }
				$__SclBd->t = 'est';
				$__SclBd->sclacc_est = $est;
				$__SclBd->sclacc_enc = $_accdt->enc;
				$__SclBd->sclacc_data = $_accdt;	
				$__Prc = $__SclBd->Upd_Acc_Fld();
				$rsp['Prc'] = $__Prc;

			}else{

				$rsp['w'] = 'No $_accdt info';
			
			}
			
			if($__Prc->e == 'ok'){
				$rsp['e'] = 'ok';
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$__Prc->w : "");
			}
		
		}elseif($_tp == '_acc_cnv_msg_snd'){
			
			$_cnvdt = GtSclAccCnvDt([ 'enc'=>$_cnvid ]);
			
			if(!isN($_cnvdt->enc)){
				
				foreach($_cnvdt->acc_scl as $ka=>$va){
					$__SclBd->t = 'est';
					$__SclBd->rplycnv_id = $_cnvdt->cnv_id;
					$__SclBd->rplycnv_tkn = $va->tlvd;
					$__SclBd->rplycnv_msg = $_rply_msg;		
					
					$__Prc = $__SclBd->_Rply();
					
					if($__Prc->e == 'ok'){ 
						break;
					}

				}
				
				//__AutoRUN(array('t'=>'sis_third', 's'=>'scl', 's2'=>'fb_acc_cnv', 'cnv'=>$_cnvid, 'lmt'=>1 ));
				
				$_cnvdt = GtSclAccCnvDt(['enc'=>$_cnvid]);
				
				if($__Prc->e == 'ok'){
					$rsp['e'] = 'ok';
					$rsp['api'] = $__Prc;
				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$__Prc->w : "");
				}
				
				$rsp['cnv'] = GtSclAccCnvDt(['enc'=>$_cnvid]);
			}
			
			if($__Prc->e == 'ok'){
				$rsp['e'] = 'ok';
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$__Prc->w : "");
			}
		
		}elseif($_tp == '_acc_cnv_est'){
			
			$_cnvdt = GtSclAccCnvDt(['enc'=>$_cnvid]);
			
			if($_cnvdt->enc != NULL){
				
				$__cnvest_mve = __LsDt(['f_vl'=>$_cnvest->move, 'attr'=>'cls', 'k'=>'scl_cnv_est']);
				
				if($__cnvest_mve->d->id != NULL){
					$__est = $__cnvest_mve->d->id;
					$__Prc = $__SclBd->UpdF(['t'=>'cnv', 'f'=>'sclacccnv_est', 'id'=>$_cnvdt->id, 'v'=>$__est]);
				}
				
				if($__Prc->e == 'ok'){
					$rsp['e'] = 'ok';
					$rsp['cnv_r'] = $_cnvid; // Conversacion a borrar
				
					$__cnvest = __LsDt(['f_vl'=>$_cnvest->set, 'attr'=>'cls', 'k'=>'scl_cnv_est']);
					if($__cnvest->d->id != NULL){
						$__set_est = $__cnvest->d->id;				
						$rsp['cnv'] = GtSclAccCnvLs(['scl_acc'=>$_cnvdt->acc->id, 'est'=>$__set_est, 'lmt'=>20]);
					}
					
				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$__Prc->w : "");
				}

			}
			
			if($__Prc->e == 'ok'){
				$rsp['e'] = 'ok';
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$__Prc->w : "");
			}
		
		}else{
			throw new Exception((ChckSESS_superadm()) ? "- No existe post ".$_POST['_tp'] : "");
		}
		
		if($__Prc != '' && $__Prc->r != NULL){ $rsp['r'] = $__Prc->r; }
		if($__Prc != '' && $__Prc->e == 'ok'){ $rsp['scl'] = GtSclLs([ 'us'=>SISUS_ID, 'cl'=>DB_CL_ENC ]); }
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = "No se pudo procesar ".$e->getMessage();
		
	}
?>