<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'ec_img' ]);

if( $_g_alw->est == 'ok' ){
		
	echo $this->h1('Pushmail Update Image');

	if(class_exists('CRM_Cnx')){
		
		$___datprcs = [];

		//--------- AUTO TIME CHECK - START ---------//

			$_AUTOP_d = $this->RquDt([ 't'=>'ec', 's'=>30 ]);
			//$_AUTOP_d->e = 'ok';
			//$_AUTOP_d->hb = 'ok';
		
		//--------- AUTO TIME CHECK - START ---------//

		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 
			
			$this->Rqu([ 't'=>'ec' ]);
			
			try {
		
				$__ec = new API_CRM_ec();
				
				$qry = "	SELECT id_ec, ec_enc
							FROM "._BdStr(DBM).TB_EC."
							WHERE ec_upd_img = 1 
							ORDER BY id_ec DESC
							LIMIT 10";
				
				$Ls_EcUpd_all = $__cnx->_qry($qry);
				
				if($Ls_EcUpd_all){
					
					$row_Ls_EcUpd_all = $Ls_EcUpd_all->fetch_assoc();
					$Tot_Ls_EcUpd_all = $Ls_EcUpd_all->num_rows;
					
					if($Tot_Ls_EcUpd_all > 0){
					
						do{
							
							try {	
												
								$___datprcs[] = $row_Ls_EcUpd_all;
								echo $this->li('Lock Before to ID '.$row_Ls_EcUpd_all['id_ec']);

							} catch (Exception $e) {
								
								echo $this->err($e->getMessage());
								
							}

						}while($row_Ls_EcUpd_all = $Ls_EcUpd_all->fetch_assoc());
					
					}
				
				}

				$__cnx->_clsr($Ls_EcUpd_all);


				if(!isN( $___datprcs ) && count($___datprcs) > 0){

					foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

						$__r = _SveEcImg([ 'id'=>$___datprcs_v['ec_enc'] ]);
						
						echo $this->h2( 'Process Pushmail '.$___datprcs_v['id_ec'] );
						//echo $this->h3( print_r($__r, true) );
						
						if($__r->e == 'ok'){
		
							$__prc = $__ec->_EcUpd_Fld([ 'id'=>$___datprcs_v['id_ec'], 'f'=>'ec_upd_img', 'v'=>2 ]);	
							
							if($__prc->e == 'ok'){
								echo $this->scss($___datprcs_v['id_ec'].' Actualizado correctamente');	
							}else{
								echo $this->scss($___datprcs_v['id_ec'].' No se actualizo '.print_r($__prc, true) );	
							}
							
						}

					}

				}
				
				$this->Rqu([ 't'=>'ec' ]);
				
			} catch (Exception $e) {
				
				$this->Rqu([ 't'=>'ec' ]);
				
				echo $this->err( 'Error Pushmail: '.$e->getMessage() );
				
			}
		
		}else{
			
			echo $this->h2('Pushmail '.$this->Spn('Actualización de Imagen'), 'Auto_Tme_Prg');
			
		}

							
	}

}else{

	echo $this->nallw('Global Pushmail - Thumb Images  - Off');

}

?>