<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'wbhk_mdl_cnt_est' ]);

if( $_g_alw->est == 'ok' ){

	try{    
	
		if(class_exists('CRM_Cnx')){			    
			
			$__Wbhk = new CRM_Webhook();
			
			echo $this->h1('Proceso Webhooks - Cambios Estado');		
			
			$Qry = "SELECT * 
					FROM ".DBP.".".TB_WBHK." 
					WHERE 	wbhk_cl = 16 AND 
							wbhk_est = 1 AND 
							wbhk_tp = '"._CId('ID_WBHTP_MDLCNTEST')."' 
					";	

			$WbhkRg = $__cnx->_qry($Qry);
			
			if($WbhkRg){
				
				$row_WbhkRg = $WbhkRg->fetch_assoc();
				$Tot_WbhkRg = $WbhkRg->num_rows;
				
				if($Tot_WbhkRg > 0){
					
					try {		
						
						do{	
							
							$_cldt = GtClDt( $row_WbhkRg['wbhk_cl']);
							
							echo $this->h2($row_WbhkRg['wbhk_nm'].' Database:'.$_cldt->bd);
							
							if(!isN($_cldt->bd)){
							
								//-------------------- LEADS TO SEND --------------------//
									
									$SbQry = "	SELECT * 
												
												FROM ".$_cldt->bd.".".TB_MDL_CNT_EST."
													 INNER JOIN ".$_cldt->bd.".".TB_MDL_CNT." ON mdlcntest_mdlcnt = id_mdlcnt
													 INNER JOIN ".$_cldt->bd.".".TB_CNT." ON mdlcnt_cnt = id_cnt
													 INNER JOIN ".$_cldt->bd.".".TB_MDL." ON mdlcnt_mdl = id_mdl
												
												WHERE id_mdlcntest NOT IN (	SELECT wbhksnd_id 
																			FROM ".DBP.".".TB_WBHK_SND."
																			WHERE wbhksnd_wbhk = '".$row_WbhkRg['id_wbhk']."' AND wbhksnd_d = 'mdl_cnt_est'
																		)
														AND mdlcntest_fi >= '".$row_WbhkRg['wbhk_snc']."'		
													  
													  {$__fl_cmpg}
													    						
												ORDER BY id_mdlcnt DESC						
												LIMIT 10"; 
	
															   
									$WbhkSbRg = $__cnx->_qry($SbQry); 
									
									
									echo $this->h1($SbQry).$__cnx->c_r->error;
	
							
									if($WbhkSbRg){
										
										$row_WbhkSbRg = $WbhkSbRg->fetch_assoc();
										$Tot_WbhkSbRg = $WbhkSbRg->num_rows;
										
										//echo $this->h3('Tot Estados:'.$SbQry.'->'.$Tot_WbhkSbRg);
										
										do{
	
											//echo li($row_WbhkRg['id_wbhk']);
											
											
											$__Wbhk->wbhksnd_wbhk = $row_WbhkRg['id_wbhk'];
											$__Wbhk->wbhksnd_id = $row_WbhkSbRg['id_mdlcntest'];
											$__Wbhk->wbhksnd_d = 'mdl_cnt_est';
											
											$__chk = $__Wbhk->_chk();
											
											
											if($__chk->rd != 'ok'){
												
												
												if(!isN($__chk->enc)){
													$__rd = $__Wbhk->_rd([ 'o'=>'ok' ]);
												}
																
														
												try {
													
													$__dtmdlcnt = GtMdlCntDt([ 	
																			'id'=>$row_WbhkSbRg['id_mdlcnt'], 
																			'bd'=>$_cldt->bd, 
																			'cnx'=>$__cnx->c_r,
																			'shw'=>[
																				'are'=>'ok',
																				'cnt'=>'ok'
																			]
																		]);
																		
													if(!isN($__dtmdlcnt->cnt->id) && !isN($__dtmdlcnt->mdl->are->last->id)){
														
														foreach($__dtmdlcnt->cnt->eml as $_eml_k=>$_eml_v){
															
															$emblue = new CRM_Emblue();         
															
															$emblue->new_eml = $_eml_v->v;
															$emblue->mdlcntest_est = $row_WbhkSbRg['mdlcntest_est'];
															$emblue->mdlcnt_mdl = $row_WbhkSbRg['mdlcnt_mdl'];
															$emblue->cnt_tel = $__dtmdlcnt->cnt->tel;
															
															/*if($_eml_v->v == 'hernando_velez@yahoo.com' || $_eml_v->v == 'camilo.garzon@servicios.in' || $_eml_v->v == 'icgarzon@servicios.in' || $_eml_v->v == 'diego.mayorga@eikondigital.com' || $_eml_v->v == 'diego77m@hotmail.com' || $_eml_v->v == 'diego77m2@gmail.com' || $_eml_v->v == 'natalia.coral@eikondigital.com' || $_eml_v->v == 'hernando.velez@eikondigital.com' || $_eml_v->v == 'felipe.romero@eikondigital.com' || $_eml_v->v == 'diego.mayorgacapera@gmail.com' || $_eml_v->v == 'feliperomero6311@gmail.com' || $_eml_v->v == 'natacoralcoral@hotmail.com' || $_eml_v->v == 'karen77m@gmail.com' || $_eml_v->v == 'Karen77m@gmail.com' ){*/
															
																$__r = $emblue->_newcntc();
																
															/*}*/
															
															
															if($__r->e != 'ok') {
															    
															    echo $this->h2( 'Curl error no: ' . $__r->error_no );
															    echo $this->h2( 'Curl error: ' . $__r->error );
															    echo $this->h2( 'Curl Code: ' . $__r->code );
															    
															} else {
																
															    echo $__dtmdlcnt->id.' - Success';
															    
															    $__Wbhk->wbhksnd_soap = mBln($row_WbhkRg['wbhk_soap']);
															    $__Wbhk->wbhksnd_rest = mBln($row_WbhkRg['wbhk_rest']);
															    
															    if(!isN($emblue->data)){
															    	$__Wbhk->wbhksnd_rqu = json_decode(json_encode($emblue->data), true);
															    }
															    
															    $__Wbhk->wbhksnd_err_no = $__r->error_no;
															    $__Wbhk->wbhksnd_err_msg = $__r->error;
															    $__Wbhk->wbhksnd_err_str = $__r->error_msg;
															    $__Wbhk->wbhksnd_r = json_decode(json_encode($__r->rsl), true);
															    $__Wbhk->wbhksnd_r_info = $__r->info;
															    $__Wbhk->wbhksnd_r_code = $__r->code;
															    $__Wbhk->wbhksnd_r_hdrs = $__r->hdrs;
															    $_prc = $__Wbhk->_upd();
															 	
				
															}
														
															curl_close($soap_do);
														
														}	
														
													}
				    
													$__Wbhk->_rd();
												    
												    
												} catch (Exception $e) {
													
													$__Wbhk->_rd();
												    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
												    
												}
											
											}								
											
										}while($row_WbhkSbRg = $WbhkSbRg->fetch_assoc()); 	
									
									
									}else{
									
										echo $this->h1($SbQry).$__cnx->c_r->error;
										
									}
				
								//-------------------- LEADS TO SEND --------------------//
							
							}
						
						}while($row_WbhkRg = $WbhkRg->fetch_assoc()); 
						
						$WbhkRg->free;
							
					}catch(Exception $e){
							
						echo $e->getMessage();
						
					}
						
				}	
			
			}	

			$__cnx->_clsr($WbhkRg);	

		}
	
	}catch(Exception $e){
	    
		echo $e->getMessage();
	   
	    exit(1);
	    
	}

}else{

	echo $this->nallw('Global Monitor Webhook - Oportunidades - Cambio de Estado - Off');

}

	
?>