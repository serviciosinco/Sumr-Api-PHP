<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_ec_cmpg_est' ]);

if( $_g_alw->est == 'ok' ){
		
	if(class_exists('CRM_Cnx')){
		
		$__btch_id = Gn_Rnd(20); 
		
		$this->btch_id = $__btch_id;
		
		$this->_RTme([ 'start'=>'ok' ]);
		
		echo $this->h1('CAMBIO STATUS CAMPAÑAS EMAIL', '_cmpg');
		
		define('GL_SND_EC', 'ec/'); // Actions	
		
		if($this->_s_cl->tot > 0){
			
			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
				
				if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_ec_cmpg_est', 'cl'=>$_cl_v->id ])->est == 'ok' ){
					
					//-------------------- AUTO TIME CHECK - START --------------------//
		
						$_AUTOP_d = $this->RquDt([ 't'=>'ec_cmpg_est', 'cl'=>$_cl_v->id, 'm'=>1 ]);
						echo $this->h2($_cl_v->nm.' habilitado? '.$_AUTOP_d->hb, '', '_check');
						//$_AUTOP_d->e = 'ok';
						//$_AUTOP_d->lck = 'no';
							
					//-------------------- AUTO TIME CHECK - END --------------------//
					
					
					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 15){ 
						
						
						try {	
							
							$_ec_snd = new API_CRM_ec([ 'cl'=>$_cl_v->id ]);	
							$___lck = $this->Rqu([ 't'=>'ec_cmpg_est', 'cl'=>$_cl_v->id, 'lck'=>1 ]);	
			
							if(!isN($this->g__i)){ $_qry_f = " AND eccmpg_enc=".GtSQLVlStr($this->g__i, "text")." "; }
							
							if(!isN($_g_alw->lmt)){ 
								$_qry_lmt = $_g_alw->lmt;
							}else{ 
								$_qry_lmt = '10';
							}

							$EcCmpgEst_Qry = "
							
											SELECT id_eccmpg	
											FROM "._BdStr(DBM).TB_EC_CMPG." 
											WHERE 	eccmpg_est != '"._CId('ID_ECCMPGEST_SND')."' AND
													eccmpg_est != '"._CId('ID_ECCMPGEST_PSD')."' AND
													eccmpg_est != '"._CId('ID_ECCMPGEST_NAPRBD')."' AND
													eccmpg_est != '"._CId('ID_ECCMPGEST_CNCL')."' AND
													eccmpg_sndr = '"._CId('ID_SISEML_SUMR')."' AND
													eccmpg_rdy = 1 AND
													eccmpg_cl = '".$_cl_v->id."'
													/*AND CONCAT(eccmpg_p_f,' ',eccmpg_p_h) < NOW()*/
															
											ORDER BY eccmpg_p_f ASC
											LIMIT {$_qry_lmt}
										
										"; 
													
							//echo $this->h3($EcCmpgEst_Qry);
										
							$EcCmpgEst = $__cnx->_qry($EcCmpgEst_Qry); 
							
							if($EcCmpgEst){
							
								$rwEcCmpgEst = $EcCmpgEst->fetch_assoc(); 
								$TotEcCmpgEst = $EcCmpgEst->num_rows;
								
								echo $this->h3($this->ttFgr($_cl_v).$TotEcCmpgEst.' campañas para cambiar de estado '.$_cl_v->nm, '_cmpg');
								
								
								if($TotEcCmpgEst > 0){
						
									do{ 
										
										//-------------------- SET READ CAMPAIGN STATUS --------------------//
										
											$this->id_eccmpg = $rwEcCmpgEst['id_eccmpg'];
											$__rd_cmpg_p = $this->EcCmpg_Rd([ 'e'=>'on' ]);
										
										//-------------------- FREE AUTO - START --------------------//
		
											$this->Rqu([ 't'=>'ec_cmpg_est', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
												
										//----------- GET CAMPAIGN DETAIL -----------//
											
											
											if(!isN($rwEcCmpgEst['id_eccmpg'])){
				
												$_cmpg_dt = GtEcCmpgDt([ 						
													'bd'=>$_cl_v->bd,
													'id'=>$rwEcCmpgEst['id_eccmpg'],
													'ec'=>'ok', 
													'q_btch'=>'ok', 
													'sgm'=>['e'=>'ok', 'ls'=>'ok', 'tot'=>'ok' ], 
													'lsts'=>['e'=>'ok', 'ls'=>'ok' ]
												]);
												
											}	
											
											echo $this->li('Process Campaign '.$this->Spn($rwEcCmpgEst['id_eccmpg']) );
											
											$_f1 = $_cmpg_dt->p_f.' '.$_cmpg_dt->p_h;
											
											
										//----------- DIFFERENCE DAY TO KNOW IT IS PAST -----------//
											
											$_f2 = SIS_F2.' '.SIS_H2;
											$_f_1 = date_create($_f1);
											$_f_2 = date_create($_f2);
											$_dif = $_f_1->diff($_f_2);

										//----------- IT IS ALLOWED FOR DATE ? -----------//
											
											
											echo $this->h2('Allowed by date? '.$this->Spn($_cmpg_dt->allw) );
											
											
											
											if($_cmpg_dt->allw == 'ok'){ 
			
												echo $this->li('Programado '.$_cmpg_dt->p_f.' '.$_cmpg_dt->p_h);
												echo $this->li('Allowed '.$_cmpg_dt->tot->lds );
												echo $this->li('Html '.$_cmpg_dt->tot->html );
												echo $this->li('Sended '.$_cmpg_dt->btch->snd );
												echo $this->li('Queue '.$_cmpg_dt->btch->in );

												if(		!isN($_cmpg_dt->tot->lds) && 
														!isN($_cmpg_dt->btch->in) && 
														(
															$_cmpg_dt->btch->snd >= $_cmpg_dt->tot->lds || 
															$_cmpg_dt->tme->out == 'ok'
														)
													){
													
													echo $this->li('All it was sended');
													
													if($_cmpg_dt->opn != 'ok'){														
														
														echo $this->li( 'Diff:'.print_r($_cmpg_dt->tme->diff, true) );
														
														
														$_Upd_r = $_ec_snd->_EcCmpg_UPD([ 'id'=>$_cmpg_dt->id, 'est'=>_CId('ID_ECCMPGEST_SND') ]); 
														
														
														if($_Upd_r->e == 'ok'){
															if($_cmpg_dt->tme->out == 'ok'){
																echo $this->scss('Cambia a estado enviado por limite de tiempo');
															}else{
																echo $this->scss('Campaña procesada en su totalidad');
															}
														}
													
													}
													
												}elseif(	
													$_cmpg_dt->btch->in >= $_cmpg_dt->tot->lds && 
													/*(	
														$_cmpg_dt->est->id != _CId('ID_ECCMPGEST_PSD') || 
														$_cmpg_dt->est->id != _CId('ID_ECCMPGEST_APRBD') 
													)&& */
													(
														$_cmpg_dt->est->id === _CId('ID_ECCMPGEST_APRBD') 
													)
												)
												{	
													
													echo $this->li( 'Time Difference '.print_r($_cmpg_dt->tme->diff, true) );	
													echo $this->li('Has to mark as sending');
																																					
													$_Upd_r = $_ec_snd->_EcCmpg_UPD([ 'id'=>$_cmpg_dt->id, 'est'=>_CId('ID_ECCMPGEST_SNDIN') ]);
													
													if($_Upd_r->e == 'ok'){
														
														echo $this->li($this->h3('Cambia a estado '.$this->Spn('enviando'). ' : '.$_Upd_r->e ));
														
													}
												
												}elseif($_dif->format('%a') > 1 && $_cmpg_dt->opn == 'no' && $_cmpg_dt->est->id == _CId('ID_ECCMPGEST_SNDIN')){	
													
													echo $this->li('It is an old campaign');
													
													//$_Upd_r = $_ec_snd->_EcCmpg_UPD([ 'id'=>$_cmpg_dt->id, 'est'=>_CId('ID_ECCMPGEST_SND') ]); 
													
													if($_Upd_r->e == 'ok'){
														echo $this->scss('Cambia a estado enviado por limite de tiempo');
													}
													
												}
												
												echo $this->br(2);
											
											}else{
												
												
												
											}

											echo $this->h2( 'Allowed to change ready?' );
											echo $this->li( 'Allow: '.$_cmpg_dt->eml_allw);	
											echo $this->li( 'Queue: '.$_cmpg_dt->btch->in);	
											echo $this->li( 'Estatus: '.$_cmpg_dt->est->id.' ('.$_cmpg_dt->est->nm.')');	
											echo $this->li( 'TimeOut: '.$_cmpg_dt->tme->out);
											echo $this->br(2);
											

											if(
												( 
													!isN($_cmpg_dt->btch->in) &&
													!isN($_cmpg_dt->eml_allw) && 
													!isN($_cmpg_dt->tot->html) &&
													$_cmpg_dt->btch->in >= $_cmpg_dt->eml_allw && 
													$_cmpg_dt->est->id == _CId('ID_ECCMPGEST_APRBD') &&
													$_cmpg_dt->tot->html == $_cmpg_dt->btch->in
												) 
											){
														
												echo $this->li( 'It has to change to ready status');			 
												$_upd_eml_rdy = $_ec_snd->_EcCmpgUpd_Fld([ 'id'=>$_cmpg_dt->id, 'f'=>'eccmpg_rdy', 'v'=>1 ]);
												echo $this->li( 'Ready change status: '.$_upd_eml_rdy->e );	

												if($_upd_eml_rdy->e == 'ok'){
													echo $this->scss('Changed to ready');
												}
													
											}


										
									} while ($rwEcCmpgEst = $EcCmpgEst->fetch_assoc());		
													
								}
										
							}else{
								
								echo $this->err($__cnx->c_r->error);
								
							}
							
							$__cnx->_clsr($EcCmpgEst);	
							
							
							$___lck = $this->Rqu([ 't'=>'ec_cmpg_est', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
							
							
						} catch (Exception $e) {
			
							$___lck = $this->Rqu([ 't'=>'ec_cmpg_est', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
					
							echo $this->err($e->getMessage());
							
						}
						
						
					}
					
					echo $this->br(1);
						
				}else{

					echo $this->nallw($_cl_v->nm.' Envios Masivos - Campañas - Estado - Off');
			
				}
				
			}			
		
		}	
		
	}else{
		
		echo $this->err('AUTO_CMPG_EC:off');
		
	}

}else{

	echo $this->nallw('Global Envios Masivos - Campañas - Estado - Off');

}

?>