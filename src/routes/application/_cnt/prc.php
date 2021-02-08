<?php
	//@ini_set('display_errors', true);
	//error_reporting(E_ALL & ~E_NOTICE);

	//------------------ SETUP - START ------------------//

		Hdr_JSON();
		ob_start("compress_code");
		$_r['e']='no';
		$__pm_1 = PrmLnk('rtn', 1, 'ok');

	//------------------ SETUP - END ------------------//

		$__cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]);
		$__Appl = new CRM_Appl();
		$__Appl->data = Php_Ls_Cln($_POST);

		$__r = $__Appl->_pdata();

		if (!isN($__r->cnt_mdl) && !isN($__r->cnt_nm) && (!isN($__r->cnt_eml) || !isN($__r->cnt_dc) ) ){



			if(isN($__r->cnt_eml->w)){

					//------------------ Check Data Before Insert ------------------//

						$__CntIn = new CRM_Cnt([ 'cl'=>$__cl->id ]);

					//------------------ DATOS BASICOS DE LEAD ------------------//

						$__CntIn->tp = $__t_p;
						$__CntIn->cnt_nm = $__r->cnt_nm;
						$__CntIn->cnt_eml = $__r->cnt_eml;
						$__CntIn->cnt_dc = $__r->cnt_dc;
						$__CntIn->cnt_dc_tp = $__r->cnt_dc_tp;
						$__CntIn->cnt_dc_exp = $__r->cnt_dc_exp;
						$__CntIn->cnt_sx = $__r->cnt_sx;

						$__CntIn->cnt_cd_all = [
													[ 'id'=>ctjTx($__r->cnt_nac,'out'), 'rel'=>ctjTx($__r->cnt_nac_rel,'out') ],
													[ 'id'=>ctjTx($__r->cnt_rds,'out'), 'rel'=>ctjTx($__r->cnt_rds_rel,'out') ]
												];

						$__CntIn->cnt_tel =[ 'no'=>$__r->cnt_tel ];
						$__CntIn->cnt_cel =[ 'no'=>$__r->cnt_cel ];
						$__CntIn->cnt_fn = $__r->cnt_fn;
						$__CntIn->cnt_tp = $__r->cnt_tp;
						$__CntIn->cnt_dir = $__r->cnt_dir;
						$__CntIn->plcy_id = $__r->plcy_id;

					//------------------ DATOS BASICOS DE RELACION CON LEAD ------------------//

						$__CntIn->gt_mdl_id = $__r->mdl->id;
						$__CntIn->gt_cl_id = $__Appl->gt_cl->id;
			 			$__CntIn->invk->by = _CId('ID_SISINVK_FORM');

					//------------------ RELACIÓN A ORGANIZACIÓN ------------------//

						$__CntIn->cnt_org = json_decode(json_encode($__r->cnt_org), true);

					//------------------ PROCESA REGISTRO - START ------------------//

						$__dtcnt = $__CntIn->Chck([ 'id'=>$__CntIn->cnt_dc, 'tp'=>$__CntIn->cnt_dc_tp ]);

						$PrcCnt = $__CntIn->MdlCnt();

						//$_r['$PrcCnt'] = $PrcCnt;

						if(!isN($PrcCnt->cnt->i) || !isN($__dtcnt->id) ){

							$__CntIn->id_cnt = (!isN($PrcCnt->cnt->i)) ? $PrcCnt->cnt->i : $__dtcnt->id;
							$__cnt_enc = (!isN($PrcCnt->cnt->enc)) ? $PrcCnt->cnt->enc : $__dtcnt->enc;

							$PrcUpd_Cnt = $__CntIn->UpdCnt();
							//$_r['PrcUpd_Cnt'] = $PrcUpd_Cnt;

							$__Appl->id_cnt = $__CntIn->id_cnt;
							$__Appl->appl = $__r->appl_fm;
							$__Appl->mdl = $__r->cnt_mdl;
							$__Appl->ext_all = $__r->{'_ext_'};
							$PrcDts = $__Appl->CntAppl();

							//$_r['$PrcDts'] = $PrcDts;

							// ---------- Datos basicos de responsable financiero 1 ---------- //
								$_rsp = $__r->{'_ext_'}->resp_finan;
								$__ParnIn = new CRM_Cnt([ 'cl'=>$__cl->id ]);
								$__ParnIn->cnt_nm = $_rsp->nm_ap_resp_finan->vl;
								$__ParnIn->cnt_fn = $_rsp->fch_nac_resp_finan->vl;
								$__ParnIn->cnt_dir = $_rsp->dir_resp_finan->vl;
								$__ParnIn->cnt_sx = $_rsp->sex_resp_finan->vl;
								$__ParnIn->cnt_dc = $_rsp->dc_resp_finan->vl;
								$__ParnIn->cnt_dc_tp = $_rsp->tp_doc_resp_fin->vl;
								$__ParnIn->cnt_eml = $_rsp->eml_resp_finan->vl;
								$__ParnIn->cnt_tel =[ 'no'=>$_rsp->tel_resp_finan->vl ];
								$__ParnIn->cnt_cel =[ 'no'=>$_rsp->cel_resp_finan->vl ];
								$__ParnIn->cnt_cd_all = [
															[ 'id'=>ctjTx($_rsp->cd_nac_resp_finan->vl,'out'), 'rel'=> _CId('ID_TPRLCC_NCO') ],
															[ 'id'=>ctjTx($_rsp->cd_res_resp_finan->vl,'out'), 'rel'=> _CId('ID_TPRLCC_VVE') ]																												];

								$PrcPrntCnt = $__ParnIn->MdlCnt();

								//$_r['PrcPrntCnt'] = $PrcPrntCnt;

								$__dtcntprnt1 = $__ParnIn->Chck([ 'id'=>$__ParnIn->cnt_dc, 'tp'=>$__ParnIn->cnt_dc_tp ]);

								if(!isN($PrcPrntCnt->cnt->i) || !isN($__dtcntprnt1->id) ){

									$__ParnIn->id_cnt = (!isN($PrcPrntCnt->cnt->i)) ? $PrcPrntCnt->cnt->i : $__dtcntprnt1->id;
									$PrcUpd_Prnt = $__ParnIn->UpdCnt();

									//$_r['$PrcUpd_Prnt'] = $PrcUpd_Prnt;

								// ---------- Parentesco 1 ---------- //

									$__ParnIn->cnt_cnt = $__dtcntprnt1->enc;
									$__ParnIn->cnt_prnt = $_rsp->pant_resp_finan->vl;
									$__ParnIn->cnt_rlc = $__cnt_enc;
									$__ParnIn->rsp_fnc = 1;

									$PrcPrnt = $__ParnIn->CntPrntIn();
									//$_r['$PrcPrnt'] = $PrcPrnt;

									$__prnt = __LsDt([ 'k'=>'ls_prnt']);

									if($_rsp->pant_resp_finan->vl == _CId('ID_LSPRNT_6')){
										if($__r->cnt_sx == _CId('ID_SX_H')){
											$__if = _CId('ID_LSPRNT_2');
										}elseif($__r->cnt_sx == _CId('ID_SX_M')){
											$__if = _CId('ID_LSPRNT_1');
										}else{
											$__if = _CId('ID_LSPRNT_2');
										}
									}else{
										$__if = _CId($__prnt->ls->ls_prnt->{$_rsp->pant_resp_finan->vl}->prt->vl);
									}


								// ---------- Parentesco 1 ---------- //

									$__ParnIn->cnt_cnt =  $__cnt_enc;
									$__ParnIn->cnt_prnt = $__if;
									$__ParnIn->cnt_rlc = $__dtcntprnt1->enc;
									$__ParnIn->rsp_fnc = 2;

									$PrcPrnt2 = $__ParnIn->CntPrntIn();
									//$_r['$PrcPrnt2'] = $PrcPrnt2;

								// ---------- Atributos Parentesco 1 ---------- //

									$__Appl->id_cnt = $__ParnIn->id_cnt;
									$__Appl->ext_all_prnt = $__r->{'_ext_'}->resp_finan_app;
									$PrcCntAppl1 = $__Appl->ExtPrntAllAppl();
									//$_r['$PrcCntAppl1'] = $PrcCntAppl1;
								}

								// ---------- Datos basicos de responsable financiero 2 ---------- //

								$_rsp2 = $__r->{'_ext_'}->resp_finan2;
								$__Parn2In = new CRM_Cnt([ 'cl'=>$__cl->id ]);
								$__Parn2In->cnt_nm = $_rsp2->nm_ap_res_finan_2->vl;
								$__Parn2In->cnt_fn = $_rsp2->fch2_nac_resp_finan->vl;
								$__Parn2In->cnt_dir = $_rsp2->dir2_resp_finan->vl;
								$__Parn2In->cnt_sx = $_rsp2->sex2_resp_finan->vl;
								$__Parn2In->cnt_dc = $_rsp2->dc2_resp_finan->vl;
								$__Parn2In->cnt_dc_tp = $_rsp2->tp2_doc_resp_fin->vl;
								$__Parn2In->cnt_eml = $_rsp2->eml2_resp_finan->vl;
								$__Parn2In->cnt_tel =[ 'no'=>$_rsp2->tel2_resp_finan->vl ];
								$__Parn2In->cnt_cel =[ 'no'=>$_rsp2->cel2_resp_finan->vl ];
								$__Parn2In->cnt_cd_all = [
															[ 'id'=>ctjTx($_rsp2->cd2_nac_resp_finan->vl,'out'), 'rel'=> _CId('ID_TPRLCC_NCO') ],
															[ 'id'=>ctjTx($_rsp2->cd2_res_resp_finan->vl,'out'), 'rel'=> _CId('ID_TPRLCC_VVE') ]
														];

								$PrcPrntCnt2 = $__Parn2In->MdlCnt();
								//$_r['$PrcPrntCnt2'] = $PrcPrntCnt2;
								$__dtcntprnt2 = $__Parn2In->Chck([ 'id'=>$__Parn2In->cnt_dc, 'tp'=>$__Parn2In->cnt_dc_tp ]);

								if(!isN($PrcPrntCnt2->cnt->i) || !isN($__dtcntprnt2->id) ){

									$__Parn2In->id_cnt = (!isN($PrcPrntCnt2->cnt->i)) ? $PrcPrntCnt2->cnt->i : $__dtcntprnt2->id;
									$PrcUpd_Prnt2 = $__Parn2In->UpdCnt();
									//$_r['$PrcUpd_Prnt2'] = $PrcUpd_Prnt2;
								// ---------- Parentesco 2 ---------- //

									$__Parn2In->cnt_cnt = $__dtcntprnt2->enc;
									$__Parn2In->cnt_prnt = $_rsp2->prnt_resp_finan_2->vl;
									$__Parn2In->cnt_rlc = $__cnt_enc;
									$__Parn2In->rsp_fnc = 1;

									$PrcPrnt1_2 = $__Parn2In->CntPrntIn();
									//$_r['$PrcPrnt1_2'] = $PrcPrnt1_2;
									$__prnt = __LsDt([ 'k'=>'ls_prnt']);

									if($_rsp->prnt_resp_finan_2->vl == _CId('ID_LSPRNT_6')){
										if($__r->cnt_sx == _CId('ID_SX_H')){
											$__if = _CId('ID_LSPRNT_2');
										}elseif($__r->cnt_sx == _CId('ID_SX_M')){
											$__if = _CId('ID_LSPRNT_1');
										}else{
											$__if = _CId('ID_LSPRNT_2');
										}
									}else{
										$__if = _CId($__prnt->ls->ls_prnt->{$_rsp2->prnt_resp_finan_2->vl}->prt->vl);
									}



								// ---------- Parentesco 2 ---------- //

									$__Parn2In->cnt_cnt = $__cnt_enc;
									$__Parn2In->cnt_prnt = $__if;
									$__Parn2In->cnt_rlc = $__dtcntprnt2->enc;
									$__Parn2In->rsp_fnc = 2;
									$PrcPrnt2 = $__Parn2In->CntPrntIn();
									//$_r['$PrcPrnt2'] = $PrcPrnt2;
								// ---------- Atributos Parentesco 2 ---------- //

									$__Appl->id_cnt = $__Parn2In->id_cnt;
									$__Appl->ext_all_prnt = $__r->{'_ext_'}->resp_finan2_app;
									$PrcCntAppl2 = $__Appl->ExtPrntAllAppl();
									//$_r['$PrcCntAppl2'] = $PrcCntAppl2;
								}

								// ---------- Datos de responsable financiero 2 ---------- //
						}

						$_r['mdlcnt'] = $PrcCnt;

						if(!isN($PrcCnt->i)){


							if($__CntIn->invk->by == _CId('ID_SISINVK_FORM')){
			                	$__Cl = new CRM_Cl();
								$__Cl->clflj_t = 'appl_new';
								$__Cl->clflj_mre->appl_enc = $PrcDts->id_appl;
								$__flj = $__Cl->__flj();
								$_r['tmp_flj'] = $__flj->appl->snd;
							}


							if( !isN($___url_go) ){

								header('location:'.$___url_go);

							}else{

								$_r['i'] = $PrcCnt->i;
								$_r['e'] = 'ok';
								$_r['m'] = 1;
								$_r['appl'] = $PrcDts->id_appl;

							}

						}else{
							$_r['e'] = 'no';
							$_r['m'] = 2;
							if(!isN($PrcDt->w) || !isN($PrcDt->w_all)){ $_r['w'] = $PrcDt->w.' '.$PrcDt->w_all; }
							$_r['a'] = $PrcDt;
						}

					//------------------ PROCESA REGISTRO - END ------------------//

			}else{ $_r['e'] = 'no'; }

		}else{ $_r['e'] = 'no_data'; }

	//------------------ PRINT RESULTS ------------------//

	if(!isN($_r)){ echo json_encode($_r); }else{  }
	ob_end_flush();

?>