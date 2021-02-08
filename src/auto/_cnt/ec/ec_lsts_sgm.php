<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'ec_lsts_sgm' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		define('GL_SND_EC_LSTS', 'ec_lsts/'); // Actions

		$__CntIn = new CRM_Cnt();

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'ec_lsts_sgm', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					//-------------------- AUTO TIME CHECK - START --------------------//

						$_AUTOP_d = $this->RquDt([ 't'=>'ec_lsts_sgm', 'cl'=>$_cl_v->id, 'm'=>5 ]);
						echo $this->h2($_cl_v->nm.' lock? '.$_AUTOP_d->lck, '', '_check');
						$_flt = '';

					//-------------------- AUTO TIME CHECK - END --------------------//


					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 15){

						$___datprcs = [];

						echo $this->h1($_cl_v->nm.' - Listas - Segmentos', '_lsts');

						if($this->g__i){ $_flt .= ' AND id_eclstssgm = \''.$this->g__i.'\' '; }

						$LstsSgmQry = "
										SELECT
											id_eclstssgm,
											id_eclsts,
											eclsts_nm,
											eclstssgm_nm,
											cl_sbd

										FROM "._BdStr(DBM).TB_EC_LSTS_SGM."
												INNER JOIN "._BdStr(DBM).TB_EC_LSTS." ON eclstssgm_lsts = id_eclsts
												INNER JOIN "._BdStr(DBM).TB_CL." ON eclsts_cl = id_cl
										WHERE 	eclsts_cl = '".$_cl_v->id."' AND
												(eclstssgm_rd = 2 || eclstssgm_rd_f < NOW() - INTERVAL 5 MINUTE )
												{$_flt}
										ORDER BY RAND()
										LIMIT 50
									";

						//echo $this->li( compress_code($LstsSgmQry) );
						$LstsSgm = $__cnx->_qry($LstsSgmQry);

						//-------------------- FREE AUTO - START --------------------//

							$this->Rqu([ 't'=>'ec_lsts_sgm', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

						//-------------------- IF QUERY RESULT --------------------//

						if($LstsSgm){

							$rwLstsSgm = $LstsSgm->fetch_assoc();
							$TotLstsSgm = $LstsSgm->num_rows;

							if($TotLstsSgm > 0){

								do{

									try {

										$this->id_eclstssgm = $rwLstsSgm['id_eclstssgm'];
										$__rd_eclstssgm_p = $this->EcLstsSgm_Rd([ 'e'=>'on' ]);

										echo $this->h3( 'Locked Segment:'.$this->id_eclstssgm.':'.$__rd_eclstssgm_p->e );

										if($__rd_eclstssgm_p->e == 'ok'){
											$___datprcs[] = $rwLstsSgm;
										}

									} catch (Exception $e) {

										$___lck = $this->Rqu([ 't'=>'ec_lsts_sgm', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
										echo $this->err($e->getMessage());

									}

								} while ($rwLstsSgm = $LstsSgm->fetch_assoc());

								//---------- Free Query For This Customer ----------//

									$this->Rqu([ 't'=>'ec_lsts_sgm', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									$__cnx->_clsr($LstsSgm);

								//---------- Release Query For This Customer ----------//

								foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

									//------- Calcilate Variables To Get Emails - Start -------//

										require(GL_SND_EC_LSTS.'ec_lsts_sgm_calc.php');

									//------- Try to Get Emails For Segment - End -------//

										require(GL_SND_EC_LSTS.'ec_lsts_sgm_eml.php');

									//------- Process List - End -------//

										$this->id_eclstssgm = $___datprcs_v['id_eclstssgm'];
										$__rd_eclstssgm_p = $this->EcLstsSgm_Rd();

								}


							}

						}else{

							echo $this->err($__cnx->c_r->error);

						}

						$__cnx->_clsr($LstsSgm);

					}

				}else{

					echo $this->nallw($_cl_v->nm.' Listas - Segmentos - Off');

				}

			}
		}

	}

}else{

	echo $this->nallw('Global Listas - Segmentos - Off');

}

?>