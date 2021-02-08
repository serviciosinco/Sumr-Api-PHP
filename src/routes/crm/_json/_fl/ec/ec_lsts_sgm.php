<?php
	
	
	 
	try{

		$__Rnd_Var = Gn_Rnd(20);

		$_tp = Php_Ls_Cln($_POST['tp']);
		$_sgm = Php_Ls_Cln($_POST['sgm']);
		$_var = Php_Ls_Cln($_POST['var']);
		$_t_sub = Php_Ls_Cln($_POST['t_sub']);
		$_lsts = Php_Ls_Cln($_POST['lsts']);
		
		$_sis_sgm = Php_Ls_Cln($_POST['sis_sgm']);
		$_sis_var = Php_Ls_Cln($_POST['sis_var']);
		
		
		$_vle = Php_Ls_Cln($_POST['vle']);

		$__Snd = new API_CRM_Snd(); 
		
		if($_tp == 'var_in'){
			
			$__dt = $__Snd->SisSgmVarTp_Dt([ 'sgm'=>$_sgm, 'var'=>$_var, 'sis_sgm'=>$_sis_sgm, 'sis_var'=>$_sis_var, 'vle'=>$_vle ]);
			
			
			if($_t_sub == "snd_ec_lsts_var"){
				$__Snd->eclstsvar_lsts = $_lsts;
				$__Snd->eclstsvar_var = $__dt->sis_var->id;
				$__Snd->eclstsvar_vl = 0;
				$PrcDt = $__Snd->LstsVar_In();
			}else{
				$__Snd->eclstssgmvar_sgm = $__dt->sgm->id;
				$__Snd->eclstssgmvar_var = $__dt->sis_var->id;
				$__Snd->eclstssgmvar_vl = 0;
				$PrcDt = $__Snd->SgmVar_In();
			}	

			if($PrcDt->e == 'ok'){	
				
				$rsp['e'] = $PrcDt->e;
				$___sis_var_enc = $PrcDt->enc;
				
				$__opt_vle = __GtSisEcSgmVarTp_Slc([ 
								'id'=>Gn_Rnd(30), 
								'tp'=>$__dt->sis_var->tp, 
								'sgm-enc'=>$_sgm, 
								'var-enc'=>$___sis_var_enc, 
								'sis-var-enc'=>$_sis_var,
								't_sub'=>$_t_sub,
								'lsts'=>( (!isN($_lsts))? $_lsts : NULL )
							]);
					
					
				$rsp['html'] = li(
								'<div class="f_opt _anm"><button class="rmv _anm" var-enc="'.$___sis_var_enc.'" sis-sgm-enc="'.$__dt->sis_sgm->enc.'">x</button></div>'.
								'<div class="f_var _anm">'.$__dt->sis_var->nm.'</div>'.
								'<div class="f_var_vl _anm" id="f_var_vl_'.$___sis_var_enc.'">'.$__opt_vle->html.'</div>'.
								'<div class="f_var_vl_sub f_var_vl_sub_'.$___sis_var_enc.' _anm" id="f_var_vl_sub'.$___sis_var_enc.'"></div>'
							, 'off _item_var', '', 'li_sgm_var_'.$___sis_var_enc);
				
				$rsp['js'] .= $__opt_vle->js;
				$rsp['js'] .= "$('#li_sgm_".$_sis_sgm."').removeClass('off').addClass('on'); LstsSgmVarDsh_Dom();";

					
			}else{
				$rsp['prc'] = $PrcDt;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
						
		}elseif($_tp == 'var_upd' || $_tp == 'var_upd_sub'){
			
			if( $_tp == 'var_upd_sub' ){
				
				if($_t_sub == "snd_ec_lsts_var"){
					$__Snd->id_eclstsvar = Php_Ls_Cln($_POST['id_eclstssgmvar']);
					$__Snd->eclstsvar_vl_sub = Php_Ls_Cln($_POST['eclstssgmvar_vl_sub']);
				}else{
					$__Snd->id_eclstssgmvar = Php_Ls_Cln($_POST['id_eclstssgmvar']);
					$__Snd->eclstssgmvar_vl_sub = Php_Ls_Cln($_POST['eclstssgmvar_vl_sub']);
				}
				
			}else{
				
				$__dt = $__Snd->SisSgmVarTp_Dt([ 'sgm'=>$_sgm, 'var'=>$_var, 'sis_var'=>$_sis_var, 'vle'=>$_vle, 'pipe'=>'ok' ]);
				
				if($_t_sub == "snd_ec_lsts_var"){
					
					$__Snd->eclstsvar_lsts = $_lsts;
					$__Snd->eclstsvar_var = $__dt->sis_var->id;
					$__Snd->eclstsvar_vl = $__dt->vle;
					$__Snd->eclstsvar_enc = $_var;
					
				}else{
					$__Snd->id_eclstssgmvar = $__dt->var->id;
					$__Snd->eclstssgmvar_vl = $__dt->vle;
				}
				
			}
			
			$PrcDt = $__Snd->SgmVar();

			if($PrcDt->e == 'ok'){	
				
				$rsp['e'] = $PrcDt->e;
				
				/* Llama el select de valor de atributos */
				if( $_tp != 'var_upd_sub' ){
					
					$l = LsDmc([
					    		'attr'=>$_vle,
					    		'id'=>'cntapplattr_vl_'.$_var,
					    		'va'=>'',
					    		'tp'=>'ls',
					    		'ph'=>'Seleccione',
					    		'attr_tp'=>'cnt_attr'
				    		]);
						
					$_var_vl_sub = ( ($l->e == "ok")? $l->html : HTML_inp_tx('cntapplattr_vl_'.$_sgm_var_v->enc, TX_VLR, ctjTx($_sgm_var_v->vle_sub,'in'), '') );
					
					
					$rsp['html'] = $_var_vl_sub;
					if($l->e == "ok"){
						$rsp['js'] = $l->js;
					}else{
						$rsp['js'] = NULL;
					}
					
				}
				
			}else{
				$rsp['prc'] = $PrcDt;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
						
		}elseif($_tp == 'var_del'){
			
			
			
			
			if($_t_sub == "snd_ec_lsts_var"){
				//$__dt = $__Snd->SisSgmVarTp_Dt([ 'var'=>$_var, 'eclstsvar'=>'ok' ]);
				$__Snd->eclstsvar_enc = $_var;
				$PrcDt = $__Snd->EcLstsVar_Del();	
			}else{
				$__dt = $__Snd->SisSgmVarTp_Dt([ 'var'=>$_var ]);
				$__Snd->eclstssgmvar_enc = $__dt->var->enc;
				$PrcDt = $__Snd->SgmVar_Del();	
			}
			
			
				

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['prc'] = $PrcDt;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
						
		}
		
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>