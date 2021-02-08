<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'up_ec_lsts' ]);

if( $_g_alw->est == 'ok' ){

	$__prfx_tt = 'ECLSTS - ';

	if(class_exists('CRM_Cnx')){

		//--------- AUTO TIME CHECK - START ---------//

		$_AUTOP_d = $this->RquDt([ 't'=>'up_ec_lsts', 'm'=>1 ]);

		//$_AUTOP_d->hb = 'ok';

		if($_AUTOP_d->hb == 'ok' || !isN($this->g__i)){

			$this->Rqu([ 't'=>'up_ec_lsts' ]);

			//-------------- Filtros --------------//

			if(!isN($this->g__i)){ $__fl_main = " AND up_enc = '".$this->g__i."' "; }
			if(!isN($this->g__lmt)){ $_qry_lmt = $this->g__lmt; }else{ $_qry_lmt = '1000'; }

			//-------------- Listado de Cargas --------------//

			$UpEcLsts_Qry = "SELECT *
							FROM ".DBP.".".MDL_UP_BD."
								 INNER JOIN "._BdStr(DBM).TB_CL." ON up_cl = id_cl
							WHERE 	up_est = '"._CId('ID_UPEST_PRC')."' AND
									up_tp = 'snd_ec_lsts_up' {$__fl_main}
							ORDER BY id_up ASC
						";

			//echo compress_code($UpEcLsts_Qry);

			$UpEcLsts_Rg = $__cnx->_qry($UpEcLsts_Qry);

			if($UpEcLsts_Rg){ //-------------- Consulta Exitosa --------------//

				$row_UpEcLsts_Rg = $UpEcLsts_Rg->fetch_assoc();
				$Tot_UpEcLsts_Rg = $UpEcLsts_Rg->num_rows;

				if($Tot_UpEcLsts_Rg > 0){ //-------------- Hay registros --------------//

					do{


						try{

							echo $this->h2($row_UpEcLsts_Rg['id_up']);

							$__Up = new CRM_Up([ 'cl'=>$row_UpEcLsts_Rg['up_cl'] ]);
							$__Up->tp = 'up_ec_lsts';

							$__eclsts_up_id = $row_UpEcLsts_Rg['id_up'];
							$__eclsts_nou = $__Up->_UpLstNo_U(['id'=>$row_UpEcLsts_Rg['up_enc'], 't'=>'enc', 'tp'=>'snd_ec_lsts_up']);


							echo $this->li( compress_code( print_r($__eclsts_nou, true) ) );

							if(($__eclsts_nou->r_tot_up+$__eclsts_nou->r_tot_w) == $__eclsts_nou->r_tot){
								//$__Up->_InUp_Est([ 'id'=>$row_UpEcLsts_Rg['id_up'], 'e'=>_CId('ID_UPEST_ON') ]);
								//echo '1. Actualiza registro '.$row_UpEcLsts_Rg['id_up'].' a 1';
							}

							if($__eclsts_nou->r_tot > 0 && !isN($__eclsts_up_id)){

								//-------------- Listado de Registro de cada Carga --------------//

								$UpEcLsts_Rcrds_Qry = "
											SELECT *,
													(NOW() - INTERVAL 5 MINUTE) AS __rd_aft,
													(	SELECT CONCAT('{\"id\":\"', id_eclstsup,'\", \"lsts\":\"', eclstsup_lsts,'\"} ')
														FROM "._BdStr(DBM).TB_EC_LSTS_UP."
														WHERE eclstsup_up = id_up
													) AS ___id_eclsts

											FROM ".DBP.".".MDL_UP_COL_BD."
													INNER JOIN ".DBP.".".MDL_UP_BD." ON upcol_up = id_up

											WHERE
													upcol_up = '".$__eclsts_up_id."' AND
													up_tp = 'snd_ec_lsts_up' AND
													up_fld != '' AND
													up_est != '"._CId('ID_UPEST_ON')."' AND
													up_est != '"._CId('ID_UPEST_ELI')."' AND
													up_est != '"._CId('ID_UPEST_W')."' AND
													upcol_est != '"._CId('ID_UPEST_ON')."' AND
													upcol_est != '"._CId('ID_UPEST_ELI')."' AND
													upcol_est != '"._CId('ID_UPEST_W')."' AND

													(
														upcol_rd = 2 ||
														(NOW() - INTERVAL 5 MINUTE) > 0
													) AND

													up_rd = 2

													/*

														(
															(upcol_est != '"._CId('ID_UPEST_W')."' || upcol_rd_f > (NOW() - INTERVAL 5 MINUTE) )
														) AND

													*/

													$__f


											ORDER BY id_upcol ASC
											LIMIT {$_qry_lmt} ";


								//echo compress_code($UpEcLsts_Rcrds_Qry);

								$UpEcLsts_Rcrds_Rg = $__cnx->_qry($UpEcLsts_Rcrds_Qry);

								if($UpEcLsts_Rcrds_Rg){

									$row_UpEcLsts_Rcrds_Rg = $UpEcLsts_Rcrds_Rg->fetch_assoc();
									$Tot_UpEcLsts_Rcrds_Rg = $UpEcLsts_Rcrds_Rg->num_rows;

								}else{

									echo $this->err( 'Query Error:'.$__cnx->c_r->error );

								}

								echo $this->h1($__prfx_tt.'Carga de Archivos ECLSTS '.$this->Spn($Tot_UpEcLsts_Rcrds_Rg). ' - cargados '.$row_UpEcLsts_Rcrds_Rg['__tot_up']. ' - rows total '.$row_UpEcLsts_Rcrds_Rg['__tot'] );

							}elseif(!isN($__eclsts_up_id)){

								echo $this->h1($__prfx_tt.$__eclsts_nou->id.' no tiene registros creados en la tabla ' );

							}else{

								echo $this->h1($__prfx_tt.' No hay bases para cargar');

							}


							$__Up->_InUp_Rd(['id'=>$__eclsts_up_id, 'e'=>'on' ]);


							if(!isN($__eclsts_nou->id) && $__eclsts_nou->r_tot > 0 && $__eclsts_nou->r_tot_up == $__eclsts_nou->r_tot){
								$__Up->_InUp_Est([ 'id'=>$__eclsts_up_id, 'e'=>_CId('ID_UPEST_ON') ]);
								echo $this->li('2. Actualiza registro '.$__eclsts_up_id.' a 1');
							}else{
								$__tot_t_up = $__eclsts_nou->r_tot_w + $__eclsts_nou->r_tot_up;
								if($Tot_UpEcLsts_Rcrds_Rg > 0 && $__tot_t_up == $__eclsts_nou->r_tot && $__eclsts_up_id != ''){
									//$__Up->_InUp_Est([ 'id'=>$__eclsts_up_id, 'e'=>_CId('ID_UPEST_W') ]);
									echo $this->li('3. Actualiza registro '.$__eclsts_up_id.' a 5');
								}
							}


							if($Tot_UpEcLsts_Rcrds_Rg > 0){

								do{

									$this->id_upcol = $row_UpEcLsts_Rcrds_Rg['id_upcol'];

									/*-------------- CHECK IF RECORD IS ON READ STATE --------------*/

									$___chk = $this->UpCol_Chk();

									/*-------------- IF CHECK IS NOT ON READ STATE --------------*/

									if($___chk->e == 'ok' && ($___chk->rd != 'ok' || $row_UpEcLsts_Rcrds_Rg['__rd_aft'])){

										try{

											$__rd_p = $__Up->_InUpRow_Rd(['id'=>$row_UpEcLsts_Rcrds_Rg['id_upcol'], 'e'=>'on' ]);

											if($__rd_p->e == 'ok'){

												$_out = '';
												$_fields = json_decode($row_UpEcLsts_Rcrds_Rg['up_fld'], true);
												$_chk = new CRM_Cnt_Up([ 'cl'=>$row_UpEcLsts_Rcrds_Rg['up_cl'] ]);

												/*-------------- CHECK ALL FIELDS SELECTED TO VERIFY INTEGRITY --------------*/

												foreach ($_fields as $k=>$v){

													$v= _jEnc($v);
													$k2 = str_replace('c_', '', $k);
													$_chk->up_tp = $row_UpEcLsts_Rcrds_Rg['up_tp'];

													if(!isN($v->id)){

														if($v->id == 'cnt_tel' || $v->id == 'cnt_tel_2' || $v->id == 'cnt_tel_3' || $v->id == 'cnt_cel' || $v->id == 'cnt_cel_2'){

															$_chk->{$v->id} = ['no'=> ctjTx($row_UpEcLsts_Rcrds_Rg['upcol_'.$k2], 'in') ];

														}elseif($v->ext->cnt == 'ok' || $v->ext->mdl_cnt == 'ok'){

															if($v->ext->cnt == 'ok'){

																$_chk->ext->cnt[$v->id] = ctjTx($row_UpEcLsts_Rcrds_Rg['upcol_'.$k2], 'in');

															}elseif($v->ext->mdl_cnt == 'ok'){

																$_chk->ext->mdl_cnt[$v->id] = ctjTx($row_UpEcLsts_Rcrds_Rg['upcol_'.$k2], 'in');

															}

														}else{

															$_chk->{$v->id} = ctjTx($row_UpEcLsts_Rcrds_Rg['upcol_'.$k2], 'in');

														}

														$__eclsts = json_decode($row_UpEcLsts_Rcrds_Rg['___id_eclsts']);

														$_chk->up_tp = $row_UpEcLsts_Rcrds_Rg['up_tp'];
														$_chk->ec_lsts_up = $__eclsts->id;
														$_chk->ec_lsts_id = $__eclsts->lsts;
														$_chk->ec_lsts_up_col = $row_UpEcLsts_Rcrds_Rg['id_upcol'];

														$_chk->id_upcol = $row_UpEcLsts_Rcrds_Rg['id_upcol'];
														$_chk->up_bd = $row_UpEcLsts_Rcrds_Rg['up_bd'];
														$_chk->c = $v->id;
														$_chk->v = strip_tags($row_UpEcLsts_Rcrds_Rg['upcol_'.$k2]);


														$_vlgo = $_chk->{$v->id};
														$_out .= $this->li('Row:'.$row_UpEcLsts_Rcrds_Rg['id_upcol'].' / Col:'.$k2.' | '.$v->id.':'.$_vlgo);

													}
												}

												$_chk->Run();

												$this->ec_lsts_id = $_chk->ec_lsts_id;
												$___exist = $this->CntEcLsts_Chk([ 'bd'=>DB_PRFX_CL.$row_UpEcLsts_Rg['cl_sbd'], 'eml'=>$_chk->cnt_eml ]);
												echo $this->li('Exists:'.print_r($___exist,true));

												/*-------------- IF ALL DATA IS GOOD TO BE UPLOADED --------------*/

												if($_chk->hb == 'no'){

													$_cls = '_no';
													$_chk->Upd_Rw_W();

												}elseif($_chk->hb != 'no' && (!isN($_chk->cnt_dc) || !isN($_chk->cnt_eml) || !isN($_chk->cnt_eml_2) && !isN($_chk->cnt_eml_3))){

													$_cls = '';
													$__CntIn = '';
													$__CntIn = new CRM_Cnt([ 'cl'=>$row_UpEcLsts_Rcrds_Rg['up_cl'] ]);

													$__CntIn->up_tp = $_chk->up_tp;
													$__CntIn->ec_lsts_up = $_chk->ec_lsts_up;
													$__CntIn->ec_lsts_id = $_chk->ec_lsts_id;
													$__CntIn->ec_lsts_sgm_id = $_chk->ec_lsts_sgm;
													$__CntIn->ec_lsts_bdt = $_chk->ec_lsts_bdt;
													$__CntIn->ec_lsts_bdt_2 = $_chk->ec_lsts_bdt_2;
													$__CntIn->ec_lsts_up_col = $_chk->ec_lsts_up_col;

													$__CntIn->cnt_nm = $_chk->cnt_nm;
													$__CntIn->cnt_ap = $_chk->cnt_ap;
													$__CntIn->cnt_dc = filter_var($_chk->cnt_dc, FILTER_SANITIZE_STRING);
													$__CntIn->cnt_dc_tp = $_chk->cnt_dctp;

													$__CntIn->cnt_eml = filter_var(strtolower($_chk->cnt_eml), FILTER_SANITIZE_EMAIL);
													$__CntIn->cnt_eml_2 = filter_var(strtolower($_chk->cnt_eml_2), FILTER_SANITIZE_EMAIL);
													$__CntIn->cnt_eml_3 = filter_var(strtolower($_chk->cnt_eml_3), FILTER_SANITIZE_EMAIL);

													$__CntIn->cnt_tp = $_chk->cnt_tp;
													$__CntIn->cnt_tp_2 = $_chk->cnt_tp_2;
													$__CntIn->cnt_tp_3 = $_chk->cnt_tp_3;

													$__CntIn->cnt_cd = [
																			'id'=>ctjTx($_chk->cnt_cd_1,'out'),
																			'rel'=>ctjTx($_chk->cnt_cd_rel,'out')
																		];


													$__CntIn->cnt_tel = [	'no'=>$_chk->cnt_tel,
																			'tp'=>$_chk->cnt_tel_tp,
																			'ext'=>$_chk->cnt_tel_ext,
																			'ps'=>$_chk->cnt_tel_ps
																		];


													$__CntIn->cnt_tel_2 = [	'no'=>$_chk->cnt_tel_2,
																			'tp'=>$_chk->cnt_tel_2_tp,
																			'ext'=>$_chk->cnt_tel_2_ext,
																			'ps'=>$_chk->cnt_tel_2_ps
																		];

													$__CntIn->cnt_tel_3 = [ 'no'=>$_chk->cnt_tel_3,
																			'tp'=>$_chk->cnt_tel_3_tp,
																			'ext'=>$_chk->cnt_tel_3_ext,
																			'ps'=>$_chk->cnt_tel_3_ps
																		];

													$__CntIn->cnt_emp = $_chk->cnt_em;
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
													$__CntIn->cnt_fi = $_chk->cnt_fi;

													$__CntIn->plcy_id = $_chk->plcy_id;


													$__CntIn->demo = DEMO_CLSS;
													$__CntIn->bugs = BUGS_EST;

													$EcLsts_PrcDt = $__CntIn->InEcLstsCnt();

													//echo $this->h3('Result:'.print_r($EcLsts_PrcDt, true));

													$EcLsts_PrcDt_Lsts = $EcLsts_PrcDt->eml_all;


													if(	$EcLsts_PrcDt_Lsts->e1->e == 'ok' || $EcLsts_PrcDt_Lsts->e1->exst == 'ok' ||
														$EcLsts_PrcDt_Lsts->e2->e == 'ok' || $EcLsts_PrcDt_Lsts->e2->exst == 'ok' ||
														$EcLsts_PrcDt_Lsts->e3->e == 'ok' || $EcLsts_PrcDt_Lsts->e3->exst == 'ok'){

														$_EcLsts_Int_upd=1;
														$_EcLsts_Est_upd = $_chk->Upd_Rw(); // Enabled


														while (($_EcLsts_Est_upd->e != 'ok') && ($_EcLsts_Int_upd < 5)){
															//sleep(5);
															$_EcLsts_Est_upd = $_chk->Upd_Rw();
															$_EcLsts_Int_upd++;
														}

														if($_EcLsts_Est_upd->e == 'ok'){ $_EcLsts_Upd = 'ok'; }

													}elseif($EcLsts_PrcDt->i == NULL){

														$EcLsts_PrcDt_u = ['w'=>$EcLsts_PrcDt->w];
														$_chk->Upd_Rw_W( $EcLsts_PrcDt_u );
														$_EcLsts_Upd = 'no';

													}else{

														$_EcLsts_Upd = '-no-';

													}

													$_chk->hb_w_all .= $EcLsts_PrcDt->w.' '.$EcLsts_PrcDt->w_all;
													$_chk->hb_u_all .= $EcLsts_PrcDt->u_all;


												}elseif($___exist->e == 'ok'){

													$__up_frce = $_chk->Upd_Rw();

													if($__up_frce->e == 'ok'){
														$_out .= $this->err(' Existe, entonces se marca en 1 ');
														$_chk->hb = 'ok';
														$_chk->hb_w_all = '';
													}

												}


												if(!isN($_chk->hb_w_all)){
													$_out .= $this->err('Errores('.$_EcLsts_Upd.'):'.compress_code(print_r($_chk->hb_w_all, true)));
													$_out .= $this->err( compress_code( print_r($EcLsts_PrcDt, true) ) );
												}

												$_out .= $this->h3( $this->Spn('Output:').$this->br().$_chk->hb_u_all );

												//if(($_chk->hb == 'no' || $EcLsts_PrcDt->e == 'no') || (DEMO_CLSS == true)){
													echo $this->h1(	$row_UpEcLsts_Rcrds_Rg['upcol_up'].'-> Row '.
																	$row_UpEcLsts_Rcrds_Rg['id_upcol'].
																	$this->ul( $_out )
																);
												//}
												//if($_EcLsts_Upd != 'ok'){ break; }

											}

											$__Up->_InUpRow_Rd(['id'=>$row_UpEcLsts_Rcrds_Rg['id_upcol']]);

										}catch(Exception $e){

											echo $this->err('Error: '.$e->getMessage());
											$__Up->_InUpRow_Rd(['id'=>$row_UpEcLsts_Rcrds_Rg['id_upcol']]);

										}

									}

								} while ($row_UpEcLsts_Rcrds_Rg = $UpEcLsts_Rcrds_Rg->fetch_assoc());

							}else{

								echo $this->err( 'No records on '.compress_code($UpEcLsts_Rcrds_Qry) );

							}

							if(!isN( $UpEcLsts_Rcrds_Rg )){ $__cnx->_clsr($UpEcLsts_Rcrds_Rg); }

							$__Up->_InUp_Rd(['id'=>$__eclsts_up_id ]);


						}catch(Exception $e){

							echo $this->err( $e->getMessage() );

							if(!isN($__eclsts_up_id)){ $__Up->_InUp_Rd(['id'=>$__eclsts_up_id ]); }

						}

					} while ($row_UpEcLsts_Rg = $UpEcLsts_Rg->fetch_assoc());


				}else{

					echo $this->h2($row_UpEcLsts_Rcrds_Rg['upcol_up'].' No records tu upload');

				}

			}else{

				echo $this->err($__cnx->c_r->error);

			}



			$__cnx->_clsr($UpEcLsts_Rg);



		}else{

			echo $this->h1('Upload '.$this->Spn('Listas Email - Run On Next'), 'Auto_Tme_Prg');

		}

	}

}else{

	echo $this->nallw('Global Monitor Upload - Listas Email - Off');

}

?>