<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=> 'vtex_ord_dt' ]);

if( $_g_alw->est == 'ok' ){

	if($this->_s_cl->tot > 0){

		foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

			if( $this->tallw_cl([ 't'=>'key', 'id'=> 'vtex_ord_dt', 'cl'=>$_cl_v->id ])->est == 'ok' ){

				//-------------------- AUTO TIME CHECK - START --------------------//

					$_AUTOP_d = $this->RquDt([ 't'=>'vtex_ord_dt', 'cl'=>$_cl_v->id, 'm'=>1 ]);

				//-------------------- AUTO TIME CHECK - END --------------------//

				if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 5){

					try{

						echo $this->h2($_AUTOP_d->e.' - '.$_cl_v->nm.' habilitado? '.$_AUTOP_d->hb.' lock? '.$_AUTOP_d->lck.' m_lck'.$_AUTOP_d->m_lck, '', '_check');

						//---------- Lock Account While Check Result On Read Mode ----------//

						$___lck = $this->Rqu([ 't'=>'vtex_ord_dt', 'cl'=>$_cl_v->id, 'lck'=>1 ]);
						echo $this->h2( 'Result of lock all query: '.$___lck->e.' w:'.$___lck->w );

						//---------- Start Query Execution ----------//

						$___datprcs = [];

						if($___lck->e == 'ok'){

							$VtexOrdDtQry = "	SELECT id_vtexord, vtexord_cid, id_vtex
                                            FROM "._BdStr(DBT).TB_VTEX_ORD."
                                                 INNER JOIN "._BdStr(DBT).TB_VTEX." ON vtexord_vtex = id_vtex
												 INNER JOIN "._BdStr(DBM).TB_CL." ON vtex_cl = id_cl
                                            WHERE cl_enc = '".$_cl_v->enc."' AND
												  vtexord_api_dt = 2
											ORDER BY vtexord_date_creation DESC
											LIMIT 50";

							//echo compress_code($VtexOrdDtQry);
							//exit();

							$VtexOrdDt = $__cnx->_qry($VtexOrdDtQry, ['cmps'=>'ok'] );

							if($VtexOrdDt){

								$rwVtexOrdDt = $VtexOrdDt->fetch_assoc();
								$TotVtexOrdDt = $VtexOrdDt->num_rows;

								echo $this->li($TotVtexOrdDt.' registros');

								if($TotVtexOrdDt > 0){
									do{ //---------- Get all Id For Read Mode Markup ----------//
										try {
											echo $this->li('Lock Before to ID '.$rwVtexOrdDt['id_vtexord']);
											$___datprcs[] = $rwVtexOrdDt;
										} catch (Exception $e) {
											$___lck = $this->Rqu([ 't'=>'vtex_ord_dt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
											echo $this->err($e->getMessage());
										}
									} while ($rwVtexOrdDt = $VtexOrdDt->fetch_assoc());
								}else{
									$___lck = $this->Rqu([ 't'=>'vtex_ord_dt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
								}

							}else{

								$___lck = $this->Rqu([ 't'=>'vtex_ord_dt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
								echo $this->err($__cnx->c_r->error);

							}

							$__cnx->_clsr($VtexOrdDt);

							if(!isN( $___datprcs ) && count($___datprcs) > 0){

								echo $this->h3('$___lck dislock query ');

								foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

									echo $this->li('Get info of VTEX order '.$___datprcs_v['id_vtexord']);

									$this->_vtex->acc = $___datprcs_v['id_vtex'];
									$_get = $this->_vtex->rqu([ 't'=>'orders_dt', 'id'=>$___datprcs_v['vtexord_cid'] ]);

									echo $this->h3( 'Process order '.$___datprcs_v['id_vtexord'] );

									if(!isN( $_get->rsl ) && !isN( $_get->rsl->orderId )){

										$this->_vtex->vtexord_id_upd = NULL;
										$this->_vtex->vtexord_api_dt = NULL;

										foreach($_get->rsl as $orddt_k=>$orddt_v){

											$_batch_w = 'no';

											if(!isN($orddt_v)){

												if($orddt_k != 'items'){

													echo $this->h3( 'Process attribute '.$orddt_k );

													$this->_vtex->vtexord_coup = NULL;
													$this->_vtex->vtexord_id_upd = NULL;

													if(is_object($orddt_v)){
														$__vle = json_encode($orddt_v);
													}else{
														$__vle = $orddt_v;
													}

													$this->_vtex->__t = 'ord_attr';
													$this->_vtex->vtexordattr_vtexord = $___datprcs_v['id_vtexord'];
													$this->_vtex->vtexordattr_key = $orddt_k;
													$this->_vtex->vtexordattr_vl = $__vle;
													$__Prc = $this->_vtex->In();

													if($__Prc->e == 'ok'){
														echo $this->scss($orddt_k .' processed succesfully');
													}else{
														echo $this->err($orddt_k .' dt not processed succesfully '.$__Prc->w);
														$_batch_w = 'ok';
													}

													if($orddt_k == 'marketingData'){

														if(!isN($orddt_v->coupon)){

															$_coup_in = $this->_vtex->coup([
																			'norqu'=>'ok',
																			'coup'=>$orddt_v->coupon
																		]);

															if(!isN($_coup_in->id)){

																$this->_vtex->vtexord_coup = $_coup_in->id;
																$this->_vtex->vtexord_id_upd = $___datprcs_v['id_vtexord'];
																$__upd = $this->_vtex->Ord(['t'=>'upd']);

																if(!isN($__upd) && $__upd->e == 'ok'){
																	echo $this->scss($orddt_k .' coupon updated succesfully');
																}else{
																	echo $this->err($orddt_k .' coupon not updated succesfully '.$__upd->w);
																	$_batch_w = 'ok';
																}

															}else{

																echo $this->err($orddt_k .' coupon not generated '.$_coup_in->w);

															}

														}

													}

												}

											}

										}

										if($_batch_w != 'ok'){ // Si no hubo errores al procesar todos los atributos

											$this->_vtex->vtexord_id_upd = $___datprcs_v['id_vtexord'];
											$this->_vtex->vtexord_api_dt = 1;
											$__chk_upd = $this->_vtex->Ord(['t'=>'upd']);

											if(!isN($__chk_upd) && $__chk_upd->e == 'ok'){
												echo $this->scss($___datprcs_v['id_vtexord'] .' order updated succesfully');
											}else{
												echo $this->err($___datprcs_v['id_vtexord'].' order not updated succesfully '.$__upd->w);
											}

										}else{

											echo $this->err($___datprcs_v['id_vtexord'] .' error on complete attributes');

										}

									}

								}

							}

						}

					}catch(Exception $e){

						$___lck = $this->Rqu([ 't'=>'vtex_ord_dt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
						echo $this->err($e->getMessage());

					}

					$___lck = $this->Rqu([ 't'=>'vtex_ord_dt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

				}else{

					echo $this->nallw(' $_AUTOP_d->e off '.$_cl_v->nm);

				}

			}else{

				echo $this->nallw(' Vtex - Get Orders - Off - '.$_cl_v->nm);

			}

		}

	}

}else{

	echo $this->nallw('Vtex - Get Orders - Details - Off');

}

?>