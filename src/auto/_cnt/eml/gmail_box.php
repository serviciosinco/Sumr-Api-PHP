<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml_gmail_cnv_empty' ]);

if( $_g_alw->est == 'ok' ){
		
	//-------------------- AUTO TIME CHECK - START --------------------//

		$_AUTOP_d = $this->RquDt(['t'=>'gmail_box', 'm'=>15]);

	//-------------------- AUTO TIME CHECK - END --------------------//


	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){
		
		try {
			
			$_lmt_msg = 100;
			
			$__EmlBd = new CRM_Eml();
			$__EmlBd->_box_e();
			
			if(class_exists('CRM_Cnx')){
		
				$Ls_Qry = " SELECT *
							FROM "._BdStr(DBT).TB_THRD_EML."
							WHERE eml_tp = '"._CId('ID_SISEML_IMAP')."' AND eml_onl = 1";
													
				$Ls_GLbl = $__cnx->_qry($Ls_Qry);	
						
				if($Ls_GLbl){
					
					$row_Ls_GLbl = $Ls_GLbl->fetch_assoc(); $Tot_Ls_GLbl = $Ls_GLbl->num_rows; 
					echo $this->h1('Gmail - Mail - Box '.$Tot_Ls_GLbl);
					
					if($Tot_Ls_GLbl > 0){						
						
						$client = _gapi_str();
						$sumrgapi = new API_GAPI();
						
						do {
							
							$__id_eml = $row_Ls_GLbl['id_eml'];					
							$sumrgapi->cl = $row_Ls_GLbl['cl_enc'];
							$sumrgapi->eml = $row_Ls_GLbl['eml_enc'];
							$sumrgapi->us = $row_Ls_GLbl['us_enc'];
							$__ustkn = $sumrgapi->tkn_chk();
							
							if($__ustkn->e == 'ok' && !isN($__ustkn->cod)) {
										
								try{
									
									$sumrgapi->service_token = $__ustkn->cod;
									$client->setAccessToken( $__ustkn->cod );
									$gmail = new Google_Service_Gmail($client);
									$labels = $gmail->users_labels->listUsersLabels('me');
		
									foreach ($labels->getLabels() as $mbox) {
		
										$__EmlBd->__t = 'eml_box';
										$__EmlBd->emlbox_eml = $__id_eml;
										$__EmlBd->emlbox_id = $mbox->id;
										$__EmlBd->emlbox_lbl = $mbox->id;
										
										$__Prc = $__EmlBd->In();
										
										$__li .= $this->li('Prc: '.print_r($__Prc, true) );
										
										if($__Prc->e=='ok' && !isN($__Prc->prc->id)){ 
											$__li .= $this->li(h2('Set On:'.$__Prc->prc->id ));
											
											if($mbox->id != 'CHAT'){
												$_setbox = $__EmlBd->_box_e([ 'e'=>'on', 'id'=>$__Prc->prc->id ]);
											}
											
											$__li .= $this->li('Result Box:'.print_r($_setbox, true));
										}
										
									}
								
								} catch (Exception $e) {
									
									echo $e->getMessage() ;
								}
								
							
							}else{
								
								echo $this->h2( TX_EMLNOSTP, '_nostup' );	
								
							}
		
						} while ($row_Ls_GLbl = $Ls_GLbl->fetch_assoc()); 
					}
					
					$this->Rqu([ 't'=>'gmail_box' ]);

				}else{
					
					echo $this->err($__cnx->c_r->error);
					
				}
				
				
				$__cnx->_clsr($Ls_GLbl);
				
			}
		
		} catch (Exception $e) {
			
			echo $e->getMessage();
			
		}

	}

}else{

	echo $this->nallw('Global Gmail - Box - Off');

}		

	
?>