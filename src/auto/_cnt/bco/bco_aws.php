<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'bco_rkgn' ]);

if( $_g_alw->est == 'ok' ){

	/*
	try {
		
		
		//--------- GET AND POST DATA ---------//
			
			$_bco = Php_Ls_Cln($_GET['id']);
			$_lmt = Php_Ls_Cln($_GET['lmt']);
		
		//--------- AUTO TIME CHECK - START ---------//
		
			$__Bco = new CRM_Bco();
			$_AUTOP_d = $this->RquDt(['t'=>'bco_aws', 'm'=>1]); 		
			
		//--------- AUTO TIME CHECK - END ---------//
		
		$_AUTOP_d->hb = 'ok';

		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 
		
			$this->Rqu([ 't'=>'bco_aws' ]);		
			
			if(class_exists('CRM_Cnx')){
				
				
				if(!isN($_bco)){ $__fl .= " AND bco_enc = '".$_bco."' "; }


				$Ls_Qry = " SELECT id_bco, bco_img,
								( bco_fa < NOW() - INTERVAL 5 MINUTE ) AS __rd_lst
								
							FROM "._BdStr(DBM).TB_BCO." 	 
							WHERE 	(
										bco_aws = '2' {$__fl} AND 
										bco_est = '"._CId('ID_SISBCOEST_ACTV')."'
									) ||
									(
										bco_aws = '1' {$__fl} AND 
										bco_est = '"._CId('ID_SISBCOEST_ACTV')."' AND
										bco_aws_w IS NULL AND
										id_bco NOT IN (
											SELECT bcotag_bco 
											FROM "._BdStr(DBM).TB_BCO_TAG."
											WHERE bcotag_aws = 1
										)
									)
									
									{$__fl}

							ORDER BY id_bco DESC
							LIMIT 50";
												
				$LsBco = $__cnx->_qry($Ls_Qry);
				
						
				if($LsBco){
					
					$row_LsBco = $LsBco->fetch_assoc(); 
					$Tot_LsBco = $LsBco->num_rows; 
					
					echo $this->h1('Images Without AWS Analyze '.$Tot_LsBco);
					
					if($Tot_LsBco > 0){
						
						do {
							
							$_AUTOP_a = $this->RquDt([ 't'=>'bco_aws', 'id'=>$row_LsBco['id_bco'], 'm'=>5 ]); 
							
							$_AUTOP_a->hb = 'ok';
							
							if($_AUTOP_a->hb == 'ok'){		
									
								
								$__Bco->nw_id_bco = $row_LsBco['id_bco'];
								$prc = $__Bco->_Aws();
								
								//if(!isN($_bco)){
									echo $this->h2( 'Aws process for: '. $row_LsBco['id_bco'].' -> '.$row_LsBco['bco_img']);
									echo $this->h3( json_encode($prc) );
								//}
								
							}
							
							$this->Rqu([ 't'=>'bco_aws', 'id'=>$row_LsBco['id_bco'] ]);		
								
						} while ($row_LsBco = $LsBco->fetch_assoc()); 

					}
				
				}else{
					
					echo $__cnx->c_r->error;
					
				}
				
				$__cnx->_clsr($LsBco);

			}
			
			$this->Rqu([ 't'=>'bco_aws' ]);
			
		
		}else{
			
			echo $this->h1('Image Stock - '.$this->Spn('Aws'), 'Auto_Tme_Prg');
			
		}
		
		

	} catch (Exception $e) {
		
		$this->Rqu([ 't'=>'bco_aws' ]);
		echo $e->getMessage();
		
	}

	*/

}else{

	echo $this->nallw('Global Banco Rekognition Off');

}
	
?>