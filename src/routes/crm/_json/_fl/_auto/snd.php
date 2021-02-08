<?php 
	
	$_ec_snd = new API_CRM_ec();
	
	$__cmpg = Php_Ls_Cln($_POST['cmpg']);
	
	
	
	foreach($__cmpg as $__cmpg_k=>$__cmpg_v){ //----------- ALL CAMPAIGNS RECEIVED -----------//
		
		
		$__icmpg = $__cmpg_v['id'];
		
		
		//----------- CHECK TYPE OF CAMPAIGN / GET DETAIL -----------//
		
		
			if($__tp == 'snd_sms_cmpg'){
				$__dt_cmpg = GtSmsCmpgDt([ 'id'=>$__cmpg_v['id'] ]);
			}elseif($__tp == 'snd_ec_cmpg'){
				$__dt_cmpg = GtEcCmpgDt([ 'id'=>$__cmpg_v['id'], 't'=>'enc', 'q_tot'=>'ok', 'q_btch'=>'ok', 'lsts'=>['e'=>'ok'] ]);
			}
			
		
		//----------- GET LEADS ALLOW / NOT IN QUEUE YET -----------//
		
		
			$__all_sved = $__dt_cmpg->btch->snd + $__dt_cmpg->btch->w;
			$__all_rest = $__dt_cmpg->btch->l - $__dt_cmpg->btch->p;
			
			
			if($__dt_cmpg->est->id == _CId('ID_ECCMPGEST_SNDIN')){	
				$_kn_clr = '14c251';
			}else{
				$_kn_clr = '4FAAD3';
			}
		
		
		//----------- IF IS EMAIL CAMPAIGN -----------//
		
		
		if($__tp == 'snd_ec_cmpg'){
			
			
			//----------- CHECK DATA ONLINE FOR ROWS AND TABLE -----------//


				$rsp['ls'][$__icmpg]['online']['snd'] = _Nmb($__dt_cmpg->_tot_snd, 3);
				
				$rsp['ls'][$__icmpg]['online']['ldd'] = _Nmb($__dt_cmpg->btch->l, 3);
				if(!isN($__dt_cmpg->btch->l)){ $rsp['ls'][$__icmpg]['online']['ldd_p'] = _Nmb( ($__dt_cmpg->btch->l*100)/$__dt_cmpg->eml_allw , 5); }
				
				$rsp['ls'][$__icmpg]['online']['op'] = _Nmb($__dt_cmpg->_tot_op, 3);
				if(!isN($__dt_cmpg->_tot_op)){ $rsp['ls'][$__icmpg]['online']['op_p'] = _Nmb( ($__dt_cmpg->_tot_op*100)/$__dt_cmpg->_tot_snd , 5); }
				
				$rsp['ls'][$__icmpg]['online']['clc'] = _Nmb($__dt_cmpg->_tot_trck, 3);
				if(!isN($__dt_cmpg->_tot_trck)){ $rsp['ls'][$__icmpg]['online']['clc_p'] = _Nmb( ($__dt_cmpg->_tot_trck*100)/$__dt_cmpg->_tot_snd, 5); }
				
				$rsp['ls'][$__icmpg]['online']['bnc'] = _Nmb($__dt_cmpg->_tot_err, 3);
				if(!isN($__dt_cmpg->_tot_err)){ $rsp['ls'][$__icmpg]['online']['bnc_p'] = _Nmb( ($__dt_cmpg->_tot_err*100)/$__dt_cmpg->_tot_snd, 5); }
					
				$rsp['ls'][$__icmpg]['online']['sndin'] = _Nmb($__dt_cmpg->btch->p, 3);
			
			
			//----------- CHECK SENDED OR QUEUE TO CHANGE CAMPAIGN STATUS -----------//
			
				if(!isN($__dt_cmpg->id)){
					
					if($__dt_cmpg->btch->snd == $__dt_cmpg->tot->lds){ 								
						if($__dt_cmpg->opn != 'ok' && $__dt_cmpg->allw == 'ok'){ 
							//$_Upd_r = $_ec_snd->_EcCmpg_UPD([ 'id'=>$__dt_cmpg->id, 'est'=>_CId('ID_ECCMPGEST_SND') ]);
						}		
					}elseif($__dt_cmpg->btch->in == $__dt_cmpg->tot->lds){	
						//$_Upd_r = $_ec_snd->_EcCmpg_UPD([ 'id'=>$__dt_cmpg->id, 'est'=>_CId('ID_ECCMPGEST_SNDIN') ]);			
					}							
					
					$rsp['ls'][$__icmpg]['p']['updr'] = $_Upd_r;
				}
			
			//----------- CALCULATE THE PERCENT TO KNOB INDICATOR -----------//
										
			
			if($__dt_cmpg->btch->l == $__dt_cmpg->eml_allw){
				
				if($__all_sved == $__all_rest){
					$__prcnt = ($__all_sved*100)/$__dt_cmpg->btch->l;	
				} 
				
				$rsp['ls'][$__icmpg]['p']['fclr'] = '#'.$_kn_clr;
				$rsp['ls'][$__icmpg]['p']['iclr'] = '#'.$_kn_clr;
				
			}else{
				
				if($__dt_cmpg->est->id == _CId('ID_ECCMPGEST_SNDIN')){
					$__prcnt = ($__dt_cmpg->btch->snd * 100) / $__dt_cmpg->btch->in;	
				}else{
					$__prcnt = ($__dt_cmpg->btch->l * 100) / $__dt_cmpg->eml_allw;
				}
				
				if(!isN($__prcnt)){
					$rsp['ls'][$__icmpg]['p']['fclr'] = '#636363';
					$rsp['ls'][$__icmpg]['p']['iclr'] = '#636363';
				}
			}
		
		}else{	
			
			$__prcnt = ($__all_sved*100)/$__dt_cmpg->btch->l;
			
		}
	
		
		$rsp['e'] = 'ok';
		
		$___js_avnc = _Kn_Prcn([ 'id'=>$__cmpg_v['id'], 'l'=>'ok', 'v'=>_Nmb($__prcnt,5), 'w'=>'35', 'clr'=>$_kn_clr ]); 
		
		$rsp['ls'][$__icmpg]['id'] = $__cmpg_v['id'];
		$rsp['ls'][$__icmpg]['f'] = $__cmpg_v['f'];
		$rsp['ls'][$__icmpg]['n']['html'] = $___js_avnc->html;
		$rsp['ls'][$__icmpg]['n']['js'] = $___js_avnc->js;
		$rsp['ls'][$__icmpg]['n']['est']['id'] = $__dt_cmpg->est->id;
		$rsp['ls'][$__icmpg]['n']['est']['nm'] = $__dt_cmpg->est->nm;
		$rsp['ls'][$__icmpg]['n']['est']['clr'] = $__dt_cmpg->est->clr;
			
		
		if(!isN($__prcnt)){
			$rsp['ls'][$__icmpg]['p']['n'] = $__prcnt;
			$rsp['ls'][$__icmpg]['p']['j'] = _Nmb($__prcnt, 1);
			$rsp['ls'][$__icmpg]['p']['k'] = _Nmb($__prcnt, 9);
		}
		
		if(!isN($__dt_cmpg->btch)){ $rsp['ls'][$__icmpg]['batch'] = $__dt_cmpg->btch; }
		if(!isN($__dt_cmpg->up)){ $rsp['ls'][$__icmpg]['up'] = $__dt_cmpg->up; }
		if(!isN($__dt_cmpg->opn)){ $rsp['ls'][$__icmpg]['opn'] = $__dt_cmpg->opn; }
	
	
	}
	
?>