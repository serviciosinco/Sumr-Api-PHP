<?php 

//@ini_set('display_errors', true); 
//error_reporting(E_ALL & ~E_NOTICE);


//-------------------- SETUP - START --------------------//
		
		
	$rsp['e'] = 'no';
	$__p_cl = Php_Ls_Cln($_POST['_cl']);
	$__p_plcy = Php_Ls_Cln($_POST['_plcy']);
	 
	$__p_ec_snd = Php_Ls_Cln($_POST['_ec_snd']);  
	$__p_cnt = Php_Ls_Cln($_POST['_cnt']);  


	
	$__p_cnt_org = Php_Ls_Cln($_POST['_cnt_org']);
	$__p_cnt_org_tt = Php_Ls_Cln($_POST['_cnt_org_tt']);
	$__p_cnt_org_tp = Php_Ls_Cln($_POST['_cnt_org_tp']);
	$__p_cnt_org_crg = Php_Ls_Cln($_POST['_cnt_org_crg']);
	
	$__p_org = Php_Ls_Cln($_POST['_org']);
	$__p_org_tp = Php_Ls_Cln($_POST['_org_tp']);
	$__p_org_prc = Php_Ls_Cln($_POST['_org_prc']);
	
	$__p_cnt_tel = Php_Ls_Cln($_POST['_cnt_tel']);
	$__p_cnt_tel_tp = Php_Ls_Cln($_POST['_cnt_tel_tp']);
	$__p_cnt_tel_prc = Php_Ls_Cln($_POST['_cnt_tel_prc']);
	$__p_cnt_tel_ps = Php_Ls_Cln($_POST['_cnt_tel_ps']); 
	
	$__p_cnt_eml = Php_Ls_Cln($_POST['_cnt_eml']);
	$__p_cnt_eml_tp = Php_Ls_Cln($_POST['_cnt_eml_tp']);
	$__p_cnt_eml_prc = Php_Ls_Cln($_POST['_cnt_eml_prc']);
	
	$__p_cnt_attr = Php_Ls_Cln($_POST['_cnt_attr']);
	
	$__p_cref = Php_Ls_Cln($_POST['_cref_cod']);
	
	
	
	
	
	
	if(!isN($__p_cl)){ $_cl_dt = GtClDt($__p_cl, 'enc'); } 
	if(!isN($__p_cnt)){ $_cnt_dt = GtCntDt([  't'=>'enc', 'cl'=>$_cl_dt->enc, 'id'=>$__p_cnt, 'bd'=>$_cl_dt->bd ]); }
	if(!isN($__p_cnt_org)){ $_org_sds_dt = GtOrgSdsDt([ 't'=>'enc', 'i'=>$__p_cnt_org ]); }
	if(!isN($__p_cnt_tel)){ $_cnt_tel_dt = GtCntTelDt([ 'bd'=>$_cl_dt->bd, 't'=>'enc', 'id'=>$__p_cnt_tel ]); }
	if(!isN($__p_cnt_eml)){ $_cnt_eml_dt = GtCntEmlDt([ 'bd'=>$_cl_dt->bd, 'tp'=>'enc', 'id'=>$__p_cnt_eml, 'cl'=>$_cl_dt->enc, 'd'=>['plcy'=>'ok'] ]); }
	if(!isN($__p_cnt_attr)){ $_cnt_attr_dt = GtCntAttrChkDt([ 'bd'=>$_cl_dt->bd, 'tp'=>'id', 'id'=>$__p_cnt_attr, 'cnt'=>$__p_cnt]); }

//-------------------- Classess --------------------//


	$__Cnt = new CRM_Cnt([ 'cl'=>$_cl_dt->id ]);
		
	
//-------------------- START PROCESS --------------------//
	
	
		
