<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=> 'vtex_ins_rfd_coup' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=> 'vtex_ins_rfd_coup', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					//-------------------- AUTO TIME CHECK - START --------------------//

						$_AUTOP_d = $this->RquDt([ 't'=>'vtex_ins_rfd_coup', 'cl'=>$_cl_v->id, 's'=>10 ]);

					//-------------------- AUTO TIME CHECK - END --------------------//

					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 5 || $_AUTOP_d->hb == 'ok'){

						try {

							echo $this->h2($_AUTOP_d->e.' - '.$_cl_v->nm.' habilitado? '.$_AUTOP_d->hb.' lock? '.$_AUTOP_d->lck.' m_lck'.$_AUTOP_d->m_lck, '', '_check');

							//---------- Lock Account While Check Result On Read Mode ----------//

							$___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_coup', 'cl'=>$_cl_v->id, 'lck'=>1 ]);

							//---------- Start Query Execution ----------//

							$___datprcs = [];

							if($___lck->e == 'ok'){

								$VtexCmpgInsCoupQry = "	SELECT  id_vtexcmpginsrfd, vtexcmpg_ec_rfd, vtexcmpg_ec_rfd_coup, vtexcmpginsrfd_rfd, vtexcmpginsrfd_rfd_coup_eml, id_cnt
                                                        FROM    "._BdStr($_cl_v->bd).TB_VTEX_CMPG_INS_RFD."
                                                                INNER JOIN "._BdStr($_cl_v->bd).TB_VTEX_CMPG_INS." ON vtexcmpginsrfd_ins = id_vtexcmpgins
																INNER JOIN "._BdStr(DBT).TB_VTEX_CMPG." ON vtexcmpgins_vtexcmpg = id_vtexcmpg
																INNER JOIN "._BdStr(DBT).TB_VTEX." ON vtexcmpg_vtex = id_vtex
																INNER JOIN "._BdStr($_cl_v->bd).TB_CNT." ON vtexcmpginsrfd_rfd = id_cnt
                                                        WHERE   vtexcmpginsrfd_rfd_coup IS NOT NULL AND
                                                                vtexcmpginsrfd_rfd_coup_eml = 2 AND
																vtexcmpginsrfd_eml = 1 AND
																NOW() > (vtexcmpgins_fi + INTERVAL 30 MINUTE)
														ORDER BY id_vtexcmpginsrfd DESC
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
												$___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_coup', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
												echo $this->err($e->getMessage());
											}
										} while ($rwVtexCmpgInsCoup = $VtexCmpgInsCoup->fetch_assoc());
									}else{
										$___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_coup', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									}

								}else{

									$___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_coup', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									echo $this->err($__cnx->c_r->error);

								}

								$__cnx->_clsr($VtexCmpgInsCoup);

								if(!isN( $___datprcs ) && count($___datprcs) > 0){

                                    foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

										echo $this->li( $___datprcs_v['id_vtexcmpginsrfd'].' to process' );
                                        $__eml_to_send='';

										$this->_vtex->acc = $___datprcs_v['vtexcmpg_vtex'];

										echo $this->li( 'Now send mail, status:'.mBln($___datprcs_v['vtexcmpginsrfd_rfd_coup_eml']) );

										if(mBln($___datprcs_v['vtexcmpginsrfd_rfd_coup_eml']) == 'no'){

											echo $this->li( 'Getting list mail of cnt '.$___datprcs_v['id_cnt'] );

											$__cnt_eml = GtCntEmlLs([ 'i'=>$___datprcs_v['id_cnt'], 'bd'=>$_cl_v->bd ]);

											//print_r($__cnt_eml);

											echo $this->li( 'Total mails:'.$__cnt_eml->tot );

											$_cld_b='';

											foreach($__cnt_eml as $__cnt_eml_k=>$__cnt_eml_v){

												echo $this->li( 'Checking mail:'.$__cnt_eml_v->v );

												if($__cnt_eml_v->cld >= $_cld_b || isN($_cld_b)){
													$__eml_to_send = $__cnt_eml_v->v;
													$_cld_b = $__cnt_eml_v->cld;
												}

											}

											if(!isN( $__eml_to_send )){

                                                $__ec = new API_CRM_ec();
                                                $__ec->snd_f = SIS_F;
                                                $__ec->snd_h = SIS_H2;
                                                $__ec->snd_ec = $___datprcs_v['vtexcmpg_ec_rfd_coup'];
                                                $__ec->snd_eml = $__eml_to_send;
                                                $__ec->snd_cnt = $___datprcs_v['vtexcmpginsrfd_rfd'];
                                                $__ec->sndr_id = $___datprcs_v['id_vtexcmpginsrfd'];
                                                $__ec->sndr_tp = 'vtex_ins_rfd';
                                                $__ec->snd_prty = 1;
                                                $__ec->snd_us = 3;
                                                $__snd_coup = $__ec->_SndEc([ 't'=>'r', 'auto'=>'ok', 'bd'=>$_cl_v->bd ]);

												if($__snd_coup->e == 'ok'){

                                                    $_upd_eml = $this->_vtex->InsRfd_Upd([
                                                        'bd'=>$_cl_v->bd,
                                                        'id'=>$___datprcs_v['id_vtexcmpginsrfd'],
                                                        'f'=>[
                                                            'vtexcmpginsrfd_rfd_coup_eml'=>1
                                                        ]
                                                    ]);

                                                    if($_upd_eml->e == 'ok'){
                                                        echo $this->scss( $___datprcs_v['id_vtexcmpginsrfd'].' send coupon on queue mail success' );
                                                    }

                                                }else{
                                                    echo $this->err( $___datprcs_v['id_vtexcmpginsrfd'].' sent but not updated '.$_upd_eml->w );
                                                }

											}else{

												echo $this->err( 'There is no mail for send' );

											}

										}else{

											if($_upd_eml->e == 'ok'){
												echo $this->scss( $___datprcs_v['id_vtexcmpginsrfd'].' is created' );
											}

										}

                                    }

								}

							}

						} catch (Exception $e) {

							$___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_coup', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
							echo $this->err($e->getMessage());

						}

						$___lck = $this->Rqu([ 't'=>'vtex_ins_rfd_coup', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

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