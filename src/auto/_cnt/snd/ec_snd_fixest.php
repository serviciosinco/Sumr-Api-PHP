<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_ec_snd_fixest' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		$__btch_id = Gn_Rnd(20);

		$this->btch_id = $__btch_id;

		$this->_RTme([ 'start'=>'ok' ]);

		echo $this->h1('CAMBIO STATUS EMAILS ENVIADOS SIN CAMBIO DE ESTADO', '_cmpg');

		define('GL_SND_EC', 'ec/'); // Actions

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_ec_snd_fixest', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					//-------------------- AUTO TIME CHECK - START --------------------//

						$_AUTOP_d = $this->RquDt([ 't'=>'ec_snd_fixest', 'cl'=>$_cl_v->id, 'm'=>1 ]);
						echo $this->h2($_cl_v->nm.' habilitado? '.$_AUTOP_d->hb, '', '_check');
						//$_AUTOP_d->e = 'ok';
						//$_AUTOP_d->lck = 'no';

					//-------------------- AUTO TIME CHECK - END --------------------//


					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 15){

						try {

							$_ec_snd = new API_CRM_ec([ 'cl'=>$_cl_v->id ]);
							$___lck = $this->Rqu([ 't'=>'ec_snd_fixest', 'cl'=>$_cl_v->id, 'lck'=>1 ]);


							$EcSndEst_Qry = "

											SELECT id_ecsnd, ecsnd_id
											FROM "._BdStr($_cl_v->bd).TB_EC_SND."
											WHERE ecsnd_est = '"._CId('ID_SNDEST_PRG')."' AND
												ecsnd_id IS NOT NULL AND
												ecsnd_id != ''
											ORDER BY id_ecsnd ASC
											LIMIT 50

										";

							echo $this->h3( compress_code($EcSndEst_Qry) );


							$EcSndEst = $__cnx->_qry($EcSndEst_Qry);

							if($EcSndEst){

								$rwEcSndEst = $EcSndEst->fetch_assoc();
								$TotEcSndEst = $EcSndEst->num_rows;

								echo $this->h3($this->ttFgr($_cl_v).$TotEcSndEst.' envios para cambiar de estado '.$_cl_v->nm, '_cmpg');


								if($TotEcSndEst > 0){

									do{

										if(!isN($rwEcSndEst['ecsnd_id'])){

											echo $this->h1( $rwEcSndEst['id_ecsnd'].' : '.$rwEcSndEst['ecsnd_id'] );

											$this->id_ecsnd = $rwEcSndEst['id_ecsnd'];
											$__snd_e = $this->EcSnd_Upd([ 'bd'=>$_cl_v->bd ]);

											if($__snd_e->e == 'ok'){

												echo $this->scss('Cambiado exitosamente');

											}

										}

									} while ($rwEcSndEst = $EcSndEst->fetch_assoc());

								}

							}else{

								echo $this->err($__cnx->c_r->error);

							}

							$__cnx->_clsr($EcSndEst);


							$___lck = $this->Rqu([ 't'=>'ec_snd_fixest', 'cl'=>$_cl_v->id, 'lck'=>2 ]);


						} catch (Exception $e) {

							$___lck = $this->Rqu([ 't'=>'ec_snd_fixest', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

							echo $this->err($e->getMessage());

						}


					}

					echo $this->br(1);

				}else{

					echo $this->nallw($_cl_v->nm.' Envios Masivos - Fix Status Sended - Off');

				}

			}

		}

	}

}else{

	echo $this->nallw('Global Envios Masivos - Fix Status Sended - Off');

}


?>