if ((isset($_POST["MM_delete_scr"])) && ($_POST["MM_delete_scr"] == "EdDelScr")) { 
	
	$_snd_dt = GtEcSndDt([ 'id'=>$__p_ec_snd, 'bd'=>$_cl_dt->bd.'.', 'tp'=>'enc' ]);
	
	if(!isN($__p_plcy) && is_array($__p_plcy)){
		
		foreach($__p_plcy as $plcy_k=>$plcy_v){
			
			$___plcydt = GtClPlcyDt([ 'id'=>$plcy_v, 't'=>'enc' ]);
			$__chk = $__Cnt->CntPlcyChk([ 'cnt'=>$_cnt_dt->id, 'plcy'=>$___plcydt->id ]);
			
			if(!isN($__chk->id)){
				
				$__prc = $__Cnt->UpdCnt_Plcy([ 'id'=>$__chk->id, 'sndi'=>2 ]);	
				
				if($__prc->e == 'ok'){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;	
					break;
				}
				
			}else{
				
				$rsp['e'] = 'no';
				$rsp['m'] = 2;	
				break;
			}
		
		}
	
	}
	
}

if ((isset($_POST["MM_update_scr"])) && ($_POST["MM_update_scr"] == "EdUpdScr")) { 
	
	$_allw = 'ok';
	
	if(!isN($__p_cnt_tel)){
		
		$__teldt = GtCntTelDt([ 't'=>'no', 'id'=>$__p_cnt_tel, 'ps'=>$__p_cnt_tel_ps, 'bd'=>$_cl_dt->bd ]);
		
		if(!isN($__teldt->cnt->id)){
			
			$_allw = 'no';
			
			if($_cnt_dt->id == $__teldt->cnt->id){
				$_allw_e = 'same_cnt';	
			}else{
				$_allw_e = 'other_cnt';	
			}
			
		}
		
	}elseif(!isN($__p_cnt_eml)){
		
		$__emldt = GtCntEmlDt(['id'=>$__p_cnt_eml, 'tp'=>'eml', 'cl'=>$_cl_dt->enc, 'bd'=>$_cl_dt->bd, 'd'=>['plcy'=>'ok'] ]);
		
		if(!isN($__emldt->cnt->id)){
			
			$_allw = 'no'; 
			
			if($_cnt_dt->id == $__emldt->cnt->id){
				$_allw_e = 'same_cnt';	
			}else{
				$_allw_e = 'other_cnt';	
			}
			
		}
		
	}elseif(!isN($__p_cnt_org)){
		
		if($__p_cnt_org_tp == 'emp'){
			$__est_pst = _CId('ID_ORGCNTRTP_TRB_PAS');
			$__est_now = _CId('ID_ORGCNTRTP_TRB_PRST');
			$__est_tp = _CId('ID_ORGTP_EMP');
		}elseif($__p_cnt_org_tp == 'uni'){
			$__est_pst = _CId('ID_ORGCNTRTP_ESTD_PAS');
			$__est_now = _CId('ID_ORGCNTRTP_ESTD_PRST');
			$__est_tp = _CId('ID_ORGTP_UNI');
		}elseif($__p_cnt_org_tp == 'clg'){
			$__est_pst = _CId('ID_ORGCNTRTP_ESTD_PAS');
			$__est_now = _CId('ID_ORGCNTRTP_ESTD_PRST');
			$__est_tp = _CId('ID_ORGTP_CLG');
		}
		
		
		if(isN($_org_sds_dt->id) && $__p_cnt_org == '-new-'){ //---------------- If company doesnt exists, insert it to check after
			
			$__org = new CRM_Org([ 'cl'=>$_cl_dt->id ]);	
			
			$__org->r_org_cl = 'ok';
			$__org->r_org_cnt = 'ok';
			
			$__org->cnt_enc = $_cnt_dt->enc;
			$__org->org_nm = $__p_cnt_org_tt;
			$__org->org_vrf = 2;
			
			$__org->org_cnt_tpr = $__est_now;
			$__org->org_cnt_tpr_o = $__est_tp;
			$__org->org_cnt_crg = $__p_cnt_org_crg;
			
			$__org_prc = $__org->In();
			
		}
		
		$__sdscntdt = GtOrgSdsCntDt([ 'bd'=>$_cl_dt->bd, 'cnt'=>$_cnt_dt->id, 'orgsds'=>$_org_sds_dt->id, 'tpro'=>$__est_tp ]);
		
		if($__sdscntdt->e == 'ok' && $__p_org_prc == 'mod'){
		
			if($__sdscntdt->tpr->id == $__est_pst){
				
				$__org = new CRM_Org([ 'cl'=>$_cl_dt->id ]);	
				$__prc_upd = $__org->_Org_Cnt_Upd([ 'enc'=>$__sdscntdt->enc, 'tpr'=>$__est_now ]);
				
				if($__prc_upd->e == 'ok'){
					$_org_sds_dt = GtOrgSdsDt([ 't'=>'enc', 'i'=>$__sdscntdt->org->sds->enc ]);
				}
				
			}else{
				
				$_allw = 'no';
				$_allw_e = 'same_est';	
				
			}	
			
		}else{
			
			$_allw_e = 'same_cnt';	
			
		}
		
	}
	
	//---------------- If it is enabled try to save data ----------------//
	
	if($_allw == 'ok'){
		
		$__CntSve = new CRM_Cnt([ 'cl'=>$_cl_dt->id ]);
		$__CntSve->cnt_id = $__p_cnt;
		
		if(!isN($__p_cnt_attr)){
			
			 
			
			$__CntSve->attr = $__p_cnt_attr;
			$__CntSve->cl_bd = $_cl_dt->bd;
			
			if($_cnt_attr_dt->e == 'no'){
				$PrcDt = $__CntSve->CntAttr_In();
			}elseif($_cnt_attr_dt->e == 'ok'){
				$PrcDt = $__CntSve->CntAttr_Del();	
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
				
		}
		
		
		if(!isN($__p_cref)){
			$__CntSve->cnt_cref = $__p_cref;
		}
	
		if(!isN($__p_cnt_tel)){ //---------------- If there is a number to save
			
			$__CntSve->cnt_tel = [
									'no'=>$__p_cnt_tel, 
									'tp'=>'',
									'ext'=>'',
									'ps'=>$__p_cnt_tel_ps
								];
		}					
		
		if(!isN($__p_cnt_eml)){ //---------------- If there is a email to save					
			$__CntSve->cnt_eml = $__p_cnt_eml;
		}
		
		if(!isN($__p_cnt_org) && !isN($_org_sds_dt->id)){ //---------------- If there is a compay to match					
			
			$__CntSve->cnt_org[] = [
				'id'=>$_org_sds_dt->enc,
				'tpr'=>$__est_now,
				'tpr_o'=>$__est_tp,
				'crg'=>$__p_cnt_org_crg
			];


		}
		
		if(!isN($__p_plcy)){
			
			foreach($__p_plcy as $_plcy_k=>$_plcy_v){
				
				$___plcydt = GtClPlcyDt([ 'id'=>$_plcy_v, 't'=>'enc' ]);
				
				if(!isN($___plcydt->id)){
					
					$__CntSve->plcy_id = $___plcydt->id;
					$__dtus_up = $__CntSve->_Cnt();
					
				}
				
			}
			
		}else{
			$__dtus_up = $__CntSve->_Cnt();	
		}
										 
	}else{
		
		$rsp['w'] = $_allw_e;
		
	}
	
	
					   
	if($__dtus_up->e == 'ok' || $__prc_upd->e == 'ok' || $__org_del->e == 'ok'){
		
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
		if(!isN($__p_cnt_tel)){
			
			$__teldt = GtCntTelDt([ 't'=>'no', 'id'=>$__p_cnt_tel, 'ps'=>$__p_cnt_tel_ps, 'bd'=>$_cl_dt->bd ]);
			
			$rsp['enc'] = $__teldt->enc;
			$rsp['no'] = __tel_scre([ 'v'=>$__teldt->tel ]);
			$rsp['ps'] = $__teldt->ps->img->url->th_50;
			$rsp['sndi'] = $__teldt->sndi;
			$rsp['sms'] = $__teldt->sms;
			$rsp['whtsp'] = $__teldt->whtsp;			
			
			
			$rsp['html'] .= '<li class="_anm" data-vl="'.$__teldt->enc.'">
								<div  class="_img_ps1" style="background-image:url('.$__teldt->ps->img->url->th_50.');"></div>
									'.__tel_scre([ 'v'=>$__teldt->tel ]);		        		
						        		
				foreach($_cnt_dt->plcy->ls as $_plcy_k=>$_plcy_v){
	        			
	        			if($_plcy_v->on == 'ok'){
	        			
	        				$__hbs = $__teldt->plcy->ls->{$_plcy_v->enc};
	        				
	        				if($__hbs->sndi == 'ok'){ $_tsndi_l='on'; $_tsndi_d='off'; $_tel_sndi_tt='on'; }else{ $_tsndi_l='off'; $_tsndi_d='on'; $_tel_sndi_tt='off'; }
	        				if($__hbs->sms == 'ok'){ $_sms_d='off'; $_tel_sms_tt='on'; }else{ $_sms_d='on'; $_tel_sms_tt='off'; }
	        				if($__hbs->whtsp == 'ok'){ $_whtsp_d='off'; $_tel_whtsp_tt='on'; }else{ $_whtsp_d='on'; $_tel_whtsp_tt='off'; }
	        				
	        				$rsp['html'] .= '<div class="_plcy '.$_tsndi_l.'" id="plcy_'.$__teldt->enc.'_'.$_plcy_v->enc.'">
						        				<div class="nm">'.$_plcy_v->nm.'</div>
								        		<div class="opt _anm">	
									        		<button class="_del _anm" data-vl="'.$__teldt->enc.'" data-mod-tp="tel" data-prc-tp="del">Ya no uso <span>este número</span></button>
									        		<button class="_sndi '.$__hbs->sndi.' _anm" data-vl="'.$__teldt->enc.'" data-mod-tp="sndi" data-prc-tp="'.$_tsndi_d.'" data-plcy-id="'.$_plcy_v->enc.'">Llamadas<span>'.$_tel_sndi_tt.'</span></button>									        		
									        		<button class="_sms '.$__hbs->sms.' _anm" data-vl="'.$__teldt->enc.'" data-mod-tp="sms" data-prc-tp="'.$_sms_d.'" data-plcy-id="'.$_plcy_v->enc.'">SMS<span>'.$_tel_sms_tt.'</span></button>			        										        		
									        		<button class="_whtsp '.$__hbs->whtsp.' _anm" data-vl="'.$__teldt->enc.'" data-mod-tp="whtsp" data-prc-tp="'.$_whtsp_d.'" data-plcy-id="'.$_plcy_v->enc.'">Whatsapp<span>'.$_tel_whtsp_tt.'</span></button>
									        	</div>
					        				</div>';
					}
					
				}
			
			$rsp['html'] .= '</li>';
							        	
							        	
							        	
							        	
							        	
			
		}elseif(!isN($__p_cnt_eml)){
			
			$__emldt = GtCntEmlDt([ 'tp'=>'eml', 'id'=>$__p_cnt_eml, 'bd'=>$_cl_dt->bd, 'cl'=>$_cl_dt->enc, 'd'=>['plcy'=>'ok'] ]);
			
			$rsp['eml'] = __eml_scre([ 'v'=>$__emldt->eml ]);
			$rsp['enc'] = $__emldt->enc;
			$rsp['sndi'] = $__emldt->sndi;

			if($__emldt->rjct=='ok'){ $_cls_eml='_lckd'; $_cls_eml_tt='No apto para envio (Hard Bounce)'; }else{ $_cls_eml=''; }

			$rsp['html'] .= '<li class="_anm" data-vl="'.$__emldt->enc.'">
									'.$__icn_sub_eml.__eml_scre([ 'v'=>$__emldt->eml ]).Spn('','','_tt_icn _tt_icn_lckd','','',$_cls_eml_tt);		        		
						        		
				foreach($_cnt_dt->plcy->ls as $_plcy_k=>$_plcy_v){
	        			
	        			if($_plcy_v->on == 'ok'){
	        			
	        				$__hbs = $__emldt->plcy->ls->{$_plcy_v->enc};
	        				
	        				if($__hbs->sndi == 'ok'){ $_tsndi_l='on'; $_tsndi_d='off'; }else{ $_tsndi_d='on'; $_tsndi_l='off'; $_eml_sndi_tt='off'; }
	        				
	        				$rsp['html'] .= '<div class="_plcy '.$_tsndi_l.'" id="plcy_'.$__emldt->enc.'_'.$_plcy_v->enc.'">
						        				<div class="nm">'.$_plcy_v->nm.'</div>
								        		<div class="opt _anm">	
									        		<button class="_del _anm" data-vl="'.$__emldt->enc.'" data-mod-tp="eml" data-prc-tp="del">Ya no uso <span>este correo</span></button>
									        		<button class="_sndi '.$__hbs->sndi.' _anm" data-vl="'.$__emldt->enc.'" data-mod-tp="sndi" data-prc-tp="'.$_tsndi_d.'" data-plcy-id="'.$_plcy_v->enc.'">Recibir Info<span>'.$_eml_sndi_tt.'</span></button>
									        	</div>
					        				</div>';
					}
					
				}
			
			$rsp['html'] .= '</li>';
			
			
			
		}elseif(!isN($__p_cnt_org)){
				
			if(!isN($__org_prc->_org_sds)){	
				$__org_sds_f = $__org_prc->_org_sds;	
			}elseif(!isN($_org_sds_dt->id)){
				$__org_sds_f = $_org_sds_dt;
			}
			
			
			if(!isN($__org_sds_f)){
				
				$__sdscntdt = GtOrgSdsCntDt([ 'bd'=>$_cl_dt->bd, 'cnt'=>$_cnt_dt->id, 'orgsds'=>$_org_sds_dt->id, 'tpro'=>$__est_tp ]);
				
				if($__p_cnt_org_tp == 'emp'){
					$__tt_btn = 'trabajo'; 
					$__tt_btn_b = 'trabajado'; 
				}elseif($__p_cnt_org_tp == 'uni' || $__p_cnt_org_tp == 'clg'){
					$__tt_btn = 'estudio';
					$__tt_btn_b = 'estudiado'; 
				}
				
				$rsp['html'] = '<li class="_anm '.$__sdscntdt->tpr->cns.'" data-tp="cnt" data-id="org" data-rel="trb_prst" data-in-tp="'.$__p_cnt_org_tp.'" data-vl="'.$__sdscntdt->enc.'" data-vl-tx="'.$__org_sds_f->nm_fll.'"><div class="_pr"><span style="border-color:'.$__org_sds_f->org->clr.'; " class="_log"><figure style="background-image:url('.$__org_sds_f->org->img->th_50.');"></figure></span>'.$__org_sds_f->nm_fll.'<strong class="subtt">'.ucfirst($__sdscntdt->tpr->tt).'</strong> </div><div class="opt _anm"><button class="_org _mod _anm" data-vl="'.$__sdscntdt->enc.'" data-mod-tp="'.$__p_cnt_org_tp.'" data-prc-tp="mod">Ya no <span>'.$__tt_btn.' aquí</span></button><button class="_org _del _anm" data-vl="'.$__sdscntdt->enc.'" data-mod-tp="'.$__p_cnt_org_tp.'" data-prc-tp="del">Nunca <span>he '.$__tt_btn_b.' aquí</span></button></div></li>';
				
				
			}
			
			
		}
		
		
	}else{
		
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['err'] = $__dtus_up;
		
	}
}




if ((isset($_POST["MM_delete_scr"])) && ($_POST["MM_delete_scr"] == "EdUpdScr")) { 
	
	
	if($__p_org_prc == 'del'){ //---------------- If there is a compay to deattach
			
		$__org = new CRM_Org([ 'cl'=>$_cl_dt->id ]);	
		$__org->cnt_enc = $_cnt_dt->enc;
		$__prc = $__org->_Org_Cnt_Del([ 'id'=>$__p_org ]);
		
	}elseif($__p_org_prc == 'mod'){ //---------------- If there is a compay to modify
		
		if($__p_org_tp == 'emp'){
			$___id_pst = _CId('ID_ORGCNTRTP_TRB_PAS');
		}elseif($__p_org_tp == 'uni' || $__p_org_tp == 'clg'){
			$___id_pst = _CId('ID_ORGCNTRTP_ESTD_PAS');
		}
		
		$__org = new CRM_Org([ 'cl'=>$_cl_dt->id ]);	
		$__prc = $__org->_Org_Cnt_Upd([ 'enc'=>$__p_org, 'tpr'=>$___id_pst ]);
		
		
		$__sdscntdt = GtOrgSdsCntDt([ 'bd'=>$_cl_dt->bd, 'id'=>$__p_org, 't'=>'enc' ]);
		
		$rsp['tpr'] = $__sdscntdt->tpr;
		
	}
	
	if($__prc->e == 'ok'){
		$rsp['e'] = 'ok';
	}
	
}





if ((isset($_POST["MM_update_tel"])) && ($_POST["MM_update_tel"] == "EdUpdTel")) { 
	
	$__CntIn = new CRM_Cnt([ 'cl'=>$_cl_dt->id ]);
	
	$__snd_data['id'] = $_cnt_tel_dt->enc;
	
	if($__p_cnt_tel_prc == 'del'){ //---------------- If has to delete the number
		
		$__snd_data['est'] = _CId('ID_SISTELEST_INCTV');
		$__prc = $__CntIn->UpdCntTel( $__snd_data );	
		$rsp['upd'] = $__prc;
		
	}elseif($__p_cnt_tel_prc == 'on' || $__p_cnt_tel_prc == 'off'){ //---------------- If there is a change to on
		

		if($__p_cnt_tel_prc == 'on'){
			$__snd_data[$__p_cnt_tel_tp] = ($__p_cnt_tel_prc=='off'?2:1);
			$__snd_data['est'] = _CId('ID_SISTELEST_ACTV');
			$__prc = $__CntIn->UpdCntTel( $__snd_data );
		}
		
		if(!isN($__p_plcy)){
			
			$___plcydt = GtClPlcyDt([ 'id'=>$__p_plcy, 't'=>'enc' ]);
			$__chk = $__Cnt->CntTelPlcyChk([ 'cnttel'=>$_cnt_tel_dt->id, 'plcy'=>$___plcydt->id ]);
			$__Cnt->plcy_id = $___plcydt->id;
				
			if(!isN($__chk->id)){	
				$__snd_data['id'] = $__chk->id;
				$__snd_data[$__p_cnt_tel_tp] = ($__p_cnt_tel_prc=='off'?2:1);
				$__prc = $__Cnt->UpdCntTel_Plcy($__snd_data);					
			}else{
				$__prc = $__Cnt->InCntTel_Plcy([ 'cnttel'=>$_cnt_tel_dt->id ]);
			}
			
		}
			
	}
	
	
	if($__prc->e == 'ok'){
		$rsp['e'] = 'ok';
	}
	
}



if ((isset($_POST["MM_update_eml"])) && ($_POST["MM_update_eml"] == "EdUpdEml")) {
	
	$__CntIn = new CRM_Cnt([ 'cl'=>$_cl_dt->id ]);
	
	$__snd_data['id'] = $_cnt_eml_dt->enc;


	if($__p_cnt_eml_prc == 'del'){ //---------------- If has to delete the number
		
		//$__prc = $__CntIn->EliCntEml( $__snd_data );
		
		$__snd_data['est'] = _CId('ID_SISEMLEST_INACT');
		$__prc = $__CntIn->UpdCntEml( $__snd_data );	
		$rsp['upd'] = $__prc;
				
		
	}elseif($__p_cnt_eml_prc == 'on' || $__p_cnt_eml_prc == 'off'){ //---------------- If there is a change to on
		
		//$__snd_data[$__p_cnt_eml_tp] = ($__p_cnt_eml_prc=='off'?2:1);	
		//$__prc = $__CntIn->UpdCntEml( $__snd_data );
		
		
		if($__p_cnt_eml_prc == 'on'){
			$__snd_data[$__p_cnt_eml_tp] = ($__p_cnt_eml_prc=='off'?2:1);
			$__snd_data['est'] = _CId('ID_SISEMLEST_NOCHCK');
			$__prc = $__CntIn->UpdCntEml( $__snd_data );
		}
		
		if(!isN($__p_plcy)){
			
			$___plcydt = GtClPlcyDt([ 'id'=>$__p_plcy, 't'=>'enc' ]);
			$__chk = $__Cnt->CntEmlPlcyChk([ 'cnteml'=>$_cnt_eml_dt->id, 'plcy'=>$___plcydt->id ]);
			$__Cnt->plcy_id = $___plcydt->id;
				
			if(!isN($__chk->id)){	
				$__snd_data['id'] = $__chk->id;
				$__snd_data[$__p_cnt_eml_tp] = ($__p_cnt_eml_prc=='off'?2:1);
				$__prc = $__Cnt->UpdCntEml_Plcy($__snd_data);					
			}else{
				$__prc = $__Cnt->InCntEml_Plcy([ 'cnteml'=>$_cnt_eml_dt->id ]);
			}
			
		}
		
		
		

	}
	
	if($__prc->e == 'ok'){
		$rsp['e'] = 'ok';
	}
	
}

	
?>