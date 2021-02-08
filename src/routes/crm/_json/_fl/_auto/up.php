<?php 
	
	$__up = Php_Ls_Cln($_POST['up']);
	$__lmt = Php_Ls_Cln($_POST['lmt']);
	
	
	if(is_array($__up)){ 
		
		$__max_up = 0;
		
		foreach($__up as $__up_k=>$__up_v){	
			
			if($__up_v['t'] == _CId('ID_UPEST_LD')){ $__t2='bd'; }else{ $__t2=$__tp2; }
			
			if($__max_up < 2){
					
				if($__up_v['t'] == _CId('ID_UPEST_LD') || $__up_v['t'] == _CId('ID_UPEST_PRC')){
					if(ChckSESS_superadm()){
						//$rsp['auto_up'][$__up_k] = __AutoRUN(['t'=>$__tp, 't2'=>$__t2, 'lmt'=>(!isN($__lmt)?$__lmt:20), 'id'=>$__up_v['id']/*, 'o_rtrn'=>'no'*/ ]); 
					}
				}
				
				$__max_up++;
			
			}
			
		}
	}
		
		
	
	
	$rsp['e'] = 'ok';
	
	
	
	if(!isN($__up) && count($__up) > 0){
		
		$_up_bd=1;
		$_up_auto=1;
		
		
		foreach($__up as $__up_k=>$__up_v){ 
			
			
			$__iup = $__up_v['id'];
			$__ibd = '';
			
			$__dt_up = GtUpDt([ 'id'=>$__iup, 't'=>'enc' ]);
			$__tp2 = $__dt_up->tp;
			
			if($__dt_up->est == _CId('ID_UPEST_LD')){ 
			
				if($_up_bd==1){
					$__ibd = $__dt_up->enc;
					$__tp2 = 'bd';
				}
			
			}
				
				
			$__all_sved = $__dt_up->tot->o + $__dt_up->tot->w;
			$__all_rest = $__dt_up->tot->l - $__dt_up->tot->p;
			
			if($__all_sved == $__all_rest){
				$__prcnt = ($__all_sved*100)/$__dt_up->tot->l;	
			} 
						
			$rsp['ls'][$__iup]['id'] = $__up_v['id'];
			$rsp['ls'][$__iup]['f'] = $__up_v['f'];
			$rsp['ls'][$__iup]['p']['n'] = $__prcnt;
			$rsp['ls'][$__iup]['p']['j'] = _Nmb($__prcnt, 1);
			$rsp['ls'][$__iup]['d'] = $__dt_up->tot;
			$rsp['ls'][$__iup]['up']['d'] = $__dt_up;	
			
			
			if($__dt_up->est == 353){ 
				
				$_clr = '';
				$__myprc = _Nmb($__prcnt,5);
				
			}elseif(!isN($__dt_up->row) && !isN($__dt_up->lrow)){

				$__myprc = (($__dt_up->lrow*100)/$__dt_up->row);
				$__myprc = _Nmb($__myprc,5);
				
				if($__dt_up->est == _CId('ID_UPEST_LD')){ $_clr = '6d7071'; }	
				
			}
			
			$___js_avnc = _Kn_Prcn([ 'id'=>$__up_v['id'], 'l'=>'ok', 'v'=>$__myprc, 'w'=>'27', /*'di'=>'ok',*/ 'clr'=>$_clr ]); 
			
			$rsp['ls'][$__iup]['up']['b']['est'] = $__dt_up->est;	
			$rsp['ls'][$__iup]['up']['b']['p'] = _Nmb($__myprc, 1);	
			$rsp['ls'][$__iup]['up']['b']['html'] = $___js_avnc->html;
			$rsp['ls'][$__iup]['up']['b']['js'] = $___js_avnc->js;
			
			$_up_bd++;
			
			if($__dt_up->est == _CId('ID_UPEST_PRC') && $_up_auto < 4){

				if(ChckSESS_superadm()){
					$rsp['ls'][$__iup]['up']['url'] = __AutoRUN(['t'=>$__tp, '__i'=>$__ibd, 't2'=>$__tp2, 'lmt'=>20, 'id'=>$__dt_up->enc, 'o_rtrn'=>'no']);
					$_up_auto++;
					//$rsp['tmp'] = $_up_auto;
				}
			}
		
		}
	
	}
	
?>