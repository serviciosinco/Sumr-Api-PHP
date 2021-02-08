<?php

	//@ini_set('display_errors', true);
	//error_reporting(E_ALL & ~E_NOTICE);

	//------------------* SETUP - START ------------------//

		Hdr_JSON();
		ob_start("compress_code");
		$_r['e']='no';

		$__pm_1 = PrmLnk('rtn', 1, 'ok');


	//------------------* SETUP - END ------------------//

		$__cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]);
		$__Forms = new CRM_Forms();
		$__Forms->data = Php_Ls_Cln($_POST);
		$__r = $__Forms->_pdata();

		if( Php_Ls_Cln($_POST['sch_cnt']) == 'ok' ){

			$___allow_all = 'ok';

		}

		$_r['er'] = $__r;


		if(
				(!isN($__r->mdl->id) || is_array($__r->mdl) ) &&
				(
					(
						!isN($__r->cnt_nm) &&
						(!isN($__r->cnt_eml) || !isN($__r->cnt_dc))
					) ||
					$___allow_all == 'ok'
				)
			){



			if(isN($__r->cnt_eml->w)){



					//------------------ Check Data Before Insert ------------------//

					$__CntIn = new CRM_Cnt([ 'cl'=>$__cl->id ]);


					//------------------ DATOS BASICOS DE LEAD ------------------//
					if( !isN($__r->cnt_ps) ){ $_ps = $__r->cnt_ps;  }else{ $_ps = 57;  }

						$__CntIn->tp = $__t_p;
						$__CntIn->cnt_nm = $__r->cnt_nm;
						$__CntIn->cnt_eml = $__r->cnt_eml;
						$__CntIn->cnt_eml_2 = $__r->cnt_eml_2;
						$__CntIn->cnt_dc = $__r->cnt_dc;
						$__CntIn->cnt_dc_tp = $__r->cnt_dc_tp;
						$__CntIn->cnt_dc_exp = $__r->cnt_dc_exp;
						$__CntIn->cnt_cd[] = [
												'id'=>ctjTx($__r->cnt_cd,'out'),
												'rel'=>ctjTx($__r->cnt_cd_rel,'out')
											];



						$__CntIn->cnt_tel =[ 'no'=>$__r->cnt_tel, 'ps'=>$_ps ];
						$__CntIn->cnttel_sms = $__r->cnttel_sms;
						$__CntIn->cnttel_whtsp = $__r->cnttel_whtsp;

						$__CntIn->cnt_sch = $__r->cnt_sch;
						$__CntIn->cnt_sndi = 1;
						$__CntIn->cnt_fn = $__r->cnt_fn;
						$__CntIn->cnt_tp = $__r->cnt_tp;
						$__CntIn->plcy_id = $__r->plcy_id;

						$__CntIn->cnt_dir = $__r->cnt_dir;
						$__CntIn->cnt_cel =[ 'no'=>$__r->cnt_cel, 'ps'=>$_ps ];

					//------------------ DATOS BASICOS DE RELACION CON LEAD ------------------//

						//----- TEMPO UEC  -----//

						if($__cl->id == 15){
							$_k = $__Forms->data->____key;
							$_md_snd = $__Forms->data->{'SndMed'.$_k};

							if($_md_snd == 14){ $__r->mdlcnt_md = 53; }
							elseif($_md_snd == 354){ $__r->mdlcnt_md = 57; }
							elseif($_md_snd == 338){ $__r->mdlcnt_md = 58; }
							elseif($_md_snd == 351){ $__r->mdlcnt_md = 59; }
							elseif($_md_snd == 352){ $__r->mdlcnt_md = 60; }
							elseif($_md_snd == 355){ $__r->mdlcnt_md = 61; }
							elseif($_md_snd == 293){ $__r->mdlcnt_md = 3; }
							elseif($_md_snd == 9){ $__r->mdlcnt_md = 62; }
							elseif($_md_snd == 353){ $__r->mdlcnt_md = 46; }
						}

						$__CntIn->cnt_fnt = $__r->mdlcnt_fnt;

						$__CntIn->mdlcnt_gen = $__r->mdl_gen->id;
						$__CntIn->mdlcnt_md = $__r->mdlcnt_md;
						$__CntIn->mdlcnt_md_k = $__r->mdlcnt_md_k;
						$__CntIn->mdlcnt_md_adg = $__r->mdlcnt_md_adg;

						$__CntIn->gt_mdl_id = $__r->mdl->id;
						$__CntIn->gt_cl_id = $__Forms->gt_cl->id;
						$__CntIn->gt_act_id = $__r->act->id;

			 			$__CntIn->invk->by = _CId('ID_SISINVK_FORM');
						$__CntIn->ext_all = $__r->{'_ext_'};

						$__CntIn->cnt_tp_mdl = $__r->cnt_tp_mdl;


					//------------------ DATOS PERSONALIZADOS DE CLIENTE ------------------//

						$__CntIn->cnt_cmn = $__r->cnt_cmnt;
						//$_r['ext'] = $__r;

					//------------------ RELACIÓN A ORGANIZACIÓN ------------------//

						$__CntIn->cnt_org = json_decode(json_encode($__r->cnt_org), true);

					//------------------ PROCESA REGISTRO - START ------------------//

						if(is_array($__r->cnt_mdl)){
							foreach ($__r->cnt_mdl as &$_v) {
								$__dtmdl = GtMdlDt([ 't'=>'enc', 'id'=>$_v ]);
								if( !isN($__dtmdl->id) ){
									$__CntIn->gt_mdl_id = $__dtmdl->id;
									$PrcDt= $__CntIn->MdlCnt();
									$_r['isd'] = $PrcDt;
								}
							}
						}else{
							$PrcDt = $__CntIn->MdlCnt();
						}

						if( !isN($__r->cnt_mdl_rel) ){

							//$__CntIn->gt_mdl_id = $__r->cnt_mdl_rel;
							//$__CntIn->MdlCnt();

							$__dtmdl = GtMdlDt([ 't'=>'enc', 'id'=>$__r->cnt_mdl_rel ]);

							//$__CntIn_Rel = new CRM_Cnt();

							if( !isN($__dtmdl->id) ){
								$__CntIn->gt_mdl_id = $__dtmdl->id;
								$Prc_Rel = $__CntIn->MdlCnt();
							}

						}

						$_r['tmp_prc'] = $PrcDt;

				 		if(!isN($PrcDt->i)){

					 		if( !isN($___url_go) ){

						 		header('location:'.$___url_go);

					 		}else{

								$_r['i'] = $PrcDt->i;
								//$_r['tmp'] = $PrcDt;
								$_r['e'] = 'ok';
								$_r['m'] = 1;

								if(!isN($___us_id)){ $_r['_c'] = base64_encode($___us_id); }

								$__mdl = GtMdlDt([ 'bd'=>$__cl->bd, 'id'=>$__r->mdl->id, 'fm'=>'ok' ]);

								if($__mdl->tp->fm->thx->top == 'ok' && !isN($__mdl->tp->fm->thx->url)){

									$__Forms->tagc->id_mdlcnt = $PrcDt->i;
									$__Forms->tagc->id_mdl = $__r->mdl->id;

									$__Forms->tagc_url = $__mdl->tp->fm->thx->url;
									$__Forms->_tagC();
									$_r['thx']['url'] = $__Forms->tagc_url;
								}

							}

						}else{
							$_r['e'] = 'no';
							$_r['m'] = 2;
							if(!isN($PrcDt->w) || !isN($PrcDt->w_all)){ $_r['w'] = $PrcDt->w.' '.$PrcDt->w_all; }
							$_r['a'] = $PrcDt;
						}


					//------------------ PROCESA REGISTRO - END ------------------//

			}else{

				$_r['e'] = 'no';

			}

		}else{

			$_r['e'] = 'no_data';

		}




	//------------------* PRINT RESULTS ------------------//


	if(!isN($_r)){ echo json_encode($_r); }else{  }
	ob_end_flush();


?>