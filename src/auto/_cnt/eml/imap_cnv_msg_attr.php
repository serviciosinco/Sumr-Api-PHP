<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml_imap_cnv_msg_attr' ]);

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
					
					if(!isN($_g_alw->lmt)){ $_lmt_msg = $_g_alw->lmt; }else{ $_lmt_msg = 50; }
					
					if(class_exists('CRM_Cnx')){
						
						$Ls_Qry = " SELECT id_emlmsg, emlmsg_id, emlmsg_no, emlmsg_uid, emlmsg_eml, emlbox_id
									FROM "._BdStr(DBT).TB_THRD_EML_MSG."
										INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON emlmsg_eml = id_eml
										INNER JOIN "._BdStr(DBT).TB_THRD_EML_BOX." ON emlmsg_box = id_emlbox
									WHERE 	emlmsg_attr_sve = 2 AND
											eml_tp = '"._CId('ID_SISEML_IMAP')."' AND
											emlbox_eml = '".$_eml_v->eml->id."' AND
											(NOW() > DATE_ADD(eml_attr_chk, INTERVAL +2 MINUTE) || eml_attr_chk IS NULL) AND
											eml_onl = 1 AND
											(eml_cnct = 2 || eml_rd_f < NOW() - INTERVAL ".UNLCK_MIN." MINUTE)
									ORDER BY RAND()
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

											echo $this->h2('EmlDt:'.$__emlid.' Message:'.$___datprcs_v['id_emlmsg'].' / uid:'.$___datprcs_v['emlmsg_no'].' / box:'.$___datprcs_v['emlbox_id']);
											
											if($__Imap->box != $___datprcs_v['emlbox_id']){ $ropn='ok'; }

											$__Imap->c_eml = $__emlid;
											$__Imap->box = $___datprcs_v['emlbox_id'];
											
											$msg_hdr = $__Imap->_hdr([ 'id'=>$___datprcs_v['emlmsg_no'], 'ropn'=>$ropn ]);

											if(isN($msg_hdr->w)){

												if($msg_hdr->tot > 0){

													echo $this->h1( 'Attributes:'.$msg_hdr->tot );

													$__Eml->emlmsg_id_upd = $___datprcs_v['id_emlmsg'];
													$__Eml->eml_attr = $msg_hdr->ls;
													$__Prc_Attr = $__Eml->Eml_Attr([ 'tp'=>'msg' ]);
													
													if($__Prc_Attr->e == 'ok' && $msg_hdr->tot == $__Prc_Attr->p->tot){

														$__Eml->__t = 'eml_msg';
														$__Eml->emlmsg_id = $___datprcs_v['emlmsg_id'];
														$__Eml->emlmsg_eml = $__emlid;
														$__Eml->emlmsg_attr_sve = 1;
														$__Prc_Msg = $__Eml->In([ 'box'=>'no' ]);

														if($__Prc_Msg->e == 'ok'){
															echo $this->scss('Update attributes on message success');
														}else{
															echo $this->err('Problem on update '.$__Prc_Msg->w);
															print_r( $__Prc_Msg );
														}

													}else{

														echo $this->err('Problem on $__Prc_Attr '.print_r($__Prc_Attr, true));
														echo $this->err('$msg_hdr->tot '.$msg_hdr->tot);
														echo $this->err('$__Prc_Attr->p->tot '.$__Prc_Attr->p->tot);

													}

												}

											}else{

												echo $this->err('Problem on get attributes '.$msg_hdr->w);

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
								'k'=>'eml_attr_chk',
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

	echo $this->nallw('Global Email - Imap - Get Messages - Attributes - Off');

}	
	
?>