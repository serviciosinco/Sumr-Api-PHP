<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml_imap_cnv' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- AUTO TIME CHECK - START --------------------//

		$_AUTOP_d = $this->RquDt([ 't'=>'imap_cnv', 'm'=>2 ]);
		//$_AUTOP_d->e = 'ok';
		//$_AUTOP_d->hb = 'ok';

	//-------------------- AUTO TIME CHECK - END --------------------//


	$_box = $this->_argv->_box?$this->_argv->_box:Php_Ls_Cln($_GET['_box']);
	$_msg = $this->_argv->_msg?$this->_argv->_msg:Php_Ls_Cln($_GET['_msg']);


	if($_AUTOP_d->hb == 'ok' || !isN($_box) || !isN($_msg)){

		if($this->_s_eml->tot > 0){

			foreach($this->_s_eml->ls as $_eml_k=>$_eml_v){

				if( $this->tallw_cl([ 't'=>'key', 'id'=>'eml_imap_cnv', 'cl'=>$_eml_v->cl->id ])->est == 'ok' ){

					try {

						if(!isN($_g_alw->lmt)){ $_lmt_msg = $_g_alw->lmt; }else{ $_lmt_msg = 100; }

						if(class_exists('CRM_Cnx')){

							$__Eml = new CRM_Eml();
							$___datprcs = [];

							if(!isN($_box)){ $__box = $__Eml->EmlBoxDt([ 'enc'=>$_box ]); }else{ $__box=''; }

							if(!isN($__box->box->id)){
								$__f_icnv .= sprintf(' AND emlmsg_eml=%s AND emlmsg_box=%s ',
														GtSQLVlStr($__box->eml, 'text'),
														GtSQLVlStr($__box->box->id, 'text'));
							}

							if(!isN($_msg)){
								$__f_icnv .= sprintf(' AND id_emlmsg = %s ',
														GtSQLVlStr($_msg, 'text'));
							}

							/*$__f_icnv .= " AND id_emlmsg IN (
													SELECT emlmsgref_msg
													FROM "._BdStr(DBT).TB_EML_MSG_REF."
												)";*/

							$Ls_Qry = " SELECT 	id_emlmsg, emlmsg_enc, emlmsg_id, emlmsg_cid, emlmsg_no, emlmsg_uid, emlmsg_inp, emlmsg_eml, emlbox_enc, emlmsg_ref_tot, emlbox_id, emlmsg_fi
										FROM "._BdStr(DBT).TB_THRD_EML_MSG."
												INNER JOIN "._BdStr(DBT).TB_THRD_EML_BOX." ON emlmsg_box = id_emlbox
												INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON emlmsg_eml = id_eml
										WHERE 	eml_tp = '"._CId('ID_SISEML_IMAP')."' AND
												/*eml_onl = 1 AND
												emlbox_est = '1' AND
												emlbox_upd = '1' AND */
												emlmsg_ref_sve = '1' AND
												emlbox_eml = '".$_eml_v->eml->id."' AND
												id_emlmsg NOT IN (
													SELECT emlcnvmsg_msg
													FROM "._BdStr(DBT).TB_THRD_EML_CNV_MSG."
												)
												{$__f_icnv}

										ORDER BY emlmsg_f ASC /* NO CHANGE CAUSE CAN DAMAGE THE RELATION TO CONVERSATION */
										LIMIT {$_lmt_msg}";


							echo compress_code( $Ls_Qry );

							$LsImapCnv = $__cnx->_qry($Ls_Qry);

							if($LsImapCnv){

								$row_LsImapCnv = $LsImapCnv->fetch_assoc();
								$Tot_LsImapCnv = $LsImapCnv->num_rows;
								echo $this->h1('Imap - Mail - Threads '.$Tot_LsImapCnv);

								if($Tot_LsImapCnv > 0){

									do {
										if(!isN($row_LsImapCnv['emlmsg_enc'])){
											$___datprcs[] = $row_LsImapCnv;
										}
									} while ($row_LsImapCnv = $LsImapCnv->fetch_assoc());

								}

								$this->Rqu([ 't'=>'imap_cnv' ]);

							}else{

								echo $this->err($__cnx->c_r->error);

							}


							$__cnx->_clsr($LsImapCnv);


							if(!isN( $___datprcs ) && count($___datprcs) > 0){

								$__EmlCnv = new CRM_Eml();
								$__Imap = new CRM_Imap();

								foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

									try {

										$rw = $___datprcs_v;

										//-------------------- GLOBAL VAR FOR EML INSIDE - START --------------------//

										$__prc_in='ok'; // Dfault action to save, instead problem in process... it doesnt save the data
										$__emlid = $___datprcs_v['emlmsg_eml'];

										//-------------------- VARIABLES INICIALES DE LOOP - START --------------------//

										echo $this->h1( 'Processing message '.$rw['emlmsg_enc'].' => '.$rw['emlmsg_cid'] );
										$__msgid = $rw['id_emlmsg'];
										$__msgdt = $__Eml->EmlMsgDt([ 't'=>'enc', 'id'=>$rw['emlmsg_enc'], 'r_bdy'=>'no', 'd'=>[ 'attr'=>'ok', 'ref'=>'ok' ] ]);

										if(!isN($__msgdt->id)){ //print_r( $__msgdt->attr );

											$__msgsbj = $__msgdt->attr->subject;
											$__replyto = $__msgdt->attr->in_reply_to;
											$__uid = $__msgdt->attr->message_id;
											$__sumrmsgref = $__msgdt->ref;

											if($__sumrmsgref->e != 'ok'){
												echo $this->err('$__sumrmsgref error:'.print_r($__sumrmsgref->w, true));
												continue;
											}

											//echo $this->h2( print_r( $__msgdt->ref ), true );
											$__refli = '';

											$__has_ref = 'no';
											$__has_rto = 'no';
											$__msgdt_rto_id = '';

											//-------------------- EXISTE ID DE REPLY TO - START --------------------//

											if(!isN($__replyto)){

												$__has_rto = 'ok';

												if(!isN($__replyto)){

													$__msgdt_rto = $__Eml->EmlCnvDt([ 'eml'=>$__emlid, 'cnv_id'=>enCad($__replyto) ]);
													echo $this->li('Search in-reply-to ('.$__replyto.')');

													if($__msgdt_rto->e == 'no'){
														echo $this->err('EmlCnvDt First Check Error:'.print_r($__msgdt_rto->w, true));
														continue;
													}

													if( !isN($__msgdt_rto->id) ){ // Existe en DB asi que se puede relacionar

														$__msgdt_rto_id = $__replyto;
														echo $this->li('Id:'.$__msgdt_rto->id);

													}else{ // No exists by conversation, so search conversation on reply to message

														$__msgdt_rto = $__Eml->EmlMsgDt([ 't'=>'enc', 'mid'=>enCad($__replyto), 'r_bdy'=>'no' ]);

														echo $this->li('Search in-reply-to by conversation related ('.$__replyto.')');

														if($__msgdt_rto->e == 'no'){
															echo $this->err('EmlCnvDt Second Check Error:'.print_r($__msgdt_rto->w, true));
															continue;
														}

														if( !isN($__msgdt_rto->cnv->id) ){ // Existe en DB asi que se puede relacionar
															$__msgdt_rto_id = $__msgdt_rto->cnv->cid;
															echo $this->li('Id conversation related to message replyto:'.$__msgdt_rto->cnv->id);
														}else{
															$__prc_in = 'no';
															echo $this->li('Message ReplyTo Not Found');
														}
													}


												}

											}else{

												$__msgdt_rto_ul = '';

											}

											//-------------------- EXISTE ID EN ATTRIBUTOS DE RELACIÓN - START --------------------//

											if(isN($__msgdt_rto_id)){

												if($___datprcs_v['emlmsg_ref_tot'] > 0){
													$__has_ref='ok';
												}

												if( !isN($__sumrmsgref) ){

													//echo $this->li('$__sumrmsgref:'.print_r($__sumrmsgref, true));

													if($__sumrmsgref->tot > 0){

														$__has_ref='ok';
														$__refli='';

														foreach($__sumrmsgref->ls as $__ref_k=>$__ref_v){

															if(!isN( $__ref_v->id )){
																$__refli .= $this->li( $__Eml->IdH($__ref_v->id) );
															}else{
																$__refli .= $this->li('Empty Value $__ref_v:'.print_r($__ref_v, true));
															}

														}
													}

													$__has_ref_ul = $this->ul( $__refli );

												}else{

													$__has_ref_ul='';

												}

												if($__has_ref=='ok' || $__has_rto=='ok'){ $_clr='blue'; }else{ $_clr='green'; }

											}

											//-------------------- DETERMINA ID DE HILO - START --------------------//

											$__cnv_id = NULL;
											$__msg_mtch = [];


											if($__has_ref=='no' && $__has_rto == 'no'){

												echo $this->li('Has no relation to another messages, so create individual cnv');
												$__cnv_id = $___datprcs_v['emlmsg_cid'];  // No tiene parents, ID de hilo es el mismo mensaje

											}else{

												echo $this->li('Try search in other match elements');

												if($__has_rto=='ok' && !isN($__msgdt_rto_id)){
													echo $this->li('Has replyto ID, so have to search conversation to match');
													$__cnv_id = $__msgdt_rto_id;  // Existe un
												}

												if($__has_ref=='ok' && isN($__cnv_id)){

													echo $this->li('Has to search by reply');

													//print_r( $__sumrmsgref->ls );

													foreach($__sumrmsgref->ls as $__ref_k=>$__ref_v){

														$_sch_r = NULL;

														if(!isN( $__ref_v->id )){

															if(!isN($__ref_v->id)){

																echo $this->li('Search for match messages on:'. $__Eml->IdH($__ref_v->id) );

																$_sch_r = $__Eml->EmlMsgCnv_Mtch([ 'msg'=>$rw['id_emlmsg'], 'eml'=>$__emlid, 'cid'=>$__ref_v->id ]);

																if(!isN($_sch_r->w)){
																	echo $this->err('$_sch_r: error on query '.print_r($_sch_r->w, true)); exit();
																}else if($_sch_r->e != 'ok'){
																	echo $this->err('$_sch_r: error on query '.print_r($_sch_r->w, true));
																	continue;
																}

															}

															if($_sch_r->e == 'ok'){

																if($_sch_r->tot > 0){

																	foreach($_sch_r->ls as $_ref_r_k=>$_ref_r_v){

																		//echo $this->h2( print_r($_ref_r_v, true) );

																		if(!isN( $_ref_r_v->id )){

																			echo $this->li('Related to message ref:'.$_ref_r_v->enc.' ('.$_ref_r_v->cid.')');

																			if(!isN($_ref_r_v->cnv->id) && !isN($_ref_r_v->cnv->enc) && isN($__cnv_id)){
																				echo $this->li('Related to conversation:'.$_ref_r_v->cnv->enc);
																				if($_ref_r_v->is_older == 'ok'){ $__cnv_id = $_ref_r_v->cnv->id; }
																				break;
																			}

																			$__msg_mtch[] = $_ref_r_v->id;


																		}

																	}

																}else{

																	echo $this->li('Nothing related on match search');

																}

																//-------------------- CNV ID NOT FOUND --------------------//

																	if(isN($__cnv_id) && ($___datprcs_v['emlmsg_ref_tot'] == 0 || $___datprcs_v['emlmsg_fi'] < strtotime('-30 days'))){
																		echo $this->li('Has to set conversation to same of message '.$__Eml->IdH($___datprcs_v['emlmsg_cid']) );
																		echo $this->li('Cause emlmsg_ref_tot is '.$___datprcs_v['emlmsg_ref_tot'] );
																		echo $this->li('Cause emlmsg_fi is '.$___datprcs_v['emlmsg_fi'] );
																		$__cnv_id = $___datprcs_v['emlmsg_cid'];
																	}

																//-------------------- CNV ID IS THE SAME OF MESSAGE ID --------------------//

															}

														}else{

															echo $this->li('Empty Value $__ref_v:'.print_r($__ref_v, true));

														}

													}

												}elseif(isN($__cnv_id)){

													echo $this->li('No nothing related ----- LEAVE ID MESSAGE as same Conversation');
													//$__cnv_id_shw = 'Has parent:'.print_r($__msgdt->attr, true);
													$__cnv_id = $___datprcs_v['emlmsg_cid'];

												}

											}

											if(!isN($__msg_mtch)){
												$__msg_mtch = array_unique($__msg_mtch);
												//echo $this->li('Add this message to match'.print_r($__msg_mtch, true));
											}

											if(!isN($__cnv_id) && !isN($__msgid)){

												echo $this->li('Lets try with cnv '.$__cnv_id);

												$__EmlCnv->__t = 'eml_cnv';
												$__EmlCnv->emlcnv_id = $__cnv_id;
												$__EmlCnv->emlcnv_eml = $rw['emlmsg_eml'];
												$__EmlCnv->emlcnv_snpt = $__msgsbj;
												$__EmlCnv->emlmsg__msg = $__msgid;

												if(!isN($__msg_mtch)){
													$__EmlCnv->emlmsg__mtch = $__msg_mtch;
												}else{
													$__EmlCnv->emlmsg__mtch = NULL;
												}

												$__Prc_In = $__EmlCnv->In();

												if($__Prc_In->e == 'ok' && !isN($__Prc_In->id) && !isN($__Prc_In->cnv_e) && $__Prc_In->cnv_e > 0){

													echo $this->scss('Inserted conversation success / id:'.$__Prc_In->id.' / cnv: '.$__msgid);

													foreach($__Prc_In->cnv  as $_cnv_k=>$_cnv_v){
														echo $this->scss('Message - Conversation Id:'.$_cnv_v->id);
													}

												}else{
													if(!isN($__Prc_In->w)){ echo $this->err('$__EmlCnv->In: Not inserted conversation '.print_r($__Prc_In->w, true)); }
													if(isN($__Prc_In->cnv->id)){
														echo $this->err('Conversation not related to message');
														echo $this->err('Conversation data:'.print_r($__Prc_In->cnv, true));
													}
												}

											}else{

												echo $this->err('THERE IS NO ID FOR CONVERSATION RELATION');
												$__Prc_In=NULL;

											}

											//-------------------- UPDATE BOX F CHECK --------------------//

											$__upd_chk = $__Eml->Upd_Eml_Fld([
												't'=>'box',
												'id'=>$___datprcs_v['emlbox_enc'],
												'fld'=>[[
													'k'=>'emlbox_cnv_chk',
													'v'=>SIS_F_TS
												]],
											]);

											//-------------------- DESPLIEGA DETALLE - START --------------------//

											echo $this->li( $this->Spn('No: '.$rw['emlmsg_no']) );
											echo $this->li( $this->Spn('Uid: '.$rw['emlmsg_uid']) );
											echo $this->li( $this->Spn('Inp: '.$rw['emlmsg_inp']) );
											echo $this->li( $this->Spn('Date: '.$__msgdt->f) );
											echo $this->li( $this->Spn('Subject:'.$__msgdt->attr->subject).'Id:'.$rw['id_emlmsg'] );
											echo $this->li( $this->Spn('MSG Id:'.$___datprcs_v['emlmsg_cid']) );
											echo $this->li( $this->Spn('CNV Id:'.$__cnv_id, '', '', 'color:#8de0ff;') );
											//echo $this->li( $this->Spn('CNV Id Show:'.$__cnv_id_shw, '', '', 'color:#8de0ff;') );
											echo $this->li( $this->Spn('Has IN-Reply To:'.$__has_rto.'  '. $this->Spn($__msgdt_rto_id, '', '', 'color:purple;') . $__msgdt_rto_ul ) );

											if(!isN($__replyto)){
												echo $this->li( $this->Spn('IN-Reply To:'.$__replyto) );
											}

											echo $this->li( $this->Spn('Has References ('.$__sumrmsgref->tot.'):'.$__has_ref.$__has_ref_ul) );

											if($__upd_chk->e == 'ok' && $__Prc_In->e == 'ok'){

												echo $this->li( $this->Spn('In Prc ('.$__cnv_id.'->'.$__msgid.') '/*.print_r($__Prc_In, true)*/ ) );

											}else{

												echo $this->err('No update conversation date check '.print_r($__Prc_In->w, true).' for message '.$rw['id_emlmsg'] );

											}

										}else{

											echo $this->err('There are no data about this message');

										}

									}catch(LoopingMsg $w){

										echo 'Excepción capturada: ',  $w->getMessage(), "\n";

									}

								}


								foreach($__refmsg as $__refmsg_k=>$__refmsg_v){

									if($__refmsg_v['tot'] > 1){

										/*
										echo $__refmsg_k.'</br>
											->Eml:'.$__refmsg_v['eml'].'</br>
											->Date:'.$__refmsg_v['f'].'</br>
											->Object:'.$__refmsg_v['o'].'</br>
											->Tot:'.$this->Spn($__refmsg_v['tot']).'</br></br>';
										*/

										$__EmlCnvR = new CRM_Eml();

										$__EmlCnvR->__t = 'eml_cnv';
										$__EmlCnvR->emlcnv_id = $__refmsg_k;
										$__EmlCnvR->emlcnv_eml = $__refmsg_v['eml'];
										$__PrcR_In = $__EmlCnvR->In();

										if($__PrcR_In->e == 'ok'){
											echo $this->scss('Conversation Inserted ok');
										}else{
											echo $this->err('Conversation not inserted '.$__PrcR_In->w);
										}

									}

								}

							}




						}

					} catch (Exception $e) {

						echo $e->getMessage();

					}
				}
			}
		}

	}

}else{

	echo $this->nallw('Global Email - Imap - Get Conversation - Off');

}


?>