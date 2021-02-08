<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml_imap_cnv_msg_attch' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- AUTO TIME CHECK - START --------------------//

		$_AUTOP_d = $this->RquDt([ 't'=>'imap_cnv_msg_html', 'm'=>1 ]);
		//$_AUTOP_d->e = 'ok';
		//$_AUTOP_d->hb = 'ok';
		$___datprcs = [];

	//-------------------- AUTO TIME CHECK - END --------------------//

	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

		if($this->_s_eml->tot > 0){

			foreach($this->_s_eml->ls as $_eml_k=>$_eml_v){

				try {

					if(!isN($_g_alw->lmt)){ $_lmt_msg = $_g_alw->lmt; }else{ $_lmt_msg = 100; }

					if(class_exists('CRM_Cnx')){

						if(!isN($this->g__i )){
							$qry_f = " AND emlmsg_enc = '".$this->g__i."'";
						}else{
							$qry_f = '';
						}

						$Ls_Qry = " SELECT id_emlmsg, emlmsg_id, emlmsg_cid, emlmsg_no, emlmsg_uid, emlmsg_eml, emlmsg_box, emlbox_id, emlmsg_attch_tot
									FROM "._BdStr(DBT).TB_THRD_EML_MSG."
										INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON emlmsg_eml = id_eml
										INNER JOIN "._BdStr(DBT).TB_THRD_EML_BOX." ON emlmsg_box = id_emlbox
									WHERE 	emlmsg_attch_sve = 2 AND
											eml_tp = '"._CId('ID_SISEML_IMAP')."' AND
											eml_onl = 1 AND
											(eml_cnct = 2 || eml_rd_f < NOW() - INTERVAL ".UNLCK_MIN." MINUTE) AND
											emlbox_eml = '".$_eml_v->eml->id."' AND
											(NOW() > DATE_ADD(eml_attch_chk, INTERVAL +2 MINUTE) || eml_attch_chk IS NULL)
											{$qry_f}
									ORDER BY emlmsg_f DESC
									LIMIT {$_lmt_msg}"; //echo $Ls_Qry;

						$LsImapCnvMsgHtml = $__cnx->_qry($Ls_Qry);

						if($LsImapCnvMsgHtml){

							$row_LsImapCnvMsgHtml = $LsImapCnvMsgHtml->fetch_assoc();
							$Tot_LsImapCnvMsgHtml = $LsImapCnvMsgHtml->num_rows;

							echo $this->h1('Imap - Mail - Messages - Html - '.$Tot_LsImapCnvMsgHtml);

							if($Tot_LsImapCnvMsgHtml > 0){

								do {
									try {
										$___datprcs[] = $row_LsImapCnvMsgHtml;
									}catch(LoopingMsg$w){
										echo 'Excepción capturada: ',  $w->getMessage(), "\n";
									}
								} while ($row_LsImapCnvMsgHtml = $LsImapCnvMsgHtml->fetch_assoc());

							}

						}else{

							echo $this->err($__cnx->c_r->error);

						}

						$__cnx->_clsr($LsImapCnvMsgHtml);

						if(!isN( $___datprcs ) && count($___datprcs) > 0){

							$__Imap = new CRM_Imap();
							$__Eml = new CRM_Eml();

							foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

								try {

									//-------------------- GLOBAL VAR FOR EML INSIDE - START --------------------//

										$__emlid = $___datprcs_v['emlmsg_eml'];

									//-------------------- CHECK IS IN / OUT - END --------------------//

										if(!isN($__emlid)){

											echo $this->h2('EmlDt:'.$__emlid.' Message:'.$___datprcs_v['id_emlmsg'].' / uid:'.$___datprcs_v['emlmsg_no'].' / box_id:'.$___datprcs_v['emlmsg_box'].' / box_label:'.$___datprcs_v['emlbox_id']);

											if($__Imap->box != $___datprcs_v['emlbox_id']){ $ropn='ok'; }

											$__Imap->c_eml = $__emlid;
											$__Imap->box = $___datprcs_v['emlbox_id'];

											$msg_attch = $__Imap->_attch([ 'id'=>$___datprcs_v['emlmsg_no'], 'ropn'=>$ropn ]);

											echo $this->h2('Attach:'. $msg_attch['tot'].' -> BD:'. $___datprcs_v['emlmsg_attch_tot'] );

											if(isN($msg_attch->w) && $msg_attch['tot'] == $___datprcs_v['emlmsg_attch_tot']){

												if($msg_attch['tot'] > 0){

													$attch_scss = 0;
													echo $this->h1( 'Attachments:'.count($msg_attch) );

													foreach($msg_attch['ls'] as $msg_attch_k=>$msg_attch_v){

														if(!isN($msg_attch_v['filename']) && !isN($msg_attch_v['content'])){

															$__Eml->__t = 'eml_msg_attch';
															$__Eml->emlmsg_cid = $___datprcs_v['emlmsg_id'];
															$__Eml->emlmsg_eml = $__emlid;
															$__Eml->emlmsgattch_cid = $msg_attch_v['id'];
															$__Eml->emlmsgattch_enc = $___datprcs_v['emlmsg_id'];
															$__Eml->emlmsgattch_emlmsg = $___datprcs_v['id_emlmsg'];
															$__Eml->emlmsgattch_name = $msg_attch_v['filename'];
															$__Eml->emlmsgattch_type = $msg_attch_v['type'];
															$__Eml->emlmsgattch_sze = $msg_attch_v['size'];
															$__Eml->emlmsgattch_fle = $msg_attch_v['content'];
															$__Eml->emlmsgattch_embd = $msg_attch_v['embed'];
															$__Prc_Attch = $__Eml->In([ 'box'=>'no' ]);

															if($__Prc_Attch->e == 'ok'){
																echo $this->scss('Attachment '.$msg_attch_v['filename'].' saved success');
																//echo $this->scss('Query:'.print_r($__Prc_Attch, true));
																$attch_scss++;
															}else{
																echo $this->err('Problem on save attachment '.$msg_attch_v['filename'].' '.$__Prc_Attch->w);
																echo $this->err( compress_code( print_r($__Prc_Attch, true) ) );
															}

														}else{
															echo $this->err('Problem on get content and name');
															echo $this->err( compress_code(print_r($msg_attch_v,true)) );
														}

													}

													if($attch_scss == count($msg_attch)){

														$__Eml->__t = 'eml_msg';
														$__Eml->emlmsg_id = $___datprcs_v['emlmsg_id'];
														$__Eml->emlmsg_eml = $__emlid;
														$__Eml->emlmsg_attch_sve = 1;
														$__Eml->emlmsg_attch_tot = count($msg_attch);
														$__Eml->emlmsg_enc = $___datprcs_v['emlmsg_enc'];
														$__Prc_Msg = $__Eml->In([ 'box'=>'no' ]);

														if($__Prc_Msg->e == 'ok'){
															echo $this->scss('Update attachments on message success');
														}else{
															echo $this->err('Problem on update '.$__Prc_Msg->w);
															echo $this->err( compress_code( print_r($__Prc_Msg, true) ) );
														}

													}

												}else{

													$__Eml->__t = 'eml_msg';
													$__Eml->emlmsg_id = $___datprcs_v['emlmsg_id'];
													$__Eml->emlmsg_eml = $__emlid;
													$__Eml->emlmsg_attch_sve = 1;
													$__Eml->emlmsg_attch_tot = 0;
													$__Prc_Msg = $__Eml->In([ 'box'=>'no' ]);

													if($__Prc_Msg->e == 'ok'){
														echo $this->scss('Update attachments success');
													}else{
														echo $this->err('Problem on update '.$__Prc_Msg->w);
														print_r( $__Prc_Msg );
													}

													echo $this->err('Has not attachments');


												}

											}else{

												echo $this->err('Problem on get attachments '.$msg_attch->w);
												echo $this->err('$msg_attch[tot] ('.$msg_attch['tot'].') / $___datprcs_v[emlmsg_attch_tot] ('.$___datprcs_v['emlmsg_attch_tot'].')');

											}

										}else{
											echo $this->err('Empty response on $__emlid '.$__emlid);
										}

								}catch(LoopingMsg $w){

									echo 'Excepción capturada: ',  $w->getMessage(), "\n";

								}

							}
						}


						$__upd_chk = $__Eml->Upd_Eml_Fld([
							't'=>'eml',
							'id'=>$_eml_v->eml->enc,
							'fld'=>[[
								'k'=>'eml_attch_chk',
								'v'=>SIS_F_TS
							]],
						]);

					}

				} catch (StartSQL $e) {

					echo $e->getMessage();

				}

			}

		}

	}

}else{

	echo $this->nallw('Global Email - Imap - Get Messages - Html - Off');

}

?>