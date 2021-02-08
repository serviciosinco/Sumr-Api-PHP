<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=> 'vtex_cnt' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		if($this->_s_cl->tot > 0){

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=> 'vtex_cnt', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					//-------------------- AUTO TIME CHECK - START --------------------//

						$_AUTOP_d = $this->RquDt([ 't'=>'vtex_cnt', 'cl'=>$_cl_v->id, 'm'=>1 ]);

					//-------------------- AUTO TIME CHECK - END --------------------//

					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 5){

						try {

							echo $this->h2($_AUTOP_d->e.' - '.$_cl_v->nm.' habilitado? '.$_AUTOP_d->hb.' lock? '.$_AUTOP_d->lck.' m_lck'.$_AUTOP_d->m_lck, '', '_check');

							//---------- Lock Account While Check Result On Read Mode ----------//

							$___lck = $this->Rqu([ 't'=>'vtex_cnt', 'cl'=>$_cl_v->id, 'lck'=>1 ]);
							echo $this->h2( 'Result of lock all query: '.$___lck->e );

							//---------- Start Query Execution ----------//

							$___datprcs = [];

							if($___lck->e == 'ok'){

								$VtexCntQry = "	SELECT id_vtexcntpss, vtexcntpss_enc, vtexcntpss_vtex, vtexcntpss_eml, cnt_nm, cnt_ap
												FROM "._BdStr($_cl_v->bd).TB_VTEX_CNT_PSS."
                                                     INNER JOIN "._BdStr(DBT).TB_VTEX." ON vtexcntpss_vtex = id_vtex
                                                     INNER JOIN "._BdStr($_cl_v->bd).TB_CNT." ON vtexcntpss_cnt = id_cnt
												WHERE vtexcntpss_cid IS NULL
												ORDER BY id_vtexcntpss DESC
												LIMIT 50";

								//echo compress_code($VtexCntQry);
								//exit();

								$VtexCnt = $__cnx->_qry($VtexCntQry, ['cmps'=>'ok'] );

								if($VtexCnt){

									$rwVtexCnt = $VtexCnt->fetch_assoc();
									$TotVtexCnt = $VtexCnt->num_rows;

									echo $this->li($TotVtexCnt.' registros');

									if($TotVtexCnt > 0){

										//---------- Get all Id For Read Mode Markup ----------//

										do{

											try {

												$___datprcs[] = $rwVtexCnt;

											} catch (Exception $e) {

												$___lck = $this->Rqu([ 't'=>'vtex_cnt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
												echo $this->err($e->getMessage());

											}

										} while ($rwVtexCnt = $VtexCnt->fetch_assoc());

									}else{

										$___lck = $this->Rqu([ 't'=>'vtex_cnt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

									}

								}else{

									$___lck = $this->Rqu([ 't'=>'vtex_cnt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									echo $this->err($__cnx->c_r->error);

								}

								$__cnx->_clsr($VtexCnt);

								if(!isN( $___datprcs ) && count($___datprcs) > 0){

                                    foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

                                        $this->_vtex->acc = $___datprcs_v['vtexcntpss_vtex'];

                                        $_sve = $this->_vtex->mdata_cnt_in([
                                                    'nm'=>ctjTx($___datprcs_v['cnt_nm'],'in'),
                                                    'ap'=>ctjTx($___datprcs_v['cnt_ap'],'in'),
                                                    'eml'=>$___datprcs_v['vtexcntpss_eml']
                                                ]);

                                        if(!isN($_sve->id)){
                                            $_upd = $this->_vtex->CntPss_UPD([ 'id'=>$___datprcs_v['vtexcntpss_enc'], 'sve'=>1, 'cid'=>$_sve->id, 'bd'=>$_cl_v->bd ]);
                                            if($_upd->e == 'ok'){
                                                echo $this->scss( $___datprcs_v['vtexcntpss_eml'].' saved on vtex success' );
                                            }else{
                                                echo $this->err( $___datprcs_v['vtexcntpss_eml'].' not saved on vtex CntPss_UPD '.$_upd->w );
                                            }
                                        }else{
											echo $this->err( 'Mail '.$___datprcs_v['vtexcntpss_eml'].' not saved on vtex ');
											echo $this->err( $_sve->w.compress_code( print_r($_sve, true) ) );
										}

                                    }

								}

							}

						} catch (Exception $e) {

							$___lck = $this->Rqu([ 't'=>'vtex_cnt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
							echo $this->err($e->getMessage());

						}

						$___lck = $this->Rqu([ 't'=>'vtex_cnt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

					}else{

						echo $this->nallw(' $_AUTOP_d->e off '.$_cl_v->nm);

					}

				}else{

					echo $this->nallw(' Vtex - Create Lead in Vtex - Off - '.$_cl_v->nm);

				}

			}

		}

	}


}else{

	echo $this->nallw('Vtex - Create Lead in Vtex - Off');

}

?>