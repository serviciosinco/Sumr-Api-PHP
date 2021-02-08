<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=> 'vtex_ord_ls' ]);

if( $_g_alw->est == 'ok' ){

	if($this->_s_cl->tot > 0){

		foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

			if( $this->tallw_cl([ 't'=>'key', 'id'=> 'vtex_ord_ls', 'cl'=>$_cl_v->id ])->est == 'ok' ){

				//-------------------- AUTO TIME CHECK - START --------------------//

					$_AUTOP_d = $this->RquDt([ 't'=>'vtex_ord_ls', 'cl'=>$_cl_v->id, 'm'=>1 ]);

				//-------------------- AUTO TIME CHECK - END --------------------//

				if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 5){

					try{

						echo $this->h2($_AUTOP_d->e.' - '.$_cl_v->nm.' habilitado? '.$_AUTOP_d->hb.' lock? '.$_AUTOP_d->lck.' m_lck'.$_AUTOP_d->m_lck, '', '_check');

						//---------- Lock Account While Check Result On Read Mode ----------//

						$___lck = $this->Rqu([ 't'=>'vtex_ord_ls', 'cl'=>$_cl_v->id, 'lck'=>1 ]);
						echo $this->h2( 'Result of lock all query: '.$___lck->e );

						//---------- Start Query Execution ----------//

						$___datprcs = [];

						if($___lck->e == 'ok'){

							$VtexOrdQry = "	SELECT id_vtex
											FROM "._BdStr(DBT).TB_VTEX."
													INNER JOIN "._BdStr(DBM).TB_CL." ON vtex_cl = id_cl
											WHERE cl_enc = '".$_cl_v->enc."'
											LIMIT 50";

							//echo compress_code($VtexOrdQry);
							//exit();

							$VtexOrd = $__cnx->_qry($VtexOrdQry, ['cmps'=>'ok'] );

							if($VtexOrd){

								$rwVtexOrd = $VtexOrd->fetch_assoc();
								$TotVtexOrd = $VtexOrd->num_rows;

								echo $this->li($TotVtexOrd.' registros');

								if($TotVtexOrd > 0){
									do{ //---------- Get all Id For Read Mode Markup ----------//
										try {
											echo $this->li('Lock Before to ID '.$rwVtexOrd['id_vtex']);
											$___datprcs[] = $rwVtexOrd;
										} catch (Exception $e) {
											$___lck = $this->Rqu([ 't'=>'vtex_ord_ls', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
											echo $this->err($e->getMessage());
										}
									} while ($rwVtexOrd = $VtexOrd->fetch_assoc());
								}else{
									$___lck = $this->Rqu([ 't'=>'vtex_ord_ls', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
								}

							}else{

								$___lck = $this->Rqu([ 't'=>'vtex_ord_ls', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
								echo $this->err($__cnx->c_r->error);

							}

							$__cnx->_clsr($VtexOrd);

							if(!isN( $___datprcs ) && count($___datprcs) > 0){

								echo $this->h3('$___lck dislock query ');

								foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

									echo $this->li('Get info of VTEX account '.$___datprcs_v['id_vtex']);

									$this->_vtex->acc = $___datprcs_v['id_vtex'];

									$_AUTOP_acc = $this->RquDt([
														't'=>'vtex_ord_ls',
														'cl'=>$_cl_v->id,
														'id'=>$___datprcs_v['id_vtex'],
														'm'=>1
													]);

									if($_AUTOP_acc->pge <= 30 || $_AUTOP_acc->all == 'ok'){

										echo $this->li('Has to search on page '.$_AUTOP_acc->pge);

										if($_AUTOP_acc->all != 'ok'){ $this->_vtex->rqu_pge = $_AUTOP_acc->pge; }
										$_get = $this->_vtex->rqu([ 't'=>'orders_ls' ]);
										//print_r( $_get->rsl );

										echo $this->h3( 'Process account '.$___datprcs_v['id_vtex'] );

										if(!isN( $_get->rsl->list )){

											foreach($_get->rsl->list as $ord_k=>$ord_v){

												if(!isN($ord_v->orderId)){

													echo $this->h3( 'Process order '.$ord_v->orderId.' '.$ord_v->status );

													$this->_vtex->__t = 'ord';
													$this->_vtex->vtexord_vtex = $___datprcs_v['id_vtex'];
													$this->_vtex->vtexord_cid = $ord_v->orderId;
													$this->_vtex->vtexord_status = $ord_v->status;
													$this->_vtex->vtexord_date_creation = $ord_v->creationDate;
													$__Prc = $this->_vtex->In();

													if($__Prc->e == 'ok'){

														echo $this->li('Status actually '.$__Prc->chk->status);

														if(	$__Prc->upd == 'ok' &&
															(
																$__Prc->chk->status != 'invoiced' ||
																$__Prc->chk->status != 'canceled'
															)
														){

															$this->_vtex->vtexord_api_dt = 1;
															$__chk_upd = $this->_vtex->Ord(['t'=>'upd']);

															if($__chk_upd->e == 'ok'){
																echo $this->scss($ord_v->orderId.' processed update succesfully');
															}else{
																echo $this->err($ord_v->orderId.' not processed update succesfully');
															}

														}else{
															echo $this->scss($ord_v->orderId.' upd processed succesfully');
															echo $this->err('Err:'.print_r($__Prc, true));
														}

													}else{
														echo $this->err($ord_v->orderId.' upd not processed succesfully');
														echo $this->err('Err:'.print_r($__Prc, true));
													}

												}

											}

											$__upd_auto = $this->Rqu([
															't'=>'vtex_ord_ls',
															'cl'=>$_cl_v->id,
															'pge'=>($_AUTOP_acc->all != 'ok')?$_get->rsl->paging->currentPage+1 : NULL,
															'pge_tot'=>$_get->rsl->paging->total,
															'id'=>$___datprcs_v['id_vtex']
														]);

										}

									}else{

										$__upd_auto = $this->Rqu([
											't'=>'vtex_ord_ls',
											'cl'=>$_cl_v->id,
											'all'=>1,
											'id'=>$___datprcs_v['id_vtex']
										]);

									}

								}

							}

						}

					}catch(Exception $e){

						$___lck = $this->Rqu([ 't'=>'vtex_ord_ls', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
						echo $this->err($e->getMessage());

					}

					$___lck = $this->Rqu([ 't'=>'vtex_ord_ls', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

				}else{

					echo $this->nallw(' $_AUTOP_d->e off '.$_cl_v->nm);

				}

			}else{

				echo $this->nallw(' Vtex - Get Orders - Off - '.$_cl_v->nm);

			}

		}

	}

}else{

	echo $this->nallw('Vtex - Get Orders - Off');

}

?>