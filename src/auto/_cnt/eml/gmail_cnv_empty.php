<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml_gmail_cnv_empty' ]);

if( $_g_alw->est == 'ok' ){
		
	//-------------------- AUTO TIME CHECK - START --------------------//

		$_AUTOP_d = $this->RquDt(['t'=>'gmail_cnv_empty', 'm'=>5]); 

	//-------------------- AUTO TIME CHECK - END --------------------//


	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){
		
		$_box = Php_Ls_Cln($_GET['_box']);
		
		
		try {
			
			$_lmt_msg = 100;
			$thrdeml = new CRM_Eml();
			
			if(class_exists('CRM_Cnx')){
				
				if(!isN($_box)){ $__f_icnv .= sprintf(' AND id_emlbox = %s ', $_box); }
				
				$Ls_Qry = " SELECT *						
							FROM "._BdStr(DBT).TB_THRD_EML_MSG."
							WHERE eml_tp = '"._CId('ID_SISEML_IMAP')."' AND eml_onl = 1 {$__f_icnv} AND 
								id_emlmsg NOT IN (SELECT emlcnvmsg_msg FROM "._BdStr(DBT).TB_THRD_EML_CNV_MSG." )
							ORDER BY RAND()
							LIMIT 50";
												
				$Ls_G_CnvEmpty = $__cnx->_qry($Ls_Qry);
				
						
				if($Ls_G_CnvEmpty){
					
					$row_Ls_G_CnvEmpty = $Ls_G_CnvEmpty->fetch_assoc(); $Tot_Ls_G_CnvEmpty = $Ls_G_CnvEmpty->num_rows; echo $this->h1('Gmail - Mail - Threads '.$Tot_Ls_G_CnvEmpty);	
					
					if($Tot_Ls_G_CnvEmpty > 0){					
						
						$client = _gapi_str();
						$sumrgapi = new API_GAPI();
						$thrdeml = new CRM_Eml();
						
						do {
							
							
							$__id_eml = $row_Ls_G_CnvEmpty['id_eml'];					
							$sumrgapi->cl = $row_Ls_G_CnvEmpty['cl_enc'];
							$sumrgapi->eml = $row_Ls_G_CnvEmpty['eml_enc'];
							$sumrgapi->us = $row_Ls_G_CnvEmpty['us_enc'];
							$__ustkn = $sumrgapi->tkn_chk();
							
							
							if($__ustkn->e == 'ok' && !isN($__ustkn->cod)) {
								
								try{
									
									
									$sumrgapi->service_token = $__ustkn->cod;
									$client->setAccessToken( $__ustkn->cod );
									$gmail = new Google_Service_Gmail($client);
									
									
									$messaged = $gmail->users_messages->get("me", $row_Ls_G_CnvEmpty['emlmsg_cid']);
									
										
									echo 'Thread:'.$messaged->threadId.'</br>';
									echo 'Eml:'.$row_Ls_G_CnvEmpty['emlmsg_eml'].'</br>';	
									echo 'Id Eml Msg:'.$row_Ls_G_CnvEmpty['id_emlmsg'].'</br>';	
									echo 'Id:'.$row_Ls_G_CnvEmpty['emlmsg_cid'].'</br></br>';
									
										
										
										if(!isN($messaged->threadId) && !isN($row_Ls_G_CnvEmpty['emlmsg_eml']) && !isN($row_Ls_G_CnvEmpty['id_emlmsg']) ){
											
											$thrdeml->__t = 'eml_cnv';
											$thrdeml->emlcnv_id = $messaged->threadId;
											$thrdeml->emlcnv_eml = $row_Ls_G_CnvEmpty['emlmsg_eml'];
											$thrdeml->emlmsg__msg = $row_Ls_G_CnvEmpty['id_emlmsg'];
											$__Prc_In = $thrdeml->In();
											
											echo print_r($__Prc_In->cnv, true);
										}
										
								
								} catch (Exception $e) {
									
									echo $e->getMessage() ;
								}
								
								
							}
							
								
						} while ($row_Ls_G_CnvEmpty = $Ls_G_CnvEmpty->fetch_assoc()); 
		
					}
				
					$this->Rqu([ 't'=>'gmail_cnv_empty' ]);
					
				}else{
					
					echo $this->err($__cnx->c_r->error);
					
				}
				
				
				$__cnx->_clsr($Ls_G_CnvEmpty);
				

			}
		
		} catch (Exception $e) {
			
			echo $e->getMessage();
			
		}

	}

}else{

	echo $this->nallw('Global Email - Gmail - Empty Conversation - Off');

}	
	
?>