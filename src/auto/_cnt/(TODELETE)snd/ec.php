<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_ec' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		//------------------- Basic Parameters ---------------------//

		$this->__btch_id = Gn_Rnd(20);

		if($this->g__s3 == 'cmpg_snd'){
			echo $this->h1('(NEW) ENVIO DE CAMPANA');
		}else{
			echo $this->h1('(NEW) ENVIO DE PUSHMAIL');
		}

		define('GL_SND_EC', 'ec/'); // Actions

		//------------------- Start ---------------------//

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_ec', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					//-------------------- AUTO TIME CHECK - START --------------------//

						$___otprcs = [];
						$___datprcs = [];
						$__cmpg_fltr = '';
						$__cmpg_to_work_id = '';

						if($this->g__s3 == 'cmpg_snd'){ $__rqu_tp='snd_cmpg'; $__rqu_tt='Campaña'; }else{ $__rqu_tp='snd_ec'; $__rqu_tt='Pushmail'; }

						$_AUTOP_d = $this->RquDt([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'm'=>1 ]);
						//$_AUTOP_d->e = 'ok';
						//$_AUTOP_d->lck = 'no';
						echo $this->h2($_AUTOP_d->e.' - '.$_cl_v->nm.' - lock? '.$_AUTOP_d->lck, '', '_check');

					//-------------------- AUTO TIME CHECK - END --------------------//

					if($_AUTOP_d->e == 'ok' && ($_AUTOP_d->lck != 'ok' || $_AUTOP_d->hb == 'ok' )){

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

							if($this->g__s3 == 'cmpg_snd'){
								$_qry_lmt = '5000'; //5000
							}elseif(!isN($this->g__lmt)){
								$_qry_lmt = $this->g__lmt;
							}elseif(defined('EC_SND_MAX') && !isN(EC_SND_MAX)){
								$_qry_lmt = EC_SND_MAX;
							}else{
								$_qry_lmt = '100';
							}

							if($this->g__rnd == 'ok'){ $__ordby = 'RAND()'; }else{ $__ordby = 'ecsnd_prty ASC, id_ecsnd DESC '; }

							$__cmpg_fltr = '';

							//---------- Filter Campaign - Search for some to work with ----------//

								if($this->g__s3 == 'cmpg_snd'){
									echo $this->h3('Search for campaign to work with');
									require(GL_SND_EC.'cmpg_filter.php');
								}else{
									$__snd_vw = VW_EC_SND;
								}

							//---------- Start Query Execution ----------//

							$EcSndQry = "SELECT id_ecsnd,
												ecsnd_enc,
												ecsnd_ec,
												ecsnd_eml,
												ecsnd_test,
												ecsnd_rply_nm,
												ecsnd_rply_eml,
												ecsnd_sbj,
												ecsnd_cleml,
												ecsnd_plcy_id,
												cnt_test,
												ecsnd_id AS sndcid,
												( ecsnd_rd_f < NOW() - INTERVAL 3 MINUTE ) AS __rd_aft
												{$__cmpg_slc}

										FROM "._BdStr($_cl_v->bd).$__snd_vw."
										WHERE 	(ecsnd_btch IS NULL || ecsnd_rd_f < NOW() - INTERVAL 3 MINUTE) AND
												ecsnd_est = "._CId('ID_SNDEST_PRG')." AND
												(ecsnd_rd = 2 || ecsnd_rd_f < NOW() - INTERVAL 3 MINUTE ) AND
												CONCAT(ecsnd_f,' ',ecsnd_h) < NOW() {$_qry_f}
												{$__cmpg_fltr}
										HAVING 	(sndcid IS NULL || sndcid = '')
										ORDER BY {$__ordby}
										LIMIT $_qry_lmt";

							//---------- Lock Account While Check Result On Read Mode ----------//

							$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>1 ]);

							echo $this->h3('Lock '.$_cl_v->nm.' / e:'.$___lck->e);

							if($___lck->e == 'ok' && !isN($EcSndQry) && !isN($__snd_vw)){

								echo $this->li( compress_code($EcSndQry) );

								$__snd_lock_qry = 'no';

								$EcSnd = $__cnx->_prc($EcSndQry); //Read main database, no problems with lag AWS

								//$EcSnd = $__cnx->_qry($EcSndQry);

								if($EcSnd){
									$rwEcSnd = $EcSnd->fetch_assoc();
									$TotEcSnd = $EcSnd->num_rows;
									echo $this->h3($this->ttFgr($_cl_v).$TotEcSnd.' envios a '.$_cl_v->nm.' (QRY LIMIT '.$_qry_lmt.') ');
								}else{
									$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									echo $this->err($__cnx->c_r->error /*. ' on '.$EcSndQry*/);
									$__cnx->_clsr($EcSnd);
								}

								if($TotEcSnd > 0){

									//---------- Instance EC Class ----------//

									$__ec = new API_CRM_ec([ 'argv'=>$__argv, 'cl'=>$_cl_v->id ]);

									//---------- Campaign Id ----------//


									if(!isN($__cmpg_to_work_id)){

										$___lck_cmpg = $this->RquDt([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'id'=>$__cmpg_to_work_id, 'm'=>1 ]);

										$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);

										if($___lck->e == 'ok' && $___lck->lck == 'ok'){
											continue;
										}

									}

									$TotEcSnd_Snd=0;

									//---------- Get all Id For Read Mode Markup ----------//

									do{

										try {
											echo $this->li('Lock Before to ID '.$rwEcSnd['id_ecsnd'].(!isN($rwEcSnd['__idcmpg']) ? ' on campaign:'.$rwEcSnd['__idcmpg']:''));
											$___otprcs[] = $rwEcSnd['id_ecsnd'];
											$___datprcs[] = $rwEcSnd;
										} catch (Exception $e) {
											$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
											echo $this->err($e->getMessage());
										}

									} while ($rwEcSnd = $EcSnd->fetch_assoc());


									//---------- Free Query ----------//


										$__cnx->_clsr($EcSnd);

										$__snd_lock_qry = $this->__snd_ec_btch([ 'bd'=>$_cl_v->bd, 'ids'=>$___otprcs, 'btch'=>$this->__btch_id ]);

										echo $this->h3('Unlock Query Now '.$__snd_lock_qry->e);

										$___unlck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);

										if($___unlck->e == 'ok'){
											echo $this->scss('Unlocked all account');
										}


									//---------- Lock All Records On This Query Result ----------//


										if($__snd_lock_qry->e == 'ok' && $___unlck->e == 'ok'){


											//---------- Release Query For This Customer ----------//


											if(!isN($__cmpg_to_work_id)){

												$__rd_cmpg_p = $this->EcCmpg_Rd();

												echo $this->h3('Unlock campaign now '.$__cmpg_to_work_id);
												$___lck_cmpg = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'id'=>$__cmpg_to_work_id, 'lck'=>2 ]);

												if($___lck_cmpg->e == 'ok'){
													echo $this->scss('Unlocked campaign '.$__cmpg_to_work_id);
												}else{
													echo $this->err('No Unlocked campaign '.$__cmpg_to_work_id);
												}

											}else{

												echo $this->h3('No campaign to work with');

											}


											echo $this->h3('$___lck dislock query ');

											//---------- Start to Send Emails ----------//

											if(!isN($__cmpg_to_work_id)){
												require(GL_SND_EC.'c_start.php');
											}else{
												require(GL_SND_EC.'s_start.php');
											}

											echo $this->h3('A enviar ('.$TotEcSnd.') - enviados '.$TotEcSnd_Snd.' envios de '.$_cl_v->sbd);

										}else{

											echo $this->err('Problem on __snd_lock_qry e:'.$__snd_lock_qry->e.' error:'.$__snd_lock_qry->w);

										}

								}else{

									$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									echo $this->h3('0 records and $___lck dislock query ');

								}

							}else{

								$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
								echo $this->err($__rqu_tt.' send for client '.$_cl_v->nm.' can not locked');

							}

							if(!isN($__cmpg_to_work_id) && $__rd_cmpg_p->e == 'ok' && $this->g__s3 == 'cmpg_snd'){

								$__rd_cmpg_p = $this->EcCmpg_Rd();

								if($__rd_cmpg_p->e == 'ok'){

									echo $this->h3('Dislock Campaign '.$__cmpg_to_work_id.' To Process');

								}

							}

						} //----------- END CHECK CLIENT ALLOWED -----------//

					}else{

						echo $this->h3($__rqu_tt.' send for client '.$_cl_v->nm. ' on read mode '.print_r($_AUTOP_d, true), '', '_onread');

					}

				}else{

					echo $this->nallw($_cl_v->nm.' Envios Masivos - Enviar Pushmail - Off');

				}

			}

		}

		$this->__btch_id = NULL;

	}else{

		echo $this->h1('ENVIO DE PUSHMAIL NOT ALLOW');

	}

}else{

	echo $this->nallw('Global Envios Masivos - Enviar Pushmail - Off');

}

?>