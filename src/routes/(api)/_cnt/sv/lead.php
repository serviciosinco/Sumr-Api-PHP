<?php 
			
	$_chk = new CRM_Cnt_Up([ 'cl'=>$__Ses->cl->id ]);
	$_cl = new CRM_Cl([ 'cl'=>$__Ses->cl->id ]);
		
	//-------------- Relation ID - START --------------//
	
	
		$_chk->mdl_cdc = _GetPost('__modulo_centrocostos');
		$_chk->mdl_id = _GetPost('__modulo_id');
		$_chk->mdl_prd = _GetPost('__modulo_periodo');
	
	
	//-------------- Check Values - START --------------//
	
	
		$_chk->mdlcnt_md = _GetPost('__medio');
		$_chk->mdlcnt_est = _GetPost('__estado');
		$_chk->mdlcnt_fi = _GetPost('__f_ingreso');
		
		$_chk->cnt_nm_disallow = 'ok';
		
		$_chk->cnt_nm = _GetPost('__nombre');
		$_chk->cnt_ap = _GetPost('__apellido');
		$_chk->cnt_dctp = _GetPost('__documento_tipo');
		$_chk->cnt_dc = _GetPost('__documento');
		$_chk->cnt_eml = _GetPost('__email');
		$_chk->cnt_eml_2 = _GetPost('__email_2');
		$_chk->cnt_eml_3 = _GetPost('__email_3');					
		$_chk->cnt_cd = [		
							'id'=>_GetPost('__ciudad'),
							'rel'=>_GetPost('__ciudad_relacion')
						];

		$_chk->cnt_tel = ['no'=>_GetPost('__telefono')];
		$_chk->cnt_tel_2 = ['no'=>_GetPost('__telefono_2')];
		$_chk->cnt_tel_3 = ['no'=>_GetPost('__telefono_3')];
		$_chk->cnt_tel_4 = ['no'=>_GetPost('__telefono_4')];
		$_chk->cnt_tel_5 = ['no'=>_GetPost('__telefono_5')];
		$_chk->cnt_tel_disallow = 'ok';
		
		
		$_chk->cnt_cel = ['no'=>_GetPost('__celular')];
		$_chk->cnt_cel_2 = ['no'=>_GetPost('__celular_2')];	
		
		
		$_chk->cnt_emp = _GetPost('__empresa');
		$_chk->cnt_prf = _GetPost('__profesion');
		$_chk->cnt_dir = _GetPost('__direccion');
		$_chk->cnt_sx = _GetPost('__sexo');
		$_chk->cnt_bd = 1;
		$_chk->cnt_sndi = _GetPost('__autoriza_envioinfo');
		$_chk->cnt_fn = _GetPost('__f_nacimiento');
		$_chk->cnt_est = _GetPost('__estado');
		$_chk->cnt_fnt = _GetPost('__fuente');
		$_chk->noi = _GetPost('__mnointeres');
		$_chk->noi_otu = _GetPost('__mnointeres_universidad');
		$_chk->cnt_fi = _GetPost('__f_ingreso');
		$_chk->cnt_cmnt = _GetPost('__comentario');

		$_chk->tra_col = _GetPost('__columna');
		$_chk->tra_sbrnd = _GetPost('__marca');
		
		$_chk->cnt_hcntc = _GetPost('__horario_contacto');
		
		$_chk->cnt_tpcntc = [
								'cntc_1' => _GetPost('__preferencia_contacto'),
								'cntc_2' => _GetPost('__preferencia_contacto_2'),
								'cntc_3' => _GetPost('__preferencia_contacto_3'),
								'cntc_4' => _GetPost('__preferencia_contacto_4')
							 ];

		
		if(!isN(_GetPost('__pdatos'))){
			$_chk->plcy_id = _GetPost('__pdatos');	
		}else{
			$___plcy_main = $_cl->plcy_main([ 'cl'=>$__Ses->cl->id ]); 
			//$rsp['slowt'][] = 'Policy Main: '.SIS_F_TS_M;
			$_chk->plcy_id = $___plcy_main->id;
		}
		
		if(!isN(_GetPost('__organizacion'))){
			
			$__org_sds = GtOrgSdsDt([ 'i'=>_GetPost('__organizacion') ]); 
			
			//$rsp['slowt'][] = 'Organization: '.SIS_F_TS_M;
			
			if(!isN($__org_sds->id)){
				
				$_chk->cnt_org[] = [
									'id'=>$__org_sds->enc,
									'tpr'=>_GetPost('__organizacion_relacion')
								];
			}				
		
		}

		// ----- Atributos Mdl_Cnt //
		$_chk->ext_out->mdl_cnt->fec_check_in->id = _CId('ID_MDLCNTATTR_FEC_CHECK_IN');
		$_chk->ext_out->mdl_cnt->fec_check_in->vl = _GetPost('__f_check_in');

		$_chk->ext_out->mdl_cnt->fec_check_out->id = _CId('ID_MDLCNTATTR_FEC_CHECK_OUT');
		$_chk->ext_out->mdl_cnt->fec_check_out->vl = _GetPost('__f_check_out');
		
		
		$_chk->ext->mdl_cnt = _GetPost('__oportunidad_ext');		
		
		$_chk->ext->cnt = _GetPost('__lead_ext');
		
		$_chk->mdlcnt_gst_us = $__Ses->us->id;
			
		$_chk->demo = _GetPost('__test');
		$_chk->bugs = false;
		$_chk->Run();
			
			
			
		//$rsp['out_crm'] = $_chk->ext_out;
			
			
			
			
	//-------------- Process - START --------------//


		if($_chk->hb != 'no'){
				
			$__CntIn = new CRM_Cnt([ 'cl'=>$__Ses->cl->id ]);
			$__CntIn->gt_mdl_id = $_chk->gt_mdl_id;	
			$__CntIn->gt_cl_id = $__Ses->cl->id;
							
			$__CntIn->mdlcnt_fi = $_chk->mdlcnt_fi;
			$__CntIn->mdlcnt_md = $_chk->mdlcnt_md;
			
			$__CntIn->cnt_nm = $_chk->cnt_nm;
			$__CntIn->cnt_ap = $_chk->cnt_ap;
			$__CntIn->cnt_dc = filter_var($_chk->cnt_dc, FILTER_SANITIZE_STRING);
			$__CntIn->cnt_dc_tp = $_chk->cnt_dctp;
			$__CntIn->cnt_eml = filter_var($_chk->cnt_eml, FILTER_SANITIZE_EMAIL);
			$__CntIn->cnt_eml_2 = filter_var($_chk->cnt_eml_2, FILTER_SANITIZE_EMAIL);
			$__CntIn->cnt_eml_3 = filter_var($_chk->cnt_eml_3, FILTER_SANITIZE_EMAIL);

			$__CntIn->cnt_cd[] = $_chk->cnt_cd;

			$__CntIn->cnt_tel = $_chk->cnt_tel;
			$__CntIn->cnt_tel_2 = $_chk->cnt_tel_2;
			$__CntIn->cnt_tel_3 = $_chk->cnt_tel_3;
			$__CntIn->cnt_tel_4 = $_chk->cnt_tel_4;
			$__CntIn->cnt_tel_5 = $_chk->cnt_tel_5;
			$__CntIn->cnt_cel = $_chk->cnt_cel;
			$__CntIn->cnt_cel_2 = $_chk->cnt_cel_2;
			$__CntIn->cnt_tel_getc = 'no';
			
			$__CntIn->cnt_estr = $_chk->cnt_estr;
			$__CntIn->cnt_eps = $_chk->cnt_eps;
			$__CntIn->cnt_emp = $_chk->cnt_em;
			$__CntIn->cnt_prf = $_chk->cnt_prf;
			$__CntIn->cnt_dir = $_chk->cnt_dir;
			$__CntIn->cnt_sx = $_chk->cnt_sx;
			$__CntIn->cnt_bd = $_chk->cnt_bd;
			$__CntIn->cnt_sndi = $_chk->cnt_sndi; 	
			$__CntIn->cnt_fn = $_chk->cnt_fn;
			
			$__CntIn->cnt_est = $_chk->mdlcnt_est;
			$__CntIn->cnt_fnt = $_chk->cnt_fnt;
			$__CntIn->noi = ($_chk->noi!=NULL?$_chk->noi:$_chk->mdlcnt_noi);
			$__CntIn->noi_otu = $_chk->mdlcnt_noi_otc;
			$__CntIn->noi_otp = $_chk->mdlcnt_noi_otp;
			$__CntIn->chk_vll = $_chk->mdlcnt_chk_vll;
			$__CntIn->chk_ner = $_chk->mdlcnt_chk_ner;
			$__CntIn->chk_spp = $_chk->mdlcnt_chk_spp;
			$__CntIn->cnt_fi = $_chk->cnt_fi;
			$__CntIn->cnt_fi = $_chk->cnt_fi;
			$__CntIn->cnt_cmn = $_chk->cnt_cmnt;
			
			$__CntIn->gst_us = $_chk->mdlcnt_gst_us;
			
			$__CntIn->ext_all = $_chk->ext_out;
			$__CntIn->mdl_prd = $_chk->mdl_prd!=NULL?$_chk->mdl_prd:$_chk->mdl_prd_l;
			
			$__CntIn->cnt_org = $_chk->cnt_org;
			
			$__CntIn->demo = _GetPost('__test');
			$__CntIn->api = true;
			$__CntIn->bugs = BUGS_EST;
			
			$__CntIn->rgs = 3;
			$__CntIn->plcy_id = $_chk->plcy_id;
			$__CntIn->invk->by = _CId('ID_SISINVK_API');
			
			$__CntIn->cnt_hcntc = $_chk->cnt_hcntc;
			$__CntIn->cnt_tpcntc = $_chk->cnt_tpcntc;

			$__CntIn->mdlcnt->attch = $_FILES;
			
			
			
			$PrcDt = $__CntIn->MdlCnt(); 
			//$rsp['slowt'][] = 'Save Data: '.SIS_F_TS_M;		
			
			if($_GET['Camilo']=='ok'){
				$rsp['tmp_ext_all__'] = _GetPost('__oportunidad_ext');
			}
					
			if(!isN($PrcDt->i)){ 
				
				//$rsp['slowt'][] = 'Gestiones: '.SIS_F_TS_M;
				
				$__gst_prc = $__CntIn->AllHisIn([	'dsc'=>_GetPost('__gestion'), 
													'us'=>$_chk->mdlcnt_gst_us, 
													'fi'=>_GetPost('__gestion_fecha'), 
													'hi'=>_GetPost('__gestion_hora') 
												]);
				
				//$rsp['gst'] = $__gst_prc;
				//$rsp['gst']['us'] = $_chk->mdlcnt_gst_us;
				
				$rsp['e'] = true;
				$rsp['e_c'] = 101;
				$rsp['i'] = $PrcDt->i;

				if(!isN( $_chk->mdl_id )){ 

					$__mdl = GtMdlDt([ 'id'=>$_chk->mdl_id ]);

					 

					if(!isN($__mdl->tp->id)){ 

						$_mdlstp_dt = GtMdlSTpDt([ 'id'=>$__mdl->tp->id, 'cl' => $__Ses->cl->id ]);
	
						if(!isN($_mdlstp_dt->tra) && $_mdlstp_dt->tra == 1){
	
							$__tra = new CRM_Tra();
							
							if(!isN($_chk->tra_col)){ 
								$__tra->tra_col = $_chk->tra_col; 
							}else{ 
								$__tra->tra_col = $_mdlstp_dt->dt->col; 
							}

							if(!isN($_chk->tra_col) && !isN($_chk->tra_sbrnd)){ 
								$__tra->tra_sbrnd = $_chk->tra_sbrnd; 
							}
	
							if(!isN($_mdlstp_dt->dt->tt)){ $___tt_tra_sve = $_mdlstp_dt->dt->tt; }else{ $___tt_tra_sve = '[NOTITLEDEFINED]'; }
	
							$__tra->tra_cl = !isN($_mdlstp_dt->dt->cl)?$_mdlstp_dt->dt->cl:$__Ses->cl->id;
							$__tra->tra_tt = $___tt_tra_sve;
							$__tra->trarsp_us = $_mdlstp_dt->dt->us;
							$__tra->trarsp_us_asg = $_mdlstp_dt->dt->us;
							$__tra->tra_dsc = $_chk->cnt_cmnt;
							$__tra->invk->by = _CId('ID_SISINVK_FORM');
							$__tra->mdlcnttra_mdlcnt = $PrcDt->i;

							if(!isN($__tra->tra_tt)){ 
								$PrcDtTra = $__tra->In_Tra(); 
								if($PrcDtTra->e != 'ok' && $PrcDtTra->mdlcnt->e != 'ok'){ 
									$rsp['e'] = 'no';
									$__prc_all = 'no';
									$rsp['w'][] = 'TraW:'.$PrcDtTra->w;
								}
							}else{
								$rsp['w'][] = 'No title for task';
								$__prc_all = 'no';
							}
	
							if($PrcDtTra->e == 'ok' && !isN($PrcDt->i)){
								$__tra->mdlcnttra_mdlcnt = $PrcDt->i;
								$__tra->mdlcnttra_tra = $PrcDtTra->i;
								$PrcDtMdlTra = $__tra->MdlCnt();
	
								if($PrcDtMdlTra->e != 'ok'){ 
									$rsp['e'] = 'no'; 
									$__prc_all = 'no';
									$rsp['w'][] = 'FM Prc: Problem on match tra and mdlcnt';
									$rsp['w'][] = $PrcDtMdlTra->w;
								}

								if($__mdl->tot->ctrl > 0){
									
									$_mdl_ctrl_ls = GtMdlCtrlLs(['id'=>$__mdl->id]);

									if(!isN($_mdl_ctrl_ls) && !isN( $_mdl_ctrl_ls->tot ) && $_mdl_ctrl_ls->tot > 0 && !isN( $PrcDtTra->i ) && $__mdl->tot->ctrl > 0){
				
										$__tra->tra = $PrcDtTra->i;
										
										foreach($_mdl_ctrl_ls->ls as $_ctrl_k => $_ctrl_v){
											
											$__tra->vl = $_ctrl_v->tx;
											$__tra->ord = $_ctrl_v->ord;	
											$__tra->id_cntrl = $_ctrl_v->id;
						
											$PrcDtCtrl = $__tra->In_TraCtrl();	
											
											if($PrcDtCtrl->e != 'ok'){
												$__prc_all = 'no';
												$rsp['ws'][] = $PrcDtCtrl;
												$rsp['w'][] = 'No List Control';
											}
										} 
									}
								}

							}else{
								$rsp['w'][] = 'Problem on save tra';
								$rsp['w'][] = $PrcDtTra->w;
							}
						}
					}
				}

				
				
				if(!isN($PrcDt->i)){
					$____prc_e = 'ok';
				}
					
			}else{
				$rsp['e'] = false;
				//$rsp['p'] = print_r($PrcDt, true);
				if($_chk->w_cod != NULL){ $rsp['e_c'] = $_chk->w_cod; }else{ $rsp['e_c'] = 102; }
			}
		}
		
		
		//$rsp['o'] = $_chk->hb_u_all
		
		//$_chk->hb_w_all .= $PrcDt->w.$PrcDt->w_all;
		$_chk->hb_u_all .= $PrcDt->u_all;
		$_chk->hb_w_api .= json_encode($_chk->hb_w_all);
		
		
		if($_chk->hb_w_api != NULL && !empty($_chk->hb_w_api)){ $rsp['w'] = $_chk->hb_w_api; }
				
			
										
?>