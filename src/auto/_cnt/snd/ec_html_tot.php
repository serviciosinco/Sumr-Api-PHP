<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_ec_html_tot' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){			
			
		//------------------- Basic Parameters ---------------------//	
				
			$__i = $this->g__i;
			echo $this->h1('UPDATE OF PUSHMAIL HTML TOTAL FOR CAMPAIGN');

		//------------------- Start ---------------------//	


		if($this->_s_cl->tot > 0){
			
			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
				
				if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_ec_html_tot', 'cl'=>$_cl_v->id ])->est == 'ok' ){
					
					//-------------------- AUTO TIME CHECK - START --------------------//

						$__ec = new API_CRM_ec([ 'argv'=>$__argv, 'cl'=>$_cl_v->id ]);
						$__qry_innr = '';
						$__cmpg_fltr = '';
							
						$_AUTOP_d = $this->RquDt([ 't'=>'ec_html_tot', 'cl'=>$_cl_v->id, 'm'=>5 ]);
						//$_AUTOP_d->e = 'ok';
						//$_AUTOP_d->lck = 'no';
							
					//-------------------- AUTO TIME CHECK - END --------------------//
					
		
					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 5){ 			
						
						try {
							
							echo $this->h2($_AUTOP_d->e.' - '.$_cl_v->nm.' habilitado? '.$_AUTOP_d->hb.' lock? '.$_AUTOP_d->lck.' m_lck'.$_AUTOP_d->m_lck, '', '_check');	
							
							//---------- Lock Account While Check Result On Read Mode ----------//
							
							$___lck = $this->Rqu([ 't'=>'ec_html_tot', 'cl'=>$_cl_v->id, 'lck'=>1 ]);
							echo $this->h2( 'Result of lock all query: '.$___lck->e );
							
							$___datprcs = [];
							
							if($___lck->e == 'ok'){	
									
								$EcHtmlTotQry = "	SELECT id_eccmpg   		  		
													FROM "._BdStr(DBM).TB_EC_CMPG."
														 INNER JOIN "._BdStr(DBM).TB_CL." ON eccmpg_cl = id_cl
                                                    WHERE   cl_enc = '".$_cl_v->enc."' AND
                                                            eccmpg_sndr = '"._CId('ID_SISEML_SUMR')."' AND
                                                            ( 
                                                                eccmpg_est = '"._CId('ID_ECCMPGEST_APRBD')."' OR
                                                                eccmpg_est != '"._CId('ID_ECCMPGEST_SND')."' 
                                                            )
													ORDER BY RAND()
													LIMIT 100";

								$EcHtmlTot = $__cnx->_qry($EcHtmlTotQry, ['cmps'=>'ok'] ); 

								if($EcHtmlTot){
					
									$rwEcHtmlTot = $EcHtmlTot->fetch_assoc(); 
									$TotEcHtmlTot = $EcHtmlTot->num_rows;

									if($TotEcHtmlTot > 0){		
										do{
											try {		
												echo $this->li('Lock Before to ID '.$rwEcHtmlTot['id_eccmpg']);
												$___datprcs[] = $rwEcHtmlTot;
											} catch (Exception $e) {	
												$___lck = $this->Rqu([ 't'=>'ec_html_tot', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
												echo $this->err($e->getMessage());  
											}		
										} while ($rwEcHtmlTot = $EcHtmlTot->fetch_assoc()); 	
									}else{
										$___lck = $this->Rqu([ 't'=>'ec_html_tot', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									}
								
								}else{
									
									$___lck = $this->Rqu([ 't'=>'ec_html_tot', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									echo $this->err($__cnx->c_r->error);
									
								}
								
								$__cnx->_clsr($EcHtmlTot);
								
								if(!isN( $___datprcs )){

									foreach($___datprcs as $___datprcs_k=>$___datprcs_v){	
                                        
                                        $__tot_html = $__ec->EcCmpgHtmlTot([ 'cmpg'=>$___datprcs_v['id_eccmpg'] ]);
                                        
                                        if(!isN($__tot_html->tot)){
                                            
                                            $_upd_cmpg_tot = $__ec->_EcCmpgUpd_Fld([ 'id'=>$___datprcs_v['id_eccmpg'], 'f'=>'eccmpg_tot_html', 'v'=>$__tot_html->tot ]);

                                            if($_upd_cmpg_tot->e == 'ok'){
                                                echo $this->scss('Campaign '.$___datprcs_v['id_eccmpg'].' update on total html builded to '.$__tot_html->tot);
                                            }else{
                                                echo $this->err('Cannot update '.$___datprcs_v['id_eccmpg'].' field '.$_upd_cmpg_tot->w);
                                            }
                                            
                                        }

									}

								}

							}
						
						} catch (Exception $e) {
				
							$___lck = $this->Rqu([ 't'=>'ec_html_tot', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
							echo $this->err($e->getMessage());
							
						}					
						
						$___lck = $this->Rqu([ 't'=>'ec_html_tot', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
					
					}
				
				}else{

					echo $this->nallw($_cl_v->nm.' Envios Masivos - Html Builder Status - Off');
			
				}	
				
			}
			
		}	
		
		$this->__btch_id = NULL;
		
	} 

}else{

	echo $this->nallw('Global Envios Masivos - Html Total Update - Off');

}

?>