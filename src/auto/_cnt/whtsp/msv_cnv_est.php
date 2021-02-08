<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'whtsp_msv_cnv_est' ]);

if( $_g_alw->est == 'ok' ){

	try {

		foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

			if( $this->tallw_cl([ 't'=>'key', 'id'=>'whtsp_msv_cnv_est', 'cl'=>$_cl_v->id ])->est == 'ok' ){

				try {

					//-------------------- AUTO TIME CHECK - START --------------------//

						$_AUTOP_d = $this->RquDt([ 't'=>'msv_cnv_est', 'cl'=>$_cl_v->id, 'm'=>2 ]);

					//-------------------- AUTO TIME CHECK - END --------------------//

					if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

						$___usrsid = [];
						$___datprcs = [];

						if(class_exists('CRM_Cnx')){

							$Ls_Qry = " SELECT 	wthsp_cl, wthspcnv_id, id_wthsp, id_wthspcnv, wthsp_no, wthspcnv_cls, wthspcnv_f_chk_est,
												( wthspcnv_f_chk_est < NOW() - INTERVAL 5 MINUTE ) AS __rd_lst
										FROM "._BdStr(DBT).TB_WHTSP_CNV."
											INNER JOIN "._BdStr(DBT).TB_WHTSP." ON wthspcnv_whtsp = id_wthsp
											INNER JOIN "._BdStr(DBM).TB_CL." ON wthsp_cl = id_cl
										WHERE 	whtsp_api = ".GtSQLVlStr(ID_APITHRD_MSVSPC, 'int')." AND
												wthspcnv_est = '"._CId('ID_SCLCNVEST_ON')."' AND
												wthsp_cl = '".$_cl_v->id."' AND
												EXISTS (
													SELECT id_wthspcnvus
													FROM "._BdStr(DBT).TB_WHTSP_CNV_US."
													WHERE wthspcnvus_wthspcnv = id_wthspcnv
												) AND
												EXISTS (
													SELECT id_wthspcnvmsg
													FROM "._BdStr(DBT).TB_WHTSP_CNV_MSG."
													WHERE wthspcnvmsg_wthspcnv = id_wthspcnv
												)
												/* AND
												wthspcnv_cls IS NOT NULL */
										HAVING __rd_lst = 1 OR wthspcnv_f_chk_est IS NULL
										ORDER BY wthspcnv_cls ASC, wthspcnv_fi ASC
										LIMIT 10
									";

							//echo compress_code( $Ls_Qry );

							$LsMsvMsgSnt = $__cnx->_qry($Ls_Qry);

							if($LsMsvMsgSnt){

								$rwMsvCnvEst = $LsMsvMsgSnt->fetch_assoc();
								$TotLsMsvMsgSnt = $LsMsvMsgSnt->num_rows;

								echo $this->h1($_cl_v->nm.' - WhatsApp - MassiveSpace - Status Check  '.$TotLsMsvMsgSnt);

								if($TotLsMsvMsgSnt > 0){

									do {

										try {
											$___datprcs[] = $rwMsvCnvEst;
										} catch (Exception $e) {
											$___lck = $this->Rqu([ 't'=>'msv_cnv_est', 'lck'=>2 ]);
											echo $this->err($e->getConversation());
										}

									} while ($rwMsvCnvEst = $LsMsvMsgSnt->fetch_assoc());

									//---------- Free Query For This Customer ----------//

										$this->Rqu([ 't'=>'msv_cnv_est', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
										$__cnx->_clsr($LsMsvMsgSnt);

									//---------- Release Query For This Customer ----------//

									foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

										if(!isN( $___datprcs_v['wthspcnv_id'] )){

											$__rdt = $this->RquDt([ 't'=>'msv_cnv_est', 'cl'=>$___datprcs_v['wthsp_cl'], 'id'=>$___datprcs_v['id_wthsp'], 'm'=>1 ]);

											$__updchk = $this->_wthsp->UpdF(['t'=>'cnv', 'f'=>[ 'wthspcnv_f_chk_est'=>SIS_F_D2 ], 'id'=>$___datprcs_v['id_wthspcnv'] ]);

											echo $this->h2('Details of channels '.$___datprcs_v['wthspcnv_id'].' Account('.$___datprcs_v['wthsp_no'].') Closed('.$___datprcs_v['wthspcnv_cls'].')');
											echo $this->h3('SumrId:'.$___datprcs_v['id_wthspcnv']);

											if($__updchk->e == 'ok'){
												echo $this->scss('Lock Date Check Success');
											}else{
												echo $this->err('Error on Lock Date Check '.$__updchk->w.' -> '.$__updchk->q);
											}

											$this->_wthsp->rst();

											$__result = $this->_massive->chnl_est([ 'acc'=>$___datprcs_v['wthsp_no'], 'chnl'=>$___datprcs_v['wthspcnv_id'] ]);

											echo $this->li('Tot:'.$__result->rsl->tot);

											if(!isN( $__result->rsl->d )){

												$__cnv_d = $__result->rsl->d;

												$__usr = $this->_wthsp->Chk_Us([ 'usr'=>$__cnv_d->user->username ]); //Validar usuario

												if(isN( $__usr->id )){
													echo $this->err('Username '.$__cnv_d->user->username.' no esta asociado en SUMR','','','ok');
												}

												//---------- Process Conversation - Start ----------//


													if(	$__cnv_d->abandoned == 'ok' ||
														$__cnv_d->archived == 'ok' ||
														!isN($__cnv_d->closed)){
														$_cnv_est = _CId('ID_SCLCNVEST_RDY');
													}else{
														$_cnv_est = NULL;
													}

													echo $this->li(' ---- Abandoned? '.$__cnv_d->abandoned.' ----- ');
													echo $this->li(' ---- Archived? '.$__cnv_d->archived.' ----- ');
													echo $this->li(' ---- Closed? '.$__cnv_d->closed.' ----- ');
													echo $this->li(' ---- Status? '.$_cnv_est.' ----- ');


													$this->_wthsp->wthspcnvmsg_wthspcnv = $___datprcs_v['wthspcnv_id'];
													$this->_wthsp->wthspcnv_est = $_cnv_est;
													$this->_wthsp->wthspcnv_cls = $this->_wthsp->_Tme($__cnv_d->closed);

													$Cnv_Upd = $this->_wthsp->Cnv_Upd();

													if($Cnv_Upd['e'] == 'ok'){
														echo $this->scss(' ---- Updated ----- ');
													}else{
														echo $this->err(' ---- Error '.$Cnv_Upd->w.' -> '.$Cnv_Upd->q.' ----- '.print_r( $Cnv_Upd, true ));
													}


												//---------- Process Conversation - End ----------//

											}

											if(!isN($__result->rsl) && isN($__result->rsl->next) && $__result->rsl->tot == 0){
												$__rqu_all = 1;
												$__rqu_nxt = '';
											}else{
												$__rqu_all='';
												$__rqu_nxt = $__result->rsl->next;
											}

											$__upd_rqu = $this->Rqu([
															't'=>'msv_cnv_est',
															'cl'=>$___datprcs_v['wthsp_cl'],
															'id'=>$___datprcs_v['id_wthsp'],
															'nxt'=>$__rqu_nxt,
															'all'=>$__rqu_all,
															'pge'=>!isN($__rdt->pge)?($__rdt->pge+1):1
														]);

										}

									}

									echo $this->ul($___accin);

								}

							}else{

								echo $this->err( 'Error:'.$__cnx->c_r->error );

							}

							$__cnx->_clsr($LsMsvMsgSnt);

						}

						$this->Rqu([ 't'=>'msv_cnv_est', 'cl'=>$_cl_v->id ]);

					}else{

						echo $this->h1('WhatsApp'.$this->Spn('MassiveSpace Conversations - Run On Next'), 'Auto_Tme_Prg');

					}

				} catch (Exception $e) {


					$this->Rqu([ 't'=>'msv_cnv', 'cl'=>$_cl_v->id ]);

					echo $e->getMessage();

				}

			}else{

				echo $this->nallw($_cl_v->nm.' Whatsapp - Massive - Conversations - Status - Off');

			}

		}

	} catch (Exception $e) {


		$this->Rqu([ 't'=>'msv_cnv_est' ]);

		echo $e->getConversation();

	}

}else{

	echo $this->nallw('Global Whatsapp - Massive - Conversations - Status - Off');

}

?>