<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'up_ec_snd' ]);

if( $_g_alw->est == 'ok' ){

	$__prfx_tt = 'EC - ';

	if(class_exists('CRM_Cnx')){	
		
		//--------- AUTO TIME CHECK - START ---------//

		$_AUTOP_d = $this->RquDt([ 't'=>'up_ec_snd', 'm'=>5 ]); 
		
		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){
			
			
			$this->Rqu([ 't'=>'up_ec_snd' ]);
			
			$this->_up->tp = 'up_ec_snd';
			
			
			$UpSmsCmpg_Qry = " SELECT * FROM ".TB_EC_CMPG." WHERE eccmpg_est = 4 ";
									
			$UpSmsCmpg_Rg = $__cnx->_qry($UpSmsCmpg_Qry); 
			
			if($UpSmsCmpg_Rg){
				
				$row_UpSmsCmpg_Rg = $UpSmsCmpg_Rg->fetch_assoc(); 
				$Tot_UpSmsCmpg_Rg = $UpSmsCmpg_Rg->num_rows; 
				
				
				echo $this->h1($__prfx_tt.'Carga de Archivos EC CMPG '.$this->Spn($Tot_UpSmsCmpg_Rg). ' - cargados '.$row_UpSmsCmpg_Rg['__tot_up']. ' - rows total '.$row_UpSmsCmpg_Rg['__tot'] ); 
				
				
				
				if($Tot_UpSmsCmpg_Rg > 0){
					
					
						do{
							//echo $row_UpSmsCmpg_Rg['id_eccmpg'];
							$__cmpg_dt = GtEcCmpgDt(['id'=>$row_UpSmsCmpg_Rg['id_eccmpg'], 'sgm'=>'ok', 'sgm'=>['e'=>'ok']]);
							//print_r($__cmpg_dt);
							foreach($__cmpg_dt->sgm as $_k){ 
								echo $this->h2('Lista: '.$_k->lsts->nm).Strn($_k->nm.'Con: '). $_k->var->tot.' variable(s)' ; 
								if( $_k->var->ls != NULL){
									foreach($_k->var->ls as $_k2 => $_v2){ 
										echo li( $_v2->sgm_nm.' '.$this->Spn($_v2->var_nm.' '.$_v2->vl), '_brd' );
									}
								}
								
							}	
									
						} while ($row_UpSmsCmpg_Rg = $UpSmsCmpg_Rg->fetch_assoc()); $UpSmsCmpg_Rg->free;
						
				}				
		
			}
			
			
			$__cnx->_clsr($UpSmsCmpg_Rg);
			
			$this->_up->_InUp_Rd(['id'=>$__smscmpg_up_id ]);
		
		}else{
			
			echo $this->h1('Upload '.$this->Spn('Envios Masivos - Run On Next'), 'Auto_Tme_Prg');
			
		}
							
	}

}else{

	echo $this->nallw('Global Monitor Upload - Campaña de Envio - Off');

}

?>