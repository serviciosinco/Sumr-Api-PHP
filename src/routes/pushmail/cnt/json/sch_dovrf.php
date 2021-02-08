<?php
	
	//---------------- SETUP - START ----------------//
		
		$__p_sch = Php_Ls_Cln($_POST['sch']); 
		$__p_cl = Php_Ls_Cln($_POST['cl']); 
		$__p_cnt_tp_grp = Php_Ls_Cln($_POST['data-cnt-tp-grp']);
		$__p_cnt_bd = Php_Ls_Cln($_POST['data-cnt-bd']);
	
	//---------------- Detail Data ----------------//
		
		if(!isN($__p_cnt_bd)){
			$__gsisbd_dt = GtSisBdDt([ 't'=>'enc', 'id'=>$__p_cnt_bd ]);
		}
		
	//---------------- SETUP - END ----------------//
		
		
		if(!isN($__p_sch)){
			
			$__cl = __Cl([ 'id'=>$__p_cl, 't'=>'enc' ]);
			$__cnt = new CRM_Cnt([ 'cl'=>$__cl->id ]);
			$__cnt->cnt_dc = filter_var($__p_sch, FILTER_SANITIZE_STRING);
			$__gcnt = $__cnt->_Cnt();
				
			if(isN($__gcnt->i)){ 
				$__cnt->cnt_eml = filter_var($__p_sch, FILTER_SANITIZE_EMAIL);
				$__gcnt = $__cnt->_Cnt();
			}
			
			if(!isN($__gcnt->i)){
				
				$__gcnt_dt = GtCntDt([ 'bd'=>$__cl->bd.'.', 'id'=>$__gcnt->enc, 't'=>'enc' ]);
				
				if(!isN($__gsisbd_dt)){
					
					$__gsisbd_chk = GtCntBdChk([ 'bd'=>$__cl->bd.'.', 'sisbd'=>$__gsisbd_dt->id, 'cnt'=>$__gcnt_dt->id ]);
					
					if($__gsisbd_chk->e == 'ok' && $__gsisbd_chk->tot < 1){
						$__gcnt_dt = '';	
					}
					
				}
				
				
				if(!isN($__gcnt_dt->id)){
					
					$rsp['e'] = 'ok';
					
					if(!isN($__gcnt_dt->tel)){
						
						foreach($__gcnt_dt->tel_all->ls as $_k_tel => $_v_tel){	
							
			        		$img_th = _ImVrs([ 'img'=>$_v_tel->img_ps, 'f'=>DMN_FLE_PS ]);
			        		
				        	$rsp['tel'][] = [
					        	'flag'=>$img_th->th_50,
					        	'enc'=>$_v_tel->enc,
					        	'no'=>__tel_scre([ 'v'=>$_v_tel->tel ])
				        	];
				        	
				        	$rsp['tot']++;
				        }
				        
					}
							
					if(!isN($__gcnt_dt->eml)){
						
						foreach($__gcnt_dt->eml as $_eml_k=>$_eml_v){
							
							if($_eml_v->rjct!='ok'){ 
								
								$rsp['eml'][] = [
						        	'enc'=>$_eml_v->eml->enc,
						        	'eml'=>__eml_scre([ 'v'=>$_eml_v->v ])
					        	];
					        	
					        	$rsp['tot']++;
					        	
							}
							
						}	
						
					}	
					
					
					if(isN($rsp['tel']) && isN($rsp['eml'])){
						
						$rsp['e'] = 'no_tel_eml';	
						
						$rsp['cnt'] = [
							'enc'=>$__gcnt_dt->enc,
							'nm'=>$__gcnt_dt->nm,
							'ap'=>$__gcnt_dt->ap,
							'sndi'=>$__gcnt_dt->sndi
						];
					
					}
					
				
				}else{
					
					$rsp['e'] = 'no_exist';
					
				}
				
			}
			
		}else{
			
			$rsp['e'] = 'no_data';	
			
		}
	
	
	//---------------- PRINT RESULTS ----------------//

		
?>