<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'whtsp_msv_cnv_msg_snt' ]);

if( $_g_alw->est == 'ok' ){

	try {
		
		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt([ 't'=>'msv_cnv_msg_snt', 'm'=>1 ]);

		//-------------------- AUTO TIME CHECK - END --------------------//
		
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 
			
			$___usrsid = [];
			$___datprcs = [];
			
			if(class_exists('CRM_Cnx')){ 
				
				$Ls_Qry = " SELECT wthspcnv_id, id_wthsp, wthsp_cl, wthsp_no, wthspcnv_id, id_wthspcnvmsg, wthspcnvmsg_id,
									( wthspcnvmsg_f_chk < NOW() - INTERVAL 5 MINUTE ) AS __rd_lst
							FROM "._BdStr(DBT).TB_WHTSP_CNV_MSG." 
								INNER JOIN "._BdStr(DBT).TB_WHTSP_CNV." ON wthspcnvmsg_wthspcnv = id_wthspcnv
								INNER JOIN "._BdStr(DBT).TB_WHTSP." ON wthspcnv_whtsp = id_wthsp
								INNER JOIN "._BdStr(DBM).TB_CL." ON wthsp_cl = id_cl
							WHERE whtsp_api = ".GtSQLVlStr(ID_APITHRD_MSVSPC, 'int')." AND wthspcnvmsg_snt = 2
							HAVING __rd_lst = 1 OR wthspcnvmsg_f_chk IS NULL
							ORDER BY wthspcnvmsg_fi DESC
							LIMIT 50
						";
				
				$LsMsvMsgSnt = $__cnx->_qry($Ls_Qry); echo $Ls_Qry;
			
				if($LsMsvMsgSnt){
					
					$rwLsMsvMsgSnt = $LsMsvMsgSnt->fetch_assoc(); $TotLsMsvMsgSnt = $LsMsvMsgSnt->num_rows; 
					
					echo $this->h1('WhatsApp - MassiveSpace - Messages Not Sent '.$TotLsMsvMsgSnt);
					
					if($TotLsMsvMsgSnt > 0){					

						do {
							
							try {					
								$___datprcs[] = $rwLsMsvMsgSnt;
							} catch (Exception $e) {	
								$___lck = $this->Rqu([ 't'=>'msv_cnv_msg_snt', 'lck'=>2 ]);
								echo $this->err($e->getMessage());	
							}
							
						} while ($rwLsMsvMsgSnt = $LsMsvMsgSnt->fetch_assoc()); 

						//---------- Free Query For This Customer ----------//
									
							$this->Rqu([ 't'=>'msv_cnv_msg_snt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
							$__cnx->_clsr($LsMsvMsgSnt);

						//---------- Release Query For This Customer ----------//

						foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

							if(!isN( $___datprcs_v['wthspcnv_id'] )){

								$__rdt = $this->RquDt([ 't'=>'msv_cnv_msg_snt', 'cl'=>$___datprcs_v['wthsp_cl'], 'id'=>$___datprcs_v['id_wthsp'], 'm'=>1 ]);

								$__updchk = $this->_wthsp->UpdF(['t'=>'msg', 'f'=>[ 'wthspcnvmsg_f_chk'=>SIS_F_D2 ], 'id'=>$___datprcs_v['id_wthspcnvmsg'] ]);

								echo $this->h2('Details of message '.$___datprcs_v['id_wthspcnvmsg']);						

								if($__updchk->e == 'ok'){
									echo $this->scss('Lock Date Check Success');
								}else{
									echo $this->err('Error on Lock Date Check '.$__updchk->w.' -> '.$__updchk->q);
								}

								$this->_wthsp->rst();

								$__msgs = $this->_massive->msg_ls([ 'acc'=>$___datprcs_v['wthsp_no'], 'chnl'=>$___datprcs_v['wthspcnv_id'], 'msg'=>$___datprcs_v['wthspcnvmsg_id'] ]); 
								
								echo $this->li('Tot:'.$__msgs->rsl->tot);

								if(!isN( $__msgs->rsl->ls )){
									
									foreach($__msgs->rsl->ls as $__msg_k=>$__msg_v){

										$__usr = $this->_wthsp->Chk_Us([ 'usr'=>$__msg_v->user->username ]); //Validar usuario							
										
										if(isN( $__usr->id )){
											echo $this->err('Username '.$__msg_v->user->username.' no esta asociado en SUMR','','','ok');
										}

										//---------- Process Message - Start ----------//

											include(GL_WHTS_MSV.'msv_cnv_msg_in.php');	
									
										//---------- Process Message - End ----------//

									}

								}

								if(!isN($__msgs->rsl) && isN($__msgs->rsl->next) && $__msgs->rsl->tot == 0){ 
									$__rqu_all = 1; 
									$__rqu_nxt = '';
								}else{ 
									$__rqu_all=''; 
									$__rqu_nxt = $__msgs->rsl->next;
								}

								$__upd_rqu = $this->Rqu([ 
												't'=>'msv_cnv_msg_snt', 
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
				
				}

				$__cnx->_clsr($LsMsvMsgSnt);

			}
		
			
			$this->Rqu([ 't'=>'msv_cnv_msg_snt' ]);
		
			
		}else{
			
			echo $this->h1('WhatsApp'.$this->Spn('MassiveSpace Messages - Run On Next'), 'Auto_Tme_Prg');
			
		}
		
		
		
	} catch (Exception $e) {
		
		
		$this->Rqu([ 't'=>'msv_cnv_msg_snt' ]);

		echo $e->getMessage();
		
	}

}else{

	echo $this->nallw('Global Whatsapp - Massive - Conversations - Messages - Check If It Was Sended - Off');

}

?>