<?php

if($this->g__s3 == 'old'){
	$_rqu_tp='vtex_ord_ls_old';
	$_f_all='old_all';
	$_f_pge='old_pge';
	$_f_pge_tot='old_pge_tot';
}else{
	$_rqu_tp='vtex_ord_ls';
	$_f_all='all';
	$_f_pge='pge';
	$_f_pge_tot='pge_tot';
}

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>$_rqu_tp ]);

if( $_g_alw->est == 'ok' ){

	if($this->_s_cl->tot > 0){

		foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

			if( $this->tallw_cl([ 't'=>'key', 'id'=>$_rqu_tp, 'cl'=>$_cl_v->id ])->est == 'ok' ){

				//-------------------- AUTO TIME CHECK - START --------------------//

					$_AUTOP_d = $this->RquDt([ 't'=>$_rqu_tp, 'cl'=>$_cl_v->id, 'm'=>1 ]);

				//-------------------- AUTO TIME CHECK - END --------------------//

				if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 5){

					try{

						echo $this->h2($_AUTOP_d->e.' - '.$_cl_v->nm.' habilitado? '.$_AUTOP_d->hb.' lock? '.$_AUTOP_d->lck.' m_lck'.$_AUTOP_d->m_lck, '', '_check');

						//---------- Lock Account While Check Result On Read Mode ----------//

						$___lck = $this->Rqu([ 't'=>$_rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>1 ]);
						echo $this->h2( 'Result of lock all query: '.$___lck->e.' w:'.$___lck->w );

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
											$___lck = $this->Rqu([ 't'=>$_rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
											echo $this->err($e->getMessage());
										}
									} while ($rwVtexOrd = $VtexOrd->fetch_assoc());
								}else{
									$___lck = $this->Rqu([ 't'=>$_rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
								}

							}else{

								$___lck = $this->Rqu([ 't'=>$_rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
								echo $this->err($__cnx->c_r->error);

							}

							$__cnx->_clsr($VtexOrd);

							if(!isN( $___datprcs ) && count($___datprcs) > 0){

								echo $this->h3('$___lck dislock query ');

								foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

									$__date_start = NULL;
									$__date_next = NULL;
									$__f_ppge = NULL;
									$__f_date = NULL;

									echo $this->li('Get info of VTEX account '.$___datprcs_v['id_vtex']);

									$this->_vtex->acc = $___datprcs_v['id_vtex'];

									$_AUTOP_acc = $this->RquDt([
														't'=>$_rqu_tp,
														'cl'=>$_cl_v->id,
														'id'=>$___datprcs_v['id_vtex'],
														'm'=>1
													]);

									if(
										( $this->g__s3 != 'old' && ($_AUTOP_acc->pge <= 30 || $_AUTOP_acc->all == 'ok')) ||
										( $this->g__s3 == 'old' && ($_AUTOP_acc->old->pge <= 30 || $_AUTOP_acc->old->all == 'ok'))
									){

										if($this->g__s3 == 'old'){

											echo $this->li('Has to search on page '.$_AUTOP_acc->old->pge);

											$__f_ord = 'asc';

											if(isN($_AUTOP_acc->date->start)){

												$__f_ppge = 1; // Request only 1 record for get first date order

											}else{

												if(!isN($_AUTOP_acc->date->next)){ // If date next to get
													$__f_date = $_AUTOP_acc->date->next;
												}else{
													$__f_date = $_AUTOP_acc->date->start;
												}

												echo $this->li('Search for specific date '.$__f_date);

												if($_AUTOP_acc->old->all != 'ok'){
													$this->_vtex->rqu_pge = $_AUTOP_acc->old->pge;
												}


											}

										}else{

											echo $this->li('Has to search on page '.$_AUTOP_acc->pge);

											$__f_ppge = '';
											$__f_ord = '';
											$__f_date = '';
											if($_AUTOP_acc->all != 'ok'){ $this->_vtex->rqu_pge = $_AUTOP_acc->pge; }

										}

										$_get = $this->_vtex->rqu([
											't'=>'orders_ls',
											'ord'=>$__f_ord,
											'ppge'=>$__f_ppge,
											'date'=>$__f_date
										]);

										if($this->g__s3 == 'old'){
											if(isN($_AUTOP_acc->date->start)){
												$__date_start = $this->_vtex->_Tme($_get->rsl->list[0]->creationDate);
											}
											$__total = $_get->rsl->paging->pages;
										}else{
											$__total = $_get->rsl->paging->pages;
										}

										echo $this->h3( 'Total Pages on Result'.$__total );

										//print_r( $_get );

										echo $this->h3( 'Process account '.$___datprcs_v['id_vtex'] );


										if(!isN( $_get->rsl->list )){

											foreach($_get->rsl->list as $ord_k=>$ord_v){

												if(!isN($ord_v->orderId)){

													echo $this->h3( 'Process order '.$ord_v->orderId.' '.$ord_v->status );

													$this->_vtex->__t = 'ord';
													$this->_vtex->vtexord_vtex = $___datprcs_v['id_vtex'];
													$this->_vtex->vtexord_cid = $ord_v->orderId;
													$this->_vtex->vtexord_status = $ord_v->status;
													$this->_vtex->vtexord_date_creation = $this->_vtex->_Tme($ord_v->creationDate);
													$__Prc = $this->_vtex->In();

													if($__Prc->e == 'ok'){
														echo $this->scss($ord_v->orderId.' processed succesfully');
													}else{
														echo $this->err($ord_v->orderId.' ls not processed succesfully');
														echo $this->err('Err:'.print_r($__Prc, true));
													}
												}
											}
										}

										if($this->g__s3 == 'old'){

											echo $this->li('Code request result '.$_get->code );

											if(!isN($_AUTOP_acc->date->start) && $_get->code == 200){

												if($_get->rsl->paging->pages < 2 || $_get->rsl->paging->currentPage >= $_AUTOP_acc->old->pge){

													if(!isN($_AUTOP_acc->date->next)){
														$__date_next_v=$_AUTOP_acc->date->next;
													}else{
														$__date_next_v=$_AUTOP_acc->date->start;
													}

													$__date_next = date('Y-m-d', strtotime($__date_next_v. ' + 1 day'));

												}else{

												}

											}

											if($_AUTOP_acc->old->all != 'ok'){

												if($_get->rsl->paging->currentPage >= $_AUTOP_acc->old->pge){
													$__u_pge = 1;
												}else{
													$__u_pge = $_get->rsl->paging->currentPage+1;
												}

											}else{
												$__u_pge = NULL;
											}

											$__upd_auto = $this->Rqu([
												't'=>$_rqu_tp,
												'cl'=>$_cl_v->id,
												'old_pge'=>$__u_pge,
												'old_pge_tot'=>$__total,
												'date_start'=>$__date_start,
												'date_next'=>$__date_next,
												'id'=>$___datprcs_v['id_vtex']
											]);

											//print_r($__upd_auto);

										}else{

											if($_AUTOP_acc->all != 'ok'){
												$__u_pge = $_get->rsl->paging->currentPage+1;
											}else{
												$__u_pge = NULL;
											}


											$__upd_auto = $this->Rqu([
												't'=>$_rqu_tp,
												'cl'=>$_cl_v->id,
												'pge'=>$__u_pge,
												'pge_tot'=>$__total,
												'date_start'=>$__date_start,
												'date_next'=>$__date_next,
												'id'=>$___datprcs_v['id_vtex']
											]);

											print_r($__upd_auto);

										}


									}else{

										$__upd_auto = $this->Rqu([
											't'=>$_rqu_tp,
											'cl'=>$_cl_v->id,
											${$_f_all}=>1,
											'id'=>$___datprcs_v['id_vtex']
										]);

									}

								}

							}

						}

					}catch(Exception $e){

						$___lck = $this->Rqu([ 't'=>$_rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
						echo $this->err($e->getMessage());

					}

					$___lck = $this->Rqu([ 't'=>$_rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);

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