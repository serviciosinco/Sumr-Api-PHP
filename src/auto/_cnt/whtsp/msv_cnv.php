<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'whtsp_msv_cnv' ]);

if( $_g_alw->est == 'ok' ){
		
	if($this->_s_cl->tot > 0){

		foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

			if( $this->tallw_cl([ 't'=>'key', 'id'=>'whtsp_msv_cnv', 'cl'=>$_cl_v->id ])->est == 'ok' ){

				try {

					//-------------------- AUTO TIME CHECK - START --------------------//

						$_AUTOP_d = $this->RquDt([ 't'=>'msv_cnv', 'cl'=>$_cl_v->id, 'm'=>2 ]);

					//-------------------- AUTO TIME CHECK - END --------------------//

					if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 
						
						$___usrsid = [];
						$___datprcs = [];
						
						if(class_exists('CRM_Cnx')){ 
							
							$Ls_Qry = " SELECT id_wthspcnv, wthspcnv_id, wthsp_cl, cl_nm, wthsp_no,
												( wthspcnv_f_chk < NOW() - INTERVAL 5 MINUTE ) AS __rd_lst

										FROM "._BdStr(DBT).TB_WHTSP_CNV."
											INNER JOIN "._BdStr(DBT).TB_WHTSP." ON wthspcnv_whtsp = id_wthsp
											INNER JOIN "._BdStr(DBM).TB_CL." ON wthsp_cl = id_cl
										WHERE 	whtsp_api = ".GtSQLVlStr(ID_APITHRD_MSVSPC, 'int')." AND
												wthspcnv_est = '"._CId('ID_SCLCNVEST_ON')."' AND
												wthsp_cl = '".$_cl_v->id."'
										
										HAVING __rd_lst = 1
										ORDER BY id_wthspcnv DESC /*wthspcnv_fi ASC*/
										LIMIT 20 
									";
							
							$LsMsvCnv = $__cnx->_qry($Ls_Qry); 
						
							if($LsMsvCnv){
								
								$rwLsMsvCnv = $LsMsvCnv->fetch_assoc(); 
								$TotLsMsvCnv = $LsMsvCnv->num_rows; 
								
								echo $this->h1($_cl_v->nm.' - WhatsApp - MassiveSpace - Conversations '.$TotLsMsvCnv);
								
								if($TotLsMsvCnv > 0){					

									do {
										
										try {					
											$___datprcs[] = $rwLsMsvCnv;
										} catch (Exception $e) {	
											$___lck = $this->Rqu([ 't'=>'msv_cnv', 'lck'=>2 ]);
											echo $this->err($e->getMessage());	
										}
										
									} while ($rwLsMsvCnv = $LsMsvCnv->fetch_assoc()); 

									//---------- Free Query For This Customer ----------//
												
										$this->Rqu([ 't'=>'msv_cnv', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
										$__cnx->_clsr($LsMsvCnv);

									//---------- Release Query For This Customer ----------//

								}
							
							}else{

								echo $this->err($__cnx->c_r->error);

							}

							$__cnx->_clsr($LsMsvCnv);


							if(!isN( $___datprcs ) && count($___datprcs) > 0){

								foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

									$__rdt = $this->RquDt([ 't'=>'msv_cnv', 'cl'=>$___datprcs_v['wthsp_cl'], 'id'=>$___datprcs_v['id_wthspcnv'], 's'=>30 ]);

									echo $this->h2('Details of conversation '.$___datprcs_v['id_wthspcnv'].' on account '.ctjTx($___datprcs_v['cl_nm'],'in').' - '.$___datprcs_v['wthsp_no']);

									if(!isN($__rdt->nxt) && $__rdt->all != 'ok'){
										$__next = $__rdt->nxt;
										$__limit = '';
									}else{
										$__next = '';
										$__limit = 100;
									}

									$this->_wthsp->rst();

									$__msg = $this->_massive->msg_ls([ 'acc'=>$___datprcs_v['wthsp_no'], 'chnl'=>$___datprcs_v['wthspcnv_id'], 'nxt'=>$__next, 'lmt'=>$__limit ]); 
									
									$__updchk = $this->_wthsp->UpdF(['t'=>'cnv', 'f'=>[ 'wthspcnv_f_chk'=>SIS_F_D2 ], 'id'=>$___datprcs_v['id_wthspcnv'] ]);

									if($__updchk->e == 'ok'){
										echo $this->scss('Lock Date Check Success');
									}else{
										echo $this->err('Error on Lock Date Check '.$__updchk->w.' -> '.$__updchk->q);
									}

									echo $this->h3('Tot:'.$__msg->rsl->tot);

									if(!isN( $__msg->rsl->ls )){
										
										foreach($__msg->rsl->ls as $__msg_k=>$__msg_v){	

											if( isN($___usrsid[ $__msg_v->user->username ]) ){

												$__usr = $this->_wthsp->Chk_Us([ 'usr'=>$__msg_v->user->username ]); //Validar usuario

												if(!isN($__usr->id)){
													$___usrsid[ $__msg_v->user->username ] = [ 'id'=>$__usr->id, 'e'=>'ok' ];										
												}else{
													$___usrsid[ $__msg_v->user->username ] = [ 'e'=>'no' ];
												}

											}else{

												$__usr = _jEnc( $___usrsid[ $__msg_v->user->username ] );

											}
											
											
											if(isN( $__usr->id )){
												
												echo $this->err('Username '.$__msg_v->user->username.' no esta asociado en SUMR','','','ok');

											}

											
											//---------- Process Message - Start ----------//

												include(GL_WHTS_MSV.'msv_cnv_msg_in.php');	
										
											//---------- Process Message - End ----------//

										}

										echo $this->li('Has to update conversation now','','','ok');

										$this->_wthsp->wthspcnvmsg_wthspcnv = $___datprcs_v['wthspcnv_id']; 
										$this->_wthsp->wthspcnv_est = $_cnv_est;
										$Cnv_Upd = $this->_wthsp->Cnv_Upd(); // Now Update Conversation

										echo $this->li('Result:'.print_r( $Cnv_Upd , true),'','','ok');

									}

									if(!isN($__msg->rsl) && isN($__msg->rsl->next) && $__msg->rsl->tot == 0){ 
										$__rqu_all = 1; 
										$__rqu_nxt = '';
									}else{ 
										$__rqu_all=''; 
										$__rqu_nxt = $__msg->rsl->next;
									}

									$__upd_rqu = $this->Rqu([ 
													't'=>'msv_cnv',  
													'cl'=>$___datprcs_v['wthsp_cl'], 
													'id'=>$___datprcs_v['id_wthspcnv'], 
													'nxt'=>$__rqu_nxt, 
													'all'=>$__rqu_all,
													'pge'=>!isN($__rdt->pge)?($__rdt->pge+1):1
												]);

								}
								
								echo $this->ul($___accin);
									
							}	

						}

					}else{
				
						echo $this->h1('WhatsApp'.$this->Spn('MassiveSpace Messages - '.$_cl_v->nm.' - Run On Next'), 'Auto_Tme_Prg');
						
					}

					$this->Rqu([ 't'=>'msv_cnv', 'cl'=>$_cl_v->id ]);
				
				} catch (Exception $e) {
			
			
					$this->Rqu([ 't'=>'msv_cnv', 'cl'=>$_cl_v->id ]);
				
					echo $e->getMessage();
					
				}
			
			}else{

				echo $this->nallw($_cl_v->nm.' Whatsapp - Massive - Conversations - Off');
		
			}
		
		}

	}	

}else{

	echo $this->nallw('Global Whatsapp - Massive - Conversations - Off');

}

?>