<?php

	include('../includes/incc.php');


	//------------------* SETUP - START ------------------//

		Hdr_JSON();
		ob_start("compress_code");
		$_r['e']='no';

		$__pm_1 = PrmLnk('rtn', 1, 'ok');


	//------------------* SETUP - END ------------------//

		$__cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]);
		$__Forms = new CRM_Forms();
		$__Forms->data = Php_Ls_Cln($_POST);
		$__Forms->svep = 'ok';
		$__r = $__Forms->_pdata();

		if( Php_Ls_Cln($_POST['sch_cnt']) == 'ok' ){
			$___allow_all = 'ok';
		}

		/*$_mdlstp_dt = GtMdlSTpDt(['id'=>$__Forms->_get_mdlstp]);
		$_r['es'] = $_mdlstp_dt;*/

		if(
				(!isN($__r->mdl->id) || is_array($__r->cnt_mdl) ) &&
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

					$__prc_all = 'ok';
					$__CntIn = new CRM_Cnt([ 'cl'=>$__cl->id ]);
					$__cnx->c_p->autocommit(FALSE);

				//------------------ DATOS BASICOS DE LEAD ------------------//

					$__CntIn->tp = $__t_p;
					$__CntIn->cnt_nm = $__r->cnt_nm;

					if(!isN($__r->cnt_ap)){
						$__CntIn->cnt_ap = $__r->cnt_ap;
					}

					$__CntIn->cnt_eml = $__r->cnt_eml;
					$__CntIn->cnt_dc = $__r->cnt_dc;
					$__CntIn->cnt_dc_tp = $__r->cnt_dc_tp;
					$__CntIn->cnt_dc_exp = $__r->cnt_dc_exp;

					if(!isN($__r->cnt_cd) && !isN($__r->cnt_cd_rel)){
						$__CntIn->cnt_cd[] = [
												'id'=>ctjTx($__r->cnt_cd,'out'),
												'rel'=>ctjTx($__r->cnt_cd_rel,'out')
											];
					}

					if(!isN($__r->cnt_tel_ps)){
						$_cnt_ps = $__r->cnt_tel_ps;
					}else{
						$_cnt_ps = $__r->cnt_ps;
					}

					$__CntIn->cnt_tel =[
						'no'=>$__r->cnt_tel,
						'ps'=>$_cnt_ps
					];

					$__CntIn->cnt_cel =[
						'no'=>$__r->cnt_cel,
						'ps'=>$_cnt_ps
					];

					$__CntIn->cnttel_sms = $__r->cnttel_sms;
					$__CntIn->cnttel_whtsp = $__r->cnttel_whtsp;

					$__CntIn->cnt_sch = $__r->cnt_sch;
					$__CntIn->cnt_sndi = 1;
					$__CntIn->cnt_fn = $__r->cnt_fn;
					$__CntIn->cnt_dir = $__r->cnt_dir;
					$__CntIn->cnt_tp = $__r->cnt_tp;
					$__CntIn->plcy_id = $__r->plcy_id;
					$__CntIn->cnt_prd = $__r->cnt_prd;
					$__CntIn->cnt_clsds = $__r->cnt_clsds;

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
					$__CntIn->mdlcnt->attch = $_FILES;

					$__CntIn->gt_mdl_id = $__r->mdl->id;
					$__CntIn->gt_cl_id = $__Forms->gt_cl->id;
					$__CntIn->gt_act_id = $__r->act->id;

					$__CntIn->invk->by = _CId('ID_SISINVK_FORM');
					$__CntIn->ext_all = $__r->{'_ext_'};
					//$_r['tmpext'][] = $__r->{'_ext_'};

				//------------------ DATOS PERSONALIZADOS DE CLIENTE ------------------//

					$__CntIn->cnt_cmn = $__r->cnt_cmnt;
					//$_r['ext'] = $__r;

				//------------------ RELACIÓN A ORGANIZACIÓN ------------------//

					$__CntIn->cnt_org = json_decode(json_encode($__r->cnt_org), true);

				//------------------ PROCESA REGISTRO - START ------------------//

					if( !isN($__r->cnt_mdl_rel) ){

						//$__CntIn->gt_mdl_id = $__r->cnt_mdl_rel;
						//$__CntIn->MdlCnt();

						$__dtmdl = GtMdlDt([ 't'=>'enc', 'id'=>$__r->cnt_mdl_rel ]);

						//$__CntIn_Rel = new CRM_Cnt();

						if( !isN($__dtmdl->id) ){
							$__CntIn->gt_mdl_id = $__dtmdl->id;
							$Prc_Rel = $__CntIn->MdlCnt();
							$_r['mdl_cnt_rel'] = $Prc_Rel;
							if($Prc_Rel->e != 'ok'){
								$_r['w'][] = $Prc_Rel->w;
								$__prc_all = 'no';
							}
						}else{
							$_r['w'][] = $__dtmdl->w;
							$__prc_all = 'no';
						}

					}

					if(is_array($__r->cnt_mdl)){

						foreach ($__r->cnt_mdl as &$_v) {

							$__dtmdl = GtMdlDt([ 't'=>'enc', 'id'=>$_v ]);

							if( !isN($__dtmdl->id) ){

								$__CntIn->gt_mdl_id = $__dtmdl->id;
								$PrcDt= $__CntIn->MdlCnt();
								//$_r['mdl_cnt'][] = $PrcDt;

								if(!isN($PrcDt->i)){
									if( !isN($__r->cnt_mdl_rel) && !isN($Prc_Rel->i)  ){

										$__CntIn->mdl_cnt_id = $Prc_Rel->i;
										$__CntIn->mdl_id = $__dtmdl->id;
										$PrcDtRel = $__CntIn->MdlCntMdl();
										$_r['mdl_cnt_mdl'][] = $PrcDtRel;

										if($PrcDtRel->e != 'ok'){
											$__prc_all = 'no';
											$_r['w'][] = $PrcDtRel->w;
										}
									}
								}else{

									$_r['w'][] = $PrcDt->w;
									$__prc_all = 'no';

								}

							}
						}

					}else{

						$PrcDt = $__CntIn->MdlCnt();
						//$_r['tmp'][] = $PrcDt;
						//$_r['tmp'][] = 'Only one module';

					}

					//$_r['tmp_prc'] = $PrcDt;

					if(!isN($PrcDt->i) && isN($PrcDt->w)){

						//$_r['tmp'][] = 'I value is'.$PrcDt->i;

						if( !isN($___url_go) ){

							header('location:'.$___url_go);

						}else{

							$_r['i'] = $PrcDt->i;
							//$_r['tmp'] = $PrcDt;
							$_r['e'] = 'ok';
							$_r['m'] = 1;

							if(!isN($___us_id)){ $_r['_c'] = base64_encode($___us_id); }

							if(!isN($__r->mdl_gen->id)){
								$__mdl_gen = GtMdlGenDt([ 'bd'=>$__cl->bd, 'id'=>$__r->mdl_gen->id, 'fm'=>'ok' ]);
							}else{
								$__mdl = GtMdlDt([ 'bd'=>$__cl->bd, 'id'=>$__r->mdl->id, 'fm'=>'ok' ]);
							}

							if($__mdl->tp->fm->thx->top == 'ok' && !isN($__mdl->tp->fm->thx->url)){

								$__Forms->tagc->id_mdlcnt = $PrcDt->i;
								$__Forms->tagc->id_mdl = $__r->mdl->id;
								$__Forms->tagc_url = $__mdl->tp->fm->thx->url;
								$__Forms->_tagC();
								$_r['thx']['url'] = $__Forms->tagc_url;

							}elseif($__mdl_gen->tp->fm->thx->top == 'ok' && !isN($__mdl_gen->tp->fm->thx->url)){

								$_r['thx']['url'] = $__mdl_gen->tp->fm->thx->url;

							}

							if(!isN($__Forms->_get_mdlstp)){

								$_mdlstp_dt = GtMdlSTpDt([ 'id'=>$__Forms->_get_mdlstp, 'cl' => $__cl->id ]);

								if(!isN($_mdlstp_dt->tra) && $_mdlstp_dt->tra == 1){

									$__tra = new CRM_Tra();

									if($__r->tra_col->id){
										$__tra->tra_col = $__r->tra_col->id;
									}else{
										$__tra->tra_col = $_mdlstp_dt->dt->col;
									}

									if($__r->tra_col->id){
										$__tra->tra_sbrnd = $__r->store_brnd->id;
									}

									if(!isN($_mdlstp_dt->dt->tt)){
										$___tt_tra_sve = $_mdlstp_dt->dt->tt;
									}else{
										$___tt_tra_sve = '[NOTITLEDEFINED]';
									}

									$__tra->tra_cl = !isN($_mdlstp_dt->dt->cl)?$_mdlstp_dt->dt->cl:$__cl->id;
									$__tra->tra_tt = $___tt_tra_sve;
									$__tra->trarsp_us = $_mdlstp_dt->dt->us;
									$__tra->trarsp_us_asg = $_mdlstp_dt->dt->us;
									$__tra->tra_dsc = $__r->cnt_cmnt;
									$__tra->invk->by = _CId('ID_SISINVK_FORM');
									$__tra->mdlcnttra_mdlcnt = $PrcDt->i;

									if(!isN($__tra->tra_tt)){

										$PrcDtTra = $__tra->In_Tra();
										//$_r['in_tra']=$PrcDtTra;

										if($PrcDtTra->e != 'ok' && $PrcDtTra->mdlcnt->e != 'ok'){
											$_r['e'] = 'no';
											$__prc_all = 'no';
											$_r['w'][] = 'TraW:'.$PrcDtTra->w;
											//$_r['tmpprcdtra'][] = $PrcDtTra;
										}elseif(!isN($PrcDtTra->i)){

											$_r['tckt_id'] = $PrcDtTra->i;

										}

									}else{
										$_r['w'][] = 'No title for task';
										$__prc_all = 'no';
									}

									if($PrcDtTra->e == 'ok' && !isN($PrcDt->i)){

										$__tra->mdlcnttra_mdlcnt = $PrcDt->i;
										$__tra->mdlcnttra_tra = $PrcDtTra->i;
										$PrcDtMdlTra = $__tra->MdlCnt();

										if($PrcDtMdlTra->e != 'ok'){
											$_r['e'] = 'no';
											$__prc_all = 'no';

											$_r['w'][] = 'FM Prc: Problem on match tra and mdlcnt';
											$_r['w'][] = $PrcDtMdlTra->w;
										}
										//$_r['in_mdl_tra']=$PrcDtMdlTra;
									}else{

										$_r['w'][] = 'Problem on save tra';
										$_r['w'][] = $PrcDtTra->w;

									}

								}

								if($__r->mdl->tot->ctrl > 0){

									$_mdl_ctrl_ls = GtMdlCtrlLs(['id'=>$__r->mdl->id]);

									if(!isN($_mdl_ctrl_ls) && !isN( $_mdl_ctrl_ls->tot ) && $_mdl_ctrl_ls->tot > 0 && !isN( $PrcDtTra->i ) && $__r->mdl->tot->ctrl > 0){

										$__tra->tra = $PrcDtTra->i;

										foreach($_mdl_ctrl_ls->ls as $_ctrl_k => $_ctrl_v){

											$__tra->vl = $_ctrl_v->tx;
											$__tra->ord = $_ctrl_v->ord;
											$__tra->id_cntrl = $_ctrl_v->id;

											$PrcDtCtrl = $__tra->In_TraCtrl();

											if($PrcDtCtrl->e != 'ok'){
												$__prc_all = 'no';
												$_r['ws'][] = $PrcDtCtrl;
												$_r['w'][] = 'No List Control';
											}
										}
									}
								}

							}

							/*if (!empty($_FILES)) {

								$__CntIn->attch->allw = ['jpg','jpeg','pdf','png','gif','doc','docx','xls','xlsx'];

								$__CntIn->_FILES = $_FILES;
								$__CntIn->id_mdlcnt = $PrcDt->i;
								$__CntIn->mdlcnt_enc = $PrcDt->enc;
								$_PrcMdlCntAttch = $__CntIn->MdlCntAttch();

								if($_PrcMdlCntAttch->e != 'ok'){
									$_r['w'][] = $_PrcMdlCntAttch->w;
									$_r['tmpppp2'][] = $_PrcMdlCntAttch;
									$__prc_all = 'no';
								}

							}*/

						}

					}else{

						$__prc_all = 'no';
						$_r['e'] = 'no';
						$_r['m'] = 2;
						//if(!isN($PrcDt->w) || !isN($PrcDt->w_all)){ $_r['w'] = $PrcDt->w.' '.$PrcDt->w_all; }
						$_r['a'] = $PrcDt;
						$_r['w'][] = $PrcDt->w;

					}

					if($__prc_all == 'ok'){
						if($__cnx->c_p->commit()){
							$_r['e'] = 'ok';
						}else{
							$_r['w'][] = 'Commit fails';
							$_r['e'] = 'no';
						}
					}else{
						$_r['e'] = 'no';
						$_r['w'][] = 'Has to do rollback';
						$__cnx->c_p->rollback();
					}

					$__cnx->c_p->autocommit(TRUE);

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