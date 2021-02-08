<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_eml_bnc' ]);

if( $_g_alw->est == 'ok' ){
		
	if(class_exists('CRM_Cnx')){

		echo $this->h1('VERIFICACIÓN DE CORREOS CON REBOTE');
		
		if($this->_s_cl->tot > 0){

			
			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
				
				if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_eml_bnc', 'cl'=>$_cl_v->id ])->est == 'ok' ){

					if(!isN($this->g__lmt)){ $_qry_lmt = $this->g__lmt; }else{ $_qry_lmt = '50'; }	
					
					$BncChk_Qry = "	SELECT cnteml_eml, cnteml_enc
									FROM ".$_cl_v->bd.".".TB_EC_SND  ." 
											INNER JOIN ".$_cl_v->bd.".".TB_CNT_EML." ON ecsnd_eml = cnteml_eml
									WHERE ecsnd_bnc_tp = '"._CId('ID_SISSNDBNCTP_PRMN')."' AND cnteml_est = '"._CId('ID_SISEMLEST_ACT')."'
									ORDER BY id_cnteml DESC 
									LIMIT $_qry_lmt ";
								
					$BncChk = $__cnx->_qry($BncChk_Qry); 
					
					if($BncChk){

						$row_BncChk = $BncChk->fetch_assoc(); 
						$Tot_BncChk = $BncChk->num_rows;
						
						echo $this->h2($this->ttFgr($_cl_v).$Tot_BncChk.' correos a verificar en '.ctjTx($_cl_v->nm,'in'));
						
						if($Tot_BncChk > 0){
							
							do{

								$___prc = UPDCntEml_Cld([ 
											'bd'=>$_cl_v->bd, 
											'rjct'=>1,
											'sndi'=>2,
											'lck'=>'ok',
											'id'=>$row_BncChk['cnteml_enc'],
											'cld'=>_CId('ID_CLD_BAD')
										]);
								
								
								if($___prc->e == 'ok'){
									
									echo li("Marcado como bloqueado <span style='color:orange;'>".$row_BncChk['cnteml_eml']."</span> con estado "._CId('ID_CLD_BAD'). print_r($___prc, true)); 
										
								}else{
									
									echo "No hay respuesta: ".print_r($_chk_eml, true).$___prc->w.$this->br();
									
								} 				
													
							} while ($row_BncChk = $BncChk->fetch_assoc()); $BncChk->free;
						
						}	
					
					}else{
						
						echo $this->err($__cnx->c_r->error);
						
					}	
					
					$__cnx->_clsr($BncChk);
				
				}else{

					echo $this->nallw($_cl_v->nm.' Envios Masivos - Email - Bounced - Off');
				
				}
				
			}
			
		}	

	}else{
		
		echo $this->err('AUTO_CHK_EML_BNC:off');
		
	}

}else{

	echo $this->nallw('Global Envios Masivos - Email - Bounced - Off');

}

?>