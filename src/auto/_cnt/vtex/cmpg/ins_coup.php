<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=> 'vtex_ins_coup' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=> 'vtex_ins_coup', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					//-------------------- AUTO TIME CHECK - START --------------------//

						$_AUTOP_d = $this->RquDt([ 't'=>'vtex_ins_coup', 'cl'=>$_cl_v->id, 's'=>10 ]);

					//-------------------- AUTO TIME CHECK - END --------------------//

					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 5 || $_AUTOP_d->hb == 'ok'){

						try {

							echo $this->h2($_AUTOP_d->e.' - '.$_cl_v->nm.' habilitado? '.$_AUTOP_d->hb.' lock? '.$_AUTOP_d->lck.' m_lck'.$_AUTOP_d->m_lck, '', '_check');

							//---------- Lock Account While Check Result On Read Mode ----------//

							$___lck = $this->Rqu([ 't'=>'vtex_ins_coup', 'cl'=>$_cl_v->id, 'lck'=>1 ]);

							//---------- Start Query Execution ----------//

							$___datprcs = [];

							if($___lck->e == 'ok'){

								$VtexCmpgInsCoupQry = "	SELECT  id_vtexcmpg, vtexcmpg_vlr_cod, vtexcmpg_vtex, id_vtexcmpgins,
																vtexcmpg_ec_ins, vtexcmpg_ec_rfd_in, vtexcntpss_eml, vtexcntpss_cnt, vtexcmpgins_coup, vtexcmpgins_eml, vtexcmpgins_rfd
														FROM 	"._BdStr($_cl_v->bd).TB_VTEX_CMPG_INS."
																INNER JOIN "._BdStr(DBT).TB_VTEX_CMPG." ON vtexcmpgins_vtexcmpg = id_vtexcmpg
																INNER JOIN "._BdStr(DBT).TB_VTEX." ON vtexcmpg_vtex = id_vtex
																INNER JOIN "._BdStr($_cl_v->bd).TB_CNT." ON vtexcmpgins_cnt = id_cnt
																INNER JOIN "._BdStr($_cl_v->bd).TB_VTEX_CNT_PSS." ON vtexcntpss_cnt = id_cnt
														WHERE vtexcmpgins_coup IS NULL || vtexcmpgins_eml = 2
														ORDER BY id_vtexcmpgins DESC
														LIMIT 50";

								//echo compress_code($VtexCmpgInsCoupQry);
								//exit();

								$VtexCmpgInsCoup = $__cnx->_qry($VtexCmpgInsCoupQry, ['cmps'=>'ok'] );

								if($VtexCmpgInsCoup){

									$rwVtexCmpgInsCoup = $VtexCmpgInsCoup->fetch_assoc();
									$TotVtexCmpgInsCoup = $VtexCmpgInsCoup->num_rows;

									echo $this->li($TotVtexCmpgInsCoup.' registros');

									if($TotVtexCmpgInsCoup > 0){
										do{ //---------- Get all Id For Read Mode Markup ----------//
											try {
												$___datprcs[] = $rwVtexCmpgInsCoup;
											} catch (Exception $e) {
												$___lck = $this->Rqu([ 't'=>'vtex_ins_coup', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
												echo $this->err($e->getMessage());
											}
										} while ($rwVtexCmpgInsCoup = $VtexCmpgInsCoup->fetch_assoc());
									}else{
										$___lck = $this->Rqu([ 't'=>'vtex_ins_coup', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									}

								}else{

									$___lck = $this->Rqu([ 't'=>'vtex_ins_coup', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									echo $this->err($__cnx->c_r->error);

								}

								$__cnx->_clsr($VtexCmpgInsCoup);

								if(!isN( $___datprcs ) && count($___datprcs) > 0){

                                    foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

										echo $this->li( $___datprcs_v['id_vtexcmpgins'].' to process' );

										$___coup='';

										$this->_vtex->acc = $___datprcs_v['vtexcmpg_vtex'];

										if(isN($___datprcs_v['vtexcmpgins_coup'])){

											echo $this->li( $___datprcs_v['id_vtexcmpgins'].' has not coupon, lets request' );

											$__gcoup = $this->_vtex->coup_new([
												'srce'=>'START-CMPG'/*$___datprcs_v['vtexcmpg_vlr_cod']*/,
												'cmpg'=>$___datprcs_v['id_vtexcmpg'],
												'sumr'=>1
											]);

											$___coup = $__gcoup->id;

										}else{
											$___coup = $___datprcs_v['vtexcmpgins_coup'];
										}

										if(!isN($___coup)){

											echo $this->scss( $___coup.' for process' );

											$_upd = $this->_vtex->Ins_Upd([
														'bd'=>$_cl_v->bd,
														'id'=>$___datprcs_v['id_vtexcmpgins'],
														'f'=>[
															'vtexcmpgins_coup'=>$___coup
														]
													]);

											if($_upd->e == 'ok'){

												echo $this->li( 'Update code and now send mail, status:'.mBln($___datprcs_v['vtexcmpgins_eml']) );

												if(mBln($___datprcs_v['vtexcmpgins_eml']) == 'no'){

													$__ec = new API_CRM_ec();
													$__ec->snd_f = SIS_F;
													$__ec->snd_h = SIS_H2;
													$__ec->snd_ec = (mBln($___datprcs_v['vtexcmpgins_rfd'])=='ok')?$___datprcs_v['vtexcmpg_ec_rfd_in']:$___datprcs_v['vtexcmpg_ec_ins'];
													$__ec->snd_eml = $___datprcs_v['vtexcntpss_eml'];
													$__ec->snd_cnt = $___datprcs_v['vtexcntpss_cnt'];
													$__ec->sndr_id = $___datprcs_v['id_vtexcmpgins'];
													$__ec->sndr_tp = 'vtex_ins';
													$__ec->snd_prty = 1;

													$__ec->snd_us = 3;
													$__snd = $__ec->_SndEc([ 't'=>'r', 'auto'=>'ok', 'bd'=>$_cl_v->bd ]);

													if($__snd->e == 'ok'){

														$_upd_eml = $this->_vtex->Ins_Upd([
																		'bd'=>$_cl_v->bd,
																		'id'=>$___datprcs_v['id_vtexcmpgins'],
																		'f'=>[
																			'vtexcmpgins_eml'=>1
																		]
																	]);

														if($_upd_eml->e == 'ok'){
															echo $this->scss( $___datprcs_v['id_vtexcmpgins'].' saved on vtex success' );
														}else{
															echo $this->err( $___datprcs_v['id_vtexcmpgins'].' sent but not updated '.$_upd_eml->w );
														}

													}else{
														echo $this->err( 'InsCoup:'.$___datprcs_v['id_vtexcmpgins'].' sended email '.$_upd->w );
													}

												}else{

													if($_upd_eml->e == 'ok'){
														echo $this->scss( $___datprcs_v['id_vtexcmpgins'].' is created' );
													}

												}

											}else{

												echo $this->err('Error on update coupon '.$_upd->w);

											}

										}else{

											echo $this->err('No coupon code '.$__gcoup->w);

										}

                                    }

								}

							}

						} catch (Exception $e) {

							$___lck = $this->Rqu([ 't'=>'vtex_ins_coup', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
							echo $this->err($e->getMessage());

						}

						$___lck = $this->Rqu([ 't'=>'vtex_ins_coup', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

					}else{

						echo $this->nallw(' $_AUTOP_d->e off '.$_cl_v->nm);

					}

				}else{

					echo $this->nallw(' Vtex - Campaigns - Inscrito Cupon - Off - '.$_cl_v->nm);

				}

			}

		}

	}


}else{

	echo $this->nallw('Vtex - Campaigns - Inscrito Cupon - Off');

}

?>