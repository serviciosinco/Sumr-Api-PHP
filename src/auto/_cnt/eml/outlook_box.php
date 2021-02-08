<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml_outlook_box' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- AUTO TIME CHECK - START --------------------//

		$_AUTOP_d = $this->RquDt(['t'=>'outlook_box', 'm'=>15]);

	//-------------------- AUTO TIME CHECK - END --------------------//


	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){
		
		
		try {
			
			$__EmlBd = new CRM_Eml();
			$__EmlBd->_box_e();
			
			if(class_exists('CRM_Cnx')){
		
				$Ls_Qry = " SELECT *
							FROM "._BdStr(DBT).TB_THRD_EML."
							WHERE eml_tp = 201 AND eml_onl = 1";
													
				$Ls_GLbl = $__cnx->_qry($Ls_Qry);	
						
				if($Ls_GLbl){
					
					$row_Ls_GLbl = $Ls_GLbl->fetch_assoc(); $Tot_Ls_GLbl = $Ls_GLbl->num_rows; 
					
					echo $this->h1('Outlook - Mail - Box '.$Tot_Ls_GLbl);
					
					if($Tot_Ls_GLbl > 0){						
						
						do {
							
							$__Mic = new CRM_Microsoft();
							$__eml_dt = GtEmlDt([ 'id'=>$row_Ls_GLbl['eml_enc'], 't'=>'enc' ]);
							$__id_eml = $row_Ls_GLbl['id_eml'];	
							
							if(!isN($__eml_dt->attr->access_token)){ 
								
								$__Mic->access_token = $__eml_dt->attr->access_token;
								$__Mic->refresh_token = $__eml_dt->attr->refresh_token;
								$__box = $__Mic->_Box(); 

									
								try{

									foreach ($__box as $mbox) {
										
										$__EmlBd->__t = 'eml_box';
										$__EmlBd->emlbox_eml = $__id_eml;
										$__EmlBd->emlbox_id = $mbox->data->id;
										$__EmlBd->emlbox_lbl = $mbox->data->displayName;
										
										if($mbox->sb == 'ok'){
											$__EmlBd->emlbox_parent = $mbox->data->id;
										}else{
											$__EmlBd->emlbox_parent = NULL;
										}
										
										$__Prc = $__EmlBd->In();
										
										$__li .= $this->li('Prc: '.print_r($__Prc, true) );
										
										if($__Prc->e=='ok' && !isN($__Prc->prc->id)){ 
											$__li .= $this->li(h2('Set On:'.$__Prc->prc->id ));
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
					
					//$this->Rqu([ 't'=>'outlook_box' ]);

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

	echo $this->nallw('Global Email - Outlook - Get Boxes - Off');

}	


?>