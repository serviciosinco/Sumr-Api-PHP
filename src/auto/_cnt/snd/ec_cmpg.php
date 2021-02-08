<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_ec_cmpg' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		$__btch_id = Gn_Rnd(20);

		$this->btch_id = $__btch_id;

		$this->_RTme([ 'start'=>'ok' ]);

		echo $this->h1('ENVIO CAMPAÑAS EMAIL', '_cmpg');

		define('GL_SND_EC', 'ec/'); // Actions
		define('GL_SND_CMPG', 'cmpg/'); // Actions

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_ec_cmpg', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					//-------------------- AUTO TIME CHECK - START --------------------//

						$_AUTOP_d = $this->RquDt([ 't'=>'ec_cmpg', 'cl'=>$_cl_v->id, 'm'=>1 ]);
						echo $this->h2($_cl_v->nm.' lock? '.$_AUTOP_d->lck, '', '_check');
						$_AUTOP_d->e = 'ok';
						$_AUTOP_d->lck = 'no';

					//-------------------- AUTO TIME CHECK - END --------------------//


					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 15){

						try {

							$_ec_snd = new API_CRM_ec([ 'cl'=>$_cl_v->id ]);

							$___lck = $this->Rqu([ 't'=>'ec_cmpg', 'cl'=>$_cl_v->id, 'lck'=>1 ]);

							$__cmpg_to_work_id = '';
							$___datprcs = [];
							$__fl = '';

							$_li = '';
							$_li_f = '';

							if(defined('DB_CL_ENC')){
								if(DB_CL_ENC != $_cl_v->enc){
									$__cl_rqu='no';
								}else{
									$__cl_rqu = 'ok';
								}
							}else{
								$__cl_rqu = 'ok';
							}

							echo $this->h2('Check $__cl_rqu is ok? => '.$__cl_rqu, '', '_check');

							if($__cl_rqu == 'ok'){ //----------- CHECK CLIENT ALLOWED -----------//


								//---------- Filter Campaign ----------//

									require(GL_SND_CMPG.'grndm.php');

								//---------- Start Query Execution ----------//


								//if(!isN($__cmpg_to_work_id)){

									//---------- Filter Id Campaign ----------//


									if(!isN($__cmpg_to_work_id)){
										$__fl .= " AND id_eccmpg = '".$__cmpg_to_work_id."' ";
									}

									//if($__rd_cmpg_p->e == 'ok'){

										$Ls_Cmpg_Qry = "

														SELECT id_eccmpg, eccmpg_us, eccmpg_nm, eccmpg_p_f, eccmpg_p_h
														FROM "._BdStr(DBM).TB_EC_CMPG."
														WHERE /*CONCAT(eccmpg_p_f,' ',eccmpg_p_h) < NOW() AND*/

															(eccmpg_rd = 2 || eccmpg_rd_f < NOW() - INTERVAL 3 MINUTE ) AND
															(
																(
																	eccmpg_est = '"._CId('ID_ECCMPGEST_APRBD')."' /*OR
																	eccmpg_est != '"._CId('ID_ECCMPGEST_SND')."'*/
																) AND
																eccmpg_est != '"._CId('ID_ECCMPGEST_PSD')."'
															) AND
															eccmpg_sndr = '"._CId('ID_SISEML_SUMR')."' AND
															eccmpg_cl = '".$_cl_v->id."' AND
															eccmpg_rdy = 2 AND

															id_eccmpg IN (
																	SELECT eccmpglsts_cmpg
																	FROM "._BdStr(DBM).TB_EC_CMPG_LSTS."
																	WHERE eccmpglsts_cmpg = id_eccmpg
															)

															{$__fl}

														ORDER BY eccmpg_p_f ASC, eccmpg_p_h ASC

														LIMIT 50

													";

										$Ls_Cmpg = $__cnx->_qry($Ls_Cmpg_Qry);

										//echo $this->h1( compress_code($Ls_Cmpg_Qry) );
									//}

									if($Ls_Cmpg){

										$row_Ls_Cmpg = $Ls_Cmpg->fetch_assoc();
										$Tot_Ls_Cmpg = $Ls_Cmpg->num_rows;

										echo $this->h3($this->ttFgr($_cl_v).$Tot_Ls_Cmpg.' campañas para enviar de '.$_cl_v->nm, '_cmpg');

										if($Tot_Ls_Cmpg > 0){

											do{

												try {

													$this->id_eccmpg = $row_Ls_Cmpg['id_eccmpg'];
													$__rd_cmpg_p = $this->EcCmpg_Rd([ 'e'=>'on' ]);

													$___datprcs[] = $row_Ls_Cmpg;
													echo $this->h3( 'Campaign '. $row_Ls_Cmpg['id_eccmpg'].' to process' );

												} catch (Exception $e) {

													$___lck = $this->Rqu([ 't'=>'ec_cmpg', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
													echo $this->err($e->getMessage());

												}

											} while ($row_Ls_Cmpg = $Ls_Cmpg->fetch_assoc());

										}

										//echo $this->br(3).h4('Procesadas ('.$Tot_Ls_Cmpg.') campañas');

									}else{

										echo $this->err( 'Error:' . $__cnx->c_r->error);

									}

									$__cnx->_clsr($Ls_Cmpg);

									echo $this->li('Close BD and CPU process '.count($___datprcs).' records' , '', '_check');

									if(!isN($___datprcs) && count($___datprcs) > 0){

										try {

											//---------- Free Query For This Customer ----------//

												$___lck = $this->Rqu([ 't'=>'ec_cmpg', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
												$__cnx->_clsr($Ls_Cmpg);

											//-------------------- SET READ CAMPAIGN STATUS --------------------//

												//$__rd_cmpg_p = $this->EcCmpg_Rd();

											//---------- Release Query For This Customer ----------//


											foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

												//----------- GET CAMPAIGN DETAIL -----------//

													$___l_eml = [];
													echo $this->h2('Getting data of campaign '.$___datprcs_v['id_eccmpg']);
													require(GL_SND_CMPG.'dt.php');

												//-------------------- FREE AUTO - START --------------------//

													$this->Rqu([ 't'=>'ec_cmpg', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

												//----------- DISPLAY CLIENT CAMPAIGNS -----------//

													$_li = '';

												//----------- IF IT EXISTS PROCESS -----------//

												if(!isN($_cmpg_dt->id)){

													echo $this->li( $this->h2( ctjTx($___datprcs_v['eccmpg_nm'], 'in') . ' con id:'. $___datprcs_v['id_eccmpg'] ) );

													//----------- UPDATE ALLOW LEADS TO SEND -----------//

														require(GL_SND_CMPG.'upd.php');

													//----------- GET CAMPAIGN DETAIL -----------//

													if(!isN($___datprcs_v['eccmpg_p_f']) && !isN($___datprcs_v['eccmpg_p_h'])){

														//----------- GET EMAILS ON LISTS OR SEGMENTS -----------//

														require(GL_SND_CMPG.'eml.php');

													}

												}


												$_li_f .= $this->li( $this->ul( $_li, 'Ls_Cmpg_Sb', '', ['n'=>2]), '', [ 'sb'=>'ok' ] );

												$__rd_cmpg_p = $this->EcCmpg_Rd();

											}

											echo $this->ul( $_li_f, 'Ls_Cmpg');

										} catch (Exception $e) {


											$__rd_cmpg_p = $this->EcCmpg_Rd();

											$___lck = $this->Rqu([ 't'=>'ec_cmpg', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

											echo $this->err($e->getMessage());

										}

									}

								//}

							}


							$___lck = $this->Rqu([ 't'=>'ec_cmpg', 'cl'=>$_cl_v->id, 'lck'=>2 ]);



						} catch (Exception $e) {

							$___lck = $this->Rqu([ 't'=>'ec_cmpg', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

							echo $this->err($e->getMessage());

						}


					}

				}else{

					echo $this->nallw($_cl_v->nm.' Envios Masivos - Campañas - Off');

				}

			}

		}

	}else{

		echo $this->err('AUTO_CMPG_EC:off');

	}

}else{

	echo $this->nallw('Global Envios Masivos - Campañas - Off');

}

?>