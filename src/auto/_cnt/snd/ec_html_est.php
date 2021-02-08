<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_ec_html_est' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){			
			
		//------------------- Basic Parameters ---------------------//	
				
			$__i = $this->g__i;
			echo $this->h1('CAMBIO ESTADO DE PUSHMAIL HTML');
			define('GL_SND_EC', 'ec/'); // Actions
			define('UNLCK_MIN', '1'); // Minutes Wait Unlock	

		//------------------- Start ---------------------//	


		if($this->_s_cl->tot > 0){
			
			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
				
				if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_ec_html_est', 'cl'=>$_cl_v->id ])->est == 'ok' ){
					
					//-------------------- AUTO TIME CHECK - START --------------------//

						$__ec = new API_CRM_ec([ 'argv'=>$__argv, 'cl'=>$_cl_v->id ]);
						$__qry_innr = '';
						$__cmpg_fltr = '';
							
						$_AUTOP_d = $this->RquDt([ 't'=>'ec_html_est', 'cl'=>$_cl_v->id, 'm'=>10 ]);
						//$_AUTOP_d->e = 'ok';
						//$_AUTOP_d->lck = 'no';
							
					//-------------------- AUTO TIME CHECK - END --------------------//
					
		
					if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 5){ 			
						
						try {
							
							echo $this->h2($_AUTOP_d->e.' - '.$_cl_v->nm.' habilitado? '.$_AUTOP_d->hb.' lock? '.$_AUTOP_d->lck.' m_lck'.$_AUTOP_d->m_lck, '', '_check');	
							
							//---------- Lock Account While Check Result On Read Mode ----------//
							
							$___lck = $this->Rqu([ 't'=>'ec_html_est', 'cl'=>$_cl_v->id, 'lck'=>1 ]);
							echo $this->h2( 'Result of lock all query: '.$___lck->e );
							
							$___datprcs = [];
							
							if($___lck->e == 'ok'){	
									
								$EcHtmlEstQry = "	SELECT id_ecsnd, ecsnd_enc	   		  		
													FROM "._BdStr($_cl_v->bd).TB_EC_SND."
														 INNER JOIN "._BdStr($_cl_v->bd).TB_EC_SND_HTML." ON ecsndhtml_ecsnd = id_ecsnd
													WHERE ecsnd_html = 2 AND ecsndhtml_s3 != 1
													ORDER BY id_ecsnd ASC
													LIMIT 50";

								$EcHtmlEst = $__cnx->_qry($EcHtmlEstQry, ['cmps'=>'ok'] ); 

								if($EcHtmlEst){
					
									$rwEcHtmlEst = $EcHtmlEst->fetch_assoc(); 
									$TotEcHtmlEst = $EcHtmlEst->num_rows;

									if($TotEcHtmlEst > 0){		
										do{
											try {		
												echo $this->li('Lock Before to ID '.$rwEcHtmlEst['id_ecsnd']);
												$___datprcs[] = $rwEcHtmlEst;
											} catch (Exception $e) {	
												$___lck = $this->Rqu([ 't'=>'ec_html_est', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
												echo $this->err($e->getMessage());  
											}		
										} while ($rwEcHtmlEst = $EcHtmlEst->fetch_assoc()); 	
									}else{
										$___lck = $this->Rqu([ 't'=>'ec_html_est', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									}
								
								}else{
									
									$___lck = $this->Rqu([ 't'=>'ec_html_est', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
									echo $this->err($__cnx->c_r->error);
									
								}
								
								$__cnx->_clsr($EcHtmlEst);
								
								if(!isN( $___datprcs )){

									foreach($___datprcs as $___datprcs_k=>$___datprcs_v){	
										
										$__rsl_upd = $__ec->_SndEc_UPD([ 
											'bd'=>$_cl_v->bd,
											'enc'=>$___datprcs_v['ecsnd_enc'], 
											'html'=>1
										]);

										if($__rsl_upd->e == 'ok'){
											echo $this->scss('Mark send '.$___datprcs_v['id_ecsnd'].' for html ok');
										}else{
											echo $this->scss('Error on mark send '.$___datprcs_v['id_ecsnd'].' for html');
										}

									}

								}

							}
						
						} catch (Exception $e) {
				
							$___lck = $this->Rqu([ 't'=>'ec_html_est', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
							echo $this->err($e->getMessage());
							
						}					
						
						$___lck = $this->Rqu([ 't'=>'ec_html_est', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
					
					}
				
				}else{

					echo $this->nallw($_cl_v->nm.' Envios Masivos - Html Builder Status - Off');
			
				}	
				
			}
			
		}	
		
		$this->__btch_id = NULL;
		
	} 

}else{

	echo $this->nallw('Global Envios Masivos - Html Builder Status - Off');

}

?>