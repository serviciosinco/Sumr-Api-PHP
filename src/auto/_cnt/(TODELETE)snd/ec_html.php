<?php

if($this->g__s3 == 'cmpg'){ $_allow_key='snd_ec_cmpg_html'; }else{ $_allow_key='snd_ec_html';  }

$_g_alw = $this->tallw([ 't'=>'key', 'id'=> $_allow_key ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		//------------------- Basic Parameters ---------------------//

			$this->__btch_id = Gn_Rnd(20);
			$__i = $this->g__i;

			if($this->g__s3 == 'cmpg'){
				echo $this->h1('CREACION DE PUSHMAIL HTML - CAMPANAS');
			}else{
				echo $this->h1('CREACION DE PUSHMAIL HTML');
			}

			define('GL_SND_HTML', 'html/'); // Actions
			define('UNLCK_MIN', '1'); // Minutes Wait Unlock

		//------------------- Start ---------------------//


		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=> $_allow_key, 'cl'=>$_cl_v->id ])->est == 'ok' ){

					//-------------------- AUTO TIME CHECK - START --------------------//

						$__ec = new API_CRM_ec([ 'argv'=>$__argv, 'cl'=>$_cl_v->id ]);
						$__qry_innr = '';
						$__cmpg_fltr = '';

						if($this->g__s3 == 'cmpg'){ $__rqu_tp='ec_snd_cmpg_html'; }else{ $__rqu_tp='ec_snd_html';  }

						$_AUTOP_d = $this->RquDt([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'm'=>1 ]);
						//$_AUTOP_d->e = 'ok';
						//$_AUTOP_d->lck = 'no';

					//-------------------- AUTO TIME CHECK - END --------------------//


					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 5){

						try {

							if($_g_alw->lmt){
								$_qry_lmt = $_g_alw->lmt;
							}elseif($this->g__s3 == 'cmpg_snd'){
								$_qry_lmt = '5000';
							}elseif(!isN($this->g__lmt)){
								$_qry_lmt = $this->g__lmt;
							}elseif(defined('EC_SND_MAX') && !isN(EC_SND_MAX)){
								$_qry_lmt = EC_SND_MAX;
							}else{
								$_qry_lmt = '100';
							}

							echo $this->h2($_AUTOP_d->e.' - '.$_cl_v->nm.' habilitado? '.$_AUTOP_d->hb.' lock? '.$_AUTOP_d->lck.' m_lck'.$_AUTOP_d->m_lck, '', '_check');

							//---------- Lock Account While Check Result On Read Mode ----------//

							$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>1 ]);

							echo $this->h2( 'Result of lock all query: '.$___lck->e );

							if($this->g__s3 == 'old'){
								$____old = " AND (ecsnd_id IS NULL || ecsnd_id = '') ";
							}else{
								//$____old = " AND ecsnd_f > '2019-09-08' ";
							}
							//echo compress_code('------:'.$____old).PHP_EOL; break;
							//---------- Filter Campaign ----------//

								$_orby = 'ecsnd_f, ecsnd_h ASC';
								include(GL_SND_EC.'ec_html_cmpg.php');

							//---------- Start Query Execution ----------//

							$___otprcs = [];
							$___datprcs = [];

							if($___lck->e == 'ok'){

								if(isN($__cmpg_to_work_id)){
									$__reldata = 'ok';
								}else{
									$__reldata = NULL;
								}

								$EcHtmlQry = "	SELECT 	id_ecsnd,
														ecsnd_enc,
														ecsnd_ec,
														ecsnd_eml,
														ecsnd_est,
														ecsnd_plcy_id
														{$__qry_slc}

												FROM "._BdStr($_cl_v->bd).TB_EC_SND."
													INNER JOIN "._BdStr(DBM).TB_US." ON ecsnd_snd = id_us
													/*INNER JOIN "._BdStr($_cl_v->bd).TB_CNT." ON ecsnd_cnt = id_cnt*/
													{$__qry_innr}

												WHERE
														/*
														(ecsnd_html_btch IS NULL || ecsnd_html_rd_f < NOW() - INTERVAL ".UNLCK_MIN." MINUTE) AND
														(ecsnd_html_rd = 2 || ecsnd_html_rd_f < NOW() - INTERVAL ".UNLCK_MIN." MINUTE ) AND
														*/

														ecsnd_html = 2 AND

														(
															ecsnd_est = "._CId('ID_SNDEST_PRG')." ||
															ecsnd_est = "._CId('ID_SNDEST_SND')."
														)

														{$____old}
														{$__cmpg_fltr}

												ORDER BY {$_orby}
												LIMIT {$_qry_lmt}";


								echo $this->h1('$EcHtmlQry').compress_code($EcHtmlQry);
								//exit();

								$EcHtml = $__cnx->_qry($EcHtmlQry, ['cmps'=>'ok'] );

								if($EcHtml){

									$rwEcHtml = $EcHtml->fetch_assoc();
									$TotEcHtml = $EcHtml->num_rows;

									//echo $this->li($TotEcHtml.' registros');

									if($TotEcHtml > 0){

										//---------- Instance EC Class ----------//


										echo $this->li('MACHINE_WRKR:'.MACHINE_WRKR);
										echo $this->li('Start ApiCRMEc Instance');
										echo $this->li('Max Execution Time '.$this->___getmxexc );
										echo $this->li('ApiCRMEc Instanced NOW');

										//---------- Get all Id For Read Mode Markup ----------//

										do{

											try {

												echo $this->li('Lock Before to ID '.$rwEcHtml['id_ecsnd']);

												$___otprcs[] = $rwEcHtml['id_ecsnd'];
												$___datprcs[] = $rwEcHtml;

											} catch (Exception $e) {

												$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
												echo $this->err($e->getMessage());

											}

										} while ($rwEcHtml = $EcHtml->fetch_assoc());

									}else{

										//echo $this->li( 'Qry-> '.compress_code($EcHtmlQry) );
										$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);

									}

								}else{

									$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									echo $this->err('PROBLEM QUERY '.$__cnx->c_r->error);
									echo $this->li( compress_code($EcHtmlQry) );

								}

								$__cnx->_clsr($EcHtml);

								if(!isN( $___otprcs )){

									$__snd_lock_qry = $this->__snd_ec_btch([ 't'=>'html', 'bd'=>$_cl_v->bd, 'ids'=>$___otprcs, 'btch'=>$this->__btch_id ]);

									//---------- Release Query For This Customer ----------//

										if(!isN( $__snd_lock_qry->w )){
											echo $this->err('Unlock Query '.$__snd_lock_qry->qry);
											echo $this->err('Ids '.print_r($___otprcs, true) );
											echo $this->err('Now '.$__snd_lock_qry->e);
											echo $this->err('error:'.$__snd_lock_qry->w);
										}

										$___unlck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);

									//---------- Lock All Records On This Query Result ----------//

								}

								if(!isN( $___datprcs ) && count($___datprcs) > 0){

									if($__snd_lock_qry->e == 'ok' && $___unlck->e == 'ok'){

										echo $this->h3('$___lck dislock query ');

										foreach($___datprcs as $___datprcs_k=>$___datprcs_v){
											include(GL_SND_HTML.'build.php');
										}

									}

								}

							}

						} catch (Exception $e) {

							$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);

							echo $this->err($e->getMessage());

						}


						$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);

					}else{

						echo $this->nallw(' $_AUTOP_d->e off '.$_cl_v->nm);

					}

				}else{

					echo $this->nallw(' Envios Masivos - Html Builder - Off - '.$_cl_v->nm);

				}

			}

		}


		$this->__btch_id = NULL;

	}


}else{

	echo $this->nallw('Global Envios Masivos - Html Builder - Off');

}

?>