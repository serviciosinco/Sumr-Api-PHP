<?php
	
	//---------------- SETUP - START ----------------//
		
		$rsp['e'] = 'no';
		$__p = _jEnc(Php_Ls_Cln($_POST['p']));
		$__p_cl = Php_Ls_Cln($_POST['cl']); 
		$__p_cnt = Php_Ls_Cln($_POST['cnt']);  
		$__p_cref = Php_Ls_Cln($_POST['cref']);  
		
		
	//---------------- SETUP - END ----------------//
		
		
		
		if(!isN($__p_cnt)){
			
			$__cl = __Cl([ 'id'=>$__p_cl, 't'=>'enc' ]);
			$__CntIn = new CRM_Cnt([ 'cl'=>$__cl->id ]);
			
			if(!isN($__p_cref)){
				$__CntIn->cnt_cref = $__p_cref;
			}
			
			if($__p->in->tp == 'sis-list'){
				
				if($__p->id == 'sx'){ $_ls_k='sx'; }
				
				$_lsdt = __LsDt([ 'k'=>$_ls_k, 'id'=>$__p->vl, 'tp'=>'enc' ]);				
				$____vl = $_lsdt->d->id;
				$rsp['tt'] = $_lsdt->d->tt;	
				
			}else{
				
				$____vl = $__p->vl;
				
			}
			
			
			if(!isN($____vl)){	
				
				$__CntIn->cnt_id = $__p_cnt;
				
				if($__p->in->tp == 'city'){
					
					if($__p->rel == 'nco'){ $____cty_rel = _CId('ID_TPRLCC_NCO'); }
					elseif($__p->rel == 'vve'){ $____cty_rel = _CId('ID_TPRLCC_VVE'); }	
					
					$__CntIn->cnt_cd_all = [ 
						[ 'id'=>$____vl, 'rel'=>$____cty_rel ]										
					];
					
					$_dt = GtCdDt([ 'id'=>$__p->vl ]);
					$rsp['tt'] = $_dt->tt;
					$rsp['img'] = $_dt->ps->img->url->th_50;
					
				}else{	
					
					$__CntIn->{$__p->tp.'_'.$__p->id} = $____vl;
						
				}
				
				$__prc = $__CntIn->_Cnt();	
				
				//$rsp['tmp_cd_all'] = $__prc->in->cd_all_rel;
				
			}
			
			if($__p->in->tp == 'sis-list'){
					
				if($__prc->upd->cnt->{$__p->id}->e == 'ok'){
					$rsp['e'] = 'ok';
				}
			
			}else{
				
				if($__prc->e == 'ok'){
					$rsp['e'] = 'ok';
				}
			}
			
		}else{
			
			$rsp['e'] = 'no_data';	
			
		}
	
	
	//-------------- PRINT RESULTS --------------//

		
?>