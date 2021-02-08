<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'whtsp_msv_cnv_msg' ]);

if( $_g_alw->est == 'ok' ){
		
	try {
		
		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt([ 't'=>'msv_cnv_msg', 'm'=>1 ]);
			//$_AUTOP_d->e = 'ok';
			//$_AUTOP_d->hb = 'ok';

		//-------------------- AUTO TIME CHECK - END --------------------//
		
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 
			
			$___usrsid = [];
			$___datprcs = [];
			$__prc_all = 'ok';
			
			if(class_exists('CRM_Cnx')){ 
				
				$Ls_Qry = " SELECT wthsp_cl, id_wthsp, wthsp_no
							FROM "._BdStr(DBT).TB_WHTSP." 
								INNER JOIN "._BdStr(DBM).TB_CL." ON wthsp_cl = id_cl
							WHERE 	whtsp_api = ".GtSQLVlStr(ID_APITHRD_MSVSPC, 'int')." AND 
									whtsp_e=1 AND
									(NOW() > DATE_ADD(wthsp_f_chk_msg, INTERVAL +2 MINUTE) || wthsp_f_chk_msg IS NULL)
							ORDER BY RAND()		
							LIMIT 2
						";
				
				$LsMsvMsg = $__cnx->_qry($Ls_Qry); //echo $Ls_Qry; exit();
			
				if($LsMsvMsg){
					
					$rwLsMsvMsg = $LsMsvMsg->fetch_assoc(); $TotLsMsvMsg = $LsMsvMsg->num_rows; 
					
					echo $this->h1('WhatsApp - MassiveSpace - Messages '.$TotLsMsvMsg);
					
					if($TotLsMsvMsg > 0){					

						do {
							
							try {					
								$___datprcs[] = $rwLsMsvMsg;
							} catch (Exception $e) {	
								$___lck = $this->Rqu([ 't'=>'msv_cnv_msg', 'lck'=>2 ]);
								echo $this->err($e->getMessage());	
							}
							
						} while ($rwLsMsvMsg = $LsMsvMsg->fetch_assoc()); 

						//---------- Free Query For This Customer ----------//
									
							$this->Rqu([ 't'=>'msv_cnv_msg', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
							$__cnx->_clsr($LsMsvMsg);

						//---------- Release Query For This Customer ----------//

						foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

							$__rdt = $this->RquDt([ 't'=>'msv_cnv_msg', 'cl'=>$___datprcs_v['wthsp_cl'], 'id'=>$___datprcs_v['id_wthsp'], 'm'=>1 ]);

							$__updchk = $this->_wthsp->UpdF(['t'=>'whtsp', 'f'=>[ 'wthsp_f_chk_msg'=>SIS_F_D2 ], 'id'=>$___datprcs_v['id_wthsp'] ]);

							echo $this->h2('Details of account '.$___datprcs_v['wthsp_no']);						

							if($__updchk->e == 'ok'){
								echo $this->scss('Lock Date Check Success');
							}else{
								echo $this->err('Error on Lock Date Check '.$__updchk->w);
							}

							if(!isN($__rdt->nxt) && $__rdt->all != 'ok'){
								$__next = $__rdt->nxt;
								$__limit = '';
							}else{
								$__next = '';
								$__limit = 50;
							}

							$this->_wthsp->rst();

							$_log_w = [];
							$__msgs = $this->_massive->msg_ls([ 'acc'=>$___datprcs_v['wthsp_no'], 'nxt'=>$__next, 'lmt'=>$__limit ]); 
							
							echo $this->li('Limit:'.$__limit);
							echo $this->li('Next:'.$__next);
							echo $this->li('Tot:'.$__msgs->rsl->tot);

							if(!isN( $__msgs->rsl->ls )){
								
								$_psve = 0;
								$__rqu_nxt = NULL;

								foreach($__msgs->rsl->ls as $__msg_k=>$__msg_v){

									if( isN($___usrsid[ $__msg_v->user->username ]) ){
										
										$__usr = $this->_wthsp->Chk_Us([ 'usr'=>$__msg_v->user->username ]); //Validar usuario

										if(!isN($__usr->id)){
											$___usrsid[ $__msg_v->user->username ] = [ 'id'=>$__usr->id, 'e'=>'ok' ];										
										}else{
											$___usrsid[ $__msg_v->user->username ] = [ 'e'=>'no' ];
										}

									}else{

										$__usr = _jEnc( $___usrsid[ $__msg_v->user->username ] );
										echo $this->li(' ---- Exists '.$__msg_v->user->username.' on array ----- ');

									}
									
									
									if(isN( $__usr->id )){
										echo $this->err('Username '.$__msg_v->user->username.' no esta asociado en SUMR','','','ok');
										$_log_w[] = 'Username '.$__msg_v->user->username.' no esta asociado en SUMR';
									}

									//---------- Process Message - Start ----------//

										include(GL_WHTS_MSV.'msv_cnv_msg_in.php');	
								
									//---------- Process Message - End ----------//

								}

								echo $this->h2('Get'.$__msgs->rsl->tot.' / Saved'.$_psve);
								echo $this->h2('Last Error:'.$_plst);
								
								if($__msgs->rsl->tot != $_psve && !isN($_log_w)){
									$__updchk = $this->_wthsp->UpdF(['t'=>'whtsp', 'f'=>[ 'wthsp_w'=>json_encode($_log_w) ], 'id'=>$___datprcs_v['id_wthsp'] ]);
								}else{
									$__updchk = $this->_wthsp->UpdF(['t'=>'whtsp', 'f'=>[ 'wthsp_w'=>NULL ], 'id'=>$___datprcs_v['id_wthsp'] ]);
									$__rqu_nxt = $_plst;
									echo $this->scss('All data saved success / last id:'.$_plst);
								}

							}else{

								if( $__msgs->rsl->exc == 'ok' ){
									$__updchk = $this->_wthsp->UpdF(['t'=>'whtsp', 'f'=>[ 'wthsp_w'=>NULL ], 'id'=>$___datprcs_v['id_wthsp'] ]);	
								}

							}

							
							/*
							if(!isN($__msgs->rsl) && isN($__msgs->rsl->next) && $__msgs->rsl->tot == 0){ 
								$__rqu_all = 1; 
								$__rqu_nxt = '';
							}else{ 
								$__rqu_all=''; 
								$__rqu_nxt = $__msgs->rsl->next;
							}*/

							if($__prc_all == 'ok'){
								$__upd_rqu = $this->Rqu([ 
												't'=>'msv_cnv_msg', 
												'cl'=>$___datprcs_v['wthsp_cl'],
												'id'=>$___datprcs_v['id_wthsp'], 
												'nxt'=>$__rqu_nxt, 
												//'all'=>$__rqu_all,
												//'pge'=>!isN($__rdt->pge)?($__rdt->pge+1):1
											]);
							}

						}
						
						echo $this->ul($___accin);
						
					}
				
				}

				$__cnx->_clsr($LsMsvMsg);

			}
			
			$this->Rqu([ 't'=>'msv_cnv_msg' ]);
			
		}else{
			
			echo $this->h1('WhatsApp'.$this->Spn('MassiveSpace Messages - Run On Next'), 'Auto_Tme_Prg');
			
		}
		
	} catch (Exception $e) {
	
		$this->Rqu([ 't'=>'msv_cnv_msg' ]);
		echo $e->getMessage();
		
	}

}else{

	echo $this->nallw('Global Whatsapp - Massive - Conversations - Messages - Off');

}

?>