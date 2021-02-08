<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml_gmail_cnv_msg' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- AUTO TIME CHECK - START --------------------//

		$_AUTOP_d = $this->RquDt(['t'=>'gmail_cnv_msg', 'm'=>15]); 

	//-------------------- AUTO TIME CHECK - END --------------------//


	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){
		
		
		try {
			
			$_emlcnv = Php_Ls_Cln($_GET['emlcnv']);
			
			
			if(class_exists('CRM_Cnx')){
			
				
				
				if(!isN($_emlcnv)){
					
					$___f_stnd = sprintf(" AND id_emlcnv = %s", GtSQLVlStr($_emlcnv, "int"));
					
				}else{
					
					$___f_stnd = " HAVING 
										( ___msg_tot < 1 || ___msg_tot != emlcnv_tot || ___msg_box_tot < 1 || ___msg_addr_non < 2) /*AND 
										(NOW() > DATE_ADD(emlcnv_f_chk, INTERVAL +1 HOUR) || emlcnv_f_chk IS NULL)*/  ";
								
				}
				
				$Ls_Qry = " SELECT *,
									
									NOW() AS ___now,
									DATE_ADD(emlcnv_f_chk, INTERVAL +1 HOUR) AS __now_chk,
									
								(SELECT COUNT(*) 
										FROM "._BdStr(DBT).TB_THRD_EML_MSG." 
											INNER JOIN "._BdStr(DBT).TB_THRD_EML_CNV_MSG." ON emlcnvmsg_msg = id_emlmsg
										WHERE emlcnvmsg_cnv = id_emlcnv) AS ___msg_tot,
										
								(SELECT COUNT(*) 
										FROM "._BdStr(DBT).TB_THRD_EML_MSG_BOX." 
											INNER JOIN "._BdStr(DBT).TB_THRD_EML_MSG." ON emlmsgbox_msg = id_emlmsg
											INNER JOIN "._BdStr(DBT).TB_THRD_EML_CNV_MSG." ON emlcnvmsg_msg = id_emlmsg
										WHERE emlcnvmsg_cnv = id_emlcnv
								) AS ___msg_box_tot,
								
								
								(SELECT COUNT(*) 
										FROM "._BdStr(DBT).TB_THRD_EML_MSG_ADDR."
											INNER JOIN "._BdStr(DBT).TB_THRD_EML_MSG." ON emlmsgaddr_msg = id_emlmsg
											INNER JOIN "._BdStr(DBT).TB_THRD_EML_CNV_MSG." ON emlcnvmsg_msg = id_emlmsg
										WHERE emlcnvmsg_cnv = id_emlcnv
								) AS ___msg_addr_non,
									
								DATE_ADD(emlcnv_f_chk, INTERVAL +4 HOUR) AS __datewait	   
									
							FROM "._BdStr(DBT).TB_THRD_EML_CNV."
		
								INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON emlcnv_eml = id_eml 
								INNER JOIN "._BdStr(DBT).TB_THRD_EML_BOX." ON emlbox_eml = id_eml
								
							WHERE 	eml_tp = '"._CId('ID_SISEML_IMAP')."' AND 
									eml_onl = 1 AND 
									emlbox_est = 1
									{$___f_stnd}
							
							ORDER BY RAND()
							LIMIT 50"; 
													
				$Ls_G_Cnv_Msg = $__cnx->_qry($Ls_Qry);
				
						
				if($Ls_G_Cnv_Msg){
					
					$row_Ls_G_Cnv_Msg = $Ls_G_Cnv_Msg->fetch_assoc(); $Tot_Ls_G_Cnv_Msg = $Ls_G_Cnv_Msg->num_rows; 
					
					echo $this->h1('Gmail - Mail - Threads - Messages '.$Tot_Ls_G_Cnv_Msg);
					
					echo '<ul style="list-style-type:none;">';
					
					if($Tot_Ls_G_Cnv_Msg > 0){						
						
						$client = _gapi_str();
						$sumrgapi = new API_GAPI();
						$thrdeml = new CRM_Eml();
						
						do {
		
							
							$__id_eml = $row_Ls_G_Cnv_Msg['id_eml'];
							$__id_thread = ctjTx($row_Ls_G_Cnv_Msg['emlcnv_id'],'in');
							$__id_emlcnv = $row_Ls_G_Cnv_Msg['id_emlcnv'];
							$__enc_thread = $row_Ls_G_Cnv_Msg['emlcnv_enc'];
							
							$sumrgapi->cl = $row_Ls_G_Cnv_Msg['cl_enc'];
							$sumrgapi->eml = $row_Ls_G_Cnv_Msg['eml_enc'];
							$sumrgapi->us = $row_Ls_G_Cnv_Msg['us_enc'];
							$__ustkn = $sumrgapi->tkn_chk();
							
							if($__ustkn->e == 'ok' && !isN($__ustkn->cod) && !isN($__id_thread)) {
								
								$__EmlBd = new CRM_Eml();
								$__RquDt = $__EmlBd->RquDt([ 'md'=>'eml', 'tp'=>'cnv_msg', 'eml'=>$__id_eml ]);      
										
								try{
									
									
									$sumrgapi->service_token = $__ustkn->cod;
									$client->setAccessToken( $__ustkn->cod );
									$gmail = new Google_Service_Gmail($client);
									
									//-------------------- GET MESSAGES --------------------//
									
										
										$thread = $gmail->users_threads->get("me", $__id_thread);
										$messages = $thread->getMessages();
									
									
									//-------------------- GET MESSAGES --------------------//
		
									
									foreach ($messages as $mlist) {
										
										if(!isN($mlist->id)){
											
											$message = $gmail->users_messages->get('me', $mlist->id);
											if(in_array("INBOX", $message->labelIds)){ $drct='INBOX'; }
											elseif(in_array("CHAT", $message->labelIds)){ $drct='CHAT'; }
											else{ $drct='SENT'; }
												
												
											echo '<ul style="border:1px solid green; margin-bottom:20px; padding:20px; ">';
												
												
												echo $this->h2('Labels before:'.print_r($message->labelIds, true));
												
												$message_d = _gmail_message_dt($gmail, $mlist, $drct);
											
											
												if($row_Ls_G_Cnv_Msg['___msg_addr_non'] < 2){
													echo li('No Addr: '.$row_Ls_G_Cnv_Msg['___msg_addr_non'], '', 'color:red;');
												}
												if($row_Ls_G_Cnv_Msg['___msg_tot'] < 1){
													echo li('Mensajes In: '.$row_Ls_G_Cnv_Msg['___msg_tot'], '', 'color:red;');
												}
												if($row_Ls_G_Cnv_Msg['___msg_tot'] != $row_Ls_G_Cnv_Msg['emlcnv_tot']){
													echo li('Tot Different Count: '.$row_Ls_G_Cnv_Msg['___msg_tot'].' - Bd Tot:'.$row_Ls_G_Cnv_Msg['emlcnv_tot'], '', 'color:red;');
												}
												if($row_Ls_G_Cnv_Msg['___msg_box_tot'] < 1){
													echo li('Box Tot: '.$row_Ls_G_Cnv_Msg['___msg_box_tot'], '', 'color:red;');
												}										
												if($row_Ls_G_Cnv_Msg['___now'] > $row_Ls_G_Cnv_Msg['__now_chk']){
													echo li('Now: '.$row_Ls_G_Cnv_Msg['___now'].' vs. '.$row_Ls_G_Cnv_Msg['__now_chk'], '', 'color:red;');
												}
												
												/*
													
												echo li('Msg Id: '.$mlist->id);
												echo li('Date Enter: '. $message->internalDate );
												echo li('Date: '. $this->Spn( date('Y-m-d H:i:s.u', $message->internalDate/1000) ) );
												echo li('Drct: '.$drct);
												echo li('Thread: '.$mlist->threadId);
												echo li('Conversation: '.$__id_emlcnv);
												//echo li('Details: '.print_r($message_d, true));
												echo li('Label: '.print_r($message->labelIds, tue));
												echo li('Snippet: '.$message_d->snippet);
												echo li('From: '.print_r($message_d->from, true) );
												echo li('To: '.print_r($message_d->to, true) );
												echo li('Cc: '.print_r($message_d->cc, true) );
												echo li('Reply: '.print_r($message_d->rto, true) );
												//echo li('To Tmp: '.print_r($message_d->to_tmp, true) );
											
												*/
											
											
												$__EmlBd->__t = 'eml_msg';
												$__EmlBd->emlmsg_id = $mlist->id;
												$__EmlBd->emlmsg_f = date('Y-m-d H:i:s.u', $message->internalDate/1000);
												$__EmlBd->emlmsg_inp = 'non';
												$__EmlBd->emlmsg_eml = $__id_eml;
												$__EmlBd->emlmsg_bdy_html = $message_d->body->cod;
												$__EmlBd->emlmsg_bdy_sze = $message_d->body->sze;
												$__EmlBd->emlmsg_attr = $message_d->attr;
												$__EmlBd->emlmsg_box = $message->labelIds;
												$__EmlBd->emlmsg__cnv = $__id_emlcnv;
												$__EmlBd->emlmsg__addr = [
																	'from'=>$message_d->from,
																	'to'=>$message_d->to,
																	'cc'=>$message_d->cc
																];	
																
												$__PrcGmailCnvMsg = $__EmlBd->In();
												
												if($__PrcGmailCnvMsg->e == 'ok'){ 
													
													echo li('Mensajes In: '.$row_Ls_G_Cnv_Msg['___msg_tot']); 	 
													echo li('Conversación ID: '.$__id_emlcnv); 
													echo li('Conversación Result: '.json_encode($__PrcGmailCnvMsg) );
													
												}
		
											
											echo '</ul>';
											
											
										
										}
									}
									
									/*	
									$__EmlBd->Rqu([
										'md'=>'eml',
										'tp'=>'cnv_msg',
										'eml'=>$__id_eml,
										'nxt'=>$messages_nxt		
									]);
									*/
								
								} catch (Exception $e) {
									
									echo ' Thread: '.$__id_thread.' <br> '.Strn('ERROR on Api: '). $this->Spn( $e->getMessage(), '', '' , 'color:red;').'<br><br><br><br><br><br>' ;
								}
								
								
								$thrdeml->emlcnv_enc = $__enc_thread;
								$thrdeml->emlcnv_f_chk = SIS_F_TS;
								$thrdeml->_upd_fld([ 't'=>'cnv', 'f'=>'f_chk' ]);
							
							
							}else{
								
								echo $this->h2( TX_EMLNOSTP, '_nostup' );	
								
							}
							
							//echo '</div>';
								
						} while ($row_Ls_G_Cnv_Msg = $Ls_G_Cnv_Msg->fetch_assoc()); 
						
						//echo $this->ul($___accin);
					}
					
					echo '</ul>';
					
					
					$this->Rqu([ 't'=>'gmail_cnv_msg' ]);
					
					
				}else{
					
					echo $this->err($__cnx->c_r->error);
					
				}
				
				
				$__cnx->_clsr($Ls_G_Cnv_Msg);
				
			}
		
		} catch (Exception $e) {
			
			echo $e->getMessage();
			
		}

	}

}else{

	echo $this->nallw('Global Email - Gmail - Get Messages - Off');

}	
	
?>