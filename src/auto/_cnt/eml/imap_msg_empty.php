<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml_imap_msg_empty' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- AUTO TIME CHECK - START --------------------//

		$_AUTOP_d = $this->RquDt(['t'=>'imap_msg_empty', 'm'=>5]); 

	//-------------------- AUTO TIME CHECK - END --------------------//


	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){
		
		
		$_box = Php_Ls_Cln($_GET['_box']);
		$_eml = Php_Ls_Cln($_GET['_eml']);
		
		try {
			
			$_lmt_msg = 100;
			
			if(class_exists('CRM_Cnx')){
				
				
				if(!isN($_box)){ $__f_icnv .= sprintf(' AND id_emlmsg = %s ', $_box); }
				elseif(!isN($_eml)){ $__f_icnv .= sprintf(' AND emlmsg_eml = %s ', $_eml); }
				
				$Ls_Qry = " SELECT *,
								
								( SELECT COUNT(*) FROM "._BdStr(DBT).TB_THRD_EML_MSG_BOX." WHERE emlmsgbox_msg = id_emlmsg) AS __tot_box,
								( SELECT COUNT(*) FROM "._BdStr(DBT).TB_THRD_EML_MSG_ADDR." WHERE emlmsgaddr_msg = id_emlmsg) AS __tot_addr
								
							FROM "._BdStr(DBT).TB_THRD_EML_MSG."
								INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON emlmsg_eml = id_eml
								
							WHERE eml_tp = '"._CId('ID_SISEML_IMAP')."' AND eml_onl = 1 
								{$__f_icnv}
							
							HAVING (__tot_box < 1) || (__tot_addr < 1)
								
							ORDER BY RAND()					
							
							LIMIT 55";
												
				$LsImapCnvMsgEmpty = $__cnx->_qry($Ls_Qry);
				
						
				if($LsImapCnvMsgEmpty){
					
					$row_LsImapCnvMsgEmpty = $LsImapCnvMsgEmpty->fetch_assoc(); $Tot_LsImapCnvMsgEmpty = $LsImapCnvMsgEmpty->num_rows; 
					
					echo $this->h1('Imap - Mail - Messages '.$Tot_LsImapCnvMsgEmpty);	
					
					if($Tot_LsImapCnvMsgEmpty > 0){					
				
						$__Imap = new CRM_Imap();
						$__Eml = new CRM_Eml();
						
						
						do {
							
							try {		
								
								//-------------------- GLOBAL VAR FOR EML INSIDE - START --------------------//
		
									$__emlid = $row_LsImapCnvMsgEmpty['id_eml'];
									$__emldt = GtEmlDt([ 'id'=>$__emlid, 'pss'=>'ok' ]);
									$__msgdt = $__Eml->EmlMsgDt([ 't'=>'enc', 'id'=>$row_LsImapCnvMsgEmpty['emlmsg_enc'], 'r_bdy'=>'no' ]);
									
								//-------------------- GLOBAL VAR FOR EML INSIDE - END --------------------//
									
									//echo li('ID:'. print_r($__msgdt->attr, true) );
									echo li('__eml:'.$row_LsImapCnvMsgEmpty['emlmsg_eml']);
									echo li('__tot_addr:'.$row_LsImapCnvMsgEmpty['__tot_addr']);
									echo li('__tot_box:'.$row_LsImapCnvMsgEmpty['__tot_box']);
									echo li('_addr_c:'.$__addr).'</br></br>';
							
							} catch (LoopingMsg $w) {
								
								echo 'Excepción capturada: ',  $w->getMessage(), "\n";
							
							}
													
						} while ($row_LsImapCnvMsgEmpty = $LsImapCnvMsgEmpty->fetch_assoc()); 
					}
					
					$this->Rqu([ 't'=>'imap_msg_empty' ]);
					
				}else{
					
					echo $this->err($__cnx->c_r->error);
					
				}
				
				
				$__cnx->_clsr($LsImapCnvMsgEmpty);

			}
		
		} catch (StartSQL $e) {
			
			echo $e->getMessage();
			
		}

	}

}else{

	echo $this->nallw('Global Email - Imap - Empty Messages - Off');

}	

?>