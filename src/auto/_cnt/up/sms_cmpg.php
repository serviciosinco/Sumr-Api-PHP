<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'up_sms_cmpg' ]);

if( $_g_alw->est == 'ok' ){

	$__prfx_tt = 'SMS - ';

	if(class_exists('CRM_Cnx')){
		
		
		//--------- AUTO TIME CHECK - START ---------//

		$_AUTOP_d = $this->RquDt([ 't'=>'up_sms_cmpg', 'm'=>5 ]); 
		
		
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){
		
			$this->Rqu([ 't'=>'up_sms_cmpg' ]);
			
			$this->_up->tp = 'up_sms_cmpg';
										
			if($this->g__i != ''){ 
				$__smscmpg_up_id = $this->g__i; 
				$__smscmpg_nou = $this->_up->_UpLstNo_U(['id'=>$__smscmpg_up_id, 't'=>'enc', 'tp'=>'sms_cmpg_up']);
			}else{
				$__smscmpg_nou = $this->_up->_UpLstNo_U(['tp'=>'sms_cmpg_up', 'f'=>' AND up_est != '._CId('ID_UPEST_ELI').' ']);
				$__smscmpg_up_id = $__smscmpg_nou->id;
			}
			
			
			if(!isN($this->g__lmt)){ $_qry_lmt = $this->g__lmt; }else{ $_qry_lmt = '100'; }
			
			if($__smscmpg_nou->r_tot > 0 && $__smscmpg_up_id != ''){
			
				$UpSmsCmpg_Qry = "SELECT *,
									(	SELECT CONCAT('{  \"id\":\"', id_smscmpgup,'\", 
														\"cmpg\":\"', smscmpgup_cmpg,'\", 
														\"us\":\"', smscmpg_us,'\",
														\"f\":\"', smscmpg_p_f,'\",
														\"h\":\"', smscmpg_p_h,'\"
														} ') 
										FROM ".DB_PRFX_CL."hotelopera.".TB_TB_SMS_CMPG_UP.", ".DB_PRFX_CL."hotelopera.".TB_TB_SMS_CMPG." 
										WHERE smscmpgup_cmpg = id_smscmpg AND smscmpgup_up = id_up
									) AS ___id_smscmpg
							FROM up_col, up 
							WHERE upcol_up = id_up AND 
									up_fld != '' AND 
									(upcol_est != 352 AND upcol_est != 353 ) AND  
									upcol_rd = 2 AND
									up_rd = 2 AND 
									(up_tp = 'sms_cmpg_up') AND 
									upcol_up = '".$__smscmpg_up_id."' $__f 
							ORDER BY upcol_up DESC LIMIT {$_qry_lmt} "; 
							//echo $UpSmsCmpg_Qry;
										
				$UpSmsCmpg_Rg = $__cnx->_qry($UpSmsCmpg_Qry); 
				
				$row_UpSmsCmpg_Rg = $UpSmsCmpg_Rg->fetch_assoc(); 
				$Tot_UpSmsCmpg_Rg = $UpSmsCmpg_Rg->num_rows;
						
				echo $this->h1($__prfx_tt.'Carga de Archivos SMS CMPG '.$this->Spn($Tot_UpSmsCmpg_Rg). ' - cargados '.$row_UpSmsCmpg_Rg['__tot_up']. ' - rows total '.$row_UpSmsCmpg_Rg['__tot'] ); 
				
			}elseif($__smscmpg_up_id != ''){
		
				echo $this->h1($__prfx_tt.$__smscmpg_nou->id.' no tiene registros creados en la tabla ' ); 
				
			}else{
				
				echo $this->h1($__prfx_tt.' No hay bases para cargar'); 
				
			}
			
			$this->_up->_InUp_Rd(['id'=>$__smscmpg_up_id, 'e'=>'on' ]);
			
		
			if($__smscmpg_nou->id != NULL && $__smscmpg_nou->r_tot > 0 && $__smscmpg_nou->r_tot_up == $__smscmpg_nou->r_tot){ 
				$this->_up->_InUp_Est([ 'id'=>$__smscmpg_up_id, 'e'=>352 ]); 
				echo 'Actualiza registro '.$__smscmpg_up_id.' a 1';
			}else{
				$__tot_t_up = $__smscmpg_nou->r_tot_w + $__smscmpg_nou->r_tot_up;
				if($Tot_UpSmsCmpg_Rg > 0 && $__tot_t_up == $__smscmpg_nou->r_tot && $__smscmpg_up_id != ''){ 
				echo 'Actualiza registro '.$__smscmpg_up_id.' a 5';	
				}
				
			}
		
			if($Tot_UpSmsCmpg_Rg > 0){
		
					do{
						
						$this->id_upcol = $row_UpSmsCmpg_Rg['id_upcol'];		
						$___chk = $this->UpCol_Chk();
						
						
						if($___chk->e == 'ok' && $___chk->rd != 'ok'){
							
							
								$__rd_p = $this->_up->_InUpRow_Rd(['id'=>$row_UpSmsCmpg_Rg['id_upcol'], 'e'=>'on' ]);
								
								
								if($__rd_p->e == 'ok'){
									
										$_out = '';
										$_fields = json_decode($row_UpSmsCmpg_Rg['up_fld'], true);
										$_fields_hdr = json_decode($row_UpSmsCmpg_Rg['up_hdr'], true);
										
										foreach($_fields_hdr as $_k => $_v){
											if(stripos($_v, '[') !== false){
												$__hdr_sch[ $_v ] = str_replace('c_', '', $_k);
											}
										}
										
										
										$_chk = new CRM_Cnt_Up();
										
										foreach ($_fields as $k=>$v){
											$__smscmpg = json_decode( ctjTx($row_UpSmsCmpg_Rg['___id_smscmpg'], 'in') ); 
											$__smscmpg_dt = GtSmsCmpgDt(['id'=>$__smscmpg->cmpg]);
											//print_r($__smscmpg_dt);
											
											$k2 = str_replace('c_', '', $k);
											$_chk->up_tp = $row_UpSmsCmpg_Rg['up_tp'];
											$_chk->sms_cmpg_up = $__smscmpg->id;
											$_chk->sms_cmpg_id = $__smscmpg->cmpg;
											$_chk->sms_cmpg_us = $__smscmpg->us;
											$_chk->sms_cmpg_msj = $__smscmpg_dt->msj;
											$_chk->sms_cmpg_f = $__smscmpg->f;
											$_chk->sms_cmpg_h = $__smscmpg->h;
											
											
											$_chk->$v = ctjTx($row_UpSmsCmpg_Rg['upcol_'.$k2], 'in');
											$_chk->id_upcol = $row_UpSmsCmpg_Rg['id_upcol'];
											$_chk->up_bd = $row_UpSmsCmpg_Rg['up_bd'];
											$_chk->c = $v;
											$_chk->v = strip_tags($row_UpSmsCmpg_Rg['upcol_'.$k2]);
											
											foreach($__hdr_sch AS $_k => $_v){
												$_chk->sms_cmpg_msj_k[$_v] = $_k;
												$_chk->sms_cmpg_msj_r[$_v] = ctjTx($row_UpSmsCmpg_Rg['upcol_'.$_v], 'in');
											}
						
											$_vlgo = $_chk->$v;
											
											// Si no viene el texto en el excel toma el de la campaña
											if($_chk->smssnd_msj == NULL || $_chk->smssnd_msj == ''){ $_chk->smssnd_msj = $__smscmpg_dt->msj; }
										}
										
										
										
										$_chk->Run();
										
										
										//print_r($_chk);
										$this->id_smscmpg = $_chk->sms_cmpg_id;
										$this->smscmpg_cel = $_chk->nw_smssnd_cel;
										$___exist = $this->SmsSndCmpg_Chk();
										
										
										$_out .= 'Exist?:'.print_r($___exist, true).$this->br().
												'Row:'.$row_UpSmsCmpg_Rg['id_upcol'].$this->br().
												'Mensaje: '.$_chk->smssnd_msj.$this->br().
												'Col:'.$k2.'-'.$v.':'.$_vlgo.$this->br().print_r($___chk, true).$this->br();
		
										
										if($_chk->hb != 'no'){
											
										
												
												$__CntIn = new CRM_Cnt([ 'cl'=>$row_Ls_Up_Rg['up_cl'] ]);
												
												$__CntIn->up_tp = $_chk->up_tp;
												$__CntIn->sms_cmpg_up = $_chk->sms_cmpg_up;
												$__CntIn->sms_cmpg_id = $_chk->sms_cmpg_id;
												$__CntIn->sms_cmpg_us = $_chk->sms_cmpg_us;
												$__CntIn->sms_cmpg_msj = $_chk->sms_cmpg_msj;
												$__CntIn->sms_cmpg_f = $_chk->sms_cmpg_f;
												$__CntIn->sms_cmpg_h = $_chk->sms_cmpg_h;
												
												$__CntIn->cnt_nm = $_chk->cnt_nm;
												$__CntIn->cnt_ap = $_chk->cnt_ap;
												$__CntIn->cnt_dc = filter_var($_chk->cnt_dc, FILTER_SANITIZE_STRING);
												$__CntIn->cnt_dc_tp = $_chk->cnt_dctp;
												
												$__CntIn->cnt_eml = filter_var($_chk->cnt_eml, FILTER_SANITIZE_EMAIL);
												$__CntIn->cnt_eml_2 = filter_var($_chk->cnt_eml_2, FILTER_SANITIZE_EMAIL);
												$__CntIn->cnt_eml_3 = filter_var($_chk->cnt_eml_3, FILTER_SANITIZE_EMAIL);
												
												$__CntIn->cnt_tp = $_chk->cnt_tp;
												$__CntIn->cnt_tp_2 = $_chk->cnt_tp_2;
												$__CntIn->cnt_tp_3 = $_chk->cnt_tp_3;
											
												$__CntIn->cnt_cd = [		
																		'id'=>ctjTx($_chk->cnt_cd_1,'out'),
																		'rel'=>ctjTx($_chk->cnt_cd_rel,'out')
																	];
												
												
												
												$__CntIn->cnt_tel = ['no'=>$_chk->cnt_tel, 
																		'tp'=>$_chk->cnt_tel_tp,
																		'ext'=>$_chk->cnt_tel_ext,
																		'ps'=>$_chk->cnt_tel_ps
																	];
												
												
												$__CntIn->cnt_tel_2 = ['no'=>$_chk->cnt_tel_2, 
																			'tp'=>$_chk->cnt_tel_2_tp,
																			'ext'=>$_chk->cnt_tel_2_ext,
																			'ps'=>$_chk->cnt_tel_2_ps
																	];					
												
												$__CntIn->cnt_tel_3 = ['no'=>$_chk->cnt_tel_3, 
																			'tp'=>$_chk->cnt_tel_3_tp,
																			'ext'=>$_chk->cnt_tel_3_ext,
																			'ps'=>$_chk->cnt_tel_3_ps
																	];	
												
												$__CntIn->cnt_prf = $_chk->cnt_prf;
												$__CntIn->cnt_dir = $_chk->cnt_dir;
												$__CntIn->cnt_sx = $_chk->cnt_sx;
												$__CntIn->up_bd = $_chk->up_bd;
												$__CntIn->cnt_fn = $_chk->cnt_fn;
												
												$__CntIn->smssnd_msj = $_chk->smssnd_msj;
												$__CntIn->smssnd_cel = $_chk->smssnd_cel;
												
												$__CntIn->demo = DEMO_CLSS;
												$__CntIn->bugs = BUGS_EST;
												
						
												if($_chk->sms_cmpg_id != NULL){
													//echo $_chk->smssnd_msj;
													$SmsCmpg_PrcDt = $__CntIn->InSmsCmpg();
												}
						
												if($SmsCmpg_PrcDt->e == ok){
													
													$_SmsCmpg_Int_upd=1;
													$_SmsCmpg_Est_upd = $_chk->Upd_Rw(); // Enabled
													
													
													while (($_SmsCmpg_Est_upd->e != 'ok') && ($_SmsCmpg_Int_upd < 5)){
														sleep(5);
														$_SmsCmpg_Est_upd = $_chk->Upd_Rw();
														$_SmsCmpg_Int_upd++;
													}
													
													if($_SmsCmpg_Est_upd->e == 'ok'){ $_SmsCmpg_Upd = 'ok'; }
							
												}elseif($SmsCmpg_PrcDt->i == NULL){
													$SmsCmpg_PrcDt_u = ['w'=>$SmsCmpg_PrcDt->w];
													$_chk->Upd_Rw_W( $SmsCmpg_PrcDt_u );	
													$_SmsCmpg_Upd = 'no';	
												}else{
													$_SmsCmpg_Upd = '-no-';
												}
												
												
												
												$_chk->hb_w_all .= $SmsCmpg_PrcDt->w.' '.$SmsCmpg_PrcDt->w_all;
												$_chk->hb_u_all .= $SmsCmpg_PrcDt->u_all;
										
										}elseif($___exist->e == 'ok'){
											
											$__up_frce = $_chk->Upd_Rw();
											
											if($__up_frce->e == 'ok'){
												$_out = ' Existe, entonces se marca en 1 ';
												$_chk->hb = 'ok';
												$_chk->hb_w_all = '';
											}
										}
										
										
										if($_chk->hb_w_all != NULL && $_chk->hb_w_all != ''){ $_out .= '<div style="color:#ed0000;">Errores:</div>'.$_chk->hb_w_all.$this->br(2); }
										
										$_out .= '<div style="font-size:9px; color:#CCC;"> '.Strn('Output:').$this->br().$_chk->hb_u_all.'</div>';
										
										if($_chk->hb == 'no'){ $_cls = '_no'; $_chk->Upd_Rw_W(); }else{ $_cls = ''; }
										
										//if(($_chk->hb == 'no' || $SmsCmpg_PrcDt->e == 'no') || (DEMO_CLSS == true)){
											echo $this->h1($row_UpSmsCmpg_Rg['upcol_up'].'-> Row '.$row_UpSmsCmpg_Rg['id_upcol'], $_cls). bdiv(['c'=>$_out, 'cls'=>$_cls]); 
										//}
									
								
								
								}
								
								
								$this->_up->_InUpRow_Rd(['id'=>$row_UpSmsCmpg_Rg['id_upcol']]);
						}
						
						
						
								
					} while ($row_UpSmsCmpg_Rg = $UpSmsCmpg_Rg->fetch_assoc()); $UpSmsCmpg_Rg->free;
			}		
		
		
			if(!isN( $UpSmsCmpg_Rg )){ $__cnx->_clsr($UpSmsCmpg_Rg); }
			
			$this->_up->_InUp_Rd(['id'=>$__smscmpg_up_id ]);
		
		}else{
			
			echo $this->h1('Upload '.$this->Spn('Sms Campaigns - Run On Next'), 'Auto_Tme_Prg');
			
		}					
	}

}else{

	echo $this->nallw('Global Monitor Upload - Campaña de SMS - Off');

}


?>