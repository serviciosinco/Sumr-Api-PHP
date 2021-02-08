<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml_gmail_cnv' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- AUTO TIME CHECK - START --------------------//

		$_AUTOP_d = $this->RquDt(['t'=>'gmail_cnv', 'm'=>5]); 

	//-------------------- AUTO TIME CHECK - END --------------------//


	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

		try {
			
			$_lmt_msg = 100;
			
			if(class_exists('CRM_Cnx')){
		
				$Ls_Qry = " SELECT *
							FROM "._BdStr(DBT).TB_THRD_EML." 
							WHERE eml_tp = '"._CId('ID_SISEML_IMAP')."' AND eml_onl = 1 ";	
												
				$Ls_G_Cnv = $__cnx->_qry($Ls_Qry);
				
						
				if($Ls_G_Cnv){
					
					$row_Ls_G_Cnv = $Ls_G_Cnv->fetch_assoc(); $Tot_Ls_G_Cnv = $Ls_G_Cnv->num_rows; 
					
					echo $this->h1('Gmail - Mail - Threads '.$Tot_Ls_G_Cnv);
					
					
					if($Tot_Ls_G_Cnv > 0){					
						
						
						$client = _gapi_str();
						$sumrgapi = new API_GAPI();
						
						
						do {
							
							$__id_eml = $row_Ls_G_Cnv['id_eml'];
							$sumrgapi->cl = $row_Ls_G_Cnv['cl_enc'];
							$sumrgapi->eml = $row_Ls_G_Cnv['eml_enc'];
							$sumrgapi->us = $row_Ls_G_Cnv['us_enc'];
							$__ustkn = $sumrgapi->tkn_chk();
							
							if($__ustkn->e == 'ok' && !isN($__ustkn->cod)) {
					
								
								$__EmlBd = new CRM_Eml();
								$__RquDt = $__EmlBd->RquDt([ 'md'=>'eml', 'tp'=>'cnv', 'eml'=>$__id_eml ]);
										
								try{
									
									$sumrgapi->service_token = $__ustkn->cod;
									$client->setAccessToken( $__ustkn->cod );
									$gmail = new Google_Service_Gmail($client);
									$conversations = $gmail->users_threads->listUsersThreads('me', [/*'maxResults'=>30,*/ 'pageToken'=>$__RquDt->nxt, 'q'=>$qry_sch ]);
									$conversations_nxt = $conversations->getNextPageToken();
									
				
									foreach ($conversations as $mlist) {
										
										$thread = $gmail->users_threads->get('me', $mlist->id);
										$messages = $thread->getMessages();					            
										
										$__EmlBd->__t = 'eml_cnv';
										$__EmlBd->emlcnv_id = $mlist->id;
										$__EmlBd->emlcnv_eml = $__id_eml;
										$__EmlBd->emlcnv_snpt = $mlist->snippet;
										$__EmlBd->emlcnv_tot = count($messages);
										$__Prc = $__EmlBd->In();
										
									}
										
									$__EmlBd->Rqu([
										'md'=>'eml',
										'tp'=>'cnv',
										'eml'=>$__id_eml,
										'nxt'=>$conversations_nxt		
									]);
								
								} catch (Exception $e) {
									
									echo $e->getMessage() ;
								}
								
							
							}else{
								
								echo $this->h2( TX_EMLNOSTP, '_nostup' );	
								
							}
							
								
						} while ($row_Ls_G_Cnv = $Ls_G_Cnv->fetch_assoc()); 
						
						//echo $this->ul($___accin);
					}
					
					$this->Rqu([ 't'=>'gmail_cnv' ]);	
					
				}else{
					
					echo $this->err($__cnx->c_r->error);
					
				}
				
				
				$__cnx->_clsr($Ls_G_Cnv);
				

			}
		
		} catch (Exception $e) {
			
			echo $e->getMessage();
			
		}


	}

}else{

	echo $this->nallw('Global Email - Gmail - Get Conversations - Off');

}	

	
?>