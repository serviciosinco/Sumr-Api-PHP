<?php
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL);
			
			
	//---------------- SETUP - START ----------------//
		
		$__p_snd_tp = Php_Ls_Cln($_POST['snd_tp']);
		$__p_snd_vl = Php_Ls_Cln($_POST['snd_vl']); 
		$__p_cl = Php_Ls_Cln($_POST['cl']); 
		
	//---------------- SETUP - END ----------------//
		
		
		if(!isN($__p_snd_tp) && !isN($__p_snd_vl)){
			
			$__cl = __Cl([ 'id'=>$__p_cl, 't'=>'enc' ]);
			
			if(!isN( $__cl )){
				
				$__dvrf = new CRM_Dvrf([ 'cl'=>$__cl->id ]);
				
				if(!isN($__p_snd_tp) && $__p_snd_tp == 'tel'){
					
					$__tel_dt = GtCntTelDt(['id'=>$__p_snd_vl, 't'=>'enc', 'bd'=>$__cl->bd ]);
					if($__tel_dt->tot > 0){ 
						$sndd = 'ok'; 
						$__dvrf->cntdvrf_cnt = $__tel_dt->cnt->id;
						$__dvrf->cntdvrf_tel = 1;
					}
					
				}elseif(!isN($__p_snd_tp) && $__p_snd_tp == 'eml'){
	
					$__eml_dt = GtCntEmlDt(['id'=>$__p_snd_vl, 'tp'=>'enc', 'bd'=>$__cl->bd, 'd'=>['plcy'=>'ok'] ]);
					
					if($__eml_dt->tot > 0){ 
						$sndd = 'ok';
						$__dvrf->cntdvrf_cnt = $__eml_dt->cnt->id;
						$__dvrf->cntdvrf_eml = 1;
					}
					
				}	
				
				
				if($sndd == 'ok'){ 
					
					$__dvrf->cntdvrf_tp = 'upd';
					$__rnc = $__dvrf->NewCod(); 
					
					if(!isN($__rnc->cod)){
						
						if($__p_snd_tp == 'tel'){
							
							
							//$rsp['tmp_tel'] = $__tel_dt->tel;
							
							$__sms = new API_CRM_sms([ 'cl'=>$__cl->id ]);
							$__sms->snd_cel = $__tel_dt->tel;
							$__sms->snd_sms = _CId('SMS_CNTDVRF');
							$__sms->snd_nm = 'SUMR';
							$__sms->snd_c = $__tel_dt->ps->cod;
							$__sms->snd_cnt = $__dvrf->cntdvrf_cnt;
							$__sms->snd_us = SUMR_IDUS;							
							$__sms->snd_tel_dvrf = $__rnc->id;
							$__sms->snd_prty = 1;
							$__snd = $__sms->_SndSMS([ 't'=>'dvrf', 'auto'=>'ok' ]);
							
							//$rsp['tmp_snd'] = $__snd;
						
							if($__snd->e == 'ok'){
								$rsp['e'] = 'ok';
								$__snd->u_o;
							}else{
								$rsp['e'] = 'no';
							}
						
						}elseif($__p_snd_tp == 'eml'){
						
							$__ec = new API_CRM_ec([ 'cl'=>$__cl->id ]);
							$__ec->snd_f = SIS_F;
							$__ec->snd_h = SIS_H2;
							$__ec->snd_ec = _CId('EC_CNTDVRF');
							$__ec->snd_eml = $__eml_dt->eml;
							$__ec->snd_cnt = $__dvrf->cntdvrf_cnt;
							$__ec->snd_us = SUMR_IDUS;							
							$__ec->snd_eml_dvrf = $__rnc->id;
							$__ec->snd_prty = 1;
							$__snd = $__ec->_SndEc([ 't'=>'dvrf', 'auto'=>'ok' ]);	
							
							//$rsp['tmp_snd'] = $__snd;
							
							if($__snd->e == 'ok'){
								$rsp['e'] = 'ok';
								$__snd->u_o;
							}else{
								$rsp['e'] = 'no';
							}
							
						}
						
					}
				}
			
			}
			
		}else{
			
			$rsp['e'] = 'no_data';	
			
		}
	
	
	//-------------- PRINT RESULTS --------------//

		
?>