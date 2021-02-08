<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_cl_flj' ]);


if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		$__btch_id = Gn_Rnd(20);

		echo $this->h1('ENVIO DE PUSHMAIL - CLIENTE FLUJO');

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_cl_flj', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					if(!isN($this->g__lmt)){ $_qry_lmt = $this->g__lmt; }else{ $_qry_lmt = '1'; }

					$Ls_ClFljSnd_Qry = "
										SELECT id_clfljsnd, clflj_cl, clfljsnd_enc, clfljsnd_ec, clfljsnd_emlortel, clfljsnd_html, clfljsnd_sbj,
												( clfljsnd_rd_f < NOW() - INTERVAL 10 MINUTE ) AS __rd_aft

										FROM "._BdStr(DBM).TB_CL_FLJ_SND."
												INNER JOIN "._BdStr(DBM).TB_CL_FLJ." ON clfljsnd_clflj = id_clflj
												INNER JOIN "._BdStr(DBM).TB_CL." ON clflj_cl = id_cl
												INNER JOIN "._BdStr(DBM).TB_US." ON clfljsnd_us = id_us

										WHERE 	clfljsnd_est = "._CId('ID_SNDEST_PRG')." AND
												(clfljsnd_rd = 2 || clfljsnd_rd_f < NOW() - INTERVAL 10 MINUTE ) AND
												CONCAT(clfljsnd_f,' ',clfljsnd_h) < NOW() AND
												cl_enc = '".$_cl_v->enc."'

										ORDER BY RAND() /*id_clfljsnd ASC */
										LIMIT $_qry_lmt "; //echo $this->li( compress_code($Ls_ClFljSnd_Qry) );

					$Ls_ClFljSnd = $__cnx->_qry($Ls_ClFljSnd_Qry);

					if($Ls_ClFljSnd){

						$row_Ls_ClFljSnd = $Ls_ClFljSnd->fetch_assoc();
						$Tot_Ls_ClFljSnd = $Ls_ClFljSnd->num_rows;

						echo $this->h2($this->ttFgr($_cl_v).$Tot_Ls_ClFljSnd.' envios a '.$_cl_v->nm);

						if($Tot_Ls_ClFljSnd > 0){


							$__sended = 0;


							do{

								$__dtec = '';

								try {

									//sleep(5);
									$__dtec = GtEcDt($row_Ls_ClFljSnd['clfljsnd_ec'], 'id');

									$__us_eml = $row_Ls_ClFljSnd['clfljsnd_emlortel'];
									$__snd_pxl = $row_Ls_ClFljSnd['clfljsnd_enc'];


									$this->id_clfljsnd = $row_Ls_ClFljSnd['id_clfljsnd'];


									$___chk = $this->ClFljSnd_Chk([ 'bd'=>$_cl_v->bd ]);

									echo $this->h1('$___chk:'.compress_code(print_r($___chk, true)));


									if(

										$___chk->e == 'ok' &&
										!isN($___chk->id) &&
										($___chk->rd != 'ok' || $row_Ls_ClFljSnd['__rd_aft'] ) &&
										( isN($___chk->btch) || $row_Ls_ClFljSnd['__rd_aft'] )

									){


										$__rd_p = $this->ClFljSnd_Rd([ 'e'=>'on', 'btch'=>$__btch_id ]);

										echo $this->h2('$__rd_p:'. compress_code( print_r($__rd_p, true) ));

										try {

											if(
												$__rd_p->e == 'ok' &&
												(
													(!isN($__rd_p->btch) && $__rd_p->btch == $__btch_id && !isN($__rd_p->id)) ||
													$row_Ls_ClFljSnd['__rd_aft']
												)
											){


												echo $this->h2('Now build message');


												$__us_msj = $row_Ls_ClFljSnd['clfljsnd_html'];

												$__us_as = ctjTx($row_Ls_ClFljSnd['clfljsnd_sbj'],'in');

												$this->msj = $__us_msj;

												//-------------------- ENVIO EL CORREO --------------------//

												if(!isN($__us_msj) && !isN($__dtec->cod) && !isN($__us_eml)){

													echo $this->h3('$__us_msj not empty on cl($_cl_v->id):'.$_cl_v->id);

													if($row_Ls_ClFljSnd['clflj_cl'] == $_cl_v->id){

														$__snd = new API_CRM_SndMail();

														$__snd->cl->id = $_cl_v->id;
														$__snd->from_n = $_cl_v->nm;
														$__snd->us_as = $__us_as;
														$__snd->us_to = $__us_eml;
														$__snd->us_msj = $__us_msj;
														$__snd->x_id = $__snd_pxl;
														$__snd->sndr->srv = 'aws';
														$__snd->sndr->id = 'sumr';
														$__snd->sndr->flj = 'cl';

														$___chk_again = $this->ClFljSnd_Chk([ 'bd'=>$_cl_v->bd ]);

														if(	$___chk_again->e == 'ok' &&
															$___chk_again->rd == 'ok' &&
															($___chk_again->btch == $__btch_id || $row_Ls_ClFljSnd['__rd_aft']) &&
															!isN($___chk_again->btch) &&
															!isN($__btch_id)){


																$_rsl_snd = $__snd->__SndMl();
																echo $this->h2(compress_code(print_r($_rsl_snd, true)));

																if($_rsl_snd->us_exito){
																	$__sended++;
																}else{
																	echo $this->err('$_rsl_snd:'.print_r($_rsl_snd, true));
																}

														}else{

															echo $this->err('$___chk_again:'.print_r($___chk_again, true));

														}

													}else{

														echo $this->err('Different clflj_cl');

													}

												}else{

													echo $this->err('No html | mail');

												}

												if($_rsl_snd->us_est == 'ok'){

													$this->clfljsnd_id = $_rsl_snd->us_id;
													$__snd_e = $this->ClFljSnd_Upd();
													$this->ClFljSnd_Rd();

												}else{

													$this->ClFljSnd_Rd();

												}
											}

										} catch (Exception $e) {

											$this->ClFljSnd_Rd();
											echo $this->err('Excepción capturada: '.  $e->getMessage());

											//break;
										}

										$this->ClFljSnd_Rd();
										//sleep(5);

									}else{

										echo $this->h2('Check Send Status ('.$___chk->e.') || Read ('.$___chk->rd.') || Is Null Batch ('.$___chk->btch.') or Read Date After 15 Minutes ('.$rwClFlj['__rd_aft'].')', '_error');

									}


								} catch (Exception $e) {



								}

							} while ($row_Ls_ClFljSnd = $Ls_ClFljSnd->fetch_assoc()); $Ls_ClFljSnd->free;

							echo $this->li('Enviados: '.$__sended.' envios de '.$_cl_v->sbd);

						}


					}else{

						echo $this->err($__cnx->c_r->error);

					}


					$__cnx->_clsr($Ls_ClFljSnd);

				}else{

					echo $this->nallw($_cl_v->nm.' Envios Masivos - Cliente - Flujo - Off');

				}

			}

		}


		$__btch_id = NULL;


	}


}else{

	echo $this->nallw('Global Envios Masivos - Cliente - Flujo - Off');

}



?>