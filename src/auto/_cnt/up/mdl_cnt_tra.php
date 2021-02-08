<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'up_mdl_cnt_tra' ]);

if( $_g_alw->est == 'ok' ){

	$__prfx_tt = 'MDLCNT - ';

	if(class_exists('CRM_Cnx')){

		$this->_up->tp = 'up_mdl_cnt_tra';

		//-------------------- CHECK IF GET ID SPECIFIC TO WORK --------------------//

			if(!isN($this->g__i)){
				$__lst_nou = $this->_up->_UpLstNo_U(['id'=>$this->g__i, 't'=>'enc', 'tp'=>'mdl_cnt_tra']);
				$__i_udp = $__lst_nou->id;
				$__fle_udp = $__lst_nou->fle;
			}else{
				if($this->g__rnd == 'ok'){ $_rnd='ok'; }else{ $_rnd='no'; }
				$__lst_nou = $this->_up->_UpLstNo_U([ 'tp'=>'mdl_cnt_tra', 'f'=>' AND up_est != '._CId('ID_UPEST_ELI').' ', 'rnd'=>$_rnd ]);
				$__i_udp = $__lst_nou->id;
				$__fle_udp = $__lst_nou->fle;
			}

		//-------------------- CHECK CUSTOM LIMIT --------------------//

			if(defined('UP_MDL_CNT_MAX') && !isN(UP_MDL_CNT_MAX)){
				$_qry_lmt = UP_MDL_CNT_MAX;
			}elseif(!isN($this->g__lmt)){
				$_qry_lmt = $this->g__lmt;
			}else{
				$_qry_lmt = '500';
			}

		//-------------------- IF THERE IS RECORS NOT UPDATE RUN QUERY --------------------//

			if($__lst_nou->r_tot > 0 && !isN($__i_udp)){

				$Ls_Up_Qry = "	SELECT *
								FROM ".DB_PRC.".".MDL_UP_COL_BD."
									INNER JOIN ".DB_PRC.".".MDL_UP_BD." ON upcol_up = id_up
								WHERE 	( up_est != "._CId('ID_UPEST_ON')." AND up_est != "._CId('ID_UPEST_ELI')." ) AND
										up_fld != '' AND
										( upcol_est != "._CId('ID_UPEST_ON')." AND upcol_est != "._CId('ID_UPEST_W')." ) AND
										( up_tp = 'mdl_cnt_tra' ) AND
										upcol_up = '".$__i_udp."' $__f
								ORDER BY RAND()
								LIMIT {$_qry_lmt} ";

				$Ls_Up_Rg = $__cnx->_qry($Ls_Up_Qry);

				if($Ls_Up_Rg){
					$row_Ls_Up_Rg = $Ls_Up_Rg->fetch_assoc();
					$Tot_Ls_Up_Rg = $Ls_Up_Rg->num_rows;
				}else{
					echo $this->h2($this->_up->c_r->error);
				}

				if($Tot_Ls_Up_Rg > 0){

					echo $this->h1($__prfx_tt.'Carga de Archivos MDLCNTTRA '.$this->Spn($Tot_Ls_Up_Rg). ' - cargados '.
							$row_Ls_Up_Rg['__tot_up']. ' - rows total '.$row_Ls_Up_Rg['__tot'] );

				}

			}elseif($__i_udp != ''){

				echo $this->h1($__prfx_tt.$__lst_nou->id.' no tiene registros creados en la tabla  ' );

			}else{

				echo $this->h1($__prfx_tt.' No hay bases para cargar');

			}


		//-------------------- THERE ARE RECORS TO PROCESS --------------------//


			if($Tot_Ls_Up_Rg > 0){


				if(!isN($__lst_nou->id) && $__lst_nou->r_tot > 0 && $__lst_nou->r_tot_up == $__lst_nou->r_tot){

					$this->_up->_InUp_Est([ 'id'=>$__i_udp, 'e'=>_CId('ID_UPEST_ON') ]);
					echo 'Actualiza registro '.$__lst_nou->id.' a 1';

				}elseif(($__lst_nou->r_tot_up+$__lst_nou->r_tot_w) == $__lst_nou->r_tot){

					//$this->_up->_InUp_Est([ 'id'=>$__i_udp, 'e'=>_CId('ID_UPEST_ON') ]);
					echo 'Actualiza registro '.$row_UpEcLsts_Rg['id_up'].' a 1';

				}


				do{

					try {

						echo $this->h1(date("Y-m-d H:i:s").' Start Loop For Record '.$row_Ls_Up_Rg['id_upcol']);

						$_AUTOP_d = $this->RquDt([ 't'=>'up_mdl_cnt_tra', 'id'=>$row_Ls_Up_Rg['id_upcol'], 'm'=>1 ]);

						//--------- AUTO TIME CHECK - START ---------//

						if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok') || Dvlpr()){

							$this->Rqu([ 't'=>'up_mdl_cnt_tra', 'id'=>$row_Ls_Up_Rg['id_upcol'] ]);

							echo $this->h3(date("Y-m-d H:i:s").' Is Locked Upload File ');

							$this->id_upcol = $row_Ls_Up_Rg['id_upcol'];

							/*-------------- CHECK IF RECORD IS ON READ STATE --------------*/

							$___chk = $this->UpCol_Chk(); if($___chk->rd == 'ok'){ echo $this->err($row_Ls_Up_Rg['id_upcol'].' esta en modo lectura'); }

							/*-------------- IF CHECK IS NOT ON READ STATE --------------*/

							if($___chk->e == 'ok' && $___chk->rd != 'ok'){

								echo $this->h3(date("Y-m-d H:i:s").' Lock Upload File');

								$__rd_p = $this->_up->_InUpRow_Rd(['id'=>$row_Ls_Up_Rg['id_upcol'], 'e'=>'on' ]);

								if($__rd_p->e == 'ok'){

									//echo $this->h2($row_Ls_Up_Rg['upcol_up'].'-> Row '.$row_Ls_Up_Rg['id_upcol'], $_cls);

									//$_out = '';
									$_fields = json_decode($row_Ls_Up_Rg['up_fld'], true);

									echo $this->h3(date("Y-m-d H:i:s").' Tickets - Start CntUp Class');

									$_chk = new CRM_Cnt_Up([ 'cl'=>$row_Ls_Up_Rg['up_cl'], 'cnx'=>[ 'c_r'=>$this->_up->c_r, 'c_p'=>$this->_up->c_p ] ]);

									/*-------------- CHECK ALL FIELDS SELECTED TO VERIFY INTEGRITY --------------*/

										foreach ($_fields as $k=>$v){

											$v= _jEnc($v);
											$k2 = str_replace('c_', '', $k);
											$_chk->up_tp = $row_Ls_Up_Rg['up_tp'];

											if(!isN($v->id)){

												if($v->id == 'cnt_tel' || $v->id == 'cnt_tel_2' || $v->id == 'cnt_tel_3' || $v->id == 'cnt_cel' || $v->id == 'cnt_cel_2'){

													$_chk->{$v->id} = ['no'=> ctjTx($row_Ls_Up_Rg['upcol_'.$k2], 'in') ];

												}elseif($v->id == 'cnt_tel_ps' || $v->id == 'cnt_tel_2_ps' || $v->id == 'cnt_tel_3_ps'){

													if($v->id == 'cnt_tel_ps'){
														$_chk->cnt_tel['ps'] = ctjTx($row_Ls_Up_Rg['upcol_'.$k2],'in');
													}elseif($v->id == 'cnt_tel_2_ps'){
														$_chk->cnt_tel_2['ps'] = ctjTx($row_Ls_Up_Rg['upcol_'.$k2],'in');
													}elseif($v->id == 'cnt_tel_3_ps'){
														$_chk->cnt_tel_3['ps'] = ctjTx($row_Ls_Up_Rg['upcol_'.$k2],'in');
													}

												}elseif($v->ext->cnt == 'ok' || $v->ext->mdl_cnt == 'ok'){

													if($v->ext->cnt == 'ok'){

														$_chk->ext->cnt[$v->id] = ctjTx($row_Ls_Up_Rg['upcol_'.$k2], 'in');

													}elseif($v->ext->mdl_cnt == 'ok'){

														$_chk->ext->mdl_cnt[$v->id] = ctjTx($row_Ls_Up_Rg['upcol_'.$k2], 'in');

													}

												}else{

													$_chk->{$v->id} = ctjTx($row_Ls_Up_Rg['upcol_'.$k2], 'in');

												}


												$_chk->id_upcol = $row_Ls_Up_Rg['id_upcol'];
												$_chk->up_bd = $row_Ls_Up_Rg['up_bd'];
												$_chk->c = $v->id;
												$_chk->v = strip_tags($row_Ls_Up_Rg['upcol_'.$k2]);


												$_vlgo = $_chk->{$v->id};
												//echo $this->h3('Row:'.$row_Ls_Up_Rg['id_upcol'].' / Col:'.$k2.' | '.$v->id.':'.$_vlgo);

											}
										}

										echo $this->h3(date("Y-m-d H:i:s").' Check Data Integrity');

										$_chk->Run();

									/*-------------- IF ALL DATA IS GOOD TO BE UPLOADED --------------*/

									//echo $_chk->hb.' <-> '.$_chk->mdlcnt_enc.' <-> '.$_chk->cnt_dc.' <-> '.$_chk->cnt_eml.' <-> '.$_chk->cnt_eml_2.' <-> '.$_chk->cnt_eml_3;

									if($_chk->hb != 'no' && (!isN($_chk->mdlcnt_enc) || !isN($_chk->cnt_dc) || !isN($_chk->cnt_eml) || !isN($_chk->cnt_eml_2) || !isN($_chk->cnt_eml_3) )){

										echo $this->h3(date("Y-m-d H:i:s").' Tickets - Start Cnt Class');

										if(isN($__CntIn) || isN($__up_cl) || $__up_cl != $row_Ls_Up_Rg['up_cl']){
											$__CntIn = new CRM_Cnt([ 'cl'=>$row_Ls_Up_Rg['up_cl'] ]);
										}

										$__up_cl = $row_Ls_Up_Rg['up_cl'];

										$__CntIn->up_tp = $_chk->up_tp;
										$__CntIn->up_us = $row_Ls_Up_Rg['up_us'];
										$__CntIn->gt_mdl_id = $_chk->gt_mdl_id;
										$__CntIn->gt_cl_id = $row_Ls_Up_Rg['up_cl'];
										$__CntIn->mdlcnt_fi = $_chk->mdlcnt_fi;
										$__CntIn->mdlcnt_md = $_chk->mdlcnt_md;
										$__CntIn->cnt_rnvl = $_chk->mdlcnt_fi;
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
										$__CntIn->cnt_cd_1 = $_chk->cnt_cd_1;
										$__CntIn->cnt_cd_tpr_1 = $_chk->cnt_cd_tpr_1;
										$__CntIn->cnt_cd_2 = $_chk->cnt_cd_2;
										$__CntIn->cnt_cd_tpr_2 = $_chk->cnt_cd_tpr_2;
										$__CntIn->cnt_cd_all = $_chk->cnt_cd_all;
										$__CntIn->cnt_ps = $_chk->cnt_ps;

										$__CntIn->cnt_tel = [	'no'=>$_chk->cnt_tel['no'],
																'tp'=>$_chk->cnt_tel_tp['tp'],
																'ext'=>$_chk->cnt_tel_ext['ext'],
																'ps'=>$_chk->cnt_tel_ps['ps']
															];

										$__CntIn->cnt_tel_2 = [	'no'=>$_chk->cnt_tel_2['no'],
																'tp'=>$_chk->cnt_tel_2_tp['tp'],
																'ext'=>$_chk->cnt_tel_2_ext['ext'],
																'ps'=>$_chk->cnt_tel_2_ps['ps']
															];

										$__CntIn->cnt_tel_3 = [	'no'=>$_chk->cnt_tel_3['no'],
																'tp'=>$_chk->cnt_tel_3_tp['tp'],
																'ext'=>$_chk->cnt_tel_3_ext['ext'],
																'ps'=>$_chk->cnt_tel_3_ps['ps']
															];

										$__CntIn->cnt_estr = $_chk->cnt_estr;
										$__CntIn->cnt_prf = $_chk->cnt_prf;
										$__CntIn->cnt_dir = $_chk->cnt_dir;
										$__CntIn->cnt_sx = $_chk->cnt_sx;
										$__CntIn->up_bd = $_chk->up_bd;
										$__CntIn->cnt_bd = [
												$_chk->cnt_bd,
												$_chk->cnt_bd_2,
												$_chk->cnt_bd_3
											];

										$__CntIn->cnt_sndi = $_chk->cnt_sndi;
										$__CntIn->cnt_fn = $_chk->cnt_fn;
										$__CntIn->cnt_est = $_chk->mdlcnt_est;
										$__CntIn->cnt_fnt = $_chk->mdlcnt_fnt;
										$__CntIn->cnt_fi = $_chk->cnt_fi;
										$__CntIn->cnt_cmn = $_chk->cnt_cmn;

										if(!isN($_chk->mdlcnt_gst_us)){
											$__CntIn->gst_us = $_chk->mdlcnt_gst_us;
										}else{
											$__CntIn->gst_us = $__CntIn->up_us;
										}

										$__CntIn->demo = DEMO_CLSS;
										$__CntIn->bugs = BUGS_EST;
										$__CntIn->cnt_tel_getc = 'no';
										$__CntIn->ext_all = $_chk->ext_out;
										$__CntIn->snd->eml->adm = 'no';
										$__CntIn->snd->eml->us = 'no';
										$__CntIn->plcy_id = $_chk->plcy_id;
										$__CntIn->invk->by = _CId('ID_SISINVK_AUTO');

										echo $this->h3(date("Y-m-d H:i:s").' Tickets Start Process to Save');

										$PrcDt = $__CntIn->MdlCnt();

										if(!isN($PrcDt->i) && isN($PrcDt->w)){

											$_r['i'] = $PrcDt->i;
											$_r['e'] = 'ok';
											$_r['m'] = 1;

											$_mdlstp_dt = GtMdlSTpDt([ 'id'=>$_chk->gt_mdl_tp->id, 'cl'=>$row_Ls_Up_Rg['up_cl'] ]);

											$__tra = new CRM_Tra([ 'cl'=>$row_Ls_Up_Rg['up_cl'] ]);
											$__tra->tra_col = $_chk->tra_col;
											$__tra->tra_sbrnd = $_chk->tra_sbrnd;

											if(!isN($_mdlstp_dt->dt->tt)){
												$___tt_tra_sve = $_mdlstp_dt->dt->tt;
											}else{
												$___tt_tra_sve = '[NOTITLEDEFINED]';
											}

											$__tra->tra_cl = $row_Ls_Up_Rg['up_cl'];
											$__tra->tra_tt = $___tt_tra_sve;
											$__tra->trarsp_us = $_mdlstp_dt->dt->us;
											$__tra->trarsp_us_asg = $_mdlstp_dt->dt->us;
											//$__tra->tra_dsc = $__r->cnt_cmnt;
											$__tra->invk->by = _CId('ID_SISINVK_AUTO');
											$__tra->mdlcnttra_mdlcnt = $PrcDt->i;

											if(!isN($__tra->tra_tt)){

												$PrcDtTra = $__tra->In_Tra();

												if($PrcDtTra->e != 'ok' && $PrcDtTra->mdlcnt->e != 'ok'){
													$PrcDt_u = [ 'w'=>'TraW:'.$PrcDtTra->w ];
													$_chk->Upd_Rw_W($PrcDt_u);
												}

											}else{
												$PrcDt_u = [ 'w'=>'No title for task' ];
												$_chk->Upd_Rw_W($PrcDt_u);
											}

											if($PrcDtTra->e == 'ok' && !isN($PrcDt->i)){

												$__tra->mdlcnttra_mdlcnt = $PrcDt->i;
												$__tra->mdlcnttra_tra = $PrcDtTra->i;
												$PrcDtMdlTra = $__tra->MdlCnt();

												if($PrcDtMdlTra->e != 'ok'){
													$PrcDt_u = [ 'w'=>'FM Prc: Problem on match tra and mdlcnt '.print_r($PrcDtMdlTra->w, true) ];
													$_chk->Upd_Rw_W($PrcDt_u);
												}else{
													echo $this->scss( 'Ticket created succesfully' );
													$_chk->Upd_Rw($PrcDt_u);
												}
												//$_r['in_mdl_tra']=$PrcDtMdlTra;
											}else{

												$PrcDt_u = [ 'w'=>'Tickets Error for PrcDtTra:'.print_r($PrcDtTra->w, true) ];
												$_chk->Upd_Rw_W($PrcDt_u);

											}

										}else{

											$PrcDt_u = [ 'w'=>'Tickets Error for PrcDt:'.print_r($PrcDt->w, true) ];
											$_chk->Upd_Rw_W($PrcDt_u);

										}

									}else{

										$PrcDt_u = ['w'=>$_chk->hb_w_all];
										$_chk->Upd_Rw_W($PrcDt_u);

									}


									if(!isN($_chk->hb_w_all)){
										echo $this->err('Tickets Errors:'.print_r($_chk->hb_w_all, true));
									}

									echo $this->h3( $this->Strn('Output:').$this->br().$_chk->hb_u_all );

									if($_chk->hb == 'no'){ $_cls = '_no'; $_chk->Upd_Rw_W(); }else{ $_cls = ''; }

									echo $this->h3(date("Y-m-d H:i:s").' End of save process: '.$PrcDt->e);

								}

							}

							$this->_up->_InUpRow_Rd(['id'=>$row_Ls_Up_Rg['id_upcol']]);

							$this->Rqu([ 't'=>'up_mdl_cnt_tra', 'id'=>$row_Ls_Up_Rg['id_upcol'] ]);

						}else{

							echo $this->h1('Upload '.$this->Spn('Tickets - Run On Next'), 'Auto_Tme_Prg');

						}

					} catch (Exception $e) {

						$this->_up->_InUpRow_Rd(['id'=>$row_Ls_Up_Rg['id_upcol'] ]);
						$this->Rqu([ 't'=>'up_mdl_cnt_tra', 'id'=>$row_Ls_Up_Rg['id_upcol'] ]);
						echo $this->err('Error loading file "' . $___fle_pth . '": ' . $e->getMessage() );

					}

				} while ($row_Ls_Up_Rg = $Ls_Up_Rg->fetch_assoc()); $Ls_Up_Rg->free;

			}



			if(!isN($Ls_Up_Rg)){
				$__cnx->_clsr($Ls_Up_Rg);
			}


	}

}else{

	echo $this->nallw('Global Monitor Upload - Tickets - Off');

}

?>
