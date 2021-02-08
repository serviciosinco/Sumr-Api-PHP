<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_sms' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx') && defined('AUTO_SND_SMS') && AUTO_SND_SMS == 'on'){

		$__btch_id = Gn_Rnd(20);

		echo $this->h1('ENVIO DE SMS');

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_sms', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					if(defined('DB_CL_ENC')){
						if(DB_CL_ENC != $_cl_v->enc){
							$__cl_rqu='no';
						}else{
							$__cl_rqu = 'ok';
						}
					}else{
						$__cl_rqu = 'ok';
					}

					if($__cl_rqu == 'ok'){ //----------- CHECK CLIENT ALLOWED -----------//

						if(!isN($this->g__lmt)){ $_qry_lmt = $this->g__lmt; }else{ $_qry_lmt = '50'; }
						if(!isN($this->g__i)){ $_qry_f = ' AND id_smssnd = '.GtSQLVlStr($this->g__i, "int").' '; }

						$LsSmsQry = "SELECT *,

											( smssnd_rd_f < NOW() - INTERVAL 15 MINUTE ) AS __rd_aft,

											(	SELECT mdlcntsms_mdlcnt
												FROM ".$_cl_v->bd.".".TB_MDL_CNT_SMS."
												WHERE mdlcntsms_smssnd = id_smssnd
												LIMIT 1
											) AS __mdlcnt,

											(	SELECT smssndcmpg_cmpg
												FROM ".$_cl_v->bd.".".TB_SMS_SND_CMPG."
												WHERE smssndcmpg_snd = id_smssnd
												LIMIT 1
											) AS __idcmpg,

											(	SELECT id_cntdvrf
												FROM ".$_cl_v->bd.".".TB_CNT_DVRF."
												WHERE cntdvrf_tel_snd = id_smssnd
												LIMIT 1
											) AS __iddvrf

									FROM ".$_cl_v->bd.".".TB_SMS_SND."
											INNER JOIN "._BdStr(DBM).TB_US." ON smssnd_snd = id_us
											INNER JOIN ".$_cl_v->bd.".".TB_CNT." ON smssnd_cnt = id_cnt
									WHERE smssnd_est = "._CId('ID_SNDEST_PRG')." AND
											(smssnd_rd = 2 || smssnd_rd_f < NOW() - INTERVAL 15 MINUTE ) AND
											CONCAT(smssnd_f,' ',smssnd_h) < NOW() {$_qry_f}
									ORDER BY smssnd_prty ASC, id_smssnd DESC
									LIMIT $_qry_lmt ";

						//echo compress_code( $LsSmsQry );

						$LsSms = $__cnx->_qry($LsSmsQry);

						if($LsSms){

							$row_LsSms = $LsSms->fetch_assoc();
							$Tot_LsSms = $LsSms->num_rows;

							echo $this->h2($this->ttFgr($_cl_v).$Tot_LsSms.' envios a '.$_cl_v->nm);

							if($Tot_LsSms > 0){

								do{

									$__dtsms = '';

									try {

										//sleep(5);

										//----------------------- PUSHMAIL DETAILS -----------------------//


											$__dtsms = GtSmsDt([ 'id'=>$row_LsSms['smssnd_sms'], 't'=>'id' ]);


										//----------------------- DOUBLE VERIFICATION DETAILS -----------------------//

											if(!isN($row_LsSms['__iddvrf'])){
												$__dvrf_dt = GtCntDvrfDt([ 'id'=>$row_LsSms['__iddvrf'], 'bd'=>$_cl_v->bd ]);
												$__rlc_dvrf = $__dvrf_dt->id;
											}else{
												$__dvrf_dt = '';
												$__rlc_dvrf = '';
											}

										//----------------------- CAMPAIGN DETAILS -----------------------//

											if(!isN($row_LsSms['__idcmpg'])){
												//$__cmpg_dt = GtSmsCmpgDt([ 'id'=>$row_LsSms['__idcmpg'], 'bd'=>$_cl_v->bd ]);
											}else{
												$__cmpg_dt = '';
											}

											$__c_tel = $row_LsSms['smssnd_cel'];
											$__snd_pxl = $row_LsSms['smssnd_enc'];
											$__rlc_mdlc = $row_LsSms['__mdlcnt'];

										//----------------------- NOT ALLOWED SEND BY DEFAULT - CHECK STATUS FOR ALLOW-----------------------//


											$___allw_snd = 'no';

											if($row_LsSms['smssnd_test'] == 1){
												$___allw_snd = 'ok'; $___allw_snd_m .= 'It is a test';
											}

											if($__cmpg_dt->est->id == _CId('ID_SMSCMPGEST_SNDIN')){
												$___allw_snd = 'ok'; $___allw_snd_m .= 'Campaign in sending status';
											}else{
												$___allw_snd_m .= 'Cmapaign (SMSCMPG-'.$__cmpg_dt->id.') in other status instead of sending';
											}

											if(isN($__cmpg_dt->id)){
												$___allw_snd = 'ok'; $___allw_snd_m .= 'Campaign is null';
											}

											if(Dvlpr() && mBln($row_LsSms['cnt_test']) == 'no'){
												$___allw_snd = 'no'; $___allw_snd_m .= 'Is developer and not a test';
											}



										//----------------------- SEND ALLOWED ? -----------------------//


										if($___allw_snd == 'ok'){


											$this->id_smssnd = $row_LsSms['id_smssnd'];

											$___chk = $this->SmsSnd_Chk([ 'bd'=>$_cl_v->bd ]);

											if(

												$___chk->e == 'ok' &&
												($___chk->rd != 'ok' || $row_LsSms['__rd_aft'] ) &&
												( isN($___chk->btch) || $row_LsSms['__rd_aft'] )

											){

												$__rd_p = $this->SmsSnd_Rd(['e'=>'on', 'bd'=>$_cl_v->bd, 'btch'=>$__btch_id]);

												try {


													if($__rd_p->e == 'ok' && !isN($__rd_p->btch) && $__rd_p->btch == $__btch_id){

														$__sms = new API_CRM_sms([ 'cl'=>$_cl_v->id ]);
														$__sms->id = $__dtsms->enc;
														$__sms->id_t = 'enc';

														if(!isN($__rlc_mdlc)){ $__sms->mdlc = $__rlc_mdlc; }
														if(!isN($__rlc_dvrf)){ $__sms->dvrf = $__rlc_dvrf; }

														$__us_msj = $__sms->_bld();
														$this->msj = $__us_msj;


														//------------ ENVIO EL CORREO ------------/

														if(!isN($__us_msj) && !isN($__dtsms->msj) && !isN($__c_tel)){


															if($__dtsms->cl->id == $_cl_v->id || $__dtsms->frm->id == _CId('ID_SISSMSFRM_SIS')){

																$this->_aws->us_to = $__c_tel;
																$this->_aws->us_msj = $__us_msj;

																$___chk_again = $this->SmsSnd_Chk([ 'bd'=>$_cl_v->bd ]);

																if($___chk_again->e == 'ok' && $___chk_again->rd == 'ok' && $___chk_again->btch == $__btch_id){

																	$_rsl_snd = $this->_aws->_sms_snd();
																	//echo $this->h3('$_rsl_snd:'.print_r($_rsl_snd, true));

																	if($_rsl_snd->e == 'ok'){
																		$Tot_LsSms_Snd++;
																	}


																}

															}else{

																echo $this->h3('Id template not same');

															}

														}else{

															echo $this->h3('No hay mensaje');

														}

														if($_rsl_snd->e == 'ok'){

															$__snd_e = $this->SmsSnd_Upd([ 'bd'=>$_cl_v->bd ]);

															$this->SmsSnd_Rd([ 'bd'=>$_cl_v->bd ]);

															$__sms = new API_CRM_sms([ 'cl'=>$_cl_v->id ]);

															$__rsl_sms = $__sms->_SndSms_UPD([
																				'enc'=>$row_LsSms['smssnd_enc'],
																				'snd_id'=>$_rsl_snd->id,
																				'msj'=>$__us_msj
																		]);

															//print_r($__rsl_sms);

														}else{

															$this->SmsSnd_Rd([ 'bd'=>$_cl_v->bd, 'btch_c'=>'ok' ]);
															//echo 'Error:'.print_r($_rsl_snd, true);

														}

													}else{

														echo $this->h2('Read Mode || No New Batch || No Same Batch', '_error');

													}


												} catch (Exception $e) {

													$this->SmsSnd_Rd([ 'bd'=>$_cl_v->bd, 'btch_c'=>'ok' ]);
													echo 'Excepción capturada on second level: ',  $e->getMessage(), "\n";

													//break;
												}

												$___chk = $this->SmsSnd_Chk([ 'bd'=>$_cl_v->bd ]);
												if($___chk->rd == 'ok'){ $this->SmsSnd_Rd([ 'bd'=>$_cl_v->bd, 'btch_c'=>'ok' ]); }
												//sleep(5);

											}else{

												echo $this->h2('Check Send Status ('.$___chk->e.') || Read ('.$___chk->rd.') || Is Null Batch ('.$___chk->btch.') or Read Date After 15 Minutes ('.$row_LsSms['__rd_aft'].')', '_error');

											}

										}else{

											//echo $this->h2('Campaign:'.print_r($__cmpg_dt->id, true) );
											echo $this->h2('Not allowed send'.$this->Spn($___allw_snd_m, 'ok'), '_error');

										}


									} catch (Exception $e) {

										/*
										echo 'Excepción capturada on first level: ',  $e->getMessage(), "\n";
										$__SndSMS = new API_CRM_sms();
										$__SndSMS->snd_cel = ADMIN_CEL;
										$__SndSMS->snd_msj = 'No mdlcesa AUTO '.pathinfo(__FILE__, PATHINFO_FILENAME).' '.$e->getMessage();
										$__SndSMS_r = $__SndSMS->_SndSMS();

										$this->SmsSnd_Rd([ 'bd'=>$_cl_v->bd, 'btch_c'=>'ok' ]);
										*/

										echo $this->err($e->getMessage());

										//break;

									}

								} while ($row_LsSms = $LsSms->fetch_assoc()); $LsSms->free;


								echo $this->h3('A enviar ('.$Tot_LsSms.') - enviados '.$Tot_LsSms_Snd.' envios de '.$_cl_v->sbd);

							}


						}else{

							echo $this->err($_cl_v->nm.' - '.$__cnx->c_r->error);

						}


						$__cnx->_clsr($LsSms);


					} //----------- END CHECK CLIENT ALLOWED -----------//

				}else{

					echo $this->nallw($_cl_v->nm.' Envios Masivos - SMS - Off');

				}

			}

		}


		$__btch_id = NULL;


	}else{

		echo $this->err('AUTO_SND_SMS:off');

	}

}else{

	echo $this->nallw('Global Envios Masivos - SMS - Off');

}


?>